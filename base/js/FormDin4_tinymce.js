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

//--------------------------------------------------------------------------------------
/*
	Função utilizada para transformar uma textarea em um editor de texto reach text.
	Utiliza a biblioteca tinyMce link: http://tinymce.moxiecode.com
	Recebe como parametro o id da textArea e o nome da Função que será chamada
	quando for clicado no botão save. Esta Função recebe uma inst?ncia do editor
	onde podemos recuperar o texto editado utilizando o comando getContent();
*/
function fwSetHtmlEditor(textAreaName,saveHandler,readonly,height,width)
{
	if( !textAreaName)
	{
		return;
	}
	//fwSetHtmlEditorPreview(textAreaName)
	//return;
	try
	{
		width  = width  || 800;
		height = height || 600;
		readonly = readonly || false;
		tinyMCE.init( {
			// General options
			//mode : "textareas",
			mode		: "exact",
			elements 	: textAreaName,
			theme 		: "advanced",
			language	: "pt",
			readonly 	: readonly,
			//height    : height,
			//width		: width,
			//auto_resize	: true,
			//mce_windowresize:true,
			//editor_selector : "mceSimple"// aplicar utilizando a propriedade class do elemento
			//theme_advanced_resize_horizontal : false,
			//theme_advanced_resize_vertical : false,
			theme_advanced_resizing : true,
			//plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager,tabfocus",
			plugins : "safari,spellchecker,pagebreak,style,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,tabfocus",
			tab_focus : ':prev,:next',
			// Theme options
			// removido image media fullscreen
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,advhr,|,print,|,ltr,rtl",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
			theme_advanced_toolbar_location : "top", // external
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			//plugin_preview_width : width,
			//plugin_preview_height : height,


			// Style formats
			/*
			style_formats : [
			{title : 'Negrito', inline : 'b'},
			{title : 'Vermelho', inline : 'span', styles : {color : '#ff0000'}}],
			*/
			// Example content CSS (should be your site CSS)
			//content_css : "css/example.css",
			content_css : pastaBase+"css/tinyMCE.css",
			// Drop lists for link/image/media/template dialogs
			/*
			template_external_list_url : "js/template_list.js",
			external_link_list_url : "js/link_list.js",
			external_image_list_url : "js/image_list.js",
			media_external_list_url : "js/media_list.js",
			*/
			add_form_submit_trigger : 0,
			submit_patch:0,
			save_onsavecallback : saveHandler,
			save_enablewhendirty:true,
			init_instance_callback : 'InitInstanceCallback',
			//file_browser_callback : 'myFileBrowser',
			setup : function(ed)
			{
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
	catch(e)
	{
		alert('arquivo .js do tinyMCE editor não carregado!');
	}
}
function InitInstanceCallback(inst)
{
	inst.onKeyDown.add(
		function(ed, e)
		{
			//if (e.keyCode == 9 && !e.altKey && !e.ctrlKey)
			if (e.keyCode == 9 )
			{
				ed.editorCommands.Indent();
				/*
			if (e.shiftKey)
				ed.editorCommands.Outdent();
			else
				ed.editorCommands.Indent();
				*/
				return tinymce.dom.Event.cancel(e);
			}
		});
}
//--------------------------------------------------------------------------------------
