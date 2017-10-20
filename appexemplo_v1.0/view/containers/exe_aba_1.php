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

//error_reporting(E_ALL);
$frm = new TForm('Exemplo - Utilização de Abas 01 ',600,800);
$frm->setMaximize(true);
$frm->setflat(true);
//$pc = $frm->addPageControl('pc',null,null,'pcBeforeClick','pcAfterClick');

//$frm->addGroupField('gpAba','Grupo Com Aba');

$pc = $frm->addPageControl('pc',300,null,null,null);
//$pc = $frm->addPageControl('pc',null,null,null,null);
$acao='';

$p = $pc->addPage('Cadastro Ação',true,true,'aba1',null);


	$pc2 = $frm->addPageControl('pc2',300);
	$pc2->addPage('Sub Aba Ação',true,true,'aba11',null);
	$frm->addTextField('cadastro','Cadastro:',20,true);
	//$frm->addHtmlField('html_texto',null,null,"Observação:",200,500);//->setCss('background-color','yellow');
	$frm->addButton('Selecionar a aba relatório',null,'btnAtivarAba','btnClick()',null,true,false);
	$frm->addButton('Selecionar a aba Histórico',null,'btnAtivarAbaHist','btnClick2()',null,false,false);
	$frm->addButton('Desabilitar aba histórico',null,'btnDesabilitarAba','btnDesabilitarClick()',null,false,false);
	$frm->addButton('Habilitar aba histórico',null,'btnHabilitarAba','btnHabilitarClick()',null,false,false);
	$frm->addButton('Mostrar Erros',null,'btnMostrarErro','MostrarErros()');
	$frm->addMemoField('memo','Obs:',1000,true,60,10);
	$frm->addTextField('campo2','Campo2:',20);
	$frm->addShortCut('F2','aba1');



$pc->addPage('&Relatório',false,true,'abaRelatorio');
	$frm->addGroupField('gpRelatorio','Grupo do Relatório');
		$frm->addMemoField('memo2','Obs:',1000,true,60,10);
    $frm->closeGroup();

$pc->addPage('Histórico',false,true,'aHist');
	$frm->addTextField('historico','Histórico:',20);


$pc->addPage('Orçamento',false,false,'abaOrcamento');
	$frm->addGroupField('gpx','Grupo x');
		$frm->addTextField('orcamento','Orçamento:',20,true)->setHint('teste - teste');
	$frm->closeGroup();
$frm->closeGroup();
//$frm->closeGroup();
//$frm->addTextField('cadastro2','Cadastro:',20);
//$pc->setActivePage('abaHistorico',true);
//$frm->addTextField('descricao','Descrição:',50);
$frm->setAction('Atualizar,Gravar');
//$frm->setMessage('Gravarção realizada com sucesso');
error_reporting(~E_NOTICE);

if($acao=='Gravar')
{
	$frm->validate();
	//$frm->validate('Cadastro Ação');
	//$frm->validate('gpx');
	//$frm->validate('abaOrcamento');
	$pc->getPage('aHist')->setVisible(false);
}
$frm->setAction( 'Teste');
$frm->show();
?>
<script>
function pcBeforeClick(rotulo,container,id)
{
	if( id == 'abarelatorio' )
	{
		//alert('Não é permito acesso a esta aba via mouse');
		return false;
	}
	return true;
}
function btnClick()
{
	//fwGetObj('pc_container_page_abarelatorio_link').onclick();
	//ou
	//fwSelecionarAba(fwGetObj('pc_container_page_abarelatorio_link'));
	// ou
	fwSelecionarAba('abaRelatorio');
}
function btnClick2()
{
	fwSelecionarAba('aHist',null,null,true);
}
function btnDesabilitarClick()
{
	fwDesabilitarAba('aHist');
}

function btnHabilitarAbaClick()
{
	fwDesabilitarAba('aHist');
}

function btnHabilitarClick()
{
	fwHabilitarAba('aHist','pc');

}
function fwAdjustHeight2(frmId,jsonParams)
{
	alert( frmId );
}
function pcAfterClick(aba,pageControl,id)
{
	alert('A função definida no evento afterClick do pageControl,\nfoi chamada e recebeu os seguintes parametros:\n\n'+
	'aba='+aba+'\n'+
	'pageControls='+pageControl+'\n'+
	'id='+id);
}
function MostrarErros()
{
	var obj = jQuery("#formdin_msg_area");
	alert( obj.length );
	obj.addClass("fwMessageAreaError");
	obj.height(150);
	obj.show();
	alert( 'ok');

}
function btnTesteOnClick()
{
	//console.log("formdin_body:" + jQuery('#formdin_body').scrollTop() );
  	//console.log( fwHasVScrollBar("#formdin_body") );

	console.log("body_gpAba_body:" + jQuery('#body_gpAba').scrollTop() );
  	console.log( fwHasVScrollBar("#body_gpAba") );


}
</script>
