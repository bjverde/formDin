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
if (!session_id())
{
	session_start();
}

$frm = new TForm('Exemplo de Gride com Campo Anexo - Ajax');
// como os dados estão sendo jogados na sessão, ao sair do formulário fazer a limpeza
$frm->setOnClose('limpar_sessao()');

// campo chave da tabela pai. Ex: seq_propriedade=22
$frm->addHiddenField('seq_propriedade',22);

// campo anexo
$frm->addFileField('anexo','Anexo:',true,'doc,xls,odt,zip,rar,pdf,gif,txt,jpg','5M',60,true,null,'callBackAnexar');

// botão para limpar o gride e os dados da sessão
$frm->addButton('Limpar Tudo',null,'btnLimparTudo','btnLimparTudoClick()','Tem Certeza?',true,false);

//--------------------
// campo html onde será exibido o gride com os anexo
$frm->addHtmlField('campo_gride');

// cria o gride via ajax após o carregamento do formulário
$frm->addJavascript('init()');
$acao = isset($acao) ? $acao : null;
// ações chamadas via ajax
if( $acao == 'gravar_anexo')
{
	// grava na sessão os dados do arquivo anexado. A chave é o nome do arquivo
	// para evitar anexar o mesmo arquivo 2 vezes
	$_SESSION['meus_anexos'][ $_POST['nom_arquivo'] ] =  array('SEQ_PROPRIEDADE'=>$_POST['seq_propriedade'],'NOM_TEMP'=>$_POST['nom_temp']);
	die();
}
else if( $acao == 'remover_anexo')
{
	// grava na sessão os dados do arquivo anexado. A chave é o nome do arquivo
	// para evitar anexar o mesmo arquivo 2 vezes
	$_SESSION['meus_anexos'][ $_POST['nom_arquivo'] ] =  null;
	unset($_SESSION['meus_anexos'][ $_POST['nom_arquivo'] ]);
	die;
}
else if( $acao == 'limpar_tudo')
{
	$_SESSION['meus_anexos']=null;
	die();
}
$frm->show();
?>
<script>
function init()
{ 	// monta o gride passando o campo seq_propriedade com o seu valor atual do formulário.
	fwGetGrid("exe_gride_2_callback.php","campo_gride",{"seq_propriedade":""});
}

// Quando terminiar de fazer o upload do arquivo anexado, esta função é chamada
// recebendo o nome temporário do arquivo, o nome do arquivo, o tipo e o tamanho
function callBackAnexar(tempName,fileName,type,size,extension)
{
	alert( 'A função de callback callBackAnexar() foi chamada.\n\nParametros recebidos:\n1) TempName='+tempName+'\n2) FileName='+fileName+'\n3)Tamanho:'+size+' bytes\n4) Extensão:'+extension);

    fwAjaxRequest({
    	"modulo":"exe_gride_2.php"
    	,"dataType":"text"
    	,"action":"gravar_anexo"
    	,"data":{"nom_arquivo":fileName,"nom_temp":tempName,"seq_propriedade":""}
    	,"callback":function( erro )
		{
				if( ! erro ) // se não deu erro
				{
					if( confirm('Visualizar o arquivo anexado ?'))
					{
						fwShowTempFile(tempName,type,fileName);
					}
					init(); // atualizar o gride
				}
				else
				{
					alert('['+ erro+']' ); // exibir o erro
				}
		}
	})
    return;
	// executa a ação gravar_anexo do formulario
	jQuery.post(app_url+app_index_file,
	{
		'modulo':'exe_gride_2.php' // chamada ajax para si próprio passando a ação gravar_anexo
		,'formDinAcao':'gravar_anexo'
		,'ajax':1
		,'nom_arquivo':fileName
		,'nom_temp':tempName
		,'seq_propriedade':jQuery("#seq_propriedade").val()
	}
	,function( erro )
	{

		if( ! erro ) // se não deu erro
		{
			if( confirm('Visualizar o arquivo anexado ?'))
			{
				alert( tempName+'\n'+type+'\n'+fileName);
				fwShowTempFile(tempName,type,fileName);
			}
			init(); // atualizar o gride
		}
		else
		{
			alert('['+ erro+']' ); // exibir o erro
		}
	});
}

function btnVisualizarClick(campos,valores)
{
		$aValores = valores.split('|');
		fwShowTempFile($aValores[0],null,$aValores[1]);
}

function btnRemoverClick(campos,valores)
{
	$aValores = valores.split('|'); // valores enviados pelo gride.
	if( !confirm( 'Confirma a remoção do arquivo:\n'+$aValores[1]+'?'))
	{
		return;
	}
	jQuery.post(app_url+app_index_file,
	{
		'modulo':'exe_gride_2.php'
		,'formDinAcao':'remover_anexo'
		,"nom_arquivo":$aValores[1]
		,'ajax':1
	}
	,function( erro )
	{
		if( ! jQuery.trim(erro) )
		{
			init(); // atualizar o gride
		}
		else
		{
			alert( '['+erro+']' ); // exibir o erro
		}
	});
}
function btnLimparTudoClick()
{
	jQuery.post(app_url+app_index_file,
	{
		'modulo':'exe_gride_2.php'
		,'formDinAcao':'limpar_tudo'
		,'async':false
		,'ajax':1
	}
	,function( erro )
	{
		if( ! erro )
		{
			init(); // atualizar o gride
		}
		else
		{
			alert( erro); // exibir o erro
		}
	});
}
function limpar_sessao()
{
	btnLimparTudoClick();
}
</script>