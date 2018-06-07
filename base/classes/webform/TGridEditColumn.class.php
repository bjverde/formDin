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
class TGridEditColumn extends TGridColumn
{
	private $size;
	private $maxLength;
	private $mask;
	private $editName;
	private $keyValue;
	private $edit;

	/**
	* Implementa coluna para entrada de dados textual no gride
	*
	* @param string $strEditName
	* @param string $strTitle
	* @param string $strFieldName
	* @param string $strDataType
	* @param integer $intSize
	* @param integer $intMaxLength
	* @param string $strMask
	* @param string $strWidth
	* @param string $strAlign
	* @param boolean $boolReadOnly
	* @return TGridEditColumn
	*/
	public function __construct($strEditName
								,$strTitle=null
								,$strFieldName=null
								,$strDataType=null
								,$intSize=null
								,$intMaxLength=null
								,$strMask=null
								,$strWidth=null
								,$strAlign=null
								,$boolReadOnly=null
								){
		
		parent::__construct($strFieldName,$strTitle,$strWidth);
		$this->setId('col_'.strtolower($strEditName));
		$this->setColumnType('edit');
		$this->setSize($intSize);
		$this->setMaxLength($intMaxLength);
		$this->setEditName($strEditName);
		$this->setDataType($strDataType);
		$this->setMask($strMask);
		$this->setClass('fwField');
		$this->setCss('margin','2px');
		$this->setSortable(false);
		$this->edit = new TElement(); // só para guardar o css e eventos quer serão atribuidos so objeto edit quando este for criado.
		/*
		$this->setCss('font-size','12px');
		$this->setCss('font-family','Arial,Times New Roman');
		*/
		$this->setCss('text-align',$strAlign);

		$this->setReadOnly($boolReadOnly);
	}
	public function setSize($intNewValue = null)
	{
		$this->size = (int) $intNewValue;
	}
	public function getSize()
	{
		return $this->size;
	}
	public function setMaxLength($intNewValue = null)
	{
		$intNewValue = is_null($intNewValue) ? $this->getSize() : (int) $intNewValue;
		$this->maxLength = $intNewValue;
	}
	public function getMaxLength()
	{
		return $this->maxLength;
	}
	public function setEditName($strNewValue = null)
	{
		$this->editName = $strNewValue;
	}
	public function getEditName()
	{
		return $this->editName;
	}
	public function setMask($strNewValue = null)
	{
		$this->mask = $strNewValue;
	}
	public function getMask()
	{
		return $this->mask;
	}
	public function getEdit()
	{
		if(!$this->getMask())
        {
       		$edit = new TEdit(strtolower($this->getEditName()).'['.$this->getKeyValue().']',$this->getValue(),$this->getMaxLength(), $this->getSize());
       		$edit->setId(strtolower($this->getEditName().'_'.$this->getRowNum()));
    		$edit->setMaxLenght($this->getMaxLength());
   			$edit->setSize($this->getSize());
		}
		else
		{
       		//$edit = new TMask(strtolower($this->getEditName().'_'.$this->getRowNum()),$this->getValue(),$this->getMask());
       		//$edit = new TMask(strtolower($this->getEditName()).'['.$this->getRowNum().']',$this->getValue(),$this->getMask());
       		$edit = new TMask(strtolower($this->getEditName()).'['.$this->getKeyValue().']',$this->getValue(),$this->getMask());
       		$edit->setId(strtolower($this->getEditName().'_'.$this->getRowNum()));
		}
		// adicionar o nome do campo como attibuto do input
		$edit->setAttribute('fieldname',$this->getFieldName() );

        //$edit->setCss($this->getCss());
		/*if( is_null( $edit->getCss('border') ) )
		{
			$edit->setCss('border','1px solid silver');
		}
        $edit->setEvents($this->getEvents());
        $this->clearEvents();
        */
		// adicionar os eventos da coluna ao campo
		$edit->setEvents($this->getEvents());
        return $edit;
	}
	public function setValue($strNewValue=null)
	{

		// o valor postado tem preferencia sobre o valor do $res
		//if( $_POST &&  $this->getRowNum() > 0 && isset($_POST[$this->getEditName()]) && isset($_POST[$this->getEditName()][$this->getRowNum()]))
		if( preg_match('/text|memo|number/', $this->getDataType()) == 1 )
		{
			if( $_POST &&  $this->getRowNum() > 0 && isset($_POST[$this->getEditName()][$this->getKeyValue()]))
			{

				$strNewValue = $_POST[$this->getEditName()][$this->getKeyValue()];
			}
		}
		parent::setValue($strNewValue);
	}
	//-------------------------------------------------------------------------------------------
	public function setKeyValue($strNewValue=null)
	{
		$this->keyValue = $strNewValue;
	}
	//--------------------------------------------------------------------------------------------
	public function getKeyValue()
	{
		return is_null($this->keyValue)?$this->getRowNum():$this->keyValue;
	}
	//---------------------------------------------------------------------------------------
	public function setCssEdit($mixProperty,$newValue=null)
	{
		$this->edit->setcss($mixProperty,$newValue);
	}
	/**
	* Define o evento e a funcao javascript do campo edit;
	* Se for restritivo e a função executada retornar false, interrompe a execução dos próximos eventos se houver
	*
	* @param string $eventName
	* @param string $functionJs
	* @param boolean $boolRestrictive
	*/
	public function setEventEdit($eventName,$functionJs=null,$boolRestrictive=null)
	{
		$this->edit->setEvent($eventName,$functionJs,$boolRestrictive);
	}
}
?>