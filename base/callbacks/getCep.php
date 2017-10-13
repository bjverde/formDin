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
 * Este programa é distribuí1do na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licen?a Pública Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

/*
Módulo utilizado para preenchimento dos campos de endereço utilizando consulta do cep, via
ajax, ao serviço www.bucacep.com.br
Data:22-03-2010
atulizado em : 13-10-2017
Teste: cep=74265010
*/
error_reporting(0);
/*
//Utilizando o serviço: http://viavirtual.com.br/webservicecep.php
$consulta = 'http://viavirtual.com.br/webservicecep.php?cep='.$_GET['cep'];
$consulta = file($consulta);
$consulta = explode('||',$consulta[0]);
$rua		=$consulta[0];
$bairro		=$consulta[1];
$cidade		=$consulta[2];
$uf			=$consulta[4];
//print_r($consulta);
print '{"rua":"'.$rua.'","bairro":"'.$bairro.'","cidade":"'.$cidade.'","uf":"'.$uf.'"}';
// java script para tratar o retorno
function getCep()
{
	var cep = jQuery('#num_cep').val();
	cep = cep.replace(/[^0-9]/g,'')
	if( cep )
	{
		fwSetEstilo('{"id":"num_cep","backgroundImage":"url(\''+pastaBase+'imagens/carregando.gif\')","backgroundRepeat":"no-repeat","backgroundPosition":"center right"}');
		jQuery.get(app_url+"base/callbacks/getCep.php", {"cep":cep},
		function(data)
		{
			if( data )
			{
				fwSetEstilo('{"id":"num_cep","backgroundImage":"","backgroundRepeat":"no-repeat","backgroundPosition":"center right"}');
				eval("var dados = "+data);
   				jQuery('#des_endereco').val(dados.rua);
   				jQuery('#nom_cidade').val(dados.cidade);
   				jQuery('#nom_bairro').val(dados.bairro);
   				jQuery('#sig_uf').val(dados.uf);
			}
 		});
	}
}
*/
function limpaCep($param) {
    $cep = preg_replace('/[^0-9]/','',$param);
    return $cep;
}

// chamada ajax
if(isset($_REQUEST['cep']))
{

    $cep = limpaCep($_REQUEST['cep']);
	header ("content-type: text/xml; charset=ISO-8859-1");
	if( function_exists('curl_init'))
	{

	    // utilizando curl()
		$options = array(
			CURLOPT_RETURNTRANSFER => true, // return web page
			CURLOPT_HEADER => false, // don’t return headers
			CURLOPT_FOLLOWLOCATION => true, // follow redirects
			CURLOPT_ENCODING => '', // handle all encodings
			CURLOPT_USERAGENT => 'formdin', // who am i
			CURLOPT_AUTOREFERER => true, // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
			CURLOPT_TIMEOUT => 120, // timeout on response
			CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
		);
		//$ch = curl_init('http://www.buscarcep.com.br/?cep='.$cep.'&formato=xml&chave=1vVU3UcKFHfVhFxBSlWWM4kqUREbBu/');
		$ch = curl_init('http://buscarcep.com.br/?cep='.$cep.'&formato=xml&chave=Chave_Gratuita_BuscarCep&identificador=CLIENTE1');
		
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		if( !$errmsg = curl_error( $ch ) )
		{
			echo utf8_decode($content);
		}
		else
		{
			echo '<?xml version="1.0" encoding="utf-8" ?><webservicecep><quantidade>1</quantidade><retorno><resultado>-7</resultado><resultado_txt>'.$errmsg.'</resultado_txt><codigo_ibge></codigo_ibge></retorno></webservicecep>';
		}
		curl_close( $ch );
		return;
		//$err = curl_errno( $ch );
		//$errmsg = curl_error( $ch );
		//$header = curl_getinfo( $ch );
	}
	else
	{
		/**
		* utilizando file_get_contents()
		* não vai funcionar se a opção URL file-access estiver desabilitada no servidor.
		*/
	    $cep = limpaCep($_REQUEST['cep']);
		header ("content-type: text/xml; charset=UTF-8");
		header("Content-Type:text/xml");
		//echo file_get_contents('http://www.buscarcep.com.br/?chave=1N4geWh.fwv1HeoCFNpBMsG1Cn1Gxf0&cep='.$cep.'&formato=xml');
		//echo file_get_contents('https://buscarcep.com.br/?cep='.$cep.'&formato=xml&chave=Chave_Gratuita_BuscarCep&identificador=CLIENTE1');
		//$res = file_get_contents('http://www.buscarcep.com.br/?cep='.$cep.'&formato=xml&chave=1vVU3UcKFHfVhFxBSlWWM4kqUREbBu/');
		$res = file_get_contents('http://buscarcep.com.br/?cep='.$cep.'&formato=xml&chave=Chave_Gratuita_BuscarCep&identificador=CLIENTE1');
		echo utf8_decode($res);
	}




	/*
	// exemplo do retorno fixo para testar a chamada
	echo utf8_encode('<?xml version="1.0" encoding="utf-8" ?>
		<webservicecep>
			<quantidade>1</quantidade>
			<retorno>]
				<cep>71505030</cep>
				<uf>DF</uf>
				<cidade>Lago Norte</cidade>
				<bairro>Setor de Habitações Individuais Norte</bairro>
				<tipo_logradouro>Conjunto</tipo_logradouro>
				<logradouro>SHIN QI 1  3</logradouro>
				<data>2010-06-12 00:18:12</data>
				<resultado>1</resultado>
				<resultado_txt>sucesso. cep encontrado local</resultado_txt>
				<limite_buscas>10</limite_buscas>
			</retorno>
		</webservicecep>');
	*/
	//$_SERVER['SERVER_ADDR']
	//echo file_get_contents('http://www.buscarcep.com.br/?chave=1N4geWh.fwv1HeoCFNpBMsG1Cn1Gxf0&cep='.$cep.'&formato=xml');
	return;
}
?>