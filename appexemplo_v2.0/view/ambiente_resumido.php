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
	$frm = new TForm('Configurações do PHP',null,600);
	$html = $frm->addHtmlField('conf','');
	$html->setCss('font-size','14px');

	$html->add('<b>Versão do PHP</b>: <span class="versao">'.phpversion().'</span><br>');
	$html->add('<b>Seu Ip</b>: <span class="versao">'.$_SERVER['REMOTE_ADDR'].'</span><br>');

	$html->add('<br><b>Extensões:</b><br>');

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
	testar('mssql',$html);

	$html->add('<br>');
	testar('pdo',$html);
	testar('PDO_Firebird',$html);
	testar('pdo_mssql',$html);
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
	//phpinfo();
	function testar($extensao=null,$html)
	{
		if( !extension_loaded($extensao) )
		{
			$html->add('<b>'.$extensao.'</b>: <span class="vermelho">Não instalada</span><br>');
			return true;
		}
		else
		{
			$html->add('<b>'.$extensao.'</b>: <span class="verde">Instalada.</span><br>');
			return false;
		}
  	}

?>
