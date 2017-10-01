<?php
$frm = new TForm('Formulário Exemplo Utilizando o FormDin',700,900);
$frm->setAction('Limpar');
$url = utf8_decode(urldecode('http://maps.google.com.br/maps?saddr=RJ-137&daddr=Barra+do+Pira%C3%AD+-+RJ&hl=pt-BR&ie=UTF8&ll=-22.371428,-43.891153&spn=0.051353,0.090895&sll=-22.361546,-43.887634&sspn=0.02671,0.038581&geocode=Febqqv4dTiti_Q%3BFcYgqf4dakFj_SklKRM_BLWeADGfgPn-zFmq1Q&mra=dme&mrsp=0&sz=15&t=h&z=14'));
$url .= '&output=embed';
$frm->addHtmlField('teste','<iframe width="400px" height="400px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$url.'"></iframe>')->setCss('border','1px solid blue');;
$frm->show();
?>