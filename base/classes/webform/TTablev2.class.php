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

class TTablev2 Extends TElement
{
    private $data;

    /**
     * Cria uma tabela HTML
     *
     * @param string $idTableHtml id da tabela
     */
    public function __construct($idTableHtml=null)
    {
        parent::__construct('table');
        $this->setId($idTableHtml);
    }

    //------------------------------------------------------------------
    public function addRow($strId=null)
    {
        $row = new TTableRow();
        $row->setId($strId);
        parent::add($row);
        return $row;
    }


    //------------------------------------------------------------------------------------
    /**
     * Coluna normal para o grid
     * @param string $strFieldName 1: ID da coluna = Nome da coluna da tabela
     * @param string $strValue     2: Nome do Label que irá aparecer 
     * @param integer $strWidth    3: tamanho da coluna
     * @param string $strTextAlign 4: Alinhamento do texto left|right|center|justify
     * @return TGridColumn
     */
    public function addColumn( $strFieldName, $strValue = null)
    {
        $col = new TGridColumn( $strFieldName, $strValue, $strWidth, $strTextAlign );
        $col->clearCss();
        $col->setGridId($this->getId());
        $this->columns[ $col->getId()] = $col;
        return $col;
    }

    //------------------------------------------------------------------------------------
    public function setData( $mixValue = null ){
        if ( !is_array( $mixValue ) ) {
            ValidateHelper::isArray($mixValue,__METHOD__,__LINE__);
        }else{
            $keys = array_keys($mixValue);
            if ( empty($keys) ) {
                $mixValue = null;
            }
        }
        $this->data = $mixValue;
    }
    
    //---------------------------------------------------------------------------------------
    /**
     * Retorna o array de dados do gride
     */
    public function getData() {
        $res = null;
        
        if ( is_array( $this->data ) ) {
            $keys = array_keys( $this->data );
            if( ! is_array($this->data[$keys[0]] ) || isset($this->data[$keys[0]][0] ) ) {
                return $this->data;
            }
            return $this->data;
        }
        else if( strpos( strtolower( $this->data ), 'select ' ) !== false ) {
            
            $bvars = null;
            $bvars = $this->getBvars();
            
            if ( function_exists( 'recuperarPacote' ) )
            {
                $cache = $this->getCache();
                print_r( $GLOBALS[ 'conexao' ]->executar_recuperar( $this->data, $bvars, $res, $cache ) );
            }
            else if( !class_exists( 'TPDOConnection' ) || !TPDOConnection::getInstance() )
            {
                $res = TPDOConnection::executeSql( $this->data );
            }
        }
        //else if( strpos(strtolower($this->data),'pk_') !== false || strpos(strtolower($this->data),'pkg_') !== false )
        else if( preg_match( '/\.PK\a?/i', $this->data ) > 0 )
        {
            $bvars = $this->getBvars();
            $cache = $this->getCache();
            print_r( recuperarPacote( $this->data, $bvars, $res, $cache ) );
        }
        else if( !is_null( $this->data ) )
        {
            $where = '';
            
            if ( is_array( $this->getBvars() ) )
            {
                foreach( $this->getBvars() as $k => $v )
                {
                    $where .= $where == '' ? '' : ' and ';
                    $where .= "($k='$v')";
                }
                $where = $where == '' ? '' : ' where ' . $where;
            }
            $sql = "SELECT * FROM {$this->data} {$where}";
            $cache = $this->getCache();
            $bvars = null;
            
            if ( function_exists( 'recuperarPacote' ) )
            {
                print_r( $GLOBALS[ 'conexao' ]->executar_recuperar( $sql, $bvars, $res, $cache ) );
            }
            else if( !class_exists( 'TPDOConnection' ) || !TPDOConnection::getInstance() )
            {
                $res = TPDOConnection::executeSql( $sql );
            }
        }
        
        if ( $res ) {
            $this->setData( $res );
        }
        return $res;
    }
}