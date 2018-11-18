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

$frm = new TForm('Exemplo Campo CEP');
$frm->setFlat(true);

$frm->addGroupField('gpx1', 'Motor de Busca ViaCep');
    $frm->addHtmlField('html1', null, 'ajuda/cep_via.html','',40)->setCss('border', '1px solid blue');

    // define a largura das colunas verticais do formulario para alinhamento dos campos
    $frm->setColumns(array(100,100));
    
    $fldCep0 = $frm->addCepField('num_cep', 'Cep:', true, null, null, 'des_endereco', 'nom_bairro', 'nom_cidade', 'cod_uf', null, null, null, null, null, null, 'pesquisarCepCallback', 'pesquisarCepBeforeSend');
    $fldCep0->setExampleText('Limpar o campo se estiver incompleto');
    $frm->setValue('num_cep', '71505030');
    
    $fldCep1 = $frm->addCepField('num_cep1', 'Cep:', true, null, null, 'des_endereco', 'nom_bairro', 'nom_cidade', 'cod_uf', null, null, null, null, null, null, 'pesquisarCepCallback', 'pesquisarCepBeforeSend', false, 'Cep está incompleto');
    $fldCep1->setExampleText('Não limpar o campo se estiver incompleto, tem msg de erro');
    
    $frm->addTextField('des_endereco', 'Endereço:', 60);
    $frm->addTextField('num_endereco', 'Número:', 10);
    $frm->addTextField('des_complemento', 'Complemento:', 60);
    $frm->addTextField('nom_bairro', 'Bairro:', 60);
    $frm->addTextField('nom_cidade', 'Cidade:', 60);
    $frm->addTextField('cod_municipio', 'Cod. Município:', 10);
    $listUF = Tb_ufDAO::selectComboSigUf();
    $frm->addSelectField('cod_uf', 'Uf:', false, $listUF);
    $frm->addTextField('sig_uf', 'Uf:', 2);
    
    
    $frm->addHtmlField('linha', '<hr><b>Consulta com select combinado, motor ViaCep</b>');
    
    // utilizando select combinados
    $frm->addHiddenField('cod_municipio_temp', '');
    $frm->addCepField('num_cep2'
                     , 'Cep:'
                     , true
                     , null
                     , null // Nova linha
        , 'des_endereco2'  // campo endereço
        , null // campo bairro
        , null // campo cidade
        , null //campo cod uf 
        , 'cod_uf2' // campo sig uf
                     , null // campo logradouro
                     , null
                     , 'cod_municipio2_temp'
                     , null, null, 'myCallback');
    $frm->addTextField('des_endereco2', 'Endereço:', 60);
    // $frm->addSelectField('cod_uf2', 'Estado:', false);
    $frm->addSelectField('cod_uf2', 'Uf:', false, $listUF);
    $frm->addSelectField('cod_municipio2', 'Município:', null, null, false);
    $frm->combinarSelects('cod_uf2', 'cod_municipio2', 'vw_municipios', 'cod_uf', 'cod_municipio', 'nom_municipio', '-- Municípios --', '0', 'Nenhum Município Encontrado');

$frm->closeGroup();

$frm->addGroupField('gpx2', 'Motor de Busca BuscarCep');
    $frm->addHtmlField('html2', null, 'ajuda/cep_buscar.html','',40)->setCss('border', '1px solid blue');
    $frm->addCepField('num_cep3'
                     ,'Cep:'
                     , true
                     , '71505030'
                     , null
                     , 'des_endereco3'
                     , null
                     , null
                     , 'cod_uf3'
                     , null
                     , null
                     , null
                     , 'cod_municipio2_temp'
                     , null
                     , null, 'myCallback', null,false,null,2);
    $frm->addTextField('des_endereco3', 'Endereço:', 60);
    $frm->addSelectField('cod_uf3', 'Estado:', false);
    $frm->addSelectField('cod_municipio3', 'Município:', null, null, false);
    $frm->combinarSelects('cod_uf3', 'cod_municipio3', 'vw_municipios', 'cod_uf', 'cod_municipio', 'nom_municipio', '-- Municípios --', '0', 'Nenhum Município Encontrado');
$frm->closeGroup();
    
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
    jQuery("#cod_uf3").change();
}
</script>
