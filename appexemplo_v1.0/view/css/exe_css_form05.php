<?php

// simulação de dados para o gride
$dados = null;
$dados['ID'][]    = 1;
$dados['NOME'][]  = 'Linha1';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'A';

$dados['ID'][]    = 2;
$dados['NOME'][]  = 'Linha2';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'A';

$dados['ID'][]    = 3;
$dados['NOME'][]  = 'Linha3';
$dados['ATIVO'][] = 'N';
$dados['GRUPO'][] = 'C';

$frm = new TForm('Layout Form 05 - Forma Antiga', 200, 700);

$html ='Esse form mostra o exemplo do uso <b>$gride->setZebrarColors(</b>'
    .'<br>Evite usar essa função !! Procure usar o CSS.';
    $frm->addHtmlField('html1', $html, null)->setClass('alert');

$gride = new TGrid('gdTeste' // id do gride
, 'Título do Gride' // titulo do gride
, $dados   // array de dados
, null     // altura do gride
, null     // largura do gride
, 'ID');     // chave primaria

$gride->setZebrarColors('#ffffff', '#ff00ff');

$gride->addColumn('ID', 'id');
$gride->addRadioColumn('idCheckColumnPost', 'Nome Título', 'ID', 'NOME');
//$gride->addColumn('NOME','Nome',100);
$gride->addColumn('ATIVO', 'Ativo');
$gride->addColumn('GRUPO', 'grupo');
$frm->addHtmlField('gride', $gride);

$frm->setAction('POST PAGINA');
$frm->show();
