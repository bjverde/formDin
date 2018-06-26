<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
 * Criado por Luís Eugênio Barbosa
 * Essa versão é um Fork https://github.com/bjverde/formDin
 *
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
 * Este programa é distribuí1do na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licen?a Pública Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

$frm = new TForm('Exemplo de Redirect - Form 1', 200, 400);
$frm->addTextField('nom_pessoa', 'Teste:', 20);
$frm->addTextField('nom_pessoa2', 'Teste 2:', 20);
$frm->addTextField('nom_pessoa3', 'Teste 3:', 20);

$frm->setHint('nom_pessoa', 'Teste');
$frm->addHtmlField('html', 'Este é o form <blink>1</blink>, clique no botão Ir para exibir o form <blink>2</blink>')->setCss('color', 'blue');
$frm->setAction('Ir submit,Ir Ajax');


$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'Ir submit':
        //Redirect só funciona se o arquivo estiver na pasta modulos
        $frm->redirect('exe_redirect_form2.inc', 'Redirect realizado com sucesso. Você está agora no 2º form.', true);
        break;
        //------------------------------------------------------------------
    case 'Ir Ajax':
        //Redirect só funciona se o arquivo estiver na pasta modulos
        $frm->redirect('exe_redirect_form2.inc', 'Redirect realizado com sucesso. Você está agora no 2º form.', false, null);
        break;
        //--------------------------------------------------------------------
}

$frm->show();
