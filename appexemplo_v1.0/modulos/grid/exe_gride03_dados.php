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

// criar o formulario com os campos off-line do gride
$frm = new TForm(null,150);

$frm->setcss('background-color','#B4CDCD');

//$frm->addJavascript('gridCallBack(REQUEST)');

$frm->addNumberField('val_salario'		, 'Salario:',10,false,2);
$frm->addSelectField('tip_pagamento'	, 'Tipo Pagamento:',null,'1=Mensal,2=Semanal,3=Diário',false);
$frm->addTextField('nom_moeda'			, 'Moeda:',13,false);
$frm->addTextField('sig_moeda'			, 'Sigla:',4,true,null,null,false)->setAttribute('grid_align','center')->setAttribute('grid_hidden','true');

$frm->addSelectField('cod_uf','Estado:',false,null,true);
$frm->addSelectField('cod_municipio'	,'Município:',null,null,false)->setAttribute('grid_column','NOM_MUNICIPIO');
$frm->combinarSelects('cod_uf','cod_municipio','vw_municipios','cod_uf','cod_municipio','nom_municipio','-- Municípios --','0','Nenhum Município Encontrado','cod_regiao','callBackSelectCombinado()');

// fazer a validação manualmente
$_REQUEST['action'] = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
if( $_REQUEST['action'] == 'save'){
	if( ! $frm->get('nom_moeda') ){
		$frm->addError('O campo Moeda é de preenchimento Obrigatório');
	}
}
/*session_start();
session_destroy();
session_start();
*/
//error_reporting(E_ALL);
//d($_SESSION);
//print_r($_SESSION['FORMDIN']['offline']['gdx']['DES_OBS']);

//$_SESSION[APLICATIVO]['offline']=NULL;
// criar o gride
$res = null;
$res['SEQ_MOEDA'][0] 		= 10;
$res['SEQ_DOCUMENTO'][0] 	= 12;
$res['NOM_MOEDA'][0] 		= 'Dolar';
$res['SIG_MOEDA'][0] 		= 'US$';
$res['TIP_PAGAMENTO'][0] 	= 2;
$res['DES_OBS'][0]			= 'Valor Inicial';
$res['VAL_SALARIO'][0]	  	= '80,00';
$res['COD_UF'][0]	  		= '22';
$res['COD_MUNICIPIO'][0]	= null;
$res['NOM_MUNICIPIO'][0]	= null;

$res['SEQ_MOEDA'][1] 		= 11;
$res['SEQ_DOCUMENTO'][1] 	= 12;
$res['NOM_MOEDA'][1] 		= 'Real';
$res['SIG_MOEDA'][1] 		= 'R$';
$res['TIP_PAGAMENTO'][1] 		= 1;
$res['DES_OBS'][1]			= 'Valor Inicial 2';
$res['VAL_SALARIO'][1]	  	= '100,00';
$res['COD_UF'][1]	  		= '12';
$res['COD_MUNICIPIO'][1]	= '1200013';
$res['NOM_MUNICIPIO'][1]	= 'ACRELANDIA';

$grid = new TGrid('gdx','Dados Off-line'
					,$res
					,null
					,null
					,'SEQ_MOEDA,SEQ_DOCUMENTO'
					,null
					,null
					,'grid/exe_gride03_dados.php');

// adicionar o formulário ao gride para criar o gride offline
$grid->setForm($frm,false);

$grid->setShowAdicionarButton(true); // exibir o botão de adicionar - default =  true

// Exemplo de como alterar a largura e o alinhamento da coluna Moeda.
$grid->setOnDrawHeaderCell('drawHeader');

$grid->show();

function drawHeader($objTh,$objCol,$objHead)
{
	if( $objCol->getFieldName() == 'NOM_MOEDA')
	{
		$objHead->setCss('width','250px');
		$objCol->setTextAlign('center');
	}
}

/*$tb = new TTable();
$tb->setCss('font-size','12px');
$row = $tb->addRow();
$row->addCell('<center>Exemplo dos dados do Grid que estão na variável de sessão:<br><b>$_SESSION[APLICATIVO]["offline"]["gdx"]</b></center>');
$row = $tb->addRow();
$row->addCell('<pre><div style="border:1px dashed black;width:540px;height:150px;overflow:hidden;overflow-y:auto;">'.print_r($_SESSION[APLICATIVO]['offline']['gdx'],true).'</div></pre>');
$tb->show();
*/
?>
