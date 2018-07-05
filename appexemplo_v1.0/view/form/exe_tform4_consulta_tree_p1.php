<?php
//var_dump($_REQUEST);
d($_REQUEST);

function voIssetOrZero($attribute, $isTrue, $isFalse)
{
    $retorno = $isFalse;
    if (isset($attribute) && ($attribute<>'')) {
        if ($attribute<>'0') {
            $retorno = $isTrue;
        }
    }
    return $retorno;
}

$html1 = 'Esse form é um outra visão do form <i>"Mestre visão com Ajax"</i>.
          <br>
          <br>Este exemplo utiliza as tabelas tb_pedido e tb_pedido_item do banco de dados bdApoio.s3db ( sqlite )  ';

$whereGrid = ' 1=1 ';
$primaryKey = 'ID_PEDIDO';
$frm = new TForm('Exemplo Form4 - Consulta Grid', 600);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField($primaryKey); // coluna chave da tabela
$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');
$frm->addDateField('data_pedido', 'Data:', false);
$frm->addTextField('nome_comprador', 'Comprador:', 60, false, null);
$listFormas = array(1=>'Dinheiro',2=>'Cheque',3=>'Cartão');
$frm->addSelectField('forma_pagamento', 'Forma Pagamento:', false, $listFormas);
//$frm->addRadioField('forma_pagamento', 'Forma Pagamento:', false, $listFormas,null,null,null,3);

$frm->addTextField('QTD', 'Quantidade de Itens', 50, false);

$frm->addButton('Ver Mestre visão com Ajax', 'redirectMestreAjax', null, null, null, true, false);
$frm->addButton('Buscar', null, 'Buscar', null, null, false, false);
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
    case 'Buscar':
        $vo = new Vw_pedido_qtd_itensVO();
        $frm->setVo($vo);
        $whereGrid = $whereGrid.( voIssetOrZero($vo->getNome_comprador(), ' AND upper(NOME_COMPRADOR) like "%'.strtoupper($vo->getNome_comprador()).'%" ', null) );
        $whereGrid = $whereGrid.( voIssetOrZero($vo->getForma_pagamento(), ' AND forma_pagamento='.$vo->getForma_pagamento().' ', null) );
        $whereGrid = $whereGrid.( voIssetOrZero($vo->getQtd(), ' AND QTD='.$vo->getQtd().' ', null) );
        break;
    //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
    //--------------------------------------------------------------------------------
    case 'redirectForm4p2':
        $frm->redirect('view/form/exe_tform4_consulta_tree_p2.php', null, true);
        break;
    //--------------------------------------------------------------------------------
    case 'redirectMestreAjax':
        $frm->redirect('../cad_mestre_detalhe/cad_mestre_detalhe.php', null, true);
        break;
}

$dados = Vw_pedido_qtd_itensDAO::selectAll($primaryKey, $whereGrid);
$mixUpdateFields = $primaryKey.'|'.$primaryKey
                 .',DATA_PEDIDO|DATA_PEDIDO'
                 .',NOME_COMPRADOR|NOME_COMPRADOR'
                 .',FORMA_PAGAMENTO|forma_pagamento'
                 .',DES_FORMA_PAGAMENTO|DES_FORMA_PAGAMENTO'
                 .',QTD|QTD';
$gride = new TGrid('gd'        // id do gride
, 'Gride'     // titulo do gride
, $dados        // array de dados
, null          // altura do gride
, null          // largura do gride
, $primaryKey   // chave primaria
, $mixUpdateFields);
$gride->addColumn($primaryKey, 'id', 50, 'center');
$gride->addColumn('DATA_PEDIDO', 'Data', 50, 'center');
$gride->addColumn('NOME_COMPRADOR', 'Comprador', 200, 'center');
$gride->addColumn('DES_FORMA_PAGAMENTO', 'Forma Pagamento', 100, 'center');
$gride->addColumn('QTD', 'Qtd Itens', 50, 'center');

$gride->enableDefaultButtons(false);
$gride->addButton('Visualizar', 'redirectForm4p2', 'btnVisualizar');


$frm->addHtmlField('gride', $gride);

$frm->show();
