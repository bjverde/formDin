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
class TDb
{
	private static $conn	= array();
	private static $dbType 	= null;

	// construtor
	private function __construct()
	{
	}
	//------------------------------------------------------------------------------------------
	private function __clone()
	{
	}
	public static function setDbType( $newType = null )
	{
		self::$dbType = $newType;
	}
	public static function getDbType()
	{
		return self::$dbType;
	}
	//------------------------------------------------------------------------------------------
	public static function sql($sql=null,$arrParams=null,$fetchMode=null,$dbType=null)
	{
		$fetchMode = is_null($fetchMode) ? PDO::FETCH_ASSOC : $fetchMode;
		if( is_null( self::$dbType ) && defined('DEFAULT_DBMS' ) ) {
			self::$dbType = DEFAULT_DBMS;
		}
		$dbType = is_null($dbType) ? self::$dbType : $dbType;
		if( ! $dbType ) {
			throw new Exception("Necessário informar o tipo do banco de dados. Ex:TDb::setDbType('mysql'); ou defina a constante DEFAULT_DBMS. ex:define('DEFAULT_DBMS','mysql');");
		}
		if( is_null( self::$dbType ) ) {
			self::$dbType = $dbType;
		}
		try {
			if( array_key_exists( $dbType, self::$conn ) ) {
				$conn = self::$conn[$dbType];
			} else {
				$conn = TConnection::connect($dbType);
				if( !array_key_exists( $dbType, self::$conn ) ){
					self::$conn[$dbType] = $conn;
				}
			}
		}
		catch( Exception $e ) {
			throw new Exception("<br><h3>Erro de conexão</h3>".$e->getMessage().'<br>');
		}
		$result=null;
		try {
			if( !$sql) {
				return null;
			}
			$sql = trim($sql);
			if( $stmt = $conn->prepare( $sql ) ) {
				if( $result = $stmt->execute( (array) $arrParams ) ) {
					try {
						$data = $stmt->fetchAll( $fetchMode );
						if( preg_match('/^select/i',$sql ) > 0 ) {
							$result = $data;
						}
					} catch(Exception $e) {
						return $result;
					}
				}
			}
		}
		catch( Exception $e ) {
			$erro = "<h3>Erro de SQL</h3>".$sql.'<br><br>';
			if( $arrParams )
			{
				$erro .= '<b>Parametros:</b><br>';
				$erro .= print_r($arrParams,true);
				$erro .= '<br><br>';
			}
			$erro .= '<b>Mensagem:</b><br>'.$e->getMessage();
			throw new Exception($erro);
		}
		return $result;
	}
}
?>