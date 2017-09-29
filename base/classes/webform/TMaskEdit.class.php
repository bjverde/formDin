<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
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
*  Classe base para criação de inputs de texto com mascara de edição
*/
class TMaskEdit extends TEdit
{
	private $mask;
	public function __construct($strName,$strValue=null,$strMask=null,$boolRequired=null)
	{
		parent::__construct($strName,$strValue,null,$boolRequired);
		$this->setMask($strMask);
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
			//$this->setEvent('onKeyUp','fwColocarMascara(this,"'.$this->getMask().'",event)');
			$this->addEvent('onFocus','MaskInput(this,"'.$this->getMask().'")');
			// retirar a borda vermelha se o campo tiver sido validado errado
		}
		return parent::show($print);
	}
}
/*
return;
$campo = new TMaskEdit('teste','123456789','9.9.9.9.9.9.9.9.9',true);
$campo->show();
*/
/*
$cpf = new TCpfField('num_cpf','CPF:',true);
$cpf->show();
$cnpj = new TCnpjField('num_cnpj','CNPJ:',true);
$cnpj->show();
*/

?>