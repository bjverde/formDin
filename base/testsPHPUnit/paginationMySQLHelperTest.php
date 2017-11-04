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
require_once '../classes/helpers/paginationSQLHelper.class.php';

/**
 * paginationSQLHelper test case.
 */
class paginationSQLHelperTest extends PHPUnit_Framework_TestCase {
	
	public function testGetRowStart_pageNullAndRowsPerPageNull() {
		$expected = 0;
		$page = null;
		$rowsPerPage =  null;
		$result = paginationSQLHelper::getRowStart($page,$rowsPerPage);		
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page1AndRowsPerPageNull() {
		$expected = 0;
		$page = 1;
		$rowsPerPage =  null;
		$result = paginationSQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page2AndRowsPerPageNull() {
		$expected = 20;
		$page = 2;
		$rowsPerPage =  null;
		$result = paginationSQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_pageNullAndRowsPerPage10() {
		$expected = 0;
		$page = null;
		$rowsPerPage =  10;
		$result = paginationSQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page1AndRowsPerPage30() {
		$expected = 0;
		$page = 1;
		$rowsPerPage =  30;
		$result = paginationSQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page2AndRowsPerPage30() {
		$expected = 30;
		$page = 2;
		$rowsPerPage =  30;
		$result = paginationSQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page3AndRowsPerPage10() {
		$expected = 20;
		$page = 3;
		$rowsPerPage =  10;
		$result = paginationSQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page2AndRowsPerPage13() {
		$expected = 13;
		$page = 2;
		$rowsPerPage =  13;
		$result = paginationSQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page3AndRowsPerPage13() {
		$expected = 26;
		$page = 3;
		$rowsPerPage =  13;
		$result = paginationSQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page10AndRowsPerPage13() {
		$expected = 117;
		$page = 10;
		$rowsPerPage =  13;
		$result = paginationSQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
}

