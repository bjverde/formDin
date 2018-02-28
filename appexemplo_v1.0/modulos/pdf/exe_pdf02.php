<?php
require_once 'exe_pdf_msg.php';
$html1 = getMsgFPDF();

//*** Criacao do objeto PDF ***
$frm = new TForm();

$pdf = new TPDF('L');

//a classe TPDF procura pela funcao cabecalho() e se existir sera executada recebendo a instancia da classe TPDF
function cabecalho($pdf) {
    $pdf->SetTextColor(0,64,128);
    $pdf->setFont('','B',14);
    $pdf->cell(0, 5, 'Sistema - v-1.0', 0, 1, 'C');
    $pdf->setFont('','B',12);
    $pdf->cell(0, 5, 'Listagem', 0, 1, 'C');
    $pdf->ln(1);
    $pdf->setFont('', '', 10);
    //exibir criterio utilizado no filtro
    $criterio = isset($criterio) ? $criterio : null;
    $criterio = (($criterio == '') ? 'Todos os produtos' : $criterio);
    $pdf->SetTextColor(0,0,255);//0,64,128);
    $pdf->setFont('','B',7);
    $pdf->cell(0, 5, 'Criterio de Consulta: '.$criterio, 0, 1, 'L');
    $pdf->ln(1);
}

//a classe TPDF procurao pela funcao rodape() e se existir sera executada recebendo a instancia da classe TPDF
function rodape($pdf) {
    $pdf->setY(- 10);
    $pdf->cell(50, 5, 'Emissao: '.date('d/m/Y h:i:s'), 'T', 0, 'L');
    $pdf->cell(0, 5, 'Pagina: '.$pdf->
    PageNo().' de {nb}', 'T', 0, 'R');
}

// simular resultado do banco de dados
$dados= null;
$dados['TXT_EMPENHO'][] = '2015NE4454';
$dados['TXT_REGISTRO'][] = 'REGNE4454';
$dados['NUM'][] = 'NUM';
$dados['DAT'][] = '01/01/2015';
$dados['TXT_TERMO'][] = 'Termo';
$dados['TXT_OBS'][] = 'OBS';
$dados['NUM_VALOR'][] = '10.45';
$dados['TXT_DESCRIMINACAO'][] = utf8_decode('Descriminação');

$dados['TXT_EMPENHO'][] = '2015NE4478';
$dados['TXT_REGISTRO'][] = 'REGNE4457';
$dados['NUM'][] = 'NUM';
$dados['DAT'][] = '02/01/2015';
$dados['TXT_TERMO'][] = 'Termo 2';
$dados['TXT_OBS'][] = 'OBS 2';
$dados['NUM_VALOR'][] = '150.47';
$dados['TXT_DESCRIMINACAO'][] = utf8_decode('Descriminação');


//adicionar array de objeto pdf
$pdf->setData($dados);

/*criacao de corpo do relatorio, que neste caso sera uma listagem simples, tipo tabela (gride)
 * adicionar colunas que iremos listar da tabela.
 */
$pdf->addColumn('Empenho', 20, 'C', 'TXT_EMPENHO', 'white', 'B', 8, 'black', 'times');
$pdf->addColumn('RM', 15, 'C', 'TXT_REGISTRO', 'white', 'B', 8, 'black', 'times');
$pdf->addColumn('Grupo', 40, 'L', 'NUM', 'white', NULL, 8, 'black', 'times');
$pdf->addColumn('Dt', 15, 'C', 'DAT', 'white', NULL, 8, 'black', 'times');
$pdf->addColumn('Termo', 20, 'C', 'TXT_TERMO', 'white', 'B', 8, 'black', 'times');
$pdf->addColumn('Obs.', 70, 'C', 'TXT_OBS', 'white', NULL, 8, 'black', 'times');
$pdf->addColumn('R$ (unitario)', 15, 'C', 'NUM_VALOR', 'white', NULL, 8, 'black', 'times');
$pdf->addColumn('Descricao', 80, 'C', 'TXT_DESCRIMINACAO', 'white', 'B', 8, 'black', 'times');
$pdf->printRows();  //criar a grid do pdf


// imprimir o subtotal
$total = 0;
$pdf->SetFillColor(240); // fundo cinza
foreach($dados['NUM_VALOR'] as $k=>$v)
{
	$total += floatval($v); // somar a coluna NUM_VALOR
}
//  imprimir a palavra subtotal ocupando as 5 primeiras colunas, o metodo getRowMaxWidth() retorna a soma de todas as larguras das colunas ou a de uma coluna especifica
$pdf->cell($pdf->getRowMaxWidth()-($pdf->getRowWidths(6)+$pdf->getRowWidths(7)) ,5,'Subtotal:',1,0,'R',1);
$pdf->cell($pdf->getRowWidths(6),5,number_format($total,2,'.',','),1,0,'C',1);
$pdf->cell($pdf->getRowWidths(7),5,'',1,1,'R',1);
$pdf->SetFillColor(255,255,255); // fundo branco
$pdf->ln(3);
$pdf->multiCell(0,4,utf8_decode(getMsgFPDF()),1);


//echo 'Pdf gerado em: '.$pdf->show('teste.pdf',false);
$pdf->show();