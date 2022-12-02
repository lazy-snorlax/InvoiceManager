<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;


class dbcaseTest extends TestCase{


	protected $SchmeaXMLNames;
	public  function setUp(): void{
		$rootdir = realpath(__DIR__ . '/../../');
		$this->SchmeaXMLNames = glob ( $rootdir . DIRECTORY_SEPARATOR . 'hospdb' . DIRECTORY_SEPARATOR . '*.xml' );
	}	
	
	
    private function getSchmea($file = "") {
        if (empty($file))
         $file = $this->getSchmeaXMLName();
		return simplexml_load_file ( $file );
	}
	
	private function getFiles($dir) {
		$rootdir = realpath(__DIR__ . '/../');
      	$dir = str_replace ( '\\', DIRECTORY_SEPARATOR, $dir );
		if (!empty($dir)) {
			$dir = $dir  . DIRECTORY_SEPARATOR;
		}
     
		$p = $rootdir . DIRECTORY_SEPARATOR .'dbclasses' . DIRECTORY_SEPARATOR . $dir  . '*.php';
        return glob ( $p );
	}
      
    private function getSchmeaXMLName()
    {
        $rootdir = realpath(__DIR__ . '/../');
        return $rootdir.'/schema.xml';
    }

    /**
     * @coversNothing
     */
	public function testClassCase() {
		foreach ($this->SchmeaXMLNames as $SchmeaName ) {
			$Schmea = $this->getSchmea ( $SchmeaName );
			 
			$counts = array ();
			$files = $this->getFiles ( isset( $Schmea ['namespace'])?$Schmea ['namespace']:'') ;
		
			$this->assertNotEmpty ( $files, "No Files for namespace?? " . $Schmea ['namespace'] );
			foreach ( $files as $value ) {
				$f = strtolower ( basename ( $value, ".php" ) );
				$all = "$value, " . ((isset ( $counts [$f] ) ? implode ( ',', $counts [$f] ) : ""));
				$this->assertFalse ( isset ( $counts [$f] ), "Case Checked: duplicate file found ($all) " . $Schmea ['namespace'] );
				$counts [$f] [] = $value;
			}
		}
	}
}
