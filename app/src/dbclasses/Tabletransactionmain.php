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

    public static function findAll() {
        return \TabletransactionmainQuery::create()->filterByType(1)->find();
    }

    public static function tableRender() {
        $data = null;

        global $app;
        $container = $app->getContainer();

        $data['data'] = \Tabletransactionmain::findAll()->count() > 0 ? \Tabletransactionmain::findAll()->toArray() : [];
        $data['columns'] = \Tabletransactionmain::tableColumns();
        $data['permissions'] = \Tabletransactionmain::permissions();
        $data['primarykey'] = \Tabletransactionmain::$primaryKey;
        $data['route'] = $container->router->pathFor(\Tabletransactionmain::$route);

        return $data;
    }

    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array {

        $parent = parent::toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, $includeForeignObjects);
        if (!$parent) return $parent;

        $parent['Company'] = $this->getCompanyNo() != null ? ($this->getTablecompanydetail()->getCompanyName()) : "";
        $parent['Date'] = $this->getDate() != null ? ($this->getDate())->format('d-m-Y') : "";

        return $parent;

    }
}
