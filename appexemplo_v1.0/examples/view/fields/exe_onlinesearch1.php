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

$frm = new TForm('Consulta Dinâmica');
$frm->setColumns(array(200));
$frm->addTextField('id','id:',10);

$frm->addCpfField('num_cpf1','CPF:',null,null,false)->setExampleText('Informe o cpf e tecle &lt;enter&gt;')->setEnabled(false);;
$frm->addTextField('nom_pessoa1','Nome 1:',50,false);
$frm->addTextField('nom_pessoa','Nome:',50,false);
$frm->addTextField('end_pessoa_eugenio','Endereço:',50,false);
$frm->addTextField('des_bairro','Bairro:',50,false);
$frm->addTextField('cod_matricula_eugenio','Matricula:',10,false);
$frm->addTextField('num_cep','Cep:',10,false);
$frm->addTextField('dat_nasc','Nacimento:',10,false);

$frm->addCpfField('campo_teste1','Teste Evento Before Execute:');
$frm->addCpfField('campo_teste2','Teste com Multi Select:',null,null,false);
$frm->addTextField('nom_fruta','Fruta:',20)->setExampleText('Com cadastro on-line de frutas se a pesquisa retornar vazia');
$frm->addTextField('num_pessoa','Pessoas Selecionadas:',50)->setEnabled(false);
$frm->addMemoField('obs','Observação:',2000,false);
$_POST['fw_back_to'] = 'modulos/teste.php';
$frm->set('fw_back_to','modulos/teste.php');


$a = array(1=>'sim',2=>'nao');
//$frm->clearFields();
$frm->setOnlineSearch('num_cpf1'
	, 'TESTE.PKG_SEGURANCA.SEL_DADOS_PESSOA'
	, 'NUM_CPF|CPF:||||cpf,NOM_PESSOA|Nome:|50,COD_NELSON|Chefe||||SELECT'
	, 'NUM_CPF1,NOM_PESSOA1'
	, true
	, null
	,'NUM_CPF|Cpf,NOM_PESSOA|Nome'
	,'NUM_PESSOA|id,NOM_PESSOA,COD_MATRICULA|cod_matricula_eugenio,END_PESSOA|end_pessoa_eugenio,DES_BAIRRO,NUM_CEP,DAT_NASC,NUM_CPF'
	,'Consulta Pessoa Física'
	,'Registros Encontrados'
	,'des_endereco'
	,400
	,900
	,"Consultar"
	,null
	,'fwFazerAcao("Nova Acao")'
	,10 // máximo de registros retorno
	,null
	,null
	,'NOM_PESSOA'
	,array('COD_NELSON'=>$a)
	,null
	,false
	,'base/exemplos/exe_select.inc'
	);

$frm->setOnlineSearch('campo_teste1'
	,'TESTE.PKG_SEGURANCA.SEL_DADOS_PESSOA'
	,'NUM_CPF|CPF:||||cpf,NOM_PESSOA|Nome:|50'
	, null // 'NUM_CPF'
	, true
	, true
	,'NUM_CPF|Cpf,NOM_PESSOA|Nome'
	,'NUM_PESSOA|id,NOM_PESSOA'
	,'Consulta Pessoa Física'
	,'Registros Encontrados'
	,'des_endereco'
	,400
	,900
	,"Consultar"
	,'id'
	,'retorno()'
	,10 // máximo de registros retorno
	,null
	,null
	,'NOM_PESSOA'
	,null
	,'chkForm()'
	);
$frm->setOnlineSearch('campo_teste2'
	,'TESTE.PKG_SEGURANCA.SEL_DADOS_PESSOA'
	,'NUM_CPF|CPF:||||cpf,NOM_PESSOA|Nome:|50'
	, null // 'NUM_CPF'
	, true
	, true
	,'NUM_CPF|Cpf,NOM_PESSOA|Nome'
	,'NUM_PESSOA|id,NOM_PESSOA'
	,'Consulta Pessoa Física'
	,'Registros Encontrados'
	,'des_endereco'
	,400
	,900
	,"Consultar"
	,null
	,null// 'retorno()'
	,10 // máximo de registros retorno
	,null
	,'NUM_PESSOA' // campo que receberá as linhas selecinadas na consulta dinamica
	,'NOM_PESSOA'
	,null
	,null
	,null
	);
$frm->setOnlineSearch('nom_fruta'
	,'TESTE.PKG_FRUTA.SEL'
	,'NOM_FRUTA|Fruta:|50'
	, 'NOM_FRUTA'
	, true
	, true
	,'NOM_FRUTA|Fruta'
	,'NOM_FRUTA'
	,'Consulta Frutas'
	,'Registros Encontrados'
	,null
	,400
	,900
	,"Consultar"
	,null
	,null// 'retorno()'
	,10 // máximo de registros retorno
	,'$res["NOM_FRUTA"][$k]!="Banana"'
	,null
	,null
	,null
	,null
	,null
	,'base/exemplos/cad_fruta.inc'
	);


$frm->setOnlineSearch('obs'
	,'TESTE.PKG_SEGURANCA.SEL_DADOS_PESSOA'
	,'NUM_CPF|CPF:||||cpf,NOM_PESSOA|Nome:|50'
	, null // 'NUM_CPF'
	, true
	, true
	,'NUM_CPF|Cpf,NOM_PESSOA|Nome'
	,'NOM_PESSOA|obs'
	,'Consulta Pessoa Física'
	,'Registros Encontrados'
	,'des_endereco'
	,400
	,900
	,"Consultar"
	,null
	,null
	,10 // máximo de registros retorno
	,null
	,null
	,'NOM_PESSOA'
	,null
	,null
	);


$frm->disableFields('nom_pessoa,id');
$frm->setAction('Atualizar');

//print 'Acao:'.$acao;
$frm->show();
?>
<script>
function retorno()
{
	fwModalBox('Teste','http://www.bb.com.br',800,600);
}
function chkForm()
{
	if(!fwGetObj('num_cpf').value)
	{
		alert('Preencha o cpf primeiro');
		return false;
	}
	return confirm('Confirma consulta on-line?');
}
</script>
