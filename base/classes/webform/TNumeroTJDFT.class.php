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
	* @param string $name
	* @param string $value
	* @param boolean $required
	*/
	public function __construct($strName,$strValue=null,$boolRequired=null)
	{
		parent::__construct($strName,$strValue,26,$boolRequired);
		$this->setFieldType('numeroTJDFT');
		$this->addEvent('onkeyup','fwFormatarNumeroTJDFT(this)');
		$this->addEvent('onblur','fwValidarNumeroTJDFT(this)');
	}
	public function getFormated()
	{

		if( $this->getValue() )
		{
		    $value = preg_replace("[^0-9]","",$this->getValue());
			if ( ! $value) // nenhum valor informado
			{
				return null;
			}

			//#######-##.####.#.##.#### - 20 dígitos
			//0123456-78.9012.3.45.6789 
			//7-2.4.1.2.4
			if( strlen($value) == 20 )
			{
				$value = substr($value,0,7).'-'.substr($value,7,2).'.'.substr($value,9,4).'.'.substr($value,13,1).'.'.substr($value,14,2).'.'.substr($value,16,4);
			}
			else
			{
				//formatação para o número de 14 digitos
				//1999.01.1.001573-8
				//4.2.1.6-1
				$value = substr($value,0,4).'3'.substr($value,4,2).'.'.substr($value,6,1).'.'.substr($value,7,6).'-'.substr($value,14,1);
				null;
			}
			return $value;
		}
	}
}
?>