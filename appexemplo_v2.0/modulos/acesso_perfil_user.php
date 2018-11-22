<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDPERFILUSER';
$frm = new TForm('acesso_perfil_user',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$listAcesso_perfil = Acesso_perfil::selectAll();
$frm->addSelectField('IDPERFIL', 'IDPERFIL',TRUE,$listAcesso_perfil,null,null,null,null,null,null,' ',null);
$listAcesso_user = Acesso_user::selectAll();
$frm->addSelectField('IDUSER', 'IDUSER',TRUE,$listAcesso_user,null,null,null,null,null,null,' ',null);
$frm->addTextField('SIT_ATIVO', 'SIT_ATIVO',1,TRUE,1);
$frm->addDateField('DAT_INCLUSAO', 'DAT_INCLUSAO',TRUE);
$frm->addDateField('DAT_UPDATE', 'DAT_UPDATE',FALSE);

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new Acesso_perfil_userVO();
				$frm->setVo( $vo );
				$resultado = Acesso_perfil_user::save( $vo );
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
			$resultado = Acesso_perfil_user::delete( $id );;
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
				'IDPERFILUSER'=>$frm->get('IDPERFILUSER')
				,'IDPERFIL'=>$frm->get('IDPERFIL')
				,'IDUSER'=>$frm->get('IDUSER')
				,'SIT_ATIVO'=>$frm->get('SIT_ATIVO')
				,'DAT_INCLUSAO'=>$frm->get('DAT_INCLUSAO')
				,'DAT_UPDATE'=>$frm->get('DAT_UPDATE')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Acesso_perfil_user::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Acesso_perfil_user::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',IDPERFIL|IDPERFIL'
					.',IDUSER|IDUSER'
					.',SIT_ATIVO|SIT_ATIVO'
					.',DAT_INCLUSAO|DAT_INCLUSAO'
					.',DAT_UPDATE|DAT_UPDATE'
					;
	$gride = new TGrid( 'gd'                        // id do gride
					   ,'Gride with SQL Pagination' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'acesso_perfil_user.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('IDPERFIL','IDPERFIL');
	$gride->addColumn('IDUSER','IDUSER');
	$gride->addColumn('SIT_ATIVO','SIT_ATIVO');
	$gride->addColumn('DAT_INCLUSAO','DAT_INCLUSAO');
	$gride->addColumn('DAT_UPDATE','DAT_UPDATE');

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
					,"IDPERFILUSER":""
					,"IDPERFIL":""
					,"IDUSER":""
					,"SIT_ATIVO":""
					,"DAT_INCLUSAO":""
					,"DAT_UPDATE":""
					};
	fwGetGrid('acesso_perfil_user.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>