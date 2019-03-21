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

$html = '<br><br><b>Form Com Borda Redondas</b>'
        .'<br><br>Depois do FormDin 4.3.2, o padrão das bordas do form é o FLAT. Para alterar utilize $frm->setFlat(false);. Porém o recomendavel é sempre alterar via CSS';

$box3 = new TBox('bx3', 300, 100);
$box3->add($html);
$box3->setFlat(true);
$box3->setPosition('tc');
$box3->setCssBody('background-color', 'yellow');

$frm = new TForm('Teste Colunas Formulário', 300, 900);
$frm->setFlat(false);

$frm->addOutside($box3);

$frm->addTextField('nom_pessoa', 'Nome da Pessoa:', 30);
$frm->addTextField('des_endereco', 'Endereço Comercial:', 60, false, null, null, false);
$frm->addTextField('nom_bairro', 'Bairro:', 30);
$frm->addTextField('num_cep', 'CEP:', 40, false, null, null, false);

$frm->setAction('Atualizar');
$frm->show();
