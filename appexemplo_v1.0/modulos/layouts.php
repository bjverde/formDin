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


$html2 = 'Forma Antiga de customizar o Layout <i>"Header customizado"</i>
          <br>
          <br>Usando metodo setHeaderBgImage que foi deprecated no formDIn v4.2.9. Procurei sempre alterar o CSS';

$homeUrl = UrlHelper::homeUrl();

$frm = new TForm('Exemplos Layout via links');

$frm->addGroupField('gpx1', 'Alterando o CSS');
    $frm->addLinkField('idLink0', 'labelLink0', 'Layout 00 - Default, setResponsiveMode = true (DEFAULT)', null, $homeUrl.'index.php', 'new');
    $frm->addLinkField('idLink1', 'labelLink1', 'Layout 01 - Menu Lateral', null, $homeUrl.'index_layout01.php', 'new');
    $frm->addLinkField('idLink2', 'labelLink2', 'Layout 02 - Default, setResponsiveMode = FALSE', null, $homeUrl.'index_layout02.php', 'new');
    $frm->addLinkField('idLink3', 'labelLink3', 'Layout 03 - Alterando APENAS CSS', null, $homeUrl.'index_layout03.php', 'new');
    $frm->addLinkField('idLink4', 'labelLink4', 'Layout 04 - Alterando APENAS CSS', null, $homeUrl.'index_layout04.php', 'new');
    $frm->addLinkField('idLink5', 'labelLink5', 'Layout 05 - TODOS os form Verdes. Utilizando TApplication->setCssDefaultFormFile', null, $homeUrl.'index_layout05.php', 'new');
$frm->closeGroup();

$frm->addGroupField('gpx2', 'Forma Antiga, até FormDin 4.2.9');
    $frm->addHtmlField('html2', $html2, null, null, null, null);
    $frm->addLinkField('idLink12', 'labelLink12', 'Layout Old 02', null, $homeUrl.'index_layout_old_02.php', 'new');
    $frm->addLinkField('idLink13', 'labelLink13', 'Layout Old 03', null, $homeUrl.'index_layout_old_03.php', 'new');
$frm->closeGroup();

$frm->setAction('POST PAGINA');
$frm->show();
