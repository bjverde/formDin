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
Módulo de cadastro de perfis de acesso do projeto
Autor: Luis Eugênio Barbosa
Data: 15/12/2009
*/
for ($i=1;$i<51;$i++)
{
	$aNiveisPerfil[$i]=$i;
}
$frm = new TForm('Cadastro de Perfil de Acesso',null,550);
// campos do formulario
$frm->addHiddenField('seq_projeto',PROJETO);
$frm->addHiddenField('seq_perfil','');

$frm->addTextField('des_perfil'		, 'Nome do Perfil',50,true);
$frm->addSelectField('num_nivel'	, 'Nível Hierarquico',true,$aNiveisPerfil);
$frm->addSelectField('sit_publico'	,'Público',true,array('N'=>"Não","S"=>"Sim"));
$frm->addSelectField('sit_cancelado','Cancelado',true,array('N'=>"Não","S"=>"Sim"));
$frm->addHtmlGride('gride'			,'base/seguranca/gride_perfil.php','gd')->setCss('width',500);

$frm->setAction('Gravar,Novo');

// tratamento das acoes do formulario
switch($acao )
{
	case 'Novo':
		$frm->clearFields();
	break;
	//---------------------------------------------------------------------------------
	case 'Gravar':
		if( $frm->validate() )
		{
			$bvars = $frm->createBvars('seq_perfil,seq_projeto,des_perfil,num_nivel,sit_publico,sit_cancelado');
			if(!$frm->addError(executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_PERFIL',$bvars,-1) ) )
			{
				$frm->clearFields();
			}
		}
	break;
	//---------------------------------------------------------------------------------
	case 'gd_excluir':
		$bvars = $frm->createBvars('seq_perfil');
		if(!$frm->addError(executarPacote(ESQUEMA.'.PKG_SEGURANCA.EXC_PERFIL',$bvars,-1) ) )
		{
			$frm->clearFields();
		}
	break;
	//-----------------------------------------------------------------------------
	case 'gd_alterar':
		$bvars = $frm->createBvars('seq_perfil');
		if(!$frm->addError(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_PERFIL_PROJETO',$bvars,$res,-1) ) )
		{
			$frm->update($res);
		}

	break;
}
$frm->setValue('seq_projeto',PROJETO);
$frm->show();
?>
