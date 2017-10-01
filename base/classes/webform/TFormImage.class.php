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
 * Extensão da classe TForm para criar formulários com imagem de fundo
 */
 class TFormImage extends TForm
 {
	private $bgImage;
	private $bgRepeat;
	private $bgPosition;
	private $width;
	private $height;
	public function __construct($strTitle=null, $strbgImagePath=null, $strBgRepeat=null, $strBgPosition=null, $strHeight=null, $strWidth=null, $strFormName=null, $strMethod=null, $strAction=null,$boolPublicMode=null )
	{
    	parent::__construct(null, $strHeight, $strWidth, $strFormName, $strMethod, $strAction,$boolPublicMode);
    	$this->width 	= $strWidth;
    	$this->height 	= $strHeight;
    	$this->setBgImage($strbgImagePath);
    	$this->setBgRepeat($strBgRepeat);
    	$this->setBgPosition($strBgPosition);
    	$this->setRequiredFieldText('');
	}
	public function show( $print=true )
	{
		$this->setFlat(true);
		$this->body->setCss('border-top','0px');
		$this->body->setCss('border-bottom','0px');
		$this->setCss('background-color','transparent');
		$this->setCss('background-image','url('.$this->getBgImage().')');
		$this->setCss('background-repeat',$this->getBgRepeat());
		$this->setCss('background-position',$this->getBgPosition());
		if( $this->width=='' || $this->height==''  )
		{
			if( $this->getBgImage() && function_exists('getimagesize') )
			{
				list($width, $height) = getimagesize( $this->getBgImage() );
           		if( is_null($this->width)  )
           		{
					$this->setWidth($width);
				}
				if( is_null($this->height ) )
				{
					$this->setHeight($height);
				}
			}
		}
		return parent::show($print);
	}

	//-----------------------------------------------------------------------------------
	public function setBgImage($strNewValue = null,$strRepeat=null)
	{
	    $this->bgImage = $strNewValue;
	    $this->setBgRepeat( $strRepeat );
	}
	public function getBgImage()
	{
		if( file_exists($this->bgImage))
		{
			return $this->bgImage;
		}
		return null;
	}
	//-----------------------------------------------------------------------------------
	public function setBgPosition($strNewValue = null)
	{
	    $this->bgPosition = $strNewValue;
	}
	public function getBgPosition()
	{
		return is_null($this->bgPosition) ? 'top': $this->bgPosition;
	}
	//-----------------------------------------------------------------------------------
	public function setBgRepeat($strNewValue = null)
	{
		$this->bgRepeat = $strNewValue;
	}
	public function getBgRepeat()
	{
		if( is_null($this->bgRepeat) && $this->getBgImage() && function_exists('getimagesize') )
		{
			list($width, $height) = getimagesize( $this->getBgImage() );
			//echo $this->getBgImage().' w:'.$width. ' h:'.$height.'<br>';
			if( $width > 100 && $height < 30 )
			{
				return 'repeat-y';
			}
			if( $width < 30 && $height < 100 )
			{
				return 'repeat-x';
			}
			if( $width < 10 && $height < 10 )
			{
				return '';
			}
			return 'no-repeat';
		}
		return $this->bgRepeat;
	}
	//-----------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

}
?>
