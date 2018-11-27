<?php
//d($_REQUEST);

$primaryKey = 'ID_PEDIDO';
$frm = new TForm('CSS Form 03 - Exemplo de uso do CSS, no grid', 300);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->setAutoSize(true);
$frm->addCssFile('css/css_form03.css');


$html ='Esse forma mostra o exemplo do uso de um css separado sobre alguns elmentos. Evite usar a funão setCSS ! O melhor é utilizar setClass com o addCssFile.';
$frm->addHtmlField('html1', $html, null, 'Dica:', null, 300)->setClass('notice');
$frm->addHiddenField($primaryKey); // coluna chave da tabela

$frm->addButton('post', 'post', null, null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);

$dados = Vw_pedido_qtd_itensDAO::selectAll($primaryKey);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',DATA_PEDIDO|DATA_PEDIDO,NOME_COMPRADOR|NOME_COMPRADOR,FORMA_PAGAMENTO|FORMA_PAGAMENTO,DES_FORMA_PAGAMENTO|DES_FORMA_PAGAMENTO,QTD|QTD';
$gride = new TGrid('gd'        // id do gride
    , 'Titulo Gride'     // titulo do gride
    , $dados        // array de dados
    , null          // altura do gride
    , null          // largura do gride
    , $primaryKey   // chave primaria
    , $mixUpdateFields);
$gride->addColumn($primaryKey, 'id', 50, 'center');
$gride->addColumn('DATA_PEDIDO', 'DATA_PEDIDO', 50, 'center');
$gride->addColumn('NOME_COMPRADOR', 'NOME_COMPRADOR', 50, 'center');
$gride->addColumn('FORMA_PAGAMENTO', 'FORMA_PAGAMENTO', 50, 'center');
$gride->addColumn('DES_FORMA_PAGAMENTO', 'DES_FORMA_PAGAMENTO', 50, 'center');
$gride->addColumn('QTD', 'QTD', 50, 'center');

$gridTitle = $gride->getTitleCell();     //Recupera o titulos do grid
$gridTitle->setClass('gridTitle',true);  //Seta uma classe CSS ao titulo do grid


$columNomeComprador = $gride->getColumn('NOME_COMPRADOR');   // recuperar o objeto coluna NOM_UF
$columNomeComprador->setClass('columRed',true);       // altera o tamanho da fonte da coluna NUM_UF


$h = $columNomeComprador->getHeader();                   // recuperar o objeto header da NOM_UF
$h->setCss('background-color', 'red');   // altera a cor de fundo do titulo da coluna para vermelha
$h->setCss('font-size', '14');           // altera o tamanho da fonte do titulo da coluna para 14


$frm->addHtmlField('gride', $gride);
$frm->show();
