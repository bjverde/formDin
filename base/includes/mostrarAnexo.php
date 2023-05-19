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

/*
Este módulo deverá ser utilizado para mostrar o conteudo de um campo blob gravado no banco de dados
Os parametros deverão ser passados no formato json:
Parametros:
pacote 		-> nome do pacote oracle que retorna o campo blob
colunaChave	-> nome da coluna chave do pacote
colunaLOB	-> nome da coluna que contem os dados binarios
valorChave	-> valor da chave a ser pesquisada
nomeArquivo	-> nome do arquivo que foi armazenado no banco. ( se tiver) ex: teste.doc, anotações.rtf

Exemplo:
1ª FORMA ( não recomendada )
	$link = '<a href="javascript:void(0);" onClick='mostrarAnexo("{\"pacote\":\"SIGER.PKG_UNIDADE_IBAMA_ACORDO.SEL_LOB\",\"colunaChave\":\"SEQ_UNIDADE_IBAMA_ACORDO\",\"colunaLOB\":\"ANEXO\",\"valorChave\":77,\"nomeArquivo\":\"dof.pdf\"}");'>052/2005</a>

2ª forma ( recomendado )
$dados = array("pacote"=>"SIGER.PKG_UNIDADE_IBAMA_ACORDO.SEL_LOB"
			,"colunaChave"=>"SEQ_UNIDADE_IBAMA_ACORDO"
			,"colunaLOB"=>"ANEXO"
			,"valorChave"=>$frm->get('seq_unidade_ibama_acordo')
			,"nomeArquivo"=>$frm->get('nom_arquivo'));
	$frm->javaScript[] ="mostrarAnexo('".json_encode($dados)."');";
*/
session_start();
include(encontrarArquivoMostrarAnexo('includes/config.inc'));
include(encontrarArquivoMostrarAnexo('classes/banco.inc'));
$tmpDir = encontrarArquivoMostrarAnexo('tmp');
$dados = json_decode(utf8_encode($_REQUEST['dados']),true);

if(!is_array($dados))
{
	print 'Parametro "dados" não está no formato json correto!';
	print '<hr>';
	print 'Valor recebido:';
	print '<pre>';
	print_r($_REQUEST['dados']);
	print '</pre>';
	die();
}
$db = new banco();
$bvars=array($dados['colunaChave']=>$dados['valorChave']);
// enviar o num_pessoa para a execução do pacote por motivo de segurança
if( !array_key_exists('NUM_PESSOA',$bvars))
{
	$bvars['NUM_PESSOA'] = $_SESSION['num_pessoa'];
}

if( $erro = $db->executar_pacote_func_proc($dados['pacote'],$bvars,-1))
{
	print_r($erro);
	return;
}

// limpa diretório temporário
$t=time();
$h=opendir($tmpDir);
while($file=readdir($h)) {
	if(substr($file,0,3)=='tmp') {
  		$path=$tmpDir."/".$file;
     	if( $t-filemtime($path)> 300 )
     	{
	     	@unlink($path);
     	}
	}
}
closedir($h);

if((string)$dados['nomeArquivo']<>'')
{
	$arquivo = $tmpDir.'/tmp_'.StringHelper::utf8_decode($dados['nomeArquivo']);
}
else
{
	$arquivo = $tmpDir.'/tmp_'.date('his');
}
$arquivo = str_replace('@','',$arquivo);
$arquivo = str_replace('$','',$arquivo);
$arquivo = str_replace(' ','_',$arquivo);
$arquivo = str_replace('//','/',$arquivo);

if( file_exists($arquivo) )
{
	unlink($arquivo);
}
if (!$handle = fopen($arquivo, 'x+'))
{
   echo "Não foi possível abrir o arquivo ($arquivo)";
   exit;
}

if( is_array( $bvars['CURSOR']))
{
	// Write $somecontent to our opened file.
	if (fwrite($handle, $bvars['CURSOR'][$dados['colunaLOB']][0]) === FALSE)
	{
		echo "Não foi possivel gravar no arquivo ($arquivo)";
		exit;
	}
}
else
{
	if (fwrite($handle, $bvars[$dados['colunaLOB']]) === FALSE)
	{
		echo "Não foi possivel gravar no arquivo ($arquivo)";
		exit;
	}
}

fclose($handle);
header("Pragma: no-cache");
if(strpos(strtoLower($arquivo),'.doc') > 0 )
{
	header("Content-type: application/msword");
}
else if(strpos(strtoLower($arquivo),'.jpg') > 0 || strpos(strtoLower($arquivo),'.jpeg') > 0 )
{
	header("Content-type: application/image/jpg");
}
else if(strpos(strtoLower($arquivo),'.pdf') > 0 )
{
	header("Content-type: application/pdf");
	if( $_REQUEST['browser']=='MSIE' && $_REQUEST['versao'] < '6')
	{
		// assim funciona no IE 5
		echo file_get_contents($arquivo);
		return;
	}
}
else if(strpos(strtoLower($arquivo),'.zip') > 0 )
{
	header("Content-type: application/zip");
}
else if(strpos(strtoLower($arquivo),'.gz') > 0 )
{
	header("Content-type: application/x-gzip");
}
else if(strpos(strtoLower($arquivo),'.rar') > 0 )
{
	header("Content-type: application/x-rar-compressed");
}
else if(strpos(strtoLower($arquivo),'.xls') > 0 )
{
	header("Content-type: application/ms-excel");
}
else if(strpos(strtoLower($arquivo),'.ppt') > 0 )
{
	header("Content-type: application/ms-powerpoint");
}
else if(strpos(strtoLower($arquivo),'.gif') > 0 )
{
	header("Content-type: application/image/gif");
}
else if(strpos(strtoLower($arquivo),'.bmp') > 0 )
{
	header("Content-type: application/image/bmp");
}
else if(strpos(strtoLower($arquivo),'.png') > 0 )
{
	header("Content-type: application/image/png");
}
else if(strpos(strtoLower($arquivo),'.tif') > 0 )
{
	header("Content-type: application/image/tif");
}
else if(strpos(strtoLower($arquivo),'.au') > 0 )
{
	header("Content-type: application/audio/basic");
}
else if(strpos(strtoLower($arquivo),'.aud') > 0 )
{
	header("Content-type: application/audio/basic");
}
else if(strpos(strtoLower($arquivo),'.wav') > 0 )
{
	header("Content-type: application/audio/wav");
}
else if(strpos(strtoLower($arquivo),'.mid') > 0 )
{
	header("Content-type: application/audio/x-mid");
}
else if(strpos(strtoLower($arquivo),'.avi') > 0 )
{
	header("Content-type: application/video/avi");
}
else if(strpos(strtoLower($arquivo),'.mp3') > 0 )
{
	header("Content-type: application/audio/mp3");
}
else if(strpos(strtoLower($arquivo),'.mpg') > 0 )
{
	header("Content-type: application/video/mpg");
}
else if(strpos(strtoLower($arquivo),'.mpeg') > 0 )
{
	header("Content-type: application/video/mpeg");
}
else if(strpos(strtoLower($arquivo),'.swf') > 0 )
{
	header("Content-type: application/x-shockwave-flash");
}
//header("Content-disposition: inline; filename=$arquivo");
header("Location: $arquivo");
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
