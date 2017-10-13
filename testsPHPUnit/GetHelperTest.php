<?php
require_once '../base/classes/helpers/GetHelper.class.php';

/**
 * GetHelper test case.
 */
class GetHelperTest extends PHPUnit_Framework_TestCase {

    public function testGet_tem() {
        $esperado = 10;
        $_GET['x']= $esperado;
        $retorno = GetHelper::get('x');        
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testGet_Naotem() {
        $esperado = '';
        $_GET['x']= 123;
        $retorno = GetHelper::get('z');
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testGetDefaultValeu_temValor(){
        $esperado = 10;
        $_GET['x']= $esperado;
        $retorno = GetHelper::getDefaultValeu('x','padrao');        
        $this->assertEquals($esperado, $retorno);
    }

    public function testGetDefaultValeu_NaoValor(){
        $esperado = 'padrao';
        $_GET['x']= 10;
        $retorno = GetHelper::getDefaultValeu('y','padrao');
        $this->assertEquals($esperado, $retorno);
    }    
    
    public function testHas_true() {
        $_GET['parametro']='tem';
        $retorno = GetHelper::has('parametro');
        $this->assertTrue($retorno);
    }
    
    public function testHas_false() {
        $retorno = GetHelper::has('naotem');
        $this->assertFalse($retorno);
    }
}

