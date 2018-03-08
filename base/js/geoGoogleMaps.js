
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

var infowindow;
var map;
var gmarkers;
var sidebar_html;
var mapCenter;
var pacoteFuncaoProc;
var arrParametros;
var cache;

/**
* Returns an XMLHttp instance to use for asynchronous
* downloading. This method will never throw an exception, but will
* return NULL if the browser does not support XmlHttp for any reason.
* @return {XMLHttpRequest|Null}
*/
function createXmlHttpRequest() {
	try {
		if (typeof ActiveXObject != 'undefined') {
			return new ActiveXObject('Microsoft.XMLHTTP');
		} else if (window["XMLHttpRequest"]) {
			return new XMLHttpRequest();
		}
	} catch (e) {
		changeStatus(e);
	}
	return null;
};

/**
* This functions wraps XMLHttpRequest open/send function.
* It lets you specify a URL and will call the callback if
* it gets a status code of 200.
* @param {String} url The URL to retrieve
* @param {Function} callback The function to call once retrieved.
*/
function downloadUrl(url, callback) {
	var status = -1;
	var request = createXmlHttpRequest();
	if (!request) {
		return false;
	}

	request.onreadystatechange = function() {
		if (request.readyState == 4) {
			try {
				status = request.status;
			} catch (e) {
				// Usually indicates request timed out in FF.
			}
			if (status == 200) {
				callback(request.responseText, request.status);
				request.onreadystatechange = function() {};
			}
		}
	}

	request.open('GET', url, true);
	try {
		request.send(null);
	} catch (e) {
		changeStatus(e);
	}
};

function setMarkerContent(html) {
	infowindow.setContent(html);
}

// Função que cria o marcador e o ajusta ao evento da janela
function createMarker(map,point,name,id,color) {
	var marker = new google.maps.Marker({
        position: point,
        map: map,
		icon: 'base/imagens/markers/'+color+'-dot.png'
    });  
	if ( infowindow ) {
		infowindow.close();
	}
	infowindow = new google.maps.InfoWindow();
	google.maps.event.addListener(marker, "click", function() {
		infowindow.setContent('<br><br><br><br><br><br><center><img src="base/imagens/process_animation.gif" alt="Aguardando.."></center><br><br><br><br><br><br>');
        var jsonStrDetalhe = '{';
        for ( i in arrParametrosDetalhe ) {
            jsonStrDetalhe += i==0?'':',';
            jsonStrDetalhe += '"'+arrParametrosDetalhe[i].toUpperCase()+'":';
            jsonStrDetalhe += i==0?'"'+id+'"':'"'+document.getElementById(arrParametrosDetalhe[i]).value+'"';
        }
        jsonStrDetalhe += '}';
		var url = 'base/callbacks/getGeoDetalhe.php'+
					'?pacoteFuncao='+encodeURIComponent(pacoteFuncaoProcDetalhe)+
					'&cacheTime='+encodeURIComponent(cache)+
					'&parametros='+encodeURIComponent(jsonStrDetalhe); 
		downloadUrl(url,setMarkerContent);
		infowindow.open(map,marker);
	});

	// salva a informação q vc precisa para ser usada posteriormente na side_bar
	gmarkers[i] = marker;

	// adiciona uma linha para a side_bar-html
	side_bar_html += '<a href="javascript:myclick(' + i + ')">' + name + '</a><br>';
	i++;
	return marker;
}

// Esta função é para capturar o click e abrir a info window correspondente
function myclick(i) {
	google.maps.event.trigger(gmarkers[i],'click');
}

// === Funcao que processa o arquivo TXT / Dados do Banco ===
processarDadosBanco = function(doc) {
	var id;
	var point;
	var lat;
	var lon;
	var line;
	var label;
	var color;
	var i;
	var x;

	if ( doc.match(/Erro: /) ) {
		alert(doc);
		return;
	}       
	if ( !doc || doc.length == 0 ) { 
        fwUnBlockScreen();
		return;
	}
	// JSON.parse não funciona no mei IE 8! RFC 4627 propoe o seguinte código:wq:wq
    var lines = !(/[^,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]/.test(doc.replace(/"(\\.|[^"\\])*"/g, ''))) &&
                eval('(' + doc + ')');

	if ( lines[0] && lines[0]['LABEL'] ) {
		document.getElementById("side_bar").style.width="250px";
		document.getElementById("side_bar").style.paddingLeft="5px";
	}
	
	for ( i=0; i<lines.length; i++) {
		line = lines[i];
		var lat = parseFloat(line['LATITUDE']);
		var lon = parseFloat(line['LONGITUDE']);
		label = line['LABEL']?line['LABEL']:null;
		color = line['MARKERCOLOR']?line['MARKERCOLOR']:null;
		id = line['ID']?line['ID']:null;
		point = new  google.maps.LatLng(parseFloat(line['LATITUDE']),parseFloat(line['LONGITUDE']));
		bounds.extend(point);
		// cria o marcador e coloca no mapa
		createMarker(map,point,label,id,color);
	}
	map.fitBounds(bounds);
	if ( i == 1 && map.getZoom() > 10 ) {
		map.setZoom(10);
	}
	if ( i==0 ) {
		map.setOptions({center:mapCenter,zoom:4});
	}
	// coloca o conteudo na Side_Bar
	document.getElementById("side_bar").innerHTML = side_bar_html;

	// Esconder GreyBox    
    fwUnBlockScreen();
}          

function processar() {
	if ( infowindow ) {
		infowindow.close();
	}
	for (var i in gmarkers) {
		gmarkers[i].setMap(null);
	}
	gmarkers = [];
	side_bar_html = '';
	bounds = null;
	bounds = new google.maps.LatLngBounds(); 
	document.getElementById("side_bar").style.width="0px";
	document.getElementById("side_bar").style.paddingLeft="0px";

	var jsonStr = '{';
	for ( i in arrParametros ) {
		jsonStr += i==0?'':',';
		jsonStr += '"'+arrParametros[i].toUpperCase()+'":';
		jsonStr += '"'+document.getElementById(arrParametros[i]).value+'"';
	}
	jsonStr += '}';
	if ( arrParametros && document.getElementById(arrParametros[0]).value ) {
        fwBlockScreen(null,null,'base/imagens/process_animation.gif','Processando. Aguarde...',100,100);
		var url = 'base/callbacks/getGeo.php?pacoteFuncao='+encodeURIComponent(pacoteFuncaoProc)+'&cacheTime='+encodeURIComponent(cache)+'&parametros='+encodeURIComponent(jsonStr);
		downloadUrl(url,processarDadosBanco); 
	}
}

function inicializarMapa(pacoteFuncao,parametros,pacoteFuncaoDetalhe,parametrosDetalhe,cacheTime) {
	// Esta variável ira conter o HTML que eventualmente será colocado no painel Side_bar
	var side_bar_html = "";

	// Funcao e campos a serem usados para pesquisa em banco
	pacoteFuncaoProc = pacoteFuncao;
	pacoteFuncaoProcDetalhe = pacoteFuncaoDetalhe;
	arrParametros = parametros.split(",");
	arrParametrosDetalhe = parametrosDetalhe.split(",");
	cache = cacheTime || -1;
	var erro = false;
	for ( i in arrParametros ) {
		if (  !document.getElementById(arrParametros[i]) ) {
			alert('Campo '+arrParametros[i]+' não encontrado!');
			erro = true;
		} 
	}
	if ( erro ) {
		return;
	}

	// arrays que contem copias dos marcadores e do html usado pela "side_bar"
	// porque a função closure trick não funciona aqui.
	gmarkers = [];
	i = 0;

	// cria o mapa
	mapCenter = new google.maps.LatLng(-14.5, -53);
	var myOptions = {
  		zoom: 4,
  		center: mapCenter,
  		MapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map"), myOptions);

	side_bar_html = "";
	processar();
}
 
  // Referencias utilizadas por Mário Pucci:
  // Blackpool Community Church Javascript Team
  // http://www.commchurch.freeserve.co.uk/   
  // em 08/07/2008   -    Versão: 0.1


