<?php
defined('APLICATIVO') or die();

$primaryKey = 'COD_UF';
$frm = new TForm('uf',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$frm->addTextField('NOM_UF', 'NOM_UF',45,TRUE,45);
$frm->addTextField('SIG_UF', 'SIG_UF',45,TRUE,45);
$frm->getLabel('SIG_UF')->setToolTip('sigla da uf');
$listRegiao = Regiao::selectAll();
$frm->addSelectField('COD_REGIAO', 'COD_REGIAO',TRUE,$listRegiao,null,null,null,null,null,null,' ',null);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new UfVO();
				$frm->setVo( $vo );
				$resultado = Uf::save( $vo );
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
			$resultado = Uf::delete( $id );;
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
				'COD_UF'=>$frm->get('COD_UF')
				,'NOM_UF'=>$frm->get('NOM_UF')
				,'SIG_UF'=>$frm->get('SIG_UF')
				,'COD_REGIAO'=>$frm->get('COD_REGIAO')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Uf::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Uf::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',NOM_UF|NOM_UF'
					.',SIG_UF|SIG_UF'
					.',COD_REGIAO|COD_REGIAO'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Gride with SQL Pagination' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'uf.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('NOM_UF','NOM_UF');
	$gride->addColumn('SIG_UF','SIG_UF');
	$gride->addColumn('COD_REGIAO','COD_REGIAO');

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
					,"COD_UF":""
					,"NOM_UF":""
					,"SIG_UF":""
					,"COD_REGIAO":""
					};
	fwGetGrid('uf.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>