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

class TTableArray Extends TElement
{
    private $keyMap = array();
    private $data = null;
    public $thead = null;
    public $tbody = null;

    /**
     * Cria uma tabela HTML
     *
     * @param string $idTableHtml id da tabela
     */
    public function __construct($idTableHtml=null)
    {
        parent::__construct('table');
        $this->setId($idTableHtml);
        $this->thead = new TTablethead();
        parent::add($this->thead);
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
     */
    public function addColumn( $strFieldName, $strValue = null)
    {
        $strValue =  empty($strValue)?$strFieldName:$strValue;
        $this->keyMap[$strFieldName]=$strValue;
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
        return $this->data;
    }
    //---------------------------------------------------------------------------------------
    private function addRowThead() {
        $listKeysMap = array_keys($this->keyMap);
        $listKeys = array_keys($this->data);
        $row = $this->thead->addRow();
        if( empty($listKeysMap) ){
            foreach( $listKeys as $keyName ) {                
                $row->addCell($keyName);
            }
        } else {
            foreach( $listKeys as $keyName ) {                
                if(in_array($keyName,$listKeysMap)) {
                    $row->addCell($this->keyMap[$keyName]);
                }
            }
        }//Fim IF
    }
    //---------------------------------------------------------------------------------------
    private function addRowTBody() {
        $listKeys = array_keys($this->data);
        $firstKey = $listKeys[0];
        foreach( $this->data[$firstKey] as $keyNumber => $value ) {
            $row = $this->addRow();
            foreach( $listKeys as $keyName ) {
                $listKeysMap = array_keys($this->keyMap);
                if( empty($listKeysMap) ){
                    $row->addCell($this->data[$keyName][$keyNumber]);
                } else {
                    if(in_array($keyName,$listKeysMap)) {
                        $row->addCell($this->data[$keyName][$keyNumber]);
                    }
                }
            }
        }
    }
    //---------------------------------------------------------------------------------------
    public function show( $boolPrint = true ) {
        $this->addRowThead();
        $this->addRowTBody();
        return parent::show( $boolPrint );
    }
}