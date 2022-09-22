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

$frm = new TForm('Exemplo 9 : Estados e Municípios com Método setando campos', 800);

$frm->addHtmlField('obs1', '<b>Este exemplo utiliza as tabelas vw_tree_regiao_uf_mun do banco de dados bdApoio.s3db ( sqlite )</b>');

$frm->addGroupField('gpFields', 'Campos');
    $frm->addTextField('ID_PAI', 'Id Pai:', 10);
    $frm->addTextField('ID', 'id:', 60);
    $frm->addTextField('NOME', 'Nome:', 60);
    $frm->addTextField('sig_unidade', 'Sigla:', 60);
$frm->closeGroup();  // fim do grupo

// adicionar grupo
$frm->addGroupField('gpTree', 'Exemplo Treeview com Fonte de Dados Definido pelo Usuário')->setcloseble(true);
    // adicionar o campo Treeview ao formulário
    $tree = $frm->addTreeField('tree'
                              ,'Região/Extados/Municípios'
                              ,'vw_tree_regiao_uf_mun'
                              ,'ID_PAI'
                              ,'ID'
                              ,'NOME'
                              ,null, null, 320);
    $tree->setStartExpanded(true);  // iniciar aberta
    $tree->setOnClick('treeClick'); // fefinir o evento que será chamado ao clicar no item da treeview
$frm->closeGroup();  // fim do grupo

$frm->addButton('Post');
$frm->addButton('Limpar', null, 'btnLimpar', 'fwClearChildFields()');

// exibir o formulário
$frm->show();
?>
<script>
function treeClick(id)
{
    /*
    alert( 'Item id:'+treeJs.getSelectedItemId()+'\n'+
    'Item text:'+treeJs.getItemText(id )+'\n'+
    'User data URL:'+treeJs.getUserData(id,'URL_UNIDADE')
    );
    */
    // atualizar os campos do formulário
    jQuery("#cod_unidade").val(treeJs.getSelectedItemId());
    jQuery("#nom_unidade").val(treeJs.getItemText(id ));
    jQuery("#url_unidade").val(treeJs.getUserData(id,'URL_UNIDADE'));
    jQuery("#sig_unidade").val(treeJs.getUserData(id,'SIG_UNIDADE'));
    
}
</script>
