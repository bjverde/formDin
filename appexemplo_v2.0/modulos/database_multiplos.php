<?php
defined('APLICATIVO') or die();

$html1 = '<h1>Exemplo acessando diversos bancos</h1>';
$html1 = $html1.'<br>'; 
$html1 = $html1.'Ao Clicar executar 3 ações de banco serão executadas';
$html1 = $html1.'<br> 1 - Select em tabela MySql';
$html1 = $html1.'<br> 2 - Select em tabela SqLite';
$html1 = $html1.'<br> 3 - Select em tabela MySql';
$html1 = $html1.'<br>';
$html1 = $html1.'<br> Reparece que o banco MySql é conexão principal, portante não precisa ser informada';

$frm = new TForm('Exemplo RollBack');
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addHtmlField('html1', $html1, null, null, null, null)->setClass('boxAlert',true);

$frm->addButton('Executar', null, 'Executar', null, null, true, false)->setClass('btnOragen', false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    case 'Executar':
        $controllerDatabase = new Database();
        $controllerDatabase->showMultiplos();
    break;
    //--------------------------------------------------------------------------------
}

$frm->show();
