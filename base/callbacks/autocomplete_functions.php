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

//--------------------------------------------------------
/**
* Função para ajudar na depuração do retorno do autocomplete
* a variavel erro esta recebendo um numero de erro como retorno mesmo a query ser bem sucesdida
* $boolDebug=true;
* impAutocomplete($sql,$boolDebug);
* impAutocomplete('$bvars='.print_r($bvars,true),$boolDebug);
* impAutocomplete('nrows='.$nrows,$boolDebug);
* impAutocomplete('intCacheTime='.$intCacheTime,$boolDebug);
* impAutocomplete('Erro='.$erro,$boolDebug);
*
* @param string $strTexto
* @param string $boolDebug
*/
function impAutocomplete($strText, $boolDebug) {
	if($boolDebug) {
		print $strText."\n";
	}
}

/**
 * Recupera o pacote Oracle e retorna o resultado.
 * 
 * @param strSearchField
 * @param intCacheTime
 * @param strSearchField
 * @param strTablePackageFuncion
 */
function recuperaPacoteOracleAutoComplete($strSearchField, $intCacheTime, $strTablePackageFuncion) {
	if($strSearchField) {
		$bvars[$strSearchField]=$_REQUEST['q'];
	}
	// Por razões de segurança, o variável num_pessoa tem que ser lido da sessão
	if ( defined('TIPO_ACESSO') && TIPO_ACESSO=='I' ) {
		$bvars['NUM_PESSOA_CERTIFICADO'] = $_SESSION['num_pessoa'];
	} else {
		$bvars['NUM_PESSOA'] = $_SESSION['num_pessoa'];
	}
	if( $erro = recuperarPacote($strTablePackageFuncion,$bvars,$res,(int)$intCacheTime)) {
		echo "Erro na função autocomplete(). Erro:".$erro[0]."\n";
		return;
	}
	
	return $res;
}


/**
 * Recupera o resultado da tabela 
 * @param array $bvars
 * @param [type] $boolSearchAnyPosition
 * @param [type] $arrUpdateFields
 * @param [type] $strSearchField
 * @param [type] $strTablePackageFuncion
 * @param string $configFileName Nome do arquivo conexão com banco na pasta <APP>/includes/<nome_arquivo>.php para executar o autocomplete. 
 * @param bool $trimText 
 * @return void
 */
function tableRecoverResult($bvars, $boolSearchAnyPosition, $arrUpdateFields, $strSearchField, $strTablePackageFuncion,$configFileName,$trimText) {
	$configFileName = isset( $configFileName ) ? $configFileName : null;
	$sql = tableRecoverCreateSql ( $bvars, $boolSearchAnyPosition, $arrUpdateFields ,$strSearchField ,$strTablePackageFuncion ,$trimText);
	//impAutocomplete( $sql,true);return;

	$res	=null;
    if( !class_exists('TPDOConnectionObj') ) {
		throw new BadFunctionCallException(TMessage::ERROR_AUTOCOMPLETE_WHITOUT_TPDO_OBJ);
		return;
	} else {
		$tpdo = New TPDOConnectionObj(false);
		if( $configFileName == "null" ){
			$tpdo->connect(null,true,null,null);
		}elseif( $configFileName == null){
			$tpdo->connect(null,true,null,null);
		}else{
			if ( !defined('ROOT_PATH') ) {
				throw new BadFunctionCallException(TMessage::ERROR_AUTOCOMPLETE_WHITOUT_ROOT);
				return;
			}
			if ( !defined('DS') ){ define ( 'DS', DIRECTORY_SEPARATOR ); }
			require_once ROOT_PATH.DS.'includes'.DS.$configFileName;
			$configArray = getConnectionArray();
			$tpdo->connect(null,true,null,$configArray);
		}
		$res = $tpdo->executeSql($sql);
	}
	return $res;
}


/**
 * Gera o SQL que será executado
 * 
 * @param array  $bvars                  1: 
 * @param bool   $boolSearchAnyPosition  2: pesquisa o texto com like dos dois lados
 * @param array  $arrUpdateFields        3:
 * @param string $strSearchField         4:
 * @param string $strTablePackageFuncion 5:
 * @param bool   $trimText               6: se não deve fazer uso o trim na pesquisa do texto
 */
function tableRecoverCreateSql($bvars, $boolSearchAnyPosition, $arrUpdateFields, $strSearchField, $strTablePackageFuncion ,$trimText) {
	$selectColumns=$strSearchField;
	$trimText = isset( $trimText ) ? $trimText : true;
	if( is_array($arrUpdateFields)) {
		foreach($arrUpdateFields as $k=>$v) {
			if( strtoupper($k) != strtoupper( $strSearchField ) ) {
				$selectColumns.=','.$k;
			}
		}
	}
	$text  = StringHelper::str2utf8($_REQUEST['q']);

	if( $trimText == true){
		$text  = trim($text);
	}
	$where = "upper({$strSearchField}) like upper('".($boolSearchAnyPosition === true ? '%' : '' ).$text."%')";
	if( is_array($bvars) ) {
		foreach($bvars as $k=>$v) {
			$where .=" and {$k} = '{$v}'";
		}
	}
	$sql 	= "select {$selectColumns} from {$strTablePackageFuncion} where {$where} order by {$strSearchField}";
	return $sql;
}

?>