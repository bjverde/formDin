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
require_once '../classes/helpers/GetHelper.class.php';

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

