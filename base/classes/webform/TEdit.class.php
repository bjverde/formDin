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
* Classe base para criação de inputs
* Adiciona as propriedades: maxlenght, required e size do campo
*
*/
class TEdit extends TControl
{
	private $exampleText;

	public function __construct($strName,$strValue=null,$intMaxLength=null,$boolRequired=null,$intSize=null)
	{
		parent::__construct('input',$strName,$strValue);
		$this->setMaxLenght($intMaxLength);
		$this->setSize($intSize);
		$this->setRequired($boolRequired);
		$this->setCss('border','1px solid #c0c0c0');
		$this->setCss('cursor','pointer');
		$this->setCss('font-family',"Arial");
		//$this->setCss('font-size',"13px");
		// carregar o valor do campo com o $_POST
		if( isset($_POST[$strName]) && (string) $_POST[$strName] != "" )
		{
			if( isset( $_POST[$strName] ) && is_string($_POST[$strName] ) )
			{
				$this->setValue(str_replace(array('"'),array('“'),stripslashes($_POST[$strName])));
			}
		}
		else if( isset($_GET[$strName]) && (string) $_GET[$strName] != "" )
		{
			if( isset( $_GET[$strName] ) && is_string($_GET[$strName] ) )
			{
				$this->setValue(str_replace(array('"'),array('“'),stripslashes($_GET[$strName])));
			}
		}
		else
		{
			// tratamento quando o campo texto estiver no formato de array nome[1], nome[2]...
			$name = preg_replace('/\[\]/','[1]',$this->getName()); // evitar erro dos campos array do TGrid
	        if( preg_match('/\[/',$name) > 0 )
			{
				$arrTemp = explode('[',$name);
				if( isset($_POST[$arrTemp[0] ] ) )
				{
					$post = '$_POST[\''.str_replace('[',"'][",$name).';';
	 				@eval('$v=$_POST[\''.str_replace('[',"'][",$name).';');
					if( !is_null( $v ) )
					{
						$this->setValue($v);
					}
				}
			}
		}
	}
	//-------------------------------------------------------------------------------------
	public function show($print=true)
	{
		if(!$this->getId())
		{
			$this->setId( $this->removeIllegalChars($this->getName()));
		}
		if($this->getFieldType() !='hidden')
		{
			if( (int) $this->size==0 && (int)$this->maxlength > 0 )
			{
				$this->size = $this->maxlength;
			}
			if( (int) $this->size==0 )
			{
				$this->size = null;
			}
			if( (int) $this->maxlength==0 )
			{
				$this->maxlength = null;
			}
			if( $this->getFieldType() != 'tag' && $this->getFieldType() != 'link')
			{
				$this->addEvent('onKeyUp','fwSetBordaCampo(this,false,event)');
			}
			if($this->getRequired()==true)
			{
				// remover a borda de advertencia dos inputs
				$this->addEvent('onBlur' ,'fwValidarObrigatorio(this)');
			}
			if($this->getExampleText())
			{
				$span = new TElement('span');
				$span->setId($this->getId().'_exempleText');
				$span->setClass('fwExampleText');
				$span->add($this->getExampleText());
				$this->add($span);
			}

		}
		else
		{
			$this->clearCss();
			$this->clearEvents();
		}
		return parent::show($print);
	}
	//-------------------------------------------------------------------------------------
	public function setMaxLenght($intLenght=null)
	{
		$this->maxlength = (int)$intLenght;
	}
	public function getMaxLenght()
	{
		return $this->getProperty('maxlength');
	}
	public function setRequired($boolValue=null)
	{
		$this->setAttribute('needed',( (bool)$boolValue ? "true" : null) );
	}
	public function getRequired()
	{
		return $this->getAttribute('needed')=="true";
	}
	public function setSize($intSize=null)
	{
		$this->size=(int)$intSize;
	}
	/**
	* Valida se o campo foi preenchido
	*
	*/
	public function validate()
	{
		$this->setCss('border','1px solid #c0c0c0');
		//$this->setError(null);
		if($this->getRequired() && (string)$this->getValue()=="")
		{
			$this->setCss('border','1px solid #ff0000');
			$this->setError('Campo obrigatório.');
		}
		// validar o tamanho
		if($this->getFieldType() != 'hidden' && $this->getFieldType() != 'file' && $this->getFieldType() != 'fileAsync')
		{
			if($this->getMaxLenght())
			{
				$value = $this->getValue();
				if( $this->getFieldType() =='number')
				{
					$value = preg_replace('/[^0-9]/','',$value);
				}
				if( (int)$this->getMaxLenght() < strlen( $value ) )
				{
					$this->setCss('border','1px solid #ff0000');
					$this->setError('máximo '.$this->getMaxLenght().' caracteres.');
				}
			}
		}
		return ( (string)$this->getError()==="" );
	}
	/**
	* Define um texto de exemplo de preenchimento do campo
	*
	* @param string $strNewValue
	*/
	public function setExampleText($strNewValue=null)
	{
		$this->exampleText=$strNewValue;
		return $this;
	}
	/**
	* Retorna o texto de exemplo de preenchimento do campo
	*
	*/
	public function getExampleText()
	{
		if( is_null($this->exampleText))
		{
			return null;
		}
		return trim($this->exampleText);
	}
}
?>