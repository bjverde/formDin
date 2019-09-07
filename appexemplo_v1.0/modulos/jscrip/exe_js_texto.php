<?php

$html1 = 'o FormDin funciona basicamente com funções PHP, logo é server-side (processado do lado do servidor).'
         .'<br>Porém algumas funcionalidades mais dinamicas do formulário, só é possível fazer usando uma tecnlogia client-side (processada do lado do servidor).'
         .'<br>'
         .'<br>Essa tecnoliga é o JavaScript. O FormDin4 faz uso do Jquery 1.16 ou JavaScript Vanila'
         .'<br>'
         .'<br>'
         .'<br>Os exemplos dessa seção focam no uso das funcionalidades internas do FormDin, JQuery ou JavaScript Vanila';


$frm = new TForm('JavaScript Leia-me');
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addCssFile('css/css_formDinv5.css');

$frm->addHtmlField('html1', $html1, null, null, null, null)->setClass('boxAlert',false);

$frm->addGroupField('gpx1', 'Change');
    $frm->addButton('Ir Change', null, null, null, null, true, false);
    $html2 = 'Exemplo change de select field que habilita abas. Fazendo uso da funções fwSetRequired, fwHabilitarAba, fwSelecionarAba e fwDesabilitarAba eee. Exemplo change que inicia janela já maximizada';
    $frm->addHtmlField('html2', $html2, null, null, null, null,false)->setClass('boxAlert',false);    
$frm->closeGroup();
$frm->addGroupField('gpx2', 'Janela Maximizada');
    $frm->addButton('Ir Janela', null, null, null, null, true, false);
    $html2 = 'Exemplo change que inicia janela já maximizada';
    $frm->addHtmlField('html2', $html2, null, null, null, null,false)->setClass('boxAlert',false);
$frm->closeGroup();


$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'Ir Change':
        $frm->redirect('view/containers/exe_aba_3.php', null, true);
    break;
    //------------------------------------------------------------------
    case 'Ir Janela':
        $frm->redirect('view/form/exe_max_start.php', null, true);
    break;
    //--------------------------------------------------------------------
}

$frm->show();