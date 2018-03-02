<?php
require_once '../classes/webform/TButton.class.php';
require_once '../classes/webform/THidden.class.php';
require_once '../classes/webform/TElement.class.php';
require_once '../classes/webform/TControl.class.php';
require_once '../classes/webform/TEdit.class.php';
require_once '../classes/webform/TFile.class.php';
/**
 * TApplication test case.
 */
class TFileTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var TFile
	 */
	private $file;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$fileFormat = 'pdf,gif,txt,jpg,rar,zip,doc';
		$this->file = new TFile('anexo','Anexo Async:',true,$fileFormat,'2M',40,FALSE);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->file = null;		
		parent::tearDown ();
	}
	
	public function testGetMaxSize() {
		$esperado = '2M';		
		$retorno = $this->file->getMaxSize();
		$this->assertEquals($esperado, $retorno);
	}
}