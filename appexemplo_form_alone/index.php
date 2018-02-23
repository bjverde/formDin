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

header("Content-Type: text/html; charset=ISO-8859-1",true);
require_once('../base/classes/webform/TApplication.class.php');
require_once('includes/info.php');

function testar($extensao=null,$html){
	if( !extension_loaded($extensao) )	{
		$html->add('<b>'.$extensao.'</b>: <span class="vermelho">Não instalada</span><br>');
		return true;
	}else {
		$html->add('<b>'.$extensao.'</b>: <span class="verde">Instalada.</span><br>');
		return false;
	}
}


    
	$frm = new TForm('Configurações do PHP');
	$frm->setFlat(true);
	$frm->setAutoSize(true);
	
	$html = $frm->addHtmlField('conf','');
	$html->setCss('font-size','14px');

	$html->add(info::phpVersionOK());
	$html->add('<b>Seu IP</b>: <span class="versao">'.$_SERVER['REMOTE_ADDR'].'</span><br>');

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
	$html->add(info::infoSQLServer()); testar('pdo_sqlsrv',$html);
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
