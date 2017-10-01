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

/*
Sistema FASIS
Módulo de alteração de senha oracle
Autor: Luis Eugênio Barbosa
*/
// campos do formulario
$arrCampos['num_cpf']				= new Campocpf('num_cpf','C.P.F.:',false,null,null,false);
$arrCampos['nom_pessoa']			= new CampoTexto('nom_pessoa','-',false,null,null,100,80);
$arrCampos['des_senha_atual']		= new CampoSenha('des_senha_atual','Senha Atual:',true,'',null,20,20);
$arrCampos['separacao']				= new CampoHtml('separacao','<hr>');
$arrCampos['des_senha']				= new CampoSenha('des_senha','Nova Senha',true,'',null,20,20);
$arrCampos['des_senha2']			= new CampoSenha('des_senha2','Redigite a Nova Senha',true,'',null,20,20);

// criar instancia do formulário dinâmico
$frm = new FormDin3($arrCampos,'ALTERAÇÃO DE SENHA',$_POST);
$frm->criarVariavel('modulo',PASTA_BASE.'/seguranca/alt_senha_oracle.inc');
$frm->setAltura(0);
$frm->setCampoFocoInicial('des_senha_atual');
$frm->botaoAcao[''] = array('Gravar');


$frm->set('num_cpf',$_SESSION[APLICATIVO]['login']['num_cpf']);
$frm->set('nom_pessoa',$_SESSION[APLICATIVO]['login']['nom_pessoa']);
$frm->protegerCampos('num_cpf,nom_pessoa');

if( (string) $_SESSION[APLICATIVO]['acao'] == '' ) 
{
   $_SESSION[APLICATIVO]['acao']=$formDinAcao;
}
// tratamento das acoes do formulario
switch($_SESSION[APLICATIVO]['acao']) {
	//---------------------------------------------------------------------------------
	case 'Gravar':
		if( !$frm->validar() )
		{
			if((string)$frm->get('des_senha') <> (string)$frm->get('des_senha2'))
			{
				$frm->msgerros[]='Senhas não conferem!';
				break;
			}
			// validar senha atual
			if( @$conn=oci_connect($frm->get("num_cpf"),$frm->get("des_senha_atual"),BANCO_TNS))
			{
				ocilogoff($conn);
				$bvars = $frm->criarBvars('num_cpf,des_senha');
				if(!$frm->msgerros = executarPacote(ESQUEMA.'.PKG_SEGURANCA.ALT_SENHA_ORACLE',$bvars,-1))
				{
					$frm->mensagem='Senha Alterada com Sucesso!!';
					$frm->limparCampos('num_cpf,nom_pessoa');
				}
			}
			else
			{
				$frm->mensagem = "Erro na validação da senha atual'";
				$erro = oci_error();
				if($erro["code"]==1017)
				{
					$frm->mensagem = "Senha Atual Inválida.";
				}
				else if($erro["code"]==28000)
				{
					$frm->mensagem = "Usuário(a) está bloqueado(a)";
				}
			}
		}
	break;
}
print $frm->criarForm($_SESSION[APLICATIVO]['acao'].$formDinAcao);
?>

