<?php
require_once '../classes/webform/TElement.class.php';
require_once '../classes/webform/TControl.class.php';
require_once '../classes/webform/TOption.class.php';
require_once '../classes/webform/TRadio.class.php';
require_once '../classes/webform/TPDOConnection.class.php';
/**
 * TRadio test case.
 */
class TRadioTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var TRadio
	 */
	private $tRadio;
	
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$listFormas = array(1=>'Dinheiro',2=>'Cheque',3=>'Cartão');
		$tRadio = new TRadio('forma_pagamento', 'Forma Pagamento:', false, $listFormas);
		$this->tRadio = $tRadio;
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {		
		parent::tearDown ();
	}
	
	public function testCheckedItemRadioOrCheck_Empty() {
		$esperado = null;
		
		$tRadio = $this->tRadio;
		$tRadio->setValue(1);
		
		$input = new TElement('input');
		$input->setProperty( 'type', 'radio' );
		$input->setName( $tRadio->getId() );
		$input->setProperty( 'id', $tRadio->getId() . '_1');
		
		$span = new TElement( 'span' );
		
		$tRadio->checkedItemRadioOrCheck( $input,$span, 2 );
		
		$retorno = $input->getProperty('checked');
		
		$this->assertSame($esperado, $retorno);
	}
	
	public function testCheckedItemRadioOrCheck_True() {
		$esperado = 'true';
		
		$tRadio = $this->tRadio;
		$tRadio->setValue(1);
		
		$input = new TElement('input');
		$input->setProperty( 'type', 'radio' );
		$input->setName( $tRadio->getId() );
		$input->setProperty( 'id', $tRadio->getId() . '_1');
		
		$span = new TElement( 'span' );
		
		$tRadio->checkedItemRadioOrCheck( $input,$span, 1 );
		
		$retorno = $input->getProperty('checked');
		
		$this->assertSame($esperado, $retorno);
	}
}