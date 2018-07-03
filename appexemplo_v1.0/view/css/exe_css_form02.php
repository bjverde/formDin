<?php
// simulação de dados para o gride
$dados = null;
$dados['ID_TABELA'][] = 1;
$dados['NM_TABELA'][] = 'Linha1';
$dados['ST_TABELA'][] = 'S';
$dados['SIT_OPCOES'][] = '1=>Um,2=>Dois';

$dados['ID_TABELA'][] = 2;
$dados['NM_TABELA'][] = 'Linha2';
$dados['ST_TABELA'][] = 'S';
$dados['SIT_OPCOES'][] = '3=Tres,4=>Quatro';

$dados['ID_TABELA'][] = 3;
$dados['NM_TABELA'][] = 'Linha3';
$dados['ST_TABELA'][] = 'N';
$dados['SIT_OPCOES'][] = '3=Tres,4=>Quatro';


//d($_REQUEST);
$frm = new TForm('CSS Form 02 - Exemplo de uso do CSS', 300);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->setAutoSize(true);
$frm->addCssFile('css/css_form02.css');


$html ='Esse forma mostra o exemplo do uso de um css separado sobre alguns elmentos. Evite usar a funão setCSS ! O melhor é utilizar setClass com o addCssFile.';
$frm->addHtmlField('html1', $html, null, 'Dica:', null, 300)->setClass('notice');

$html2 ='Font Awesome Icons !! <i class="fab fa-php"></i> <i class="fab fa-bitcoin"></i>'
		.'<br><i class="fa fa-cloud"></i><i class="fa fa-heart"></i> '
		.'<i class="fa fa-bars"></i>  <i class="fa fa-file"></i>';
		
$frm->addHtmlField('html2', $html2, null,null, null, 300)->setClass('notice');

$frm->addDateField('data_pedido', 'Data:', false);
$frm->getLabel('data_pedido')->setClass('label', true);

$frm->addTextField('nome_comprador', 'Comprador:', 60, false, null)->setClass('text', true);
$frm->addSelectField('forma_pagamento', 'Forma Pagamento:', false, '1=Dinheiro,2=Cheque,3=Cartão');
$frm->addTextField('QTD', 'Quantidade de Itens', 50, false);

$frm->addButton('post', 'post', null, null, null, true, false)->setClass('btnOragen', false);
$frm->addButton(null, 'post', null, null, null, true, false)->setClass('btnImg', false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false)->setClass('buttonBigGreen', true);

$gride = new TGrid('gdTeste' // id do gride
, 'Título do Gride' // titulo do gride
, $dados     // array de dados
, null       // altura do gride
, null       // largura do gride
, 'ID_TABELA');// chave primaria


$gride->addCheckColumn('st_tabela', 'Selecione', 'ST_TABELA', 'NM_TABELA')->setEvent('onClick', 'chkClic()');
$gride->addColumn('nm_tabela', 'Nome');
$gride->addColumn('ST_TABELA', 'Status');
$gride->addButton('Alterar 1', null, 'btnAlterar1', 'grideAlterar()', null, 'editar.gif', 'editar.gif', 'Alterar registro')->setEnabled(false);
$gride->addButton('Alterar 2', null, 'btnAlterar2', 'grideAlterar()', null, null, null, 'Alterar registro')->setEnabled(false);
$gride->addButton('Excluir', null, 'btnExcluir', 'grideAlterar()', null, null, null)->setEnabled(false)->setClass('buttonGridRed', true);
$gride->addButton('Ir para Redirect 2', 'btnRedirect2', null, null, null, null, null, null, true)->setClass('buttonGridBlue', true);

// função de callback da criação das celulas
$gride->setOnDrawCell('gdAoDesenharCelula');
// campo html para exibir o gride
$frm->addHtmlField('gride', $gride);


$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'Ir submit':
        //Redirect só funciona se o arquivo estiver na pasta modulos
        $frm->redirect('exe_redirect_form2.inc', 'Redirect realizado com sucesso. Você está agora no 2º form.', true);
        break;
        //------------------------------------------------------------------
    case 'Ir Ajax':
        //Redirect só funciona se o arquivo estiver na pasta modulos
        $frm->redirect('exe_redirect_form2.inc', 'Redirect realizado com sucesso. Você está agora no 2º form.', false, null);
        break;
        //------------------------------------------------------------------
    case 'btnRedirect2':
        //Redirect só funciona se o arquivo estiver na pasta modulos
        $frm->redirect('exe_redirect_form2.inc', 'Redirect realizado com sucesso. Você está agora no 2º form.', false, null);
        break;
        //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
}

$frm->show();
