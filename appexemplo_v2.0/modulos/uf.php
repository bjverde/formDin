<?php
$primaryKey = 'COD_UF';
$frm = new TForm('Cadastro de Uf',600);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( $primaryKey ); // coluna chave da tabela
$frm->addTextField('NOM_UF', 'Nome',50,true);
$frm->addTextField('SIG_UF', 'Sigla',50,true);

$dadosRegiao = RegiaoDAO::selectAll('COD_REGIAO');
$frm->addSelectField('COD_REGIAO','Região:',true,$dadosRegiao);

$frm->addButton('Salvar', null, 'Salvar', null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new UfVO();
			$frm->setVo( $vo );
			$resultado = UfDAO::insert( $vo );
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
		$resultado = UfDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}

$dados = UfDAO::selectAll($primaryKey);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',NOM_UF|NOM_UF,SIG_UF|SIG_UF,COD_REGIAO|COD_REGIAO';
$gride = new TGrid( 'gd'        // id do gride
				   ,'Gride'     // titulo do gride
				   ,$dados 	      // array de dados
				   ,null		  // altura do gride
				   ,null		  // largura do gride
				   ,$primaryKey   // chave primaria
				   ,$mixUpdateFields
				   );
$gride->addColumn($primaryKey,'id',50,'center');
$gride->addColumn('NOM_UF','Nome',100,'center');
$gride->addColumn('SIG_UF','Sigla',50,'center');
$gride->addColumn('COD_REGIAO','COD_REGIAO',50,'center');
$frm->addHtmlField('gride',$gride);
$frm->show();
?>