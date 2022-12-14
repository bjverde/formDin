<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
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
* Em função dos parametros recibidos "pasta_base" e "app_url_root", encontrar o diretório raiz da aplicacao
* para poder criar o banco de dados de ajuda /ho/bdho.s3bd
*/
/*
$app_url_root='';
// se a base estiver fora do diretório da aplicacao, montar a url com o nome do diretório da aplicação
if ( preg_match('/\.\.\//',$_REQUEST['pastaBase']) == 1 )
{
	$app_url_root 	= preg_replace('/\/\//','/',$_REQUEST['app_url_root']);
	$aPath 			= explode('/',$app_url_root);
	//$pastaBase 		= preg_replace('/\/base/','',$_REQUEST['pastaBase']);
	$app_url_root 	= ( $aPath[count($aPath)-1] != '') ? $aPath[count($aPath)-1] != '':$aPath[count($aPath)-2];
}
$bdDirName 		= preg_replace('/\/\//','/','../../'.$app_url_root.'/ho/');
$bdFileName 	= preg_replace('/\/\//','/',$bdDirName.'/dbho.s3db');
*/
//[HTTP_REFERER] => http://localhost/sistemas/formdin4/cemave/sistaxon2/index.php?modulo=modulos/cad_ajax/cad_ajax.php
//[SCRIPT_FILENAME] => E:/xampp/htdocs/sistemas/formdin4/cemave/sistaxon2/index.php
//[REQUEST_URI] => /sistemas/formdin4/cemave/sistaxon2/index.php
//[SCRIPT_NAME] => /sistemas/formdin4/cemave/sistaxon2/index.php
//[PHP_SELF] => /sistemas/formdin4/cemave/sistaxon2/index.php

/*
$ru = $_SERVER['REQUEST_URI']
$aFileParts = pathinfo($ru);
$dirName 	= $aFileParts['dirname'];
$bdDirName  = str_replace('//','/',$dirName.'/ho');
*/
/*
 *
 * */
//ob_start();

@chmod('ho/', 0777);
if ( ! is_writable('ho/' ) )
{
	die ('não tem permissão');
	exit();
}
$bdDirName  = 'ho/';
@mkdir("ho/","0775");

if( !file_exists($bdDirName))
{
	if( $bdDirName && ! file_exists($bdDirName) )
	{
		//if ( ! mkdir($bdDirName, 0775, true ) )
    	{
 			echo '- Não foi possivel criar o diretório do banco de dados de ajuda: '.$bdDirName;
		}
	}
}

//error_reporting(E_ALL);
if( !$db = new PDO('sqlite:'.$bdDirName.'/dbho.s3.db') )
{
	echo  ' - Não foi possivel conectar ao banco sqlite '.$bdDirName.'/dbho.s3.db';
}

//$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$row = $db->query('select count(*) as total from tb_help where 1 = 1');
if( ! $row )
{
	 $query = 'CREATE TABLE [tb_help] (
				[help_key] char(32)  NULL,
				[help_title] VARCHAR(150)  NULL,
				[help_text] TEXT  NULL,
				PRIMARY KEY ([help_key])
				)';
	$db->exec( $query );

}
$acao = isset($_REQUEST['acao'] ) ? $_REQUEST['acao'] : '';
$key  	= md5( strtoupper(trim($_REQUEST['contexto'].'_'.$_REQUEST['campo'])));
sleep(1); // mostrar progressbar
switch( $acao )
{
	case 'salvar';
		//error_reporting(E_ALL);
		$query = "select help_key from tb_help where help_key='".$key."'";
		$res = $db->query( $query );
		$row = $res->fetch(PDO::FETCH_ASSOC);
   		if( $row['help_key'] )
		{
 			$query = "update tb_help set help_title = '".addslashes($_REQUEST['help_title'])."', help_text='".addslashes($_REQUEST['help_text'])."' where help_key='".addslashes($key)."'";
	    }
    	else
    	{
   			$query = "insert into tb_help ( help_key,help_title,help_text) values('".addslashes($key)."','".addslashes($_REQUEST['help_title'])."','".addslashes($_REQUEST['help_text'])."')";
		}
		if( !$db->exec( $query ))
		{
			 print 'Erro de gravação';
		}
		exit(0);
	break;
	//--------------------------------------------------------------------------------------------------------------------
	case 'ler':
		//error_reporting(E_ALL);
	   	$query = "select help_text,help_title from tb_help where help_key='".$key."'";
		if( ! $result = $db->query( $query ) )
		{
			die( $error );
		}
		$row = $result->fetch(PDO::FETCH_ASSOC);
		//die( 'RESULTADO:' . print_r( $row, true ) );
		$data = null;
		$_REQUEST['label'] = is_null($_REQUEST['label']) ?'&lt;CAMPO&gt;' : $_REQUEST['label'];
		$html = '<p><span style="text-decoration: underline;"><span style="font-size: x-large;">'.$_REQUEST['label'].'</span></span></p>';
		$data['help_text']  = StringHelper::utf8_decode( $html);//'Digite aqui o conteúdo do arquivo de ajuda!' );
		$data['help_title'] = '';
		if( isset( $row['help_text']) && $row['help_text'] )
		{
			$data = null;
			$data['help_text']  = stripslashes($row['help_text']);
			$data['help_title'] = ( trim($row['help_title']) == '' ) ? $_REQUEST['label'] : $row['help_title'];
		}
		echo json_encode($data);
	break;
}



/*
$bdFileName = str_replace('//','/',$bdDirName.'/dbho.s3.db');
//if ( $db = sqlite_open( $bdFileName, 0666, $sqliteerror))
if ( $db = new SQLiteDatabase($bdFileName,0666) )
{
	// verificar se a tabela existe e cria-la se não existir
	$q = @$db->query('select count(*) from tb_help where 1 = 1');
    if ($q === false)
    {
    	$query = 'CREATE TABLE [tb_help] (
					[help_key] char(32)  NULL,
					[help_title] VARCHAR(150)  NULL,
					[help_text] TEXT  NULL,
					PRIMARY KEY ([help_key])
					)';
    	if( ! $db->queryExec( $query, $error))
		{
			die( $error );
		}
	}
}
else
{
	 die( $sqliteerror );
}
$acao = isset($_REQUEST['acao'] ) ? $_REQUEST['acao'] : '';
$key  	= md5( strtoupper(trim($_REQUEST['contexto'].'_'.$_REQUEST['campo'])));
sleep(1); // mostrar progressbar
switch( $acao )
{
	case 'salvar';
		$query = "select help_key from tb_help where help_key='".$key."'";
		if( ! $res=$db->query( $query, SQLITE_ASSOC, $error) )
		{
			die( $error );
		}
   		if( $res->numRows() > 0)
		{
 			$query = "update tb_help set help_title = '".sqlite_escape_string($_REQUEST['help_title'])."', help_text='".sqlite_escape_string($_REQUEST['help_text'])."' where help_key='".sqlite_escape_string($key)."'";
	    }
    	else
    	{
   			$query = "insert into tb_help ( help_key,help_title,help_text) values('".sqlite_escape_string($key)."','".sqlite_escape_string($_REQUEST['help_title'])."','".sqlite_escape_string($_REQUEST['help_text'])."')";
		}
		if( ! $db->queryExec( $query, $error))
		{
			die( $error );
		}
		exit(0);
	break;
	//--------------------------------------------------------------------------------------------------------------------
	case 'ler':
	   	$query = "select help_text,help_title from tb_help where help_key='".$key."'";
		if( ! $res=$db->query( $query, SQLITE_ASSOC, $error) )
		{
			die( $error );
		}
		$data = null;
		$_REQUEST['label'] = is_null($_REQUEST['label']) ?'&lt;CAMPO&gt;' : $_REQUEST['label'];
		$html = '<p><span style="text-decoration: underline;"><span style="font-size: x-large;">'.$_REQUEST['label'].'</span></span></p>';
		$data['help_text']  = utf8_encode( $html);//'Digite aqui o conteúdo do arquivo de ajuda!' );
		$data['help_title'] = '';
		if( $res->numRows() > 0)
		{
			$row = $res->fetch();
			$data = null;
			$data['help_text']  = stripslashes($row['help_text']);
			$data['help_title'] = $row['help_title'];
			//$frm->set('hepp_title',$row['help_title']);
		}
		echo json_encode($data);
	break;
}
*/
?>
