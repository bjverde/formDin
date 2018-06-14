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

$frm = new TForm('Exemplo de Criação de Gride');

$gride = new TGrid('idGride' // id do gride
, 'Título do Gride' // titulo do gride
, $dados     // array de dados
, 250        // altura do gride
, null       // largura do gride
, 'COD_UF');
$gride->setcss('font-size', '10px'); // altera o tamanho da fonte padrão para todo o gride
$gride->addExcelHeadField('Estado:', 'cod_uf'); // Informa ao gride que o campo cod_uf do formulário deve ser exportado para o excel tambem
$gride->autoCreateColumns(); // cria as colunas de acordo com o array de dados

//$gride->addColumn('NOM_UF','Nome',null,'center')->setCss('font-weight','normal');
//$gride->addButton('Gravar')->setClass('fwLink');
//$gride->addSelectColumn('cod_uf','Estado','cod_uf','uf',null,null,null,null,'COD_UF','SIG_UF');
//$gride->addSelectColumn('seq_fruta','Fruta','seq_fruta','fruta',null,null,null,null);


$gride->getTitleCell()->setCss('font-size', 20); // alterar a fonte do titulo do gride


$c = $gride->getColumn('NOM_UF');   // recuperar o objeto coluna NOM_UF
$c->setcss('font-size', '14');       // altera o tamanho da fonte da coluna NUM_UF


$h = $c->getHeader();                   // recuperar o objeto header da NOM_UF
$h->setCss('background-color', 'red');   // altera a cor de fundo do titulo da coluna para vermelha
$h->setCss('font-size', '14');           // altera o tamanho da fonte do titulo da coluna para 14


//$gride->addSelectColumn('seq_fruta','Fruta','seq_fruta','fruta',null,null,null,null,'SEQ_FRUTA','NOM_FRUTA');
$gride->setCache(-1); // não utiliza cache da classe banco ( IBAMA );

$frm->show();
return;

$frm->addHtmlField('campo_gride1');
$frm->addHtmlField('campo_gride2', null, null, null, null, 320);

$frm->addHtmlGride('campo_gride3', 'modulos/grid/exe_gride03_old.php', null, 250);
$frm->addHtmlField('campo_gride4', 'Clique no botão Criar Gride 4 Abaixo', null, null, null, 300, false);
$frm->addHtmlField('campo_gride5');
$frm->addHtmlField('campo_gride6');
$frm->addHtmlField('campo_gride7');
//gride 1
//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
/*
$gride = new TGrid('gd1','Gride Nº 1','TESTE.PKG_MOEDA.SEL_UF',450);
//$gride->setSortable(false);
$frm->addButton('Ativar Sort',null,'btnAtivar','ativarSort()');
//<div></div>$gride->setZebrarColors('#ffffff','#ffffff');
$gride->setCache(-1);
$gride->addColumn('des_letra','Letra',100);
$gride->addColumn('Nome do Estado','Estado',300);
*/

//$gride->addColumn('Nome do Estado','ESTADO');
//$gride->autoCreateColumns();

// não mostrar os botoes de alterar e excluir padrão
//$gride->enableDefaultButtons(false);
//$gride->addSelectColumn('sel_sig_moeda','Sigla','SIG_MOEDA','R$=Reais,US$=Dolar',null,null,'');
//$gride->addSelectColumn('selUF','Estado','SIG_UF','TESTE.PKG_MOEDA.SEL_UF',null,null,'-- Estados --');
//$gride->addColumn('NOME DA MOEDA','Nome da Moeda');
//$c=$gride->getColumn('SIG_UF');
//$c->setWidth(100);
//$frm->setValue('campo_gride1',$gride->show(false));

// gride 2
//-------------------------------------------------------------------------------------------------
/*
$gride = new TGrid('gd2','Gride Nº 2','TESTE.PKG_MOEDA.SEL_MOEDA',250
,null
,null
,null
,null
,null
,'gd2OnDrawCell'
,'gd2OnDrawRow'
,'gd2OnDrawHeader'
,null
);
$gride->autoCreateColumns();
$gride->addButton('Gravar',null,'btnGravar');
$gride->enableDefaultButtons(true);
$frm->setValue('campo_gride2',$gride->show(false));
$frm->addButton('Criar Gride 4',null,'btnCriarGride4','fwGetGrid("base/exemplos/gride4.php","campo_gride4",{"num_pessoa":""});');
*/

//$data = $gride->getData();
//---------------------------------------------------------------------------
// gride 5
//-------------------------------------------------------------------------------------------------
/*
$gride = new TGrid('gd5','Gride Nº 5'
,'TESTE.PKG_MOEDA.SEL_MOEDA',300
,null
,null
,null
,null
,null
,'gd5OnDrawCell'
,'gd5OnDrawRow'
,null
,'gd5onDrawButton'
);
$gride->addCheckColumn('sig_moeda','SIGLA','SEQ_MOEDA','SIG_MOEDA')->setWidth(200);
$gride->addColumn('SEQ_MOEDA','ID',100,'Center');
$frm->setValue('campo_gride5',$gride->show(false));
/*


//-------------------------------------------------------------------------------------------------
/*$g = new TGrid('gride_documento'
    ,'Lista de Documentos'
    ,'DOCIBAMA.PKG_PROT_DOCUMENTO.SEL_DOCUMENTO'
    ,200 // altura
    ,'100%' // largura
    ,'SEQ_DOCUMENTO','SEQ_DOCUMENTO',null,null,'grideDrawCel','grideDrawRow',null,'grideDrawButton');
$g->enableDefaultButtons(false);
$g->setReadOnly(true);
$g->addButton('Excluir','btngride_documentoExcluir',null,null,'Tem certeza que deseja excluir o Documento?','lixeira.gif');
*/
/*
$g->setBvars(array ('COD_ORIGEM'=>$_SESSION['RECIBO_ANDAMENTO']['seq_unidade_atual']
      ,'COD_ASSUNTO' =>$_SESSION[APLICATIVO]['cod_assunto']
      ,'SEQ_DOCUMENTO' =>$_SESSION[APLICATIVO]['seq_documento']
      ,'COD_UNIDADE_LOGADA' => $_SESSION['SISWEB']['login']['cod_unidade_ibama']));
*/

/*
$g->addCheckColumn('checkbox_1','Número','SEQ_DOCUMENTO','NUM_DOCIBAMA');
$g->addColumn('DES_TIPO_DOCUMENTO','Tipo');
$g->addColumn('DES_ASSUNTO','Resumo');
$g->addColumn('SIT_CONFIRMADO','confirmado');
$frm->setValue('campo_gride6',$g->show(false));
*/
//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------



/*
$res['CD_DEMANDA'][0]   = 1;
$res['DEMANDA'][0]      = 'Demanda';
$res['DEMANDANTE'][0]   = 'Luis Eugênio';

$g_Demanda = new TGrid('grd_Demanda','Demanda',$res);
//$g_Demanda->addColumn('CD_CEMANDA','Demanda');
$g_Demanda->addHiddenField('cd_demanda');
$g_Demanda->addColumn('DEMANDA','Demanda');
$g_Demanda->addColumn('DEMANDANTE','Demandante');
$g_Demanda->enableDefaultButtons(false);
$g_Demanda->addButton('Alterar','grd_Demanda_alterar',null,null,null,'alterar.gif',null,'Alterar');
$frm->setValue('campo_gride6',$g_Demanda->show(false));
*/

$frm->addSelectField('cod_uf', 'Estado:');
$gride = new TGrid('gd7', 'Gride Nº 7', 'UF', 450, null, 'COD_UF');
$gride->setcss('font-size', '10px');
$gride->addExcelHeadField('Estado:', 'cod_uf');
$gride->addColumn('NOM_UF', 'Nome', null, 'center')->setCss('font-weight', 'normal');
$gride->setCache(-1);
//$gride->autoCreateColumns();
$frm->setValue('campo_gride7', $gride);
//-------------------------------------------------------------------------------
$frm->setAction('Atualizar');
$frm->show();


//-------------------------------------------------------------------------------
// Eventos de tratamento dos Grides
//-------------------------------------------------------------------------------
function gd2OnDrawHeader($header, $coluna, $th)
{
    if ($coluna->getFieldName() == 'NOM_MOEDA') {
        $coluna->setTitle('Nome da Moeda');
        $coluna->setTextAlign('center');
        $th->setCss('background-color', 'yellow');
        $th->setCss('cursor', 'pointer');
        $header->setEvent('onclick', 'alert("cliquei na coluna")');
        $header->setHint('Este é o hint do titulo da coluna');
        $header->setHelpOnLine('Nome da Moeda', null, null, 'nom_moeda');
        $coluna->setSortable(false);
    } elseif ($coluna->getFieldName() == 'SIG_MOEDA') {
        $coluna->setTitle('Sigla da Moeda');
        $coluna->setTextAlign('center');
        $coluna->setCss('background-color', 'lightblue');
    } elseif ($coluna->getFieldName() == 'SIT_CANCELADO') {
        $coluna->setTitle('Cancelado ?');
        $coluna->setTextAlign('center');
    }
    // ou assim
    if ($coluna->getTitle() == 'SEQ_MOEDA') {
        $header->setvalue('Id');
        $header->setCss('color', 'red');
        $coluna->setCss('background-color', 'gray');
    }
}
function gd2OnDrawCell($rowNum, $cell, $objColumn, $aData, $edit)
{
    if ($objColumn->getFieldName() == 'SIG_MOEDA') {
        if ($cell->getValue() =='R$') {
            $cell->setCss('color', 'blue');
        }
    }
}
function gd2OnDrawRow($row, $rowNum, $aData)
{
    if ($aData['NOM_MOEDA']=='Libra') {
        // esconder a linha
        $row->setVisible(false);
    }
}
//-------------------------------------------------------------------
function gd5OnDrawCell($rowNum, $cell, $objColumn, $aData, $edit)
{
    if ($edit) {
        if ($aData['SIG_MOEDA']=='R$') {
            $edit->setProperty('disabled', '');
        }

        if ($edit->getProperty('checked')) {
            print 'Linha:'.$rowNum.' está selecionada, ';
        }
    }
}
//-------------------------------------------------------------------
function gd5onDrawButton($rowNum, $button, $objColumn, $aData)
{
    if ($aData['SIG_MOEDA']=='R$') {
        if ($button->getId()=='gd5Alterar') {
            //$button->setVisible(false);
            $button->setEnabled(false);
        }
        //$button->setEnabled(false);
    }
}
//--------------------------------------------------------------------
function grideDrawCel($a, $b, $c, $res, $edit)
{
    if ($edit) {
        //$edit->setProperty('checked','true');
        if ($res['SIT_CONFIRMADO'] == 'N') {
            $edit->setProperty('disabled', '');
        }
    }
}

//--------------------------------------------------------------------
function grideDrawButton($rowNum, $button, $objColumn, $aData)
{
    //if( $aData['SIT_CONFIRMADO']=='N')
    if ($aData['DES_TIPO_DOCUMENTO']=='COMUNICADO') {
        $button->setEnabled(false);
    }
}
//----------------------------------------------------------------------
function grideDrawRow($row, $rowNum, $aData)
{
    // esconder linha em função do $_POST
    if (is_array($_POST['checkbox_num_item'])) {
        if (! in_array($aData['SEQ_DOCUMENTO'], $_POST['checkbox_num_item'])) {
            $row->setVisible(false);
        }
    }

    switch ($aData['DES_TIPO_DOCUMENTO']) {
        case 'COMUNICACAO INTERNA':
            $row->setCss('color', 'red');
            break;
        case 'AVISO':
            $row->setCss('color', 'blue');
            break;
        case 'COMUNICADO':
            $row->setCss('color', 'green');
            break;
        case 'MEMORANDO':
            $row->setCss('color', 'purple');
            $row->setCss('background-color', 'yellow');
            break;
    }
}
