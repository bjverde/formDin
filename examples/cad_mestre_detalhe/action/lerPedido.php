<?php
$res = Tb_pedidoDAO::select($_POST['id']);
if( $res )
{
	prepareReturnAjax(1,$res);
}
prepareReturnAjax(0,null,'Pedido não encontrado');
?>
