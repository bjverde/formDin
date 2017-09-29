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

error_reporting(E_ALL);
define('BDHO','./ho/bdho.s3db');

$frm = new TForm('Ajuda em Tempo Real',500,850);
$frm->addTextField('help_title'	,'Título:'		,50,false);
$frm->addTextField('help_form'	,'Formulário:'	,50,true);
$frm->addTextField('help_field'	,'Campo:'		,50,true);
$frm->addMemoField ('help_text','',10000,false,100,15,true,true,false);
$frm->setRichEdit(true);
$frm->addJavascript('fwSetHtmlEditor("help_text","callBackEditor",false)');

// conectar com banco de dados
if( !file_exists(BDHO))
{
	$aFileParts = pathinfo( BDHO );
	$baseName = $aFileParts[ 'basename' ];
	$fileName = $aFileParts[ 'filename' ];
	$dirName = $aFileParts[ 'dirname' ];
	if( $dirName && ! file_exists($dirName) )
	{
		if ( ! mkdir($dirName, 0775, true ) )
    	{
 			die('Não foi possivel criar o diretório '.$dirName);
		}
	}
}
//if ( $db = sqlite_open( BDHO, 0666, $sqliteerror))
if ( $db = new SQLiteDatabase(BDHO,0666) )
{
	// verificar se a tabela existe e cria-la se não existir
	$q = @$db->query('select count(*) from helponline where 1 = 1');
    if ($q === false)
    {
    	$query = 'CREATE TABLE [helpOnLine] (
					[help_form] VARCHAR(50)  NULL,
					[help_field] VARCHAR(50)  NOT NULL,
					[help_title] VARCHAR(50)  NULL,
					[help_text] TEXT  NULL,
					PRIMARY KEY ([help_form],[help_field])
					)';
    	if( ! $db->queryExec( $query, $error))
		{
			die( $error );
		}
	}
}
else
{
	 die( $sqliteerror );
}

$acao = isset($acao) ? $acao : '' ;
switch( $acao )
{
	case 'salvar';
		ob_clean();
		//print "select count(*) as total from helpOnLine where form_name='".$_REQUEST['form_name']."' and form_field='".$_REQUEST['form_field']."'" ;
       	$res = $db->query("select count(*) as total from helpOnLine where help_form='".$_REQUEST['help_form']."' and help_field='".$_REQUEST['help_field']."'",SQLITE_ASSOC,$error );
    	$row = $res->fetch();
    	if( $row['total'] > 0)
    	{
 			$query = "update helpOnLine set help_title = '".$_REQUEST['help_title']."', help_text='".$_REQUEST['help_text']."' where help_form='".$_REQUEST['help_form']."' and help_field='".$_REQUEST['help_field']."'";
	    }
    	else
    	{
   			$query = "insert into helpOnLine ( help_form,help_field,help_title,help_text) values('".$_REQUEST['help_form']."','".$_REQUEST['help_field']."','".$_REQUEST['help_title']."','".$_REQUEST['help_text']."')";
		}
		if( ! $db->queryExec( $query, $error))
		{
			die( $error );
		}

   		die('Dados gravados com sucesso!');
	break;
	default:
	$_REQUEST['help_form'] = isset($_REQUEST['help_form']) ? $_REQUEST['help_form'] : 'cad_teste' ;
	$_REQUEST['help_field'] = isset($_REQUEST['form_field']) ? $_REQUEST['form_field'] : 'nom_pessoa' ;

	   	$query = "select help_text,help_title from helpOnLine where help_form='".$_REQUEST['help_form']."' and help_field='".$_REQUEST['help_field']."'";
		if( ! $res=$db->query( $query, SQLITE_ASSOC, $error) )
		{
			die( $error );
		}
		if( $res->numRows() > 0)
		{
			$row = $res->fetch();
			$frm->set('help_text', $row['help_text'] );
			$frm->set('hepp_title',$row['help_title']);
		}
	break;
}
$frm->setAction('Atualizar');
$frm->addButton('Criar BD','criarBD','btnCriarBD');
$frm->show();
?>
<script>

function callBackEditor(ed)
{
	//alert( ed);
	//ed.windowManager.alert('Dados gravados!');
	//var ed = tinyMCE.get('help');
	//ed.setProgressState(1);
	//alert( 'salvar\t\t'+ed.getContent());
	//ed.setProgressState(0);
	jQuery('#formDinAcao').val('salvar');
    var dados = jQuery("#formdin").serialize();
    dados += '&ajax=1';
	// inicia a requisição ajax
    fwBlockScreen();
    jQuery.ajax({
          url: app_url+app_index_file,
          type: "POST",
          async: true,
          data: dados,
          dataType: 'text',
          containerId:null,
          success: function(res){alert(res);fwUnBlockScreen();  },
          error: function( res ){ alert('Erro!\n\n'+res );fwUnBlockScreen(); }
    });
}
//-----------------------------------------------------------------------------------------------
</script>
