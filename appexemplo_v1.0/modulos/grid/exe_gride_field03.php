<?php
d($_REQUEST);
$frm = new TForm('Gride Campos 03 - select', 300, 700);

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

$html1 = '<b>ATENÇÃO</b>: addSelectColumn para funcionar corretamente precisa que a chave primaria no grid seja definida';
$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');

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
$gride->addSelectColumn('sit_opcoes', 'Opções', 'SIT_OPCOES', '1=Amarelo,2=Verde');
//$gride->addSelectColumn('sit_opcoes','Opções','SIT_OPCOES',null,null,null,null,null,null,null,'VAL_OPCAO');
$frm->addHtmlField('gride', $gride);

$frm->setAction('POST PAGINA');
$frm->show();
