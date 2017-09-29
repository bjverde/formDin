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
Módulo de definição de acesso do perfil
Autor: Luis Eugênio Barbosa
Data: 16/12/2009
*/
$frm = new TForm('Definir o Acesso do Perfil',550,600);
$frm->addHiddenField('seq_projeto',PROJETO);
$frm->addHiddenField('seq_perfil_menu');

$frm->addSelectField('seq_perfil','Perfil',true,null,null)->addEvent('onChange','seq_perfil_change()');
$frm->addHtmlField('gride');

$frm->setAction('Gravar');
// preencher campo select com os perfis abaixo do que o do usuário logado

// preencher campo select com os perfis
$bvars=array('SEQ_PROJETO'=>PROJETO
            ,'SIT_CANCELADO'=>'N'
            ,'NUM_NIVEL'=>$_SESSION[APLICATIVO]['login']['maior_nivel']);
print_r(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_PERFIL_PROJETO',$bvars,$res));
$frm->setOptionsSelect('seq_perfil',$res,'DES_PERFIL','SEQ_PERFIL');

// tratamento das acoes do formulario
switch($acao)
{
	//---------------------------------------------------------------------------------
	case 'Gravar':
		$bvars=$frm->createBvars('seq_perfil');
		
		// cancelar todos os diretos do perfil primeiro
		if( $frm->addError(executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_PERMISSAO_INDIVIDUAL',$bvars) ) )
		{
			break;
		}
		foreach($_POST['seq_menu'] as $k=>$v)
		{
			$bvars=$frm->createBvars('seq_perfil');
			$bvars['SEQ_MENU']=$v;
			if( $frm->addError(executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_PERMISSAO_INDIVIDUAL',$bvars) ) )
			{
				$frm->mensagem = null;
				break;
			}
		}
		// gravar no histórico e depois excluir os registrs da tabela perfil_menu
		$bvars				= $frm->createBvars('seq_perfil');
		$bvars['SEQ_MENU'] 	= -1;
		if( $frm->addError(executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_PERMISSAO_INDIVIDUAL',$bvars ) ) )
		{
			$frm->mensagem = null;
			break;
		}
		$frm->setPopUpMessage('Dados gravados com sucesso!');
}

$frm->addJavascript('seq_perfil_change()');
$frm->show();
?>
<script>
function seq_perfil_change()
{
	jQuery("#gride").html('<center>Carregando...<br>'+fw_img_processando2+'<center>');
	jQuery("#gride").load(app_url+app_index_file,{"ajax":1,"seq_perfil":jQuery("#seq_perfil").val(),"modulo":"base/seguranca/gride_perfil_menu.php"} );
}
</script>

