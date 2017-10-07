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

$frm = new TForm('Estilos do Menu Principal',230,600);
$frm->setCss('background-color','#FAFAD2');
$frm->addHtmlField('current','')->setCss(array('font-size'=>14,'color'=>'blue','text-align'=>'center','margin-bottom'=>"10px"));
$frm->addButton('standard',null,'btn1','setMenu("standard")',null,true,false);
$frm->addButton('aqua_dark',null,'btn2','setMenu("aqua_dark")',null,false,false);
$frm->addButton('aqua_sky',null,'btn3','setMenu("aqua_sky")',null,false,false);
$frm->addButton('aqua_orange',null,'btn4','setMenu("aqua_orange")',null,false,false);
$frm->addButton('clear_blue',null,'btn5','setMenu("clear_blue")',null,false,false);
$frm->addButton('clear_green',null,'btn6','setMenu("clear_green")',null,false,false);

$frm->addButton('dhx_black',null,'btn7','setMenu("dhx_black")',null,true,false);
$frm->addButton('dhx_blue',null,'btn8','setMenu("dhx_blue")',null,false,false);
$frm->addButton('glassy_blue',null,'btn9','setMenu("glassy_blue")',null,false,false);
$frm->addButton('modern_black',null,'btn10','setMenu("modern_black")',null,false,false);
$frm->addButton('modern_black',null,'btn11','setMenu("modern_black")',null,false,false);
$frm->addButton('modern_blue',null,'btn12','setMenu("modern_blue")',null,false,false);

$frm->addButton('modern_red',null,'btn13','setMenu("modern_red")',null,true,false);
$frm->addButton('clear_silver',null,'btn14','setMenu("clear_silver")',null,false,false);

$frm->addHtmlField('message','Para alterar o tema do menu, adicione a linha <blink><b><span id="exemplo">$app->setMenuTheme("clear_silver");</span></b></blink> no index.php')->setCss(array('font-size'=>12,'color'=>'red','text-align'=>'center','font-weight'=>'normal','margin-top'=>'10px'));

$frm->addJavascript('jQuery("#current").html(top.menuTheme+"<br/>")');
$frm->show();
?>
<script>
function setMenu(tema)
{
	top.app_change_menu_theme(tema,'menu_principal.php');
	jQuery("#current").html(tema);
	jQuery("#exemplo").html('$app->setMenuTheme("'+tema+'");');

}
</script>

