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
require_once $path.'helpers/autoload_formdin_helper.php';

require_once __DIR__.'/../../mockFormDinArray.php';

use PHPUnit\Framework\TestCase;

/**
 * ArrayHelper test case.
 */
class ArrayHelperTest extends TestCase
{

    public function testValidateUndefined_temValor() {
        $index = 'key';
        $valor = 1500;
        $esperado = $valor;
        $arrayTest = array();
        $arrayTest[$index] = $valor;
        $retorno = ArrayHelper::validateUndefined($arrayTest,$index);        
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testValidateUndefined() {
        $esperado = '';
        $arrayTest = array();
        $retorno = ArrayHelper::validateUndefined($arrayTest,'indexNotExist');
        $this->assertEquals($esperado, $retorno);
    }    
    
    public function testHas_notArray() {
    	$esperado = FALSE;
    	$arrayTest = null;
    	$retorno = ArrayHelper::has('x',$arrayTest);
    	$this->assertEquals($esperado, $retorno);
    }    
   
    public function testHas_notInArray() {
    	$esperado  = FALSE;
    	$arrayTest = array("foo" => "bar","bar" => "foo",100=> -100,-100=> 100);
    	$retorno = ArrayHelper::has('x',$arrayTest);
    	$this->assertEquals($esperado, $retorno);
    }
    
    public function testHas_InArray() {
    	$esperado  = TRUE;
    	$arrayTest = array("foo" => "bar","x" => "foo",100=> -100,-100=> 100);
    	$retorno = ArrayHelper::has('x',$arrayTest);
    	$this->assertEquals($esperado, $retorno);
    }    
    
    public function testArray_keys2_true() {
        $esperado  = array(0=>'x');
        $arrayTest = array("foo" => "bar","x" => "foo",100=> -100,-100=> 100);
        $retorno = ArrayHelper::array_keys2($arrayTest,'foo');
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testArray_keys2_position2() {
        $esperado  = array(0=>2);
        $arrayTest = array(0 => 'idTest',1=>'nm_test',2=>'tp_test');
        $retorno = ArrayHelper::array_keys2($arrayTest,'tp_test');
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testArray_keys2_position1() {
        $esperado  = array(0=>1);
        $arrayTest = array(0 => 'idTest',1=>'nm_test',2=>'tp_test');
        $retorno = ArrayHelper::array_keys2($arrayTest,'nm_test');
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testArray_keys2_position0() {
        $esperado  = array(0=>0);
        $arrayTest = array(0 => 'idTest',1=>'nm_test',2=>'tp_test');
        $retorno = ArrayHelper::array_keys2($arrayTest,'idTest');
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testArray_keys2_false() {
        $esperado  = array();
        $arrayTest = array("foo" => "bar","x" => "foo",100=> -100,-100=> 100);
        $retorno = ArrayHelper::array_keys2($arrayTest,'xxx');
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testGetDefaultValeu_NotInArray() {
    	$esperado  = 'x';
    	$array = array();
    	$array ['y'] = 123;
    	$atributeName = 'k';
    	$DefaultValue = 'x';    	
    	$retorno = ArrayHelper::getDefaultValeu($array,$atributeName,$DefaultValue);
    	$this->assertEquals($esperado, $retorno);
    }
    
    public function testGetDefaultValeu_NotArray() {
    	$esperado  = 'x';
    	$array = 123;
    	$atributeName = 'k';
    	$DefaultValue = 'x';
    	$retorno = ArrayHelper::getDefaultValeu($array,$atributeName,$DefaultValue);
    	$this->assertEquals($esperado, $retorno);
    }
    
    public function testGetDefaultValeu_InArray() {
    	$esperado  = 123;
    	$array = array();
    	$array ['y'] = 123;
    	$atributeName = 'y';
    	$DefaultValue = 'x';
    	$retorno = ArrayHelper::getDefaultValeu($array,$atributeName,$DefaultValue);
    	$this->assertEquals($esperado, $retorno);
    }    
    
    public function testGetArray_true() {
        $mock = new mockFormDinArray();        
        $esperado  = array(0=>'Joao Silva', 1=>'Maria Laranja', 2=>'Dell', 3=>'Microsoft');
        $array = $mock->generateTable();
        $atributeName = 'NMPESSOA';
        $retorno = ArrayHelper::getArray($array,$atributeName);
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testGetArray_false() {
        $mock = new mockFormDinArray();
        $esperado  = array();
        $array = $mock->generateTable();
        $atributeName = 'TIA';
        $retorno = ArrayHelper::getArray($array,$atributeName);
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testArrayFormKey_true() {
        $mock = new mockFormDinArray();
        $esperado  = 'Maria Laranja';
        $array = $mock->generateTable();
        $atributeName = 'NMPESSOA';
        $key = 1;
        $retorno = ArrayHelper::getArrayFormKey($array,$atributeName,$key);
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testArrayFormKey_AtributeNameNotFound() {
        $mock = new mockFormDinArray();
        $esperado  = null;
        $array = $mock->generateTable();
        $atributeName = 'TIA';
        $key = 1;
        $retorno = ArrayHelper::getArrayFormKey($array,$atributeName,$key);
        $this->assertEquals($esperado, $retorno);
    }

    public function testConvertArrayPdo2FormDin_Upcase() {
        $mock = new mockFormDinArray();
        $esperado  = $mock->generateTable();
        $array = $mock->generateTablePessoaPDO();
        $retorno = ArrayHelper::convertArrayPdo2FormDin($array,true);
        $this->assertEquals($esperado, $retorno);
    }
    
    
    public function testConvertArrayFormDin2Pdo_Upcase() {
        $mock = new mockFormDinArray();
        $esperado  = $mock->generateTablePessoaPDO();
        $array = $mock->generateTable();
        $retorno = ArrayHelper::convertArrayFormDin2Pdo($array,true);
        $this->assertEquals($esperado, $retorno);
    }
    //-----------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------
    public function testValidateIsArray_FailNull(){
        $this->expectException(InvalidArgumentException::class);
        ArrayHelper::validateIsArray(null,__METHOD__,__LINE__);
    }
    public function testValidateIsArray_FailArrayEmpty(){
        $this->expectException(InvalidArgumentException::class);
        $listArray = array();
        $this->assertNull( ArrayHelper::validateIsArray($listArray,__METHOD__,__LINE__) );
    }
    /**
     * @expectedException InvalidArgumentException
     */
    public function testValidateIsArray_FailString(){
        $listArray = 'xxx';
        $this->assertNull( ArrayHelper::validateIsArray($listArray,__METHOD__,__LINE__) );
    }
    public function testValidateIdIsNumeric_OKArrayNotEmpty(){
        $listArray = array();
        $listArray[]=1;
        $listArray[]=2;
        $this->assertNull( ArrayHelper::validateIsArray($listArray,__METHOD__,__LINE__) );
    }
    //-----------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------
    /**
     * @expectedException InvalidArgumentException
     */
    public function testFormDinDeleteRowByKeyIndex_FailNull(){
        ArrayHelper::formDinDeleteRowByKeyIndex(null,10);
    }
    
    public function testFormDinDeleteRowByKeyIndex_FailAttributeNotExist(){
        $mock = new mockFormDinArray();
        $array = $mock->generateTable();
        
        $result = ArrayHelper::formDinDeleteRowByKeyIndex($array,10);
        
        $expected = false;
        $this->assertEquals($expected, $result['result']);
        $expected = TMessage::ARRAY_KEY_NOT_EXIST;
        $this->assertEquals($expected, $result['message']);
    }
    
    //-----------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------
    /**
     * @expectedException InvalidArgumentException
     */
    public function testFormDinDeleteRowByColumnNameAndKeyIndex_FailNull(){
        ArrayHelper::formDinDeleteRowByColumnNameAndKeyIndex(null,'xx',10);
    }
    
    public function testFormDinDeleteRowByColumnNameAndKeyIndex_FailAttributeNotExist(){
        $mock = new mockFormDinArray();
        $array = $mock->generateTable();
        
        $result = ArrayHelper::formDinDeleteRowByColumnNameAndKeyIndex($array,'idCarro',10);
        
        $expected = false;
        $this->assertEquals($expected, $result['result']);
        $expected = TMessage::ARRAY_ATTRIBUTE_NOT_EXIST;
        $this->assertEquals($expected, $result['message']);
    }
    
    public function testFormDinDeleteRowByColumnNameAndKeyIndex_FailKeyNotExist(){
        $mock = new mockFormDinArray();
        $array = $mock->generateTable();
        
        $result = ArrayHelper::formDinDeleteRowByColumnNameAndKeyIndex($array,'IDPESSOA',10);
        
        $expected = false;
        $this->assertEquals($expected, $result['result']);
        $expected = TMessage::ARRAY_KEY_NOT_EXIST;
        $this->assertEquals($expected, $result['message']);
    }
    
    public function testFormDinDeleteRowByColumnNameAndKeyIndex_okQtd(){
        $mock = new mockFormDinArray();
        $array = $mock->generateTable();
        
        $result = ArrayHelper::formDinDeleteRowByColumnNameAndKeyIndex($array,'IDPESSOA',1);
        
        $expected = true;
        $this->assertEquals($expected, $result['result']);
        $expected = 3;
        $resultQtd = CountHelper::count($result['formarray']['IDPESSOA']);
        $this->assertEquals($expected, $resultQtd);
        
        $this->assertEquals(3, $result['formarray']['IDPESSOA'][1]);
        $this->assertEquals('Dell', $result['formarray']['NMPESSOA'][1]);
        $this->assertEquals('J', $result['formarray']['TPPESSOA'][1]);
        $this->assertEquals(null, $result['formarray']['NMCPF'][1]);
        $this->assertEquals('72381189000110', $result['formarray']['NMCNPJ'][1]);
    }
    
    public function testFormDinDeleteRowByColumnNameAndKeyIndex_ok3Times(){
        $mock = new mockFormDinArray();
        $array = $mock->generateTable();
        
        $result = ArrayHelper::formDinDeleteRowByColumnNameAndKeyIndex($array,'IDPESSOA',3);
        $result = ArrayHelper::formDinDeleteRowByColumnNameAndKeyIndex($result['formarray'],'IDPESSOA',2);
        $result = ArrayHelper::formDinDeleteRowByColumnNameAndKeyIndex($result['formarray'],'IDPESSOA',1);
        
        $expected = true;
        $this->assertEquals($expected, $result['result']);
        $expected = 1;
        $resultQtd = CountHelper::count($result['formarray']['IDPESSOA']);
        $this->assertEquals($expected, $resultQtd);
        
        $this->assertEquals(1, $result['formarray']['IDPESSOA'][0]);
        $this->assertEquals('Joao Silva', $result['formarray']['NMPESSOA'][0]);
        $this->assertEquals('F', $result['formarray']['TPPESSOA'][0]);
        $this->assertEquals('123456789', $result['formarray']['NMCPF'][0]);
    }
    
}