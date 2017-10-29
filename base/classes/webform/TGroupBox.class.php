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
* Classe para criar grupo de campos identificados com um titulo
*
*/
class TGroupBox Extends TForm
{
	private $imageClosed;
	private $imageOpened;
	private $closeGroupId;
	private $opened;
	private $closeble;
	public function __construct($strName,$strLegend=null,$strHeight=null,$strWidth=null,$boolCloseble=null,$boolOverflowY=null,$boolOverflowX=null)
	{
		parent::__construct(null,$strHeight,$strWidth,$strName,"",null);
		$this->setTagType('fieldset');
		$this->setFieldType('groupbox');
		$this->setClass('fwGroupBox');
		$this->setWidth($strWidth);
		$this->setHeight($strHeight);
		$legend = new TElement('legend');
		$legend->setClass('fwGroupBoxLegend');
		$legend->add($strLegend);
		$this->setLegend($legend);
		$this->setOverflowX( ( is_null( $boolOverflowX ) ? false : $boolOverflowX ) );
		$this->setOverflowY( ( is_null( $boolOverflowY ) ? false : $boolOverflowY ) );
		$this->setCloseble($boolCloseble);
		//$this->body->add($legend);
	}
	public function setImageClosed($strNewValue=null)
	{
		$this->imageClosed = $strNewValue;
	}
	public function setImageOpened($strNewValue=null)
	{
		$this->imageOpened = $strNewValue;
	}
	public function setCloseGroupId($strNewValue=null)
	{
		$this->closeGroupId =  $strNewValue;
	}
	public function getCloseGroupId()
	{
		if( is_null($this->closeGroupId ) )
		{
			$this->setCloseGroupId( $this->getRandomChars() );
		}
		return $this->closeGroupId;
	}
	public function getImageClosed()
	{
		return  is_null($this->imageClosed) ? 'fwFolderOpen.gif' : $this->imageClosed;
	}
	public function getImageOpened()
	{
		return is_null($this->imageOpened) ? 'fwFolder.gif' : $this->imageOpened;
	}
	public function setOpened($boolNewValue=null)
	{
		$this->opened = $boolNewValue;
	}
	public function getOpened()
	{
		if( $this->getCloseble())
		{
			return is_null($this->opened) ? false : $this->opened;
		}
		else
		{
			return is_null($this->opened) ? true : $this->opened;
		}
	}
	public function setCloseble($boolNewValue=null)
	{
		$this->closeble = $boolNewValue;
	}
	public function getCloseble()
	{
		return $this->closeble;
	}
	public function show($print=true)
	{
		if( !$this->getLegend())
		{
			$this->legend->setcss('display','none');
		}
		if( $this->getCloseble() )
		{
			//$json=array('closeGroupId'=>$this->getCloseGroupId(),'groupId'=>$this->getId(),'imageOpened'=>$this->getImageOpened(),'imageClosed'=>$this->getImageClosed());
			//$btn = new TButton('btn_'.$this->getId().'_img',null,null,"fwOpenedCloseGroup(".json_encode($json).",this)",null,$this->getImageClosed(),null,'Fechar');
			$btn = new TButton($this->getId().'_img_opened_closed',null,null,"fwOpenCloseGroup('".$this->getId()."')",null,$this->getImageClosed(),null,'Abrir');
			$btn->setClass('fwGroupBoxImage');
			$btn->setProperty('alt','/\\');
			$this->setProperty('closeGroupId',$this->getCloseGroupId());
			$this->setProperty('imageOpened',$this->getImageOpened());
			$this->setProperty('imageClosed',$this->getImageClosed());
			$this->setOpenCloseButton($btn);
		}
		return parent::show($print);
	}
}

/*
$group = new TGroupBox('gpTeste','Cadastro');
$group->setLegendText('Luis Eugênio');
$group->addTextField('nom_pessoa','Nome:',50);
$group->show();
return;
*/

/*
$group->addTextField('nom_pessoa2','Nome2:',50);
$group->addMemoField('obs','Obs',500,true,80,4,null,null,null,'asasdfasdfasd fçkjasçd flasçdklf asdf');
$group->setColumns(array(120));
//$group->legend->setCss('background-color','red');
$group->setEnabled(false);
*/
/*
$f = new TForm('Teste Grupo Box');
//$f->setFlat(true);
	$g = $f->addGroupField('gpTeste','Dados Funcionais','auto','auto');
	$g->addTextField('nom_pessoa1',"Nome:",20);
	$g->addTextField('nom_pessoa2',"Nome:",20);
	$g->addTextField('nom_pessoa3',"Nome:",20);
	$g->addTextField('nom_pessoa4',"Nome:",20);
	$g->addTextField('nom_pessoa5',"Nome:",20);

$f->closeGroup();
	$g = $f->addGroupField('gpTeste2','Dados Relatório','auto','auto',false);
	$g->addTextField('nom_pessoa6',"Nome:",20);
	$g->addTextField('nom_pessoa7',"Nome:",20);
	$g->addTextField('nom_pessoa8',"Nome:",20);
	$g->addTextField('nom_pessoa9',"Nome:",20);
	$g->addTextField('nom_pessoa10',"Nome:",20);

$f->show();
*/
?>