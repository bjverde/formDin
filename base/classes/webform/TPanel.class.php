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
*  Objeto tipo container que permite ter outros objetos como filhos
*  Se a propriedade flat for true, exibe com bordas
*/
class TPanel extends TControl
{
	private $controls;
	private $flat;
	public $legend;
	public function __construct($strName,$strWidth=null,$strHeight=null)
	{
		$strWidth 	= $strWidth	==null ? "auto" : $strWidth;
		$strHeight	= $strHeight==null ? "auto" : $strHeight;
		$this->setFlat(true);
		parent::__construct('div',$strName);
		parent::setFieldType('panel');
		parent::setWidth($strWidth);
		parent::setHeight($strHeight);
		// tirar a borda do painel depois
		parent::setCss('border'	,'none');
		//parent::setCss('border'	,'1px dashed red');
		parent::setCss('display','block');
		// definir as propriedade como nula inicializa-la no array, se por acaso precisar definir a margin-top, por exemplo , ficar abaixo de margin;
		$this->setcss('margin','');
        $this->setcss('padding','');

		// legenda do box
		$this->legend = new TElement('div');
		$this->legend->setCss('top','-10px');
		$this->legend->setCss('left','10px');
		$this->legend->setCss('position','absolute');
		$this->legend->setCss('background-color','silver');
		$this->legend->setCss('border','1px solid gray');
		$this->legend->setCss('padding-left','2px');
		$this->legend->setCss('padding-right','2px');
		$this->legend->setCss('font-size','12px');
		$this->legend->setCss('font-weight','normal');
		$this->legend->setCss('font-family','arial,sans-serif');
		$this->legend->setCss('border','1px outset #C0C0C0');
		$this->legend->setCss('background-color','#E1E1E1');
		$this->legend->setCss('color','#24618E');
	}
	//--------------------------------------------------------------------
	public function show($print=true)
	{
		$box=null;
		if(!$this->getFlat())
		{
			$this->setcss('margin','0');
			$this->setcss('padding','0');
			if((int)$this->getWidth()==0)
			{
			$this->setWidth(200);
			}
			if((int)$this->getHeight()==0)
			{
				$this->setHeight(200);
			}
			$this->setWidth($this->getWidth()+17);
			$this->setHeight($this->getHeight()+23);
			$box = new TBox('box_'.$this->getName(),$this->getWidth()-1,$this->getHeight()-8);
			$box->setCssBody('background-color',$this->getCss('background-color'));
			// se tiver legenda inserir um espaço no topo
			if((string) $this->legend->id != '' )
			{
				// ajustar o id da legenda como o id do elemento
				$this->legend->id= $this->getId().'_legend';
				$box->setCssBody('margin-top',15);
				// para nao colar no campo de cima
				$this->setCss('margin-top','10');
			}
			$box->add($this->getChildren());
			$this->clearChildren();

		}
		else
		{
			// construir o painel
			if((string)$this->getCss('overflow')=='')
			{
				parent::setCss('overflow'	,'auto');
			}
			parent::setCss('margin'		,'0');
			parent::setCss('padding'	,'2');
		}
		if(is_array($this->controls) )
		{
			foreach ($this->controls as $k => $control)
			{
				if($box)
				{
					$box->add($control);
				}
				else
				{
					$this->add($control);
				}
			}
		}
		if($box)
		{
			$this->legend->setCss('top','-7px');
			$this->legend->setCss('left','15px');
			$this->add($box);
			// se for groupbox, colocar o label se o label tiver o id definido
       		if($this->legend->id !='')
       		{
				parent::add($this->legend);
			}
		}
		else
		{
			// se tiver legenda, reconfirar o objeto para fieldset e adicionar a tag legend
			if((string) $this->legend->id != '' )
			{
				$this->setTagType('fieldset');
				// ajustar o id da legenda como o id do elemento
				$this->legend->id= $this->getId().'_legend';
				$this->legend->setTagType('legend');
				$this->legend->setCss('top','');
				$this->legend->setCss('left','');
				$this->legend->setCss('position','');
				$this->legend->setCss('padding-left','2px');
				$this->legend->setCss('padding-right','2px');
				$children = $this->getChildren();
				$this->clearChildren();
				// o heigh tem que ser alterado para auto devido ao firefox nao aceitar overflow:auto na tag fieldset
				$this->setcss('height','auto');
				$this->add($this->legend);
				$this->add($children);
			}

		}
		return parent::show($print);
	}
	//--------------------------------------------------------------------
	public function addControl(TElement $control)
	{
		$this->controls[$control->getName()] = $control;
	}
	//---------------------------------------------------------------------------------------
//	public function setFlat($boolFlat=null)
//	{
//		$boolFlat = $boolFlat===null ? true :(bool)$boolFlat;
//		$this->flat = (bool)$boolFlat;
//	}

	//---------------------------------------------------------------
	/**
	 * Define a borda 3D ou borda simples do formulário
	 * Se for retirada a borda 3D, assume o fundo padrão cinza claro
	 *
	 * @param boolean $boolValue
	 */
	public function setFlat($boolFlat=null)
	{
		$boolFlat = $boolFlat===null ? true :(bool)$boolFlat;
		$this->flat = (bool) $boolFlat;
		if($this->flat)
		{
			if((string)$this->getCss('border') == "")
			{
				$this->setCss('border','1px solid #808080');
			}
			if((string)$this->getCss('background-color')=="")
			{
				$this->setCss('background-color','#efefef');
			}
		}
		else
		{
			$this->setCss('border','none');
			$this->setCss('background-color','transparent');
		}
	}
	//---------------------------------------------------------------------------------------
	public function getFlat()
	{
		return $this->flat;
	}
	//---------------------------------------------------------------------------------------
	public function setLegend($strTitle=null)
	{
		$this->legend->clearChildren();
		$this->legend->id='';
		if((string)$strTitle!="")
		{
			$this->legend->add($strTitle);
			$this->legend->id= $this->getId().'_legend';
		}
	}
}

//$panel = new TPanel('pnl_teste',500,300);
//$panel->show();
//return;
/*
//$panel->add('Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>Linha <br>');
$panel->setFlat(true);
$panel->legend->id='xxx';
$panel->legend->add('Cadastro de Cliente');
$panel->add('Linha 1');
$panel->add('Linha 2<br>');
$panel->add('Linha 3<br>');
$panel->add('Linha 4<br>');
$panel->show();
*/
?>