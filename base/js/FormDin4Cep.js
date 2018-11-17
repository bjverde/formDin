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
Função para preenchimento automático de campos que compoem o endereço, utilizando ajax para consultar o CEP
Xml de retorno:
<cep>35164067</cep>
<uf>MG</uf>
<cidade>Ipatinga</cidade>
<bairro>Beth?nia</bairro>
<tipo_logradouro>Avenida</tipo_logradouro>
<logradouro>Jos? Assis Vasconcelos</logradouro>
<resultado>1</resultado>
<resultado_txt>sucesso. logradouro encontrado local</resultado_txt>
<limite_buscas>5</limite_buscas>
<ibge_uf>31</ibge_uf>
<ibge_municipio>313130</ibge_municipio>
<ibge_municipio_verificador>3131307</ibge_municipio_verificador>
*/
function getCepJquery(idNum_cep,fields,callback,beforeSend)
{
	// limpar os campos com valor = ?
	for (key in fields)
	{
		try
		{
			if( jQuery("#"+fields[key]).val()== '?' )
			{
				jQuery("#"+fields[key]).val('');
			}
		}
		catch(e){}
	}
	// se não informou o cep limpar os campos e sair
	if(!idNum_cep || jQuery('#'+idNum_cep).attr('value').replace(/[^0-9]/g,'').length != 8 )
	{
		// limpar o campos
		for (key in fields)
		{
			try{
				JQuery("#"+fields[key]).val('');
			}catch(e){}
		}
		return;
	}
	// bucar os dados de endereço
	setTimeout( function()
	{
		if(jQuery('#'+idNum_cep).attr('value')!='' && jQuery('#'+idNum_cep).attr('value')!=undefined)
		{
			//fwSetEstilo('{"id":"'+idNum_cep+'","backgroundImage":"url(\''+pastaBase+'imagens/carregando.gif\')","backgroundRepeat":"no-repeat","backgroundPosition":"center right"}');
			jQuery('#'+idNum_cep+'_btn_consultar').attr("disabled", true);
			jQuery('#'+idNum_cep+'_btn_consultar').val('Aguarde');
			jQuery('#'+idNum_cep+'_btn_consultar').css('color','red');
			fwExecutarFuncao(beforeSend,idNum_cep);
			jQuery.ajax(
			{
				type: 'POST',
				dataType: 'xml',
				//url: '?modulo='+pastaBase+'/callbacks/getCep.php',
				url: app_index_file,
				data: 'ajax=1&modulo='+pastaBase+'/callbacks/getCep.php&cep='+jQuery('#'+idNum_cep).attr('value').replace(/[^0-9]/g,''),
				error:function(erro){
					alert(erro);
				},
				success:function(dataset)
				{
					fwSetEstilo('{"id":"'+idNum_cep+'","backgroundImage":"","backgroundRepeat":"no-repeat","backgroundPosition":"center right"}');
					jQuery('#'+idNum_cep+'_btn_consultar').removeAttr("disabled");
					jQuery('#'+idNum_cep+'_btn_consultar').val('Consultar');
					jQuery('#'+idNum_cep+'_btn_consultar').css('color','blue');
					jQuery(dataset).find('webservicecep').each(
						function()
						{

							switch(jQuery(this).find('resultado').text())
							{
								case '1':
									break;
								case '-1':
									alert('CEP não encontrado');
									break;
								case '-2':
									alert('Formato de CEP inválido');
									break;
								case '-3':
									alert('Limite de buscas de ip por minuto excedido');
									break;
								case '-4':
									alert('Ip banido. Contate o administrador');
									break;
								default:
									alert('Erro ao conectar-se tente novamente');
									break;
							}
							if(jQuery(this).find('resultado').text()==1)
							{
								for (key in fields)
								{
									if (key == 'endereco')
									{
										var complemento='';
										if (!fields['complemento'])
										{
											complemento = ' '+jQuery(this).find('complemento').text()
										}
										// campo endereco concatenar com: tipo_logradouro e logradouro
										try{
											jQuery("#"+fields[key]).attr({
												value: jQuery(this).find('tipo_logradouro').text()+" "+jQuery(this).find('logradouro').text()+complemento
											});
										}catch(e){}
									}
									else
									{
										try{
											jQuery("#"+fields[key]).attr({
												value: jQuery(this).find(key).text()
											});
										}catch(e){}
										try{
											jQuery("#"+fields[key]+'_temp').attr({
												value: jQuery(this).find(key).text()
											});
										}catch(e){}

									}
								}
								fwExecutarFuncao( callback, dataset);
							}
						});
				}
			});
		}
	},1);


}
//----------------------------------------------------------------------------------------------------
function fwValidarTamanhoCep(e,clearIncompleteValue,incompleteMessage)
{
	if( !e )
	{
		return true;
	}
	var cep = e.value.replace(/[^0-9]/g,'');
	if( cep.length != 8)
	{
		if( incompleteMessage && e.value != '' )
		{
			fwAlert( incompleteMessage,{"callback":function(){ e.focus() }} );
		}
		if( clearIncompleteValue )
		{
			e.value='';
		}
	}
	return true;
}
//----------------------------------------------------------------------------------------------------