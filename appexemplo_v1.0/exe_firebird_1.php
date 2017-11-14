<?php
//error_reporting( E_ALL );
//$db = new PDO ("firebird:dbname=localhost:C:\\path\\to\\database\\MyDatabase.FDB", "username", "password");
/*
$conn = new PDO("firebird:dbname=C://xampp//htdocs//formdin//base//exemplos//BDAPOIO.GDB",'SYSDBA','masterkey');
$sql = 'SELECT * from tb_uf';
	foreach ($conn->query($sql) as $row) {
		print 'cod_uf:'.$row['COD_UF'] . "<br>";
		print 'nom_uf:'.$row['NOM_UF'] . "<br>";
		print 'sig_uf:'.$row['SIG_UF'] . "<br>";
	}
*/

print_r( TPDOConnection::executeSql("SELECT * FROM TB_UF") );

$frm = new TForm('Exemplo PDO Firebird');
$frm->addHtmlField('html','Olhe o codigo desse arquivo');
$frm->show();
?>
