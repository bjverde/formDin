<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
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
 * Este arquivo é parte do Framework Formdin.
 *
 * O Framework Formdin é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da GNU LGPL versão 3 como publicada pela Fundação
 * do Software Livre (FSF).
 *
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

$frm = new TForm('Teste Campo Captcha', 300);
$frm->addHtmlField('texto', '<p><h3>O termo, CAPTCHA, é um acrônimo para <b>Completely Automated Public Turing Test to Tell Computers and Humans Apart</b> ou, numa tradução direta, teste de Turing público completamente automatizado para diferenciação entre computadores e humanos.<br>Leia mais em: <a target="_blank" href="http://www.tecmundo.com.br/2861-o-que-e-captcha-.htm#ixzz1qVPUhQeZ">Captcha</a></h3></p>');


$frm->addCaptchaField('campo_captcha', 'Cód. Segurança:', 'Captcha - Clique aqui para gerar nova combinação');

// centralizado no formulário
$frm->addCaptchaField('captcha_center', null)->setAttribute('align', 'center');

$frm->setAction('Gravar');
$frm->addButtonAjax('Gravar Ajax', null, 'fwValidateFields()', 'callbackGravar', 'Gravar', 'Gravando...', 'text', false, null, 'btnGravarAjax');
if (isset($acao) && $acao == 'Gravar') {
    if ($_POST['campo_captcha'] != $_SESSION['campo_captcha_code']) {
        $frm->setError('Caracteres informados incorretamente!');
    } else {
        $frm->setMessage('Captcha OK');
    }
}
$frm->show();
?>
<script>
function callbackGravar(res)
{
    alert( res );
}
</script>
