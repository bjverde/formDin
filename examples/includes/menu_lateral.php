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

include('../../base/classes/webform/TTreeView.class.php');
$page = new THtmlPage();

$page->addJsCssFile('../js/appJs.js');
$page->addJsCssFile('dhtmlx/dhtmlxcommon.js');
$page->addJsCssFile('dhtmlx/treeview/dhtmlxtree.js');
$page->addJsCssFile('dhtmlx/treeview/dhtmlxtree.css');
$page->addInHead('<script>var treeView;</script>');

// criar o objeto treeview.
$tree = new TTreeView('treeView');

$tree->setWidth(200); // define a largura da Ã¡rea onde serÃ¡ exibida a treeview
$tree->setHeight(300); // define a altura da Ã¡rea onde serÃ¡ exibida a treeview

// adicionar manualmente os Ã­tens na treeview
$tree->addItem(null,1,'Relatorio',true);
$tree->addItem(1,11,'Financeiro',true,null,array('URL'=>'www.bb.com.br'));

//$tree->setOnClick('treeClick'); // fefinir o evento que serÃ¡ chamado ao clicar no item da treeview
//$frm->addJavascript($tree->getJs());// gerar e adicionar na criaÃ§Ã£o da pagina o codigo javascript que adiciona os itens na treeview
$tree->setXY(0,100); // posiciona a treeview na tela. left=0, top=100
//$tree->show(); // exibe o tree view
$page->addInBody( $tree );
$page->addJavascript( $tree->getJs() );
$page->show();
?>
