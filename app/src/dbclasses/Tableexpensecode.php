<?php

use Base\Tableexpensecode as BaseTableexpensecode;

use Propel\Runtime\Propel;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Skeleton subclass for representing a row from the '[Table Expense Code]' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Tableexpensecode extends BaseTableexpensecode
{
    public static $primaryKey = 'ExpenseCode';
    // public static $route = 'invoice.form';

    public static function tableColumns() {
        $cols = [];
        $cols[] = ['data' => 'ExpenseCode', 'title' => 'Expense Code', 'type' => 'number'];
        $cols[] = ['data' => 'ExpenseDescription', 'title' => 'Description', 'type' => 'text'];
        $cols[] = ['data' => 'ExpenseGroup', 'title' => 'Group', 'type' => 'number'];
        return $cols;
    }

    public static function permissions() {
        $permissions = [];
        $permissions['isEdit'] = true;
        $permissions['isDelete'] = false;

        return $permissions;
    }

    public static function findOne($pk) {
        return \TableexpensecodeQuery::create()->filterByExpenseCode($pk)->findOne();
    }

    public static function findAll() {
        return \TableexpensecodeQuery::create()->find();
    }

    public static function tableRender() {
        $data = null;

        global $app;
        $container = $app->getContainer();

        $data['data'] = \Tableexpensecode::findAll()->count() > 0 ? (\Tableexpensecode::findAll()->toArray()) : [];
        $data['columns'] = \Tableexpensecode::tableColumns();

        $data['permissions'] = \Tableexpensecode::permissions();
        $data['primarykey'] = \Tableexpensecode::$primaryKey;
        $data['route'] = isset(\Tableexpensecode::$route) ? $container->router->pathFor(\Tableexpensecode::$route) : null;

        return $data;
    }

    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array {
        
        $parent = parent::toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, $includeForeignObjects);
        if (!$parent) return $parent;

        // $parent['Group'] = $this->getExpenseGroup() != null ? $this->getTableexpensegroup()->getGroupDescription() : "";
        
        return $parent;
    }
}
