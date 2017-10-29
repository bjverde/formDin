<?php
$primaryKey = 'COD_UF';
$frm = new TForm('Cadastro de Uf',400,900);
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
//d($_POST);

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {

	
	$maxRows = 3;
	$page = PostHelper::get('page'); 
	//$dados = UfDAO::selectAll($primaryKey);
	$dados = UfDAO::selectAllPagination( $primaryKey, null, $page,  10);
	$mixUpdateFields = $primaryKey.'|'.$primaryKey.',NOM_UF|NOM_UF,SIG_UF|SIG_UF,COD_REGIAO|COD_REGIAO';
	$gride = new TGrid( 'gd'        // id do gride
					   ,'Gride'     // titulo do gride
					   );
	$gride->setMaxRows( $maxRows );
	$gride->setData( $dados ); // array de dados
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setUpdateFields( $mixUpdateFields );
	$gride->setUrl( 'uf_paginador.php' );
	$gride->setOnDrawActionButton('onDraw');
	
	$gride->addColumn($primaryKey,'id',50,'center');
	$gride->addColumn('NOM_UF','Nome',100,'center');
	$gride->addColumn('SIG_UF','Sigla',50,'center');
	$gride->addColumn('COD_REGIAO','COD_REGIAO',50,'center');
	$gride->show();
	die();
}


$frm->addHtmlField('gride');
$frm->addJavascript('init()');
$frm->show();



function onDraw($rowNum, $button, $objColumn, $aData) {
	// $button->setEnabled( false );
	if ($button->getName () == 'btnAlterar') {
		if ($rowNum == 1) {
			$button->setEnabled ( false );
		}
	}
}

?>

<script>
function init(){
	fwGetGrid("uf_paginador.php",'gride');
}
// recebe fields e values do grid
function alterar(f,v) {
	var dados = fwFV2O(f,v);
	fwModalBox('Alteração','index.php?modulo=uf_paginador.php',300,800,null,dados);
}
</script>