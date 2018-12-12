<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDTELEFONE';
$frm = new TForm('telefone',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$frm->addTextField('NUMERO', 'NUMERO',45,TRUE,45);
$listPessoa = Pessoa::selectAll();
$frm->addSelectField('IDPESSOA', 'IDPESSOA',TRUE,$listPessoa,null,null,null,null,null,null,' ',null);
$frm->getLabel('IDPESSOA')->setToolTip('dono do telefone');
$listTipo = Tipo::selectAll();
$frm->addSelectField('IDTIPO_TELEFONE', 'IDTIPO_TELEFONE',TRUE,$listTipo,null,null,null,null,null,null,' ',null);
$frm->getLabel('IDTIPO_TELEFONE')->setToolTip('tipo de telefon');
$listEndereco = Endereco::selectAll();
$frm->addSelectField('IDENDERECO', 'IDENDERECO',FALSE,$listEndereco,null,null,null,null,null,null,' ',null);
$frm->addTextField('SIT_FIXO', 'SIT_FIXO',1,FALSE,1);
$frm->addTextField('WHASTAPP', 'WHASTAPP',1,FALSE,1);
$frm->getLabel('WHASTAPP')->setToolTip('informa se o numero tem whastapp');
$frm->addTextField('TELEGRAM', 'TELEGRAM',1,FALSE,1);
$frm->getLabel('TELEGRAM')->setToolTip('informa se o numero tem telegram');

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new TelefoneVO();
				$frm->setVo( $vo );
				$resultado = Telefone::save( $vo );
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
			$resultado = Telefone::delete( $id );;
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
				'IDTELEFONE'=>$frm->get('IDTELEFONE')
				,'NUMERO'=>$frm->get('NUMERO')
				,'IDPESSOA'=>$frm->get('IDPESSOA')
				,'IDTIPO_TELEFONE'=>$frm->get('IDTIPO_TELEFONE')
				,'IDENDERECO'=>$frm->get('IDENDERECO')
				,'SIT_FIXO'=>$frm->get('SIT_FIXO')
				,'WHASTAPP'=>$frm->get('WHASTAPP')
				,'TELEGRAM'=>$frm->get('TELEGRAM')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Telefone::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Telefone::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',NUMERO|NUMERO'
					.',IDPESSOA|IDPESSOA'
					.',IDTIPO_TELEFONE|IDTIPO_TELEFONE'
					.',IDENDERECO|IDENDERECO'
					.',SIT_FIXO|SIT_FIXO'
					.',WHASTAPP|WHASTAPP'
					.',TELEGRAM|TELEGRAM'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Gride with SQL Pagination' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'telefone.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('NUMERO','NUMERO');
	$gride->addColumn('IDPESSOA','IDPESSOA');
	$gride->addColumn('IDTIPO_TELEFONE','IDTIPO_TELEFONE');
	$gride->addColumn('IDENDERECO','IDENDERECO');
	$gride->addColumn('SIT_FIXO','SIT_FIXO');
	$gride->addColumn('WHASTAPP','WHASTAPP');
	$gride->addColumn('TELEGRAM','TELEGRAM');

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
					,"IDTELEFONE":""
					,"NUMERO":""
					,"IDPESSOA":""
					,"IDTIPO_TELEFONE":""
					,"IDENDERECO":""
					,"SIT_FIXO":""
					,"WHASTAPP":""
					,"TELEGRAM":""
					};
	fwGetGrid('telefone.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>