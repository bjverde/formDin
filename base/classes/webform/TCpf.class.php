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
* Classe para entrada de dados tipo CPF
*/
class TCpf extends TMask
{
	private $invalidMessage;
	private $alwaysValidate;
	private $callback;

	/**
	* Metódo construtor
	*
	* @param string $strName
	* @param string $strValue
	* @param boolean $boolRequired
	* @return TCpfField
	*/
	public function __construct($strName,$strValue=null,$boolRequired=null,$strInvalidMessage=null, $boolAwaysValidate = null,$strJsCallback=null)
	{
		parent::__construct($strName,$strValue,'',$boolRequired);
		$this->setFieldType('cpf');
		$this->setEvent('onblur','if(!fwValidarCpf(this,event)){return false}');
		$this->setEvent('onkeyup','fwFormatarCpf(this,event)');
		$this->setSize(15);
		$this->setInvalidMessage($strInvalidMessage);
		$this->setAlwaysValidate($boolAwaysValidate);
		$this->setCallback($strJsCallback);
	}

	public function show($print=true)
	{
        $this->setAttribute('meta-invalid-message',$this->getInvalidMessage());
        $this->setAttribute('meta-always-validate',$this->getAlwaysValidate());
        $this->setAttribute('meta-callback',$this->getCallback());
		return parent::show($print);
	}

	/**
	* Retorna o CPF formatado
	*
	*/
	public function getFormated()
	{
		if( $this->getValue())
		{
			$cpf = @preg_replace("/[^0-9]/","",$this->getValue());
			return substr($cpf,0,3).".".substr($cpf,3,3).".".substr($cpf,6,3)."-".substr($cpf,9,2);
		}
		return $this->getValue();
	}

	/**
	* Retorna o CPF sem formatação
	*
	*/
	public function getValue()
	{
		return @preg_replace("/[^0-9]/","",$this->value);
	}
	/**
	* Validar o cpf
	*
	*/
	public function validate()
	{
		if( ! parent::validate() )
		{
			return false;
		}
		$dv 		= false;
		$cpf 		= preg_replace("/[^0-9]/","",$this->getValue());
		if($cpf=='')
		{
			return true;
		}
		$cpf_dv 	= substr($cpf,-2);
		$controle 	= '';
		// evitar sequencias de número. Ex:11111111111
		for ( $i = 0; $i < 10; $i++ )
		{
			if( $cpf == str_repeat($i,11))
			{
				$cpf_dv = '99'; // causar erro de validação
				break;
			}
		}

		for ( $i = 0; $i < 2; $i++ ) {
			$soma = 0;
			for ( $j = 0; $j < 9; $j++ )
			$soma += substr($cpf,$j,1)*(10+$i-$j);
			if ( $i == 1 ) $soma += $digito * 2;
			$digito = ($soma * 10) % 11;
			if ( $digito == 10 ) $digito = 0;
			$controle .= $digito;
		}
		if ( $controle != $cpf_dv )
		{
			$this->setCss('border','1px solid #ff0000');
			$this->setError('Cpf '.$this->getFormated().' está digitado incorretamente!');
		}
		return ( (string)$this->getError()==="" );
	}
	public function setInvalidMessage($strNewValue=null)
	{
		$this->invalidMessage = $strNewValue;
	}

	public function getInvalidMessage()
	{
		return $this->invalidMessage;
	}

	public function setAlwaysValidate($boolNewValue=null)
	{
		$this->alwaysValidate = $boolNewValue;
	}

	public function getAlwaysValidate()
	{
		return ($this->alwaysValidate===true) ? 'true' :'false' ;
	}

	public function setCallback($strJsFunction=null)
	{
		$this->callback = $strJsFunction;
	}

	public function getCallback()
	{
		return $this->callback;
	}



}
?>