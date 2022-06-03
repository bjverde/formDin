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

ini_set('default_charset','utf-8');

//$_REQUEST['fwDebug'] = 1;
$_REQUEST['fwDebug'] = ( isset( $_REQUEST['fwDebug'] ) ? $_REQUEST['fwDebug'] : 0 );
$configFileName = isset( $_REQUEST['configFileName'] ) ? $_REQUEST['configFileName'] : null; // nome arquivo de config de banco

if( $_REQUEST['fwDebug']==1) {
	print_r( $_REQUEST );
	die();
}

function combinarSelectIsUTF8($string) {
    return (utf8_encode(utf8_decode($string)) == $string);
}

/**
 * Configura a conexão de banco. Se foi informado a constante ROOT_PATH vai
 * procurar o arquivo $configFileName informado via POST. Se não foi definida
 * a constante vai a configuração padrão do arquivo config_conexao.php
 *
 * @param String $configFileName 
 * @return void
 */
function getConfigBanco(String $configFileName) {
	$tpdo = New TPDOConnectionObj(false);
	if ( defined('ROOT_PATH') ) {
		if ( !defined('DS') ){ define ( 'DS', DIRECTORY_SEPARATOR ); }
		$configFileNamePath = ROOT_PATH.DS.'includes'.DS.$configFileName;
		if( !FileHelper::exists($configFileNamePath) ){
			throw new BadFunctionCallException(TMessage::ERROR_AUTOCOMPLETE_WHITOUT_CONFIG);
			return;
		}
		require_once $configFileNamePath;
		$configArray = getConnectionArray();
		$tpdo->connect(null,true,null,$configArray);
	}else{
		$configArray= array(
			'DBMS' => BANCO
		   ,'PORT' => PORT
		   ,'HOST' => HOST
		   ,'DATABASE' => DATABASE
		   ,'USERNAME' => USUARIO
		   ,'PASSWORD' => SENHA
		   ,'UTF8_DECODE' => 0
	   );
	   $tpdo->connect(null,true,null,$configArray);	
	}
	return $tpdo;
}


if( isset( $_REQUEST['descPrimeiraOpcao'] ) && combinarSelectIsUTF8( $_REQUEST['descPrimeiraOpcao'] ) )
{
	$_REQUEST['descPrimeiraOpcao'] = utf8_encode( $_REQUEST['descPrimeiraOpcao'] );
}

// executar pacote
$bvars=array(strtoupper($_REQUEST['colunaFiltro'])=>$_REQUEST['valorFiltro']);
// where que podera se utilizado no comando select se não tiver sido informado o nome de um pacote
$where		= strtoupper($_REQUEST['colunaFiltro'])."='".$_REQUEST['valorFiltro']."'";
if((string)$_REQUEST['campoFormFiltro']<>'')
{
	$aCampos 	= explode('|',$_REQUEST['campoFormFiltro']);
	$aValores 	= explode('|',$_REQUEST['campoFormFiltroValor']);
	foreach($aCampos as $k=>$v)
	{
		if((string)$aValores[$k]<>'')
		{
			$bvars[$v]=$aValores[$k];
			$where.=' and '.$v."='".$aValores[$k]."'";
		}
	}
}

if( isset($_REQUEST['fwSession_expired'] ) &&  $_REQUEST['fwSession_expired'] && $_REQUEST['fwSession_expired'] == true ) {
	 echo '{"fwSession_expired":"1"}';
	 die();
}

$campoCodigo  	= strtoupper($_REQUEST['colunaCodigo']);
$campoDescricao = strtoupper($_REQUEST['colunaDescricao']);
$retorno='{"campo":"'.$_REQUEST['campoSelect'].
			'","selectPai":"'.utf8_decode($_REQUEST['selectPai']).
			'","valorInicial":"'.utf8_decode($_REQUEST['valorInicial']).
			'","selectFilhoStatus":"'.$_REQUEST['selectFilhoStatus'].
			'","descPrimeiraOpcao":"'.utf8_decode($_REQUEST['descPrimeiraOpcao']).
			'","valorPrimeiraOpcao":"'.utf8_decode($_REQUEST['valorPrimeiraOpcao']).
			'","funcaoExecutar":"'.$_REQUEST['funcaoExecutar'].
			'","selectUniqueOption":"'.$_REQUEST['selectUniqueOption'].
			'","descNenhumaOpcao":"'.utf8_decode($_REQUEST['descNenhumaOpcao']).'"';
// executar pacote
$pacoteCache = explode('|',$_REQUEST['pacoteOracle']);

if (!isset($pacoteCache[1])) {
	$pacoteCache[1] = NULL;
}
//if(strpos($pacoteCache[0],'.PKG')>0)
if( preg_match('/\.PK\a?/i',$pacoteCache[0]) > 0 ) {
	if( $erro = recuperarPacote($pacoteCache[0],$bvars,$res,$pacoteCache[1])) {
		/*$banco = new banco();
		$bvars = array('COD_UF'=>53);
		$erro = $banco->executar_pacote_func_proc($pacoteCache[0],$bvars,0);
		$res = $bvars['CURSOR'];
		if( $res )
			print "alert('sim')";
		else
		   print "alert('{$erro[0]}')";
		return;
		*/
		print "alert('Erro na função combinarSelect().\\n".$erro[0]."')";
		return;
	}
} else {
	$sql = 'select '.$campoCodigo.','.$campoDescricao.' from '.$pacoteCache[0];
	if($where != "") {
		$sql .= " where ".$where;
	}
	$sql .= " order by ".$campoDescricao;

	if( $_REQUEST['fwDebug'] == '1' || $_REQUEST['fwDebug'] == '2' ){
		//echo 'Comando SQL:<br>';
		echo $sql;
		$sql = 'select COD_MUNICIPIO, NOM_MUNICIPIO from municipio where cod_uf = 53 order by nom_municipio';
	}

    if( !class_exists('TPDOConnection') || !TPDOConnection::getInstance() ){
		$bvars=null;
		$res=null;
		$res[$campoCodigo][] = 0;
		$res[$campoDescricao][] = $sql;
		if( $erro = $GLOBALS['conexao']->executar_recuperar($sql,$bvars,$res,$nrows,(int)$pacoteCache[1])) {
			if( preg_match('/falha/i',$erro ) > 0 ){
				$res[$campoCodigo][] = 0;
				$res[$campoDescricao][] = "Erro na funcao combinarSelect(). Erro:".$erro;
			}
		}
	} else {
		$tpdo = getConfigBanco($configFileName);
		$res = $tpdo->executeSql($sql);
		if( $tpdo->getError() ) {
			$res[$campoCodigo][] = 0;
			$res[$campoDescricao][] = "Erro na funcao combinarselect(). Erro:".$tpdo->getError();
			MessageHelper::logRecordSimple($tpdo->getError());
		}



		/*
		$tpdo = New TPDOConnectionObj(false);
		if( empty($configFileName) ){
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
		if( $tpdo->getError() ) {
			$res[$campoCodigo][] = 0;
			$res[$campoDescricao][] = "Erro na funcao combinarselect(). Erro:".$tpdo->getError();
			MessageHelper::logRecordSimple($tpdo->getError());
		}
		*/
	}
}

if( $_REQUEST['fwDebug'] == 3) {
	echo 'Resultado consulta:<br>';
	print_r($res);
	die('<hr>fim debug');
}

if($res) {
	/**
	* remover retorno de linha
	*/
	foreach( $res[$campoDescricao] as $k=>$v)
	{
		$res[$campoDescricao][$k] = preg_replace('/'.chr(13).'/',' ',$res[$campoDescricao][$k]);
		$res[$campoDescricao][$k] = preg_replace('/'.chr(10).'/',' ',$res[$campoDescricao][$k]);
		$res[$campoDescricao][$k] = preg_replace('/  /',' ',$res[$campoDescricao][$k]);

		if ( ! combinarSelectIsUTF8( $res[$campoDescricao][$k] ) )
		{
			$res[$campoDescricao][$k] = utf8_encode( $res[$campoDescricao][$k]);
			$res[$campoCodigo][$k] 	  = utf8_encode( $res[$campoCodigo][$k]);
		}
	}
	if( !array_key_exists($campoCodigo,$res))
	{
		$res[$campoCodigo][] = 0;
		$res[$campoDescricao][] = "1) Erro nos parametros da funcao combinarSelect(). A coluna ".$campoCodigo." nao existe no retorno do banco";
		//print "alert('Erro nos parametros da função combinarSelect().\\nA coluna ".$campoCodigo." não existe no retorno da função \\n".$_REQUEST['pacoteOracle']."')";
		//return;
	}
	else if( !array_key_exists($campoDescricao,$res))
	{
		$res[$campoCodigo][] = 0;
		$res[$campoDescricao][] = "2) Erro nos parametros da funcao combinarSelect(). A coluna ".$campoDescricao." nao existe no retorno do banco";
		//	print "alert('Erro nos parametros da função combinarSelect().\\nA coluna ".$campoDescricao." não existe no retorno da função \\n".$_REQUEST['pacoteOracle']."')";
		//	return;
	}
	if($res){
		$retorno.=',"dados":{';
		foreach($res[$campoCodigo] as $k=>$v)
		{
			$retorno .= ($k>0) ? ',' : '';
			//$retorno.='"'.$v.'":"'.str_replace("'",'´',str_replace('"','“',$res[$campoDescricao][$k]) ).'"';
			//$retorno.='"'.$v.'":"'.htmlspecialchars(str_replace('"','“',$res[$campoDescricao][$k])).'"';
			$retorno.='"'. htmlspecialchars(str_replace('"','“',$res[$campoDescricao][$k]))  .'":"'.$v.'"';
		}
		//$retorno.='"where":"'.$where.'"';
		$retorno.="}";
	}
}
$retorno .= ($retorno == '') ? '' : '}';
echo $retorno;