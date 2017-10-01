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

$frm = new TForm('Exemplo Utilização de Abas');
$frm->setFlat(true);
$frm->setAutoSize(true);
$frm->addTextField('nom_pessoa','Nome:',50,true);

$pc = $frm->addPageControl('pc',null,null,'pcBeforeClick','pcAfterClick');

//$pc = $frm->addPageControl('pc',null,null);
//$pc = $frm->addPageControl('pc');
$p = $pc->addPage('Cadastro Ação',true,true,null,false);
	$frm->addTextField('cadastro','Cadastro:',20,true);
	//$frm->addHtmlField('html_texto',null,null,"Observação:",200,500);//->setCss('background-color','yellow');
	$frm->addButton('Selecionar a aba relatório',null,'btnAtivarAba','btnClick()',null,true,false);
	$frm->addButton('Desabilitar aba histórico',null,'btnDesabilitarAba','btnDesabilitarClick()',null,true,false);
	$frm->addButton('Habilitar aba histórico',null,'btnHabilitarAba','btnHabilitarClick()',null,true,false);
	$frm->addButton('Mostrar Erros',null,'btnMostrarErro','MostrarErros()');
	$frm->addMemoField('memo','Obs:',1000,true,60,10);

$pc->addPage('Relatório',false,true,'abaRelatorio');
	$frm->addTextField('relatorio','Relatório:',20);
$pc->addPage('Histórico',false,true,'aHist',false,false);
	$frm->addTextField('historico','Histórico:',20);
$pc->addPage('Orçamento',false,true,'abaOrcamento',false);
	$frm->addGroupField('gpx','Grupo x');
		$frm->addTextField('orcamento','Orçamento:',20,true)->setHint('teste - teste');
	$frm->closeGroup();
$frm->closeGroup();

$frm->addTextField('cadastro2','Cadastro:',20);
//$pc->setActivePage('abaHistorico',true);
$frm->closeGroup();
//$frm->addTextField('descricao','Descrição:',50);
$frm->setAction('Atualizar,Gravar');
//$frm->setMessage('Gravarção realizada com sucesso');
if($acao=='Gravar')
{
	$frm->validate();
	//$frm->validate('Cadastro Ação');
	//$frm->validate('gpx');
	//$frm->validate('abaOrcamento');
	$pc->getPage('aHist')->setVisible(false);
}
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
	fwSelecionarAba(fwGetObj('pc_container_page_abarelatorio_link'));
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
</script>
