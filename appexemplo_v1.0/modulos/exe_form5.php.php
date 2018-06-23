<?php
defined('APLICATIVO') or die();

$whereGrid = ' 1=1 ';
$primaryKey = 'IDTEXTO';
$frm = new TForm('Exemplo Form5 - Consulta Grid',600);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$frm->addTextField('TXNOME', 'TXNOME',50,true);
$frm->addTextField('TXDATA', 'TXDATA',50,true);
$frm->addTextField('STATIVO', 'STATIVO',50,true);
$frm->addTextField('TEXTO', 'TEXTO',50,true);
$frm->addTextField('TX_DATA_INCLUSAO', 'TX_DATA_INCLUSAO',50,true);

$frm->addButton('Buscar', null, 'Buscar', null, null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new Tb_textoVO();
			$frm->setVo( $vo );
			$resultado = Tb_textoDAO::insert( $vo );
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
				'IDTEXTO'=>$frm->get('IDTEXTO')
				,'TXNOME'=>$frm->get('TXNOME')
				,'TXDATA'=>$frm->get('TXDATA')
				,'STATIVO'=>$frm->get('STATIVO')
				,'TEXTO'=>$frm->get('TEXTO')
				,'TX_DATA_INCLUSAO'=>$frm->get('TX_DATA_INCLUSAO')
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
		$resultado = Tb_textoDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}


$dados = Tb_textoDAO::selectAll($primaryKey,$whereGrid);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',TXNOME|TXNOME,TXDATA|TXDATA,STATIVO|STATIVO,TEXTO|TEXTO,TX_DATA_INCLUSAO|TX_DATA_INCLUSAO';
$gride = new TGrid( 'gd'        // id do gride
				   ,'Gride'     // titulo do gride
				   ,$dados 	      // array de dados
				   ,null		  // altura do gride
				   ,null		  // largura do gride
				   ,$primaryKey   // chave primaria
				   ,$mixUpdateFields
				   );
$gride->addColumn($primaryKey,'id',50,'center');
$gride->addColumn('TXNOME','TXNOME',50,'center');
$gride->addColumn('TXDATA','TXDATA',50,'center');
$gride->addColumn('STATIVO','STATIVO',50,'center');
$gride->addColumn('TEXTO','TEXTO',50,'center');
$gride->addColumn('TX_DATA_INCLUSAO','TX_DATA_INCLUSAO',50,'center');
$frm->addHtmlField('gride',$gride);

$frm->show();
?>