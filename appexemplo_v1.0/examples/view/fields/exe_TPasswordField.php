<?php
$frm = new TForm('Exemplo Campo Senha',200,500);
$frm->addPasswordField('senha1','Senha1:');
$frm->addPasswordField('senha2','Senha2:',null,null,null,null,null,null,null,true,true,false);
$frm->addPasswordField('senha3','Senha3:',null,null,null,null,null,null,null,true,true,true);
$frm->addPasswordField('senha4','Senha4:',null,null,null,null,null,null,null,true,false,true);
$frm->show();
?>