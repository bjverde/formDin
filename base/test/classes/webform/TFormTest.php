<?php
$path =  __DIR__.'/../../../';
require_once $path.'classes/helpers/ArrayHelper.class.php';
require_once $path.'classes/helpers/CountHelper.class.php';

require_once $path.'classes/webform/TElement.class.php';
require_once $path.'classes/webform/TControl.class.php';
require_once $path.'classes/webform/TBox.class.php';
require_once $path.'classes/webform/TEdit.class.php';
require_once $path.'classes/webform/TForm.class.php';
require_once $path.'classes/webform/TRichTextEditor.class.php';
require_once $path.'classes/webform/TSelect.class.php';

use PHPUnit\Framework\TestCase;

/**
 * TForm case.
 */
class TFormTest extends TestCase
{
	
	/**
	 *
	 * @var TForm
	 */
	private $TForm;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->TForm = new TForm(/* parameters */);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->TForm = null;
		parent::tearDown ();
	}
	
	public function testTitle() {
		$esperado = 'Test';
		$form = $this->TForm;
		$form->setTitle($esperado);
		$retorno = $form->getTitle();
		$this->assertSame($esperado, $retorno);
	}
	
	public function testSetWidth_Menor200() {
	    $esperado = 200;
	    $form = $this->TForm;
	    $form->setWidth(199);
	    $retorno = $form->getWidth();
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testSetWidth_Maior200() {
	    $esperado = 201;
	    $form = $this->TForm;
	    $form->setWidth(201);
	    $retorno = $form->getWidth();
	    $this->assertSame($esperado, $retorno);
	}	
	
	public function testSetHeight_Menor100() {
	    $esperado = 100;
	    $form = $this->TForm;
	    $form->setHeight(99);
	    $retorno = $form->getHeight();
	    $this->assertSame($esperado, $retorno);
	}	
	
	public function testSetHeight_Maior100() {
	    $esperado = 101;
	    $form = $this->TForm;
	    $form->setHeight(101);
	    $retorno = $form->getHeight();
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testGetUf_countROW() {
	    $esperado = 27;
	    $form = $this->TForm;
	    $array = $form->getUfs();
	    $retorno = CountHelper::count($array);
	    $this->assertSame('ACRE',  $array[12]);
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testGetUf_TreeColumuns() {
	    $esperado = 27;
	    $form = $this->TForm;
	    $array = $form->getUfs("SIG_UF,NOM_UF");
	    $retorno = CountHelper::count($array);
	    $this->assertSame('ACRE',  $array['AC']);
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testAddTextField() {
	    $frm = $this->TForm;
	    $field = $frm->addTextField('SIT_ATIVO', 'SIT_ATIVO',1,TRUE,1);
	    //$fieldType = $frm->getFieldType('SIT_ATIVO');
	    //$this->assertEquals('Text',$fieldType);
	    $this->assertInstanceOf(TEdit::class,$field);
	}
	
	public function testAddSelectField() {
	    $frm = $this->TForm;
	    $listAcesso_menu = $frm->getUfs();
	    $field = $frm->addSelectField('IDMENU', 'Menu',TRUE,$listAcesso_menu,null,null,null,null,null,null,' ',null);
	    $this->assertInstanceOf(TSelect::class,$field);
	}
	
	public function testAddRichTextEditor() {
		$form = $this->TForm;
		$text = $form->addRichTextEditor('TEXTO', 'Texto', 10000, false, 100, 15, true, true, false);
		$this->assertInstanceOf(TRichTextEditor::class,$text);
	}
}