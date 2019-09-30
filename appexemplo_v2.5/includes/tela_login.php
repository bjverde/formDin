<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Minist?rio do Planejamento
 * ----------------------------------------------------------------------------
 * This file is part of Formdin Framework.
 * 
 * Formdin Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License version 3
 * as published by the Free Software Foundation.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License version 3
 * along with this program; if not,  see <http://www.gnu.org/licenses/>
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA  02110-1301, USA.
 * ----------------------------------------------------------------------------
 * Este arquivo ? parte do Framework Formdin.
 * 
 * O Framework Formdin ? um software livre; voc? pode redistribu?-lo e/ou
 * modific?-lo dentro dos termos da GNU LGPL vers?o 3 como publicada pela Funda??o
 * do Software Livre (FSF).
 * 
 * Este programa ? distribu?do na esperan?a que possa ser ?til, mas SEM NENHUMA
 * GARANTIA; sem uma garantia impl?cita de ADEQUA??O a qualquer MERCADO ou
 * APLICA??O EM PARTICULAR. Veja a Licen?a P?blica Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 * 
 * Voc? deve ter recebido uma c?pia da GNU LGPL vers?o 3, sob o t?tulo
 * "LICENCA.txt", junto com esse programa. Se n?o, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Funda??o do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

$filePathHtmlLogin = 'ajuda/info_login_pt-br.php';
$filePathHtmlInfo  = 'ajuda/info_start_pt-br.php';

$frm = new TForm('Acesso ao Sistema',500,540);
$frm->hideCloseButton();
$frm->addTextField('login'		,'Login:',20,true,20);
$frm->addPasswordField('senha'	,'Senha:',20,true,20);
$frm->addHtmlField('htmlLogin', null, $filePathHtmlLogin, null, null, null);
$frm->addHtmlField('htmlInfo' , null, $filePathHtmlInfo, null, null, null)->setClass('boxAlert',true);
//$frm->addButton('Entrar','login',null);
$frm->addButtonAjax('Entrar',null,'fwValidateFields()','resultado','login','Validando informações','json',false);

$acao = isset($acao) ? $acao : null;
if( $acao =='login'){
    sleep(1);
    $nom_user = $frm->get('login');
    $pwd_user = $frm->get('senha');
    $msg = Acesso::login($nom_user,$pwd_user);;
    if( $msg == 1 ) {
        $_SESSION[APLICATIVO]['conectado']=true;
        prepareReturnAjax(1);
    }
    else {
        //$frm->setShowMessageForm(true);
        $frm->setMessage('Login Inválido');
        prepareReturnAjax(0);
    }
}

$frm->show();
?>

<script>

function resultado(res) {
    if( res.status==1) {
        fwApplicationRestart();    
    }
    else {
        fwAlert('Login Inválido');
    }
}
</script>