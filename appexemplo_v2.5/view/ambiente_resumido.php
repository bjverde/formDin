<style type="">
.vermelho
{
	color:#ff0000;
	font-weight:bold;
}
.verde
{
	color:#008000;
	font-weight:bold;
}
.versao
{
	color:#0000FF;
	font-weight:bold;
	font-size:16px;
}

</style>
<?php

function testar($extensao=null,$html){
	if( !extension_loaded($extensao) )	{
		$html->add('<b>'.$extensao.'</b>: <span class="vermelho">Não instalada</span><br>');
		return true;
	}else {
		$html->add('<b>'.$extensao.'</b>: <span class="verde">Instalada.</span><br>');
		return false;
	}
}

function infoSQLServer(){
	if(PHP_OS == "Linux"){
		$msg = "Para utilizar Linux com Microsoft SQL Server será utilizado o PDO com o drive dblib";
	}else{
		switch(PHP_INT_SIZE) {
			case 4:
				$msg = 'Para utilizar Windows com Microsoft SQL Server utilize o PDO com o drive sqlsrv';
				break;
			case 8:
				$msg = '<span class="vermelho">ATENÇÃO o Drive da Microsoft não funciona em Windows 64 bits</span>, instale o drive não oficial';
				break;
			default:
				$msg  = 'PHP_INT_SIZE is ' . PHP_INT_SIZE;
		}
	}
	return $msg;
}

function phpVersionOK(){
	$texto = '<b>VersÃ£o do PHP</b>: ';
	if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
		$texto =  $texto.'<span class="verde">'.phpversion().'</span><br>';
	}else{
		$texto =  $texto.'<span class="vermelho">'.phpversion().' atualize seu sistema para o PHP 5.4.0 ou seperior </span><br>';
	}
	return $texto;
}
	
	$frm = new TForm('ConfiguraÃ§Ãµes do PHP',null,800,600);
	$html = $frm->addHtmlField('conf','');
	$html->setCss('font-size','14px');

	$html->add(phpVersionOK());
	$html->add('<b>Seu Ip</b>: <span class="versao">'.$_SERVER['REMOTE_ADDR'].'</span><br>');

	$html->add('<br><b>Extensções:</b><br>');

	testar('gd',$html);
	testar('pdf',$html);

	$html->add('<br>');
	testar('pgsql',$html);
	testar('SQLite',$html);
	testar('sqlite3',$html);
	testar('odbc',$html);
	testar('mysql',$html);
	testar('interbase',$html);
	testar('oci8',$html);
	testar('sqlsrv',$html);

	$html->add('<br>');
	testar('pdo',$html);
	testar('PDO_Firebird',$html);
	$html->add(infoSQLServer()); testar('pdo_sqlsrv',$html);
	testar('pdo_mysql',$html);
	testar('PDO_OCI',$html);
	testar('PDO_ODBC',$html);
	testar('pdo_pgsql',$html);
	testar('pdo_sqlite',$html);

	$html->add('<br>');
	testar('soap',$html);
	testar('xml',$html);
	testar('SimpleXML',$html);
	testar('xsl',$html);
	testar('zip',$html);
	testar('zlib',$html);
	testar('ldap',$html);
	testar('json',$html);
	testar('curl',$html);

	$frm->show();
?>
