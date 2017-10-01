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
Módulo de cadastro do menu principal do projeto
Autor: Luis Eugênio Barbosa
Data Inicio: 03-12-2009
*/
$frm = new TForm('Cadastro do Menu Principal da Aplicação',500);
$frm->addHiddenField('seq_projeto',PROJETO);
$frm->addHiddenField('seq_menu');
$frm->addHiddenField('sit_sistema');
//$frm->addHiddenField('des_rotulo');
//--------------------------------------------------------------------------------
$pc = $frm->addPageControl('pc',null,null,'pcClick');
$abaCadastro = $pc->addPage('Cadastro',true,true,'abaCadastro');
	$frm->addSelectField('seq_menu_pai'			,'Item Pai:',false);
	$frm->addTextField('des_rotulo'				,'Rótulo:',40,false);
	$frm->addSelectField('seq_modulo'			,'Módulo Executar:',false,null);
	$frm->addNumberField('num_ordem'			,'Ordem:',3,false,0);
	$frm->addSelectField('sit_separador'		,'Item Separador:',true,'N=Não,S=Sim');
	$frm->addSelectField('sit_cancelado'		,'Cancelado:',true,'N=Não,S=Sim');
	$frm->addTextField('des_grupo'				,'Grupo:',20,false,null,null);
	$frm->addTextField('des_hint'				,'Texto Ajuda:',500,false,30);
	$frm->addTextField('nom_gif'				,'Imagem Gif:',100,false,30,null);
	//$frm->addHtmlGride('gride2'					,'base/seguranca/gride_menu.php');
$pc->addPage('Gride',false,true,'abaGride');
	$frm->addHtmlField('gride');

// definir os botões de ação do formulário
$frm->setAction('Gravar,Novo');
$frm->getField('seq_modulo')->addEvent('onChange','jQuery("#des_rotulo").val(jQuery("#seq_modulo option:selected").text() );');
//$frm->addButton('Atualizar',null,'btnAtualizar','btnAtualizarClick()');
// tratamento das acoes do formulario
switch($acao)
{
	case 'Novo':
		$frm->clearFields(null,'seq_projeto');
		$pc->setActivePage('abaCadastro',true);
	break;
	//---------------------------------------------------------------------------------
	case 'Gravar':
		// item do menu principal não pode ter mais de 25 caracteres
		if((integer)$frm->getValue('seq_menu_pai')==0 && strlen($frm->getValue('des_rotulo'))>40)
		{
			$frm->setMessage('Item do menu principal não pode ter mais de 40 caracteres!!');
			break;
		}
		if( $frm->validate() )
		{
			$bvars = $frm->createBvars('seq_menu,seq_menu_pai,seq_modulo,num_ordem,seq_projeto,des_rotulo,des_hint,nom_gif,sit_separador,sit_cancelado,sit_sistema,des_grupo');
			if(!$frm->addError(executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_MENU',$bvars,-1)))
			{
				$frm->clearFields(null,'seq_projeto,seq_menu_pai');
			}
		}
	break;
	//---------------------------------------------------------------------------------
	case 'gd_excluir':
			$bvars = $frm->createBvars('seq_menu');
			if(!$erro = executarPacote(ESQUEMA.'.PKG_SEGURANCA.EXC_MENU',$bvars,-1))
			{
				$frm->clearFields(null,'seq_projeto,seq_menu_pai');
			}
			$frm->addJavascript("pcClick(null,null,'abagride')");
	break;
	//-----------------------------------------------------------------------------
	case 'gd_alterar':
		$bvars = $frm->createBvars('seq_menu');
		if(!$frm->addError(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_MENU',$bvars,$res,-1) ) )
		{
			$frm->update($res);
		}
		$pc->setActivePage('abaCadastro',true);
	break;
}
// refazer o menu para dar um preview de como está ficando

if( $acao && $acao != 'gd_alterar')
{
	$frm->addJavascript("top.app_build_menu(true,null,'base/seguranca/ler_menu_xml.php')");
}

// preencher combo modulos
$bvars=array('SEQ_PROJETO'=>PROJETO,'SIT_SISTEMA'=>'N');
$GLOBALS['conexao']->limparCache(ESQUEMA.'.PKG_SEGURANCA.SEL_MODULO');
print_r( recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_MODULO',$bvars,$res,-1) );
$frm->setOptionsSelect('seq_modulo',$res,'DES_TITULO','SEQ_MODULO');

// preencher combo itens pai
$bvars=array('SEQ_PROJETO'=>PROJETO);
$GLOBALS['conexao']->limparCache(ESQUEMA.'.PKG_SEGURANCA.SEL_MENU_PROJETO');
print_r( recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_MENU_PROJETO',$bvars,$res,-1) );
$frm->setOptionsSelect('seq_menu_pai',$res,'DES_ROTULO_IDENTADO','SEQ_MENU');
$frm->show();
?>
<script>
function pcClick(rotuloAba,pageControl,idAba)
{
	//if( idAba =='abagride' && !trim(jQuery("#gride").html()))
	if( idAba =='abagride' )
	{
		jQuery("#gride").html('<center>Carregando...<br>'+fw_img_processando2+'</center><br><br>');
		jQuery("#gride").load(app_url+app_index_file,{"ajax":1,"modulo":"base/seguranca/gride_menu.php"} );
	}
	return true;
}
</script>
