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

$frm = new TForm('Dados de Apoio', 450, 700);
$frm->setAutosize(true);
$frm->addGroupField('gpTipoDado', 'Tipo de Dado');
    $frm->addSelectField('seq_dado_apoio', 'Tipo Dado:', false, null, true, false, null, null, null, null, '&lt;Registrar tipo de dado novo&gt;', null, 'SEQ_DADO_APOIO', 'TIP_DADO_APOIO');
    $frm->addTextField('tip_dado_apoio', 'Descrição', 100, true, 80);
    $frm->addTextField('sig_dado_apoio', 'Sigla', 25, true);
    $frm->addSelectField('bol_cancelado', 'Inativo', true, '0=Não,1=Sim');
$frm->closeGroup();

$frm->addGroupField('gpDado', 'Dados');
    $frm->addHtmlField('gride');
    $frm->addSelectField('num_registros_novos', 'Nº de registros novos no gride', false, "1=1,2=2,3=3,4=4,5=5,6=6,7=7,8=8,9=9,10=10", true, true);
$frm->closeGroup();

// valor default para o numero de registros
if (!$frm->getValue('num_registros_novos')) {
    $frm->setValue('num_registros_novos', 2);
}

// adicionar evento aos campos
$frm->getField('seq_dado_apoio')->setEvent('onChange', 'fwFazerAcao("atualizar")');
$frm->getField('num_registros_novos')->setEvent('onChange', 'fwFazerAcao("atualizar")');

// remover os campos se o tipo de  dados não estiver selecionado
if (!$frm->getValue('seq_dado_apoio')) {
    $frm->removeField(array('bol_cancelado','gride','gpDado','num_registros_novos'));
}
// estabelecer conexão
TPDOConnection::connect('config_conexao.php');

// SWITCH DA ACAO
$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'Novo':
        $frm->clearFields();
        $_POST['formDinAcao']='';
        break;
    //------------------------------------------------------------------------------
    case 'Gravar':
        if (!$frm->get('seq_dado_apoio')) {
            if ($frm->validate()) {
                $bvars = $frm->createBvars('tip_dado_apoio,sig_dado_apoio');
                $bvars['BOL_CANCELADO']='false';
                if (TPDOConnection::executeSql("insert into dado_apoio (tip_dado_apoio,sig_dado_apoio,bol_cancelado) values (?,?,?)", $bvars)) {
                    $frm->setMessage('Registro gravado com sucesso!!!');
                    $frm->clearFields();
                }
            }
        } else {
            $bvars = $frm->createBvars('seq_dado_apoio|SEQ_DADO_APOIO_PAI');
            foreach ($_POST['text_tip_dado_apoio'] as $k => $v) {
                if (( $k < 0  && strlen($_POST['text_tip_dado_apoio'][$k]) > 0 )
                    ||  $_POST['text_tip_dado_apoio'][$k] != $_POST['text_tip_dado_apoio_atual'][$k]
                    ||  $_POST['text_bol_cancelado'][$k] != $_POST['text_bol_cancelado_atual'][$k] ) {
                    $bvars = $frm->createBvars('seq_dado_apoio|SEQ_DADO_APOIO_PAI');
                    $bvars['TIP_DADO_APOIO'] = $_POST['text_tip_dado_apoio'][$k];
                    $bvars['BOL_CANCELADO'] = $_POST['text_bol_cancelado'][$k];
                    TPDOConnection::executeSql('insert into dado_apoio( seq_dado_apoio_pai, tip_dado_apoio,bol_cancelado) values (?,?,?)', $bvars);
                    d($bvars);
                }
            }
        }
        break;
        /*
            if( ! $frm->addError(executarPacote(ESQUEMA.'.PKG_DADOS_APOIO.INC_ALT_TIPO_DADO',$_POST,-1)) )
            {
                if( (integer) $frm->getValue('seq_dado_apoio')==0)
                {
                    $frm->setPopUpMessage('Tipo dado incluído com sucesso!!!');
                    $frm->clearFields();
                }
                else
                {
                    $bvars = $frm->createBvars('seq_dado_apoio');
                    foreach ($_POST['text_des_apoio'] as $k=>$v)
                    {
                        if( ( $k < 0  && strlen($_POST['text_des_apoio'][$k]) > 0 )
                            ||  $_POST['text_des_apoio'][$k] != $_POST['text_des_apoio_atual'][$k]
                            ||  $_POST['text_sit_cancelado'][$k] != $_POST['text_sit_cancelado_atual'][$k] )
                            {
                                $bvars['seq_dado_apoio'][] = $k;
                                $bvars['des_apoio'][] = $_POST['text_des_apoio'][$k];
                                $bvars['sit_cancelado'][] = $_POST['text_sit_cancelado'][$k];
                            }
                    }
                    if( !$frm->addError(executarPacote(ESQUEMA.'.PKG_DADOS_APOIO.INC_ALT_DADO_APOIO',$bvars)) )
                    {
                        $frm->setPopUpMessage('Tipo dado alterado com sucesso!!!');
                    }
                }
            }
            */
        
    break;
}
//--------------------------------------------------------------------------------------------------
// preencher os cambos
$bvars = null;

//print_r(recuperarPacote(ESQUEMA.'.PKG_DADOS_APOIO.SEL_TIPO_DADOS',$bvars,$res_tipo_dados,-1));
$res_tipo_dados = TPDOConnection::executeSql('select * from dado_apoio where seq_dado_apoio_pai is null order by tip_dado_apoio');
$frm->setOptionsSelect('seq_dado_apoio', $res_tipo_dados, 'TIP_DADO_APOIO', 'SEQ_DADO_APOIO');


// remover os campos se o tipo de  dados não estiver selecionado
if (!$frm->getValue('seq_dado_apoio')) {
    $frm->removeField(array('bol_cancelado','gride','gpDado','num_registros_novos'));
}

// criar o gride com os dados para inclusão / aleração
if ($frm->getValue('seq_dado_apoio')) {
    $bvars = $frm->createBvars('seq_dado_apoio');
    $res_tipo_dado = TPDOConnection::executeSql("select seq_dado_apoio, tip_dado_apoio,sig_dado_apoio, bol_cancelado from dado_apoio where seq_dado_apoio_pai=?", $bvars);
    //$frm->update($res_tipo_dado);
    /*for ($i=1; $i<=$frm->getValue('num_registros_novos');$i++)
    {
        $res_tipo_dado['SEQ_DADO_APOIO'][]  = -$i;
        $res_tipo_dado['TIP_DADO_APOIO'][]  = '';
        $res_tipo_dado['BOL_CANCELADO'][]   = 'false';
    }
    */
    $gride = new TGrid('gride', null, $res_tipo_dado, null, null, 'SEQ_DADO_APOIO', 'SEQ_DADO_APOIO');
    $gride->enableDefaultButtons(false);
    // campos ocultos do gride
    //$gride->addHiddenField('BOL_CANCELADO'        ,'text_bol_cancelado_atual');
    //$gride->addHiddenField('TIP_DADO_APOIO'       ,'text_tip_dado_apoio_atual');
    //$gride->addSelectColumn('TEXT_BOL_CANCELADO','Inativo ?','BOL_CANCELADO',array('N'=>'Não','Y'=>'Sim'));
    $gride->addTextColumn('tip_dado_apoio', 'Descrição', 'TIP_DADO_APOIO', 80, 100);
    $frm->setValue('gride', $gride);
    //$frm->setValue('gride',$gride->show(false));


    // desabilitar o campo da sigla
    $frm->disableFields('sig_dado_apoio');
    $frm->removeField(array('tip_dado_apoio,bol_cancelado'));
}
//--------------------------------------------------------------------------------------------------
$frm->setAction('Gravar,Novo');
$frm->show();
