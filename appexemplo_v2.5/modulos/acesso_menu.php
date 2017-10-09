<?php
$primaryKey = 'IDMENU';
$frm = new TForm('Cadastro de Menu',600);
$frm->setFlat(true);


$frm->addHiddenField( $primaryKey ); // coluna chave da tabela
$frm->addTextField('IDMENU_PAI', 'IDMENU_PAI',50,true);
$frm->addTextField('NOM_MENU', 'NOM_MENU',50,true);
$frm->addTextField('URL', 'URL',50,true);
$frm->addTextField('TOOLTIP', 'TOOLTIP',50,true);
$frm->addTextField('IMG_MENU', 'IMG_MENU',50,true);
$frm->addTextField('IMGDISABLED', 'IMGDISABLED',50,true);
$frm->addTextField('DISSABLED', 'DISSABLED',50,true);
$frm->addTextField('HOTKEY', 'HOTKEY',50,true);
$frm->addTextField('BOOLSEPARATOR', 'BOOLSEPARATOR',50,true);
$frm->addTextField('JSONPARAMS', 'JSONPARAMS',50,true);
$frm->addTextField('SIT_ATIVO', 'SIT_ATIVO',50,true);
$frm->addTextField('DAT_INCLUSAO', 'DAT_INCLUSAO',50,true);
$frm->addTextField('DAT_UPDATE', 'DAT_UPDATE',50,true);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new Acesso_menuVO();
			$frm->setVo( $vo );
			$resultado = Acesso_menuDAO::insert( $vo );
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
		$resultado = Acesso_menuDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}

$dados = Acesso_menuDAO::selectAll($primaryKey);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',IDMENU_PAI|IDMENU_PAI,NOM_MENU|NOM_MENU,URL|URL,TOOLTIP|TOOLTIP,IMG_MENU|IMG_MENU,IMGDISABLED|IMGDISABLED,DISSABLED|DISSABLED,HOTKEY|HOTKEY,BOOLSEPARATOR|BOOLSEPARATOR,JSONPARAMS|JSONPARAMS,SIT_ATIVO|SIT_ATIVO,DAT_INCLUSAO|DAT_INCLUSAO,DAT_UPDATE|DAT_UPDATE';
$gride = new TGrid( 'gd'        // id do gride
				   ,'Gride'     // titulo do gride
				   ,$dados 	      // array de dados
				   ,null		  // altura do gride
				   ,null		  // largura do gride
				   ,$primaryKey   // chave primaria
				   ,$mixUpdateFields
				   );
$gride->addColumn($primaryKey,'id',50,'center');
$gride->addColumn('IDMENU_PAI','IDMENU_PAI',50,'center');
$gride->addColumn('NOM_MENU','NOM_MENU',50,'center');
$gride->addColumn('URL','URL',50,'center');
$gride->addColumn('TOOLTIP','TOOLTIP',50,'center');
$gride->addColumn('IMG_MENU','IMG_MENU',50,'center');
$gride->addColumn('IMGDISABLED','IMGDISABLED',50,'center');
$gride->addColumn('DISSABLED','DISSABLED',50,'center');
$gride->addColumn('HOTKEY','HOTKEY',50,'center');
$gride->addColumn('BOOLSEPARATOR','BOOLSEPARATOR',50,'center');
$gride->addColumn('JSONPARAMS','JSONPARAMS',50,'center');
$gride->addColumn('SIT_ATIVO','SIT_ATIVO',50,'center');
$gride->addColumn('DAT_INCLUSAO','DAT_INCLUSAO',50,'center');
$gride->addColumn('DAT_UPDATE','DAT_UPDATE',50,'center');
$frm->addHtmlField('gride',$gride);
$frm->setAction( 'Salvar,Limpar' );
$frm->show();
?>