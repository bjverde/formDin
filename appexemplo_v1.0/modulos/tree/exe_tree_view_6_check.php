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

d($_REQUEST);


$html = 'Essa Funcionalidade não está completa, falta algumas coisas !';


$frm = new TForm('6 - TreeView with CheckBox', 400);


$frm->addButton('Atualizar', null, 'Atualizar', null, null, true, false);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->setAutoSize(true);
$frm->addCssFile('css/css_form04.css');

$frm->addHtmlField('html1', $html, null,null)->setClass('alert');


$frm->addGroupField('gpTree', 'Exemplo Treeview', null)->setcloseble(true);

    $tree = $frm->addTreeField('tree'
                              , null
                              , 'treecheck_link'
                              ,'ID_PAI'
                              ,'ID'
                              ,'NOME'
                              , null
                              , null, null);
    $tree->setStartExpanded(true);
    $tree->enableCheck(true);

    $tree->setOnCheck('treeCheck'); //Função chamada ao checar o item
    //$tree->setOnCheck('treeCheckOld'); //Função chamada ao checar o item
$frm->closeGroup();

$frm->addButton('Post');
$frm->addButton('Limpar', null, 'btnLimpar', 'fwClearChildFields()');

$frm->show();
?>
<script>
function treeCheck(id, checked){
    var postForm = {
             'id'     : id
            ,'checked': checked
        };
    jQuery.ajax({
         type: "POST"
        ,url: "treeview_salvar_check.php"
        ,data: postForm
        ,success: function(response, textStatus, jqXHR){
                console.log(response);
                console.log(textStatus);
                msg = jQuery.trim(response);
                if( msg ){
                    alert( msg );
                }
            }
        ,error: function(response, textStatus, jqXHR){
                console.log(response);
                console.log(textStatus);
                alert( 'erro:' + msg );
            }
    });
}
function treeCheckOld(id) {
    var checkState = treeJs.isItemChecked(id);

    alert( 'Item id:'+treeJs.getSelectedItemId()+'\n'+
    'stado checado:'+checkState+'\n'
    );    
}
</script>
