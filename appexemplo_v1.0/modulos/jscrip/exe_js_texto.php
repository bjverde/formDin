<?php

$frm = new TForm('JavaScript Leia-me', 700);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addCssFile('css/css_form.css');

$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');

$frm->show();