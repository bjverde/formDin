<?php

$path =  __DIR__.'/../../../';
require_once $path.'classes/webform/TElement.class.php';
require_once $path.'classes/webform/TControl.class.php';
require_once $path.'classes/webform/TOption.class.php';
require_once $path.'classes/webform/TRadio.class.php';
require_once $path.'classes/webform/TPDOConnection.class.php';

use PHPUnit\Framework\TestCase;

/**
 * TRadio test case.
 */
class TRadioTest extends TestCase
{	
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