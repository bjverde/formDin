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

/*
Todo elemento que possuir a propriedade tooltip="true" será processado
ex: <input type="button" tooltip="true">
*/
$frm = new TForm('Exemplo de Hints / Tooltips');
//define('REQUIRED_FIELD_MARK','*');
//$frm->setColorHighlightBackground('#FAFAD2');

$frm->setColumns(array(150));
$frm->addTextField('endereco','Endereço:',150	,false,50)->setHint('Endereço - O endereço deve ser informado completo, sendo o nome da rua, o bairro, o unidade da federação e o complemento.');
$frm->addTextField('longo1','Hint Longo:',150	,false,50)->setHint('Música de Lulu Santos - Nada do que foi será de novo do jeito que ja foi um dia, tudo passa tudo sempres passará, a vaida vem em ondas como um mar!!!<br>Tudo que se vê não é igual ao que a gente viu a um segundo tudo muda o tempo todo no mundo.');
$frm->addTextField('longo2','Hint Muito Longo:'	,150,false,50)->setHint('Música de Roberto Carlos - Eu tenho tanto, pra lhe falar, mas com palavras não sei dizer, como é grande o meu amor por você.<br>E não há nada pra comparar para poder lhe explicar, como é grande o meu amor por você.<br>Nem mesmo o ceu nem as estrelas, nem mesmo o mar e o infinito, não é maior que meu amor nem mais bonito.<br>Me desespero a procurar alguma forma de lhe falar como é grande o meu amor por você.');
$frm->addTextField('longo3','Hint Com Tabela:'	,150,false,50)->setHint('<table border=1><th>COLUNA 1</th><th>COLUNA 2</th><tr><td>A</td><td>B</td></tr></table>');
$frm->getLabel('longo2')->setToolTip('olá');

$frm->addTextField('dica1','Dica 1'	,150,false,50)->setToolTip('Cabeçalho','Texto da dica');
$frm->addDateField('dica2','Data')->setToolTip('Cabeçalho','Texto da dica');
$frm->addMemoField('dica3','Obs 1',500,true,30,5,null,null,false)->setToolTip('Cabeçalho','Texto da dica');
$frm->addMemoField('dica4','Obs 2',500,true,20,5,false,false,false)->setToolTip('Cabeçalho','Texto da dica<table><tr><td>teste tabela </td></tr></table>');
$frm->setAction('Atualizar');
$frm->show();
?>
