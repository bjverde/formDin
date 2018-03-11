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

HelpOnLineDAO::createFileAndTable();

$whereGrid = ' 1=1 ';
$primaryKey = 'HELP_FORM';
$frm = new TForm('Ajuda em Tempo Real',600,850);

$frm->addTextField($primaryKey ,'Formulário:',50,true);
$frm->addTextField('HELP_TITLE','Título:'	 ,50,false);
$frm->addTextField('HELP_FIELD','Campo:'	 ,50,true);
$frm->addMemoField('HELP_TEXT' ,''           ,10000,false,100,15,true,true,false);
$frm->setRichEdit(true);
$frm->addJavascript('fwSetHtmlEditor("HELP_TEXT","callBackEditor",false)');

$frm->addButton('Buscar', null, 'Buscar', null, null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);

//$frm->setAction('Atualizar');
//$frm->addButton('Criar BD','criarBD','btnCriarBD');

$acao = isset($acao) ? $acao : '' ;
switch( $acao ) {
	case 'salvar';
		ob_clean();
		//print "select count(*) as total from helpOnLine where form_name='".$_REQUEST['form_name']."' and form_field='".$_REQUEST['form_field']."'" ;
       	$res = $db->query("select count(*) as total from helpOnLine where help_form='".$_REQUEST['help_form']."' and help_field='".$_REQUEST['help_field']."'",SQLITE_ASSOC,$error );
    	$row = $res->fetch();
    	if( $row['total'] > 0) {
 			$query = "update helpOnLine set help_title = '".$_REQUEST['help_title']."', help_text='".$_REQUEST['help_text']."' where help_form='".$_REQUEST['help_form']."' and help_field='".$_REQUEST['help_field']."'";
	    } else{
   			$query = "insert into helpOnLine ( help_form,help_field,help_title,help_text) values('".$_REQUEST['help_form']."','".$_REQUEST['help_field']."','".$_REQUEST['help_title']."','".$_REQUEST['help_text']."')";
		}
		if( ! $db->queryExec( $query, $error)) {
			die( $error );
		}
   		die('Dados gravados com sucesso!');
	break;
	/*
	default:
		
		$result = HelpOnLineDAO::selectAll('help_form',null);		
		if( count( $result )  > 0){
			$frm->set('HELP_FORM',$result['HELP_FORM'][0]);
			$frm->set('HELP_TITLE',$result['HELP_TITLE'][0]);
			$frm->set('HELP_FIELD', $result['HELP_FIELD'][0] );
		    $frm->set('HELP_TEXT', $result['HELP_TEXT'][0] );
		}
		break;
	*/
}

$dados = HelpOnLineDAO::selectAll($primaryKey,$whereGrid);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',HELP_FIELD|HELP_FIELD,HELP_TITLE|HELP_TITLE,HELP_TEXT|HELP_TEXT';
$gride = new TGrid( 'gd'        // id do gride
		,'Gride'     // titulo do gride
		,$dados 	      // array de dados
		,null		  // altura do gride
		,null		  // largura do gride
		,$primaryKey   // chave primaria
		,$mixUpdateFields
		);
$gride->addColumn($primaryKey,'id',50,'center');
$gride->addColumn('HELP_FIELD','HELP_FIELD',50,'center');
$gride->addColumn('HELP_TITLE','HELP_TITLE',50,'center');
$gride->addColumn('HELP_TEXT','HELP_TEXT',50,'center');
$frm->addHtmlField('gride',$gride);


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
