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

/**
* Substituir a fução alert() do javascript;
*/

$frm = new TForm('Exemplo de Diálogo de Confirmação', 300, 600);
$frm->addHtmlField('html', '<br><center><b>Exemplo de utilização da função fwConfirm() para substituir a função alert() do javascript</b></center>');
$frm->addTextField('nome', 'Nome:', 100, true, 50);
$frm->addDateField('nasc', 'Nascimento:', true);
$frm->addNumberField('salario', 'Salário', 10, false, 2);

$frm->addButton('Salvar', null, 'btnSalvar1', 'btnGravarClick()');

$_POST['formDinAcao'] = isset($_POST['formDinAcao']) ? $_POST['formDinAcao'] : '';
switch ($_POST['formDinAcao']) {
    case 'Gravar':
        if ($frm->validate()) {
            $frm->setMessage('Ação salvar executada com SUCESSO!!!');
        }
        break;
}
$frm->setAction('Atualizar');
$frm->show();
?>
<script>
function btnGravarClick(status)
{
    //fwConfirm('Confirma Gravação do Regirtro ?', function(){alert('ok')},function(){alert('não') }, 'Sim', 'Não', 'Salvar dados');
    fwConfirm('Confirma Gravação do Regirtro ?', cb,null, 'Sim', 'Não', 'Salvar dados');

}
function cb(p)
{
    if( p )
    {
        alert( 'Confirmado!' );
    }
    else
    {
        alert( 'Cancelado');
    }
}
</script>
