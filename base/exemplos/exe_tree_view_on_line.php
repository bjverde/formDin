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
error_reporting(E_ALL);
$res=null;
if( ! isset($_REQUEST['ajax']) || ! $_REQUEST['ajax'] )
{
	$_REQUEST['cod_uf'] = isset($_REQUEST['cod_uf']) ? $_REQUEST['cod_uf']:'53';
	$bvars=array('COD_UNIDADE_INICIAL'=>10000,'COD_UF'=>$_REQUEST['cod_uf']);
	$bvars=array('COD_UNIDADE_INICIAL'=>10000,'COD_UF'=>53);
	//print_r(recuperarPacote('SIGER.PKG_UNIDADE_IBAMA.SEL_ARVORE_UNIDADE',$bvars,$res,300));
}
else
{
	$retorno['message'] = utf8_encode('Operação realizada com SUCESSO!');
	echo json_encode($retorno);
	exit;
}
 *
 */
$frm = new TForm('Estrutura Oragnizacional',400);
$frm->addHiddenField('cod_unidade_inicial',10000);
$frm->addButton('Atualizar','atualizar','btnAtualizar',null,null,false,false);


/*
 $tree = $frm->addTreeField('tree'

	,null
	,'SIGER.PKG_UNIDADE_IBAMA.SEL_ARVORE_UNIDADE'
	,'COD_SUBORDINADO'
	,'COD_UNIDADE_IBAMA'
	,'NOM_UNIDADE_IBAMA'
	,10000
	,null
	,($frm->getHeight()-120)
	);
*/
//https://10.1.4.65/~45427380191/appbase/?modulo=base/callbacks/treeView.php&ajax=1&parentField=SEQ_TAXONOMIA_PAI&childField=SEQ_TAXONOMIA&descField=DES_TAXONOMIA&tableName=TESTE.PKG_TAXONOMIA_TREE.SEL_TAXON

$tree = $frm->addTreeField('tree'
	,null
	,'TESTE.PKG_TAXONOMIA_TREE.SEL_TAXON'
	,'SEQ_TAXONOMIA_PAI'
	,'SEQ_TAXONOMIA'
	,'DES_TAXONOMIA'
	,null
	,'SEQ_TAXONOMIA,DES_TAXONOMIA'
	,($frm->getHeight()-120)
	,null
	,null
	,null
	,null
	,null
	,null
	,null
	,null
	,null
	,null,null,null
	,null//'cod_unidade_inicial'
	);


$tree->setStartExpanded(true);
//$tree->setOnDblClick('parent.onTreeDblClick');
$tree->setOnClick('treeClick'); // fefinir o evento que será chamado ao clicar no item da treeview

$frm->show();
?>
<script>
function treeClick(id)
{
	alert( 'Item id:'+tree.getSelectedItemId()+'\n'+
	'Item text:'+tree.getItemText(id )+'\n'+
	'User data1 :'+tree.getUserData(id,'SEQ_TAXONOMIA')+'\n'+
	'User data2 :'+tree.getUserData(id,'DES_TAXONOMIA'));
}
function treeDrag(id, id2)
{
	if( confirm("Mover:  " + tree.getItemText(id) + "\n para:" + tree.getItemText(id2) + "\n\nConfirma ?") )
    {
		dados = 'cod_unidade_ibama='+id+'&cod_unidade_destino='+id2+'&ajax=1&modulo=base/exemplos/exe_tree_view_unid_ibama.inc&formDinAcao=Alterar';
		fwBlockScreen(null,null,null,'Gravando. Aguarde...');
		jQuery.post( app_url + app_index_file
			, dados
			,function(data)
   			{
   				fwUnBlockScreen();
				if( data )
   				{
   					if( data.message )
   					{
   						alert( data.message );
   					}
				}
   			},"json"
   		);
   		return true;
	}
}
</script>

