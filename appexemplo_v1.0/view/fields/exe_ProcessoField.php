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

$frm = new TForm('Campos de processos');

$frm->addGroupField('Federal','Campos do Processo Federal');
    $frm->addProcessoField('processo2','Apenas Campo de processo federal: ',false,true,null,null,null,true,false)->setExampleText('Ex: 08190.000000/22-65 ou 02000.000343/2020-51');
    $frm->addProcessoField('processo3','Apenas Campo de processo federal (SEI): ',false,true,null,null,null,false,true)->setExampleText('Ex: 19.04.4192.0000009/2022-80');
    $frm->addProcessoField('processo4','Campo de processo federal (SEI): ',false,true,null,null,null,true,true)->setExampleText('Todos os números anteriores');
$frm->closeGroup();

$frm->addGroupField('TJDFT','Campos do Processo Judiciário');
    $frm->addNumeroTJDFTField('numeroTJDFT','Campo do número Único/Distribuição do TJDFT: ',false,true,null,null,null,true,true)->setExampleText('Ex: 0700444-79.2021.8.07.0003 ou 1999.01.1.001573-8');
    $frm->addNumeroTJDFTField('numeroUnicoTJDFT','Campo do número Único do TJDFT: ',false,true,null,null,null,false,true)->setExampleText('Ex: 0700444-79.2021.8.07.0003');
    $frm->addNumeroTJDFTField('numeroDistribuicaoTJDFT','Campo do número Distribuição do TJDFT: ',false,true,null,null,null,true,false)->setExampleText('Ex: 1999.01.1.001573-8');
$frm->closeGroup();

$frm->setHint('numeroTJDFT','Aceita o número Único e o número de Distribuição');
$frm->setHint('numeroUnicoTJDFT','Aceita apenas o número Único');
$frm->setHint('numeroDistribuicaoTJDFT','Aceita apenas o número de Distribuição');
$frm->set('processo', '02000.000343/2020-51');
$frm->set('numeroTJDFT', '0700444-79.2021.8.07.0003');

$frm->show();
