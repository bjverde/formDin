<?php
if(!defined('ENCODINGS')){ define('ENCODINGS','ISO-8859-1'); }
require_once '../classes/webform/THtmlPage.class.php';
/**
 * THtmlPage test case.
 */
class THtmlPageTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var THtmlPage
	 */
	private $tHtmlPage;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();				
		$this->tHtmlPage = new THtmlPage(/* parameters */);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->tHtmlPage = null;		
		parent::tearDown ();
	}
	

	/**
	 * Tests THtmlPage->addJavascript()
	 */
	public function testAddJsCssFile_array() {
		$expected[] = 'script01.js';
		$expected[] = 'script02.js';
		
		$this->tHtmlPage->addJsCssFile($expected);
		$result =  $this->tHtmlPage->getArrJsCssFile();
		$this->assertEquals( $expected , $result);
	}
	
	/**
	 * Tests THtmlPage->addJavascript()
	 */
	public function testAddJsCssFile_SemRepetidos() {
		$expected[] = 'script01.js';
		$expected[] = 'script02.js';
		
		$input = $expected;
		$input[]= 'script01.js';
		$input[]= 'script01.js';
		$input[]= 'script01.js';
		
		$this->tHtmlPage->addJsCssFile($input);
		$result =  $this->tHtmlPage->getArrJsCssFile();
		$this->assertEquals( $expected , $result);
	}
	
	/**
	 * Tests THtmlPage->addJavascript()
	 */
	public function testAddJsCssFile_SingleFile() {
		$expected = 'scripthfdka.js';		
		
		$this->tHtmlPage->addJsCssFile($expected);
		$result =  $this->tHtmlPage->getArrJsCssFile();
		$this->assertEquals( $expected , $result[2]);
	}
	
	/**
	 * Tests THtmlPage->getCharset()
	 */
	public function testGetCharset_ISO88591() {
		$expected = 'ISO-8859-1';		
		$result =  $this->tHtmlPage->getCharset();
		$this->assertEquals( $expected , $result);
	}
}

