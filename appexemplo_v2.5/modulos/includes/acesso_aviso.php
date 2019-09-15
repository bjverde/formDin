<?php

$html = '<b>Aviso</b>'
       .'<br>Essa tela só funciona do Aplicativo de exemplo 2.5'
       .'<br>No Aplicativo de exemplo 2.0 serve apenas mostrar';
$frm->addHtmlField('texto', $html)->setCss('border', '1px solid red');;
$frm->addHtmlField('linha', ' ');