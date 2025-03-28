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
$path =  __DIR__.'/../../../';
require_once $path.'classes/constants.php';
require_once $path.'classes/webform/autoload_formdin.php';
require_once $path.'classes/helpers/autoload_formdin_helper.php';

use PHPUnit\Framework\TestCase;

/**
 * TPDOConnection test case.
 */
class TPDOConnectionTest extends TestCase
{
	/**
	 *
	 * @var TPDOConnection
	 */
    private $TPDOConnection;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp(): void {
		parent::setUp ();
		//if(!defined('ENCODINGS')){ define('ENCODINGS','UTF-8'); }
		$this->TPDOConnection = new TPDOConnection(/* parameters */);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown(): void {
	    $this->TPDOConnection = null;		
		parent::tearDown ();
	}
	
	public function testGetUtfDecode_NotDefined() {
		$expected= true;
		
		$boolNewValue = $this->TPDOConnection->getUtfDecode();
		$this->assertEquals( $expected , $boolNewValue);
	}
	
	public function testSetConfigDBMS_ArrayWrong() {
		$expected= 'Array Config is not configured! Define DBMS';
		
		$useConfigFile= false;
		$configArray  = array( 'X'=>'A');
		$configErrors = array();
		$root = null;
		$configErrors = $this->TPDOConnection->setConfigDBMS($useConfigFile, $configArray, $configErrors, $root);
		$size = count($configErrors);
		$this->assertEquals( 1 , $size);
		$this->assertEquals( $expected , $configErrors[0]);
	}
	
	public function testSetConfigDBMS_ArrayDBMS() {
		$expected= DBMS_MYSQL;
		
		$useConfigFile= false;
		$configArray  = array( 'DBMS'=>DBMS_MYSQL);
		$configErrors = array();
		$root = null;
		$configErrors = $this->TPDOConnection->setConfigDBMS($useConfigFile, $configArray, $configErrors, $root);
		$size = count($configErrors);
		$this->assertEquals( 0 , $size);
		$this->assertEquals( $expected , $this->TPDOConnection->getDBMS());
	}
	
	public function testSetConfigDBMS_ArrayBanco() {
		$expected= DBMS_MYSQL;
		
		$useConfigFile= false;
		$configArray  = array( 'BANCO'=>DBMS_MYSQL);
		$configErrors = array();
		$root = null;
		$configErrors = $this->TPDOConnection->setConfigDBMS($useConfigFile, $configArray, $configErrors, $root);
		$size = CountHelper::count($configErrors);
		$this->assertEquals( 0 , $size);
		$this->assertEquals( $expected , $this->TPDOConnection->getDBMS());
	}
	
	public function testSetConfigDbmsPort_ArrayDefault(){
		$expected= '3306';
		
		$useConfigFile= false;
		$configArray  = array( 'BANCO'=>DBMS_MYSQL);
		$configErrors = array();
		$configErrors = $this->TPDOConnection->setConfigDbmsPort($useConfigFile, $configArray);
		$size = CountHelper::count($configErrors);
		$this->assertEquals( 0 , $size);
		$result = $this->TPDOConnection->getPort();
		$this->assertEquals( $expected , $result);
	}
	
	public function testSetConfigDbmsPort_ArrayDiferentPort(){
		$expected= '7001';
		
		$useConfigFile= false;
		$configArray  = array( 'BANCO'=>DBMS_MYSQL , 'PORT'=>'7001');
		$configErrors = array();
		$configErrors = $this->TPDOConnection->setConfigDbmsPort($useConfigFile, $configArray);
		$size = CountHelper::count($configErrors);
		$this->assertEquals( 0 , $size);
		$this->assertEquals( $expected , $this->TPDOConnection->getPort());
	}
	
	public function testgetDefaultPortDBMS_EmptyDbmsNull(){
		$this->expectException(InvalidArgumentException::class);
		$DBMS = null;
		$this->TPDOConnection->getDefaultPortDBMS($DBMS);
	}
	
	public function testgetDefaultPortDBMS_EmptyDbmsWhite(){
		$this->expectException(InvalidArgumentException::class);
		$DBMS = '';
		$this->TPDOConnection->getDefaultPortDBMS($DBMS);
	}
	
	public function testgetDefaultPortDBMS_WrongDbms(){
		$this->expectException(InvalidArgumentException::class);
		$DBMS = 'test';
		$this->TPDOConnection->getDefaultPortDBMS($DBMS);
	}
	
	public function testgetDefaultPortDBMS_MySQLDefault(){
		$expected= '3306';
		$DBMS = DBMS_MYSQL;
		$port = $this->TPDOConnection->getDefaultPortDBMS($DBMS);
		$this->assertSame( $expected , $port );
	}
	
	public function testgetDefaultPortDBMS_PostgresDefault(){
		$expected= '5432';
		$DBMS = DBMS_POSTGRES;
		$port = $this->TPDOConnection->getDefaultPortDBMS($DBMS);
		$this->assertSame( $expected , $port );
	}

	public function testgetDefaultPortDBMS_OracleDefault(){
		$expected= '1521';
		$DBMS = DBMS_ORACLE;
		$port = $this->TPDOConnection->getDefaultPortDBMS($DBMS);
		$this->assertSame( $expected , $port );
	}
	
	public function testgetDefaultPortDBMS_SqlServerDefault(){
		$expected= '1433';
		$DBMS = DBMS_SQLSERVER;
		$port = $this->TPDOConnection->getDefaultPortDBMS($DBMS);
		$this->assertSame( $expected , $port );
	}
	
	public function testSetConfigUtf8Decode_ArrayEmpty(){
		$expected = true;
		
		$useConfigFile= false;
		$configArray  = array( 'BANCO'=>DBMS_MYSQL , 'PORT'=>'7001');
		$this->TPDOConnection->setConfigUtf8Decode($useConfigFile, $configArray);
		$utf8 = $this->TPDOConnection->getUtfDecode();
		$this->assertSame( $expected , $utf8 );
	}

	public function testSetConfigUtf8Decode_ArrayUtf8True(){
		$expected = 1;
		
		$useConfigFile= false;
		$configArray  = array( 'BANCO'=>DBMS_MYSQL , 'PORT'=>'7001' , 'UTF8_DECODE' => 1);
		$this->TPDOConnection->setConfigUtf8Decode($useConfigFile, $configArray);
		$utf8 = $this->TPDOConnection->getUtfDecode();
		$this->assertSame( $expected , $utf8 );
	}
	
	public function testSetConfigUtf8Decode_ArrayUtf8False(){
		$expected = 0;
		
		$useConfigFile= false;
		$configArray  = array( 'BANCO'=>DBMS_MYSQL , 'PORT'=>'7001' , 'UTF8_DECODE' => 0);
		$this->TPDOConnection->setConfigUtf8Decode($useConfigFile, $configArray);
		$utf8 = $this->TPDOConnection->getUtfDecode();
		$this->assertSame( $expected , $utf8 );
	}
	
	public function testPrepareArray_string() {
	    $arrayExpected = array();
		$arrayExpected[0] = 'abc';
		$arrayExpected[1] = '123.679,00';

		$arrayData = array();
		$arrayData[0] = 'abc';
		$arrayData[1] = '123.679,00';
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_stringVazia() {
	    $arrayExpected = array();
	    $arrayExpected[0] = null;
		$arrayExpected[1] = '123.679,00';
		$arrayExpected[2] = null;
		
		$arrayData = array();
		$arrayData[0] = '';
		$arrayData[1] = '123.679,00';
		$arrayData[2] = "";
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_stringEspace() {
	    $arrayExpected = array();
	    $arrayExpected[0] = ' ';
		$arrayExpected[1] = '123.679,00';
		$arrayExpected[2] = '   ';
		
		$arrayData = array();
		$arrayData[0] = ' ';
		$arrayData[1] = '123.679,00';
		$arrayData[2] = '   ';
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_soNumerosComZero() {
	    $arrayExpected = array();
	    $arrayExpected[0] = 1;
		$arrayExpected[1] = 0;

		$arrayData = array();
		$arrayData[0] = 1;
		$arrayData[1] = 0;
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_soNumerosStringComZero() {
	    $arrayExpected = array();
		$arrayExpected[0] = '1';
		$arrayExpected[1] = '0';
		
		$arrayData = array();
		$arrayData[0] = '1';
		$arrayData[1] = '0';
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_dateDDMMYYYY() {
	    $arrayExpected = array();
		$arrayExpected[0] = '1980-01-01';
		$arrayData = array();
		$arrayData[0] = '01/01/1980';
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testPrepareArray_dateDDMM() {
	    $arrayExpected = array();
		$arrayExpected[0] = '28/12';
		$arrayData = array();
		$arrayData[0] = '28/12';
		
		$arrayActual = $this->TPDOConnection->prepareArray($arrayData);
		$this->assertSame( $arrayExpected , $arrayActual,'Os arrays nao sao iguais');
	}
	
	public function testGetStrUtf8OrAnsi_DecoldeFalseApp2DbStringUtf8() {
	    $string = 'Você deve ter recebido uma cópia da GNU LGPL versão 3';
	    
	    $this->TPDOConnection->setDBMS(DBMS_POSTGRES);
	    $result = $this->TPDOConnection->getStrUtf8OrAnsi(false, $string, TPDOConnection::WAY_APP2BANK);
	    $this->assertSame( $string , $result,'String não tem o mesmo formato');
	}
	
	public function testGetStrUtf8OrAnsi_DecoldeFalseApp2DbStringISO88591() {
	    $string = 'Você deve ter recebido uma cópia da GNU LGPL versão 3';
	    $string = StringHelper::utf8_decode($string);
	    
	    $this->TPDOConnection->setDBMS(DBMS_POSTGRES);
	    $result = $this->TPDOConnection->getStrUtf8OrAnsi(false, $string, TPDOConnection::WAY_APP2BANK);
	    $this->assertSame( $string , $result,'String não tem o mesmo formato');
	}
	
	public function testGetStrUtf8OrAnsi_DecoldefalseDb2AppStringUtf8() {
	    $string = 'Você deve ter recebido uma cópia da GNU LGPL versão 3';
	    
	    $this->TPDOConnection->setDBMS(DBMS_POSTGRES);
	    $result = $this->TPDOConnection->getStrUtf8OrAnsi(false, $string, TPDOConnection::WAY_BANK2APP);
	    $this->assertSame( $string , $result,'String não tem o mesmo formato');
	}
	
	public function testGetStrUtf8OrAnsi_DecoldefalseDb2AppStringISO88591() {
	    $string = 'Você deve ter recebido uma cópia da GNU LGPL versão 3';
	    $string = StringHelper::utf8_decode($string);
	    
	    $this->TPDOConnection->setDBMS(DBMS_POSTGRES);
	    $result = $this->TPDOConnection->getStrUtf8OrAnsi(false, $string, TPDOConnection::WAY_BANK2APP);
	    $this->assertSame( $string , $result,'String não tem o mesmo formato');
	}	

	public function testGetStrUtf8OrAnsi_DecoldeTrueApp2DbStringUtf8() {
	    $string = 'Você deve ter recebido uma cópia da GNU LGPL versão 3';
	    
	    $this->TPDOConnection->setDBMS(DBMS_POSTGRES);
	    $result = $this->TPDOConnection->getStrUtf8OrAnsi(true, $string, TPDOConnection::WAY_APP2BANK);
	    
	    $string = StringHelper::utf8_decode($string);
	    $this->assertSame( $string , $result,'String não tem o mesmo formato');
	}
	
	public function testGetStrUtf8OrAnsi_DecoldeTrueDb2AppStringUtf8() {
	    $string = 'Você deve ter recebido uma cópia da GNU LGPL versão 3';	    
	    
	    $this->TPDOConnection->setDBMS(DBMS_POSTGRES);
	    $result = $this->TPDOConnection->getStrUtf8OrAnsi(true, $string, TPDOConnection::WAY_BANK2APP);
	    
	    $this->assertSame( $string , $result,'String não tem o mesmo formato');
	}
	
	public function testGetStrUtf8OrAnsi_DecoldeTrueDb2AppStringISO88591() {
	    $string = 'Você deve ter recebido uma cópia da GNU LGPL versão 3';
	    $string = StringHelper::utf8_decode($string);
	    
	    $this->TPDOConnection->setDBMS(DBMS_POSTGRES);
	    $result = $this->TPDOConnection->getStrUtf8OrAnsi(true, $string, TPDOConnection::WAY_BANK2APP);	    
	    
	    $string = StringHelper::utf8_encode($string);
	    $this->assertSame( $string , $result,'String não tem o mesmo formato');
	}

	public function testGetDsnPDO_DBMS_Branco() {
		$this->expectException(InvalidArgumentException::class);
		$DBMS = null;
		$host = null;
		$port = null;
		$database=null;
		$username=null;
		$password=null;

	    $dns = TPDOConnection::getDsnPDO($DBMS,$host,$port,$database,$username,$password);
	}

	public function testGetDsnPDO_Mysql_falhaHost() {
		$this->expectException(InvalidArgumentException::class);
		$DBMS = DBMS_MYSQL;
		$host = null;
		$port = null;
		$database=null;
		$username=null;
		$password=null;

	    $dns = TPDOConnection::getDsnPDO($DBMS,$host,$port,$database,$username,$password);
	}
	
	public function testGetDsnPDO_Mysql_falhaDatabase() {
		$this->expectException(InvalidArgumentException::class);
		$DBMS = DBMS_MYSQL;
		$host = 'localhost';
		$port = null;
		$database=null;
		$username=null;
		$password=null;

	    $dns = TPDOConnection::getDsnPDO($DBMS,$host,$port,$database,$username,$password);
	}

	public function testGetDsnPDO_Mysql() {
		$expected= 'mysql:host=localhost;dbname=test;port=3306';
		$DBMS = DBMS_MYSQL;
		$host = 'localhost';
		$port = null;
		$database='test';
		$username=null;
		$password=null;

	    $result = TPDOConnection::getDsnPDO($DBMS,$host,$port,$database,$username,$password);
		$this->assertSame( $expected , $result );
	}

	public function testStringStoredProcedureInSqlServer_ExecInicial()
    {
        $sql = "EXEC my_stored_procedure";
        $result = TPDOConnection::stringStoredProcedureInSqlServer($sql);
        $this->assertTrue($result, "Deve retornar true para comandos que começam com 'EXEC'.");
    }

    public function testStringStoredProcedureInSqlServer_ExecMeioContextInfo()
    {
        $sql = "SELECT * FROM table WHERE context_info = 'EXEC my_stored_procedure'";
        $result = TPDOConnection::stringStoredProcedureInSqlServer($sql);
        $this->assertTrue($result, "Deve retornar true para comandos que contêm 'EXEC' no meio.");
    }

    public function testStringStoredProcedureInSqlServer_SemExec()
    {
        $sql = "SELECT * FROM table";
        $result = TPDOConnection::stringStoredProcedureInSqlServer($sql);
        $this->assertFalse($result, "Deve retornar false para comandos que não contêm 'EXEC'.");
    }

    public function testStringStoredProcedureInSqlServer_SemExecContextInfo()
    {
        $sql = "SELECT * context_info FROM table";
        $result = TPDOConnection::stringStoredProcedureInSqlServer($sql);
        $this->assertFalse($result, "Deve retornar false para comandos que não contêm 'EXEC'.");
    }	
}
