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

if( !class_exists('TPDOConnection') || !TPDOConnection::getInstance() )
{
	if( !function_exists('recuperarPacote') )
	{
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
foreach($_REQUEST as $k=>$v)
{
	// decodificar os parametros recebidos
	$v = utf8_decode($v);
	$_REQUEST[$k] = $v;

	// os parametros para adicionar ao bvars vem prefixados com _w_   ( de where )
	if(substr($k,0,3)=="_w_")
	{
		if( $v )
		{
			$aTemp = explode('|',$k);
			if( ! isset($aTemp[1] ) )
			{
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
// se for passado o nome de uma tabela, criar o comando select
if(preg_match('/\.PK\a?/i',$strTablePackageFuncion)>0) {
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
		echo utf8_encode("Erro na função autocomplete(). Erro:".$erro[0])."\n";
		return;
	}
} else {
	$selectColumns=$strSearchField;
	
	if( is_array($arrUpdateFields)) {
		foreach($arrUpdateFields as $k=>$v) {
			if( strtoupper($k) != strtoupper( $strSearchField ) ) {
				$selectColumns.=','.$k;
			}
		}
	}
	//$where = "upper({$strSearchField}) like '".strtoupper($_REQUEST['q'])."%'";
	$where = "upper({$strSearchField}) like upper('".($boolSearchAnyPosition === true ? '%' : '' ). utf8_encode($_REQUEST['q'])."%')";
	if( is_array($bvars) ) {
		foreach($bvars as $k=>$v) {
			$where .=" and {$k} = '{$v}'";
		}
	}
	$sql 	= "select {$selectColumns} from {$strTablePackageFuncion} where {$where} order by {$strSearchField}";
	//impAutocomplete( $sql,true);return;

	$bvars	=null;
	$res	=null;
	$nrows	=null;
    if( !class_exists('TPDOConnection') || !TPDOConnection::getInstance() )
    {
		if( $erro = $GLOBALS['conexao']->executar_recuperar($sql,$bvars,$res,$nrows,(int)$intCacheTime) )
		{
			// a variavel erro esta recebendo um numero de erro como retorno mesmo a query ser bem sucesdida
            //$boolDebug=true;
			//impAutocomplete($sql,$boolDebug);
			//impAutocomplete('$bvars='.print_r($bvars,true),$boolDebug);
			//impAutocomplete('nrows='.$nrows,$boolDebug);
			//impAutocomplete('intCacheTime='.$intCacheTime,$boolDebug);
			//impAutocomplete('Erro='.$erro,$boolDebug);
			if( preg_match('/falha/i',$erro ) > 0 )
			{
				echo utf8_encode("Erro na função autocomplete(). Erro:".$erro)."\n".$sql;
				return;
			}
		}
	} else {
		$res = TPDOConnection::executeSql($sql);
		//echo utf8_encode($sql."\n");
		//return;
	}
}
//----------------------------------------------------------------------------------
if( is_array( $res ) )
{
	if( count($res[key($res)])==0)
	{
		return;
	}
	//echo 'Update:'.print_r($arrUpdateFields,true);
	if ( !array_key_exists($strSearchField ,$res) )
	{
		$strSearchField = strtoupper($strSearchField);
	}
	if ( !array_key_exists($strSearchField ,$res) )
	{
		echo utf8_encode('Coluna '.$strSearchField.' não existe na tabela');
		return;
	}
	foreach($res[key($res)] as $k=>$v)
	{
		$upd=array();
		if(is_array($arrUpdateFields))
		{
			foreach($arrUpdateFields as $fieldOracle=>$fieldForm)
			{
				$upd[$fieldForm] = utf8_encode($res[$fieldOracle][$k]);
			}
			if(isset($strFunctionJs))
			{
				$upd['fwCallbackAc']= $strFunctionJs;
				//$upd[$strFunctionJs]='';
			}
		}
		if( isset($res[$strSearchField][$k]))
		{
			echo $res[$strSearchField][$k].'|'.json_encode($upd)."\n";
		}
		else
		{
			echo $res[$strSearchField][$k].'|'.json_encode($upd)."\n";
		}
		//echo json_encode($upd)."\n";
	}
}
return;

//--------------------------------------------------------
/**
* Função para ajudar na depuração do retorno do autocomplete
*
* @param string $strTexto
* @param string $boolDebug
*/
function impAutocomplete($strText, $boolDebug)
{
	if($boolDebug)
	{
		print $strText."\n";
	}
}
?>

