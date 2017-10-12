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

/**
* Classe base para criação de inputs de texto com mascara de edição
*
* Esta classe utiliza o plugin meioMask para o jquery.
* site: http://www.meiocodigo.com/projects/meiomask/#mm_usage
*
* $.mask.options = options : {
* attr: 'alt', // an attr to look for the mask name or the mask itself
* mask: null, // the mask to be used on the input
* type: 'fixed', // the mask of this mask
* maxLength: -1, // the maxLength of the mask
* defaultValue: '', // the default value for this input
* textAlign: true, // to use or not to use textAlign on the input
* selectCharsOnFocus: true, //selects characters on focus of the input
* setSize: false, // sets the input size based on the length of the mask (work with fixed and reverse masks only)
* autoTab: true, // auto focus the next form element
* fixedChars : '[(),.:/ -]', // fixed chars to be used on the masks.
* onInvalid : function(){},
* onValid : function(){},
* onOverflow : function(){}
*
};
*/
class TMask extends TEdit
{
	private $mask;
	private $usePlaceHolder;
	private $maskPlaceHoder;
	public function __construct($strName,$strValue=null,$strMask=null,$boolRequired=null, $boolUsePlaceHolder = null )
	{
		parent::__construct($strName,$strValue,null,$boolRequired);
		$this->setMask($strMask);
		$this->setUsePlaceHolder($boolUsePlaceHolder);
	}
	//-------------------------------------------------------------------------------------
	public function setMask($strNewMask=null)
	{
		$this->mask=(string)$strNewMask;
		$len = strlen($this->mask);
		parent::setMaxLenght($len);
	}
	//-------------------------------------------------------------------------------------
	public function getMask()
	{
		return $this->mask;
	}
	//-------------------------------------------------------------------------------------
	public function show($print=true)
	{
		if( (string) $this->getMask()!='')
		{
			// http://www.meiocodigo.com/projects/meiomask/
			// http://digitalbush.com/projects/masked-input-plugin/ ( com placehoder)
			$len = strlen($this->getMask());
			$js = new TElement('script');
			$js->setProperty('type',"text/javascript");
			$js->add('jQuery("#'.$this->getId().'").setMask("'.$this->getMask().'");');
            /*
			if( ! $this->getUsePlaceHolder() )
			{
				// usar o plugin: jquery/jquery.meio.mask.min.js
				$js->add('jQuery("#'.$this->getId().'").setMask("'.$this->getMask().'");');
			}
			else
			{
				$placeHolder = $this->getMaskPlaceHoder();
				// usar o plugin: jquery/jquery.maskedinput.min.js
				$js->add('jQuery("#'.$this->getId().'").mask("'.$this->getMask().'",{placeholder:"'.$placeHolder.'"});');
			}
			*/
			//$placeHolder = $this->getMaskPlaceHoder();
			// usar o plugin: jquery/jquery.maskedinput.min.js
			//$js->add('jQuery("#'.$this->getId().'").mask("'.$this->getMask().'",{placeholder:"'.$placeHolder.'"});');
			$this->add($js);
			//$this->addEvent('onFocus','MaskInput(this,"'.$this->getMask().'")');
			//$this->addEvent('onFocus','jQuery("#'.$this->getId().'").mask("'.$this->getMask().'",{placeholder:"_"})');
			/*
			$js = new TElement('script');
			$js->setProperty('type',"text/javascript");
			$js->add('jQuery("#'.$this->getId().'").mask("'.$this->getMask().'",{placeholder:"'.$this->getMaskPlaceHoder().'"});');
			$this->add($js);
			*/
			/*  exemplos;
			$("#product").mask("99/99/9999",{completed:function(){alert("You typed the following: "+this.val());}});
			jQuery(function($){
				$.mask.definitions['~']='[+-]';
   				$("#eyescript").mask("~9.99 ~9.99 999");
			});
			*/
		}
		return parent::show($print);
	}

	public function setMaskPlaceHolder($strChar=null)
	{
		$this->maskPlaceHolder = $strChar;
	}

	function getMaskPlaceHoder()
	{
		$strChar = is_null( $this->maskPlaceHoder) ? '_' : substr($this->maskPlaceHoder,0,1);
		if( strlen($strChar ) < 1 )
		{
			$strChar='_';
		}
		return $strChar;
	}

	function setUsePlaceHolder($boolNewValue=null)
	{
		$this->usePlaceHolder = $boolNewValue;
	}
	function getUsePlaceHolder()
	{
		return ( $this->usePlaceHolder === false ? false : true );
	}
}
/*
$campo = new TMask('teste','123456789','9.9.9.9.9.9.9.9.9',true);
$campo->show();
*/
/*
$cpf = new TCpfField('num_cpf','CPF:',true);
$cpf->show();
$cnpj = new TCnpjField('num_cnpj','CNPJ:',true);
$cnpj->show();
*/
?>