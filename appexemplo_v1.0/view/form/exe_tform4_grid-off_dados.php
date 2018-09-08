<?php

$primaryKey = 'ID_ITEM';
$frm = new TForm(null, 150);
$frm->setFlat(true);
$frm->setMaximize(true);

//$frm->addHiddenField($primaryKey); // coluna chave da tabela

$frm->addTextField($primaryKey, 'item:', 10, false, null);
$frm->addTextField('produto', 'Produto:', 30, false, null);
$frm->addNumberField('quantidade', 'Quantidade:', 5, true, 1, true);
$frm->addNumberField('preco', 'Preço:', 10, true, 2, true);

$dados = Tb_pedido_itemDAO::selectAll($primaryKey, null);

$mixUpdateFields = $primaryKey.'|'.$primaryKey
                   .',ID_PEDIDO|ID_PEDIDO'
                   .',PRODUTO|PRODUTO'
                   .',QUANTIDADE|QUANTIDADE'
                   .',PRECO|PRECO';

$grid = new TGrid('gdx'         // id do gride
                , null          // titulo do gride
                , $dados        // array de dados
                , null          // altura do gride
                , null          // largura do gride
                , $primaryKey   // chave primaria
                , $mixUpdateFields);

$grid = new TGrid('gdx', 'Dados Off-line', $dados, null, null, 'SEQ_MOEDA,SEQ_DOCUMENTO', null, null, 'view/form/exe_tform4_grid-off_dados.php');

// adicionar o formulário ao gride para criar o gride offline
$grid->setForm($frm, false);

$grid->setShowAdicionarButton(true); // exibir o botão de adicionar - default =  true

// Exemplo de como alterar a largura e o alinhamento da coluna Moeda.
$grid->setOnDrawHeaderCell('drawHeader');

$grid->show();
