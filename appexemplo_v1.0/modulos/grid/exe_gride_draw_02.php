<?php
d($_REQUEST);
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
$dados['ATIVO'][] = 'N';
$dados['GRUPO'][] = 'C';
$dados['VALOR'][] = '3';


$frm = new TForm('Gride Draw 02 - Pintando a linha conforme o valor', 300, 700);

$html1 = '<b>ATENÇÃO</b>: Quando o valor for menor que 5, todo o texto da linha ficará vermelho';
$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');

$gride = new TGrid('gdTeste' // id do gride
                , 'Título do Gride' // titulo do gride
                , $dados   // array de dados
                , null     // altura do gride
                , null     // largura do gride
                , 'ID');     // chave primaria
$gride->setOnDrawCell('confGride');

$gride->addColumn('ID', 'id');
$gride->addColumn('NOME', 'Nome', 100);
$gride->addColumn('ATIVO', 'Ativo');
$gride->addColumn('GRUPO', 'grupo');
$gride->addColumn('VALOR', 'Valor');


$frm->addHtmlField('gride', $gride);

$frm->setAction('POST PAGINA');
$frm->show();


function confGride($rowNum, $cell, $objColumn, $aData, $edit) {    
    if ($aData['VALOR']<5) {
        $cell->setCss('color', 'red');           // altera a cor de fundo do titulo da coluna para vermelha
        $cell->setCss('font-size', '14');        // altera o tamanho da fonte do titulo da coluna para 14
    }
}