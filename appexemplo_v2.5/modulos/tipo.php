<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDTIPO';
$frm = new TForm('tipo',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$listTipo_de_tipos = Tipo_de_tipos::selectAll();
$frm->addSelectField('IDTIPO_DE_TIPOS', 'IDTIPO_DE_TIPOS',TRUE,$listTipo_de_tipos,null,null,null,null,null,null,' ',null);
$frm->addTextField('DESCRICAO', 'DESCRICAO',100,FALSE,100);
$frm->addTextField('SIT_ATIVO', 'SIT_ATIVO',1,FALSE,1);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new TipoVO();
				$frm->setVo( $vo );
				$resultado = Tipo::save( $vo );
				if($resultado==1) {
					$frm->setMessage('Registro gravado com sucesso!!!');
					$frm->clearFields();
				}else{
					$frm->setMessage($resultado);
				}
			}
		}
		catch (DomainException $e) {
			$frm->setMessage( $e->getMessage() );
		}
		catch (Exception $e) {
			MessageHelper::logRecord($e);
			$frm->setMessage( $e->getMessage() );
		}
	break;
	//--------------------------------------------------------------------------------
	case 'Limpar':
		$frm->clearFields();
	break;
	//--------------------------------------------------------------------------------
	case 'gd_excluir':
		try{
			$id = $frm->get( $primaryKey ) ;
			$resultado = Tipo::delete( $id );;
			if($resultado==1) {
				$frm->setMessage('Registro excluido com sucesso!!!');
				$frm->clearFields();
			}else{
				$frm->clearFields();
				$frm->setMessage($resultado);
			}
		}
		catch (DomainException $e) {
			$frm->setMessage( $e->getMessage() );
		}
		catch (Exception $e) {
			MessageHelper::logRecord($e);
			$frm->setMessage( $e->getMessage() );
		}
	break;
}


function getWhereGridParameters(&$frm){
	$retorno = null;
	if($frm->get('BUSCAR') == 1 ){
		$retorno = array(
				'IDTIPO'=>$frm->get('IDTIPO')
				,'IDTIPO_DE_TIPOS'=>$frm->get('IDTIPO_DE_TIPOS')
				,'DESCRICAO'=>$frm->get('DESCRICAO')
				,'SIT_ATIVO'=>$frm->get('SIT_ATIVO')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Tipo::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Tipo::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',IDTIPO_DE_TIPOS|IDTIPO_DE_TIPOS'
					.',DESCRICAO|DESCRICAO'
					.',SIT_ATIVO|SIT_ATIVO'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Gride with SQL Pagination' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'tipo.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('IDTIPO_DE_TIPOS','IDTIPO_DE_TIPOS');
	$gride->addColumn('DESCRICAO','DESCRICAO');
	$gride->addColumn('SIT_ATIVO','SIT_ATIVO');

	$gride->show();
	die();
}

$frm->addHtmlField('gride');
$frm->addJavascript('init()');
$frm->show();

?>
<script>
function init() {
	var Parameters = {"BUSCAR":""
					,"IDTIPO":""
					,"IDTIPO_DE_TIPOS":""
					,"DESCRICAO":""
					,"SIT_ATIVO":""
					};
	fwGetGrid('tipo.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>