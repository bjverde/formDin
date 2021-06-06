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
class TGridNumberColumn extends TGridEditColumn
{
	private $decimalPlaces;
	private $formatInteger;
	/**
	* Implementa coluna para entrada de dados num?rica
	*
	*
	* @param string $strEditName
	* @param string $strTitle
	* @param string $strFieldName
	* @param integer $intSize
	* @param integer $intDecimalPlaces
	* @param boolean $boolFormatInteger
	* @param string $strWidth
	* @param string $strAlign
	* @param boolean $boolReadOnly
	* @return TGridNumberColumn
	*/
	public function __construct(string $strEditName
	                           ,string $strTitle=null
							   ,string $strFieldName=null
							   ,string $intSize
							   ,$intDecimalPlaces=null,$boolFormatInteger=null,$strWidth=null,$strAlign=null,$boolReadOnly=null)
	{
		parent::__construct($strEditName,$strTitle,$strFieldName,'number',$intSize,$intSize,null,$strWidth,$strAlign,$boolReadOnly);
		$this->setDecimalPlaces($intDecimalPlaces);
		$this->setFormatInteger($boolFormatInteger);
	}
	//---------------------------------------------------------------------------------------------------
	public function getEdit()
	{
	 	$edit = new TNumber($this->getEditName().'['.$this->getKeyValue().']',$this->getValue(),$this->getSize(),false,$this->getDecimalPlaces(),null,null,$this->getFormatInteger());
	 	$edit->setId($this->getEditName().'_'.$this->getRowNum());
     	$edit->setExampleText(''); // n?o exibir o texto exemplo na frente do campo
        $edit->setCss($this->getCss());
		if( is_null( $edit->getCss('border') ) )
		{
			$edit->setCss('border','1px solid silver');
		}
        $edit->setEvents($this->getEvents());

		// adicionar o nome do campo como attibuto do input
		$edit->setAttribute('fieldname',$this->getFieldName() );
        return $edit;
	}
	//---------------------------------------------------------------------------------------------------
	public function setDecimalPlaces($intNewValue=null)
	{
		$this->decimalPlaces = $intNewValue;
	}
	public function getDecimalPlaces()
	{
		return $this->decimalPlaces;
	}
	//---------------------------------------------------------------------------------------------------
	public function setFormatInteger($boolNewValue=null)
	{
		$this->formatInteger = $boolNewValue;
	}
	public function getFormatInteger()
	{
		return $this->formatInteger;
	}
}
?>