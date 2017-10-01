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

// url para testar o retorno do xml
//http://10.1.4.65/~45427380191/appbase/index.php?modulo=base/seguranca/ler_menu_xml.php&content-type=xml
//error_reporting(E_ALL);

/*
// testar conexão
http://10.1.4.65/~45427380191/appbase/index.php?modulo=base/seguranca/ler_menu_xml.php
$bvars=array("SEQ_PROJETO"=> PROJETO,'NUM_PESSOA'=>$_SESSION[APLICATIVO]['login']['num_pessoa']);
$res=null;
print_r($bvars);
print_r(recuperarPacote(ESQUEMA.".PKG_SEGURANCA.SEL_MENU_PESSOA",$bvars,$res,-1));
print_r($res);
die('fim');
*/

$menu = new TMenuDhtmlx(null,false);
//if( isset($GLOBALS['conexao'] ) && $GLOBALS['conexao'] )
{
	if(	! defined('PROJETO') )
	{
		ob_clean();
		echo '<menu>
				<item id="erro" text="Erro '.date('h:i:s').'">
					<item id="erro1" text="Constante PROJETO não definida."/>
				</item>
			</menu>';
		return;
	}
	if(	! defined('APLICATIVO') )
	{
		ob_clean();
		echo '<menu>
				<item id="erro" text="Erro '.date('h:i:s').'">
					<item id="erro1" text="Constante APLICATIVO não definida."/>
				</item>
			</menu>';
		return;
	}

	if( !isset($_SESSION[APLICATIVO]['login']['num_pessoa']) )
	{
		$_SESSION[APLICATIVO]['login']['num_pessoa'] = 0;
		ob_clean();
		echo '<menu>
			<item id="erro" text="Erro '.date('h:i:s').'">
				<item id="erro1" text="NUM_PESSOA não encontrado na sessão. Efetue login novamente."/>
			</item>
		</menu>';
		return;
	}
	$bvars=array("SEQ_PROJETO"=> PROJETO,'NUM_PESSOA'=>$_SESSION[APLICATIVO]['login']['num_pessoa']);
	$res=null;
	if($erro = recuperarPacote(ESQUEMA.".PKG_SEGURANCA.SEL_MENU_PESSOA",$bvars,$res,-1))
	{
		ob_clean();
        print_r($erro);
        print 'PROJETO='.PROJETO.'<BR>';
        print 'ESQUEMA='.ESQUEMA.'<BR>';
        PRINT 'APLICATIVO='.APLICATIVO.'<BR>';;
        PRINT 'NUM_PESSOA='.$_SESSION[APLICATIVO]['login']['num_pessoa'].'<BR>';
        print '<hr>';
        print_r($_SESSION);
        die();
		//<item id="x" text=Esquema:"'.ESQUEMA.' Projeto:'.PROJETO.' Erro:'.$erro[0].'"></item>
		echo '<menu>
		</menu>';
		return;
	}
	/*
	print 	'<menu>
				<item id="1" text="'.PROJETO.'"/>
				<item id="2" text="'.ESQUEMA.'"/>
				<item id="3" text="erro:'.$erro[0].'"/>
				<item id="4" text="erro:'.print_r($erro,true).'"/>
				<item id="5" text="erro:'.$buff.'"/>
				<item id="5" text="$RES='.$res['DES_ROTULO'][0].'"/>
			</menu>';
	return;
	*/
	if($res)
	{
		foreach($res['SEQ_MENU'] as $k=>$v)
		{
			$menu->add($res['SEQ_MENU'][$k]
			,$res['SEQ_MENU_PAI'][$k]
			,$res['DES_ROTULO'][$k]
			,$res['NOM_FISICO'][$k]
			,$res['DES_HINT'][$k]
			,$res['NOM_GIF'][$k]
			,null
			,null
			,null
			,$res['SIT_SEPARADOR'][$k]==='S');
		}
	}
}

/*
if( ($_SESSION[APLICATIVO]['login']['num_cpf'] = '45427380191' ) ||
	( ( defined('MENU_FASIS') && MENU_FASIS ) &&
		( defined('BANCO_TNS') && BANCO_TNS=='DESENV' ) &&
		( isset($_SESSION[APLICATIVO]['login']['num_cpf'] ) && preg_replace('/[^0-9]/','',$_SESSION[APLICATIVO]['login']['num_cpf']) != '66677788830' ) )  )
{
*/
if( ( preg_replace('/[^0-9]/','',$_SESSION[APLICATIVO]['login']['num_cpf'] == '45427380191' )) ||
	(
 		( defined('MENU_FASIS') && MENU_FASIS == '1' ) &&
		( isset($_SESSION[APLICATIVO]['login']['num_cpf'] ) && preg_replace('/[^0-9]/','',$_SESSION[APLICATIVO]['login']['num_cpf']) != '66677788830' )
   	))
   	{
	$menu->add(-9,0,'Limpar Cache ','app_server_action("limparCache",false,"script");','Remover dados offline dos pacotes','lixeira.gif');
	$menu->add(-10,0,'F A S I S',null,'Você é um desenvolvedor','editar.gif');
	$menu->add(-100,-10,'Cadastro de Módulo','base/seguranca/cad_modulo.php');
	$menu->add(-101,-10,'Cadastro do Menu Principal','base/seguranca/cad_menu_principal.php');
	$menu->add(-102,-10,'Cadastro de Perfil','base/seguranca/cad_perfil.php');
	$menu->add(-103,-10,'Cadastro de Perfil Acesso','base/seguranca/cad_perfil_menu.php');

	if( isset($_SESSION[APLICATIVO]['login']['num_cpf'])&& $_SESSION[APLICATIVO]['login']['num_cpf'] !='')
	{
		$menu->add(-104,-10,'Alterar Senha','base/seguranca/alt_senha_oracle.php');
	}

   //	$menu->add(-10,0,'Exemplos','base/exemplos/index.php','Exemplo de Recursos do Formulário Dinâmico IV','ajudaonline.gif');
   	$menu->add(-20,0,'Exemplos',null,'Exemplo de Recursos do Formulário Dinâmico IV','ajudaonline.gif');
	$menu->add(-260,-20,'Grides');
	$menu->add(-26001,-260	,'Criação de Gride','base/exemplos/exe_gride.inc');
	$menu->add(-26002,-260	,'Grid Off-Line - Formdin3','base/exemplos/exe_gride_off_line.inc');
	$menu->add(-26003,-260	,'Grid Off-Line - FormDin4','base/exemplos/exe_gride_off_line_novo.inc');
	$menu->add(-26004,-260	,'Grid Com Coluna Checkbox','base/exemplos/exe_gride_checkbox.inc');
	$menu->add(-26005,-260	,'Grid com Arquivos Anexados ( ajax )','base/exemplos/exe_gride_anexo.inc');

	$menu->add(-270,-20,'Outros');
	$menu->add(-27001,-270,'Banco Textual DBM (db4)','base/exemplos/exe_db4.inc');
	$menu->add(-27002,-270,'Cadastro on-line (CRUD)','base/exemplos/exe_crud_online.inc');
	$menu->add(-27003,-270,'Documentação on-line','base/exemplos/exe_documentacao_online.inc');
	$menu->add(-27004,-270,'Select Combinado','base/exemplos/exe_select_combinado.inc');
	$menu->add(-27005,-270,'Select Combinado F3','base/exemplos/exe_select_combinado_f3.inc');
	$menu->add(-27006,-270,'Select Combinado Ajax','base/exemplos/exe_select_combinado_ajax.php');
	$menu->add(-27009,-270,'FormDin 3','base/exemplos/exe_formDin3.inc');
	$menu->add(-27010,-270,'PDF','base/exemplos/exe_pdf.inc');
	$menu->add(-27011,-270,'HINT','base/exemplos/exe_hint.inc');
	//$menu->add(-27012,-270,'TreeView Taxonomia','base/exemplos/exe_tree_view.inc');
	$menu->add(-27012,-270,'TreeView Unidade Ibama','base/exemplos/exe_tree_view_unid_ibama.inc');
	$menu->add(-27013,-270,'TreeView Unidade Ibama On Line','base/exemplos/exe_tree_view_on_line.php');
	$menu->add(-27014,-270,'Campo Select Ajax','base/exemplos/exe_fill_select_ajax.inc');
	$menu->add(-27015,-270,'Redirect','base/exemplos/exe_redirect.inc');
	$menu->add(-27016,-270,'Javascript/Css Externos','base/exemplos/exe_javascript_externo.inc');
	$menu->add(-27017,-270,'Definir Colunas no Formulário','base/exemplos/exe_colunas.inc');
	$menu->add(-27018,-270,'Tela de Confirmação','base/exemplos/exe_confirm_dialog.php');
	// parametros da janela
	$params = array('width'=>800,'height'=>500,'resizeble'=>true,'confirmClose'=>false,'modal'=>true);
	$menu->add(-27019,-270,'Site da Google','http://www.google.com','Site do Google',null,null,null,null,null,json_encode($params));

	$menu->add(-27019,-270,'Postgres Lob','base/exemplos/exe_postgres.php');
	$menu->add(-27020,-270,'Exemplo de Mensagens','base/exemplos/exe_mensagem.php');

	$menu->add(-2001,-20,'Criação de Abas','base/exemplos/exe_aba.inc');
	$menu->add(-2002,-20,'Campo/Gride com Autocompletar','base/exemplos/exe_autocompletar.inc');
	$menu->add(-2003,-20,'Campo Checkbox','base/exemplos/exe_checkbox.inc');
	$menu->add(-2004,-20,'Campo com Consulta On-line','base/exemplos/exe_onlinesearch.inc');
	$menu->add(-2005,-20,'Campo Texto e Tag','base/exemplos/exe_campo_texto.inc');
	$menu->add(-2006,-20,'Campo Select','base/exemplos/exe_select.inc');
	$menu->add(-2007,-20,'Campo Cep','base/exemplos/exe_campo_cep.inc');
	$menu->add(-2008,-20,'Campo Link','base/exemplos/exe_campo_link.inc');
	$menu->add(-2009,-20,'Campo Hora','base/exemplos/exe_campo_hora.inc');
	$menu->add(-2010,-20,'Campo Cor','base/exemplos/exe_campo_cor.inc');
	$menu->add(-2011,-20,'Campo Memo / Editor HTML','base/exemplos/exe_campo_memo.inc');
	$menu->add(-2012,-20,'Campo Coordenada Geográfica','base/exemplos/exe_campo_coordGMS.inc');
	$menu->add(-2013,-20,'Campo Número','base/exemplos/exe_campo_numero.inc');
	$menu->add(-2014,-20,'Campo Ajuda (facebox)','base/exemplos/exe_campo_ajuda.inc');
	$menu->add(-2015,-20,'Campo Grupo','base/exemplos/exe_campo_grupo.inc');
	$menu->add(-2016,-20,'Campo Telefone','base/exemplos/exe_telefone.inc');
	$menu->add(-2017,-20,'Campo Arquivo','base/exemplos/exe_campo_arquivo.inc');
	$menu->add(-2018,-20,'Cad Funcionario F3','base/seguranca/cad_funcionario.inc');
	$menu->add(-2019,-20,'Campo Autocompletar'	,'base/exemplos/exe_autocomplete.php');
	$menu->add(-2099,-20,'Testes Laboratório','base/exemplos/exe_teste.inc');

	}


$menu->getXml();
?>
