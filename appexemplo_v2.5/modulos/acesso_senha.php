<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDPERFILUSER';
$frm = new TForm('Alterar a senha');
$frm->setFlat(true);
$frm->setMaximize(true);

include 'modulos/acesso_aviso.php';
$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$login = ArrayHelper::get( $_SESSION[APLICATIVO],'LOGIN');
$frm->addTextField('login','Login',20,true,20,$login)->setEnabled(false);
$frm->addPasswordField('senha1','Senha',true,20);
$frm->addPasswordField('senha2','Repita a Senha',true,20);

$frm->addButton('Salvar', null, 'Salvar', null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$senha1 = $frm->getFieldValue('senha1');
				$senha2 = $frm->getFieldValue('senha2');
				if(strlen($senha1)<8){
					throw new DomainException('A senha de ter no minomo 8 caractes');
				}
				if($senha1 != $senha2){
					throw new DomainException('As senhas não iguais');
				}

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
					   ,'Relações' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'acesso_perfil_user.php' );

	$gride->addColumn($primaryKey,'id',null,'center');
	$gride->addColumn('IDPERFIL','IDPERFIL',null,'center');
	$gride->addColumn('NOM_PERFIL','Perfil');
	$gride->addColumn('IDUSER','IDUSER',null,'center');
	$gride->addColumn('LOGIN_USER','Login');
	//$gride->addColumn('SIT_ATIVO','SIT_ATIVO');
	$gride->addColumn('DAT_INCLUSAO','Data da inclusão',null,'center');
	$gride->addColumn('DAT_UPDATE','Data do Update',null,'center');

	$gride->show();
	die();
}

$frm->show();

?>