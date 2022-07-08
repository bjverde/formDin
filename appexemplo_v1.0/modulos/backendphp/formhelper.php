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

error_reporting(E_ALL);

$moduloApache = ArrayHelper::get($_REQUEST,'moduloApache');
FormDinHelper::debug($moduloApache,'POST do campo moduloApache');
if( !empty($moduloApache) ){
    $result = FormDinHelper::ApacheModule($moduloApache);
    FormDinHelper::debug($result,'FormDinHelper::ApacheModule');
}

$frm = new TForm('Exemplo da funções do FormDinHelper');
$frm->setFlat(true);
$frm->setMaximize(true);

$html1 = 'Esse form foi criado para mostrar o funcionamento de algumas funções de backend do FormDin
    <br>
    <br>ArrayHelper::get($array,$atributo) - Função que retorna um o valor de um array sem o problemas de notice
    <br>
    <br>FormDinHelper::debug() - ajuda debugar 
    <br>
    <br>FormDinHelper::ApacheModule() - vc informa um modulo do apache está instaldo ou não
    <br>
    <br>Exemplo de modulos do Apache: core, http_core, mod_rewrite, mod_mime e mod_mime';

$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');
$frm->addTextField('moduloApache', 'Nome modulo apache:', 60, false, 60);


$frm->addButton('Salvar', null, 'Salvar', null, null, true, false);





$frm->show();

?>