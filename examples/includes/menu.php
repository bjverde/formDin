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


// url para teste: http://index.php?modulo=menu_principal.php&ajax=1&content-type=xml
$menu =  new TMenuDhtmlx();
$menu->add('1',null,'Campos',null,null,'user916.gif');
	$menu->add('11','1','Campo Texto',null,'Declaração de texto' );
		$menu->add('11.1','11','Campo Texto','view/fields/exe_TextField.php')->setJsonParams("{'p1':'parametro_1','p2':'parametro_2'}");
		$menu->add('11.2','11','Autocompletar','view/fields/exe_autocomplete.php');
		$menu->add('11.3','11','Autocompletar II','view/fields/exe_autocomplete2.php');
		$menu->add('11.4','11','Consulta On-line I','view/fields/exe_onlinesearch1.php');
		$menu->add('11.5','11','Entrada com Máscara','view/fields/exe_maskField.php');
	$menu->add('12','1','Campo HTML','view/fields/exe_HtmlField.php');
	$menu->add('13','1','Campo Coord GMS','view/fields/exe_CoordGmsField.php');
	$menu->add('14','1','Campo Select','view/fields/exe_SelectField.php');
	$menu->add('15','1','Campo Radio','view/fields/exe_RadioField.php');
	$menu->add('16','1','Campo Check','view/fields/exe_CheckField.php');
	$menu->add('17','1','Campo Arquivo');
		$menu->add('171','17','Assincrono','view/fields/exe_FileAsync.php');
		$menu->add('172','17','Normal','view/fields/exe_TFile.php');
		$menu->add('173','17','TAssincrono','view/fields/exe_TFileAsync.php');
	$menu->add('18','1','Campo Numérico','view/fields/exe_NumberField.php');
	$menu->add('19','1','Campo CEP'	,'view/fields/exe_CepField.php');
	$menu->add('20','1','Campo Telefone'	,'view/fields/exe_FoneField.php');
	$menu->add('21','1','Campo Cpf/Cnpj'	,'view/fields/exe_campo_cpf_cnpj.php');
	$menu->add('110','1','Campo Data'	,'view/fields/exe_DateField.php');
	$menu->add('111','1','Campo Select Diretorio/Pasta'	,'view/fields/exe_OpenDirField.php');
	$menu->add('112','1','Campo Fuso Horário - ERRO'	,'exe_TTimeZoneField.php');
	$menu->add('113','1','Campo Editor'	,'view/fields/exe_TTextEditor.php');
	$menu->add('114','1','Campo Memo - ERRO'	,'exe_TMemo.php');
	$menu->add('115','1','Campo Senha'	,'view/fields/exe_TPasswordField.php');
	$menu->add('116','1','Campo Agenda'	,'view/fields/exe_TCalendar.php');
	$menu->add('117','1','Campo Captcha'	,'view/fields/exe_TCaptchaField.php');
	$menu->add('118','1','Campo Blob'	);
		$menu->add('1181','118','Campo Blob Salvo no Banco'		,'view/fields/exe_fwShowBlob.php');
		$menu->add('1182','118','Campo Blob Salvo no Disco'		,'view/fields/exe_fwShowBlobDisco.php');
	$menu->add('119','1','Campo Cor'		,'view/fields/exe_TColorPicker.php');
	$menu->add('120','1','Tecla de Atalho'		,'view/fields/exe_Shortcut.php');




$menu->add('2',null,'Containers');
$menu->add('22','2','Grupo');
	$menu->add('221','22','Grupo Normal','exe_GroupField.php');
	$menu->add('222','22','Grupo Combinados ( Efeito Sanfona )','exe_GroupField_2.php');

$menu->add('23','2','Aba'		,'exe_aba_1.php');
$menu->add('24','2','TreeView');
$menu->add('241','24','Dentro do Formulário' ,'exe_tree_view_1.php');
$menu->add('242','24','Fora do Formulário'	,'exe_tree_view_2.php');
$menu->add('243','24','User Data - Array'	,'exe_tree_view_3.php');
$menu->add('244','24','Uf x Municípios'		,'exe_tree_view_4.php');
$menu->add('245','24','Uf x Municípios com SetXmlFile()' ,'exe_tree_view_5.php');

$menu->add('4',null,'Ajuda On-line (sqlite)','exe_documentacao_online.inc','Confeção do texto de ajuda gravando no banco de dados sqlite');


$menu->add('5',null,'Ajax');
$menu->add('51','5','Exemplo 1','exe_ajax_1.php');
$menu->add('52','5','Atualizar Campos','exe_ajax_2.php');
$menu->add('53','5','Botão Ajax','exe_TButtonAjax.php');
$menu->add('54','5','Ajax com Semáforo','exe_ajax_semaphore.php');

$menu->add('6',null,'PDF');
$menu->add('61','6','Exemplo 1','exe_pdf_1.php');
$menu->add('62','6','Exemplo 2','exe_pdf_2.php');

$menu->add('7',null,'Mensagens');
$menu->add('71','7','Exemplo 1','exe_mensagem.php');
$menu->add('72','7','Caixa de Confirmação','exe_confirmDialog.php');

$menu->add('8',null,'Gride');
$menu->add('81','8','Exemplo 1','exe_gride_1.php');
$menu->add('82','8','Exemplo 2 - Anexos - Ajax','exe_gride_2.php');
$menu->add('83','8','Grid Offline','exe_gride_3.php');
$menu->add('84','8','Grid Offline com fwGetGrid()','exe_gride_4.php');
$menu->add('85','8','Paginação','exe_gride_paginacao.php');
$menu->add('86','8','Função getGrid()','exe_gride_4.php');
$menu->add('87','8','Gride com Campos 1','exe_gride_10.php');
$menu->add('88','8','Gride com Campos 2','exe_gride_11.php');

$menu->add('9',null,'PDO');
$menu->add('91','9','Exemplo Mysql','exe_pdo_1.php');
$menu->add('92','9','Exemplo Sqlite e Mysql','exe_pdo_2.php');
$menu->add('93','9','Exemplo Postgres');
 $menu->add('931','93','DAO e VO','exe_pg_dao_vo_1.php');
$menu->add('94','9','Exemplo Firebird');
 $menu->add('941','94','Conexão','exe_firebird_1.php');
$menu->add('95','9','Gerador VO/DAO','../base/includes/gerador_vo_dao.php');
$menu->add('96','9','Testar Conexão','exe_teste_conexao.php');
$menu->add('97','9','Dados de Apoio','cad_apoio_pdo.php');


$menu->add('101',null,'Hints');
$menu->add('1011','101','Exemplo I','exe_hint.php');

$menu->add('102',null,'Teste','teste.php');
$menu->add('103',null,'Formulário');
	$menu->add('1031','103','Normal','exe_TForm.php');
	$menu->add('1032','103','Subcadastro','exe_TForm2.php');
	$menu->add('1033','103','Boxes','exe_TBox.php');
	$menu->add('1034','103','Mestre Detalhe com Ajax','cad_mestre_detalhe/cad_mestre_detalhe.php');
	$menu->add('1035','103','Imagem de Fundo','exe_TFormImage.php');
	$menu->add('1036','103','Customizado com CSS','exe_TForm3.php');
	$menu->add('1037','103','Recurso de Autosize','exe_TForm_autosize.php');


$menu->add('104',null,'TZip','exe_TZip.php');

$menu->add('199',null,'Temas do Menu','exe_menu_tema.php');


//$menu->add('520','5','Exemplo Select Combinado','exe_select_combinado_ajax.php');
$menu->getXml();
?>