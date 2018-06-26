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

error_reporting(E_ALL);
$frm = new TForm('Gride Com Colunas Checkbox', 480, 500);
$frm->setFlat(false);

$frm->addSelectField('cod_uf', 'Uf:');
$frm->addTextField('nom_pessoa', 'Nome:', '30', false, null, 'Nome de Teste ação');
$frm->addSelectField('cod_bioma', 'Bioma:', false, '1=Cerrado,2=Mata Atlântica,3=Bioma 3', null, null, null, true, 4);

$frm->addGroupField('gp', 'Gr');
    $frm->addHtmlField('gride');
$frm->closeGroup();

$frm->addJsFile('jquery/facebox/facebox.js');
$frm->addCssFile('jquery/facebox/facebox.css');
$frm->addSelectField('cod_uf', 'Estado:')->setOptions($frm->getUfs("COD_UF,SIG_UF"));

$gride = new TGrid('gd5', 'Gride Nº 5', 'TESTE.PKG_MOEDA.SEL_MOEDA', 50, null, null, null, null, null, 'gd5OnDrawCell', 'gd5OnDrawRow', null, 'gd5onDrawButton');
$gride->addExcelHeadField('Estado', 'cod_uf');
$gride->addExcelHeadField('Nome', 'nom_pessoa');
$gride->addExcelHeadField('Biomas', 'cod_bioma');

$gride->addCheckColumn('sig_moeda', 'SIGLA', 'SEQ_MOEDA', 'SIG_MOEDA')->setWidth(200);
//$gride->addSelectColumn('sig_moeda','SIGLA','SEQ_MOEDA','TESTE.PKG_MOEDA.SEL_MOEDA')->setWidth(200);
$gride->addColumn('SEQ_MOEDA', 'ID', 100, 'Center');
$gride->addButton('Selecionar 1', null, 'btnSelecionar1', 'fwModalBox("Exemplo de subcadastro","index.php?modulo=base/exemplos/cad_fruta.inc",350,810)');
$gride->addButton('Selecionar 2', null, 'btnSelecionar2', 'fwFaceBoxIframe("index.php?modulo=base/exemplos/cad_fruta.inc",310,810);');
$frm->getField('gride')->add($gride);
//$frm->addMemoField('memo','obs:',2000,false,60,10);
$frm->addButton('Teste');

$frm->setAction('Refresh');
$frm->show();
?>
<script>
function fRetorno()
{
    //alert( document.getElementById('memo').innerHTML);
    alert( document.getElementById('memo').value);
}
function btnTesteOnClick()
{


    //fwFaceBox('<textarea name="memo" id="memo" maxlength="2000" size="2000" cols="40" rows="10" wrap="virtual"></textarea>',false,200,300,fRetorno);
    //return;
    var ln = parseInt(fwGetObj('gd5').getAttribute('row_count'));
    for( i=1;i<=ln;i++)
    {
        var chk = fwGetObj('sig_moeda_'+i);
        if( chk )
        {
            if (chk.checked)
            {
                var v = trim(fwGetObj('sig_moeda_desc_'+i).innerHTML);
                alert( v );
            }
        }
    }
}
</script>
