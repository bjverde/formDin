<?php
// simulação de dados para o gride
$dados = null;
$dados['ID'][]    = 1;
$dados['NOME'][]  = 'Linha1';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'A';
$dados['VALOR'][] = '7';


$dados['ID'][]    = 2;
$dados['NOME'][]  = 'Linha2';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'A';
$dados['VALOR'][] = '4';


$dados['ID'][]    = 3;
$dados['NOME'][]  = 'Linha3';
$dados['ATIVO'][] = 'N';
$dados['GRUPO'][] = 'C';
$dados['VALOR'][] = '5';

$dados['ID'][]    = 4;
$dados['NOME'][]  = 'Linha4';
$dados['ATIVO'][] = 'N';
$dados['GRUPO'][] = 'C';
$dados['VALOR'][] = '10';


$dados['ID'][]    = 5;
$dados['NOME'][]  = 'Linha5';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'C';
$dados['VALOR'][] = '3';


$frm = new TForm('Gride Draw 06 - Table HTML');

$html1 = '<b>ATENÇÃO</b>: Aqui não usa o GRID apenas cria uma tabela HTML comum, passando um array FormDin';
$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');

$tableHtml = new TTableArray();
$tableHtml->setData($dados);
$table1 = $tableHtml->show();
//FormDinHelper::debug($tableHtml->thead,'obj Tabela');
//FormDinHelper::debug($tableHtml,'obj Tabela');

$frm->addHtmlField('avisotabela1','Resultado simples, todas as colunas', null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');
$frm->addHtmlField('table1', $table1);

$tableHtml2 = new TTableArray();
$tableHtml2->setData($dados);
$tableHtml2->addColumn('NOME','Nome');
$tableHtml2->addColumn('VALOR','Valor');
$table2 = $tableHtml2->show();

$frm->addHtmlField('avisotabela2','Resultado simples, algumas colunas', null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');
$frm->addHtmlField('table2', $table2);

$frm->show();