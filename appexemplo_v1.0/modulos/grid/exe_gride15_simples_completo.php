<?php
defined('APLICATIVO') or die();

$whereGrid = ' 1=1 ';
$primaryKey = 'IDFORM_PAGAMENTO';
$frm = new TForm('Exe Grid 15 - Grid simples completo',600);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$frm->addTextField('DESCRICAO', 'DESCRICAO',50,true);

$frm->addButton('Buscar', null, 'Buscar', null, null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new Tb_forma_pagamentoVO();
			$frm->setVo( $vo );
			$resultado = Tb_forma_pagamentoDAO::insert( $vo );
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
				'IDFORM_PAGAMENTO'=>$frm->get('IDFORM_PAGAMENTO')
				,'DESCRICAO'=>$frm->get('DESCRICAO')
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
		$resultado = Tb_forma_pagamentoDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}


$dados = Tb_forma_pagamentoDAO::selectAll($primaryKey,$whereGrid);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',DESCRICAO|DESCRICAO';
$gride = new TGrid( 'gd'        // id do gride
				   ,'Gride'     // titulo do gride
				   ,$dados 	      // array de dados
				   ,null		  // altura do gride
				   ,null		  // largura do gride
				   ,$primaryKey   // chave primaria
				   ,$mixUpdateFields
				   );
$gride->addColumn($primaryKey,'id',null,'center');
$gride->addColumn('DESCRICAO','DESCRICAO');
$frm->addHtmlField('gride',$gride);

$frm->show();
?>