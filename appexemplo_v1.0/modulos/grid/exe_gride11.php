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

//echo '<pre>'; print_r($_SESSION);  echo '</pre>';
$frm = new TForm('Exemplo de Gride "offline"',500,600);

$frm->addJsFile($this->getBase().'/js/jquery/jquery.autocomplete.dylan.js');
$frm->addCssFile($this->getBase().'/css/jquery/jquery.autocomplete.dylan.css');

$frm->addDateField('dat_nascimento','Data:',true);
$frm->addHiddenField('cod_moeda','10');

//$frm->addHtmlGride('campo_moeda','base/exemplos/gride_offline.php','gdx',null,null,null,null,'cod_moeda,dat_nascimento' )->setWidth(560);
$frm->addHtmlField('campo_moeda', montar_gride() );

$frm->setAction('Gravar,Novo');
$frm->addButton('Validar com Js',null,'btnValidarJs','fwValidateFields()');
$frm->show();

$acao = isset($acao) ? $acao : null;
if ($acao == 'Novo') {
	$frm->clearFields ();
} else if ($acao == 'Gravar') {
	if ($frm->validate ()) {
		
		// d($_SESSION[APLICATIVO]);
		$res = $frm->createBvars ( 'campo_moeda' );
		// d($res);
		foreach ( $res as $k => $v ) {
			// d($k,'$k');
			// d($v,'$v');
		}
	}
}
function montar_gride()
{
	return 'grid off line';

	$frm = new TForm(null,200,500);
 	$frm->addJavascript('gridCallBack()');
 	$frm->addTextField('tx_especie_nativa'		,'Especie:',50,true)->setExampleText('ex: mogno');
	$frm->addTextField('des_nome_popular'		,'Nome Popular:',20);
	$frm->setAutoComplete( 'tx_especie_nativa'
	                       ,'CAR.PKG_CAD_CAR.SEL_TAXON'
	                       ,'NOM_CIENTIFICO'
	                       ,'DES_NOME_POPULAR'
	                       ,false
	                       ,null
	                       ,null
	                       ,4
	                       ,1000
	                       ,50
	                       ,null
                        );

 	$res['SEQ_MOEDA'][0] 		= 1000;
	$res['NOM_MOEDA'][0] 		= 'Dollar';
	$res['SIG_MOEDA'][0] 		= 'US$';
	$res['NOM_ANEXO'][0] 		= 'imagem.jpg';
	$res['TX_ESPECIE_NATIVA'][0] = 'Nome da especie nativa';
	$res['OBS_ANEXO'][0] 		= 'asdçfkasd fasdfasdfasdfasdfasd fasdf asdf asdf';
	$res['DES_NOME_POPULAR'][0] 		= 'Nome popular teste';
	$res['SIT_CANCELADO'][0] 	= 'N';
	$grid = new TGrid('gdx','Gride Off-line',$res,null,550,'SEQ_MOEDA',null,null,'modulos/grid/exe_gride12.php');
	$grid->setForm($frm,false);
	return $grid->show(false);
}
?>


<script>
function callback_autocomplete_especies()
{
	alert( 'Callback do autocomplente chamado!')
}
function gridCallBack()
{
	//alert( 'Uma Ação no grid off-line foi executada!\nPara definir uma função de callback basta inserir o nome da função no formulário do gride off-line, neste caso foi no arquivo gride_offline.php');
}
</script>
