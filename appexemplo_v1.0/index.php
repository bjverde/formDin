<?php
include('../base/classes/webform/TApplication.class.php');
$app = new TApplication(); // criar uma inst�ncia do objeto aplica��o
$app->setTitle('Instituto Brasileiro de Meio Ambiente - IBAMA');
$app->setSUbTitle('Framework para Desenvolvimento de Aplicativos WEB');
$app->setSigla('FORMDIN IV');
$app->setUnit('Departamento de Informática - DI - 2011');
$app->setLoginInfo('Bem-vindo');
$app->setMainMenuFile('includes/menu.php');
$app->run();
?>