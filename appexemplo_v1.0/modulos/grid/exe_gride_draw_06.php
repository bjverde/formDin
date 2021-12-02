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


$tableHtml = new TTableArray('table1');
$tableHtml->setData($dados);
$table1 = $tableHtml->show();
//FormDinHelper::debug($tableHtml->thead,'obj Tabela');
//FormDinHelper::debug($tableHtml,'obj Tabela');

echo '<br><br>';

$tableHtml2 = new TTableArray();
$tableHtml2->setData($dados);
$tableHtml2->addColumn('NOME','Nome');
$tableHtml2->addColumn('VALOR','Valor');
$table2 = $tableHtml2->show();
