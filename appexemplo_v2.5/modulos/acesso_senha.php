<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDPERFILUSER';
$frm = new TForm('Alterar a senha',300,400);
$frm->setFlat(true);
$frm->setMaximize(true);

include 'modulos/acesso_aviso.php';
$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$login = ArrayHelper::get( $_SESSION[APLICATIVO],'LOGIN');
$frm->addTextField('login','Login',20,true,20,$login)->setEnabled(false);
$frm->addPasswordField('senha','Senha atual',true,20);
$frm->addHtmlField('espaço1','');
$frm->addPasswordField('senha1','Nova Senha',true,20);
$frm->addPasswordField('senha2','Repita a nova Senha',true,20);
$frm->addHtmlField('espaço2','');
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
		$frm->clearFields(null,array('login'));
	break;
}

$frm->show();

?>