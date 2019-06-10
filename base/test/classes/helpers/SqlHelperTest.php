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

use PHPUnit\Framework\TestCase;

/**
 * paginationSQLHelper test case.
 */
class SqlHelperTest extends TestCase
{
	
	public function testGetRowStart_pageNullAndRowsPerPageNull() {
		$expected = 0;
		$page = null;
		$rowsPerPage =  null;
		$result = SqlHelper::getRowStart($page,$rowsPerPage);		
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page1AndRowsPerPageNull() {
		$expected = 0;
		$page = 1;
		$rowsPerPage =  null;
		$result = SqlHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page2AndRowsPerPageNull() {
		$expected = 20;
		$page = 2;
		$rowsPerPage =  null;
		$result = SqlHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_pageNullAndRowsPerPage10() {
		$expected = 0;
		$page = null;
		$rowsPerPage =  10;
		$result = SqlHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page1AndRowsPerPage30() {
		$expected = 0;
		$page = 1;
		$rowsPerPage =  30;
		$result = SqlHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page2AndRowsPerPage30() {
		$expected = 30;
		$page = 2;
		$rowsPerPage =  30;
		$result = SqlHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page3AndRowsPerPage10() {
		$expected = 20;
		$page = 3;
		$rowsPerPage =  10;
		$result = SqlHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page2AndRowsPerPage13() {
		$expected = 13;
		$page = 2;
		$rowsPerPage =  13;
		$result = SqlHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page3AndRowsPerPage13() {
		$expected = 26;
		$page = 3;
		$rowsPerPage =  13;
		$result = SqlHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page10AndRowsPerPage13() {
		$expected = 117;
		$page = 10;
		$rowsPerPage =  13;
		$result = SqlHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testAttributeIssetOrNotZero_AttributeNull_FALSE() {
		$expected = 'ISFALSE';
		$whereGrid = null;
		$isTrue = 'ISTRUE';
		$isFalse = 'ISFALSE';
		$result = SqlHelper::attributeIssetOrNotZero($whereGrid,'NUMERO',$isTrue,$isFalse);
		$this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testAttributeIssetOrNotZero_AttributeWhite_FALSE() {
		$expected = 'ISFALSE';
		$whereGrid = array();
		$whereGrid['NUMERO']='';
		$isTrue = 'ISTRUE';
		$isFalse = 'ISFALSE';
		$result = SqlHelper::attributeIssetOrNotZero($whereGrid,'NUMERO',$isTrue,$isFalse);
		$this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testAttributeIssetOrNotZero_AttributeZero_FALSE_testZeroOmitted() {
		$expected = 'ISFALSE';
		$whereGrid = array();
		$whereGrid['NUMERO']=0;
		$isTrue = 'ISTRUE';
		$isFalse = 'ISFALSE';
		$result = SqlHelper::attributeIssetOrNotZero($whereGrid,'NUMERO',$isTrue,$isFalse);
		$this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testAttributeIssetOrNotZero_AttributeZero_FALSE_testZeroTRUE() {
	    $expected = 'ISFALSE';
	    $whereGrid = array();
	    $whereGrid['NUMERO']=0;
	    $isTrue = 'ISTRUE';
	    $isFalse = 'ISFALSE';
	    $result = SqlHelper::attributeIssetOrNotZero($whereGrid,'NUMERO',$isTrue,$isFalse,TRUE);
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testAttributeIssetOrNotZero_AttributeZero_FALSE_testZeroFALSE() {
	    $expected = 'ISTRUE';
	    $whereGrid = array();
	    $whereGrid['NUMERO']=0;
	    $isTrue = 'ISTRUE';
	    $isFalse = 'ISFALSE';
	    $result = SqlHelper::attributeIssetOrNotZero($whereGrid,'NUMERO',$isTrue,$isFalse,FALSE);
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testAttributeIssetOrNotZero_AttributeSearchDoNotExist_FALSE() {
		$expected = 'ISFALSE';
		$whereGrid = array();
		$whereGrid['NUMBER']=0;
		$isTrue = 'ISTRUE';
		$isFalse = 'ISFALSE';
		$result = SqlHelper::attributeIssetOrNotZero($whereGrid,'X',$isTrue,$isFalse);
		$this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testAttributeIssetOrNotZero_Attribute_TRUE() {
		$expected = 'ISTRUE';
		$whereGrid = array();
		$whereGrid['NUMERO']='xxx';
		$isTrue = 'ISTRUE';
		$isFalse = 'ISFALSE';
		$result = SqlHelper::attributeIssetOrNotZero($whereGrid,'NUMERO',$isTrue,$isFalse);
		$this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testTransformValidateString_ok_MySQL() {
	    $expected = 'blablabla';
	    $string = 'blablabla';
	    SqlHelper::setDbms(DBMS_MYSQL);
	    $result = SqlHelper::transformValidateString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testTransformValidateString_SingleQuotes_MySQL() {
	    $expected = "blabl\'abla";
	    $string = "blabl'abla";
	    SqlHelper::setDbms(DBMS_MYSQL);
	    $result = SqlHelper::transformValidateString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testTransformValidateString_DubleQuotes_MySQL() {
	    $expected = 'blabl\"abla';
	    $string = 'blabl"abla';
	    SqlHelper::setDbms(DBMS_MYSQL);
	    $result = SqlHelper::transformValidateString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testTransformValidateString_ok_SqlServer() {
	    $expected = 'blablabla';
	    $string = 'blablabla';
	    SqlHelper::setDbms(DBMS_SQLSERVER);
	    $result = SqlHelper::transformValidateString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	/**
	 * @expectedException DomainException
	 */
	public function testTransformValidateString_SingleQuotes_SqlServer() {
	    $string = "blabl'abla";
	    SqlHelper::setDbms(DBMS_SQLSERVER);
	    SqlHelper::transformValidateString( $string );
	}
	//--------------------------------------------------------------------------------
	/**
	 * @expectedException DomainException
	 */
	public function testTransformValidateString_DubleQuotes_SqlServer() {
	    $string = 'blabl"abla';
	    SqlHelper::setDbms(DBMS_SQLSERVER);
	    SqlHelper::transformValidateString( $string );
	}
	//--------------------------------------------------------------------------------
	public function testGetSqlTypeIn_TextNoArray() {
	    $expected = ' AND LETRAS = \'xxx\'  ';
	    $stringWhere = null;
	    $value = 'xxx';
	    $arrayWhereGrid = array();
	    $arrayWhereGrid['LETRAS'] = $value;
	    $attribute = 'LETRAS';
	    $result = SqlHelper::getSqlTypeIn($stringWhere, $arrayWhereGrid, $attribute, true ,$value,null,SqlHelper::SQL_TYPE_IN_TEXT);
	    $this->assertEquals( $expected , $result);
	}
	public function testGetSqlTypeIn_TextArray1Element() {
	    $expected = ' AND LETRAS = \'a\'  ';
	    $stringWhere = null;
	    $value = array('a');
	    $arrayWhereGrid = array();
	    $arrayWhereGrid['X'] = 123;
	    $arrayWhereGrid['D'] = 123;
	    $arrayWhereGrid['LETRAS'] = $value;
	    $attribute = 'LETRAS';
	    $result = SqlHelper::getSqlTypeIn($stringWhere, $arrayWhereGrid, $attribute, true ,$value,null,SqlHelper::SQL_TYPE_IN_TEXT);
	    $this->assertEquals( $expected , $result);
	}
	public function testGetSqlTypeIn_Text() {
	    $expected = ' AND LETRAS in (\'a\',\'b\',\'c\') ';
	    $stringWhere = null;
	    $value = array('a','b','c');
	    $arrayWhereGrid = array(); 
	    $arrayWhereGrid['X'] = 123;
	    $arrayWhereGrid['D'] = 123;
	    $arrayWhereGrid['LETRAS'] = $value;
	    $attribute = 'LETRAS';
	    $result = SqlHelper::getSqlTypeIn($stringWhere, $arrayWhereGrid, $attribute, true ,$value,null,SqlHelper::SQL_TYPE_IN_TEXT);
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testGetSqlTypeIn_NumericNoArray() {
	    $expected = ' AND NUMEROS = 1  ';
	    $stringWhere = null;
	    $value = '1';
	    $arrayWhereGrid = array();
	    $arrayWhereGrid['NUMEROS'] = $value;
	    $attribute = 'NUMEROS';
	    $result = SqlHelper::getSqlTypeIn($stringWhere, $arrayWhereGrid, $attribute, true ,$value,null,SqlHelper::SQL_TYPE_IN_NUMERIC);
	    $this->assertEquals( $expected , $result);
	}
	public function testGetSqlTypeIn_NumericArray1Element() {
	    $expected = ' AND NUMEROS = 1  ';
	    $stringWhere = null;
	    $value = array('1');
	    $arrayWhereGrid = array();
	    $arrayWhereGrid['X'] = 123;
	    $arrayWhereGrid['D'] = 123;
	    $arrayWhereGrid['NUMEROS'] = $value;
	    $attribute = 'NUMEROS';
	    $result = SqlHelper::getSqlTypeIn($stringWhere, $arrayWhereGrid, $attribute, true ,$value,null,SqlHelper::SQL_TYPE_IN_NUMERIC);
	    $this->assertEquals( $expected , $result);
	}
	public function testGetSqlTypeIn_Numeric() {
	    $expected = ' AND NUMEROS in (1,2,3) ';
	    $stringWhere = null;
	    $value = array('1','2','3');
	    $arrayWhereGrid = array();
	    $arrayWhereGrid['X'] = 123;
	    $arrayWhereGrid['D'] = 123;
	    $arrayWhereGrid['NUMEROS'] = $value;
	    $attribute = 'NUMEROS';
	    $result = SqlHelper::getSqlTypeIn($stringWhere, $arrayWhereGrid, $attribute, true ,$value,null,SqlHelper::SQL_TYPE_IN_NUMERIC);
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_1Word_MySQL() {
	    $expected = 'blablabla';
	    $string = 'blablabla';
	    SqlHelper::setDbms(DBMS_MYSQL);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_2Words_MySQL() {
	    $expected = 'blablabla%etcetc';
	    $string = 'blablabla etcetc';
	    SqlHelper::setDbms(DBMS_MYSQL);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_5Words_MySQL() {
	    $expected = 'aaa%bbb%ccc%ddd%eee';
	    $string = 'aaa bbb ccc ddd eee';
	    SqlHelper::setDbms(DBMS_MYSQL);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_1Word_Postgresql() {
	    $expected = 'blablabla';
	    $string = 'blablabla';
	    SqlHelper::setDbms(DBMS_POSTGRES);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_2Words_Postgresql() {
	    $expected = 'blablabla%etcetc';
	    $string = 'blablabla etcetc';
	    SqlHelper::setDbms(DBMS_POSTGRES);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_5Words_Postgresql() {
	    $expected = 'aaa%bbb%ccc%ddd%eee';
	    $string = 'aaa bbb ccc ddd eee';
	    SqlHelper::setDbms(DBMS_POSTGRES);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_1Word_Sqlite() {
	    $expected = 'blablabla';
	    $string = 'blablabla';
	    SqlHelper::setDbms(DBMS_SQLITE);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_2Words_Sqlite() {
	    $expected = 'blablabla%etcetc';
	    $string = 'blablabla etcetc';
	    SqlHelper::setDbms(DBMS_SQLITE);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_5Words_Sqlite() {
	    $expected = 'aaa%bbb%ccc%ddd%eee';
	    $string = 'aaa bbb ccc ddd eee';
	    SqlHelper::setDbms(DBMS_SQLITE);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_1Word_SqlServer() {
	    $expected = 'blablabla';
	    $string = 'blablabla';
	    SqlHelper::setDbms(DBMS_SQLSERVER);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_2Words_SqlServer() {
	    $expected = 'blablabla%etcetc';
	    $string = 'blablabla etcetc';
	    SqlHelper::setDbms(DBMS_SQLSERVER);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testExplodeTextString_5Words_SqlServer() {
	    $expected = 'aaa%bbb%ccc%ddd%eee';
	    $string = 'aaa bbb ccc ddd eee';
	    SqlHelper::setDbms(DBMS_SQLSERVER);
	    $result = SqlHelper::explodeTextString( $string );
	    $this->assertEquals( $expected , $result);
	}	
	//--------------------------------------------------------------------------------
	public function getWhereGrid() {
	    $whereGrid = array('1WORD'=> 'blablabla'
	                      ,'2WORD'=> 'blablabla etcetc'
	                      ,'5WORD'=> 'aaa bbb ccc ddd eee'
	                      ,'NUM_ORD'=> '1200'
	                      );	    
	    return $whereGrid;
	}
	//--------------------------------------------------------------------------------
	public function testGetAtributeWhereGridParameters_Numeric_only() {
	    $expected = ' AND NUM_ORD = 1200  ';
	    $where = null;
	    $whereGrid = self::getWhereGrid();
	    $result = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'NUM_ORD', SqlHelper::SQL_TYPE_NUMERIC);
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testGetAtributeWhereGridParameters_Numeric_others() {
	    $expected = ' AND 1WORD = \'blablabla\'   AND NUM_ORD = 1200  ';
	    $where = ' AND 1WORD = \'blablabla\'  ';
	    $whereGrid = self::getWhereGrid();
	    $result = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'NUM_ORD', SqlHelper::SQL_TYPE_NUMERIC);
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testGetAtributeWhereGridParameters_TextEqual_1word() {
	    $expected = ' AND 1WORD = \'blablabla\'  ';
	    $where = null;
	    $whereGrid = self::getWhereGrid();
	    $result = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, '1WORD', SqlHelper::SQL_TYPE_TEXT_EQUAL);
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testGetAtributeWhereGridParameters_TextEqual_5word() {
	    $expected = ' AND 5WORD = \'aaa bbb ccc ddd eee\'  ';
	    $where = null;
	    $whereGrid = self::getWhereGrid();
	    $result = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, '5WORD', SqlHelper::SQL_TYPE_TEXT_EQUAL);
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testGetAtributeWhereGridParameters_TextLike_1word() {
	    $expected = ' AND 1WORD like \'%blablabla%\' ';
	    $where = null;
	    $whereGrid = self::getWhereGrid();
	    $result = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, '1WORD', SqlHelper::SQL_TYPE_TEXT_LIKE);
	    $this->assertEquals( $expected , $result);
	}
	//--------------------------------------------------------------------------------
	public function testGetAtributeWhereGridParameters_TextLike_5word() {
	    $expected = ' AND 5WORD like \'%aaa%bbb%ccc%ddd%eee%\' ';
	    $where = null;
	    $whereGrid = self::getWhereGrid();
	    $result = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, '5WORD', SqlHelper::SQL_TYPE_TEXT_LIKE);
	    $this->assertEquals( $expected , $result);
	}
}