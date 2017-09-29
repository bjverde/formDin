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

$tmpDir = encontrarArquivoMostrarAnexo('tmp');
if ( $_POST['nomArquivo'] ) {
	session_start();
	
	// limpa diretório temporário
	$t=time();
	$h=opendir($tmpDir);
	while($file=readdir($h)) 
	{
		if(substr($file,0,3)=='tmp') 
		{
	  		$path=$tmpDir."/".$file;
	     	if( $t-filemtime($path)> 1800 )
	     	{
		     	@unlink($path);
	     	}
		}
	}
	closedir($h);
	
	$arquivo = 'tmp'.substr(session_id(),0,6).'_'.strtolower($_POST['nomArquivo']);
			
	if( file_exists($arquivo) )
	{
		unlink($arquivo);
	}
	$uri   = ($_SERVER['HTTPS']?'https://':'http://').$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
}
if ( !$_POST['valorChave'] && $_POST['nomArquivo'] ){
	if ( !file_put_contents('../tmp/'.$arquivo,file_get_contents('../tmp/upload_'.md5(session_id().$_POST['nomArquivo']))) )
	{
			echo "Não foi possível gravar o arquivo ($arquivo)";
			exit();			
	}
	header("Location: ".dirname($uri).'/tmp/'.rawurlencode($arquivo));
	exit();
}
if( $_POST['valorChave']  && $_POST['nomArquivo'] && $_POST['funcaoPlsqlMostrarAnexo']) {
	include(encontrarArquivoMostrarAnexo('includes/config.inc'));
	include(encontrarArquivoMostrarAnexo('classes/banco.inc'));
	
	$db = new banco();
	$bvars=array($_POST['campoChave']=>$_POST['valorChave'],'NUM_PESSOA' => $_SESSION['num_pessoa'] );
	
	if( $erro = $db->executar_pacote_func_proc($_POST['funcaoPlsqlMostrarAnexo'],$bvars,-1))
	{
		print_r($erro);
		return;
	}

	if( $bvars[$_POST['campoRetorno']] )
	{
		if ( ! file_put_contents('../tmp/'.$arquivo,$bvars[$_POST['campoRetorno']]) ) {
			echo "Não foi possível gravar o arquivo ($arquivo)";
			exit;			
		}
	}
	header("Location: ".dirname($uri).'/tmp/'.rawurlencode($arquivo));
	exit();
}

//--------------------------------------------------------------------
function encontrarArquivoMostrarAnexo($arquivo) {
	for( $i=0;$i<10;$i++) {
		$path = str_repeat('../',$i);
		if( file_exists($path.$arquivo ) ) {
			return $path.$arquivo;
			break;
		}
	}
}
?>
<html>
<head></head>
<body>
<form method="POST">
<input type="hidden" name="nomArquivo">
<input type="hidden" name="valorChave">
<input type="hidden" name="funcaoPlsqlMostrarAnexo">
<input type="hidden" name="campoChave">
<input type="hidden" name="campoRetorno">
</form>
</body>
</html>

