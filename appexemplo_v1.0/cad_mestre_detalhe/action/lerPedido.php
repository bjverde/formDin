<?php
$res = Tb_pedidoDAO::selectById($_POST['id']);
if ($res) {
    prepareReturnAjax(1, $res);
}
prepareReturnAjax(0, null, 'Pedido não encontrado');
