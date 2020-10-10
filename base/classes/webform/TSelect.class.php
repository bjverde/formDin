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
    * Adicionar campo tipo combobox ou menu select
    *
    * $mixOptions = array no formato "key=>value", nome do pacote oracle e da função a ser executada, comando sql ou tabela|condicao
    * $strKeyColumn = nome da coluna que será utilizada para preencher os valores das opções
    * $strDisplayColumn = nome da coluna que será utilizada para preencher as opções que serão exibidas para o usuário
    * $strDataColumns = informações extras do banco de dados que deverão ser adicionadas na tag option do campo select
    *
    * <code>
    * 	// exemplos
    * 	$frm->addSelectField('tipo','Tipo:',false,'1=Tipo 1,2=Tipo 2');
    * 	$frm->addSelectField('tipo','Tipo:',false,'tipo');
    * 	$frm->addSelectField('tipo','Tipo:',false,'select * from tipo order by descricao');
    * 	$frm->addSelectField('tipo','Tipo:',false,'tipo|descricao like "F%"');
    *
    *  //Exemplo espcial - Campo obrigatorio e sem senhum elemento pre selecionado.
    *  $frm->addSelectField('tipo','Tipo',true,$tiposDocumentos,null,null,null,null,null,null,' ','');
    * </code>
    *
    * @param string $strName       - 01: ID do campo
    * @param mixed  $mixOptions    - 02: array dos valores. no formato "id=>value", nome do pacote oracle e da função a ser executada, comando sql ou tabela|condicao
    * @param mixed $strValue       - 03: Valor DEFAULT, informe o ID do array
    * @param mixed $boolRequired   - 04: Default FALSE = não obrigatori, TRUE = obrigatorio
    * @param mixed $boolMultiSelect- 05: Default FALSE = SingleSelect, TRUE = MultiSelect
    * @param mixed $intSize        - 06: Default 1. Num itens que irão aparecer no MultiSelect
    * @param mixed $intWidth       - 07: Largura em Pixels
    * @param mixed $strFirstOptionText - 08:
    * @param mixed $strFirstOptionValue- 09:
    * @param mixed $strKeyColumn       - 10: Nome da coluna que será utilizada para preencher os valores das opções
    * @param mixed $strDisplayColumn   - 11: Nome da coluna que será utilizada para preencher as opções que serão exibidas para o usuário
    * @param mixed $strDataColumns     - 12: Informações extras do banco de dados que deverão ser adicionadas na tag option do campo select
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
		 parent::__construct($strName
							 ,$mixOptions     // 2: array no formato "key=>value" ou nome do pacote oracle e da função a ser executada
							 ,$strValue       // 3: array no formato "key=>key" para identificar a(s) opção(ões) selecionada(s)
							 ,$boolRequired   // 4: Default FALSE = não obrigatori, TRUE = obrigatorio
							 ,null
							 ,$intWidth
							 ,null
							 ,null
							 ,$boolMultiSelect //09: Default FALSE = SingleSelect, TRUE = MultiSelect
							 ,TOption::SELECT  //10: 10: define o tipo de input a ser gerado. Ex: select, radio ou check
							 ,$strKeyColumn    //11: Nome da coluna que será utilizada para preencher os valores das opções
							 ,$strDisplayColumn//12: Nome da coluna que será utilizada para preencher as opções que serão exibidas para o usuário
							 ,null
							 ,$strDataColumns  //14: informações extras do banco de dados que deverão ser adicionadas na tag option do campo select
							);
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