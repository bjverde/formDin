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
class TGridColumnCompact extends TGridColumn
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
	private $strMaxTextLength;

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
	public function __construct($strFieldName=null,$strTitle=null,$strWidth=null,$strTextAlign=null,$boolReadOnly=null,$boolSortable=null,$boolVisible=null,$strMaxTextLength=null)
	{
		$this->clearCss();
		$this->setId(strtolower($strFieldName));
		$this->setFieldName($strFieldName);
		$this->setWidth($strWidth);
		$this->setTitle($strTitle);
		$this->setColumnType('columncompact');
		$this->setHeaderAlign('center');
		$this->setTextAlign($strTextAlign);
		$this->header = new TLabel($this->getId(),$strTitle);
		$this->header->clearCss();
		$this->setReadOnly($boolReadOnly);
		$this->setSortable($boolSortable);
		$this->setVisible($boolVisible);
		$this->setMaxTextLength($strMaxTextLength);
	}

	public function setMaxTextLength($strMaxTextLength)
	{
	    $this->strMaxTextLength = $strMaxTextLength;
	    return $this;
	}

	public function getMaxTextLength()
	{
	    return $this->strMaxTextLength;
	}
	
	public function getHeader()
	{
	    if( $this->getSortable() && $this->getColumnType() != 'action' )
	    {
	        $this->header->setClass('fwGridHeaderSortable');
	    }
	    return $this->header;
	}
}
?>