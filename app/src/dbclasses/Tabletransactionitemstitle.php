<?php

use Base\Tabletransactionitemstitle as BaseTabletransactionitemstitle;

use Propel\Runtime\Propel;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Skeleton subclass for representing a row from the '[Table Transaction Items Title]' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Tabletransactionitemstitle extends BaseTabletransactionitemstitle
{
    
    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array {

        $parent = parent::toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, $includeForeignObjects);
        if (!$parent) return $parent;

        $parent['Lines'] = $this->getTabletransactionitemss() ? $this->getTabletransactionitemss()->toArray() : null;

        return $parent;

    }
}
