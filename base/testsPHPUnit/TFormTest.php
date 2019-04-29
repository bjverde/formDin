<?php
require_once __DIR__.'/../classes/webform/TElement.class.php';
require_once __DIR__.'/../classes/webform/TControl.class.php';
require_once __DIR__.'/../classes/webform/TBox.class.php';
require_once __DIR__.'/../classes/webform/TForm.class.php';
require_once __DIR__.'/../classes/webform/TRichTextEditor.class.php';

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
	
	public function testAddRichTextEditor() {
		$form = $this->TForm;
		$text = $form->addRichTextEditor('TEXTO', 'Texto', 10000, false, 100, 15, true, true, false);
		$this->assertInstanceOf(TRichTextEditor::class,$text);
	}
}