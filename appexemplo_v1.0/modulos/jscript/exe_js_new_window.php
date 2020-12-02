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
	novaJanela('https://www.linhadecomando.com/javascript/javascript-carregando-uma-pagina-em-outra-janela');
}
function novaJanela (URL){
   		window.open(URL,"janela1"
                   ,"width=800,height=600,directories=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,resizable=no"
                    )
	}
</script>
