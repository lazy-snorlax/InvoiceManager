<?php

use Base\Tabletaxcode as BaseTabletaxcode;

/**
 * Skeleton subclass for representing a row from the '[Table Tax Code]' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Tabletaxcode extends BaseTabletaxcode
{
    public static $primaryKey = 'TaxPercent';
    // public static $route = 'invoice.form';

    public static function tableColumns() {
        $cols = [];
        $cols[] = ['data' => 'TaxPercent', 'title' => 'Tax Percent', 'type' => 'percent'];
        $cols[] = ['data' => 'TaxCode', 'title' => 'Tax Code', 'type' => 'text'];
        $cols[] = ['data' => 'TaxDescription', 'title' => 'Tax Description', 'type' => 'text'];
        return $cols;
    }

    public static function permissions() {
        $permissions = [];
        $permissions['isEdit'] = true;
        $permissions['isDelete'] = false;

        return $permissions;
    }

    public static function findOne($pk) {
        return \TabletaxcodeQuery::create()->filterByTaxPercent($pk)->findOne();
    }

    public static function findAll() {
        return \TabletaxcodeQuery::create()->find();
    }

    public static function tableRender() {
        $data = null;

        global $app;
        $container = $app->getContainer();

        $data['data'] = \Tabletaxcode::findAll()->count() > 0 ? (\Tabletaxcode::findAll()->toArray()) : [];
        $data['columns'] = \Tabletaxcode::tableColumns();

        $data['permissions'] = \Tabletaxcode::permissions();
        $data['primarykey'] = \Tabletaxcode::$primaryKey;
        $data['route'] = isset(\Tabletaxcode::$route) ? $container->router->pathFor(\Tabletaxcode::$route) : null;

        return $data;
    }

}
