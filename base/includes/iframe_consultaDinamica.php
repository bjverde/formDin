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

session_start();
define('NOME',0); // CAR,DAT,NUM,DEC,CPF,CGC
define('TIPO',1); // CAR,DAT,NUM,DEC,CPF,CGC
define('CARACTERES',2); // quantidadede caracteres que podem ser digitados
define('LARGURA',3); // largura do campo na tela
define('NOVA_LINHA',4); // se N o proximo campo será criado na frente
/* ULTIMA ALTERAÇÃO
	11/08/2004 	- possibilidade de passar a coluna para ordenar o gride
	17/08/2004 	- implementado o parametro $bvars
				- implementada a possibilidade de passar um array no valor do campo filtro para criar um campo select
					ex 1. array('NUM_CPF'=>'C.P.F:','DES_NOME'=>'Nome:','COD_UF|UF'=>'GO|GOIAS||MG|MINAS GERAIS'), ou
					ex 2. array('NUM_CPF'=>'C.P.F:','DES_NOME'=>'Nome:','COD_UF|UF'=>array('GO'=>'Goias') ),
					ex 3. array('NUM_CPF'=>'C.P.F:','DES_NOME'=>'Nome:','COD_UF|UF'=>$res), ( estilo array oracle )
	20/08/2004	- colocada a opcao de submeter o parent form apos a seleção
	25/08/2004  - acertada a criacao dos campos filtro, campos select estavam acumulando as opcoes um do outro
	23/09/2004	- alterei o parametro submeterForm para executarFuncao. Este parametro recebe o nome de uma funcao javascript que será chamada quando o usuário fizer a seleçao do dado.
	08/07/2005  - colocado ordem de tabulacao nos campos
	21/07/2005 - implementada a possibilidade de configurar o tipo, qtd de caracteres, largura e quebra de linha nos campos de filtro.
	               ex , array('NUM_CPF|CPF'=>'CPF'
	                        , 'NOM_PESSOA|CAR|40|20'=>'Nome' // campo tipo caractere com 40 posicoes e 20 de comprimento
	                        , 'NUM_CNPJ|CNPJ|||N'=>'CNPJ'  // campo tipo cnpj e sem quebra a linha
	                        , 'NUM_CNPJ_CNPJ|CPFCNPJ'=>'CPF/CNPJ' // campo tipo cpfcnpj
	                        , 'DAT_NASCIMENTO|DAT|||N'=>'DATA' // campo tipo data sem quebra de linha
	                        , 'VAL_SALARIO|DEC'=>'SALÁRIO MÍNIMO' // campo tipo decimal
	                        , 'NUM_IDADE|INT|||N'=>'IDADE' // campo tipo inteiro
	                        )
	22/07/2005 - implementada a possibilidade de passar junto com o nome do pacote separado por | o nome do módulo de cadastro on-line caso a pesquisa não encontre nenhum registro
	27/01/2006	- adicionado o parametro $camposBvar para especificar campos do formulario que farão parte do filtro do pacote( bvars ) ao iniciar a pesquisa
	              ex. COD_UF|cod_uf,TIP_PESSOA|tipo_pessoa, o primeiro parametro é o nome do parametro do pacote e o segundo é o nome do campo do formulario.
	              se o campo do pacote tiver o mesmo nome do campo no formulario e o nome do campo no formulario estiver em caixa baixa, basta especificar o nome do parametro do pacote
*/

// cadastro on-line
if ( $_POST['modulo'] or $_POST['btnCadastrar']) {
	if($_POST['btnCadastrar'] ) {
		$_SESSION['consulta_dinamica']['post'] = $_POST;
	}
	$formDinAcao = $_POST['formDinBotao'].$_POST['formDinAcao'];
	if ($formDinAcao == 'Sair')
		$_POST = $_SESSION['consulta_dinamica']['post'];
	else {
		if( $arquivo = encontrarArquivoIframeConsultaDinamica('conexao.inc') )
    		include_once($arquivo);
	    else
	    {
		   imp('módulo conexao.inc não encontrado para incluir');
		}
		if( $arquivo = encontrarArquivoIframeConsultaDinamica('funcoes.inc') )
    		include_once($arquivo);
	    else
		   imp('módulo funcoes.inc não encontrado para incluir');

		// nome do módulo de cadastro on-line
		$a=explode('|',$_GET['nomePacote']);
		if( !$arquivo = encontrarArquivoIframeConsultaDinamica($a[1]) )
			if( !$arquivo = encontrarArquivoIframeConsultaDinamica($a[1].'.inc') )
				if( !$arquivo = encontrarArquivoIframeConsultaDinamica('modulos/'.$a[1]) )
					if( !$arquivo = encontrarArquivoIframeConsultaDinamica('modulos/'.$a[1].'.inc') )
						imp('arquivo '.$a[1].' não encontrado.');
		if($arquivo) {
   			imp('<table width=100% height=100% border=1><tr><td>');
    		include_once($arquivo);
			imp('</td></tr></table>');
		}
		return;
	}
}
$_SESSION['consulta_dinamica']['post'] = null;
?>
<html>
<head>
<!-- funções javasctipt -->
<script language="JavaScript">
//-----------------------------------------------------------------------
function btnGravarMultiClick(campo,executarFuncao)
{
	var i,id,o;
	var resultado ='';
	for(i=0;i<1000;i++)
	{
		try{
		o = document.getElementById('chk_'+i);
		if( o )
		{
			if( o.checked )
			{
				if(resultado!='')
				{
					resultado +=',';
				}
				resultado += o.value;
			}
		}
		} catch(e){}
	}
	try
	{
		//parent.document.getElementById('seq_pessoas').value = resultado;
	selecionar(campo,resultado,1,'',executarFuncao);
	} catch(e){}
}
//-------------------------------------------------------------
function selecionar(campo, valor, fecharJanela,campoFoco,executarFuncao )
{
	// criar array com os campos e valores
	aCampo = campo.split('|');
	aValor = valor.split('|');
	try {
	for(i=0;i<aCampo.length;i++){
		try {
		parent.document.getElementById(aCampo[i]).value=aValor[i];
		} catch(e){}
	}
	} catch(e){ alert(e.message) }
	if( campoFoco )
		try {
		parent.document.getElementById(campoFoco).focus();
		} catch(e){}

	if( fecharJanela==1  ) {
		fechar();
		}

	//poder ser passado o nome de uma função ou nome do formulario para submeter
	if( executarFuncao != null && executarFuncao != '')
	{
		try
		{
			if(executarFuncao.indexOf('(')>-1){
			  eval('parent.'+executarFuncao+';');
			}
			else
			{
		      		// limpar a ultima acao executada pelo formulario

		      		parent.document.getElementById('formDinAcao').value='';
				if(executarFuncao.toUpperCase() == 'FORMDIN')
				{
					// submeter o formulario
			      eval('parent.document.formdin.submit();');
				}
				else
				{
					// definir acao do formulario e submeter
			   	parent.document.getElementById('formDinAcao').value=executarFuncao;
	     	   	try {
	     	   		eval('parent.document.formdin.submit();');
	     	   	} catch(e) {
	     	   		alert("Erro na consulta dinâmica:\n"+e.message);
	     	   	}
				}
			}
		} catch(e) {};
	}
}
//-----------------------------------------------------------------------
function fechar(){
	// retirar o iframe de cima dos campos porque está escondendo o cursor do campo em edição
	parent.document.getElementById(this.name).style.visibility='hidden';
	parent.document.getElementById(this.name).style.top = -5000;

}
//-----------------------------------------------------------------------
function pesquisar(campos){
	if( campos ) {
	    var aCampo = campos.split(',');
	    for(i=0; i<aCampo.length; i++){
	    	var c = aCampo[i].split('|');
	    	c[1]=c[1] ? c[1] : c[0].toLowerCase();

	    	// verificar se o nome existe
	    	var obj;
	    	try { obj = parent.document.getElementById(c[1]); } catch(e){}
	    	if (!obj) {
	    		//verficar se é radio. O formulario dinamico coloca o sufixo _1 _2 _3 no id dos radiobox
	    		try { obj = parent.document.getElementById(c[1]+'_1'); } catch(e){}
	    	}
	    	valor= obj.value;
	    	if (obj.type=='radio')  {
	    		var len=parent.document.forms[0].elements[c[1]].length;
	    		for(j=0;j<len;j++) {
					obj = parent.document.getElementById(c[1]+'_'+(j+1))
					if (obj.checked) {
					   valor= obj.value;
					   break;
	    			}
	    		}
	    	}
	    	// gravar o valor no campo oculto do iframConsulta
	    	document.getElementById(c[1]).value = valor;
	    }
	}
	obj=document.getElementById('btnPesquisar');
	if(obj)
	{
		obj.disabled=true;
		obj.value = 'Aguarde';
	}
	obj=document.getElementById('td_dados');
	if(obj)
	{
		obj.innerHTML = '<blink>Consultando...</blink>';
	}
	obj=document.getElementById('acao');
	if(obj)
	{
		obj.value="Pesquisar";
	}
	document.consultaDinamica.submit();
}
//-----------------------------------------------------------------------
function centralizar() {
	var wTotal = parent.document.body.clientWidth;
	var hTotal = parent.document.body.clientHeight;
	var wIframe = parseInt( parent.document.getElementById(this.name).style.width);
	var hIframe = parseInt( parent.document.getElementById(this.name).style.height);
	var t,l;
	t = parseInt( ( hTotal - hIframe)/2);
	l = parseInt( ( wTotal - wIframe)/2);
	t= t + parent.document.body.scrollTop;
	l= l + parent.document.body.scrollLeft;
	parent.document.getElementById(this.name).style.top = t;
	parent.document.getElementById(this.name).style.left= l;
}
//-----------------------------------------------------------------------
function ordenarColuna(coluna){
	//alert( document.getElementById('colunaOrdenar') );
	document.getElementById('colunaOrdenar').value=coluna;
	pesquisar();
}
</script>
<!-- definição dos estilos -->
<style>
body {
	background-color:#F1F2F2;
	margin:0;
	padding:0;
}
.labelfiltro {
	font-family:Arial;
	font-size:12px;
	color:black;
}
.colunaLink {
	font-family:Arial;
	font-size:10px;
	border-bottom:1px solid silver;
	border-right:1px solid silver;
	color:blue;
	text-decoration:underline;
	cursor:pointer;
}
.colunaDados {
	font-family:Arial;
	font-size:10px;
	border-bottom:1px solid silver;
	border-right:1px solid silver;
	color:black;
}
.colunaTitulo {
	font-family:Arial;
	font-size:12px;
	border:1px solid silver;
	color:navy;
}
.botao {
	font-family:Arial;
	font-size:11px;
	border:1px solid white;
	border-style:outset;
	color:blue;
	cursor:pointer;
}
.titulo {
	font-family:Arial;
	font-size:14px;
	font-weight:bold;
	border:1px solid silver;
}
.tabela {
	font-family:Arial;
	border:1px solid silver;
}
.campo {
	font-size:12px;
	font-family:Arial;
	border:1px solid silver;
}
.tdBotao {
	text-align:center;
	font-family:Arial;
	border:0px solid silver;
	padding-top:3px;
	padding-bottom:3px;
}
</style>
</head>
<!--<body onload="centralizar();">-->
<body>
<form name="consultaDinamica" method="POST">
<input type="hidden" id="acao" name="acao" value="">
<input type="hidden" id="colunaOrdenar" name="colunaOrdenar" value="">
<table align="center" width="100%" height="96%" class="tabela" cellpadding="0" cellspacing="1">
<?php
// error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
if( $arquivo = encontrarArquivoIframeConsultaDinamica('conexao.inc') )
    include_once($arquivo);
 else
	imp('módulo '.$arquivo.' não encontrado para incluir');


$executarFuncao = str_replace('"',"'",$_GET['executarFuncao']); // não obrigatorio
// colocar o titulo da janela
$tituloJanela = $_GET['tituloJanela'];
$numMaximoRegistros = ((integer)$_GET['qtdMaxRegistros'])==0?200:$_GET['qtdMaxRegistros'];
if( $tituloJanela ) {
	imp('<tr>');
	imp('<th height="1%" colspan="3" class="tabela">'.$tituloJanela.'</th>');
	imp('</tr>');
}

//valorCampoIframe
//campoIframe

$campoFiltro = $_GET['campoFiltro'];
$qtdCampos=0;
$i=0;
$bvars=$_GET['bvars'];
$camposBvar = $_GET['camposBvar'];
$multiSelect = $_GET['multiSelect'];
//$multiSelect = true;
 // se foi passado os campos do formulario que farão parate do bvars, carregar
$camposAtualizar='';
if ( $camposBvar ) {
	$aCampos=explode(',',$camposBvar);
	imp('<!-- campos do formulario que serão incluídos no bvars do pacote-->');
	foreach($aCampos as $k=>$campo){
		$a=explode('|',$campo); //COD_UF|cod_uf
		$a[1]=$a[1]?$a[1]:strtolower($a[0]);
		$camposAtualizar.= $camposAtualizar ? ','. $a[1]: $a[1];
		imp('<input type="hidden" id="'.$a[1].'" name="'.$a[1].'" value="">');
		if ($_POST[$a[1]]){
			if (strtoupper($a[0])=='NUM_CPF' or strtoupper($a[0])=='NUM_CNPJ')
			    $_POST[$a[1]]= preg_replace("[^0-9]","",$_POST[$a[1]]);
			$bvars[$a[0] ]= $_POST[$a[1]];
		}
	}
}
// se tiver bvars e não tiver nenhum filtro, disparar consulta;
$dispararConsulta = false;
$tabIndex=1;
$campoFocoInicial='';
$fecharLinha='N';
if( $campoFiltro ) {
    imp('<tr><td><table border=0 cellpadding=1 cellspacing=0>');
	$camposFiltro='';
	foreach ($campoFiltro as $campo=>$rotulo )
	{
		$campoSelect = false;
		$label = $rotulo[0];
		if( strpos($rotulo[0],'|') >-1 )
		{
			$campoSelect = true;
			$label = explode('|',$campo);
			$campo = $label[0];
			if( !$_POST[$campo] && $_GET['campoIframe']==$campo && (string)$_GET['valorCampoIframe']<>'')
			{
				$_POST[$campo] = $_GET['valorCampoIframe'];
				$dispararConsulta=true;
			}
			$label = $label[1] ? $label[1] : $label[0];
			$a=explode('||',$rotulo[0]);
			$opcoes='';
			foreach ($a as $k=>$v){
				$b = explode('|',$v);
				$selecionar = $_POST[$campo] == $b[0] ?' selected':'';
				//print $campo.'->'.$_POST[$campo].'='.$b[0].' então '.$selecionar.'<br>';
				$opcoes.='<option value="'.$b[0].'"'.$selecionar.'>'.$b[1].'</option>'."\n";
				}
		}
		// o pacote recebe parametro em caixa alta
		$campo=strtoupper($campo);
		$aCampo = explode('|',$campo);
		if( !$_POST[$aCampo[NOME]] && $_GET['campoIframe']==$aCampo[NOME] && (string)$_GET['valorCampoIframe']<>'')
		{
			$_POST[$aCampo[NOME]] = $_GET['valorCampoIframe'];
			$dispararConsulta=true;
		}
		// guardar os campos filtrados para serem limpos apos a seleção se tiver somente 1 registro no retorno do banco
		$camposFiltro.= $camposFiltro ==''? '': ',';
		$camposFiltro.=$aCampo[NOME];
		$bvars[$aCampo[NOME]]=$aCampo[NOME]=='NUM_CPF' ? preg_replace('[^0-9]','',$_POST[$aCampo[NOME]]) : $_POST[$aCampo[NOME]];
        $aCampo[TIPO]        =  $aCampo[TIPO] == NULL ?'CAR':$aCampo[TIPO];
		if ($campoFocoInicial==''){
			$campoFocoInicial=$aCampo[NOME];
		}
	    imp('<!--	campo '.$aCampo[NOME].' filtro -->');
		if($fecharLinha) {
		  imp('<tr>');
		}
		imp('<td nowrap height="1%" class="labelfiltro">'.$label.':</td>');
      $fecharLinha         = $aCampo[NOVA_LINHA] === 'N' ? '': '</tr>';
		if(!$campoSelect) {
		   $eventos='';
		   if($aCampo[TIPO]=='DAT'){
                $aCampo[LARGURA] = 11;
                $aCampo[CARACTERES] = 10;
                $eventos='onKeyUp=\'colocarMascara(this,"##/##/####",event);\' onBlur=\'if(!DataOk(this,"dmy")) return false;\'';
		   } elseif($aCampo[TIPO]=='DEC'){
                $aCampo[LARGURA]     =  $aCampo[LARGURA] < 1 ?  15 :$aCampo[LARGURA];
                $aCampo[CARACTERES]  =  $aCampo[CARACTERES] < 1 ?  15 :$aCampo[CARACTERES];
                $eventos="dir=\"rtl\" onKeyUp='FormataDecimal(this,2);'";
		   } elseif($aCampo[TIPO]=='INT'){
                $aCampo[LARGURA]     =  $aCampo[LARGURA] < 1 ?  15 :$aCampo[LARGURA];
                $aCampo[CARACTERES]  =  $aCampo[CARACTERES] < 1 ?  15 :$aCampo[CARACTERES];
                $eventos="dir=\"rtl\" onKeyUp='FormataInteiro(this);'";
		   } elseif($aCampo[TIPO]=='CPF'){
                $aCampo[LARGURA]     =  14;
                $aCampo[CARACTERES]  =  14;
                $eventos="onKeyUp='FormataCpf(this);' onBlur='if( !DvCpfOk(this,event)) return false;'";
		   } elseif($aCampo[TIPO]=='CNPJ'){
                $aCampo[LARGURA]     = 18;
                $aCampo[CARACTERES]  = 18;
                $eventos="onKeyUp='FormataCnpj(this);' onBlur='if( !DvCnpjOk(this)) return false;'";
		   } elseif($aCampo[TIPO]=='CPFCNPJ'){
                $aCampo[LARGURA]     = 18;
                $aCampo[CARACTERES]  = 18;
                $eventos="onKeyUp='FormataCpfCnpj(this);' onBlur='if( !DvCpfCnpjOk(this)) return false;'";
		   }
       	   $aCampo[LARGURA]     =  $aCampo[LARGURA]    < 1 ? 60 :$aCampo[LARGURA];
	       $aCampo[CARACTERES]  =  $aCampo[CARACTERES] < 1 ? 60 :$aCampo[CARACTERES];
//	       $fecharLinha         = $aCampo[NOVA_LINHA] === 'N' ? '': '</tr>';
           imp('<td><input type="text" tabIndex="'.$tabIndex.'" name="'.$aCampo[NOME].'" id="'.$aCampo[NOME].'" size="'.$aCampo[LARGURA].'" maxlength="'.$aCampo[CARACTERES].'" value="'.$_POST[$aCampo[NOME]].'" class="campo" '.$eventos.'>&nbsp;</td>');
		} else {
			imp('<td><select name="'.$aCampo[NOME].'" tabIndex="'.$tabIndex.'" id="'.$aCampo[NOME].'" class="campo">');
			imp($opcoes);
			imp('</select></td>');
		}
		//if( $i++==0 ) {
		//	imp('<td width="1%" rowspan="'.$qtdCampos.'"><input type="button" tabindex="'.(count($campoFiltro)+1).'" id="btnPesquisar" name="btnPesquisar" value="Pesquisar" class="botao" onClick="pesquisar();"></td>');
		//}
		if ($fecharLinha<>'') {
		  imp($fecharLinha);
		  $qtdCampos++;
		} else
		$tabIndex++;
	}
	if ($fecharLinha=='')
	  imp('</tr>');
   imp('</td></tr></table>');
}
if($dispararConsulta)
{
	print '<script>pesquisar("'.$camposAtualizar.'");</script>';
	$dispararConsulta=false;
}

if( $_POST['acao']=='Pesquisar' or $formDinAcao == 'Sair') {
	$id = $_GET['id'];
	$selecionarFechar=$_GET['selecionarFehar']===null?'true':$_GET['selecionar_fechar'] ;
	$campoFocar=$_GET['campoFocar'];
	$a=explode('|',$_GET['nomePacote']);
	$nomePacote = $a[0];
	$modulo = $a[1];
	$res	= null;
	$mens 	= recuperarPacote($nomePacote,$bvars,$res);
}

// se tiver registros colocar o titulo do gride
$tituloGride = $_GET['tituloGride']===null?'Registros Encontrados':$_GET['tituloGride'];
imp('<tr>');
imp('<td colspan="3" class="tdBotao"><input type="button" tabindex="'.(count($campoFiltro)+1).'" id="btnPesquisar" name="btnPesquisar" value="Pesquisar" class="botao" onClick="pesquisar(\''.$camposAtualizar.'\');"></td>');
imp('</tr>');
if(is_array($res)) {
	imp('<tr>');
	imp('<th height="1%" colspan="3"  class="tabela">'.$tituloGride.'</th>');
	imp('</tr>');
}
imp('<tr>');

// calcular a area disponivel para montagem do gride
$alturaTela = $_GET['alturaTela'];
$areaUtilizada = ( ( $qtdCampos + 3 ) * 30);
$grideH = $alturaTela - $areaUtilizada;
imp('<td id="tdGride" colspan="3" height="*" align="center">');
imp('<div id="divGride" style="position:relative;vertical-align:middle;overflow:auto; margin:0px; padding:0px;height:'.$grideH.';width:auto;">');
imp('   <table width="100%">');

// quando o usuário volta da tela de cadastro on-line, a acao = Sair
if( $_POST['acao']=='Pesquisar' || $formDinAcao == 'Sair')
{
	if(!is_array($res)) {
		imp('<td colspan="'.$qtdColuna.'" style="text-align:center;vertical-align:middle;font-size:18;font-family:Arial;color:blue;height:150px">');
		imp('Nenhum registro encontrado!');
		if($modulo) {
			$btn = new Botao('btnCadastrar','Cadastrar',true,null,'Clique aqui para efetuar o cadastro','botao');
			imp('<br><br>'.$btn->getHtml());
		}
		imp('</td>');
	}
	$colunaOrdenar = $_POST['colunaOrdenar'] ? $_POST['colunaOrdenar']: $_GET['colunaOrdenar'];
	if( $colunaOrdenar )
		ordenarArrayOracle($res,$colunaOrdenar );

	if( $res ) {
		// se não foi informado os campos do formulario para serem atualizados, atualizar todos os campos que possuirem o mesmo nome que os campos do pacote
		$campoAtualizar = $_GET['campoAtualizar'];
		if( !$campoAtualizar ) {
			foreach ($res as $k=>$v)
				$campoAtualizar[$k]=strtolower($k);
		}
		reset($res);
		// criar os titulos das colunas do gride
		$colunas = $_GET['coluna'];

        //print_r($campoAtualizar);
		// se não foi informado as colunas do gride, listar todas as colunas retornadas
		if( !$colunas ) {
			foreach ($res as $k=>$v)
				$colunas[$k]=$k;
		}
		reset($res);

		$qtdColuna=  count($colunas);
		$i=0;
		imp('   <tr>');
		foreach ($colunas as $campo=>$titulo){
			$titulo = $colunaOrdenar===$campo ? "^&nbsp;".$titulo:$titulo;
			imp('      <th class="colunaTitulo"><a class="colunaLink" onClick="ordenarColuna(\''.$campo.'\');">'.$titulo.'</a></th>');
		}
		imp('   </tr>');

		$chave=key($res);
		foreach ($res[$chave] as $k=>$v ) {
			if($k >= $numMaximoRegistros){
				$mens[]='A consulta retornou mais de '.$numMaximoRegistros.' registros. Seja mais específico!';
				break;
			}
			$i= 0;
			// linhas do gride
			reset($colunas);
			$comando='';
			imp('   <tr>');
			foreach ($colunas as $campo=>$titulo )
            {
				if($i==0)
				{
					$condicao=true;
					if((string)$_GET['condicaoLink']<>'')
					{
					   eval('$condicao='.$_GET['condicaoLink'].';');
					}
				}
                // se for a coluna 1 fazer o link
				if( $i==0 && !$multiSelect)
                {
					$listaCampos='';
					$listaValores='';
					reset($campoAtualizar);
                    $contador=0;
					foreach ( $campoAtualizar as $nomeBanco=>$nomeTela ){
                        if($contador>0)
                        {
                            $listaValores.='|';
                            $listaCampos .='|';
                        }
                        $contador++;
                        $listaCampos .= $nomeTela;
						if( $res[$nomeBanco] )
                        {
							$listaValores.= trim($res[$nomeBanco][$k]);
                        }
					}
                    $listaValores = str_replace("'","`",$listaValores);
					$listaValores = str_replace('"','“',$listaValores);
					$listaValores = str_replace(chr(10),'\n',$listaValores);
					$listaValores = str_replace(chr(13),'',$listaValores);
					if($condicao)
					{
						if($comando==''){
						   $comando = 'selecionar(\''.$listaCampos.'\',\''.$listaValores.'\','.$selecionarFechar.',\''.$campoFocar.'\',\''.$executarFuncao.'\');';
						}
					    imp('      <td nowrap class="colunaLink" onClick="selecionar(\''.$listaCampos.'\',\''.$listaValores.'\','.$selecionarFechar.',\''.$campoFocar.'\',\''.$executarFuncao.'\');">'.$res[$campo][$k].'</td>');
					}
					else
                        imp('      <td nowrap class="colunaDados">'.$res[$campo][$k].'</td>');
				}
                 else
                {
					$texto = empty( $res[$campo][$k] ) ?'<center>---</center>':$res[$campo][$k];
					if($multiSelect && $i==0)
					{
						imp('      <td class="colunaDados"><input type="checkbox"'. (($condicao==true) ? '' : 'disabled') .' id="chk_'.$k.'" value="'.$res[key($campoAtualizar)][$k].'">'.$texto.'</td>');
					}
					else
						imp('      <td class="colunaDados">'.$texto.'</td>');
					}
				$i++;
			}
			imp('   </tr>');
		}
	}
   if( $res && count($res[key($res)])==1 && $comando<>'')
   {
	//print $comando;
	print '<script>limparFormulario(null,"consultaDinamica");'.$comando.'</script>';
	//print '<script>'.$comando.'</script>';
   }
} else {
	imp('<td id="td_dados" colspan="'.$qtdColuna.'" style="text-align:center;vertical-align:middle;font-size:18;font-family:Arial;color:blue;height:150px">');
	imp('Informe parâmetros e clique no botão PESQUISAR!!');
	imp('</td>');
}
imp('   </table>');
imp('</div>');
imp('</td>');
imp('</tr>');
if($mens){
	imp('<tr><td colspan="3" style="text-align:center;font-size:17;font-family:Arial;color:red;background-color:white;border:1px solid silver;">');
	imp($mens[0]);
	imp('</td></tr>');
}
imp('<tr>');
if(!$multiSelect)
{
	imp('   <td align="center" height="1%" colspan="3" class="tabela" ><input type="button" value="Fechar" name="sair" onclick="fechar(\''.$id.'\');" class="botao"></td>');
}
else
{
	@imp('   <td align="center" height="1%" colspan="3" class="tabela" >
	<input type="button" value="Gravar" name="btnGravar" onclick="btnGravarMultiClick(\''.$campoAtualizar[key($campoAtualizar)].'\',\''.$executarFuncao.'\');" class="botao">&nbsp;&nbsp;
	<input type="button" value="Fechar" name="sair" onclick="fechar(\''.$id.'\');" class="botao">
	</td>');
}
imp('</tr>');

// função criada somente para imprimir com "\n"
function imp( $valor ){
	print $valor."\n";
}

// colocar o foco no primeiro campo se existir
if ($campoFocoInicial)
	print'<script> try{ document.consultaDinamica.'.$campoFocoInicial.'.focus();} catch(e){};</script>';

function encontrarArquivoIframeConsultaDinamica($arquivo) {
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
</table>
</body>
</form>
</html>

