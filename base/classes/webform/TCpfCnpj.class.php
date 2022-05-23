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
* Classe para entrada de dados tipo CNPJ
*/
class TCpfCnpj extends TMask
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
	* @return TCpfCnpj
	*/
	public function __construct($strName,$strValue=null,$boolRequired=null,$strInvalidMessage=null, $boolAwaysValidate = null,$strJsCallback=null)
	{
		parent::__construct($strName,$strValue,'',$boolRequired);
		$this->setFieldType('cpfcnpj');
		$this->setEvent('onkeyup','fwFormataCpfCnpj(this,event)');
		$this->setEvent('onblur','fwValidarCpfCnpj(this,event)');
		$this->setSize(19);
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

	public function getFormated()
	{
		if( $this->getValue() ){
		  return self::formatarNumero($this->getValue());
		}
	}

	/**
     * Recebe uma string e formata 
     * ###.###.###-## para CPF
     * ##.###.###/####-## CNPJ
     * @param string $value
     * @return string
     */
	public static function formatarNumero($value)
	{
		$value = preg_replace("/[^0-9]/","",$value);

		$tamanho = StringHelper::strlen($value);
		if( $tamanho == 11 ){
			return substr($value,0,3).".".substr($value,3,3).".".substr($value,6,3)."-".substr($value,9,2);
		} else if ( $tamanho == 14 ) {
			return substr($value,0,2).".".substr($value,2,3).".".substr($value,5,3)."/".substr($value,8,4)."-".substr($value,12,2);
		}

		return $value;
	}


	/**
     * Recebe uma string Formatada e retorna apenas os números
     * ###.###.###-## para CPF
     * ##.###.###/####-## CNPJ
     * @param string $value
     * @return string
     */
    public static function limpaCnpjCpf($value){
        $limpo = preg_replace("/\D/", '', $value);
        return $limpo;
    }

	public static function validarCpf($value){
		$dv 		= false;
		$cpf 		= self::limpaCnpjCpf($value);
		if($cpf=='') {
			return false;
		}

		$cpf_dv 	= substr($cpf,-2);
		$controle 	= '';
		// evitar sequencias de número. Ex:11111111111
		for ( $i = 0; $i < 10; $i++ ) {
			if( $cpf == str_repeat($i,11)){
				$cpf_dv = '99'; // causar erro de validação
				break;
			}
		}

        $digito = null;
		for ( $i = 0; $i < 2; $i++ ) {
			$soma = 0;
			for ( $j = 0; $j < 9; $j++ )
			$soma += substr($cpf,$j,1)*(10+$i-$j);
			if ( $i == 1 ) $soma += $digito * 2;
			$digito = ($soma * 10) % 11;
			if ( $digito == 10 ) $digito = 0;
			$controle .= $digito;
		}

		if ( $controle != $cpf_dv ){
		    return false;
		}
		return true;
	}

	//fonte:https://gist.github.com/guisehn/3276302
	function validarCnpj($value)
	{
		$cnpj = preg_replace('/[^0-9]/', '', $value);
		
		// Valida tamanho
		if (strlen($cnpj) != 14)
			return false;

		// Verifica se todos os digitos são iguais
		if (preg_match('/(\d)\1{13}/', $cnpj))
			return false;	

		// Valida primeiro dígito verificador
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
		{
			$soma += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}

		$resto = $soma % 11;

		if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
			return false;

		// Valida segundo dígito verificador
		for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
		{
			$soma += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}

		$resto = $soma % 11;

		return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
	}
	
	/**
	* Retorna o CPF CNPJ sem formatação
	*
	*/
	public function getValue()
	{
		return @preg_replace("/[^0-9]/","",$this->value);
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
/*
$cpfcnpj = new TCpfCnpjField('num_cpf_cnpj','CPF/CNPJ:',true);
$cpfcnpj->show();
*/
?>