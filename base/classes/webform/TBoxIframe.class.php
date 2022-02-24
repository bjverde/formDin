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

class TBoxIframe extends Tbox
{
	private $strUrl;
	private $strTitle;
	public function __construct(string $strTitle=null
	                           ,string $strUrl
							   ,string $strName=null,$strHeight=null,$strWidth=null,$boolFlat=null)
	{
		$strHeight = is_null($strHeight) ? 600 : $strHeight;
		$strWidth = is_null($strWidth) ? 800 : $strWidth;
		parent::__construct($strName,$strWidth,$strHeight,$boolFlat);
		$this->divBody->setCss('overflow','hidden');
		$this->setUrl($strUrl);
		$this->setTitle($strTitle);
	}
	public function setUrl($newUrl=null)
	{
		$this->strUrl = $newUrl;
	}
	public function getUrl()
	{
		return $this->strUrl;
	}
	public function setTitle($newTitle=null)
	{
		$this->strTitle = $newTitle;
	}
	public function getTitle()
	{
		return $this->strTitle;
	}
	public function show($print=true,$flat=false)
	{
		$this->divBody->add('<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%"><tr><td height="*" width="99%" style="font-family:arial,helvetica, geneva, sans-serif;font-size:18px;height:18px;text-align:center;color:#256391;font-weight:bold;vertical-align:middle;" >'.$this->getTitle().'</td><td width="*"><img style="float:right;cursor:pointer;" onClick="fwFecharFormulario(\''.$this->getId().'\',true);" src="'.$this->getBase().'imagens/fwbtnclosered.jpg"></td></tr><tr><td colspan="2" height="99%" style="overflow:auto;">
				<iframe id="iframe_'.$this->getId().'" style="width:100%;height:99%;" frameborder="0" marginheight="0" marginwidth="0" src="'.$this->getUrl().'"></iframe></td></tr></table>');
		return parent::show($print,$flat);
	}
}
//$box = new TBoxIframe('Teste do Box IFrame','http://www.bb.com.br','biTeste',500,800,false);
//$box->show();
?>