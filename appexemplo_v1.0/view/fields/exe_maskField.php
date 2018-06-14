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

  $frm = new TForm('Exemplo de Entrada de Dados com Máscara');

  $frm->addHtmlField('ajuda', '<b>Campo para entrada de dados com máscara de edição<br>
		a - Representa uma letra (A-Z,a-z)<br>
		9 - Representa um número (0-9)<br>
		* - Representa um caractere (A-Z,a-z,0-9)<br>
		<a href="http://digitalbush.com/projects/masked-input-plugin/" target="_blank">Visite o Site</a></b>')->setcss('margin-bottom', 10);

  $frm->addMaskField('c1', 'Código:', false, '99.99.99', null, null, null, null, '99.99.99');
  $frm->addMaskField('c2', 'Placa do Carro:', false, 'aaa-9999')->setExampleText('aaa-9999');
  $frm->addMaskField('c3', 'Código de Barras:', false, '9 999999 999999')->setExampleText('9 999999 999999');
  ;

  $frm->addHtmlField(null, 'Coração - Neste formulário, os rótulos dos campos foram alinhados à direita utilizando o método <b>$frm->setLabelsAlign("right")</b>.');
  $frm->setAction('Atualizar');
  $frm->setLabelsAlign('right');
  $frm->Show();
