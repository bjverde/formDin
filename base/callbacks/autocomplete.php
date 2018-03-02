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

require_once 'autocomplete_functions.php';

if( !class_exists('TPDOConnection') || !TPDOConnection::getInstance() ) {
	if( !function_exists('recuperarPacote') ) {
		print 'Faltou include da conexão|';
		return;
	}
}

$boolDebug=false;
$bvars=null;
$intCacheTime = isset( $_REQUEST['cacheTime'] ) ? $_REQUEST['cacheTime'] : -1; // sem cache
$boolSearchAnyPosition = isset( $_REQUEST['searchAnyPosition'] ) ? ( $_REQUEST['searchAnyPosition'] == 'true' ) : false; // usar %like%


 //print_r($_REQUEST,TRUE);
 //DIE;

$strFunctionJs = null;
//----------------------------------------------------------------------------------
foreach($_REQUEST as $k=>$v) {
	// decodificar os parametros recebidos
	$v = utf8_decode($v);
	$_REQUEST[$k] = $v;

	// os parametros para adicionar ao bvars vem prefixados com _w_   ( de where )
	if(substr($k,0,3)=="_w_") {
		if( $v ) {
			$aTemp = explode('|',$k);
			if( ! isset($aTemp[1] ) ) {
				$aTemp[1]=substr($aTemp[0],3);
			}
			$bvars[strtoupper($aTemp[1])]= $v;
			impAutocomplete("bvars:".strtoupper($aTemp[1]).'='.$v,$boolDebug);
		}
	}
	// os parametros para atualizar os campos ao selecionar uma opção veem com _u_  ( de update )
	else if(substr($k,0,3)=="_u_") {
		$arrUpdateFields[strtoupper(substr($k,3))]=$v;
		impAutocomplete("upd:".strtoupper(substr($k,3)).'='.$v,$boolDebug);
	}
	else if($k=='functionJs') {
		$strFunctionJs=$v;
		impAutocomplete("functionJs:".$strFunctionJs,$boolDebug);
	}
	else if($k=='searchField') {
		$strSearchField=$v;
		impAutocomplete("searchField:".$strSearchField."\n",$boolDebug);
	}
	else if($k=='tablePackageFunction') {
		$strTablePackageFuncion=$v;
		impAutocomplete("tablePackageFunction:".$strTablePackageFuncion,$boolDebug);
	} else {
		impAutocomplete( $k.'='.$v,$boolDebug);
	}
}
if($boolDebug) {
	return;
}

// Testa se foi passado um pacote Oracle, Se não busca uma tabela
if(preg_match('/\.PK\a?/i',$strTablePackageFuncion)>0) {
	$res = recuperaPacoteOracleAutoComplete ( $strSearchField, $intCacheTime, $strTablePackageFuncion );
} else {
	$res = tableRecoverResult( $bvars, $boolSearchAnyPosition, $arrUpdateFields, $strSearchField, $strTablePackageFuncion);
}

//----------------------------------------------------------------------------------
if( is_array( $res ) ) {
	if( count($res[key($res)])==0) {
		return;
	}
	//echo 'Update:'.print_r($arrUpdateFields,true);
	if ( !array_key_exists($strSearchField ,$res) ) {
		$strSearchField = strtoupper($strSearchField);
	}
	if ( !array_key_exists($strSearchField ,$res) ) {
		echo utf8_encode('Coluna '.$strSearchField.' não existe na tabela');
		return;
	}
	foreach($res[key($res)] as $k=>$v) {
		$upd=array();
		if( is_array($arrUpdateFields) ) {
			foreach($arrUpdateFields as $fieldOracle=>$fieldForm) {
				$upd[$fieldForm] = utf8_encode($res[$fieldOracle][$k]);
			}
			
			if(isset($strFunctionJs)) {
				$upd['fwCallbackAc']= $strFunctionJs;
				//$upd[$strFunctionJs]='';
			}
		}
		if( isset($res[$strSearchField][$k]) ){
			echo $res[$strSearchField][$k].'|'.json_encode($upd)."\n";
		} else {
			echo $res[$strSearchField][$k].'|'.json_encode($upd)."\n";
		}
		//echo json_encode($upd)."\n";
	}
}
return;
?>