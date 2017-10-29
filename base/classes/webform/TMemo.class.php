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

/**
* Classe para implementar campos de entrada de dados de varias linhas (textareas)
*
*/
class TMemo extends TEdit
{
	private $showCounter;
	private $onlineSearch;
	public function __construct($strName,$strValue=null,$intMaxLength,$boolRequired=null,$intColumns=null,$intRows=null,$boolShowCounter=null)
	{
		parent::__construct($strName,$strValue,$intMaxLength,$boolRequired);
		parent::setTagType('textarea');
		parent::setFieldType('memo');
		$this->setColumns($intColumns);
		$this->setRows($intRows);
		$this->setShowCounter($boolShowCounter);
		$this->setProperty('wrap','virtual'); //Physical, off
	}
	public function show($print=true)
	{
		$this->setProperty('size',null);
		if((string)trim($this->getValue())!="")
		{
			$this->add($this->getValue());
		}
		$this->value=null;
		// adicionar o evento de validação de tamanho
		$this->addEvent('onkeyup','fwCheckNumChar(this,'.$this->maxlength.')');
		// remover os caracteres ENTER deixando somente as quebras de linhas
		$this->addEvent('onBlur','fwRemoverCaractere(this,13);this.onkeyup();');

		// se for para mostrar o contador de caracteres, criar um div externo
		if($this->getShowCounter())
		{
			$div = new TElement('div');
			$div->setId($this->getId().'_div');
			$div->setCss('display','inline');
			$div->add( parent::show(false).$this->getOnlineSearch());
			$counter = new TElement('span');
			$counter->setId($this->getId().'_counter');
			$counter->setCss('border','none');
			$counter->setCss('font-size','11');
			$counter->setCss('color','#00000');
			$div->add('<br>');
			$div->add($counter);
			$script=new TElement('<script>');
			$script->add('// inicializar o contador de caracteres.');
			$script->add('fwGetObj("'.$this->getId().'").onkeyup();');
			$div->add($script);
			return $div->show($print);
		}
		else
		{
			return parent::show($print).$this->getOnlineSearch();
		}
	}
	public function setColumns($intNewValue=null)
	{
		$intNewValue = is_null($intNewValue) ? 50 : $intNewValue;
		$this->setProperty('cols',$intNewValue);
	}
	public function getColumns()
	{
		return $this->getProperty('cols');
	}
	public function setRows($intNewValue=null)
	{
		$intNewValue = is_null($intNewValue) ? 5 : (int) $intNewValue;
		$this->setProperty('rows',$intNewValue);
	}
	public function getRows()
	{
		return $this->getProperty('rows');
	}
	public function setShowCounter($boolShow=null)
	{
		$boolShow = is_null($boolShow) ? true : (bool) $boolShow;
		$this->showCounter = $boolShow;
	}
	public function getShowCounter()
	{
		return $this->showCounter;
	}
	public function clear()
	{
		$this->clearChildren();
		parent::clear();
	}
	public function setOnlineSearch($strNewValue=null)
	{
		$this->onlineSearch = $strNewValue;
	}
	public function getOnlineSearch()
	{
		return $this->onlineSearch;
	}

}
/*
return;
$memo = new TMemo('obs_exemplo','Luis',500,false,50,10);
$memo->setValue('Luis Eugênio Barbosa, estou lhe enviando este e-mail para confirmar se o precos da propsota está de acordo com o que combinamos ontem.');
$memo->show();
*/
?>