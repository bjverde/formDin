<?php
defined('APLICATIVO') or die();

$frm = new TForm('Relatório do pedido',100);
$frm->setFlat(true);
$frm->setMaximize(true);

$frm->addNumberField('IDPEDIDO', 'Num do Pedido',4,null,0)->setEnabled(false);
$frm->addDateField('DAT_PEDIDO', 'Data do Pedido',null,false)->setEnabled(false);
$frm->addTextField('NOM_PESSOA', 'Solicitante',150,null,70)->setEnabled(false);
$frm->addPdfFile('modulos/relatorio_pedido_item.php');


$frm->addButton('Lista de pedidos', 'voltar', null, null, null, true, true);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
case 'voltar':
	$frm->redirect('pedido.php',null,true,null,true);
    break;
}
$frm->show();
?>