<?
//---------------------------------------------------------------------------------------------------------
// EXEMPLO 1:
// $campos['cod_uf']		= new camposelect('cod_uf','Estado:',true);
// $campos['cod_municipio']	= new CampoIframe('cod_municipio','Município:',true,'cod_uf','SISLIV.PK_GERAL.SEL_MUNICIPIO','COD_UF',null,null,null,null,null,null,null,null,null,null,'teste');
// o parametro 'teste' é o nome da função javascript que será chamada apos a seleção do municipios.
// Esta função recebe 4 parametros: o objeto select, o valor da chave que é o codigo do municipio, a posicao que o municipio selecionado esta na lista e o nome do mumicipio selecionado
// function teste(p1,p2,p3,p4) {
// alert( "Funcao teste foi executada:\n"+'Objeto:' + p1+"\nValor:"+p2+"\nIndice:"+p3+"\nTexto:"+p4);
// return true;
//---------------------------------------------------------------------------------------------------------
// EXEMPLO 2:
// $campos['seq_norma']  			= new CampoSelect ('seq_norma','Nº norma:',false);
// $campos['seq_rotina_anterior'] 	= new CampoIFrame ('seq_rotina_anterior'
//                           ,'Artigo anterior:'
//                           ,false
//                           ,'seq_norma'
//                           ,'AUDITORIA_PAAAI.PKG_ROTINA.SEL_ROTINA_NORMA_ANTERIOR
//                                 |SEQ_ROTINA
//                                 |DES_ARTIGO
//                                 |Selecione uma norma
//                                 |Nenhuma artigo revogado
//                                 |N'
//                           ,'SEQ_NORMA');
//
//---------------------------------------------------------------------------------------------------------

error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
session_start();
?>
<html>
<head>
<style>
body{
background-color:#F3F3F4;;
}
input {
	border:1px solid silver;

}
.formDinCampoMulti{
	border:solid 0px black;
	padding:0;
	vertical-align:middle;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	font-style:normal;
	color:#000000;
	cursor:pointer;
}
</STYLE>
<!--<link href="../css/FormDin3.css" rel="stylesheet" type="text/css">-->
<script language="JavaScript">
	function mudou(campo, campoSelect,valorCampoOutro, campoOutroCampoAtualizar,executarFuncao ) {
		if(campoOutroCampoAtualizar) {
			obj = document.getElementById('campooutro');
			if( obj) {
				if( campoSelect.options[campoSelect.selectedIndex].text==valorCampoOutro) {
					obj.style.display='';
					document.getElementById(campo+'_outro').focus();
				} else {
					obj.style.display='none';
					eval( 'parent.document.formdin.'+campoOutroCampoAtualizar+'.value=""');
				}
			}
		}
		eval( 'parent.document.formdin.'+campo+'.value="'+campoSelect.options[campoSelect.selectedIndex].value+'"');
		if( executarFuncao != null && executarFuncao != '') {
			try {
				if(executarFuncao.indexOf('(') >-1 ){
			  		eval('parent.'+executarFuncao+';');
			} else {
		      		eval('parent.'+executarFuncao+'(this,"'+campoSelect.options[campoSelect.selectedIndex].value+
		      		                                    '",'+campoSelect.selectedIndex+
		      		                                    ',"'+campoSelect.options[campoSelect.selectedIndex].text+
		      		                                    '");');
				}
	 		} catch(e) {};
		}
	}
	function atualizarCampoOutro(obj,campoOutroCampoAtualizar){
		eval( 'parent.document.formdin.'+campoOutroCampoAtualizar+'.value="'+obj.value+'"');
	}
</script>
</head>
<body>
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

$aDados = explode('|',$_GET['nomePacote']);
$nomePacote   = strtoupper($aDados[0]);
$colunaChave  = strtoupper($aDados[1]);
$colunaDados  = strtoupper($aDados[2]);
$msgSelecione = !$aDados[3] ? 'Selecione UF' : $aDados[3];
$msgNenhum    = !$aDados[4] ? 'Nenhum município encontrado' : $aDados[4];
$msgSelecione = '-- '.$msgSelecione.' --';
$msgNenhum    = '-- '.$msgNenhum.' --';

if(!$_GET){
	print $msgSelecione;
	return;
}
$pasta_base   = iFrameEncontrarArquivo('base/');
$arq_config = iFrameEncontrarArquivo('includes/config.inc');
$arq_banco  = iFrameEncontrarArquivo('classes/banco.inc');
define('PASTA_BASE',$pasta_base);
include($arq_config);
include($arq_banco);

function criarOpcoes($res,$valorInicial,$colunaChave,$colunaDados,$campoOutroValorInicial=null,&$disp){
	$html='';
	$disp='none';
	foreach($res[$colunaChave] as $k=>$valor) {
		if ($res[$colunaChave][$k]==$valorInicial ) {
			$selected=' selected';
			if($campoOutroValorInicial and $res[$colunaDados][$k] == $campoOutroValorInicial)
				$disp='';
		}
		else
		 	$selected='';
		$html.= '   <option'.$selected.' value="'.$valor.'">'.$res[$colunaDados][$k].'</option>'."\n";
	}
	return $html;
}
$CampoFiltro  = $_GET['campoFiltro'];    // 'COD_UF'
$valorFiltro  = $_GET['valorFiltro'];    // 'GO'
$valorInicial = $_GET['valorInicial'];   // goiania
$campoFormDin = $_GET['campoFormDin'];   // cod_municipio
$soLeitura	  = $_GET['soLeitura'];
$nomePacoteParametro 	=$_GET['nomePacoteParametro'];
$campoOutroTamanho		=$_GET['campoOutroTamanho'];
$campoOutroRotulo		=$_GET['campoOutroRotulo'];
$campoOutroValorMostrar	=$_GET['campoOutroValorMostrar'];
$campoOutroValorInicial	=$_GET['campoOutroValorInicial'];
$campoOutroCampoAtualizar=$_GET['campoOutroCampoAtualizar']; // nome do campo hidden do formulario que será gravado no banco de dados o valor do campo outro
$executarFuncao 		=$_GET['executarFuncao'];
if( !$valorFiltro ) {
	print $msgSelecione;
	return;
}

// verificar se o usuário está logado
$_POST['login_cpf']   =  $_SESSION['usuario']['login_cpf'];
$_POST['login_senha'] =  $_SESSION['usuario']['login_senha'];
if(!isset($_POST['login_cpf'])) {
	//print 'falta definir:Para que o campo iframe funcione é necessário existir na sessao as seguintes variáveis: '."\n";
	print 'Não achei: '."\n";
	print '$_SESSION[\'usuario\'][\'login_cpf\'] e '."\n";
	print '$_SESSION[\'usuario\'][\'login_senha\']'."\n";
	return;
}
$clientedb = new banco();
// definir as opções do select para o campo municipio
$bvars = array( $nomePacoteParametro => $valorFiltro );
if( $clientedb ){
	//	$mens = $clientedb->executar_recuperar_pkg_funcao($nomePacote,$bvars,$res);
	$erro = $clientedb->executar_pacote_func_proc($nomePacote,$bvars);
	$res=$bvars['CURSOR'];
	if( !is_array($res) or ( $res[key($res)])===0 )
	   $res=null;
} else {
	print 'Não consegui conexão com banco de dados!';
	return;
}
if( !$res ) {
	print $msgNenhum;
} else {
	// se não foi informado as colunas do pacote que irão alimentar o select, assumir as duas primeiras colunas do pacote
	if(!$colunaChave or !$colunaDados) {
		// encontrar as colunas
		foreach ($res as $p=>$s){
				$cols[]=$p;
			}
		// o pacote deverá devolver sempre 2 colunas. Uma com a chave e a outra com a descricao
		$colunaChave= !$colunaChave ? $cols[0] : $colunaChave;
		$colunaDados= !$colunaDados ? $cols[1] : $colunaDados;
		// se o pacote tiver somente uma coluna, assumir a coluna chave como segunda coluna
		$colunaDados= !$colunaDados ? $colunachave : $colunaDados;
	}
	if( $valorFiltro ) {
		if($soLeitura)
		  $desabilitado = 'disabled';
//		if( $campoOutroTamanho>0 )  {
//			$evt = 'mostrarEsconderCampoOutrothis(this.options[this.selectedIndex].text,\''.$campoOutroValorMostrar.'\');';

		print '<select tabindex="0" name="cmbIfrm" '.$desabilitado.' id="cmbIfrm" class="formDinCampoMulti" onchange="mudou(\''.$campoFormDin.'\',this,\''.$campoOutroValorMostrar.'\',\''.$campoOutroCampoAtualizar.'\',\''.$executarFuncao.'\');">';
		print '<option value="">-- selecione --</option>'."\n";

		print criarOpcoes($res,$valorInicial,$colunaChave,$colunaDados,$campoOutroValorMostrar,$disp);
		print '</select>';
		if( $campoOutroTamanho>0 )  {
			print "\n".'<span id="campooutro" style="display:'.$disp.'">';
			print '&nbsp;';
			if ( $campoOutroRotulo)
				print '<span class="rotulo">'.$campoOutroRotulo.'</span>'."\n";
			print '<input tabindex="0" type="text" name="'.$campoFormDin.'_outro" id="'.$campoFormDin.'_outro" size="'.$campoOutroTamanho.'" maxlength="'.$campoOutroTamanho.'" value="'.$campoOutroValorInicial.'" onBlur="atualizarCampoOutro(this,\''.$campoOutroCampoAtualizar.'\');" '."\n";
			print '</span>'."\n";
		}
	} else
		print $msgNenhum;
}

function iFrameEncontrarArquivo($arquivo) {
    for( $i=0;$i<10;$i++) {
        $path = str_repeat('../',$i);
        if( file_exists($path.$arquivo ) ) {
            return $path.$arquivo;
            break;
            }
        }
   return null;
}

?>
</body>
</html>

