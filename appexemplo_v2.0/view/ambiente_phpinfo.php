<?php
$width=900;
$height=700;
$frm = new TForm('Informações do PHP Info', $height, $width);
$url = utf8_decode(urldecode('view/phpinfo.php'));
$frm->addHtmlField('teste', '<iframe style="border:none;" width="'.($width-20).'" height="'.($height-100).'" frameborder="0" marginheight="0" marginwidth="0" src="'.$url.'"></iframe>')->setCss('border', '1px solid blue');;
$frm->show();
?>