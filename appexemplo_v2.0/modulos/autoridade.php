<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDAUTORIDADE';
$frm = new TForm('autoridade',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$frm->addDateField('DAT_INCLUSAO', 'DAT_INCLUSAO',TRUE);
$frm->addDateField('DAT_EVENTO', 'DAT_EVENTO',TRUE);
$frm->getLabel('DAT_EVENTO')->setToolTip('Data do evento');
$frm->addNumberField('ORDEM', 'ORDEM',10,TRUE,0);
$frm->getLabel('ORDEM')->setToolTip('ordem daa autoridades');
$frm->addTextField('CARGO', 'CARGO',100,TRUE,100);
$frm->getLabel('CARGO')->setToolTip('nome do cargo da autoridade');
$frm->addTextField('NOME_PESSOA', 'NOME_PESSOA',100,TRUE,100);
$frm->getLabel('NOME_PESSOA')->setToolTip('nome da pessoa');

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new AutoridadeVO();
				$frm->setVo( $vo );
				$resultado = Autoridade::save( $vo );
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
			$resultado = Autoridade::delete( $id );;
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
				'IDAUTORIDADE'=>$frm->get('IDAUTORIDADE')
				,'DAT_INCLUSAO'=>$frm->get('DAT_INCLUSAO')
				,'DAT_EVENTO'=>$frm->get('DAT_EVENTO')
				,'ORDEM'=>$frm->get('ORDEM')
				,'CARGO'=>$frm->get('CARGO')
				,'NOME_PESSOA'=>$frm->get('NOME_PESSOA')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Autoridade::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Autoridade::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',DAT_INCLUSAO|DAT_INCLUSAO'
					.',DAT_EVENTO|DAT_EVENTO'
					.',ORDEM|ORDEM'
					.',CARGO|CARGO'
					.',NOME_PESSOA|NOME_PESSOA'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Gride with SQL Pagination' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'autoridade.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('DAT_INCLUSAO','DAT_INCLUSAO');
	$gride->addColumn('DAT_EVENTO','DAT_EVENTO');
	$gride->addColumn('ORDEM','ORDEM');
	$gride->addColumn('CARGO','CARGO');
	$gride->addColumn('NOME_PESSOA','NOME_PESSOA');

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
					,"IDAUTORIDADE":""
					,"DAT_INCLUSAO":""
					,"DAT_EVENTO":""
					,"ORDEM":""
					,"CARGO":""
					,"NOME_PESSOA":""
					};
	fwGetGrid('autoridade.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>