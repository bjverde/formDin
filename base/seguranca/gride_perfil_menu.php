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

// ler as opções de menu que o perfil seleciona possui para marcar no gride
if(!isset($_REQUEST['seq_perfil']))
{
	return null;
}
$bvars = null;
// selecionar os itens ja selecionados para marcar no gride
$bvars['SEQ_PERFIL']	= $_REQUEST['seq_perfil'];
recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_MENU_PERFIL',$bvars,$res,-1);
$_POST['seq_menu'] = $res['SEQ_MENU'];
$gride = new TGrid('gd'
	,'Opções do Menu Principal'
	,ESQUEMA.'.PKG_SEGURANCA.SEL_MENU_PROJETO'
	,null
	,null
	,'SEQ_MENU'
	,'SEQ_MENU',null,null,'onDrawGrideCell');
//$gride->addColumn('des_rotulo_identado','Rotulo',1200,'left');
$gride->addCheckColumn('seq_menu','','SEQ_MENU','DES_ROTULO_IDENTADO');
$gride->setCache(-1);
$gride->enableDefaultButtons(false);
$gride->setBvars(array('SEQ_PROJETO'=>PROJETO));
$gride->show();
//------------------------------------------------------------------------------
function onDrawGrideCell($rowNum,$cell,$column,$data,$edit)
{
	// alterar a cor de fundo dos itens marcados
	if(is_object($edit) && $edit->getProperty('checked'))
	{
		$cell->setCss('background-color','#FFFFDB');
	}
}

?>

