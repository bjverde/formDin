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
$frm->disableCustomHint();
$frm->addCoordGMSField('num_gms1','Coordenada Geográfica:',false,true,null,null,'NUM_LAT','NUM_LON');
$frm->addCoordGMSField('num_gms2','Coordenada Geográfica:',false,true,null,null,'NUM_LAT','NUM_LON','Grau:,Min:,Seg:');
$frm->addButton('Map',null,'btnMapa','showPointGoogleMap()');
$frm->setAction('Atualizar,Gravar,Inicializar');
//$frm->addJsFile('http://maps.google.com/maps/api/js?v=3.1&sensor=false&language=pt_BR&region=BR');

if( isset($acao ) )
{
	if($acao =='Gravar')
	{
		$bvars = $frm->createBvars('num_gms1');
		$frm->clearFields();
		d($bvars);

	}
	else if($acao=='Inicializar')
	{
		$frm->getField('num_gms1')->setLat('5.3388888888889');
		$frm->getField('num_gms1')->setLon('-35.685277777778');
	}
}
$frm->show();
?>
<script>
function showPointGoogleMap()
{
	//top.fwModalBox('Consulta Coordenada',top.app_url+"base/includes/ponto_google_map.php",400,700);
	//return;
	if( top.app_prototype )
	{
		top.app_faceBoxIframe(top.app_url+"base/includes/ponto_google_map.php?prototypeId="+fwGetObj('prototypeId').value+'&updateField=num_gms1',400,700);
	}
	else
	{
		fwFaceBoxIframe(top.app_url+"base/includes/ponto_google_map.php?prototypeId=&updateField=num_gms1",400,700);
	}
	//top.fwFaceBoxIframe(top.app_url+app_index_file+"?modulo=base/includes/ponto_google_map.php",450,700);
}
</script>
