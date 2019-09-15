<?php
defined('APLICATIVO') or die();

$filePath = 'ajuda/info_start_pt-br.php';

$frm = new TForm('Informações iniciais');
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addHtmlField('html1', null, $filePath, null, null, null)->setClass('boxAlert',true);

$frm->show();
