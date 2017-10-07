<?php
$primaryKey = 'IDUSER';
$frm = new TForm('Cadastro de usuários ',600);
$frm->setFlat(true);


$frm->addHiddenField( $primaryKey ); // coluna chave da tabela
$frm->addTextField('NOM_USER', 'NOM_USER',50,true);
$frm->addTextField('PWD_USER', 'PWD_USER',50,true);
$frm->addTextField('SIT_ATIVO', 'SIT_ATIVO',50,true);
$frm->addTextField('DAT_INCLUSAO', 'DAT_INCLUSAO',50,true);
$frm->addTextField('DAT_UPDATE', 'DAT_UPDATE',50,true);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new Acesso_userVO();
			$frm->setVo( $vo );
			$resultado = Acesso_userDAO::insert( $vo );
			if($resultado==1) {
				$frm->setMessage('Registro gravado com sucesso!!!');
				$frm->clearFields();
			}else{
				$frm->setMessage($resultado);
			}
		}
	break;
	//--------------------------------------------------------------------------------
	case 'Limpar':
		$frm->clearFields();
	break;
	//--------------------------------------------------------------------------------
	case 'gd_excluir':
		$id = $frm->get( $primaryKey ) ;
		$resultado = Acesso_userDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}

$dados = Acesso_userDAO::selectAll($primaryKey);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',NOM_USER|NOM_USER,PWD_USER|PWD_USER,SIT_ATIVO|SIT_ATIVO,DAT_INCLUSAO|DAT_INCLUSAO,DAT_UPDATE|DAT_UPDATE';
$gride = new TGrid( 'gd'        // id do gride
				   ,'Gride'     // titulo do gride
				   ,$dados 	      // array de dados
				   ,null		  // altura do gride
				   ,null		  // largura do gride
				   ,$primaryKey   // chave primaria
				   ,$mixUpdateFields
				   );
$gride->addColumn($primaryKey,'id',50,'center');
$gride->addColumn('NOM_USER','NOM_USER',50,'center');
$gride->addColumn('PWD_USER','PWD_USER',50,'center');
$gride->addColumn('SIT_ATIVO','SIT_ATIVO',50,'center');
$gride->addColumn('DAT_INCLUSAO','DAT_INCLUSAO',50,'center');
$gride->addColumn('DAT_UPDATE','DAT_UPDATE',50,'center');
$frm->addHtmlField('gride',$gride);
$frm->setAction( 'Salvar,Limpar' );
$frm->show();
?>