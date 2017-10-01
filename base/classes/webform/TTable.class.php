<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
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

class TTable Extends TElement
{
	public function __construct($strName=null)
	{
		parent::__construct('table');
		$this->setId($strName);
	}

	//------------------------------------------------------------------
	public function addRow($strId=null)
	{
		$row = new TTableRow();
		$row->setId($strId);
		parent::add($row);
		return $row;
	}
}
//------------------------------------------------------------------------
class TTableRow extends TElement
{
	private $visible;
	public function __construct()
	{
		parent::__construct('tr');
		$this->setVisible(true);
	}
	//------------------------------------------------------------------
	public function addCell($value=null,$strId=null)
	{
		$cell = new TTableCell($value);
		$cell->setId($strId);
		parent::add($cell);
		return $cell;
	}
	public function setVisible($boolNewValue=null)
	{
		$boolNewValue = is_null($boolNewValue) ? true :$boolNewValue;
		$this->visible = $boolNewValue;
	}
	public function getVisible()
	{
		return $this->visible;
	}
	public function show($print=true)	{
		if($this->getVisible())
		{
			return parent::show($print);
		}
		return null;
	}
}

//------------------------------------------------------------------------
class TTableCell extends TElement
{
	public function __construct($value=null)
	{
		parent::__construct('td');
		parent::add($value);
	}
	public function getValue()
	{
		if( $this->getChildren())
		{
			$children = $this->getChildren();
			if( is_object($children[0] ) )
			{
				return '';
			}
			return implode('',$this->getChildren());
		}
		return '';
	}
	public function setValue($newValue=null)
	{
		$this->clearChildren();
		$this->add($newValue);
	}
}
/*
//------------------------------------------------------------------------------------
$tb = new TTable;
$tb->border=1;
$tb->width=300;

$row = $tb->addRow();
$row->bgColor="#efefef";
	$cell = $row->addCell('celula 1');
	$cell->colspan=5;
	$cell->align="center";
$row = $tb->addRow();

$row->bgColor="green";
	$cell = $row->addCell('celula 1');
	$cell = $row->addCell('celula 1');
	$cell = $row->addCell('celula 1');
	$cell = $row->addCell('celula 1');
	$cell = $row->addCell('celula 1');
$tb->show();
*/
?>