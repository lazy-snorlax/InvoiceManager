<?php

use Base\Tabletransactiontype as BaseTabletransactiontype;

/**
 * Skeleton subclass for representing a row from the '[Table Transaction Type]' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Tabletransactiontype extends BaseTabletransactiontype
{
    
    public static $primaryKey = 'TypeCode';
    // public static $route = 'invoice.form';

    public static function tableColumns() {
        $cols = [];
        $cols[] = ['data' => 'TypeCode', 'title' => 'Type Code', 'type' => 'number'];
        $cols[] = ['data' => 'TypeDescription', 'title' => 'Description', 'type' => 'text'];
        return $cols;
    }

    public static function permissions() {
        $permissions = [];
        $permissions['isEdit'] = true;
        $permissions['isDelete'] = false;

        return $permissions;
    }

    public static function findOne($pk) {
        return \TabletransactiontypeQuery::create()->filterByTaxPercent($pk)->findOne();
    }

    public static function findAll() {
        return \TabletransactiontypeQuery::create()->find();
    }

    public static function tableRender() {
        $data = null;

        global $app;
        $container = $app->getContainer();

        $data['data'] = \Tabletransactiontype::findAll()->count() > 0 ? (\Tabletransactiontype::findAll()->toArray()) : [];
        $data['columns'] = \Tabletransactiontype::tableColumns();

        $data['permissions'] = \Tabletransactiontype::permissions();
        $data['primarykey'] = \Tabletransactiontype::$primaryKey;
        $data['route'] = isset(\Tabletransactiontype::$route) ? $container->router->pathFor(\Tabletransactiontype::$route) : null;

        return $data;
    }

}
