<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDNATUREZA_JURIDICA';
$frm = new TForm('natureza_juridica',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$frm->addMemoField('NOM_NATUREZA_JURIDICAC', 'NOM_NATUREZA_JURIDICAC',300,TRUE,80,3);
$frm->getLabel('NOM_NATUREZA_JURIDICAC')->setToolTip('Natureza Jurídica ');
$frm->addMemoField('ADMINISTRADORES', 'ADMINISTRADORES',1000,FALSE,80,3);
$frm->getLabel('ADMINISTRADORES')->setToolTip('Integrantes do Quadro de Sócios e Administradores ');

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new Natureza_juridicaVO();
				$frm->setVo( $vo );
				$resultado = Natureza_juridica::save( $vo );
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
			$resultado = Natureza_juridica::delete( $id );;
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
				'IDNATUREZA_JURIDICA'=>$frm->get('IDNATUREZA_JURIDICA')
				,'NOM_NATUREZA_JURIDICAC'=>$frm->get('NOM_NATUREZA_JURIDICAC')
				,'ADMINISTRADORES'=>$frm->get('ADMINISTRADORES')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Natureza_juridica::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Natureza_juridica::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',NOM_NATUREZA_JURIDICAC|NOM_NATUREZA_JURIDICAC'
					.',ADMINISTRADORES|ADMINISTRADORES'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Gride with SQL Pagination' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'natureza_juridica.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('NOM_NATUREZA_JURIDICAC','NOM_NATUREZA_JURIDICAC');
	$gride->addColumn('ADMINISTRADORES','ADMINISTRADORES');

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
					,"IDNATUREZA_JURIDICA":""
					,"NOM_NATUREZA_JURIDICAC":""
					,"ADMINISTRADORES":""
					};
	fwGetGrid('natureza_juridica.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>