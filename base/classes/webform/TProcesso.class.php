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
if( !function_exists('__autoload') )
{
	function __autoload($class_name) {
		require_once $class_name . '.class.php';
	}
}
class TProcesso extends TEdit
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
		parent::__construct($strName,$strValue,21,$boolRequired);
		$this->setFieldType('processo');
		$this->addEvent('onkeyup','fwFormatarProcesso(this)');
		$this->addEvent('onblur','fwValidarProcesso(this)');
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
			if( strlen($value) == 17 )
			{
				$value = substr($value,0,5).'.'.substr($value,5,6).'/'.substr($value,11,4).'-'.substr($value,15,2);
			}
			else
			{
				$value=substr($value,0,5).'.'.substr($value,5,6).'/'.substr($value,11,2).'-'.substr($value,13,2);
			}
			return $value;
		}
	}
}
?>