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

//------------------------------------------------------------------------------
class TLink extends TControl
{
	private $onClick = null;
	private $url	 = null;
	private $target	 = null;
	public function __construct($strName,$strValue=null,$strOnClick=null,$strUrl=null,$strTarget=null,$strHint=null)
	{
		parent::__construct('div',$strName,$strValue);
		parent::setFieldType('link');
		parent::setValue($strValue);
		parent::setClass('fwLink');
		$this->setOnClick($strOnClick);
		$this->seturl($strUrl);
		$this->setTarget($strTarget);
		$this->setHint($strHint);

	}
	//--------------------------------------------------------------------
	public function show($print=true)
	{
		$this->clearChildren();
		$this->add($this->getValue());
		$this->setValue(null);
		return parent::show($print);
	}
	//---------------------------------------------------------------------
	public function setOnClick($strFunctionJs=null)
	{
		$this->onClick = $strFunctionJs;
	}
	//---------------------------------------------------------------------
	public function getOnClick()
	{
		return $this->onClick;
	}
	//---------------------------------------------------------------------
	public function setUrl($strUrl=null)
	{
		$this->url = $strUrl;
	}
	//---------------------------------------------------------------------
	public function getUrl()
	{
		return $this->url;
	}
	//---------------------------------------------------------------------
	public function setTarget($strTarget=null)
	{
		$this->target = $strTarget;
	}
	//---------------------------------------------------------------------
	public function getTarget()
	{
		if(is_null($this->target))
		{
			return '_blank';
		}
		return $this->target;
	}
	//----------------------------------------------------------------------
	public function getValue()
	{
		$e = new TElement('a');
		$e->add($this->value);
		if( $this->getEnabled() )
		{
			if($this->getOnClick())
			{
				$e->addEvent('onclick',$this->getOnClick());
				$e->setProperty('href','javascript:void(0);');
				return $e->show(false);
			}
			else if( $this->getUrl() )
			{
				$e->setProperty('href',$this->getUrl());
				$e->setProperty('target',$this->getTarget());
				return $e->show(false);
			}
		}
		return $this->value;
	}
}
?>