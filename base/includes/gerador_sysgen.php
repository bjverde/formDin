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

$html1 =
'Escreva menos, faça mais. Mas <b>"Falar é fácil. Me mostre o código"</b>!
<br>
<br>O gerador de sistemas lê um banco de dados e gera uma tela crud para cada uma das tabelas montando o esqueleto do sistema.
<br>O código gerado é de fácil manutenção e modificação utilizando o como framework FormDin para o novo sistema.
<ul>
    <li>Reconhece o tipo de campo do banco é cria o campo equivalente na tela com formDin</li>
    <li>Reconhece obrigatoriedade ou não</li>
    <li>Reconhece chaves estrangeiras já traz como select field</li>
    <li>Todos os campos podem ser utilizados como parâmetro de busca</li>
</ul>
<br><a href="https://github.com/bjverde/sysgen/wiki/Do-Zero-at%C3%A9-Rodar">Tutorial com vídeo do SysGen no GitHub</a>
<br><a href="https://github.com/bjverde/sysgen">SysGen no GitHub</a> 
<br>
<img src="../base/imagens/2-code-gen-database-first.png" alt="Fluxo SysGen">
';

$frm = new TForm('SysGen - Gerador de sistemas em FormDin',450);
$frm->setFlat(true);
$frm->addHtmlField('html1', $html1, null, null, null, null);
$frm->show();
