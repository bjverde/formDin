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
function osPesquisar()
{
	var btnPesquisar = fwGetObj('btnPesquisar');
	var obj = fwGetObj('gdsearch');

	if (obj)
	{
		obj.innerHTML = '';
	}

	try
	{
		jQuery("#html_msg").hide();
		jQuery("#btnCadastrar").hide();
	}
	catch (e)
	{
	}
	obj = fwGetObj('formsearch_area');

	var html = jQuery('#html_gride');
	html.width(html.width() - 5);
	html.html('<center><span style="font-size:18px;color:blue;padding-top:50px;">Pesquisando...<\/span><br><img src=' + pastaBase + '/imagens/processando.gif><center>');
	btnPesquisar.disabled = true;
	btnPesquisar.value = 'Aguarde...';
	btnPesquisar.style.color = '#ff0000';
	// colocar um timer para carregar a imagem de processando.gif on moizilla
	window.setTimeout("fwFazerAcao('pesquisar');", 500);
}

/**
* Seleciona o valor, atualiza os campos, do formulário chamou a consulta dinâmica ,
* executa a função de callback e fecha a janela da consulta dinâmica
*
* @param strFields
* @param strValues
* @param strFunction
* @param timeOut
* @param strFocusField
*/
function osSelecionar(strFields, strValues, strFunction, timeOut, strFocusField)
{
	var parentWin 	= getParentWin();
	var winId 		= jQuery('#prototypeParentWin').val();
	var dialogId 	= jQuery('#dialogId').val();
	if( parentWin )
	{
		if( strFunction )
		{
			var form = jQuery('form');
			var params = { 'fields':form.serialize(), 'form':form.get(0) };
		}
    	if( typeof top.app_getObj == 'function' && ! winId && !dialogId )
       	{
			if (strFocusField)
			{
				try
				{
					top.app_getObj(strFocusField).focus();
				}
				catch (e)
				{
				}

			}
			top.app_atualizarCampos(strFields, strValues);
			if (strFunction)
			{
				try
				{
					top.app_executarFuncao(strFunction,params);
				}
				catch (e)
				{
					alert(e.message);
				}
			}
		}
		else
		{
			if (strFocusField)
			{
				try
				{
					parentWin.fwGetObj(strFocusField).focus();
				}
				catch (e){}
			}
			parentWin.fwUpdateFields(strFields, strValues);
			if (strFunction)
			{
				try
				{
					parentWin.fwExecutarFuncao(strFunction,params);
				}
				catch (e)
				{
					alert(e.message);
				}
			}
		}
		timeOut = timeOut | 300;
		setTimeout('fechar();', timeOut);
	}
}
//------------------------------------------------
function osStart(fieldLocal, fieldParent, autoStart, filterFields)
{
	// com iframe
	var aDbFields = filterFields.split(',');
	var aFormFields = fieldLocal.split(',');

	if (typeof top.app_getObj == 'function')
	{
		try
		{
			if (fieldParent && fieldLocal)
			{
				//                              alert( fieldLocal+'\n'+fieldParent+'\n'+filterFields);
				var f;
				var aParts;
				var from;
				var to;

				for (i = 0; i < aDbFields.length; i++)
				{
					aParts = aDbFields[i].split('|');
					from = aFormFields[i].toLowerCase();
					to = aParts[0];
					//                                      alert( 'de: '+ from +' para: ' + to );

					if (top.app_prototype)
					{
						var parentWin = top.Windows.getWindow(fwGetObj('prototypeParentWin').value);
						f = parentWin.getContent().contentWindow.fwGetObj(from);
					}

					else
					{
						f = top.app_getObj(from);
					}

					if (f && f.value)
					{
						fwGetObj(to).value = f.value;
					}
				}

			/*if( top.app_prototype )
					{
							var parentWin = top.Windows.getWindow(fwGetObj('prototypeParentWin').value );
							f = parentWin.getContent().contentWindow.fwGetObj(fieldParent);

					}
					else
					{
							f = top.app_getObj(fieldParent);
					}
					if( f && f.value)
					{
							fwGetObj(fieldLocal).value = f.value;
					}
					*/
			}
		}
		catch (e)
		{
		}
	}

	else
	{
		try
		{
			if (fieldParent && fieldLocal)
			{
				try
				{
					f = parent.fwGetObj(fieldParent);
		            if (f && f.value)
					{
						jQuery("#"+fieldLocal).val( f.value ) ;
					}
				}
				catch(e){}

				var f;
				var aParts;
				var from;
				var to;

				for (i = 0; i < aDbFields.length; i++)
				{
					aParts = aDbFields[i].split('|');
					from = aFormFields[i].toLowerCase();
					to = aParts[0];
					// alert( 'de: '+ from +' para: ' + to );

					if (top.app_prototype)
					{
						var parentWin = top.Windows.getWindow(fwGetObj('prototypeParentWin').value);
						f = parentWin.getContent().contentWindow.fwGetObj(from);
					}

					else
					{
						f = top.fwGetObj(from);
					}

					if (f && f.value)
					{
						fwGetObj(to).value = f.value;
					}
				}
			/*
					var f;
					if( top.app_prototype )
					{
							var parentWin = top.Windows.getWindow(fwGetObj('prototypeParentWin').value );
							f = parentWin.getContent().contentWindow.fwGetObj(fieldParent);

					}
					else
					{
							f = top.fwGetObj(fieldParent);
					}
					if( f && f.value)
					{
							fwGetObj(fieldLocal).value = f.value;
					}
					*/
			}
		}
		catch (e)
		{
		}
	}

	if (autoStart)
	{
		// so disparar a consulta se tiver algum campo preenchido
		if (filterFields)
		{
			var aTemp = filterFields.split(',');
			var aField;
			var ok = false;

			for (i = 0; i < aTemp.length; i++)
			{
				aField = aTemp[i].split('|');

				if (fwGetObj(aField[0]).value)
				{
					ok = true;
					break;
				}
			}
		}

		else
		{
			ok = true;
		}

		if (ok)
		{
			osPesquisar();
		}
	}
}

/**
* Preencher os campos locais com os valores valores dos campos do formulário que executou a consulta dinâmica,
* para compor a condição da consulta sql
*
* @param formFields
*/
function osGetTopValues(formFields)
{
	if (! formFields )
	{
		return;
	}
	var aTemp = formFields.split(',');
	var aField;
	var eTop;
	var eLocal
	var parentWin 	= getParentWin();
	var winId 		= jQuery('#prototypeParentWin').val();
	var dialogId 	= jQuery('#dialogId').val();
	var value;
	var localField 	= null;
	for (i = 0; i < aTemp.length; i++)
	{
		aField = aTemp[i].split('|');
		aField[1] = aField[1] ? aField[1] : aField[0];
		localField = fwGetObj(aField[1] );
		if (parentWin && localField && localField.value == '' )
		{
			if ( typeof parentWin.app_getObj == 'function' )
			{
				eTop = parentWin.app_getObj( aField[0] );
			}
			else
			{
				eTop = parentWin.fwGetObj(aField[0] );
			}
			if (eTop )
			{
				if (eTop.value)
				{
					if (eLocal = fwGetObj(aField[1]))
					{
						eLocal.value = eTop.value;
					}
				}
			}
		}
	}
}

/**
	 * fechar
	 *
	 *
	 * @return
	 *
	 * @see
	 */
function fechar()
{
	try
	{
		fwClose_modal_window(); // formdin4
	}
	catch (e)
	{
		try
		{
			top.GB_hide(); // formdin3
		}
		catch (e)
		{

		}
	}
}

/**
* retorna a janela que abriu a consulta dinâmica
*
*/
function getParentWin()
{
	var winId 		= jQuery('#prototypeParentWin').val();
	var dialogId 	= jQuery('#dialogId').val();
	var parentWin	= top;
	var parentDialog;

	if( winId )
	{
		// janelas prototype
		parentWin = top.Windows.getWindow(winId);
		parentWin = parentWin.getContent().contentWindow;
	}
	else if( dialogId )
	{
		if( typeof parent.getObj == 'function')
		{
			parentWin = parent;
		}
		else
		{
			// Dialog jquery UI
			parentWin = top.fwGetParentDialog( dialogId );

			if( parentWin != top )
			{
				parentWin = parentWin.get(0).contentWindow;
			}
		}
		closeFunction = "fechar()";
	}
	return parentWin;
}