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


$frm = new TForm('Gride OFF-LINE',300,600);
$frm->addSelectField('seq_impureza_metal','Metal',false,'1=Chumbo,2=Arsenio,3=Cromo')->addEvent('onChange','this.form.chave_gride_impureza_metalica.value=this.options[this.selectedIndex].value');
$frm->addSelectField('cod_impureza_comp','Valor (mg/kg)',false,array('='=>'=','>'=>'&gt;','<'=>'&lt;'),false,false,null,null,null,null,'--');
$frm->addNumberField('val_impureza_metalica','',7,true,4,false,null,0,1000);
$frm->addHiddenField('chave_gride_impureza_metalica');
$frm->addButton('+',null,'btn_gride_impureza_metalica','gride_linha_alterar(this)',null,false,false,null,null,'Clique aqui para adicionar metal à lista');
$frm->addHtmlField('gride_impureza');
$frm->setAction('Gravar');

$arrSeq_impureza_metal = $frm->getField('seq_impureza_metal')->getOptions();
if ( is_array($_POST['text_seq_impureza_metal']) ) {
	foreach ( $_POST['text_seq_impureza_metal'] as $k=>$v ) {
		$bvars_prd['CURSOR_IMPUREZA_METALICA']['SEQ_IMPUREZA_METALICA'][] = $_POST['text_seq_impureza_metal'][$k];
		$bvars_prd['CURSOR_IMPUREZA_METALICA']['DES_IMPUREZA_METALICA'][] = $arrSeq_impureza_metal[ $_POST['text_seq_impureza_metal'][$k] ];
		$bvars_prd['CURSOR_IMPUREZA_METALICA']['COD_IMPUREZA_COMP'][] = $_POST['text_cod_impureza_comp'][$k];
		$bvars_prd['CURSOR_IMPUREZA_METALICA']['VAL_IMPUREZA_METALICA'][] = $_POST['text_val_impureza_metalica'][$k];
	}
}

$frm->setValue('gride_impureza'
	,'<br>'.criarGride('gride_impureza_metalica'
	,''
	,$bvars_prd['CURSOR_IMPUREZA_METALICA']
	,null
	,($soLeitura?'':'Editar\Clique aqui para editar registro\base/imagens/editar.gif\ \gride_linha_editar(this)|
	  Remover\Clique aqui para remover registro\base/imagens/cancelhabilitada.gif\ \gride_linha_remover(this)')
	,'SEQ_IMPUREZA_METALICA' // campos atualizar na tela,
	,'text_seq_impureza_metal/0/text/SEQ_IMPUREZA_METALICA
	 `DES_IMPUREZA_METALICA|Metal
	 `text_cod_impureza_comp/0/text/COD_IMPUREZA_COMP
	 `COD_IMPUREZA_COMP|&lt;=
	 `text_val_impureza_metalica/0/text/VAL_IMPUREZA_METALICA
	 `VAL_IMPUREZA_METALICA|Valor (mg/kg)
	 ' // colunas do gride
	,0,null,null,null,null,null,null,'Nenhum registro encontrado',null
	,'ALINHAMENTO_TEXTO|VAL_IMPUREZA_METALICA||right
	 `ALINHAMENTO_TEXTO|COD_IMPUREZA_COMP||center' //$configuracao
	,false,null,null,null,null ,null,null ,null,null,null,null,false,null,false));
$frm->show();

?>
<script>
function disabilitarTeclaCtrl(e,teclas)
{
	var teclasProibidas;
	if( teclas )
	{
		var teclasProibidas = teclas.slice(',');
	}
	else
	{
		//Lista de todas as combinações de CTRL + key que voce quer desativar
		teclasProibidas = new Array('a', 'n', 'c', 'x', 'v', 'j');
	}
	var key;
	var isCtrl;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
		if(window.event.ctrlKey)
			isCtrl = true;
		else
			isCtrl = false;
	}
	else
	{
		key = e.which;     //firefox
		if(e.ctrlKey)
			isCtrl = true;
		else
		isCtrl = false;
	}
	if(isCtrl)
	{
		for(i=0; i<teclasProibidas .length; i++)
		{
			if(teclasProibidas[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
			{
				key=0;   
				return false;
			}
		}
	}
	return true;
}
</script>
