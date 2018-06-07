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


/**
 * Sobre o PDO
 * http://www.phpro.org/tutorials/Introduction-to-PHP-PDO.html
 **/


if ( !defined ( 'DS' ) ) { define( 'DS', DIRECTORY_SEPARATOR ); }
$currentl_dir = dirname ( __FILE__ );

require_once( $currentl_dir . DS . '..' . DS . 'constants.php' );

class TPDOConnection {
    private static $error = null;
    private static $instance = null;
    private static $banco;
    private static $dsn;
    private static $password;
    private static $username;
    private static $lastSql;
    private static $lastParams;
    private static $utfDecode;
    private static $useSessionLogin;
    private static $dieOnError;
    private static $showFormErrors;
    private static $databaseName;
    private static $message;
    private static $schema;
    private static $configFile;
    
    // construtor
    public function __construct(){
    }
    
    //------------------------------------------------------------------------------------------
    public static function connect( $configFile = null, $boolRequired = true, $boolUtfDecode = null ) {
        
        self::setUtfDecode( $boolUtfDecode );
        self::validateConnect( $configFile ,$boolRequired);
        try {
            self::$instance[ self::getDatabaseName()] = new PDO( self::$dsn, self::$username, self::$password );
            self::$instance[ self::getDatabaseName()]->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            
        } catch( PDOException $e ){
            self::$error = utf8_encode( 'Erro de conexão.<br><b>DNS:</b><br>' . self::$dsn . '<br><BR><b>Erro retornado:</b><br>'
                . $e->getMessage() );
            return false;
        }
        
        return true;
    }
    
    
    private static function validateConnect($configFile ,$boolRequired) {
        $configErrors = array();
        $root = null;
        
        if ( self::getDataBaseName() ) {
            $configFileDb = $configFile;
            
            if ( is_null( $configFileDb ) || !file_exists( $configFileDb . '_' . self::getDataBaseName() ) ) {
                $configFileDb = is_null( $configFileDb ) ? 'config_conexao_' . self::getDataBaseName() . '.php' : $configFileDb;
                
                if ( !file_exists( $configFileDb ) ) {
                    $configFileDb = 'includes/' . $configFileDb;
                    
                    if ( !file_exists( $configFileDb ) ) {
                        $root = self::getRoot();
                        $configFileDb = $root . $configFileDb;
                        if ( file_exists( $configFileDb ) ) {
                            $configFile = $configFileDb;
                        }
                    } else {
                        $configFile = $configFileDb;
                    }
                } else {
                    $configFile = $configFileDb;
                }
            } else {
                $configFile = $configFileDb;
            }
        }
        
        if ( is_null( $configFile ) || !file_exists( $configFile ) ) {
            $configFile = is_null( $configFile ) ? 'config_conexao.php' : $configFile;
            
            if ( !file_exists( $configFile ) ) {
                $configFile = 'includes/config_conexao.php';
                
                // procurar o arquivo padrão de conexão em até 5 niveis acima
                for( $i = 1; $i < 6; $i++ ) {
                    if( file_exists( str_repeat( '../', $i ) . $configFile ) ) {
                        $configFile = str_repeat( '../', $i ) . $configFile;
                        break;
                    }
                }
                if ( !file_exists( $configFile ) ) {
                    $root = self::getRoot();
                    $configFile = $root . 'includes/config_conexao.php';
                }
            }
        }
        
        self::$configFile = $configFile;
        
        if ( !file_exists( $configFile ) ) {
            if ( $boolRequired ) {
                $configErrors[] = "Classe TPDOConnectio.class.php - Arquivo {$configFile} não encontrado!";
                self::showExemplo( DBMS_MYSQL, $configErrors );
            }
            return false;
        } else {
            require_once( $configFile );
            
            if ( !defined( 'BANCO' ) ) {
                $configErrors[] = 'O arquivo ' . $root . 'includes/config_conexao.php não está configurado corretamente! Definal o tipo de banco de dados';
                self::showExemplo( DBMS_MYSQL, $configErrors );
            }else{
                self::$banco = strtoupper( BANCO );
            }
            
            if ( !defined( 'DATABASE' ) ) {
                $dataBaseName = self::getDataBaseName();
                if( empty($dataBaseName) ){
                    $configErrors[] = 'Falta informar o DATABASE';
                    self::showExemplo( self::$banco, $configErrors );
                }
            }else{
                self::setDataBaseName( DATABASE );
            }
            
            if ( is_null( self::$utfDecode ) && defined( 'UTF8_DECODE' ) ) {
                self::setUtfDecode( UTF8_DECODE );
            }
            
            if ( !defined( 'USE_SESSION_LOGIN' ) ) {
                define( 'USE_SESSION_LOGIN', 0 );
            }
            
            if ( !defined( 'SENHA' ) ) {
                define( 'SENHA', NULL );
            }
            
            if ( !defined( 'USUARIO' ) ) {
                define( 'USUARIO', NULL );
            }
            
            if ( USE_SESSION_LOGIN ) {
                if ( !isset( $_SESSION[ APLICATIVO ][ 'login' ][ 'password' ] ) ) {
                    die ( 'Para utilizar usuário e senha do usuário logado,<br>defina as varíaveis de sessão:<b>$_SESSION[APLICATIVO]["login"]["username"]</b> e <b>$_SESSION[APLICATIVO]["login"]["password"]</b>.' );
                }
                self::$password = $_SESSION[ APLICATIVO ][ 'login' ][ 'password' ];
                self::$username = $_SESSION[ APLICATIVO ][ 'login' ][ 'username' ];
            } else {
                self::$password = SENHA;
                self::$username = USUARIO;
            }
            
            if ( !self::simpleDBMS() ) {
                if ( !defined( 'HOST' ) ) {
                    $configErrors[] = 'Falta informar o HOST';
                }
                
                if( empty(self::$username) ){
                    $configErrors[] = 'Falta informar um usuario para logar no banco';
                }
                
                if( empty(self::$password) ){
                    $configErrors[] = 'Falta informar uma senha para logar no banco';
                }
            }
            
            $configErrorsDsn = self::defineDsnPDO($configErrors);
            if ( count( $configErrorsDsn ) > 0 ) {
                $configErrors = $configErrors + $configErrorsDsn;
            }
        }
        
        
        if ( count( $configErrors ) > 0 ) {
            self::showExemplo( self::$banco, $configErrors );
        }
    }
    
    /***
     *  Data Base Management System is simple or not.
     *  Simple does not have user and password or host
     * @return boolean
     */
    private static function simpleDBMS() {
        return (self::$banco != DBMS_FIREBIRD) || (self::$banco != DBMS_SQLITE);
    }
    
    private static function defineDsnPDO($configErrors) {
        switch( self::$banco ) {
            case DBMS_MYSQL:
                if ( !defined( 'PORT' ) ) {
                    define( 'PORT', '3306' );
                }
                self::$dsn = 'mysql:host=' . HOST . ';dbname=' . DATABASE . ';port=' . PORT;
                break;
                //-----------------------------------------------------------------------
            case DBMS_POSTGRES :
                if ( !defined( 'PORT' ) ) {
                    define( 'PORT', '5432' );
                }
                if ( defined( 'SCHEMA' ) ) {
                    self::setSchema(SCHEMA);
                }
                self::$dsn = 'pgsql:host=' . HOST . ';dbname=' . self::getDataBaseName() . ';port=' . PORT;
                break;
                //-----------------------------------------------------------------------
            case DBMS_SQLITE:
                //self::validateFileDataBaseExists ( $configErrors );
                self::$dsn = 'sqlite:' . DATABASE;
                break;
                //-----------------------------------------------------------------------
            case DBMS_ORACLE:
                if ( !defined( 'PORT' ) ) {
                    define( 'PORT', '1521' );
                }
                self::$dsn = "oci:dbname=(DESCRIPTION =(ADDRESS_LIST=(ADDRESS = (PROTOCOL = TCP)(HOST = " . HOST . ")(PORT = " . PORT . ")))(CONNECT_DATA =(SERVICE_NAME = " . SERVICE_NAME . ")))";
                //self::$dsn = "oci:dbname=".SERVICE_NAME;
                break;
                //----------------------------------------------------------
            case DBMS_SQLSERVER:
                if ( !defined( 'PORT' ) ) {
                    define( 'PORT', '1433' );
                }
                /**
                 * Dica de Reinaldo A. Barrêto Junior para utilizar o sql server no linux
                 *
                 * No PHP 5.4 ou superior o drive mudou de MSSQL para SQLSRV
                 * */
                if (PHP_OS == "Linux") {
                    $driver = 'dblib';
                    //self::$dsn = $driver.':version=7.2;charset=UTF-8;host=' . HOST . ';dbname=' . DATABASE . ';port=' . PORT;
                    self::$dsn = $driver.':version=7.2;host=' . HOST . ';dbname=' . DATABASE . ';port=' . PORT;
                } else {
                    $driver = 'sqlsrv';
                    self::$dsn = $driver.':Server=' . HOST . ';Database=' . DATABASE;
                }
                break;
                //----------------------------------------------------------
            case DBMS_FIREBIRD:
                //self::validateFileDataBaseExists ( $configErrors );
                self::$dsn = 'firebird:dbname='.DATABASE;
                break;
                //----------------------------------------------------------
            case 'MSACCESS':
            case DBMS_ACCESS:
                //self::fileDataBaseExists ( $configErrors );
                self::$dsn = 'odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq='.DATABASE.';Uid='.self::$username.';Pwd='.self::$password;
                break;
                //----------------------------------------------------------
            default:
                $configErrors[] = 'Falta informar o sistema gerenciador de Banco de Dados: Access, Firebird, MySQL, Oracle, PostGresSQL, SQL Lite ou SQL Server';
                break;
                //----------------------------------------------------------
        }
        return $configErrors;
    }
    /**
     * @param configErrors
     */
    private static function validateFileDataBaseExists($configErrors) {
        $dataBaseName = self::getDataBaseName();
        $homeUrl = UrlHelper::homeUrl();
        $path = $homeUrl.$dataBaseName;
        $file_exists = file_exists( $path );
        if ( !$file_exists ) {
            $configErrors[] = 'Arquivo ' . DATABASE . ' não encontrado!';
            self::showExemplo( self::$banco, $configErrors );
        }
    }
    
    //-------------------------------------------------------------------------------------------
    public static function showError( $error = null )
    {
        if ( !is_null( $error ) )
        {
            self::$error = $error;
        }
        
        if ( self::$error )
        {
            if ( self::getDieOnError() && ( !isset( $_REQUEST[ 'ajax' ] ) || !$_REQUEST[ 'ajax' ] ) )
            {
                die ( self::getError());
            }
            else
            {
                if ( self::getShowFormErrors() )
                {
                    echo self::getError();
                }
            }
        }
        return null;
    }
    
    //-------------------------------------------------------------------------------------------
    public static function setError( $strNewValue = null )
    {
        self::$error = $strNewValue;
    }
    
    //-------------------------------------------------------------------------------------------
    public static function getError()
    {
        if ( self::$error )
        {
            return utf8_decode( '<br><b>Erro PDO:</b> ' . self::$error . '<br/><br/><b>Sql: </b>' . self::$lastSql . '<div><br/></div><b>Parametros: </b> ' . print_r( self::$lastParams, true ) );
        }
        
        if ( self::getMessage() )
        {
            return self::getMessage();
        }
        return null;
    }
    
    //-------------------------------------------------------------------------------------------
    public static function getInstance()
    {
        
        if ( self::getDataBaseName() )
        {
            if ( !self::$instance[ self::getDatabaseName()] )
            {
                self::connect( null, false );
                if ( !self::$instance[ self::getDatabaseName()] )
                {
                    return false;
                }
                
                if( self::getSchema() )
                {
                    if( self::getDataBaseName() == 'POSTGRES')
                    {
                        self::executeSQL('set search_path='.self::getSchema());
                    }
                }
            }
            return self::$instance[ self::getDatabaseName()];
        }
        else
        {
            if ( !self::$instance )
            {
                self::connect( null, false );
                
                if ( !self::$instance )
                {
                    return false;
                }
                if( self::getSchema() )
                {
                    if( self::$banco == 'POSTGRES')
                    {
                        self::executeSQL('set search_path='.self::getSchema());
                    }
                }
            }
            return self::$instance;
        }
    }
    
    //------------------------------------------------------------------------------------------
    private function __clone() {
    }
    
    //------------------------------------------------------------------------------------------
    public static function executeSql( $sql, $arrParams = null, $fetchMode = PDO::FETCH_ASSOC, $boolUtfDecode = null ) {
        if ( !self::getInstance() ) {
            self::getError();
            return;
        }
        self::$error = null;
        
        // ajuste do teste para banco oracle
        if ( $sql == 'select 1 as teste'  && strtolower(BANCO)== 'oracle' ) {
            $sql .= ' from dual';
        }
        
        // converter o parametro passado para array
        if ( is_string( $arrParams ) || is_numeric( $arrParams ) ) {
            $arrParams = array( $arrParams );
        }
        $result = null;
        
        // nás chamadas ajax, não precisa aplicar utf8
        if ( !isset( $_REQUEST[ 'ajax' ] ) || !isset( $_REQUEST[ 'ajax' ] ) ) {
            $boolUtf8_Decode = self::getUtfDecode();
            $sql       = self::getStrUtf8OrAnsi( $boolUtf8_Decode , $sql );
            $arrParams = self::encodeArray( $arrParams );
        }
        $arrParams = self::prepareArray( $arrParams );
        // guardar os parametros recebidos
        self::$lastParams = $arrParams;
        self::$lastSql = $sql;
        
        // verificar se a quantidade de parametros é igual a quantidade de variaveis
        if ( strpos( $sql, '?' ) > 0 && is_array( $arrParams ) && count( $arrParams ) > 0 ) {
            $qtd1 = substr_count( $sql, '?' );
            $qtd2 = count( $arrParams );
            
            if ( $qtd1 != $qtd2 ) {
                self::$error = 'Quantidade de parametros diferente da quantidade utilizada na instrução sql.';
                self::showError();
                return false;
            }
        } else {
            $arrParams = array();
        }
        
        try {
            $stmt = self::getInstance()->prepare( $sql );
            
            if ( !$stmt ) {
                self::$error = 'Erro no comando sql';
                self::showError();
                return false;
            }
            
            $result = $stmt->execute( $arrParams );
            
            if ( $result ) {
                // em caso select ou insert com returning, processa o resultado
                if ( preg_match( '/^select/i', $sql ) > 0 || preg_match( '/returning/i', $sql ) > 0 || preg_match( '/^with/i', $sql ) > 0 ) {
                    $res = $stmt->fetchAll( $fetchMode );
                    $res = self::processResult( $res, $fetchMode, $boolUtfDecode );
                    
                    if ( is_array( $res ) || is_object( $res ) ){
                        return $res;
                    }else {
                        return null;
                    }
                    
                    // Para stored procedure do MS SQL Server
                }else if( preg_match( '/^exec/i', $sql ) > 0  ){
                    $res = array();
                    do {
                        $results = $stmt->fetchAll( $fetchMode );
                        $res[] = self::processResult( $results, $fetchMode, $boolUtfDecode );
                    } while ($stmt->nextRowset());
                    
                    if ( is_array( $res ) || is_object( $res ) ){
                        return $res;
                    }else {
                        return null;
                    }
                    // Para stored procedure do MySQL
                }else if( preg_match( '/^call/i', $sql ) > 0  ){
                    $res = $stmt->fetchAll( $fetchMode );
                    $res = self::processResult( $res, $fetchMode, $boolUtfDecode );
                    
                    if ( is_array( $res ) || is_object( $res ) ){
                        return $res;
                    }else {
                        return null;
                    }
                }
            }
            return $result;
        }
        catch( PDOException $e ) {
            self::$error = $e->getMessage();
            self::showError();
        }
        return false;
    }
    
    //--------------------------------------------------------------------------
    public static function prepare( $strSql ) {
        if ( !self::getInstance() ) {
            return false;
        }
        return self::getInstance()->prepare( $strSql );
    }
    
    //---------------------------------------------------------------------------
    public static function encodeArray( $arrDados = null ) {
        $result = array();
        
        if ( is_array( $arrDados ) ) {
            if ( is_string( key( $arrDados ) ) ) {
                foreach( $arrDados as $k => $v ) {
                    if ( ! is_null( $v )  ) {
                        
                        $boolUtf8_DecodeDataBase = self::getUtfDecode();
                        $arrDados[ $k ] = self::getStrUtf8OrAnsi(!$boolUtf8_DecodeDataBase, $v);
                        
                        // inverter campo data
                        if ( preg_match( '/^DAT[_,A]/i', $k ) > 0 || ( strpos( $v, '/' ) == 2 && strpos( $v, '/', 4 ) == 5 ) ) {                        	
                        	$v = self::verifyformtDateYMD( $v );
                        	$arrDados[ $k ] = $v;
                        }
                        else if( preg_match( '/VAL_|NUM_/i', $k ) > 0 )
                        {
                            // alterar a virgula por ponto nos campos decimais
                            $posPonto = ( int ) strpos( $v, '.' );
                            $posVirgula = ( int ) strpos( $v, ',' );
                            
                            if ( $posVirgula > $posPonto )
                            {
                                if ( $posPonto && $posVirgula && $posPonto > $posVirgula )
                                {
                                    $v = preg_replace( '/\,/', '', $v );
                                }
                                else
                                {
                                    $v = preg_replace( '/,/', ' ', $v );
                                    $v = preg_replace( '/\./', '', $v );
                                    $v = preg_replace( '/ /', '.', $v );
                                }
                            }
                            $arrDados[ $k ] = trim( $v );
                        }
                    }
                    else
                    {
                        $arrDados[ $k ] = null;
                    }
                    $result[] = $arrDados[ $k ];
                }
            } else {
                foreach( $arrDados as $k => $v ) {
                	if ( !is_null($v) && !empty($v) ){
                        $v  = self::verifyformtDateYMD( $v );
                        $boolUtf8_DecodeDataBase = self::getUtfDecode();
                        $arrDados[ $k ] = self::getStrUtf8OrAnsi(!$boolUtf8_DecodeDataBase, $v);
                	}else if( is_int($v) ){
                		$arrDados[ $k ] = $v;
                	}else if( $v === '0' ){
                		$arrDados[ $k ] = $v;
                	}else {
                		$arrDados[ $k ] = null;
                	}
                }
                $result = $arrDados;
            }
        }
        return $result;
    }
    
    public static function prepareArrayNamed( $arrDados = null ) {
    	$result = array();
    	
    	foreach( $arrDados as $k => $v )
    	{
    		if ( !is_null($v) )
    		{
    			$arrDados[ $k ] = $v;
    			// inverter campo data
    			if ( preg_match( '/^DAT[_,A]/i', $k ) > 0 || ( strpos( $v, '/' ) == 2 && strpos( $v, '/', 4 ) == 5 ) )    {    				
    				$v  = self::verifyformtDateYMD( $v );
    				$arrDados[ $k ] = $v;
    			}
    			else if( preg_match( '/NR_|VAL_|NUM_/i', $k ) > 0 )
    			{
    				// alterar a virgula por ponto nos campos decimais
    				$posPonto = ( int ) strpos( $v, '.' );
    				$posVirgula = ( int ) strpos( $v, ',' );
    				
    				if ( $posVirgula > $posPonto ) {
    					if ( $posPonto && $posVirgula && $posPonto > $posVirgula ) {
    						$v = preg_replace( '/\,/', '', $v );
    					} else {
    						$v = preg_replace( '/,/', ' ', $v );
    						$v = preg_replace( '/\./', '', $v );
    						$v = preg_replace( '/ /', '.', $v );
    					}
    				}
    				$arrDados[ $k ] = trim( $v );
    			}
    		}else{
    			$arrDados[ $k ] = null;
    		}
    		$result[] = $arrDados[ $k ];
    	}    	
    	return $result;
    }
    
    /***
     * Campo data deve ser invertido para gravar no banco de dados.
     * @param string $v
     * @return string
     */
    public static function verifyformtDateYMD( $v ) {
    	if ( strpos( $v, '/' ) == 2 && strpos( $v, '/', 4 ) == 5 ) {
    		$v = self::formatDate( $v, 'ymd' );
    	}    	
    	return $v;
    }
    
    
    public static function prepareArray( $arrDados = null ) {
        $result = array();
        
        if ( is_array( $arrDados ) ) {
        	
            if ( is_string( key( $arrDados ) ) ) {
            	$result = self::prepareArrayNamed($arrDados);
            } else {
                foreach( $arrDados as $k => $v ) {
                    if ( !is_null($v) && !empty($v) ){
                    	$v  = self::verifyformtDateYMD( $v );
                        $arrDados[ $k ] = $v;
                    }else if( is_int($v) ){
                    	$arrDados[ $k ] = $v;
                    }else if( $v === '0' ){
                    	$arrDados[ $k ] = $v;
                    }else {
                        $arrDados[ $k ] = null;
                    }
                }
                $result = $arrDados;
            }
        }
        return $result;
    }
    
    //------------------------------------------------------------------------------
    /**
     * Localiza a pasta base da framework
     *
     */
    private static function getRoot()
    {
        $base = '';
        
        for( $i = 0; $i < 10; $i++ )
        {
            $base = str_repeat( '../', $i ) . 'base/';
            
            if ( file_exists( $base ) )
            {
                $i = 20;
                break;
            }
        }
        
        if ( !file_exists( $base ) )
        {
            die ( 'pasta base/ não encontrada' );
        }
        $base = str_replace( 'base', '', $base );
        $base = str_replace( '//', '/', $base );
        $root = ( $base == '/' ) ? './' : $base;
        return $root;
    }
    
    //------------------------------------------------------------------------------------------
    public static function showExemplo( $banco, $arrErros = null ) {
        $msgErro = '';
        
        if ( is_array( $arrErros ) ) {
            $msgErro = implode( '<br>', $arrErros );
        }
        $html = '<div style="padding:5px;border:1px solid red;background-color:lightyellow;width:400px;color:blue;">';
        $html .= '<div style="border-bottom:1px solid blue;color:red;text-align:center;"><blink>' . $msgErro . '</blink></div>';
        
        switch( $banco ) {
            case DBMS_ORACLE:
                $html .= "<center>Exemplo de configuração para conexão com banco ORACLE</center><br>
					define('BANCO','ORACLE');<br>
					define('HOST','192.168.0.132');<br>
					define('PORT','1521');<br>
					define('SERVICE_NAME','xe');<br>
					define('USUARIO','root');<br>
					define('SENHA','root');<br><br>";
                break;
                
            case DBMS_MYSQL:
                $html .= "<center>Exemplo de configuração para conexão com banco MYSQL</center><br>
					 define('BANCO','MYSQL');<br>
					 define('HOST','192.168.0.132');<br>
					 define('PORT','3306');<br>
					 define('DATABASE','exemplo');<br>
					 define('UTF8_DECODE',0);<br>
					 define('USUARIO','root');<br>
					 define('SENHA','root');<br><br>";
                break;
                
            case DBMS_POSTGRES:
                $html .= "<center>Exemplo de configuração para conexão com banco POSTGRES</center><br>
					 define('BANCO','POSTGRES');<br>
					 define('HOST','192.168.0.132');<br>
					 define('PORT','5432');<br>
					 define('DATABASE','exemplo');<br>
					 define('SCHEMA','public');<br>
					 define('USUARIO','postgres');<br>
					 define('SENHA','123456');<br><br>";
                break;
                
            case DBMS_SQLITE:
                $html .= "<center>Exemplo de configuração para conexão com banco SQLITE</center><br>
					 define('BANCO','SQLITE');<br>
					 define('DATABASE','includes/exemplo.s3db');<br>
					 define('UTF8_DECODE',0);<br>";
                break;
                
            case DBMS_FIREBIRD:
                $html .= "<center>Exemplo de configuração para conexão com banco FIREBIRD</center><br>
					 define('BANCO','FIREBIRD');<br>
					 define('DATABASE','C://bd//DBTESTE.FDB');<br>;
					 define('UTF8_DECODE',0);<br>
					 define('USUARIO','SYSDBA');<br>
					 define('SENHA','masterkey');<br>";
                break;
                
            case DBMS_SQLSERVER:
                $html .= "<center>Exemplo de configuração para conexão com banco SQLSERVER</center><br>
					 define('BANCO','SQLSERVER');<br>
					 define('HOST','192.168.0.132');<br>
					 define('PORT','1433');<br>
					 define('DATABASE','exemplo');<br>
					 define('UTF8_DECODE',0);<br>
					 define('USUARIO','sa');<br>
					 define('SENHA','123456');<br><br>";
                break;
                
            case 'ACCESS':
                $html .= "<center>Exemplo de configuração para conexão com banco ACCES</center><br>
					 define('DATABASE','C://bd//DBTESTE.MDB');<br>
					 define('UTF8_DECODE',0);<br>
					 define('USUARIO','admin');<br>
					 define('SENHA','123456');<br><br>";
                break;
                
        }
        //---------------------
        $html . '</div>';
        die ( $html );
    }
    
    //---------------------------------------------------
    public static function test( $boolDie = null )
    {
        $res = self::executeSql( 'select 1 as teste' );
        if ( $res )
        {
            echo '<H2>FORMDIN - Teste de conexão com banco de dados.<br>Arquivo de Configuração utilizado: '.self::$configFile.'<br></h2><h3>DNS:'.self::$dsn.'</h3><h1>Conexão com ' . BANCO . ' está Ok!!!!</h1>';
        }
        else
        {
            echo '<H2>FORMDIN - Teste de conexão com banco de dados.<br>Arquivo de Configuração utilizado: '.self::$configFile.'<br></h2></h3>';
            echo '<br><h3>Falha na conexão.<br/><br/>' . self::getError().'</h3>';
        }
        
        if ( is_null( $boolDie ) || $boolDie )
        {
            die ( '<hr>' );
        }
    }
    
    //----------------------------------------------------
    public static function beginTransaction()
    {
        if ( self::getInstance() )
        {
            return self::getInstance()->beginTransaction();
        }
        return false;
    }
    
    //---------------------------------------------------
    public static function commit()
    {
        if ( self::getInstance() )
        {
            return self::getInstance()->commit();
        }
        return false;
    }
    
    //---------------------------------------------------
    public static function rollBack()
    {
        if ( self::getInstance() )
        {
            return self::getInstance()->rollBack();
        }
        return false;
    }
    
    //--------------------------------------------------------------------------------------
    public static function getLastId( $strTable, $strKeyField )
    {
        $res = self::executeSql( "select max( {$strKeyField} ) as last_id from {$strTable}" );
        return $res[ 'LAST_ID' ][ 0 ];
    }
    //--------------------------------------------------------------------------------------
    public static function formatDate( $date = null, $format = 'dmy' )
    {
        if ( $date )
        {
            $format = is_null( $format ) ? 'dmy' : strtolower( $format );
            
            if ( $format != 'dmy' && $format != 'ymd' )
            {
                $format = 'dmy';
            }
            if ( preg_match( '/\//', $date ) > 0 )
            {
                $delim = '/';
            }
            else if( preg_match( '/-/', $date ) > 0 )
            {
                $delim = '-';
            }
            $aDataHora = explode( ' ', $date );
            $aDMY = explode( $delim, $aDataHora[ 0 ] );
            
            // esta no formaty ymd
            if ( preg_match( '/^[0-9]{4}/', $date ) )
            {
                if ( $format == 'ymd' )
                {
                    return $date;
                }
            }
            else
            {
                if ( $format == 'dmy' )
                {
                    return $date;
                }
            }
            $delim = '-';
            $date = $aDMY[ 2 ] . $delim . $aDMY[ 1 ] . $delim . $aDMY[ 0 ] . ( isset( $aDataHora[ 1 ] ) ? ' ' . $aDataHora[ 1 ] : '' );
        }
        return $date;
    }
    //--------------------------------------------------------------------------------------
    public static function dmy( $date = null )
    {
        if ( $date )
        {
            // verificar se não está invertida
            if ( !preg_match( '/^[0-9]{4}/', $date ) )
            {
                // inverter campo data
                if ( preg_match( '/\//', $date ) > 0 )
                {
                    $delim = '/';
                }
                else if( preg_match( '/-/', $date ) > 0 )
                {
                    $delim = '-';
                }
                $aDataHora = explode( ' ', $date );
                $aDMY = explode( $delim, $aDataHora[ 0 ] );
                $date = $aDMY[ 2 ] . $delim . $aDMY[ 1 ] . $delim . $aDMY[ 0 ] . ( isset( $aDataHora[ 1 ] ) ? ' ' . $aDataHora[ 1 ] : '' );
            }
        }
        return $date;
    }
    //--------------------------------------------------------------------------------------
    /**
     * Returns the string in the appropriate format UTF8 or ANSI
     * @param boolean $boolUtf8_Decode
     * @param string $string
     * @return NULL|string
     */
    public static function getStrUtf8OrAnsi( $boolUtf8_Decode , $string ) {
        $retorno = null;
        if(  (self::$banco == DBMS_SQLSERVER) && (PHP_OS != "Linux" ) ){
            $retorno = $string;
        } elseif (self::$banco == DBMS_SQLITE) {
        	$retorno = $string;
        }else{
            if ( $boolUtf8_Decode ) {
                $retorno = utf8_decode( $string );
            } else {
                $retorno = utf8_encode( $string );
            }
        }
        return $retorno;
    }
    //--------------------------------------------------------------------------------------
    public static function processResult( $result, $fetchMode, $boolUtf8_Decode = null ) {
        $boolUtf8_Decode = ( $boolUtf8_Decode === null ? self::getUtfDecode() : $boolUtf8_Decode );
        
        // formato vo
        if ($result && $fetchMode == PDO::FETCH_OBJ) {
            if (count ( $result ) == 1) {
                return $result [0];
            }
            return $result;
        }
        $res = null;
        
        if ( is_array( $result ) ) {
            foreach( $result as $key => $val ) {
                foreach( $val as $k => $v ) {
                    $k = strtoupper( self::getStrUtf8OrAnsi( $boolUtf8_Decode , $k ) );
                    
                    // transformar tags"< >" em codigo html para não serem interpretadas
                    if ( is_string( $v ) ) {
                        $res[ $k ][ $key ] = self::getStrUtf8OrAnsi( $boolUtf8_Decode , $v );
                        
                        //$res[ $k ][ $key ] = utf8_decode($v);
                        // consertar ordem do campo data
                        if ( preg_match( '/DAT/i', $k ) > 0 ) {
                            $delim = null;
                            
                            if ( preg_match( '/\//', $v ) > 0 ) {
                                $delim = '/';
                            } else if( preg_match( '/-/', $v ) > 0 ) {
                                $delim = '-';
                            }
                            
                            if ( $delim ) {
                                $aDataHora = explode( ' ', $v );
                                $aDMY = explode( $delim, $aDataHora[ 0 ] );
                                // verificar se está invertida
                                $delim = '/';
                                
                                if ( preg_match( '/^[0-9]{4}/', $v ) ) {
                                    $res[ $k ][ $key ] = $aDMY[ 2 ] . $delim . $aDMY[ 1 ] . $delim . $aDMY[ 0 ] . ( isset( $aDataHora[ 1 ] ) ? ' ' . $aDataHora[ 1 ] : '' );
                                }
                            }
                        }
                    } else {
                        $res[ $k ][ $key ] = $v;
                    }
                }
            }
        }
        return $res;
    }
    //--------------------------------------------------------------------------------------
    public static function setUtfDecode( $boolNewValue = null ) {
        self::$utfDecode = $boolNewValue;
    }
    //--------------------------------------------------------------------------------------
    public static function getUtfDecode() {
        $utfDecodeReturn = self::$utfDecode;
        if ( is_null($utfDecodeReturn) ){
            if( !defined( 'UTF8_DECODE' ) ) { define( 'UTF8_DECODE', 1 ); }
            if( UTF8_DECODE ){
                $utfDecodeReturn = true;
            } else {
                $utfDecodeReturn = false;
            }
        }
        return $utfDecodeReturn;
    }
    //--------------------------------------------------------------------------------------
    public static function pgsqlLOBOpen($oid = null, $mode = null) {
        return self::getInstance()->pgsqlLOBOpen ( $oid, $mode );
    }
    //--------------------------------------------------------------------------------------
    public static function pgsqlLOBCreate() {
        return self::getInstance()->pgsqlLOBCreate ();
    }
    //--------------------------------------------------------------------------------------
    public static function setDieOnError( $boolNewValue = null ) {
        self::$dieOnError = $boolNewValue;
    }
    public static function getDieOnError() {
        return is_null( self::$dieOnError ) ? true : self::$dieOnError;
    }
    public static function setShowFormErrors( $boolNewValue = null ) {
        self::$showFormErrors = $boolNewValue;
    }
    public static function getShowFormErrors() {
        return is_null( self::$showFormErrors ) ? true : self::$showFormErrors;
    }
    public static function setBanco( $banco = null ) {
        self::$banco = $banco;
    }
    public static function setDataBaseName( $strNewValue = null ) {
        self::$databaseName = $strNewValue;
    }
    public static function getDataBaseName() {
        $retorno = null;
        if ( isset( self::$databaseName ) ){
            $retorno = self::$databaseName;
        } else {
            if ( defined( 'DATABASE' ) ){
                $retorno = DATABASE;
            }
        }
        return  $retorno;
    }
    public static function setMessage( $strNewValue = null) {
        self::$message = $strNewValue;
    }
    public static function getMessage() {
        return self::$message;
    }
    public static function setSchema( $newSchema = null) {
        self::$schema = $newSchema;
    }
    public static function getSchema() {
        return self::$schema;
    }
}
?>