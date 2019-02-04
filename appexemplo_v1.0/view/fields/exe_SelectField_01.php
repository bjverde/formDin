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

$frm = new TForm('Exemplo do Campo Select Simples', 450);

$frm->addSelectField('estado', 'Estado (todos):', true, 'tb_uf', true, false, null, false, null, null, '-- selecione o Estado --', null, 'COD_UF', 'NOM_UF', null, 'cod_regiao')->addEvent('onChange', 'select_change(this)')->setToolTip('SELECT - esta campo select possui o código da região adicionado em sua tag option. Para adicionar dados extras a um campo select, basta definir as colunas no parâmetro $arrDataColumns.');

$frm->addGroupField('gp1', 'Selects Normais');
    $f = $frm->addSelectField('sit_cancelado', 'Cancelado:', null, '0=Não,1=Sim', null, null, '1')->addEvent('onChange', 'select_change(this)');
    $f->setOptionsData(array('0'=>'Zero','1'=>'Um'));
$frm->closeGroup();


$frm->addGroupField('gp5', 'Selects MultiSelect');
    $arrayBiomas = array();
    $arrayBiomas['AM']='Amazônia';
    $arrayBiomas['CE']='CERRADO';
    $arrayBiomas['CA']='Caatinga';
    $arrayBiomas['PA']='PANTANAL';
    $arrayBiomas['MA']='MATA ATLÂNTICA';
    $arrayBiomas['PM']='Pampa';
    $frm->addSelectField('seq_bioma'
                        , 'Bioma:'
                        , true
                        , $arrayBiomas
                        , null
                        , null
                        , null
                        , true);


    $frm->addSelectField('estadomultiselect'
        , 'Estado (todos):'
        , true
        , 'tb_uf'
        , true
        , false
        , null
        , true
        , null
        , null
        , '-- selecione o Estado --'
        , null
        , 'COD_UF'
        , 'NOM_UF'
        , null
        , 'cod_regiao');
$frm->closeGroup();

$frm->setAction('Atualizar,Validar');
$frm->addButton('Limpar', null, 'btnLimpar', 'btnLimparClick()');
$frm->addButton('Iniciar Estado 2', null, 'btnUF2', 'btnUF2Click()');

$acao = isset($acao) ? $acao : null;
if ($acao=='Validar') {
    //d($_POST);
    $frm->validate();
}

$frm->show();
?>