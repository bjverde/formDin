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

d($_REQUEST);

HelpOnLineDAO::createFileAndTable();

$whereGrid = ' 1=1 ';
$primaryKey = 'HELP_FORM';
$frm = new TForm('Ajuda em Tempo Real',600,850);

$frm->addTextField($primaryKey ,'Formulário:',50,true);
$frm->addTextField('HELP_TITLE','Título:'	 ,50,false);
$frm->addTextField('HELP_FIELD','Campo:'	 ,50,true);

$frm->setRichEdit(true);
//$frm->addMemoField('campo_memo_tinymce','Documento:',100000,false,80,5,null,null,false);
//$frm->addMemoField('HELP_TEXT' ,'HELP_TEXT',10000,false,100,15,true,true,false);
$frm->addMemoField('HELP_TEXT' ,'HELP_TEXT',10000,false,100,15,true,true,false);
//$frm->addJavascript('fwSetHtmlEditorPreview("HELP_TEXT")');
$frm->addJavascript('fwSetHtmlEditor("HELP_TEXT",false,false)');
//$frm->addJavascript('fwSetHtmlEditor("HELP_TEXT","callBackEditor",false)');
echo 'Valor do Campo: HELP_TEXT =<br>';
echo htmlspecialchars($frm->get('HELP_TEXT'));

$frm->addButton('Buscar', null, 'Buscar', null, null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);
$frm->addButton('Post', null, 'Post', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		if ( $frm->validate() ) {
			$vo = new HelpOnLineVO();
			$frm->setVo( $vo );
			d( $vo );
			$resultado = HelpOnLineDAO::insert( $vo );
			if($resultado==1) {
				$frm->setMessage('Registro gravado com sucesso!!!');
				$frm->clearFields();
			}else{
				$frm->setMessage($resultado);
			}
		}
		break;
		//--------------------------------------------------------------------------------
	case 'Buscar':
		$retorno = array(
		'HELP_FORM'=>$frm->get('HELP_FORM')
		,'HELP_FIELD'=>$frm->get('HELP_FIELD')
		,'HELP_TITLE'=>$frm->get('HELP_TITLE')
		,'HELP_TEXT'=>$frm->get('HELP_TEXT')
		);
		$whereGrid = $retorno;
		break;
		//--------------------------------------------------------------------------------
	case 'Limpar':
		$frm->clearFields();
		break;
		//--------------------------------------------------------------------------------
	case 'gd_excluir':
		$id = $frm->get( $primaryKey ) ;
		$resultado = HelpOnLineDAO::delete( $id );;
		if($resultado==1) {
			$frm->setMessage('Registro excluido com sucesso!!!');
			$frm->clearFields();
		}else{
			$frm->clearFields();
			$frm->setMessage($resultado);
		}
		break;
		//--------------------------------------------------------------------------------
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
		,$dados 	 // array de dados
		,null		 // altura do gride
		,null		 // largura do gride
		,$primaryKey // chave primaria
		,$mixUpdateFields
		);
$gride->addColumn($primaryKey,'id');
$gride->addColumn('HELP_TITLE','Título');
$gride->addColumn('HELP_FIELD','Campo');
$gride->addColumn('HELP_TEXT','Texto');
$frm->addHtmlField('gride',$gride);


$frm->show();
?>
<script>

function callBackEditor(ed) {
	alert( ed);
	ed.windowManager.alert('Dados gravados!');
	var ed = tinyMCE.get('help');
	ed.setProgressState(1);
	alert( 'salvar\t\t'+ed.getContent());
	ed.setProgressState(0);
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
function fwSetHtmlEditorPreview(textAreaName){
	tinyMCE.init({
		// General options
		mode		: "exact",
		elements 	: textAreaName,
		language	:'pt',   		
		theme 		: "advanced",
		//skin 		: "o2k7",
        //skin_variant : "silver",
		
		plugins 	: "safari,spellchecker,pagebreak,style,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,tabfocus",
		
		// Theme options
		/*theme_advanced_buttons1 : "preview",
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
       	theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom"
		*/
	 	content_css : pastaBase+"css/tinyMCE.css",

		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

	})
}
//-----------------------------------------------------------------------------------------------
</script>
