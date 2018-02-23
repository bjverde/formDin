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
}

