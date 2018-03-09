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

$frm = new TForm('Dados de Apoio',450,700);

$frm->addGroupField('gpTipoDado','Tipo de Dado');
	$frm->addSelectField('seq_tipo_dados_apoio'			,'Tipo Dado:'	,false	,null	,true,false,null,null,null,null,'&lt;Registrar tipo de dado novo&gt;');
	$frm->addTextField('des_tipo_dados_apoio'			,'Descrição'	,100	,true	,80);
	$frm->addTextField('sig_tipo_dados_apoio'			,'Sigla'		,25		,true);
	$frm->addSelectField('sit_cancela_tipo_dados_apoio'	,'Inativo'		,true	,'N=Não,S=Sim');
$frm->closeGroup();

$frm->addGroupField('gpDado','Dados');
	$frm->addHtmlField('gride');
	$frm->addSelectField('num_registros_novos'				,'Nº de registros novos no gride',false,"1=1,2=2,3=3,4=4,5=5,6=6,7=7,8=8,9=9,10=10",true,true);
$frm->closeGroup();

// valor default para o numero de registros
if(!$frm->getValue('num_registros_novos'))
{
	$frm->setValue('num_registros_novos',2);
}

// adicionar evento aos campos
$frm->getField('seq_tipo_dados_apoio')->setEvent('onChange','fwFazerAcao("atualizar")');
$frm->getField('num_registros_novos')->setEvent('onChange','fwFazerAcao("atualizar")');

// remover os campos se o tipo de  dados não estiver selecionado
if ( !$frm->getValue('seq_tipo_dados_apoio') )
{
	$frm->removeField(array('sit_cancela_tipo_dados_apoio','gride','gpDado','num_registros_novos') );
}
// SWITCH DA ACAO
switch($acao)
{
	case 'Novo':
		$frm->clearFields();
		$_POST['formDinAcao']='';
	break;
	//------------------------------------------------------------------------------
	case 'Gravar':
		if ( $frm->validate() )
		{
			//$_SESSION['form_token'] = md5(serialize($_POST));

			if( ! $frm->addError(executarPacote(ESQUEMA.'.PKG_DADOS_APOIO.INC_ALT_TIPO_DADO',$_POST,-1)) )
			{
				if( (integer) $frm->getValue('seq_tipo_dados_apoio')==0)
				{
					$frm->setPopUpMessage('Tipo dado incluído com sucesso!!!');
					$frm->clearFields();
				}
				else
				{
					$bvars = $frm->createBvars('seq_tipo_dados_apoio');
					foreach ($_POST['TEXT_DES_DADOS_APOIO'] as $k=>$v)
					{
						if(	( $k < 0  && strlen($_POST['TEXT_DES_DADOS_APOIO'][$k]) > 0 )
							||  $_POST['TEXT_DES_DADOS_APOIO'][$k] != $_POST['TEXT_DES_DADOS_APOIO_ATUAL'][$k]
							||  $_POST['TEXT_SIT_CANCELADO'][$k] != $_POST['TEXT_SIT_CANCELADO_ATUAL'][$k] )
							{
								$bvars['SEQ_DADOS_APOIO'][] = $k;
								$bvars['DES_DADOS_APOIO'][] = $_POST['TEXT_DES_DADOS_APOIO'][$k];
								$bvars['SIT_CANCELADO'][] = $_POST['TEXT_SIT_CANCELADO'][$k];
							}
					}
					if( !$frm->addError(executarPacote(ESQUEMA.'.PKG_DADOS_APOIO.INC_ALT_DADO_APOIO',$bvars)) )
					{
						$frm->setPopUpMessage('Tipo dado alterado com sucesso!!!');
					}
				}
			}
		}
	break;
}
//--------------------------------------------------------------------------------------------------
// preencher os cambos
$bvars = null;
print_r(recuperarPacote(ESQUEMA.'.PKG_DADOS_APOIO.SEL_TIPO_DADOS',$bvars,$res_tipo_dados,-1));
$frm->setOptionsSelect('seq_tipo_dados_apoio',$res_tipo_dados,'DESCRICAO','CODIGO');

// remover os campos se o tipo de  dados não estiver selecionado
if ( !$frm->getValue('seq_tipo_dados_apoio') )
{
	$frm->removeField(array('sit_cancela_tipo_dados_apoio','gride','gpDado','num_registros_novos') );
}

// criar o gride com os dados para inclusão / aleração
if ( $frm->getValue('seq_tipo_dados_apoio') )
{
	$bvars = $frm->createBvars('seq_tipo_dados_apoio');
	print_r(recuperarPacote(ESQUEMA.'.PKG_DADOS_APOIO.SEL_DADOS_APOIO',$bvars,$res_tipo_dado,-1));
	$res_tipo_dado=$bvars['CURSOR_PAI'];
	$frm->update($res_tipo_dado);
	for ($i=1; $i<=$frm->getValue('num_registros_novos');$i++)
	{
		$bvars['CURSOR']['SEQ_DADOS_APOIO'][] 	= -$i;
		$bvars['CURSOR']['DES_DADOS_APOIO'][] 	= '';
		$bvars['CURSOR']['SIT_CANCELADO'][] 	= 'N';
	}
    $gride = new TGrid('gride'
    ,null
    ,$bvars['CURSOR']
    ,null
    ,'100%'
    ,'SEQ_DADOS_APOIO'
    ,'SEQ_DADOS_APOIO');
    $gride->enableDefaultButtons(false);
    // campos ocultos do gride
	$gride->addHiddenField('SIT_CANCELADO'			,'text_sit_cancelado_atual');
	$gride->addHiddenField('DES_DADOS_APOIO'		,'text_des_dados_apoio_atual');
   	$gride->addSelectColumn('text_sit_cancelado'	,'Inativo ?','SIT_CANCELADO',array('N'=>'Não','S'=>'Sim'));
	$gride->addTextColumn('text_des_dados_apoio'	,'Descrição','DES_DADOS_APOIO',80,100);
    $frm->setValue('gride',$gride->show(false));


    // desabilitar o campo da sigla
    $frm->disableFields('sig_tipo_dados_apoio');
}
//--------------------------------------------------------------------------------------------------
$frm->setAction('Gravar,Novo');
$frm->show();
?>
