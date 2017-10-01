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
Módulo de cadastro de perfis do projeto
Autor: Luis Eugênio Barbosa
*/
for ($i=1;$i<51;$i++)
{
	$aNiveisPerfil[$i]=$i;
}
// campos do formulario
$arrCampos['seq_projeto']			= new CampoOculto('seq_projeto',PROJETO);
$arrCampos['seq_perfil']			= new CampoOculto('seq_perfil','');
$arrCampos['operacao']				= new CampoHtml('operacao','');

$arrCampos['des_perfil']			= new CampoTexto('des_perfil','Nome do Perfil',true,'',null,40,40);
$arrCampos['num_nivel']				= new CampoSelect('num_nivel','Nível Hierarquico',true,1,$aNiveisPerfil);
$arrCampos['sit_publico']			= new CampoSelect('sit_publico','Público',true,'N',array('N'=>"Não","S"=>"Sim"),null,false);
$arrCampos['sit_cancelado']			= new CampoSelect('sit_cancelado','Cancelado',true,'N',array('N'=>"Não","S"=>"Sim"));
$arrCampos['gride_perfil']			= new CampoHtml('gride_perfil','');

// criar instancia do formulário dinâmico
$frm = new FormDin3($arrCampos,'CADASTRO DE PERFIL DE ACESSO',$_POST);
$frm->criarVariavel('modulo',PASTA_BASE.'seguranca/cad_perfil.inc');
$frm->setAltura(0);
$frm->setCampoFocoInicial('des_perfil');
$frm->botaoAcao[''] = array('Gravar','Novo');

if( (string) $_SESSION[APLICATIVO]['acao'] == '' ) 
{
   $_SESSION[APLICATIVO]['acao']=$formDinAcao;
}
// tratamento das acoes do formulario
switch($_SESSION[APLICATIVO]['acao']) {
	case 'Novo':
		$frm->limparCampos('seq_projeto',true);
	break;
	//---------------------------------------------------------------------------------
	case 'Gravar':
		// nivel hierarquico deve ser menor que o do usuario logado
		if((integer)$frm->get('num_nivel') >= $_SESSION[APLICATIVO]['login']['maior_nivel'])
		{
			$frm->msgerros[] = "Nível hierárquico deve ser menor que ".$_SESSION[APLICATIVO]['login']['maior_nivel'];
			break;

		}
		if( !$frm->validar() )
		{
			if(!$frm->msgerros = executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_PERFIL',$_POST,-1))
			{
				$frm->limparCampos('seq_projeto',true);
				$frm->mensagem='Gravação realizada com sucesso!!!';
			}
		}
	break;
	//---------------------------------------------------------------------------------
	case 'btngride_perfilExcluir':
			if(!$frm->msgerros = executarPacote(ESQUEMA.'.PKG_SEGURANCA.EXC_PERFIL',$_POST,-1))
			{
				$frm->limparCampos('seq_projeto',true);
				$frm->mensagem='Registro excluído com sucesso!!!';
			}
	break;
	//-----------------------------------------------------------------------------
	case 'btngride_perfilAlterar':
	case 'Alterar':
		$bvars = $frm->criarBvars('seq_perfil');
		if(!$frm->msgerros = recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_PERFIL_PROJETO',$bvars,$res,-1))
		{
			$frm->atualizarCampos($res);
		}

	break;
}
$bvars = array('SEQ_PROJETO'=>PROJETO
               ,'NUM_NIVEL'=>$_SESSION[APLICATIVO]['login']['maior_nivel']);
print_r(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_PERFIL_PROJETO',$bvars,$res));
// se for cadastro inicial, criar o botão para gerar os perfis padrão
if(count($res['SEQ_PERFIL'])==0)
{
$frm->botaoAcao[''][] = 'Gerar Perfis Padrão';
}
// criar o gride com os projetos cadastrados
$frm->set('gride_perfil','<br>'.criarGride('gride_perfil'
									,null
									,$res
									,null
									,null
									,'SEQ_PERFIL'
									,'DES_PERFIL|PERFIL,NUM_NIVEL|NÍVEL,CALC_SIT_PUBLICO|PÚBLICO,CALC_SIT_CANCELADO|CANCELADO'
									,null
									,null
									,null
									,null
									,null
									,null
									,null
									,'Nenhum perfil cadastrado'
									,null
									,'COR_FUNDO||$nl%2!=0|#efefef
									,ALINHAMENTO_TEXTO|||CENTER
									,ALINHAMENTO_TEXTO|DES_PERFIL||LEFT
									,COR_FONTE||$res["SIT_CANCELADO"][$k]=="S"|gray
									,LARGURA|DES_PERFIL||350'
									,null,null,false
									)
								);


//$frm->modoDepuracao=true;
// exibir o formulário
if((integer)$frm->get('seq_perfil')>0)
{
	$frm->set('operacao',STATUS_ALTERANDO);
	//	$frm->set('operacao','<center><blink>ALTERANDO</blink></center>');
}
else
	$frm->set('operacao',STATUS_INCLUINDO);
	//	$frm->set('operacao','<center>INCLUINDO</center>');

print $frm->criarForm($_SESSION[APLICATIVO]['acao'].$formDinAcao);
?>

