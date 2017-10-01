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

$frm = new TForm('Exemplo Documentação On-line');
$frm->addHiddenField('oculto');
//$frm->enableOnlineDoc(false,400,600,'des_bairro','data,sit_cancelado'); // false = permitir edição. Tela com 200px de altura por 600px de largura
$frm->enableOnlineDoc(false,400,600,'nom_pessoa,des_endereco'); // false = permitir edição. Tela com 200px de altura por 600px de largura
$pc = $frm->addPageControl('pc');
$pc->addPage('Cadastro',true,true);
$frm->addTextField('nom_pessoa','Nome da pessoa:',50,true,50,null,true,'Este é um campo texto','Ex:João',false);
$frm->addTextField('des_endereco','Enderço:',50,false,50,null,true,null,null,false);
$frm->addTextField('des_bairro','Bairro:',50,false,50,null,true,null,null,true);
$frm->addMemoField('obs','Observação:',200,false,80,5,null,true,true);
$frm->addDateField('data','Data:',true);
$frm->addSelectField('sit_cancelado','Cancelado ?',true,'S=Sim,N=Não');
$frm->setAction('Gravar');
$frm->show();
?>
