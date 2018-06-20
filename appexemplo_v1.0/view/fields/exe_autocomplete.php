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

//Info sobre a conecao
TPDOConnection::test(false);

$html = '<h3>Este exemplo está utilizando o banco de dados bdApoio.s3db ( sqlite) do diretório exemplos.<br>
 A tabela de consulta é a tb_municipio.<br>
 A consulta esta configurada para disparar quando for digitado o terceiro caractere do nome.<br>
 O campo Cod Uf será preenchido automaticamente quando a cidade for encontrada ou selecionada</h3>';


$html2 = 'Exemplo busque pela palavra SERRA, nos dois grupos.'
		.'<br>No grupo 1 irá buscar por municipios iniciados com SERRA'
		.'<br>No grupo 2 irá buscar por municipios com SERRA em qualquer posição'
		;

 $frm = new TForm( 'Exemplo Campo Texto com Autocompletar',400 );
 $frm->addHtmlField('msg',$html);
 
$frm->addGroupField('gpx1','Exemplo AutoComple, busca apenas iniciando com');
	$frm->addTextField( 'nom_municipio', 'Cidade:', 60 )->setExampleText( 'Digite os 3 primeiros caracteres.')->addEvent('onblur','validarMunicipio(this)');
	$frm->addTextField('cod_uf','Cód Uf:',false);
$frm->closeGroup();

$frm->addGroupField('gpx2','Exemplo AutoComple, busca qualquer posição');
	$frm->addHtmlField('msg2',$html2);
	$frm->addTextField( 'nom_municipio2', 'Cidade 2:', 60 )->setExampleText( 'Digite os 3 primeiros caracteres.')->addEvent('onblur','validarMunicipio(this)');
	$frm->addTextField('cod_uf2','Cód Uf 2:',false);
$frm->closeGroup();


/**************
 *  o setAutoComplete deve sempre ficar depois da definição dos campos
 */

$frm->setAutoComplete( 'nom_municipio'
		             , 'tb_municipio'            // tabela alvo da pesquisa
		             , 'nom_municipio'           // campo de pesquisa
                	 , 'cod_municipio,cod_uf'    // campos do form origem que serão atualizados ao selecionar o item desejado. Separados por virgulas seguindo o padrão <campo_tabela> | <campo_formulario> , <campo_tabela> | <campo_formulario>
                     , true
		             , null                      // campo do formulário que será adicionado como filtro
                     , 'callback_autocomplete_municipio()'
                     , 3
                     , 1000
		             , 50                         // máximo de registros que deverá ser retornado
                     , null
                     , null
		             , null                       //url da função de callbacks, se ficar em branco será tratado por callbacks/autocomplete.php
		             , null
                     , true );

$frm->setAutoComplete( 'nom_municipio2'
		             , 'tb_municipio'            // 2: tabela alvo da pesquisa
		             , 'nom_municipio'           // 3: campo de pesquisa
		             , 'cod_municipio|cod_municipio2,cod_uf|cod_uf2'  // 4: campos do form origem que serão atualizados ao selecionar o item desejado. Separados por virgulas seguindo o padrão <campo_tabela> | <campo_formulario> , <campo_tabela> | <campo_formulario>
		             , true
		             , null                      // 6: campo do formulário que será adicionado como filtro
		             , 'callback_autocomplete_municipio()'
		             , 3
		             , 1000                       // Default 1000, tempo após a digitação para disparar a consulta
		             , 50                         // máximo de registros que deverá ser retornado
		             , null
		             , null
		             , null                       // url da função de callbacks, se ficar em branco será tratado por callbacks/autocomplete.php
		             , null                       // Mesagem caso não encontre nenhum registro
		             , null
		             , null
		             , null
		             , true                       // $boolSearchAnyPosition busca o texto em qualquer posição igual Like %texto%
		             );



$frm->setAction( 'Refresh' );
$frm->show();
?>

<script>
	/**
	 * callback_autocomplete_especies
	 *
	 *
	 * @return
	 *
	 * @see
	 */

	function callback_autocomplete_municipio() {
			fwAlert('callback autocompelte foi chamada.');
	}
	
	function validarMunicipio(e) {
		if( !fwAutoCompleteValidade(e)) {
			e.value = '';
		}
	}
</script>