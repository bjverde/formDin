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
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

 // marcar os campos obrigatórios com Asterisco na frente
define('REQUIRED_FIELD_MARK', '*');

d($_REQUEST);

$frm = new TForm('Exemplo do Campo Texto');
$frm->addCssFile('css/css_formDinv5.css');

$frm->addTextField('nome', 'Nome da pessoa sem quebra:', 60, false, 60, null, null, null, null, null, true);

$frm->addTextField('nome3', 'Nome Somente Leitura:', 80, true, null, 'Somente leitura', true, null, null, true)->setReadOnly(true);


$html1 = '<b>ATENÇÃO</b> Eviete ao maximo usar setEnabled.'
         .'<br>'
         .'<br>Existem vários casos que o campo desabilitados não funcionada corretamente'
         .'<br>';

$frm->addHtmlField('html1', $html1, null, null, null, null)->setClass('boxAlert',false);
$frm->addTextField('nome2', 'Nome Desabilitado:', 80, null, null, 'Desabilitado', true, null, null, true)->setEnabled(false);

// botões de ação
$frm->setAction('Atualizar');
$frm->addButton('Post');
$frm->addButton('Validar', null, null, 'fwValidateFields()');
$frm->addButton('Limpar', null, 'btnLimpar', 'fwClearChildFields()');

// criar o html do formulário
$frm->show();
?>
