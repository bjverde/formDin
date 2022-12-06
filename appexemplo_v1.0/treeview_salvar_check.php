<?php
/****
 * Arquivo utilizado pelo arquivo exe_tree_view_6_check.php
 * para gravar o valor check ou não da treeview
 ****/
header('Content-Type: application/json; charset=utf-8');

require_once 'includes/constantes.php';
require_once 'includes/config_conexao.php';
require_once '../base/classes/webform/TApplication.class.php'; //FormDin 5

// AQUI SERÁ O CONTROLE DE ACESSO
// AQUI SERÁ O CONTROLE DE ACESSO
// AQUI SERÁ O CONTROLE DE ACESSO
// AQUI SERÁ O CONTROLE DE ACESSO

try{
    //var_dump($_REQUEST);
    $id = $_REQUEST['id'];
    $checked = $_REQUEST['checked'];
    $checked = ($checked==1)?'S':'N';

    if ( !isset($id) ) {
        $data = "Id não informado";
        echo json_encode($data);
    } else {
        $arrParams = array($checked,$id);
        $sql = "UPDATE treecheck_link SET checked = ? WHERE  id = ?";
        $dados = TPDOConnection::executeSql($sql, $arrParams);
        echo json_encode($dados);
    }
} catch (Exception $e) {
    $msg = 'Exceção capturada: '.$e->getMessage();
    echo json_encode($data);
}