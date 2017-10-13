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
TPDOConnection::test(false);

$frm = new TForm('Exemplo do Campo Select',450);

$frm->addHtmlField('html_gp2','<center><b>Este exemplos estão utilizando o banco de dados local "base/exemplos/bdApoio.s3db" (sqlite)</center></b><br/>');


//$frm->addSelectField('estado_norte','Estado Norte:',true,'tb_uf|cod_regiao=1',true,false,null,false,null,null,'-- selecione o Estado --',null,'COD_UF','NOM_UF',null)->setRequired(true)->setValue(12);
$frm->addSelectField('estado','Estado (todos):',true,'tb_uf',true,false,null,false,null,null,'-- selecione o Estado --',null,'COD_UF','NOM_UF',null,'cod_regiao')->addEvent('onChange','select_change(this)')->setToolTip('SELECT - esta campo select possui o código da região adicionado em sua tag option. Para adicionar dados extras a um campo select, basta definir as colunas no parâmetro $arrDataColumns.');

$frm->addGroupField('gp1','Selects Normais');
	$f = $frm->addSelectField('sit_cancelado','Cancelado:',null,'0=Não,1=Sim',null,null,'1')->addEvent('onChange','select_change(this)');
	$f->setOptionsData(array('0'=>'Zero','1'=>'Um') );

	$f=$frm->addSelectField('seq_bioma'	,'Bioma:',true,'CE=CERRADO,PA=PANTANAL,MA=MATA ATLÂNTICA',null,null,null,true,4)->setOptionsData(array('CE'=>array('seq_x'=>'147','nom_x'=>'nome x')));

	$frm->addHtmlField('status');
$frm->closeGroup();


$frm->addGroupField('gp2','Selects Combinados');
	$frm->addSelectField('cod_regiao','Região:',null,'1=NORTE,2=NORDETE,3=SUDESTE,4=SUL,5=CENTRO OESTE,9=UNICA')->setEvent('onchange','regiaoChange()');
	$frm->addSelectField('cod_uf','Estado(s):',false,null,FALSE);

	$frm->addSelectField('cod_municipio'	,'Município:',null,null,false);

	$frm->addSelectField('cod_uf_2','Estado 2:',false);
	$frm->addSelectField('cod_municipio_2'	,'Município 2:',null,null,false);

	$frm->combinarSelects('cod_regiao','cod_uf','tb_uf','cod_regiao','cod_uf','nom_uf',null,null,'Nenhum',null,null,TRUE);

	$frm->combinarSelects('cod_uf','cod_municipio','vw_municipios','cod_uf','cod_municipio','nom_municipio','-- Municípios --','0','Nenhum Município Encontrado','cod_regiao','callBackSelectCombinado()');

	$frm->combinarSelects('cod_uf_2','cod_municipio_2','vw_municipios','cod_uf','cod_municipio','nom_municipio','-- Municípios --','0','Nenhum Município Encontrado');
$frm->closeGroup();

$frm->addGroupField('gp3','Selects Ajax');
 	$frm->addSelectField('cod_estados_ajax'	,'Estado (ajax):');
	$frm->addButton('Preencher',null,'btnMunAjax','lerMunAjax()',null,null,false);
$frm->closeGroup();


$frm->setAction('Atualizar,Validar');
$frm->addButton('Limpar',null,'btnLimpar','btnLimparClick()');
$frm->addButton('Iniciar Estado 2',null,'btnUF2','btnUF2Click()');

if( $acao=='Validar' )
{
	//d($_POST);
	$frm->validate();

	$txt = $frm->getField('seq_bioma')->getText();
	$val = $frm->getField('seq_bioma')->getValue();
	$frm->set('status','<PRE>Biomas selecionado:'.print_r($txt,true).'<br>Valores selecionado:'.print_r($val,true).'<br>CreateBvars:<br>'.print_R($frm->createBvars('seq_bioma'),true).'</PRE>');
}

/*
$frm->set('cod_regiao','3');
$frm->set('cod_uf','32');
$frm->set('cod_municipio','3203353');
*/

// exibir o formulário
$frm->show();
?>
<script>
function btnLimparClick()
{
	//jQuery('#sit_cancelado').get(0).options.length=null;
	//ou
	//jQuery('#sit_cancelado').find('option').remove();
	// ou
	//document.getElementById('sit_cancelado').options.length=null;
	fwClearChildFields();
}
function callBackSelectCombinado(pai,filho)
{
	alert( 'Callback combinar select.\nO campo cod_municipio agora possui '+filho.length+' municípios.\n\nValor do Select Pai ('+pai.id+') ='+pai.value+'\nValor do Select Filho ('+filho.id+') = '+filho.value );
}
function regiaoChange()
{
	alert( 'Rregião foi alterada');
}
function lerMunAjax()
{
	fwFillSelectAjax('cod_estados_ajax','tb_uf','cod_uf','nom_uf',null,'retorno','-- estados --');
}
function retorno(id)
{
	alert( 'O campo '+id+' foi preenchido!' );
}
function btnUF2Click()
{
	var campos = 'cod_uf_2|cod_municipio_2';
	var valores= '52|5200506';
	//fwUpdateFields(campos,valores);
	fwAtualizarCampos(campos,valores);
}

function select_change(e)
{
	if( e.id == 'estado')
	{
 		alert( 'Código da Região: '+jQuery("#"+e.id+' option:selected').attr('data-cod_regiao') );
	}
	else
	{

 		alert( 'data-value = '+jQuery("#"+e.id+' option:selected').attr('data-value') );

	}
}
</script>

