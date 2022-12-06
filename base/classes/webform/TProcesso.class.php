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

/*
Classe para entrada de número de processo
*/
class TProcesso extends TEdit
{
	/**
	* Classe para entrada de número de processo com os formatos: 
	* #####.######/####-## (2 digitos no ano) ou
	* ######.######/##-## (4 dígitos no ano)ou
	* ##.##.####.#######/####-## (SEI do MP)
	*
	* @param string $strName 		- 1: ID do campo.
	* @param string $strValue 		- 2: Valor inicial do campo.
	* @param boolean $boolRequired 	- 3: Campo Obrigatório, DEFALUT is FALSE não Obrigatório.
	* @param boolean $boolAcceptNumeroProcessoAAouAAAA  - 4: Número de processo, DEFALUT is TRUE - Aceitar os números de processo ######.######/##-## e #####.######/####-##.
	* @param boolean $boolAcceptNumeroSeiMP  			- 5: Número SEI do MP, DEFALUT is TRUE - Aceitar o número de processo ##.##.####.#######/####-##.
	*/
	public function __construct($strName,$strValue=null,$boolRequired=null, $boolAcceptNumeroProcessoAAouAAAA=true, $boolAcceptNumeroSeiMP=true )
	{

		if ( $boolAcceptNumeroProcessoAAouAAAA == true  && $boolAcceptNumeroSeiMP != true ){
			$intMaxLength = 21;
			$intSize = 22;
		}else{
			$intMaxLength = 26;
			$intSize = 27;
		}
		
		$numeroProcessoAAouAAAA = ( $boolAcceptNumeroProcessoAAouAAAA == 1 ) ? 'true' : 'false';
		$numeroSeiMP = ( $boolAcceptNumeroSeiMP == 1 ) ? 'true' : 'false';		

		parent::__construct($strName,$strValue,$intMaxLength,$boolRequired,$intSize);
		$this->setFieldType('processo');
		$this->addEvent('onkeyup',"fwFormatarProcesso(this,'".$numeroProcessoAAouAAAA."','".$numeroSeiMP."')");
		$this->addEvent('onblur',"fwValidarProcesso(this,null,'".$numeroProcessoAAouAAAA."','".$numeroSeiMP."')");
	}

	public function getFormated()
	{
		if( $this->getValue() ){
		  return self::formatarNumero($this->getValue());
		}
	}

	public static function formatarNumero($value)
	{
		$value = is_null($value)?'':$value;

		$value = preg_replace("/\D/", '', $value);

		if ( ! $value ) // nenhum valor informado
		{
			return null;
		}
		if ( strlen($value) == 17 ){
		// #####.######/####-##
			$value = substr( $value,0,5 ).'.'.substr( $value,5,6 ).'/'.substr( $value,11,4 ).'-'.substr( $value,15,2 );

		} else if( strlen($value) == 13 ){ 
		//######.######/##-##		
			$value=substr($value,0,5).'.'.substr($value,5,6).'/'.substr($value,11,2).'-'.substr($value,13,2);
		} else {
		// ##.##.####.#######/####-##
			$value = substr( $value,0,2 ).'.'.substr( $value,2,2 ).'.'.substr( $value,4,4 ).'.'.substr( $value,8,7 ).'/'.substr( $value,15,4 ).'-'.substr( $value,19,2 );

		}

		return $value;
	}
}
?>