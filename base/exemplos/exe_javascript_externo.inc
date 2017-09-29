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

/*
A classe TApplication prcourará pelo aquivo javascript com o mesmo nome do modulo e com aextensão .js na
pasta js/ do aplicativo. Se encontrar este será adicionado na página gerada
*/
$frm = new TForm('Arquivos JS e CSS externos');
$frm->addTextField('nom_pessoa','Nome:',50,true,50,null,true,'Campo Texto','ex: texto livre',false,true);
$frm->addHtmlField('mensagem','<hr>Neste formulário foram incluídos os arquivos:<ul><li><b>js/exe_javascript_externo.js</b>;</li><li><b>css/exe_javascript_externo.css</b></li></ul><br>A classe TForm, automaticamente, procura pelos arquivos js e css, na pasta js/ e css/, que possuirem o mesmo nome do módulo postado.</b>');
$frm->getField('nom_pessoa')->addEvent('onBlur','if( this.value){Alerta2(this.value)}');
$frm->setAction('Refresh');
// pode ser adicionado arquivo js manualmente
$frm->addJsFile('teste.js');
if( $frm->getField('nom_pessoa')->validate() )
{
	$frm->setPopUpMessage('Campo Nome ok');
}
// pode ser adicionado arquivo css manualmente
$frm->addCssFile('teste.css');
$frm->show();
?>
