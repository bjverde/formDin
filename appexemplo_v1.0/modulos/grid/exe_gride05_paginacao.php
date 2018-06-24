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

$frm = new TForm('Exemplo Paginação do Gride', null, 600);
$frm->addHtmlField('mensagem', "<h3>Este exemplo utiliza a tabela tb_paginacao do banco de dados bdApoio.s3db (sqlite).</h3>");

if (isset($_REQUEST['ajax'])  && $_REQUEST['ajax']) {
                $res = TPDOConnection::executeSql("select * from tb_paginacao");
                $g = new TGrid('gd', 'Gride com Paginação', $res, 200, null, 'ID', 'descricao', 10, 'grid/exe_gride05_paginacao.php');
                $g->setOnDrawActionButton('onDraw');
                $g->addColumn('id', 'Id', 50, 'center');
                $g->addColumn('descricao', 'Descrição', 1200, 'left');
                //$g->addButton('Alterar','alterar','btnAlterar','alterar()',null,'editar.gif');
                //$g->addButton('Excluir','excluir','btnExcluir',null,null);
                //$g->setCreateDefaultDeleteButton(false);
                //$g->setCreateDefaultEditButton(false);
                $g->enableDefaultButtons(false);

                $g->show();
                die();
}
//print_r( $_REQUEST);
$frm->addHtmlField('html_gride');
$frm->setAction("Refresh");
$frm->addJavascript('init()');
$frm->show();

function onDraw($rowNum, $button, $objColumn, $aData)
{
    //$button->setEnabled( false );
    if ($button->getName() == 'btnAlterar') {
        if ($rowNum == 1) {
            $button->setEnabled(false);
        }
    }
}

?>
<script>
function init()
{
                fwGetGrid("grid/exe_gride05_paginacao.php",'html_gride');
}
// recebe fields e values do grid
function alterar(f,v)
{
    var dados = fwFV2O(f,v);
    fwModalBox('Alteração','index.php?modulo=exe_gride_form_edicao.php',300,800,null,dados);
}
</script>



