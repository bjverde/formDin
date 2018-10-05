<?php

//d($_REQUEST);
//d($_SESSION['APPEV1']);

$html1 = 'Esse form é um outra visão do form <i>"Mestre visão com Ajax" e "Exemplo Form4 - Consulta Grid"</i>.
          <br>
          <br>Este exemplo utiliza as tabelas tb_pedido e tb_pedido_item do banco de dados bdApoio.s3db ( sqlite )  ';


$primaryKey = 'ID_PEDIDO';
$frm = new TForm('Exemplo Form4 - Grid Off', 700);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField($primaryKey); // coluna chave da tabela
$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');


$frm->addGroupField('gpx1', 'Pedido');
    $frm->addTextField('nome_comprador', 'Comprador:', 60, false, null);
    $frm->addDateField('data_pedido', 'Data:', false);
    $listFormas = array(1=>'Dinheiro',2=>'Cheque',3=>'Cartão');
    $frm->addSelectField('forma_pagamento', 'Forma Pagamento:', false, $listFormas,false);
$frm->closeGroup();

//Campos que serão enviados ao subform
$mixFormFields = array('ID_PEDIDO'=> $frm->get('ID_PEDIDO'));
// subformulário com campos "offline" 1-N
$frm->addHtmlGride('grid_off', 'view/form/exe_tform4_grid-off_dados.php', 'gdItem',null,null,null,null,$mixFormFields);


$frm->addButton('Salvar', null, null, null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);

$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'Salvar':
        if ($frm->validate()) {
            $vo = new Tb_pedidoVO();
            $frm->setVo($vo);
            $list_pedido_item = $frm->createBvars('grid_off');
            d($list_pedido_item['GRID_OFF']);
            $vo->setList_pedido_item($list_pedido_item['GRID_OFF']);
            $resultado = Tb_pedido::saveGridOff($vo);
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
    case 'gd_excluir':
        $id = $frm->get($primaryKey);
        $resultado = Tb_pedido::delete($id);
        if($resultado==1) {
            $frm->setMessage('Registro excluido com sucesso!!!');
            $frm->clearFields();
        }else{
            $frm->clearFields();
            $frm->setMessage($resultado);
        }
        break;
}

function getWhereGridParameters(&$frm){
    $retorno = null;
    if($frm->get('BUSCAR') == 1 ){
        $retorno = array(
            'ID_PEDIDO'=>$frm->get('ID_PEDIDO')
            ,'DATA_PEDIDO'=>$frm->get('DATA_PEDIDO')
            ,'NOME_COMPRADOR'=>$frm->get('NOME_COMPRADOR')
            ,'FORMA_PAGAMENTO'=>$frm->get('FORMA_PAGAMENTO')
        );
    }
    return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
    $maxRows = ROWS_PER_PAGE;
    $whereGrid = getWhereGridParameters($frm);
    $dados = Tb_pedido::selectAll( $primaryKey, $whereGrid );
    $mixUpdateFields = $primaryKey.'|'.$primaryKey
                      .',DATA_PEDIDO|DATA_PEDIDO'
                      .',NOME_COMPRADOR|NOME_COMPRADOR'
                      .',FORMA_PAGAMENTO|FORMA_PAGAMENTO'
                      ;
    $gride = new TGrid('gd'               // id do gride
                      ,'Lista de Pedidos' // titulo do gride
                      );
    $gride->addKeyField( $primaryKey ); // chave primaria
    $gride->setData( $dados ); // array de dados
    $gride->setMaxRows( $maxRows );
    $gride->setUpdateFields($mixUpdateFields);
    $gride->setUrl( 'view/form/exe_tform4_grid-off_form.php' );
    
    $gride->addColumn($primaryKey,'id',null);
    $gride->addColumn('DATA_PEDIDO','Data do Pedido',null,'center');
    $gride->addColumn('NOME_COMPRADOR','Nome do Comprar',null);
    //$gride->addColumn('FORMA_PAGAMENTO','Forma de Pagamento',null);
    $gride->addColumn('DES_FORMA_PAGAMENTO','Forma de Pagamento',null);
    $gride->addColumn('QTD','Qtd Itens',null,'center');    
    
    $gride->show();
    die();
}


$frm->addHtmlField('gride');
$frm->addJavascript('init()');
$frm->show();
?>

<script>
function init() {
	var Parameters = {"BUSCAR":""
					,"ID_PEDIDO":""
					,"DATA_PEDIDO":""
					,"NOME_COMPRADOR":""
					,"FORMA_PAGAMENTO":""
					};
	fwGetGrid('view/form/exe_tform4_grid-off_form.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>