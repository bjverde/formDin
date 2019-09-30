<?php
d($_REQUEST);
$frm = new TForm('CSS Form 04 - Exemplo de uso do CSS, no grid com Font Awesome', 300, 800);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->setAutoSize(true);
$frm->addCssFile('css/css_form04.css');

// simulação de dados para o gride
$dados = null;
$dados['ID'][]    = 1;
$dados['NOME'][]  = 'Linha1';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'A';
$dados['FONT'][] = '<span class="icon btc"></span> Login';

$dados['ID'][]    = 2;
$dados['NOME'][]  = 'Linha2';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'A';
$dados['FONT'][] = '<span class="gold"><i class="fab fa-bitcoin"></i></span>';

$dados['ID'][]    = 3;
$dados['NOME'][]  = 'Linha3';
$dados['ATIVO'][] = 'N';
$dados['GRUPO'][] = 'C';
$dados['FONT'][] = '<span class="success"><i class="fab fa-bitcoin"></i></span>';

$dados['ID'][]    = 4;
$dados['NOME'][]  = 'Linha4';
$dados['ATIVO'][] = 'N';
$dados['GRUPO'][] = 'C';
$dados['FONT'][] = '<span class="azul"><i class="fab fa-php"></i></span>';

$dados['ID'][]    = 5;
$dados['NOME'][]  = 'Linha5';
$dados['ATIVO'][] = 'N';
$dados['GRUPO'][] = 'C';
$dados['FONT'][] = '<span class="gold"><i class="fab fa-bitcoin"></i></span>';

$html ='Esse form mostra o exemplo do uso de um css separado sobre alguns elmentos.'
    .'<br>Evite usar a funão setCSS ! O melhor é utilizar setClass com o addCssFile.';
    $frm->addHtmlField('html1', $html, null, 'Dica:')->setClass('alert');


$gride = new TGrid('gdTeste' // id do gride
                , 'Título do Gride' // titulo do gride
                , $dados   // array de dados
                , null     // altura do gride
                , null     // largura do gride
                , 'ID');     // chave primaria


$gride->addColumn('ID', 'id');
$gride->addColumn('NOME', 'Nome');
$gride->addColumn('ATIVO', 'Ativo');
$gride->addColumn('GRUPO', 'grupo');
$gride->addColumn('FONT', 'Font Awesome',null,'center');


$gride->addbutton('Alterar', $gride->getId() .'_alterar', null, null, null, 'alterar.gif', null, 'Alterar' );
$gride->addButton('Excluir', $gride->getId() .'_excluir', null, 'fwGridConfirmDelete()', null, 'lixeira.gif', null, 'Excluir' );
$gride->addButton('Normal','gd_btn1','btn1',null,null,null,null,'Ação 01');
$gride->addButton(null,'gd_btn2','btn2',null,null,null,null,'Ação 02')->setClass('icon login', true);
$gride->addButton(null,'gd_btn3','btn3',null,null,null,null,'Ação 03')->setClass('icon btc', true);
$gride->addButton('Verde','gd_btn4','btn4',null,null,null,null,'Ação 04')->setClass('buttonBigGreen', true);
$gride->addButton('xxx','gd_btn5','btn5',null,null,null,null,'Ação 05')->setClass('buttonNoBorder icon login', true);
$gride->addButton('xxx','gd_btn6','btn6',null,null,null,null,'Ação 06')->setClass('buttonTransparent icon login', true);
$gride->addButton(null,'gd_btn7','btn7',null,null,null,null,'Ação 07')->setClass('buttonTransparent icon php', true);
$gride->addbutton('Alterar', $gride->getId() .'_alterar', null, null, null, 'alterar.gif', null, 'Alterar' );
$gride->addButton('Excluir', $gride->getId() .'_excluir', null, 'fwGridConfirmDelete()', null, 'lixeira.gif', null, 'Excluir' );

$frm->addHtmlField('gride', $gride);

$frm->setAction('POST PAGINA');
$frm->show();
