<?php

$primaryKey = 'ID_ITEM';
$frm = new TForm(null,120);
$frm->setFlat(true);
$frm->setMaximize(true);

$frm->addHiddenField($primaryKey); // coluna chave da tabela
//$frm->addTextField('ID_ITEM','item',30); // coluna chave da tabela
$frm->addTextField('PRODUTO', 'Produto:', 30, false, null);
$frm->addNumberField('QUANTIDADE', 'Quantidade:', 5, true, 1, true);
$frm->addNumberField('PRECO', 'Preço:', 10, true, 2, true);

$dados = Tb_pedido_itemDAO::selectAll($primaryKey, null);


$grid = new TGrid('gdItem'      // id do gride
                , null          // titulo do gride
                , $dados        // array de dados
                , null          // altura do gride
                , null          // largura do gride
                , 'ID_ITEM,ID_PEDIDO'   // chave primaria
                , null
                , null
                ,'view/form/exe_tform4_grid-off_dados.php');
            


$grid->setForm($frm, false);  // adicionar o formulário ao gride para criar o gride offline
$grid->setShowAdicionarButton(true); // exibir o botão de adicionar - default =  true

// Exemplo de como alterar a largura e o alinhamento da coluna Moeda.
//$grid->setOnDrawHeaderCell('drawHeader');

$grid->show();
