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
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

/**
 * @name grides/gride_condominio_offline.php
 * @author  Altamiro Rodrigues <altamiro27 at gmail dot com>
 * @since   2011-10-19
 * @version $Id: teste.php,v 1.3 2012/01/27 14:04:51 LUIS_EUGENIO_BARBOSA Exp $
 */

// arquivo de interno de configuracao do car(externo)
//require_once 'modulos/car_externo/config.php';

$frm = new TForm('Formulário de Cadastro de Clientes');
$frm->addHtmlField('msg','Exemplo de como alterar a inteface do formulário utilizando um arquvo css externo');
// adicionar o arquivo css ao formulário
$frm->addCssFile('css/css_form.css');


// exibir bordas simples
$frm->setFlat(true);

// remover o botão fechar original
$frm->hideCloseButton();

// adionar o conteúdo do cabeçalho com no novo botão fechar
$frm->getHeaderButtonCell()->add('<table border="0" width="100%" height="100%" cellpadding="0px" cellspacing="0px" style="padding-right:2px;padding-top:2px;"><tr align="right"valign="bottom"><td></td></tr><tr align="right" valign="top"><td><img style="cursor:pointer;" src="imagem/btnFecharVermelho.jpg" alt="Fechar" width="18px" height="18px"  title="Fechar" onclick="fwConfirmCloseForm(\'formdin_area\',null,null,null);"></td></tr></table>');

// adicionar campo grupo para exemplo
$frm->addGroupField('bg1','Grupo de teste');
	$frm->addTextField('nome','Nome:',60);
$frm->closeGroup();

// exibir o formulário
$frm->show();
?>