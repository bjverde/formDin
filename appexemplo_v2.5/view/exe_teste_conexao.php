<?php
$frm = new TForm('Teste de Conexão',500,900);
$frm->setAutoSize(true);

$pc = $frm->addPageControl('pc');
$pc->addPage('MYSQL',true,true,'abamy');
	$frm->addHiddenField('myDbType','mysql');
	$frm->addTextField('myHost'	,'Host:',20,true,20,'localhost',true,null,null,true);
	$frm->addTextField('myDb	','Database:',20,true,20,'form_exemplo',true,null,null,true);
	$frm->addTextField('myUser'	,'User:',40,true,20,'form_exemplo',false,null,null,true);
	$frm->addTextField('myPass'	,'Password:',40,true,20,'123456',false,null,null,true);
	$frm->addTextField('myPort'	,'Porta:',6,false,6,'3306',false,null,null,true,false);
	$frm->addButton('Testar Conexão',null,'btnTestarmy','testarConexao("my")',null,true,false);
	$frm->addMemoField('mySql'	,'Sql:',10000,false,90,5,true,true,true,null,true);
	$frm->addButton('Executar Sql',null,'btnSqlmy','executarSql("my")',null,true,false);
	$frm->addHtmlField('myGride'	,'');

$_POST['banco'] = isset($_POST['banco']) ? $_POST['banco'] : '';
$banco = $_POST['banco'];
$Schema = isset($_POST[$banco.'Schema']) ? $_POST[$banco.'Schema'] : '';

$acao = isset($acao) ? $acao : '';
switch($acao) {
	case 'testar_conexao':
		//prepareReturnAjax(0,null, $banco.print_r($_POST,TRUE) );
		if( $banco == 'my' || $banco == 'pg' || $banco == 'ora'){
			if( ! $_POST[$banco.'User'] ){
				prepareReturnAjax(0,null,'Informe o Usuário');
			}
		}
		
		$dao = new TDAO(null,$_POST['dbType'],$_POST[$banco.'User'],$_POST[$banco.'Pass'],$_POST[$banco.'Db'],$_POST[$banco.'Host'],$_POST[$banco.'Port'],$Schema);
		if( $dao->connect() ) {
			prepareReturnAjax(2,null,'Conexão OK!');
		}
		prepareReturnAjax(0,null, $dao->getError());

	break;

	case 'executar_sql':
	{
		//if( $banco == 'my' || $banco == 'pg')
		{
			//prepareReturnAjax(0,null,print_r($_POST,true));
			$dao = new TDAO(null,$_POST['dbType'],$_POST[$banco.'User'],$_POST[$banco.'Pass'],$_POST[$banco.'Db'],$_POST[$banco.'Host'],$_POST[$banco.'Port'],$Schema);
			$dados = $dao->executeSql($_POST[$banco.'Sql']);
			if( ! $dao->getError() )
			{
				$g = new TGrid('gd'.$banco,'Resultado SQL',$dados);
				$g->setCreateDefaultEditButton(false);
				$g->setCreateDefaultDeleteButton(false);
				prepareReturnAjax(2,null,$g->show(false));
			}
			prepareReturnAjax(0,null, $dao->getError());
		}
		die; // ajax
	}
}
$frm->show();

?>

<style>
.fwField
{
	font-size:14px;
}
.fwMemo{
	    font-family: "Corier New" Arial;
	    font-size:14px;
	    color:navy;
}
</style>
<script>
function testarConexao(banco)
{
	var data={};
	data['banco'] = banco;
	data['dbType'] = jQuery("#"+banco+'DbType').val();
	data[banco+'Host'] = jQuery("#"+banco+'Host').val();
	data[banco+'User'] = jQuery("#"+banco+'User').val();
	data[banco+'Pass'] = jQuery("#"+banco+'Pass').val();
	data[banco+'Port'] = jQuery("#"+banco+'Port').val();
	data[banco+'Db']   = jQuery("#"+banco+'Db').val();
	data[banco+'Schema']   = jQuery("#"+banco+'Schema').val();
	jQuery("#"+banco+"Gride").html('');
	fwAjaxRequest({
		"action":"testar_conexao",
		"async":false,
		"dataType":"json",
		"data":data,
		"callback":function(res)
		{
			if( res.status == 2 )
			{
				fwAlert( res.message);

			}
			else
			{
				jQuery("#"+banco+"Gride").html( res.message );
			}
		}
	})

}
function executarSql(banco)
{
	var data={};
	data['banco'] = banco;
	data['dbType'] = jQuery("#"+banco+'DbType').val();
	data[banco+'Host'] = jQuery("#"+banco+'Host').val();
	data[banco+'User'] = jQuery("#"+banco+'User').val();
	data[banco+'Pass'] = jQuery("#"+banco+'Pass').val();
	data[banco+'Port'] = jQuery("#"+banco+'Port').val();
	data[banco+'Db']   = jQuery("#"+banco+'Db').val();
	data[banco+'Schema']   = jQuery("#"+banco+'Schema').val();
	data[banco+'Sql']   = jQuery("#"+banco+'Sql').val();
	jQuery("#"+banco+"Gride").html('');
	fwAjaxRequest({
		"action":"executar_sql",
		"async":false,
		"dataType":"json",
		"data":data,
		"callback":function(res)
		{
			if( res.status != 2 )
			{
				fwAlert( res.message);

			}
			else
			{
				jQuery("#"+banco+"Gride").html( res.message );
			}
		}
	})

}
</script>
