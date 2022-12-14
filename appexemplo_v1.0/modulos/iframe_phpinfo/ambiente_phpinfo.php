<?php
$width=900;
$height=850;
$frm = new TForm('Informações do PHP Info', $height, $width);
$url = urldecode('modulos/iframe_phpinfo/phpinfo.php');
$url = StringHelper::utf8_decode($url);
$frm->addHtmlField('teste', '<iframe style="border:none;" width="'.($width-20).'" height="'.($height-100).'" frameborder="0" marginheight="0" marginwidth="0" src="'.$url.'"></iframe>')->setCss('border', '1px solid blue');
;
$frm->show();
