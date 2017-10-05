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

$res['NUM_PESSOA'][0] = 1;
$res['NOM_PESSOA'][0] = 'Luis Eugênio';
$res['VAL_SALARIO'][0] = '1.500,00';
$frm = new TForm('Gride Editavel');
$frm->addTextField('tx_especie_nativa','Espécie:',80);
$frm->setAutoComplete( 'tx_especie_nativa'
                       ,'CAR.PKG_CAD_CAR.SEL_TAXON'
                       ,'NOM_CIENTIFICO_POPULAR'
                       ,'SEQ_TAXONOMIA,DES_NOME_POPULAR'
                       ,true
                       ,null
                       ,'callback_autocomplete_especies()'
                       ,4
                       ,1000
                       ,50
                       ,null
                       );



$g = new TGrid('gd','Edit',$res,null,null,'NUM_PESSOA');
$g->addRowNumColumn();
$g->addTextColumn('nom_pessoa','Nome','NOM_PESSOA',20,20);
$col = $g->addNumberColumn('val_salario','Salário','VAL_SALARIO',10,2);
$col->addEvent('onChange','alert("Salvar:"+this.value);this.style.fontWeight="bold"');
//$col->setCss('border','0px');
$g->addDateColumn('dat_nascimento','Data:','DAT_NASCIMENTO');

$frm->addHtmlField('gride',$g);
$frm->setAction('Refresh');
$frm->show();
?>
