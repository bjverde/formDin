<?php
/**
* Arquivo utilizado pelo arquivo exe_tree_view_5.php 
* para alimentar a árvore
*  
*/

// criar a instância do objeto TTreeView que será responsável por gerar o xml de retorno
$tree = new TTreeView();

// a classe treeview envia no request o codigo do item clicado na variavel $_REQUEST["id"]

// se não foi passaado nenhum item pai, retornar todos os pais ( inicialização da árvore )
if( ! isset( $_REQUEST['id']  ) )
{
	$sql = "select id, id_pai,nome from vw_tree_regiao_uf_mun where id_pai is null";	
}
else
{
   // quando for para selecionar os estados da região, filtrar somente o estado selecionado no formulário.
   // os campos filtros definidos no metodo addFormSearchFields() veem prefixados com "_w_" indicando que devem ser adicionados na cláusula "where" do sql
   if( preg_match('/re/',$_REQUEST['id']) == 1 && $_REQUEST['_w_cod_uf'] != '' )
   {
		$sql = "select id, id_pai,nome from vw_tree_regiao_uf_mun where id_pai = ? and id='".$_REQUEST['_w_cod_uf']."'";	
   }
   else
   {	
   		$sql = "select id, id_pai,nome from vw_tree_regiao_uf_mun where id_pai = ?";	
   }	
}
// fazer a consulta ao banco de dados
if( $dados = TPDOConnection::executeSql($sql,$_REQUEST['id'] ) )
{
	// adicionar os itens na árvore
	foreach($dados['ID'] as $k=>$v)
	{
		$tree->addItem( $dados['ID_PAI'][$k], $dados['ID'][$k],$dados['NOME'][$k]);
 	}
}

// devolver o xml
$tree->getXml(true);
?>