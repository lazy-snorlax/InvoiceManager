<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'default' => 
  array (
    'tablesByName' => 
    array (
      'dbo.[Table Business Detail]' => '\\Map\\TablebusinessdetailTableMap',
      'dbo.[Table Company Detail]' => '\\Map\\TablecompanydetailTableMap',
      'dbo.[Table Company Type]' => '\\Map\\TablecompanytypeTableMap',
      'dbo.[Table Credit Type]' => '\\Map\\TablecredittypeTableMap',
      'dbo.[Table Default Setting]' => '\\Map\\TabledefaultsettingTableMap',
      'dbo.[Table Expense Code]' => '\\Map\\TableexpensecodeTableMap',
      'dbo.[Table Expense Group]' => '\\Map\\TableexpensegroupTableMap',
      'dbo.[Table Tax Code]' => '\\Map\\TabletaxcodeTableMap',
      'dbo.[Table Transaction Items Title]' => '\\Map\\TabletransactionitemstitleTableMap',
      'dbo.[Table Transaction Items]' => '\\Map\\TabletransactionitemsTableMap',
      'dbo.[Table Transaction Main]' => '\\Map\\TabletransactionmainTableMap',
      'dbo.[Table Transaction Type]' => '\\Map\\TabletransactiontypeTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Tablebusinessdetail' => '\\Map\\TablebusinessdetailTableMap',
      '\\Tablecompanydetail' => '\\Map\\TablecompanydetailTableMap',
      '\\Tablecompanytype' => '\\Map\\TablecompanytypeTableMap',
      '\\Tablecredittype' => '\\Map\\TablecredittypeTableMap',
      '\\Tabledefaultsetting' => '\\Map\\TabledefaultsettingTableMap',
      '\\Tableexpensecode' => '\\Map\\TableexpensecodeTableMap',
      '\\Tableexpensegroup' => '\\Map\\TableexpensegroupTableMap',
      '\\Tabletaxcode' => '\\Map\\TabletaxcodeTableMap',
      '\\Tabletransactionitems' => '\\Map\\TabletransactionitemsTableMap',
      '\\Tabletransactionitemstitle' => '\\Map\\TabletransactionitemstitleTableMap',
      '\\Tabletransactionmain' => '\\Map\\TabletransactionmainTableMap',
      '\\Tabletransactiontype' => '\\Map\\TabletransactiontypeTableMap',
    ),
  ),
));
