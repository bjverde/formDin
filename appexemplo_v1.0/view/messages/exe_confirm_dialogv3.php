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
$frm = new TForm('Exemplo de Caixa de Confirmação 3');
$frm->addCssFile('css/css_form02.css');

$html ='O exemplo faz uso do addButton com a função JS';
$frm->addHtmlField('html1', $html, null, null, null, 300)->setClass('notice2');

$frm->addGroupField('gpx1', 'Pegar Valor');
    $frm->addTextField('IDFIELD1', 'Informe um Valor', 40,true);
    $frm->addButton('Confirmar1', null, 'btnConfirmar1', 'fnBtnConfirmar1()',null,null,false);
$frm->closeGroup();

$frm->addGroupField('gpx2', 'Pegar Valor com submit form via JS');
    $frm->addTextField('IDFIELD2', 'Informe um Valor', 40,true);
    $frm->addButton('Confirmar2', null, 'btnConfirmar2', 'fnBtnConfirmar2()',null,null,false);
$frm->closeGroup();

$frm->addButton('Limpar', null, 'Limpar');

$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'btn05':
        $frm->setFieldValue('field5', 'Você falou SIM !! :-) ');
        break;
    //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields(null);
        break;
    //--------------------------------------------------------------------------------
}

$frm->show();
?>
<script>
function fnBtnConfirmar1()
{
	id = fwGetFieldValue('IDFIELD1');
	fwConfirm("O que deseja fazer com "+id+" ?"
			,confirmSim
			,confirmNao
			,"Repetir o Cadasro"
			,"Repetir a Consulta"
			,"Tome uma decisão");
}
function confirmSim() {
    alert('sim');
}
function confirmNao() {
    alert('nao');
}
</script>
