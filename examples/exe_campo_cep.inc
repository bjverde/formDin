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

// chamada ajax
if(isset($_POST['num_cep'])){
	header("Content-Type:text/xml");
	echo file_get_contents('http://www.buscarcep.com.br/?cep='.$_POST['num_cep'].'&formato=xml');
	exit;
}
$frm = new TForm('Exemplo Campo CEP',300,600);
// define a largura das colunas verticais do formulario para alinhamento dos campos
$frm->setColumns(array(100,100));
$fldCep = $frm->addCepField('num_cep1','Cep:',null,'71505030');
$fldCep = $frm->addCepField('num_cep2','Cep:',true,null,null,'des_endereco','nom_bairro','nom_cidade','cod_uf',null,null,null,null,null);
$frm->addTextField('des_endereco','Endereço:',60);
$frm->addTextField('num_endereco','Número:',10);
$frm->addTextField('des_complemento','Complemento:',60);
$frm->addTextField('nom_bairro','Bairro:',60);
$frm->addTextField('nom_cidade','Cidade:',60);
$frm->addTextField('cod_municipio','Cod. Município:',10);
$frm->addSelectField('cod_uf','Uf:',2);
$frm->addTextField('sig_uf','Uf:',2);
$frm->setValue('num_cep','71505030');
//$fldCep->addEvent('onblur','getCepJquery("num_cep","des_endereco","nom_bairro","nom_cidade","cod_uf","num_endereco","sig_uf","des_complemento","cod_municipio")');
//$fldCep->addEvent('onblur','getCepJquery("num_cep",{"logradouro":"des_endereco","bairro":"nom_bairro"})');

$frm->show();
?>
