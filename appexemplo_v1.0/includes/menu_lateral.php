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

include('../../base/classes/webform/TApplication.class.php');


$page = new THtmlPage();

$page->addJsCssFile('../css/css_form.css');
$page->addJsCssFile('../js/appJs.js');
$page->addJsCssFile('dhtmlx/dhtmlxcommon.js');
$page->addJsCssFile('dhtmlx/treeview/dhtmlxtree.js');
$page->addJsCssFile('dhtmlx/treeview/dhtmlxtree.css');
$page->addInHead('<script>var treeView;</script>');

// criar o objeto treeview.
$tree = new TTreeView('treeView');

$tree->setWidth(200); // define a largura da área onde será exibida a treeview
$tree->setHeight(300); // define a altura da área onde será exibida a treeview

// adicionar manualmente os ítens na treeview
$tree->addItem(null,1,'Relatório',true);
$tree->addItem(1,11  ,'Financeiro',true,null,array('URL'=>'www.bb.com.br'));
$tree->addItem(1,12  ,'Orçamentário',true,null,array('URL'=>'www.bcb.gov.br'));

$tree->setOnClick('treeClick');     // Definir o evento que será chamado ao clicar no item da treeview
//$page->addJavascript($tree->getJs());// Gerar e adicionar na criação da pagina o codigo javascript que adiciona os itens na treeview
$tree->setXY(0,100); // posiciona a treeview na tela. left=0, top=100
$tree->show(); // exibe o tree view
//$page->addInBody( $tree );
$page->addJavascript( $tree->getJs() );
$page->show();
?>
<script>
function treeClick(id) {

	/*
	alert( 'Item id:'+treeJs.getSelectedItemId()+'\n'+
	'Item text:'+treeJs.getItemText(id )+'\n'+
	'User pai:'+treeJs.getUserData(id,'IDMENU_PAI')+'\n'+
	'User data URL:'+treeJs.getUserData(id,'URL')+'\n'+
	'IMG:'+treeJs.getUserData(id,'IMG_MENU')
	);
	*/

	
	alert( treeJs.getSelectedItemId());
	alert( treeJs.getItemText(id ) );
	alert( treeJs.getUserData(id,'URL') );

	jQuery("#item").val(treeJs.getSelectedItemId());
	jQuery("#NOM_MENU").val(treeJs.getItemText(id ));
	jQuery("#link").val(treeJs.getUserData(id,'URL'));
}
</script>
