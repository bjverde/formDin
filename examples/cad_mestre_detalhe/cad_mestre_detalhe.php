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
$frm = new TForm('Exemplo de Cadastramento Mestre - Detalhe',240);
$frm->addHtmlField('obs','<b>Este exemplo utiliza as tabelas tb_pedido e tb_pedido_item do banco de dados bdApoio.s3db ( sqlite )</b>');
$frm->addGroupField('gpPedido','Pedido'); // criar um grupo para os campos da tabela MESTRE
	$frm->addTextField('id_pedido'			,'Nº'	,5,true,5)->setReadOnly(true)->setCss('font-size','14')->setcss('color','blue')->setCss('text-align','center')->setCss('font-weight','bold'); // coluna chave da tabela de pedido
	$frm->addDateField('data_pedido'		,'Data:',true);
	$frm->addTextField('nome_comprador'		,'Comprador:',60,true,null);
	$frm->addSelectField('forma_pagamento'	,'Forma Pagamento:',true,'1=Dinheiro,2=Cheque,3=Cartão');
	$frm->addButtonAjax('Salvar Pedido'		,null,'validarPedido','depoisSalvarPedido','salvar_pedido','Salvando pedido...','json',false,null,'btnSalvarPedido',null,true,false);
	$frm->addButton('Novo Pedido'			,null,'btnNovoPedido','novoPedido()',null,false,false);
	$frm->addButton('Consultar Nº Pedido'				,null,'btnConsultarPedido','consultarPedido()',null,false,false);
$frm->closeGroup(); // fechar o grupo

$frm->addGroupField('gpItem','Item do Pedido'); // criar um grupo para os campos da tabela Item
	$frm->addTextField('produto'		,'Produto:',60,true);
	$frm->addNumberField('quantidade'	,'Quantidade:',5,true,1,true);
	$frm->addNumberField('preco'		,'Preço:',10,true,2,true);
	$frm->addButtonAjax('Salvar Item'		,null,'validarItem','depoisSalvarItem','salvar_item','Salvando item...','text',false,null,'btnSalvarItem',null,true,false);
	$frm->addHtmlField('html_gride_itens');
$frm->closeGroup(); // fechar o grupo

$frm->processAction(); // processar a ação do usuário

$frm->addJavascript('inicializar()');
$frm->setFocusField('data_pedido');
$frm->show(); // exibir o formulário
?>
<script>
function inicializar()
{
	jQuery("#id_pedido").val('Novo');
	jQuery("#gpItem_area").hide('fast',function(){fwSetFocus('data_pedido')});
	jQuery("#html_gride_itens").html('');
	jQuery("#btnSalvarPedido").show();
	fwSetFormHeight(240);
}
function validarPedido()
{
	// validar os campos do grupo Pedido
	if( !fwValidateFields(null,'gpPedido'))
	{
		return false;
	}
	return confirm('Confirma novo pedido ?');
}

function depoisSalvarPedido(resultado)
{

	/**
	 	Quando utilizada a função prepareReturnAjax() no retorno da ação, e o formato estiver definido como 'json',
		o parametro resultado virá com a seguinte estrutura:
		a) resultado.status
		b) resultado.data
		c) resultado.mensagem
	*/
	if( resultado.status == 1 )
	{
		if( jQuery('#id_pedido').val() == '' ) // quando for inclusão
		{
			jQuery('#id_pedido').val( resultado.data.ID_PEDIDO );
			jQuery("#html_gride_itens").html('');
			fwSetFormHeight(500);
			jQuery("#gpItem_area").show('slow',function(){ 	fwSetFocus('produto');atualizar_gride_itens() } );
			jQuery("#btnSalvarPedido").hide();
		}
	}
	if( res.message )
	{
		alert( resultado.message );
	}
}

function validarItem()
{
	if( jQuery("#id_pedido").val() == 'Novo' )
	{
		fwAlert('Pedido ainda não foi salvo!');
		return false;
	}
	if( !fwValidateFields(null,'gpItem'))
	{
		return false;
	}
	return true;
}

function depoisSalvarItem(resultado)
{
	if( resultado )
	{
		fwAlert( resultado );
		return;
	}
	fwClearChildFields('gpItem'); // limpar os campos do grupo Item
	fwSetFocus('produto');
	atualizar_gride_itens();
}
function novoPedido()
{
	fwClearChildFields(); // limpar todos os campos do formulário
	inicializar();
}
function atualizar_gride_itens()
{
	// o valor do parametro id_pedido, como está em branco, a função getGrid() procurará nos campos do formulário e preencherá automaticamente.
	fwGetGrid('cad_mestre_detalhe/cad_mestre_detalhe.php','html_gride_itens',{'acao':'criar_gride_itens','id_pedido':''},true);
}
function consultarPedido()
{
	var id = prompt('Nº do Pedido:');
	if( id )
	{
        fwAjaxRequest({
			"action":"lerPedido",
			"dataType":"json",
			"data":{"id":id},
			"callback":function(retorno)
			{
				if( retorno.message )
				{
					alert( retorno.message);
				}
				if( retorno.data )
				{
					fwUpdateFieldsJson(retorno);
    				jQuery("#id_pedido").val(id);
					jQuery("#html_gride_itens").html('');
					fwSetFormHeight(500);
					jQuery("#gpItem_area").show('slow',function(){ 	fwSetFocus('produto');atualizar_gride_itens() } );
				}
			}
        });
	}
}
</script>