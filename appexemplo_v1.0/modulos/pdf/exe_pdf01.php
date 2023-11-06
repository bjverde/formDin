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

require_once 'exe_pdf_msg.php';

//error_reporting(~E_NOTICE);
if (RequestHelper::get('formDinAcao') == 'gerar_pdf') {
    gerar_pdf();
    return;
}
$frm = new TForm('Exemplo de Geração de PDF', 240);
$html1 = getMsgFPDF();

$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');
$frm->addHtmlField('msg', '<b><h3>Exemplo de utilização da classe TPDF, utilizando o metodo Row() para criar uma listagem simpes de Nome e Cpf</h3></b>
<br>Utilizei o método setOnDrawCell para definir uma função de callback para alterar as propriedade da celula do cpf quando for o usuário de teste.');
$frm->addTextField('des_marcadagua', 'Marca d´agua:', 30, null, null, 'RELATÓRIO EXEMPLO I');
$frm->addButton('Gerar Pdf', null, 'btnPdf', 'exibir_pdf()');
$frm->show();

function gerar_pdf()
{
    $rel = new TPDF('P', 'mm', 'A4');

    /*
    $rel->AddPage();
    for($i=1;$i<100;$i++)
    {
        $rel->cell(0,5,'Linha:'.$i,1,1);
    }
    $rel->show();
    die;
    */
    $rel->setWaterMark($_REQUEST['des_marcadagua']);
    $rel->setOnDrawCell('myOdc');
    // criação do relatório em colunas utilizando row
    $dados=null;
    // CPF diferente do loop
    $dados['NUM_CPF'][]     = '111.111.111-11';
    $dados['NOM_PESSOA'][]  = StringHelper::utf8_decode_windows1252('Usuário de teste');

    for ($i=0; $i<100; $i++) {
        $dados['NUM_CPF'][]     = '123.456.789-09';
        $dados['NOM_PESSOA'][]  = StringHelper::utf8_decode_windows1252('Usuário de teste');
    }
    $rel->setData($dados);
    $rel->addColumn('Nome', 100, 'L', 'NOM_PESSOA', '', 'I', 8, 'black', 'times');
    $rel->addColumn('Cpf', 50, 'C', 'NUM_CPF', '', 'B', 6, 'black', 'arial');
    $rel->printRows();
    $rel->ln(5);
    $rel->cell(0, 5, 'Imprimir o gride novamente', 1, 1, 'c');
    $rel->ln(5);
    $rel->printRows();
    $rel->show();
}

function myOdc(TPDFColumn $oCol = null, $value = null, $colIndex = null)
{
    if ($oCol->getFieldName() == 'NUM_CPF' && $value=='111.111.111-11') {
        $oCol->setFontColor('red');
        $oCol->setFillColor('yellow');
        $value = 'OPA!! NOVO NOME';
    } else {
        $oCol->setFontColor('black');
        $oCol->setFillColor('white');
    }
}
// função chamada automaticamente pela classe TPDF quando existir
function cabecalho(TPDF $pdf)
{
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 5, utf8_decode('Cabecalho do Relatório'), 'b', 1, 'C');
    $pdf->ln(3);
    $pdf->SetFont('Times', '', 10);
}
// função chamada automaticamente pela classe TPDF quando existir
function rodape(TPDF $pdf)
{

        $fs=$pdf->getFontSize();
        $pdf->SetY(-15);
        $pdf->SetFont('', '', 8);
        $pdf->Cell(0, 5, utf8_decode('Rodapé do Relatório'), 'T', 0, 'L');
        $pdf->setx(0);
        $pdf->Cell(0, 5, utf8_decode('Pág ').$pdf->PageNo().'/{nb}', 0, 0, 'C');
        $pdf->setx(0);
        $pdf->cell(0, 5, 'Emitido em:'.date('d/m/Y H:i:s'), 0, 0, 'R');
        $pdf->setfont('', '', $fs);
}
?>
<script>
function exibir_pdf() {
    //fwFaceBox(  pastaBase+'js/jquery/facebox/stairs.jpg');
    fwShowPdf({"modulo" : "pdf/exe_pdf01.php","des_marcadagua":jQuery("#des_marcadagua").val()});
}
</script>

