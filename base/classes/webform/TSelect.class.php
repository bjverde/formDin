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

class TSelect extends TOption
{
	private $firstOptionText;
	private $firstOptionValue;

    /**
    * Classe para criação de campos do tipo combobox / menu select
    *
    * @param mixed $strName
    * @param mixed $mixOptions
    * @param mixed $strValue
    * @param mixed $boolRequired
    * @param mixed $boolMultiSelect
    * @param mixed $intSize
    * @param mixed $intWidth
    * @param mixed $strFirstOptionText
    * @param mixed $strFirstOptionValue
    * @param mixed $strKeyColumn
    * @param mixed $strDisplayColumn
    * @param mixed $strDataColumns
    * @return TSelect
    */
    public function __construct($strName
                               ,$mixOptions=null
                               ,$strValue=null
                               ,$boolRequired=null
                               ,$boolMultiSelect=null
                               ,$intSize=null
                               ,$intWidth=null
                               ,$strFirstOptionText=null
                               ,$strFirstOptionValue=null
                               ,$strKeyColumn=null
                               ,$strDisplayColumn=null
                               ,$strDataColumns=null)
    {
         parent::__construct($strName,$mixOptions,$strValue,$boolRequired,null,$intWidth,null,null,$boolMultiSelect,'select',$strKeyColumn,$strDisplayColumn,null,$strDataColumns);
         parent::setSelectSize($intSize);
         $this->setFirstOptionText($strFirstOptionText);
         $this->setFirstOptionValue($strFirstOptionValue);
    }
    public function show($print=true)
    {
    	// adicionar o texto "-- selecione --" como primeira opção, se o campo não for obrigatório
    	if(!$this->getMultiSelect() )
    	{
    		if( is_null($this->getFirstOptionText()) && !$this->getRequired() )
    		{
				$this->setFirstOptionText('-- selecione --');
			}
    		if( !$this->getFirstOptionValue() && !$this->getRequired() )
    		{
				$this->setFirstOptionValue(null);
			}
			$arrTemp=array();
			if($this->getFirstOptionText())
			{
				$arrTemp = array($this->getFirstOptionValue()=>$this->getFirstOptionText());
			}
			if(is_array($this->getOptions()) )
			{
				forEach($this->getOptions() as $k=>$v)
				{
					$arrTemp[$k]=$v;
				}
			}
			$this->setOptions($arrTemp);
		}
		return parent::show($print);
	}

	//---------------------------------------------------------------------------------
    public function setFirstOptionText($strNewValue=null)
    {
		$this->firstOptionText = $strNewValue;
		return $this;
    }
	//---------------------------------------------------------------------------------
    public function getFirstOptionText()
    {
		return $this->firstOptionText;
    }
	//---------------------------------------------------------------------------------
	public function setFirstOptionValue($strNewValue=null)
    {
		$this->firstOptionValue = $strNewValue;
		return $this;
    }
	//---------------------------------------------------------------------------------
    public function getFirstOptionValue()
    {
		return $this->firstOptionValue;
    }
    // Retorna o texto da opção selecionada do combobox
    public function getText($strKeyValue=null)
    {
   		$strKeyValue =  ( is_null( $strKeyValue ) ) ? $this->getValue() : $strKeyValue ;
    	if(!$this->getMultiSelect() )
    	{
			//if( !is_null($this->getValue() ) )
			if( !is_null($strKeyValue ) )
			{
				$aTemp = $this->getOptions();
				return $aTemp[$strKeyValue];
				//return $aTemp[$this->getValue()];
			}
		}
		else
		{
			$result=null;
			if( is_array($strKeyValue))
			{
				$aTemp = $this->getOptions();
				forEach( $strKeyValue as $k )
				{
					$result[] = $aTemp[$k];
				}
			}
			return $result;
		}
    }
}
?>