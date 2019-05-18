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


class TTableTest extends TestCase
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
	
	public function testNewTable() {
	    $expected = '<table id="tb01" >'.EOL
	               .'</table>'.EOL;
	    $test = new TTable('tb01');
	    $result = $test->show(false);
	    $this->assertSame($expected, $result);
	}
	
	public function testAddRow() {
	    $expected = '<table id="tb01" >'.EOL
	               .'<tr>'.EOL
	               .'</tr>'.EOL
	               .'</table>'.EOL;
	    $test = new TTable('tb01');
	    $test->addRow();
	    $result = $test->show(false);
	    $this->assertSame($expected, $result);
	}
	
	
	public function testAddCell() {
	    $expected = '<table id="tb01" >'.EOL
	               .'<tr>'.EOL
	               .ESP.'<td>'.EOL
	               .'        aaa'.EOL
	               .ESP.'</td>'.EOL
	               .'</tr>'.EOL
	               .'</table>'.EOL;
	    $test = new TTable('tb01');
	    $row = $test->addRow();
	    $row->addCell('aaa');
	    $result = $test->show(false);
	    $this->assertSame($expected, $result);
	}

}