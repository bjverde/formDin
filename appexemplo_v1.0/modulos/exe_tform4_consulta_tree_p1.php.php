<?php
$primaryKey = 'ID_PEDIDO';
$frm = new TForm('Exemplo Form4 - Consulta Grid',600);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( $primaryKey ); // coluna chave da tabela
$frm->addTextField('DATA_PEDIDO', 'DATA_PEDIDO',50,true);
$frm->addTextField('NOME_COMPRADOR', 'NOME_COMPRADOR',50,true);
$frm->addTextField('FORMA_PAGAMENTO', 'FORMA_PAGAMENTO',50,true);
$frm->addTextField('DES_FORMA_PAGAMENTO', 'DES_FORMA_PAGAMENTO',50,true);
$frm->addTextField('QTD', 'QTD',50,true);

$frm->addButton('Salvar', null, 'Salvar', null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new Vw_pedido_qtd_itensVO();
			$frm->setVo( $vo );
			$resultado = Vw_pedido_qtd_itensDAO::insert( $vo );
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
		$resultado = Vw_pedido_qtd_itensDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}

$dados = Vw_pedido_qtd_itensDAO::selectAll($primaryKey);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',DATA_PEDIDO|DATA_PEDIDO,NOME_COMPRADOR|NOME_COMPRADOR,FORMA_PAGAMENTO|FORMA_PAGAMENTO,DES_FORMA_PAGAMENTO|DES_FORMA_PAGAMENTO,QTD|QTD';
$gride = new TGrid( 'gd'        // id do gride
				   ,'Gride'     // titulo do gride
				   ,$dados 	      // array de dados
				   ,null		  // altura do gride
				   ,null		  // largura do gride
				   ,$primaryKey   // chave primaria
				   ,$mixUpdateFields
				   );
$gride->addColumn($primaryKey,'id',50,'center');
$gride->addColumn('DATA_PEDIDO','DATA_PEDIDO',50,'center');
$gride->addColumn('NOME_COMPRADOR','NOME_COMPRADOR',50,'center');
$gride->addColumn('FORMA_PAGAMENTO','FORMA_PAGAMENTO',50,'center');
$gride->addColumn('DES_FORMA_PAGAMENTO','DES_FORMA_PAGAMENTO',50,'center');
$gride->addColumn('QTD','QTD',50,'center');
$frm->addHtmlField('gride',$gride);

$frm->show();
?>