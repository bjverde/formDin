<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDENDERECO';
$frm = new TForm('endereco',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$frm->addMemoField('ENDERECO', 'ENDERECO',300,TRUE,80,3);
$listPessoa = Pessoa::selectAll();
$frm->addSelectField('IDPESSOA', 'IDPESSOA',TRUE,$listPessoa,null,null,null,null,null,null,' ',null);
$listTipo = Tipo::selectAll();
$frm->addSelectField('IDTIPO_ENDERECO', 'IDTIPO_ENDERECO',TRUE,$listTipo,null,null,null,null,null,null,' ',null);
$listMunicipio = Municipio::selectAll();
$frm->addSelectField('COD_MUNICIPIO', 'COD_MUNICIPIO',TRUE,$listMunicipio,null,null,null,null,null,null,' ',null);
$frm->getLabel('COD_MUNICIPIO')->setToolTip('código do municipio');
$frm->addTextField('CEP', 'CEP',8,FALSE,8);
$frm->addTextField('NUMERO', 'NUMERO',5,FALSE,5);
$frm->addMemoField('COMPLEMENTO', 'COMPLEMENTO',300,FALSE,80,3);
$frm->addMemoField('BAIRRO', 'BAIRRO',300,FALSE,80,3);
$frm->addMemoField('CIDADE', 'CIDADE',300,FALSE,80,3);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new EnderecoVO();
				$frm->setVo( $vo );
				$resultado = Endereco::save( $vo );
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
			$resultado = Endereco::delete( $id );;
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
				'IDENDERECO'=>$frm->get('IDENDERECO')
				,'ENDERECO'=>$frm->get('ENDERECO')
				,'IDPESSOA'=>$frm->get('IDPESSOA')
				,'IDTIPO_ENDERECO'=>$frm->get('IDTIPO_ENDERECO')
				,'COD_MUNICIPIO'=>$frm->get('COD_MUNICIPIO')
				,'CEP'=>$frm->get('CEP')
				,'NUMERO'=>$frm->get('NUMERO')
				,'COMPLEMENTO'=>$frm->get('COMPLEMENTO')
				,'BAIRRO'=>$frm->get('BAIRRO')
				,'CIDADE'=>$frm->get('CIDADE')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Endereco::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Endereco::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',ENDERECO|ENDERECO'
					.',IDPESSOA|IDPESSOA'
					.',IDTIPO_ENDERECO|IDTIPO_ENDERECO'
					.',COD_MUNICIPIO|COD_MUNICIPIO'
					.',CEP|CEP'
					.',NUMERO|NUMERO'
					.',COMPLEMENTO|COMPLEMENTO'
					.',BAIRRO|BAIRRO'
					.',CIDADE|CIDADE'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Gride with SQL Pagination' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'endereco.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('ENDERECO','ENDERECO');
	$gride->addColumn('IDPESSOA','IDPESSOA');
	$gride->addColumn('IDTIPO_ENDERECO','IDTIPO_ENDERECO');
	$gride->addColumn('COD_MUNICIPIO','COD_MUNICIPIO');
	$gride->addColumn('CEP','CEP');
	$gride->addColumn('NUMERO','NUMERO');
	$gride->addColumn('COMPLEMENTO','COMPLEMENTO');
	$gride->addColumn('BAIRRO','BAIRRO');
	$gride->addColumn('CIDADE','CIDADE');

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
					,"IDENDERECO":""
					,"ENDERECO":""
					,"IDPESSOA":""
					,"IDTIPO_ENDERECO":""
					,"COD_MUNICIPIO":""
					,"CEP":""
					,"NUMERO":""
					,"COMPLEMENTO":""
					,"BAIRRO":""
					,"CIDADE":""
					};
	fwGetGrid('endereco.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>