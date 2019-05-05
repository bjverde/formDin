<?php
if(!defined('ENCODINGS')){ define('ENCODINGS','ISO-8859-1'); }

$path =  __DIR__.'/../../../';
require_once $path.'classes/webform/THtmlPage.class.php';

use PHPUnit\Framework\TestCase;

/**
 * THtmlPage test case.
 */
class THtmlPageTest extends TestCase
{
	
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
	 * Tests THtmlPage->getCharset()
	 */
	public function testGetCharset_ISO88591() {
		$expected = 'UTF-8';		
		$result =  $this->tHtmlPage->getCharset();
		$this->assertEquals( $expected , $result);
	}
}

