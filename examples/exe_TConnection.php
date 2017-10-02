<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt">
<head>
    <title>Teste TConnection</title>
    <meta name="language" content="pt">
<!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">-->
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>

<?php
/**
* @todo Implementar método open,first,last, next, prior
*/
/*
$conn = oci_connect('root','123456','xe');
print_r($conn);
*/
echo '<pre>';
$img = file_get_contents('imagem/acessibilidade-brasil.gif');
$txt = file_get_contents('config.php');
require_once('../base/classes/webform/TConnection.class.php');

// teste sqlite
$d = new TDAO('tb_test','sqlite',null,null,'bdApoio.s3db');
$d->setMetadataDir('dao/metadata');
if( ! $d->connect() )
{
	print_r($d->getError());
	die;
}
else
{

	//$d->setContentType('utf8');
	/*echo 'UTF8:'.$d->getUtf8().'<br>';
	echo 'CONTENT:'.$d->getContentType().'<br>';
    echo 'AutoIncField:'.$d->getAutoincFieldName().'<br>';
    echo 'DbType:'.$d->getDbType().'<br>';
    echo 'Conn DbType:'.$d->getConnDbType().'<br>';
    */

	//echo '<hr>Campos:<br>';
	//print_r($d->getFields());

	/*
	echo '<hr>Insert:<br>';
	$d->setObs($txt);
	$d->setimg_teste($img);
	if( ! $d->insert() )
	{
		echo $d->getError();
	}
	echo 'Last Insert:'. $d->getLastInsertId().'<br>';
	echo 'Last Id:'. $d->getLastId().'<br>';
	*/


}
$res = $d->query("select * from tb_test");
print_r($res);

/*
$d->setseq_uf(7);
if( $d->delete() )
{
	echo 'Excluido<br>';

}
*/
//echo $d->getError();
//echo '<br>Arquivo: '.__FILE__.'<br>Linha: '. __LINE__.'<br>';
die('ok');


// teste com MYSQL

$dao = new TDAO('tb_uf','mysql','root','','dbteste','192.168.1.140');
$dao->setPrimaryKey('cod_uf');
$dao->setFieldValue( 'cod_uf',2);  // ou
$dao->setCod_uf(2);
echo '<br>Cod_uf:'.$dao->getCod_uf().' foi excluído<br>';
echo '<br>';
$dao->delete();
echo $dao->getError();
die;


// teste postgres

$dao = new TDAO('tb_uf','postgres','postgres','123456','dbteste','192.168.1.140',null,'public');
$dao->setPrimaryKey('cod_uf');
//$dao->setFieldValue( 'cod_uf',22);  // ou
$dao->setCod_uf(22);
if( $dao->delete() )
{
	echo '<br>Cod_uf:'.$dao->getCod_uf().' foi excluído<br>';
	echo '<br>';
}
//$res = $dao->query("select * from tb_uf");
//print_r($res);
echo $dao->getError();
die;



// teste oracle XE
/*
$dao = new TDAO('tb_uf','oracle','root','123456','xe','192.168.1.140',null,null,null,null,true);
$dao->setPrimaryKey('cod_uf');
//$dao->setFieldValue( 'cod_uf',22);  // ou
$dao->setCod_uf(20);
if( $dao->delete() )
{
	echo '<br>Cod_uf:'.$dao->getCod_uf().' foi excluído<br>';
	echo '<br>';
}
$res = $dao->query("select cod_uf from tb_uf");
print_r($res);
echo $dao->getError();
die;
*/



//********************************************************************************************
// 								M Y S Q L
//********************************************************************************************
/*
$dao = new TDAO('tb_uf','mysql','root','','dbteste','192.168.1.140');
if( !$dao->connect())
{
	die($dao->getError());
}
//$daoMy->setAutoincFieldName('seq_uf');
//$daoMy->setPrimaryKey('cod_uf');
//$daoMy->setFieldValue('cod_uf'		,'22');
//$daoMy->setFieldValue('nom_uf'		,'Estado 22 alterado');
//$daoMy->setFieldValue('sig_uf'		,'PA');
//$daoMy->setFieldValue('dat_validade',date('d/m/Y') );
//$daoMy->setFieldValue('dat_inclusao',date('d/m/Y h:i:s') );
//$daoMy->setFieldValue('val_pib' 	, 188.00);
//$daoMy->setFieldValue('obs_uf' 		,$txt);
//$daoMy->setFieldValue('img_uf'		,$img);

//if( $daoMy->save() )
//{
//	echo 'sucesso<br>id:'.$daoMy->getLastId().'<br>';
//}
$dao->setPrimaryKey('cod_uf');
if( $dao->deleteValues(array('cod_uf'=>22) ) )
{
	$dao->commit();
}
die;
*/
//$dao->query("DELETE FROM TB_UF WHERE COD_UF = ?",22);
/*
//  teste 1 com blob
$dao->setPrimaryKey('cod_uf');
$dao->addField('val_pib','number',20);
$dao->addField('img_uf','blob');
$dao->query("DELETE FROM TB_UF WHERE COD_UF = ?",22);
$res = $dao->query( "INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB,OBS_UF,IMG_UF)
		VALUES (?,?,?,?,?,?)"
		,array(22,'NV','Estado Novo','val_pib'=>'120,78',$txt,'img_uf'=>$img));
if( !$res )
{
	die($dao->getError());
}
$dao->commit();
print_r('Id:'.$dao->getLastId());
echo '<hr>';
print_r($dao->query("SELECT * FROM TB_UF WHERE COD_UF = ?",22));
*/

// teste 2 sem blob e sem definição de campos
/*
$res = $dao->query( "INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB,OBS_UF)
		VALUES (?,?,?,?,?)"
		,array(22,'NV','Estado Novo','val_pib'=>'120.78','Observacao estado') );

if( !$res )
{
	die($dao->getError());
}
$dao->commit();
print_r('Id:'.$dao->getLastId());
echo '<hr>';
print_r($dao->query("SELECT * FROM TB_UF WHERE COD_UF = ?",22));
*/

/*
// Teste 3 - sql e valores sem parametros
$res = $dao->query( "INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB,OBS_UF)
		VALUES (22,'NV','Estado Novo',120.78,'Observação estado')");;

if( !$res )
{
	die($dao->getError());
}
$dao->commit();
print_r('Id:'.$dao->getLastId());
echo '<hr>';
print_r($dao->query("SELECT * FROM TB_UF WHERE COD_UF = ?",22));
die;
*/

//********************************************************************************************
// 								P O S T G R E S
//********************************************************************************************
// Teste 1 postgres
/*
$daoPg = new TDAO('tb_uf','postgres','postgres','123456','dbteste','192.168.1.140',null,'public');
if( !$daoPg->connect())
{
	die($daoPg->getError());
}
$daoPg->setPrimaryKey('cod_uf');
$daoPg->addField('val_pib','number',20);
$daoPg->addField('img_uf','blob');
$daoPg->query("DELETE FROM TB_UF WHERE COD_UF = ?",22);
$res = $daoPg->query( "INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB,OBS_UF,IMG_UF)
		VALUES (?,?,?,?,?,?) returning seq_uf"
		,array(22,'NV','Estado Novo','val_pib'=>'120,78',$txt,'img_uf'=>$img));
if( !$res )
{
	die($daoPg->getError());
}
$daoPg->commit();
print_r($res);
echo '<hr>';
print_r($daoPg->query("SELECT * FROM TB_UF WHERE COD_UF = ?",22));
die;
*/

// teste 2 postgres
/*
$daoPg = new TDAO('tb_uf','postgres','postgres','123456','dbteste','192.168.1.140',null,'public');
if( !$daoPg->connect())
{
	die($daoPg->getError());
}
$daoPg->query("DELETE FROM TB_UF WHERE COD_UF = ?",22);
//$res = $daoPg->query( "INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB,OBS_UF) VALUES (22,'GO','Novo','125.80','observacao do campo obs') returning seq_uf");
$res = $daoPg->query( "INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB,OBS_UF)
		VALUES (?,?,?,?,?) returning seq_uf"
		,array(22,'NV','Estado Novo','val_pib'=>'120.78','Observacao estado') );

if( !$res )
{
	die($daoPg->getError());
}
$daoPg->commit();
print_r($res);
echo '<hr>';
print_r($daoPg->query("SELECT * FROM TB_UF WHERE COD_UF = ?",22));
echo $daoPg->getSqlCmd();
print_r($daoPg->getSqlParams());
die('<br>fim');
die;
*/


//$daoOra = new TDAO('tb_uf','oracle','root','123456','xe','192.168.1.140',null,null,null,null,true);
//$res = $daoOra->query('select * from tb_uf where cod_uf = ?',55);
//$res = $daoOra->query('select * from tb_uf where cod_uf = ? and sig_uf = ?',array('cod_uf'=>'55','sig_uf'=>'GO'));
//$res = $daoOra->query("select * from tb_uf where  sig_uf = ? AND COD_UF=?",array('sig_uf'=>'GO',55));
//$res = $daoOra->query("select * from tb_uf where  sig_uf = ? AND VAL_PIB=?",array('sig_uf'=>'GO','val_pib' => '125,68'));
//$res = $daoOra->query('select * from tb_uf where cod_uf = 55');
//echo $daoOra->getError();
//print_r($res);
//header("Content-type: image/png");
//echo file_put_contents('teste.jpg',$res[0]['IMG_UF']);
//echo '<img src="teste.jpg"/>';
//if( $daoOra->deleteValues(array('COD_UF'=>22)))
//{
//	echo 'Registro 22 excluído com sucesso!';
//	$daoOra->commit();
//	$res = $daoOra->query('select * from tb_uf where cod_uf = ?',22);
//	print_r($res);
//}
//die;

/*
$host = '192.168.1.140:f:\fiirebird/DBTESTE.GDB';
$link = ibase_connect( $host, 'SYSDBA','masterkey');
print_r($link);
$sql = "SELECT * FROM TB_UF";
$sth = ibase_query( $link, $sql );
$row = ibase_fetch_object( $sth );
print_r($row);
die();
*/
// exemplo conexção
/*
// oracle
$conOracle = TConnection::connect('oracle','root','123456','xe','192.168.1.140','1521');

$c1 = TConnection::connect(); // utilizar o arquivo conn_default.php

$c1 = TConnection::connect('MYSQL','root','','dbteste','192.168.1.140');

$stmt = $c1->prepare( 'select * from tb_uf' );
if ( !$stmt )
{
    die('metodo prepare falhou!');
}

$result = $stmt->execute();
if ( !$result )
{
    die('metodo result falhou!');
}

$res = $stmt->fetchAll( PDO::FETCH_ASSOC );

echo '<pre>';
print_r($res);
echo '<hr><hr><hr>';
die( 'fim MYSQL');




///-----------------------------------------------------------------------------------
$c1 = TConnection::connect('POSTGRE');

//die('fim');
//$c1 = TConnection::connect('POSTGRE','postgres','123456','sisteste','192.168.1.140',null,'public');

$stmt = $c1->prepare( 'select * from perfil' );
if ( !$stmt )
{
    die('metodo prepare falhou!');
}

$result = $stmt->execute();
if ( !$result )
{
    die('metodo result falho!');
}

$res = $stmt->fetchAll( PDO::FETCH_ASSOC );

echo '<pre>';
print_r($res);
echo '<hr><hr><hr>';



$c2 = TConnection::connect('POSTGRE','sisteste','senha','teste','192.168.1.100',null,'public');

$stmt = $c2->prepare( 'select * from perfil' );
if ( !$stmt )
{
    die('metodo prepare falhou!');
}

$result = $stmt->execute();
if ( !$result )
{
    die('metodo result falhou!');
}

$res = $stmt->fetchAll( PDO::FETCH_ASSOC );

echo '<pre>';
print_r($res);
echo '<hr><hr><hr><hr>';


$stmt = $c1->prepare( 'select * from perfil' );
if ( !$stmt )
{
    die('metodo prepare falhou!');
}

$result = $stmt->execute();
if ( !$result )
{
    die('metodo result falho!');
}

$res = $stmt->fetchAll( PDO::FETCH_ASSOC );

echo '<pre>';
print_r($res);
echo '<hr><hr><hr>';

echo '<br>fim';
*/



/*
$daoOra = new TDAO('tb_uf','oracle','root','123456','xe','192.168.1.140',null,null,null,null,true,'includes/metadata/');
$daoOra->setAutoincFieldName('seq_uf');

if( !$daoOra->connect())
{
	die($daoOra->getError());
}
//$res = $daoOra->query("select * from tb_uf where cod_uf = 59",null,'FETCH_CLASS');
*/
/*
$s = oci_parse($daoOra->getConn()->connection,"INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB) VALUES (21,'GO','Novo','125') returning seq_uf into :id");
oci_bind_by_name($s, ":id", $id, 20, SQLT_INT);
oci_execute($s);
echo "Data inserted with id: $id<br>";
echo $daoOra->getError();
*/
/*
$stmt = oci_parse($daoOra->getConn()->connection,"insert into tb_uf (cod_uf,nom_uf,sig_uf,val_pib,dat_validade) values (:cod_uf,:nom_uf,:sig_uf,:val_pib,:dat_validade)  returning seq_uf into :out_id");
$params = array(20,'Novo','LE','158,56','12-03-2012');
oci_bind_by_name($stmt, ":cod_uf",$params[0]);
oci_bind_by_name($stmt, ":nom_uf",$params[1]);
oci_bind_by_name($stmt, ":sig_uf",$params[2]);
oci_bind_by_name($stmt, ":val_pib",$params[3]);
oci_bind_by_name($stmt, ":dat_validade",$params[4]);
oci_bind_by_name($stmt, ":out_id", $id, 20, SQLT_INT);
oci_execute($stmt);
echo "Data inserted with id: $id<br>";
echo $daoOra->getError();
*/
/*
if( ! file_exists('imagem/acessibilidade-brasil.gif'))
{
	die('imagem não existe');
}
$img = file_get_contents('imagem/acessibilidade-brasil.gif');
$txt = file_get_contents('config.php');
$daoOra->setAutoCommit(false);
*/
/*
if( ! $daoOra->insertValues(array('cod_uf'=>'20','nom_uf'=>'Estado Luis Eugenio','sig_uf'=>'LE','val_pib'=>'157,87','dat_validade'=>'12/03/2012','dat_inclusao'=>date('d/m/Y h:i:s'),'OBS_UF'=>$txt,'IMG_UF'=>$img ) ))
//if( ! $daoOra->insertValues(array('cod_uf'=>'20','nom_uf'=>'Estado Luis Eugenio','sig_uf'=>'LE','val_pib'=>'157,87','dat_validade'=>'12/03/2012','dat_inclusao'=>date('d/m/Y h:i:s'),'IMG_UF'=>$img ) ))
{
	die($daoOra->getError());
}
//$daoOra->commit();
echo '<br>Id:'.$daoOra->getLastId();
echo '<br>Id:'.$daoOra->getLastInsertId();
*/
/*
$params = array('cod_uf'=>'20','nom_uf'=>'Estado Luis Eugenio','sig_uf'=>'LE','val_pib'=>'157,87','dat_validade'=>'12/03/2012','dat_inclusao'=>date('d/m/Y h:i:s'),'obs_uf'=>$txt,'img_uf'=>$img );
if( ! $daoOra->query("insert into tb_uf ( cod_uf,nom_uf,sig_uf,val_pib,dat_validade,dat_inclusao,obs_uf,img_uf) values ( :cod_uf,:nom_uf,:sig_uf,:val_pib,:dat_validade,:dat_inclusao,empty_clob(),emtpy_lob()) returning obs_uf, img_uf into :obs_uf, :img_uf ", $params ) )
{
	die($daoOra->getError());
}
die;
*/
//echo $daoOra->getAutoincFieldName().'<br>';
//print_r($daoOra->getFields());
//die();
//echo $daoPg->getMetadataDir();
//die;
//$daoPg->setKeyFieldName('cod_uf');
//print_r($daoPg->getKeyFieldNames());
/*
if( ! $daoOra->insertValues(array('cod_uf'=>'20','nom_uf'=>'Estado Luis Eugenio','sig_uf'=>'LE','val_pib'=>'157,87','dat_validade'=>'12/03/2012') ))
{
		die($daoOra->getError());

}
echo 'Last Id '.$daoOra->getAutoincFieldName().'='.$daoOra->getLastId().'<br>';
echo 'Last Inserted Id:'.$daoOra->getLastInsertId().'<br><br>';
die;
*/



/*
$daoOra = new TDAO('tb_uf','oracle','root','123456','xe','192.168.1.140',null,null,null,null,true,'includes/metadata/');
$daoOra->setAutoincFieldName('seq_uf');
if( !$daoOra->connect())
{
	die($daoOra->getError());
}
$daoOra->setPrimaryKey('cod_uf');
$daoOra->setFieldValue('cod_uf'		,'22');
$daoOra->setFieldValue('nom_uf'		,'Estado 22');
$daoOra->setFieldValue('sig_uf'		,'PA');
$daoOra->setFieldValue('dat_validade',date('d/m/Y') );
$daoOra->setFieldValue('dat_inclusao',date('d/m/Y h:i:s') );
$daoOra->setFieldValue('val_pib' 	, 188.00);
$daoOra->setFieldValue('obs_uf' 	,$txt);
$daoOra->setFieldValue('img_uf'		,$img);
if( $daoOra->save() )
{
	echo 'sucesso<br>id:'.$daoOra->getLastId().'<br>';
}
echo $daoOra->getError();
die;
*/


/*
$daoMy = new TDAO('tb_uf','mysql','root','','dbteste','192.168.1.140','includes/metadata/');
$daoMy->setAutoincFieldName('seq_uf');
$daoMy->setPrimaryKey('cod_uf');
if( !$daoMy->connect())
{
	die($daoMy->getError());
}
$daoMy->setFieldValue('cod_uf'		,'22');
$daoMy->setFieldValue('nom_uf'		,'Estado 22 alterado');
$daoMy->setFieldValue('sig_uf'		,'PA');
$daoMy->setFieldValue('dat_validade',date('d/m/Y') );
$daoMy->setFieldValue('dat_inclusao',date('d/m/Y h:i:s') );
$daoMy->setFieldValue('val_pib' 	, 188.00);
$daoMy->setFieldValue('obs_uf' 		,$txt);
$daoMy->setFieldValue('img_uf'		,$img);
if( $daoMy->save() )
{
	echo 'sucesso<br>id:'.$daoMy->getLastId().'<br>';
}
echo $daoMy->getError();
die;
*/






/*
$daoPg = new TDAO('tb_uf','postgres','postgres','123456','dbteste','192.168.1.140',null,'public','includes/metadata/');
if( !$daoPg->connect())
{
	die($daoPg->getError());
}
//$daoPg->beginTransaction();
$daoPg->setPrimaryKey('cod_uf');
$daoPg->setFieldValue('cod_uf'		,'20');
$daoPg->setFieldValue('nom_uf'		,'Estado Alterado');
$daoPg->setFieldValue('sig_uf'		,null);
$daoPg->setFieldValue('dat_validade',date('d/m/Y') );
$daoPg->setFieldValue('dat_inclusao',date('d/m/Y h:i:s') );
$daoPg->setFieldValue('val_pib' 	, 157.89);
$daoPg->setFieldValue('obs_uf' 		, 'Observação da uf');
//if( $daoPg->save() )
if( $daoPg->save() )
{
	//$daoPg->commit();
	echo 'sucesso<br>';
}
echo $daoPg->getError();
*/

//print_r( $daoPg->getField('obs_uf') );
//die( $daoPg->getValidFieldType('text'));
//$img = file_get_contents('imagem/acessibilidade-brasil.gif');
//$daoPg->setFieldValue('img_uf' 		, $img);

//$daoPg->setPrimaryKey(array('cod_uf','nom_uf'));
//$daoPg->setPrimaryKey('cod_uf,nom_uf');
//print_r( $daoPg->getFields());
//print_r($daoPg->getPrimaryKeys());
//$daoPg->getConn()->isPDO = false;
//die('fim');

/*
$res = $daoPg->query("select * from tb_uf where cod_uf = 56",NULL,PDO::FETCH_CLASS);
echo $daoPg->getError();
print_r($res);
//die;
//echo $daoPg->getMetadataDir();
//die;
//$daoPg->setKeyFieldName('cod_uf');
//print_r($daoPg->getKeyFieldNames());
if( ! $daoPg->insertValues(array('cod_uf'=>'22','nom_uf'=>'Estado Luis Eugênio','sig_uf'=>'LE','val_pib'=>'157,78','dat_validade'=>'12/03/2012') ))
{
		die($daoPg->getError());

}
echo 'Last Id '.$daoPg->getAutoincFieldName().'='.$daoPg->getLastId().'<br>';
echo 'Last Inserted Id:'.$daoPg->getLastInsertId().'<br><br>';
die;
*/



/*
$daoMySql = new TDAO('tb_uf','mysql','root','','dbteste','192.168.1.140','includes/metadata/');
//$daoMySql->setKeyFieldName('cod_uf');
//print_r($daoMySql->getKeyFieldNames());
if( !$daoMySql->connect())
{
	die($daoMySql->getError());
}
//echo 'AutoInc:'.$daoMySql->getAutoincFieldName();
//echo '<pre>';
//print_r($daoMySql->getFields());
//die;
if( ! $daoMySql->insertValues(array('cod_uf'=>'26','nom_uf'=>'Estado Luis Eugênio','sig_uf'=>'LE','val_pib'=>'157,78','dat_validade'=>'12/03/2012') ))
{
		die($daoMySql->getError());

}
//$dao = new TDAO('tb_lixo','mysql','root','','dbteste','192.168.1.140','includes/metadata/');
//$dao->setAutoincFieldName('seq_lixo');
//$dao->insertValues(array('seq_lixo'=>'5','codigo'=>4,'nome'=>'Luis Eugênio'));
//echo 'Last Id:'.$dao->getLastId().'<br>';
//echo 'Last Inserted Id:'.$dao->getLastInsertId().'<br><br>';
echo 'Last Id tb_uf:'.$daoMySql->getLastId().'<br>';
echo 'Last Inserted Id tb_uf:'.$daoMySql->getLastInsertId().'<br>';
die;
*/

die('<br>ok');

//$dao      = new TDAO();
//$dao->setContentType('utf8');
//$dao->setContentType('ISO');
/*
if( ! $daoMySql->connect() )
{
	die( $daoMySql->getError() ) ;
}
*/
//die;


/*
Echo 'mysql<br>';
$daoMySql->connect();
$daoMySql->connect();
$daoMySql->connect();
*/
$dao->setMetadataDir('includes/metadata');
$dao->setTableName('tb_uf');

//echo 'Campos:<hr>';
//print_r($dao->getFields());
//die();

//$dao->addField('data','date');
//$dao->addField('salario','number');
//$dao->addField('nom_uf','varchar');
//$dao->addField('dat_inclusao','date');
//$dao->addField('val_pib','number');


//$dao->query("update tb_uf set nom_uf='".UTF8_ENCODE('JO?O')."' where cod_uf=55");

/*if( ! $dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB) VALUES (53,'GO','JOAO E JOSE',125.68)"))
{
	echo $dao->getError();
}
*/
/*
$dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB) VALUES (54,'GO','JOÃO E JOSÉ',125.68)");
$dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB) VALUES (55,'GO',? ,125.68)", ARRAY('JOÃO E JOSÉ') );
$dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB) VALUES (56,'GO',? ,125.68)", ARRAY(utf8_encode('JOÃO E JOSÉ')) );
$dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB) VALUES (57,'GO','".utf8_encode('JOÃO E JOSÉ')."',125.68)");
$dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB) VALUES (58,'GO',? ,125.68)", ARRAY('JOÃƒO E JOSÃ‰') );
$dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB) VALUES (59,'GO','".'JOÃƒO E JOSÃ‰'."',125.68)");
*/

//$dao->query("update tb_uf set dat_nascimento=?, dat_inclusao = ?",array('dat_nascimento'=>'31/12/2012','DAT_INCLUSAO'=>date('d/m/Y h:i:s') ) );

//$dao->query("update tb_uf set nom_uf='ROND?NIA' where cod_uf=11");
//$dao->query("update tb_uf set nom_uf=? where cod_uf=55", array('JO?O') );
//$dao->query("update tb_uf set nom_uf='JO?O' where cod_uf=56");
//$dao->query("update tb_uf set nom_uf=? where cod_uf=56",array($v));

//$dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF,VAL_PIB) VALUES (57,'GO','".utf8_encode('JO?O')."',125.68)");



//print_r( $dao->prepareParams(array('nom_uf'=>'luis eugenio') ) );
//print_r( $dao->prepareParams( array($v,52) ) );
//die;


//$dao->query("update tb_uf set nom_uf=? where cod_uf=?",array('??o',52));


//echo $dao->parseNumber('12.345,67');
//die();


/*
echo $dao->parseFloat().'<br>';
echo $dao->parseFloat(5).'<br>';
echo $dao->parseFloat(5000).'<br>';
echo $dao->parseFloat(50).'<br>';
echo $dao->parseFloat(50.200).'<br>';
echo $dao->parseFloat('50,30').'<br>';
echo $dao->parseFloat('1,578,750.30').'<br>';
echo $dao->parseFloat('2,754,735,50').'<br>';
//echo $dao->parseFloat('1.578.750,40').'<br>';
die;
*/

/*
echo $dao->parseDMY('01/10/2012 15:54:38').'<br>';
echo $dao->parseDMY().'<br>';
echo $dao->parseDMY('2011/12/31 12:30:14').'<br>';
die;
*/

/*
echo $dao->parseDMY('01/10/2012 15:54:38').'<br>';
echo $dao->parseDMY().'<br>';
echo $dao->parseDMY('2011/12/31 12:30:14').'<br>';
die;
*/

/*
if( !$dao->query('select * from teste'))
{
	echo $dao->getError();
	die();
}
*/



//$params = array('nom_pessoa'=>'MARIA' ,'nom_irmao'=>'JO?O','data'=>'01/10/2012','salario'=>'145.45');
//print_R($dao->prepareParams($params) );


//print_r($dao->getSpecialChars());
//die();

/*
echo $v.'<br>';
for($i=0;$i<strlen($v);$i++)
{
	echo substr($v,$i,1);
}
die();
*/

/*
echo 'Normal:'.$v;
$x = $dao->utf8Encode($v);
echo '<br>Encode:'.$x;
echo '<br>Decode:'.$dao->utf8Decode($x);
die();
*/


/*
if( $dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF) VALUES (52,'GO','".$v."')") )
//if( $dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF) VALUES (52,'GO','".utf8_encode('Goi?ni? ??')."')") )
{
	echo 'Insers?o ok';
}
else
{
	echo 'Erro na Inclus?o: '.$dao->getError();
	echo '<br>Dsn:'.$dao->getConnDsn();
	die('<br>fim');
}
*/

/*
if( $_REQUEST['update'] )
{
	if( !$dao->query("update tb_uf set val_pib = ? where cod_uf = 52",array('val_pib'=>'12,345.67' ) ) )
	//if( !$dao->query("update tb_uf set val_pib = 78254.45 where cod_uf = 52" ) )
	{
		die( $dao->getError());
	}
	echo 'Update ok<br>';
}
*/
//$res = $dao->query('select * from tb_uf',null,PDO::FETCH_CLASS);
//$res = $dao->query('select * from tb_uf where cod_uf = 56',NULL, PDO::FETCH_ASSOC);


$res = $dao->query('select * from tb_uf where cod_uf >0',NULL, PDO::FETCH_ASSOC);
print_r($res);
/*
echo '<hr>';
$res = $daoMySql->query('select * from tb_uf where cod_uf >0',NULL, PDO::FETCH_ASSOC);
print_r($res);
*/
echo $dao->getError();
DIE;
/*
if( ! $res )
{
	if( $dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF) VALUES (52,'GO','".$v."')") )
	//if( $dao->query("INSERT INTO TB_UF ( COD_UF, SIG_UF, NOM_UF) VALUES (52,'GO','".utf8_encode('Goi?ni? ??')."')") )
	{
		echo 'Insers?o ok';
		$res = $dao->query('SELECT * FROM TB_UF',null,PDO::FETCH_CLASS);
	}
	else
	{
		echo 'Erro na Inclus?o: '.$dao->getError();
		echo '<br>Dsn:'.$dao->getConnDsn();
		die('<br>fim');
	}
	//die('Nenhum resultado.<br>'.$dao->getError());
}
*/
echo '<pre>';
/*
if( is_array($res) )
{
	if( isset($res[0]) )
	{
		if( is_object($res[0]))
		{
			if( $dao->getFields() )
			{
				foreach($res as $k=>$obj)
				{
					foreach($dao->getFields() as $fieldName=>$objField)
					{

	                    $f = $objField->fieldName;
	                    $fieldValue=null;
						if( !isset( $obj->$f ) )
						{
							$f = strtolower($f);
							if( !isset( $obj->$f ) )
							{
								$f=null;
							}
						}
                        if( !is_null( $f ) )
                        {
							if ($objField->fieldType == 'date')
							{
								$fieldValue = $dao->parseDMY($obj->$f);
							}
							else if ($objField->fieldType == 'varchar')
							{
								if( $dao->getConnUtf8() )
								{
									if( $dao->getContentType() != 'utf-8' )
									{
										$fieldValue = $dao->utf8Decode($obj->$f);
									}
									else
									{
										$fieldValue = $obj->$f;
									}
								}
								else
								{
									if( $dao->getContentType() == 'utf-8' )
									{
										$fieldValue = $dao->utf8Encode( $obj->$f );
									}
									else
									{
										$fieldValue = $obj->$f;
									}
								}
							}
							if( ! is_null( $fieldValue ) )
							{
								$obj->$f=$fieldValue;
							}
						}
					}
				}
			}
		}
	}
}
*/
//$f = $dao->getField('dat_nascimento');
//echo 'Nome:'.$f->fieldName.', Tipo:'.$f->fieldType;
print_r($res);
//print_r($res[0]->cod_uf);
?>
<script>

</script>