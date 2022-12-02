<?php


use PHPUnit\Framework\TestCase;

class dbclassTest extends TestCase
{

    private function getSchmea($file = "")
    {
        if (empty($file))
            $file = $this->getSchmeaXMLName();
        return simplexml_load_file($file);
    }

    private function getSchmeaXMLName()
    {
        $rootdir = realpath(__DIR__ . '/../');
        return $rootdir . '/schema.xml';
    }
  
    /**
     * @coversNothing
     */
    public function testSchemaTable()
    {
        $this->assertNotEmpty($this->getSchmeaXMLName());
        $Schmea = $this->getSchmea();
        $this->assertNotEmpty($Schmea);
        $this->assertInstanceOf('SimpleXMLElement', $Schmea);
        $this->assertNotEmpty($Schmea->table, "Schema has tables");
        foreach ($Schmea->table as $value) {
            $this->assertTrue(!empty($value['name']), "Table donst has a Name >" . print_r($value, true));
            $this->assertTrue(!empty($value['phpName']), "Table donst has a phpName >  Name:" . $value['name']);
        }
    }

   
    /**
     * @coversNothing
     */    
    public function testTableCreate_NoSave()
    {
        $Schmea = $this->getSchmea();
        foreach ($Schmea->table as $value) {
            $phpname = '\\' . (string)$value['phpName'];
            $this->assertTrue(class_exists($phpname), "Cound not find class for table create $phpname");
            $tmp = new $phpname();
            $this->assertNotEmpty($tmp, "cound not create $phpname");
            $tmp->clearAllReferences(true);
            unset($tmp);
            $tmp = null;
        }
    }

    /**
     * @coversNothing
     */
    public function testQueryCreate_NoSave()
    {
        $Schmea = $this->getSchmea();
        foreach ($Schmea->table as $value) {
            $phpname = '\\' . (string)$value['phpName'] . 'Query';
            $this->assertTrue(class_exists($phpname), "Cound not find class for Query $phpname");
            $tmp = new $phpname();
            $this->assertNotEmpty($tmp, "cound not create $phpname");
            unset($tmp);
            $tmp = null;

            $tmp = $phpname::create();
            $this->assertNotEmpty($tmp, "cound not static create $phpname");
            unset($tmp);
            $tmp = null;
        }
    }



     /**
     * @coversNothing
     */ 
    public function testSelectFind()
    {

        $Schmea = $this->getSchmea();
        foreach ($Schmea->table as $value) {
            $phpname = '\\' . (string)$value['phpName'] . 'Query';
            $phpnamemap = '\\Map\\' . (string)$value['phpName'] . 'TableMap';
            $this->assertTrue(class_exists($phpname), "Cound not find class for Query $phpname");
            $tmp = new $phpname();

            $res = $tmp->limit(1)->find();
            $this->assertNotNull($res, "Finding Rows in table " . $value['phpName']);
            foreach ($res as $r) {
                $r->clearAllReferences(true);
                unset($r);
                $r = null;
            }

            unset($res);
            $res = null;


            $phpnamemap::clearRelatedInstancePool(true);
            $phpnamemap::clearInstancePool(true);


            unset($tmp);
            $tmp = null;
        }
    }
}
