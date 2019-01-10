<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDPESSOA';
$frm = new TForm('Cadastro de Pessoa',500);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$frm->addMemoField('NOME', 'Nome',200,TRUE,80,3);
$frm->addSelectField('TIPO'	, 'Tipo Pessoa:',true,'PF=Pessoa física,PJ=Pessoa jurídica');
$frm->getLabel('TIPO')->setToolTip('Valor permitidos PF ou PJ');
$frm->addSelectField('SIT_ATIVO', 'Ativo:', true, 'S=Sim,N=Não', true);
//$frm->addDateField('DAT_INCLUSAO', 'DAT_INCLUSAO',TRUE);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new PessoaVO();
				$frm->setVo( $vo );
				$resultado = Pessoa::save( $vo );
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
			$resultado = Pessoa::delete( $id );;
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
				'IDPESSOA'=>$frm->get('IDPESSOA')
				,'NOME'=>$frm->get('NOME')
				,'TIPO'=>$frm->get('TIPO')
				,'SIT_ATIVO'=>$frm->get('SIT_ATIVO')
				,'DAT_INCLUSAO'=>$frm->get('DAT_INCLUSAO')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Pessoa::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Pessoa::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',NOME|NOME'
					.',TIPO|TIPO'
					.',SIT_ATIVO|SIT_ATIVO'
					.',DAT_INCLUSAO|DAT_INCLUSAO'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Gride with SQL Pagination' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'pessoa.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('NOME','Nome');
	$gride->addColumn('TIPO','Tipo de Pessoa',null,'center');
	$gride->addColumn('SIT_ATIVO','Ativo',null,'center');
	$gride->addColumn('DAT_INCLUSAO','Data da Inclusão',null,'center');

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
					,"IDPESSOA":""
					,"NOME":""
					,"TIPO":""
					,"SIT_ATIVO":""
					,"DAT_INCLUSAO":""
					};
	fwGetGrid('pessoa.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>