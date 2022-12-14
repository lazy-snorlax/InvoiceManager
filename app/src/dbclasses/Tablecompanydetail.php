<?php

use Base\Tablecompanydetail as BaseTablecompanydetail;

use Propel\Runtime\Propel;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Skeleton subclass for representing a row from the '[Table Company Detail]' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Tablecompanydetail extends BaseTablecompanydetail
{
    public static $primaryKey = 'CompanyId';
    // public static $route = 'invoice.form';

    public static function tableColumns() {
        $cols = [];
        // $cols[] = ['data' => 'CompanyId', 'title' => 'Company ID', 'type' => 'number'];
        $cols[] = ['data' => 'CompanyName', 'title' => 'Company Name', 'type' => 'text'];
        $cols[] = ['data' => 'ContactName1', 'title' => 'Contact', 'type' => 'text'];
        $cols[] = ['data' => 'Phone3', 'title' => 'Phone', 'type' => 'text'];
        $cols[] = ['data' => 'Mobile2', 'title' => 'Mobile', 'type' => 'text'];
        return $cols;
    }

    public static function permissions() {
        $permissions = [];
        $permissions['isEdit'] = true;
        $permissions['isDelete'] = false;

        return $permissions;
    }

    public static function findOne($pk) {
        return \TablecompanydetailQuery::create()->filterByCompanyType(1)->filterByTransactionId($pk)->findOne();
    }

    public static function findAll($type) {
        return \TablecompanydetailQuery::create()->filterByCompanyType($type)->find();
    }

    public static function tableRender($type = 1) {
        $data = null;

        global $app;
        $container = $app->getContainer();

        $data['data'] = \Tablecompanydetail::findAll($type)->count() > 0 ? (\Tablecompanydetail::filteredArray(\Tablecompanydetail::findAll($type)->toArray())) : [];
        $data['columns'] = \Tablecompanydetail::tableColumns();
        $data['permissions'] = \Tablecompanydetail::permissions();
        $data['primarykey'] = \Tablecompanydetail::$primaryKey;
        $data['route'] = isset(\Tablecompanydetail::$route) ? $container->router->pathFor(\Tablecompanydetail::$route) : null;

        return $data;
    }

    public static function filteredArray($parent) {
        $cols = \Tablecompanydetail::tableColumns();
        $arr = [];

        foreach ($parent as $value) {
            $arr[] = array_filter($value, fn ($key) => in_array($key, array_column($cols, 'data')), ARRAY_FILTER_USE_KEY);
        }
        return $arr;
    }

}
