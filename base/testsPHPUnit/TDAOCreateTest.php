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

require_once '../classes/constants.php';
require_once '../classes/webform/TDAOCreate.class.php';

define('TEOL',"\n");
define('TTAB',chr(9));
/**
 * TDAOCreate test case.
 */
class TDAOCreateTest extends PHPUnit_Framework_TestCase {

    /**
     *
     * @var TDAOCreate
     */
    private $tDAOCreate;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(){
        parent::setUp();        
        // TODO Auto-generated TDAOCreateTest::setUp()
        $tableName = 'myTableTest';
        $keyColumnName = 'pkColumnName';
        $this->tDAOCreate = new TDAOCreate($tableName,$keyColumnName);
        
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(){
        // TODO Auto-generated TDAOCreateTest::tearDown()
        $this->tDAOCreate = null;        
        parent::tearDown();
    }
    
    public function testSetShowSchema_true(){
        $esperado = true;
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setShowSchema(true);
        $retorno = $tDAOCreate->getShowSchema();
        //$this->tDAOCreate->setShowSchema(true);
        //$retorno = $this->tDAOCreate->getShowSchema();        
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testSetShowSchema_false(){
        $esperado = false;
        $this->tDAOCreate->setShowSchema(false);
        $retorno = $this->tDAOCreate->getShowSchema();
        $this->assertEquals($esperado, $retorno);
    }

    public function testHasSchema_yes(){
        $esperado = '\'.SCHEMA.\'';        
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setShowSchema(true);
        $retorno = $tDAOCreate->hasSchema();        
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testHasSchema_no(){
        $esperado = '';
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setShowSchema(false);
        $retorno = $tDAOCreate->hasSchema();  
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testAddLine_string(){
    	$esperado = 'echo';
    	$tDAOCreate = $this->tDAOCreate;
    	$tDAOCreate->addLine($esperado);
    	$retorno = $tDAOCreate->getLinesString();
    	$this->assertEquals($esperado, $retorno);
    	
    	$retornoArray = $tDAOCreate->getLinesArray();
    	$size = count($retornoArray);
    	$this->assertEquals( 1, $size);
    }
    
    public function testAddLine_nameFunction(){
    	$tDAOCreate = $this->tDAOCreate;
    	$esperado = TTAB.'public function '.$tDAOCreate->getTableName().'DAO() {';
    	$tDAOCreate->addLine($esperado);    	
    	$retorno = $tDAOCreate->getLinesString();
    	$this->assertEquals( trim($esperado), $retorno);
    	
    	$retornoArray = $tDAOCreate->getLinesArray();
    	$size = count($retornoArray);
    	$this->assertEquals( 1, $size);
    }
    
    public function testAddLine_onlyLine(){
    	$esperado = TTAB.'//'.str_repeat( '-', 80 ).TEOL;
    	$tDAOCreate = $this->tDAOCreate;
    	$tDAOCreate->addLine();
    	$retorno = $tDAOCreate->getLinesString();
    	$this->assertEquals( trim($esperado), $retorno);
    	
    	$retornoArray = $tDAOCreate->getLinesArray();
    	$size = count($retornoArray);
    	$this->assertEquals( 1, $size);
    }    
    
    public function testAddSqlSelectCount_sizeArray(){
    	$tDAOCreate = $this->tDAOCreate;
    	$tDAOCreate->addSqlSelectCount();
    	
    	$resultArray = $tDAOCreate->getLinesArray();
    	$size = count($resultArray);
    	$this->assertEquals( 5, $size);
    }

    public function testAddSqlSelectAllPagination_sizeArrayNoDBMS(){
        $tDAOCreate = $this->tDAOCreate;        
        $tDAOCreate->addSqlSelectAllPagination();
        
        $resultArray = $tDAOCreate->getLinesArray();
        $size = count($resultArray);
        $this->assertEquals( 10, $size);
    }
    
    public function testAddSqlSelectAllPagination_sizeArrayMySQL(){
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setDatabaseManagementSystem('mysql');
        $tDAOCreate->addSqlSelectAllPagination();
        
        $resultArray = $tDAOCreate->getLinesArray();
        $size = count($resultArray);
        $this->assertEquals( 11, $size);
    }
    
    public function testAddSqlSelectAllPagination_stringMySQL(){
        $expectedArray[] = TTAB.'public static function selectAllPagination( $orderBy=null, $where=null, $page=null,  $rowsPerPage= null ) {'.TEOL;
        $expectedArray[] = TTAB.TTAB.'$rowStart = paginationSQLHelper::getRowStart($page,$rowsPerPage);'.TEOL;
        $expectedArray[] = ''.TEOL;
        $expectedArray[] = TTAB.TTAB.'$sql = self::$sqlBasicSelect'.TEOL;
        $expectedArray[] = TTAB.TTAB.'.( ($where)? \' where \'.$where:\'\')'.TEOL;
        $expectedArray[] = TTAB.TTAB.'.( ($orderBy) ? \' order by \'.$orderBy:\'\');'.TEOL;
        $expectedArray[] = TTAB.TTAB.'.( \' LIMIT \'.$rowStart.\',\'.$rowsPerPage);'.TEOL;
        $expectedArray[] = ''.TEOL;
        $expectedArray[] = TTAB.TTAB.'$result = self::executeSql($sql);'.TEOL;
        $expectedArray[] = TTAB.TTAB.'return $result;'.TEOL;
        $expectedArray[] = TTAB.'}'.TEOL;
        
        
        $expectedString = trim( implode($expectedArray) );
        
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setDatabaseManagementSystem('mysql');
        $tDAOCreate->addSqlSelectAllPagination();        
        
        $result = $tDAOCreate->getLinesString();
        
        $this->assertEquals( $expectedString , $result);
    }
    
    public function testAddSqlSelectAllPagination_stringMSSQL(){
        $expectedArray[] = TTAB.'public static function selectAllPagination( $orderBy=null, $where=null, $page=null,  $rowsPerPage= null ) {'.TEOL;
        $expectedArray[] = TTAB.TTAB.'$rowStart = paginationSQLHelper::getRowStart($page,$rowsPerPage);'.TEOL;
        $expectedArray[] = ''.TEOL;
        $expectedArray[] = TTAB.TTAB.'$sql = self::$sqlBasicSelect'.TEOL;
        $expectedArray[] = TTAB.TTAB.'.( ($where)? \' where \'.$where:\'\')'.TEOL;
        $expectedArray[] = TTAB.TTAB.'.( ($orderBy) ? \' order by \'.$orderBy:\'\');'.TEOL;
        $expectedArray[] = TTAB.TTAB.'.( \' OFFSET \'.$rowStart.\' ROWS FETCH NEXT \'.$rowsPerPage.\' ONLY \');'.TEOL;
        $expectedArray[] = ''.TEOL;
        $expectedArray[] = TTAB.TTAB.'$result = self::executeSql($sql);'.TEOL;
        $expectedArray[] = TTAB.TTAB.'return $result;'.TEOL;
        $expectedArray[] = TTAB.'}'.TEOL;
        
        
        $expectedString = trim( implode($expectedArray) );
        
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setDatabaseManagementSystem('mssql');
        $tDAOCreate->addSqlSelectAllPagination();
        
        $result = $tDAOCreate->getLinesString();
        
        $this->assertEquals( $expectedString , $result);
    }
    
    public function testAddSqlDelete_sizeArray(){
    	$tDAOCreate = $this->tDAOCreate;
    	$tDAOCreate->addSqlDelete();
    	
    	$resultArray = $tDAOCreate->getLinesArray();
    	$size = count($resultArray);
    	$this->assertEquals( 4, $size);
    }
    
    public function testAddSqlDelete_string(){
    	$tDAOCreate = $this->tDAOCreate;
    	
    	$expectedArray[] = TTAB.'public static function delete( $id ){'.TEOL;
    	$expectedArray[] = TTAB.TTAB.'$values = array($id);'.TEOL;
    	$expectedArray[] = TTAB.TTAB.'return self::executeSql(\'delete from '.$tDAOCreate->hasSchema().$tDAOCreate->getTableName().' where '.$tDAOCreate->getKeyColumnName().' = '.$tDAOCreate->getCharParam().'\',$values);'.TEOL;
    	$expectedArray[] = TTAB.'}'.TEOL;
    	$expectedString = trim( implode($expectedArray) );
    	
    	$tDAOCreate->addSqlDelete();
    	$result = $tDAOCreate->getLinesString();
    	
    	$this->assertEquals( $expectedString , $result);
    }

}