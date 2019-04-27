<?php
require_once __DIR__.'/../classes/webform/TElement.class.php';

use PHPUnit\Framework\TestCase;

/**
 * TElement test case.
 */
class TElementTest extends TestCase
{
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {		
		parent::tearDown ();
	}
	
	public function testId_Empty() {
		$esperado = null;
		$test = new TElement();
		$retorno = $test->getId();
		$this->assertSame($esperado, $retorno);
	}
	
	public function testId_EmptyNull() {
		$esperado = null;
		$test = new TElement(null);
		$retorno = $test->getId();
		$this->assertSame($esperado, $retorno);
	}
	
	public function testId_FalseBoolean() {
		$esperado = null;
		$test = new TElement(false);
		$retorno = $test->getId();
		$this->assertSame($esperado, $retorno);
	}
	
	public function testId_FalseString() {
		$esperado = "false";
		$test = new TElement("false");
		$retorno = $test->getId();
		$this->assertSame($esperado, $retorno);
	}
	
	public function testId_TrueString() {
		$esperado = "true";
		$test = new TElement("true");
		$retorno = $test->getId();
		$this->assertSame($esperado, $retorno);
	}
	
	public function testId_ZeroInteger() {
		$esperado = '0';
		$test = new TElement(0);
		$retorno = $test->getId();
		$this->assertSame($esperado, $retorno);
	}
	
	public function testId_ZeroString() {
		$esperado = '0';
		$test = new TElement('0');
		$retorno = $test->getId();
		$this->assertSame($esperado, $retorno);
	}
	
	public function testId_Integer() {
		$esperado = '1024';
		$test = new TElement(1024);
		$retorno = $test->getId();
		$this->assertSame($esperado, $retorno);
	}
}