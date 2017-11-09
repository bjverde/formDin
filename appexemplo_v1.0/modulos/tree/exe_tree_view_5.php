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

$frm = new TForm('Estados e Municípios com Método setXmlFile()',500);

// ler os Estados cadastrados
$ufs = TPDOConnection::executeSql("select 'uf'||cod_uf as cod_uf,nom_uf||'/'||sig_uf as nom_uf from tb_uf order by nom_uf");

// criar campo select para filtrar o Estado
$frm->addSelectField('cod_uf','Estado:',false,$ufs,null,null,null,null,null,null,'-- Todos --')->addEvent('onchange','submit()');

// adicionar grupo
$frm->addGroupField('gpTree','Exemplo Treeview com Fonte de Dados Definido pelo Usuário')->setcloseble(true);
    // adicionar o campo Treeview ao formulário
	$tree = $frm->addTreeField('tree','Região/Extados/Municípios','vw_tree_regiao_uf_mun','ID_PAI','ID','NOME',null,null,320);
 	// configurar a treeview	
	$tree->addFormSearchFields('cod_uf'); // informar a tree para utilizar o campo cod_uf do form como parte do filtro
	$tree->setStartExpanded(true);  // iniciar aberta
	$tree->setTheme('winstyle'); // estilo das imagens
	$tree->setXmlFile('includes/carregar_treeview.php'); 	// definir a fonte de dados ( xml ) que alimentará a treview
$frm->closeGroup();  // fim do grupo

// exibir o formulário
$frm->show();
?>