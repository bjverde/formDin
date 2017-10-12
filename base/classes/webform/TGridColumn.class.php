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
 * Este programa é distribuí1do na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licen?a Pública Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

class TGridColumn extends TElement
{
	private $fieldName;
	private $title;
	private $width;
	private $columnType;
	private $headerAlign;
	private $textAlign;
	private $rowNum;
	private $header;
	private $readonly;
	private $sortable;
	private $dataType;
	private $colIndex;
	private $noWrap;
	private $gridId;
	private $visible;

	/**
	* Classe para construir as colunas no gride
	*
	* @param string $strFieldName
	* @param string $strTitle
	* @param string $strWidth
	* @param string $strTextAlign
	* @param boolean $boolReadOnly
	* @param boolean $boolSortable
	* @param boolean $boolVisivle
	* @return TGridColumn
	*/
	public function __construct($strFieldName=null,$strTitle=null,$strWidth=null,$strTextAlign=null,$boolReadOnly=null,$boolSortable=null,$boolVisible=null)
	{
		parent::__construct('span');
		$this->clearCss();
		$this->setId(strtolower($strFieldName));
		$this->setFieldName($strFieldName);
		$this->setWidth($strWidth);
		$this->setTitle($strTitle);
		$this->setColumnType('plain');
		$this->setHeaderAlign('center');
		$this->setTextAlign($strTextAlign);
		$this->header = new TLabel($this->getId(),$strTitle);
		$this->header->clearCss();
		$this->setReadOnly($boolReadOnly);
		$this->setSortable($boolSortable);
		$this->setVisible($boolVisible);
	}
	//-----------------------------------------------------------------------------------------
	public function setFieldName($strFieldName)
	{
		$this->fieldName = $strFieldName;
		return $this;
	}
	//-----------------------------------------------------------------------------------------
	public function getFieldName()
	{
		return $this->fieldName;
	}
	//---------------------------------------------------------------------------------------
    public function show($boolPrint=true)
    {
    }
	//---------------------------------------------------------------------------------------
	public function setTitle($strNewValue=null)
	{
		$this->title = $strNewValue;
		return $this;
	}
	//---------------------------------------------------------------------------------------
	public function getTitle()
	{
		return $this->title;
	}
	//---------------------------------------------------------------------------------------
	public function setWidth($strNewValue=null)
    {
    	$this->width = $strNewValue;
    	return $this;
    }
	//---------------------------------------------------------------------------------------
	public function getWidth()
	{
		if(is_null($this->width))
		{
			return 'auto';
		}
		else
		{
			if( strpos($this->width,'%')===false )
			{
				$w = @preg_replace('/[^0-9]/','',$this->width).'px';
	            $w = $w == 'px' ? 'auto' : $w;
			}
			else
			{
				return $this->width;
			}
		}
		return $w;
	}
	//---------------------------------------------------------------------------------------
	public function setColumnType($strNewValue)
	{
		$this->columnType = strtolower($strNewValue);
		return $this;
	}
	//---------------------------------------------------------------------------------------
	public function getColumnType()
	{
		return $this->columnType;
	}
	//---------------------------------------------------------------------------------------
	public function setRowNum($intNewValue=null)
	{
		$this->rowNum = $intNewValue;
		return $this;
	}
	//---------------------------------------------------------------------------------------
	public function getRowNum()
	{
		return $this->rowNum;
	}
	//----------------------------------------------------------------------------------------
	public function setHeaderAlign($strNewValue=null)
	{
		$this->headerAlign = $strNewValue;
		return $this;
	}
	//----------------------------------------------------------------------------------------
	public function getHeaderAlign()
	{
		return is_null( $this->headerAlign ) ? 'center' : $this->headerAlign;
	}
	//-----------------------------------------------------------------------------------------
	public function getHeader()
	{
		/*
		if($this->getDataType() == 'checkbox')
		{
			 if($this->getAllowCheckAll())
			 {
			 	$tb = new TTable('chk_'.$this->getId().'_table');
			 	$tb->setClass('fwGridHeader');
			 	$tbr= $tb->addRow();
			  	$chk = new TElement('input');
			  	$chk->setProperty('type','checkbox');
			  	$chk->setId('chk_'.$this->getId().'_header');
			  	$chk->setCss('cursor','pointer');
			  	//$chk->setCss('float','left');
			  	//$chk->setCss('clear','both');
			  	$chk->setProperty('title','marcar/desmarcar todos');
			  	$chk->addEvent('onclick',"fwGridCheckUncheckAll(this,'{$this->getEditName()}')");
			  	$tbr->addCell($chk);
			  	$tbr->addCell($this->header->getValue());
			  	$tb = $tb->show(false);
			  	//$this->header->add($tb);
				$this->header->setValue($tb);
			 }
		}
		else */
		if( $this->getSortable() && $this->getColumnType() != 'action' )
		{
			//<a href="#" title="Ordenar coluna" style="cursor:pointer;" class="sortheader" onclick="ts_resortTable(this, 0);return false;">Nº<span sortdir="up" class="sortarrow"></span></a></
			//$a = '<a href="javascript:void(0);" title="Ordenar coluna" style="cursor:pointer" class="sortheader" onClick="ts_resortTable(this,'.$this->getColIndex().');jQuery(\'#'.$this->getGridId().'_sorted_column\').val(\''.$this->getFieldName().'\');jQuery(\'#'.$this->getGridId().'_sorted_column_order\').val(jQuery(this).find(\'span\').attr(\'sortdir\'));return false;">'.$this->header->getValue().'<span sortdir="up" class="sortarrow"></span></a>';
			//$this->header->setValue($a);
			//$this->header->setCss( array('color'=>'#3661F1','text-decoration'=>'underline'));
			$this->header->setClass('fwGridHeaderSortable');
		}
		return $this->header;
	}
	//-----------------------------------------------------------------------------------------
	public function setReadOnly($boolNewValue=null)
	{
		$this->readonly = $boolNewValue;
		return $this;
	}
	//-----------------------------------------------------------------------------------------
	public function getReadOnly()
	{
		return (bool) $this->readonly;
	}
	//-------------------------------------------------------------------------------------------
	public function setTextAlign($strNewValue=null)
	{
		$this->textAlign = $strNewValue;
		return $this;
	}
	//-------------------------------------------------------------------------------------------
	public function getTextAlign()
	{
		return $this->textAlign;
	}
	//-------------------------------------------------------------------------------------------
	public function setSortable($boolNewValue=null)
	{
		$this->sortable = $boolNewValue;
		return $this;
	}
	//-------------------------------------------------------------------------------------------
	public function getSortable()
	{
		return is_null($this->sortable) ? true : $this->sortable;
	}
	//------------------------------------------------------------------------
	public function setDataType($newDataType=null)
	{
		$this->dataType = $newDataType;
		return $this;
	}
	//------------------------------------------------------------------------
	public function getDataType()
	{
		if( is_null($this->dataType))
		{
			return 'text';
		}
		return $this->dataType;
	}
	//
	public function setColIndex($newValue=null)
	{
		$this->colIndex = (int) $newValue;
		return $this;
	}
	public function getColIndex()
	{
		 return (int)$this->colIndex;
	}
	public function setNoWrap($boolNewValue=null)
	{
		$this->noWrap = $boolNewValue;
		return $this;
	}
	public function getNoWrap()
	{
		return ($this->noWrap === true ) ? true : $this->noWrap;
	}
	public function setGridId($strNewValue=null)
	{
		$this->gridId = $strNewValue;
	}
	public function getGridId()
	{
		return $this->gridId;
	}
	public function setVisible($boolNewValue=null)
	{
		$this->visible = $boolNewValue;
	}
	public function getVisible()
	{
		return ( $this->visible === false ) ? false : true;
	}
}
?>