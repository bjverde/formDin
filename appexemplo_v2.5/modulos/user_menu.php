<?php
$primaryKey = 'IDUSER';
$frm = new TForm('Usuario e Menu',600);
$frm->setFlat(true);


$frm->addHiddenField( $primaryKey ); // coluna chave da tabela
$frm->addTextField('LOGIN_USER', 'LOGIN_USER',50,true);
$frm->addTextField('IDPERFIL', 'IDPERFIL',50,true);
$frm->addTextField('NOM_PERFIL', 'NOM_PERFIL',50,true);
$frm->addTextField('IDMENU', 'IDMENU',50,true);
$frm->addTextField('NOM_MENU', 'NOM_MENU',50,true);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new User_menuVO();
			$frm->setVo( $vo );
			$resultado = User_menuDAO::insert( $vo );
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
		$resultado = User_menuDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}

$dados = User_menuDAO::selectAll($primaryKey);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',LOGIN_USER|LOGIN_USER,IDPERFIL|IDPERFIL,NOM_PERFIL|NOM_PERFIL,IDMENU|IDMENU,NOM_MENU|NOM_MENU';
$gride = new TGrid( 'gd'        // id do gride
				   ,'Gride'     // titulo do gride
				   ,$dados 	      // array de dados
				   ,null		  // altura do gride
				   ,null		  // largura do gride
				   ,$primaryKey   // chave primaria
				   ,$mixUpdateFields
				   );
$gride->addColumn($primaryKey,'id',50,'center');
$gride->addColumn('LOGIN_USER','LOGIN_USER',50,'center');
$gride->addColumn('IDPERFIL','IDPERFIL',50,'center');
$gride->addColumn('NOM_PERFIL','NOM_PERFIL',50,'center');
$gride->addColumn('IDMENU','IDMENU',50,'center');
$gride->addColumn('NOM_MENU','NOM_MENU',50,'center');
$frm->addHtmlField('gride',$gride);
$frm->setAction( 'Salvar,Limpar' );
$frm->show();
?>