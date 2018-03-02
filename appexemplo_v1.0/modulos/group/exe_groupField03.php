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

  $frm = new TForm('Exemplo de Campo Grupo');
  $frm->addTextField('nome','Campo nome comprido com wordwrap true:',30,null,null,null,null,null,null,null,true);

  $frm->addGroupField('gp00','Grupo Teste I',80,null,null,null,false,'gx',true,null,null,null,true);
	  //$frm->addTextField('nome2','Campo nome comprido com wordwrap true:',30,null,null,null,null,null,null,null,true);
	  $frm->addCheckField('gravar','Marque aqui para não gravar este grupo:',null,null,false,false,null,1,null,null,null,true);
	  $frm->addTextField('nome3','Endereço:',30);
	  $frm->addTextField('nome4','Bairro:',40);
	  $frm->addTextField('nome5','Cep:',50);
  $frm->closeGroup();


  $frm->addGroupField('gp01','Grupo Teste II',null,null,null,true,true,'gx',true)->setCss('background-color','red');
  	$frm->addHtmlField('html_1','<b>Campo grupo SEM quebra na coluna do rótulo</b>');
  	$frm->addTextField('txt_nome','Nome completo da pessoa física:',60);
  $frm->closeGroup();
  $frm->addGroupField('gp02','Grupo Teste III',null,null,null,null,true,'gx')->setCss('background-color','white');
  	$frm->addHtmlField('html_2','<b>Campo grupo com fundo branco e COM quebra na coluna do rótulo</b>');
  	$frm->addTextField('txt_nome','Nome completo da pessoa física:',60);
  $frm->closeGroup();

  $frm->setAction('Gravar,Refresh');
  $frm->addButton('Confirmar',null,'btnConfirmar','fwConfirm("Tem certeza ?","confirmOk(1)","confirmOk(0)")');
  $frm->show();
?>
