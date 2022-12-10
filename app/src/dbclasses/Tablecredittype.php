<?php

use Base\Tablecredittype as BaseTablecredittype;

/**
 * Skeleton subclass for representing a row from the '[Table Credit Type]' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Tablecredittype extends BaseTablecredittype
{
    
    public static $primaryKey = 'AccountType';
    // public static $route = 'invoice.form';

    public static function tableColumns() {
        $cols = [];
        $cols[] = ['data' => 'AccountType', 'title' => 'Account Type', 'type' => 'number'];
        $cols[] = ['data' => 'AccountDescription', 'title' => 'Account Description', 'type' => 'text'];
        $cols[] = ['data' => 'AccountDays', 'title' => 'Account Days', 'type' => 'number'];
        return $cols;
    }

    public static function permissions() {
        $permissions = [];
        $permissions['isEdit'] = true;
        $permissions['isDelete'] = false;

        return $permissions;
    }

    public static function findOne($pk) {
        return \TablecredittypeQuery::create()->filterByTaxPercent($pk)->findOne();
    }

    public static function findAll() {
        return \TablecredittypeQuery::create()->find();
    }

    public static function tableRender() {
        $data = null;

        global $app;
        $container = $app->getContainer();

        $data['data'] = \Tablecredittype::findAll()->count() > 0 ? (\Tablecredittype::findAll()->toArray()) : [];
        $data['columns'] = \Tablecredittype::tableColumns();

        $data['permissions'] = \Tablecredittype::permissions();
        $data['primarykey'] = \Tablecredittype::$primaryKey;
        $data['route'] = isset(\Tablecredittype::$route) ? $container->router->pathFor(\Tablecredittype::$route) : null;

        return $data;
    }
}
