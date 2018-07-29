<?php

$html1 = 'Esse form funciona melhor quando aberto pelo form "Form 04 - Consulta Pedidos"';


//var_dump($_REQUEST);
//d($_REQUEST);
$primaryKey = 'ID_PEDIDO';
$frm = new TForm('Exemplo Form4 - Visualizar Item', null, 500);
//$frm->setPosition('TC');
$frm->setFlat(true);
$frm->setAutoSize(true);
$frm->setMaximize(true);

$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');

$frm->addHiddenField($primaryKey); // coluna chave da tabela
$frm->addGroupField('gpx1', 'Pedido');
    $frm->addTextField('nome_comprador', 'Comprador:', 60, false, null)->setEnabled(false);
    $frm->addDateField('data_pedido', 'Data:', false)->setEnabled(false);
    $frm->addTextField('QTD', 'Quantidade de Itens: ', 10, false, null, null, false)->setEnabled(false);
    $listFormas = array(1=>'Dinheiro',2=>'Cheque',3=>'Cartão');
    //$frm->addSelectField('forma_pagamento', 'Forma Pagamento:', false, $listFormas);
    $frm->addRadioField('forma_pagamento', 'Forma Pagamento:', false, $listFormas,null,null,null,3)->setEnabled(false);
$frm->closeGroup();
$frm->addGroupField('gpx2', 'Visualização do Item');
    $frm->addTextField('item', 'item:', 10, false, null);
    $frm->addTextField('produto', 'Produto:', 30, false, null);
    $frm->addNumberField('quantidade', 'Quantidade:', 5, true, 1, true)->setEnabled(false);
    $frm->addNumberField('preco', 'Preço:', 10, true, 2, true)->setEnabled(false);
$frm->closeGroup();


$frm->addButton('Ver Fomr04 - Conulta Pedidos', 'backForm4p1', null, null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);

$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'Salvar':
        if ($frm->validate()) {
            $vo = new Vw_pedido_qtd_itensVO();
            $frm->setVo($vo);
            $resultado = Vw_pedido_qtd_itensDAO::insert($vo);
            if ($resultado==1) {
                $frm->setMessage('Registro gravado com sucesso!!!');
                $frm->clearFields();
            } else {
                $frm->setMessage($resultado);
            }
        }
        break;
    //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
    //--------------------------------------------------------------------------------
    case 'backForm4p1':
        $frm->redirect('view/form/exe_tform4_consulta_tree_p1.php', null, true);
        break;
}

// exemplo de criação de uma treeview fora do formulário


// adicionar ao form os arquivos js e css necessários para o funcionamento da treeview
$frm->addJsFile('dhtmlx/dhtmlxcommon.js');
$frm->addJsFile('dhtmlx/treeview/dhtmlxtree.js');
$frm->addCssFile('dhtmlx/treeview/dhtmlxtree.css');

// criar o objeto treeview.
$tree = new TTreeView('tree');

$tree->setWidth(200); // define a largura da área onde será exibida a treeview
$tree->setHeight(300); // define a altura da área onde será exibida a treeview


$idGrupo = ArrayHelper::validateUndefined($_REQUEST, 'ID_PEDIDO');
$where = ($idGrupo ?'idgrupo='.$idGrupo : null);
$dados = Vw_pedido_treeDAO::selectAll('idgrupo', $where);
foreach ($dados['IDPARENT'] as $key => $value) {
    $idParent = $dados['IDPARENT'][$key];
    $id       = $dados['ID'][$key];
    $text     = $dados['TEXT'][$key];
    $tree->addItem($idParent, $id, $text, true);
}

$tree->setOnClick('treeClick'); // fefinir o evento que será chamado ao clicar no item da treeview
$frm->addJavascript($tree->getJs());// gerar e adicionar na criação da pagina o codigo javascript que adiciona os itens na treeview
$tree->setXY(0, 20); // posiciona a treeview na tela. left=0, top=100
$tree->show(); // exibe o tree view
$frm->addJavascript('jQuery("#tree_toolbar").hide();'); // esconder a toolbar da treeview
// fim criação da treeview

$frm->show();
?>
<script>
function treeClick(id) {
    //alert( treeJs.getSelectedItemId());
    //alert( treeJs.getItemText(id ) );
    
    jQuery("#item").val(treeJs.getSelectedItemId());
    jQuery("#produto").val(treeJs.getItemText(id ));
    //jQuery("#link").val(treeJs.getUserData(id,'URL'));
}
</script>
