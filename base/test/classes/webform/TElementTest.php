<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
 * Criado por Luís Eugênio Barbosa
 * Essa versão é um Fork https://github.com/bjverde/formDin
 *
 * ----------------------------------------------------------------------------
 * This file is part of Formdin Framework.
 *
 * Formdin Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License version 3
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License version 3
 * along with this program; if not,  see <http://www.gnu.org/licenses/>
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA  02110-1301, USA.
 * ----------------------------------------------------------------------------
 * Este arquivo é parte do Framework Formdin.
 *
 * O Framework Formdin é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da GNU LGPL versão 3 como publicada pela Fundação
 * do Software Livre (FSF).
 *
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

$path =  __DIR__.'/../../../classes/';
require_once $path.'constants.php';
require_once $path.'webform/autoload_formdin.php';
require_once $path.'helpers/autoload_formdin_helper.php';

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
	
	public function testTagImg_NotClose() {
	    $esperado = '<img>'.EOL;
	    $test = new TElement('img');
	    $retorno = $test->show(false);
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testTagInput_NotClose() {
	    $esperado = '<input>'.EOL;
	    $test = new TElement('input');
	    $retorno = $test->show(false);
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testTagDoctype_NotClose() {
	    $esperado = '<!DOCTYPE html>'.EOL;
	    $test = new TElement('doctype');
	    $retorno = $test->show(false);
	    $this->assertSame($esperado, $retorno);
	}
	
	public function testgetIdent_null() {
	    $expected = null;
	    $test = new TElement('nav');	    
	    $result = $test->getIdent();
	    $this->assertSame($expected, $result);
	}
	
	public function testgetIdent_3_depthNull() {
	    $expected = null;
	    $test = new TElement('nav');
	    $result = $test->getIdent(3);
	    $this->assertEquals($expected, $result);
	}
	
	public function testgetIdent_1_depthNull() {
	    $expected = null;
	    $test = new TElement('nav');
	    $result = $test->getIdent(1);
	    $this->assertEquals($expected, $result);
	}
	
	public function testChilren() {
	    $expected = 'If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".';
	    $test = new TElement('p');
	    $test->add('If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".');
	    $result = $test->getChildren();
	    $this->assertEquals( $expected , $result[0]);
	}
	
	public function testChilren_index() {
	    $expected = 'Text BBBB';
	    $test = new TElement('p');
	    $test->add('Text BBBB');
	    $test->add('Text CCCC');
	    $test->add('Text DDDD');
	    $test->addOnTop('Text AAAA');
	    $result = $test->getChildren();
	    $this->assertEquals( $expected , $result[1]);
	}
	
	public function testAddOnTop() {
	    $expected = 'Text AAAA';
	    $test = new TElement('p');
	    $test->add('Text BBBB');
	    $test->add('Text CCCC');
	    $test->add('Text DDDD');
	    $test->addOnTop('Text AAAA');
	    $result = $test->getChildren();
	    $this->assertEquals( $expected , $result[0]);
	}
	
	public function testShow() {
	    $expected = '<p>'.EOL
	                .'If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".'.EOL
	                .'</p>'.EOL;
	    $test = new TElement('p');
	    $test->add('If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".');
	    $result = $test->show(false);
	    $this->assertEquals( $expected , $result);
	}
}