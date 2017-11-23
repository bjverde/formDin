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

//d($_REQUEST);

$frm = new TForm('Exemplos de Formulário',300);
$frm->addHiddenField('flat');

// adicinoar eventos ao fechar e antes de fechar
$frm->setOnBeforeClose('antesFechar()');
$frm->setOnClose('depoisFechar()');


$frm->addTextField('nome','Nome:',60);
if( $frm->get('flat')=='1') {
	$frm->setFlat(true);
	$frm->addButton('Com bordas',null,'btn2','jQuery("#flat").val(0);fwDoAction();');
} else {
	$frm->addButton('Sem bordas',null,'btn2','jQuery("#flat").val(1);fwDoAction();');
}
$frm->addRadioField('sexo','Sexo:',false,'M=masculino,F=Feminino');
$frm->addCheckField('cor','Cor:',false,'M=Marrom,B=Branca');

$frm->addTextField('municipio','Municipio',60,false,60);

$frm->setOnlineSearch('municipio'
    ,'tb_municipio'               //$strPackageFunction
    ,'nom_municipio|Município:||||||like'   //$strFilterFields
    ,false                        //$strAutoFillFilterField
    ,false                        //$boolAutoStart
	,true                         //se for encontrada apenas 1 opção fazer a seleção automaticamente
	,'cod_municipio|Código,nom_municipio|Município'
    ,'NOM_MUNICIPIO|municipio'    //$strUpdateFormFields
    ,'Pesquisar Municípios'       //$strWindowHeader -  Titulo da janela de pesquisa
	,'Registros'                  //$strGridHeader   -  Titulo do Gride
    ,'nom_municipio'              //$strFocusFieldName - Seta o Foco no campo definido 
    ,null                         //$strWindowHeight
    ,null                         //$strWindowWidth
    ,null                         //$strSearchButtonLabel
    ,null                         //$strFormFilterFields
    ,'funcaoRetorno()'            //$strFunctionExecute
    ,null                         //$intMaxRecord
    ,null                         //$strClickCondition
    ,null                         //$strMultiSelectKeyField
    ,null                         //$strColumnLink
    ,null                         //$arrSqls
    ,null                         //$strBeforeExecuteJs
    ,null                         //$boolDisableEnterKey
    ,null                         //$strCrudModuleName
    ,false                        //$boolCaseSensitive caseSensitive
	);

$frm->addLinkField('idLink1','Conteudo da Modal','Abre o conteudo da modal em nova janela',null,'index.php?modulo=view/form/exe_TForm.php','new');

$frm->setonMaximize('onMaximize');
$frm->addButton('Fechar Modal',null,'btnFechar','fecharModal()');
$frm->addButton('Maximizar',null,'btn1','fwFullScreen(null,onMaximize)','Confirma Maximizar?');
$frm->addButton('Open Modal',null,null,'openModal()');
//$frm->setPrototypeId('1');
$frm->show();

?>
<script>
//Window.keepMultiModalWindow=true;
function openModal() {
  	fwModalBox('Janela Modal 2','index.php?modulo=view/form/exe_TForm.php');
	//top.app_open_modal_window({url:'http://localhost/fontes/base/exemplos/index.php?modulo=exe_TForm.php'});
}
function onMaximize(res) {
	if( res == 0 ) {
		jQuery('#btn2').val('Maximizar');
	}else {
		jQuery('#btn1').val('Minimizar');
	}
}
function fecharModal() {
	alert( 'fechar');
	fwClose_window();
}

function funcaoRetorno() {
	alert('funcaoRetorno() executada!');
}
function antesFechar() {
	return confirm('Prosseguir com o fechamento do Formulário ?');
}
function depoisFechar() {
	alert( 'Formulário será fechado');
}
</script>