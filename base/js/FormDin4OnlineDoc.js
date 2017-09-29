
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

var edOnlineDoc; // guardar a instância do editor
function fwShowOnlineDocumentation(contexto,campo,label)
{
	if( edOnlineDoc.visible )
	{
		if (jQuery('#fwOnlineDoc').css('display') != 'none')
		{
			alert('Feche a edição anterior');
		}
		return;
	}
	//var edOnlineDoc = tinyMCE.get('fwOnlineDocTextArea');
	edOnlineDoc.contexto	= contexto;
	edOnlineDoc.campo 	= campo;
	edOnlineDoc.label	= label;
	edOnlineDoc.visible	= true;
	jQuery('#fwOnlineDoc').fadeTo("slow",0.95);
	edOnlineDoc.setProgressState(1);
	if (edOnlineDoc.settings.readonly)
	{
		jQuery('#fwOnlineDocInputTitle').hide();
		try{
			jQuery('#fwOnlineDocTituloModuleName').html('<br\>'+jQuery('#'+campo).attr('label').replace(':',''));
		}
		catch (e)
		{
			jQuery('#fwOnlineDocTituloModuleName').html('<br\>'+jQuery('#'+campo+'_container').attr('label').replace(':',''));
		}
	}
	else
	{
		jQuery('#fwOnlineDocInputTitle').show();
		try
		{
			jQuery('#fwOnlineDocInputTitle').val( jQuery('#'+campo).attr('label').replace(':','') );
		}
		catch(e)
		{
			jQuery('#fwOnlineDocInputTitle').val( jQuery('#'+campo+'_container' ).attr('label').replace(':','') );
		}
		//jQuery('#fwOnlineDocTituloModuleName').html('Módulo:&nbsp;<b>'+jQuery("#modulo").val()+ '</b>&nbsp;-&nbsp;Campo:&nbsp;<b>'+campo+'</b><br\>');
		jQuery('#fwOnlineDocTituloModuleName').html('Módulo:&nbsp;<b>'+contexto+ '</b>&nbsp;-&nbsp;Campo:&nbsp;<b>'+campo+'</b><br\>');
	}
	fwSet_position( 'fwOnlineDoc','cc')
	jQuery.ajax(
	{
		type: "POST",
		url: '?',
		data: "modulo="+pastaBase+"includes/fwHelpOnlineSqlite.php&ajax=1&contexto="+contexto+"&campo="+campo+'&label='+label+'&acao=ler',
		cache: true,
		async: true,
		dataType: "text",
		error:function(o,msg)
		{
			edOnlineDoc.setProgressState(0);
			alert(msg);
			return;
		},
		success: function(result)
		{
			edOnlineDoc.setProgressState(0);
			result = jQuery.parseJSON(result);
			edOnlineDoc.setContent(result.help_text);

			try
			{
				//alert( result.help_title )
				if (edOnlineDoc.settings.readonly )
				{
					jQuery("#fw_div_online_doc_subtitle_input").hide();
					jQuery("#fw_div_online_doc_subtitulo").val(result.help_title)
				}
				else
				{
					jQuery("#fwOnlineDocInputTitle").val(result.help_title)
				}
			}
			catch(e){}
			edOnlineDoc.setProgressState(0);
			edOnlineDoc.focus();
			fwSet_position( 'fwOnlineDoc','cc')
		}
	});
}
//--------------------------------------------------------------------------------------
function fwHideOnlineDocumentation()
{
	if( edOnlineDoc.changed && !edOnlineDoc.settings.readonly && !confirm('Texto foi alterado. Fechar janela de edição ?') )
	{
		return;
	}
	jQuery('#fwOnlineDoc').fadeOut("slow");
	edOnlineDoc.setContent('');
	edOnlineDoc.visible=false;
}
//--------------------------------------------------------------------------------------
function fwSaveOnlineDoc(ed)
{
	if( edOnlineDoc.changed )
	{
		//alert( ed.getContent() );
		edOnlineDoc.setProgressState(1);
		jQuery.post( app_url+app_index_file
			,{"ajax":1,"modulo":pastaBase+'includes/fwHelpOnlineSqlite.php',"contexto":ed.contexto,"campo":ed.campo,"help_text":ed.getContent(),"help_title":jQuery("#fwOnlineDocInputTitle").val(),"acao":"salvar" }
			,function(result)
			{
				edOnlineDoc.setProgressState(0);
				edOnlineDoc.changed=false;
				if( result)
				{
					if( result )
					{
		   				alert( result);
					}
				}
			});
	}
}
//--------------------------------------------------------------------------------------
function fwInitOnlieDocEditor(readOnly)
{
	readOnly = readOnly || false;
	var w = jQuery("#fwOnlineDoc").width();
	var h = jQuery("#fwOnlineDoc").height();
	var hh = jQuery("#fwOnlineDocHeader").height()+5;
	h = h-hh;
	tinyMCE.init( {
		// General options
		mode		: "exact",
		elements 	: "fwOnlineDocTextArea",
		language 	: "pt",
		theme 		: "advanced",
		readonly 	: readOnly,
		height		: h,
		width		: w,
		auto_resize	: false,
		mce_windowresize:false,
		theme_advanced_resizing : false,
		plugins : "safari,spellchecker,pagebreak,style,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,tabfocus",
		tab_focus : ':prev,:next',
		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
		theme_advanced_toolbar_location : "top", // external
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		plugin_preview_width : 800,
		plugin_preview_height : 600,
		add_form_submit_trigger : 0,
		submit_patch:0,
		content_css : pastaBase+"css/tinyMCE.css",
		save_onsavecallback : fwSaveOnlineDoc,
		save_enablewhendirty:true,
		onchange_callback : "fwOnlineDocChange" ,
		init_instance_callback : 'InitInstanceCallback',
		//file_browser_callback : 'myFileBrowser',
		setup : function(ed)
		{
			edOnlineDoc = ed;
			edOnlineDoc.changed = false;
		},
		// Replace values for the template plugin
		template_replace_values : {
			username : "htmlEditor",
			staffid : "123456"
		}
	});
}
//-------------------------------------------------------------------------------------
function fwOnlineDocChange (inst)
{
	edOnlineDoc.changed = true;
}
