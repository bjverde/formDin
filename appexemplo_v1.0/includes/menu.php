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
$menu->add('18','1','Campo Numúrico','view/fields/exe_NumberField.php');
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

$menu->add('4',null,'Ajuda On-line (sqlite)','exe_documentacao_online.inc','Confe??o do texto de ajuda gravando no banco de dados sqlite');


$menu->add('5',null,'Ajax');
$menu->add('51','5','Exemplo 1','exe_ajax_1.php');
$menu->add('52','5','Atualizar Campos','exe_ajax_2.php');
$menu->add('53','5','Botão Ajax','exe_TButtonAjax.php');
$menu->add('54','5','Ajax com Sem?foro','exe_ajax_semaphore.php');

$menu->add('6',null,'PDF');
$menu->add('61','6','Exemplo 1','exe_pdf_1.php');
$menu->add('62','6','Exemplo 2','exe_pdf_2.php');

$menu->add('7',null,'Mensagens');
$menu->add('71','7','Exemplo 1','view/messages/exe_mensagem.php');
$menu->add('72','7','Caixa de Confirmação','view/messages/exe_confirmDialog.php');
$menu->add('73','7','Caixa de Confirmação 2','view/messages/exe_confirm_dialog.php');

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
$menu->add('96','9','Testar Conex?o','exe_teste_conexao.php');
$menu->add('97','9','Dados de Apoio','cad_apoio_pdo.php');


$menu->add('101',null,'Hints');
$menu->add('1011','101','Exemplo I','exe_hint.php');

$menu->add('102',null,'Teste','teste.php');
$menu->add('103',null,'Formulário');
$menu->add('1031','103','Normal','view/form/exe_TForm.php');
$menu->add('1032','103','Subcadastro','view/form/exe_TForm2.php');
$menu->add('1033','103','Boxes','view/form/exe_TBox.php');
$menu->add('1034','103','Mestre Detalhe com Ajax','cad_mestre_detalhe/cad_mestre_detalhe.php');
$menu->add('1035','103','Imagem de Fundo','view/form/exe_TFormImage.php');
$menu->add('1036','103','Customizado com CSS','view/form/exe_TForm3.php');
$menu->add('1037','103','Recurso de Autosize','view/form/exe_TForm_autosize.php');
$menu->add('1038','103','Tela Login','view/form/exe_tela_login.php');


$menu->add('104',null,'TZip','exe_TZip.php');
$menu->add('199',null,'Temas do Menu','exe_menu_tema.php');


$menu->add(-20,0,'Exemplos',null,'Exemplo de Recursos do Formul?rio Din?mico IV','ajudaonline.gif');
$menu->add(-260,-20,'Grides');
$menu->add(-26001,-260	,'Criação de Gride','exe_gride.inc');
$menu->add(-26002,-260	,'Grid Off-Line - Formdin3','exe_gride_off_line.inc');
$menu->add(-26003,-260	,'Grid Off-Line - FormDin4','exe_gride_off_line_novo.inc');
$menu->add(-26004,-260	,'Grid Com Coluna Checkbox','exe_gride_checkbox.inc');
$menu->add(-26005,-260	,'Grid com Arquivos Anexados ( ajax )','exe_gride_anexo.inc');

$menu->add(-270,-20,'Outros');
$menu->add(-27001,-270,'Banco Textual DBM (db4)','exe_db4.inc');
$menu->add(-27002,-270,'Cadastro on-line (CRUD)','exe_crud_online.inc');
$menu->add(-27003,-270,'Documentação on-line','exe_documentacao_online.inc');
$menu->add(-27004,-270,'Select Combinado','exe_select_combinado.inc');
$menu->add(-27005,-270,'Select Combinado F3','exe_select_combinado_f3.inc');
$menu->add(-27006,-270,'Select Combinado Ajax','exe_select_combinado_ajax.php');
$menu->add(-27009,-270,'FormDin 3','exe_formDin3.inc');
$menu->add(-27010,-270,'PDF','exe_pdf.inc');
$menu->add(-27011,-270,'HINT','exe_hint.inc');
//$menu->add(-27012,-270,'TreeView Taxonomia','exe_tree_view.inc');
$menu->add(-27012,-270,'TreeView Unidade Ibama','exe_tree_view_unid_ibama.inc');
$menu->add(-27013,-270,'TreeView Unidade Ibama On Line','exe_tree_view_on_line.php');
$menu->add(-27014,-270,'Campo Select Ajax','exe_fill_select_ajax.inc');
$menu->add(-27015,-270,'Redirect','exe_redirect.inc');
$menu->add(-27016,-270,'Javascript/Css Externos','exe_javascript_externo.inc');
$menu->add(-27017,-270,'Definir Colunas no Formul?rio','exe_colunas.inc');
$menu->add(-27018,-270,'Tela de Confirma??o','exe_confirm_dialog.php');
// parametros da janela
$params = array('width'=>800,'height'=>500,'resizeble'=>true,'confirmClose'=>false,'modal'=>true);
$menu->add(-27019,-270,'Site da Google','http://www.google.com','Site do Google',null,null,null,null,null,json_encode($params));

$menu->add(-27019,-270,'Postgres Lob','exe_postgres.php');
$menu->add(-27020,-270,'Exemplo de Mensagens','exe_mensagem.php');

$menu->add(-2001,-20,'Cria??o de Abas','exe_aba.inc');
$menu->add(-2002,-20,'Campo/Gride com Autocompletar','exe_autocompletar.inc');
$menu->add(-2003,-20,'Campo Checkbox','exe_checkbox.inc');
$menu->add(-2004,-20,'Campo com Consulta On-line','exe_onlinesearch.inc');
$menu->add(-2005,-20,'Campo Texto e Tag','exe_campo_texto.inc');
$menu->add(-2006,-20,'Campo Select','exe_select.inc');
$menu->add(-2007,-20,'Campo Cep','exe_campo_cep.inc');
$menu->add(-2008,-20,'Campo Link','exe_campo_link.inc');
$menu->add(-2009,-20,'Campo Hora','exe_campo_hora.inc');
$menu->add(-2010,-20,'Campo Cor','exe_campo_cor.inc');
$menu->add(-2011,-20,'Campo Memo / Editor HTML','exe_campo_memo.inc');
$menu->add(-2012,-20,'Campo Coordenada Geogr?fica','exe_campo_coordGMS.inc');
$menu->add(-2013,-20,'Campo N?mero','exe_campo_numero.inc');
$menu->add(-2014,-20,'Campo Ajuda (facebox)','exe_campo_ajuda.inc');
$menu->add(-2015,-20,'Campo Grupo','exe_campo_grupo.inc');
$menu->add(-2016,-20,'Campo Telefone','exe_telefone.inc');
$menu->add(-2017,-20,'Campo Arquivo','exe_campo_arquivo.inc');
$menu->add(-2018,-20,'Cad Funcionario F3','base/seguranca/cad_funcionario.inc');
$menu->add(-2019,-20,'Campo Autocompletar'	,'exe_autocomplete.php');
$menu->add(-2099,-20,'Testes Laborat?rio','exe_teste.inc');



$menu->getXml();
?>