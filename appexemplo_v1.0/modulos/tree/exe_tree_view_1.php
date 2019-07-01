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

d($_REQUEST);


$frm = new TForm('Estrutura Oragnizacional', 400);


$listThemes = array();
$listThemes['bluebooks']='bluebooks';
$listThemes['bluefolders']='bluefolders';
$listThemes['books']='books';
$listThemes['default']='default';
$listThemes['scbrblue']='scbrblue';
$listThemes['skyblue']='skyblue';
$listThemes['vista']='vista';
$listThemes['winstyle']='winstyle';
$listThemes['yellowbooks']='yellowbooks';
$frm->addRadioField('theme', 'Tema da TreeView', false, $listThemes, null, true, 'default', 5, null, null, null, false, false);
$frm->addButton('Atualizar', null, 'Atualizar', null, null, true, false);


$frm->addGroupField('gpTree', 'Exemplo Treeview', 200)->setcloseble(true);
//$pc = $frm->addPageControl('xxx',200);
//$page = $pc->addPage('label',true,true);

    $tree = $frm->addTreeField('tree', null, null, null, null, null, null, null, null);
    $tree->setStartExpanded(true);
    
    $theme = $frm->get('theme');
    $tree->setTheme($theme);

    $tree->addItem(null, 1, 'Relatório', true);
    $tree->addItem(1, 11, 'Financeiro', true, 'Meu Hint', array('URL'=>'www.bb.com.br'));
    $tree->addItem(1, 12, 'Recursos Humanos', null, null, array('URL'=>'www.google.com.br'));
    $tree->addItem(null, 2, 'Arquivos', true);
    $tree->addItem(2, 21, 'Documentos', null, 'Documentos do órgão', array('MODULO'=>'modulos/cad_documento'));
    $tree->addItem(2, 22, 'Planilhas');
for ($i=23; $i<50; $i++) {
    $tree->addItem(2, $i, 'Nivel teste '.$i);
}
$frm->closeGroup();
$frm->show();
