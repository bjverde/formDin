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

//Menu FormDin

function addMenuItem($tableMenu
                    , $idmenu
                    , $idmenu_pai
                    , $nom_menu                    
                    , $url = null
                    , $tooltip  = null
                    , $img_menu  = null
                    , $imgdisabled = null
                    , $disabled  = null
                    , $hotkey  = null
                    , $boolseparator  = null
                    , $jsonparams  = null
                    , $sit_ativo  = null
                    , $dat_inclusao  = null
                    , $dat_update  = null
                    ){
    $tableMenu['IDMENU'][] = $idmenu;
    $tableMenu['NOM_MENU'][] = $nom_menu;
    $tableMenu['IDMENU_PAI'][] = $idmenu_pai;
    $tableMenu['URL'][] = $url;
    $tableMenu['TOOLTIP'][] = $tooltip;
    $tableMenu['IMG_MENU'][] = $img_menu;
    $tableMenu['IMGDISABLED'][] = $imgdisabled;
    $tableMenu['DISABLED'][] = $disabled;
    $tableMenu['HOTKEY'][] = $hotkey;
    $tableMenu['BOOLSEPARATOR'][] = $boolseparator;
    $tableMenu['JSONPARAMS'][] = $jsonparams;
    $tableMenu['SIT_ATIVO'][] = $sit_ativo;
    $tableMenu['DAT_INCLUSAO'][] = $dat_inclusao;
    $tableMenu['DAT_UPDATE'][] = $dat_update;
    return $tableMenu;
}

function selectMenu() {
    $tableMenu = array();
    $tableMenu = addMenuItem($tableMenu,'1', null, 'Campos', null, null, 'user916.gif');
    $tableMenu = addMenuItem($tableMenu,'11', '1', 'Campo Texto', null, 'Declaração de texto');
        $tableMenu = addMenuItem($tableMenu,'11.1', '11', 'Campo Texto Simples');
            $tableMenu = addMenuItem($tableMenu,'11.1.1', '11.1', 'Campo Texto', 'view/fields/exe_TextField.php');
            $tableMenu = addMenuItem($tableMenu,'11.1.2', '11.1', 'Entrada com Máscara', 'view/fields/exe_maskField.php');
            $tableMenu = addMenuItem($tableMenu,'11.2.3', '11.1', 'Campo Memo', 'view/fields/exe_TMemo.php');
        $tableMenu = addMenuItem($tableMenu,'11.2', '11', 'Campo Texto Richo');
            $tableMenu = addMenuItem($tableMenu,'11.2.1', '11.2', 'Campo Memo com tinyMCE', 'view/fields/exe_Ttinymce.php');
            $tableMenu = addMenuItem($tableMenu,'11.2.2', '11.2', 'Campo Editor com CkEditor', 'view/fields/exe_TTextEditor.php');
        $tableMenu = addMenuItem($tableMenu,'11.3', '11', 'Campo Texto funções');
            $tableMenu = addMenuItem($tableMenu,'11.3.1', '11.3', 'Autocompletar', 'view/fields/exe_autocomplete.php');
            $tableMenu = addMenuItem($tableMenu,'11.3.2', '11.3', 'Autocompletar II', 'view/fields/exe_autocomplete2.php');
            $tableMenu = addMenuItem($tableMenu,'11.3.3', '11.3', 'Consulta On-line', 'view/fields/exe_onlinesearch.php');
            $tableMenu = addMenuItem($tableMenu,'11.3.4', '11.3', 'Consulta On-line I (ERRO)', 'view/fields/exe_onlinesearch1.php');
            $tableMenu = addMenuItem($tableMenu,'11.3.5', '11.3', 'Autocompletar 3 + Consulta On-line', 'view/fields/exe_autocomplete3.php');
    $tableMenu = addMenuItem($tableMenu,'12', '1', 'Campo HTML');
        $tableMenu = addMenuItem($tableMenu,'12.1', '12', 'Campo HTML', 'view/fields/exe_HtmlField.php');
        $tableMenu = addMenuItem($tableMenu,'12.2', '12', 'Campo HTML com iFrame', 'modulos/iframe_phpinfo/ambiente_phpinfo.php');
    $tableMenu = addMenuItem($tableMenu,'13', '1', 'Campo Coord GMS');
        $tableMenu = addMenuItem($tableMenu,'13.1', '13', 'Campo Coord GMS', 'view/fields/exe_CoordGmsField.php');
        $tableMenu = addMenuItem($tableMenu,'13.2', '13', 'Campo Coord GMS 02', 'view/fields/exe_CoordGmsField02.php');
    $tableMenu = addMenuItem($tableMenu,'14', '1', 'Campo Select');
        $tableMenu = addMenuItem($tableMenu,'14.1', '14', 'Campo Select - Simples', 'view/fields/exe_SelectField_01.php');
        $tableMenu = addMenuItem($tableMenu,'14.2', '14', 'Campo Select - Combinados', 'view/fields/exe_SelectField_02.php');
    
    $tableMenu = addMenuItem($tableMenu,'15', '1', 'Campo Radio', 'view/fields/exe_RadioField.php');
    $tableMenu = addMenuItem($tableMenu,'16', '1', 'Campo Check', 'view/fields/exe_CheckField.php',null,'../../base/imagens/iconCheckAll.gif');
    $tableMenu = addMenuItem($tableMenu,'17', '1', 'Campo Arquivo ou Blob');
        $tableMenu = addMenuItem($tableMenu,'171', '17', 'Campo Blob');
            $tableMenu = addMenuItem($tableMenu,'1171', '171', 'Campo Blob Salvo no Banco', 'view/fields/exe_fwShowBlob.php');
            $tableMenu = addMenuItem($tableMenu,'1172', '171', 'Campo Blob Salvo no Disco', 'view/fields/exe_fwShowBlobDisco.php');
        $tableMenu = addMenuItem($tableMenu,'172', '17', 'Campo Arquivo simples');
           $tableMenu = addMenuItem($tableMenu,'1721', '172', 'Assincrono', 'view/fields/exe_FileAsync.php');
           $tableMenu = addMenuItem($tableMenu,'1722', '172', 'Normal', 'view/fields/exe_TFile.php');
           $tableMenu = addMenuItem($tableMenu,'1723', '172', 'TAssincrono', 'view/fields/exe_TFileAsync.php');
        $tableMenu = addMenuItem($tableMenu,'173', '17', 'Cadastro Arquivo Postgres', 'pdo/exe_pdo_4.php', 'Exemplo de Upload de imagem que mostra o arquivo antes de finalizar');
    
        
    $tableMenu = addMenuItem($tableMenu,'18', '1', 'Campo Numérico', 'view/fields/exe_NumberField.php');
    $tableMenu = addMenuItem($tableMenu,'19', '1', 'Campo Brasil', null, null, '../../base/imagens/flag_brazil.png');
        $tableMenu = addMenuItem($tableMenu,'191', '19', 'Campo CEP', 'view/fields/exe_CepField.php');
        $tableMenu = addMenuItem($tableMenu,'192', '19', 'Campo Telefone', 'view/fields/exe_FoneField.php');
        $tableMenu = addMenuItem($tableMenu,'193', '19', 'Campo Cpf/Cnpj', 'view/fields/exe_campo_cpf_cnpj.php');
    $tableMenu = addMenuItem($tableMenu,'110', '1', 'Campos Data e hora');
        $tableMenu = addMenuItem($tableMenu,'1101', '110', 'Campo Data', 'view/fields/exe_DateField.php');
        $tableMenu = addMenuItem($tableMenu,'1102', '110', 'Campo Hora', 'view/fields/exe_campo_hora.php');
        $tableMenu = addMenuItem($tableMenu,'1104', '110', 'Campo Agenda', 'view/fields/exe_TCalendar.php');
    $tableMenu = addMenuItem($tableMenu,'111', '1', 'Campo Select Diretorio/Pasta', 'view/fields/exe_OpenDirField.php');
    
    $tableMenu = addMenuItem($tableMenu,'115', '1', 'Campo Senha', 'view/fields/exe_TPasswordField.php', null, '../../base/imagens/lock16.gif');
    
    $tableMenu = addMenuItem($tableMenu,'117', '1', 'Campo Captcha', 'view/fields/exe_TCaptchaField.php');
    
    $tableMenu = addMenuItem($tableMenu,'119', '1', 'Campo Cor', 'view/fields/exe_TColorPicker.php');
    $tableMenu = addMenuItem($tableMenu,'120', '1', 'Tecla de Atalho', 'view/fields/exe_Shortcut.php');
    $tableMenu = addMenuItem($tableMenu,'121', '1', 'Campo Link', 'view/fields/exe_field_link.php');
    //Redirect só funciona se o arquivo estiver na pasta modulos
    $tableMenu = addMenuItem($tableMenu,'122', '1', 'Redirect', 'exe_redirect.inc');
    $tableMenu = addMenuItem($tableMenu,'123', '1', 'TZip', 'exe_TZip.php');
    $tableMenu = addMenuItem($tableMenu,'124', '1', 'E-mail', 'view/fields/exe_TEmail.php', null, '../../base/imagens/email.png');
    $tableMenu = addMenuItem($tableMenu,'125', '1', 'Button', 'view/fields/exe_TButton.php', null);
    
    //-----------------------------------------------------------------------------
    $tableMenu = addMenuItem($tableMenu,'2', null, 'Containers');
        $tableMenu = addMenuItem($tableMenu,'22', '2', 'Grupo');
            $tableMenu = addMenuItem($tableMenu,'221', '22', 'Grupo 01 Normal', 'group/exe_GroupField01.php');
            $tableMenu = addMenuItem($tableMenu,'222', '22', 'Grupo 02 Combinados, ( Efeito Sanfona )', 'group/exe_GroupField02.php');
            $tableMenu = addMenuItem($tableMenu,'223', '22', 'Grupo 03 Combinados, muda cor fundo', 'group/exe_groupField03.php');
        $tableMenu = addMenuItem($tableMenu,'23', '2', 'Abas');
            $tableMenu = addMenuItem($tableMenu,'231', '23', 'Aba - com tecla de atalha', 'view/containers/exe_aba_1.php');
            $tableMenu = addMenuItem($tableMenu,'232', '23', 'Aba2 - Botão ligando aba', 'view/containers/exe_aba_2.php');
            $tableMenu = addMenuItem($tableMenu,'233', '23', 'Aba3 - select chamando aba', 'view/containers/exe_aba_3.php');
            $tableMenu = addMenuItem($tableMenu,'234', '23', 'Aba4', 'view/containers/exe_aba_4.php');
            $tableMenu = addMenuItem($tableMenu,'235', '23', 'Aba5', 'view/containers/exe_aba05_pagacontrol.php');
        $tableMenu = addMenuItem($tableMenu,'24', '2', 'TreeView', null, null, '../../base/imagens/folder-39-128.png');
            $tableMenu = addMenuItem($tableMenu,'241', '24', 'Dentro do Formulário', 'tree/exe_tree_view_1.php', null, '../../base/imagens/folder-bw.png');
            $tableMenu = addMenuItem($tableMenu,'242', '24', 'Fora do Formulário', 'tree/exe_tree_view_2.php', null, '../../base/imagens/folder-bw.png');
            $tableMenu = addMenuItem($tableMenu,'243', '24', 'User Data - Array', 'tree/exe_tree_view_3.php', null, '../../base/imagens/folder-bw.png');
            $tableMenu = addMenuItem($tableMenu,'244', '24', 'Uf x Municípios', 'tree/exe_tree_view_4.php');
            $tableMenu = addMenuItem($tableMenu,'245', '24', 'Com vários níveis', 'tree/exe_tree_view_8_multiple_levels.php');
            $tableMenu = addMenuItem($tableMenu,'246', '24', 'Uf x Municípios com SetXmlFile()', 'tree/exe_tree_view_5.php');
            $tableMenu = addMenuItem($tableMenu,'247', '24', 'TreeView with CheckBox (ERRO)', 'tree/exe_tree_view_6_check.php');
            $tableMenu = addMenuItem($tableMenu,'248', '24', 'TreeView with Drag and Drop (ERRO)', 'tree/exe_tree_view_7_drag.php');
    
    //-----------------------------------------------------------------------------
    $tableMenu = addMenuItem($tableMenu,'4', null, 'Mensagens e Ajuda', null, null, '../../base/imagens/feedback-512.png');
        $tableMenu = addMenuItem($tableMenu,'40', '4', 'Hints / Tooltips', 'exe_hint.php');
        $tableMenu = addMenuItem($tableMenu,'41', '4', 'Mensagens');
            $tableMenu = addMenuItem($tableMenu,'411', '41', 'Mensagens JS', 'view/messages/exe_mensagem.php');
            $tableMenu = addMenuItem($tableMenu,'412', '41', 'Mensagens PHP', 'view/messages/exe_mensagemv2.php');
            $tableMenu = addMenuItem($tableMenu,'413', '41', 'Caixa de Confirmação', 'view/messages/exe_confirmDialog.php');
            $tableMenu = addMenuItem($tableMenu,'414', '41', 'Caixa de Confirmação 2', 'view/messages/exe_confirm_dialog.php');
            $tableMenu = addMenuItem($tableMenu,'415', '41', 'Caixa de Confirmação 3', 'view/messages/exe_confirm_dialogv3.php');
        $tableMenu = addMenuItem($tableMenu,'42', '4', 'Ajuda');
            $tableMenu = addMenuItem($tableMenu,'421', '42', 'Ajuda com arquivo HTML', 'exe_campo_ajuda.php', 'Com um arquivo HTML separado', '../../base/imagens/icon_help.png');
            $tableMenu = addMenuItem($tableMenu,'422', '42', 'Ajuda On-line (sqlite)', 'exe_documentacao_online.php', 'Confe??o do texto de ajuda gravando no banco de dados sqlite');
            $tableMenu = addMenuItem($tableMenu,'423', '42', 'Ajuda On-line (sqlite) - ERRO', 'exe_help_online_1.php');
    
    //-----------------------------------------------------------------------------
    $tableMenu = addMenuItem($tableMenu,'5', null, 'JavaScript', null, null, '../../base/imagens/logo_js_flat.png');
        $tableMenu = addMenuItem($tableMenu,'50', '5', 'JavaScript Leia-me', 'jscript/exe_js_texto.php', null, '../../base/imagens/logo_js_flat.png');
        $tableMenu = addMenuItem($tableMenu,'51', '5', 'Exemplo 1', 'ajax/exe_ajax01.php');
        $tableMenu = addMenuItem($tableMenu,'52', '5', 'Atualizar Campos', 'ajax/exe_ajax02.php');
        $tableMenu = addMenuItem($tableMenu,'53', '5', 'Ajax com Semáforo', 'ajax/exe_ajax03_semaphore.php');
        $tableMenu = addMenuItem($tableMenu,'54', '5', 'Ajax 04', 'ajax/exe_ajax04.php');
        $tableMenu = addMenuItem($tableMenu,'55', '5', 'Ajax 05', 'ajax/exe_ajax05.php');
        $tableMenu = addMenuItem($tableMenu,'56', '5', 'Ajax 06 - JavaScript e CSS', 'ajax/exe_ajax06_javascript_css.php');
        $tableMenu = addMenuItem($tableMenu,'57', '5', 'Esconder campos', 'jscript/exe_js_fileds.php', null, '../../base/imagens/logo_js_flat.png');
    
    //-----------------------------------------------------------------------------
    $tableMenu = addMenuItem($tableMenu,'6', null, 'PDF', null, null, '../../base/imagens/adobe-acrobat-pdf-file-512.png');
        $tableMenu = addMenuItem($tableMenu,'61', '6', 'Exemplo 1', 'pdf/exe_pdf01.php');
        $tableMenu = addMenuItem($tableMenu,'62', '6', 'Exemplo 2 - grid simples', 'pdf/exe_pdf02.php');
        $tableMenu = addMenuItem($tableMenu,'63', '6', 'Exemplo 3, com passagem de parametros via Json', 'pdf/exe_pdf03.php');
        $tableMenu = addMenuItem($tableMenu,'64', '6', 'Exemplo 4', 'pdf/exe_pdf04.php');
        $tableMenu = addMenuItem($tableMenu,'65', '6', 'Exemplo 5 - PDF diversos grids', 'pdf/exe_pdf05.php');
        $tableMenu = addMenuItem($tableMenu,'66', '6', 'Exemplo 6 - Grid chamando PDF', 'pdf/exe_pdf06_grid.php');
    
    //-----------------------------------------------------------------------------
    $tableMenu = addMenuItem($tableMenu,'8', null, 'Gride', null, null, '../../base/imagens/table16.gif');
        $tableMenu = addMenuItem($tableMenu,'80', '8', 'Grides simples', null, null, '../../base/imagens/table16.gif');
            $tableMenu = addMenuItem($tableMenu,'80.1', '80', 'Gride 02 - Anexos e imagens - Ajax', 'grid/exe_gride02.php');
            $tableMenu = addMenuItem($tableMenu,'80.2', '80', 'Gride 03 - Offline', 'grid/exe_gride03.php');
            $tableMenu = addMenuItem($tableMenu,'80.3', '80', 'Gride 04 - fwGetGrid()', 'grid/exe_gride04.php');
            $tableMenu = addMenuItem($tableMenu,'80.4', '80', 'Gride 05 - Paginação', 'grid/exe_gride05_paginacao.php');
            $tableMenu = addMenuItem($tableMenu,'80.5', '80', 'Gride 13 com imagens', 'grid/exe_gride13.php');
        $tableMenu = addMenuItem($tableMenu,'81', '8', 'Grides com campos internos', null, null, '../../base/imagens/table16.gif');
            $tableMenu = addMenuItem($tableMenu,'81.1', '81', 'Gride Campos 01 - CheckColumn', 'grid/exe_gride_field01_check.php');
            $tableMenu = addMenuItem($tableMenu,'81.2', '81', 'Gride Campos 02 - RadioButun', 'grid/exe_gride_field02.php');
            $tableMenu = addMenuItem($tableMenu,'81.3', '81', 'Gride Campos 03 - Select', 'grid/exe_gride_field03.php');
            $tableMenu = addMenuItem($tableMenu,'81.4', '81', 'Gride Campos 04 - Memo', 'grid/exe_gride_field04_memo.php');
            $tableMenu = addMenuItem($tableMenu,'81.5', '81', 'Gride Campos 05 - Oculto', 'grid/exe_gride_field05_hidden.php');
            $tableMenu = addMenuItem($tableMenu,'81.6', '81', 'Gride 01 - botões sobre grid', 'grid/exe_gride01.php');
            $tableMenu = addMenuItem($tableMenu,'81.7', '81', 'Gride 06 - Campos 1', 'grid/exe_gride06.php');
            $tableMenu = addMenuItem($tableMenu,'81.8', '81', 'Gride 07 - Campos 2', 'grid/exe_gride07.php');
            $tableMenu = addMenuItem($tableMenu,'81.9', '81', 'Gride 08 - Campos 3', 'grid/exe_gride08.php');
        $tableMenu = addMenuItem($tableMenu,'82', '8', 'Grides Draw - desenhando Dinamicamente', null, null, '../../base/imagens/table16.gif');
            $tableMenu = addMenuItem($tableMenu,'82.1', '82', 'Gride Draw 01 - Desativando order', 'grid/exe_gride_draw_01.php');
            $tableMenu = addMenuItem($tableMenu,'82.2', '82', 'Gride Draw 02 - Mudando a cor da linha', 'grid/exe_gride_draw_02.php');
            $tableMenu = addMenuItem($tableMenu,'82.3', '82', 'Gride Draw 03 - Desativando Botões v1', 'grid/exe_gride_draw_03.php');
            $tableMenu = addMenuItem($tableMenu,'82.4', '82', 'Gride Draw 04 - Desativando Botões v2', 'grid/exe_gride_draw_04.php');
            $tableMenu = addMenuItem($tableMenu,'82.5', '82', 'Gride Draw 05 - addFooter e cor da linha', 'grid/exe_gride_draw_05.php');
            
        $tableMenu = addMenuItem($tableMenu,'83', '8', 'Exempos Grides problemas', null, null, '../../base/imagens/table16.gif');
            $tableMenu = addMenuItem($tableMenu,'83.1', '83', 'Gride 10 - erro', 'grid/exe_gride10.php');
            $tableMenu = addMenuItem($tableMenu,'83.2', '83', 'Gride 11 Offine 02 - erro', 'grid/exe_gride11.php');
            $tableMenu = addMenuItem($tableMenu,'83.3', '83', 'Gride 14 - erro', 'grid/exe_gride14.php');
    
    
    //-----------------------------------------------------------------------------
    $tableMenu = addMenuItem($tableMenu,'9', null, 'Banco e PDO', null, 'Exemplo de Recursos para conectar nos bancos de dados', 'data_base.png');
        $tableMenu = addMenuItem($tableMenu,'9.1', '9', 'Exemplo Mysql', 'pdo/exe_pdo_1.php', null, '../../base/imagens/MySQL-Database-512.png');
        $tableMenu = addMenuItem($tableMenu,'9.2', '9', 'Exemplo Sqlite e Mysql', 'pdo/exe_pdo_2.php', null, '../../base/imagens/MySQL-Database-512.png');
        $tableMenu = addMenuItem($tableMenu,'9.3', '9', 'Exemplo Postgres');
            $tableMenu = addMenuItem($tableMenu,'9.3.1', '93', 'DAO e VO', 'pdo/pg/exe_pgsql01.php');
            $tableMenu = addMenuItem($tableMenu,'9.3.2', '93', 'Cadastro Arquivo Postgres', 'pdo/exe_pdo_4.php');
            $tableMenu = addMenuItem($tableMenu,'9.3.3', '93', 'Postgres SQL 02', 'pdo/pg/exe_pgsql02.php');
            $tableMenu = addMenuItem($tableMenu,'9.3.4', '93', 'Postgres SQL 03', 'pdo/pg/exe_pgsql03.php');
        $tableMenu = addMenuItem($tableMenu,'9.4', '9', 'PDO Firebird', 'pdo/exe_pdo_firebird01.php');
        $tableMenu = addMenuItem($tableMenu,'9.6', '9', 'Testar Conexão', 'pdo/exe_teste_conexao.php');
        $tableMenu = addMenuItem($tableMenu,'9.7', '9', 'Dados de Apoio', 'pdo/exe_pdo_6_apoio.php');
        $tableMenu = addMenuItem($tableMenu,'9.8', '9', 'Banco Textual DBM (db4)', 'pdo/exe_db4.php');
        $tableMenu = addMenuItem($tableMenu,'9.9', '9', 'Transação');
            $tableMenu = addMenuItem($tableMenu,'9.9.1', '9.9', 'Commit', 'pdo/exe_pdo_transaction_commit.php', null, '../../base/imagens/database_commit.png');
            $tableMenu = addMenuItem($tableMenu,'9.9.2', '9.9', 'RollBack', 'pdo/exe_pdo_transaction_commit.php', null, '../../base/imagens/database_rollback.png');
        $tableMenu = addMenuItem($tableMenu,'9.10', '9', 'Multiplos SBGDs ou Bancos', 'pdo/exe_pdo_multidabase.php', null, '../../base/imagens/database_balance.png');
    
    
    //-----------------------------------------------------------------------------
    $tableMenu = addMenuItem($tableMenu,'10', null, 'Formulário', null, null, '../../base/imagens/fill_form-512.png');
    
        $tableMenu = addMenuItem($tableMenu,'10.01', '10', 'Recursos do Formulário');
            $tableMenu = addMenuItem($tableMenu,'10.0.1', '10.01', 'Recurso de Autosize', 'view/form/exe_TForm_autosize.php');
            $tableMenu = addMenuItem($tableMenu,'10.0.2', '10.01', 'Boxes', 'view/form/exe_TBox.php');
            $tableMenu = addMenuItem($tableMenu,'10.0.3', '10.01', 'Maximizar', 'view/form/exe_max.php');
            $tableMenu = addMenuItem($tableMenu,'10.0.4', '10.01', 'Inicia Maximizar', 'view/form/exe_max_start.php');
        $tableMenu = addMenuItem($tableMenu,'10.1', '10', 'Exemplos de Formulários', null, null, '../../base/imagens/fill_form-512.png');
            $tableMenu = addMenuItem($tableMenu,'10.1.1', '10.1', 'Form 01 - Normal', 'view/form/exe_TForm.php');
            $tableMenu = addMenuItem($tableMenu,'10.1.2', '10.1', 'Form 02 - Subcadastro', 'view/form/exe_TForm2.php');
            $tableMenu = addMenuItem($tableMenu,'10.1.3', '10.1', 'Form 03 - Mestre Detalhe com Ajax', 'cad_mestre_detalhe/cad_mestre_detalhe.php');
            $tableMenu = addMenuItem($tableMenu,'10.1.4', '10.1', 'Form 04 - Consulta Pedidos', 'view/form/exe_tform4_consulta_tree_p1.php');
            $tableMenu = addMenuItem($tableMenu,'10.1.5', '10.1', 'Form 04 - Visualizar Item', 'view/form/exe_tform4_consulta_tree_p2.php');
            $tableMenu = addMenuItem($tableMenu,'10.1.6', '10.1', 'Form 05 - Grid Off-line', 'view/form/exe_tform4_grid-off_form.php');
            $tableMenu = addMenuItem($tableMenu,'10.1.7', '10.1', 'Form 06 - Texto Rico TinyMCE (ERRO)', 'view/form/exe_TForm5.php');
            $tableMenu = addMenuItem($tableMenu,'10.1.8', '10.1', 'Form 07 - Texto Rico CkEditor (ERRO)', 'view/form/exe_TForm5_ckeditor.php');
            $tableMenu = addMenuItem($tableMenu,'10.1.9', '10.1', 'Form 08 - Grid Duplo Paginado', 'view/form/exe_form_gride_paginacao_dupla.php');
        $tableMenu = addMenuItem($tableMenu,'10.9', '10', 'Agenda');
            $tableMenu = addMenuItem($tableMenu,'10.9.1', '10.9', 'Cadastro de Horarios disponiveis', 'view/form/horario_atendimento.php');
            $tableMenu = addMenuItem($tableMenu,'10.9.2', '10.9', 'Cadastro de Pessoas', 'view/form/pessoa.php');
        $tableMenu = addMenuItem($tableMenu,'10.11', '10', 'Tela Login', 'view/form/exe_tela_login.php');
        $tableMenu = addMenuItem($tableMenu,'10.12', '10', 'Cadastro on-line (CRUD)', 'view/form/exe_crud_online.php');
        $tableMenu = addMenuItem($tableMenu,'10.13', '10', 'ERRO - Local Destino', 'view/form/exe_form_local_destino.php');
        
    //-----------------------------------------------------------------------------
    $tableMenu = addMenuItem($tableMenu,'200', 0, 'Layouts', null, 'Exemplos de Layouts, CSS e apresentações diferentes', '../../base/imagens/art-1f3a8.png');
        $tableMenu = addMenuItem($tableMenu,'20010', '200', 'Layout Menu Principal');
            $tableMenu = addMenuItem($tableMenu,'20010.1', '20010', 'Layout index', 'layouts.php');
            $tableMenu = addMenuItem($tableMenu,'20010.2', '20010', 'Temas do Menu', 'exe_menu_tema.php');
            $tableMenu = addMenuItem($tableMenu,'20010.3', '20010', 'Esqueleto do Layout', 'exe_layout_1.php');
       $tableMenu = addMenuItem($tableMenu,'20020', '200', 'Customizado com CSS', null, null, '../../base/imagens/css.png');
            $tableMenu = addMenuItem($tableMenu,'20020.1', '20020', 'Customizado com CSS', 'view/form/exe_TForm3.php', null, '../../base/imagens/css.png');
            $tableMenu = addMenuItem($tableMenu,'20020.2', '20020', 'Form Buttuns Customizado com CSS', 'view/css/exe_css_form02.php', null, '../../base/imagens/css.png');
            $tableMenu = addMenuItem($tableMenu,'20020.3', '20020', 'Customizado grid com CSS - 01', 'view/css/exe_css_form03.php', null, '../../base/imagens/table16.gif');
            $tableMenu = addMenuItem($tableMenu,'20020.4', '20020', 'Customizado grid com Font Awesome', 'view/css/exe_css_form04.php', null, '../../base/imagens/table16.gif');
            $tableMenu = addMenuItem($tableMenu,'20020.5', '20020', 'Customizado grid forma antiga', 'view/css/exe_css_form05.php', null, '../../base/imagens/table16.gif');
        $tableMenu = addMenuItem($tableMenu,'20021', '200', 'Definir Colunas no Formulário', 'view/form/exe_colunas.php');
        $tableMenu = addMenuItem($tableMenu,'20022', '200', 'Formulário Borda Redonda', 'view/form/exe_borda.php');
        $tableMenu = addMenuItem($tableMenu,'20023', '200', 'Imagem de Fundo', 'view/form/exe_TFormImage.php');
    
    
    //-----------------------------------------------------------------------------
    $tableMenu = addMenuItem($tableMenu,'210', null, 'Gerador de Código', null, 'Formularios geradores de codigo', 'settings_tool_preferences-512.png');
        $tableMenu = addMenuItem($tableMenu,'210.1', '210', 'Gerador VO/DAO', '../base/includes/gerador_vo_dao.php', null, '../../base/imagens/Icon_35-512.png');
        $tableMenu = addMenuItem($tableMenu,'210.2', '210', 'Gerador Form VO/DAO', '../base/includes/gerador_form_vo_dao.php', null, '../../base/imagens/smiley-1-512.png');
        $tableMenu = addMenuItem($tableMenu,'210.3', '210', 'Gerador de Sistemas', '../base/includes/gerador_sysgen.php', null, '../../base/imagens/oculos-de-sol-smiley-1F60E.png');
    return $tableMenu;
}



$primaryKey = 'IDMENU';
$frm = new TForm('Cadastro de Menu',1000,1000);
$frm->setShowCloseButton(false);
$frm->setFlat(true);
$frm->setMaximize(true);

$frm->addTextField('NOM_MENU', 'Nome do Menu',45,true,45);
$frm->getLabel('NOM_MENU')->setToolTip('o nome que o usuario irá ver');

$listAcesso_menu = selectMenu();
$frm->addSelectField('IDMENU_PAI', 'Pai do Menu',FALSE,$listAcesso_menu,null,null,null,null,null,null,' ',null);
$frm->getLabel('IDMENU_PAI')->setToolTip('id do menu pai, se o pai é null então começa na raiz');
$frm->addMemoField('URL', 'URL',300,false,80,3);
$frm->getLabel('URL')->setToolTip('caminho do item de menu');
$frm->addMemoField('TOOLTIP', 'TOOLTIP',300,false,80,3);
$frm->getLabel('TOOLTIP')->setToolTip('decrição mais detalhada do menu');
$frm->addTextField('IMG_MENU', 'IMG_MENU',45,false,45);
$frm->getLabel('IMG_MENU')->setToolTip('Caminho da imagem será utilizada como ícone');
$frm->addTextField('IMGDISABLED', 'IMGDISABLED',45,false,45);
$frm->getLabel('IMGDISABLED')->setToolTip('Caminho da imagem para o menu desabilitado');
$frm->addSelectField('DISABLED', 'DISABLED:', true, 'N=Não,S=Sim', true);


$dados = selectMenu();
//var_dump($dados);

$frm->addGroupField('gpTree','Menus em Treeview')->setcloseble(true);
$userData = array('IDMENU_PAI','NOM_MENU','URL','TOOLTIP','IMG_MENU','IMGDISABLED','DISSABLED','HOTKEY','BOOLSEPARATOR','JSONPARAMS','SIT_ATIVO','DAT_INCLUSAO','DAT_UPDATE');
$tree = $frm->addTreeField('tree'
                           ,null
                           ,$dados
                           ,'IDMENU_PAI'
                           ,$primaryKey    // 05: id do campo chave dos filhos
                           ,'NOM_MENU'
                           ,null
                           ,$userData
                           ,null
                           ,null           //10: largura
                           ,null
                           ,null
                           ,null
                           ,null           //14: Habilita campo Checks
                           ,null           //15: 
                           ,null
                           ,null
                           ,null
                           ,null
                           ,null //19:
                           ,null //20:
                           ,null           //21:
                           ,null           //22:
                           ,true           //23: Se o TreeView deve iniciar expandido ou não
                        );
//$tree->setStartExpanded(false);
//$tree->setStartExpanded(true);
$tree->setOnClick('treeClick'); // fefinir o evento que ser? chamado ao clicar no item da treeview
$frm->closeGroup();

$frm->show();
?>
<script>
function treeClick(id) {
	
	/*
	alert( 'Item id:'+treeJs.getSelectedItemId()+'\n'+
	'Item text:'+treeJs.getItemText(id )+'\n'+
	'User pai:'+treeJs.getUserData(id,'IDMENU_PAI')+'\n'+
	'User data URL:'+treeJs.getUserData(id,'URL')+'\n'+
	'IMG:'+treeJs.getUserData(id,'IMG_MENU')
	);
	*/
	
	// atualizar os campos do formulário
	jQuery("#IDMENU").val(treeJs.getSelectedItemId());
	jQuery("#NOM_MENU").val(treeJs.getItemText(id ));
	jQuery("#IDMENU_PAI").val(treeJs.getUserData(id,'IDMENU_PAI'));
	jQuery("#URL").val(treeJs.getUserData(id,'URL'));
	jQuery("#TOOLTIP").val(treeJs.getUserData(id,'TOOLTIP'));
	jQuery("#IMG_MENU").val(treeJs.getUserData(id,'IMG_MENU'));
	jQuery("#IMGDISABLED").val(treeJs.getUserData(id,'IMGDISABLED'));
	jQuery("#DISABLED").val(treeJs.getUserData(id,'DISABLED'));
	jQuery("#HOTKEY").val(treeJs.getUserData(id,'HOTKEY'));
	jQuery("#BOOLSEPARATOR").val(treeJs.getUserData(id,'BOOLSEPARATOR'));
	jQuery("#JSONPARAMS").val(treeJs.getUserData(id,'JSONPARAMS'));
	jQuery("#DAT_INCLUSAO").val(treeJs.getUserData(id,'DAT_INCLUSAO'));
	jQuery("#DAT_UPDATE").val(treeJs.getUserData(id,'DAT_UPDATE'));
	
}
</script>
