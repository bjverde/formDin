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
função para depuração. Exibe o modulo a linha e a variável/objeto solicitado
*/
function d( $mixExpression,$strComentario='Debug', $boolExit=FALSE )
{
	if (defined('DEBUGAR') && !DEBUGAR){
	    return;
	}
	$arrBacktrace = debug_backtrace();
	if( isset($_REQUEST['ajax']) && $_REQUEST['ajax'] )
	{   echo '<pre>';
		foreach ( $arrBacktrace[0] as $strAttribute => $mixValue )
		{
			echo $strAttribute .'='. $mixValue ."\n";
		}
		echo "---------------\n";
   		print_r( $mixExpression );
   		echo '</pre>';

	}
	else
	{
		echo "<script>try{fwUnblockUI();}catch(e){try{top.app_unblockUI();}catch(e){}}</script>";
		echo "<fieldset style='text-align:left;'><legend><font color=\"#007000\">".$strComentario."</font></legend><pre>" ;
		foreach ( $arrBacktrace[0] as $strAttribute => $mixValue )
		{
			if( is_string( $mixValue ) )
			{
				echo "<b>" . $strAttribute . "</b> ". $mixValue ."\n";
			}
		}
		echo "</pre><hr />";
		echo '<span style="color:red;"><blink>'.$strComentario.'</blink></span>'."\n";;
		echo '<pre>';
		if( is_object($mixExpression) )
		{
    		var_dump( $mixExpression );
		}
		else
		{
		  print_r($mixExpression);
		}
		echo "</pre></fieldset>";
		if ( $boolExit )
		{
			echo "<br /><font color=\"#700000\" size=\"4\"><b>D I E</b></font>";
			exit();
		}
	}
}

/*
Cria o script para exibir alert em javascript
*/
function criarMensagemJS($mensagem){
	$JS = "<script> ";
	$JS .= " alert('".$mensagem."');";
	return $JS .= " </script> ";
}
/*
Cria o codigo js para atualizar os campos do formulario que tiverem os mesmos nomes do $res
*/
function criarAtualizacaoJS($res){
	$JS = "<script> ";

	foreach ($res as $i => $v){

		$res[$i][0] = str_replace(chr(13),'\n',$res[$i][0]);
		$res[$i][0] = str_replace(chr(10),'',$res[$i][0]);

		$JS .= " if (getObj('".strtolower($i)."')){ document.getElementById('".strtolower($i)."').value = '".$res[$i][0]."'; } ";
	}
	return $JS .= " </script> ";
}

function cortaNome($nome,$tamanho=20)
{
	$parte1 = substr($nome,0,$tamanho);
	$parte2 = trim(substr($nome,$tamanho,1));
	$retorno='';
	if((string)$parte2=='')
	{
	  $retorno=$parte1;
	}
	else
	{
		$parte1 = substr($parte1,0, strrpos($parte1,' '));
		$retorno=$parte1;
	}
	$aRetorno = explode(' ',$retorno);
	if( count($aRetorno)>0)
	{
		$ultimoNome = $aRetorno[count($aRetorno)-1];
		if(strtoupper($ultimoNome)=='DE' || strtoupper($ultimoNome)=='DA' || strtoupper($ultimoNome)=='DO')
		{
			$aRetorno[count($aRetorno)-1]='';
		}
	}
	$retorno='';
	foreach ($aRetorno as $k=>$v) {
		$retorno .= $retorno==''?'':' ';
		$retorno .=$v;
	}
return $retorno;
}

function str2float($str)
{
	if( preg_match('/\,/',$str) == 1 )
	{
		$posVirgula = strpos($str,',');
		$posPonto = strpos($str,'.');
		if( $posPonto == 0 && $posVirgula > 0  )
		{
			$str = str_replace(',','.',$str);
		}
		else if( $posVirgula > $posPonto )
		{
			// converte 1.000.000,05 em 1000000.05 para poder ser utilizado em operações matematicas
   			$str = str_replace('.','',$str);
   			$str = str_replace(',','.',$str);
		}
		else if( $posVirgula < $posPonto )
		{
   			$str = str_replace(',','',$str);
		}
	}
	return (float) $str;
}

function lindig2codigobarra($ld) {
	/*
	Transforma o conteúdo de uma linha digitável de boleto de cobrança
	em código para código de barras.
	Autor: Andries Jan Algera
	Data: 13 de março de 2007
	*/
	$cb = substr($ld, 0, 4).substr($ld, 40, 14).
			substr($ld, 4, 1).substr($ld, 6, 4).substr($ld, 12, 5).
			substr($ld, 18, 5).substr($ld, 25, 5).
			substr($ld, 31, 5);
	if ( substr($ld, 38, 1) <> dv_banco_11_cb($cb) )
	  return 'Erro no dígito verificador';
	else
	  return substr($cb,0,4).substr($ld, 38, 1).substr($cb,4);
}

function xml2Array($xml)
{
	/*
	Rafael Roque
	Transforma um estrutura xml em um array php
	Data: 23/01/2006
	*/
	$criador = xml_parser_create();
	xml_parse_into_struct($criador,$xml , $vals, $index);
	foreach ($vals as $i => $v)
	{
		if($v["type"]=='open')
		{
		$nome_array = $nome_array .'['.$v["tag"].']';
		}
		elseif($v["type"]=='close')
		{
		$nome_array = str_replace('['.$v["tag"].']','',$nome_array);
		}
		else
		{
			$nome_final = 'vetor'.$nome_array .'['. $v["tag"].'][]';
			eval('$'.$nome_final.' = $v["value"];');
		}
	}
	return $vetor;
}
// converte cores de 255,10,50 para o formato #5447845
function rgb2html($r, $g=-1, $b=-1)
{
	if (is_array($r) && sizeof($r) == 3)
		list($r, $g, $b) = $r;

	$r = intval($r); $g = intval($g);
	$b = intval($b);

	$r = dechex($r<0?0:($r>255?255:$r));
	$g = dechex($g<0?0:($g>255?255:$g));
	$b = dechex($b<0?0:($b>255?255:$b));

	$color = (strlen($r) < 2?'0':'').$r;
	$color .= (strlen($g) < 2?'0':'').$g;
	$color .= (strlen($b) < 2?'0':'').$b;
	return '#'.$color;
}
//------------------------------------------------------------------------------------
// converte cores de #5447845 para o formato 255,10,50
function html2rgb($color)
{
	$color= strtolower($color);
	if($color=='black')
		return array(0,0,0);

	if ($color[0] == '#')
		$color = substr($color, 1);

	if (strlen($color) == 6)
		list($r, $g, $b) = array($color[0].$color[1],
								 $color[2].$color[3],
								 $color[4].$color[5]);
	elseif (strlen($color) == 3)
		list($r, $g, $b) = array($color[0], $color[1], $color[2]);
	else
		return false;

	$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

	return array($r, $g, $b);
}
//--------------------------------------------------------------------------------------
function getDiaSemana(){
	$diaSemana = array('Domingo','Segunda-Feira','Terça-Feira','Quarta-Feira','Quinta-Feira','Sexta-Feira','Sábado');
	return $diaSemana[date(w)];
}

function janela_erros($Erros,$TITULO="Erro(s) encontrado(s):"){
	  $erro='';
	  for ($i=0; $i<(count($Erros)); $i++) {
			$erro .= $erro == '' ? '' :'|';
			$erro .= $Erros[$i];
	  }
	  $arquivo = formDinEncontraArquivo(PASTA_BASE.'includes/exibirErros.php');
	  echo '<iframe name="iframeErros" id="iframeErros" scrolling="auto" frameborder="1" style="z-index:9000;border:3px solid white;border-style:outset;position:absolute; top:90px;left:30px;background-color:white;width:600px;height:500px;" src="'.$arquivo.'?erros='.$erro.'"></iframe>';
}
function mensagem($TEXTO){?>
	<SCRIPT>
		newWindow = window.open('', 'newWin', 'toolbar=no,location=no,scrollbars=0,resizable=no,width=400,height=250,top=100,left=180')
		newWindow.focus();
		newWindow.document.writeln('<font face="Arial Black">ATENÇÃO</font><hr>');
		newWindow.document.writeln('<font face="Arial" color=red size="2"><?=$TEXTO;?></font>');
		newWindow.document.writeln('<hr><center><input type="button" value="Fechar" onclick="window.close();"></center>')
	</SCRIPT>
<?php }
function formatar_cpf($cpf)
{
	$cpf=limpar_numero($cpf);
	if ( empty($cpf) )
		return '' ;
	return substr($cpf,0,3).".".substr($cpf,3,3).".".substr($cpf,6,3)."-".substr($cpf,9,2);
}
function formatar_cnpj($cnpj)
{
	$cnpj=limpar_numero($cnpj);
	if ( empty($cnpj) )
		return '';
	return substr($cnpj,0,2).".".substr($cnpj,2,3).".".substr($cnpj,5,3)."/".substr($cnpj,8,4)."-".substr($cnpj,12,2);
}
function formatar_cpf_cnpj($cpfcnpj)
{
	$cpfcnpj=limpar_numero($cpfcnpj);
	if ( strlen($cpfcnpj) == 11 )
		return substr($cpfcnpj,0,3).".".substr($cpfcnpj,3,3).".".substr($cpfcnpj,6,3)."-".substr($cpfcnpj,9,2);
	else if ( strlen($cpfcnpj) == 14 )
		return substr($cpfcnpj,0,2).".".substr($cpfcnpj,2,3).".".substr($cpfcnpj,5,3)."/".substr($cpfcnpj,8,4)."-".substr($cpfcnpj,12,2);
	else return '';
}
function make_seed() {
	list($usec, $sec) = explode(' ', microtime());
		return (float) $sec + ((float) $usec * 100000);
}
function senha() {
	mt_srand(make_seed());
	for($i=0;$i<8;$i++) {
		$n = (integer)mt_rand(0,35);
		$c = ($n<10) ? ($n+48) : ($n+55);
		$senha.= pack ("c",$c);
	}
	return $senha;
}
function registrar_sessao($num_sess,$cpfcnpj_sess,$tipo_sess) {
	if($tipo_sess == "F") {
		session_register("num_pessoa","num_cpf","tipo");
		$num_pessoa = $num_sess;
		$num_cpf = $cpfcnpj_sess;
		$tipo = $tipo_sess;
	}
	else if($tipo_sess == "J") {
		session_register("num_pessoa","num_cnpj","tipo");
		$num_pessoa = $num_sess;
		$num_cnpj = $cpfcnpj_sess;
		$tipo = $tipo_sess;
	}
}

function ulcase($variavel) {
	setlocale(LC_CTYPE,"iso_8859_1");
	$nom=explode(" ",$variavel);
	$nom[0]=ucfirst(strtolower($nom[0]));
	for ($j=1;$nom[$j];$j++) {
		$nom[$j]=strtolower($nom[$j]);
		$nom[$j]=ucfirst($nom[$j]);
		if ( ereg("^(Com|Sem|Para|Por|Dos|Das|Ou)$",$nom[$j],$temp ) ) {
			$nom[$j]=strtolower($nom[$j]);
		}
		if ( ereg("^[DN].$",$nom[$j],$temp ) ) {
			$nom[$j]=strtolower($nom[$j]);
		}
		if ( ereg("^[AEO]$",$nom[$j],$temp ) ) {
			$nom[$j]=strtolower($nom[$j]);
		}
	}
	$nom_int = implode($nom," ");
	if ( substr($nom_int,-3,1) == "/" )
		$nom_int = substr($nom_int,0,strlen($nom_int)-3)." - "
					.strtoupper(substr($nom_int,-2));
	return $nom_int;
}

	function tirar_acentos($variavel) {
		$busca= array("'Á'","'À'","'Ã'","'Ä'","'Â'","'É'","'È'","'Ê'","'Ë'",
					  "'Í'","'Ì'","'Ï'","'Î'","'Ñ'",
					  "'Ó'","'Ò'","'Ô'","'Õ'","'Ö'","'Ú'","'Ù'","'Ü'","'Û'",
					  "'Ý'","'Ç'",
					  "'á'","'à'","'ã'","'ä'","'â'","'é'","'è'","'ê'","'ë'",
					  "'í'","'ì'","'ï'","'î'","'ñ'",
					  "'ó'","'ò'","'ô'","'õ'","'ö'","'ú'","'ù'","'ü'","'û'",
					  "'ý'","'ç'");
		$subst= array("A","A","A","A","A","E","E","E","E","I","I","I","I","N",
					  "O","O","O","O","O","U","U","U","U","Y","C",
					  "a","a","a","a","a","e","e","e","e","i","i","i","i","n",
					  "o","o","o","o","o","u","u","u","u","y","c");
		$result = preg_replace($busca,$subst,$variavel);
		return $result;
	}

	function dv_cpf_cnpj_ok($cpfcnpj) {
		$dv = false;
		$cpfcnpj = ereg_replace("[^0-9]","",$cpfcnpj);
		if ( strlen($cpfcnpj) == 14 ) {
			$cnpj_dv = substr($cpfcnpj,-2);
			for ( $i = 0; $i < 2; $i++ ) {
				$soma = 0;
				for ( $j = 0; $j < 12; $j++ )
					$soma += substr($cpfcnpj,$j,1)*((11+$i-$j)%8+2);
				if ( $i == 1 ) $soma += $digito * 2;
				$digito = 11 - $soma  % 11;
				if ( $digito > 9 ) $digito = 0;
				$controle .= $digito;
			}
			if ( $controle == $cnpj_dv )
				$dv = true;
		}
		if ( strlen($cpfcnpj) == 11 ) {
			$cpf_dv = substr($cpfcnpj,-2);
			for ( $i = 0; $i < 2; $i++ ) {
				$soma = 0;
				for ( $j = 0; $j < 9; $j++ )
					$soma += substr($cpfcnpj,$j,1)*(10+$i-$j);
				if ( $i == 1 ) $soma += $digito * 2;
				$digito = ($soma * 10) % 11;
				if ( $digito == 10 ) $digito = 0;
				$controle .= $digito;
			}
			if ( $controle == $cpf_dv )
				$dv = true;
		}
		return $dv;
	}

	function formata_fone_fax($numero) {
		$numero = ereg_replace("[^0-9]","",$numero);
		$numero = ereg_replace("^0+","",$numero);
		if ( strlen($numero) == 14 or strlen($numero) == 12 )
			$numero = substr($numero,-10);
		if ( strlen($numero) == 13 or strlen($numero) == 11 )
			$numero = substr($numero,-9);

		$res = substr($numero,-4);
		if ( strlen($numero) > 4  and strlen($numero) < 9 )
			$res = substr($numero,0,strlen($numero)-4)."-".$res;
		if ( strlen($numero) > 8  )
			$res = "(0XX".substr($numero,0,2).") ".
						substr($numero,2,strlen($numero)-6)."-".$res;
		return $res;
	}

	function formata_cep($num) {
		$num = ereg_replace("[^0-9]","",$num);
		$res = substr($num,0,5);
		if ( strlen($num) > 5 ) $res.="-".substr($num,5,3);
		return $res;
	}

	function verifica_email ($email) {
		 return(preg_match("'^[a-z0-9_.=-]+@(?:[a-z0-9-]+\.)+([a-z]{2,3})\$'i",
				$email));
	}

	function verifica_cep ($cep) {
		$res=false;
		$cep = ereg_replace("[^0-9]","",$cep);
		if ( strlen($cep) == 8 ) $res=true;
		return $res;
	}

	function verifica_data($data) {
		$dv = false;

		$data = ereg_replace("[^0-9]","",$data);
		$tam = strlen($data);
		if ( $tam == 8 ) {
			$dia = substr($data,0,2);
			$mes = substr($data,2,2);
			$ano = substr($data,4,4);
			if ( $dia > 0 && $dia < 32 &&
				 $mes > 0 && $mes < 13 &&
				 $ano > 1900 && $ano < 2100 ) $dv=true;
		}
		return $dv;
	}

	function dv_banco_11_cb($numero) {
		$numero = ereg_replace("[^0-9]","",$numero);
		$len = strlen($numero);
		for ( $i = 0; $i<$len; $i++ )
			$soma+= (($len-$i-1)%8+2) * intval(substr($numero,$i,1));
		$dv = 11 - $soma%11;
		if ( $dv > 9 ) {
			$dv="1";
		}
		return $dv;
	}

	function dv_banco_11($numero,$x=false) {
		$numero = ereg_replace("[^0-9]","",$numero);
		$len = strlen($numero);
		for ( $i = 0; $i<$len; $i++ )
			$soma+= (9-($len-$i-1)%8) * intval(substr($numero,$i,1));
		$dv = $soma%11;
		if ( $dv == 10 ) {
			if ( $x ) $dv="X";
			else $dv="0";
		}
		return $dv;
	}

	function dv_banco_10($numero) {
		$numero = ereg_replace("[^0-9]","",$numero);
		$len = strlen($numero);
		for ( $i = 0; $i<$len; $i++ ) {
			$s = (2-($len-$i-1)%2) * intval(substr($numero,$i,1));
			if ( $s > 9 ) $s = intval(substr($s,0,1)) + intval(substr($s,1,1));
			$soma+=$s;
		}
		$dv = 10-$soma%10;
		if ( $dv == 10 ) $dv = 0;
		return $dv;
	}

	function exibir_erros($erros) {
		$num = count($erros);
		if(!$num) return 0;
		echo "Foram encontrado(s) o(s) seguinte(s) erro(s) no seu formulário:<br>\n";
		for($x=0;$x<$num;$x++) {
			echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;"."<font color=red><b>".$erros[$x]."</b></font>"."\n";
		}
		return 1;
	}

	function fator_vencimento($data) {
			$dat = explode("/",$data);
			return intval((mktime(0,0,0,$dat[1],$dat[0],$dat[2])-mktime(0,0,0,10,7,1997))/86400);
	}

	function limpar_numero($num) {
		return preg_replace('/[^0-9]/','',$num);
	}

	function md5_senha($senha) {
		return "{MD5}".base64_encode(pack("H*",md5($senha)));

	}

	function maiuscula($str) {
		$str = strtoupper($str);
		$str = str_replace(	 array('á','é','í','ó','ú','à','ã','â','õ','â','ê','ô','ç')
							,array('Á','É','Í','Ó','Ú','À','ã','Â','Õ','Â','Ê','Ô','Ç')
						,$str);
		return $str;

	}
	function minuscula($str) {
		$str = strtolower($str);
		$str = str_replace(	 array('Á','É','Í','Ó','Ú','À','Â','Ã','Õ','Â','Ê','Ô','Ç')
				   			,array('á','é','í','ó','ú','à','â','ã','õ','â','ê','ô','ç')
						,$str);
		return $str;

	}
	// esta função ordena o array no formato de rotorno da classe banco()
	// ex: odenarArrayBanco($res,'NOM_PESSOA'); // ordena pela coluna NOM_PESSOA
	function ordenarArrayBanco( $array, $coluna,$crescente=true, $tipoString=true ){
	if(!$array[$coluna]) {
		//print 'Impossivel ordenar o array. Coluna ['.$coluna.'] não existe!';
		return $array;
	}
	if(!is_array($array) )
		return $array;

	if( count($array[$coluna])==1)
		return $array;

	if($tipoString or $tipoString === null)
		$tipo = 'SORT_STRING';
	else
		$tipo = 'SORT_NUMERIC';

	if($crescente or $crescente === null)
		$ordem = 'SORT_ASC';
	else
		$ordem = 'SORT_DESC';
	// tratamento para colunas tipo DATA
	$aDataInvertida=null;
	if( substr($array[$coluna][0],2,1).substr($array[$coluna][0],5,1) == '//') {
		foreach ($array[$coluna] as $k=>$v){
			$aDataInvertida[$coluna][$k] = substr($v,6,4).'/'.substr($v,3,2).'/'.substr($v,0,2).' '.substr($v,11,8);
		}
		$expressao= 'array_multisort($aDataInvertida["'.$coluna.'"], '.$tipo.', '.$ordem;
		$coluna='';
	} else if( preg_match('/^\s*[+-]?(\d+|[1-9]\d?(\.\d{3,3})*)(,\d+)?\s*$/',$array[$coluna][0])) {
		$tipo = 'SORT_NUMERIC';
		foreach ($array[$coluna] as $k=>$v){
			$aNumeroPonto[$coluna][$k] = preg_replace('/,/','.',preg_replace('/\./','',$v));
		}
		$expressao= 'array_multisort($aNumeroPonto["'.$coluna.'"], '.$tipo.', '.$ordem;
		$coluna='';
	} else {
		$expressao= 'array_multisort($array["'.$coluna.'"], '.$tipo.', '.$ordem;
	}
	foreach ($array as $k=>$col){
		$array[$k][0] = $array[$k][0]; // para corrigir o bug de não alterar os dados da sessao
		if( $k != $coluna ){
			$expressao.=' ,$array["'.$k.'"]';
		}
	}
	reset( $array);
	$expressao.=');';
	eval($expressao);
	return $array;
	}

	//Função para gerar numero romano
	function converterRomano($num) {
		$conv = array(10 => array('X', 'C', 'M'),
		5 => array('V', 'L', 'D'),
		1 => array('I', 'X', 'C'));
		$roman = '';

		if ($num < 0 or $num > 3999) {
			return '';
		}

		$num = (int) $num;

		$digit = (int) ($num / 1000);
		$num -= $digit * 1000;
		while ($digit > 0) {
			$roman .= 'M';
			$digit--;
		}

		for ($i = 2; $i >= 0; $i--) {
			$power = pow(10, $i);
			$digit = (int) ($num / $power);
			$num -= $digit * $power;

			if (($digit == 9) || ($digit == 4)) {
				$roman .= $conv[1][$i] . $conv[$digit+1][$i];
			} else {
				if ($digit >= 5) {
					$roman .= $conv[5][$i];
					$digit -= 5;
				}

				while ($digit > 0) {
					$roman .= $conv[1][$i];
					$digit--;
				}
			}
		}
		return $roman;
	}

	function pesquisarRetornoBanco($resultadoBanco,$colunasValoresPesquisa,$colunasRetorno=null) {
		if ( is_array($colunasValoresPesquisa) )
			foreach($colunasValoresPesquisa as $k=>$v) {
				if ( is_array($resultadoBanco[$k]) )
					$chaves = array_keys($resultadoBanco[$k],$v);
				else
					return 'Campo '.$k.' não encontrado no resultado!';
				if ( is_array($chavesAnterior) ) {
					foreach ( $chaves as $kc=>$vc ) {
						if ( !in_array($vc,$chavesAnterior) ) {
							unset($chaves[$kc]);
						}
					}
				}
				$chavesAnterior = $chaves;
			}
		else
			return;
		if ( is_array($chaves) ) {
			if ( is_array($colunasRetorno) )
				foreach($colunasRetorno as $v)
					foreach($chaves as $vc)
						$ret[$v][$vc] = $resultadoBanco[$v][$vc];
			else
				foreach($resultadoBanco as $k=>$v)
					foreach($chaves as $vc)
						$ret[$k][$vc] = $resultadoBanco[$k][$vc];
			return $ret;
		} else
			return;
	}
	// utilizada no sispass
	function layer_select($var,$lista,$titulo="",$event_style="",$form="formulario",$tamanho) {
		global ${$var};
		if ( is_array($lista) ) {
			list($k,$v) = each($lista);
			// Detectamos se os dados so um array de resulatdo do Oracle
			// convertemos numa lista para selectbox.
			if ( is_array($v) and ($k=="CODIGO" || $k=="DESCRICAO" ) ) {
				foreach($v as $i=>$val) {
					$cod=$lista["CODIGO"][$i];
					$lst[$cod] = $lista["DESCRICAO"][$i];
				}
				$lista = $lst;
			}
			$nlinhas = count($lista);
			reset($lista);
		}
		if ($titulo) $title=$titulo;
		else list($k,$title)=each($lista);
		$maxlen=strlen($titulo)-1;
		if ( eregi("MSIE",$_SERVER["HTTP_USER_AGENT"]) and is_array($_SESSION["menu"]) ) {
			if ( is_array($lista) )
				foreach ( $lista as $k=>$v ) {
					if ( $maxlen<(strlen($v)-1) )
						$maxlen=strlen($v)-1;
					if ( $k == ${$var} )
						$title0=$v;
				}
			$events=explode(" ",$event_style);
			reset($events);
			while ( list($k,$v) = each($events) ) {
				if ( eregi("^onchange=.",$v) ) {
				unset($events[$k]);
				$v=eregi_replace("^onchange=['\"](javascript:)*","",$v);
				$onchange=ereg_replace("['\"]$","",$v);
			}
			if ( eregi("document",$v) and $k>0 ) {
				$onchanges[]=$v;
				unset($events[$k]);
			}
		}
		if ( is_array($onchanges) ) $onchange.=implode(" ",$onchanges);
		$event_style=implode(" ",$events);
?>
			<div id=<?=$var?>div style="position:absolute; visibility:hidden;z-index:1;text-align:left;"
				onmouseover='HideItem(getRefToDiv("<?=$var?>div"));
					ShowItem(document.<?=$form?>.<?=$var?>);'>
			<table cellspacing=0 cellpadding=0><tr><td class="DADOS">
				<input type=text name=<?=$var?>txt value='<?=($title0?$title0:$title)?>' class="IMAGEM" style="width:<?=$tamanho - 18?>px;text-indent:2px;" readonly>
			</td><td><img src='imagens/botao.png'></td></tr></table></div>
			<select name=<?=$var?>
				onchange='document.<?=$form?>.<?=$var?>txt.value=this.options[this.selectedIndex].text;<?=$onchange?>'
				<?=$event_style?>
				style="visibility:visible;width:<?=$tamanho?>px;">
<?php 		} else { ?>
			<select name=<?=$var?> <?=$event_style?> >
<?php 		}
		if ( $titulo )  { ?>
			<option value=""><?=$titulo."\n"?>
<?php		}
		if ( is_array($lista) ) reset($lista);
		while ( is_array($lista) and list($k,$v) = each($lista) ) { ?>
			<option value='<?=$k?>' <?=(${$var}==$k?"SELECTED":"")?>><?=$v."\n"?>
<?php		} ?>
		</select>
<?php	}
?>