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
TPDOConnection::test(false);

$frm = new TForm( 'Exemplo Campo Texto com Autocompletar II',220 );
$frm->addHtmlField('msg','<h3>Este exemplo está utilizando o banco de dados bdApoio.s3db ( sqlite) do diretório exemplos.<br>
A tabela de consulta é a tb_municipio.<br>
A consulta esta configurada para disparar quando for digitado o terceiro caractere do nome.<br>Se o campo Estado tiver preenchido o codigo da uf será utilizado no filtro.<br></h3>');


$frm->addSelectField( 'cod_uf', 'Estado:')->addEvent('onChange','jQuery("#nom_municipio").val("");fwAutoCompleteClearCache("nom_municipio")');
$frm->addTextField( 'nom_municipio', 'Cidade:', 60 )->setExampleText( 'Digite os 3 primeiros caracteres.');
$frm->addHiddenField('cod_municipio','');

//Deve sempre ficar depois da definição dos campos
$frm->setAutoComplete( 'nom_municipio'
			, 'tb_municipio'	// tabela de municipios
			, 'nom_municipio'	// campo de pesquisa
			, 'cod_municipio'	// campo que será atualizado ao selecionar o nome do município
			, null
			,'cod_uf'			// campo do formulário que será adicionado como filtro
			,null
			,3					// numero de caracteres minimos para disparar a pesquisa
			,1000				// tempo após a digitação para disparar a consulta
			,50					// máximo de registros que deverá ser retornado
			);
$frm->show();
?>