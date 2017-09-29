
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
* Converte de Grau decimal para Graus Minuto segundos direção
* EX: fwDecimalDegrees2Gms('-7.161829',"LA");
* @return string[] resultado
*/
function fwDecimalDegrees2Gms(pCoordinated,pType){

	return fwGd2dms(pCoordinated,pType,true);
}

/**
* Converte de Graus Minuto segundos para Graus decimal
* EX: fwGms2decimalDegrees(7, 9, 35, 'S');
* @return string resultado
*/
function fwGms2decimalDegrees(pGrau, pMinuto, pSegundo, pDirecao){
   return fwGms2gd(pGrau,pMinuto,pSegundo, pDirecao)
}

/*
 * Recebe o id do campo GMS ou as coordenadas e converte para decimal degree
 * Ex: fwDms2dd('campo_gms1');
 * ou fwDms2dd(null,20,30,40,'LAT');
 */
function fwDms2dd(field,latlon,deg,min,sec,hem)
{
    if( field )
    {
		deg = jQuery("#"+field+'_'+latlon.toLowerCase()+'_grau').val();
		min = jQuery("#"+field+'_'+latlon.toLowerCase()+'_min').val();
		sec = jQuery("#"+field+'_'+latlon.toLowerCase()+'_seg').val();
		hem = jQuery("#"+field+'_'+latlon.toLowerCase()+'_hem option:selected').val();
    }
    deg = parseInt(String(deg).replace(/[^0-9]/,''),10)
    min = parseInt(String(min).replace(/[^0-9]/,''),10);
    sec = parseFloat(String(sec).replace(/,/,'.'));
    if ( latlon.toUpperCase() == 'LAT' )
    {

		if ( hem.toUpperCase() == 'N' ) {
		    //return deg+min/60+sec/3600;
		    return fwGms2gd(deg,min,sec,'N')
		}
		else
		{
		    //return -deg-min/60-sec/3600;
		    return fwGms2gd(deg,min,sec,'S')
		}
    }
    if ( latlon.toUpperCase() == 'LON' )
    {
        return fwGms2gd(deg,min,sec,'W')
   		//return -deg-min/60-sec/3600;
    }
}

/*
 * Converte coordenada decimal para GMS
 * Ex: fwDd2dms(45.5454578,'LAT');
 */
function fwDd2dms(dd,latlon)
{
    dd = parseFloat(String(dd).replace(/\,/,'.'));
    if( isNaN( dd ) )
    {
    	return [];
	}
    var deg = Math.floor(Math.abs(dd));
    var min = Math.floor((Math.abs(dd)-deg)*60);
    var sec = String((60*((Math.abs(dd)-deg)*60-min)).toFixed(2)).replace(/\./,',');
    var result=[];
    if ( latlon == 'LAT' )
    {
	result.deg = deg;
	result.min = min;
	result.sec = sec;
	result.hem = ( dd <= 0.000000 ? 'S' : 'N');
}
    if ( latlon == 'LON' ) {
	result.deg = deg;
	result.min = min;
	result.sec = sec;
    result.hem = 'W';
    }
    return result;
}

/**
 * Atualiza o campo GMS do formulário via java
 */
function fwSetGmsField(id,lat,lon)
{
   // latitude
   var l = fwGd2dms(lat,'LAT');
   jQuery("#"+id+'_lat_grau').val(l.g);
   jQuery("#"+id+'_lat_min').val(l.m);
   jQuery("#"+id+'_lat_seg').val(l.s);
   jQuery("#"+id+'_lat_hem').val(l.h);

   jQuery("#"+id+'_lat_grau_disabled').val(l.g);
   jQuery("#"+id+'_lat_min_disabled').val(l.m);
   jQuery("#"+id+'_lat_seg_disabled').val(l.s);
   jQuery("#"+id+'_lat_hem_disabled').val(l.h);
   // longitude
   var l = fwGd2dms(lon,'LON');
   jQuery("#"+id+'_lon_grau').val(l.g);
   jQuery("#"+id+'_lon_min').val(l.m);
   jQuery("#"+id+'_lon_seg').val(l.s);
   jQuery("#"+id+'_lon_hem').val(l.h);

   jQuery("#"+id+'_lon_grau_disabled').val(l.g);
   jQuery("#"+id+'_lon_min_disabled').val(l.m);
   jQuery("#"+id+'_lon_seg_disabled').val(l.s);
   jQuery("#"+id+'_lon_hem_disabled').val(l.h);
}

/**
* Função para converter Graus Decimais em Graus, minutos, Segundos e Hemisfério
*/
function fwGd2dms(gd,latLon,formated) {
	formated = formated || false;
    var gms = {};
    var gdAbs = Math.abs(gd);
    gms.g = Math.floor(gdAbs);
    gms.m = Math.floor(60*gdAbs - 60*gms.g);
    gms.s = (3600*gdAbs - 60*gms.m - 3600*gms.g).toFixed(2);
    if ( gms.s > 59 ) {
        gms.s = 0;
        gms.m += 1;
        if ( gms.m > 59 ) {
            gms.m=0;
            gms.g += 1;
        }
    }
    gms.h='';
    if( latLon.match(/lat/i) )
    {
    	gms.h = ( gd > 0 ? 'N' : 'S' ) ;
	}
    else if(    latLon.match(/lon/i) )
    {
    	gms.h = ( gd > 0 ? 'E' : 'W' ) ;
    }
    if( formated )
    {
	   return gms.h + " " + gms.g + "º " + gms.m + "&rsquo; " + gms.s + "&quot;";
	}
	else
	{
    	return gms;
	}
}

/**
* Função para converter Graus, minutos, segundos e Hemisfério para graus decimais
*/
function fwGms2gd(g,m,s,h) {

	if( g === '' )
	{
		return 0;
	}
	s = String(s).replace(',','.');
	var gInt = parseInt(g);
	var mInt = parseInt(m);
	var sFloat = parseFloat(s);

    var gd = gInt + mInt/60 + sFloat/3600;
    if ( h.match( /w|s/i) )
    {
     	return gd * -1;
    }
    else
    {
    	return gd;
	}
}