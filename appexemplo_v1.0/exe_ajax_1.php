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

/**
* Primeiro exemplo.
* Adicionar botão ajax em um form no padrão normal com submit
*/

// fazer o include das funções ajax quando receber uma requisição ajax;
if( isset($_REQUEST['ajax'] ) && $_REQUEST['ajax'] == 1 )
{
	require_once($this->getBase().'includes/formDin4Ajax.php');
}

$frm = new TForm('Formulário Ajax - Exemplo Nº 1 - Módulo: exe_ajax_1.php ',400,600);
$frm->addHtmlField('html','<br><center><b>Exemplo de transformação de um formulário no formato padrão ( submit ) para ajax.</b></center><br>Os botões abaixo foram trasnformados para o padrão ajax, alterando a linha:<br>$frm->setActions("Gravar,Excluir"); <br>para:<br>$frm->addButtonAjax("Gravar");<br>$frm->addButtonAjax("Excluir");<br<br>');

$frm->addTextField('nome','Nome:',100,true,50);
$frm->addDateField('nasc','Nascimento:',true);
$frm->addNumberField('salario','Salário',10,false,2);
$frm->addButton('Normal',null,'btnTeste',null,null,true,false);
$frm->addButtonAjax('Normal',null,null,null,null,null,null,null,null,'btnAjax',null,true,false);
$frm->addButtonAjax('Entrar',null,'fwValidateFields()','resultado','login','Validando informações','text',false);

if( $acao =='login') {
    sleep(1);
    echo 'Passo 1 ok';die();
    if( $frm->get('login')=='admin' && $frm->get('senha')=='admin'){
        $_SESSION[APLICATIVO]['conectado']=true;
        prepareReturnAjax(1);
    }else {
        prepareReturnAjax(0);
    }
}

$_POST['formDinAcao'] = isset($_POST['formDinAcao']) ? $_POST['formDinAcao'] : '';
switch($_POST['formDinAcao'])
{
	case 'testar_callback':

	   //prepareReturnAjax(1,null,'POST');
	   //prepareReturnAjax(1,null,'SERVER');
		$res['NUM_CPF'][0]= '45427380191';
		$res['NUM_CPF'][1]= '12345678909';
		$res['NOM_PESSOA'][0] = $_POST['nome'];
		$frm->setReturnAjaxData($res);
		//prepareReturnAjax(0,null, $res );
		// retornar
		//$frm->addReturnAjaxData(array('cod_uf'=>53));
		//$frm->setReturnAjaxData(array('cod_uf'=>53));
		$frm->setMessage('Registro OK!');
		// prepareReturnAjax(1,array('cod_uf'=>53),'Registro Ok');
	break;
	case 'Gravar':
		/*
		$res['DAT_ITEM'][0] = '01/01/2012';
		$res['NOM_ITEM'][0] = "CORAÇÃO";
		prepareReturnAjax(1,$res);
		prepareReturnAjax(1,"'CORAÇÃO'");
		*/
		sleep(1); // temporizador de 1 segundo para retornar
		if( $frm->validate() )
		{
			$frm->setMessage('Ação salvar executada com SUCESSO!!!');
		}
	break;
	//---------------------------------------------------------------------------------
	case 'Excluir':
		//sleep(1); // temporizador de 1 segundo para retornar
		if( $frm->validate() )
		{
			$frm->setMessage('Ação Excluir executada com SUCESSO!!!');
		}
	break;
	//---------------------------------------------------------------------------------
}

// antes
//$frm->setAction('Salvar,Excuir');

// depois
// botão ajax
$frm->addButtonAjax('Gravar',null,null,null,null,'Gravando. Aguarde...','json');
// botão ajax
$frm->addButtonAjax('Excluir',null,null,null,null,'Excluindo Registro...');

// chamada ajax manual
$frm->addButtonAjax('Meu Callback',null,'meuBeforeSend','meuCallBack','testar_callback'
			,'Testando Ajax!!!'
			,'json');

$frm->addButton('Teste Ajax',null,'btnTeste','teste()');

$frm->setAction('Refresh');
$frm->addButton('Confirmar',null,'btnConfirmar','confirmacao()');

$frm->show();
?>
<script>
function meuCallBack(res)
{
    //alert( res );
    alert( res.message );
    alert( res.data);
    alert( res.data.NUM_CPF );

    //alert( res.message);
    //alert( res.data.NUM_CPF[0]);
   	//data = jQuery.parseJSON( res.data );
	alert( 'res.message='+res.message+
		   '\nres.data.NOM_PESSOA[0]='+res.data.NOM_PESSOA[0]+
		   '\nres.data.NUM_CPF[0]='+res.data.NUM_CPF[0]+
		   '\nres.data.NUM_CPF='+res.data.NUM_CPF);
    //utilizar a funcao fwUpdateFieldsJson para atualizar os campos
    //ex: fwUpdateFieldsJson(res);
}
function meuBeforeSend(data)
{
	data['nome'] = 'parametro adicionado no evento beforeSend';
	//alert('Não vai passar');
	if( confirm('Função beforeSend foi chamada. Deseja continuar ?'))
		return true;
	return false;
}
function teste()
{


    //fwBlockScreen('red','40',pastaBase+'imagens/processando_red.gif','Aguarde');
     //alert( 'Documento:'+jQuery(document).scrollTop()+'\nbody:'+document.body.scrollTop );

     //return;
    //return;
    //fwBlockScreen( maskColor, opacity, imgWait, txtWait, imgWidth, imgHeight,txtColor)

	/*if( ! fwValidateForm() )
	{
		return false;
	}
	*/
	fwAjaxRequest(
            {'action':'Gravar'
            ,'dataType':'json'
            ,'async':false
            ,'msgLoad':'Gravando. Aguarde...'
            //,'containerId':'html'
            ,'callback':function(res)
            {
            	alert( res );
            	try{ alert( '1 '+res.data );}catch(e){}
            	/*
            	try{ alert( '1 '+res.data );}catch(e){}
            	try{ alert( '2 '+res.data.DAT_ITEM );}catch(e){}
            	try{ alert( '3 '+res.data.NOM_ITEM );}catch(e){}
            	*/
            	var o = jQuery.parseJSON(res.data);
            	try{ alert( '8 '+o.DAT_ITEM );}catch(e){alert('erro')}

            	var o  = fwParseJSON( res.data );
            	try{ alert( '9 '+o.DAT_ITEM );}catch(e){}
            }
            });
}
function confirmacao(status)
{
    status = status||null;
	if( !status)
	{
		fwConfirm('Tem certeza que testou esta mensagem?', confirmacao, confirmacao, 'Sim', 'Não', 'Salvar arquivo');
	}
    else
    {
        alert('Resultado:'+status);
    }

}
function resultado( res)
{
	alert( res);
}
</script>
