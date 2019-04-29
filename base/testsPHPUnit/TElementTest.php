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
		$esperado = null;
		$test = new TElement("false");
		$retorno = $test->getId();
		$this->assertSame($esperado, $retorno);
	}
	
	public function testId_TrueBoolean() {
	    $esperado = null;
	    $test = new TElement(true);
	    $retorno = $test->getId();
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testId_TrueString() {
		$esperado = null;
		$test = new TElement("true");
		$retorno = $test->getId();
		$this->assertSame($esperado, $retorno);
	}
	
	public function testId_ZeroInteger() {
	    $esperado = null;
		$test = new TElement(0);
		$retorno = $test->getId();
		$this->assertSame($esperado, $retorno);
	}
	
	public function testId_DivWithId1024_setAttribute() {
	    $esperado = '1024';
	    $test = new TElement('div');
	    $test->setAttribute('id','1024');
	    $retorno = $test->getId();
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testId_DivWithId1024_setId() {
	    $esperado = '1024';
	    $test = new TElement('div');
	    $test->setId('1024');
	    $retorno = $test->getId();
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testTagType_Div() {
	    $esperado = 'div';
	    $test = new TElement('div');
	    $retorno = $test->getTagType();
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testTagType_Nav() {
	    $esperado = 'nav';
	    $test = new TElement('nav');
	    $retorno = $test->getTagType();
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testSetClass() {
	    $esperado = 'navbar-brand';
	    $test = new TElement('nav');
	    $test->setClass('navbar-brand');
	    $retorno = $test->getClass();
	    $this->assertSame($esperado, $retorno);
	}
}