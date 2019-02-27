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


/*
Biblioteca de Funções JavaScript utilizadas pela classe FormDin4
Versão:1.0
Ultima Atualizacao:31/05/2009    Por:Luís Eugênio Barbosa
*/


if (!app_url){
	try
	{
		// configuração do ambiente javascript
		var app_formdin;
		var isNS4 = (navigator.appName=="Netscape")?1:0;
		var isIE  = (navigator.appName=="Netscape")?0:1;
		var pathArray 		= window.location.pathname.split( '/' );
		var app_url 		= window.location.pathname.substring(0,window.location.pathname.lastIndexOf('/'));
		var app_index_file 	= window.location.pathname.substring(window.location.pathname.lastIndexOf('/')+1);
		var pastaBase;
		app_index_file 		= app_index_file || "index.php";
		app_url = window.location.protocol+'//'+window.location.host+app_url+'/';
		var app_url_root = app_url;
		if( app_url_root.indexOf('/base/') > -1 )
		{
			app_url_root = app_url.substring(0,app_url_root.indexOf('/base/'))+'/';
		}
		//var tinyMCE;
		var globalLoaded_css_js  		= '';
		var fw_img_processando1 = '<img width="16px" height="16px" src="'+app_url_root+'/base/imagens/carregando.gif"/>';
		var fw_img_processando2 = '<img width="190px" height="20px" src="'+app_url_root+'/base/imagens/processando.gif"/>';
	}
	catch (e)
	{
		alert('Não foi possível inicializar a aplicação neste browser');
	}

	// variáveis globais
	/*
	var isNS4 = (navigator.appName=="Netscape")?1:0;
	var isIE  = (navigator.appName=="Netscape")?0:1;
	var globalCorBordaCampo 	= '#8C8C8C';
	var globalCorBordaCampoErro = '#ff0000';
	*/
	var GB_ROOT_DIR;
	try
	{
		if( top.GB_ROOT_DIR )
		{
			var GB_ROOT_DIR = top.GB_ROOT_DIR;
		}
		else
		{
			var GB_ROOT_DIR = 'base/js/greybox/';
		}
	}
	catch(e)
	{
		var GB_ROOT_DIR = 'base/js/greybox/';
	}
	var GB_CURRENT=false;

	// verificar se o formulário está sendo chamado pela TApplication.class.php
	try
	{
		if( typeof top.app_init == 'function')
		{
			app_formdin = true;
		}
		else
		{
			app_formdin = false;
		}
	}
	catch(e)
	{
		app_formdin = false;
	}
}
var globalCorBordaCampo 		= '#c0c0c0';
var globalCorBordaCampoErro 	= '#ff0000';
var win;
var modalWindowList = [];
var blockUIOnAction=true;
var uiBlocked=false;
var ajaxRequestCount=0;
var semaphore = [];

// controle de janelas dialog do jquery UI
var isChildDialog=false;
if( typeof top.arrDialogs == 'undefined')
{
	var arrDialogs=[];
}
else
{
	isChildDialog=true;
}
//-------------------------------------------------------------------------------------
function fwTeste(a,b,c)
{
	alert('fwTeste - Função Genérica de Teste');
	if( a )
	{
		alert(a)
	}
	if( b )
	{
		alert(b)
	}
	if( c )
	{
		alert(c)
	}
	return true;
}

//-------------------------------------------------------
// posicionar o foco no campo data apos fazer a selecao da data no pop-up
function fwCalendarioUpdate(cal)
{
	cal.params.inputField.focus();
}
//-------------------------------------------------------
function fwChkMinMax(vMin, vMax, pCampo, casasDecimais,allowZero, allowNull)
{
	allowZero = allowZero||false;
	allowNull = allowNull||false;
	var tipoCampo='D';
	if(casasDecimais==0)
	{
		tipoCampo='I'; // inteiro ou decimal
	}
	var obj=fwGetObj(pCampo);
	var v=obj.value;
	if(  v == ''  )
	{
	if(  allowNull )
	{
		return true;
	}
	fwSetBordaCampo(pCampo,true,true)
	alert('Campo deve ser preenchido!')
		return false;
	}
	if( !v && obj.getAttribute('needed') != 'true' )
	{
		return true;
	}
	// tirar os pontos
	v = v.replace(/\./g,'').replace(/,/,'.');
	if( tipoCampo=='D' )
	{
		v=parseFloat(v);
		vMin =parseFloat(vMin);
		vMax =parseFloat(vMax);
	}
	else
	{
		v=parseInt(v,10);
		vMin =parseInt(vMin,10);
		vMax =parseInt(vMax,10);
	}
	if( isNaN(v) )
	{
		v=0;
	}
	if( v==0 && allowZero  )
	{
		return true;
	}
	if( !isNaN(vMin) || !isNaN(vMax) )
	{
		if( ( !isNaN(vMin) && v < vMin) || ( !isNaN(vMax) && v > vMax))
		{
			var msg='';
			if( !isNaN(vMin))
			{
				msg= 'Valor dever ser MAIOR ou IGUAL a '+vMin.formatMoney(casasDecimais);
			}
			if( !isNaN(vMax))
			{
				if ( msg !='')
				{
					msg +=' e MENOR ou IGUAL '+vMax.formatMoney(casasDecimais)
				}
				else
				{
					msg='Valor dever ser MENOR ou IGUAL a '+vMax.formatMoney(casasDecimais);
				}
			}
			if(msg!='')
			{
				if( allowZero )
				{
					msg += ' ou zero';
				}
				if( allowNull )
				{
					msg += ' ou em branco';
				}
				msg +='.';
				fwSetBordaCampo(pCampo,true,true); // coloca a cor vermelha
				alert(msg);
			}
		}
	}
}
//--------------------------------------------------------------------------------
function fwFiltraCampo(codigo,campo,evento) {
	var c = codigo.replace(/[^0-9]/g,'')
	if( campo )
	{
		if( evento )
		{
			if (isNS4) {
				tecla=evento.which;
			} else {
				tecla=evento.keyCode;
			}
			if( tecla==8 || tecla==13 || tecla==9 || tecla==32 || tecla==33 || tecla==34 || tecla==35 || tecla==36 ||tecla==37 || tecla==38 || tecla==39 || tecla==40 || tecla==46 ) {
				return;
			}
		}
		campo.value=c
	}
	return c;
}
//-------------------------------------------------------------------------------------
function fwFormatarCpf(e,evento,value)
{
	var s = "";
	if( evento )
	{
		if (isNS4) {
			tecla=evento.which;
		} else {
			tecla=evento.keyCode;
		}
		if( tecla==35 || tecla==36 || tecla==37 || tecla==38 || tecla==39 || tecla==40 || tecla==46 ) {
			return true;
		}
	}
	if( e )
	{
		s = e.value;
	}
	else
	{
		s = value;
	}
	s = fwFiltraCampo(s);
	tam =  s.length;
	r = s.substring(0,3) + "." + s.substring(3,6) + "." + s.substring(6,9)
	r += "-" + s.substring(9,11);
	if ( tam < 4 )
		s = r.substring(0,tam);
	else if ( tam < 7 )
		s = r.substring(0,tam+1);
	else if ( tam < 10 )
		s = r.substring(0,tam+2);
	else
		s = r.substring(0,tam+3);
	if( e )
	{
		e.value = s;
		return true;
	}
	return s;
}
//-------------------------------------------------------------------------------------
function fwValidarCpf(e,evento,clear) {
	var dv = false;
	var fn = jQuery(e).attr('meta-callback');
	fwSetBordaCampo(e,false,evento); // retira a cor vermelha
	controle = "";
	s = fwFiltraCampo(e.value);
	tam = s.length;
	if ( tam == 11 && !s.match(/(\d)\1{10}/) ) {
		dv_cpf = s.substring(tam-2,tam);
		for ( i = 0; i < 2; i++ ) {
			soma = 0;
			for ( j = 0; j < 9; j++ )
				soma += s.substring(j,j+1)*(10+i-j);
			if ( i == 1 ) soma += digito * 2;
			digito = (soma * 10) % 11;
			if ( digito == 10 ) digito = 0;
			controle += digito;
		}
		if ( controle == dv_cpf )
			dv = true;

        if( fn  )
		{
			if ( window[fn] )
			{
			    window[fn](dv,e,evento)
        	}
			else
			{
				fwAlert('função callback '+fn+' não definida.');
			}
			return;
		}

		if ( ! dv && tam > 0) {
			fwSetBordaCampo(e,true,evento); // coloca a cor vermelha
			mensagem = "           Erro de digitação:\n";
			mensagem+= "          ===============\n\n";
			mensagem+= " O CPF: " + e.value + " não existe!!\n";
			//mensagem+= " O DV: " + controle + "\n";
			if( clear )
			{
				e.value='';
			}
			if( jQuery(e).attr('meta-invalid-message'))
			{
				mensagem = jQuery(e).attr('meta-invalid-message');
			}
			fwAlert(mensagem,{'callback':function(){ e.focus() }});
			evento.returnvalue=false;
			return false;
		}
	} else  {
        if( fn  )
		{
			if ( window[fn] )
			{
			    window[fn]((e.value==''),e,evento)
        	}
			else
			{
				fwAlert('Função callback '+fn+' não definida.');
			}
			return;
		}
		if( jQuery(e).attr('meta-always-validate') == 'true' && e.value != '' )
		{
			mensagem = 'CPF esta incompleto!';
			if( jQuery(e).attr('meta-invalid-message'))
			{
				mensagem = jQuery(e).attr('meta-invalid-message');
			}
			fwAlert(mensagem,{'callback':function(){ e.focus() }});
			evento.returnvalue=false;
		}
		else
		{
			e.value = '';
		}
	}
	return true;
}
//-------------------------------------------------------------------------------------
function fwFormatarCnpj(e,evento,value) {
	var s = "";
	var r = "";
	if( evento )
	{
		if (isNS4) {
			tecla=evento.which;
		} else {
			tecla=evento.keyCode;
		}
		// teclas válidas tab, backspace setaesquerda, setadireita e delete
		if( tecla==35 || tecla==36 ||tecla==37 || tecla==38 || tecla==39 || tecla==40 || tecla==46 ) {
			return true;
		}
	}
	if( e)
	{
		s = e.value;
	}
	else
	{
		s = value;
	}
	s = fwFiltraCampo(s);
	tam =  s.length;
	r = s.substring(0,2) + "." + s.substring(2,5) + "." + s.substring(5,8)
	r += "/" + s.substring(8,12) + "-" + s.substring(12,14);
	if ( tam < 3 )
		s = r.substring(0,tam);
	else if ( tam < 6 )
		s = r.substring(0,tam+1);
	else if ( tam < 9 )
		s = r.substring(0,tam+2);
	else if ( tam < 13 )
		s = r.substring(0,tam+3);
	else
		s = r.substring(0,tam+4);
	if(e)
	{
		e.value = s;
		return true;
	}
	return s;
}
//-------------------------------------------------------------------------------------
function fwValidarCnpj(e,evento,clear) {
	var dv = false;
	var fn = jQuery(e).attr('meta-callback');
	fwSetBordaCampo(e,false,evento); // retira a cor vermelha
	controle = "";
	s = fwFiltraCampo(e.value);
	tam = s.length
	if ( tam  == 14  && !s.match(/(\d)\1{13}/) )
	{
		dv_cnpj = s.substring(tam-2,tam);
		for ( i = 0; i < 2; i++ ) {
			soma = 0;
			for ( j = 0; j < 12; j++ )
				soma += s.substring(j,j+1)*((11+i-j)%8+2);
			if ( i == 1 ) soma += digito * 2;
			digito = 11 - soma  % 11;
			if ( digito > 9 ) digito = 0;
			controle += digito;
		}
		if ( controle == dv_cnpj )
			dv = true;

        if( fn  )
		{
			if ( window[fn] )
			{
			    window[fn](dv,e,evento)
        	}
			else
			{
				fwAlert('Função callback '+fn+' não definida.');
			}
			return;
		}


		if ( ! dv && tam > 0) {
			mensagem = "           Erro de digitação:\n";
			mensagem+= "          ===============\n\n";
			mensagem+= " O CNPJ: " + e.value + " não existe!!\n";
			//mensagem+= " CONTROLE " +controle +"\n";
			if( clear )
			{
				e.value='';
			}
			fwSetBordaCampo(e,true,evento); // retira a cor vermelha
			if( jQuery(e).attr('meta-invalid-message'))
			{
				mensagem = jQuery(e).attr('meta-invalid-message');
			}
			fwAlert(mensagem,{'callback':function(){ e.focus() }});

			evento.returnvalue=false;
		}
	} else  {

        if( fn  )
		{
			if ( window[fn] )
			{
			    window[fn]((e.value==''),e,evento)
        	}
			else
			{
				fwAlert('Função callback '+fn+' não definida.');
			}
			return;
		}
		if( jQuery(e).attr('meta-always-validate') == 'true' && e.value != '' )
		{
			mensagem = 'CNPJ esta incompleto!';
			if( jQuery(e).attr('meta-invalid-message'))
			{
				mensagem = jQuery(e).attr('meta-invalid-message');
			}
			fwAlert(mensagem,{'callback':function(){ e.focus() }});
			evento.returnvalue=false;
		}
		else
		{
			e.value = '';
		}
	}
	return dv;
}
//--------------------------------------------------------------------------------
function fwValidarCpfCnpj(e,event,numPessoa) {
	var s = "";
	var tam="";
	s = fwFiltraCampo( e.value );
	tam = s.length;
	if ( tam < 12 ) {
		if ( tam == 11 || !numPessoa )
			return fwValidarCpf(e,event);
	} else
		return fwValidarCnpj(e,event);
}
//--------------------------------------------------------------------------------
function fwFormataCpfCnpj(e,event,value)
{
	var s = "";
	if( e )
	{
		s = fwFiltraCampo(e.value);
	}
	else
	{
		s = value;
	}
	tam =  s.length;
	if (tam < 12 )
	{
		fwFormatarCpf(e,event,value)
	}
	else
	{
		fwFormatarCnpj(e,event,value);
	}
}
//--------------------------------------------------------------------------------
function fwValidarData(e,evento,formato,dataMinima,dataMaxima)
{
	var strDia	=	"";
	var strMes	=	"";
	var strAno	=	"";
	var Dia		=	0;
	var Mes		=	0;
	var Ano		=	0;
	var texto	=	e.value;
	var Msg		=	"";    		// mensagem a ser exibida na tela se houver erro
	var erro 	= 	false;
	formato 	= 	formato.toLowerCase();
	fwSetBordaCampo(e,false,evento); // retira a cor vermelha
	switch (formato.toLowerCase())
	{
		case 'dm':
			texto +='/2000';
			if(dataMinima)
			{
				dataMinima +='/2000';
			}
			if(dataMaxima)
			{
				dataMaxima +='/2000';
			}
			break;
		case 'my':
			texto ='01/' + texto;
			if(dataMinima)
			{
				dataMinima = '01/' + dataMinima;
			}
			if(dataMaxima)
			{
				dataMaxima = '01/' + dataMaxima;
			}
			break;
	}
	if ( fwFiltraCampo(texto)!="")
	{
		// data está digitada incompleta
		if ( texto.length < 10 && texto.length != 8 )
		{
			e.value = '';
			return true;
		}
		strDia = texto.substring(0,2);
		strMes = texto.substring(3,5);
		strAno = texto.substring(6);

		Dia=parseInt(strDia,10);
		Mes=parseInt(strMes,10);
		Ano=parseInt(strAno,10);
		// colocar o ano com 4 digitos se o usuario informar com 2
		if ( Ano < 100 )
		{
			if (Ano > 40 )
				Ano += 1900
			else
				Ano += 2000;

			switch (formato)
			{
				case 'my':
					e.value = strMes+'/'+Ano;
					break;
				default:
			}
			strAno=Ano;
		}

		if ((Dia<1) || (Dia>31) || isNaN(Dia)) {
			Msg = Msg + 'Dia '+Dia+' inválido\n';
			erro = true;
		}
		if ((Mes<1) || (Mes>12) || isNaN(Mes))
		{
			Msg = Msg + 'Mês '+Mes+' inválido\n';
			erro = true;
		}
		if (isNaN(Ano))
		{
			Msg = Msg + 'Ano '+Ano+' inválido\n';
			erro = true;
		}
		if ((Dia>=31) && ((Mes==4) || (Mes==6) || (Mes==9) || (Mes==11)))
		{
			Msg = Msg + 'Dia inválido para este Mês\n';
			erro = true;
		}
		if (Mes==2)
		{
			//MES DE FEVEREIRO
			if (Dia>=30)
			{
				Msg = Msg + 'Dia inválido para fevereiro\n';
				erro = true;
			}
			if ((Dia==29) && (((Ano % 4) != 0) || (((Ano % 100) == 0) && ((Ano % 400) != 0))))
			{
				Msg = Msg + 'Dia inválido para fevereiro. '+ Ano +' não é bisexto\n';
				erro = true;
			}
		}
		if(!erro)
		{
			// verificar se a data está dento da faixa
			if( dataMaxima )
			{
				strDiaMax = dataMaxima.substring(0,2);
				strMesMax = dataMaxima.substring(3,5);
				strAnoMax = dataMaxima.substring(6);
				dataMaxima = ''+strAnoMax+''+strMesMax+''+strDiaMax;
			}
			if( dataMinima )
			{
				strDiaMin = dataMinima.substring(0,2);
				strMesMin = dataMinima.substring(3,5);
				strAnoMin = dataMinima.substring(6);
				dataMinima = ''+strAnoMin+''+strMesMin+''+strDiaMin;
			}
			dataInformada = strAno+''+strMes+''+strDia;
			if(dataMaxima && dataMinima)
			{
				if( dataInformada < dataMinima || dataInformada > dataMaxima)
				{
					fwSetBordaCampo(e,true,evento); // retira a cor vermelha
					switch (formato)
					{
						case 'dm':
							alert('Valor deve estar entre ' +strDiaMin+'/'+strMesMin+' e '+strDiaMax+'/'+strMesMax);
							break;
						case 'my':
							alert('Valor deve estar entre '+strMesMin+'/'+strAnoMin+' e '+strMesMax+'/'+strAnoMax);
							break;
						default:
							alert('Valor deve estar entre ' +strDiaMin+'/'+strMesMin+'/'+strAnoMin+' e '+strDiaMax+'/'+strMesMax+'/'+strAnoMax);
					}
					evento.returnvalue=false;
					e.focus();
					globalFlag = 0;
					return false;
				}
			} else if ( dataMinima != '' )
{
				if( dataInformada < dataMinima )
				{
					fwSetBordaCampo(e,true,evento); // coloca a cor vermelha
					evento.returnvalue=false;
					switch (formato)
					{
						case 'dm':
							alert('Valor deve ser maior ou igual a ' +strDiaMin+'/'+strMesMin );
							break;
						case 'my':
							alert('Valor deve ser maior ou igual a ' +strMesMin+'/'+strAnoMin );
							break;
						default:
							alert('Valor deve ser maior ou igual a ' +strDiaMin+'/'+strMesMin+'/'+strAnoMin );
					}
					e.focus();
					globalFlag = 0;
					return false;
				}
			} else if ( dataMaxima != '' )
{
				if( dataInformada > dataMaxima )
				{
					fwSetBordaCampo(e,true,true); // coloca a cor vermelha
					evento.returnvalue=false;
					switch (formato)
					{
						case 'dm':
							alert('valor deve ser menor ou igual a ' +strDiaMax+'/'+strMesMax );
							break;
						case 'my':
							alert('valor deve ser menor ou igual a ' +strMesMax+'/'+strAnoMax );
							break;
						default:
							alert('valor deve ser menor ou igual a ' +strDiaMax+'/'+strMesMax+'/'+strAnoMax );
					}
					e.focus();
					globalFlag = 0;
					return false;
				}
			}
		}
	}
	if ( erro )
	{
		fwSetBordaCampo(e,true,evento); // coloca a cor vermelha
		switch (formato)
		{
			case 'dm':
				alert(Msg +'Informe o dia e o Mês no formato DD/MM.\nExemplo:25/12' );
				break;
			case 'my':
				alert(Msg +'Informe a Mês e o ano no formato MM/YYYY.\nExemplo:12/2009' );
				break;
			default:
				alert(Msg +'Informe a data no formato DD/MM/YYYY\nExemplo:25/12/2009' );
		}
		evento.returnvalue=false;
		e.focus();
	}
	return !erro;
}
//-------------------------------------------------------------------------------------
function fwValidarEmail(campo,alertar)
{
	// verificar se existe suporte para expressao regular;
	var supported = 0;
	var str=campo.value;
	fwSetBordaCampo(campo,false,true); // retira a cor vermelha
	if (str=='')
	{
		return true;
	}
	if (window.RegExp) {
		var tempStr = "a";
		var tempReg = new RegExp(tempStr);
		if (tempReg.test(tempStr)) supported = 1;
	}
	if (!supported)
	{
		fwSetBordaCampo(campo,true,true); // coloca a cor vermelha
		if( alertar)
		{
			alert('nao suportado');
		}
		return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);

	}
	var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
	var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$");
	var r = !r1.test(str) && r2.test(str);
	if (!r)
	{
		fwSetBordaCampo(campo,true,true); // coloca a cor vermelha
		if(alertar)
		{
			alert('Email inválido!');
		}
	}
	return r;
}
//-------------------------------------------------------------------------------------
/*
function fwFormatarTelefone(e) {
	var s = "";
	var res = "";
	s = fwFiltraCampo(e.value);
	while ( s.substring(0,1) == "0" ) {
		s1 = s.substring(1,s.length);
		s = s1;
	}
	s = s.substring(0,10);
	res = s.substring(s.length-4,s.length);
	if ( s.length > 4  && s.length < 9 )
		res = s.substring(0,s.length-4)+"-"+res;
	if ( s.length > 8  )
		res = "(0xx" + s.substring(0,2) + ") " +
				   s.substring(2,s.length-4) + "-" + res;
	e.value = res;
	return res;
}
*/

function fwFormatarTelefone(e) {
	var s = "";
	var res = "";
	s = fwFiltraCampo(e.value);
	if (s.length > 12 )
	{
		s = s.substring(0,11);
	}
	if ( s.length > 4 && s.substring(0,1) =='0' && s.substring(0,4) !='0800')
	{
		while ( s.substring(0,1) == "0" )
		{
			s1 = s.substring(1,s.length);
			s = s1;
		}
	}
	if ( s.substring(0,4) == '0800' )
	{
		res = s.substring(0,4) + " " + s.substring(4,7) + " " +s.substring(7);
	}
	else
	{
		if ( s.length == 14 || s.length == 12 )
			s = s.substring(s.length-10,s.length);
		if ( s.length == 13 )
			s = s.substring(s.length-9,s.length);

		res = s.substring(s.length-4,s.length);
		if ( s.length > 4  && s.length < 9 )
			res = s.substring(0,s.length-4)+"-"+res;

		if ( s.length > 8  )
		{
			if(s.length == 11 )
			{
             	res = "(0xx" + s.substring(0,2) + ") " + s.substring(2,s.length-4) + "-" + res;
			}
			else if(s.length == 9 )
			{
                res = s.substring(0,5)+'-'+res;
			}
			else
             res = "(0xx" + s.substring(0,2) + ") " + s.substring(2,s.length-4) + "-" + res;
		}

	}
	e.value = res;
	return res;
}
//-------------------------------------------------------------------------------------
function fwFormatarCep(e) {
	var s = "";
	s = fwFiltraCampo(e.value);
	tam =  s.length;
	if(tam>2 && tam<6 ) {
		s = s.substring(0,2)+'.'+s.substring(2,5);
	} else if ( tam > 5 ) {
		s = s.substring(0,2)+'.'+s.substring(2,5)+'-'+s.substring(5,8);
	}
	e.value = s;
	return s;
}
//-----------------------------------------------------------------------------------------
function fwFormatarProcesso(e)
{
	var s = "";
	s =  fwFiltraCampo(e.value);
	tam =  s.length;
	if ( tam >15 ) // && s.substring(0,5) == "02000" && s.substring(11,13) == "20" )
		ano_dig = 4;
	else
		ano_dig = 2;

	r = s.substring(0,5) + "." + s.substring(5,11) + "/";
	r+= s.substring(11,11+ano_dig)  + "-" + s.substring(11+ano_dig,13+ano_dig);
	//window.status = r + 'tam:'+tam;
	if ( tam < 6 )
		s = r.substring(0,tam);
	else if ( tam < 12 )
		s = r.substring(0,tam+1);
	else if ( tam < 12 + ano_dig )
		s = r.substring(0,tam+2);
	else
		s = r.substring(0,tam+3);
	e.value = s;
	return s;
}
//-----------------------------------------------------------------------------------------
function fwValidarProcesso(e,clear)
{
	var dv = false;
	clear  = clear||true;
	s = fwFiltraCampo(e.value);
	tam = s.length
	if ( tam == 15 || tam == 17 ) {
		if ( tam == 15 && s.substring(11,13) < 60 ) {
			s = s.substring(0,tam-4) + "20" + s.substring(tam-4);
			tam = 17;
		}
		num = s.substring(0,tam-2);
		for ( i = 0; i < 2; i++ ) {
			soma = 0;
			mult = num.length + 1;
			for ( k = 0; k < num.length ; k++ )
				soma += num.substring(k,k+1)*(mult-k);
			mod11 = 11 - (soma % 11);
			if ( mod11 < 10 )  dv_proc="0"+mod11;
			else  dv_proc = mod11 + "";
			dv_proc = dv_proc.substring(1,2);
			num+= dv_proc;
		}
		if ( num == s )
			dv = true;
	}
	if ( ! dv && tam > 0 ) {
		if( !fwValidarProcessoSISPROT(e) ) {
			mensagem = "           Erro de digitação:\n";
			mensagem+= "          ===============\n\n";
			mensagem+= " DV para o processo " + e.value + " não confere!!\n";

			alert(mensagem);
			if( clear )
			{
				e.value = '';
			}
			e.focus();
		}
	}
	return dv;
}
//-----------------------------------------------------------------------------------------
function fwValidarProcessoSISPROT(e)
{
	var dv = false;
	s = fwFiltraCampo(e.value);
	tam = s.length
	if ( tam == 15 || tam == 17 ) {
		num = s.substring(0,tam-2);
		for ( i = 0; i < 2; i++ ) {
			soma = 0;
			mult = num.length + 1;
			for ( k = 0; k < num.length ; k++ )
				soma += num.substring(k,k+1)*(mult-k);
			mod11 = 11 - (soma % 11);
			if ( mod11 < 10 )  dv_proc="0"+mod11;
			else  dv_proc = mod11 + "";
			dv_proc = dv_proc.substring(1,2);
			num+= dv_proc;
		}
		if ( num == s )
			dv = true;
	}
	return dv;
}
//-----------------------------------------------------------------------------------------
function fwColocarMascara(field, _mascara, event) {
	var key ='';
	var aux='';
	var len=0;
	var i=0;
	var strCheck = '0123456789';
	var rcode = (window.Event) ? event.which : event.keyCode;
	function mascara(_mascara, val)
	{
		var i, mki;
		var aux="";

		for(i=mki=0; i<val.length; i++, mki++) {
			if(_mascara.charAt(mki)=='' || _mascara.charAt(mki)=='#' || _mascara.charAt(i)==val.charAt(i)) {
				aux+=val.charAt(i);
			} else {
				aux+=_mascara.charAt(mki)+val.charAt(i);
				mki++;
			}
		}
		return aux;
	}
	function retirarMascara(val)
	{
		var strCheck = "'[](){}<>=+-*/_|\~`!?@#$%^&:;,.";
		var aux="";
		var i;

		for(i=0; i<val.length; i++) {
			if(strCheck.indexOf(val.charAt(i))==-1) {
				aux+=val.charAt(i);
			}
		}
		return aux;
	}
	// se trocar o evento onKeypress por onKeyUp, tem que diminuir 48 para achar o codigo certo.
	rcode-=48;
	aux=field.value;
	aux=retirarMascara(aux);
	aux=mascara(_mascara,aux);
	if( (rcode < 1 ) || ( field.value.length >= _mascara.length )  ) {
		if( rcode < 0 ) {
			return false;
		}
	}
	key=String.fromCharCode(rcode);
	if(strCheck.indexOf(key)==-1) {
		key=String.fromCharCode(rcode+48);
		if(strCheck.indexOf(key)==-1) {
			i = field.value.toUpperCase().indexOf(key);
			aux = field.value.substr(0,i) + field.value.substr(i+1,1000);
			aux=mascara(_mascara,aux);
			field.value=aux;
			return false;
		}
	}
	field.value=aux;
	field.value = aux.substr(0,_mascara.length);
	return false;
}

//-----------------------------------------------------------------------------------------
function fwDoAction(action,form)
{
	fwFazerAcao(action,form);
}
function fwFazerAcao( acao,formulario )
{
	if( !fwChkRequestAjax() )
	{
		return false;
	}
	if ( formulario == null )
	{
		if ( document.forms[0].name != 'menuweb_submit')
		{
			// encontrar o formulário
			formulario = document.forms[0];
		}
		else
		{
			formulario = document.forms[1];
		}
	}
	else
	{
		formulario = fwGetObj(formulario);
	}
	try{
		if( blockUIOnAction )
		{
			try{fwBlockUI('Executando. Aguarde...');}catch(e){}
		}
		acao=acao==null ? '#' : acao;
		formulario.formDinAcao.value=acao;
		formulario.submit();
	} catch(e){
		alert('coloque um campo hidden com id=formDinAcao no formulário\npara qua a acao '+acao+' possa ser submetida!');
	}
}
//-------------------------------------------------------------------------------------
// Função para substituir a document.getElementById()
function fwGetObj(nomeObjeto,propriedade)
{
	var app_iframe = document.getElementById('app_iframe');
	if ( app_iframe )
	{
		return app_iframe.contentWindow.fwGetObj(nomeObjeto,propriedade);
	}
	// compatibilidade com formdin3
	app_iframe = document.getElementById('iframe_area_dados');
	if ( app_iframe )
	{
		return app_iframe.contentWindow.fwGetObj(nomeObjeto,propriedade);
	}
	var obj;

		try {
		obj=jQuery("#"+nomeObjeto).get(0);
		} catch(e){}
		if(!obj)
		{
			try{
			obj=jQuery("#"+nomeObjeto+'disabled').get(0);
			} catch(e){}
		}
		if(!obj)
		{
			try{
			obj=jQuery("#"+nomeObjeto+'_disabled').get(0);
			} catch(e){}
		}
		// procurar em caixa baixa
	nomeObjeto = nomeObjeto.toLowerCase();
		if(!obj)
		{
			try{
			obj=jQuery("#"+nomeObjeto).get(0);
			} catch(e){}
		}
		if(!obj)
		{
			try{
			obj=jQuery("#"+nomeObjeto+'disabled').get(0);
			} catch(e){}
		}
		if(!obj)
		{
			try{
			obj=jQuery("#"+nomeObjeto+'_disabled').get(0);
			} catch(e){}
		}

	if( obj && propriedade)
	{
		try {
			eval('var prop = obj.'+propriedade);
			return prop;
		} catch(e) {}
	}
	return obj;
}
//-------------------------------------------------------------------------------------
function fwFormatarInteiro(e,formatar)
{
	if (e.value.length == 0) {
		return null;
	}
	s = e.value;
	// window.status = s;
	if ( s == '0-')
		s = '- ';
	negativo = (s.indexOf('-') > -1) && ( s.indexOf('+') == -1 );

	s = fwFiltraCampo(e.value); // retirar os caractes inválidos
	if (formatar=='N') {
		if (negativo)
			e.value = ' -'+s ;
		else
			e.value = s;
		return e.value;
	}
	tam =  s.length; // numero de caracteres digitados
	if ( tam > 0  )
		// retirar os zeros da esquerda
		s = eval(s.substring(0))+'';
	if ( tam > 3 ) {
		// retirar os zeros da esquerda
		//s = eval(s.substring(0))+'';
		j = 0;
		r = '';
		// ler os digitos de traz para frente colocando os pontos e guardando em r
		for( i = tam; i > 0 ; i-- ) {
			j++;
			if ( j == 4 ) {
				j = 1;
				r = '.' + r;
			}
			r = s.substring(i-1,i) + r;
		}
		// devolver para o resultado a parte inteira formatada
		s = r;
	}
	e.value =  s;
	if ( negativo ) {
		e.value = ' -'+e.value+'';
		s = ' -'+s+'';
	}
	if ( e.value.length == 0 )
		e.value = '';
	return s;
}
//-------------------------------------------------------------------------------------
function fwFormatarDecimal(e,casas)
{
	if (e.value.length == 0) {
		return null;
	}
	var zeros = '00000000000000000';
	if( casas==null)
		casas=2;
	//alert( zeros.substr(0,casas));
	zeros = zeros.substr(0,casas);
	s = e.value;
	if ( s == '0,'+zeros+'-'){
		s = '- ';
	}
	negativo = ( s.substring(0,1) == '-');
	if( s.indexOf(',')== -1)
	{
		e.value += ','+zeros;
	}
	// retirar os caractes inválidos
	s = fwFiltraCampo(e.value);
	// completar com zeros quando o valor for menor que  1,00
	if (s.length == 0)
		s = "0"+zeros.substr(0,casas)
	else if (s.length == 1)
		s = "00"+zeros.substr(0,casas-1) + s
	else if (s.length == 2)
		s = "0" +zeros.substr(0,casas-2)+ s;

	//	if (s.length == 0) s = "000" + s
	//      else if (s.length == 1) s = "00" + s
	//         else if (s.length == 2) s = "0" + s;
	// numero de caracteres digitados
	tam =  s.length;
	if ( tam > casas ) {
		// a posição da vírgula será sempre o tamanho meno 2
		posvirg = tam - casas;
		// retirar os zeros da esquerda da parte inteira e colocar a virgula na parte decimal
		s = eval(s.substring(0,posvirg)) + "," + s.substring(posvirg);
		// colocar pontos de 3 em 3 digitos se a parte inteira ja tiver tamanho > 3
		parteInteira = s.substring(0,posvirg);
		if ( parteInteira.length > 3 )  {
			j = 0;
			//
			r = '';
			// ler a parte inteira de traz para frente colocando os pontos e guardando em r
			for( i = parteInteira.length; i > 0 ; i-- ) {
				j++;
				if (j == 4) {
					j = 1;
					r = '.' + r;
				}
				r = parteInteira.substring(i-1,i) + r;
			}
			// devolver para o resultado a parte inteira formatada concatenada com a parte decimal
			s = r + s.substring(posvirg);
		}
	}
	if ( negativo ) {
		e.value = '-'+e.value+'';
		s = '-'+s+'';
	}
	e.value = s;
	return s;
}
//-------------------------------------------------------------------------------
function fwSetBordaCampo(e,erro,evento)
{
	if( ! evento )
	{
		return;
	}
	try
	{
		if ( typeof(e)=='string')
		{
			e = jQuery("#"+e).get(0);
		}
		if( e )
		{
			if ( e.style.border.indexOf('none') > -1 )
			{
				return;
			}
			if(erro)
			{
				e.setAttribute('bc',e.style.borderColor);
				e.setAttribute('bw',e.style.borderWidth);
				e.setAttribute('bs',e.style.borderStyle);
				e.style.borderColor=globalCorBordaCampoErro;
				if( ! e.style.borderWidth )
				{
					e.style.borderWidth="1";
				}
				e.style.borderStyle='solid';
			}
			else
			{
				var bc = e.getAttribute('bc');
				var bc = bc||globalCorBordaCampo;
				e.style.borderColor = bc;
				e.style.borderWidth = e.getAttribute('bw')==null ? 1  : e.getAttribute('bw');
				e.style.borderStyle = e.getAttribute('bs')==null ? 'solid': e.getAttribute('bs');
			}
		}
	} catch(e){}
}
//------------------------------------------------------------------------------
function fwSelecionarAba(aba,pageControl,fnAfterClick,ignoreDisabled)
{
	if(!aba){
		return;
	}
	ignoreDisabled = ignoreDisabled || false;
	// passou o nome da aba
	if( typeof(aba) == 'string')
	{
		if(!pageControl)
		{
			// encontrar o id da primeira aba
			jQuery("table:first[fieldType='pagecontrol']").each(
				function()
				{
					pageControl =  this.id;
				}
			);
			if( !pageControl )
			{
				alert( 'Para selecionar a aba pelo seu nome, passe o nome do seu objeto pageControl no segundo parametro!');
				return;
			}
		}
		var link = pageControl+'_container_page_'+aba+'_link';
		link = fwGetObj(link.toLowerCase());
		if( link )
		{
			try{
				if( ignoreDisabled )
				{
					fwSelecionarAba(link,pageControl,fnAfterClick,ignoreDisabled);
				}
				else
				{
					link.onclick();
				}
			}catch(e){}
		}
		else
		{
			alert( 'A aba ' + aba + ' não existe no formulário!');
		}
	}
	else if( typeof(aba) == 'object')
	{
		// passou o objeto aba
		if( aba.nodeType==1 )
		{
			// encontrar o objeto container pai
			var objParent 	= aba.parentNode.parentNode;
			var arrChildren = objParent.childNodes;

			// percorrer todas as paginas
			for(i = 0; i < arrChildren.length; i++)
			{
				var objChild = arrChildren[i];
				if (objChild.nodeType==1)
				{
					try
					{
						document.getElementById( objChild.getAttribute('tabRef')).style.display='none';
					//document.getElementById( objChild.getAttribute('tabRef')).style.height='1%';
					}
					catch(e){}
					objChild.className=null;
				}
			}
			// encontrar a div referente a aba
			try
			{
				// exibir a aba selecionada
				var obj = document.getElementById( aba.parentNode.getAttribute('tabRef'));
				obj.style.display='block';
				// aba corrente
				var ac = obj.id;
				// definir o campo oculto referente a aba atual
				document.getElementById(aba.getAttribute('pagecontrol')+'_current').value=ac;
			}
			catch(e){}
			aba.parentNode.className='activePageControl';
		}
	}
	if( fnAfterClick )
	{
		try{
			if( fnAfterClick.indexOf('(')==-1)
			{
				fnAfterClick =+'()';
			}
			eval(fnAfterClick+';');
		}catch(e){}
	}
}
//------------------------------------------------------------------------------
function fwConfirmCloseForm( strForm, boolSubForm, afterCloseFunction ,beforeCloseFunction )
{
			var result=true;
			if( beforeCloseFunction )
			{
				try {

					if( typeof beforeCloseFunction == 'string' )
					{
						if( beforeCloseFunction.indexOf('(') == -1)
						{
							beforeCloseFunction+='()';
						}
						 eval('result='+beforeCloseFunction+';');
					}
					else if( typeof beforeCloseFunction == 'function' )
					{
						result = beforeCloseFunction.call();
					}
				} catch(e){ alert( e.message ) }
				if( !result )
				{
					return false;
				}
			}
	// quando tiver um iframe, pode ter um plugin da adobe aberto, então utilzar confirm() nativo que não dá conflito
	if( jQuery('iframe').length>0)
	{
		if( confirm('Deseja fechar o formulário?'))
		{
			fwFecharFormulario(strForm,boolSubForm,afterCloseFunction,beforeCloseFunction)
		}
		return;
	}

	jQuery.alerts.okButton        ='Sim';
	jQuery.alerts.cancelButton    ='Não';
	jConfirm('Deseja fechar o formulário?','Confirmação'
	,function(r)
	{
		if( r == true )
		{
			fwFecharFormulario( strForm, boolSubForm, afterCloseFunction, beforeCloseFunction )
		}
	});
}

function fwFecharFormulario( strForm, boolSubForm, afterCloseFunction, beforeCloseFunction )
{
		var obj = jQuery("#"+strForm).get(0);
		if(obj)
		{

			if( afterCloseFunction )
			{
				try {

					if( typeof afterCloseFunction == 'string' )
					{
						if( afterCloseFunction.indexOf('(') == -1)
						{
							afterCloseFunction+='()';
						}
						eval(afterCloseFunction+';');
					}
					else if( typeof afterCloseFunction == 'function' )
					{
						afterCloseFunction.call();
					}
				} catch(e){}
			}

			if( jQuery('#box_' + strForm) )
			{
				try{
					jQuery('#fwOnlineDoc').remove();
				}catch(e){}
				try{
					jQuery('#box_'+strForm).remove();
				}catch(e){}
				try{
					jQuery('#'+strForm).remove();
				}catch(e){}
			}
			else
			{
				//obj.parentNode.removeChild(obj);
				try{
					jQuery('#'+strForm).remove();
				} catch(e){}
			}
			try
			{
				if ( top.app_load_module && !boolSubForm)
				{
					top.app_load_module('about:blank');
				}
			}
			catch(e){}
			try
			{
				// não limpar o nome do módulo do rodape se fechar um subformulario
				if( ! boolSubForm )
				{
					parent.app_setFooterModule('');
				}
			}
			catch(e) {}
		}
}

//------------------------------------------------------------------------------
function fwUpdateFields( fields, values, event )
{
	fwSetFields( fields, values, event )
}
// Função utilizada pelo autocomplete para limpar os campo que serão atualizados ao começar a digitar
function fwSetFields( fields, values, event )
{
	if( event )
	{
		tecla = fwGetTecla(event);
		// desprezar teclas que não alteram valor do campo
		if( tecla==9 ||tecla==17 ||tecla==18 ||tecla==20 || tecla==33|| tecla==34 || tecla==35 || tecla==36 || tecla==37 || tecla==38 || tecla==39 || tecla==40 )
		{
			return false;
		}
	}
	try
	{
		var val;
		var delim;
		var obj;
		var aFields = [];
		var	aValues = [];
		var parentSelects = [];
		if( fields.indexOf('|') >- 1)
		{
			delim = '|';
		}
		else if( fields.indexOf(',') > -1 )
		{
			delim = ',';
		}
		else
		{
			aFields[0] = fields;
			aValues[0] = values;
		}

		if( delim )
		{
			aFields = fields.split(delim);
			aValues = values.split(delim);
		}
		for( i=0;i<aFields.length;i++ )
		{
			val = (aValues[i] == null ) ? aValues : aValues[i];
		   try
		   {
				obj = jQuery("#"+aFields[i]).get(0);
				if( !obj )
				{
					obj = jQuery("input[name='" + aFields[i] + "']" ).get(0);
				}
				// verificar se é checkbox de opção S ou N
				if( !obj )
				{
					obj = jQuery("#" + aFields[i] + "_"+val ).get(0);
				}

				if( obj.type =='select-one' )
				{
					obj.selectedIndex=-1;
					jQuery(obj).val(val);
					// verificar se é um select combinado atraves da propriedade parentselect
					if( jQuery(obj).attr('parentselect'))
					{
						parentSelects.push(jQuery(obj).attr('parentselect'));
						// criar  campo temp se não existir
						if( ! jQuery("#"+obj.id+'_temp').get(0) )
						{
							jQuery(obj).append('<input type="hidden" id="'+obj.id+'_temp" name="'+obj.id+'_temp" value="'+val+'">');
						}
					}
				}
				else if( obj.type =='checkbox' )
				{
					obj.checked=true;
				}
				else if( obj.type =='radio' )
				{
					fwClearChildFields(aFields[i]+'_table');
					if( val )
					{
						obj = jQuery("#"+aFields[i] + "_"+val ).get(0);
						if( obj && obj.value==val )
						{
							obj.checked=true;
						}
					}
				}
				else if( obj.innerHTML )
				{
					jQuery(obj).html('');
				}
				else
				{
					  jQuery(obj).val(val);
				}
				// limpar o campo desabilitado tambem

				try{
					fwGetObj(aFields[i]+'_disabled').value=val;
				}catch(e){};
				try{
					fwGetObj(aFields[i]+'_temp').value=val;
				}catch(e){};
				try{
					fwGetObj(aFields[i]+'disabled').value=val;
				}catch(e){};

			} catch(e) {}

		}
		// disparar os eventos onchange dos selects pai
		if( parentSelects.length > 0 )
		{
			for( key in parentSelects)
			{
				jQuery("#"+parentSelects[key] ).change();
			}
		}
	} catch(e) {}
}
//-------------------------------------------------------------------------------
function fwAutoCompleteFindValue(li,obj)
{

	//alert( 'fwAutoCompleteFindValue');
	//obj=fwGetObj('nom_municipio');
	//var data = new Date();
	//fwGetObj('tecla_disabled').value = data;

	/*
	 * keepFieldValues - Utilizado para não sobrepor os valores dos campos
	 * do formulário alterados pelo usuário na primeira vez que o formulario
	 * for postado. Recurso utilizado pelo gride-offline com autocomplete
	 */
	var keepFieldValues = obj.getAttribute('keepFieldValues');
	obj.setAttribute('keepFieldValues','0');
	fwSetBordaCampo(obj,false,true);
	if( li == null )
	{
		if( obj.getAttribute('needed')=='true' )
		{
			fwSetBordaCampo(obj,true,true);
		}
		else
		{
			var label = obj.getAttribute('label');
			if( obj.value )
			{
				fwAlert( (label?label+' ':'')+obj.value+ ' inexistente.');
			}
			// limpar os campos dependentes
			obj.onkeydown();
		}
		return false;
	// alert("Nao Encontrado!");
	}

	// voltou da chamada ajax
	if( !!li.extra )
	{
		try	{
			eval('var dados='+li.extra[0]);
			for (key in dados)
			{
				var campo = key;
				var valor = dados[key];
				if( key == 'fwCallbackAc')
				{
					// retirar as barras invertidas. ex: atualizar(\'atualizar\');
					//campo = campo.replace(new RegExp(/\\/g),'');
					valor = valor.replace(new RegExp(/\(\\\'/g),'(\'');
					valor = valor.replace(new RegExp(/\\\'\)/g),'\')');
					eval( valor );
				}
				else if( keepFieldValues == '0' || jQuery('#'+campo ).val() == '' )
				{
					if(campo.indexOf('(')>0)
					{
						// retirar as barras invertidas. ex: atualizar(\'atualizar\');
						//campo = campo.replace(new RegExp(/\\/g),'');
						//campo = campo.replace(new RegExp(/\(\\\'/g),'(\'');
						//campo = campo.replace(new RegExp(/\\\'\)/g),'\')');
						//eval(campo);
					}
					else
					{
						fwAtualizarCampos(campo,valor);
					/*
						if(oCampo = fwGetObj(campo)
						{
							try{oCampo.value=valor;} catch(e){}
						}
						if(oCampo = fwGetObj(campo+'_disabled'))
						{
							try{oCampo.value=valor;}catch(e){}
						}
						if(oCampo = fwGetObj(campo+'disabled'))
						{
							try{oCampo.value=valor;}catch(e){}
						}
						*/
					}
				}
			}
		} catch(e){}
	}
	else
	{
		var sValue = li.selectValue;
	}
}
//-------------------------------------------------
function fwAutoCompleteSelectItem(li,obj)
{
	//eval('var dados='+li.extra[0]);
	//alert( li.extra[0] );
	//alert( 'fwAutoCompleteSelectItem');
	fwAutoCompleteFindValue(li,obj);
//alert('Parametros extras:'+li.extra[0]+' e '+ li.extra[1]);
}
//-------------------------------------------------
function fwAutoCompleteValidade(e)
{
	var oSuggest = e.autocompleter;
	return oSuggest.findValue();
}
/*
	Limpar o cache do campo autocomplente
	ex: fwAutoCompleteClearCache('nom_interessado');
*/
function fwAutoCompleteClearCache(e)
{
	if( typeof(e) == 'string')
	{
		e = fwGetObj(e);
	}
	if( typeof(e) == 'object')
	{
		var oSuggest = e.autocompleter;
		oSuggest.flushCache();
	}
}
//--------------------------------------------------
function fwSetFocus( campo )
{
	try {
		campo = campo.replace('#','');
		var e = jQuery("#"+campo);
		var pc;
		if( e.get(0) )
		{
    		var parent = e.attr('parent');
    		var p;
    		while ( parent )
    		{
    			try{p = jQuery("#"+parent).attr('parent');}catch(e){break;}
    			if( !p )
    			{
    				p=parent;
    			}
    			if( p )
    			{
   			   		try{ pc = jQuery('span[tabid="'+p+'"]').attr('pagecontrol');}catch(e){break}
    				if( pc )
    				{
						fwSelecionarAba(p,pc);
    				}
    				else
    				{
    					break;
    				}
    				parent = pc
				}
				else
				{
					break;
				}
    		}
            if( parent )
            {
               try{ pc = jQuery('span[tabid="'+parent+'"]').attr('pagecontrol');}catch(e){}
               if( pc )
               {
					fwSelecionarAba(parent,pc);
               }
            }
			jQuery("#"+campo.replace('#','')).focus();
		}
	} catch(e){}
}
//--------------------------------------------------

// inicio
function fwSetOpcoesSelect(dados)
{
	var aCmbFilhos = dados.split(';');
	var i, opt;
	for(i=0;i<aCmbFilhos.length;i++)
	{

		eval('var obj='+aCmbFilhos[i]);
		comboPai = fwGetObj(obj['selectPai']);
		if( !obj.pastaBase )
		{
			obj.pastaBase = pastaBase;
		}
		var indiceComboPai 		= comboPai.selectedIndex;
		var valorComboPai  		= comboPai.value;
		comboFilho = fwGetObj(obj['selectFilho']+'_disabled');
		if(!comboFilho)
		{
			comboFilho = fwGetObj(obj['selectFilho']);
		}
		if(!comboFilho)
		{
			alert( 'Erro na Função: fwSetOpcoesSelect().\n\nO campo '+obj['selectFilho']+' não existe no formulário, e foi combinado com o campo '+obj['selectPai']);
			return;
		}
		else
		{
           if( obj['selectFilhoStatus'] == 'habilitado')
           {
               if( comboFilho.disabled && comboFilho.options.length > 1)
               {
                   obj['selectFilhoStatus'] = 'desabilitado';
               }
           }
			fwLimparOpcoesSelect(comboFilho);
			// retirar animação ajax
			//try {fwSetEstilo('{"id":"'+objCombo.id+'","backgroundImage":"","backgroundRepeat":"","backgroundposition":""}');}catch(e){}
			if (indiceComboPai == -1 || valorComboPai==''  )
			{
				try
				{
					// desabiltar o select filho
					comboFilho.disabled = true;

					if(obj['descNenhumaOpcao'])
					{
						opt = new Option(obj['descNenhumaOpcao'],'');
						comboFilho.options[comboFilho.options.length] = opt;
					}
					if( comboFilho.onchange)
					{
						//alert( 'x:'+obj['selectFilho'] );
						comboFilho.onchange();
					}
					if( obj['funcaoExecutar'] )
					{
						var f = obj['funcaoExecutar'].replace('()','(comboPai,comboFilho);');
						try{
							eval( f )
						}catch(e){};
					}
				}catch(e){}
			}
			else
			{
				//alert( 'y:'+comboFilho.id );
				//try {fwSetEstilo('{"id":"'+comboFilho.id+'","backgroundImage":"url(\''+obj.pastaBase+'imagens/carregando.gif\')","backgroundRepeat":"no-repeat","backgroundPosition":"center right"}')} catch(e){};
				if( comboFilho.options )
				{
					opt = new Option('Carregando...','');
					comboFilho.disabled=true;
					comboFilho.options[comboFilho.options.length] = opt;
				}
				fwPreencherSelectAjax(obj);
			}
		}
	}
}
//------------------------------------------------------------------------
function fwPreencherSelectAjax(obj)
{
	var arquivoInclude = 'callbacks/combinarSelects.php';
	var valorFiltro   = fwGetObj(obj['selectPai']).value;
	var acao;
	var urlDestino = '';
	if( obj['acaoExecutar'] )
	{
		acao=obj['acaoExecutar'];
	}
	if( !acao && !obj['pacoteOracle'])
	{
		alert('Necessário definir uma acao ou o nome do pacote oracle na Função conbinarSelect()');
		return;
	}
	if( obj['pastaBase'])
	{
		arquivoInclude = obj['pastaBase']+arquivoInclude;
	}
	else
	{
		arquivoInclude = pastaBase+'/'+arquivoInclude;
	}
	// campos do form que entrarão no filtro
	var campoFormFiltroValor='';
	var campoBvars='';
	if(obj['campoFormFiltro'])
	{
		var aCampos=obj['campoFormFiltro'].split(',');
		var aSubCampo;
		for(i=0;i<aCampos.length;i++)
		{
			aSubCampo = aCampos[i].split('|');
			if(!aSubCampo[1])
			{
				aSubCampo[1]=aSubCampo[0].toUpperCase();
			}
			if(campoFormFiltroValor!='')
			{
				campoFormFiltroValor+='|';
				campoBvars+='|';
			}
			try{
				campoFormFiltroValor+=fwGetObj(aSubCampo[0]).value;
				campoBvars+=aSubCampo[1];
			} catch( e ){}
		}
	}
	try {
		if( !obj['valorInicial'] )
		{
			var campoTemp = fwGetObj( obj['selectFilho'] + '_temp' );
			if(campoTemp && campoTemp.value)
			{
				obj['valorInicial'] = campoTemp.value;
			}

		}
	} catch(e) {}

	/*var postData =
	'selectPai='+obj['selectPai']+
	'&campoSelect='+obj['selectFilho']+
	'&pacoteOracle='+obj['pacoteOracle']+
	'&colunaFiltro='+obj['colunaFiltro']+
	'&valorFiltro='+valorFiltro+
	'&selectFilhoStatus='+obj['selectFilhoStatus']+
	'&colunaCodigo='+obj['colunaCodigo']+
	'&colunaDescricao='+obj['colunaDescricao']+
	'&valorInicial='+obj['valorInicial']+
	'&descPrimeiraOpcao='+obj['descPrimeiraOpcao']+
	'&valorPrimeiraOpcao='+obj['valorPrimeiraOpcao']+
	'&descNenhumaOpcao='+obj['descNenhumaOpcao']+
	'&campoFormFiltro='+campoBvars+
	'&campoFormFiltroValor='+campoFormFiltroValor+
	'&funcaoExecutar='+obj['funcaoExecutar']+
	'&ajax=1'+
	'&modulo='+arquivoInclude
	'&selectUniqueOption='+obj['selectUniqueOption']+
	'&acao='+acao;
	*/
	var dadosJson = {
		modulo:obj['pastaBase']+"callbacks/combinarSelects.php"
		,
		selectPai		:obj['selectPai']
		,
		campoSelect		:obj['selectFilho']
		,
		pacoteOracle		:obj['pacoteOracle']
		,
		colunaFiltro		:obj['colunaFiltro']
		,
		valorFiltro		:valorFiltro
		,
		selectFilhoStatus	:obj['selectFilhoStatus']
		,
		colunaCodigo		:obj['colunaCodigo']
		,
		colunaDescricao	:obj['colunaDescricao']
		,
		valorInicial		:obj['valorInicial']
		,
		descPrimeiraOpcao	:obj['descPrimeiraOpcao']
		,
		valorPrimeiraOpcao	:obj['valorPrimeiraOpcao']
		,
		descNenhumaOpcao	:obj['descNenhumaOpcao']
		,
		campoFormFiltro	:campoBvars
		,
		campoFormFiltroValor:campoFormFiltroValor
		,
		funcaoExecutar		:obj['funcaoExecutar']
		,
		ajax			:"1"
		,
		selectUniqueOption	:obj['selectUniqueOption']
		,
		acao			:acao
		,
		dataType		:'textJson'
		,
		fwPublicMode : obj['fwPublicMode']
	};
	if( app_index_file != '' )
	{
		urlDestino = app_index_file;
	}
	jQuery.post(urlDestino+'?',dadosJson ,function(aDados)
	{
		if( aDados )
		{
			try{aDados = jQuery.parseJSON( aDados);} catch(e){
				if( aDados.indexOf('Erro PDO:') > -1 )
				{
					fwAlert( aDados );
					return;
				}
				return;
			}

			if( aDados['fwSession_expired'] && aDados['fwSession_expired'] == 1 )
			{
				alert( 'Sessão encerrada. Clique Ok para reiniciar!');
				fwApplicationRestart();
				return;
			}
			var objCombo	= fwGetObj(aDados['campo']+'_disabled');
			var objComboPai	= fwGetObj(aDados['selectPai']);
			if( !objCombo)
			{
				objCombo	= fwGetObj(aDados['campo']);
			}
			// retirar animação ajax
			//try {fwSetEstilo('{"id":"'+objCombo.id+'","backgroundImage":"","backgroundRepeat":"","backgroundPosition":""}');}catch(e){}
			if( !objCombo)
			{
				alert('campo select ' + aDados['campo']+' não encontrado no formulário');
				return;
			}
			if( !aDados['dados'])
			{
				// pacote retornou vazio
				fwLimparOpcoesSelect(objCombo);
				if (aDados['descNenhumaOpcao'])
				{
					var opt = new Option(aDados['descNenhumaOpcao'],'');
					objCombo.options[objCombo.options.length] = opt;
				}
				objCombo.disabled=true;
				if( objCombo.onchange )
				{
					objCombo.onchange();
				}
				if( aDados['funcaoExecutar'] )
				{
					var f = aDados['funcaoExecutar'].replace('()','(objComboPai,objCombo);');
					try{
						eval( f )
					}catch(e){};
				}
				return;
			}
			fwLimparOpcoesSelect( objCombo );
			if(aDados['descPrimeiraOpcao'])
			{
				var opt = new Option(aDados['descPrimeiraOpcao'],aDados['valorPrimeiraOpcao']);
				objCombo.options[objCombo.options.length] = opt;
			}
			//var selectUniqueOption=true;
			var v_selected = false;
			for (key in aDados['dados'])
			{
				//var opt = new Option(aDados['dados'][key],key);
				var opt = new Option(key,aDados['dados'][key]);
				key = aDados['dados'][key];

				// tratar calores quando for multiselect
				key ='|'+key+'|';
				var vi = '|'+aDados['valorInicial']+'|';
				if( vi.indexOf(key) > -1 )
				{
					opt.selected=true;
					v_selected=true;
				}
				objCombo.options[objCombo.options.length] = opt;
			}
			// fazer seleção automática quando houver apenas uma opção no select filho
			if( ! v_selected )
			{
				// selecionar a primeira e Única opção
				//if( aDados['descPrimeiraOpcao'] && objCombo.options.length==2 && selectUniqueOption )
				if( aDados['descPrimeiraOpcao'] && objCombo.options.length==2 && aDados['selectUniqueOption'] == 1 )
				{
					objCombo.options[1].selected=true;
				}
				else if( objCombo.options.length > 0  )
				{
					objCombo.options[0].selected=true;
				}
			}
			// preencher select filho se existir
			if( objCombo.onchange)
			{
				objCombo.onchange();
			}
			objCombo.disabled = (   aDados['selectFilhoStatus']=='desabilitado' || objCombo.id.indexOf('_disabled') > -1 );
			if( aDados['funcaoExecutar'] )
			{
				var f = aDados['funcaoExecutar'].replace('()','(objComboPai,objCombo);');
				try{
					eval( f )
				}catch(e){};
			}

		}
	});
}
//-----------------------------------------------------------------
function fwLimparOpcoesSelect(sel)
{
	if(sel)
	{
		if( sel.options)
		{
			while (sel.options.length > 0 )
			{
				sel.options[sel.options.length-1] = null;
			}
			if( sel.disabled )
			{
				var pos = sel.id.indexOf('_disabled');
				if( pos > 0 )
				{
					fwGetObj(sel.id.substr(0,pos) ).value = null;
				}
			}
		}
	}
}
//-------------------------------------------------------------------
// Definir o estilo de um componente utilizando javascript
// o parametro dados deve estar no formato json ex: {color:'red',backgroundColor:'blue'}
function fwSetEstilo(dados)
{
	eval('var oDados='+dados);
	var id = oDados['id'];
	if( !id )
	{
		alert("Para utilizar a Função setEstilo, é necessário o parametro id. Ex: {id='div1'}");
		return;
	}
	var obj = fwGetObj(id);
	if (obj!=null)
	{
		for (key in oDados)
		{
			if(key!='id')
			{
				try{
					eval('obj.style.'+key+'="'+oDados[key]+'"');
				}catch(e){}
			}
		}
	}
}
//------------------------------------------------------------------
function fwFieldCheckBoxClick(e,item )
{

	var objName =e.name.replace('[]','');
	var parentId = e.name.replace('[]','')+'_container';

	// escondder a borda
    jQuery("#"+parentId).css({
		'border-color':"transparent",
		"border-width":"1px",
		"border-style":"solid"
	});

    // destacar o item selecionado
	jQuery("#"+parentId+" span").each(
		function()
		{
			try
			{
	            if( ! jQuery('#'+this.id).prev().get(0).checked )
	            {
					this.style.color="#000000";
				}
				else
				{
					this.style.color="#0000FF";

				}
			}catch( e ) {}

		});
}
//----------------------------------------------------------------------
function fwFieldRadioClick(field,item)
{
	fwFieldCheckBoxClick(field,item);
}
//-----------------------------------------------------------------------------------
function fwRemoverCaractere(input,codigoAscii)
{
	var output = '';
	if( codigoAscii)
	{
		for (var i = 0; i < input.value.length; i++)
		{
			if ( (input.value.charCodeAt(i) == codigoAscii) )
			{
				i++;
			//output += '';
			}
			else
			{
				output += input.value.charAt(i);
			}
		}
		input.value=output;
	}
}
//-------------------------------------------------------------------------------------
function fwCheckNumChar(e,max)
{
	try {
		var obj = fwGetObj(e.id+'_counter');
		var texto = e.value.trim();
		var tamanho = texto.length;
		obj.style.color='#000000';
		if( tamanho > max )
		{
			fwRemoverCaractere(e,13);
			texto = e.value.trim();
			tamanho = texto.length;
			if( tamanho > max )
			{
				obj.style.color='red';
				alert('Limite de '+max+' caracteres atingido!');
				texto = texto.substr(0,max);
				e.value=texto;
				var dif = (tamanho-e.value.length);
				if( dif > 1 )
				{
					alert( 'Foram removidos '+dif+' caracteres do final do texto.')
				}
			}
		}
		obj.innerHTML='caracteres:'+e.value.length+"/"+max;
	} catch(e)	{}
}
//--------------------------------------------------------------------------------------
function fwValidarObrigatorio(e)
{
	if( e )
	{
		if( e.getAttribute('needed')=='true' && e.value=="" )
		{
			// colocar a cor vermelha na borda
			fwSetBordaCampo(e,true,true);
		}
	}
}
//---------------------------------------------------------------------
function fwLimparCampoAnexo(e,campo)
{
	e.src = e.src.replace('lixeira.gif','lixeira_bw.gif');
	e.disabled=true;
	//var btnView = fwGetObj(campo+'_view');
	//btnView.src = btnView.src.replace('page.gif','page_bw.gif');
	//btnView.disabled=true;
	fwGetObj(campo).value			= '';
	fwGetObj(campo+'_temp').value	= '';
	fwGetObj(campo+'_type').value	= '';
	fwGetObj(campo+'_size').value	= '';
	fwGetObj(campo+'_name').value	= '';
}
//------------------------------------------------------------------------
function fwClearFileAsync(id)
{
	var btnDelete;
	// trocar a imagem do botão
    try
    {
		btnDelete = jQuery('#'+id+'_btn_delete');
	    btnDelete.attr('src',btnDelete.attr('src').replace('lixeira.gif','lixeira_disabled.gif') );
	    jQuery("#"+id+",#"+id+"_disabled,#"+id+"_extension,#"+id+"_type,#"+id+"_size,#"+id+"_name,#"+id+"_temp_name").val('');
	}
	catch(e){}
}

//------------------------------------------------------------------------
function fwCampoArquivoChange(e)
{
	var btn=fwGetObj(e.id+'_clear');
	btn.src = btn.src.replace('lixeira_bw.gif','lixeira.gif');
	btn.disabled=false;
//var btn=fwGetObj(e.id+'_view');
//btn.src = btn.src.replace('page_bw.gif','page.gif');
//btn.disabled=false;

}
// Executar uma Função javascript
function fwExecutarFuncao(funcao,param)
{
  	if( typeof param == 'undefined')
	{
  		param = '';
	}
	try
	{
		var app_iframe = document.getElementById('app_iframe'); // não utilizar fwGetObj() aqui
		if ( app_iframe )
		{
			app_iframe.contentWindow.fwExecutarFuncao(funcao,param);
			return;
		}
		var app_iframe = document.getElementById('iframe_area_dados'); // não utilizar fwGetObj() aqui
		if ( app_iframe )
		{
			app_iframe.contentWindow.fwExecutarFuncao(funcao,param);
			// eval('app_iframe.contentWindow.'+funcao+';');
			return;
		}

		if( typeof funcao == 'function')
		{

			funcao.apply(this,[ param ] );
		}
		else if( typeof funcao == 'string')
		{
			funcao = funcao.replace('()','');
			if( funcao.indexOf('(')==-1)
			{
				if( typeof param == 'object' ||typeof param == 'boolean' )
				{
					funcao += '.apply(this,[param])';
				}
				else
				{
					funcao += ".apply(this,['"+param.replace(/\n/g,'').replace(/'/g,"\\'")+"'])";
				}
			}
            eval( funcao+';' );
		}
	}
	catch(e)
	{
		alert(e.message )
	}
}
//----------------------------------------------------------------------------
// atualizar uma serie de campos com uma serie de valores
// ex: fwAtualizarCampos('c1|c2|c3','a|b|c');
function fwAtualizarCampos(campos,valores)
{
	if (!campos)
	{
		return;
	}
	var app_iframe = jQuery('#app_iframe').get(0);

	if ( app_iframe )
	{
		app_iframe.contentWindow.fwAtualizarCampos(campos,valores);
		return;
	}
	// compatibilidade com FormDin3
	var app_iframe = jQuery('#iframe_area_dados').get(0);
	if ( app_iframe )
	{

		app_iframe.contentWindow.fwAtualizarCampos(campos,valores);
		return;
	}
	valores = valores || '';
	var parentSelects = [];
	var delim='|';
	if( campos.indexOf(delim) < 0 )
	{
		delim = ',';
	}
	valores = valores=='' ? delim : valores + delim;
	var aCampo = campos.split( delim );
	var aValor = valores.split( delim );

	var i;
	for(i=0;i<aCampo.length;i++)
	{
		try
		{

			campo = fwGetObj(aCampo[i]);
			if( !campo )
			{
				campo = fwGetObj(aCampo[i]);
				campo = jQuery("input:[name="+aCampo[i]+"]").get(0);
			}
			var campo_disabled1 = fwGetObj(aCampo[i]+'_disabled');
			var campo_disabled2 = fwGetObj(aCampo[i]+'disabled');
			var campo_temp = fwGetObj(aCampo[i]+'_temp');
			if( campo )
			{
				if( aValor[i])
				{
					// se for campo cpf, formatar.
					if( aCampo[i].toLowerCase().indexOf('cpf')>-1 && aValor[i].length==11 )
					{
						aValor[i] = fwFormatarCpf(null,null,aValor[i]);
					}

					if( campo.type == 'undefined' )
					{
						campo.innerHTML= decodeURI(aValor[i]); // para campos label que não possuem value;
					}
					else if( campo.type =='select-one')
					{
						campo.selectedIndex=-1;
						jQuery(campo).val(aValor[i]);
						// verificar se é um select combinado atraves da propriedade parentselect
						if( jQuery(campo).attr('parentselect') )
						{
							parentSelects.push(jQuery(campo).attr('parentselect') );
							// criar  campo temp se não existir
							if( ! campo_temp )
							{
								jQuery(campo).append('<input type="hidden" id="'+campo.id+'_temp" name="'+campo.id+'_temp" value="'+aValor[i]+'">');
								alert( 'Campo tmp criado');
							}
							else
							{
								campo_temp.value = aValor[i];
							}
						}
					}
					else if( campo.type =='radio')
					{
						jQuery('input:radio[name='+aCampo[i]+'][value='+aValor[i]+']').attr('checked',true);
					}
					else if( campo.type == 'checkbox')
					{
						if ( campo.value == aValor[i])
						{
							campo.checked=true;
						}
						else
						{
							campo.checked=false;
						}
					}
					else
					{
						campo.value=decodeURI(aValor[i]);
						fwSetBordaCampo(campo,false,true);
						if( campo_disabled1 )
						{
							try{
								campo_disabled1.value=campo.value;
								fwSetBordaCampo(campo_disabled1,false,true);
							}catch(e){}
						}
						if( campo_disabled2 )
						{
							try{
								campo_disabled2.value=campo.value;
								fwSetBordaCampo(campo_disabled2,false,true);
							}catch(e){}
						}
						if( campo_temp )
						{
							try{
								campo_temp.value=campo.valor;
								fwSetBordaCampo(campo_temp,false,true);
							}catch(e){}
						}
					}
				}
				else
				{
					if( campo.type == 'undefined' )
					{
						campo.innerHTML=''; // para campos label que não possuem value;
					}
					else
					{
						campo.value='';
						if( campo_disabled1)
						{
							try{
								campo_disabled1.value = '';
							}catch(e){}
						}
						if( campo_disabled2)
						{
							try{
								campo_disabled2.value = '';
							}catch(e){}
						}
						if( campo_temp)
						{
							try{
								campo_temp.value = '';
							}catch(e){}
						}
					}
				}
			}
		} catch(e){}
	}
	// disparar os eventos onchange dos selects pai
	if( parentSelects.length > 0 )
	{
		for( key in parentSelects)
		{
			jQuery("#"+parentSelects[key] ).change();
		}
	}
}
//--------------------------------------------------------------------------
function fwMostrarAjuda(arquivo)
{
	if( arquivo )
	{
		//GB_showCenter('Ajuda on-line',arquivo,400,800);
		GB_showFullScreen('Ajuda on-line',arquivo);
	}
	else
	{
		alert('Arquivo de ajuda não disponível');
	}
}
//------------------------------------------------------------------------------
function fwCentralizarObjeto(obj)
{
	var wTotal = document.body.clientWidth;
	var hTotal = document.body.clientHeight;
	var wIframe = parseInt( obj.style.width,10);
	var hIframe = parseInt( obj.style.height,10);
	var t,l;
	t = parseInt( ( hTotal - hIframe)/2,10);
	l = parseInt( ( wTotal - wIframe)/2,10);
	t= t + document.body.scrollTop;
	l= l + document.body.scrollLeft;
	obj.style.top = t;
	obj.style.left= l;
}
//-------------------------------------------------------------------------------------------------------
function fwModalBox(title,url,height,width,callback,data)
{
	data = fwData2Url(data);
	if( top.app_open_modal_window)
	{
		top.app_open_modal_window({url:url, title:title, width:width, height:height, callback:callback,data:data });
	}
	else
	{
		fwOpen_modal_window({url:url, title:title, width:width, height:height, callback:callback,data:data });
	}
}
function fwData2Url(data)
{
	var url='';
	var val='';
	if( typeof data =='object')
	{
		for(key in data)
		{
			url += (url=='') ? '' : '&';
			val = data[key] ?  data[key] : jQuery("#"+key).val();
			url += key+'='+val;
		}
	}
	else if( typeof data == 'string')
	{
		url = data;
	}
	return url;

}
function fwModalBox2(title,url,height,width,callBack,fullscreen)
{
	height 		= height||300;
	width		= width||800;
	if( top.app_modalBox)
	{
		top.app_modalBox(title,url,height,width,callBack,fullscreen)
	}
	else
	{
		if( GB_CURRENT )
		{
			return;
		}
		GB_CURRENT=true;
		if(typeof GB_showCenter == 'undefined' )
		{
			LazyLoad.css(app_url_root+pastaBase+'css/greybox/gb_styles.css',
				function()
				{
					LazyLoad.js(app_url_root+pastaBase+'js/greybox/AJS.js',
						function()
						{
						   LazyLoad.js(app_url_root+pastaBase+'js/greybox/AJS_fx.js',
							function()
							{
							   LazyLoad.js(app_url_root+pastaBase+'js/greybox/gb_scripts.js',
							   function()
								{
										if(typeof GB_showCenter != 'undefined' )
										{
											fwModalBox2(title,url,height,width,callBack,fullscreen);
										}
										else
										{
											alert('não foi possivel carregar a biblioteca graybox!');
										}
								});
							  });
						   });
					});
		}
		else
		{
			if( isIE)
			{
				height += 5;
			}
			if( url.substring(0,3) !='../' && url.substring(0,4)!='http' && url.substring(0,3)!='www' )
			{
				url = app_url_root+url;
				url += ( ( url.indexOf('?')==-1) ? '?' :'&' ) +'modalbox=1&subform=1';
			}

			if( title.indexOf('|')>-1)
			{
				title = title.substr(0,title.indexOf('|'));
			}

			// adicionar o parametro subform=1 para não alterar o modulo atual da sessão
			if( fullscreen )
			{
				GB_showFullScreen(title, url, callBack );
			}
			else
			{
				GB_showCenter(title,url,height,width,callBack);
			}
		// para fechar via js chamar: GB_hide()
		}
	}
}

//-----------------------------------------------------------------------------------
function fwSetSelectedIndex(idCampo,valor)
{
	var obj = fwGetObj(idCampo);
	if( obj )
	{
		for (var i=0;i < obj.length; i++)
		{
			if(obj[i].text == valor)
			{
				obj.selectedIndex=i;
			}
		}
	}
}

/**
 * Simplified way to get the value of a field
 * @param contentId field identifier
 * @returns   value of a field
 */
function fwGetFieldValue(contentId) {
	var result='';
	var elemForm, type, value;
	if( contentId ) {		
		// se não encontrar pelo id, tentar pelo name
		elemForm = fwGetObj(contentId);
		if( !elemForm ){
			// para campos radio
			elemForm = jQuery("input[name='" + contentId + "']" ).get(0);
		}
		if( !elemForm ){
			// para campos check
			elemForm = jQuery("input[name='" + contentId + "[]']" ).get(0);
		}
		
		if( elemForm ){
			type = elemForm.type;
			if (type == 'radio') {
				value = jQuery("input[name='" + elemForm.name + "']:checked" ).val();
				if(value){
					result = value;
				}
			}else{
				result = jQuery("#"+contentId).val();
			}
		}
	}
	return result;
}

/**
*	Fazer o carregamento via ajax de grides
*	phpFile = nome do arquivo php que gera o html do gride
*	idContainer = id do elemento html onde será inserdo o codigo html
*	jsonData = parametros que serão passados para o arquivo phpFile, se for passada uma string
* 	será assumido como a ação a ser executada pelo formulário
* 	obs:se o parametro estiver sem valor definido, a Função tentara encontrar nos campos do formulário
*	Ex: fwGetGrid("gride4.php","campo_gride4",{"num_pessoa":""}); // pegar o valor de num_pessoa no formulario
*	Ex: fwGetGrid("gride4.php","campo_gride4","criar_gride"); // o parametro jsonData como sendo a acao
*/
function fwGetGrid(phpFile,idContainer,jsonData,clearContainer,callback)
{
	clearContainser = clearContainer||false;
	if( jsonData) {
		if( typeof jsonData == 'string') {
			jsonData={'acao':jsonData};
		}
		for (key in jsonData) {
			if(!jsonData[key]) {
				jsonData[key] = fwGetFieldValue(key);
			}
		}
	} else {
		jsonData={};
	}
	jsonData.message = jsonData.message || 'Carregando...';
	jsonData['modulo'] = phpFile;
	jsonData['dataType'] = 'text';
	jsonData['formdin_instance_id'] = jQuery("#formdin_instance_id").val() || '';
	if( !jsonData['gridOffline'] )
	{
		jsonData['ajax'] = 1;
	}
	if( !jQuery("#"+idContainer+" >table").get(0) || clearContainer )
	{
		jQuery("#"+idContainer).html("<center>"+jsonData.message+'<br><img width="190px" height="20px" src="'+pastaBase+'imagens/processando.gif"/><center>');
	}
	jQuery("#"+idContainer).load(app_url+app_index_file,jsonData,function(res)
	{
		if( res == 'fwSession_expired' || res.indexOf('oci_parse()') >-1 )
		{
			alert( 'Sessão encerrada. Clique Ok para reiniciar!');
			fwApplicationRestart();
			return;
		}

		if( typeof callback == 'string' )
		{
			if( callback.indexOf('(') == -1)
			{
				callback+='()';
			}
			eval(callback+';');
		}
		else if( typeof callback == 'function' )
		{
			callback.call();
		}

	});
}
//------------------------------------------------------------------------------
function fwGridCheckUncheckAll(checkbox,field,ev)
{
    var onoff = jQuery(checkbox).attr('onoff');
    var changed = 0;
    if( !onoff || onoff=='off' )
    {
	    onoff='off';
    }
	jQuery('input:checkbox').each(
		function()
		{
			if( this.id.indexOf(field+'_')==0 )
			{
				if( !this.disabled)
				{
					changed=false;
				    if( ! this.checked && onoff=='off')
				    {
				     	changed=1;
					}
				    else if( this.checked && onoff =='on')
				    {
				    	changed=2;
					}
					if( changed )
					{
						this.checked = (changed==1);
						if( this.onclick   )
						{
							this.onclick();
						}
					}
				}
			}
		});
		if(onoff=='on')
		{
		    jQuery(checkbox).attr('onoff','off');
		}
		else
		{
		    jQuery(checkbox).attr('onoff','on');
		}
		try{ev.preventDefault();}catch(e){}
	    try{ev.stopPropagation();}catch(e){}
	    try{ev.returnValue=false;}catch(e){}
}

//-------------------------------------------------------------------------------------
function fwCallOnlineSearch(field,event)
{
	var rcode = (window.Event) ? event.which : event.keyCode;
	if( rcode == 13)
	{
		try{
			fwGetObj(field.id+'_search').onclick()
		} catch(e){};
		fwCancelEvent(event );
	}
}
//---------------------------------------------------------------------------------------
// validar hora
function fwValidarHora( campo, hora, mask, min, max, msg )
{
	//^([0-1][0-9]|[2][0-3]):[0-5][0-9]$
	if( ! hora )
	{
		return true;
	}
	var aHora = hora.split(':');
	var erro=false;
	mask = mask || 'hm';
	if( mask =='hm' && hora.length != 5 )
	{
		erro = true;
	}
	if( mask =='hms' && hora.length != 8 )
	{
		erro = true;
	}

	if ( aHora[0] > 24 || aHora[0] < 0  )
	{
		erro= true;
	}
	if (aHora[1]>59 || aHora[1] < 0)
	{
		erro=true;
	}
	if( aHora[2] && ( aHora[2]>59 || aHora[2] < 0 ))
	{
		erro = true;
	}
	if( erro)
	{
		if( campo )
		{
			campo.style.borderColor=globalCorBordaCampoErro;
		}
		if( msg )
		{
			alert(msg);

		}
		return erro;
	}
	// validar intervalo
	msg=null;
	if( min && (hora < min ) )
	{
		if (max)
		{
			msg='Data deve estar entre '+min+ ' e '+max;
		}
		else
		{
			msg='Data deve MAIOR ou IGUAL a '+min;
		}
		erro=true;
	}
	if( max && (hora > max ) )
	{
		if( min )
		{
			msg='Data deve estar entre '+min+ ' e '+max;
		}
		else
		{
			msg='Data deve ser MENOR ou IGUAL a '+max;
		}
		erro=true;
	}
	if( msg )
	{
		alert( msg );
		campo.style.borderColor=globalCorBordaCampoErro;
	}
	return erro;
}
//----------------------------------------------------------------------------------------
// Remover as tags html de um texto
function fwStripTags(s)
{
	return s.replace(/<.*?>/g, "");
}
//------------------------------------------------------------------------------------------
function fwGetTecla(event)
{
	if ( window.event )
	{
		return window.event.keyCode;
	}
	else
	{
		return event.which;
	}
	return 0;
}
//-------------------------------------------------------------------------------------------------
/**
 * @deprecated
 */
function fwSet_position(element,position)
{
	fwSetPosition(element,position);
}
function fwSetPosition(element,position)
{
	// position pode ser: tl, tc, tr, cl, cc, cr, bl, bc, br e o padrão ? tc
	position = position || 'tc';
	var topReference=0;
	try
	{
		if( jQuery("#div_main_menu").offset().top )
		{
			topReference 	= parseInt(jQuery("#div_main_menu").offset().top) + parseInt(jQuery("#div_main_menu").height() );
		}
	} catch(e) {}
	var appWidth 		= parseInt(jQuery('body').width());
	var appHeight 		= parseInt(jQuery('body').height());
	var scrollTop		= jQuery(document).scrollTop();
	try
	{
		if( jQuery('#app_footer_message').offset().top )
		{
			var appHeight  		= parseInt(jQuery('#app_footer_message').offset().top) - 6 - topReference;
		}
	}
	catch(e) {}
	var eleWidth		= parseInt(jQuery('#'+element).width());
	var eleHeight		= parseInt(jQuery('#'+element).height());
	var top	=0;
	var left=0;
	switch(position.toLowerCase())
	{
		case 'tl':
			break;
		//------------------------------------------------
		case 'tc':
			left	= (appWidth - eleWidth) / 2;
			break;
		//------------------------------------------------
		case 'tr':
			left	= (appWidth - eleWidth);
			break;
		//------------------------------------------------
		//------------------------------------------------
		case 'cl':
			top		= (appHeight - eleHeight) / 2;
			left	= 0
			break;
		//------------------------------------------------
		case 'cc':
			top		= (appHeight - eleHeight) / 2;
			left	= (appWidth - eleWidth) / 2;
			break;
		//------------------------------------------------
		case 'cr':
			top		= (appHeight - eleHeight) / 2;
			left	= (appWidth - eleWidth);
			break;
		//------------------------------------------------
		//------------------------------------------------
		case 'bl':
			top	= (appHeight- eleHeight)
			break;
		//------------------------------------------------
		case 'bc':
			top	= (appHeight- eleHeight)
			left	= (appWidth - eleWidth) / 2;
			break;
		//------------------------------------------------
		case 'br':
			top	= (appHeight- eleHeight)
			left	= (appWidth - eleWidth);
			break;
	}
	if( top>=0 && left>=0)
	{
		jQuery('#'+element).css('position','absolute');
		jQuery('#'+element).css('top',topReference + top + scrollTop );
		jQuery('#'+element).css('left',left);
	}
}
//--------------------------------------------------------------------------------------
/*
Função para desabilitar a cobinação de teclas "ctrl + tecla"
O parametro teclas deve ser as teclas separadas por virgula. Ex: v,c,x
exemplo: adicionar no evento onKeyPress do campo a chamada: onKeyPress="fwDisableCtrlKey(event,'v')" para desabilitar o ctrl+v
*/
function fwDisableCtrlKey(evt,teclas,field)
{
	var teclasProibidas;
	var key;
	var isCtrl;
	if( teclas )
	{
		teclasProibidas = teclas.split(',');
	}
	else
	{
		//Lista de todas as combina??es de CTRL + key que voce quer desativar
		teclasProibidas = new Array('a', 'n', 'c', 'x', 'v', 'j');
	}
	if(window.event)
	{
		key = window.event.keyCode;     //IE
		if(window.event.ctrlKey)
			isCtrl = true;
		else
			isCtrl = false;
	}
	else
	{
		key = evt.which;     //firefox
		if(evt.ctrlKey)
			isCtrl = true;
		else
			isCtrl = false;
	}
	if(isCtrl)
	{
		for(i=0; i < teclasProibidas.length; i++)
		{
			if(teclasProibidas[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
			{
				key=0;


				if (!evt)
				{
					evt = window.event
				}
				if( evt.cancelBubble)
				{
					evt.cancelBubble = true;
				}
				if (evt.stopPropagation)
				{
					evt.stopPropagation();

				}
				if( field )
				{
					if( field.type == 'password')
					{
						window.setTimeout("fwGetObj('"+field.id+"').value=''",10);
						field.focus();
					}
				}
				return false;
			}
		}
	}
	return true;
}
//-------------------------------------------------------------------------------------
/*
Cancela a tecla F5 para evitar o carregamento da página.
*/
function fwCancelRefresh(event,reload)
{
	// keycode for F5 function
	if (window.event )
	{
		if ( window.event.keyCode == 116 )
		{
			window.event.keyCode = 8;
			// keycode for backspace
			if (window.event && window.event.keyCode == 8)
			{
				// try to cancel the backspace
				window.event.cancelBubble = true;
				window.event.returnValue = false;
				if( reload)
				{
					window.location.reload();
				}
			}
		}
	}
	else if( event.which )
	{
		if( event.which == 116 )
		{
			event.which = 8;
			if (event.stopPropagation)
			{
				event.stopPropagation();
			}
			if( event.cancelBubble)
			{
				event.cancelBubble = true;
			}
			if( event.preventDefault)
			{
				event.preventDefault();
			}
			if( reload)
			{
				window.location.reload();
			}
		}
	}
	return false;
}
/**
*	Função para preenchimento de campos do tipo combobox ( select ) utilizando chamada assincrona ajax
*
*	Ex: fwFillSelectAjax("tip_bioma2","bioma","COD_BIOMA","NOM_BIOMA","200","myCallback","-- biomas --","-1","tip_bioma|COD_BIOMA","",0,0)
*	Se for especificada a Função de callback, esta receber? o id do campo select informado
*
*	@param selectId
*	@param packageFunctionTable
*	@param keyColumn
*	@param descColumn
*	@param initialValue
*	@param callBackFunction
*	@param firstOptionText
*	@param firstOptionValue
*	@param formWhereField
*	@param loadingMessage
*	@param cacheTime
*	@param debug
*/
function fwFillSelectAjax(selectId, packageFunctionTable, keyColumn, descColumn, initialValue, callBackFunction, firstOptionText, firstOptionValue, formWhereField, loadingMessage, cacheTime, debug)
{
	var where 	= '';
	var columns	= '';
	var opt;
	var debug = debug||0
	var objSelect;
	if( typeof( selectId )=='string' )
	{
		objSelect = fwGetObj( selectId );
	}
	else
	{
		objSelect = selectId;
	}
	// limpar o campo select
	fwLimparOpcoesSelect(objSelect);
	if( !selectId)
	{
		alert('Parametro selectId da Função fwFillSelectAjax() deve ser informado!');
		return null;
	}
	if( !packageFunctionTable)
	{
		alert('Parametro packageFunctionTable da Função fwFillSelectAjax() deve ser informado!');
		return null;
	}
	// adicionar texto carregando
	opt = new Option((loadingMessage||'Carregando...'),'');
	objSelect.options[0] = opt;
	// desabilitar o campo
	objSelect.disabled=true;
	// ler os valores dos campos do formulario para compor a expressão where
	if ( formWhereField )
	{
		var aTemp1 = formWhereField.split(',');
		for( var i=0;i<aTemp1.length;i++)
		{
			var aTemp2 = aTemp1[i].split('|');
			aTemp2[1] = aTemp2[1] || aTemp2[0];
			var f = fwGetObj(aTemp2[0]);
			if( f && f.value )
			{
				if( where !='' )
				{
					where+=',';
				}
				where += '"'+aTemp2[1]+'":"'+f.value+'"';
			}
		}
		where = '{'+where+'}';
	//alert( where );
	}
	if( !keyColumn && descColumn )
	{
		keyColumn = descColumn;
		descColumn= null;
	}
	keyColumn	= keyColumn || '';
	descColumn	= descColumn|| '';
	orderBy		= ''
	if( keyColumn != '')
	{
		columns = keyColumn;
		if( descColumn != '')
		{
			columns += ','+descColumn;
			orderBy = descColumn;
		}
	}
	var dadosJson = {
		modulo:pastaBase+'callbacks/sql2json.php'
		,
		ajax:"1"
		,
		table:packageFunctionTable
		,
		columns:columns
		,
		where:where
		,
		orderBy:orderBy
		,
		cacheTime:(cacheTime||"0")
		,
		debug:debug
	};
	jQuery.post('?', dadosJson, function(data)
	{
		if( debug )
		{
			keyColumn=null;
			descColumn=null;
		}
		if( data )
		{
			data=String(data).trim(); // remover espaços do inicio e fim da string para evitar erro no eval()
		}
		fwFillSelectJson( selectId,data,keyColumn,descColumn,initialValue,firstOptionText, firstOptionValue);
		if( callBackFunction )
		{
			// retirar os parenteses "()" do nome da funcao
			var i=callBackFunction.indexOf('(');
			if( i > -1)
			{
				callBackFunction = callBackFunction.substr(0,i);
			}
			callBackFunction = callBackFunction+'(selectId)';
			// executar a Função de callback
			try{
				eval(callBackFunction+';')
			} catch(e){
				alert( 'Erro na CallBackFunction:'+callBackFunction+"\n\n"+e.message )
			}
		}
	});
}

/**
* Função para preenchimento de campos do tipo combobox (select) a partir de dados no formato json {key:value}
*
* @param selectId
* @param jsonString
* @param keyField
* @param descField
* @param initialValue
* @param firstOptionText
* @param firstOptionValue
*/
function fwFillSelectJson(selectId, jsonString, keyField, descField, initialValue,firstOptionText, firstOptionValue )
{
	selectId = fwGetObj( selectId );
	var objSelect;
	var data;
	if( typeof( selectId )=='string' )
	{
		objSelect = fwGetObj( selectId );
	}
	else
	{
		objSelect = selectId;
	}
	objSelect.disabled=false;
	fwLimparOpcoesSelect(objSelect);
	if( jsonString == '[]')
	{
		return;
	}
	if( typeof jsonString == 'string')
	{
		try {
			eval('var data='+jsonString);
		} catch(e){
			return;
		}
	}
	else if( typeof jsonString == 'object')
	{
		data = jsonString;
	}
	if (!data)
	{
		return;
	}
	for ( key in data )
	{
		if(!keyField)
		{
			keyField = key;
		} else if(!descField)
{
			descField=key;
			break;
		}
	}

	if( firstOptionText )
	{
		firstOptionValue = firstOptionValue || '';
		var opt = new Option(firstOptionText,firstOptionValue);
		objSelect.options[objSelect.options.length] = opt;
	}
	descField = descField || keyField;
	if( data )
	{
		if( !data[keyField])
		{
			keyField=keyField.toUpperCase();
		}
		if( !data[descField])
		{
			descField=descField.toUpperCase();
		}
		if( !data[keyField])
		{
			keyField=keyField.toLowerCase();
		}
		if( !data[descField])
		{
			descField=descField.toLowerCase();
		}
		if( !data[keyField])
		{
			//alert('Campo chave '+keyField+' não existe');
			return;
		}
		if( !data[descField])
		{
			//alert('Campo descricao '+descField+' não existe');
			return;
		}
	}
	for (key in data[keyField])
	{
		if( typeof data[descField][key] == 'string')
		{
			var opt = new Option(data[descField][key],data[keyField][key]);
			objSelect.options[objSelect.options.length] = opt;
			if( initialValue &&  data[keyField][key] == initialValue)
			{
				opt.selected=true;
			}
		}
	}
}

//---------------------------------------------------------------------------------------------
function fwUnblockUI()
{
	if( top.app_unblockUI )
	{
		top.app_unblockUI();
	}
	else
	{
		jQuery.unblockUI();
	}
}

function fwBlockUI(message,callback,imgWait,imgWidth,imgHeight,opacity,messageColor,backgroundColor,timeout,overlayColor)
{
	if( top.app_blockUI )
	{
		top.app_blockUI(message,callback,imgWait,imgWidth,imgHeight,opacity,messageColor,backgroundColor,timeout,overlayColor);
		return;
	}
	if( uiBlocked )
	{
		return;
	}
	message			= message || '';
	opacity 		= opacity||0.2;
	imgWait 		= imgWait||'<img style="border:none;" src="'+pastaBase+'imagens/fwProcessing.gif"/>';
	messageColor 	= messageColor||'#000000';
	backgroundColor = backgroundColor||'#efefef';
	timeout			= timeout||0;
	overlayColor	= overlayColor || '#000000';
	uiBlocked:true;
	if( message && imgWait)
	{
		message+='<br>';
	}
	jQuery.blockUI({
			message: message+imgWait
			,timeout: timeout
			,fadeIn: 0
			,fadeOut:0
			,css:{ 'backgroundColor': '#efefef'
				,'color':'#000000'
				,'-webkit-border-radius': '10px'
				,'-moz-border-radius': '10px'
				,'border-radius':'15px'
				,'border':'2px solid #000000'
				,'padding': '5px'
				,'font-size':'12px'
				,'font-weight':'bold'
				}
			,overlayCSS:{'opacity':'0.2','backgroundColor':overlayColor}
			,onUnblock:function(e,o)
			{
				uiBlocked = false;
				fwExecutarFuncao(callback,e);
			}});
}

//---------------------------------------------------------------------------------------------
function fwBlockScreen( maskColor, opacity, imgWait, txtWait, imgWidth, imgHeight,txtColor)
{
	if( top.jQuery && typeof top.jQuery.blockUI == 'function' )
	{
		fwBlockUI( txtWait, null, imgWait, imgWidth, imgHeight, opacity, txtColor,null,null,maskColor);
		return;

	}

	// se tiver rodando dentro de um iframe, executar o bloqueio pela pagina pai
	if( top.app_blockScreen )
	{
		top.app_blockScreen ( maskColor, opacity, imgWait, txtWait, imgWidth, imgHeight, txtColor)
		return;
	}
	var div 	= document.getElementById('blockScreenDiv');
	maskColor 	= maskColor	|| '#333333';
	imgWidth	= imgWidth 	|| '';
	imgHeight	= imgHeight || '';
	txtColor	= txtColor	|| '#ffffff'
	opacity 	= opacity || 60;
	if( !div)
	{
		jQuery('body').append('<div id="blockScreenDiv" class="fwBlockScreenDiv"><table width="100%" height="100%"><tr><td id="tdBlockScreen" align="center" valign="middle"></td></tr></table></div>');
	}
	div = jQuery('#blockScreenDiv');
	if( div.get(0) )
	{
		div.css('background-color',maskColor);
		jQuery('#tdBlockScreen').html('');
		div.css('filter', "alpha(opacity="+opacity+")");
		div.css('opacity',opacity/100);
		if( imgWait )
		{
			jQuery('#tdBlockScreen').append('<img class="fwImgBlockScreen" src="'+imgWait+'"'
				+(imgWidth!='' ? ' width="'+imgWidth+'"':"")
				+(imgHeight!='' ? ' height="'+imgHeight+'"':"")+">");
		}
		if( txtWait )
		{
			var css='';
			if( txtColor)
			{
				css = 'style="color:'+txtColor+';"';
			}
			jQuery('#tdBlockScreen').append('<br/><span class="fwTxtBlockScreen"'+css+'>'+txtWait+'</span>');
		}
		div.css('display','block');
	}
}
//------------------------------------------------------------------------------------------------
function fwUnBlockScreen()
{
	if( top.app_unBlockScreen )
	{
		top.app_unBlockScreen();
		return;
	}
	if( typeof jQuery.unblockUI == 'function')
	{
		jQuery.unblockUI();
		return;
	}
	var div = document.getElementById('blockScreenDiv');
	if( div )
	{
		div.style.display='none';
	}
}
//---------------------------------------------------------------------------------------------
function fwUTF8_decode(str_data)
{
	// http://kevin.vanzonneveld.net
	// +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
	// +      input by: Aman Gupta
	// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// *     example 1: utf8_decode('Kevin van Zonneveld');
	// *     returns 1: 'Kevin van Zonneveld'

	var tmp_arr = [], i = ac = c = c1 = c2 = 0;

	while (i < str_data.length) {
		c = str_data.charCodeAt(i);
		if (c < 128) {
			tmp_arr[ac++] = String.fromCharCode(c);
			i++;
		}
		else
		if ((c > 191) && (c < 224)) {
			c2 = str_data.charCodeAt(i + 1);
			tmp_arr[ac++] = String.fromCharCode(((c & 31) << 6) | (c2 & 63));
			i += 2;
		}
		else {
			c2 = str_data.charCodeAt(i + 1);
			c3 = str_data.charCodeAt(i + 2);
			tmp_arr[ac++] = String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
			i += 3;
		}
	}
	return tmp_arr.join('');
}
//-------------------------------------------------------------------------------------------------------------

function fwConfirmOld(message, callbackYes, callbackNo, yesLabel, noLabel, titleLabel)
{

	yesLabel	= yesLabel||'Sim';
	noLabel		= noLabel||'não';
	titleLabel	= titleLabel||'Confirmação';

	jQuery.alerts.okButton        = yesLabel;
	jQuery.alerts.cancelButton    = noLabel;
	jConfirm(message, titleLabel
	,function(r)
	{
		if( r == true )
		{
			fwExecutarFuncao(callbackYes,true)
		}
		else if( r == false )
		{
			if (jQuery.isFunction(callbackNo))
			{
				callbackNo.call(false);
			}
			else if (jQuery.isFunction(callbackYes))
			{
				callbackYes.call(false);
			}
		}
	});
}
function fwConfirm2(message, callbackYes, callbackNo, yesLabel, noLabel, titleLabel) {
	yesLabel	= yesLabel||'Sim';
	noLabel		= noLabel||'não';
	titleLabel	= titleLabel||'Confirmação';

	//jQuery("<div id='confirm'><div class='header'><span>"+titleLabel+"</span></div><div class='message' style='overflow-y:auto;border:none;height:45px;'></div><div class='buttons'><div class='no simplemodal-close'>"+noLabel+"</div><div class='yes'>"+yesLabel+"</div></div></div>").modal({
	jQuery("<div id='confirm'><div class='header'><span>"+titleLabel+"</span></div><div class='message'></div><div class='buttons'><div class='no simplemodal-close'>"+noLabel+"</div><div class='yes'>"+yesLabel+"</div></div></div>").modal({
		closeHTML: ( callbackNo ? "" : "<a href='#' title='Fechar' class='modal-close'>x</a>"),
		position: ["20%",],
		overlayId: 'confirm-overlay',
		containerId: 'confirm-container',
		autoResize :true,
		opacity:50,
		overlayCss: {
			backgroundColor:"#000"
		},
		onOpen: function (dialog)
		{
			dialog.overlay.fadeIn('fast', function ()
			{
				dialog.data.show();
				dialog.container.fadeIn('slow', function ()
				{
					//dialog.data.show('fast');
					});
			});
		},
		onShow: function (dialog) {
			jQuery('.message', dialog.data[0]).append(message);
			// if the user clicks "yes"
			jQuery('.yes', dialog.data[0]).click(function () {
				// call the callback
				if (jQuery.isFunction(callbackYes))
				{
					callbackYes.apply(this,['S']);
				}
				callbackNo=null;
				// close the dialog
				jQuery.modal.close();
			});
		},
		onClose: function (dialog) {
			if (jQuery.isFunction(callbackNo)) {
				try{
					callbackNo.apply(this,['N']);
				}
				catch(e){
					alert( e.message );
				}
			}
			// close the dialog
			jQuery.modal.close();
		}
	});
}

/**
* Abre uma tela bloqueando a tela de baixo no estilo modal
* site: http://chriswanstrath.com/facebox/
*/
function fwFaceBox(content,iframe,height,width,onClose,onShow,css)
{
	// carregar dinamicamente o js e o css do facebox;
	if(typeof jQuery.facebox == 'undefined' )
	{
		LazyLoad.css(pastaBase+'js/jquery/facebox/facebox.css',function()
		{
			LazyLoad.js(pastaBase+'js/jquery/facebox/facebox.js', function ()
			{
				jQuery.facebox.settings.closeImage = pastaBase+'js/jquery/facebox/closelabel.png';
				jQuery.facebox.settings.loadingImage = pastaBase+'js/jquery/facebox/loading.gif';
				fwFaceBox( content,iframe,height,width,onClose,onShow,css);
			})
		});
	}
	else
	{
		var container='';
		if( iframe || content.indexOf('http') == 0 || content.indexOf('www') == 0)
		{
			height	= height || 600;
			width	= width  || 800;
			// container mostra a animação de carregando
			container = '<iframe id="faceBoxIframe" scrolling="auto" frameborder="no" align="center" style="width:'+width+'px;height:'+height+'px;border:0px;padding-right:7px;'+css+'" src="'+pastaBase+'includes/carregando_cinza.html"></iframe>';
			// mostrar a url dentro do iframe em 1 segundo
			content += ( ( content.indexOf('?')==-1) ? '?' :'&' ) +'modalbox=1&subform=1&facebox=1';
			window.setTimeout('jQuery("#faceBoxIframe").attr("src","'+fwAdjustBasePath(content)+'");',300);
		}
		else
		{
			height	= height || 'auto';
			width	= width || 'auto';
			height	+= (height == 'auto') ? '' : 'px';
			width	+= (width == 'auto') ? '' : 'px';
			container = '<div style="width:'+width+';height:'+height+';border:0px;'+css+'">'+content+'</div>';
		}
		if( typeof onShow == 'function' )
		{
			jQuery( document ).bind('reveal.facebox', onShow );
		}
		if( typeof onClose == 'function' )
		{
			jQuery( document ).bind('afterClose.facebox', onClose );
		}
		// retirar o evento onclick do overlay
		jQuery('#facebox_overlay').unbind('click');
		// retirar fechamento com a tecla ESC
		jQuery(document).unbind('keydown.facebox');
		var r = new RegExp("\.jpe?g|\.png|\.gif|\.bmp|\.tif|\.gif");

		//if ( content.indexOf('.png') )
		if( r.test( content ) )
		{
			jQuery.facebox({
				image:content
			});
		}
		else
		{
			jQuery.facebox( container );
		}
	}
}
/**
Função para fechar a faceBox aberta via javascript
*/
function fwFaceBoxClose()
{
	try{
		jQuery.facebox.close();
	}catch(e){}
}
/*
Função para fazer arredondamento de números decimais
*/
function fwRoundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}
/*
Função javascript para recuperar os parametros recebidos via get, equivalente ao $_GET do php. Ex: a=jsRequest('num_pessoa');
*/
function fwJsRequest( name )
{
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null )
		return "";
	else
		return results[1];
}
//------------------------------------------------------------------------------------------
function fwFieldCoordShowMap(id,height,width,jsonParams)
{
	jsonParams = jsonParams || {};
	var h= height || jQuery("body").height()-100;
	var w= width  || jQuery("body").width()-100;
	var url = "?modulo="+pastaBase+"includes/ponto_google_map.php&ajax=1&h=+"+(h-50)+"&prototypeId=&updateField="+id;

    // se o campo estiver readonly via funcao fwReadOnly(), nao permitir clicar no mapa para retornar a coordenada
    if( jQuery("#"+id+"_lat_grau").attr('readonly') == 'readonly' )
    {
    	jsonParams['readonly'] = 'true';
    	jsonParams['mapHeaderText'] = 'Consulta Coordendada Geográfica';
    }

	for( key in jsonParams )
	{
		url += '&'+key+'='+jsonParams[key];
	}
	if( top.app_prototype )
	{
		top.appFaceBox(url,true,h,w,null,null,'overflow:hidden');
	}
	else
	{
		fwFaceBox(url,true,h,w,null,null,'overflow:hidden;');
	}
}

/*
Função para definir o bounding box e o centro do mapa utilizada pelo campo coordenada gerográfica ao exibir o mapa
Formato do parêmetro bounds: {"latMin":"-13,0141881286166","latMax":"-12,7248145057069","lonMin":"-38,6998295398796","lonMax":"-38,2952318041981"}
*/
function fwSetZoomLevelCenter(id, bounds, height, width) {
	if (typeof bounds == "undefined" || bounds.latMin  == "undefined" )
	{
		return false;
	}
	var h = height || jQuery("body").height()-100;
	var w = width  || jQuery("body").width()-100;
	var WORLD_DIM = { height: 256, width: 256 };
	var ZOOM_MAX = 21;

	function latRad(lat) {
		var sin = Math.sin(lat * Math.PI / 180);
		var radX2 = Math.log((1 + sin) / (1 - sin)) / 2;
		return Math.max(Math.min(radX2, Math.PI), -Math.PI) / 2;
	}

	function zoom(mapPx, worldPx, fraction) {
		return Math.floor(Math.log(mapPx / worldPx / fraction) / Math.LN2);
	}

	var latMin=parseFloat(bounds.latMin.replace(/,/,'.'));
	var latMax=parseFloat(bounds.latMax.replace(/,/,'.'));
	var lonMin=parseFloat(bounds.lonMin.replace(/,/,'.'));
	var lonMax=parseFloat(bounds.lonMax.replace(/,/,'.'));
	var latFraction = ( latRad(latMax) - latRad(latMin) ) / Math.PI;

	var lngDiff = lonMax - lonMin;
	var lngFraction = ((lngDiff < 0) ? (lngDiff + 360) : lngDiff) / 360;

	var latZoom = zoom(h, WORLD_DIM.height, latFraction);
	var lngZoom = zoom(w, WORLD_DIM.width, lngFraction);

	jQuery("#"+id+"_map_zoom").val(Math.min(latZoom, lngZoom, ZOOM_MAX));
	jQuery("#"+id+"_map_lon_center").val((lonMax + lonMin)/2);
	jQuery("#"+id+"_map_lat_center").val((latMax + latMin)/2);
}
//--------------------------------------------------------------------------------------------
/*
	Esta Função aumenta a altura do formulário até sumir a barra vertical de scroll
	fwFormDinAutoSize({formId:"formdin",initialHeight:150});
*/
function fwFormDinAutoSize(jsonParams)
{
	jsonParams = jsonParams || {};
	var frmId = null;
	var dif;
	if( jsonParams['formId'] )
	{
		frmId = jsonParams['formId'];
	}
	frmId = frmId||'formdin';
	var initialHeight = jsonParams.initialHeight || null;
	if( initialHeight > 0 )
	{
		fwSetFormHeight(initialHeight);
	}
	var i  = 0;
	var o1 = jQuery('#content_'+frmId); // so existe se o form não estiver flat
	var o2 = jQuery('#body_'+frmId);
	var o3 = jQuery('#'+frmId+'_body');

	// retirar o evento de auto redimensionamento
	if( jQuery("#"+frmId+"_body").bind("overflow") )
	{
		jQuery("#"+frmId+"_body").unbind("overflow");
	}
	/*
	o1.height(74);
	o2.height(69);
	o3.height(15);
	*/
	do
	{
		// posiciona a barra de rolagem no valor máximo
		o3[0].scrollTop = o3[0].scrollTop + o3[0].scrollHeight;
		dif = o3[0].scrollTop;
		if( dif > 0 )
		{
			o1.height(o1.height() + dif );
			o2.height(o2.height() + dif );
			o3.height(o3.height() + dif );
		}
		i++;
		// evitar loop infinito
		if( i > 2 )
		{
			break;
		}
	} while (o3[0].scrollTop > 0 );

	// adicionar o evento de auto redimensionamento
	jQuery("#"+frmId+"_body").bind("overflow",function (e) {
		fwFormDinAutoSize(jsonParams)
	});
	if( jsonParams['winId'])
	{
		parent.app_set_prototype_win({
			winId:jsonParams.winId,
			height:o2.height(),
			force:true
		});
	}
	o3.css('overflow','hidden');
}

/**
 * Função para ajustar a altura do formdin
*/
function fwSetFormHeight(h,frmId,showScrollBar)
{
	frmId = frmId || 'formdin';
	var o1 = jQuery('#content_'+frmId); // so existe se o form não estiver flat
	var o2 = jQuery('#body_'+frmId);
	var o3 = jQuery('#'+frmId+'_body');
	if( o1.get(0) )
	{
		if( h<0)
		{
			h = o1.height() + h;
		}
		o1.height(h);
		o2.height(h-5);
		o3.height(h-59);
	}
	else
	{
		if( h < 0 )
		{
			h = o3.height() + h;
		}
		o3.height(h-45);
		o2.height(o3.height()+53);
	}
	//alert( o3.css('overflow')+'\n'+o3.css('overflow-y') );
	if( showScrollBar )
	{
		o3.css('overflow-y','auto');
	}
	else
	{
		//o3.css('overflow-y','hidden');
	}
}
/**
 * Função para ajustar a largura do formdin
*/
function fwSetFormWidth(w,frmId,showScrollBar)
{
	frmId = frmId || 'formdin';
	var o1 = jQuery('#'+frmId+'_area');
	var o2 = jQuery('#box_'+frmId);
	var o3 = jQuery('#body_'+frmId);
	var o4 = jQuery('#'+frmId+'_header');
	var o5 = jQuery('#'+frmId+'_body');
	if( o2.get(0)) // não está flat
	{
		o1.width(w);
		o2.width(o1.width());
		o3.width(o2.width()-13);
		o4.width(o3.width());
		o5.width(o3.width()-3);
	}
	else // flat
	{
		o1 = jQuery('#'+frmId+'_area');
		o2 = jQuery('#body_'+frmId);
		o3 = jQuery('#'+frmId+'_header');
		o4 = jQuery('#'+frmId+'_body');
		o1.width(w);
		o2.width(o1.width());
		o3.width(o1.width()-70);
		o4.width(o1.width()-5);
	}
	if( showScrollBar )
	{
		o3.css('overflow-x','auto');
	}
	else
	{
		o3.css('overflow-x','hidden');
	}
}

/**
Esta Função é utilizada pela classe TGrid para exportar o dados.
*/
function fwExportGrid2Excel(dadosJson)
{
	var conf;
	var params = '?gride=' + dadosJson.id+'&title='+dadosJson.title;
	if( isIE )
	{
		conf = "height=0,width=0,status=no,toolbar=no,menubar=no,location=no,top=0,left=0";
	}
	else
	{
		var conf = "height=0,width=0,status=0,toolbar=0,menubar=0,location=0,top=0,left=0";
	}

	if( dadosJson.head )
	{
		if( typeof dadosJson.head == 'object')
		{
			var o,v;
			var p=[];
			for (key in dadosJson.head )
			{
				o = null;
				try
				{
					o = jQuery('#'+dadosJson.head[key]).get(0);
				}
				catch(e){}
				if( o )
				{
					//alert( o.type);
					if( o.type =='select-one' || o.type =='select-multiple' )
					{
						v = [];
						jQuery('#'+dadosJson.head[key]+' :selected').each(function(i, selected)
						{
							v.push(jQuery(selected).text());
						});
						// exibir os valores do multi-select separados por barra "/"
						v = v.join('/');
					}
					else
					{
						v = o.value;
					}
					v = ( v == '-- selecione --') ? '' : v;
					v = ( v == '' ? 'Todos' : v);
					if( v )
					{
						p.push('w_'+key+'='+v);
					}
				}
			}
			if( p.length > 0 )
			{
				params += '&' + p.join( '&' );
			}
		}
	}
	// ler checkboxex marcados no grid ( colunas checkbox )
	var checkboxes = {};
	var line=0;
	jQuery("#"+ dadosJson.id+" input[type='checkbox']").each(
		function()
		{
			colIndex = jQuery(this).parent().attr('column_index');
			if( colIndex )
			{
				colIndex--;
				if( typeof checkboxes[ colIndex ] == 'undefined' )
				{
					checkboxes[colIndex] = { "dados":[] };
				}
				if( this.checked )
				{
					if( !isNaN(colIndex))
					{
                		checkboxes[colIndex].dados.push(line)
					}
				}
				line++;
			}
		}
	)
	// ler radio marcados no grid ( colunas radiobutton )
	var radiobuttons = {};
	var line=0;
	jQuery("#"+ dadosJson.id+" input[type='radio']").each(
		function()
		{
			colIndex = jQuery(this).parent().attr('column_index');
			if( colIndex )
			{
				colIndex--;
				if( typeof radiobuttons[ colIndex ] == 'undefined' )
				{
					radiobuttons[colIndex] = { "dados":[] };
				}
				if( this.checked )
				{
					if( !isNaN(colIndex))
					{
                		radiobuttons[colIndex].dados.push(line)
					}
				}
				line++;
			}
		}
	)
	var iframe = jQuery("#fwIframeTemp");
	if( iframe.length == 0 )
	{
		jQuery('<iframe id="fwIframeTemp" style="display:none;" src="about:blank;position:absolute;top:-5000;"></iframe>').appendTo("body");
		iframe = jQuery("#fwIframeTemp");
	}
 	params+='&ajax=1&modulo='+pastaBase+'classes/FormDin4.xls.php';
	if( JSON.stringify( checkboxes ) != '{}' )
	{
		params+='&checkboxes='+JSON.stringify( checkboxes );
	}
	if( JSON.stringify( radiobuttons ) != '{}' )
	{
		params+='&radiobuttons='+JSON.stringify( radiobuttons );
	}
	params = params.replace(/\{\}/g,'');
	if( iframe.get(0))
	{
		iframe.attr('src',app_index_file+params);
	}
	else
	{
		var winTemp = window.open( app_index_file+params,"winTemp",conf);
	}
}
//--------------------------------------------------------------------------------------
// funções Genéricas para utilização com dhtmlx Tree
function fwTreeAddLoading(tree,id)
{
	if( id )
	{
		if( !tree.getIndexById(id+'loading') )
		{
			tree.insertNewChild(id,id+'_loading','Carregando...',0,'loader.gif',0,0,'SELECT');
			tree.setItemStyle(id+'_loading','color:#FFFFC0;background-color:#969696');
			//tree.setItemStyle(id+'_loading','background-color:#969696');
		}
	}
}
//--------------------------------------------------------------------------------------
function fwTreeRemoveLoading(tree,id)
{
	if( id )
	{
		tree.deleteItem(id+'_loading',true);
	}
}
//--------------------------------------------------------------------------------------
function fwUrlAddParams(url,formFields)
{
	var p='';
	var v='';
	for( key in formFields)
	{
		v = formFields[key];
		if( !v )
		{
			v = jQuery("#"+key).val();
		}
		if( v )
		{
			p += ( (p=='') ? '&' : '');
			p += '_w_'+key+'='+v;
		}
	}
	//alert( url+p);
	return url+p;
}
/**
	Função para desabilitar abas da classe TPageControl via javascript
	O parametro pc é opcional e se for omitido será considerado o nome do
	primeiro grupo de abas da pagina
*/
function fwDesabilitarAba(aba,pc)
{
	if( !pc )
	{
		pc = jQuery('a[pagecontrol]:first').attr('pagecontrol');
	}
	if( pc )
	{
		try
		{
			pc 	= pc.toLowerCase();
			aba = aba.toLowerCase();
			jQuery('#'+pc+'_container_page_'+aba+'_span').css('color','#A9A9A9');
			//fwGetObj(pc+'_container_page_'+aba+'_link').onclick=null;
			jQuery('#'+pc+'_container_page_'+aba+'_link').attr('tabDisabled','1');
		} catch(e) {}
	}
}
/**
	Função para habilitar abas da classe TPageControl via javascript
	O parametro pc é opcional e se for omitido será considerado o nome do
	primeiro grupo de abas da pagina
*/
function fwHabilitarAba(aba,pc)
{
	if( !pc )
	{
		pc = jQuery('a[pagecontrol]:first').attr('pagecontrol');
	}
	if( pc )
	{
		try
		{
			pc 	= pc.toLowerCase();
			aba = aba.toLowerCase();
			jQuery('#'+pc+'_container_page_'+aba+'_link').attr('tabDisabled','0');
			//fwGetObj(pc+'_container_page_'+aba+'_link').onclick=function(e){fwSelecionarAba(this)};
			jQuery('#'+pc+'_container_page_'+aba+'_span').css('color','');
		} catch(e) {}
	}
}
//--------------------------------------------------------------------------------------------------
/**
Função para inicializar o tooltip das imagens com o atributo "tooltip" definidos na classe TDisplayControl
*/
function fwAttatchTooltip( config )
{
	if( typeof config == 'string' )
	{
		return;
	}
	config = config || {};
	config.container = ( config.container ? '#'+config.container : config.container );
	config.container = config.container || '*';
	//jQuery(config.container + " [tooltip='true']").tooltip({
	//jQuery("img").tooltip({
	jQuery("* [tooltip='true']").tooltip({
		track: true,
		delay: 0,
		showURL: false,
		showBody: ' - ',
		fade: 250
	});
	return true;
}
//------------------------------------------------------------------------------------------------------
function fwShowBlob(table_name, blob_column_name, file_column_name, key_column_name, key_value, width, height, file_extension, dialog_name, dialog_title )
{
	width			= width  || 800;
	height			= height || 600;
	file_column_name= file_column_name || '';
	file_extension	= file_extension  || 'pdf';
	dialog_title	= dialog_title || 'Visualizar Anexo';
	var url = app_url+app_index_file+'?ajax=1&pastaBase='+pastaBase+'&modulo='+pastaBase+'includes/downloadAnexo.php&table_name='+table_name+'&blob_column_name='+blob_column_name+'&file_column_name='+file_column_name+'&key_column_name='+key_column_name+'&file_extension='+file_extension+'&key_value='+key_value;
	if( dialog_name )
	{
		dialog_name		= dialog_name   || 'win';
		window.open(url, dialog_name,'toolbar=no,location=no,scrollbars=yes,width='+width+',height='+height+',top=10,left=10');
	}
	else
	{
		fwModalBox(dialog_title,url,height,width,null,true);
	}
}
/**
Função para calcular a idade em anos.
@param string data - data de nascimento
@param mixed updateField - campo ou nome do campo que será atualizado com a idade ( opcional )
*/
function fwGetAge( birthDate, updateField )
{
	if( updateField )
	{
		if( typeof updateField == 'object')
		{
			updateField.value = '';
		}
		else
		{
			fwAtualizarCampos(updateField,'');
		}
	}
	// data atual
	today = new Date()
	var array_birthDate = birthDate.split("/")
	//se o array nao tem tres partes, a data está errada
	if (array_birthDate.length != 3 )
		return '';

	//comprovo que o ano, mes, dia são corretos
	var year = parseInt(array_birthDate[2]);
	if (isNaN(year))
		return ''

	var month = parseInt(array_birthDate[1]);
	if (isNaN(month))
		return ''

	var day = parseInt(array_birthDate[0]);
	if (isNaN(day))
		return ''

	//se o ano da data que recebo so tem 2 cifras temos que muda-lo a 4
	if ( year <= 99 )
	{
		year  += 1900
	}
	//subtraio os anos das duas datas
	age=today.getFullYear()- year - 1; //-1 porque ainda nao fez anos durante este ano

	//se subtraio os mes e for menor que 0 entao nao cumpriu anos. Se for maior sim ja cumpriu

	if (today.getMonth() + 1 - month >= 0) //+ 1 porque os meses comecam em 0
	{
		if (today.getMonth() + 1 - month > 0)
		{
			age++;
		}
		else  if (today.getUTCDate() - day >= 0)
		{
			//entao eh porque sao iguais. Vejo os dias
			//se subtraio os dias e der menor que 0 entao nao cumpriu anos. Se der maior ou igual sim que já cumpriu
			age++
		}
	}
	if( updateField )
	{
		if( typeof updateField == 'object')
		{
			updateField.value = age;
		}
		else
		{
			fwAtualizarCampos(updateField,age);
		}
	}
	return age
}
//-----------------------------------------------------------------------------
function fwSetFormAlignment(vertical,horizontal)
{
	if( vertical )
	{
		jQuery("#data_content").attr("valign",vertical);
	}
	if( horizontal )
	{
		jQuery("#data_content").attr("align",horizontal);
	}
}
//-------------------------------------------------------------------------------------------
/**
Função para ajustar o caminho da pasta base das urls
*/
function fwAdjustBasePath(url)
{
	if( ( url.indexOf('base/') > -1 ) && pastaBase && url.indexOf( app_index_file ) == -1 && url.indexOf('?') != 0  )
	{
		url	= pastaBase + url.substring(url.indexOf('base/')+5);
	}
	return url
}
/*
Função para limpar todos os campos filhos
*/
function fwClearChildFields( parentId,except )
{
	except = ( except ? ','+except + ',' : null);
	if( except )
	{
		// adicionar os campos disabled na lista
		var aTemp = except.split(',');
		except=',';
		for( key in aTemp)
		{
			if( aTemp[key] )
			{
				if( aTemp[key].indexOf('_disabled')==-1)
				{
					except += aTemp[key]+','+aTemp[key]+'_disabled,';
				}
			}
		}
	}
	if( parentId )
	{
		if( jQuery("#"+parentId).length == 0)
		{
		 	parentId = parentId.toLowerCase();
		}
	}
	jQuery( (!parentId ? "*" : "#"+parentId+" *") ).each( function()
	{
		var type 	= this.type;
		var tag 	= this.tagName.toLowerCase();
		var id 		= this.id;
		var fieldType = this.getAttribute('fieldtype');
		if( id != '' )
		{
			id = String(id).toLowerCase();
			if( ( ! except || except.indexOf( ',' + id + ',') == -1 ) && this.getAttribute('noClear') != 'true' )
			{
				if (type == 'text' || type == 'hidden' || type == 'password' || tag == 'textarea')
				{

					if( fieldType == 'fileasync')
					{
						fwClearFileAsync(id.replace('_disabled',''));
					}
					else if( fieldType == 'color')
					{
						this.value = '';
						jQuery("#"+id+"_preview").css('background-color','transparent');
					}
					this.value = '';
				}
				else if (type == 'checkbox' || type == 'radio')
					this.checked = false;
				else if (tag == 'select')
				{
					this.selectedIndex = -1;
					if ( this.options.length > 0 && ( this.options[0].value=='' || this.getAttribute('needed') == 'true' )  )
					{
						this.selectedIndex = 0;
					}
				}
			}
		}
	}
	);
}
//-------------------------------------------------------------------------------------
/*
Função para formatar números adicionando pontos a cada 3 digitos e
retornando a virgula como separador decimal se o numero não for inteiro
Ex:
	fwAddPoints('123456') 		-> 123.456
	fwAddPoints('1,234.56') 	-> 1,234.56
	fwAddPoints('1.234,566')	-> 1,234.566
	fwAddPoints('1234.56')		-> 1.234,56
	fwAddPoints('1234,56')		-> 1.234,56
*/
function fwAddPoints(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? ',' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return x1 + x2;
}

function fwApplicationRestart(message,clearModule)
{
	if ( typeof top.app_restart =='function')
	{
		top.app_restart(message,clearModule);
	}
	else
	{
		if ( typeof parent.app_restart =='function')
		{
			parent.app_restart(message,clearModule);
		}
		else
		{
			if( message )
			{
				alert( message );
			}
			location.href=app_url+app_index_file;
		}
	}
}
function fwApplicationEnd()
{
	if ( typeof top.app_login =='function')
	{
		top.app_login();
	}
	else
	{
		if ( typeof parent.app_login =='function')
		{
			parent.app_login();
		}
		else
		{
			location.href=app_url+app_index_file+'?module=session_destroy';
		}
	}
}

function fwClose_window( winId )
{
	if ( winId )
	{
		if( typeof top.app_close_window == 'function')
		{
			top.app_close_window( windId );
		}
		else if (Windows.getWindow(winId))
		{
			Windows.getWindow(winId).close();
		}
	}
	else if( typeof top.app_close_modal_window =='function' )
	{
		top.app_close_modal_window();
	}
	else
	{

	}

}
function fwCancelEvent(event)
{
	if (window.event )
	{
		window.event.cancelBubble = true;
		window.event.returnValue = false;
	}
	else if( event.which )
	{
		if (event.stopPropagation)
		{
			event.stopPropagation();
		}
		if( event.cancelBubble)
		{
			event.cancelBubble = true;
		}
		if( event.preventDefault)
		{
			event.preventDefault();
		}
	}
	return false;
}

/**
 * Valida o preenchimento do form
 * ## Se quiser validar campos especificos passe eles como parametro config JSON
 * como string e seprarados por virgura
 * EX: fwValidateForm{"fields":"num_pessoa,dat_nasc"}
 * ## Para validar um form especifico informe o id do form no config json
 * EX: fwValidateForm{"formName":"formdin_2"}
 *
 * @todo add config: exetoCampos, msg no topo, validar aba especifica
 * -retorna true se estiver ok
 * -retorna false + mensagens de erro se não estiver ok
*/
function fwValidateForm(config)
{
	var msgErroJS = '';
	var numErros = 0;
	var campoRadio = new Array();
	var formName=null;
	// considerar sempre o último form da pagina
	var objForm = jQuery("form");
	if( objForm.length > 0 )
	{
		objForm = objForm.get(  objForm.length - 1 );
	}
	else
	{
		return true;
	}
	if( objForm )
	{
		formName = objForm.name;
	}

	var fields = null;
	var ignoreFields=null;
	var val;
	if(config)
	{
		if( config.formName )
		{
			formName = config.formName;
		}
		if(config.fields){
			fields = config.fields;
		}
		if( config.ignoreFields )
		{
			if( typeof config.ignoreFields == 'object' )
			{

			}
			else
			{
				ignoreFields = ','+config.ignoreFields+',';
			}
		}
	}
	if(fields)
	{ // se os campos foram informados

		try {
			var aCampos = fields.split(',');
			for(var idx in aCampos )
			{
				// se não encontrar pelo id, tentar pelo name
				elemForm = jQuery("#"+aCampos[idx]).get(0);
				if( !elemForm )
				{
					// para campos radio
					elemForm = jQuery("input[name='" + aCampos[idx] + "']" ).get(0);
				}
				if( !elemForm )
				{
					// para campos check
					elemForm = jQuery("input[name='" + aCampos[idx] + "[]']" ).get(0);
				}


				if( elemForm && elemForm.id)
				{

				   var campoLabel = elemForm.getAttribute('label');
				   if( ! campoLabel )
				   {
				   		campoLabel = jQuery("#"+aCampos[idx] ).attr('label');
				   }

				   /*if( !elemForm )
					{
						elemLabel = jQuery("input[name='" + aCampos[idx] + "']" ).attr('label');
					}
					*/
					if( !campoLabel )
					{
						campoLabel = jQuery.trim(jQuery('#'+aCampos[idx]+'_label').html());
					}
					if( campoLabel && campoLabel.indexOf('<') != -1 )
					{
						campoLabel = campoLabel.substr(0,campoLabel.indexOf('<') );
					}
					if( campoLabel.indexOf(':') != -1 )
					{
						campoLabel = campoLabel.substr(0,campoLabel.indexOf(':'));
					}

					switch(elemForm.type){
						case 'text':
						case 'textarea':
						case 'password':
						case 'select':
						case 'select-one':
						case 'select-multiple':
						case 'file':
							try{
								if( jQuery.trim(elemForm.value)=="" && jQuery(elemForm).attr('needed') == 'true' )
								{
									// colocar a cor vermelha na borda
									fwSetBordaCampo(elemForm,true,true);
									if(campoLabel)
									{
										msgErroJS+=' O campo '+ campoLabel.replace(':','') +' ? obrigatório !'+"\n";
									}
									numErros++;
								}
								else if( jQuery(elemForm).attr('fieldType') == 'cpf' || jQuery(elemForm).attr('fieldType') == 'cnpj' || jQuery(elemForm).attr('fieldType') == 'cpfcnpj' )
								{
									if( ! elemForm.value.isCPF() && ! elemForm.value.isCNPJ() )
									{
										fwSetBordaCampo(elemForm,true,true);
										msgErroJS+=' O campo '+ campoLabel.replace(':','') +' está inválido !'+"\n";
										numErros++;
									}
								}
								else if( jQuery(elemForm).attr('fieldType') == 'email' )
								{
									if( ! fwValidarEmail(elemForm,false) )
									{
										msgErroJS+=' O campo '+ campoLabel.replace(':','') +' está inválido !'+"\n";
										numErros++;
									}
								}
							}
							catch(e){}
							break;
						case 'radio':
							if(jQuery('#'+elemForm.name+'_label_area').attr('needed')  == 'true' )
							{
								if(jQuery.inArray(elemForm.name, campoRadio)==-1)
								{
									if( jQuery("input[name='" + elemForm.name + "']:checked" ).length == 0 )
									{
										campoRadio.push(elemForm.name);
										msgErroJS+=' O campo '+ campoLabel +' ? obrigatório !'+"\n";
										fwSetBordaCampo(elemForm.name+'_container',true,true);
										numErros++;
									}
								}
							}
							break;
						case 'checkbox':

							//fwSetBordaCampo(elemForm.name.replace('[]','')+'_table',false,true);
							if(jQuery('#'+elemForm.name.replace('[]','')+'_label_area').attr('needed')  == 'true' )
							{
								if(jQuery.inArray(elemForm.name, campoRadio)==-1)
								{
									if( jQuery("input[name='" + elemForm.name + "']:checked" ).length == 0 )
									{
										campoRadio.push(elemForm.name.replace('[]','') );
										msgErroJS+=' O campo '+ campoLabel +' ? obrigatório !'+"\n";
										//jQuery("#"+elemForm.name.replace('[]','')+'_container').css('border','1px solid transparent');
										fwSetBordaCampo(elemForm.name.replace('[]','')+'_container',true,true);
										numErros++;
									}
								}
							}
							break;
						case 'hidden': // para campos file formdin4
							try{
								if(elemForm.type=='hidden')
								{
									// se campos FILE do formdin4
									var idField = elemForm.id;
									var campoLabel = jQuery.trim(jQuery('#'+idField+'_label').html());
									if(jQuery('#'+idField+'_disabled').val()==''){
										fwSetBordaCampo(jQuery('#'+idField+'_disabled'),true,true);
										if(campoLabel){
											msgErroJS+=' O campo '+ campoLabel +' ? obrigatório !'+"\n";
										}
										numErros++;
									}
								}
							}catch(e){}
							break;
					}
				}
			}
		}catch(e){}
	}else{

		for (i = 0; i < objForm.elements.length; i++) {
			elemForm = objForm.elements[i];

			if(elemForm && elemForm.id )
			{
				if( ( ignoreFields && ignoreFields.indexOf( ','+elemForm.id+',' ) > -1) || ( jQuery("#"+elemForm.id ).attr('gridofflinefield')=='true' ) )
				{
				  continue;
				}

				var campoLabel = jQuery("#"+elemForm.id ).attr('label');
				if( !campoLabel )
				{
					try{campoLabel = jQuery("#"+elemForm.name ).attr('label');}catch(e){}
				}
				if( !campoLabel )
				{
					campoLabel = jQuery.trim(jQuery('#'+elemForm.id+'_label').html());
				}
				if( campoLabel && campoLabel.indexOf('<') > -1 )
				{
					campoLabel = campoLabel.substr(0,campoLabel.indexOf('<') );
				}
				if( campoLabel && campoLabel.indexOf(':') != -1)
				{
					campoLabel = campoLabel.substr(0,campoLabel.indexOf(':'));
				}

				switch(elemForm.type)
				{
					case 'text':
					case 'textarea':
					case 'password':
					case 'select':
					case 'select-one':
					case 'select-multiple':
					case 'file':
						try{
							if(jQuery('#'+elemForm.id).attr('fieldtype')=='fileasync')
							{
								// se campos FILE do formdin4
								var idField = elemForm.id;
								idField = idField.replace("_disabled", "");
								if(jQuery('#'+idField+'_label').hasClass('fwFieldRequired')){
									if(jQuery('#'+idField+'_disabled').val()==''){
										fwSetBordaCampo(jQuery('#'+idField+'_disabled'),true,true);
										if(campoLabel){
											msgErroJS+=' O campo: '+ campoLabel +' ? obrigatório !'+"\n";
										}
										numErros++;
									}
								}
							}
							else if( elemForm.getAttribute('needed')=='true' && jQuery.trim(elemForm.value)=="" )
							{
									// colocar a cor vermelha na borda
									fwSetBordaCampo(elemForm,true,true);
									//var campoLabel = jQuery.trim(jQuery('#'+elemForm.id+'_label').html());
									if(campoLabel){
										msgErroJS+=' O campo: '+ campoLabel +' ? obrigatório !'+"\n";
									}
									numErros++;
								}
								else if( jQuery(elemForm).attr('fieldType') == 'cpf' || jQuery(elemForm).attr('fieldType') == 'cnpj' || jQuery(elemForm).attr('fieldType') == 'cpfcnpj' )
								{
									if( ! elemForm.value.isCPF() && ! elemForm.value.isCNPJ() )
									{
										fwSetBordaCampo(elemForm,true,true);
										msgErroJS+=' O campo: '+ campoLabel.replace(':','') +' está inválido !'+"\n";
										numErros++;
									}
								}
								else if( jQuery(elemForm).attr('fieldType') == 'email' )
								{
									if( ! fwValidarEmail(elemForm,false) )
									{
										msgErroJS+=' O campo: '+ campoLabel.replace(':','') +' está inválido !'+"\n";
										numErros++;
									}
								}


						}catch(e){}
						break;

					case 'radio':

						if(jQuery('#'+elemForm.name+'_label_area').attr('needed') == 'true' )
						{
                    		if(jQuery.inArray(elemForm.name, campoRadio)== -1)
							{
								if( jQuery("input[name='" + elemForm.name + "']:checked" ).length == 0 )
								{
									campoRadio.push(elemForm.name);
									msgErroJS+=' O campo: '+ campoLabel +' ? obrigatório !'+"\n";
									fwSetBordaCampo(elemForm.name+'_container',true,true);
									numErros++;
								}
							}
						}
						break;
				} // fim switch
			}
		}//fim form
	}// fim if
	if(numErros > 0){
		var str_s = (numErros > 1) ? 's': '';
		fwAlert(' '+numErros + ' Erro' + str_s + ' Encontrado' + str_s + "! \n\n"+ msgErroJS,{"title":"Mensagem","theme":"error"});
		return false;
	}
	return true;
}
/**
 * Função alias de fwValidateForm() simplificada para validar campos, abas ou grupos
 * EX: fwValidateFields('des_nivel,nom_pessoa,...');
 * Para validar campos de uma aba ou grupo especifico, passe o id do grupo ou da aba no
 * segundo parametro.
 * EX: fwValidateFields('des_nivel,nom_pessoa,...','pc_abateste');
 */
function fwValidateFields(pFields,parentId )
{
	if(!pFields && !parentId)
	{

		var form = jQuery("form").get(0);
		if( form )
		{
			parentId = form.name;
		}
		else
		{
			parentId='formdin';
		}
	}
	if( parentId )
	{
		var aFields=[];
		var obj;
		if( ! jQuery( '#'+parentId).get(0) )
		{
			parentId = parentId.toLowerCase();
			if( ! jQuery( '#'+parentId).get(0))
			{
				if( jQuery( '#'+parentId+'_layout' ).get(0))
				{
					parentId=parentId+'_layout';
				}
				else if( jQuery( '#'+parentId+'_container' ).get(0))
				{
					parentId=parentId+'_container';
				}
				else if( jQuery( '#'+parentId+'_table' ).get(0))
				{
					parentId=parentId+'_table';
				}
				else
				{
					return true;
				}
			}
		}

		jQuery( '#'+parentId+' [needed="true"],[fieldType="cpf"],[fieldType="cnpj"],[fieldType="cpfcnpj"],[fieldType="email"]').not('[gridOfflineField="true"]').each( function()
		//jQuery( '#'+parentId+' [required="true"]').each( function()
		{
			if(jQuery(this).is(':visible'))
			{
				var type = this.type;
				var tag = this.tagName.toLowerCase();
				var id = this.id;
				var name = id;
				var aType = ['text','password','textarea','radio','checkbox','select','select-one','select-multiple','file'];
				if(jQuery.inArray( type, aType ) != -1)
				{
					if( jQuery.inArray(name, aFields) == -1 )
					{
						if( type != 'radio' && type !='checkbox' )
						{
							aFields.push( id );
						}
						else
						{
							if( this.getAttribute('name') )
							{
								//name = this.getAttribute('name').toLowerCase();
								name = this.getAttribute('name');
			   				}
			   				if( aFields.indexOf(name) == -1 )
			   				{
								aFields.push( name );
							}
						}
					}
				}
			}
		});
		pFields = aFields.join(',');
	}
	if( ( aFields && aFields.length > 0) || pFields)
	{
		return fwValidateForm({
			"fields":pFields,"formName":parentId
		});
	}
	return true;
}
//------------------------------------------------------------------------------------------------------
function fwShowTempFile(tempName, contentType, fileName, extension, width, height)
{
	fwModalBox(fileName ,app_url+app_index_file+'?ajax=1&pastaBase='+pastaBase+'&modulo='+pastaBase+'includes/fwOpenTempFile.php&tempName='+tempName+'&contentType='+contentType+'&fileName='+fileName+'&extension='+extension,height,width,null,true);
}
//-------------------------------------------------------------------------------------------------
/*
 * Mostra mensagem no form
 * Exemplos uso:
 * fwShowMessage('Mensagem aqui'); // mostra mensagem de sucesso no form
 * fwShowMessage({message:"Mensagem aqui",status:1}); // mostra
mensagem de sucesso no form, igual a anterior
 * fwShowMessage({message:"Mensagem aqui",status:0}); // mostra
mensagem de erro no form
 * fwShowMessage({message:"Mensagem aqui",status:1,alert:1}); //
mostra mensagem de sucesso com ALERT
 * fwShowMessage({message:"Mensagem aqui",status:0,alert:1}); //
mostra mensagem de erro no form
 */
function fwShowMessage(jsonParams)
{
	try{
		var vMessage;
		var vAlert;
		var vMsgStatusCSS;
		if( typeof jsonParams == 'string')
		{
			vMessage = jsonParams;
			vAlert = 0;
			vMsgStatusCSS = 'fwMessageAreaSucess';
			vFormId='formdin';
		}
		else
		{
			if( ! jsonParams['formId'])
			{
				jsonParams['formId'] = "formdin";
			}
			vFormId = jsonParams['formId'];
			vMessage = jsonParams.message;
			vAlert = (jsonParams.alert) ? 1 : 0;
			if(!jsonParams.status){
				vMsgStatusCSS = 'fwMessageAreaError';
				if(vAlert) vMessage = "Erro:\n\n"+vMessage;
			}else{
				vMsgStatusCSS = 'fwMessageAreaSucess';
			}
		}
		//fwShowMsgArea({"formId":vFormId,"message":vMessage,"alert":vAlert,"class":vMsgStatusCSS,"clear":true});
		var vContainerId = '';
		if(jsonParams.containerId)
		{
			vContainerId = jsonParams.containerId;
		}
		fwShowMsgArea({
			"formId":vFormId,
			"message":vMessage,
			"alert":vAlert,
			"class":vMsgStatusCSS,
			"clear":true,
			"containerId":vContainerId
		});
	}catch(e){}
}
//-------------------------------------------------------------------------------------------------
function fwShowMsgArea(jsonParams)
{
	if( typeof jsonParams == 'string')
	{
		jsonParams={
			"message":jsonParams,
			"formId":"formdin",
			"class":"fwMessageAreaSucess",
			"title":"Mensagem"
		}
	}
	if( ! jsonParams['formId'])
	{
		jsonParams['formId'] = "formdin";
	}
	if( ! jsonParams['title'])
	{
		jsonParams['title'] = "Mensagem";
	}

	try
	{
    	// Função fwAlert não funciona direito com subforms
		if ( typeof parent.fwShowMsgArea == 'function')
   		{
   			alert( jsonParams['message'] );
			return;
   		}

		var td, area, content, button;
		var id = ( ( jsonParams.containerId ) ? '_' + jsonParams.containerId:"" );
		td		= jQuery("#td_"+jsonParams['formId']+id+"_msg_area");
		area	= jQuery("#"+jsonParams['formId']+id+"_msg_area");
		content = jQuery("#"+jsonParams['formId']+id+"_msg_area_content");
		button	= jQuery("#btn_close_"+jsonParams['formId']+id+"_msg_area");
	}
	catch(e)
	{
		// se der erro emitir o alert do browse
		alert( jsonParams['message'] );
		return;
	}
	if( area.length > 0 )
	{
		if( jsonParams['message'] )
		{
			if( jsonParams['alert'] )
			{
				fwHideMsgArea(jsonParams['formId']+id);
				fwAlert(jsonParams['message'],{'title':jsonParams.title} );
			}
			else
			{
				td.show();
				area.width(jQuery("#"+jsonParams['formId']+"_body").width()-20 );
				area.css('height','auto');
				area.removeClass('fwMessageAreaSucess');
				area.removeClass('fwMessageAreaError');
				area.addClass( jsonParams['class'] );
				if( jsonParams['clear'] == true )
				{
					content.html("");
				}
				content.append( jsonParams['message'].replace(/\n/g,'<br>') );
				area.show('slow',function()
				{
					button.show();
					fwFormDinAutoSize( {
						"formId":jsonParams['formId']
					} );
				});
			}
		}
	}
}
//-------------------------------------------------------------------------------------------------
function fwHideMsgArea( id )
{
	try
	{
		id 			= id || 'formdin';
		var area 	= jQuery("#"+id+"_msg_area");
		var h		= area.height()*-1;
		jQuery("#"+id+"_msg_area").hide("fast",
			function()
			{
				jQuery("#td_"+id+"_msg_area").hide();
				jQuery("#"+id+"_msg_area_content").html("")
				if( h < -15 )
				{
			//fwSetFormHeight(h);
			}
			}
			);
	}
	catch(e){}
}
/*
Função para exibir um arquivo pdf ou um pdf gerado dinamicamente com php.
Parametros: url, modulo, acao, titulo
Ex: fwShowPdf({"modulo" : pastaBase + "exemplos/exe_pdf_1.php" });
Ex: fwShowPdf({"url" :"tmp/teste.pdf" });
*/
function fwShowPdf( jsonParams )
{
	jsonParams 		= jsonParams || {};
	jsonParams.ajax	= 1;
	jsonParams.pdf	= 1;

	if( !jsonParams.modulo )
	{
		jsonParams.modulo = jQuery("#modulo").val();
	}
	if( !jsonParams.acao )
	{
		jsonParams.formDinAcao = 'gerar_pdf';
	}
	if( !jsonParams.url )
	{
		jsonParams.url = app_url+app_index_file;
	}
	if( !jsonParams.titulo )
	{
		jsonParams.titulo = 'Relatório Pdf';
	}
	if( !jsonParams.conatinerId )
	{
		jsonParams.containerId='formdin';
	}
	/*if( !jsonParams.data )
	{
		jsonParams.data = jQuery("#formdin").serialize();
	}
	*/
	if( jsonParams.url.indexOf('.pdf') == -1 )
	{
		for( key in jsonParams )
		{
			if (key != 'url')
			{
				if( jsonParams[key] == '' )
				{
					jsonParams[key] = jQuery('#'+key).val();
				}
				jsonParams.url += ( ( jsonParams.url.indexOf('?') > 0) ? '&' : '?') + ( ( jsonParams[key]) ? key+"="+jsonParams[key] : "" );
			}
		}
	}
	fwModalBox(jsonParams.titulo,jsonParams.url,null,null,null,null);
}


/**
 * Simplified way to get the value of a field
 * @param contentId field identifier
 * @param delimiter
 * @param onlyNames
 * @returns   value of a field
 */
function fwGetFields(contentId,delimiter,onlyNames) {
	delimiter = delimiter || '&';
	onlyNames = onlyNames || false;
	contentId = contentId || 'formdin';
	var result='';
	if( contentId ) {
		var aFields=[];
		jQuery( "#"+contentId+" *").each( function() {
			var type 	= this.type;
			var tag 	= this.tagName.toLowerCase();
			var id		= ''
			var value	= '';
			if (type == 'text' || type == 'password' || tag == 'textarea') {
				id = this.id;
				if( ! onlyNames ) {
					id += '='+this.value;
				}
			} else if (type == 'checkbox' || type == 'radio') {
				id = this.id;
				if( ! onlyNames ){
					id += '='+this.value;
				}
			} else if (tag == 'select') {
				id = this.id;
				if( ! onlyNames ){
					id += '='+this.value;
				}
			}
			if( id ) {
				aFields.push(id);
			}
		});
		result = aFields.join(delimiter);
	}
	return result;
}
//-----------------------------------------------------------------------------------------------------
function fwOpenCloseGroup( id, open )
{
	open = open || true;
	fwGroupboxOpenCloseClick(id,(open==true ? 'open' : 'close' ) );
}
function fwGroupOpen(id)
{
	fwGroupboxOpenCloseClick(id,'open');
}
function fwGroupClose(id)
{
	fwGroupboxOpenCloseClick(id,'close');
}
function fwGroupboxOpenCloseClick(e,action)
{
	var obj;
	try {
		if( typeof e == 'string')
		{
		  e = jQuery('#'+e+'_img_open_close').get(0);
			if( !e )
			{
				return;
			}
		}
	}
	catch(e)
	{
		return;
	}
	var groupId 	= e.getAttribute('groupId');
	var imgOpened	= e.getAttribute('imgOpened');
	var imgClosed	= e.getAttribute('imgClosed');
	var status		= e.getAttribute('status');
	var accordion_id= e.getAttribute('accordion_id');
	var groupH		= e.getAttribute('groupheight');
	var bodyH		= e.getAttribute('bodyheight');

	accordion_id = accordion_id || null;
	if( status=='opened' || action=='close')
	{
		if( groupH =='auto')
		{
			e.setAttribute('groupHeight',jQuery("#"+groupId).height());
		}
		if( bodyH =='auto')
		{
			e.setAttribute('bodyheight',jQuery("#body_"+groupId).height());
		}
		jQuery("#body_"+groupId).height(0);
		jQuery("#"+groupId).height(20);
		e.setAttribute('status','closed');
		e.src = imgClosed;
		e.setAttribute('title','Abrir');
	}
	else
	{
		var bh = e.getAttribute('bodyHeight');
		var h = e.getAttribute('groupHeight');
		jQuery("#"+groupId).height(h);
		jQuery("#body_"+groupId).height(bh);
		e.setAttribute('status','opened');
		e.src = imgOpened;
		e.setAttribute('title','Fechar');
		// fechar os outro grupos
		if( accordion_id )
		{
			jQuery('img[accordion_id="'+accordion_id+'"]').each(
				function()
				{
					if( this.getAttribute('groupId')!=groupId)
					{
						fwGroupboxOpenCloseClick(this,'close');
					}
				});
		}
	}

}
function fwLoadModule( module, jsonParams )
{
	if( top.app_load_module )
	{
		/*if( jsonParams )
		{
			alert( jsonParams.seq_evento );
		}
		*/
		top.app_load_module( module,0, jsonParams );
	}
}
//------------------------------------------------------------------------------
function fwSetLabel(field,newValue)
{
	field = field.replace('#','');
	jQuery('#'+field).attr('label',newValue);
	jQuery('#'+field+'_label').html(newValue);
}
//------------------------------------------------------------------------------
function fwGridSetRowColor(idGrid,rownum,$newColor)
{
	var id = '#'+idGrid+'_tr_'+rownum;
	var tr = jQuery(id).get(0);
	if( !tr )
	{
		id = '#'+idGrid.toLowerCase()+'_tr_'+rownum;
	}
	var bgc = jQuery(id).css('background-color');
	jQuery(id).css('background-color',$newColor);
	return bgc;
}
function fwGridConfirmDelete( campos, valores, idGrid, rownum )
{
	var bgc = fwGridSetRowColor(idGrid,rownum,'#FFFF66');
	if( confirm('confirma Exclusão ?') )
	{
		fwGridSetRowColor(idGrid,rownum,bgc);
		fwAtualizarCampos(campos,valores);
		fwFazerAcao(idGrid+'_excluir');
		return true;
	}
	fwGridSetRowColor(idGrid,rownum,bgc);
	return false;
}
/**
 * Função utilizada pelo campo TCoordGms para formatar os segundos
 * permitindo digitar a virgula quando necessário, diferentemente do campo
 * decimal
 */
function fwFormatSecondsGms(e,evt)
{
	var key;
	if (!evt)
	{
		evt = window.event
	}
	if( evt )
	{
		if (isNS4) {
			key=evt.which;
		} else {
			key=evt.keyCode;
		}
	}
	// keys válidas tab, backspace setaesquerda, setadireita e delete
	if( key==8 || key==9 || key==35 || key==36 ||key==37 || key==38 || key==39 || key==40 || key==46 ) {
		 return true;
	}
	var result=true;
	if( ( key >95 && key<106 ) || ( key >47 && key <58 ) || key == 188 )
	{
		if( e.value.indexOf(',')!=-1 && key == 188)
			{
				result=false;
			}
	}
	else
	{
		result=false;
	}
	if( !result )
	{

		try{evt.preventDefault()}catch(e){};
		key=0;
		if( evt.cancelBubble)
		{
			evt.cancelBubble = true;
		}
		if (evt.stopPropagation)
		{
			evt.stopPropagation();
		}
	}
	return false;
}

/**
 * Função para bloquear ou desbloquear campos do formulário
 * areaId = id do elemento pai
 * lock = true para bloquear ou false para desbloquear
 */
function fwLockUnlockArea(areaId,lock)
{
	if( !areaId ){return;}
	lock			= ( ( lock==null ) ? true : lock );
	areaId			= areaId.replace('#','');
	var area		= jQuery("#"+areaId);
	var w			= area.width();
	var h			= area.height();
	var top			= area.position().top;
	var divId		= areaId+'_container_block';
	if( lock )
	{
		if( !jQuery('#'+divId).get(0) )
		{
			area.append('<div id="'+divId+'" style="background-color: gray;opacity:.10;filter: alpha(opacity=10); display:block; position:absolute; top:'+top+'px; border:none;width:'+w+'px; height:'+h+'px;"></div>');
		}
	}
	else
	{
		jQuery('#'+divId).remove();
	}
}

/**
 * Funcao utilizada para bloquear ou desbloquear campos
 * containerId = id do campo, grupo ou aba para bloquear somente campos filhos
 * except = lista de campos que nao deverao ser desabilitados, separados por virgula.
 * lock = true para bloquear ou false para desbloquear
 */
function fwLockFields(containerId, except, lock ){
	var tag;
	var obj;
	if( containerId ) {
		obj = jQuery( "#"+containerId );
		if( !obj.get(0) ) // radio
		{
			obj = jQuery("input[name='" + containerId + "']" );
			if( !obj.get(0)) // check
			{
				obj = jQuery("input[name='" + containerId + "[]']" );
			}
			if( obj.get(0) )
			{
				while( obj.parent().get(0).tagName.toLowerCase() != 'table' )
				{
					obj = obj.parent();
				}
				//alert( obj.parent().parent().parent().parent().get(0).id );
				fwLockFields( obj.parent().get(0).id , except, lock );
				obj=null;
			}
		}
		if( !obj ) {
			return null;
		}
		var typeInput    = obj.get(0).tagName.toLowerCase()=='input';
		var typeTextArea = obj.get(0).tagName.toLowerCase()=='textarea';
		var typeSelect   = obj.get(0).tagName.toLowerCase()=='select';
		if( typeInput ||  typeTextArea ||  typeSelect ) {
			fwLockFields(obj.parent().get(0).id);
		}
	}
	except		= ( except		? ','+except + ','	: null);
	containerId	= ( containerId	? "#"+containerId.replace('#','')+" *" : "*" );
	jQuery( containerId ).each( function()
	{
		var type = this.type
		var tag = this.tagName.toLowerCase();
		var id = this.id.toLowerCase();
		if( tag == 'option' )
		{
			fwLockUnlockArea(jQuery(this).parent().parent().get(0).id,lock);
		}
		var idLock=null;
		if( ( ! except || except.indexOf( ',' + id + ',') == -1 ) )
		{
			if (type == 'text' || type == 'password' || type == 'select-one'  || type == 'select-multiple' )
			{
				idLock = jQuery(this).parent().get(0).id;
			}
			else if (type == 'textarea')
			{
				if( jQuery(this).parent().get(0).tagName.toLowerCase()=='div')
				{
					idLock = jQuery(this).parent().parent().get(0).id;
				}
				else
				{
					idLock = jQuery(this).parent().get(0).id;
				}
			}
			else if (type == 'checkbox' || type == 'radio')
			{
				idLock = jQuery(this).parent().parent().parent().parent().get(0).id; // table
			}
			if( idLock )
			{
				fwLockUnlockArea(idLock,lock);
			}
		}
	});
}
/**
* Maximizar/Minimizar o formulário
*
* @param formdinId
* @param callback
*/
function fwFullScreen(formdinId,callback)
{
	formdinId = formdinId ||'formdin';
	if( !jQuery('#'+formdinId ).get(0) )
	{
		return;
	}
	var status = jQuery("#"+formdinId+'_header').attr('fullscreen');
	var h;
	var w;
	var flat = ( jQuery('#box_'+formdinId).length == 0 );
	var src;
 	if( status=='true' )
	{
		h = jQuery("#"+formdinId+'_header').attr('oldHeight');
		w = jQuery("#"+formdinId+'_header').attr('oldWidth');
		jQuery("#"+formdinId+'_header').attr({'fullscreen':'false'});
		src = String( jQuery("#btn_"+formdinId+'_max_min').attr('src')).replace('minimize','maximize');
		jQuery("#btn_"+formdinId+'_max_min').attr({'title':'Maximizar','src':src});
	}
	else
	{
		src = String( jQuery("#btn_"+formdinId+'_max_min').attr('src')).replace('maximize','minimize');
		jQuery("#btn_"+formdinId+'_max_min').attr({'title':'Minimizar','src':src});
		var currH = jQuery("#"+formdinId+'_area').height();
		var currW = jQuery("#"+formdinId+'_area').width();
		jQuery("#"+formdinId+'_header').attr({'fullscreen':'true','oldWidth':currW,'oldHeight':currH});
		h= jQuery("body").height()-15;
		w= jQuery("body").width()-15;

	}
	fwSetFormHeight(h,formdinId);
	fwSetFormWidth(w,formdinId);
    fwAdjustTabsWidth( formdinId );
    fwAdjustGroupsWidth( formdinId );
    fwAdjustHtmlFieldsWidth( formdinId );

	if( callback )
	{
		try
		{
			status = (status=='true') ? '0' : ' 1';
			if( typeof callback == 'string' )
			{
				callback = callback.replace('()','');
				callback +='('+status+')';
				eval(callback);
			}
			else if( typeof callback =='function')
			{
				callback(status);
			}
		}catch(e){}
	}
}
/*
 * Função para transformar valores e campos concatenados com | em objeto
 * Ex: valores='brasilia|computador' e campos='cidade|objeto'
 * o=fwFV2O(campos, valores);
 * alert( o.cidade )
 * alert( o.objeto )
 */
function fwFV2O(fields,values)
{
	if( fields && values )
	{
		var aFields=fields.split('|');
		var aValues=values.split('|');
		var o=[];
		for(key in aFields)
		{
			o[aFields[key]]= aValues[key];
		}
		return o;
	}
}

/**
 * Função para solicitar confirmação de visualizar o arquivo anexado
 * quando utilizado o campo TFileAsync
 */
function fwConfirmShowTempFile(tempName,fileName,type,size)
{
	if( tempName )
	{
		jQuery.alerts.okButton		='Sim';
		jQuery.alerts.cancelButton	='não';
		jConfirm('Deseja visualizar o arquivo '+fileName+'?', 'Confirmação',
			function(res)
			{
				if( res )
				{
					fwShowTempFile(tempName,type,fileName);
				}
			});
	}
}

function fwOpenDir(updateField,rootDir,callback,title)
{
		title = title || 'Selecionar Diretório';
		var container = jQuery('#divFileTree')
		if( ! container.get(0) )
		{
			idContainer='divFileTree';
			title +='<span style="float:right;cursor:pointer;margin-right:5px;" onClick="jQuery(\'#divFileTree\').hide()">x</span>';
			//jQuery('body').append('<div id="divFileTree" style="width:500px;height:300px;border:1px solid silver;overflow:auto;background-color:#ffffff;display:none;position:absolute;top:20px;left:20px;"><div id="divTreeFileHeader" style="border:none;border-bottom:1px;height:26px;font-size:12px;color:#000000;background-color:#efefef;background-image:url('+pastaBase+'/js/jquery/jqueryFileTree/headerbg.gif);background-repeat: repeat-x;"><table width="100%" height="100%"><tr><td>Selecione o Diretório</td></tr></table></div><div id="divFileTreeContainer" style="border:none;border-top:1px solid silver;height:auto;"></div></div>');
			jQuery('body').append('<div id="divFileTree" style="display:none;font-size:12px;font-family:Verdana, Geneva, Arial, sans-serif;;margin:0px;padding:0px;width:500px;height:300px;border:1px solid silver;overflow:hidden;background-color:#ffffff;display:block;position:absolute;top:20px;left:20px;"><div style="position:absolute;top:-1px;left:0px;width:100%;height:26px;margin:0px;padding:0px;border:none;border-bottom:1px solid silver;display:block;background-image:url(headerbg.gif);background-repeat: repeat-x;text-align:left;"><div style="padding-left:2px;margin-top:6px;border:none;">'+title+'</div></div><div id="divFileTreeContainer" style="position:absolute;width:100%;height:246px;top:27px;border:0px;overflow:auto;padding-left:2px;"></div><div style="position:absolute;bottom:-1px;width:100%;height:26px;border:none;display:block;background-image:url('+pastaBase+'/js/jquery/jqueryFileTree/headerbg.gif);background-repeat: repeat-x;text-align:center;"> <div style="margin-top:4px;border:none;"><input id="fileTreeCurDir" type="hidden" value=""> <input class="fwButton" type="button" name="btnAbrir" id="btnAbrirFileTree" value="Selecionar" onClick="jQuery(\'#'+updateField+'\').val(jQuery(\'#fileTreeCurDir\').val());jQuery(\'#divFileTree\').hide();"></div></div></div>');
			container = jQuery('#divFileTree');
			container.hide();
			fwSetPosition(idContainer,'cc');
		}
		if( container.is(':visible'))
		{
			container.hide('fast');
			return;
		}
		rootDir = rootDir || '../';
		container.show('fast');
		//fwFaceBox('',true,300,600)
		jQuery("#divFileTreeContainer").fileTree({
				root: rootDir,
				//script: '../js/jquery/jqueryFileTree/jqueryFileTreeDir.php',
				script: pastaBase+'js/jquery/jqueryFileTree/jqueryFileTreeDir.php',
				expandSpeed: 100,
				collapseSpeed: 100,
				folderEvent:'click',
				updateField:updateField,
				folderDblClick:function( selectedDir)
					{
						container.hide();
						jQuery("#"+updateField).val( selectedDir );
						if( typeof callback == "function" )
							{
								callback(selectedDir);
							}
					},
				multiFolder: false,
				onlyDir:true
			},
			function(file)
			{
				if( typeof callback== 'function' )
				{
					callback(file);
				}
			});
	}
/**
* Função para retorna a data e a hora atual
*
*/
function fwGetTime()
{
	return new Date().getTime();
}
/**
* Função para converter horas em minutos
* @exemple: fwH2M('08:00');
* @param hrs - 99:99
*/
function fwH2M(hrs)
{
	var hora = hrs.charAt(0)+hrs.charAt(1);
	var minutos = hrs.charAt(3)+hrs.charAt(4);
	var min = Number(hora)*60 + Number(minutos);
	return min;
}
/**
* Função para tranformar minutos em horas
* @exemple: fwM2H('128'); = 02:08
*
* @param min
* @prame returnType - s=string , a=array ou j=json ( padrão )
*/
function fwM2H( min,returnType )
{
	returnType 	= returnType || 'j';
	var hours 	= Math.floor ( min / 60 );
	var minutes = min%60;
	// Função pad esta definida no arquivo funcoes.js
	if( returnType == 's')
	{
		return String(hours).pad(2,'0',0) + ":" + String(minutes).pad(2,'0',0);
	}
	else if( returnType=='a')
	{
		return [hours,minutes];
	}
	else
	{
		return {'hour':hours,'minute':minutes}
	}
	return null;
}
/**
* Função para calcular a diferença entre 2 horas
*/
function fwTimeDiference(earlierDate, laterDate)
{
	var h = earlierDate.split(":");
	earlierDate = new Date(2000, 1, 1, h[0], h[1], 0);
	h = laterDate.split(":");
	laterDate = new Date(2000, 1, 1, h[0], h[1], 0);
	var nTotalDiff = laterDate.getTime() - earlierDate.getTime();
	var oDiff = new Object();

	oDiff.days = Math.floor(nTotalDiff / 1000 / 60 / 60 / 24);
	nTotalDiff -= oDiff.days * 1000 * 60 * 60 * 24;

	oDiff.hours = Math.floor(nTotalDiff / 1000 / 60 / 60);
	nTotalDiff -= oDiff.hours * 1000 * 60 * 60;

	oDiff.minutes = Math.floor(nTotalDiff / 1000 / 60);
	nTotalDiff -= oDiff.minutes * 1000 * 60;

	oDiff.seconds = Math.floor(nTotalDiff / 1000);

	return String(oDiff.hours).pad(2, '0', 0) + ':' + String(oDiff.minutes).pad(2, '0', 0);
}

/**
* Função para converter string no formato dd/mm/yyyy em objeto Date
*
* @param dateDMY
*
* @returns {Date}
*/
function fw2Date(dateDMY)
{
	try
	{
		if( !dateDMY )
		{
			return null;
		}
		var delim;
		var a;
		if( dateDMY.indexOf('/') )
		{
			delim = '/';
		}
		else if( dateDMY.indexOf('-') )
		{
			delim = '-';
		}
		if( delim )
		{
			a = dateDMY.split(delim);
			return new Date(a[2], (a[1]-1), a[0], 0, 0, 0);
		}
	} catch(e){}
	return null;
}

function fwOpen_modal_window(jsonParams)
{
	if( top.app_open_modal_window )
	{
		top.app_open_modal_window(jsonParams);
		return;
	}

	if( typeof $ != 'function') // não carregou a prototype
	{
		if( typeof jQuery(document).dialog == 'function')
		{
			if( isChildDialog )
			{
       	 		top.fwDialog(jsonParams.title,jsonParams.url,jsonParams.height,jsonParams.width,jsonParams.callback,jsonParams.data);
			}
			else
			{
       	 		fwDialog(jsonParams.title,jsonParams.url,jsonParams.height,jsonParams.width,jsonParams.callback,jsonParams.data);
			}
		}
		else
		{
			fwModalBox2(jsonParams.title,jsonParams.url,jsonParams.height,jsonParams.width,jsonParams.callback,jsonParams.data);
		}
		return;
	}

	var header_height	= 0;
	var areaWidth		= parseInt(jQuery(window).width()-45);
	var areaHeight		= parseInt(jQuery(window).height()-45);
	var url 			= jsonParams.url || '';
	var title			= jsonParams.title || '';
	var width			= jsonParams.width ? jsonParams.width : (areaWidth);
	var height			= jsonParams.height ? jsonParams.height : (areaHeight);
	var data			= jsonParams.data;
	var callback		= jsonParams.callback;
	if( url )
	{
		if( url.substring(0,3) !='../' && url.substring(0,4)!='http' && url.substring(0,3)!='www' )
		{
			url = app_url+url;
			url += ( ( url.indexOf('?')==-1) ? '?' :'&' ) +'modalbox=1&subform=1';

		}
		if( title.indexOf('|')>-1)
		{
			title = title.substr(0,title.indexOf('|'));
		}
		if( url.substring(0,3) =='../')
		{
			url = app_url + url;
		}
		win = new Window({className: "alphacube"
		, title: title
		, width:width
		, height:height
		, destroyOnClose: true
		, recenterAuto:false
		, draggable:false
		, showProgress: true
		, resizable:false
		, overlayShowEffectOptions:{duration:10}
		, overlayHideEffectOptions:{duration:10}
		, hideEffect:Element.hide
		, showEffect:Element.show
		, closeCallback	: function (win)
			{
				modalWindowList.pop();
				if( callback )
				{
					var formData;
					var fields;
					var fieldName;
					//win.getContent().contentWindow.document.forms[0].nome.value;
					//win.getContent().contentDocument.forms[0].nome.value;
					try
					{
						formData = jQuery(win.getContent().contentDocument.forms[0]).serializeArray();
						fields=Array();
						for ( key in formData )
						{
							fieldName = formData[key].name;
							if( fieldName.indexOf('[]') > -1 )
							{
								fieldName = fieldName.replace('[]','');
								if( typeof fields[ fieldName ] == 'undefined')
								{
									fields[fieldName] = Array();
								}
								fields[fieldName].push(formData[key].value);
							}
							else
							{
								fields[formData[key].name] = formData[key].value;
							}
						}
					}
					catch(e){}
					eval( 'callback.apply(this,[fields,win.getContent().contentDocument]);');
				}
				return true;
			}
		// botoes
		,maximizable: false
		,minimizable: false
		});
		if( header_height )
		{
			win.setConstraint(true, {top:header_height});
		}
		if( url.substring(0,3) !='../' && url.substring(0,4)!='http' && url.substring(0,3)!='www' )
		{
			url += ( ( url.indexOf('?')==-1) ? '?' :'&' )+'modalWinId='+win.getId()
		}
		if( typeof data =='object')
		{
			for(key in data)
			{
				url +='&'+key+'='+data[key];
			}
		}
		else if( typeof data == 'string')
		{
			url+='&'+data;
		}
		win.setURL(url);
		win.showCenter(true);
		//win.maximize();
		//win.setConstraint(true, {left:0, right:0,bottom:-100,top:80});
		win.toFront();
		modalWindowList.push(win);
	}
}
function fwClose_modal_window(w)
{
	if( top.app_close_modal_window )
	{
		top.app_close_modal_window(w);
		return;
	}
	else if( typeof top.fwClose_modal_window  != 'undefined' && isChildDialog )
	{
		top.fwClose_modal_window(w);
		return;
	}
	else if( typeof parent.fwClose_modal_window  != 'undefined'  && isChildDialog )
	{
		parent.fwClose_modal_window(w);
		return;
	}
	else
	{
		if( typeof arrDialogs != 'undefined' && arrDialogs.length > 0 )
		{
			w = w || arrDialogs[arrDialogs.length-1];
			if( w )
			{
				//var position = arrDialogs.indexOf(w);
				var position = jQuery.inArray(w,arrDialogs);
				if( position > -1 )
				{
		                     arrDialogs.splice(position,1);
					//arrDialogs.pop();
					jQuery("#"+w).dialog('close').remove();
				}
			}
		}
		else
		{
			try{
				w = modalWindowList[modalWindowList.length-1];
				if( typeof w == 'object' )
				{
					w.close();
				}
				else
				{
					parent.jQuery("#dialog_0").dialog('close').remove();
				}
			}
			catch(e){}
		}
	}
}
function fwGetParentDialog(w)
{
	if( typeof top.fwGetParentDialog  != 'undefined' && isChildDialog )
	{
		return top.fwGetParentDialog(w);
	}
	else
	{
		if( typeof arrDialogs != 'undefined' && arrDialogs.length > 0 )
		{
			w = w || arrDialogs[arrDialogs.length-1];
			if( w )
			{
				var position = arrDialogs.indexOf(w);
				if( position > -1 )
				{
					if( position > 0 )
					{
						w = arrDialogs[position-1];
						return jQuery("#"+ w);
					}
					else
					{
						return top;
					}
				}
			}
		}
	}
	return null;
}

function fwSshow_image(url,height,width)
{
	if( top.app_show_image )
	{
		top.app_show_image(url,height,width);
		return;
	}
	height = height || jQuery("body").height()-100;
	width  = width  || jQuery("body").width()-100;
	fwOpen_modal_window({"url":url,"width":width,"height":height});
}
function fwParseJSON( valor )
{
	if( typeof valor == 'string')
	{
		try {
			var v = jQuery.parseJSON( valor );
			return v;
		}
		catch(e){}
	}
	return valor;
}
/**
* Função para verificar se existe alguma chamada ajax em execu??o.
* Valida somente para as chamadas ajax feitas pela Função
* fwAjaxRequest()
*
* @returns {Boolean}
*/
function fwChkRequestAjax()
{
	ajaxRequestCount = ajaxRequestCount || 0 ;
	if( ajaxRequestCount > 0  )
	{
		var msg;
		if( ajaxRequestCount > 1 )
		{
		   msg = 'Existem '+ajaxRequestCount+' requisições ajax pendentes!';
		}
		else
		{
		   msg = 'Existe '+ajaxRequestCount+' requisição ajax pendente!';
		}
		fwAlert(msg);
		return false;
	}
	return true;
}
/**
 * Faz um elemento piscar. ( blink )
 * @param seletor seletor jQuery do elemento. Exemplo: "#formdin_header"
 */
function fwBlinkElement(seletor,speed)
{
	speed = speed || 500;

/**
 * Função interna para piscar um elemento usada por fwBlinkElement
 */
	function _fwBlinkElement(seletor,speed)
{
		if (jQuery(seletor).attr('blink') == 'false')
		return;

	jQuery(seletor)
		.animate(
			{opacity: .25},
			"slow",
			function()
			{
					jQuery(this).animate({opacity: 1}, speed, _fwBlinkElement(seletor,speed));
			}
		);
}
	if( seletor.substr(0,1) != '#' && seletor.substr(0,1) != '.')
	{
		seletor = '#'+seletor;
	}
	jQuery(seletor).attr('blink',true);
	_fwBlinkElement(seletor,speed);
}

/**
 * Faz um elemento parar de piscar
 * @param seletor seletor jQuery do elemento. Exemplo: "#formdin_header"
 */
function fwStopBlinkElement(seletor)
{
	if( seletor.substr(0,1) != '#' && seletor.substr(0,1) != '.')
	{
		seletor = '#'+seletor;
	}
	jQuery(seletor).attr('blink', false);
}
/**
 * Altera o source do calendario
 * @param idCalendar
 * @param strUrl
 * @param jsonData
 * @return
 */
function fwSetCalendarSource(idCalendar, strUrl, jsonData) {
	//jQuery('#'+idCalendar).fullCalendar('removeEvents').fullCalendar('removeEventSources');
	jQuery('#'+idCalendar).fullCalendar( 'removeEventSource', 'index.php?ajax=1&modulo='+strUrl);

		if(jQuery('#'+idCalendar).fullCalendar('clientEvents') == "") {

			jQuery("#"+idCalendar).fullCalendar('addEventSource', {
		        url: "index.php?ajax=1&modulo="+strUrl,
	        type: "POST",
	        data: jsonData,
	        error: function() {  alert("Erro ao carregar os eventos da Agenda!");}

		});

	} // load the new source if the Calendar is empty

//	jQuery('#'+idCalendar).fullCalendar('removeEvents').fullCalendar('removeEventSources').fullCalendar('addEventSource', {
//        url: "index.php?ajax=1&modulo="+strUrl,
//        type: "POST",
//        data: jsonData,
//        error: function() {  alert("Erro ao carregar os eventos da Agenda!");}
//	});

	//jQuery("#"+idCalendar).fullCalendar('refetchEvents');

}

/**
 * Adiciona um source ao calendario, mantendo os outros sources
 * @param idCalendar
 * @param strUrl
 * @param jsonData
 * @return
 */
function fwAddCalendarSource(idCalendar, strUrl, jsonData) {
	jQuery("#"+idCalendar).fullCalendar('addEventSource', {
        url: "index.php?ajax=1&modulo="+strUrl,
        type: "POST",
        data: jsonData,
        error: function() {  alert("Erro ao carregar os eventos da Agenda!");}
    	});
}

/**
 * Atualiza o calendario
 * @param idCalendar
 * @return
 */
function fwRefreshCalendar(idCalendar) {
	jQuery("#"+idCalendar).fullCalendar("refetchEvents");
}

/**
* Acrescentar dias a uma data. Pode ser passada a data no formato dd/mm/yyyy ou o id do campo data
* neste caso o campo data sera atualizado
* no formato dd/mm/yyyy
* Obs: o dia informado conta como o primeiro dia válido então por exemplo
* dia 20/01/2012 + 1 dia será o pr?prio dia 20/01/2012
*/
function fwDateAddDay(dateDmy,days,fieldId)
{
    var delim;
    var field;
    days= days||1;
    days = parseInt( days );
    days--
    if( days < 1 )
    {
        return dateDmy ;
    }
    if( fieldId  )
    {
        field = jQuery("#"+fieldId);
        dateDmy = field.val();
    }
    if( !dateDmy  )
    {
        return null;
    }
    if( dateDmy.indexOf('/') )
    {




        aDate = dateDmy.split('/');
        delim='/';
    }
    else if( dateDmy.indexOf('-') )
    {
        aDate = dateDmy.split('/');
        delim = '-';
    }
    else
    {
        return null;
    }
    try
    {
        date = new Date();
        date.setMonth(aDate[1]-1);
        date.setFullYear(aDate[2]);
        date.setDate(aDate[0]);
        date.setDate( date.getDate() + days );
        date = String(date.getDate()).pad(2,'0',0) +delim+String(date.getMonth()+1).pad(2,'0',0)+delim+date.getFullYear();
        if( field )
        {
            field.val(date);
        }
        return date;
    }
    catch(e)
    {
        alert( e.message);
        return null
    }
}

/**
* Função para calcular a diferença em dias entre duas datas
* Obs: o dia informado conta como o primeiro dia válido então por exemplo
* dia 20/01/2012 - 20/01/2012 será 1 dia
*/
function fwDateDiffDays(date1,date2)
{
	var	aDate1,aDate2;
	try
	{

		if( !date1 || !date2)
		{
			return 0;
		}
		if( date1.indexOf('/') )
		{
			aDate1 = date1.split('/');
		}
		else if( date1.indexOf('-') )
		{
			aDate1 = date1.split('/');
		}
		else
		{
			return 0;
		}
		if( date2.indexOf('/') )
		{
			aDate2 = date2.split('/');
}
		else if( date2.indexOf('-') )
		{
			aDate2 = date2.split('/');
		}
		else
		{
			return 0;
		}
		var aDate2 = date2.split('/');
		if( aDate1[2]+''+aDate1[1]+''+aDate1[0] > aDate2[2]+''+aDate2[1]+''+aDate2[0])
		{
			fwDiffDays(date2,date1);
		return;
}
		return  ( parseInt( ( ( ( Date.parse( aDate2[1]+'/'+aDate2[0]+'/'+aDate2[2] ) ) - ( Date.parse( aDate1[1] + '/' + aDate1[0] + '/'+aDate1[2] ) ) ) / (24*60*60*1000) ).toFixed(0) ) + 1 );
	}
	catch(e)
	{
		return 0;
	}
}

/**
* Habilitar a navegação entre os campos com a tecla Enter como se fosse TAB
* Se o parametro always for true, irá pular até mesmo selects e textareas
*
* @param idForm
* @param always
*/
function fwEnterAsTab(idForm,always)
{
	var objForm;
	if( idForm )
	{
		if( typeof idForm == 'string')
		{
			objForm = jQuery('#'+idForm).get(0);
		}
	}
	else
	{
		objForm = jQuery('form').get(0);
	}
	enterAsTab( objForm,always );
}
//------------------------------------------------------------------
/**
* Função para definr a cor do campo TColorPicker
*
* @param id
* @param {String} color
*/
function fwSetColorPicker(id,color)
{
	var field;
	if( typeof id == 'string')
	{
		id = id.replace("#","");
		field = jQuery("#"+id);
	}
	else if( typeof id == 'object')
	{
		field = id;
		id = jQuery( field ).attr( "id" );
	}
	if( field )
	{
		field.value = color;
		if( ! color )
   		{
   			color = 'transparent';
   		}
		jQuery("#" + id + '_preview').css('background-color',color);
	}
}

/**
* Função para esconder/mostrar colunas do gride
*
* @param string colName
* @param string idGrid
* @param boolean show
*
* @example:
* fwGridShowHideColumn('col_a',null,true); exibir a coluna
* fwGridShowHideColumn('col_a,col_b',null, false); // esconder as colunas
* fwGridShowHideColumn('action','gridA', false); // ocultar a coluna Ação do gridA
*/
function fwGridShowHideColumn( colName, idGrid, show )
{
	if( !colName )
	{
		return;
	}
	show 	= show || false;
	idGrid 	= idGrid || jQuery("* [fieldtype=grid]").attr('id');
	if( !idGrid )
	{
		return;
	}
	var aCols = colName.split(',');
	var obj;
	var colIndex;
	for(var i=0;i<aCols.length;i++)
	{
		obj = jQuery('* [grid_id='+idGrid+'][column_name="'+aCols[i]+'"]');
		if( obj.length == 0 && aCols[i] == 'action' )
		{
			obj = jQuery('* [grid_id='+idGrid+'][column_name="'+idGrid+'_'+aCols[i]+'"]');
		}
		if( obj.length == 1 )
		{
			colIndex = obj.attr('column_index');
			if( colIndex )
			{
				if ( show )
				{
					jQuery("* [grid_id="+idGrid+"][column_index="+colIndex+"]").show();
				}
				else
				{
					jQuery("* [grid_id="+idGrid+"][column_index="+colIndex+"]").hide();
				}
			}
		}
	}
}

/**
* Função para esconder colunas do gride
*
* @param string colName
* @param string idGrid
*
* @example
* fwGridHideColumn('col_a');
* fwGridHideColumn('col_a,col_b');
* fwGridHideColumn('grideX_action'); // ocultar a coluna Ação
* fwGridHideColumn('action'); // ocultar a coluna Ação
* fwGridHideColumn('action','gridA'); // ocultar a coluna Ação do gridA
*/

function fwGridHideColumn( colName, idGrid )
{
	fwGridShowHideColumn(colName,idGrid,false);
}
/**
* Função para exibir colunas do gride
*
* @param string colName
* @param string idGrid
*
* @example
* fwGridShowColumn('col_a');
* fwGridShowColumn('col_a,col_b');
* fwGridShowColumn('grideX_action'); // exibir a coluna Ação
* fwGridShowColumn('action'); // exibir a coluna Ação
* fwGridShowColumn('action','gridA'); // exibir a coluna Ação do gridA
*/
function fwGridShowColumn( colName, idGrid )
{
	fwGridShowHideColumn(colName,idGrid,true);
}

/**
* Funcao para habilitar/desabilitar a edicao de campos
* @example fwReadOnly() para proteger, fwReadOnly(false) para desproteger
* @example fwReadOnly(null,'gp1'); para proteger os campos do grupo gp1
*
* @param trueFalse
* @param parentId
* @param except
*/
function fwReadOnly(trueFalse, parentId, except )
{
	trueFalse = ( trueFalse == null ) ? true : trueFalse
	except = ( except ? ','+except + ',' : null);
	if( except )
	{
		// adicionar os campos disabled na lista
		var aTemp = except.split(',');
		except=',';
		for( key in aTemp)
		{
			if( aTemp[key] )
			{
				if( aTemp[key].indexOf('_disabled')==-1)
				{
					except += aTemp[key]+','+aTemp[key]+'_disabled,';
				}
			}
		}
	}
	if( parentId )
	{
		if( jQuery("#"+parentId).length == 0)
		{
		 	parentId = parentId.toLowerCase();
		}
	}
	jQuery( (!parentId ? "*" : "#"+parentId+" *") ).each( function()
	{
		var type 	= this.type;
		var tag 	= this.tagName.toLowerCase();
		var id 		= this.id;
		var fieldType = this.getAttribute('fieldtype');
		if( id != '' )
		{
			// se não encontrar o id informado, procurar em caixa baixa
			if( ! jQuery("#"+id).get(0) )
			{
				id = String(id).toLowerCase();
			}
			if( ( ! except || except.indexOf( ',' + id + ',') == -1 ) && this.getAttribute('noClear') != 'true' && this.getAttribute('disabled') != 'true' )
			{
				if (type == 'file')
				{

					if( trueFalse )
					{
						jQuery(this).attr('disabled','true');
						jQuery("#"+id+"_clear").hide();
					}
					else
					{
						jQuery(this).removeAttr('disabled');
						jQuery("#"+id+"_clear").show();
					}
				}
				else if (fieldType == 'fileasync')
				{
					if( trueFalse )
					{
						jQuery("#"+id+'_btn_delete').hide();
						jQuery("#"+id+'_upload_iframe').get(0).contentWindow.habilitarBotao(false);
					}
					else
					{
						jQuery("#"+id+'_btn_delete').show();
						jQuery("#"+id+'_upload_iframe').get(0).contentWindow.habilitarBotao(true);
					}
				}
				else if (type == 'text' || type == 'password' || tag == 'textarea' )
				{
 					if( fieldType == 'date')
					{
						if( trueFalse )
						{
							jQuery("#"+id+'_calendar').hide();
						}
						else
						{
							jQuery("#"+id+'_calendar').show();
						}
					}
					if( trueFalse )
					{
						jQuery(this).attr('readonly','readonly').css('border','1px solid blue');
					}
					else
					{
						jQuery(this).removeAttr('readonly').css('border','1px solid silver');
					}
				}

				else if (type == 'hidden')
				{
					// pode ser campos radio, check ou select que estão desabilitados
					if( jQuery("#"+id).attr('readonly')=='readonly' && trueFalse == false)
					{
						jQuery("#"+id).remove();
						jQuery("#"+id+'_disabled').attr("id",id).attr("name",this.name).val(this.value);
					}

					if( fieldType == 'color')
					{
						if( ! jQuery(this).hasClass('fwFieldReadonly') )
						{
							if( trueFalse )
							{
	 							jQuery("#"+id+"_preview").attr('readonly','readonly');
							}
							else
							{
								jQuery("#"+id+"_preview").removeAttr('readonly');
							}
						}
     				}
				}
				else if (type == 'checkbox' || type == 'radio')
				{
					this.disabled = trueFalse;

					if( trueFalse && this.checked )
					{
						var arr='';
						if( type=='checkbox')
						{
							var arr = '[]';
						}
						var name = this.name;
						jQuery("#"+id).attr("id",id+"_disabled")
							.attr("name",id+"_disabled"+arr)
							.parent()
							.append('<input readonly="readonly" type="hidden" id="'+id+'" name="'+name+'" value="'+this.value+'">');
					}
				}
				else if (tag == 'select')
				{
					if( trueFalse )
					{
						jQuery("#"+id).attr("id",id+"_disabled")
							.attr("name",id+"_disabled")
							.append('<input readonly="readonly" type="hidden" id="'+id+'" name="'+id+'" value="'+this.value+'">');
					}
					this.disabled = trueFalse;
				}
			}
		}
	}
	);
}
/**
* Abrir uma janela moda utilizando jQuery UI Dialog
*
* @param title
* @param url
* @param height
* @param width
* @param callback
* @param data
*/
function fwDialog( title,url,height,width,callback,data)
{
	if( typeof top.fwDialog != 'undefined' &&  isChildDialog )
	{
		top.fwDialog( title,url,height,width,callback,data );
		return;
	}
	// padrão será fullscreen

	width  = width || parseInt(jQuery(window).width()-45); // jQuery(body).width()-100;
    height = height || parseInt(jQuery(window).height()-45); // jQuery(body).height()-100;

	var horizontalPadding = 15;
	var verticalPadding = 15;
	var startWidth = width;
	var startHeight = height;
	var dialogId = "dialog_"+arrDialogs.length;
	var scroll = jQuery(document).scrollTop();
	//top.document.body.scrollTop=0;
	//jQuery(document).scrollTop(0);
	data = data || {};
	dataComplement = 'subform=1&modalbox=1&dialogId='+dialogId;
	data = fwData2Url(data);
	url = url || 'about:blank';
	if( url.indexOf('?')==-1)
	{
		url += '?' + data;
	}
	else
	{
		url += '&' + data;
	}

	if( url.indexOf('?')==-1)
	{
		url += '?' + dataComplement;
	}
	else
	{
		url += '&' + dataComplement;
	}

	if( String( url ).indexOf('app_formdin=') == -1)
	{
		if( url.indexOf('?')==-1)
		{
			url += '?' + 'app_formdin=' + (app_formdin==true ? '1' : '0');
		}
		else
		{
			url += '&' + 'app_formdin=' + (app_formdin==true ? '1' : '0');
		}
	}
	jQuery('<iframe allowtransparency="true"  id="'+dialogId+'" src="'+url+'" hspace="0"  vspace="0" frameborder="0" style="padding:0px;overflow:auto;border:0px;vertical-align:middle;background:transparent;background-color:transparent;"/>').dialog({
	autoOpen: true,
	width: startWidth,
	height: startHeight,
    position: ['50%', '50%'],
	modal: true,
	title:title,
	resizable: false,
	autoResize: true,
	overlay: {
	   opacity: 0.5,
	   background: "black"
	},
	open:function(event, ui)
	{
		arrDialogs.push(this.id);
	},
	close:function(event, ui)
	{
	    //top.document.body.scrollTop=scroll;
	    try
	    {
		    jQuery(document).scrollTop(scroll);
			if( arrDialogs.indexOf(this.id ) > -1 )
			{
				if( ! isChildDialog )
				{
					fwClose_modal_window(this.id);
				}
				fwExecutarFuncao(callback,null);
			}
		} catch(e){}
	}
	}).width(startWidth-horizontalPadding).height(startHeight-verticalPadding);
}
/**
* Faz a varredura nos elementos da pagina e ativa a tecla de atalho
* de acorco com o atribute shortcut do elemento
*
*/
function fwApplyShortcuts()
{
    function addSpan(c,v,sc,tag)
    {
    	tag = tag || 'span';
		if( v.indexOf(c) == -1 )
		{
			v = '<'+tag+' class="fwShortcut">'+sc+'</'+tag+'>-'+v;
		}
		else
		{
			v = v.replace(c,'<'+tag+' class="fwShortcut">'+c+'</'+tag+'>');
		}
		return v;
    }

	jQuery("*[shortcut]").each( function()
	{
     	var a = this.getAttribute('shortcut').split('|');
     	var sc = a[0];
     	var id = a[1];
     	var ft = this.getAttribute('fieldtype');
   		var c = sc.replace('ALT+','');


     	if( ft == 'label' || ft== 'edit' )
     	{
     		var e = jQuery("#"+id+'_label');
     		var v = e.html();
     		v = addSpan( c,v,sc);
    		e.html(v);
       		jQuery.Shortcuts.add({
			type: 'down'
			, mask: sc
			, enableInInput: true
			, handler: function() { fwSetFocus(id) } } );
     	}
     	else if( ft == 'button' )
     	{
     		var e = jQuery("#"+id);
     		var v = jQuery.trim(e.html());
     		v = addSpan(c,v,sc);
    		e.html(v);
       		jQuery.Shortcuts.add({
			type: 'down'
			, mask: sc
			, enableInInput: true
			, handler: function() { jQuery("#"+id).click() } } );
     	}
     	else if( ft == 'img' )
     	{
     		var e = jQuery("#"+id);
     		var title = e.attr('title');
     		e.attr('title', ( title ? e.attr('title')+' ('+sc+')' : sc ) );
       		jQuery.Shortcuts.add({
			type: 'down'
			, mask: sc
			, enableInInput: true
			, handler: function() { jQuery("#"+id).click() } } );
     	}
     	else if( ft == 'tabsheet')
     	{
     		var v = jQuery.trim(jQuery(this).html());
     		var pc = this.getAttribute('pagecontrol');
     		v = addSpan(c,v,sc,'b');
     		//v = v.replace(c,'<b class="fwShortcut">'+c+'</b>');
    		jQuery(this).html(v);
       		jQuery.Shortcuts.add({
			type: 'down'
			, mask: sc
			, enableInInput: true
			, handler: function() { fwSelecionarAba(id,pc) } } );

     	}
	});
	jQuery.Shortcuts.start();
}

/**
* Atribuir uma tecla de atalho a um elemento do formulário ou para executar uma
* Função javascript
*
* @param hotkey
* @param id
* @param changeLabel
* @param js
*/
function fwSetShortcut(hotkey,id,changeLabel,js )
{
	//jQuery.Shortcuts.stop();
	changeLabel = changeLabel || false;
	var label;

    if( js )
    {
		jQuery.Shortcuts.add({
		type: 'down'
		, mask: hotkey
		, enableInInput: true
		, handler: function() { fwExecutarFuncao(js) } } );
		jQuery.Shortcuts.start();
		return;
    }
	var e = jQuery("#"+id);
	if( !e.get(0))
	{
		// varificar se é uma aba
		e = jQuery('span[tabid="'+id+'"]');
		// se não existir nenhum elemento executa uma ação
		if( ! e.get(0) )
		{
			jQuery.Shortcuts.add({
			type: 'down'
			, mask: hotkey
			, enableInInput: true
			, handler: function() { fwDoAction(id) } } );
		}
		else
		{
			var pc = jQuery(e).attr('pagecontrol');
			value = jQuery.trim(e.html());
            if( changeLabel )
        	{
        		if( value.indexOf( hotkey ) == -1  && e.html().indexOf('<') == -1 )
        		{
					e.html('<b class="fwShortcut">'+hotkey+'</b>-'+value);
				}
			}
			if( value.indexOf('&')!=-1)
			{
				value = value.replace('&amp;','&');
				var c = value.substring(( value.indexOf('&')+1),2);
				if( c )
				{
					hotKey = 'ALT+'+c;
					value = value.replace('&'+c, '<b class="fwShortcut">'+c+'</b>');
					e.html(value );
				}
			}
			jQuery.Shortcuts.add({
			type: 'down'
			, mask: hotkey
			, enableInInput: true
			, handler: function() {
            	fwSelecionarAba(id,pc);
			 }});
		}
		jQuery.Shortcuts.start();
		return;

	}
	var eType = e.attr('fieldtype');
	var value = e.attr('value');

	if( eType == 'button')
	{
		jQuery.Shortcuts.add({
		type: 'down'
		, mask: hotkey
		, enableInInput: true
		, handler: function() {jQuery('#'+id).click() }});
        if( changeLabel && value.indexOf( hotkey ) == -1  && e.html().indexOf('<') == -1 )
        {
        	if( e.html() !== '')
        	{
        		e.html( '<span class="fwShortcut">'+hotkey+'</span>-'+e.html() );
			}
			else
			{
				e.attr('value','<span class="fwShortcut">'+hotkey+'</span>-'+value);
			}
        }

	}
	else if( eType =='edit' || eType =='memo')
	{
		var label = jQuery('#'+id+'_label');
		if( e.attr('readonly')=='readonly' )
		{
			jQuery.Shortcuts.add({
			type: 'down'
			, mask: hotkey
			, enableInInput: true
			, handler: function() { jQuery('#'+id).click() }});
		}
		else
		{
			jQuery.Shortcuts.add({
			type: 'down'
			, mask: hotkey
			, enableInInput: true
			, handler: function() { jQuery('#'+id).focus() }} );
		}
		if( label )
		{
			value = label.html();
			if( changeLabel && value.indexOf(hotkey)==-1)
			{
				label.html('<span class="fwShortcut">'+hotkey+'</span>-'+value);
			}
		}
	}
	jQuery.Shortcuts.start();

}

/**
* Bloqueia a execução do programa pelo tempo solicitado em milissegundos e
* depois executa a Função de callback se tiver sido informada.
*
* Exemplo: 	fwSleep(1000,function(){alert("voltei")}); // aguarda 1 segundo
* 			fwSleep(2000,"alert('voltei')")}); // aguarda 2 segundos
*
* @param milliSeconds
* @param callback
*/
function fwSleep(milliSeconds,callback)
{
	var startTime = new Date().getTime();
	while (new Date().getTime() < startTime + milliSeconds);
	fwExecutarFuncao(callback);
}

/**


* Retorna o código da tecla pressionada
*
* @param event
*/
function fwGetKey(event)
{
	var key=0;
	if( !event )
	{
		event = window.event;
	}
	if (isNS4) { key=event.which;} else {key=event.keyCode;}
	return key;
}
/**
* Função utilizada pela classe TGrid quando o gride possuir paginação e for clicado nos botoes
* de proxima, anterior, ultima e primeira página.
*
* @param params
*/
function fwGridChangePage(params)
{
	var select 	= jQuery("#"+params.id+"_jumpToPage");
	var page 	= parseInt( select.val() );
	var pages	= select.get(0).options.length;
	var changed = false;
	switch(params.action)
	{
		case 'first':
			select.get(0).selectedIndex = 0;
			changed=true;
		break;
		case 'last':
			select.get(0).selectedIndex = (pages-1);
			changed=true;
		break;
		case 'next':
			if ( ( page + 1 ) <= pages )
			{
				select.get(0).selectedIndex = select.get(0).selectedIndex + 1;
				changed=true;
			}
		break;
		case 'prior':
			if ( ( page - 1 ) > 0 )
			{
				select.get(0).selectedIndex = select.get(0).selectedIndex - 1;
				changed=true;
			}
		break;
	}
	if( changed )
	{
		select.change();
	}

}

/**
* Funcao utilizada pela classe TGrid quando o gride possuir paginação e a pagina for modificada
*
* @param params
*/
function fwGridPageChange(page,params)
{
	//var url = params.url || app_url+app_index_file;
	params.page = page;
    fwAjaxRequest(
			{
			'module':params.modulo
			,'dataType':'text'
			,'action': (params.formDinAcao||'paginar')
			,'async':true
			,'data':params
			,'callback': function( html ){
				jQuery("#"+params.gridId+"_table tbody").remove();
				try{
					jQuery("#"+params.gridId+"_table").trigger("update"); // funcao do TableSorter
				}catch(e){}
            	jQuery("#"+params.gridId+"_table").append(html);
				fwLockUnlockArea(params.gridId,false);
	   			jQuery("#"+params.gridId+"_loading").hide();
				fwAttatchTooltip({"container":params.gridId+"_table"});
				window.setTimeout( function()
				{
					var colIndex;
					var sorting=[];
					try{
						jQuery("#"+params.gridId+"_table > thead > tr > th").each (
							function()
 							{
 								if( jQuery(this).hasClass('headerSortUp'))
 								{
									colIndex = parseInt(jQuery(this).attr("column_index"))-1;
									sorting.push([colIndex,1]);
 								}
 								else if( jQuery(this).hasClass('headerSortDown'))
 								{
									colIndex = parseInt(jQuery(this).attr("column_index"))-1;
									sorting.push([colIndex,0]);
 								}
 							}
					   	);
					   	jQuery("#"+params.gridId+"_table").trigger("sorton",[sorting]);
		 				}catch(e){}
					},500);
			}
    		,'beforeSend': function(){
				fwLockUnlockArea(params.gridId,true);
				jQuery("#"+params.gridId+"_loading").show();
				return true;
    		}
			});
}
/**
* Função para ajustar a altura da aplicação para a altura do formulário e
* evitar as barras de rolagem do iframe, mostrando apenas as barrar de rolagem
* do browser.
*/
function fwAppFitFormHeight(delay)
{
    var iframe;
	delay=delay||100;
	window.setTimeout(function()
	{
		try {iframe = top.jQuery("#app_iframe");} catch(e){return;};
		jQuery('body').css('overflow-y','auto');
		jQuery(window).scrollTop(500000);
		var st = jQuery(window).scrollTop();
		jQuery('body').css('overflow-y','hidden');
		if( st > 0 )
		{
			var h = iframe.height();
			var container = top.jQuery('#app_container');
			var header = top.jQuery("#table_header").height()||0;
			var footer = top.jQuery("#table_footer").height()||0;
			var menu = top.jQuery("#div_main_menu").height()||0;
			iframe.height( h+st )
			container.height( h+st+header+footer+menu );
			top.lapp.resizeAll();


		}
	},delay);
}
	/**
	 * janelaModal
	 *
	 * @param paramModal
	 *
	 */
	function fwModalGeneric(paramModal)
		{
	   	try { top.app_modalGeneric( paramModal ); return;} catch( e ){}
		paramModal.id = (paramModal.id == null) ? 'dialog-message' : paramModal.id;
		paramModal.width = (paramModal.width == null) ? 530 : paramModal.width;
		paramModal.height = (paramModal.height == null) ? 200 : paramModal.height;
		paramModal.title = (paramModal.title == null) ? 'Alerta' : paramModal.title;
		paramModal.data = (paramModal.data == null) ? '' : paramModal.data;
		paramModal.css = (paramModal.css == null) ? '' : paramModal.css;
		if( app_url )
		{
			paramModal.img = (paramModal.img==null) ? app_url+(pastaBase==null?'base/':pastaBase)+ 'css/imagens/alert/help.gif':paramModal.img; // não utilizar a variavel pastaBase aqui
		}
		else
		{
			paramModal.img = (paramModal.img==null) ? '../css/imagens/alert/help.gif':paramModal.img; // não utilizar a variavel pastaBase aqui
		}
		if (jQuery('#janela-modal' + paramModal.id))
			{
			jQuery('#janela-modal' + paramModal.id).remove();
			}
	   	if( ! paramModal.data )
	   	{
	   		return;
	   	}
	   	jQuery(window).scrollTop(0);
	   	paramModal.data = paramModal.data.replace(/\n/g,'<br>' );
		//var html = "<div style='display:table-cell;vertical-align:middle;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11.5px;font-weight:bold;"+paramModal.css+"; ' id='janela-modal" + paramModal.id + "' title='" + paramModal.title + "'></div>";
        var html = "<table id='janela-modal" + paramModal.id+"' title='" + paramModal.title+"' border='0' cellpadding='0' cellspacing='0' class='dialog-confirm' style='width:100%;font-family:Arial, Verdana, Helvetica, sans-serif; font-size:11.5px;font-weight:bold;"+paramModal.css+"'><tr>";
        html += "<td style='width:40px;vertical-align: middle;'><img id='dialog-image' src='"+paramModal.img+"' style='border:none;width:32px;height:32px;'/></td>";
        html += "<td id='dialog-content' style='vertical-align: middle;text-align: left;'>"+paramModal.data+"</td>";
        html += "</tr></table>";
		jQuery('body').append( html );
        jQuery("#janela-modal" + paramModal.id).dialog(
        {
            height: paramModal.height,
            width: paramModal.width,
            position: ['50%', '50%'],
            modal: true,
            resizable: false,
            //autoOpen : false,
            closeOnEscape: true,
            zIndex: 99996,
            buttons: paramModal.buttons,
            close: paramModal.close
            ,create: function(event, ui)
                {
                    jQuery('body').css({ overflow: 'hidden' })
                }
            ,beforeClose: function(event, ui)
                {
                jQuery('body').css({ overflow: 'inherit' })
                }
            }
        );
    jQuery('.ui-dialog-titlebar-close').hide();
    }

	/**
	 * fwAlert
	 *
	 * @param message
	 * @param jsonParams
	 * @param theme
	 */
	function fwAlert(message, jsonParams, theme )
	{

		try{top.app_alert( message, jsonParams, theme);return} catch(e) {}
		jsonParams = ( ! jsonParams ) ? {} : jsonParams;
        jsonParams.title = (!jsonParams.title) ? 'Mensagem' : jsonParams.title;
        jsonParams.width = (!jsonParams.width) ? 530 : jsonParams.width;
        jsonParams.height = (!jsonParams.height) ? null : jsonParams.height;
        jsonParams.callback = (!jsonParams.callback) ? null : jsonParams.callback;
        jsonParams.css = (!jsonParams.css) ? 'color:#0000FF' : jsonParams.css;
        jsonParams.theme = (!jsonParams.theme) ? '':jsonParams.theme;
        jsonParams.buttonLabel = (jsonParams.buttonLabel==null) ? 'Fechar' : jsonParams.buttonLabel;

		if( app_url )
		{
			jsonParams.img = (jsonParams.img==null) ? app_url +  ( pastaBase==null ? 'base/' : pastaBase ) + 'css/imagens/alert/info.gif':jsonParams.img;
		}
		else
		{
			jsonParams.img = (jsonParams.img==null) ? '../css/imagens/alert/info.gif':jsonParams.img; // não utilizar a variavel pastaBase aqui
		}
		if( theme === 'error')
        {
        	jsonParams.css += 'background-color:#f2dede;';
        }
		fwModalGeneric(
			{
			data : message,
			width: jsonParams.width,
			height: jsonParams.height,
			close:jsonParams.callback,
			title:jsonParams.title,
			css:jsonParams.css,
			img:jsonParams.img,
            buttons:  [ { text: jsonParams.buttonLabel, click: function() { jQuery( this ).dialog( "close" ); } } ]
			});
		}

/**
* Dialogo de confirmação
*
* @param message
* @param callbackYes
* @param callbackNo
* @param yesLabel
* @param noLabel
* @param title
*/

function fwConfirm(message, callbackYes, callbackNo, yesLabel, noLabel, title)
{
	try{top.app_confirm(message, callbackYes, callbackNo, yesLabel, noLabel, title);return;}catch(e){}
	title 		= (!title)?'Confirmação':title;
	yesLabel 	=(!yesLabel)?'Sim':yesLabel;
	noLabel 	=(!noLabel)?'não':noLabel;

	fwModalGeneric(
	{
		data : message,
		height: 'auto !important',
		width:530,
		title:title,
		buttons	:
			[ {text:noLabel,click: function()
				{
					jQuery(this).dialog("close");
					if( jQuery.isFunction(callbackNo))
					{
						callbackNo.call()
					}

				}
			},
			   {text:yesLabel,click: function()
				{
					jQuery(this).dialog("close");
					if( jQuery.isFunction( callbackYes ))
					{
				   		callbackYes.call();
					}
				}
			   }]
		});
}
//------------------------------------------------------------------------------
/**
* Função utilizada pelo plugin do jquery tablesorter para ordenar datas e
* valores monetários formatados com ponto e virgula ex: 123.456,78
*/
function fwTableSorter(node)
{
	var text = jQuery.trim(jQuery(node).text());
	var number = text.replace(/[^0-9]/g,'');
	if( String(number) != '' )
	{
		// verificar se é um data
		var dateFormat = /(^\d{1,4}[\.|\\/|-]\d{1,2}[\.|\\/|-]\d{1,4})(\s*(?:0?[1-9]:[0-5]|1(?=[012])\d:[0-5])\d\s*[ap]m)?$/;
  		if ( dateFormat.test( text ) )
  		{
  			var posBarra = text.indexOf('/');
  			var posHifen = text.indexOf('-');
  			if ( posBarra == 2 || posHifen==2 )
  			{
         		text = text.substring(6)+text.substring(3,5)+text.substring(0,2)
			}
		}
		else
		{
			// valores monetários ou inteiros
			var posPonto 	= text.indexOf('.');
			var posVirgula	= text.indexOf(',');
			if( posVirgula > posPonto  )
			{
				text = text.replace(/\./g,'').replace(/,/,'.');
			}
			else if( posVirgula < posPonto )
			{
				text = text.replace(/\,/g,'');
			}
		}
	}
	return text;
}


/**
* Função para verificar se a tag esta com a barra de rolagem vertical visivel
*
* @param id
*
* @returns {Boolean}
*/
function fwHasVScrollBar( id )
{
	try
	{
		var posAtual;
		id = "#"+String(id).replace("#",'');
		if( jQuery(id).get(0).scrollHeight > 0 )
		{
			posAtual = jQuery(id).scrollTop();
			jQuery(id).scrollTop(1);
			if( jQuery(id).scrollTop() != posAtual )
			{
				jQuery(id).scrollTop(posAtual);
				return true;
			}
			jQuery(id).scrollTop(-1);
			if( jQuery(id).scrollTop() != posAtual )
			{
				jQuery(id).scrollTop(posAtual);
				return true;
			}
			jQuery(id).scrollTop(posAtual);
			return false;
		}
	} catch(e) {}
	return false;
}
/**
* Função para ajustr a largura dos grupos e seus subgrupos
* @param containerId
*/
function fwAdjustGroupsWidth(containerId)
{
	containerId = containerId || 'formdin';
	var divGrp;
	var parentId;
	var parentObj;
	var parentTag;
	var parentWidth;
	var parentVScroll;
	var offset;
	var flat;
	// encontrar os grupos diretamente subordinados ao container informado
    jQuery("div[fieldtype='group'][parent='"+containerId+"'][fullwidth='true']").each( function()
    	{
            divGrp			= jQuery(this);
            parentId		= divGrp.attr('parent');
            parentObj		= jQuery("#"+parentId);
            parentTag		= String( parentObj.prop("tagName")).toLowerCase();
            parentVScroll	= false;
            offset 		 	= 0 ;
            flat			= false;
            if( parentTag == 'form' )
            {
            	parentWidth = jQuery("#"+parentId+"_body").width();
            	parentVScroll = fwHasVScrollBar("#"+parentId+"_body");
				flat = ( jQuery('#box_'+containerId).length == 0 );
				if( flat )
				{
					if ( parentVScroll )
					{
						offset = 24; // ok
					}
					else
					{
						offset = 7; // ok
					}				}
				else
				{
					if ( parentVScroll )
					{
						offset = 24; // ok
					}
					else
					{
						offset = 7; // ok
					}
				}
            }
            else if( parentTag == 'div' )
            {
            	parentWidth = jQuery("#"+parentId).width();
            	parentVScroll = fwHasVScrollBar("#"+parentId) || fwHasVScrollBar("#body_"+parentId);
            	if( parentVScroll )
            	{
               		offset = 15;
				}
				else
				{
            		offset = 3;
				}
            }
            if( parentId == containerId )
            {
	            //console.log( 'ParentId:'+parentId,' / Pai Tag:'+parentTag,' / Parent width:'+parentWidth,' / Scroll: '+parentVScroll,' / offset: '+offset,' / flat:'+flat);
 				divGrp.width(parentWidth-offset);
	 			jQuery('#body_'+this.id ).width( divGrp.width()-13 ) ;
  	 			fwAdjustGroupsWidth( this.id ); // ajustar os subgrupos
	 			fwAdjustTabsWidth(this.id); // ajustar as subabas
				fwAdjustHtmlFieldsWidth( this.id ); // ajustar campos htmls
			}
 		});
}

/**
* Função para ajustr a largura das abas e suas subabas
* @param containerId
*/
function fwAdjustTabsWidth(containerId)
{
	containerId = containerId || 'formdin';
	var tabRef;
	var divTab;
	var pageControl;
	var parentId;
	var parentObj;
	var parentTag;
	var parentWidth;
	var parentVScroll;
	var offset;
	var flat;
	var parentFieldType;
	// encontrar todas as abas subordinadas diretamente ao container informado
	jQuery("table[fieldtype='pagecontrol'][parent='"+containerId+"'][fullwidth='true'] li").each( function()
	{

			tabRef 		= jQuery(this).attr('tabref');
			divTab 		= jQuery("#"+tabRef);
			pageControl = divTab.attr('pagecontrol');
            parentId 	= jQuery("#"+pageControl).attr('parent');
            parentObj 	= jQuery("#"+parentId);
            parentTag 	= String( parentObj.prop("tagName")).toLowerCase();
            parentFieldType =  parentObj.attr("fieldType") || '';
            parentVScroll = false;
            offset 			= 0 ;
            flat			= false;
            if( parentTag === 'form')
            {
            	parentWidth = jQuery("#body_"+parentId).width();
            	parentVScroll = fwHasVScrollBar("#"+parentId+"_body");
				flat = ( jQuery('#box_'+containerId).length == 0 );
				if( flat )
				{
					if ( parentVScroll )
					{
	               		offset = 52;  // ok
					}
					else
					{
	               		offset = 34;  // ok
					}
				}
				else
				{
					if ( parentVScroll )
					{
						offset = 50;  // ok
					}
					else
					{
						offset = 32;  // ok
					}
				}
            }
            else
            {
            	parentWidth = jQuery("#"+parentId).width();
            	parentVScroll = fwHasVScrollBar("#"+parentId);
            	if( parentFieldType =='group')
            	{
	            	parentWidth = jQuery("#body_"+parentId).width();
            		parentVScroll = fwHasVScrollBar("#body_"+parentId);
            		if( parentVScroll )
            		{
	            		offset = 47; // ok
					}
					else
					{
	            		offset = 32; // ok
					}
				}
				else
				{
            		if( parentVScroll )
            		{
		            	offset = 36; // ok
					}
					else
					{
		            	offset = 25; // ok
					}

				}
            }
            if( parentId == containerId )
            {
	            //console.log( 'TabRef:'+tabRef,' / PageControl:'+pageControl,' / Parent:'+parentId,' / Pai Tag:'+parentTag,' / Parent width:'+parentWidth,' / Scroll: '+parentVScroll,' / offset: '+offset,' / flat:'+flat,' / ParentFieldType:'+parentFieldType);
 				divTab.width(parentWidth-offset);
 				fwAdjustGroupsWidth(tabRef); // ajustar os grupos da aba
 				fwAdjustTabsWidth(tabRef); // ajustar as sub-abas
				fwAdjustHtmlFieldsWidth( tabRef ); // ajustar campos htmls
            }
	});
}

function fwAdjustHtmlFieldsWidth(containerId)
{
	containerId = containerId || 'formdin';
	var divGrp;
	var parentId;
	var parentObj;
	var parentTag;
	var parentWidth;
	var parentVScroll;
	var offset;
	var flat;
	// encontrar os grupos diretamente subordinados ao container informado
    jQuery("div[fieldtype='html'][parent='"+containerId+"'][fullwidth='true']").each( function()
    	{
            divGrp			= jQuery(this);
            parentId		= divGrp.attr('parent');
            parentObj		= jQuery("#"+parentId);
            parentTag		= String( parentObj.prop("tagName")).toLowerCase();
            parentVScroll	= false;
            offset 		 	= 0 ;
            flat			= false;
            if( parentTag == 'form' )
            {
            	parentWidth = jQuery("#body_"+parentId).width();
            	parentVScroll = fwHasVScrollBar("#"+parentId+"_body");
				flat = ( jQuery('#box_'+containerId).length == 0 );
				if( flat )
				{
					if( parentVScroll)
					{
						offset = 27; // ok
					}
					else
					{
						offset = 9; // ok
					}
				}
				else
				{
					if( parentVScroll)
					{
						offset = 26; // ok
					}
					else
					{
						offset = 7; // ok
					}
				}
            }
            else if( parentTag == 'div' )
            {
            	parentWidth = jQuery("#"+parentId).width();
            	parentVScroll = fwHasVScrollBar("#body_"+parentId);
            	if( parentVScroll )
            	{
               		offset = 35; // ok
				}
				else
				{
            		offset = 23; // ok
				}
            }
            if( parentId == containerId )
            {
	            //console.log( 'ParentId:'+parentId,' / Pai Tag:'+parentTag,' / Parent width:'+parentWidth,' / Scroll: '+parentVScroll,' / offset: '+offset,' / flat:'+flat);
 				divGrp.width(parentWidth-offset);
			}
 		});
}