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
$g = new TGroup('gp1','Grupo 1',null,null,false);
$g->show();
return;
//$frm->getField('cod_uf')->setEvent('onchange','jQuery("#cod_municipio").val("");jQuery("#nom_municipio").val("");jQuery("#nom_municipio").autocomplete(app_index_file+"?modulo='.$frm->getBase().'callbacks/autocomplete.php&ajax=1", { delay:800, minChars:3, matchSubset:1, matchContains:1, cacheLength:10, onItemSelect:fwAutoCompleteSelectItem, onFindValue:fwAutoCompleteFindValue, matchCase:false, maxItemsToShow:13, autoFill:true, selectFirst:true, mustMatch:false, selectOnly:true,removeMask:false,extraParams:{"tablePackageFunction":"SISPROT.PKG_PROT_GERAL.SEL_MUNIC_SUGESTAO","searchField":"NOM_MUNICIPIO","cacheTime":60,"_u_COD_MUNICIPIO":"cod_municipio","_w_cod_uf":jQuery("#cod_uf").get(0).value} })');




*/

$frm = new TForm('Exemplo de Grupo - Combinados',400);

$g = $frm->addGroupField('gp1','Grupo 1',null,null,null,null,true,'gps',true,true,null,null,true);
	$frm->addTextField('nomeg1','Nomeg1:',40,true);
	$frm->addTextField('nomeg2','Nomeg2:',40,true);
	$frm->addGroupField('subGrupo','Subgrupo');
		$frm->addTextField('nomeg3','Nomeg1:',40,true);
		$frm->addTextField('nomeg4','Nomeg1:',40,true);
		$frm->addTextField('nomeg5','Nomeg1:',40,true);
		$frm->addTextField('nomeg6','Nomeg1:',40,true);
		$frm->addTextField('nomeg7','Nomeg1:',40,true);
	$frm->closeGroup();
$frm->closeGroup();

$frm->addGroupField('gp2','Grupo 2',null,null,null,null,true,'gps',false);
	$frm->addTextField('nomeh1','Nome2:',40,true);
	$frm->addTextField('nomeh2','Nome2:',40,true);
	$frm->addTextField('nomeh3','Nome2:',40,true);
	$frm->addTextField('nomeh4','Nome2:',40,true);
	$frm->addTextField('nomeh5','Nome2:',40,true);
	$frm->addTextField('nomeh6','Nome2:',40,true);
$frm->closegroup();

//$frm->setFlat(true);


/*
$frm->addGroupField('gpExemplo1','Grupo 1');
$frm->closeGroup();
*/
/*
$frm->addGroupField('gpExemplo1','Grupo 1');
$frm->closeGroup();
*/
/*
$frm->addGroupField('gpExemplo2','Grupo 2');
	$frm->addGroupField('gpExemplo2.1','Grupo 2.1');
	$frm->closeGroup();
$frm->closeGroup();
*/

/*
$frm->addGroupField('gpExemplo3','Grupo 3',50,null,null,null,true,'gpx',true);
$frm->closeGroup();
$frm->addGroupField('gpExemplo4','Grupo 4',100,null,null,null,true,'gpx');
	$frm->addTextField('nome','Nome',30);
$frm->closeGroup();
*/
//$frm->addGroupField('gpExemplo4','Grupo 4',100)->setColumns(array(80));
/*
$g = $frm->addGroupField('gpExemplo4','Grupo 4',100,null,null,null,true);
$g->setColumns(array(80));
	$frm->addTextField('nome1','Nome',30);
	$frm->addTextField('nome2','Nome',30);
	$frm->addTextField('nome3','Nome',30);
	$frm->addTextField('nome4','Nome',30);
$frm->closeGroup();
*/

$frm->setAction("Refresh");
$frm->addButton('Limpar',null,'btnLimpar','fwClearChildFields()');
$frm->show();
?>

