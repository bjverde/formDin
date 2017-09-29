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

try
{
	var app_formdin;
	var isNS4 = (navigator.appName=="Netscape")?1:0;
	var isIE  = (navigator.appName=="Netscape")?0:1;
	var pathArray 		= window.location.pathname.split( '/' );
	var app_url 		= window.location.pathname.substring(0,window.location.pathname.lastIndexOf('/'));
	var pastaBase;
	var app_index_file 	= window.location.pathname.substring(window.location.pathname.lastIndexOf('/')+1);
	app_index_file 		= app_index_file || "index.php";
	app_url = window.location.protocol+'//'+window.location.host+app_url+'/';
	var app_url_root 	= app_url;
	if( app_url_root.indexOf('/base/') > -1 )
	{
		app_url_root = app_url.substring(0,app_url_root.indexOf('/base/'))+'/';
	}
	var GB_ROOT_DIR 	= app_url_root+'base/js/greybox/';
	var GB_CURRENT		= false;
	var showMenu		= true;
	var showFooterModule = true;
	var tinyMCE;
	//var img_carregando = '<img width="190px" height="20px" src="'+app_url_root+'base/imagens/processando.gif"/>';
	var img_carregando = '<img width="190px" height="20px" src="base/imagens/processando.gif"/>';
	// não permitir que a conexão expire
	// var app_refresh_seconds = 10;
	//var timeout_refresh = window.setTimeout("app_start_refresh(0.5)", 500);
	var ajax_count = 0;
	var app_loaded_css_js="";
	var app_main_menu=null;
	var menuTheme;
	var menuIconsPath;
	var marca_dagua;
	var background_image;
	var background_repeat;
	var aplicativo;
	var win;
	var modalWindowList = [];
	var app_prototype = false;
	var app_center;
	var menuShowLinkStatusBar=false;
	var uiBlocked=false;
	//habilita/desabilita mostrar a url do item de menu quando posicionar o mouse sobre o item
	if( app_url.indexOf('/~') > 0 ||app_url.indexOf('localhost') > 0 || app_url.indexOf('/projetos/') > 0 )
	{
		menuShowLinkStatusBar = true;
	}
	var lapp=null;
	var app_layout=false;

    // verificar se o formulário está sendo chamado pela TApplication.class.php
	try
	{
		if( typeof top.app_init == 'function')
		{
			app_formdin = true;
		}
		else
		{
			app_formdin = false;
		}
	}
	catch(e)
	{
		app_formdin = false;
	}

}
catch (e)
{
	alert('Não foi possível inicializar a aplicação neste browser');
}

if( pathArray[pathArray.length-1].indexOf('.php') > 0 )
{
	app_index_file = pathArray[pathArray.length-1];
}
//---------------------------------------------------------------------------------------------
function app_init()
{
	try
	{
		// ajustar o tamanho do iframe/object central para ocupar toda a area meio da aplicação.
		app_adjust_middle_area_size();
	}
	catch(e)
	{
		alert( e.message );
	}
	if( marca_dagua)
	{
		app_set_water_mark(marca_dagua);
	}
	if( background_image )
	{
		app_set_background( background_image, background_repeat, background_position );
	}
/*
	// criar uma janela ficticia para inicializar o overlay modal window porque só bloqueia a tela inteira quando for executado pela segunda vez
	win = new Window({onShow:function(){Windows.closeAll()},className: "alphacube", title: "Sample", width:200, height:150, destroyOnClose: true, recenterAuto:false});
	win.getContent().update("");
	win.setLocation(-5000,0);
	win.show(true);
	*/
}
//---------------------------------------------------------------------------------------------
function app_set_background(img,repeat,position)
{

	repeat = repeat || 'repeat';
	position = position || '';
	//jQuery("#app_main_table").css('background-color','transparent');
	jQuery("#table_header").css('background-color','transparent');
	jQuery("#div_main_menu").css('background-color','transparent');
	//jQuery("#app_center").css('background-color','transparent');
	jQuery("#table_footer").css('background-color','transparent');

	jQuery("body").css('background-repeat',repeat);
	//jQuery("body").css('background-attachment','fixed');
	jQuery("body").css('background-position',position);
	jQuery("body").css('background-image','url('+img+')');
}
//---------------------------------------------------------------------------------------------
function app_set_water_mark(img)
{
	if( app_layout )
	{
		jQuery(".ui-app-center").css('background-repeat','no-repeat');
		//jQuery("#app_center").css('background-attachment','fixed');
		jQuery(".ui-app-center").css('background-position','center center');
		jQuery(".ui-app-center").css('background-image','url('+img+')');
	}
	else
	{
		jQuery("#app_center").css('background-repeat','no-repeat');
		//jQuery("#app_center").css('background-attachment','fixed');
		jQuery("#app_center").css('background-position','center center');
		jQuery("#app_center").css('background-image','url('+img+')');
	}

}
//---------------------------------------------------------------------------------------------
function app_adjust_middle_area_size()
{
	if ( app_layout )
	{
		return;
	}
 	if( !app_prototype)
	{
		window.onresize = null;
		try
		{
			//var app_centerH	= jQuery('#app_center').height();
			var bodyH = jQuery("body").height();
		    var o = jQuery('body').get(0);
			//var menuH = jQuery("#div_main_menu").height();
			jQuery("#app_center").height(bodyH);
			o.scrollTop = o.scrollTop + 1000;
			var scroll = o.scrollTop;
			var app_centerH	= jQuery('#app_center').height();
			jQuery("#app_center").height( app_centerH - scroll );
			var app_centerInnerH = jQuery('#app_center').innerHeight();
			jQuery("#app_iframe").height(app_centerInnerH-5);
			/*
			var i=0;
			o.scrollTop++;
			while( o.scrollTop++ > 0 )
			{
		    	app_centerH = app_centerH-1;
				jQuery("#app_iframe").height(app_centerH);
				i++;
				if( i > 31) // evitar loop infinito
				{
					break;
				}
			}
			*/
		}
		catch(e)
		{
			alert( e.message );
		}
		window.onresize = app_resized;
	}
}
//---------------------------------------------------------------------------------------------
function app_load_module(module,step,jsonParams)
{
	jsonParams = jsonParams||{};
	if( typeof jsonParams == 'string')
	{
		eval('var jsonParams='+jsonParams);
	}
	// compatibilidade com applayout novo
	if( typeof module == 'object')
	{
		jsonParams=module;
		module=module.module;
		jsonParams.module=null;
	}
    var url;
    var iframe =jQuery("#app_iframe");
	if( !app_prototype && iframe )
	{
		module = (module.toLowerCase()) == 'about:blank' ? '' : module;
		if( step )
		{
			if( module && module.indexOf('base/') > -1 )
			{
				module = pastaBase+module.substring(module.indexOf('base/')+5);
			}
			if( jsonParams)
			{
				var params='?modulo='+module;
				for ( key in jsonParams )
				{
					params+='&'+key+'='+jsonParams[key];
				}
			}
			//jQuery("#app_iframe").attr("src",app_index_file+params);
			iframe.attr("src",app_index_file+params);
	        app_setFooterModule(module);
	        app_setFooterMessage('');
	        app_adjust_middle_area_size();
		}
		else
		{
			var app_url_root = app_url;
			if( app_url_root.indexOf('/base/') > -1 )
			{
				app_url_root = app_url.substring(0,app_url_root.indexOf('/base/'))+'/';
			}
			// exibir animação de carregando ou limpar a tela
       		app_setFooterMessage('');
			app_setFooterModule('');
			if( module != '' )
			{
				if( !app_layout )
				{
					//jQuery("#app_iframe").height(100);
					//jQuery("#app_iframe").attr("src",pastaBase+"includes/carregando.html").height(100);
					iframe.height(100);
					iframe.attr("src",pastaBase+"includes/carregando.html").height(100);
				}
				else
				{
					//jQuery("#app_iframe").attr("src",pastaBase+"includes/carregando.html");
					iframe.attr("src",pastaBase+"includes/carregando.html");
				}
				window.setTimeout('app_load_module("'+module+'",1,\''+json2str(jsonParams)+'\');',400);
			}
			else
			{
				if( !app_layout )
				{
					/*
					jQuery("#app_iframe").height(0);
					jQuery("#app_iframe").attr("src",app_url_root+pastaBase+"includes/pagina_branco.html"); // limpar o conteudo
					*/
					iframe.height(0);
					iframe.attr("src",app_url_root+pastaBase+"includes/pagina_branco.html"); // limpar o conteudo
				}
				else
				{
					// não utilizar o about:blank senão IE não mostra a marca dagua
					//jQuery("#app_iframe").attr("src",pastaBase+"includes/pagina_branco.html"); // limpar o conteudo
					iframe.attr("src",pastaBase+"includes/pagina_branco.html"); // limpar o conteudo
    			}
			}
		}
	}
	else
	{
		jsonParams.module = module;
		app_window( jsonParams );
  	}
}
//-------------------------------------------------------------------------------------------
function app_setFooterModule(module,action)
{
	action = action ? '/'+action : '';
	module = module ? module : '';
	if( showFooterModule )
	{
		jQuery("#app_footer_module").html(module+action);
	}
	if( !module||module=='' )
	{
		app_server_action('unsetModuloSessao');
	}
	else
	{
		app_server_action('setModuloSessao',false,'text','modulo='+module);
	}
}
//-------------------------------------------------------------------------------------------
function app_setFooterMessage(msg)
{
	jQuery("#app_footer_message").html(msg+' ['+app_getDate()+' ]');
}
//--------------------------------------------------------------------------------------------
function app_terminate(ask)
{
	//app_stop_refresh();
	if( ask )
	{
		if( !confirm('Deseja encerrar ?'))
		{
			//app_start_refresh();
		    return false;
		}
	}
	// encerrar a sessão e sair
	app_load_module('terminate',1);
}
//------------------------------------------------------------------------------------------------
function app_login(ask,module,loginInfo)
{
	//app_stop_refresh();
	if( ask )
	{
		if( !confirm('Deseja encerrar a aplicação ?'))
		{
			//app_start_refresh();
		    return false;
		}
	}
	loginInfo = loginInfo || 'Bem-vindo';
	if( !app_layout )
	{
		jQuery("#app_main_menu").css('display','none');
		jQuery("#app_iframe").height(jQuery("#div_main_menu").height() + jQuery("#app_iframe").height() );
	}
	else
	{
		jQuery("#div_main_menu").hide();
	}

	jQuery("#button_end_session").css('display','none');
	jQuery("#app_header_login").html(loginInfo);
	app_server_action('logout',true,'script');
	if( app_prototype || modalWindowList.length > 0)
	{
		Windows.closeAll();
	}
	if( module )
	{
		app_load_module(module,null,{"modal":true,"closable":false,"minimizable":false,"maximizable":false});
	}
	else
	{
		app_restart();
	}
}
//----------------------------------------------------------------------------------------------------
function app_restart(mensagem,clearModule)
{
	//location.href='index.php';
	//alert('reiniciar');
	//alert(app_url+app_index_file);
	// utilizar setTimeout para evitar erro xmlRequest no chrome

	if( mensagem )
	{
		jAlert(mensagem,null,function(){
			app_restart(null,clearModule);
		});

	}
	else
	{
		if( clearModule === true )
		{
			app_load_module('about:blank');
		}
		window.setTimeout("top.location = '"+app_url+app_index_file+"';", 1000);
	}
	//top.location = app_url+app_index_file;
}

function app_modalBox(title,url,height,width,callBack,fullscreen)
{
	callBack = callBack || '';
	if( typeof GB_showCenter == 'undefined')
	{
		//LazyLoad.css(app_url_root+'base/css/greybox/gb_styles.css',
		LazyLoad.css(pastaBase+'css/greybox/gb_styles.css',
		function()
		{
			//LazyLoad.js([app_url_root+'/base/js/greybox/AJS.js',app_url_root+'base/js/greybox/AJS_fx.js',app_url_root+'base/js/greybox/gb_scripts.js'],
			LazyLoad.js(pastaBase+'js/greybox/AJS.js',
			function()
			{
				LazyLoad.js(pastaBase+'js/greybox/AJS_fx.js',
				function()
				{

					LazyLoad.js(pastaBase+'js/greybox/gb_scripts.js',
					function()
					{

						if(typeof GB_showFullScreen != 'undefined' )
						{
							app_modalBox(title,url,height,width,callBack,fullscreen)
						}
						else
						{
							alert('Não foi possivel carregar a biblioteca graybox!');
						};
					});
				});
			});
		});
	}
	else
	{

		if( GB_CURRENT )
		{
			return;
		}

		GB_CURRENT=true;
		if( isIE)
		{
			height += 5;
		}
		if( url.substring(0,3) !='../' && url.substring(0,4)!='http' && url.substring(0,3)!='www' )
		{
			url = app_url+url;
			url += ( ( url.indexOf('?')==-1) ? '?' :'&' ) +'modalbox=1&subform=1';

		}
		if( title.indexOf('|')>-1)
		{
			title = title.substr(0,title.indexOf('|'));
		}
		if( url.substring(0,3) =='../')
		{
			url = app_url + url;
		}
		url += '&app_formdin=1';
		if( fullscreen )
		{
			GB_showFullScreen(title, url, callBack );
		}
		else
		{
			GB_showCenter(title,url,height,width,callBack);
			// para fechar via js chamar: GB_hide()
		}
	};
};


//-----------------------------------------------------------------------------------------------------
function app_start_refresh(seconds)
{
	/*seconds = seconds || app_refresh_seconds;
	if ( timeout_refresh )
	{
		app_stop_refresh();
		app_server_action('refresh',false,'script');
	}
	else
	{
		timeout_refresh = window.setTimeout("app_start_refresh()", seconds * 1000);
	}
	*/
}
//-------------------------------------------------------------------------------------------
function app_server_action(action,wait,format,params,callback)
{
	//app_stop_refresh();
	params = params || '';
	format = format || 'text';
	ajax_count++;
	app_setFooterMessage(ajax_count);
	if( format == 'text') // se retornar texto
	{
		wait = wait || false;
		jQuery.ajax( {
			type: "POST",
			//url: app_url+"includes/app_server_action.php",
			url: app_url+app_index_file,
			//data: "action="+action+'&'+params,
			data: "app_action="+action+'&'+params,
			async:!wait,
			success: function(msg)
				{
					msg = jQuery.trim(msg);
					if( msg )
					{
						alert( msg );
					}
					ajax_count--;
					app_setFooterMessage(ajax_count);
				},
			error: function(msg)
				{
					ajax_count--;
					app_setFooterMessage(ajax_count);
					alert( 'erro:' + msg );
					//alert( 'erro:' + msg + "\n\n Verifique se o arquivo includes/app_server_action.php existe!");
				}
			});
	}
	else if (format=='script') // se retornar codigo javascript
	{
	 	//jQuery.getScript(app_url+"includes/app_server_action.php?action=" + action+'&'+params,
	 	jQuery.getScript(app_url+app_index_file+'?app_action='+action+'&'+params,
	 	function()
	 	{
			ajax_count--;
			app_setFooterMessage(ajax_count);
			////app_start_refresh();
			if( callback )
			{
				if( typeof callback == 'string')
				{
					eval( callback+';');
				}
				else if( typeof callback == 'function')
				{
					callback.apply(this);
				}
			}
	 	}
	 );
	}
	else
	{
		ajax_count--;
		app_setFooterMessage(ajax_count);
	}

}
//----------------------------------------------------------------------------------------------------------
function app_show_message(msg,type,seconds,image)
{
	type 	= type || 'error';
	type 	= type.toLowerCase();
	seconds	= seconds || 5;
	var obj = jQuery('#app_div_message').get(0);
	if( !obj )
	{
	    jQuery('.ui-app-center').prepend('<div id="app_div_message" style="position:absolute;top:30px;text-align:center;display:none;width:600px;"><table border="0" width="100%" cellpadding="0" cellspacing="0"><tr><td valign="middle" width="10px" align="left" style="padding-left:5px"><img id="app_div_message_image" src="../imagens/ajuda.gif" border="0"></td><td valign="middle" style="text-align: center;"id="app_div_message_text"></td></tr></table></div>');
		//app_alert( msg,null,type );
		//return;
	}

	if (!msg)
	{
		jQuery('#app_div_message').hide('slow');
		return;
	}

	if( type == 'sucess' && !image)
	{
		image = pastaBase+'imagens/ok16.gif';
	}

	// seleciona a imagem padrao
	image  = image || pastaBase+'imagens/icon_alert.png';
	jQuery("#app_div_message").removeClass();
	jQuery("#app_div_message").addClass("app_div_"+type);
	if( image )
	{
		jQuery("#app_div_message_image") .attr('src',image);
		jQuery("#app_div_message_image") .show();
	}
	else
	{
		jQuery("#app_div_message_image") .hide();
	}
	jQuery("#app_div_message_text").html(msg);
	// centralizar e posicionar no topo/centro
	if( jQuery("#app_div_message") )
	{
		jQuery('#app_div_message').css('top',30).css('width',jQuery('.ui-app-north').width()-7 ).css('z-index','999');;
		// esconder a mensagem depois do tempo passado
		if( seconds > 0)
		{
			window.setTimeout("app_show_message()", seconds * 1000 );
		}
		jQuery('#app_div_message').show('slow');
	}
	else
	{
		app_alert( msg );
	}
}
//--------------------------------------------------------------------------------------
function app_build_menu(force, message,module)
{
	if ( ! showMenu )
	{
		return;
	}
	var obj = jQuery("#div_main_menu");
	if( !obj.get(0) )
	{
		alert('Div com id div_main_menu não encontrada para montagem do menu');
		return;
	}
	//app_stop_refresh();
	try
	{
		menuTheme = menuTheme||'clear_silver';
		app_main_menu = new dhtmlXMenuObject("div_main_menu",menuTheme);
	}
	catch(e)
	{
		alert( "Erro no menu. Não foi possível instanciar a classe dhtmlXMenuObject.\t"+e.message);
		return;
	};
	menuIconsPath = menuIconsPath || pastaBase+"imagens/";
	app_main_menu.setOverflowHeight(25);
	app_main_menu.setOpenMode("web");
	app_main_menu.setWebModeTimeout(400);
	app_main_menu.hide();  // fecha todos os menus
	app_main_menu.setImagePath(pastaBase+"/js/dhtmlx/menu/skins/");
	app_main_menu.setIconsPath(menuIconsPath);

	/*
	// evento disponiveis para o menu
	menu.attachEvent("onXLS", menuXLS); // on xml load start
	menu.attachEvent("onXLE", menuXLE); // on xml load end
	menu.attachEvent("onClick", menuClick);
	app_main_menu.attachEvent("onTouch", app_menu_mouse_over);
	menu.attachEvent("onShow", menuShow);
	menu.attachEvent("onHide", menuHide);
	*/
	/*
	app_main_menu.attachEvent("onTouch", function(id, zoneId, casState)
	{
		jQuery('#app_footer_company').html(url);
	}

	);

	*/
  	app_main_menu.attachEvent("onClick", function(id, zoneId, casState)
	{
  			var url = app_main_menu.getUserData(id, 'url');
  			var jsonParams = app_main_menu.getUserData(id, 'jsonParams');
  			if( url )
  			{
				//jQuery('#app_header_title').html(url);

				/*if (casState && casState["ctrl"] == true)
 				{
 						window.status=url;
 						jQuery('#app_footer_company').html(url);
 						// o arquivo js dhtmlxmenu_cas.js está adaptado para mostrar a url no rodapé do form se a variavel menuShowLinkStatusBar for true
 						menuShowLinkStatusBar=!menuShowLinkStatusBar;
 						return null;
 				}
 				*/
  				if( url.indexOf('(')>-1)
  				{
					try {eval( url);}
					catch(e){
						alert( "Erro na execução do script:\n"+url);
					}
  				}
  				else
  				{
					app_load_module(url,0,jsonParams);
  				}
			}
		});
	if( !app_layout )
	{
		jQuery("#app_main_menu").css('display','');
		jQuery("#app_iframe").height(10);
		app_resized();
	}
	//app_main_menu.loadXML('base/seguranca/ler_menu_xml.php?e='+new Date().getTime());
	//app_main_menu.loadXML( app_url + app_index_file+'?modulo=base/seguranca/ler_menu_xml.php&content-type=xml&e='+new Date().getTime());
	if( !module )
	{
		alert( 'Para criação do menu é necessário informar o módulo que retornará o xml com a estrutura do menu!');
	}
	else
	{
		//alert( app_url + app_index_file+'?modulo='+module+'&content-type=xml&e='+new Date().getTime());
		//jQuery("#app_main_menu").html('Lendo...');
		app_main_menu.loadXML( app_url + app_index_file+'?menu=1&ajax=1&modulo='+module+'&content-type=xml&e='+new Date().getTime(),function()
		{
			//app_adjust_middle_area_size();
		});
		if( message)
		{
			alert(message);
		}
	}
}
//------------------------------------------------------------------------------------------
function app_stop_refresh()
{
	/*if( timeout_refresh )
	{
		clearTimeout(timeout_refresh) ;
	}
	timeout_refresh=0;
	*/
}
//------------------------------------------------------------------------------------
function app_set_position(element,position)
{
	try
	{
		// position pode ser: tl, tc, tr, cl, cc, cr, bl, bc, br e o padrão é tc
		position = position || 'tc';
		var topReference;
		if( jQuery("#div_main_menu").offset().top)
		{
			topReference 	= parseInt(jQuery("#div_main_menu").offset().top) + parseInt(jQuery("#div_main_menu").height());
		}
		else
		{
			topReference=0;
		}
		var appWidth 		= parseInt(jQuery('body').width());
		if( jQuery('#app_footer_message').offset().top )
		{
			var appHeight  		= parseInt(jQuery('#app_footer_message').offset().top) - 6 - topReference;
		}
		else
		{
			var appHeight 		= parseInt(jQuery('body').height());
		}
		var eleWidth		= parseInt(jQuery('#'+element).width());
		var eleHeight		= parseInt(jQuery('#'+element).height());
		var top	=0;
		var left=0;
		switch(position.toLowerCase())
		{
			case 'tl':
			break;
			//------------------------------------------------
			case 'tc':
			    left	= (appWidth - eleWidth) / 2;
			break;
			//------------------------------------------------
			case 'tr':
			    left	= (appWidth - eleWidth);
			break;
			//------------------------------------------------
			//------------------------------------------------
			case 'cl':
			    top		= (appHeight - eleHeight) / 2;
			    left	= 0;
			break;
			//------------------------------------------------
			case 'cc':
			    top		= (appHeight - eleHeight) / 2;
			    left	= (appWidth - eleWidth) / 2;
			break;
			//------------------------------------------------
			case 'cr':
			    top		= (appHeight - eleHeight) / 2;
			    left	= (appWidth - eleWidth);
			break;
			//------------------------------------------------
			//------------------------------------------------
			case 'bl':
			    top	= (appHeight- eleHeight);
			break;
			//------------------------------------------------
			case 'bc':
			    top	= (appHeight- eleHeight);
			    left	= (appWidth - eleWidth) / 2;
			break;
			//------------------------------------------------
			case 'br':
			    top	= (appHeight- eleHeight);
			    left	= (appWidth - eleWidth);
			break;
		}
		if( top>=0 && left>=0)
		{
			jQuery('#'+element).css('top',topReference + top);
			jQuery('#'+element).css('left',left);
		}
	}catch(e){}
}
//------------------------------------------------------------------------------------
function app_getDate()
{
	var data = new Date();
	var h = data.getHours();
	var m = data.getMinutes();
	var s = data.getSeconds();
	if(h<10){h='0'+h;}
	if(m<10){m='0'+m;}
	if(s<10){s='0'+s;}
	return  h+':'+m+':'+s;
}
//------------------------------------------------------------------------------------
/*
	Adiciona camada transparente para bloquear a tela evitando acesso aos campos e cliques
	ex: app_blockScreen('yellow','60','base/imagens/processando.gif','Processando. Aguarde...',20,150','red');
*/
function app_blockScreen( maskColor, opacity, imgWait, txtWait, imgWidth, imgHeight,txtColor)
{
	if( typeof jQuery.blockUI == 'function' )
	{
		app_blockUI( txtWait, null, imgWait, imgWidth, imgHeight, opacity, txtColor,null,null,maskColor);
		return;

	}	var div 	= document.getElementById('blockScreenDiv');
	maskColor 	= maskColor	|| '#333333';
	imgWidth	= imgWidth 	|| '';
	imgHeight	= imgHeight || '';
	txtColor	= txtColor	|| '#ffffff';
	opacity 	= opacity||30;
	if( !div)
	{
		jQuery("body").append('<div id="blockScreenDiv" class="fwBlockScreenDiv"><table width="100%" height="100%"><tr><td id="tdBlockScreen" align="center" valign="middle"></td></tr></table></div>');
	}
	div = document.getElementById('blockScreenDiv');
	if( div )
	{
		div.style.backgroundColor=maskColor;
		jQuery('#tdBlockScreen').html('');
		if( opacity > 0  )
		{
			try{div.style.filter="alpha(opacity="+opacity+")";}catch(e){}
 			try{div.style.opacity=opacity/100;}catch(e){};
		}
		/*
		if(typeof div.style.filter !='undefined' )
		{
 			try{div.style.filter="alpha(opacity="+opacity+")";}catch(e){}
 			try{div.style.opacity=opacity/100;}catch(e){};
		}
		else
		{
			div.style.opacity=opacity/100;
		}
		*/
		if( imgWait )
		{
			jQuery('#tdBlockScreen').append('<img class="fwImgBlockScreen" src="'+imgWait+'"'+(imgWidth!='' ? ' width="'+imgWidth+'"':"")+(imgHeight!='' ? ' height="'+imgHeight+'"':"")+">");
		}
		if( txtWait )
		{
			var css='width:220px;background-color:#000000;display:block;border:1px solid #ffffff;font-size:14px;font-weight:bold;opacity:100;-moz-opacity:1.0;filter: alpha(opacity=100);-moz-border-radius: 15px;border-radius: 15px;';
			if( txtColor)
			{
				css += 'color:'+txtColor;
			}
			jQuery('#tdBlockScreen').append('<br/><div style="'+css+'">'+txtWait+'</div>');
		}
		div.style.display='block';
	}
}
function app_blockUI(message,callback,imgWait,imgWidth,imgHeight,opacity,messageColor,backgroundColor,timeout,overlayColor)
{
	if( uiBlocked )
	{
		return;
	}
	message			= message || '';
	opacity 		= opacity||0.2;
	imgWait 		= imgWait||'<img style="border:none;" src="'+pastaBase+'imagens/fwProcessing.gif"/>';
	messageColor 	= messageColor||'#000000';
	backgroundColor = backgroundColor||'#efefef';
	timeout			= timeout||0;
	overlayColor	= overlayColor || '#000000';
	uiBlocked:true;
	if( message && imgWait)
	{
		message+='<br>';
	}
	jQuery.blockUI({
            message: message+imgWait
            ,timeout: timeout
            ,fadeIn:  200
            ,fadeOut:  100
            ,css:{ 'backgroundColor': '#efefef'
            	,'color':'#000000'
                ,'-webkit-border-radius': '10px'
            	,'-moz-border-radius': '10px'
            	,'border-radius':'15px'
            	,'border':'2px solid #000000'
				,'padding': '5px'
				,'font-size':'12px'
				,'font-weight':'bold'
            	}
            ,overlayCSS:{'opacity':'0.2','backgroundColor':overlayColor}
            ,onUnblock:function(e,o)
            {
				uiBlocked = false;
            	app_executarFuncao(callback,e);
            }});
}

/*
	Remove o bloqueio da tela bloqueada pelo app_blockScreen
*/
function app_unBlockScreen()
{
	if( typeof jQuery.blockUI == 'function' )
	{
		jQuery.unblockUI()
		return;
	}
	var div 	= document.getElementById('blockScreenDiv');
	if( div )
	{
		div.style.display='none';
	}
}
function app_unblockUI()
{
	jQuery.unblockUI();
}
//--------------------------------------------------------------------------------------------
function app_resized()
{
	app_adjust_middle_area_size();
}
//---------------------------------------------------------------------------------------------
function utf8_decode(str_data)
{
	// http://kevin.vanzonneveld.net
	// +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
	// +      input by: Aman Gupta
	// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// *     example 1: utf8_decode('Kevin van Zonneveld');
	// *     returns 1: 'Kevin van Zonneveld'

	var tmp_arr = [], i = ac = c = c1 = c2 = 0;

	while (i < str_data.length) {
	    c = str_data.charCodeAt(i);
	    if (c < 128) {
	            tmp_arr[ac++] = String.fromCharCode(c);
	            i++;
	    }
	    else
	            if ((c > 191) && (c < 224)) {
	                    c2 = str_data.charCodeAt(i + 1);
	                    tmp_arr[ac++] = String.fromCharCode(((c & 31) << 6) | (c2 & 63));
	                    i += 2;
	            }
	            else {
	                    c2 = str_data.charCodeAt(i + 1);
	                    c3 = str_data.charCodeAt(i + 2);
	                    tmp_arr[ac++] = String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
	                    i += 3;
	            }
	}
	return tmp_arr.join('');
}

//---------------------------------------------------------------------------------------------
function app_set_prototype_win(jsonParams)
{
	var win = Windows.getWindow( jsonParams.winId );
	if ( !win.parsed || jsonParams.force )
	{
		if( jsonParams.title )
		{
			win.setTitle(jsonParams.title);
		}
		var h = win.height;
		var w = win.width;
		if( jsonParams.width)
		{
			var app_centerW				= jQuery('#app_center').width();
			if(jsonParams.width > app_centerW )
			{
				jsonParams.width = app_centerW-35;
			}
			w=jsonParams.width;
		}
		if( jsonParams.height )
		{
			var app_centerH				= jQuery('#app_center').height();

			if(jsonParams.height > app_centerH )
			{
				jsonParams.height = app_centerH - 40 ;
			}
			h=jsonParams.height;
		}
		// adicionei 20 para regirar o scroll horizontal
		win.setSize(w+10,h);
		win.showCenter();
		if( jsonParams.statusBar && menuShowLinkStatusBar )
		{
			win.setStatusBar(jsonParams.status);
		}
		win.parsed = true;
	}

}
//----------------------------------------------------------------------------------------------
function app_window(jsonParams)
{
	var winId			= jsonParams.winId || 'win'+new Date().getTime();
	var modal 			= jsonParams.modal		== true ? true : false;
	var closable 		= jsonParams.closable	== false ? false : true;
	var minimizable		= jsonParams.minimizable== false ? false : true;
	var maximizable		= jsonParams.maximizable== true ? true : false;
	var resizable		= jsonParams.resizable  == true ? true : false;
	var draggable		= jsonParams.draggable  == false ? false : true;
	var confirmClose	= jsonParams.confirmClose 	== false ? false : true;
	var module			= jsonParams.module||'';
	var step  			= jsonParams.step||0;
	var url;
	var wiredDrag = true;
	if( modal )
	{
		minimizable = false;
	}
	if( !draggable )
	{
		wiredDrag	= false;
	}
	if( step )
	{
		if( Windows.getWindow(winId) )
		{
			if( module.indexOf('http')==-1 && module.indexOf('www')==-1)
			{
				url = app_url+app_index_file+ ( module.indexOf('?') == -1 ? '?' : '&' )+"modulo="+module+'&prototypeId='+winId
			}
			else
			{
				if( module.indexOf(app_index_file) >-1 )
				{
					url = module + ( module.indexOf('?') == - 1 ? '?':'&')+'prototypeId='+winId
				}
				else
				{
					url = module;
		       		Windows.getWindow(winId).setTitle( url );
				}
			}
       		Windows.getWindow(winId).getContent().src = url;
       		Windows.getWindow(winId).setURL( url );
       		if( jsonParams.width || jsonParams.height )
       		{
				jsonParams.width 	= jsonParams.width||600;
				jsonParams.height 	= jsonParams.height||450;
				Windows.getWindow(jsonParams.winId).setSize(jsonParams.width,jsonParams.height);
				Windows.getWindow(jsonParams.winId).showCenter();
       		}
		}
    }
	else
	{
		if( module )
		{
			win = new Window(winId,
			{
			 className			: "mac_os_x_right"
			 //, blurClassName	: "blur_os_x"
			 , title			: ''
			 , width			: 400
			 , height			: 150
			 //, url				: app_url_root+pastaBase+"/includes/carregando.html"
			 , url				: pastaBase+"/includes/carregando.html"
			 , wiredDrag		: true
			 , maximizable		: maximizable
			 , minimizable		: minimizable
			 , closable			: closable
			 , resizable		: resizable
			 , draggable		: draggable
			 , closeCallback	: function (win){ return app_close_prototype_window(confirmClose, win) }
			 });
			win.showCenter(modal);
		    win.setConstraint(true, {left:0, right:0,bottom:-100,top:80});
  			win.toFront();
  			if( menuShowLinkStatusBar )
  			{
  				win.setStatusBar('Módulo: '+module);
			}
  			win.setDestroyOnClose();
			//window.setTimeout('app_window({step:1,winId:"'+winId+'",module:"'+module+'"})',300);
			jsonParams.step = 1;
			jsonParams.winId = winId;
			window.setTimeout('app_window('+array2json( jsonParams )+')',300);
		}
	}
}
//---------------------------------------------------------------------------
function app_close_window(winId)
{
	if (Windows.getWindow(winId))
	{
		Windows.getWindow(winId).close();
	}
}

/**
 * Converts the given Json data structure to a string.
*/
function json2str(o) {
    var arr = [];
    var fmt = function(s) {
    if (typeof s == 'object' && s != null) return json2str(s);
    return /^(string|number)$/.test(typeof s) ? (/^(string)$/.test(typeof s)? "\"" + s.replace(/"/,'\\"') + "\"":s) : s;
    }
    for (var i in o) arr.push("\"" + i + "\":" + fmt(o[i]));
    return '{' + arr.join(',') + '}';
    }
//---------------------------------------------------------------------------
/**
 * Converts the given data structure to a JSON string.
 * Argument: arr - The data structure that must be converted to JSON
 * Example: var json_string = array2json(['e', {pluribus: 'unum'}]);
 * 			var json = array2json({"success":"Sweet","failure":false,"empty_array":[],"numbers":[1,2,3],"info":{"name":"Binny","site":"http:\/\/www.openjs.com\/"}});
 * http://www.openjs.com/scripts/data/json_encode.php
 */
function array2json(arr)
{
    var parts = [];
    var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');
    for(var key in arr) {
    	var value = arr[key];
        if(typeof value == "object") { //Custom handling for arrays
            if(is_list) parts.push(array2json(value)); /* :RECURSION: */
            else parts[key] = array2json(value); /* :RECURSION: */
        } else {
            var str = "";
            if(!is_list) str = '"' + key + '":';

            //Custom handling for multiple data types
            if(typeof value == "number") str += value; //Numbers
            else if(value === false) str += 'false'; //The booleans
            else if(value === true) str += 'true';
            else str += '"' + value + '"'; //All other things
            parts.push(str);
        }
    }
    var json = parts.join(",");
    if(is_list) return '[' + json + ']';//Return numerical JSON
    return '{' + json + '}';//Return associative JSON
}
//-------------------------------------------------------------------------------------
function app_close_prototype_window(confirmClose, win )
{
	//alert( win.getURL());
	var result=false;
	if ( !confirmClose )
	{
		result = true;
	}
	else if( confirm('Finalizar módulo '+win.getTitle()+' ?'))
	{
		result=true;
	}
	if( result)
	{
		app_server_action('unsetSessionModule');
	}
	return result;
}
function getHeight(id)
{
	return jQuery("#"+id).height();
}
function getWidth(id)
{
	return jQuery("#"+id).width();
}

function app_getObj(nomeObjeto,propriedade)
{
	var app_iframe = document.getElementById('app_iframe');
	if ( app_iframe )
	{
		return app_iframe.contentWindow.fwGetObj(nomeObjeto,propriedade);
	}
	// compatibilidade com formdin3
	app_iframe = document.getElementById('iframe_area_dados');
	if ( app_iframe )
	{
		return app_iframe.contentWindow.fwGetObj(nomeObjeto,propriedade);
	}
	var obj;
	if(isNS4)
	{
		try {obj=document.getElementById(nomeObjeto);} catch(e){}
		if(!obj)
		{
			try{obj=document.getElementById(nomeObjeto+'disabled');} catch(e){}
		}
		if(!obj)
		{
			try{obj=document.getElementById(nomeObjeto+'_disabled');} catch(e){}
		}
		// procurar em caixa baixa
		if(!obj)
		{
			try{obj=document.getElementById(nomeObjeto.toLowerCase());} catch(e){}
		}
		if(!obj)
		{
			try{obj=document.getElementById(nomeObjeto.toLowerCase()+'disabled');} catch(e){}
		}
		if(!obj)
		{
			try{obj=document.getElementById(nomeObjeto.toLowerCase()+'_disabled');} catch(e){}
		}
	}
	else
	{
			try{obj=document.all[nomeObjeto];} catch(e){}
			if(!obj)
			{
				try{obj=document.all[nomeObjeto+'disabled'];} catch(e){}
			}
			if(!obj)
			{
				try{obj=document.all[nomeObjeto+'_disabled'];} catch(e){}
			}
			// procurar em caixa baixa
			if(!obj)
			{
				try{obj=document.all[nomeObjeto.toLowerCase()];} catch(e){}
			}
			if(!obj)
			{
				try{obj=document.all[nomeObjeto.toLowerCase()+'disabled'];} catch(e){}
			}
			if(!obj)
			{
				try{obj=document.all[nomeObjeto.toLowerCase()+'_disabled'];} catch(e){}
			}

	}
	if( obj && propriedade)
	{
		try {
			eval('var prop = obj.'+propriedade);
			return prop;
		} catch(e) {}
	}
	return obj;
}

function app_atualizarCampos(campos,valores)
{
	if (!campos)
	{
		return;
	}
	var app_iframe = jQuery('#app_iframe').get(0);
	if ( app_iframe )
	{
		app_iframe.contentWindow.fwAtualizarCampos(campos,valores);
		return;
	}
	// compatibilidade com FormDin3
	var app_iframe = jQuery('#iframe_area_dados').get(0);
	if ( app_iframe )
	{
		app_iframe.contentWindow.fwAtualizarCampos(campos,valores);
		return;
	}
}
function app_executarFuncao(funcao,param)
{
   try
   {
   	  	if( typeof param == 'undefined')
   		{
	   		param = '';
		}
		var app_iframe = jQuery('#app_iframe').get(0);
		if ( app_iframe )
		{
			app_iframe.contentWindow.fwExecutarFuncao(funcao,param);
			return;
		}
		var app_iframe = jQuery('#iframe_area_dados').get(0);
		if ( app_iframe )
		{
			app_iframe.contentWindow.fwExecutarFuncao(funcao,param);
			return;
		}
        if( typeof funcao == 'function')
        {
			funcao.apply(this,[ param ] );
        }
        else if( typeof funcao == 'string')
        {
			funcao = funcao.replace('()','');
        	if( funcao.indexOf('(')==-1)
        	{
        		if( typeof param == 'string')
        		{
		   			funcao += '.apply(this,[\''+param.replace(/\n/g)+'\'])';
				}
				else
				{
			   		funcao += '.apply(this,[param])';
				}
        	}
        	eval( funcao+';' );
		}
		/*
        if( typeof funcao == 'function' )
        {
			funcao.call(param);
        }
        else
        {
        	eval( funcao+';' );
		}
		*/
   } catch(e) {}
}
/**
* Abre uma tela bloqueando a tela de baixo no estilo modal
* site: http://chriswanstrath.com/facebox/
*/
function app_faceBox(content,iframe,height,width,onClose,onShow,css,isImage)
{
	if(typeof jQuery.facebox == 'undefined' )
	{
		LazyLoad.css(pastaBase+'js/jquery/facebox/facebox.css',function()
		{
			LazyLoad.js(pastaBase+'js/jquery/facebox/facebox.js', function ()
			{
				jQuery.facebox.settings.closeImage = pastaBase+'js/jquery/facebox/closelabel.png';
				jQuery.facebox.settings.loadingImage = pastaBase+'js/jquery/facebox/loading.gif';
				app_faceBox( content,iframe,height,width,onClose,onShow,css);
			})
		});
	}
	else
	{
		var container='';
		isImage = isImage || false;
		if( iframe || content.indexOf('http') == 0 || content.indexOf('www') == 0)
		{
			height	= height || 200;
			width	= width  || 500;
			// container mostra a animação de carregando
			container = '<iframe id="faceBoxIframe" scrolling="auto" frameborder="no" align="center" style="width:'+width+'px;height:'+height+'px;border:0px;padding-right:7px;'+css+'" src="'+pastaBase+'includes/carregando_cinza.html"></iframe>';
			// mostrar a url dentro do iframe em 1 segundo
			window.setTimeout('jQuery("#faceBoxIframe").attr("src","'+app_adjustBasePath(content)+'");',1000);
		}
		else
		{
			height	= height || 'auto';
			width	= width || 'auto';
			height	+= (height == 'auto') ? '' : 'px';
			width	+= (width == 'auto') ? '' : 'px';
			container = '<div style="width:'+width+';height:'+height+';border:0px;'+css+'">'+content+'</div>';
		}
		if( typeof onShow == 'function' )
		{
			jQuery( document ).bind('reveal.facebox', onShow );
		}
		if( typeof onClose == 'function' )
		{
			jQuery( document ).bind('afterClose.facebox', onClose );
		}
		// retirar o evento onclick do overlay
		jQuery('#facebox_overlay').unbind('click');
		// retirar fechamento com a tecla ESC
		jQuery(document).unbind('keydown.facebox');
		var r = new RegExp("\.jpe?g|\.png|\.gif|\.bmp|\.tif|\.gif");

		//if ( content.indexOf('.png') )
		if( r.test( content ) || isImage )
		{
			jQuery.facebox({image:content});
		}
		else
		{
			jQuery.facebox( container );
		}
	}
}
/**
Função para fechar a faceBox aberta via javascript
*/
function app_faceBoxClose()
{
	try{ jQuery.facebox.close();}catch(e){}
}
/**
Função para ajustar o caminho da pasta base da url
*/
function app_adjustBasePath(url)
{
	if( ( url.indexOf('base/') > -1 ) && pastaBase )
	{
		url	= pastaBase + url.substring(url.indexOf('base/')+5);
	}
	return url
}
/**
 * Função para retornar a largura do iframe central da aplicação
 */
function app_getIframeH()
{
	return jQuery('#app_iframe').height();
}
function app_getIframeW()
{
	return jQuery('#app_iframe').width();
}

/**
	Função utilizada para alterar o tema do menu pricipal da aplicação
*/
function app_change_menu_theme(theme, urlMenuFile)
{
    var css =pastaBase+'js/dhtmlx/menu/skins/'+theme+'/'+theme+'.css';
	LazyLoad.css(css,function()
		{
			menuTheme = theme;
			app_build_menu(false,null,urlMenuFile);
		});

}
function app_open_modal_window(jsonParams)
{

	if( typeof $ != 'function') // não carregou a prototype
	{
		app_modalBox(jsonParams.title,jsonParams.url,jsonParams.height,jsonParams.width,jsonParams.callback,jsonParams.data);
		return;
	}
	var header_height	= jQuery("#table_header").height();
 	var areaWidth		= parseInt(jQuery('body').width()-100);
	var areaHeight		= parseInt(jQuery('body').height()-100);
	var url 			= jsonParams.url || '';
	var title			= jsonParams.title || '';
	var width			= jsonParams.width ? jsonParams.width : (areaWidth);
	var height			= jsonParams.height ? jsonParams.height : (areaHeight);
	var data			= jsonParams.data;
	var callback		= jsonParams.callback;
    if( height > areaHeight )
    {
   		height = areaHeight;
   		var areaMenu		= parseInt(jQuery('#div_main_menu').height());
   		if( !isNaN(areaMenu) )
   		{
   			height-=areaMenu;
   			header_height+=(areaMenu-4);
   		}
    }
 	if( jsonParams.url )
	{
		if( jsonParams.url.indexOf('www')== 0 )
		{
			url = 'http://'+url;
		}
   		if( jsonParams.url.substring(0,3) != '../' && jsonParams.url.substring(0,4)!='http' && jsonParams.url.substring(0,3)!='www' )
		{
			url = app_url+url;
			url += ( ( url.indexOf('?')==-1) ? '?' :'&' ) +'modalbox=1&subform=1';

		}
		if( title.indexOf('|')>-1)
		{
			title = title.substr(0,title.indexOf('|'));
		}
		url += '&app_formdin=1';
		win = new Window({className: "alphacube"
		, title: title
		, width:width
		, height:height
		, destroyOnClose: true
		, recenterAuto:false
 		, draggable:false
 		, showProgress: true
		, resizable:false
		, overlayShowEffectOptions:{duration:10}
		, overlayHideEffectOptions:{duration:10}
		, hideEffect:Element.hide
		, showEffect:Element.show
		, closeCallback	: function (win)
			{
				modalWindowList.pop();
				if( callback )
				{

					var formData;
					var fields;
					var fieldName;
					//win.getContent().contentWindow.document.forms[0].nome.value;
					//win.getContent().contentDocument.forms[0].nome.value;
					try
					{
						formData = jQuery(win.getContent().contentDocument.forms[0]).serializeArray();
						fields=Array();
						for ( key in formData )
						{
							fieldName = formData[key].name;
							if( fieldName.indexOf('[]') > -1 )
							{
								fieldName = fieldName.replace('[]','');
								if( typeof fields[ fieldName ] == 'undefined')
								{
									fields[fieldName] = Array();
								}
								fields[fieldName].push(formData[key].value);
							}
							else
							{
								fields[formData[key].name] = formData[key].value;
							}
						}
					}
					catch(e){}
					try{
						eval( 'callback.apply(this,[fields,win.getContent().contentDocument]);');
					}catch(e){}
				}
				return true;
			}
		// botoes
		,maximizable: false
		,minimizable: false
		});
		if( header_height )
		{
			win.setConstraint(true, {top:header_height});
		}
   		if( url.indexOf(app_url) == 0 )
        {
	 		url += ( ( url.indexOf('?')==-1 ) ? '?': '&' );
        	url+='modalWinId='+win.getId()
		}

		if( typeof data =='object')
		{
		 	for(key in data)
		 	{
		 		url += ( ( url.indexOf('?')==-1 ) ? '?': '&' );
				url += key+'='+data[key];
		 	}
		}
		else if( typeof data == 'string' && data)
		{
	 		url+= ( ( url.indexOf('?')==-1 ) ? '?': '&' );
			url+=  data;
		}
		//url += '&nome="luis"';
  		//win.setURL(url);
  		url =  url.replace(/"/g,'\\"');
  		win.setURL(pastaBase+"includes/carregando.html");
  		window.setTimeout('win.setURL("'+url+'");',1000);
		win.showCenter(true);
		//win.show(true);
		//win.maximize();
		//win.setConstraint(true, {left:0, right:0,bottom:-100,top:80});
  		win.toFront();
  		modalWindowList.push(win);
		window.keepMultiModalWindow=true;
		WindowCloseKey.init();
	}
}
function app_close_modal_window()
{
 	var w = modalWindowList[modalWindowList.length-1];
	try{ w.close();} catch(e) {}
}

function app_data2Url(data)
{
	var url='';
	var val='';
	if( typeof data =='object')
	{
	 	for(key in data)
		{
			url += (url=='') ? '' : '&';
		  	val = data[key] ?  data[key] : jQuery("#"+key).val();
			url += key+'='+val;
		}
	}
	else if( typeof data == 'string')
	{
		url = data;
	}
	return url;
}

function app_show_image(url,height,width)
{
	height = height || jQuery("body").height()-100;
	width  = width  || jQuery("body").width()-100;
    app_open_modal_window({"url":url,"width":width,"height":height});
}

	/**
	 * janelaModal
	 *
	 * @param paramModal
	 *
	 */
function app_modalGeneric(paramModal)
	{
	paramModal.id = (paramModal.id == null) ? 'dialog-message' : paramModal.id;
	paramModal.width = (paramModal.width == null) ? 530 : paramModal.width;
	paramModal.height = (paramModal.height == null) ? 200 : paramModal.height;
	paramModal.title = (paramModal.title == null) ? 'Alerta' : paramModal.title;
	paramModal.data = (paramModal.data == null) ? '' : paramModal.data;
	paramModal.css = (paramModal.css == null) ? '' : paramModal.css;
	paramModal.img = (paramModal.img==null) ? pastaBase+'css/imagens/alert/help.gif':paramModal.img;

	if (jQuery('#janela-modal' + paramModal.id))
		{
		jQuery('#janela-modal' + paramModal.id).remove();
		}
	if( ! paramModal.data )
	{
	   	return;
	}

    paramModal.data = paramModal.data.replace(/\n/g,'<br>' );
	//var html = "<div style='display:table-cell;vertical-align:middle;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11.5px;font-weight:bold;"+paramModal.css+"; ' id='janela-modal" + paramModal.id + "' title='" + paramModal.title + "'></div>";

    var html = "<table id='janela-modal" + paramModal.id+"' title='" + paramModal.title+"' border='0' cellpadding='0' cellspacing='0' class='dialog-confirm' style='width:100%;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11.5px;font-weight:bold;"+paramModal.css+"'><tr>";
	html+="<td style='width:40px;vertical-align: middle;'><img id='dialog-image' src='"+paramModal.img+"' style='border:none;width:32px;height:32px;'/></td>";
	html+="<td id='dialog-content' style='vertical-align: middle;text-align: left;'>"+paramModal.data+"</td>";
	html+="</tr></table>";
	jQuery('body').append( html );
	jQuery("#janela-modal" + paramModal.id).dialog(
		{
		height: paramModal.height,
		width: paramModal.width,
		position: ['50%', '50%'],
		modal: true,
		resizable: false,
		//autoOpen : false,
		closeOnEscape: true,
		zIndex: 99996,
		buttons: paramModal.buttons,

		close: paramModal.close
        ,create: function(event, ui)
            {
				jQuery('body').css({ overflow: 'hidden' })
			}
		,beforeClose: function(event, ui)
			{
			jQuery('body').css({ overflow: 'inherit' })
			}
		}
		);
	jQuery('.ui-dialog-titlebar-close').hide();
	}


/**
 * fwAlert
 *
 * @param message
 * @param jsonParams
 * @param theme
 */
function app_alert(message, jsonParams, theme )
{
	jsonParams = ( ! jsonParams ) ? {} : jsonParams;
    jsonParams.title = (!jsonParams.title) ? 'Mensagem' : jsonParams.title;
    jsonParams.width = (!jsonParams.width) ? 530 : jsonParams.width;
    jsonParams.height = (!jsonParams.height) ? null : jsonParams.height;
    jsonParams.callback = (!jsonParams.callback) ? null : jsonParams.callback;
    jsonParams.css = (!jsonParams.css) ? 'color:#0000FF' : jsonParams.css;
    jsonParams.img = (!jsonParams.img) ? pastaBase+'css/imagens/alert/info.gif':jsonParams.img;
    jsonParams.theme = (!jsonParams.theme) ? '':jsonParams.theme;
    jsonParams.buttonLabel = (jsonParams.buttonLabel==null) ? 'Fechar' : jsonParams.buttonLabel;

    if( jsonParams.img.indexOf('undefinedcss') > -1)
    {
    	jsonParams.img = jsonParams.img.replace('undefinedcss',pastaBase+'css');
	}

    if( typeof pastaBase == 'undefined' )
    {
    	if( jsonParams._setTimeout )
    	{
			  alert( message );
		  	  return;
    	}
		jsonParams['_setTimeout']=true;
		window.setTimeout(function(){
			app_alert(message,jsonParams,theme);
		},100);
		return;
    }

    if( theme === 'error' || jsonParams.theme=='error')
    {
    	jsonParams.img = (jsonParams.img==pastaBase+'css/imagens/alert/info.gif') ? pastaBase+'css/imagens/alert/important.gif':jsonParams.img;
        jsonParams.css += ';color:#ff0000;';
    }
	app_modalGeneric(
		{
		data : message,
		width: jsonParams.width,
		height: jsonParams.height,
		close:jsonParams.callback,
		title:jsonParams.title,
		css:jsonParams.css,
		img:jsonParams.img,
        buttons:  [ { text: jsonParams.buttonLabel, click: function() { jQuery( this ).dialog( "close" ); } } ]
		});
	}
 /**
 * Dialogo de confirmação
 *
 * @param message
 * @param callbackYes
 * @param callbackNo
 * @param yesLabel
 * @param noLabel
 * @param title
 */
function app_confirm(message, callbackYes, callbackNo, yesLabel, noLabel, title)
{
	title 		= (!title)?'Confirmação':title;
	yesLabel 	= (!yesLabel)?'Sim':yesLabel;
	noLabel 	= (!noLabel)?'Não':noLabel;
	app_modalGeneric(
	{
		data : message,
		height: 'auto !important',
		width:530,
		title:title,
		buttons	:
			[ {text:noLabel,click: function()
				{
					jQuery(this).dialog("close");
					var app_iframe = document.getElementById('app_iframe'); // não utilizar fwGetObj() aqui

					if( typeof callbackNo=='function')
					{
						if( app_iframe )
						{
	            			app_iframe.contentWindow.fwExecutarFuncao(callbackNo);
						}
						else
						{
							app_executarFuncao( callbackNo);
						}
					}
					else
					{
						if( app_iframe )
						{
	            			app_iframe.contentWindow.fwExecutarFuncao(callbackYes,false);
						}
						else
						{
							app_executarFuncao( callbackYes,false);
						}
					}
				}
			},
			   {text:yesLabel,click: function()
				{
					jQuery(this).dialog("close");
					var app_iframe = document.getElementById('app_iframe'); // não utilizar fwGetObj() aqui
					if( app_iframe )
					{
	            		app_iframe.contentWindow.fwExecutarFuncao(callbackYes,true);
					}
					else
					{
						app_executarFuncao( callbackYes,true  );
					}
				}
			   }]
		});
}