<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDPESSOA_FISICA';
$frm = new TForm('pessoa_fisica',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$listPessoa = Pessoa::selectAll();
$frm->addSelectField('IDPESSOA', 'IDPESSOA',TRUE,$listPessoa,null,null,null,null,null,null,' ',null);
$frm->addCpfField('CPF', 'CPF',true);
$frm->addDateField('DAT_NASCIMENTO', 'Data Nascimento',FALSE);
$listMunicipio = Municipio::selectAll();
$frm->addSelectField('COD_MUNICIPIO_NASCIMENTO', 'COD_MUNICIPIO_NASCIMENTO',FALSE,$listMunicipio,null,null,null,null,null,null,' ',null);
$frm->addDateField('DAT_INCLUSAO', 'DAT_INCLUSAO',TRUE);
$frm->addDateField('DAT_ALTERACAO', 'DAT_ALTERACAO',FALSE);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new Pessoa_fisicaVO();
				$frm->setVo( $vo );
				$resultado = Pessoa_fisica::save( $vo );
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
			$resultado = Pessoa_fisica::delete( $id );;
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
				'IDPESSOA_FISICA'=>$frm->get('IDPESSOA_FISICA')
				,'IDPESSOA'=>$frm->get('IDPESSOA')
				,'CPF'=>$frm->get('CPF')
				,'DAT_NASCIMENTO'=>$frm->get('DAT_NASCIMENTO')
				,'COD_MUNICIPIO_NASCIMENTO'=>$frm->get('COD_MUNICIPIO_NASCIMENTO')
				,'DAT_INCLUSAO'=>$frm->get('DAT_INCLUSAO')
				,'DAT_ALTERACAO'=>$frm->get('DAT_ALTERACAO')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Pessoa_fisica::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Pessoa_fisica::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',IDPESSOA|IDPESSOA'
					.',CPF|CPF'
					.',DAT_NASCIMENTO|DAT_NASCIMENTO'
					.',COD_MUNICIPIO_NASCIMENTO|COD_MUNICIPIO_NASCIMENTO'
					.',DAT_INCLUSAO|DAT_INCLUSAO'
					.',DAT_ALTERACAO|DAT_ALTERACAO'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Gride with SQL Pagination' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'pessoa_fisica.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('IDPESSOA','IDPESSOA');
	$gride->addColumn('CPF','CPF');
	$gride->addColumn('DAT_NASCIMENTO','DAT_NASCIMENTO');
	$gride->addColumn('COD_MUNICIPIO_NASCIMENTO','COD_MUNICIPIO_NASCIMENTO');
	$gride->addColumn('DAT_INCLUSAO','DAT_INCLUSAO');
	$gride->addColumn('DAT_ALTERACAO','DAT_ALTERACAO');

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
					,"IDPESSOA_FISICA":""
					,"IDPESSOA":""
					,"CPF":""
					,"DAT_NASCIMENTO":""
					,"COD_MUNICIPIO_NASCIMENTO":""
					,"DAT_INCLUSAO":""
					,"DAT_ALTERACAO":""
					};
	fwGetGrid('pessoa_fisica.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>