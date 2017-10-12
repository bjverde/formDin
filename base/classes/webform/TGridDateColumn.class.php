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

class TGridDateColumn extends TGridEditColumn
{
	/**
	* Implementa coluna para entrada datas no gride
	*
	* @param string $strEditName
	* @param string $strTitle
	* @param string $strFieldName
	* @param string $strMaskType
	* @param string $strWidth
	* @param string $strAlign
	* @param boolean $boolReadOnly
	* @return TGridDateColumn
	*/

	public function __construct($strEditName,$strTitle=null,$strFieldName=null,$strMaskType=null,$strWidth=null,$strAlign=null,$boolReadOnly=null)
	{
		parent::__construct($strEditName,$strTitle,$strFieldName,'date',10,10,$strMaskType,$strWidth,$strAlign,$boolReadOnly);
	}
	///---------------------------------------------------------------------------------------------------
	public function getEdit()
	{
	 	$edit = new TDate(strtolower($this->getEditName()).'['.$this->getKeyValue().']',$this->getValue(),false,null,null,$this->getMask());
	 	$edit->setId(strtolower($this->getEditName()).'_'.$this->getRowNum());
     	$edit->setExampleText(''); // não exibir o texto exemplo na frente do campo
     	$edit->setButtonVisible(false); // não exibir o botão calendário
        $edit->setCss($this->getCss());
   		if( is_null( $edit->getCss('border') ) )
		{
			$edit->setCss('border','1px solid silver');
		}
        $edit->setEvents($this->getEvents());
        return $edit;
	}
}
?>