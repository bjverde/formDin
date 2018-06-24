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

$frm = new TForm('Campo Coordendada Geográfica (GMS)');
$frm->setOnlineDoc(true);
//$frm->addJsFile('FormDin4Geo.js');
$frm->disableCustomHint();
$frm->addCoordGMSField('num_gms1', 'Coordenada Geográfica:', false, true, null, null, 'NUM_LAT', 'NUM_LON')->setMapHeaderText('meu cabecalho')->setMapHeaderFontColor('red')->setMapHeaderFontSize('14px')->setMapCallback('mapCallback');
//$frm->addCoordGMSField('campo_gms','Coordenadas Geográficas:',false,true,null,null,'NUM_LAT','NUM_LON')->setMapCallback('mapCallback')->setMapZoom(10);
//$frm->addCoordGMSField('num_gms2','Coordenada Geográfica:',false,true,null,null,'NUM_LAT','NUM_LON','Grau:,Minutos:,Segundos:',null,null,null,null,null,null,'Teste',null,null)->setEnabled(false);
$frm->addButton('Teste', null, 'btnTeste', 'testar()');
$frm->addButton('Abrir Map', null, 'btnMapa', 'showPointGoogleMap()');
$frm->addButton('Grau Decimal', null, 'btnGrauDecimal', 'showGrauDecimal("num_gms1")');
$frm->addButton('Set Js', null, 'btnSetJs', 'fwSetGmsField("num_gms1",-5.338611111111111,-35.68499999999999)');

$frm->setAction('Inicializar,Gravar,SetLat e setLon');

if (isset($acao)) {
    if ($acao =='Gravar') {
        //d($_POST);
        $bvars = $frm->createBvars('num_gms1');
        d($bvars);
    } elseif ($acao=='Inicializar') {
        //Latitude: -5.300947222222222
        //Longitude: -35.71515555555556
        $frm->getField('num_gms1')->setLat('-5.300947222222222');
        $frm->getField('num_gms1')->setLon('-35.71515555555556');
        /*
         * 5, 18 , 3,41
         * 35, 42, 54,56
         */
    }
}
$frm->show();
?>
<script>
function showPointGoogleMap()
{
    var y='-15.767299';
    var x='-47.861102';
    fwFieldCoordShowMap(null,600,900,{"lat":y,"lon":x,"mapHeaderText":"CONSULTA MAP","mapHeaderFontColor":"blue","mapHeaderFontSize":"16","zoom":"17","mapType":"satellite"});
}

function showGrauDecimal(field)
{
    alert( "Latitude: "+fwDms2dd(field,'LAT')+'\nLongitude: '+fwDms2dd(field,'LON') );
    //alert( dms2dd('field','LON'));
}

function mapCallback(lat,lon,zoom,latDMS,lonDMS,event,map)
{
    var latitude        = event.latLng.lat();
    var longitude       = event.latLng.lng();

    alert( 'Callback chamado.\nSelecionado: LAT:'+lat+' LON:'+lon+'\nZoom:'+zoom
    +'\nLat Degree :'+latDMS.d
    +'\nLat Minute :'+latDMS.m
    +'\nLat Second :'+latDMS.s
    +'\nLatitude   :'+latitude
    +'\nLongitude  :'+longitude
    +'\nZoom       :'+map.getZoom()
    );
}
</script>
