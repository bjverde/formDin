
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

<html>
<script type="text/javascript" src="base/js/jquery/jquery.js"></script>
<script type="text/javascript" src="base/js/jquery/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
function fwSetHtmlEditor(textAreaName,saveHandler)
{
	if( !tinyMCE )
	{
		alert('Arquivos js do Editor tinMCS não carregado');
		return;
	}
	if( !textAreaName)
	{
		return;
	}
	tinyMCE.init({
		// General options
		//mode : "textareas",
		mode: "exact",
		language:'pt',
		elements : textAreaName,	
		theme : "advanced",
		//height:"350px",
	    //width:"600px",
		
		//plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",
		plugins : "safari,spellchecker,pagebreak,style,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,tabfocus",
		tab_focus : ':prev,:next',
		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/example.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "js/template_list.js",
		external_link_list_url : "js/link_list.js",
		external_image_list_url : "js/image_list.js",
		media_external_list_url : "js/media_list.js",
		add_form_submit_trigger : 0,
		submit_patch:0,
		save_onsavecallback : saveHandler,
	    save_enablewhendirty:true,
		//file_browser_callback : 'myFileBrowser',
		setup : function(ed) {
	        // Display an alert onclick
	        /*
	        ed.onClick.add(function(ed) {
	            ed.windowManager.alert('User clicked the editor.');
	        });
	        */
	        // Add a custom button
	        /*
	        ed.addButton('mybutton', {
	            title : 'My button',
	            image : 'img/example.gif',
	            onclick : function() {
	                ed.selection.setContent('<strong>Hello world!</strong>');
	            }
	            */
	        },
	    

		// Replace values for the template plugin
		template_replace_values : {
			username : "htmlEditor",
			staffid : "123456"
		}
	});
}

function tinySave(ed)
{
	ed.windowManager.alert('Dados gravados!');
	
	//var ed = tinyMCE.get('content');
	//ed.setProgressState(1); 
	//alert( 'salvar\t\t'+ed.getContent());
	//ed.setProgressState(0); 
	//ed.setContent('Texto inserido via javascript');
}
function teste()
{
	alert('inicializar o editor html na textArea');
	fwSetHtmlEditor('area_editor','tinySave');
}
</script>

<form method="post" action="somepage">
	<textarea name="area_editor" style="width:400px"></textarea>
	<br/><input type="button" onclick="teste();this.disabled=true;" value="Inicializar Editor">
</form>
</html>
