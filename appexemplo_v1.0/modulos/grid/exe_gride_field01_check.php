<?php
d($_REQUEST);
$frm = new TForm('Gride Campos 01 - CheckColumn', 300, 700);
$html = '<br><b>Importante</b>'
        .'<br><br>SEMPRE declare a chave primaria do grid. Sem a PK o campo não vai funcionar';		
$frm->addHtmlField('aviso', $html, null,null, null,null);

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


$gride = new TGrid('gdTeste' // id do gride
, 'Título do Gride' // titulo do gride
, $dados   // array de dados
, null     // altura do gride
, null     // largura do gride
, 'ID');     // chave primaria


$gride->addColumn('ID', 'id');
$gride->addCheckColumn('idCheckColumnPost', 'Nome Título', 'ID', 'NOME', true, true);
//$gride->addColumn('NOME','Nome',100);
$gride->addColumn('ATIVO', 'Ativo');
$gride->addColumn('GRUPO', 'grupo');

$frm->addHtmlField('gride', $gride);




$frm->setAction('POST PAGINA');
$frm->show();
