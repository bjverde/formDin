<?php

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

