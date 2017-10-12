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
 class TBox extends TControl
{
	private $divBox;
	private $divContent;
	public	$divBody;
	private $flat;
	public $legend;   // devido a compatibilidade com IE, a legenda só será exibida no modo FLAT
	public $openCloseButton;
	private $position;
	private $outside;
	public function __construct($strName=null,$intWidth=null,$intHeight=null,$boolFlat=null)
	{

		parent::__construct('fieldset',$strName);
		$this->clearCss();
		parent::setFieldType('box');
		parent::setCss('border','none');
		parent::setCss('width','auto');
		parent::setCss('height','auto');
		parent::setCss('overflow','hidden');
		parent::setCss('display','inline');
		parent::setCss('vertical-align','top');
		parent::setCss('margin','0');
		parent::setCss('padding','0');
		parent::setCss('position','relative');
		parent::setCss('background-color','#efefef');
		$this->setFlat($boolFlat);
		$this->divBox 		= new TElement('div');
		$this->divBox->clearCss();
		$this->divBox->setProperty('id','box_'.$strName);
		$this->divBox->setCss('padding','0');
		$this->divBox->setcss('margin','0');
		$this->divBox->setcss('border','none');
		$this->divBox->setcss('background-color','transparent');
		$this->divContent 	= new TElement('div');
		$this->divContent->setProperty('id','content_'.$strName);
		$this->divContent->setClass('content');
		$this->divContent->clearCss();
		$this->divContent->setCss('background-color','transparent');

		$this->divBody 		= new TElement('div');
		$this->divBody->clearCss();
		$this->divBody->setCss('padding-top','0');
		$this->divBody->setCss('border','none');
		$this->divBody->setCss('overflow','auto');
		$this->divBody->setProperty('id','body_'.$strName);
		$this->setWidth($intWidth);
		$this->setheight($intHeight);

		$this->outside = new TElement();
	}
	public function showFlat($print=true)
	{

		if(is_object($this->openCloseButton ) )
		{
			parent::add($this->openCloseButton);
		}
		if(is_object($this->legend))
		{
			//parent::add('<img class="fwGroupBoxImage" src="base/imagens/folder.gif">');
			parent::add($this->legend);
		}
		if( (string)$this->divBody->getCss('width')=="")
		{
			$this->divBody->setCss('width',$this->divBox->getCss('width'));
		}
		if( (string)$this->divBody->getCss('height')=="")
		{
			$this->divBody->setCss('height',$this->divContent->getCss('height'));
		}
		if( $this->divBody->getCss('background-color') == "")
		{
			$this->divBody->setCss('background-color',$this->getCss('background-color'));
		}
		if($this->getCss('border')=='none')
		{
			$this->setCss('border','1px solid #c0c0c0');
		}
		if( $this->getPosition() )
		{
			$this->divBody->add('<script>window.setTimeout(\'fwSet_position("'.$this->getId().'","'.$this->getPosition().'")\',100);</script>');
		}
		parent::add($this->divBody);
		return parent::show($print).$this->getOutsideHtml($print);
	}

	public function show($print=true,$flat=false)
	{

		//$content = $this->divBody->getChildren();
		// limpar o array de objetos para poder chamar o metodo show() "n" vezes seguidas
		//$this->divBox->clearChildren();
		//$this->divContent->clearChildren();
		//$this->divBody->add($content);
		if( (bool)$flat==true || $this->getFlat() || is_object($this->legend) )
		{
			return $this->showFlat($print);
		}
		$this->divBody->setCss('height',(int)($this->getHeight()-8- ((int)$this->divBody->getCss('margin-top')) ));
		$this->divBody->setCss('width',(int)($this->getwidth()-13));
		$this->divBody->SetCss('position','absolute');
		$this->divBody->SetCss('border','none');
		$this->divBody->SetCss('top','5px');
		$this->divBody->SetCss('left','5px');
		//$this->divBody->setCss('background-color', $this->getCss('background-color'));

		$this->divContent->add($this->divBody);

		// cria a estrutura de divs com as imagens para da o efeito de caixa com cantos arredondados
		$divlb = new TElement('div');
		$divlb->clearCss();
		$divlb->setCss('background-color','transparent');
		$divlb->setClass('lb');
		//$divlb->setCss('background-color','transparent');

		$divrb = new TElement('div');
		$divrb->clearCss();
		$divrb->setClass('rb');
		$divrb->setCss('background-color','transparent');


		$divbb = new TElement('div');
		$divbb->setClass('bb');
		$divbb->clearCss();
		$divbb->setCss('background-color','transparent');

		$divblc = new TElement('div');
		$divblc->setClass('blc');
		$divblc->clearCss();
		$divblc->setCss('background-color','transparent');


		$divbrc = new TElement('div');
		$divbrc->setClass('brc');
		$divbrc->clearCss();
		$divbrc->setCss('background-color','transparent');

		$divtb = new TElement('div');
		$divtb->setClass('tb');
		$divtb->clearCss();
		$divtb->setCss('background-color','transparent');

		$divtlc = new TElement('div');
		$divtlc->setClass('tlc');
		$divtlc->clearCss();
		$divtlc->setCss('background-color','transparent');

		$divtrc = new TElement('div');
		$divtrc->setClass('trc');
		$divtrc->clearCss();
		$divtrc->setCss('background-color','transparent');

		$divtrc->add($this->divContent);
		$divtlc->add($divtrc);
		$divtb->add($divtlc);
		$divbrc->add($divtb);
		$divblc->add($divbrc);
		$divbb->add($divblc);
		$divrb->add($divbb);
		$divlb->add($divrb);
		$this->divBox->add($divlb);
		if( $this->getPosition() )
		{
			$this->divBody->add('<script>window.setTimeout(\'fwSet_position("'.$this->getId().'","'.$this->getPosition().'")\',100);</script>');
		}
		parent::add($this->divBox);
		return parent::show($print).$this->getOutsideHtml($print);
	}

	/**
	 *
	 */
	public function setWidth($strNewWidth=null)
	{
		if( isset( $strNewWidth ) && (string)$strNewWidth !='auto' )
		{
			if(strpos($strNewWidth,'%')===false)
			{
				/*if( $this->getFieldType()!='groupbox')
				{
					$strNewWidth = (int)$strNewWidth == 0 ? 100 : (int)$strNewWidth;
				}
				*/
				$strNewWidth = (int)$strNewWidth;
			}
		}
		$this->divBox->setCss('width',$strNewWidth);
		return $this;
	}
	public function getWidth( $strMinWidth = null )
	{
		return $this->divBox->getCss('width');
	}
	/**
	 *
	 */
	public function setHeight($strNewHeight=null)
	{
		if( isset($strNewHeight ) && (string)$strNewHeight != 'auto')
		{
			if(strpos($strNewHeight,'%')===false)
			{
				if( $this->getFieldType()!='groupbox')
				{
					//$strNewHeight = (int)$strNewHeight == 0 ? 50 : (int)$strNewHeight;
				}
				$strNewHeight = (int)$strNewHeight;
			}
		}
		$this->divContent->setCss('height',$strNewHeight);
		return $this;
	}
	public function getHeight( $strMinHeight = null )
	{
		return $this->divContent->getCss('height');
	}
	public function add($value,$body=true)
	{
		if( $body )
		{
			$this->divBody->add($value);
		}
		else
		{
			parent::add($value);
		}
	}
	/**
	* Define o css que será aplicado na div onde será colocado o conteudo do BOX
	*
	* @param string $strCssProperty
	* @param string $strValue
	*/
	public function setCssBody($strCssProperty,$strValue)
	{
		$this->divBody->setCss($strCssProperty,$strValue);
	}

	/**
	* Define se a caixa terá borda 3D ou Simples
	*
	* @param boolean $boolNewValue
	*/
	public function setFlat($boolNewValue=null)
	{
		$this->flat = (bool)$boolNewValue;
	}

	/**
	* Retorna true ou false para exibir a caixa com borda 3D ou Simples
	*
	*/
	public function getFlat()
	{
		return $this->flat;
	}
	/**
	* Define o objeto legenda
	* Obs: devido a compatibilidade com IE, a legenda só será exibida no modo FLAT
	*
	* @param TElement $objLegend
	*/
	public function setLegend($objLegend)
	{
		$this->legend = $objLegend;
	}
	/**
	* Retorna o objeto legenda
	*
	*/
	public function getLegend()
	{
		if($this->legend)
		{
			$legend = $this->legend->getChildren();
			return $legend[0];
		}
	}
	/**
	* Define o texto da legenda do grupo
	*
	* @param string $strLegend
	*/
	public function setLegendText($strLegend=null)
	{
		$this->legend->clearChildren();
		if((string)$strLegend!="")
		{
			$this->legend->add($strLegend);
		}
	}
	public function setOpenCloseButton($objNewValue=null)
	{
		$this->openCloseButton = $objNewValue;
	}
	/**
	* Define a posição do box na tela. Os valores possíveis são:
	*
	*	TL	= Top Left		CL	= Center Left 		BL	= Bottom Left
	* 	TC	= Top Center	CC	= Center Center		BC	= Bottom Center
	* 	TR	= Top Right		CR	= Center Right		BR	= Bottom Right
	*
	* <code>
	* 	$box->setPosition( 'CC' );
	* </code>
	*
	* @param mixed $strNewValue
	*/
	public function setPosition($strNewValue='tl|tc|tr|cl|cc|cr|bl|bc|br')
	{
		$this->position=$strNewValue;
	}
	public function getPosition()
	{
		return $this->position;
	}

	public function getDivContent()
	{
		return $this->divContent;
	}

	public function getDivBox()
	{
		return $this->divBox;
	}

	public function getDivBody()
	{
		return $this->divBody;
	}

		/**
	 * Método para retornar a instância do objeto outside
	 *
	 */
	public function getOutside()
	{
		return $this->outside;
	}
	/**
	 * Método utilizado para retornar o html adicionado fora da área do formulário.
	 *
	 */
	public function getOutsideHtml($print=true)
	{
		return $this->outside->show($print);
	}
	//-----------------------------------------------------------------------------
	/**
	 * Método utilizado para adicionar objetos e ou códigos html
	 * fora da área do formulário
	 */
	public function addOutside($mixNewValue=null)
	{
		$this->outside->add($mixNewValue);
	}

}
?>