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
// http://localhost/fontes/sistemas/sisteste/aplicacao.php?admin&modulo=base/seguranca/ler_menu_xml.php&content-type=xml
error_reporting(0);
if(	! defined('PROJETO') )
{
	echo '<menu>
			<item id="erro" text="Erro '.date('h:i:s').'">
				<item id="erro1" text="Constante PROJETO não definida."/>
			</item>
		</menu>';
	return;
}
if(	! defined('APLICATIVO') )
{
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
	echo '<menu>
		<item id="erro" text="Erro '.date('h:i:s').'">
			<item id="erro1" text="Num_pessoa não encontrado. Efetue login novamente."/>
		</item>
	</menu>';
	return;
}
$bvars=array("SEQ_PROJETO"=> PROJETO,'NUM_PESSOA'=>$_SESSION[APLICATIVO]['login']['num_pessoa']);
$res=null;
//ob_start();
if($erro = recuperarPacote(ESQUEMA.".PKG_SEGURANCA.SEL_MENU_PROJETO",$bvars,$res,-1))
{
	//<item id="x" text=Esquema:"'.ESQUEMA.' Projeto:'.PROJETO.' Erro:'.$erro[0].'"></item>
	echo '<menu>
	</menu>';
	return;
}
//$buff = ob_get_contents();
//ob_clean();
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
	$menu = new TMenuDhtmlx(null,false);
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
	//if( isset($_SESSION[APLICATIVO]['DESENVOLVIMENTO']) && $_SESSION[APLICATIVO]['DESENVOLVIMENTO'] == true )
	if( defined('MENU_FASIS') && MENU_FASIS )
	{
		$menu->add(-10,0,'F A S I S',null,'Você é um desenvolvedor','editar.gif');
		$menu->add(-100,-10,'Módulo','base/seguranca/cad_modulo.php');
		$menu->add(-101,-10,'Menu Principal','base/seguranca/cad_menu_principal.php');
		$menu->add(-102,-10,'Perfil','base/seguranca/cad_perfil.php');
		$menu->add(-103,-10,'Perfil Acesso','base/seguranca/cad_perfil_menu.php');
		if( isset($_SESSION[APLICATIVO]['login']['num_cpf'])&& $_SESSION[APLICATIVO]['login']['num_cpf'] !='')
		{
			$menu->add(-104,-10,'Alterar Senha','base/seguranca/alt_senha_oracle.php');
		}
		$menu->add(-20,0,'Exemplos',null,'Exemplo de Recursos do Formulário Dinâmico IV','ajudaonline.gif');
		$menu->add(-200,-20,'Criação de Abas','exemplo/exe_aba.inc');
		$menu->add(-210,-20,'Campo com Autocompletar','exemplo/exe_autocompletar.inc');
		$menu->add(-220,-20,'Campo Checkbox','exemplo/exe_checkbox.inc');
		$menu->add(-230,-20,'Criação de Gride','exemplo/exe_gride.inc');
		$menu->add(-240,-20,'Campo com Consulta On-line','exemplo/exe_onlinesearch.inc');
		$menu->add(-245,-20,'Campo Texto','exemplo/exe_campo_texto.inc');
		$menu->add(-250,-20,'Campo Select','exemplo/exe_select.inc');
		$menu->add(-290,-20,'Consulta XAJAX','exemplo/exe_xajax.inc');
		$menu->add(-291,-20,'Redirect','exemplo/exe_redirect.inc');
		$menu->add(-292,-20,'Campo Hora','exemplo/exe_campo_hora.inc');

		$menu->add(-295,-20,'Javascript/Css Externos','exemplo/exe_javascript_externo.inc');
	}
	//$menu->getXml();
}
else
{
	echo '<menu>';
	echo '</menu>';
	return;
}
$menu->getXml();
?>
