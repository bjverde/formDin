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

$frm = new TForm('Exemplo do Campo Checkbox');
//$frm->setFlat(true);
//$pc = $frm->addPageControl('pc');
//$aba = $pc->addPage('Cadastro',true,true,'abaCadastro');


$frm->addGroupField('gp1','Grupo');

	//$frm->addTextField('nm_anexo_doc', 'Arquivo de Word (DOC) associado pelo Advogado ou Estagiário:&nbsp;&nbsp;',35,false,35,null,true,null,null,null,true);
	//$frm->addButton('Baixar',null,'btn_baixar_anexo',"baixar_anexo('doc')",null,false,false,'last16.gif',null,'Baixar');
  	//$frm->addHtmlField('st_publico_doc',null,null,null,20,100,false)->setCss('font','9px sans-serif')->setCss('border','1px solid red');
	$frm->addCheckField('st_publico','Na análise do Advogado esta peça deve ser pública?',false,null,null,null,null,null,null,null,null,true);

	$frm->addCheckField('campo_1','Confirma ?',true);
	$frm->addCheckField('campo_2','Bioma Obrigatório para o cadastramentodas espécies:',true,'1=Cerrado,2=Mata Atlântica,3=Caatinga',null,null,null,null,null,null,null,true);
	$frm->addCheckField('campo_3','Bioma Não Obrigatório:',false,'1=Cerrado,2=Mata Atlântica,3=Caatinga');
	$frm->addCheckField('campo_4','Exemplo 4:',false,'N',null,null);

	$frm->addCheckField('cd_especie','Espécies:',false,'1=Amarela,2=Branca,3=Vermelha')->addEvent('onChange','cd_especieChange()');
$frm->closeGroup();

$frm->addGroupField('gp2','Grupo 2');

	$leg = '<div style=\'border:1px solid green;float:left;background-color:#cfffcf;width:10px;height:10px;\'></div>&nbsp;';
	//$frm->addCheckField('st_abertas',$leg.'Abertas',null,null,false,null,'N')->addEvent('onChange','formDinFazer()');
	$frm->addCheckField('st_abertas',$leg.'Abertas',null,null,false,null,'N')->addEvent('onChange','filtrar(this)');
	$frm->getLabel('st_abertas')->setCss('color','green');

	$leg = '<div style=\'border:1px solid red;float:left;background-color:#FFC1C1;width:10px;height:10px;\'></div>&nbsp;';
	$frm->addCheckField('st_pendente',$leg.'Pendentes',null,null,false,null,'N')->addEvent('onChange','formDinFazer()');

	$leg = '<div style=\'border:1px solid blue;float:left;background-color:#C6E2FF;width:10px;height:10px;\'></div>&nbsp;';
	$frm->addCheckField('st_andamento',$leg.'Andamento',null,null,false,null,'N')->addEvent('onChange','formDinFazer()');

$frm->closeGroup();

$frm->setAction('Validar,Atualizar');
//$c = $frm->getLabel('campo_1');
//$c->setCss('color','blue');
$frm->addButton('Full',null,'btnFull','fwFullScreen()');
if( $acao=='Validar' )
{
	$frm->validate();
}
// exibir o formulário
$frm->show();
?>
<script>
function fwMaximize(e,event)
{
	var id = e.id.substr(0,e.id.indexOf('_header'));
	fwFullScreen(id);
}
function fwFullScreen(id)
{
	id = id ||'formdin';
	var status = jQuery("#"+id+'_header').attr('fullscreen');
	var h;
	var w;
	if( status=='true' )
	{
		h = jQuery("#"+id+'_header').attr('oldHeight');
		w = jQuery("#"+id+'_header').attr('oldWidth');
		jQuery("#"+id+'_header').attr({'fullscreen':'false'});
	}
	else
	{
		var currH = jQuery("#"+id+'_area').height();
		var currW = jQuery("#"+id+'_area').width();
		jQuery("#"+id+'_header').attr({'fullscreen':'true','oldWidth':currW,'oldHeight':currH});
		h= jQuery("body").height()-15;
		w= jQuery("body").width()-15;
	}
	fwSetFormHeight(h,id);
	fwSetFormWidth(w,id);
}

function filtrar(check)
{
	if( check.checked )
	{
		//alert( check.value);
	}
	// ler todos os campos check
   jQuery("form input:checkbox").each(
   	function()
   	{
   		//alert( jQuery(this).id);
   	}
   );

   jQuery("#gp2 input[type=checkbox]").each(
  	function() {
   	if( this.checked )
   	{
	   	alert( this.id+' valor:'+this.value );
   	}
  });
}
function cd_especieChange()
{
	var sql='';
	jQuery('input[type=checkbox][name^="cd_especie"]').each(
	function() {
   		if( this.checked )
   		{
   			sql += ( sql == '' ? '' : ' and ');
   			sql += 'cd_especie =  '+this.value;
   		}
	});
	alert( 'select cd_especie from tabela_x where '+sql );
}
</script>

