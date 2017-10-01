<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
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
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 * 
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

$frm = new TForm('Exemplo PDO 1',450);
$frm->addHtmlField('mensagem','Dados da conexão:<br>Banco:MYSQL<BR>Host:127.0.0.1<br>Port:3306<br>Database:text<br>Usuário:root<br>Senha:');
$frm->addHtmlField('status');

if( $acao == 'Testar' )
{
	/*
	TPDOConnection::connect('config_conexao_sqlite.php',null,false);
	$bd1 = TPDOConnection::getInstance();
	if( ! TPDOConnection::getError() )
	{
		$frm->set('status','Conexão OK');
	}
	else
	{
		TPDOConnection::showError();
		die();
	}

	$res = TPDOConnection::executeSql('select * from tb_test');

	$frm->set('status','Resultado:<hr><pre>'.print_r($res,true).'</pre>');
	if( $_REQUEST['ajax'] )
	{
		print_r($frm->getField('status')->getChildren() );
	}
    */
	// mysql
	TPDOConnection::connect('config_conexao_mysql.php',null,false);
	if( ! TPDOConnection::getError() )
	{
		$frm->set('status','Conexão OK');
	}
	else
	{
		TPDOConnection::showError();
		die();
	}

	$res = TPDOConnection::executeSql('select * from tb_test');
	$frm->set('status','Resultado:<hr><pre>'.print_r($res,true).'</pre>');
	if( $_REQUEST['ajax'] )
	{
		print_r($frm->getField('status')->getChildren() );
	}
}

$frm->addButtonAjax('Testar Ajax',null,null,null,'Testar',null,'json',true,'status');
$frm->setAction('Testar');
$frm->show();
?>
