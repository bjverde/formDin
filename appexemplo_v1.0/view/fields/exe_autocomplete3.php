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

$html = '<h3>Este exemplo está utilizando o banco de dados bdApoio.s3db ( sqlite) do diretório exemplos.'
       .'<br>A tabela de consulta é a tb_municipio.'
       .'<br>A consulta esta configurada para disparar quando for digitado o terceiro caractere do nome.'
       .'<br>Pode ser feita um Consulta On-line Junto<br></h3>';

$frm = new TForm('Autocompletar + OnlineSearch', 400);
$frm->addHtmlField('msg', $html);

$frm->addTextField('cod_municipio', 'cod_municipio',30,false)->setEnabled(true);
$frm->addTextField('municipio_form', 'Cidade:', 60)->setExampleText('Digite os 3 primeiros caracteres.');

//Deve sempre ficar depois da definição dos campos
$frm->setAutoComplete('municipio_form'  // id do campo no form
		            , 'tb_municipio'    // tabela de municipios
		            , 'nom_municipio'   // campo de pesquisa
		            , 'nom_municipio|municipio_form,cod_municipio|cod_municipio'   // campo que será atualizado ao selecionar o nome do município <campo_tabela> | <campo_formulario>
		            , null
		            , null           // campo do formulário que será adicionado como filtro
		            , null
		            , 3                 // Default 3, numero de caracteres minimos para disparar a pesquisa
		            , 1000              // 9: Default 1000, tempo após a digitação para disparar a consulta
		            , 50);              // 10: máximo de registros que deverá ser retornado

//Deve sempre ficar depois da definição dos campos
$frm->setOnlineSearch('municipio_form' //id do campo no form
		            , 'tb_municipio' // tabela de municípios
            		, 'cod_uf|Uf:||||select,nom_municipio|Município:||||||like'  // campos para seleção do município. Ordem dos parametros: name|label|length|size|required|$type|decimalPlaces|partialKey|searchFormated
            		, false
            		, false
            		, true // se for encontrada apenas 1 opção faz a seleção automaticamente
            		, 'cod_municipio|Código,nom_municipio|Município'
            		, 'NOM_MUNICIPIO|municipio_form,COD_MUNICIPIO|cod_municipio'
            		, null
            		, null
            		, null
            		, null
            		, null
            		, null
            		, null
            		, null  // javascript de retorno
            		, null  //10
            		, null
            		, null
            		, null
            		, array('cod_uf'=>"SELECT COD_UF,NOM_UF||'/'||SIG_UF AS SIG_UF FROM TB_UF ORDER BY SIG_UF")  //Campo de filtro
            		, null, null, null, false);
		            
		            
$frm->addButton('Post', null, 'Post', null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);
$acao = isset($acao) ? $acao : null;
switch ($acao) {
	case 'Limpar':
		$frm->clearFields();
		break;
		//--------------------------------------------------------------------------------
}

$frm->show();
