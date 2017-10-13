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

error_reporting(E_ALL);
$frm = new TForm('Exemplo Tree View',null,500);
$frm->setPosition('TR');
$frm->setAutoSize(true);



// exemplo de criação de uma treeview fora do formulário

// adicionar ao form os arquivos js e css necessários para o funcionamento da treeview
$frm->addJsFile('dhtmlx/dhtmlxcommon.js');
$frm->addJsFile('dhtmlx/treeview/dhtmlxtree.js');
$frm->addCssFile('dhtmlx/treeview/dhtmlxtree.css');

// criar o objeto treeview. 
$tree = new TTreeView('tree');

$tree->setWidth(400); // define a largura da área onde será exibida a treeview
$tree->setHeight(300); // define a altura da área onde será exibida a treeview

// adicionar manualmente os ítens na treeview
$tree->addItem(null,1,'Relatório',true);
$tree->addItem(1,11,'Financeiro',true,null,array('URL'=>'www.bb.com.br'));
$tree->addItem(1,12,'Orçamentário',true,null,array('URL'=>'www.bb.com.br'));

$tree->setOnClick('treeClick'); // fefinir o evento que será chamado ao clicar no item da treeview
$frm->addJavascript($tree->getJs());// gerar e adicionar na criação da pagina o codigo javascript que adiciona os itens na treeview
$tree->setXY(0,20); // posiciona a treeview na tela. left=0, top=100
$tree->show(); // exibe o tree view
$frm->addJavascript('jQuery("#tree_toolbar").hide();'); // esconder a toolbar da treeview 
// fim criação da treeview

$frm->setAction('Atulizar');	
$frm->show();
?>

<script>
function treeClick(id)
{
	alert( tree.getSelectedItemId());
	alert( tree.getItemText(id ) );
	alert( tree.getUserData(id,'URL') );
}
</script>

