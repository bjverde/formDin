<?php
d($_REQUEST);
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


$frm = new TForm('Gride Draw 01 - Desativando order', 300, 700);

$html1 = '<b>ATENÇÃO</b>: Desativando a ordenação de uma coluna Nome e Grupo';
$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');

$gride = new TGrid('gdTeste' // id do gride
                , 'Título do Gride' // titulo do gride
                , $dados   // array de dados
                , null     // altura do gride
                , null     // largura do gride
                , 'ID');     // chave primaria


$gride->addColumn('ID', 'id');
$gride->addColumn('NOME', 'Nome', 100)->setSortable(false);
$gride->addColumn('ATIVO', 'Ativo');
$gride->addColumn('GRUPO', 'grupo')->setSortable(false);


$frm->addHtmlField('gride', $gride);

$frm->setAction('POST PAGINA');
$frm->show();
