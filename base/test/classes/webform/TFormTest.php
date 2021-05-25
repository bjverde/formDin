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
	protected function setUp(): void {
		parent::setUp ();
		$this->TForm = new TForm(/* parameters */);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown(): void {
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