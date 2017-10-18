<?php
$primaryKey = 'IDPERFIL';
$frm = new TForm('Cadastro de Perfils',600);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( $primaryKey ); // coluna chave da tabela
$frm->addTextField('NOM_PERFIL', 'Nome Perfil',50,true);
$frm->addSelectField('SIT_ATIVO', 'Ativo:', true, 'S=Sim,N=Não', true);
$frm->addTextField('DAT_INCLUSAO', 'Data Inclusão:',null,false,null,null,true)->setReadOnly(true);
$frm->addTextField('DAT_UPDATE', 'Data Update: ',null,false,null,null,false)->setReadOnly(true);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new Acesso_perfilVO();
			$frm->setVo( $vo );
			$resultado = Acesso_perfilDAO::insert( $vo );
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
		$resultado = Acesso_perfilDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}

$dados = Acesso_perfilDAO::selectAll($primaryKey);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',NOM_PERFIL|NOM_PERFIL,SIT_ATIVO|SIT_ATIVO,DAT_INCLUSAO|DAT_INCLUSAO,DAT_UPDATE|DAT_UPDATE';
$gride = new TGrid( 'gd'        // id do gride
				   ,'Gride'     // titulo do gride
				   ,$dados 	      // array de dados
				   ,null		  // altura do gride
				   ,null		  // largura do gride
				   ,$primaryKey   // chave primaria
				   ,$mixUpdateFields
				   );
$gride->addColumn($primaryKey,'id',50,'center');
$gride->addColumn('NOM_PERFIL','Nome Perfil',50,'center');
$gride->addColumn('SIT_ATIVO','Ativo',30,'center');
$gride->addColumn('DAT_INCLUSAO','Data Inclusão',100,'center');
$gride->addColumn('DAT_UPDATE','Data Update',100,'center');
$frm->addHtmlField('gride',$gride);
$frm->setAction( 'Salvar,Limpar' );
$frm->show();
?>