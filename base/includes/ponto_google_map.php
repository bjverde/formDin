<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<script type="text/javascript" src="<?= $_SERVER["HTTPS"]=='on'?'https':'http'?>://maps.google.com/maps/api/js?v=3.1&sensor=false&language=pt_BR&region=BR"></script>
</head>
<body onload="start()">
<div id="cab" style="font-family:Aria; font-size:12px;height:40px;border:none;">
	<table border="0" width="99%" cellpadding="0" cellspacing="0" style="border:1px solid blue;background-color:#efefef;">
		<tr>
			<td rowspan="2" height="20px" width="*" nowrap="nowrap" style="font-size:12px;text-align:center;border-right:1px solid blue;">
                <b><span id="fwMapHeader"></span></b>
			</td>
			<td style="width:100px;color:blue;border-right:1px solid blue;padding-left:5px;" id="tdLatCoord" nowrap="nowrap">
			&nbsp;
			</td>
			<td style="width:100px;color:blue;padding-left:5px;" id="tdLatCoordGms" nowrap="nowrap">
			&nbsp;
			</td>
		</tr>
		<tr>
			<td style="width:100px;color:blue;border-right:1px solid blue;padding-left:5px;" id="tdLonCoord" nowrap="nowrap">
			&nbsp;
			</td>
			<td style="width:100px;color:blue;padding-left:5px;" id="tdLonCoordGms" nowrap="nowrap">
			&nbsp;
			</td>
		</tr>
	</table>
</div>
<div id="map" style="width:99%;height:375px;border:1px solid blue;"></div>
</body>
</html>
<script>
var map;
function start()
{
	document.getElementById('map').style.height="<?php print($_REQUEST['h']); ?>px";
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
    <?php
    	$_REQUEST['zoom'] = isset( $_REQUEST['zoom'] ) && $_REQUEST['zoom'] ? $_REQUEST['zoom'] : "4";
    	$_REQUEST['mapType'] = isset( $_REQUEST['mapType'] ) && $_REQUEST['mapType'] ? $_REQUEST['mapType'] : "roadmap";
    ?>

	var mapCenter = new google.maps.LatLng(-14.5, -53);
	var myOptions = {
  		zoom: 4,
  		center: mapCenter,
  		MapTypeId: google.maps.MapTypeId.ROADMAP
	};
    /*
    MapTypeId.ROADMAP: exibe a visualização de mapas rodoviários padrão
    MapTypeId.SATELLITE: exibe imagens de satélite do Google Earth
    MapTypeId.HYBRID: exibe uma mistura de visualizações normais e de satélite
    MapTypeId.TERRAIN: exibe um mapa físico com base nas informações do terreno.
    */

	map = new google.maps.Map(document.getElementById("map"), myOptions);

    map.readonly = ( request('readonly') ==  'true' );

    //alert( request('readonly') );
    map.headerText ="<?php print($_REQUEST['mapHeaderText']); ?>";
    map.headerFontColor = request('mapHeaderFontColor');
    map.headerFontSize = request('mapHeaderFontSize');

    map.callback = request('mapCallback');
    map.lat = String(request('lat')).replace(',','.');
    map.lon = String(request('lon')).replace(',','.');
    if( map.headerText )
    {
        document.getElementById('fwMapHeader').innerHTML = map.headerText;
    }
    else
    {
        if( !map.lat )
        {
            if ( map.readonly )
            {
                document.getElementById('fwMapHeader').innerHTML ='Consulta de Coordenada Geográfica';
            }
            else
            {
                document.getElementById('fwMapHeader').innerHTML ='Clique com o botão direito do mouse sobre o mapa para selecionar o ponto.';
            }
        }
    }
    if( map.headerFontSize )
    {
        document.getElementById('fwMapHeader').style.fontSize = map.headerFontSize+'px';
    }
    if( map.headerFontColor )
    {
        document.getElementById('fwMapHeader').style.color = map.headerFontColor;
    }

	google.maps.event.addListener(map,"mousemove",function(event)
	{
   	   document.getElementById("tdLatCoord").innerHTML = "Latitude(y):&nbsp;&nbsp;" + event.latLng.lat().toFixed(6);
   	   document.getElementById("tdLonCoord").innerHTML = "Longitude(x):&nbsp;" + event.latLng.lng().toFixed(6);
	   document.getElementById("tdLatCoordGms").innerHTML = fwDecimalDegrees2Gms(event.latLng.lat().toFixed(6),"LA");
	   document.getElementById("tdLonCoordGms").innerHTML = fwDecimalDegrees2Gms(event.latLng.lng().toFixed(6),"LO");
	});

    if( ! map.readonly )
    {
        google.maps.event.addListener(map, 'rightclick', updateFormField );
    }
	var lat;
	var lon;
	var ponto={};
	// ler as coordenadas informadas no formulario
	var field		= request('updateField');
	var winId 		= request('prototypeId');

	// latitude
	var signlat;
	var latAbs ;
	var latGrau;
	var latMin;
	var latSeg;
	var latCenter;

	// longitude
	var signlon;
	var lonAbs;
	var lonGrau;
	var lonMin;
	var lonSeg;
	var lonCenter;
	<?php
		echo 'var zoom = '.$_REQUEST['zoom'].';';
	?>
	//var zoom = 4;
    if( !map.lat)
    {
        if( top.app_prototype)
        {
            // latitude
            latGrau = top.Windows.getWindow(winId).getContent().contentWindow.fwGetObj(field+'_lat_grau').value;
            latMin 	= top.Windows.getWindow(winId).getContent().contentWindow.fwGetObj(field+'_lat_min').value;
            latSeg	= top.Windows.getWindow(winId).getContent().contentWindow.fwGetObj(field+'_lat_seg').value;
            latCenter	= top.Windows.getWindow(winId).getContent().contentWindow.fwGetObj(field+'_map_lat_center').value;
            if( top.Windows.getWindow(winId).getContent().contentWindow.fwGetObj(field+'_lat_hem').selectedIndex == 0 )
            {
                signlat = -1; // norte
            }
            else
            {
                signlat = 1; // sul
            }
            // longitude
            lonGrau = top.Windows.getWindow(winId).getContent().contentWindow.fwGetObj(field+'_lon_grau').value;
            lonMin	= top.Windows.getWindow(winId).getContent().contentWindow.fwGetObj(field+'_lon_min').value;
            lonSeg	= top.Windows.getWindow(winId).getContent().contentWindow.fwGetObj(field+'_lon_seg').value;
			zoom	= top.Windows.getWindow(winId).getContent().contentWindow.fwGetObj(field+'_map_zoom').value;
            lonCenter	= top.Windows.getWindow(winId).getContent().contentWindow.fwGetObj(field+'_map_lon_center').value;
            signlon = -1;
        }
        else
        {
            // latitude
            latGrau = parent.fwGetObj(field+'_lat_grau').value;
            latMin 	= parent.fwGetObj(field+'_lat_min').value;
            latSeg	= parent.fwGetObj(field+'_lat_seg').value;
            latCenter	= parent.fwGetObj(field+'_map_lat_center').value;
            if( parent.fwGetObj(field+'_lat_hem').selectedIndex == 0 )
            {
                signlat = 'S'; // sul

            }
            else
            {
                signlat = 'N'; // norte
            }
            // longitude
            lonGrau = parent.fwGetObj(field+'_lon_grau').value;
            lonMin	= parent.fwGetObj(field+'_lon_min').value;
            lonSeg	= parent.fwGetObj(field+'_lon_seg').value;
            lonCenter	= parent.fwGetObj(field+'_map_lon_center').value;
            zoom	= parent.fwGetObj(field+'_map_zoom').value;
            signlon = 'W';
        }
        var lat = dms2dd(latGrau,latMin,latSeg,signlat);
        var lon = dms2dd(lonGrau,lonMin,lonSeg,signlon);
        ponto = {lat:lat,lon:lon};
    }
    else
    {
        ponto.lat = map.lat;
        ponto.lon = map.lon;
    }
	if( ponto && ponto.lat != 0 && ponto.lon !=0 )
	{
		point = new  google.maps.LatLng(ponto.lat,ponto.lon);
		bounds = new google.maps.LatLngBounds();
		bounds.extend(point);
		// cria o marcador e coloca no mapa
		var marker = new google.maps.Marker({
    		position: point,
	        map: map
	    });
	}
	else if ( latCenter && lonCenter )
	{
		point = new  google.maps.LatLng(latCenter, lonCenter);
	}
	else
	{
		point = new  google.maps.LatLng(-14.5, -53);
	}

	if( zoom )
	{
		map.setZoom( parseInt( zoom ) );
	}
	map.setCenter(point);
	<?php
    if( strtoupper( $_REQUEST['mapType'] ) == 'ROADMAP' || strtoupper( $_REQUEST['mapType'] ) == 'SATELLITE' || strtoupper( $_REQUEST['mapType'] ) == 'TERRAIN' || strtoupper( $_REQUEST['mapType'] ) == 'HYBRID' )
    {
		echo 'map.setMapTypeId("'.strtolower( $_REQUEST['mapType'] ).'");';
	}
	?>
}
//-----------------------------------------------------------------------------------
function updateFormField(event)

{
	var field		= request('updateField');
	var winId 		= request('prototypeId');

	// ponto clicado no mapa
	var lat 		= event.latLng.lat();
	var lon			= event.latLng.lng();

	var latDMS = dd2dms(lat,'LAT');
	var lonDMS = dd2dms(lon,'LON');

	parent.fwSetFields(field+'_lat_grau', latDMS.d );
    parent.fwSetFields(field+'_lat_min',latDMS.m);
	parent.fwSetFields(field+'_lat_seg',String(latDMS.s).replace('.',','));
    if( latDMS.h == 'S' )
	{
		parent.fwGetObj(field+'_lat_hem').selectedIndex=0; // sul
	}
	else
	{
		parent.fwGetObj(field+'_lat_hem').selectedIndex=1; // norte
	}
    parent.fwSetFields(field+'_lon_grau',lonDMS.d);
	parent.fwSetFields(field+'_lon_min',lonDMS.m);
	parent.fwSetFields(field+'_lon_seg',String(lonDMS.s).replace('.',',') );
	parent.fwSetFields(field+'_lon_hem','W');

	if( map.callback )
	{
        if( typeof parent.window[ map.callback ] == 'function')
        {
			parent.window[map.callback](lat,lon,map.getZoom(),latDMS,lonDMS,event,map);
		}
	}
	// enviar nivel de zoom do mapa para o formulario
	parent.fwSetFields(field+'_map_zoom',map.getZoom());
	parent.jQuery.facebox.close();
}

function request( name )
{
  url = window.location.href;
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( url );
  if( results == null )
	return "";
  else
	return results[1];
}


/**
* Converte de Grau decimal para Graus Minuto segundos direção
* EX: fwDecimalDegrees2Gms('-7.161829',"LA");
* @return string[] resultado
*/
function fwDecimalDegrees2Gms(pCoordinated,pType)
{
   var v_type = pType.toUpperCase();
   // valida o tipo de coordenada: LA => latitude, LO => longitude
   if(v_type!="LA" && v_type!="LO"){
       return false; //alert("O tipo (LA)titude ou (LO)ngitudeinformado é inválido!")
   }
   var v_coordinated = new String(pCoordinated);
   // verifica a direção
   var v_direction = (v_coordinated.substring(0,1)=="-")?"W":"E";
   if(v_type=="LA"){
           v_direction = (v_coordinated.substring(0,1)=="-")?"S":"N";
   }
   // retira o "-" se direção for "S" ou "W"
   if(v_direction=="S" || v_direction=="W"){
           v_coordinated = v_coordinated.substring(1,v_coordinated.length);
   }
   // pega os graus
   var graus = parseInt(v_coordinated);
   // pega os minutos
   // concatena "0." com os minutos da latitude, multiplica por 60 e pega a parte inteira dos minutos
   var minutos = "0."+v_coordinated.split(".")[1];
   minutos = 60 * minutos / 1;
   minutosOK = new String(minutos).split(".")[0];
   minutosOK = (isNaN(minutosOK))?"0":minutosOK;
   // pega os segundos
   // concatena "0." com os segundos dos minutos, multiplica por 60 e pega a parte inteira dos segundos
   // OBS: despresamos os milesimos de segundos
   var segundos = "0." + new String(minutos).split(".")[1];
   segundos = 60 * segundos / 1;
   segundos = new String(segundos).split(".")[0];
   segundos = (isNaN(segundos))?"0":segundos;

   // retorno em forma de array
   var aRes = [v_direction,pad( graus ,3,' ',1),pad( minutosOK ,3,' ',1),pad( segundos,3,' ',1) ];
   return aRes[0] + " " + aRes[1] + "º " + aRes[2] + "` " + aRes[3] + "``";
}
var STR_PAD_LEFT = 1;
var STR_PAD_RIGHT = 2;
var STR_PAD_BOTH = 3;
function pad(str, len, pad, dir)
{

	if (typeof(len) == "undefined") { var len = 0; }
	if (typeof(pad) == "undefined") { var pad = ' '; }
	if (typeof(dir) == "undefined") { var dir = STR_PAD_LEFT; }

	if (len + 1 >= str.length)
	{

		switch (dir){

			case STR_PAD_LEFT:
				str = Array(len + 1 - str.length).join(pad) + str;
			break;

			case STR_PAD_BOTH:
				var right = Math.ceil((padlen = len - str.length) / 2);
				var left = padlen - right;
				str = Array(left+1).join(pad) + str + Array(right+1).join(pad);
			break;

			default:
				str = str + Array(len + 1 - str.length).join(pad);
			break;

		} // switch

	}
	return str;
}

//------------------------------------------------------------------------------------------

function dd2dms(dd,latLon) {
    var dms = {};
    var ddAbs = Math.abs(dd);
    dms.d = Math.floor(ddAbs);
    dms.m = Math.floor(60*ddAbs - 60*dms.d);
    dms.s = (3600*ddAbs - 60*dms.m - 3600*dms.d).toFixed(2);
    if ( dms.s > 59 ) {
        dms.s = 0;
        dms.m += 1;
        if ( dms.m > 59 ) {
            dms.m=0;
            dms.d += 1;
        }
    }
    if( latLon.match(/lat/i) )
    {
    	dms.h = ( dd > 0 ? 'N' : 'S' ) ;
	}
    else if(    latLon.match(/lon/i) )
    {
    	dms.h = ( dd > 0 ? 'E' : 'W' ) ;
    }
    return dms;
}

function dms2dd(d,m,s,h) {

	if( d === '' )
	{
		return 0;
	}
	s = s.replace(',','.');
	var dInt = parseInt(d);
	var mInt = parseInt(m);
	var sFloat = parseFloat(s);

    var ddAbs = dInt + mInt/60 + sFloat/3600;
    if ( h.match( /w|s/i) )
    {
     	return ddAbs * -1;
    }
    else
    {
    	return ddAbs;
	}
}
</script>
