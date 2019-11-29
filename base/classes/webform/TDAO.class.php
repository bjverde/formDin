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

include_once( 'autoload_formdin.php');
class TDAO
{
	private $dbType      = null;
	private $username    = null;
	private $password    = null;
	private $database    = null;
	private $host        = null;
	private $port        = null;
	private $schema      = null;
	private $utf8        = null;
	private $error		= null;
	private $conn		= null;
	private $tableName	= null;
	private $fields		= null;
	private $specialChars = array();
	private $charset = null;
	private $metadataDir = null;
	private $primaryKeys = null;
	private $autoincFieldName = null;
	private $lastId      = null;
	private $autoCommit  = null;
	private $hasActiveTransaction = false;
	private $sqlCmd		= null;
	private $sqlParams	= null;
	private $cursor		= null;
	private $eof		= null;

	/**
	* Classe de conexão com banco de dados e execução de comandos sql
	* Permite conectar com vários tipos de banco de dados ao mesmo tempo
	*
	* Por padrão utilizará o arquivo conn_default.php ou includes/con_default.php
	* caso não seja informado o parametro dbType. Quando o parametro dbType for
	* informado, será então utlizado o arquivo "conn_????.php" referente.
	* Exemplo: $dao = new TDAO(null,'postgres');
	* será utilizado o arquivo conn_postgres.php
	*
	* Os arquivos de configurações devem possuir as seguintes definições:
	*
    * Exemplo Postgres
	* $dbType = "postgres";
	* $host = "192.168.1.140";
	* $port = "5432";
	* $database = "dbteste";
	* $username = "postgres";
	* $password = "123456";
	* $utf8=1;
	*
    * Exemplo Mysql
	* $dbType = "mysql";
	* $host = "192.168.1.140";
	* $port = "5432";
	* $database = "dbteste";
	* $username = "root";
	* $password = "123456";
	* $utf8=1;
	*
	* Exemplo Oracle
	* $dbType = 'oracle';
	* $host = '192.168.1.140';
	* $port = '1521';
	* $database = 'xe';
	* $username = 'root';
	* $password = '123456';
	* $utf8=0;
	*
	* Exemplo Firebird/Interbase
	* $dbType = "firebird";
	* $host = '192.168.1.140';
	* $port = null;
	* $database = 'f:/fiirebird/DBTESTE.GDB';
	* $username = "SYSDBA";
	* $password = "masterkey";
	* $utf8=1;
	* return;
	*
	* Exemplo Sqlite
	* $dbType = "sqlite";
	* $database = "bdApoio.s3db";
	* $utf8=0;
	*/

	/**
	* @param string $strTableName
	* @param string $strDbType
	* @param string $strUsername
	* @param string $strPassword
	* @param string $strDatabase
	* @param string $strHost
	* @param string $strPort
	* @param string $strSchema
	* @param boolean$boolUtf8
	* @param string $strCharset
	* @param boolean $boolAutoCommit
	* @param string $strMetadataDir
	* @return object TDAO
	*/
	public function __construct( $strTableName = null
								, $strDbType = null
								, $strUsername = null
								, $strPassword = null
								, $strDatabase = null
								, $strHost = null
								, $strPort = null
								, $strSchema = null
								, $boolUtf8 = null
								, $strCharset = null
								, $boolAutoCommit = null
								, $strMetadataDir = null  )	{
		$this->setTableName( $strTableName );
		$this->setMetadataDir( $strMetadataDir );
		$this->setDbType( $strDbType );
		$this->setUserName( $strUsername );
		$this->setPassword( $strPassword );
		$this->setDataBase( $strDatabase );
		$this->setHost( $strHost );
		$this->setPort( $strPort );
		$this->setSchema( $strSchema );
		$this->setUtf8( $boolUtf8 );
		$this->setCharset( $strCharset );
		$this->setAutoCommit( $boolAutoCommit );
	}

	//----------------------------------------------------------------------------------
	/**
	* Define o tipo do banco de dados que será acessado.
	* Os tipos de banco de dados suportados atualmente são:
	* 
	* 1) define('DBMS_MYSQL','MYSQL');
	* 2) define('DBMS_POSTGRES','POSTGRES');
	* 3) define('DBMS_FIREBIRD','FIREBIRD');
	* 4) define('DBMS_SQLITE','SQLITE');
	* 5) define('DBMS_ORACLE','ORACLE');
	* 6) define('DBMS_SQLSERVER','SQLSERVER');
	* 
	* Obs: todos utilizam a extensão PDO exceto o Oracle que utiliza as funções OCI diretamente
	*
	* @param string $strNewValue
	*/
	public function setDbType( $strNewValue = null ){
		$this->dbType=$strNewValue;
	}

	/**
	* Retorna o tipo do banco de dados que será acessado
	*
	* @return string;
	*/
	public function getDbType(){
		if( $this->conn ){
			//return $this->getConnDbType();
		}
		return $this->dbType;
	}

	/**
	* Define o nome do usuário que será utilizado para fazer a conexão com o banco de dados
	*
	* @param string $strNewValue
	*/
	public function setUsername( $strNewValue = null ){
		$this->username=$strNewValue;
	}

   	/**
	* Retorna o nome do usuário definido para fazer a conexão com o banco de dados.
	*
	* @return string $strNewValue
	*/
	public function getUsername(){
		return $this->username;
	}
	/**
	* Define a senha de acesso do banco de dados
	*
	* @param string $strNewValue
	*/
	public function setPassword( $strNewValue = null ){
		$this->password=$strNewValue;
	}

	/**
	* Retorna  a senha de acesso do banco de dados
	*
	*/
	public function getPassword(){
		return $this->password;
	}

	/**
	* Define o banco de dados onde estão as tabelas. No caso do oracle deve ser especificado
	* o TNS, no caso do oracleXE seria XE
	*
	* @param string $strNewValue
	*/
	public function setDatabase( $strNewValue = null ){
		$this->database=$strNewValue;
	}
    /**
    * Retorna o nome do banco de dados onde estão as tabelas
    *
    * @return string
    */
	public function getDatabase()
	{
		return $this->database;
	}

	/**
	* Define o nome ou endereço IP do computador onde está instalado o banco de dados
	*
	* @param mixed $strNewValue
	*/
	public function setHost( $strNewValue = null )
	{
		$this->host=$strNewValue;
	}
    /**
    * Retorna o nome ou endereço IP do computador onde está instalado o banco de dados
    *
    * @return null
    */
	public function getHost()
	{
		return $this->host;
	}

	/**
	* Define a porta de comunicação utilizada pelo banco de dados
	* Quando não informada será utilzada as portas padrão de cada banco
	*
	* @param string $strNewValue
	*/
	public function setPort( $strNewValue = null ){
		$this->port=$strNewValue;
	}
    /**
    * Retorna a porta de comunicação utilizada pelo banco de dados
    *
    */
	public function getPort() {
		if ( is_null( $this->port ) ) {
			switch( strtolower( $this->getDbType() ) ) {
				case 'postgre':
				case DBMS_POSTGRES:
					$this->port='5432';
					break;

				case DBMS_MYSQL:
					$this->port='3306';

					break;

				case DBMS_SQLSERVER:
					$this->port='1433';

					break;

				case DBMS_ORACLE:
					$this->port='1521';

					break;
				}
		}

		return $this->port;
	}

	/**
	* Define o nome do esquema dentro do banco de dados que deverã ser utilizado.
	* Este método aplica somente ao banco de dados postgres
	* Quando informado será adicionado ao path do banco de dados
	*
	* @param string $strNewValue
	*/
	public function setSchema( $strNewValue = null )
	{
		$this->schema=$strNewValue;
	}

	/**
	* Retorna o nome do esquema do banco de dados que será utilizado. Aplica-se somente
	* ao banco de dados postgres.
	*
	* Quando informado será adicionado ao path do banco de dados
	*
	* @return string
	*/
	public function getSchema()
	{
		if( $this->conn )
		{
			return $this->getConnSchema();
		}
		return $this->schema;
	}

	/**
	* Define se o banco de dados está utilizando codificação UTF-8
	*
	* @param boolean $boolNewValue
	*/
	public function setUtf8( $boolNewValue = null )
	{
		$this->utf8=$boolNewValue;
	}
    /**
    * Retorna true ou false se o banco de dados está utilizando codificação UTF-8
    *
    */
	public function getUtf8()
	{
		if( $this->conn )
		{
			return $this->getConnUtf8();
		}
		return ( ( $this->utf8 === false ) ? false : true );
	}

	/**
	* Tenta fazer a conexão com o banco de dados retornando verdadeiro o falso
	*
	* @return boolean
	*/
	public function connect() {
		try {
			if( ! $this->conn ){
				$this->conn = TConnectionPool::connect( $this->getDbType()
													  , $this->getUsername()
													  , $this->getPassword()
													  , $this->getDatabase()
													  , $this->getHost()
													  , $this->getPort()
													  , $this->getSchema()
													  , $this->getUtf8() );
			}
		}
		catch( Exception $e ) {
			$this->setError( $e->getMessage() );
			return false;
		}

        if( $this->getMetadataDir())
        {
			if ( !is_array( $this->getFields() ) )
			{
				if ( !$this->unserializeFields() )
				{
					$this->loadFieldsFromDatabase();
				}
			}
			if( is_array($this->primaryKeys ) )
			{
				foreach($this->primaryKeys as $fieldName=>$boolTemp)
				{
					$this->getField($fieldName)->primaryKey = 1;
				}
			}
		}

		return true;
	}

	/**
	* Executa o comando sql recebido retornando o cursor ou verdadeiro o falso se a operação
	* foi bem sucedida.
	*
	* @param string $sql
	* @param mixed $params
	* @param string $fetchMode
	*/
	public function query( $sql = null, $params = null, $fetchMode = null )
	{
		$data=false;
		$hasUserTransaction = $this->getHasActiveTransaction();
		if ( !$this->getConn() )
		{
			return false;
		}
		try
		{
			if ( !is_null($params) && !is_array( $params ) )
			{
				$params = array($params);
			}
			$sql=trim( $sql );              // remover espaços do início e final
			$sql=$this->utf8Decode( $sql ); // remover codificação utf8

			if ( $this->getConnUtf8() )
			{
				$sql = $this->utf8Encode( $sql ); // aplicar codificação utf8
			}
			$params=$this->prepareParams( $params ); // aplicar/remover utf8 nos parâmetros
		}
		catch( Exception $e )
		{
			$this->setError( $e->getMessage() );
			return false;
		}

		if ( $this->isPdo() )
		{
			if ( is_null( $fetchMode ) || ( $fetchMode != PDO::FETCH_ASSOC && $fetchMode != PDO::FETCH_CLASS ) )
			{
				$fetchMode = PDO::FETCH_ASSOC;
			}

			try
			{
				// trocar os "?" por ":p" para fazer o bind_by_name
				if( is_array($params) && preg_match('/\?/',$sql)==1 )
				{
					$keys = array_keys($params);
					foreach($keys as $v)
					{
						$sql = preg_replace('/\?/',':'.$v,$sql,1);
					}
				}
				$this->sqlCmd 		= $sql;
				$this->sqlParams 	= $params;

				$stmt=$this->getConn()->prepare( $sql );
				if ( !$stmt )
				{
					throw new Exception( 'Error preparing Sql.' );
				}

                if( preg_match( '/^select/i', $sql ) == 0 )
                {
					$this->beginTransaction();
				}
				// fazer BINDS
				if( is_array($params) )
				{
					// formato de bindParam
					/*
					$paramIndex=1;
					forEach( $params  as $fieldName=>$fieldValue )
					{
						echo $fieldName.': ';
						$objField = $this->getField($fieldName);
						if( $objField )
						{
							$fieldType = $this->getValidFieldType($objField->fieldType);
							echo $fieldName.' = '.$fieldType.' Valor: '.$params[$fieldName].'<br>';
							switch( $fieldType )
							{
									case 'binary':
										$stmt->bindParam($paramIndex, $params[$fieldName], PDO::PARAM_LOB);
									break;
									//------------------------------------------------------------
									case 'number':
										$stmt->bindParam($paramIndex, $params[$fieldName]);
									break;
									//------------------------------------------------------------
									default;
									$stmt->bindParam($paramIndex, $params[$fieldName], PDO::PARAM_STR);
        					}
						}
						else
						{
							$stmt->bindParam($paramIndex, $params[$fieldName], PDO::PARAM_STR);
						}
						$paramIndex++;
					}
					*/
			        // formato bindValues
					foreach( $params  as $fieldName=>$fieldValue )
					{
						$objField = $this->getField($fieldName);
						if( $objField )
						{
							$fieldType = $this->getValidFieldType($objField->fieldType);
							switch( $fieldType )
							{
									case 'binary':
										// ler o conteudo do arquivo se para o camp blob for informado o nome do arquivo
										if( @file_exists($params[$fieldName] ) )
										{
											$params[$fieldName] = file_get_contents($params[$fieldName]);
										}
										$stmt->bindValue(':'.$fieldName, $params[$fieldName], PDO::PARAM_LOB);
									break;
									//------------------------------------------------------------
									case 'number':
										$stmt->bindValue(':'.$fieldName, $params[$fieldName]);
									break;
									//------------------------------------------------------------
									default;
									$stmt->bindValue(':'.$fieldName, $params[$fieldName], PDO::PARAM_STR);
        					}
						}
						else
						{
							if( is_integer($params[$fieldName] ))
							{
									$stmt->bindValue(':'.$fieldName, $params[$fieldName], PDO::PARAM_INT);
							}
							else if( is_numeric($params[$fieldName] ) )
							{
								$stmt->bindValue(':'.$fieldName, $params[$fieldName]);
							}
							else
							{
								$stmt->bindValue(':'.$fieldName, $params[$fieldName], PDO::PARAM_STR);
							}
						}
					}
					$params=null;
				}
				$result=$stmt->execute( $params );
				if ( !$result )
				{
					throw new Exception( 'Error executing Sql!' );
				}
			}
			catch( Exception $e )
			{
				$this->setError( $e->getMessage() );
				return false;
			//throw $e;
			}
			if( $this->getAutoCommit() && ! $hasUserTransaction )
			{
				$this->commit();
			}
			$data=true;
			try
			{
				if ( preg_match( '/^select/i', $sql ) > 0 || preg_match( '/returning /i', $sql ) > 0 || preg_match( '/^with /i', $sql ) > 0 )
				{
					$data = $stmt->fetchAll( $fetchMode );
				}
			}
			catch( Exception $e )
			{
				$data=false;
				$this->setError( $e->getMessage() );
			}

			$stmt->closeCursor();
		}
		else
		{
			$conn=$this->getConn()->connection;

			if ( $this->getDbType() == DBMS_ORACLE )
			{
				if ( is_null( $fetchMode ) || ( $fetchMode != 'FETCH_ASSOC' && $fetchMode != 'FETCH_CLASS' ) )
				{
					$fetchMode = 'FETCH_ASSOC'; //OCI_FETCHSTATEMENT_BY_ROW;
				}

				try
				{
                    // trocar os "?" por ":p" para fazer o bind_by_name
					if( is_array($params) && preg_match('/\?/',$sql)==1 )
					{
						$keys = array_keys($params);
						foreach($keys as $v)
						{
							$sql = preg_replace('/\?/',':'.$v,$sql,1);
						}
					}
					$stmt = oci_parse( $conn, $sql );
					$descriptors=null;

					if ( is_array( $params ) )
					{
						foreach( $params as $fieldName => $fieldValue )
						{
							$objField = $this->getField( $fieldName );
							if ( $objField )
							{
								$bindType=$this->getBindType( $objField->fieldType );
								oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], $objField->size, $bindType );
							}
							else
							{
								oci_bind_by_name( $stmt, ':' . $fieldName, $params[$fieldName] );
							}
						}
					}

					if ( !@oci_execute( $stmt, OCI_NO_AUTO_COMMIT ) ) // OCI_DEFAULT = não commit
					{
						$e=oci_error( $stmt );

						throw new Exception( 'Sql error ' . $e[ 'message' ] );
					}

					if ( preg_match( '/^select/i', $sql ) > 0 )
					{
						if ( $fetchMode == 'FETCH_ASSOC' )
						{
							oci_fetch_all( $stmt, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_RETURN_NULLS );
						}
						else if( $fetchMode == 'FETCH_CLASS' )
						{
							$data=array();

							while( $row = oci_fetch_object( $stmt ) )
							{
								array_push( $data, $row );
							}
						}
					}
				}
				catch( Exception $e )
				{
					$data=false;
					$this->setError( $e->getMessage() );
				}

				oci_free_statement( $stmt );
			//oci_close($conn);
			}
		}

		if ( $data && is_array( $data ) )
		{
			$data = $this->parseFetchResult( $data );
		}

		return $data;
	}

	/**
	* Retorna a instância do objeto da conexão com o banco de dados
	*
	* @return object
	*/
	public function getConn()
	{
		if ( is_null( $this->conn ) )
		{
			if ( !$this->connect() )
			{
				return false;
			}
		}

		return $this->conn;
	}

	/**
	* Adiciona campos da tabela ao array de campos que serão utilizados
	* nos binds e nos métodos save, insert e delete da classe
	*
	* @param string $strFieldName
	* @param string $strFieldType
	* @param integer $intSize
	* @param integer $intPrecision
	* @param string $strDefaultValue
	* @param boolean $boolNullable
	* @param boolean $boolAutoincrement
	* @param boolean $boolPrimaryKey
	*/
	public function addField( $strFieldName, $strFieldType = null, $intSize = null, $intPrecision = null, $strDefaultValue = null, $boolNullable = null, $boolAutoincrement = null, $boolPrimaryKey = null )
	{
		$strFieldType 		=( is_null( $strFieldType ) ? 'varchar':$strFieldType);
		$boolAutoincrement	=( is_null( $boolAutoincrement ) ? 0 : $boolAutoincrement );
		$boolNullable       =( is_null( $boolNullable ) ? 1 : $boolNullable );
		$boolPrimaryKey     =( is_null( $boolPrimaryKey ) ? 0 : $boolPrimaryKey );
		$this->fields[ strtoupper( $strFieldName )]=(object)array
			(
			'fieldName'     => $strFieldName,
			'fieldType'     => $strFieldType,
			'size'          => $intSize,
			'precision'     => $intPrecision,
			'defaultValue'  => $strDefaultValue,
			'nullable'      => $boolNullable,
			'autoincrement' => $boolAutoincrement,
			'primaryKey'    => $boolPrimaryKey,
			'value'			=> null
			);
	}

	/**
	* Retorna o objeto do campo solictado
	* Se o campo não existier retorna null
	*
	* @param string $strFieldName
	*/
	public function getField( $strFieldName )
	{
		$strFieldName=strtoupper( $strFieldName );

		if ( isset( $this->fields[ $strFieldName ] ) )
		{
			return $this->fields[ $strFieldName ];
		}

		return null;
	}

	/**
	* Retorna o array de objetos dos campos da tabela
	*
	*/
	public function getFields()
	{
		return $this->fields;
	}
	/**
	* Defina a mensagem de erro
	*
	* @param string $strError
	*/
	public function setError( $strError = null )
	{
		$this->error=$strError;
	}
	/**
	* Retorna a mensagem de erro atual
	*
	*/
	public function getError()
	{
		return $this->error;
	}

	/**
	* Retorna a string dsn utilizada na conexão PDO
	*
	* @return string
	*/
	public function getConnDsn()
	{
		if ( $this->getConn() )
		{
			return $this->getConn()->dsn;
		}

		return null;
	}

	/**
	* Retorna se o banco de dados está utilizando a codificação UTF-8
	*
	*/
	public function getConnUtf8(){
		if ( $this->getConn() ){
			return $this->getConn()->utf8;
		}
		return true;
	}
	
	/**
	* Retorna o tipo de banco de dados que está sendo utilizado.
	* Ex: mysql, postgres, oracle...
	*
	* @return string
	*/
	public function getConnDbType(){
		if ( $this->getConn() ) {
			return $this->getConn()->dbType;
		}
		return null;
	}

	/**
	* Retorna o nome do esquema utilizado pela conexão postgres somente
	* @return string
	*/
	public function getConnSchema()
	{
		if ( $this->getConn() )
		{
			return $this->getConn()->schema;
		}

		return null;
	}

	/**
	* Retorna os caracteres considerados especias
	*
	* @return array
	*/
	public function getSpecialChars()
	{
		if ( count( $this->specialChars ) == 0 )
		{
			$this->specialChars=array
				(
				'Ã',
				'Â'
				);

			for( $i = 127; $i < 256; $i++ )
			{
				$char = chr( $i );

				if ( !preg_match( '/Â|Ã/', $char ) )
				{
					$this->specialChars[] = $char;
				}
			}
		}

		return $this->specialChars;
	}

	/**
	* Transforma os caracteres epeciais em seus carateres utf8 relacionados
	*
	* @param string $str
	*/
	public function utf8Encode( $str = null )
	{
		if ( is_null( $str ) || $str == '' )
		{
			return $str;
		}

		$result='';
		$this->utf8Decode( $str );

		for( $i = 0; $i < strlen( $str ); $i++ )
		{
			$result .= utf8_encode( substr( $str, $i, 1 ) );
		}

		return $result;
	}

	/**
	* Transforma o caracteres codificados em utf-8 no caractere especial relacionado
	*
	* @param string $str
	*/
	public function utf8Decode( $str = null )
	{
		foreach( $this->getSpecialChars()as $char )
		{
			$str = preg_replace( '/' . utf8_encode( $char ) . '/', $char, $str );
		}

		return $str;
	}

	/**
	* Processa o array de parametros aplicando/removendo codificação utf8, convertendo
	* datae números no formado correto de acordo com o banco de dados.
	*
	* Se $boolBind for true ( padrão) o retorno será o array associativo (key=>value ) quando
	* este for recebido neste formato,  se false o resultdo será convertido em um array indexado de 0 a N
	*
	* @param mixed $mixParams
	* @param boolean $boolBind
	*/
	public function prepareParams( $mixParams = null, $boolBind = true )
	{
		if ( is_numeric( $mixParams ) )
		{
			return $this->parseNumber( $mixParams );
		}
		else if( is_string( $mixParams ) )
		{
			if ( $this->getConnUtf8() )
			{
				$mixParams=trim( $mixParams );
				$mixParams=$this->utf8Decode( $mixParams ); // remover utf8
				return $this->utf8Encode( $mixParams );
			}

			return $this->utf8Decode( $mixParams );
		}
		else if( is_array( $mixParams ) )
		{
			$result=array();

			foreach( $mixParams as $k => $item )
			{
				if ( is_numeric( $item ) )
				{
					if ( !$boolBind )
					{
						array_push( $result, $this->prepareParams( $item, $boolBind ) );
					}
					else
					{
						$result[ $k ] = $this->prepareParams( $item, $boolBind );
					}
				}
				else
				{
					$objField=$this->getField( $k );
					$fieldType=null;
					if ( ! is_null( $objField ) )
					{
						$fieldType=$this->getValidFieldType( $objField->fieldType );
						if ( $fieldType == 'date' )
						{
							if ( $this->getDbType() == DBMS_ORACLE )
							{
								$item = $this->parseDMY( $item );
							}
							else
							{
								$item = $this->parseYMD( $item );
							}
						}
						elseif( $fieldType == 'number' )
						{
							$item = $this->parseNumber( $item );
						}
					}

					if ( ! $boolBind )
					{
						if ( $fieldType != 'binary' )
						{
							$item = $this->prepareParams( $item, $boolBind );
						}
						array_push( $result, $item );
					}
					else
					{
						if ( $fieldType != 'binary' )
						{
							$item = $this->prepareParams( $item, $boolBind );
						}
						$result[ $k ]=$item;
					}
				}
			}
			return $result;
		}
		return $mixParams;
	}
    /**
    * Retorna a data invertida no formato Ano, MÊs e Dia.
    *
    * @param string $date
    */
	public function parseYMD( $strDate = null )
	{
		if ( is_null( $strDate ) )
		{
			return $strDate;
		}

		$strDate =preg_replace( '/\//', '-', $strDate ); // trocar barra para hifem
		$aTemp=explode( ' ', $strDate );              // separar horas
		$strDate =$aTemp[ 0 ];
		$time =( isset( $aTemp[ 1 ] ) ? $aTemp[ 1 ] : null );
		$aTemp=explode( '-', $strDate );

		if ( !preg_match( '/^[0-9]{4}/', $strDate ) )
		{
			$strDate = $aTemp[ 2 ] . '-' . $aTemp[ 1 ] . '-' . $aTemp[ 0 ];
		}

		return $strDate . ( is_null( $time ) ? '' : ' ' . $time );
	}
    /**
    * Retorna a data no formato normal de Dia, Mês e Ano
    *
    * @param string $date
    */
	public function parseDMY( $strDate = null )
	{
		if ( is_null( $strDate ) )
		{
			return $strDate;
		}

		$strDate =preg_replace( '/\//', '-', $strDate ); // trocar barra para hifem
		$aTemp=explode( ' ', $strDate );              // separar horas
		$strDate =$aTemp[ 0 ];
		$time =( isset( $aTemp[ 1 ] ) ? $aTemp[ 1 ] : null );
		$aTemp=explode( '-', $strDate );

		if ( preg_match( '/^[0-9]{4}/', $strDate ) )
		{
			$strDate = $aTemp[ 2 ] . '-' . $aTemp[ 1 ] . '-' . $aTemp[ 0 ];
		}

		return $strDate . ( is_null( $time ) ? '' : ' ' . $time );
	}

	/**
	* Corrige o valor formatdo para numero decimal válido, colocando o ponto no lugar
	* da virgula
	*
	* @param string $value
	*/
	public function parseNumber( $strValue = null)
	{
		if ( preg_match( '/\,/', $strValue ) == 1 )
		{
			$posComma=strpos( $strValue, ',' );
			$qtdComma=substr_count( $strValue, ',' );
			$posPoint=strpos( $strValue, '.' );

			if ( $posPoint === false && $qtdComma > 1 )
			{
				$strValue = preg_replace( '/\,/', '', $strValue );
			}
			else if( $posPoint == 0 && $posComma > 0 )
			{
				$strValue = preg_replace( '/\,/', '.', $strValue );
			}
			else if( $posComma > $posPoint )
			{
				$strValue=preg_replace( '/\./', '', $strValue );
				$strValue=preg_replace( '/\,/', '.', $strValue );
			}
			else if( $posComma < $posPoint )
			{
				$strValue = preg_replace( '/\,/', '', $strValue );
			}
		}

		if ( $this->getDbType() == DBMS_ORACLE )
		{
			$strValue = preg_replace( '/\./', ',', $strValue );
		}

		return $strValue;
	}

	/**
	* Processa o resultado da consulta sql aplivando/removendo utf-8, ajustando números e datas
	* de acordo com o tipo da coluna
	*
	* @param mixed $data
	*/
	public function parseFetchResult( $data = null )
	{
		//return $data;
		if ( is_null( $data ) )
		{
			return $data;
		}

		if ( !is_array( $data ) )
		{
			return $data;
		}

		if ( isset( $data[ 0 ] ) )
		{
			if ( is_object( $data[ 0 ] ) )
			{
				if ( $this->getFields() )
				{
					foreach( $data as $k => $obj )
					{
						foreach( $this->getFields()as $fieldName => $objField )
						{
							$f         = $objField->fieldName;
							$fieldValue=null;

							if ( !isset( $obj->$f ) )
							{
								$f=strtolower( $f );

								if ( !isset( $obj->$f ) )
								{
									$f = null;
								}
							}

							if ( !is_null( $f ) )
							{
								$fieldType=$this->getValidFieldType( $objField->fieldType );

								if ( $fieldType == 'date' )
								{
									$fieldValue = $this->parseDMY( $obj->$f );
								}
								else if( $fieldType == 'text' )
								{
									$fieldValue = $this->parseString( $obj->$f );
								}

								if ( !is_null( $fieldValue ) )
								{
									$obj->$f = $fieldValue;
								}
							}
						}
					}
				}
			}
			else if( is_array( $data[ 0 ] ) )
			{
				foreach( $data as $k => $arr )
				{
					foreach( $arr as $fieldName => $value )
					{
						if ( $this->getField( $fieldName ) )
						{
							$objField =$this->getField( $fieldName );
							$fieldType=$this->getValidFieldType( $objField->fieldType );
							if ( $fieldType == 'date' )
							{
								$data[ $k ][ $fieldName ] = $this->parseDMY( $value );
							}
							else if( $fieldType == 'string' )
							{
								$data[ $k ][ $fieldName ] = $this->parseString( $value );
							}
						}
						else
						{
							$data[ $k ][ $fieldName ] = $this->parseString( $value );
						}
					}
				}
			}
		}
		return $data;
	}
	/**
	* Define o tipo de codificação que está sendo utilizada no browser. Padrão é utf-8
	* Pode ser definido de maneira global utilizando a constante CHARSET
	* Exemplo: setCharset('utf-8'); ou setCharset('iso-8859');
	*
	* @example setCharset('utf-8'),setCharset('iso-8859');
	* @param string $strNewValue
	*/
	public function setCharset( $strNewValue = null )
	{
		$this->charset=$strNewValue;
	}
    /**
    * REtorna o tipo de codificação que está sendo utilizada no browser
    *
    * @return string
    */
	public function getCharset()
	{
		if ( is_null( $this->charset ) )
		{
			if ( defined( 'CHARSET' ) )
			{
				$this->charset = CHARSET;
			}
			else
			{
				$this->charset = 'iso-8859';
			}
		}

		if ( strtolower( $this->charset ) == 'utf8' )
		{
			$this->charset = 'utf-8';
		}

		if ( !defined( 'CHARSET' ) )
		{
			define('CHARSET',$this->charset);
		}
		return strtolower( $this->charset );
	}

	/**
	* Retorna true/false se string estiver na codificação UTF-8
	*
	* @param string $strValue
	* @return boolean
	*/
	public function detectUTF8( $strValue = null )
	{
		if ( is_numeric( $strValue ) || !is_string( $strValue ) )
		{
			return false;
		}

		$result=false;

		foreach( $this->getSpecialChars()as $k => $v )
		{
			if ( preg_match( '/' . utf8_encode( $v ) . '/', $strValue ) )
			{
				$result=true;
				break;
			}
		}

		return $result;
	}
	/**
	* Método para verificar se existe algum caractere especial na string
	*
	* @param mixed $strValue
	* @return boolean
	*/
	public function detectSpecialChar( $strValue = null )
	{
		if ( is_numeric( $strValue ) || !is_string( $strValue ) )
		{
			return false;
		}

		// se tiver na codificação utf-8 retornar false
		if ( $this->detectUTF8( $strValue ) )
		{
			return false;
		}

		$result=false;

		foreach( $this->getSpecialChars()as $k => $v )
		{
			if ( preg_match( '/' . $v . '/', $strValue ) )
			{
				$result=true;
				break;
			}
		}

		return $result;
	}

	/**
	* Método para converter a string para utf-8 ou ascii dependendo
	* das configurações do banco de dados e do charset definido
	*
	* @param string $strValue
	*/
	public function parseString( $strValue = null )
	{
		if ( !is_string( $strValue ) || is_numeric( $strValue ) )
		{
			return $strValue;
		}

		if ( $this->getCharset() == 'utf-8' )
		{
			if ( $this->detectSpecialChar( $strValue ) )
			{
				$strValue = $this->utf8Encode( $strValue );
			}
		}
		else
		{
			if ( $this->detectUTF8( $strValue ) )
			{
				$strValue = $this->utf8Decode( $strValue );
			}
		}

		return $strValue;
	}

	/**
	* Define o nome da tabela do banco de dados que será utizizada nos
	* comando insert, save, delete ...
	*
	* @param string $strNewValue
	*/
	public function setTableName( $strNewValue = null )
	{
		$this->tableName=$strNewValue;
	}
    /**
    * Retorna o nome da tabela que está sendo utilizada nos comandos
    * insert, delete, save ...
    *
    */
	public function getTableName()
	{
		return $this->tableName;
	}

	/**
	* Converte o tipo de campo da coluna da tabela para um tipo de campo padrão da classe
	*
	* @param string $strFieldType
	* @return string
	*/
	public function getValidFieldType( $strFieldType = null )
	{
		list( $strFieldValue )=explode( ' ', $strFieldType );

		if ( is_null( $strFieldType ) )
		{
			return null;
		}

		if ( preg_match( '/long|clob|char|varchar|varchar2|text|charactervarying/i', $strFieldType ) )
		{
			return 'string';
		}

		if ( preg_match( '/decimal|real|float|numeric|number|int|int64|integer|double|smallint|bigint/i', $strFieldType ) )
		{
			return 'number';
		}

		if ( preg_match( '/date|datetime|timestamp/i', $strFieldType ) )
		{
			return 'date';
		}

		if ( preg_match( '/blob|bytea/i', $strFieldType ) )
		{
			return 'binary';
		}

		return $strFieldType;
	}

	/**
	* Retorna o diretório/pasta onde será armazenada as informações dos campos
	* extraídos das tabela
	*
	* @param string $strNewValue
	*/
	public function setMetadataDir( $strNewValue = null )
	{
		$this->metadataDir=trim( $strNewValue ) . '/';
		$this->metadataDir=preg_replace( '/\/\//', '', $this->metadataDir ) . '/';

		if ( !is_null( $strNewValue ) && !file_exists( $strNewValue ) )
		{
			$oldumask=umask( 0 );
			@mkdir( $strNewValue, 0755, true );
			umask( $oldumask );
		}
	}
    /**
    * Retorna o nome do diretório/pasta onde serão armazendas as informações dos campos
    * das tabelas
    *
    * @return string;
    */
	public function getMetadataDir()
	{
		if ( !is_null( $this->metadataDir ) && file_exists( $this->metadataDir ) )
		{
			return preg_replace( '/\/\//', '/', $this->metadataDir . '/' );
		}

		return null;
	}

	/**
	* Serialize e salva os campos no diretório/pasta de metadados
	*
	* @return null
	*/
	public function serializeFields()
	{
		if ( $this->getMetadataDir() && $this->getTableName() )
		{
		    $filename = $this->getMetadataDir() . $this->getConnDbType() . '-' . $this->getTableName() . '.ser';
		    $data = serialize( $this->getFields() );
		    file_put_contents( $filename, $data );
		}
	}
    /**
    * Desserializa as definições dos campos de uma tabela que foram salvos no diretório/pasta
    * de metadados e carrega o array fields da classe
    *
    * @return boolean
    */
	public function unserializeFields()
	{
		$result=false;

		if ( $this->getMetadataDir() && $this->getTableName() )
		{
			$fileName=$this->getMetadataDir() . $this->getConnDbType() . '-' . $this->getTableName() . '.ser';

			if ( file_exists( $fileName ) )
			{
				$this->fields=unserialize( file_get_contents( $fileName ) );

				if ( is_array( $this->fields ) )
				{
					$result = true;
				}
			}
		}

		return $result;
	}
	
	public function loadTablesFromDatabase() {
		//$DbType = $this->getConnDbType();
		$DbType = $this->getDbType();
		$sql = null;
		switch( $DbType ) {
			case DBMS_SQLITE:
				$sql = 'SELECT 
							\'\' as TABLE_SCHEMA
							,name as TABLE_NAME 
							,\'\' as COLUMN_QTD
							,upper(type) as TABLE_TYPE
						FROM sqlite_master where type in (\'table\', \'view\')';
			break;
			//--------------------------------------------------------------------------------
			case DBMS_MYSQL:
				$sql = "select vg.TABLE_SCHEMA
                        	  ,vg.TABLE_NAME
                              ,vg.COLUMN_QTD
                              ,vg.TABLE_TYPE
                        from
                        (                        
                        	select vt.TABLE_SCHEMA
                        		  ,vt.TABLE_NAME
                        		  ,count(*) as COLUMN_QTD
                        		  ,vt.TABLE_TYPE
                        	from
                        	(
                        		SELECT t.TABLE_SCHEMA
                        			  ,t.TABLE_NAME
                        			  ,case when upper(t.TABLE_TYPE) = 'BASE TABLE' then 'TABLE' else upper(t.TABLE_TYPE) end  as TABLE_TYPE
                        		FROM INFORMATION_SCHEMA.TABLES as t
                        			,INFORMATION_SCHEMA.COLUMNS as c
                        		WHERE t.TABLE_NAME = c.TABLE_NAME 
                        		 and  t.TABLE_SCHEMA = c.TABLE_SCHEMA
                        		 and (t.TABLE_TYPE = 'BASE TABLE' OR t.TABLE_TYPE = 'VIEW')
                        		 and t.TABLE_SCHEMA not in ('sys','performance_schema','mysql','information_schema')
                        	 ) as vt
                        	 group by vt.TABLE_SCHEMA
                        			 ,vt.TABLE_NAME
                        			 ,vt.TABLE_TYPE
                        			 
                        	union
                        
                        	select vp.TABLE_SCHEMA
                                  ,vp.TABLE_NAME
                                  ,count(*) as COLUMN_QTD
                                  ,'PROCEDURE' as TABLE_TYPE
                        	from
                        	(
                        		select p.SPECIFIC_SCHEMA as TABLE_SCHEMA
                        			  ,p.SPECIFIC_NAME as TABLE_NAME
                        			  ,p.routine_type as TABLE_TYPE
                        		from information_schema.routines as r
                        		left join information_schema.parameters as p
                        				  on p.specific_schema = r.routine_schema
                        				  and p.specific_name = r.specific_name
                        		where r.routine_schema not in ('sys', 'information_schema','mysql', 'performance_schema')
                        		and p.routine_type = 'PROCEDURE'
                        	) as vp
                        	group by vp.TABLE_SCHEMA
                        			,vp.TABLE_NAME
                        			,vp.TABLE_TYPE
                        ) as vg
                        order by 
                                 vg.TABLE_SCHEMA
                        		,vg.TABLE_TYPE
                        		,vg.TABLE_NAME";
			break;
			//--------------------------------------------------------------------------------
			case DBMS_SQLSERVER:
			    $sql = "select 
                        TABLE_SCHEMA
                        ,TABLE_NAME
                        ,COLUMN_QTD
                        ,TABLE_TYPE
                        from (
                        SELECT qtd.TABLE_SCHEMA
                        		,qtd.TABLE_NAME
                        		,qtd.COLUMN_QTD
                        		,case ty.TABLE_TYPE WHEN 'BASE TABLE' THEN 'TABLE' ELSE ty.TABLE_TYPE end as TABLE_TYPE
                        FROM
                        	(SELECT TABLE_SCHEMA
                        			,TABLE_NAME
                        			,COUNT(TABLE_NAME) COLUMN_QTD
                        	FROM INFORMATION_SCHEMA.COLUMNS c
                        	where c.TABLE_SCHEMA <> 'METADADOS'
                        	group by TABLE_SCHEMA, TABLE_NAME
                        	) as qtd
                        	,(SELECT TABLE_SCHEMA
                        			, TABLE_NAME
                        			, TABLE_TYPE
                        	FROM INFORMATION_SCHEMA.TABLES i
                        	where I.TABLE_SCHEMA <> 'METADADOS'
                        	) as ty
                        where qtd.TABLE_SCHEMA = ty.TABLE_SCHEMA
                        and qtd.TABLE_NAME = ty.TABLE_NAME
                        
                        UNION
                        
                         SELECT Schema_name(schema_id)   AS TABLE_SCHEMA,
                               SO.NAME                   AS TABLE_NAME,       
                        	   count(*)                  AS COLUMN_QTD,
                        	   CASE SO.type_desc 
                        	   WHEN  'SQL_STORED_PROCEDURE' THEN 'PROCEDURE'
                        	   ELSE 'FUNCTION' 
                        	   END AS TABLE_TYPE	   
                        FROM   sys.objects AS SO
                               INNER JOIN sys.parameters AS P
                                       ON SO.object_id = P.object_id
                        WHERE  SO.object_id IN (SELECT object_id
                                                FROM   sys.objects
                                                WHERE  type IN ( 'P', 'FN' ))
                        group by schema_id, SO.NAME, SO.type_desc
                        ) as res
                        order by res.TABLE_SCHEMA
                               , res.TABLE_TYPE
                               , res.TABLE_NAME";
			break;
			//--------------------------------------------------------------------------------
			case DBMS_POSTGRES:
			    $sql = "SELECT qtd.TABLE_SCHEMA
                              ,qtd.TABLE_NAME
                        	  ,qtd.COLUMN_QTD
                        	  ,ty.TABLE_TYPE
							  ,case ty.TABLE_TYPE WHEN 'BASE TABLE' THEN 'TABLE' ELSE ty.TABLE_TYPE end as TABLE_TYPE
                        FROM
                        	(SELECT TABLE_SCHEMA
                        		  ,TABLE_NAME
                        		  ,COUNT(TABLE_NAME) COLUMN_QTD
                        	FROM INFORMATION_SCHEMA.COLUMNS c
                        	where c.TABLE_SCHEMA <> 'pg_catalog' and c.TABLE_SCHEMA <> 'information_schema'
                        	group by TABLE_SCHEMA, TABLE_NAME
                        	) as qtd
                        	,(SELECT TABLE_SCHEMA
                        	       , TABLE_NAME
                        		   , TABLE_TYPE
                        	FROM INFORMATION_SCHEMA.TABLES i
                        	where I.TABLE_SCHEMA <> 'pg_catalog' and I.TABLE_SCHEMA <> 'information_schema'
                        	) as ty
                        where qtd.TABLE_SCHEMA = ty.TABLE_SCHEMA
                        and qtd.TABLE_NAME = ty.TABLE_NAME
                        order by qtd.TABLE_SCHEMA, qtd.TABLE_NAME";
			    break;
			//--------------------------------------------------------------------------------
			default:
				throw new DomainException('Database '.$DbType.' not implemented ! TDAO->loadTablesFromDatabase. Contribute to the project https://github.com/bjverde/sysgen !');
		}
		$result = $this->executeSql($sql);
		return $result;
	}
	
	private function getMsSqlShema() {
	    $result = '';
	    if($this->getSchema()){
	        $result = " AND upper(c.TABLE_SCHEMA) = upper('".$this->getSchema()."') ";
	    }
	    return $result;
	}
	
	public function getSqlToFieldsFromOneStoredProcedureMySQL() {
	    $sql="select 
                	 p.parameter_name as COLUMN_NAME
                	,'FALSE' as REQUIRED
                	,r.routine_type AS DATA_TYPE
                	,p.character_maximum_length as CHAR_MAX
                	,p.numeric_precision as NUM_LENGTH
                	,p.numeric_scale as NUM_SCALE
                	,r.ROUTINE_COMMENT as COLUMN_COMMENT
                	,r.specific_name as TABLE_NAME
                	,r.routine_schema as TABLE_SCHEMA
                	,p.ordinal_position
                	,case when p.parameter_mode is null and p.data_type is not null
                				then 'RETURN'
                				else parameter_mode end as parameter_mode
                from information_schema.routines r
                left join information_schema.parameters p
                          on p.specific_schema = r.routine_schema
                          and p.specific_name = r.specific_name
                where r.routine_schema not in ('sys', 'information_schema','mysql', 'performance_schema')
                and upper(r.specific_name)  = upper('".$this->getTableName()."')
                and upper(r.routine_schema) = upper('".$this->getSchema()."')
                order by r.routine_schema,
                         r.specific_name,
                         p.ordinal_position";
	    return $sql;
	}
	
	public function getSqlToFieldsFromOneStoredProcedureSqlServer() {
	    $name = $this->getTableName();
	    $shema = $this->getSchema();
	    $sql="SELECT REPLACE(P.NAME,'@','')   AS COLUMN_NAME
                   ,'FALSE'                   AS REQUIRED
            	   ,Type_name(P.user_type_id) AS DATA_TYPE
                   ,P.max_length              AS CHAR_MAX
                   ,null                      AS NUM_LENGTH
                   ,null                      AS NUM_SCALE
                   ,null                      AS COLUMN_COMMENT
            	   ,null                      AS COLUMN_COMMENT
            	   ,null                      AS KEY_TYPE
            	   ,null                      AS REFERENCED_TABLE_NAME
            	   ,null                      AS REFERENCED_COLUMN_NAME
                   ,Schema_name(schema_id)    AS TABLE_SCHEMA
                   ,SO.NAME                   AS table_name
            FROM   sys.objects AS SO
                   INNER JOIN sys.parameters AS P
                           ON SO.object_id = P.object_id
            WHERE  SO.object_id IN (SELECT object_id
                                    FROM   sys.objects
                                    WHERE  type IN ( 'P'))
                  AND upper(SO.NAME) = upper('".$name."')
                  AND upper(Schema_name(schema_id)) = upper('".$shema."')
                  ";
	    return $sql;
	}
	
	public function getSqlToFieldsOneStoredProcedureFromDatabase() {
	    //$DbType = $this->getConnDbType();
	    $DbType = $this->getDbType();
	    $sql    = null;
	    $params = null;
	    $data   = null;
	    
	    // ler os campos do banco de dados
	    if ( $DbType == DBMS_MYSQL ){
	        $sql   = $this->getSqlToFieldsFromOneStoredProcedureMySQL();
	    }
	    else if( $DbType == DBMS_SQLSERVER ) {
	        $sql   = $this->getSqlToFieldsFromOneStoredProcedureSqlServer();
	        $params=array($this->getTableName());
	    }
	    $result = array();
	    $result['sql']    = $sql;
	    $result['params'] = $params;
	    $result['data']   = $data;	    
	    return $result;
	}
	
	/**
	 * Recupera as informações dos parametros de uma Storage Procedeure diretamente do banco de dados
	 * @return null
	 */
	public function loadFieldsOneStoredProcedureFromDatabase() {
	    $DbType = $this->getDbType();
	    if ( !$this->getTableName() ) {
	        throw new InvalidArgumentException('Table Name is empty');
	    }
	    $result = $this->getSqlToFieldsOneStoredProcedureFromDatabase();
	    $sql    = $result['sql'];
	    switch( $DbType ) {
	        case DBMS_MYSQL:
	        case DBMS_SQLSERVER:
	            $result = $this->executeSql($sql);
	        break;
	        //--------------------------------------------------------------------------------
	        default:
	            throw new DomainException('Database '.$DbType.' not implemented ! Contribute to the project https://github.com/bjverde/sysgen !');
	    }
	    return $result;
	}
	
	public function getSqlToFieldsFromDatabaseMySQL() {
	    // http://dev.mysql.com/doc/refman/5.0/en/tables-table.html
	    $sql="SELECT c.column_name COLUMN_NAME
						, case when upper(c.IS_NULLABLE) = 'NO' then 'TRUE' else 'FALSE' end REQUIRED
						, c.data_type DATA_TYPE
						, c.character_maximum_length CHAR_MAX
						, c.numeric_precision NUM_LENGTH
						, c.numeric_scale NUM_SCALE
						, c.COLUMN_COMMENT
						, case when upper(c.COLUMN_KEY) = 'PRI' then 'PK' when ( upper(c.COLUMN_KEY) = 'MUL' AND k.REFERENCED_TABLE_NAME is not null ) then 'FOREIGN KEY' else 0 end  KEY_TYPE
						, case when lower(c.EXTRA) = 'auto_increment' then 1 else 0 end  AUTOINCREMENT
						, c.COLUMN_DEFAULT
						, k.REFERENCED_TABLE_NAME
						, k.REFERENCED_COLUMN_NAME
						, c.TABLE_SCHEMA
						, c.table_name
						, c.TABLE_CATALOG
				   from information_schema.columns as c
				   left join information_schema.KEY_COLUMN_USAGE as k
				   on c.TABLE_SCHEMA = k.TABLE_SCHEMA
				   and c.table_name = k.table_name
				   and c.column_name = k.column_name
				   WHERE upper(c.table_name) = upper('".$this->getTableName()."')
						 order by c.table_name
						 ,c.ordinal_position";
	    return $sql;
	}
	
	public function getSqlToFieldsFromDatabaseSqlServer() {
	    $sql="SELECT c.column_name as COLUMN_NAME
                          ,case c.IS_NULLABLE WHEN 'YES' THEN 'FALSE' ELSE 'TRUE' end as REQUIRED
                          ,c.DATA_TYPE
                          ,c.CHARACTER_MAXIMUM_LENGTH as CHAR_MAX
                          ,c.NUMERIC_PRECISION as NUM_LENGTH
                          ,c.NUMERIC_SCALE as NUM_SCALE
                    	  ,prop.value AS COLUMN_COMMENT
                    	  ,fk2.CONSTRAINT_TYPE as KEY_TYPE
                    	  ,fk2.REFERENCED_TABLE_NAME
                    	  ,fk2.REFERENCED_COLUMN_NAME
                          ,c.TABLE_SCHEMA
                          ,c.table_name
                    	  ,c.TABLE_CATALOG
                    from INFORMATION_SCHEMA.COLUMNS c
                        join sys.columns AS sc on sc.object_id = object_id(c.TABLE_SCHEMA + '.' + c.TABLE_NAME) AND sc.NAME = c.COLUMN_NAME
                        LEFT JOIN sys.extended_properties prop ON prop.major_id = sc.object_id AND prop.minor_id = sc.column_id AND prop.NAME = 'MS_Description'
                    	LEFT JOIN (
                    		SELECT CT.TABLE_CATALOG
                    			 , CT.TABLE_SCHEMA
                    			 , CT.TABLE_NAME
                    			 , CT.COLUMN_NAME
                    			 , CT.CONSTRAINT_TYPE
                    			 , FK.REFERENCED_TABLE_NAME
                    			 , FK.REFERENCED_COLUMN_NAME
                    		FROM (
                    				SELECT kcu.TABLE_CATALOG
                    					 , kcu.TABLE_SCHEMA
                    					 , kcu.TABLE_NAME
                    					 , kcu.COLUMN_NAME
                    					 , tc.CONSTRAINT_TYPE
                    					 , kcu.CONSTRAINT_NAME
                    				FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE kcu
                    					,INFORMATION_SCHEMA.TABLE_CONSTRAINTS  tc
                    				where kcu.CONSTRAINT_NAME = tc.CONSTRAINT_NAME
                    				) as CT
	        
                    			LEFT JOIN (
                    				SELECT
                    					 KCU1.CONSTRAINT_NAME AS FK_CONSTRAINT_NAME
                    					,KCU1.TABLE_NAME AS FK_TABLE_NAME
                    					,KCU1.COLUMN_NAME AS FK_COLUMN_NAME
                    					,KCU2.TABLE_NAME AS REFERENCED_TABLE_NAME
                    					,KCU2.COLUMN_NAME AS REFERENCED_COLUMN_NAME
                    				FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS AS RC
	        
                    				INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KCU1
                    					ON KCU1.CONSTRAINT_CATALOG = RC.CONSTRAINT_CATALOG
                    					AND KCU1.CONSTRAINT_SCHEMA = RC.CONSTRAINT_SCHEMA
                    					AND KCU1.CONSTRAINT_NAME = RC.CONSTRAINT_NAME
	        
                    				INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KCU2
                    					ON KCU2.CONSTRAINT_CATALOG = RC.UNIQUE_CONSTRAINT_CATALOG
                    					AND KCU2.CONSTRAINT_SCHEMA = RC.UNIQUE_CONSTRAINT_SCHEMA
                    					AND KCU2.CONSTRAINT_NAME = RC.UNIQUE_CONSTRAINT_NAME
                    					AND KCU2.ORDINAL_POSITION = KCU1.ORDINAL_POSITION
                    				) as FK
                    		ON CT.CONSTRAINT_NAME = FK.FK_CONSTRAINT_NAME
                    		AND CT.TABLE_NAME = FK.FK_TABLE_NAME
                    		AND CT.COLUMN_NAME = FK.FK_COLUMN_NAME
                    	) as FK2
                    	on c.TABLE_SCHEMA = FK2.TABLE_SCHEMA
                    	and c.TABLE_NAME = Fk2.TABLE_NAME
                    	and c.COLUMN_NAME = fk2.COLUMN_NAME
                    WHERE upper(c.table_name) = upper('".$this->getTableName()."')".$this->getMsSqlShema()."
                    ORDER by   c.TABLE_SCHEMA
                              ,c.TABLE_NAME
                              ,c.ORDINAL_POSITION";
	    return $sql;
	}
	
	public function getSqlToFieldsFromDatabasePostGres() {
		$sql   ="SELECT c.column_name as COLUMN_NAME
					  , case c.IS_NULLABLE WHEN 'YES' THEN 'FALSE' ELSE 'TRUE' end as REQUIRED
					  , data_type as DATA_TYPE
					  , character_maximum_length CHAR_MAX
					  , coalesce(numeric_precision, datetime_precision) as NUM_LENGTH
					  , numeric_scale as NUM_SCALE
					  , des.description COLUMN_COMMENT
					  , refe.KEY_TYPE
					  , column_default COLUMN_DEFAULT
					  , refe.REFERENCED_TABLE_NAME
					  , refe.REFERENCED_COLUMN_NAME					  
					  , position('nextval(' in column_default)=1 as AUTOINCREMENT
					  , c.TABLE_SCHEMA
					  , c.table_name
					  , c.TABLE_CATALOG
					FROM information_schema.columns as c
						 left join (SELECT  st.schemaname as table_schema
							              , st.relname as table_name
							              , pgd.objsubid
							              , pgd.description
							         FROM pg_catalog.pg_statio_all_tables as st
							         inner join pg_catalog.pg_description pgd on (pgd.objoid=st.relid)
							       ) as des
						 on (des.objsubid=c.ordinal_position and  des.table_schema = c.table_schema and des.table_name = c.table_name)
						 left join (SELECT
										  tc.table_schema
										, tc.table_name
										, kcu.column_name
										, tc.constraint_name	
										, tc.constraint_type
										, case when upper(tc.constraint_type) = 'PRIMARY KEY' THEN  'PK' 
											   when upper(tc.constraint_type) = 'FOREIGN KEY' THEN 'FOREIGN KEY' 
											   ELSE tc.constraint_type
											   END  as KEY_TYPE	
										, ccu.table_schema AS REFERENCED_TABLE_SCHEMA
										, ccu.table_name AS REFERENCED_TABLE_NAME
										, ccu.column_name AS REFERENCED_COLUMN_NAME 
									FROM 
										information_schema.table_constraints AS tc 
										JOIN information_schema.key_column_usage AS kcu
										  ON tc.constraint_name = kcu.constraint_name
										JOIN information_schema.constraint_column_usage AS ccu
										  ON ccu.constraint_name = tc.constraint_name
									WHERE constraint_type in ('FOREIGN KEY' ,'PRIMARY KEY')
							       ) as refe
						 on (refe.table_schema = c.table_schema and refe.table_name = c.table_name and refe.column_name = c.column_name)						 
					WHERE upper(c.table_name) =upper('".$this->getTableName()."')".$this->getMsSqlShema()." 
					ORDER BY c.TABLE_SCHEMA
                            ,c.table_name
                            ,c.ordinal_position";
		return $sql;
	}
	
	public function getSqlToFieldsFromDatabase() {
		//$DbType = $this->getConnDbType();
		$DbType = $this->getDbType();
		$sql    = null;
		$params = null;
		$data   = null;
		
		// ler os campos do banco de dados
		if ( $DbType == DBMS_MYSQL ){
		    $sql   = $this->getSqlToFieldsFromDatabaseMySQL();
			$params=null;
		}
		else if( $DbType == DBMS_SQLSERVER ) {
		    $sql   = $this->getSqlToFieldsFromDatabaseSqlServer();
		    $params=array($this->getTableName());
		}
		else if( $DbType == DBMS_ORACLE ) {
			$sql="select a.column_name COLUMN_NAME
					, a.data_type DATA_TYPE
					, data_default as COLUMN_DEFAULT
					, 0 AUTOINCREMENT
					, decode(nullable,'Y',1,0) as REQUIRED
					, a.data_length CHAR_MAX
					, a.data_precision NUM_LENGTH
					, a.data_scale NUM_SCALE
    				from all_tab_columns a
    				where upper(a.table_name) = upper(:0)";
			
			$params=array($this->getTableName());
		}
		else if( $DbType == DBMS_POSTGRES ) {
		    $schema=( is_null( $this->getSchema() ) ? 'public' : $this->getSchema());
		    $sql   = $this->getSqlToFieldsFromDatabasePostGres();			
			$params=array( $schema ,$this->getTableName() );
		}
		else if( $DbType == DBMS_FIREBIRD ) {
			$sql='SELECT
					RDB$RELATION_FIELDS.RDB$FIELD_NAME COLUMN_NAME,
					\'\' as COLUMN_DEFAULT,
					0 AUTOINCREMENT,
					0 REQUIRED,
					RDB$TYPES.RDB$TYPE_NAME DATA_TYPE,
					RDB$FIELDS.RDB$CHARACTER_LENGTH CHAR_MAX,
					RDB$FIELDS.RDB$FIELD_PRECISION NUM_LENGTH,
					RDB$FIELDS.RDB$FIELD_SCALE NUM_SCALE
					FROM RDB$RELATIONS
					INNER JOIN RDB$RELATION_FIELDS ON RDB$RELATIONS.RDB$RELATION_NAME = RDB$RELATION_FIELDS.RDB$RELATION_NAME
					LEFT JOIN RDB$FIELDS ON RDB$RELATION_FIELDS.RDB$FIELD_SOURCE = RDB$FIELDS.RDB$FIELD_NAME
					LEFT JOIN RDB$TYPES ON RDB$FIELDS.RDB$FIELD_TYPE = RDB$TYPES.RDB$TYPE
					LEFT JOIN RDB$FIELD_DIMENSIONS  on RDB$FIELD_DIMENSIONS.RDB$FIELD_NAME = RDB$FIELDS.RDB$FIELD_NAME
					WHERE UPPER(RDB$RELATIONS.RDB$RELATION_NAME) = upper(?)
					AND RDB$RELATIONS.RDB$SYSTEM_FLAG = 0
					AND RDB$TYPES.RDB$FIELD_NAME=\'RDB$FIELD_TYPE\'
					ORDER BY RDB$RELATION_FIELDS.RDB$FIELD_POSITION';
			
			$params=array($this->getTableName());
		}
		else if( $DbType == DBMS_SQLITE) {
			$stmt = $this->getConn()->query( "PRAGMA table_info(".$this->getTableName().")");
			$res  = $stmt->fetchAll();
			$data = null;
			$sql  = null;
			foreach($res as $rownum => $row)
			{
				$data[$rownum]['COLUMN_NAME'] 	= $row['NAME'];
				$data[$rownum]['COLUMN_DEFAULT']= $row['DFLT_VALUE'];
				$data[$rownum]['AUTOINCREMENT'] = $row['PK'];
				$data[$rownum]['REQUIRED'] 		= ( $row['NOTNULL'] == 0 ? 'FALSE' : 'TRUE' );
				$data[$rownum]['DATA_TYPE'] 	= strtoupper($row['TYPE']);
				$data[$rownum]['CHAR_MAX'] 	= null;
				$data[$rownum]['NUM_LENGTH']= 0;
				$data[$rownum]['NUM_SCALE']	= 0;
				$data[$rownum]['PRIMARYKEY']	= $row['PK'];
				if( preg_match('/\(/',$row['TYPE']) == 1 )
				{
					$aTemp = explode('(',$row['TYPE']);
					$data[$rownum]['DATA_TYPE'] = $aTemp[0];
					$type= substr($row['TYPE'],strpos($row['TYPE'],'('));
					$type = preg_replace('/(\(|\))/','',$type);
					@list($length,$precision) = explode(',',$type);
					
					if( preg_match('/varchar/i',$aTemp[0]==1) ) {
						$data[$rownum]['DATA_LENGTH'] = $length;
					}
					else {
						$data[$rownum]['CHAR_MAX'] 	  = 0;
						$data[$rownum]['NUM_LENGTH']  = $length;
						$data[$rownum]['NUM_SCALE']   = $precision;
					}
				}
			}
		}
		$result = array();
		$result['sql']    = $sql;
		$result['params'] = $params;
		$result['data']   = $data;
		
		return $result;
	}
	
	/**
	 * Recupera as informações dos campos da tabela defida na classe diretamente do banco de dados
	 * @return null
	 */
	public function loadFieldsOneTableFromDatabase() {
		$DbType = $this->getDbType();
		if ( !$this->getTableName() ) {
			throw new InvalidArgumentException('Table Name is empty');
		}
		$result = $this->getSqlToFieldsFromDatabase();
		$sql    = $result['sql'];
		$data   = $result['data'];
		switch( $DbType ) {
			case DBMS_SQLITE:
				$result = ArrayHelper::convertArrayPdo2FormDin($data);
			break;
			//--------------------------------------------------------------------------------
			case DBMS_MYSQL:
			case DBMS_SQLSERVER:
			case DBMS_POSTGRES:
				$result = $this->executeSql($sql);
		    break;
			//--------------------------------------------------------------------------------
			default:
				throw new DomainException('Database '.$DbType.' not implemented ! Contribute to the project https://github.com/bjverde/sysgen !');
		}		
		return $result;
	}

	/**
	* Recupera as informações dos campos da tabela defida na classe diretamente do banco de dados
	* @return null
	*/
	public function loadFieldsFromDatabase() {		
		if ( !$this->getTableName() ) {
			return null;
		}
		$result = $this->getSqlToFieldsFromDatabase();
		$sql    = $result['sql'];
		$params = $result['params'];
		$data   = $result['data'];
		
		if ( !is_null( $sql ) ) {
			$data =  $this->query( $sql, $params );
		}
		
		if ( is_array( $data ) ){
			foreach( $data as $k => $row ) {
				$boolPrimaryKey = ArrayHelper::get($row,'PRIMARYKEY');
				$this->addField( trim( $row[ 'COLUMN_NAME' ] )
				               , trim( strtolower($row[ 'DATA_TYPE' ]) )
				               , ( (int) $row[ 'NUM_LENGTH' ] > 0 ? $row[ 'NUM_LENGTH' ] : $row[ 'CHAR_MAX' ] )
				               , $row[ 'NUM_SCALE' ]
				               , $row[ 'COLUMN_DEFAULT' ]
				               , $row[ 'REQUIRED' ]
				               , $row[ 'AUTOINCREMENT' ]
				               , $boolPrimaryKey);
			}
			if ( is_array( $this->getfields() ) ) {
				$this->serializeFields();
			}
		}
	}

	/**
	* Define o nome do campo autoincremento da tabela
	*
	* @param string $strNewValue
	*/
	public function setAutoincFieldName( $strNewValue = null )
	{
		$this->autoincFieldName=$strNewValue;
	}
    /**
    * Retorna o nome do campo autoincremento da tabela
    *
    */
	public function getAutoincFieldName()
	{
		if ( is_null( $this->autoincFieldName ) )
		{
			if ( $this->getFields() )
			{
				foreach( $this->getFields()as $fieldName => $objField )
				{
					if ( $objField->autoincrement == 1 )
					{
						$this->setAutoincFieldName( $objField->fieldName );
						break;
					}
				}
			}
		}

		return trim( $this->autoincFieldName );
	}

	/**
	* Retorna o valor da propriedade lastId
	*
	* @return integer
	*/
	public function getLastId()
	{
		return $this->lastId;
	}
    /**
    * Recupera do banco de dados o valor campo autoincremento referente ao último insert ocorrido
    *
    */
	public function getLastInsertId()
	{
		$sql   =null;
		$params=null;
		$dbType = $this->getConnDbType();
		if ( $dbType == DBMS_MYSQL )
		{
			$sql = 'SELECT LAST_INSERT_ID() as ID';
		}
		else if( $dbType == DBMS_POSTGRES )
		{
			if ( $this->getAutoincFieldName() )
			{
				$sql="SELECT currval(pg_get_serial_sequence(?,?) ) as ID";

				$params=array
					(
					$this->getTableName(),
					$this->getAutoincFieldName()
					);
			}
		}
		else if( $dbType == DBMS_ORACLE )
		{
			if ( $this->getAutoincFieldName() )
			{
				return $this->lastId;
			}
		}
		else if( $dbType == DBMS_SQLITE )
		{
			if ( $this->getAutoincFieldName() )
			{
				$sql = "select last_insert_rowid() as ID";
				$params=null;
			}
		}
		if ( $sql )
		{
			$res = self::query($sql,$params);
			if ( isset( $res[ 0 ][ 'ID' ] ) )
			{
				return $res[ 0 ][ 'ID' ];
			}
			else if( isset( $res[ 0 ][ 'id' ] ) )
			{
				return $res[ 0 ][ 'id' ];
			}
		}

		return null;
	}
    /**
    * Retorna se a conexão está utilizando a extensão PDO para conexão com o
    * banco de dados
    * Obs: para o banco de dados oracle serão utilizadas as funções oci do php
    *
    */
	public function isPDO()
	{
		if ( $this->getConn() )
		{
			return $this->getConn()->isPDO;
		}
		return null;
	}
    /**
    * Recebe o tipo de dados da coluna e retorna o tipo bind relacionado
    *
    * @param mixed $strFieldType
    */
	public function getBindType( $strFieldType = null )
	{
		$bindTypes[ 'oracle' ][ 'char' ]        =SQLT_CHR;
		$bindTypes[ 'oracle' ][ 'varchar' ]     =SQLT_CHR;
		$bindTypes[ 'oracle' ][ 'varchar2' ]    =SQLT_CHR;
		$bindTypes[ 'oracle' ][ 'integer' ]     =SQLT_INT;
		$bindTypes[ 'oracle' ][ 'number' ]      =SQLT_LNG;
		$bindTypes[ 'oracle' ][ 'blob' ]        =SQLT_BLOB;
		$bindTypes[ 'oracle' ][ 'clob' ]        =SQLT_CLOB;
		$bindTypes[ 'oracle' ][ 'long' ]        =SQLT_LNG;
		$bindTypes[ 'oracle' ][ 'long raw' ]    =SQLT_LBI;
		$bindTypes[ 'oracle' ][ 'date' ]        =SQLT_LNG;
		$bindTypes[ 'oracle' ][ 'timestamp(6)' ]=SQLT_LNG;
		$strFieldType                           =strtolower( $strFieldType );
		$dbType                                 =strtolower( $this->getDbType() );
		$result                                 =null;

		if ( isset( $bindTypes[ $dbType ][ $strFieldType ] ) )
		{
			$result = $bindTypes[ $dbType ][ $strFieldType ];
		}

		return $result;
	}
    /**
    * Ativa / Desativia o commit automático após a execução do método query()
    *
    * @param boolean $boolNewValue
    */
	public function setAutoCommit( $boolNewValue = null )
	{
		$this->autoCommit=$boolNewValue;
	}
    /**
    * Retorna se autocomit está ativo ou não.
    *
    */
	public function getAutoCommit()
	{
		return ( ( $this->autoCommit === false ) ? false : true );
	}
    /**
    * Inicializa uma transação no banco de dados
    *
    */
	public function beginTransaction()
	{
		if( $this->getHasActiveTransaction() )
		{
			return true;
		}
		if ( $this->getConn() )
		{
			if ( $this->isPDO() )
			{
				$this->getConn()->beginTransaction();
				$this->hasActiveTransaction=true;
				return true;
			}
		}
		return false;
	}
    /**
    * Termina a transação atual e faz com que todas as mudanças sejam permanentes.
    *
    */
	public function commit()
	{
		if( ! $this->getHasActiveTransaction() )
		{
			return;
		}
		$this->hasActiveTransaction=false;
		if ( $this->getConn() )
		{
			if ( $this->getDbType() == DBMS_ORACLE )
			{
				oci_commit( $this->getConn()->connection );
			}
			else
			{
				$this->getConn()->commit();
			}
		}
	}
    /**
    * Cancela a transação atual desfazendo todas as mudanças pendentes.
    *
    */
	public function rollBack()
	{
		if( ! $this->getHasActiveTransaction() )
		{
			return;
		}
		$this->hasActiveTransaction=false;
		if ( $this->getConn() )
		{
			if ( $this->isPDO() )
			{
				$this->getConn()->rollBack();
			}
		}
	}
	/**
	* Define o valor de um campo da tabela
	*
	* @param string $strFieldName
	* @param mixed $value
	*/
	public function setFieldValue($strFieldName,$value=null)
	{
		$objField = $this->getField($strFieldName);
		if( is_object($objField) )
		{
			$objField->value = $value;
		}
		else
		{
			throw new Exception('Invalid field name '.$strFieldName. ' for table '.$this->getTableName() );
		}
	}
	/**
	* Retorna o valor de um campo da tabela
	*
	* @param string $strFieldName
	*/
	public function getFieldValue($strFieldName)
	{
		$objField = $this->getField($strFieldName);
		if( is_object($objField) && isset($objField->value) )
		{
			return $objField->value;
		}
		return null;
	}
	/**
	* Define o(s) campo(s) que serão chave primária da tabela
	*
	* @example
	* $daoPg->setPrimaryKey(array('campo1','campo2'));
	* $daoPg->setPrimaryKey('campo1,campo2');
	*
	* @param mixed $mixFieldName
	*/
	public function setPrimaryKey( $mixFieldName=null )
	{
		$fields 	= $this->getFields();
		if( is_array( $fields ) )
		{
			// remover marcação de chave primaria
			foreach($fields as $k => $objField )
			{
				$objField->primaryKey= 0;
			}
		}
		else
		{
			$this->addField( $mixFieldName );
			$fields 	= $this->getFields();
		}
		if( is_string($mixFieldName))
		{
			if( preg_match('/\,/',$mixFieldName)==1)
			{
				$mixFieldName = explode(',',$mixFieldName );
				$this->setPrimaryKey($mixFieldName);
			}
			else
			{
				$mixFieldName = trim($mixFieldName);
                $this->primaryKeys[$mixFieldName]=true;
				if( $this->getField($mixFieldName) )
				{
					$this->getField($mixFieldName)->primaryKey=1;
				}
			}
		}
		else if( is_array($mixFieldName))
		{
			foreach($mixFieldName as $fieldName)
			{
				$fieldName = trim($fieldName);
                $this->primaryKeys[$fieldName]=true;
				if( $this->getField($fieldName) )
				{
					$this->getField($fieldName)->primaryKey=1;
				}
			}
		}
	}
    /**
    * Retorna o array de campos que fazem parte da chave primária da tabela
    *
    * @return array
    */
	public function getPrimaryKeys()
	{
		$result=array();
		if( $this->getFields())
		{
			foreach($this->getFields() as $fieldName=>$objField)
			{
				if( isset( $objField->primaryKey) && $objField->primaryKey == 1 )
				{
					array_push($result,$objField->fieldName);
				}
			}
		}
		else
		{
			if( is_array($this->primaryKeys) )
			{
				$result = array_keys($this->primaryKeys);
			}
		}
		return $result;
	}
	/**
	* Persiste os valores dos campos definidos com setFieldValue() chamando
	* o método insert ou update
	*
	*/
	public function save()
	{
		$result = false;
		$pks = $this->getPrimaryKeys();
		if( count($pks) > 0 )
		{
			$params=null;
			$where = array();
			foreach($pks as $v)
			{
				$params[$v] = $this->getFieldValue($v);
				if($this->isPDO())
				{
					$where[] = $v.'=?';
				}
				else
				{
					$where[] = $v.' = :'.$v;
				}
			}
			$sql = "select ".$pks[0]." from ".$this->getTableName()." where ".implode(' and ',$where);
			//print_r($params);
			$result = $this->query($sql,$params);
			if( is_array($result) && count($result)>0)
			{
				$result = $this->update();
			}
			else
			{
				$result = $this->insert();
			}
		}
		else
		{
			$result = $this->insert();
		}
		return $result;
	}
	/**
	* Executa o comando insert com os valores definidos nos campos da tabela
	*
	*/
	public function insert()
	{
		$fields=$this->getFields();
		if( is_array( $fields ) )
		{
			$params=null;
			foreach($fields as $fieldName=>$objField)
			{
				if( ! $objField->autoincrement )
				{
					$params[$objField->fieldName] = isset($objField->value) ? $objField->value : null;
				}
			}
		}
		return $this->insertValues($params);
	}
    /**
    * Executa o comando update na tabela
    *
    */
	public function update()
	{
		$fields=$this->getFields();
		if( is_array( $fields ) )
		{
			$params=null;
			foreach($fields as $fieldName=>$objField)
			{
				if( ! $objField->autoincrement )
				{
					$params[$objField->fieldName] = isset($objField->value) ? $objField->value : null;
				}
			}
		}
		return $this->updateValues($params);
	}
    /**
    * Executa o comando delete na tabela
    *
    */
	public function delete()
	{
		return $this->deleteValues();
	}
    /**
    * Executa o comando insert baseado no array de campos e valores recebidos
    *
    * @param mixed $arrFieldValues
    */
    public function insertValues( $arrFieldValues = null )
	{
		if ( !$this->connect() )
		{
			return false;
		}

		try
		{
			$userTransation = $this->getHasActiveTransaction();
			$this->beginTransaction();
			if ( $this->getDbType() != DBMS_ORACLE )
			{
				$sqlInsert      ="insert into " . $this->getTableName() . ' ';
				$valuesClause   =array();
				$params         =array();
				$returningClause='';

				foreach( $arrFieldValues as $fieldName => $fieldValue )
				{
					$fieldName = trim( $fieldName );

					if ( !$this->getAutoincFieldName() || strtolower( $fieldName ) != strtolower( $this->getAutoincFieldName() ) )
					{
						if( ! is_null( $fieldValue ) )
						{
							$params[ $fieldName ]=$fieldValue;
							$valuesClause[]      ='?';
						}
					}
				}
				$columnsClause='(' . implode( ',', array_keys( $params ) ) . ')';
				$valuesClause ='values (' . implode( ',', $valuesClause ) . ')';
				if ( $this->getDbType() == DBMS_POSTGRES && $this->getAutoincFieldName() )
				{
					$returningClause = 'returning ' . $this->getAutoincFieldName();
				}
				$sqlInsert .= trim( ' ' . $columnsClause . ' ' . $valuesClause . ' ' . $returningClause );
				$this->lastId=null;
				$result = self::query( $sqlInsert, $params );
			}
			else
			{
				// oracle
				$sqlInsert   ="insert into " . $this->getTableName() . ' ';
				$valuesClause=array();
				$params      =array();
				$returningFields=array();
				$returningInto=array();
				$descriptors=null;
				foreach( $arrFieldValues as $fieldName => $fieldValue )
				{
					$fieldName = strtolower( trim( $fieldName ) );
					$objField  =$this->getField( $fieldName );

					if ( !$this->getAutoincFieldName() || strtolower( $fieldName ) != strtolower( $this->getAutoincFieldName() ) )
					{
						// valor do campo
						$params[ $fieldName ]=$fieldValue;

						// campo blob
						if ( $objField && strtoupper( $objField->fieldType ) == 'BLOB' )
						{
							$valuesClause[]='empty_blob()';
							array_push( $returningFields, $fieldName );
							array_push( $returningInto, ':' . $fieldName );
						}
						else if( $objField && strtoupper( $objField->fieldType ) == 'CLOB' )
						{
							$valuesClause[]='empty_clob()';
							array_push( $returningFields, $fieldName );
							array_push( $returningInto, ':' . $fieldName );
						}
						else
						{
							$valuesClause[] = ':' . $fieldName;
						}
					}
				}

				$params       =$this->prepareParams( $params, true ); // tratar acentos
				$columnsClause='(' . implode( ',', array_keys( $params ) ) . ')';
				$valuesClause ='values (' . implode( ',', $valuesClause ) . ')';

				if ( $this->getAutoincFieldName() )
				{
					array_push( $returningFields, $this->getAutoincFieldName() );
					array_push( $returningInto, ':' . $this->getAutoincFieldName() );
				}

				$returningClause='';

				if ( count( $returningFields ) > 0 )
				{
					$returningClause = ' returning ' . implode( ',', $returningFields ) . ' into ' . implode( ',', $returningInto );
				}
				$sqlInsert .= $columnsClause . ' ' . $valuesClause . ' ' . $returningClause;
				$stmt=oci_parse( $this->getConn()->connection, $sqlInsert );
				foreach( $params as $fieldName => $fieldValue )
				{
					$objField = $this->getField( $fieldName );

					if ( $objField )
					{
						$bindType=$this->getBindType( $objField->fieldType );
						if ( $bindType == SQLT_CLOB )
						{
							$descriptors[ $fieldName ]=$params[ $fieldName ];
							$params[ $fieldName ]     =oci_new_descriptor( $this->getConn()->connection );
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], -1, SQLT_CLOB );
						}
						else if( $bindType == SQLT_BLOB )
						{
							$descriptors[ $fieldName ]=$params[ $fieldName ];
							$params[ $fieldName ]     =oci_new_descriptor( $this->getConn()->connection );
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], -1, SQLT_BLOB );
						}
						else
						{
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], $objField->size, $bindType );
						}
					}
					else
					{
						oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ] );
					}
				}

				$lastId      =null;
				$this->lastId=null;

				// adicionar o campo autoinc no retorno do insert para capturar o valor gerado
				if ( $this->getAutoincFieldName() )
				{
					oci_bind_by_name( $stmt, ':' . $this->getAutoincFieldName(), $lastId, 20, SQLT_INT );
				}

				if ( !@oci_execute( $stmt, OCI_NO_AUTO_COMMIT ) )
				{
					$e=oci_error( $stmt );
					oci_free_statement( $stmt );

					throw new Exception( 'Insert error ' . $e[ 'message' ] );
				}

				// salvar os campos lobs
				if ( count( $descriptors ) > 0 )
				{
					foreach( $descriptors as $k => $v )
					{
						$params[ $k ]->save( $v );
					}
				}

				if ( $this->getAutoCommit() && ! $userTransation )
				{
					$this->commit();
				}

				oci_free_statement( $stmt );

				if ( $lastId )
				{
					$result[ 0 ][ $this->getAutoincFieldName()] = $lastId;
				}
			}
		}
		catch( Exception $e )
		{
			if( ! $userTransation )
			{
				$this->rollBack();
			}
			$this->setError( $e->getMessage() );
			return false;
		}
		if( $this->getAutoincFieldName() )
		{
			if ( isset($result) && is_array($result) )
			{
				if ( isset( $result[ 0 ][ strtolower( $this->getAutoincFieldName() )] ) )
				{
					$this->lastId = $result[ 0 ][ strtolower( $this->getAutoincFieldName() )];
				}
				else if( isset( $result[ 0 ][ strtoupper( $this->getAutoincFieldName() )] ) )
				{
					$this->lastId = $result[ 0 ][ strtoupper( $this->getAutoincFieldName() )];
				}
			}
			else
			{
				$this->lastId = $this->getLastInsertId();
			}
			$this->setFieldValue($this->getAutoincFieldName(),$this->lastId);
		}

		if( ! $userTransation )
		{
			$this->commit();
		}
		return true;
	}

    /**
    * Executa o comando delete aseado no array de campos e valores recebidos
    * @param mixed $arrFieldValues
    */
	public function deleteValues($arrFieldValues=null)
	{
		if ( !$this->connect() )
		{
			return false;
		}
    	$result = false;
		try
		{
			if ( $this->getDbType() != DBMS_ORACLE )
			{
				$sqlUpdate 		= "delete from " . $this->getTableName();
				$params         = null;
				if( is_array( $arrFieldValues ) )
				{
					foreach( $arrFieldValues as $fieldName => $fieldValue )
					{
						$fieldName = trim( $fieldName );
						$params[ $fieldName ]=$fieldValue;
					    $whereClause[] = $fieldName.' = ?';
					}
				}
				else
				{
					$pks = $this->getPrimaryKeys();
					if( count($pks) == 0 )
					{
						$this->setError('Primary key for table '.$this->getTableName().' not defined!');
						return $result;
					}
					else
	                {
		                $whereClause = null;
   						foreach($pks as $k=>$v)
						{
				            $whereClause[] = $v.' = ?';
				            $params[] = $this->getFieldValue($v);
						}
					}
				}
				if( is_array($params) && is_array($whereClause) )
				{
					$whereClause = implode(' and ',$whereClause);
					$sqlUpdate .= ' where '.$whereClause;
					$result = self::query( $sqlUpdate, $params );
				}
			}
			else
			{
  				// oracle sem PDO
				$sql ="delete from " . $this->getTableName();
				$whereClause = array();
				$params      =null;
				if( is_array($arrFieldValues))
				{
					foreach( $arrFieldValues as $fieldName => $fieldValue )
					{
						$params[ $fieldName ]=$fieldValue;
						$whereClause[] = $fieldName.'=:' . $fieldName;
					}
				}
				else
				{
					// where
					$pks = $this->getPrimaryKeys();
					if( count($pks) == 0 )
					{
						$this->setError('Primary key for table '.$this->getTableName().' not defined!');
						return $result;
					}
					else
	                {
						$whereClause =null;
						foreach($pks as $v)
						{
							$v = strtolower($v);
							$params[$v] = $this->getFieldValue($v);
							$whereClause[] = $v.' = :'.$v;
						}
					}
				}
				$whereClause = 'where '.implode(' and ', $whereClause);
				$sql .= ' '.$whereClause;
				$stmt = oci_parse( $this->getConn()->connection, $sql);
				if( !$stmt)
				{
					$e = oci_error();
					throw new Exception( 'Parse error ' . $e[ 'message' ] );
				}

   				$params = $this->prepareParams( $params, true ); // tratar acentos
				// fazer o bind dos valores aos parametros

				foreach( $params as $fieldName => $fieldValue )
				{
					oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ] );
				}
				if ( !@oci_execute( $stmt, OCI_NO_AUTO_COMMIT ) )
				{
					$e=oci_error( $stmt );
					oci_free_statement( $stmt );
					throw new Exception( 'Update error ' . $e[ 'message' ] );
				}
 				if ( $this->getAutoCommit() )
				{
					$this->commit();
				}
				$result = true;
 				oci_free_statement( $stmt );
			}
		}
		catch(Exception $e)
		{
			$this->setError($e->getMessage());
			return $result;
		}
		return $result;
	}
	/**
	* Executa o comando update baseado no array de campos e valores recebidos
	*
	* @param mixed $arrFieldValues
	*/
	public function updateValues($arrFieldValues=null)
	{
		if ( !$this->connect() )
		{
			return false;
		}
		$result = false;
		try
		{
			$pks = $this->getPrimaryKeys();
			if( ! is_array($pks))
			{
				$this->setError('Primary key for table '.$this->getTableName().' not defined!');
				return $result;
			}

			if ( $this->getDbType() != DBMS_ORACLE )
			{
				$sqlUpdate 		= "update " . $this->getTableName() . ' set ';
				$valuesClause   = array();
				$params         = array();
				foreach( $arrFieldValues as $fieldName => $fieldValue )
				{
					$fieldName = trim( $fieldName );
					if ( !$this->getAutoincFieldName() || strtolower( $fieldName ) != strtolower( $this->getAutoincFieldName() ) )
					{
						//if( ! is_null( $fieldValue ) )
						{
							$params[ $fieldName ]=$fieldValue;
							$valuesClause[]      = $fieldName.'=?';
						}
					}
				}
				$valuesClause = implode( ',', $valuesClause );
                // criar a clausula where
				$sqlUpdate .= trim( $valuesClause );
                if( is_array($pks))
                {
	                $whereClause = array();
   					foreach($pks as $k=>$v)
					{

			            $whereClause[] = $v.' = ?';
			            $params[] = $this->getFieldValue($v);
					}
					$whereClause = implode(' and ',$whereClause);
					$sqlUpdate .= ' where '.$whereClause;
				}
				$result = self::query( $sqlUpdate, $params );
			}
			else
			{
  				// oracle sem PDO
				$sql ="update " . $this->getTableName() . ' set ';
				$valuesClause=array();
				$params      =array();
				$returningFields=array();
				$returningInto=array();
				$descriptors=null;
				foreach( $arrFieldValues as $fieldName => $fieldValue )
				{
					$fieldName = strtolower( trim( $fieldName ) );
					$objField  = $this->getField( $fieldName );
					if ( !$this->getAutoincFieldName() || strtolower( $fieldName ) != strtolower( $this->getAutoincFieldName() ) )
					{
						// valor do campo
						$params[ $fieldName ]=$fieldValue;

						// campo blob
						if ( $objField && strtoupper( $objField->fieldType ) == 'BLOB' )
						{
							$valuesClause[]= $fieldName.'=empty_blob()';
							array_push( $returningFields, $fieldName );
							array_push( $returningInto, ':' . $fieldName );
						}
						else if( $objField && strtoupper( $objField->fieldType ) == 'CLOB' )
						{
							$valuesClause[] = $fieldName.'= empty_clob()';
							array_push( $returningFields, $fieldName );
							array_push( $returningInto, ':' . $fieldName );
						}
						else
						{
							$valuesClause[] = $fieldName.'=:' . $fieldName;
						}
					}
				}
				$valuesClause = implode(',',$valuesClause);
				$sql .= ' '.$valuesClause;

				// where
				$whereClause =array();
				foreach($pks as $v)
				{
					$v = strtolower($v);
					$params['w_'.$v] = $this->getFieldValue($v);
					$whereClause[] = $v.' = :w_'.$v;
				}
				$whereClause = 'where '.implode(' and ', $whereClause);
				$sql .= ' '.$whereClause;

				// returning
				$returningClause='';
				if ( count( $returningFields ) > 0 )
				{
					$returningClause = ' returning ' . implode( ',', $returningFields ) . ' into ' . implode( ',', $returningInto );
				}

				$sql .= ' '.$returningClause;

				$stmt = oci_parse( $this->getConn()->connection, $sql);
				if( !$stmt)
				{
					$e = oci_error();
					throw new Exception( 'Parse error ' . $e[ 'message' ] );
				}

   				$params = $this->prepareParams( $params, true ); // tratar acentos
				// fazer o bind dos valores aos parametros
				foreach( $params as $fieldName => $fieldValue )
				{
					$objField = $this->getField( $fieldName );

					if ( $objField )
					{
						$bindType=$this->getBindType( $objField->fieldType );
						if ( $bindType == SQLT_CLOB )
						{
							$descriptors[ $fieldName ]=$params[ $fieldName ];
							$params[ $fieldName ]     =oci_new_descriptor( $this->getConn()->connection );
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], -1, SQLT_CLOB );
						}
						else if( $bindType == SQLT_BLOB )
						{
							$descriptors[ $fieldName ]=$params[ $fieldName ];
							$params[ $fieldName ]     =oci_new_descriptor( $this->getConn()->connection );
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], -1, SQLT_BLOB );
						}
						else
						{
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], $objField->size, $bindType );
						}
					}
					else
					{
						oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ] );
					}
				}
				if ( !@oci_execute( $stmt, OCI_NO_AUTO_COMMIT ) )
				{
					$e=oci_error( $stmt );
					oci_free_statement( $stmt );

					throw new Exception( 'Update error ' . $e[ 'message' ] );
				}

				// salvar os campos lobs
				if ( count( $descriptors ) > 0 )
				{
					foreach( $descriptors as $k => $v )
					{
						$params[ $k ]->save( $v );
					}
				}
 				if ( $this->getAutoCommit() )
				{
					$this->commit();
				}
				$result = true;
 				oci_free_statement( $stmt );
			}
		}
		catch(Exception $e)
		{
			$this->setError($e->getMessage());
			return $result;
		}
		return $result;
	}
	/**
	* Retorna se já existe ou não uma transação aberta
	*
	*/
	public function getHasActiveTransaction()
	{
		return $this->hasActiveTransaction;
	}
	/**
	* Retorna o último comando sql executado
	*
	*/
	public function getSqlCmd()
	{
		return $this->sqlCmd;
	}
	/**
	* Retorna os parametros recebidos no ultimo comando sql executado
	*
	*/
	public function getSqlParams()
	{
		return $this->sqlParams;
	}

	/**
	* Método mágico para definir/recuperar os valores dos campos no formato
	* setNome_campo(0) e getNome_campo();
	* sem a necessidade de criar um método get e set para cada campo
	*
	* @param mixed $m
	* @param mixed $a
	*/
    function __call($m, $a)
    {
    	if( preg_match('/^set/',$m) == 1 )
    	{
    		$fieldName = substr($m,3);
    		if( $fieldName )
    		{
    			$this->setFieldValue($fieldName, isset( $a[0] ) ? $a[0]:null );
    			return;
			}
		}
		else
		{
    		if( preg_match('/^get/',$m) == 1 )
    		{
    			$fieldName = substr($m,3);
    			if( $fieldName )
    			{
    				return $this->getFieldValue($fieldName);
				}
			}
		}
		throw new Exception( 'Call to Undefined Method/Class Function '.$m );
    }
    /**
    * Manter compatibilidade com a classe TPDOConnection
    * retornando o array no formato $data['COLUNA_TABELA'][LINHA]= VALOR;
    *
    * @param string $sql
    * @param string $params
    */
    function executeSql($sql=null,$params=null){
    	$data   = $this->query($sql,$params);
		$result = ArrayHelper::convertArrayPdo2FormDin($data);
		return $result;
    }

    function getFieldNames() {
    	if( is_array($this->getFields() ))
    	{
    		$arrNames=array();
			foreach( $this->getFields() as $fieldName => $objField ) {
				$arrNames[] = $objField->fieldName;
			}
			return implode(',',$arrNames);
		}
		return '*';
    }
    /**
    * Consulta com retorno no formato de array da Framework FormDin
    *
    * @param mixed $sql
    * @param mixed $params
    * @param mixed $fechMode
    */
    function qfw($sql=null,$params=null,$fechMode=null) {
		$data   = $this->query($sql,$params,$fechMode);
		$result = ArrayHelper::convertArrayPdo2FormDin($data);
		return $result;
    }
}
?>