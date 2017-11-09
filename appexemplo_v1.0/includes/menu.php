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


// url para teste: http://index.php?modulo=menu_principal.php&ajax=1&content-type=xml
$menu =  new TMenuDhtmlx();
$menu->add('1',null,'Campos',null,null,'user916.gif');
$menu->add('11','1','Campo Texto',null,'Declaração de texto' );
	$menu->add('11.1','11','Campo Texto','view/fields/exe_TextField.php')->setJsonParams("{'p1':'parametro_1','p2':'parametro_2'}");
	$menu->add('11.2','11','Autocompletar','view/fields/exe_autocomplete.php');
	$menu->add('11.3','11','Autocompletar II','view/fields/exe_autocomplete2.php');
	$menu->add('11.4','11','Consulta On-line I','view/fields/exe_onlinesearch1.php');
	$menu->add('11.5','11','Entrada com Máscara','view/fields/exe_maskField.php');
	$menu->add('11.6','11','Campo Editor'	,'view/fields/exe_TTextEditor.php');
	$menu->add('11.7','11','Campo Memo'	,'view/fields/exe_TMemo.php');
$menu->add('12','1','Campo HTML','view/fields/exe_HtmlField.php');
$menu->add('13','1','Campo Coord GMS','view/fields/exe_CoordGmsField.php');
$menu->add('14','1','Campo Select','view/fields/exe_SelectField.php');
$menu->add('15','1','Campo Radio','view/fields/exe_RadioField.php');
$menu->add('16','1','Campo Check','view/fields/exe_CheckField.php');
$menu->add('17','1','Campo Arquivo');
	$menu->add('171','17','Assincrono','view/fields/exe_FileAsync.php');
	$menu->add('172','17','Normal','view/fields/exe_TFile.php');
	$menu->add('173','17','TAssincrono','view/fields/exe_TFileAsync.php');
$menu->add('18','1','Campo Numúrico','view/fields/exe_NumberField.php');
$menu->add('19','1','Campo Brasil');
	$menu->add('191','19','Campo CEP'	,'view/fields/exe_CepField.php');
	$menu->add('292','19','Campo Telefone'	,'view/fields/exe_FoneField.php');
	$menu->add('193','19','Campo Cpf/Cnpj'	,'view/fields/exe_campo_cpf_cnpj.php');
$menu->add('110','1','Campos Data e hora');
	$menu->add('1101','110','Campo Data' ,'view/fields/exe_DateField.php');
	$menu->add('1102','110','Campo Hora' ,'view/fields/exe_campo_hora.php');
	$menu->add('1103','110','Campo Fuso Horário - ERRO'	,'exe_TTimeZoneField.php');
	$menu->add('1104','110','Campo Agenda'	,'view/fields/exe_TCalendar.php');
$menu->add('111','1','Campo Select Diretorio/Pasta'	,'view/fields/exe_OpenDirField.php');

$menu->add('115','1','Campo Senha'	,'view/fields/exe_TPasswordField.php');

$menu->add('117','1','Campo Captcha'	,'view/fields/exe_TCaptchaField.php');
$menu->add('118','1','Campo Blob'	);
	$menu->add('1181','118','Campo Blob Salvo no Banco'		,'view/fields/exe_fwShowBlob.php');
	$menu->add('1182','118','Campo Blob Salvo no Disco'		,'view/fields/exe_fwShowBlobDisco.php');
$menu->add('119','1','Campo Cor'		,'view/fields/exe_TColorPicker.php');
$menu->add('120','1','Tecla de Atalho'	,'view/fields/exe_Shortcut.php');
$menu->add('121','1','Campo Link','view/fields/exe_field_link.php');
//Redirect só funciona se o arquivo estiver na pasta modulos
$menu->add('122','1','Redirect','exe_redirect.inc');
$menu->add('123','1','TZip','exe_TZip.php');

//-----------------------------------------------------------------------------
$menu->add('2',null,'Containers');
	$menu->add('22','2','Grupo');
		$menu->add('221','22','Grupo Normal','exe_GroupField.php');
		$menu->add('222','22','Grupo Combinados ( Efeito Sanfona )','exe_GroupField_2.php');
	$menu->add('23','2','Abas');
		$menu->add('231','23','Aba'		,'view/containers/exe_aba_1.php');
		$menu->add('232','23','Aba2'	,'view/containers/exe_aba_2.php');
		$menu->add('233','23','Aba3'	,'view/containers/exe_aba_3.php');
		$menu->add('234','23','Aba4'	,'view/containers/exe_aba_4.php');
	$menu->add('24','2','TreeView');
		$menu->add('241','24','Dentro do Formulário' ,'exe_tree_view_1.php');
		$menu->add('242','24','Fora do Formulário'	,'exe_tree_view_2.php');
		$menu->add('243','24','User Data - Array'	,'exe_tree_view_3.php');
		$menu->add('244','24','Uf x Municípios'		,'exe_tree_view_4.php');
		$menu->add('245','24','Uf x Municípios com SetXmlFile()' ,'exe_tree_view_5.php');

//-----------------------------------------------------------------------------
$menu->add('4',null,'Mensagens e Ajuda');
	$menu->add('41','4','Mensagens');
		$menu->add('411','41','Exemplo 1','view/messages/exe_mensagem.php');
		$menu->add('412','41','Caixa de Confirmação','view/messages/exe_confirmDialog.php');
		$menu->add('413','41','Caixa de Confirmação 2','view/messages/exe_confirm_dialog.php');
	$menu->add('42','4','Ajuda');
		$menu->add('421','42','Ajuda com arquivo HTML','exe_campo_ajuda.php','Com um arquivo HTML separado');
		$menu->add('422','42','Ajuda On-line (sqlite)','exe_documentacao_online.php','Confe??o do texto de ajuda gravando no banco de dados sqlite');		

//-----------------------------------------------------------------------------
$menu->add('5',null,'Ajax');
	$menu->add('51','5','Exemplo 1','exe_ajax_1.php');
	$menu->add('52','5','Atualizar Campos','exe_ajax_2.php');
	$menu->add('53','5','Botão Ajax','exe_TButtonAjax.php');
	$menu->add('54','5','Ajax com Sem?foro','exe_ajax_semaphore.php');

//-----------------------------------------------------------------------------
$menu->add('6',null,'PDF');
	$menu->add('61','6','Exemplo 1','exe_pdf_1.php');
	$menu->add('62','6','Exemplo 2','exe_pdf_2.php');
	$menu->add('63','6','Exemplo 3, com passagem de parametros via Json','pdf/exe_pdf03.php');
	$menu->add('64','6','Exemplo 4','pdf/exe_pdf04.php');

//-----------------------------------------------------------------------------
$menu->add('8',null,'Gride');
	$menu->add('81','8','Exemplo 1','exe_gride_1.php');
	$menu->add('82','8','Exemplo 2 - Anexos - Ajax','exe_gride_2.php');
	$menu->add('83','8','Grid Offline','exe_gride_3.php');
	$menu->add('84','8','Grid Offline com fwGetGrid()','exe_gride_4.php');
	$menu->add('85','8','Paginação','exe_gride_paginacao.php');
	$menu->add('86','8','Função getGrid()','exe_gride_4.php');
	$menu->add('87','8','Gride com Campos 1','exe_gride_10.php');
	$menu->add('88','8','Gride com Campos 2','exe_gride_11.php');
	$menu->add('89','8','Gride com campos 3','view/grid/exe_gride_campos3.php');
	$menu->add('90','8','exe_gride_09','view/grid/exe_gride_09.php');

//-----------------------------------------------------------------------------
$menu->add('9',null,'PDO');
	$menu->add('91','9','Exemplo Mysql','exe_pdo_1.php');
	$menu->add('92','9','Exemplo Sqlite e Mysql','exe_pdo_2.php');
	$menu->add('93','9','Exemplo Postgres');
		$menu->add('931','93','DAO e VO','exe_pg_dao_vo_1.php');
	$menu->add('94','9','Exemplo Firebird');
		$menu->add('941','94','Conexão','exe_firebird_1.php');
	$menu->add('95','9','Gerador VO/DAO','../base/includes/gerador_vo_dao.php');
	$menu->add('96','9','Testar Conex?o','exe_teste_conexao.php');
	$menu->add('97','9','Dados de Apoio','cad_apoio_pdo.php');

//-----------------------------------------------------------------------------
$menu->add('101',null,'Hints');
$menu->add('1011','101','Exemplo I','exe_hint.php');

//-----------------------------------------------------------------------------
$menu->add('103',null,'Formulário');
	$menu->add('1031','103','Normal','view/form/exe_TForm.php');
	$menu->add('1032','103','Subcadastro','view/form/exe_TForm2.php');
	$menu->add('1033','103','Boxes','view/form/exe_TBox.php');
	$menu->add('1034','103','Mestre Detalhe com Ajax','cad_mestre_detalhe/cad_mestre_detalhe.php');
	$menu->add('1035','103','Imagem de Fundo','view/form/exe_TFormImage.php');
	$menu->add('1036','103','Customizado com CSS','view/form/exe_TForm3.php');
	$menu->add('1037','103','Recurso de Autosize','view/form/exe_TForm_autosize.php');
	$menu->add('1038','103','Tela Login','view/form/exe_tela_login.php');
	$menu->add('1039','103','Cadastro on-line (CRUD)','view/form/exe_crud_online.php');
	$menu->add('1040','103','Definir Colunas no Formulário','view/form/exe_colunas.php');

//-----------------------------------------------------------------------------
$menu->add('200',0,'Layout');
	$menu->add('201','200','Layout','layouts.php');
	$menu->add('202','200','Temas do Menu','exe_menu_tema.php');

//-----------------------------------------------------------------------------
$menu->add(-20,0,'Exemplos',null,'Exemplo de Recursos do Formulário Diâmico IV','acessibilidade-brasil.gif');
$menu->add(-26020,-20,'editor','exe_editor_html.inc');
$menu->add(-26001,-20,'Criação de Gride','exe_gride.inc');
$menu->add(-26003,-20,'Grid Off-Line - FormDin4','exe_gride_off_line_novo.inc');
$menu->add(-26004,-20,'Grid Com Coluna Checkbox','exe_gride_checkbox.inc');
$menu->add(-26005,-20,'Grid com Arquivos Anexados ( ajax )','exe_gride_anexo.inc');
$menu->add(-27001,-20,'Banco Textual DBM (db4)','exe_db4.inc');
$menu->add(-27005,-20,'Select Combinado F3','exe_select_combinado_f3.inc');
$menu->add(-27006,-20,'Select Combinado Ajax','exe_select_combinado_ajax.php');
$menu->add(-27013,-20,'TreeView Unidade Ibama On Line','exe_tree_view_on_line.php');
$menu->add(-27014,-20,'Campo Select Ajax','exe_fill_select_ajax.inc');
$menu->add(-27016,-20,'Javascript/Css Externos','exe_javascript_externo.inc');
$menu->add(-27018,-20,'Tela de Confirma??o','exe_confirm_dialog.php');
// parametros da janela
$params = array('width'=>800,'height'=>500,'resizeble'=>true,'confirmClose'=>false,'modal'=>true);
$menu->add(-27019,-20,'Site da Google','http://www.google.com','Site do Google',null,null,null,null,null,json_encode($params));
$menu->add(-27019,-20,'Postgres Lob','exe_postgres.php');
$menu->add(-27020,-20,'Exemplo de Mensagens','exe_mensagem.php');
$menu->add(-2002,-20,'Campo/Gride com Autocompletar','exe_autocompletar.inc');
$menu->add(-2003,-20,'Campo Checkbox','exe_checkbox.inc');
$menu->add(-2005,-20,'Campo Texto e Tag','exe_campo_texto.inc');
$menu->add(-2006,-20,'Campo Select','exe_select.inc');
$menu->add(-2012,-20,'Campo Coordenada Geogr?fica','exe_campo_coordGMS.inc');
$menu->add(-2014,-20,'Campo Ajuda (facebox)','exe_campo_ajuda.inc');
$menu->add(-2018,-20,'cad_departamento.php','cad_departamento.php');
$menu->add(-2019,-20,'cad_fruta.inc','cad_fruta.inc');
$menu->add(-2020,-20,'cad_fruta.inc','cad_fruta.inc');



$menu->getXml();
?>