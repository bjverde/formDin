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
class TNumeroTJDFT extends TEdit
{
	/**
	 * Classe para entrada de número de processo
	 *
	 * @param string $strName        - 1: ID do campo
	 * @param string $strValue       - 2: Valor inicial do campo
	 * @param boolean $boolRequired  - 3: Campo Obrigatório, DEFALUT is FALSE não Obrigatório.
	 * @param boolean $boolAcceptNumeroDistribuicao
	 * @param boolean $boolAcceptNumeroUnico
	 */
	public function __construct($strName,$strValue=null,$boolRequired=null, $boolAcceptNumeroDistribuicao=true, $boolAcceptNumeroUnico = true)
	{

			$numeroDistribuicao = 'false';
			$numeroUnico = 'false';

		if ($boolAcceptNumeroDistribuicao == true){
			$intMaxLength = 20;
			$intSize = 14;
			$numeroDistribuicao = 'true';
		}

		if ($boolAcceptNumeroUnico == true){
			$intMaxLength = 26;
			$intSize = 20;
			$numeroUnico = 'true';
		}
		
		parent::__construct($strName,$strValue,$intMaxLength,$boolRequired,$intSize);
		$this->setFieldType('numeroTJDFT');
		$this->addEvent('onkeyup',"fwFormatarNumeroTJDFT(this,'".$numeroDistribuicao."','".$numeroUnico."')");
		$this->addEvent('onblur','fwValidarNumeroTJDFT(this)');
	}

	public function getFormated()
	{
		if( $this->getValue() ){
		    $value = preg_replace("/\D/", '', $this->getValue());
			if( strlen($value) == 20 ){
				//#######-##.####.#.##.#### - 20 dígitos
				//0123456-78.9012.3.45.6789 
				//7-2.4.1.2.4				
				$value = substr($value,0,7).'-'.substr($value,7,2).'.'.substr($value,9,4).'.'.substr($value,13,1).'.'.substr($value,14,2).'.'.substr($value,16,4);
			} else if( strlen($value) == 14 ) {
				//formatação para o número de 14 digitos
				//1999.01.1.001573-8
				//4.2.1.6-1
				$value = substr($value,0,4).'3'.substr($value,4,2).'.'.substr($value,6,1).'.'.substr($value,7,6).'-'.substr($value,14,1);
			} else {
				$value =  null;
			}
			return $value;
		}
	}
}
?>