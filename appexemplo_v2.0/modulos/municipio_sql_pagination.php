<?php
$primaryKey = 'COD_MUNICIPIO';
$frm = new TForm('Cadastro de Municípios',600);
$frm->setFlat(true);
$frm->setMaximize(true);

$frm->addHiddenField( $primaryKey ); // coluna chave da tabela
$frm->addHiddenField( 'whereGrid');

$dadosUf = UfDAO::selectAll('NOM_UF');
$frm->addSelectField('COD_UF','Estado:',true,$dadosUf,null,null,null,null,null,null,'-- selecione um item --',0);
$frm->addTextField('NOM_MUNICIPIO', 'Nome município:', 50, true);
$frm->addSelectField('SIT_ATIVO', 'Ativo:', true, 'S=Sim,N=Não', true,null,null,null,null,null,'-- selecione um item --',0);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new MunicipioVO();
			$frm->setVo( $vo );
			$resultado = MunicipioDAO::insert( $vo );
			if($resultado==1) {
				$frm->setMessage('Registro gravado com sucesso!!!');
				$frm->clearFields();
			}else{
				$frm->setMessage($resultado);
			}
		}
	break;
	//--------------------------------------------------------------------------------
	case 'Limpar':
		$frm->clearFields();
	break;
	//--------------------------------------------------------------------------------
	case 'gd_excluir':
		$id = $frm->get( $primaryKey ) ;
		$resultado = MunicipioDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = 17;
	$page = PostHelper::get('page');
	$whereGrid = $frm->get('whereGrid');
	$dados = MunicipioDAO::selectAllSqlPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = MunicipioDAO::selectCount($whereGrid);
	$mixUpdateFields = $primaryKey.'|'.$primaryKey.',COD_UF|COD_UF,NOM_MUNICIPIO|NOM_MUNICIPIO,SIT_ATIVO|SIT_ATIVO';
	$gride = new TGrid( 'gd'          // id do gride
					   ,'Gride com Paginador SQL'       // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'municipio_sql_pagination.php' );
	
	$gride->addColumn($primaryKey, 'id', 50, 'center');
	$gride->addColumn('COD_UF', 'COD_UF', 50, 'center');
	$gride->addColumn('SIG_UF', 'UF', 50, 'center');
	$gride->addColumn('NOM_MUNICIPIO', 'Nome município', 200);
	$gride->addColumn('SIT_ATIVO', 'Ativo', 50, 'center');
	$gride->show();
	die();
}

$frm->addHtmlField('gride');
$frm->addJavascript('init()');
$frm->show();
?>
<script>
function init() {
	//fwGetGrid("municipio_sql_pagination.php",'gride');
	fwGetGrid("municipio_sql_pagination.php",'gride',{"whereGrid":""},true);
}
function whereClauses(whereGrid,attribute,isTrue,isFalse) {
	var retorno = whereGrid;
	if(attribute != null){
		if(attribute != 0){
			retorno = retorno+isTrue;
		}
	}else{
		retorno = retorno+isFalse;
	}
	return retorno;
}
function buscar() {
	var cod_uf = jQuery("#COD_UF").val();
	var nom_municipio = jQuery("#NOM_MUNICIPIO").val();
	var sit_ativo = jQuery("#SIT_ATIVO").val();
	var whereGrid = ' 1=1 ';
	whereGrid = whereClauses(whereGrid,cod_uf,' AND COD_UF='+cod_uf,'');
	whereGrid = whereClauses(whereGrid,nom_municipio," AND upper(nom_municipio) like '%"+nom_municipio+"%'",'');
	whereGrid = whereClauses(whereGrid,sit_ativo," AND sit_ativo='"+sit_ativo+"'",'');
	jQuery("#whereGrid").val(whereGrid);
	//alert(whereGrid);
	init();	
}
</script>