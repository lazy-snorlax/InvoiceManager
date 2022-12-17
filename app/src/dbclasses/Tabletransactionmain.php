<?php

use Base\Tabletransactionmain as BaseTabletransactionmain;

use Propel\Runtime\Propel;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Skeleton subclass for representing a row from the '[Table Transaction Main]' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Tabletransactionmain extends BaseTabletransactionmain
{
    public static $primaryKey = 'TransactionId';
    public static $route = 'invoice.form';

    public static function tableColumns() {
        $cols = [];
        $cols[] = ['data' => 'TransactionId', 'title' => 'Transaction ID', 'type' => 'number'];
        $cols[] = ['data' => 'Company', 'title' => 'Company', 'type' => 'text'];
        $cols[] = ['data' => 'Date', 'title' => 'Date', 'type' => 'date'];
        $cols[] = ['data' => 'Paid', 'title' => 'Paid', 'type' => 'boolean'];
        return $cols;
    }

    public static function permissions() {
        $permissions = [];
        $permissions['isEdit'] = true;
        $permissions['isDelete'] = false;

        return $permissions;
    }

    public static function findOne($pk) {
        return \TabletransactionmainQuery::create()->filterByType(1)->filterByTransactionId($pk)->findOne();
    }

    public static function findAll($type) {
        return \TabletransactionmainQuery::create()->filterByType($type)->find();
    }

    public static function tableRender($type = 1) {
        $data = null;

        global $app;
        $container = $app->getContainer();

        $data['data'] = \Tabletransactionmain::findAll($type)->count() > 0 ? (\Tabletransactionmain::filteredArray(\Tabletransactionmain::findAll($type)->toArray())) : [];
        $data['columns'] = \Tabletransactionmain::tableColumns();

        $data['permissions'] = \Tabletransactionmain::permissions();
        $data['primarykey'] = \Tabletransactionmain::$primaryKey;
        $data['route'] = isset(\Tabletransactionmain::$route) ? $container->router->pathFor(\Tabletransactionmain::$route) : null;

        return $data;
    }
    
    public static function filteredArray($parent) {
        $cols = \Tabletransactionmain::tableColumns();
        $arr = [];

        foreach ($parent as $value) {
            $arr[] = array_filter($value, fn ($key) => in_array($key, array_column($cols, 'data')), ARRAY_FILTER_USE_KEY);
        }
        return $arr;
    }

    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array {

        $parent = parent::toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, $includeForeignObjects);
        if (!$parent) return $parent;

        $parent['Company'] = $this->getCompanyNo() != null ? \TablecompanydetailQuery::create()->findOneByCompanyId($this->getCompanyNo())->getCompanyName() : "";

        $parent['Date'] = $this->getDate() != null ? ($this->getDate())->format('d-m-Y') : "";
        $parent['ReportDate'] = $this->getDate() != null ? ($this->getDate())->format('d-M-Y') : "";

        return $parent;

    }

    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME) {
        if (isset($arr['Date'])) {
            $arr['Date'] = explode('-', $arr['Date']);
            $arr['Date'] = implode('-', array_reverse($arr['Date']));
        }

        return parent::fromArray($arr, $keyType);
    }

}
