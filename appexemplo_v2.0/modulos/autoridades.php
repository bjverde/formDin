<?php
require_once('services/autoridades.php');
$primaryKey = 'IDAUTORIDADE';
$frm = new TForm('Cadastro de Autoridades',600);
$frm->setFlat(true);


$frm->addHiddenField( $primaryKey ); // coluna chave da tabela
$frm->addDateField('DAT_INCLUSAO', 'Data inclusão',false,null,null,null,null,null,false)->setReadOnly(true);;
$frm->addDateField('DAT_EVENTO','Data Evento:',true);
$frm->addNumberField('ordem', 'Ordem:',10,true,0,true,null,1,5,true);
$frm->addTextField('cargo', 'Cargo:',50,true);
$frm->addTextField('nome_pessoa', 'Nome Pessoa:',50,true);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new AutoridadeVO();
			$frm->setVo( $vo );
			//$resultado = AutoridadeDAO::insert( $vo );
			$resultado = autoriadeGravar($vo);
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
		$resultado = AutoridadeDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
	break;
}

$dados = AutoridadeDAO::selectAll($primaryKey);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',DAT_INCLUSAO|DAT_INCLUSAO,DAT_EVENTO|DAT_EVENTO,ORDEM|ORDEM,CARGO|CARGO,NOME_PESSOA|NOME_PESSOA';
$gride = new TGrid( 'gd'        // id do gride
				   ,'Gride'     // titulo do gride
				   ,$dados 	      // array de dados
				   ,null		  // altura do gride
				   ,null		  // largura do gride
				   ,$primaryKey   // chave primaria
				   ,$mixUpdateFields
				   );
$gride->addColumn($primaryKey,'id',50,'center');
$gride->addColumn('DAT_INCLUSAO','DAT_INCLUSAO',50,'center');
$gride->addColumn('DAT_EVENTO','DAT_EVENTO',50,'center');
$gride->addColumn('ORDEM','ORDEM',50,'center');
$gride->addColumn('CARGO','CARGO',50,'center');
$gride->addColumn('NOME_PESSOA','NOME_PESSOA',50,'center');
$frm->addHtmlField('gride',$gride);
$frm->setAction( 'Salvar,Limpar' );
$frm->show();
?>