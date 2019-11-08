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

$frm = new TForm('Exemplo do TButton');


$frm->addNumberField('num_peso', 'Peso Unitário:', 5, true, 2, true)->setExampleText('Kg');
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);
$frm->addButton('Exemplo 09 - img', null, 'act09', null, null, true, false,'joia.gif');
$frm->addButton('Exemplo 09 - img desabilitado', null, 'act09d', null, null, true, false,'joia.gif','joia_desabilitado.gif');
$frm->addButton('Exemplo 10 - img', null, 'act10', null, null, true, false,'favicon-32x32.png');
$frm->addButton('Exemplo 11 - hint', null, 'act11', null, null, true, false,null,null,'text hint');
$frm->addButton('Exemplo 12', null, 'act12', null, null, true, false,null,null,null,null,true,'xxx','center');
$frm->addButton('Exemplo 13', null, 'act13', null, null, true, false,null,null,null,null,true,'xxx','left');
$frm->addButton('Exemplo 14', null, 'act14', null, null, true, false,null,null,null,null,null,null,'left');
$frm->addTextField('xxx','xxx',30);

// botões de ação
$frm->setAction('Atualizar');
$frm->addButton('Validar', null, null, 'fwValidateFields()');
$frm->addButton('Limpar', null, 'btnLimpar', 'fwClearChildFields()');

// criar o html do formulário
$frm->show();
?>
