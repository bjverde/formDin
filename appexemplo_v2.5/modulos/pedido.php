<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDPEDIDO';
$frm = new TForm('pedido',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$listPessoa = Pessoa::selectAll();
$frm->addSelectField('IDPESSOA', 'IDPESSOA',TRUE,$listPessoa,null,null,null,null,null,null,' ',null);
$listTipo = Tipo::selectAll();
$frm->addSelectField('IDTIPO_PAGAMENTO', 'IDTIPO_PAGAMENTO',TRUE,$listTipo,null,null,null,null,null,null,' ',null);
$frm->addDateField('DAT_PEDIDO', 'DAT_PEDIDO',TRUE);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new PedidoVO();
				$frm->setVo( $vo );
				$resultado = Pedido::save( $vo );
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
			$resultado = Pedido::delete( $id );;
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
				'IDPEDIDO'=>$frm->get('IDPEDIDO')
				,'IDPESSOA'=>$frm->get('IDPESSOA')
				,'IDTIPO_PAGAMENTO'=>$frm->get('IDTIPO_PAGAMENTO')
				,'DAT_PEDIDO'=>$frm->get('DAT_PEDIDO')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Pedido::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Pedido::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',IDPESSOA|IDPESSOA'
					.',IDTIPO_PAGAMENTO|IDTIPO_PAGAMENTO'
					.',DAT_PEDIDO|DAT_PEDIDO'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Gride with SQL Pagination' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'pedido.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('IDPESSOA','IDPESSOA');
	$gride->addColumn('IDTIPO_PAGAMENTO','IDTIPO_PAGAMENTO');
	$gride->addColumn('DAT_PEDIDO','DAT_PEDIDO');

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
					,"IDPEDIDO":""
					,"IDPESSOA":""
					,"IDTIPO_PAGAMENTO":""
					,"DAT_PEDIDO":""
					};
	fwGetGrid('pedido.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>