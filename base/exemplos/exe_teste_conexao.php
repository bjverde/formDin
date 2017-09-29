<?php
$frm = new TForm('Teste de Conexão',500,900);
$frm->setAutoSize(true);

$pc = $frm->addPageControl('pc');
$pc->addPage('MYSQL',true,true,'abamy');
	$frm->addHiddenField('myDbType','mysql');
	$frm->addTextField('myHost'	,'Host:',20,true,20,'127.0.0.0.1',true,null,null,true);
	$frm->addTextField('myDb	','Database:',20,true,20,'test',true,null,null,true);
	$frm->addTextField('myUser'	,'User:',40,true,20,'root',false,null,null,true);
	$frm->addTextField('myPass'	,'Password:',40,true,20,'',false,null,null,true);
	$frm->addTextField('myPort'	,'Porta:',6,false,6,'3306',false,null,null,true,false);
	$frm->addButton('Testar Conexão',null,'btnTestarmy','testarConexao("my")',null,true,false);
	$frm->addMemoField('mySql'	,'Sql:',10000,false,90,5,true,true,true,null,true);
	$frm->addButton('Executar Sql',null,'btnSqlmy','executarSql("my")',null,true,false);
	$frm->addHtmlField('myGride'	,'');

$pc->addPage('POSTGRES',false,true,'abapg');
	$frm->addHiddenField('pgDbType','postgres');
	$frm->addTextField('pgHost','Host:',20,true,20,'127.0.0.0.1',true,null,null,true);
	$frm->addTextField('pgDb	','Database:',20,true,20,'test',true,null,null,true);
	$frm->addTextField('pgUser','User:',40,true,20,'postgres',false,null,null,true);
	$frm->addTextField('pgPass','Password:',40,true,20,'123456',false,null,null,true);
	$frm->addTextField('pgSchema','Esquema:',20,true,20,'public',false,null,null,true);
	$frm->addTextField('pgPort','Porta:',6,false,6,'5432',false,null,null,true,false);
	$frm->addButton('Testar Conexão',null,'btnTestarPg','testarConexao("pg")',null,true,false);
	$frm->addMemoField('pgSql','Sql:',10000,false,90,5,true,true,true,null,true);
	$frm->addButton('Executar Sql',null,'btnSqlPg','executarSql("pg")',null,true,false);
	$frm->addHtmlField('pgGride','');

$pc->addPage('SQLITE',false,true,'abaSqlite');
	$frm->addHiddenField('sqDbType','sqlite');
	$frm->addTextField('sqDb	','Database:',80,true,80,'bdApoio.s3db',false,null,null,true);
	$frm->addButton('Testar Conexão',null,'btnTestarsq','testarConexao("sq")',null,true,false);
	$frm->addMemoField('sqSql'	,'Sql:',10000,false,90,5,true,true,true,null,true);
	$frm->addButton('Executar Sql',null,'btnSqlsq','executarSql("sq")',null,true,false);
	$frm->addHtmlField('sqGride'	,'');

//$dao = new TDAO('tb_uf','oracle','root','123456','xe','192.168.1.140',null,null,null,null,true);
$pc->addPage('ORACLE',true,true,'abaora');
	$frm->addHiddenField('oraDbType','oracle');
	$frm->addTextField('oraHost'	,'Host:',20,true,20,'127.0.0.0.1',true,null,null,true);
	$frm->addTextField('oraDb'		,'Database:',20,true,20,'xe',true,null,null,true);
	$frm->addTextField('oraUser'	,'User:',40,true,20,'root',false,null,null,true);
	$frm->addTextField('oraPass'	,'Password:',40,true,20,'123456',false,null,null,true);
    $frm->addButton('Testar Conexão',null,'btnTestarora','testarConexao("ora")',null,true,false);
	$frm->addMemoField('oraSql'	,'Sql:',10000,false,90,5,true,true,true,null,true);
	$frm->addButton('Executar Sql',null,'btnSqlOra','executarSql("ora")',null,true,false);
	$frm->addHtmlField('oraGride'	,'');


$banco = $_POST['banco'];
switch($acao)
{
	case 'testar_conexao':


		//prepareReturnAjax(0,null, $banco.print_r($_POST,TRUE) );
		if( $banco == 'my' || $banco == 'pg' || $banco == 'ora')
		{
			if( ! $_POST[$banco.'User'] )
			{
				prepareReturnAjax(0,null,'Informe o Usuário');
			}
		}
		$dao = new TDAO(null,$_POST['dbType'],$_POST[$banco.'User'],$_POST[$banco.'Pass'],$_POST[$banco.'Db'],$_POST[$banco.'Host'],$_POST[$banco.'Port'],$_POST[$banco.'Schema']);
		if( $dao->connect() )
		{
			prepareReturnAjax(2,null,'Conexão OK!');
		}
		prepareReturnAjax(0,null, $dao->getError());

	break;

	case 'executar_sql':
	{
		//if( $banco == 'my' || $banco == 'pg')
		{
			//prepareReturnAjax(0,null,print_r($_POST,true));
			$dao = new TDAO(null,$_POST['dbType'],$_POST[$banco.'User'],$_POST[$banco.'Pass'],$_POST[$banco.'Db'],$_POST[$banco.'Host'],$_POST[$banco.'Port'],$_POST[$banco.'Schema']);
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
