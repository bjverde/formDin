<?php
defined('APLICATIVO') or die();

$primaryKey = 'COD_MUNICIPIO';
$frm = new TForm('Município',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$listUf = Uf::selectAll();
$frm->addSelectField('COD_UF', 'UF',TRUE,$listUf,null,null,null,null,null,null,' ',null);
$frm->addMemoField('NOM_MUNICIPIO', 'Nome',200,TRUE,80,3);
$frm->addSelectField('SIT_ATIVO', 'Ativo:', true, 'S=Sim,N=Não', true);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new MunicipioVO();
				$frm->setVo( $vo );
				$resultado = Municipio::save( $vo );
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
			$resultado = Municipio::delete( $id );;
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
				'COD_MUNICIPIO'=>$frm->get('COD_MUNICIPIO')
				,'COD_UF'=>$frm->get('COD_UF')
				,'NOM_MUNICIPIO'=>$frm->get('NOM_MUNICIPIO')
				,'SIT_ATIVO'=>$frm->get('SIT_ATIVO')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Municipio::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Municipio::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',COD_UF|COD_UF'
					.',NOM_MUNICIPIO|NOM_MUNICIPIO'
					.',SIT_ATIVO|SIT_ATIVO'
					;
	$gride = new TGrid( 'gd'                  // id do gride
					   ,'Lista de Municípos' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'municipio.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('COD_UF','COD UF',null,'center');
	$gride->addColumn('SIG_UF','UF',null,'center');
	$gride->addColumn('NOM_MUNICIPIO','Nome');
	$gride->addColumn('SIT_ATIVO','Ativo',null,'center');

	$gride->show();
	die();
}

$frm->addHtmlField('gride');
$frm->addJavascript('init()');
if ( Acesso::moduloAcessoPermitido($_REQUEST['modulo']) ){
    $frm->show();
}
?>
<script>
function init() {
	var Parameters = {"BUSCAR":""
					,"COD_MUNICIPIO":""
					,"COD_UF":""
					,"NOM_MUNICIPIO":""
					,"SIT_ATIVO":""
					};
	fwGetGrid('municipio.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>