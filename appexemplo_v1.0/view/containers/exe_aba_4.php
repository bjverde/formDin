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

$frm= new TForm('Exemplo de Criação de Gride', 600);
//$frm->setOverflowY(false);
//$frm->setOverflowY(true);
$frm->setFlat(true);


// html dentro do form
$frm->addHtmlField('campo_gridex', null, null, null, 100)->setCss('border', '1px solid green'); // cria o campo para exibição do gride

//grupo dentro do form
$frm->addGroupField('gp', 'Luis', 150, null, null, null, true)->setOverflowY(false);
    $frm->addHtmlField('campo_gride2', null, null, null, 100)->setCss('border', '1px solid green'); // cria o campo para exibição do gride
$frm->closeGroup();

// aba dentro do form
$pc = $frm->addPageControl('pc', 150);
$pc->addPage('Cadastro', true, true);
    $frm->addHtmlField('campo_gride', null, null, null, 500)->setcss('border', '1px solid green'); // cria o campo para exibição do gride
$frm->closeGroup();

//**************************************************************************
// aba dentro de aba
$pc = $frm->addPageControl('pc1', 150);
    $pc->addPage('Cadastro', true, true);
    $pc2 = $frm->addPageControl('pc2');
    $pc2->addPage('Subcadastro', true, true);
    $frm->closeGroup();
 $frm->closeGroup();



// grupo dentro de aba
$pc = $frm->addPageControl('pc1', 150);
    $pc->addPage('Cadastro', true, true);
        $g=$frm->addGroupField('gp2rew', 'Eugenio', 400, null, null, null, true, null, null, null, null, null, true);
        $frm->closeGroup();
    $frm->closeGroup();
 $frm->closeGroup();
$frm->closeGroup();

// grupo dentro de grupo
$frm->addGroupField('gp2dg', 'Eugenio', null, null, null, null, true, null, null, null, null, null, true);
    $frm->addGroupField('gp2dg2', 'Barbosa', null, null, null, null, true, null, null, null, null, null, true);
        $frm->addGroupField('gp2dg21', 'Barbosa', 100, null, null, null, true, null, null, null, null, null, true);

        $frm->closeGroup();
    $frm->closeGroup();
$frm->closeGroup();

// aba dento de aba
$pc = $frm->addPageControl('pcADA', 150);
    $pc->addPage('Cadastro', true, true);
    $frm->addDateField('data1', 'Data1:');
    $pc2 = $frm->addPageControl('pcada2');
    $pc2->addPage('Subaba', true, true);
        $frm->addDateField('data2', 'Data2');
        $pc3 = $frm->addPageControl('pcada21');
        $pc3->addPage('Subaba2', true, true);
        $frm->addDateField('data3', 'Data3:');

    $frm->closeGroup();
 $frm->closeGroup();
$frm->closeGroup();




// criação do array de dados
for ($i=0; $i<100; $i++) {
    $res['SEQ_GRIDE'][] = ($i+1);
    $res['NOM_LINHA'][] = 'Linha nº '. ($i+1);
    $res['DES_LINHA'][] = str_repeat('Linha ', 40);
}

$gride = new TGrid('idGride' // id do gride
, 'Título do Gride' // titulo do gride
, $res       // array de dados
, 250        // altura do gride
, '100%'     // largura do gride
, 'SEQ_GRIDE', null, 10, 'exe_gride_1.php', null);
$gride->addColumn('nom_linha', 'Nome', 100);
$gride->addColumn('des_linha', 'Descricao', 1200);

//$gride->autoCreateColumns(); // cria as colunas de acordo com o array de dados
$gride->setNoWrap(false);

// quando for uma chamada ajax, devolver apenas o conteudo do gride, sem o formulário
if (isset($_REQUEST['ajax'])) {
    $gride->show();
    exit(0);
}
//error_reporting(E_ALL);
$frm->set('campo_gride', $gride); // adiciona o objeto gride ao campo html
$frm->setAction('Atualizar');
$frm->show();
