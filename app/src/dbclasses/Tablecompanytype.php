<?php

use Base\Tablecompanytype as BaseTablecompanytype;

/**
 * Skeleton subclass for representing a row from the '[Table Company Type]' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Tablecompanytype extends BaseTablecompanytype
{
    public static $primaryKey = 'CompanyType';
    // public static $route = 'invoice.form';

    public static function tableColumns() {
        $cols = [];
        $cols[] = ['data' => 'CompanyType', 'title' => 'Company Type', 'type' => 'number'];
        $cols[] = ['data' => 'CompanyTypeDescription', 'title' => 'Description', 'type' => 'text'];
        return $cols;
    }

    public static function permissions() {
        $permissions = [];
        $permissions['isEdit'] = true;
        $permissions['isDelete'] = false;

        return $permissions;
    }

    public static function findOne($pk) {
        return \TablecompanytypeQuery::create()->filterByCompanyType($pk)->findOne();
    }

    public static function findAll() {
        return \TablecompanytypeQuery::create()->find();
    }

    public static function tableRender() {
        $data = null;

        global $app;
        $container = $app->getContainer();

        $data['data'] = \Tablecompanytype::findAll()->count() > 0 ? (\Tablecompanytype::findAll()->toArray()) : [];
        $data['columns'] = \Tablecompanytype::tableColumns();

        $data['permissions'] = \Tablecompanytype::permissions();
        $data['primarykey'] = \Tablecompanytype::$primaryKey;
        $data['route'] = isset(\Tablecompanytype::$route) ? $container->router->pathFor(\Tablecompanytype::$route) : null;

        return $data;
    }
}
