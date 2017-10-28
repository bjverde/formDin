<?php
require_once '../classes/webform/TDAOCreate.class.php';

define('TEOL',"\n");
define('TTAB',chr(9));
/**
 * TDAOCreate test case.
 */
class TDAOCreateTest extends PHPUnit_Framework_TestCase {

    /**
     *
     * @var TDAOCreate
     */
    private $tDAOCreate;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(){
        parent::setUp();        
        // TODO Auto-generated TDAOCreateTest::setUp()
        $tableName = 'myTableTest';
        $keyColumnName = 'pkColumnName';
        $this->tDAOCreate = new TDAOCreate($tableName,$keyColumnName);
        
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(){
        // TODO Auto-generated TDAOCreateTest::tearDown()
        $this->tDAOCreate = null;        
        parent::tearDown();
    }
    
    public function testSetShowSchema_true(){
        $esperado = true;
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setShowSchema(true);
        $retorno = $tDAOCreate->getShowSchema();
        //$this->tDAOCreate->setShowSchema(true);
        //$retorno = $this->tDAOCreate->getShowSchema();        
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testSetShowSchema_false(){
        $esperado = false;
        $this->tDAOCreate->setShowSchema(false);
        $retorno = $this->tDAOCreate->getShowSchema();
        $this->assertEquals($esperado, $retorno);
    }

    public function testHasSchema_yes(){
        $esperado = '\'.SCHEMA.\'';        
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setShowSchema(true);
        $retorno = $tDAOCreate->hasSchema();        
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testHasSchema_no(){
        $esperado = '';
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setShowSchema(false);
        $retorno = $tDAOCreate->hasSchema();  
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testAddLine_string(){
    	$esperado = 'echo';
    	$tDAOCreate = $this->tDAOCreate;
    	$tDAOCreate->addLine($esperado);
    	$retorno = $tDAOCreate->getLinesString();
    	$this->assertEquals($esperado, $retorno);
    	
    	$retornoArray = $tDAOCreate->getLinesArray();
    	$size = count($retornoArray);
    	$this->assertEquals( 1, $size);
    }
    
    public function testAddLine_nameFunction(){
    	$tDAOCreate = $this->tDAOCreate;
    	$esperado = TAB.'public function '.$tDAOCreate->getTableName().'DAO() {';
    	$tDAOCreate->addLine($esperado);    	
    	$retorno = $tDAOCreate->getLinesString();
    	$this->assertEquals( trim($esperado), $retorno);
    	
    	$retornoArray = $tDAOCreate->getLinesArray();
    	$size = count($retornoArray);
    	$this->assertEquals( 1, $size);
    }
    
    public function testAddLine_onlyLine(){
    	$esperado = TTAB.'//'.str_repeat( '-', 80 ).TEOL;
    	$tDAOCreate = $this->tDAOCreate;
    	$tDAOCreate->addLine();
    	$retorno = $tDAOCreate->getLinesString();
    	$this->assertEquals( trim($esperado), $retorno);
    	
    	$retornoArray = $tDAOCreate->getLinesArray();
    	$size = count($retornoArray);
    	$this->assertEquals( 1, $size);
    }    
    
    public function testAddSqlSelectCount_sizeArray(){
    	$tDAOCreate = $this->tDAOCreate;
    	$tDAOCreate->addSqlSelectCount();
    	
    	$resultArray = $tDAOCreate->getLinesArray();
    	$size = count($resultArray);
    	$this->assertEquals( 5, $size);
    }    
    
    public function testAddSqlDelete_sizeArray(){
    	$tDAOCreate = $this->tDAOCreate;
    	$tDAOCreate->addSqlDelete();
    	
    	$resultArray = $tDAOCreate->getLinesArray();
    	$size = count($resultArray);
    	$this->assertEquals( 4, $size);
    }
    
    public function testAddSqlDelete_string(){
    	$tDAOCreate = $this->tDAOCreate;
    	
    	$expectedArray[] = TAB.'public static function delete( $id ){'.TEOL;
    	$expectedArray[] = TAB.TAB.'$values = array($id);'.TEOL;
    	$expectedArray[] = TAB.TAB.'return self::executeSql(\'delete from '.$tDAOCreate->hasSchema().$tDAOCreate->getTableName().' where '.$tDAOCreate->getKeyColumnName().' = '.$tDAOCreate->getCharParam().'\',$values);'.TEOL;
    	$expectedArray[] = TAB.'}'.TEOL;
    	$expectedString = trim( implode($expectedArray) );
    	
    	$tDAOCreate->addSqlDelete();
    	$result = $tDAOCreate->getLinesString();
    	
    	$this->assertEquals( $expectedString , $result);
    }

}