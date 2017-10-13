<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
 * Criado por Luís Eugênio Barbosa
 * Essa versão é um Fork https://github.com/bjverde/formDin
 *
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
 * Este programa é distribuí1do na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licen?a Pública Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

// chamada ajax


/***
* Observação o campo addCepField 
* Chama FormDin4.js getCepJquery que chama getCep.php 
* que utiliza o serviço buscarcep.com.br 
*
* Esse serviço é pago em 13-10-2017 estava disponivel a consulta gratuida via xml
**/


if(isset($_POST['num_cep'])){
	header("Content-Type:text/xml");
	echo file_get_contents('http://buscarcep.com.br/?cep='.$_POST['num_cep'].'&formato=xml&chave=Chave_Gratuita_BuscarCep&identificador=CLIENTE1');
	exit;
}
$frm = new TForm('Exemplo Campo CEP',400,600);
// define a largura das colunas verticais do formulario para alinhamento dos campos
$frm->setColumns(array(100,100));
$fldCep = $frm->addCepField('num_cep1','Cep:',true,null,null,'des_endereco','nom_bairro','nom_cidade','cod_uf',null,null,null,null,null,null,'pesquisarCepCallback','pesquisarCepBeforeSend',false,'Cep está incompleto')->setExampleText('Não limpar se estiver incompleto');
$fldCep = $frm->addCepField('num_cep','Cep:',true,null,null,'des_endereco','nom_bairro','nom_cidade','cod_uf',null,null,null,null,null,null,'pesquisarCepCallback','pesquisarCepBeforeSend');
$frm->addTextField('des_endereco','Endereço:',60);
$frm->addTextField('num_endereco','Número:',10);
$frm->addTextField('des_complemento','Complemento:',60);
$frm->addTextField('nom_bairro','Bairro:',60);
$frm->addTextField('nom_cidade','Cidade:',60);
$frm->addTextField('cod_municipio','Cod. Município:',10);
$frm->addSelectField('cod_uf','Uf:',2);
$frm->addTextField('sig_uf','Uf:',2);
$frm->setValue('num_cep','71505030');

$frm->addHtmlField('linha','<hr><b>Consulta com select combinado</b>');

// utilizando select combinados
$frm->addHiddenField('cod_municipio_temp','');
$fldCep = $frm->addCepField('num_cep2','Cep:',true,null,null
	,'des_endereco2'
	,null
	,null
	,'cod_uf2'
	,null
	,null
	,null
	,'cod_municipio2_temp'
	,null
	,null,'myCallback');
	$frm->addTextField('des_endereco2','Endereço:',60);
	$frm->addSelectField('cod_uf2','Estado:',false);
	$frm->addSelectField('cod_municipio2','Município:',null,null,false);
	$frm->combinarSelects('cod_uf2','cod_municipio2','vw_municipios','cod_uf','cod_municipio','nom_municipio','-- Municípios --','0','Nenhum Município Encontrado');

$frm->show();
?>
<script>
function pesquisarCepCallback(xml){
	alert( 'Evento callback do campo cep foi chamada com sucesso');
}

function pesquisarCepBeforeSend(id){
	alert( 'Evento beforeSend do campo cep '+id+' foi chamado com sucesso');
}

function myCallback(dataset){
	console.log(jQuery("#cod_municipio2_temp").val());
	jQuery("#cod_uf2").change();
}
</script>