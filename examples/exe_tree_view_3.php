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

$frm = new TForm('Estrutura Oragnizacional',400);
$frm->addTextField('cod_unidade','Código:',10);
$frm->addTextField('nom_unidade','Unidade:',60);
$frm->addTextField('url_unidade','Url:',60);
$frm->addTextField('sig_unidade','Sigla:',60);


$frm->addGroupField('gpTree','Exemplo Treeview')->setcloseble(true);

// simulando consulta ao banco de dados
$res=null;
$res['COD_UNIDADE_PAI'][] = null;
$res['COD_UNIDADE'][] = 1;
$res['NOM_UNIDADE'][] = 'Presidência';
$res['URL_UNIDADE'][] = 'www.presidencia_ibama.gov.br';
$res['SIG_UNIDADE'][] = 'PRESI';

$res['COD_UNIDADE_PAI'][] = 1;
$res['COD_UNIDADE'][] = 11;
$res['NOM_UNIDADE'][] = 'Dilretoria de Planejamento';
$res['URL_UNIDADE'][] = 'www.diplan_ibama.gov.br';
$res['SIG_UNIDADE'][] = 'DIPLAN';



$tree = $frm->addTreeField('tree',null,$res,'COD_UNIDADE_PAI','COD_UNIDADE','NOM_UNIDADE',null, array('SIG_UNIDADE','URL_UNIDADE') );
$tree->setStartExpanded(true);
$tree->setOnClick('treeClick'); // fefinir o evento que será chamado ao clicar no item da treeview
                                                                               
//$frm->setAction('Atualizar');
$frm->show();
?>
<script>
function treeClick(id)
{
	/*
	alert( 'Item id:'+treeJs.getSelectedItemId()+'\n'+
	'Item text:'+treeJs.getItemText(id )+'\n'+
	'User data URL:'+treeJs.getUserData(id,'URL_UNIDADE')
	);
	*/
	// atualizar os campos do formulário
	jQuery("#cod_unidade").val(treeJs.getSelectedItemId());
	jQuery("#nom_unidade").val(treeJs.getItemText(id ));
	jQuery("#url_unidade").val(treeJs.getUserData(id,'URL_UNIDADE'));
	jQuery("#sig_unidade").val(treeJs.getUserData(id,'SIG_UNIDADE'));
	
}
</script>
