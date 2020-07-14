<?php
defined('APLICATIVO') or die();

$whereGrid = ' 1=1 ';
$primaryKey = 'COD_MUNICIPIO';
$frm = new TForm('Exe Grid 16 - Grid simples completo v2',600);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$frm->addTextField('COD_UF', 'COD_UF',50,true);
$frm->addTextField('NOM_MUNICIPIO', 'NOM_MUNICIPIO',50,true);

$frm->addButton('Buscar', null, 'Buscar', null, null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new Tb_municipioVO();
			$frm->setVo( $vo );
			$resultado = Tb_municipioDAO::insert( $vo );
			if($resultado==1) {
				$frm->setMessage('Registro gravado com sucesso!!!');
				$frm->clearFields();
			}else{
				$frm->setMessage($resultado);
			}
		}
	break;
	//--------------------------------------------------------------------------------
	case 'Buscar':
		$retorno = array(
				'COD_MUNICIPIO'=>$frm->get('COD_MUNICIPIO')
				,'COD_UF'=>$frm->get('COD_UF')
				,'NOM_MUNICIPIO'=>$frm->get('NOM_MUNICIPIO')
		);
		$whereGrid = $retorno;
	break;
	//--------------------------------------------------------------------------------
	case 'Limpar':
		$frm->clearFields();
	break;
	//--------------------------------------------------------------------------------
	case 'gd_excluir':
		$id = $frm->get( $primaryKey ) ;
		$resultado = Tb_municipioDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}


$dados = Tb_municipioDAO::selectAll($primaryKey,$whereGrid);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',COD_UF|COD_UF,NOM_MUNICIPIO|NOM_MUNICIPIO';
$gride = new TGrid( 'gd'        // id do gride
				   ,'Gride'     // titulo do gride
				   ,$dados 	      // array de dados
				   ,null		  // altura do gride
				   ,null		  // largura do gride
				   ,$primaryKey   // chave primaria
				   ,$mixUpdateFields
				   );
$gride->addColumn($primaryKey,'id',null,'center');
$gride->addColumn('COD_UF','COD_UF',null,'center');
$gride->addColumn('NOM_MUNICIPIO','NOM_MUNICIPIO');
$frm->addHtmlField('gride',$gride);

$frm->show();
?>