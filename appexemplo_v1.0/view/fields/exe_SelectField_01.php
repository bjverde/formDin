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

d($_REQUEST);

$frm = new TForm('Exemplo do Campo Select Simples', 450);
$frm->setFlat(true);
$frm->setShowCloseButton(false);

$frm->addGroupField('gp1', 'Selects Normais');
    $listFormas = array(1=>'Dinheiro',2=>'Cheque',3=>'Cartão',4=>'BitCoin');
    $frm->addSelectField('forma_pagamento'     // 1: ID do campo
                       , 'Forma Pagamento:'
                       , TRUE
                       , $listFormas           // 4: array dos valores
                       , null
                       , null
                       , null
                       , null
                       , null  //  9: Num itens que irão aparecer
                       , null  // 10: Largura em Pixels
                       , ' '   // 11: First Key in Display
                       , null  // 12: Frist Valeu in Display, use value NULL for required
                       );
    
    $fg2 = $frm->addSelectField('forma_pagamento2'     // 1: ID do campo
                               , 'Forma Pagamento (DEFAULT):'
                               , TRUE                  // 3: Obrigatorio
                               , $listFormas           // 4: array dos valores
                               , true                  // 5: Default TRUE = cria nova linha , FALSE = fica depois do campo anterior
                               , true                  // 6: Default FALSE = Label mesma linha, TRUE = Label acima
                               , null                  // 7: Valor DEFAULT, informe o ID do array
                               , null
                               , null  //  9: Num itens que irão aparecer
                               , 150   // 10: Largura em Pixels
                               , null   // 11 First Key in Display
                               , null     // 12 Frist Valeu in Display, use value NULL for required
                               ,2
                               );
    $fg2->setToolTip('Campo com valor DEFAULT pré-selecionado');
    
    $fg2 = $frm->addSelectField('forma_pagamento3'     // 1: ID do campo
                            , 'Forma Pagamento (DEFAULT):'
                            , TRUE                  // 3: Obrigatorio
                            , $listFormas           // 4: array dos valores
                            , true                  // 5: Default TRUE = cria nova linha , FALSE = fica depois do campo anterior
                            , true                  // 6: Default FALSE = Label mesma linha, TRUE = Label acima
                            , null                  // 7: Valor DEFAULT, informe o ID do array
                            , null
                            , null  //  9: Num itens que irão aparecer
                            , 150   // 10: Largura em Pixels
                            , ' '   // 11 First Key in Display
                            , 4     // 12 Para o valor DEFAULT informe o ID do $mixOptions e $strFirstOptionText = '' não pode ser null
                            );
    $fg2->setToolTip('Campo com valor DEFAULT pré-selecionado, ATRIBUTO 12');
    
    
    $frm->addSelectField('estado', 'Estado (todos):', false, 'tb_uf', true, false, null, false, null, null, '-- selecione o Estado --', null, 'COD_UF', 'NOM_UF', null, 'cod_regiao')->addEvent('onChange', 'select_change(this)')->setToolTip('SELECT - esta campo select possui o código da região adicionado em sua tag option. Para adicionar dados extras a um campo select, basta definir as colunas no parâmetro $arrDataColumns.');
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
                        , $arrayBiomas  // 4: array dos valores
                        , null
                        , null
                        , null
                        , true);
    
    $frm->addSelectField('seq_bioma2'
                        , 'Bioma:'
                        , false
                        , $arrayBiomas  // 4: array dos valores
                        , null
                        , null
        ,3  // 7: Valor DEFAULT, informe o ID do array array(0=>3,1=>4)
                        , true);


    $frm->addSelectField('estadomultiselect'
                        , 'Estado (todos):'
                        , false
                        , 'tb_uf'      // 4: array dos valores. tb_uf vem do SqLite Configurdo na app de exemplo
                        , true
                        , false
                        , null
                        , true
                        , 5          // 9: Num itens que irão aparecer
                        , null       // 10: Largura em Pixels
                        , '-- selecione o Estado --'
                        , null
                        , 'COD_UF'
                        , 'NOM_UF'
                        , null
                        , 'cod_regiao');
$frm->closeGroup();

$frm->addButton('Salvar', null, 'Salvar', null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    case 'Limpar':
        $frm->clearFields();
    break;
    //--------------------------
    case 'Salvar':
        $frm->validate();
    break;
}
$frm->show();
?>