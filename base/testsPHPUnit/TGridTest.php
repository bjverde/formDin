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
require_once '../classes/webform/TGrid.class.php';
/**
 * TGrid test case.
 */
class TGridTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var TGrid
	 */
	private $tGrid;
	private $dataGrid;
	
	
	protected function incluirPessoa($dadosPessoa, $id, $nome, $tipo, $cpf, $cnpj){
		$dadosPessoa['IDPESSOA'][]=$id;   $dadosPessoa['NMPESSOA'][]=$nome;
		$dadosPessoa['TPPESSOA'][]=$tipo; $dadosPessoa['NMCPF'][]=$cpf;
		$dadosPessoa['NMCNPJ'][]=$cnpj;
		
		return $dadosPessoa;
	}
	
	protected function generateTable(){
		$dadosPessoa = isset($dadosPessoa) ? $dadosPessoa : null;
		$dadosPessoa = $this->incluirPessoa($dadosPessoa, 1, 'Joao Silva', 'F', '123456789', null);
		$dadosPessoa = $this->incluirPessoa($dadosPessoa, 2, 'Maria Laranja', 'F', '52798074002', null);
		$dadosPessoa = $this->incluirPessoa($dadosPessoa, 3, 'Dell', 'J', null, '72381189000110');
		
		return $dadosPessoa;
	}
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();				
		
		$primaryKey = 'IDPESSOA';
		$dadosPessoa = $this->generateTable();
		
		$mixUpdateFields = $primaryKey.'|'.$primaryKey.',NMPESSOA|NMPESSOA,TPPESSOA|TPPESSOA,NMCPF|NMCPF,NMCNPJ|NMCNPJ';
		$gride = new TGrid( 'gd'        // id do gride
				,'Gride'     // titulo do gride
				,$dadosPessoa            // array de dados
				,null                  // altura do gride
				,null                  // largura do gride
				,$primaryKey   // chave primaria
				,$mixUpdateFields
				);
		$gride->addColumn($primaryKey,'id',50,'center');
		$gride->addColumn('NMPESSOA','Nome',50,'center');
		$gride->addColumn('TPPESSOA','Tipo',50,'center');
		$gride->addColumn('NMCPF','CPF',13,'center');
		$gride->addColumn('NMCNPJ','CNPJ',15,'center');
		
		$this->tGrid = $gride;
		$this->dataGrid = $dadosPessoa;
		
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated TGridTest::tearDown()
		$this->tGrid = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	/**
	 * Tests TGrid->sortDataByColum()
	 */
	public function testSortDataByColum_RequestNull() {
		$expected = $this->dataGrid;
		
		$tGrid = $this->tGrid;
		$res = $tGrid->getData();
		$result = $tGrid->sortDataByColum($res);
		$this->assertEquals( $expected['IDPESSOA'][0] , $result['IDPESSOA'][0]);
		$this->assertEquals( $expected['IDPESSOA'][1] , $result['IDPESSOA'][1]);
		$this->assertEquals( $expected['IDPESSOA'][2] , $result['IDPESSOA'][2]);
	}
	
	public function testSortDataByColum_RequestNmpessoaOrderASC() {		
		$expected['NMPESSOA'][0] = $this->dataGrid['NMPESSOA'][2];
		$expected['NMPESSOA'][1] = $this->dataGrid['NMPESSOA'][0];
		$expected['NMPESSOA'][2] = $this->dataGrid['NMPESSOA'][1];
		
		$_REQUEST['gd_sorted_column']='NMPESSOA';
		$_REQUEST['gd_sorted_column_order']='SORT_ASC';
		
		$tGrid = $this->tGrid;
		$res = $tGrid->getData();
		$result = $tGrid->sortDataByColum($res);
		
		$this->assertEquals( $expected['NMPESSOA'][0] , $result['NMPESSOA'][0]);
		$this->assertEquals( $expected['NMPESSOA'][1] , $result['NMPESSOA'][1]);
		$this->assertEquals( $expected['NMPESSOA'][2] , $result['NMPESSOA'][2]);
	}
	
	public function testSortArray_parameterColunaBlank() {
		$expected = $this->dataGrid;
		
		$res = $this->dataGrid;
		$tGrid = $this->tGrid;
		$result = $tGrid->sortArray($res,'','SORT_ASC');
		
		$this->assertEquals( $expected , $result);
	}
	
	public function testSortArray_columNotExist() {
		$expected = $this->dataGrid;
		
		$res = $this->dataGrid;
		$tGrid = $this->tGrid;
		$result = $tGrid->sortArray($res,'xx','SORT_ASC');
		
		$this->assertEquals( $expected , $result);
	}
	
	public function testSortArray_OneRow() {
		$expected = isset($expected) ? $expected : null;
		$expected = $this->incluirPessoa($expected, 1, 'Joao Silva', 'F', '123456789', null);
		
		$res = isset($res) ? $res : null;
		$res = $this->incluirPessoa($res, 1, 'Joao Silva', 'F', '123456789', null);
		$tGrid = $this->tGrid;
		$result = $tGrid->sortArray($res,'NMPESSOA','SORT_ASC');
		
		$this->assertEquals( $expected , $result);
	}
	
	public function testSortArray_RequestNmpessoaOrderASC() {
		$expected['NMPESSOA'][0] = $this->dataGrid['NMPESSOA'][2];
		$expected['NMPESSOA'][1] = $this->dataGrid['NMPESSOA'][0];
		$expected['NMPESSOA'][2] = $this->dataGrid['NMPESSOA'][1];
		
		$_REQUEST['gd_sorted_column']='NMPESSOA';
		$_REQUEST['gd_sorted_column_order']='SORT_ASC';
		
		$tGrid = $this->tGrid;
		$res = $tGrid->getData();
		$result = $tGrid->sortDataByColum($res);
		
		$this->assertEquals( $expected['NMPESSOA'][0] , $result['NMPESSOA'][0]);
		$this->assertEquals( $expected['NMPESSOA'][1] , $result['NMPESSOA'][1]);
		$this->assertEquals( $expected['NMPESSOA'][2] , $result['NMPESSOA'][2]);
	}
	
	public function testGetRowNumWithPaginator_without_RealTotalRowsSqlPaginator() {
		$expected = 30;
		$tGrid = $this->tGrid;
		$result = $tGrid->getRowNumWithPaginator($expected,40,0);
		$this->assertEquals( $expected , $result);
	}
	
	
	public function testGetRowNumWithPaginator_with_RealTotalRowsSqlPaginator() {
		$expected = 30;
		$tGrid = $this->tGrid;
		$tGrid->setRealTotalRowsSqlPaginator(30);
		$result = $tGrid->getRowNumWithPaginator(20,$expected,0);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowCount_NoDataGrid() {
		$tGrid = $this->tGrid;
		$tGrid->setData(null);
		$result = $tGrid->getRowCount();
		
		$this->assertEquals( 0 , $result);
	}
	
	public function testGetRowCount_3Rows() {		
		$tGrid = $this->tGrid;
		$result = $tGrid->getRowCount();		
		$this->assertEquals( 3 , $result);
	}
	
	public function testGetRowCount_with_RealTotalRowsWithoutPaginator() {
		$expected = 30;
		$tGrid = $this->tGrid;
		$tGrid->setRealTotalRowsSqlPaginator($expected);
		$result = $tGrid->getRowCount();
		$this->assertEquals( $expected , $result);
	}
	
}

