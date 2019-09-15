<?php
defined('APLICATIVO') or die();
require_once 'modulos/includes/acesso_view_allowed.php';

$html1 = '<h1>Exemplo controle de transação de banco</h1>';
$html1 = $html1.'<br>';
$html1 = $html1.'Ao Clicar executar 3 ações de banco serão executadas:';
$html1 = $html1.'<ul>';
$html1 = $html1.'<li>INSERT novo usuáiro em Acesso_user</li>';
$html1 = $html1.'<li>INSERT nova relação novo usuário com o perfil  (4) trainee</li>';
$html1 = $html1.'<li>DELETE os dois registros</li>';
$html1 = $html1.'</ul>';

$frm = new TForm('Exemplo Commit',250);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addHtmlField('html1', $html1, null, null, null, null)->setClass('boxAlert',true);

$frm->addButton('Executar', null, 'Executar', null, null, true, false)->setClass('btnOragen', false);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    case 'Executar':
        $controllerDatabase = new Database();
        $controllerDatabase->commit();
    break;
    //--------------------------------------------------------------------------------
}

$frm->show();
