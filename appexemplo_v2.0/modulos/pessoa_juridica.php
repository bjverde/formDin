<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDPESSOA_JURIDICA';
$frm = new TForm('pessoa_juridica',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$frm->addTextField('CNPJ', 'CNPJ',14,TRUE,14);
$listPessoa = Pessoa::selectAll();
$frm->addSelectField('IDPESSOA', 'IDPESSOA',TRUE,$listPessoa,null,null,null,null,null,null,' ',null);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new Pessoa_juridicaVO();
				$frm->setVo( $vo );
				$resultado = Pessoa_juridica::save( $vo );
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
			$resultado = Pessoa_juridica::delete( $id );;
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
				'IDPESSOA_JURIDICA'=>$frm->get('IDPESSOA_JURIDICA')
				,'CNPJ'=>$frm->get('CNPJ')
				,'IDPESSOA'=>$frm->get('IDPESSOA')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Pessoa_juridica::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Pessoa_juridica::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',CNPJ|CNPJ'
					.',IDPESSOA|IDPESSOA'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Gride with SQL Pagination' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'pessoa_juridica.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('CNPJ','CNPJ');
	$gride->addColumn('IDPESSOA','IDPESSOA');

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
					,"IDPESSOA_JURIDICA":""
					,"CNPJ":""
					,"IDPESSOA":""
					};
	fwGetGrid('pessoa_juridica.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>