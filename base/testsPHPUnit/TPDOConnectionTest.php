<?php

require_once '../classes/constants.php';
require_once '../classes/helpers/ArrayHelper.class.php';
require_once '../classes/webform/TPDOConnection.class.php';
/**
 * TPDOConnection test case.
 */
class TPDOConnectionTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var TPDOConnection
	 */
    private $TPDOConnection;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		//if(!defined('ENCODINGS')){ define('ENCODINGS','UTF-8'); }
		$this->TPDOConnection = new TPDOConnection(/* parameters */);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
	    $this->TPDOConnection = null;		
		parent::tearDown ();
	}
	
	public function testGetUtfDecode_NotDefined() {
		$expected= true;
		
		$boolNewValue = $this->TPDOConnection->getUtfDecode();
		$this->assertEquals( $expected , $boolNewValue);
	}
	
	public function testSetConfigDBMS_ArrayWrong() {
		$expected= 'Array Config is not configured! Define DBMS';
		
		$useConfigFile= false;
		$configArray  = array( 'X'=>'A');
		$configErrors = array();
		$root = null;
		$configErrors = $this->TPDOConnection->setConfigDBMS($useConfigFile, $configArray, $configErrors, $root);
		$size = count($configErrors);
		$this->assertEquals( 1 , $size);
		$this->assertEquals( $expected , $configErrors[0]);
	}
	
	public function testSetConfigDBMS_ArrayDBMS() {
		$expected= DBMS_MYSQL;
		
		$useConfigFile= false;
		$configArray  = array( 'DBMS'=>DBMS_MYSQL);
		$configErrors = array();
		$root = null;
		$configErrors = $this->TPDOConnection->setConfigDBMS($useConfigFile, $configArray, $configErrors, $root);
		$size = count($configErrors);
		$this->assertEquals( 0 , $size);
		$this->assertEquals( $expected , $this->TPDOConnection->getDBMS());
	}
	
	public function testSetConfigDBMS_ArrayBanco() {
		$expected= DBMS_MYSQL;
		
		$useConfigFile= false;
		$configArray  = array( 'BANCO'=>DBMS_MYSQL);
		$configErrors = array();
		$root = null;
		$configErrors = $this->TPDOConnection->setConfigDBMS($useConfigFile, $configArray, $configErrors, $root);
		$size = count($configErrors);
		$this->assertEquals( 0 , $size);
		$this->assertEquals( $expected , $this->TPDOConnection->getDBMS());
	}
	
	public function testSetConfigDbmsPort_Default(){
		$expected= '3306';
		
		$useConfigFile= false;
		$configArray  = array( 'BANCO'=>DBMS_MYSQL);
		$configErrors = array();
		$configErrors = $this->TPDOConnection->setConfigDbmsPort($useConfigFile, $configArray);
		$size = count($configErrors);
		$this->assertEquals( 0 , $size);
		$this->assertEquals( $expected , $this->TPDOConnection->getPort());
	}
	
	public function testSetConfigDbmsPort_DiferentPort(){
		$expected= '7001';
		
		$useConfigFile= false;
		$configArray  = array( 'BANCO'=>DBMS_MYSQL , 'PORT'=>'7001');
		$configErrors = array();
		$configErrors = $this->TPDOConnection->setConfigDbmsPort($useConfigFile, $configArray);
		$size = count($configErrors);
		$this->assertEquals( 0 , $size);
		$this->assertEquals( $expected , $this->TPDOConnection->getPort());
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testgetDefaultPortDBMS_EmptyDbmsNull(){
		$DBMS = null;
		$port = $this->TPDOConnection->getDefaultPortDBMS($DBMS);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testgetDefaultPortDBMS_EmptyDbmsWhite(){
		$DBMS = '';
		$port = $this->TPDOConnection->getDefaultPortDBMS($DBMS);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testgetDefaultPortDBMS_WrongDbms(){
		$DBMS = 'test';
		$port = $this->TPDOConnection->getDefaultPortDBMS($DBMS);
	}
	
	public function testgetDefaultPortDBMS_MySQLDefault(){
		$expected= '3306';
		$DBMS = DBMS_MYSQL;
		$port = $this->TPDOConnection->getDefaultPortDBMS($DBMS);
	}
	
	public function testgetDefaultPortDBMS_PostgresDefault(){
		$expected= '5432';
		$DBMS = DBMS_POSTGRES;
		$port = $this->TPDOConnection->getDefaultPortDBMS($DBMS);
	}

	public function testgetDefaultPortDBMS_OracleDefault(){
		$expected= '1521';
		$DBMS = DBMS_ORACLE;
		$port = $this->TPDOConnection->getDefaultPortDBMS($DBMS);
	}
	
	public function testgetDefaultPortDBMS_SqlServerDefault(){
		$expected= '1433';
		$DBMS = DBMS_SQLSERVER;
		$port = $this->TPDOConnection->getDefaultPortDBMS($DBMS);
	}
	
	public function testPrepareArray_string() {
		$arrayExpected[0] = 'abc';
		$arrayExpected[1] = '123.679,00';

		$arrayData[0] = 'abc';
		$arrayData[1] = '123.679,00';
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_stringVazia() {
		$arrayExpected[0] = null;
		$arrayExpected[1] = '123.679,00';
		$arrayExpected[2] = null;
		
		$arrayData[0] = '';
		$arrayData[1] = '123.679,00';
		$arrayData[2] = "";
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_stringEspace() {
		$arrayExpected[0] = ' ';
		$arrayExpected[1] = '123.679,00';
		$arrayExpected[2] = '   ';
		
		$arrayData[0] = ' ';
		$arrayData[1] = '123.679,00';
		$arrayData[2] = '   ';
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_soNumerosComZero() {
		$arrayExpected[0] = 1;
		$arrayExpected[1] = 0;

		$arrayData[0] = 1;
		$arrayData[1] = 0;
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_soNumerosStringComZero() {
		$arrayExpected[0] = '1';
		$arrayExpected[1] = '0';
		
		$arrayData[0] = '1';
		$arrayData[1] = '0';
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_dateDDMMYYYY() {
		$arrayExpected[0] = '1980-01-01';
		
		$arrayData[0] = '01/01/1980';
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_dateDDMM() {
		$arrayExpected[0] = '28/12';
		
		$arrayData[0] = '28/12';
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
}