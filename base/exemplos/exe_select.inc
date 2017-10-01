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

$frm = new TForm('Campo Select',300);

$frm->addSelectField('sit_cancelado','Cancelado:',null,'0=Não,1=Sim');
$frm->addSelectField('seq_bioma'	,'Bioma:',true,'0=CERRADO,1=PANTANAL,2=MATA ATLÂNTICA',null,null,null,true,4);


$frm->setAction('Atualizar,Sair');

$frm->addSelectField('seq_moeda' ,'Moeda 1:',true,'TESTE.PKG_MOEDA.SEL_MOEDA',null,null,null,null,null,null,'-- moeda --')->setEnabled(false);
$frm->addSelectField('seq_moeda2','Moeda 2:',true,null,null,null,null,true,4,null,'<< Selecione a Moeda >>','');
$frm->addSelectField('seq_moeda3','Moeda 3:',false,null,null,null,null,false);

$frm->setOptionsSelect('seq_moeda2','TESTE.PKG_MOEDA.SEL_MOEDA','SIG_MOEDA',null,'SIG_MOEDA=R$');
$frm->setOptionsSelect('seq_moeda3','TESTE.PKG_MOEDA.SEL_MOEDA','SIG_MOEDA',null,'SIG_MOEDA=R$');

$frm->setAction('Atualizar,Sair');

// adicionar o evento ao campo
$frm->setFieldEvent('seq_moeda','onChange','selectAlterou()');
$frm->setFieldEvent('seq_moeda3','onChange','selectAlterou()');

// retirar o evento do campo
$frm->setFieldEvent('seq_moeda','onChange');


$frm->addButton('Validar','validar','btnValidar');
$frm->addButton('Testar Disabled',null,'btnTestar','btnTestarClick()');

if( $acao=='validar' )
{
	$frm->validate();
	
}
// exibir o formulário
$frm->show();
?>
<script>
function selectAlterou()
{
	alert('campod select foi alterado');
}
function btnTestarClick()
{
	
	//alert( fwGetObj('seq_moeda').value);
	//alert( document.getElementById('seq_moeda').value);
	
	fwAtualizarCampos('seq_moeda','14');
	//alert( fwGetObj('seq_moeda').value);
	//fwGetObj('seq_moeda_disabled').value = 14);

}
</script>
