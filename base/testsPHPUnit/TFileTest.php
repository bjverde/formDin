<?php
require_once __DIR__.'/../classes/exceptions/UploadException.class.php';
require_once __DIR__.'/../classes/webform/TButton.class.php';
require_once __DIR__.'/../classes/webform/THidden.class.php';
require_once __DIR__.'/../classes/webform/TElement.class.php';
require_once __DIR__.'/../classes/webform/TControl.class.php';
require_once __DIR__.'/../classes/webform/TEdit.class.php';
require_once __DIR__.'/../classes/webform/TFile.class.php';

use PHPUnit\Framework\TestCase;

/**
 * TApplication test case.
 */
class TFileTest  extends TestCase
{
	/**
	 * @var TFile
	 */
	private $file;
	private $fieldName;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$fileFormat = 'pdf,gif,txt,jpg,rar,zip,doc';
		$this->fieldName = 'anexo';
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
		$esperado = '2Mb';
		$retorno = $this->file->getMaxSize();
		$this->assertEquals($esperado, $retorno);
	}
	
	public function testGetMaxSizeKb_2k() {
		$size = '2K';
		$esperado = '2048';
		$this->file->setMaxSizeKb($size);
		$retorno = $this->file->getMaxSizeKb();
		$this->assertEquals($esperado, $retorno);
	}
	
	public function testGetMaxSizeKb_3M() {
		$size = '3M';
		$esperado = '3145728';
		$this->file->setMaxSizeKb($size);
		$retorno = $this->file->getMaxSizeKb();
		$this->assertEquals($esperado, $retorno);
	}
	
	public function testGetMaxSizeKb_4G() {
		$size = '4G';
		$esperado = '4294967296';
		$this->file->setMaxSizeKb($size);
		$retorno = $this->file->getMaxSizeKb();
		$this->assertEquals($esperado, $retorno);
	}	
}