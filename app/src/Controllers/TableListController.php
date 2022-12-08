<?php
namespace App\Controllers;
use App\Controllers\Controller;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Propel;
use Propel\Runtime\Map\TableMap;

class TableListController extends Controller {

    public const TABLE_DATA = [
        "invoices" => "\Tabletransactionmain"
    ];

    public static function routes() {

    }

    public function getTableList( $request, $response, array $args ) {
        try {
            $classname = TableListController::TABLE_DATA[strtolower($args['table'])];
            $data_haul = TableListController::tablelist($classname);
            $data_haul['args'] = $args;

            return $response->withJSON($data_haul, 200);
        } catch (\Throwable $th) {
            return $this->exceptJSON($response, $th, ['args' => $args]);
        }
    }

    public static function tablelist($classname, $data_haul = []) {
        $data_haul['request'] = $_REQUEST;
        $data_haul['draw'] = intval(isset($_REQUEST['draw']) ? $_REQUEST['draw'] : 1);
        $data_haul['data'] = [];
        $tablename = ($classname::TABLE_MAP)::CLASS_DEFAULT;

        try {
            $query = ($classname)::findAll();
            
            $data_haul['tablename'] = $tablename;
            $data_haul['totalRecords'] = is_array($query) ? sizeof($query) : $query->count();
            $data_haul['filteredRecords'] = $data_haul['totalRecords'];

            if (is_array($query)) {
                $data_haul['data'] = $query;
                return $data_haul;
            }

            if (isset($_REQUEST['columns'])) {
                $searchValue = strtolower(trim(isset($_REQUEST['search']) ? $_REQUEST['search']['value'] : ''));
                $conditions = array();
                
                $columns = [];
                $tableMap = (new ($classname::TABLE_MAP)());
                foreach ($_REQUEST['columns'] as $column) {
                    if (!empty($column['data'])) {
                        $fieldname = trim(str_replace('"', '', $column['data']));
                        $columns[] = $fieldname;
                        
                        if (($column['searchable'] == 'true') && !empty($searchValue)) {
                            $tableCol = $tableMap->getColumn($fieldname);
                            if ($tableCol) {
                                if ($tableCol->getType() == 'TIMESTAMP') {

                                    if (!preg_match("/[a-z]/i", $searchValue) && !str_ends_with($searchValue, '-') && !str_ends_with($searchValue, '/')) {
                                        $query->condition('D' . $fieldname, "((convert(varchar, ($tablename.$fieldname), 103)) LIKE ? )", "%$searchValue%", \PDO::PARAM_STR);
                                        $conditions[] = 'D' . $fieldname;
                                    }
                                } else {
                                    $query->condition($fieldname, "LOWER(" . $tablename . "." . $fieldname . ") LIKE ? ", "%$searchValue%");
                                    $conditions[] = $fieldname;
                                }
                            }
                        }
                    }
                }

                if (sizeof($conditions) >= 1) {
                    $query->where($conditions, "%$searchValue%");
                }


                if (isset($_REQUEST['filter'])) {
                    $fs = explode('|', $_REQUEST['filter']);
                    foreach ($fs as $fstr) {
                        $f = explode(':', $fstr);
                        $query->addUsingAlias($f[0],"%$f[1]%",  Criteria::LIKE);
                    }
                }

                $query->select($columns);

                if (isset($_REQUEST['order'])) {
                    foreach ($_REQUEST['order'] as $order) {
                        $query->orderBy($columns[$order['column']], $order['dir']);
                    }
                }
            }

            if (isset($_REQUEST['length'])) {
                $query->limit($_REQUEST['length']);
            }
            if (isset($_REQUEST['start'])) {
                $query->offset($_REQUEST['start']);
            }

            if (isset($_REQUEST['debug'])) {
                echo "<pre>";
                echo $query->toString();
                d($query->find()->toArray());
            }

            $query = $query->find();
            $data_haul['data'] = $query->toArray(
                null,
                false,
                TableMap::TYPE_FIELDNAME
            );

            if (isset($_REQUEST['debug'])) {
                ddd($data_haul);
            }
           
            $data_haul['data'] = (array_map( function ($v) {
                foreach ($v as $key => $value) {
                    if (strpos($key,'.' ) > 0) {
                        unset ($v[$key]);
                        $new = explode('.',$key);
                        if (!  isset(  $v[$new[0]]) )
                                $v[$new[0]] =[];
                        $v[$new[0]][$new[1]] = $value;
                        
                    }
                }
                return $v;
            }, $data_haul['data']));

        } catch (\Throwable $th) {
            $e = [];

            foreach ($_REQUEST['columns'] as  $value) {
                $e[$value['data']] = $th->getMessage();
            }

            $data_haul['data'] =  [$e];
            $data_haul['recordsFiltered'] = 1;
        }

        return $data_haul;
    }
}