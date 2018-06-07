<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
 * Criado por Luís Eugênio Barbosa
 * Essa versão é um Fork https://github.com/bjverde/formDin
 *
 * ----------------------------------------------------------------------------
 * This file is part of Formdin Framework.
 *
 * Formdin Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License version 3
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License version 3
 * along with this program; if not,  see <http://www.gnu.org/licenses/>
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA  02110-1301, USA.
 * ----------------------------------------------------------------------------
 * Este arquivo é parte do Framework Formdin.
 *
 * O Framework Formdin é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da GNU LGPL versão 3 como publicada pela Fundação
 * do Software Livre (FSF).
 *
 * Este programa é distribuí1do na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licen?a Pública Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

$frm = new TForm('Teste de Conexão',650,900);
$frm->setFlat(true);
$frm->setAutoSize(true);

$pc = $frm->addPageControl('pc');
$pc->addPage('MYSQL',true,true,'abamy');
    $frm->addHiddenField('myDbType',DBMS_MYSQL);
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
    $frm->addHiddenField('pgDbType',DBMS_POSTGRES);
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
	$frm->addHiddenField('sqDbType',DBMS_SQLITE);
	$frm->addTextField('sqDb	','Database:',80,true,80,'bancos_locais/bdApoio.s3db',false,null,null,true);
	$frm->addButton('Testar Conexão',null,'btnTestarsq','testarConexao("sq")',null,true,false);
	$frm->addMemoField('sqSql'	,'Sql:',10000,false,90,5,true,true,true,null,true);
	$frm->addButton('Executar Sql',null,'btnSqlsq','executarSql("sq")',null,true,false);
	$frm->addHtmlField('sqGride'	,'');

$pc->addPage('ORACLE',true,true,'abaora');
    $frm->addHiddenField('oraDbType',DBMS_ORACLE);
	$frm->addTextField('oraHost'	,'Host:',50,true,50,'127.0.0.0.1',true,null,null,true);
	$frm->addTextField('oraDb'		,'Database:',20,true,20,'xe',true,null,null,true);
	$frm->addTextField('oraUser'	,'User:',40,true,20,'root',false,null,null,true);
	$frm->addTextField('oraPass'	,'Password:',40,true,20,'123456',false,null,null,true);
    $frm->addButton('Testar Conexão',null,'btnTestarora','testarConexao("ora")',null,true,false);
	$frm->addMemoField('oraSql'	,'Sql:',10000,false,90,5,true,true,true,null,true);
	$frm->addButton('Executar Sql',null,'btnSqlOra','executarSql("ora")',null,true,false);
	$frm->addHtmlField('oraGride'	,'');


$pc->addPage('SQLSERVER',true,true,'abass');
    $info_sqlserver = '<p>Para usar Microsoft SQL Server com PHP superior 5.4 e inferior a 7.0 utilize'
                    . '<ul>'
                    . '    <li>Linux: PDO com drive dblib</li>'
                    . '    <li>Windows: PDO com drive sqlsrv</li>'
                    . '<ul>'
                    . '</p><p>ATENÇÃO o Drive da Microsoft não funciona em Windows 64 bits com PHP 64Bits, se deseja usar essa configuração instale o drive não oficial. Porém recomendavel Win 64 Bits com PHP 32Bits</p>'
                    . '<p>PHP 7.0 ou superior é recomendavel utilizar o Drive oficial da Microsoft</p>'
                    		;

    $frm->addHiddenField('ssDbType',DBMS_SQLSERVER);
	$frm->addHtmlField('msg',$info_sqlserver);
	$frm->addTextField('ssHost'    ,'Host:',50,true,50,'127.0.0.0.1',true,null,null,true);
	$frm->addTextField('ssDb'      ,'Database:',20,true,20,'Northwind',true,null,null,true);
	$frm->addTextField('ssUser'    ,'User:',40,true,20,'sa',false,null,null,true);
	$frm->addTextField('ssPass'	   ,'Password:',40,true,20,'123456',false,null,null,true);
	$frm->addTextField('ssPort'    ,'Porta:',6,false,6,'1433',false,null,null,true,false);
    $frm->addButton('Testar Conexão',null,'btnTestarss','testarConexao("ss")',null,true,false);
	$frm->addMemoField('oraSql'	,'Sql:',10000,false,90,5,true,true,true,null,true);
	$frm->addButton('Executar Sql',null,'btnSqlss','executarSql("ss")',null,true,false);
	$frm->addHtmlField('ssGride'	,'');

$banco    = PostHelper::get('banco');
$dbType   = PostHelper::get('dbType');
$user     = PostHelper::get($banco.'User');
$password = PostHelper::get($banco.'Pass');
$dataBase = PostHelper::get($banco.'Db');
$host     = PostHelper::get($banco.'Host');
$port     = PostHelper::get($banco.'Port');
$schema   = PostHelper::get($banco.'Schema');
$sql      = PostHelper::get($banco.'Sql');
$acao = isset($acao) ? $acao : '';
switch($acao) {
	case 'testar_conexao':
		//prepareReturnAjax(0,null, $banco.print_r($_POST,TRUE) );
		if( $banco == 'my' || $banco == 'pg' || $banco == 'ora'|| $banco == 'ss'){
			if( ! $user ){
				prepareReturnAjax(0,null,'Informe o Usuário');
			}
		}
		$dao = new TDAO(null,$dbType,$user,$password,$dataBase,$host,$port,$schema);
		if( $dao->connect() ) {
			prepareReturnAjax(2,null,'Conexão OK!',true);
		}
		prepareReturnAjax(0,null, $dao->getError());

	break;

	case 'executar_sql':
	{
		//if( $banco == 'my' || $banco == 'pg')
		{
			//prepareReturnAjax(0,null,print_r($_POST,true));
			$dao = new TDAO(null,$dbType,$user,$password,$dataBase,$host,$port,$schema);
			$dados = $dao->executeSql($sql);
			if( ! $dao->getError() ) {
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
