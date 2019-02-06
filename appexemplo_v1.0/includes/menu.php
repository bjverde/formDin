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
$menu->add('1', null, 'Campos', null, null, 'user916.gif');
$menu->add('11', '1', 'Campo Texto', null, 'Declaração de texto');
	$menu->add('11.1', '11', 'Campo Texto Simples');
    	$menu->add('11.1.1', '11.1', 'Campo Texto', 'view/fields/exe_TextField.php')->setJsonParams("{'p1':'parametro_1','p2':'parametro_2'}");
    	$menu->add('11.1.2', '11.1', 'Entrada com Máscara', 'view/fields/exe_maskField.php');
    	$menu->add('11.2.3', '11.1', 'Campo Memo', 'view/fields/exe_TMemo.php');
	$menu->add('11.2', '11', 'Campo Texto Richo');
    	$menu->add('11.2.1', '11.2', 'Campo Memo com tinyMCE', 'view/fields/exe_Ttinymce.php');
    	$menu->add('11.2.2', '11.2', 'Campo Editor com CkEditor', 'view/fields/exe_TTextEditor.php');
	$menu->add('11.3', '11', 'Campo Texto funções');
    	$menu->add('11.3.1', '11.3', 'Autocompletar', 'view/fields/exe_autocomplete.php');
    	$menu->add('11.3.2', '11.3', 'Autocompletar II', 'view/fields/exe_autocomplete2.php');
    	$menu->add('11.3.3', '11.3', 'Consulta On-line', 'view/fields/exe_onlinesearch.php');
    	$menu->add('11.3.4', '11.3', 'Consulta On-line I (ERRO)', 'view/fields/exe_onlinesearch1.php');
    	$menu->add('11.3.5', '11.3', 'Autocompletar 3 + Consulta On-line', 'view/fields/exe_autocomplete3.php');
$menu->add('12', '1', 'Campo HTML');
    $menu->add('12.1', '12', 'Campo HTML', 'view/fields/exe_HtmlField.php');
    $menu->add('12.2', '12', 'Campo HTML com iFrame', 'modulos/iframe_phpinfo/ambiente_phpinfo.php');
$menu->add('13', '1', 'Campo Coord GMS');
    $menu->add('13.1', '13', 'Campo Coord GMS', 'view/fields/exe_CoordGmsField.php');
    $menu->add('13.2', '13', 'Campo Coord GMS 02', 'view/fields/exe_CoordGmsField02.php');
$menu->add('14', '1', 'Campo Select');
    $menu->add('14.1', '14', 'Campo Select - Simples', 'view/fields/exe_SelectField_01.php');
    $menu->add('14.2', '14', 'Campo Select - Combinados', 'view/fields/exe_SelectField_02.php');

$menu->add('15', '1', 'Campo Radio', 'view/fields/exe_RadioField.php');
$menu->add('16', '1', 'Campo Check', 'view/fields/exe_CheckField.php',null,'../../base/imagens/iconCheckAll.gif');
$menu->add('17', '1', 'Campo Arquivo ou Blob');
    $menu->add('171', '17', 'Campo Blob');
        $menu->add('1171', '171', 'Campo Blob Salvo no Banco', 'view/fields/exe_fwShowBlob.php');
        $menu->add('1172', '171', 'Campo Blob Salvo no Disco', 'view/fields/exe_fwShowBlobDisco.php');
    $menu->add('172', '17', 'Campo Arquivo simples');
       $menu->add('1721', '172', 'Assincrono', 'view/fields/exe_FileAsync.php');
       $menu->add('1722', '172', 'Normal', 'view/fields/exe_TFile.php');
       $menu->add('1723', '172', 'TAssincrono', 'view/fields/exe_TFileAsync.php');
    $menu->add('173', '17', 'Cadastro Arquivo Postgres', 'pdo/exe_pdo_4.php', 'Exemplo de Upload de imagem que mostra o arquivo antes de finalizar');

    
$menu->add('18', '1', 'Campo Numérico', 'view/fields/exe_NumberField.php');
$menu->add('19', '1', 'Campo Brasil', null, null, '../../base/imagens/flag_brazil.png');
    $menu->add('191', '19', 'Campo CEP', 'view/fields/exe_CepField.php');
    $menu->add('192', '19', 'Campo Telefone', 'view/fields/exe_FoneField.php');
    $menu->add('193', '19', 'Campo Cpf/Cnpj', 'view/fields/exe_campo_cpf_cnpj.php');
$menu->add('110', '1', 'Campos Data e hora');
    $menu->add('1101', '110', 'Campo Data', 'view/fields/exe_DateField.php');
    $menu->add('1102', '110', 'Campo Hora', 'view/fields/exe_campo_hora.php');
    $menu->add('1104', '110', 'Campo Agenda', 'view/fields/exe_TCalendar.php');
$menu->add('111', '1', 'Campo Select Diretorio/Pasta', 'view/fields/exe_OpenDirField.php');

$menu->add('115', '1', 'Campo Senha', 'view/fields/exe_TPasswordField.php', null, '../../base/imagens/lock16.gif');

$menu->add('117', '1', 'Campo Captcha', 'view/fields/exe_TCaptchaField.php');

$menu->add('119', '1', 'Campo Cor', 'view/fields/exe_TColorPicker.php');
$menu->add('120', '1', 'Tecla de Atalho', 'view/fields/exe_Shortcut.php');
$menu->add('121', '1', 'Campo Link', 'view/fields/exe_field_link.php');
//Redirect só funciona se o arquivo estiver na pasta modulos
$menu->add('122', '1', 'Redirect', 'exe_redirect.inc');
$menu->add('123', '1', 'TZip', 'exe_TZip.php');
$menu->add('124', '1', 'E-mail', 'view/fields/exe_TEmail.php', null, '../../base/imagens/email.png');

//-----------------------------------------------------------------------------
$menu->add('2', null, 'Containers');
    $menu->add('22', '2', 'Grupo');
        $menu->add('221', '22', 'Grupo 01 Normal', 'group/exe_GroupField01.php');
        $menu->add('222', '22', 'Grupo 02 Combinados, ( Efeito Sanfona )', 'group/exe_GroupField02.php');
        $menu->add('223', '22', 'Grupo 03 Combinados, muda cor fundo', 'group/exe_groupField03.php');
    $menu->add('23', '2', 'Abas');
        $menu->add('231', '23', 'Aba - com tecla de atalha', 'view/containers/exe_aba_1.php');
        $menu->add('232', '23', 'Aba2 - Botão ligando aba', 'view/containers/exe_aba_2.php');
        $menu->add('233', '23', 'Aba3 - select chamando aba', 'view/containers/exe_aba_3.php');
        $menu->add('234', '23', 'Aba4', 'view/containers/exe_aba_4.php');
        $menu->add('235', '23', 'Aba5', 'view/containers/exe_aba05_pagacontrol.php');
    $menu->add('24', '2', 'TreeView', null, null, '../../base/imagens/folder-39-128.png');
        $menu->add('241', '24', 'Dentro do Formulário', 'tree/exe_tree_view_1.php');
        $menu->add('242', '24', 'Fora do Formulário', 'tree/exe_tree_view_2.php', null, '../../base/imagens/folder-bw.png');
        $menu->add('243', '24', 'User Data - Array', 'tree/exe_tree_view_3.php');
        $menu->add('244', '24', 'Uf x Municípios', 'tree/exe_tree_view_4.php');
        $menu->add('245', '24', 'Uf x Municípios com SetXmlFile()', 'tree/exe_tree_view_5.php');

//-----------------------------------------------------------------------------
$menu->add('4', null, 'Mensagens e Ajuda', null, null, '../../base/imagens/feedback-512.png');
    $menu->add('40', '4', 'Hints / Tooltips', 'exe_hint.php');
    $menu->add('41', '4', 'Mensagens');
        $menu->add('411', '41', 'Exemplo 1', 'view/messages/exe_mensagem.php');
        $menu->add('412', '41', 'Caixa de Confirmação', 'view/messages/exe_confirmDialog.php');
        $menu->add('413', '41', 'Caixa de Confirmação 2', 'view/messages/exe_confirm_dialog.php');
    $menu->add('42', '4', 'Ajuda');
        $menu->add('421', '42', 'Ajuda com arquivo HTML', 'exe_campo_ajuda.php', 'Com um arquivo HTML separado', '../../base/imagens/icon_help.png');
        $menu->add('422', '42', 'Ajuda On-line (sqlite)', 'exe_documentacao_online.php', 'Confe??o do texto de ajuda gravando no banco de dados sqlite');
        $menu->add('423', '42', 'Ajuda On-line (sqlite) - ERRO', 'exe_help_online_1.php');

//-----------------------------------------------------------------------------
$menu->add('5', null, 'Ajax');
    $menu->add('51', '5', 'Exemplo 1', 'ajax/exe_ajax01.php');
    $menu->add('52', '5', 'Atualizar Campos', 'ajax/exe_ajax02.php');
    $menu->add('53', '5', 'Ajax com Semáforo', 'ajax/exe_ajax03_semaphore.php');
    $menu->add('54', '5', 'Ajax 04', 'ajax/exe_ajax04.php');
    $menu->add('55', '5', 'Ajax 05', 'ajax/exe_ajax05.php');
    $menu->add('56', '5', 'Ajax 06 - JavaScript e CSS', 'ajax/exe_ajax06_javascript_css.php');

//-----------------------------------------------------------------------------
$menu->add('6', null, 'PDF', null, null, '../../base/imagens/adobe-acrobat-pdf-file-512.png');
    $menu->add('61', '6', 'Exemplo 1', 'pdf/exe_pdf01.php');
    $menu->add('62', '6', 'Exemplo 2 - grid simples', 'pdf/exe_pdf02.php');
    $menu->add('63', '6', 'Exemplo 3, com passagem de parametros via Json', 'pdf/exe_pdf03.php');
    $menu->add('64', '6', 'Exemplo 4', 'pdf/exe_pdf04.php');
    $menu->add('65', '6', 'Exemplo 5 - PDF diversos grids', 'pdf/exe_pdf05.php');

//-----------------------------------------------------------------------------
$menu->add('8', null, 'Gride', null, null, '../../base/imagens/table16.gif');
    $menu->add('80', '8', 'Grides simples', null, null, '../../base/imagens/table16.gif');
        $menu->add('80.1', '80', 'Gride 02 - Anexos e imagens - Ajax', 'grid/exe_gride02.php');
        $menu->add('80.2', '80', 'Gride 03 - Offline', 'grid/exe_gride03.php');
        $menu->add('80.3', '80', 'Gride 04 - fwGetGrid()', 'grid/exe_gride04.php');
        $menu->add('80.4', '80', 'Gride 05 - Paginação', 'grid/exe_gride05_paginacao.php');
        $menu->add('80.5', '80', 'Gride 13 com imagens', 'grid/exe_gride13.php');
    $menu->add('81', '8', 'Grides com campos internos', null, null, '../../base/imagens/table16.gif');
        $menu->add('81.1', '81', 'Gride Campos 01 - CheckColumn', 'grid/exe_gride_field01_check.php');
        $menu->add('81.2', '81', 'Gride Campos 02 - RadioButun', 'grid/exe_gride_field02.php');
        $menu->add('81.3', '81', 'Gride Campos 03 - Select', 'grid/exe_gride_field03.php');
        $menu->add('81.4', '81', 'Gride Campos 04 - Memo', 'grid/exe_gride_field04_memo.php');
        $menu->add('81.5', '81', 'Gride 01 - botões sobre grid', 'grid/exe_gride01.php');
        $menu->add('81.6', '81', 'Gride 06 - Campos 1', 'grid/exe_gride06.php');
        $menu->add('81.7', '81', 'Gride 07 - Campos 2', 'grid/exe_gride07.php');
        $menu->add('81.8', '81', 'Gride 08 - Campos 3', 'grid/exe_gride08.php');
    $menu->add('82', '8', 'Grides Draw - desenhando Dinamicamente', null, null, '../../base/imagens/table16.gif');
        $menu->add('82.1', '82', 'Gride Draw 01 - Desativando order', 'grid/exe_gride_draw_01.php');
        $menu->add('82.2', '82', 'Gride Draw 02 - Mudando a cor da linha', 'grid/exe_gride_draw_02.php');
        
    $menu->add('83', '8', 'Exempos Grides problemas', null, null, '../../base/imagens/table16.gif');
        $menu->add('83.1', '83', 'Gride 10 - erro', 'grid/exe_gride10.php');
        $menu->add('83.2', '83', 'Gride 11 Offine 02 - erro', 'grid/exe_gride11.php');
        $menu->add('83.3', '83', 'Gride 14 - erro', 'grid/exe_gride14.php');


//-----------------------------------------------------------------------------
$menu->add('9', null, 'Banco e PDO', null, 'Exemplo de Recursos para conectar nos bancos de dados', 'data_base.png');
    $menu->add('91', '9', 'Exemplo Mysql', 'pdo/exe_pdo_1.php', null, '../../base/imagens/MySQL-Database-512.png');
    $menu->add('92', '9', 'Exemplo Sqlite e Mysql', 'pdo/exe_pdo_2.php', null, '../../base/imagens/MySQL-Database-512.png');
    $menu->add('93', '9', 'Exemplo Postgres');
        $menu->add('931', '93', 'DAO e VO', 'pdo/pg/exe_pgsql01.php');
        $menu->add('932', '93', 'Cadastro Arquivo Postgres', 'pdo/exe_pdo_4.php');
        $menu->add('933', '93', 'Postgres SQL 02', 'pdo/pg/exe_pgsql02.php');
        $menu->add('934', '93', 'Postgres SQL 03', 'pdo/pg/exe_pgsql03.php');
    $menu->add('94', '9', 'PDO Firebird', 'pdo/exe_pdo_firebird01.php');
    $menu->add('96', '9', 'Testar Conexão', 'pdo/exe_teste_conexao.php');
    $menu->add('97', '9', 'Dados de Apoio', 'pdo/exe_pdo_6_apoio.php');
    $menu->add('98', '9', 'Banco Textual DBM (db4)', 'pdo/exe_db4.php');


//-----------------------------------------------------------------------------
$menu->add('10', null, 'Formulário', null, null, '../../base/imagens/fill_form-512.png');
    $menu->add('10.1', '10', 'Form 01 - Normal', 'view/form/exe_TForm.php');
    $menu->add('10.2', '10', 'Form 02 - Subcadastro', 'view/form/exe_TForm2.php');
    $menu->add('10.3', '10', 'Form 03 - Mestre Detalhe com Ajax', 'cad_mestre_detalhe/cad_mestre_detalhe.php');
    $menu->add('10.4', '10', 'Form 04 - Consulta Pedidos', 'view/form/exe_tform4_consulta_tree_p1.php');
    $menu->add('10.5', '10', 'Form 04 - Visualizar Item', 'view/form/exe_tform4_consulta_tree_p2.php');
    $menu->add('10.6', '10', 'Form 05 - Grid Off-line', 'view/form/exe_tform4_grid-off_form.php');
    $menu->add('10.7', '10', 'Form 06 - Texto Rico TinyMCE', 'view/form/exe_TForm5.php');
    $menu->add('10.8', '10', 'Form 07 - Texto Rico CkEditor (ERRO)', 'view/form/exe_TForm5_ckeditor.php');
    $menu->add('10.9', '10', 'Boxes', 'view/form/exe_TBox.php');
    $menu->add('10.10', '10', 'Recurso de Autosize', 'view/form/exe_TForm_autosize.php');
    $menu->add('10.11', '10', 'Tela Login', 'view/form/exe_tela_login.php');
    $menu->add('10.12', '10', 'Cadastro on-line (CRUD)', 'view/form/exe_crud_online.php');
    $menu->add('10.13', '10', 'ERRO - Local Destino', 'view/form/exe_form_local_destino.php');
    
//-----------------------------------------------------------------------------
$menu->add('200', 0, 'Layouts', null, 'Exemplos de Layouts, CSS e apresentações diferentes', '../../base/imagens/art-1f3a8.png');
    $menu->add('20010', '200', 'Layout Menu Principal');
        $menu->add('20010.1', '20010', 'Layout index', 'layouts.php');
        $menu->add('20010.2', '20010', 'Temas do Menu', 'exe_menu_tema.php');
        $menu->add('20010.3', '20010', 'Esqueleto do Layout', 'exe_layout_1.php');
   $menu->add('20020', '200', 'Customizado com CSS', null, null, '../../base/imagens/css.png');
        $menu->add('20020.1', '20020', 'Customizado com CSS', 'view/form/exe_TForm3.php', null, '../../base/imagens/css.png');
        $menu->add('20020.2', '20020', 'Form Buttuns Customizado com CSS', 'view/css/exe_css_form02.php', null, '../../base/imagens/css.png');
        $menu->add('20020.3', '20020', 'Customizado grid com CSS - 01', 'view/css/exe_css_form03.php', null, '../../base/imagens/table16.gif');
        $menu->add('20020.4', '20020', 'Customizado grid com Font Awesome', 'view/css/exe_css_form04.php', null, '../../base/imagens/table16.gif');
        $menu->add('20020.5', '20020', 'Customizado grid forma antiga', 'view/css/exe_css_form05.php', null, '../../base/imagens/table16.gif');
    $menu->add('20021', '200', 'Definir Colunas no Formulário', 'view/form/exe_colunas.php');
    $menu->add('20022', '200', 'Imagem de Fundo', 'view/form/exe_TFormImage.php');


//-----------------------------------------------------------------------------
$menu->add('210', null, 'Gerador de Código', null, 'Formularios geradores de codigo', 'settings_tool_preferences-512.png');
    $menu->add('210.1', '210', 'Gerador VO/DAO', '../base/includes/gerador_vo_dao.php', null, '../../base/imagens/Icon_35-512.png');
    $menu->add('210.2', '210', 'Gerador Form VO/DAO', '../base/includes/gerador_form_vo_dao.php', null, '../../base/imagens/smiley-1-512.png');
    $menu->add('210.3', '210', 'Gerador de Sistemas', '../base/includes/gerador_sysgen.php', null, '../../base/imagens/oculos-de-sol-smiley-1F60E.png');
    

$menu->getXml();
