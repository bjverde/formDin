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

$frm = new TForm('Exemplo 9 : Estados e Municípios com Método setando campos', 600);

$frm->addHtmlField('obs1', '<b>Este exemplo utiliza as tabelas vw_tree_regiao_uf_mun do banco de dados bdApoio.s3db ( sqlite )</b>');

$frm->addGroupField('gpFields', 'Campos');
    $frm->addTextField('ID_PAI', 'Id Pai:', 20);
    $frm->addTextField('ID', 'id:', 20,null,null,null,false);
    $frm->addTextField('NOME', 'Nome:', 60);
    $frm->addTextField('SIG_UF', 'Sigla:', 30);
    $frm->addTextField('COD_REGIAO', 'Cod Região:',30,null,null,null,false);
$frm->closeGroup();  // fim do grupo

$frm->addButton('Atualizar', null, 'Atualizar', null, null, true, false);
$frm->addButton('Limpar'   , null, 'btnLimpar', 'fwClearChildFields()', null, false, false);

// adicionar grupo
$frm->addGroupField('gpTree', 'Exemplo Treeview com Fonte de Dados Definido pelo Usuário');
    //$mixUserDataFields = array('ID_PAI','ID','NOME');
    $mixUserDataFields = 'ID,ID_PAI,NOME,COD_REGIAO';
    //$mixUserDataFields = 'ID,ID_PAI,NOME';
    $tree = $frm->addTreeField('tree'
                              ,'Região/Extados/Municípios'
                              ,'vw_tree_regiao_uf_mun'
                              ,'ID_PAI'
                              ,'ID'
                              ,'NOME'
                              ,null
                              ,$mixUserDataFields
                              ,320
                              ,null);
    $tree->setShowToolBar(false);
    $tree->setStartExpanded(true);  // iniciar aberta
    $tree->setOnClick('treeClick'); // fefinir o evento que será chamado ao clicar no item da treeview
$frm->closeGroup();  // fim do grupo

// exibir o formulário
$frm->show();
?>
<script>
function treeClick(id) {
    // atualizar os campos do formulário
    jQuery("#ID").val(treeJs.getSelectedItemId());
    jQuery("#NOME").val(treeJs.getItemText(id));
    jQuery("#ID_PAI").val(treeJs.getUserData(id,'ID_PAI'));
    jQuery("#SIG_UF").val(treeJs.getUserData(id,'SIG_UF'));
    jQuery("#COD_REGIAO").val(treeJs.getUserData(id,'COD_REGIAO'));
}
</script>
