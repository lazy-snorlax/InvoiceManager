<?php

use Base\Tableexpensegroup as BaseTableexpensegroup;

use Propel\Runtime\Propel;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Skeleton subclass for representing a row from the '[Table Expense Group]' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Tableexpensegroup extends BaseTableexpensegroup
{
    
    public static $primaryKey = 'GroupId';
    // public static $route = 'invoice.form';

    public static function tableColumns() {
        $cols = [];
        $cols[] = ['data' => 'GroupId', 'title' => 'Expense Code', 'type' => 'number'];
        $cols[] = ['data' => 'GroupDescription', 'title' => 'Description', 'type' => 'text'];
        return $cols;
    }

    public static function permissions() {
        $permissions = [];
        $permissions['isEdit'] = true;
        $permissions['isDelete'] = false;

        return $permissions;
    }

    public static function findOne($pk) {
        return \TableexpensegroupQuery::create()->filterByGroupId($pk)->findOne();
    }

    public static function findAll() {
        return \TableexpensegroupQuery::create()->find();
    }

    public static function tableRender() {
        $data = null;

        global $app;
        $container = $app->getContainer();

        $data['data'] = \Tableexpensegroup::findAll()->count() > 0 ? (\Tableexpensegroup::findAll()->toArray()) : [];
        $data['columns'] = \Tableexpensegroup::tableColumns();

        $data['permissions'] = \Tableexpensegroup::permissions();
        $data['primarykey'] = \Tableexpensegroup::$primaryKey;
        $data['route'] = isset(\Tableexpensegroup::$route) ? $container->router->pathFor(\Tableexpensegroup::$route) : null;

        return $data;
    }
}
