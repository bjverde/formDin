<?php
d($_REQUEST);
$frm = new TForm('Gride Campos 04 - Campo Memo', 300, 700);

// simulação de dados para o gride
$dados = null;
$dados['ID'][]    = 1;
$dados['NOME'][]  = 'Linha1';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'A';
$dados['SIT_OPCOES'][] = '1=>Um,2=>Dois';

$dados['ID'][]    = 2;
$dados['NOME'][]  = 'Linha2';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'A';
$dados['SIT_OPCOES'][] = '3=Tres,4=>Quatro';

$dados['ID'][]    = 3;
$dados['NOME'][]  = 'Linha3';
$dados['ATIVO'][] = 'N';
$dados['GRUPO'][] = 'C';
$dados['SIT_OPCOES'][] = null;

$gride = new TGrid('gdTeste' // id do gride
, 'Título do Gride' // titulo do gride
, $dados   // array de dados
, null     // altura do gride
, null     // largura do gride
, 'ID');     // chave primaria


$gride->addColumn('ID', 'id');
$gride->addColumn('NOME', 'Nome', 100);
$gride->addColumn('ATIVO', 'Ativo');
$gride->addColumn('GRUPO', 'grupo');
$gride->addMemoColumn('MEMO','Label', 'Label',60);

$frm->addHtmlField('gride', $gride);

$frm->setAction('POST PAGINA');
$frm->show();
