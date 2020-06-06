<?php

require_once 'includes/constantes.php';
require_once 'includes/config_conexao.php';

//FormDin version: 4.9.2
require_once '../base/classes/webform/TApplication.class.php';
//require_once 'controllers/autoload_audit.php';
require_once 'dao/autoload_audit_dao.php';

$frm = new TForm('Result');
$frm->setFlat(true);
$frm->setAutoSize(true);

$frm->addLinkField('Link2','','index',null,'index.php','new');
$frm->addLinkField('Link1','','Layout 2',null,'index2.php','new');


$dao = new PerguntasDAO();
$resultado = $dao->selectAll();
var_dump($resultado);

$frm->show();
?>
