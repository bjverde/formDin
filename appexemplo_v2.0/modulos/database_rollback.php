<?php
defined('APLICATIVO') or die();

$html1 = '<h1>Exemplo controle de transação de banco</h1>';
$html1 = $html1.'<br>'; 
$html1 = $html1.'Ao Clicar executar 3 ações de banco serão executadas';

$frm = new TForm('Exemplo RollBack');
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addHtmlField('html1', $html1, null, null, null, null)->setClass('boxAlert',true);

$frm->addButton('Executar', null, 'Executar', null, null, true, false)->setClass('btnOragen', false);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    case 'Executar':
        $controllerDatabase = new Database();
        $controllerDatabase->rollBack();
        break;
        //--------------------------------------------------------------------------------
}

$frm->show();
