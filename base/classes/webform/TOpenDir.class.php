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

/**
* Classe base para seleção de diretórios
*/
class TOpenDir extends TEdit
{
	private $btnOpen;
	private $rootDir;
	private $title;
	private $callback;
	public function __construct($strName, $strRootDir=null, $strValue=null, $intMaxLength=null, $boolRequired=null, $intSize=null, $strTitle=null, $strJsCallBack=null )
	{
		$intSize = is_null($intSize) ? '60' : $intSize;
		$intMaxLength = is_null( $intMaxLength) ? $intSize : $intMaxLength;
		parent::__construct($strName, $strValue, $intMaxLength, $boolRequired, $intSize );
		$this->setFieldType('opendir');
		$strRootDir = is_null($strRootDir) ? './' : $strRootDir;
		$this->setHint('Selecionar - Clique duas vezes para abrir a caixa de dialogo!');
		$this->setReadOnly(true);
		$this->setRootDir($strRootDir);
		$this->btnOpen = new TButton('btn'.ucfirst($strName),'...',null,'evento',null,'folderOpen.gif','folderopen_desabilitado.gif','Selecionar pasta' );
	}
	public function show($print=true)
	{
		$btnClear = new TButton('btn'.ucfirst($this->getId()).'_clear', 'x', null, 'jQuery("#'.$this->getId().'").val("");',null,'borracha.gif' );
		$btnClear->setHint('Apagar');
		$btn = $this->getButton();
		$btn->setAction('');
        if( !$this->getEnabled())
        {
            $btn=null;
        }
        else
        {
            $btn->setEvent('onclick','fwOpenDir("'.$this->getId().'","'.$this->getRootDir().'","'.$this->getCallBack().'","'.$this->getTitle().'")');
    		$this->setEvent('ondblclick',$btn->getEvent('onclick'));
        }
		return parent::show($print).( ($btn) ? $btn->show($print).$btnClear->show(false):'');
	}
	public function getButton()
	{
		return $this->btnOpen;
	}
	public function setRootDir($strNewValue=null)
	{
		$this->rootDir = $strNewValue;
	}
	public function getRootDir()
	{
		return $this->rootDir;
	}
	public function setId($strNewValue=null)
	{
        parent::setId($strNewValue);
	}
	public function setTitle($strNewValue=null)
	{
		$this->title = $strNewValue;
	}
	public function getTitle()
	{
		return $this->title;
	}
	public function setCallback($strNewValue=null)
	{
		$this->callback = $strNewValue;
	}
	public function getCallback()
	{
		return $this->callback;
	}
}
?>