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

$pdf = new TPDF('P');
$pdf->AddPage();

//a classe TPDF procura pela funcao cabecalho() e se existir sera executada recebendo a instancia da classe TPDF
function cabecalho($pdf)
{
    $pdf->Image('imagem/appv1_logo.png',10,6,30);
    $pdf->SetTextColor(160, 60, 60);
    $pdf->setFont('', 'B', 14);
    $pdf->cell(0, 5, APLICATIVO.' - v:'.SYSTEM_VERSION, 0, 1, 'C');
    $pdf->setFont('', 'B', 12);
    $pdf->cell(0, 5, 'Exemplo 6 - Grid Chamando PDF', 0, 1, 'C');
    $pdf->ln(1);
    $pdf->setFont('', '', 10);
    
}

//a classe TPDF procurao pela funcao rodape() e se existir sera executada recebendo a instancia da classe TPDF
function rodape($pdf)
{
    $pdf->setY(- 10);
    $pdf->cell(50, 5, 'Emissao: '.date('d/m/Y h:i:s'), 'T', 0, 'L');
    $pdf->cell(0, 5, 'Pagina: '.$pdf->
        PageNo().' de {nb}', 'T', 0, 'R');
}

$pdf->SetFont('Arial', '', 10);
$pdf->ln(3);
$pdf->multiCell(0, 4, utf8_decode( print_r($_REQUEST, true)) , 1);
$pdf->show();
