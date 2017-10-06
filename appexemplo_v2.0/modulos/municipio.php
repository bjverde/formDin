<?php
$primaryKey = 'COD_MUNICIPIO';
$frm = new TForm('Cadastro de Municípios',600);
$frm->setFlat(true);


$frm->addHiddenField( $primaryKey ); // coluna chave da tabela
$frm->addTextField('COD_UF', 'COD_UF',50,true);
$frm->addTextField('NOM_MUNICIPIO', 'NOM_MUNICIPIO',50,true);
$frm->addTextField('SIT_ATIVO', 'SIT_ATIVO',50,true);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new MunicipioVO();
			$frm->setVo( $vo );
			$resultado = MunicipioDAO::insert( $vo );
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
		$resultado = MunicipioDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}

$dados = MunicipioDAO::selectAll($primaryKey);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',COD_UF|COD_UF,NOM_MUNICIPIO|NOM_MUNICIPIO,SIT_ATIVO|SIT_ATIVO';
$gride = new TGrid( 'gd'        // id do gride
				   ,'Gride'     // titulo do gride
				   ,$dados 	      // array de dados
				   ,null		  // altura do gride
				   ,null		  // largura do gride
				   ,$primaryKey   // chave primaria
				   ,$mixUpdateFields
				   );
$gride->addColumn($primaryKey,'id',50,'center');
$gride->addColumn('COD_UF','COD_UF',50,'center');
$gride->addColumn('NOM_MUNICIPIO','NOM_MUNICIPIO',50,'center');
$gride->addColumn('SIT_ATIVO','SIT_ATIVO',50,'center');
$frm->addHtmlField('gride',$gride);
$frm->setAction( 'Salvar,Limpar' );
$frm->show();
?>