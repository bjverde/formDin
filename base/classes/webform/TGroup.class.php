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
class TGroup Extends TForm
{
	private $imageClosed;
	private $imageOpened;
	private $closeGroupId;
	private $opened;
	private $closeble;
	private $accordionId;
	// composição
	private $divLegend;
	private $objImage;
	private $objLegend;
	public function __construct($strName, $strLegend=null, $strHeight=null, $strWidth=null, $boolCloseble=null, $boolOpened=null, $boolOverflowY=null,$boolOverflowX=null, $strAccordionId=null )
	{
		$this->divLegend 	= new TElement('div');
		$this->objLegend 	= new TElement('span');
		$this->objImage 	= new TElement('img');
		parent::__construct(null,$strHeight,$strWidth,$strName,"",null);
		$this->setTagType('div');
		$this->setFieldType('group');
		$this->setflat(true);
		$this->removeField('fw_back_to');
		$this->setShowHtmlTag(null);
		$this->setCloseble($boolCloseble);
		$this->setOpened($boolOpened);
		$this->setAccordionId($strAccordionId);
		$this->setOverflowX( ( is_null($boolOverflowX) ? false : $boolOverflowX) );
		$this->setOverflowY((is_null($boolOverflowY) ? false : $boolOverflowY) );
		$this->clearCss();
		$this->setCss(array("margin"=>"2px","padding"=>"0px","border"=>"1px solid silver","width"=>$this->getWidth()."px","height"=>"auto","margin-left"=>"0px","margin-top"=>"15px"));

		//$this->setWidth( is_null($strWidth)   ? '400' : $strWidth );
		$this->setHeight('auto'); // tem que ser auto, a div body é quem manda na altura e no scroll do componente


		$this->divLegend->clearCss();
		$this->divLegend->setCss(array("padding"=>"0px","margin"=>"0px","position"=>"relative","top"=>"-9px","left"=>"0px","width"=>$this->getWidth()."px","height"=>"14px","border"=>"none","background-color"=>"transparent"));

		$this->objLegend->add($strLegend);
		$this->objLegend->setClass("fwGroupBoxLegend");
		$this->objLegend->setCss(array("margin"=>"0px","padding"=>"0px","margin-left"=>"10px","padding-left"=>"5px","padding-right"=>"3px") );

		$this->objImage->clearCss();
		$this->objImage->setId($this->getId().'_img_open_close');
		$this->objImage->setProperty('title'		,'Fechar');
		$this->objImage->setProperty('tooltip'		,'true');
		$this->objImage->setProperty('groupId'		,$this->getId());
		$this->objImage->setProperty('groupHeight'	,$this->getHeight());
		$this->objImage->setProperty('bodyHeight'	,( $this->getHeight() != 'auto' ? ($this->getHeight()-13) : $this->getHeight() ) );
		$this->objImage->setProperty('imgOpened'	,$this->getImageOpened());
		$this->objImage->setProperty('imgClosed'	,$this->getImageClosed());
		$this->objImage->setProperty('status'		,'opened');
		$this->objImage->setCss(array("width"=>"16px","height"=>"16px","cursor"=>"pointer","float"=>"right","margin"=>"0px","padding"=>"0px","margin-top"=>"0px","margin-right"=>"2px"));
		$this->objImage->setProperty("src"			,$this->getImageOpened());
		$this->objImage->addEvent('onclick'			,'fwGroupboxOpenCloseClick(this)');

		$this->divLegend->add( $this->objImage );
		$this->divLegend->add( $this->objLegend );
		$this->add( $this->divLegend, false );

		$this->divBody->clearCss();
		$h = is_null($strHeight) ? 'auto' : $strHeight;
		$this->divBody->setCss(array("margin"=>"0px","padding"=>"0px","position"=>"relative","top"=>"-5px","border"=>"0px","width"=>($this->getWidth()-13)."px","height"=>$h,"overflow"=>"hidden","overflow-x"=>"hidden","overflow-y"=>"hidden","padding-left"=>"10px"));

	}
	public function show($print=true,$flat=false)
	{

		if( $this->getAccordionId())
		{
			$this->objImage->setAttribute('accordion_id',$this->getAccordionId());
		}
		//definir os ids dos componentes que compoem o objeto groupbox
		$this->divLegend->setId($this->getId().'_div_legend');
		$this->objImage->setId($this->getId().'_img_open_close');
		$this->objLegend->setId($this->getId().'_legend');
		if( ! $this->objLegend->getChildren() )
		{
			$this->objLegend->setCss('display','none');
		}
		$this->divBody->setCss('overflow-x',$this->getOverFlowX());
		$this->divBody->setCss('overflow-y',$this->getOverflowY());
		if( ! $this->getCloseble() )
		{
			$this->objImage->setCss('display','none');
		}
		if( ! $this->getOpened() )
		{
			$this->divBody->setCss('height','0px');
			$this->objImage->setProperty('status','closed');
			$this->objImage->setProperty('src',$this->getImageClosed());
			$this->objImage->setProperty('title','Abrir');
		}
		return parent::show($print);
	}
	public function setImageClosed($strNewValue=null)
	{
		$this->imageClosed = $strNewValue;
		return $this;
	}
	public function setImageOpened($strNewValue=null)
	{
		$this->imageOpened = $strNewValue;
		return $this;
	}
	public function setCloseGroupId($strNewValue=null)
	{
		$this->closeGroupId =  $strNewValue;
		return $this;

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
		$image = is_null( $this->imageClosed ) ? 'fwFolder.gif' : $this->imageClosed;
		if( ! file_exists( $image) )
		{
			$image = $this->getBase().'imagens/'.$image;
		}
		return $image;
	}
	public function getImageOpened()
	{
		$image = is_null( $this->imageOpened ) ? 'fwFolderOpen.gif' : $this->imageOpened;
		if( ! file_exists( $image ) )
		{
			$image = $this->getBase().'imagens/'.$image;
		}
		return $image;
	}
	public function setOpened($boolNewValue=null)
	{
		$this->opened = $boolNewValue;
		return $this;
	}
	public function getOpened()
	{
		return is_null($this->opened) ? true : $this->opened;
	}
	public function setCloseble($boolNewValue=null)
	{
		$this->closeble = $boolNewValue;
		return $this;
	}
	public function getCloseble()
	{
		return ( $this->closeble === true ? true : false ) ;
	}
	public function getImage()
	{
		return $this->objImagem;
	}
	public function getLegend()
	{
		return $this->objLegend;
	}
	public function setWidth($strNewValue=null)
	{
		parent::setWidth($strNewValue);
		$width = $this->getWidth();
		$width = is_null($width) ? 0 : $width;
		$this->setCss("width", $this->getWidth() );
		$this->divLegend->setCss("width",$this->getWidth() );
		$this->divBody->setCss("width", ( $this->getWidth()-13) );
		return $this;
	}
	public function setHeight($strNewValue=null)
	{
		parent::setHeight('auto');
		$this->setCss("height",'auto' );
		$height = is_null( $strNewValue ) ? 'auto' : $strNewValue;
		$this->divBody->setCss("height",$height);
		return $this;
	}
	public function getHeight($strMinHeight = null)
	{
		return $this->divBody->getCss("height");
	}
	public function setAccordionId($strNewValue=null)
	{
		$this->accordionId = $strNewValue;
		return $this;
	}
	public function getAccordionId()
	{
		return $this->accordionId;
	}
}
?>