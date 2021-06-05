<?php

$html1 = 'O exemplo nem é FormDin, basicamente temos um JavaScript Vanila que abre uma nova janela do navegado';
$html1 = $html1.'<br> você dever permitir abertura da nova janela';


$frm = new TForm('JavaScript abrindo nova Janela');
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addCssFile('css/css_formDinv5.css');

$frm->addHtmlField('html1', $html1, null, null, null, null)->setClass('boxAlert',false);

$frm->addJavascript('init()');
$frm->show();
?>

<script>
function init() {
	novaJanela('https://developer.mozilla.org/pt-PT/docs/Web/API/Window/open','j1');
    novaJanela('https://www.w3schools.com/jsref/met_win_open.asp','j2');
}
function novaJanela (URL,JANELA){
   		window.open(URL,JANELA
                   ,"width=800,height=600,directories=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,resizable=no"
                    )
	}
</script>
