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

$frm = new TForm('Cadastro de Funcionário',500);
$frm->setColumns(array(130));

$frm->addHiddenField('num_pessoa');
$frm->addHiddenField('cod_uf');
$frm->addGroupField('gpCTF','Consulta CTF');
	$frm->addCpfField('num_cpf'					,'Cpf:'					,true);
$frm->closeGroup();

$frm->addGroupField('gpCadastro','Dados do Funcionário')->setEnabled(false);
	$frm->addTextField('nom_pessoa'				,'Nome'					,60,false);
	$frm->addDateField('dat_nasc'				,'Aniversário:'	,false,false);
	$frm->addTextField('end_pessoa'				,'Endereço'	,100,null,60);
	$frm->addTextField('des_bairro'				,'Bairro'	,60,false);
	$frm->addCepField('num_cep'					,'C.E.P.',false,null,false);
	$frm->addTextField('nom_municipio'			,'Município/Uf',60);
	$frm->addTextField('sig_uf'					,'',2,null,2,null,false)->setEnabled(false);
	$frm->addTextField('num_fone'				,'Telefone',60);
	$frm->addTextField('des_email'				,'E-mail',60);
$frm->closeGroup();

$frm->addGroupField('gpLotação','Lotação e Exercício');
	$frm->addSelectField('seq_tipo_funcionario'	,'Tipo de Funcionário:'	,true,'SIGER.PKG_PUBLICO.SEL_TIPO_FUNCIONARIO',true,null,null,null,null,null,null,null,'SEQ_TIPO_FUNCIONARIO','DES_TIPO_FUNCIONARIO');
	$frm->addMaskField('cod_matricula'			,'Matrícula SIAPE:'		,true,'9999999999',false);
	$frm->addTextField('nom_unidade_ibama'		,'Lotação:'				,120,null,75)->setEnabled(false);
	$frm->addTextField('cod_unidade_ibama'		,''				,10,true,5,null,false)->setEnabled(false);
	$frm->addTextField('nom_unidade_exercicio'	,'Unidade Exercício:'	,120,null,75)->setEnabled(false);
	$frm->addTextField('cod_unidade_exercicio'	,''				,10,true,5,null,false)->setEnabled(false);
$frm->closeGroup();

$frm->addGroupField('gpSenha','Cadastrar/Alterar Senha');
	$frm->addHtmlField('aviso','Obs: <b>Deixe os campos abaixo em branco para manter a senha atual do funcionário.</b><br>');
	$frm->addPasswordField('des_senha'		,'Senha:',false,true,15);
	$frm->addPasswordField('des_senha2'		,'Redigite a senha:',false,false,15);

$frm->closeGroup();

$frm->setAction('Gravar,Novo');

// eventos dos campos
$frm->getField('seq_tipo_funcionario')->addEvent('onChange','seq_tipo_funcionarioChange()');
$frm->getField('nom_unidade_exercicio')->addEvent('onFocus','cod_unidade_ibama_callback()');

switch( $acao )
{
	case 'Novo':
		$frm->clearFields();
	break;
	//--------------------------------------------------------------
	case 'Gravar':
		// se nao for servidor, não precisa do cod_matricula
		if((integer)$frm->getValue('seq_tipo_funcionario')>1)
		{
			$frm->getField('cod_matricula')->setRequired(false);
			$frm->setValue('cod_matricula','');
		}
		if( $frm->validate() )
		{
			if((string)$frm->getValue('des_senha')<>'' && (string)$frm->getValue('des_senha') <> (string)$frm->getValue('des_senha2') )
			{
				$frm->setPopUpMessage('Senhas informadas estão diferentes.',null,'ERROR');
				break;
			}
			$bvars=$frm->createBvars('num_pessoa,num_cpf,cod_matricula,cod_unidade_ibama,cod_unidade_exercicio,des_senha,seq_tipo_funcionario');
			$erro = executarPacote('SIGER.PKG_PUBLICO.INC_ALT_FUNCIONARIO_IBAMA',$bvars,-1);
			if( ! $erro )
			{
				if((integer)$frm->getValue('num_pessoa')==0)
				{
					$frm->setValue('num_pessoa',$bvars['NUM_PESSOA']);
					$frm->setPopUpMessage('Inclusão realizada com sucesso!');
				}
				else
				{
					$frm->setPopUpMessage('Alteração realizada com sucesso!!!');
				}
				$frm->setValue('des_senha','');
				$frm->setValue('des_senha2','');
			}
			else
			{
				$frm->addError( $erro[0]);
			}
		}
	break;
	//------------------------------------------------------------------------
}

// configurar o formulario ao iniciar
$frm->addJavascript('init()');

// consulta on-line
$frm->setAutoComplete('num_cpf',ESQUEMA.'.PKG_SEGURANCA.SEL_DADOS_PESSOA','NUM_CPF','NUM_PESSOA,NOM_PESSOA,COD_UNIDADE_IBAMA,END_PESSOA,DES_BAIRRO,NUM_CEP,NUM_FONE,DES_EMAIL,NOM_MUNICIPIO,DAT_NASC,NOM_UNIDADE_IBAMA,COD_UNIDADE_EXERCICIO,NOM_UNIDADE_EXERCICIO,COD_UF,SIG_UF,COD_MATRICULA',false,null,null,14,400,2,-1,true);

$frm->setOnlineSearch('nom_unidade_ibama'
	,'SIGER.PKG_PUBLICO.SEL_UNIDADE_IBAMA'
	,'COD_UF|Uf:||||uf,NOM_UNIDADE_IBAMA|Nome:'
	,false,false,true
	,'NOM_UNIDADE_IBAMA|Unidade,SIG_UNIDADE_IBAMA|Sigla'
	,'COD_UNIDADE_IBAMA,NOM_UNIDADE_IBAMA'
	,'Unidade de Lotação'
	,null,null,null,null,null,null,'cod_unidade_ibama_callback()',100,null,null
	,'NOM_UNIDADE_IBAMA');
$frm->setOnlineSearch('nom_unidade_exercicio'
	,'SIGER.PKG_PUBLICO.SEL_UNIDADE_IBAMA'
	,'COD_UF|Uf:||||uf,NOM_UNIDADE_IBAMA|Nome:'
	,false,false,true
	,'NOM_UNIDADE_IBAMA|Unidade,SIG_UNIDADE_IBAMA|Sigla'
	,'COD_UNIDADE_IBAMA|cod_unidade_exercicio,NOM_UNIDADE_IBAMA|nom_unidade_exercicio'
	,'Unidade de Exercício'
	,null,null,null,null,null,null,null,100,null,null
	,'NOM_UNIDADE_IBAMA');
$frm->show();
?>

<script>
function init()
{
	seq_tipo_funcionarioChange();
}
function seq_tipo_funcionarioChange()
{
	if( jQuery('#seq_tipo_funcionario').val() == 1 )
	{
		fwGetObj('cod_matricula_area').style.display='inline';
	}
	else
	{
		fwGetObj('cod_matricula_area').style.display='none';
	}
}
function cod_unidade_ibama_callback()
{
	if(!jQuery('#cod_unidade_exercicio').val())
	{
		fwAtualizarCampos('nom_unidade_exercicio|cod_unidade_exercicio',fwGetObj('nom_unidade_ibama').value+'|'+fwGetObj('cod_unidade_ibama').value);
	}
}
</script>
