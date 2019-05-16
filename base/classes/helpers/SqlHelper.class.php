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

if(!defined('ROWS_PER_PAGE')) { define('ROWS_PER_PAGE', 20); 
}

class SqlHelper
{
	const SQL_TYPE_NUMERIC    = 'numeric';
	const SQL_TYPE_TEXT_LIKE  = 'like';
	const SQL_TYPE_TEXT_EQUAL = 'text';
	const SQL_TYPE_IN_TEXT    = 'text with IN';
	const SQL_TYPE_IN_NUMERIC    = 'text with IN';
	
	const SQL_CONNECTOR_AND = ' AND ';
	const SQL_CONNECTOR_OR  = ' OR ';
	
	private static $dbms;	
	
	public static function setDbms($dbms)
	{
	    self::$dbms = $dbms;	    
	}
	public static function getDbms()	
    {
        $dbms =  null;
        if ( !empty(self::$dbms) ){
            $dbms = self::$dbms;
        } else {
            $dbms = BANCO;
        }
        return $dbms;
    }
    //--------------------------------------------------------------------------------
    public static function getRowStart($page,$rowsPerPage) 
    {
        $rowStart = 0;
        $page = isset($page) ? $page : null;
        $rowsPerPage = isset($rowsPerPage) ? $rowsPerPage : ROWS_PER_PAGE;
        if(!empty($page)) {
            $rowStart = ($page-1)*$rowsPerPage;
        }        
        return $rowStart;
    }
    //--------------------------------------------------------------------------------
    public static function attributeIsset($attribute,$isTrue,$isFalse)
    {
        $retorno = $isFalse;
        if(isset($attribute) && ($attribute<>'') ){
            if( $attribute<>'0' ){
                $retorno = $isTrue;
            }
        }
        return $retorno;
    }
    //--------------------------------------------------------------------------------
    public static function attributeIssetOrNotZero($whereGrid,$attribute,$isTrue,$isFalse,$testZero=true)
    {
        $retorno = $isFalse;
        $has = ArrayHelper::has($attribute, $whereGrid);
        if($has ) {
            if(isset($whereGrid[$attribute]) && !($whereGrid[$attribute]==='') ) {
                if($testZero) {
                    if($whereGrid[$attribute]<>'0' ) {
                        $retorno = $isTrue;
                    }
                }else{
                    $retorno = $isTrue;
                }
            }
        }
        return $retorno;
    }
    //----------------------------------------
    public static function transformValidateString( $string ) {        
        if ( self::getDbms() == DBMS_MYSQL ) {
            //$string = addslashes($string);
            //$patterns = '/(%)/';
            $doubleQuotes = chr(34);
            $patterns = '/(%|\'|"|'.$doubleQuotes.')/';
            $replacements = '\\\$1';
            $string = preg_replace($patterns, $replacements, $string);
        } else {
            if ( preg_match('/(\'|")/', $string ) > 0 ) {
                throw new InvalidArgumentException('Não use aspas simples ou duplas na pesquisa !');
            }
        }
        return $string;
    }
    //----------------------------------------
    /**
     * Replace spaces with % to make it easier to search with like.
     * 
     * Substitua os espaços por % para facilitar a busca com like.
     * 
     * @param string $string
     * @return string`
     */
    public static function explodeTextString( $string ) {
        $dataBaseWithLike = (self::getDbms() == DBMS_MYSQL) || (self::getDbms() == DBMS_POSTGRES) || (self::getDbms() == DBMS_SQLITE) || (self::getDbms() == DBMS_SQLSERVER);
        if ( $dataBaseWithLike ) {
            $string = trim($string);
            $string = preg_replace('/\s/', '%', $string);
        }
        return $string;
    }
    
    /***
     * Return string sql for query with numeric
     * @param string $stringWhere
     * @param array $arrayWhereGrid
     * @param string $atribute
     * @param string $type
     * @param boolean $testZero
     * @param string $value
     * @param string $connector
     * @return string
     */
    public static function getSqlTypeNumeric( $stringWhere
                                            , $arrayWhereGrid
                                            , $attribute
                                            , $type
                                            , $testZero=true
                                            , $value
                                            , $connector=self::SQL_CONNECTOR_AND
                                            ) {
        $isTrue = ' AND '.$attribute.' = '.$value.'  ';
        $attribute = self::attributeIssetOrNotZero($arrayWhereGrid,$attribute,$isTrue,null,$testZero);
        $stringWhere = $stringWhere.$attribute;
        return $stringWhere;
    }
    public static function getSqlTypeTextLike( $stringWhere
                                             , $arrayWhereGrid
                                             , $attribute
                                             , $type
                                             , $testZero=true
                                             , $value
                                             , $connector=self::SQL_CONNECTOR_AND
                                             ) {
            $value = self::explodeTextString($value);
            $isTrue = ' AND '.$attribute.' like \'%'.$value.'%\' ';
            $attribute = self::attributeIssetOrNotZero($arrayWhereGrid,$attribute,$isTrue,null,$testZero);
            $stringWhere = $stringWhere.$attribute;
            return $stringWhere;
    }
    public static function getSqlTypeText( $stringWhere
                                         , $arrayWhereGrid
                                         , $attribute
                                         , $type
                                         , $testZero=true
                                         , $value
                                         , $connector=self::SQL_CONNECTOR_AND
                                         ) {
            $isTrue = ' AND '.$attribute.' = \''.$value.'\'  ';
            $attribute = self::attributeIssetOrNotZero($arrayWhereGrid,$attribute,$isTrue,null,$testZero);
            $stringWhere = $stringWhere.$attribute;
            return $stringWhere;
    }
    //----------------------------------------
    public static function getAtributeWhereGridParameters( $stringWhere, $arrayWhereGrid, $attribute, $type ,$testZero=true ) {
        if( ArrayHelper::has($attribute, $arrayWhereGrid) ){
    	    $value = $arrayWhereGrid[$attribute];
    	    if ( !empty($value) ){
    		    $value = self::transformValidateString($value);
    		}
    		
    		switch ($type) {
    		    case self::SQL_TYPE_NUMERIC:
    		        $stringWhere = self::getSqlTypeNumeric($stringWhere, $arrayWhereGrid, $attribute, $type, $testZero ,$value, self::SQL_CONNECTOR_AND);
    		    break;
    		    case self::SQL_TYPE_TEXT_LIKE:
    		        $stringWhere = self::getSqlTypeTextLike($stringWhere, $arrayWhereGrid, $attribute, $type, $testZero ,$value, self::SQL_CONNECTOR_AND);
    		    break;
    		    case self::SQL_TYPE_TEXT_EQUAL:
    		        $stringWhere = self::getSqlTypeText($stringWhere, $arrayWhereGrid, $attribute, $type, $testZero ,$value, self::SQL_CONNECTOR_AND);
    		    break;
    		}
    	}
    	return $stringWhere;
    }
    
}
?>
