<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDPRODUTO';
$frm = new TForm('Produtos',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela

$listPessoa = Pessoa::selectAll('nome');
$frm->addSelectField('IDPESSOA', 'Pessoa',TRUE,$listPessoa,null,null,null,null,null,null,' ',null);

$listMarca = Marca::selectAll();
$frm->addSelectField('IDMARCA', 'Marca',TRUE,$listMarca,null,null,null,null,null,null,' ',null);

$frm->combinarSelects('IDPESSOA', 'IDMARCA', 'vw_pessoa_marca_produto', 'IDPESSOA', 'IDMARCA', 'NOM_MARCA', null, null, 'Nenhum', null, null, true);

$listTipo = Tipo::selectAllAtivoByMeta(Meta_tipoDAO::PRODUTO);
$frm->addSelectField('IDTIPO_PRODUTO', 'Tipo Produto',TRUE,$listTipo,null,null,null,null,null,null,' ',null);

$frm->addTextField('NOM_PRODUTO', 'Nome',45,TRUE,45);
$frm->addTextField('MODELO', 'Modelo',45,TRUE,45);
$frm->addTextField('VERSAO', 'Versão',45,TRUE,45);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new ProdutoVO();
				$frm->setVo( $vo );
				$resultado = Produto::save( $vo );
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
			$resultado = Produto::delete( $id );;
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
				 'IDPRODUTO'=>$frm->get('IDPRODUTO')
				,'NOM_PRODUTO'=>$frm->get('NOM_PRODUTO')
				,'MODELO'=>$frm->get('MODELO')
				,'VERSAO'=>$frm->get('VERSAO')
				,'IDMARCA'=>$frm->get('IDMARCA')
				,'IDTIPO_PRODUTO'=>$frm->get('IDTIPO_PRODUTO')
		        ,'IDPESSOA'=>$frm->get('IDPESSOA')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Produto::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Produto::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',NOM_PRODUTO|NOM_PRODUTO'
					.',MODELO|MODELO'
					.',VERSAO|VERSAO'
					.',IDPESSOA|IDPESSOA'
					.',IDMARCA|IDMARCA'
					.',IDTIPO_PRODUTO|IDTIPO_PRODUTO'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Lista de Produtos' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'produto.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('NOM_PRODUTO','Nome');
	$gride->addColumn('MODELO','Modelo');
	$gride->addColumn('VERSAO','Versão');
	$gride->addColumn('IDPESSOA','id Pessoa');
	$gride->addColumn('NOM_PESSOA','Pessoa');
	$gride->addColumn('IDMARCA','id Marca');
	$gride->addColumn('NOM_MARCA','Marca');
	$gride->addColumn('IDTIPO_PRODUTO','id Tipo Produto');
	$gride->addColumn('NOM_TIPO','Tipo');

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
					,"IDPRODUTO":""
					,"NOM_PRODUTO":""
					,"MODELO":""
					,"VERSAO":""
					,"IDMARCA":""
					,"IDTIPO_PRODUTO":""
					,"IDPESSOA":""
					};
	fwGetGrid('produto.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>