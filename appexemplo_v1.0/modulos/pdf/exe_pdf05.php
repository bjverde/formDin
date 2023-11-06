<?php
require_once 'exe_pdf_msg.php';
$html1 = getMsgFPDF();

//*** Criacao do objeto PDF ***
$frm = new TForm();

$pdf = new TPDF('L');
$pdf->AddPage();

//a classe TPDF procura pela funcao cabecalho() e se existir sera executada recebendo a instancia da classe TPDF
function cabecalho($pdf)
{
    $pdf->Image('imagem/appv1_logo.png',10,6,30);
    $pdf->SetTextColor(0, 64, 128);
    $pdf->setFont('', 'B', 14);
    $pdf->cell(0, 5, APLICATIVO.' - v:'.SYSTEM_VERSION, 0, 1, 'C');
    $pdf->setFont('', 'B', 12);
    $pdf->cell(0, 5, 'Listagem', 0, 1, 'C');
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

// simular resultado do banco de dados
$dados= null;
$dados['TXT_EMPENHO'][] = '2015NE4454';
$dados['TXT_REGISTRO'][] = 'REGNE4454';
$dados['NUM'][] = 'NUM';
$dados['DAT'][] = '01/01/2015';
$dados['TXT_TERMO'][] = 'Termo';
$dados['TXT_OBS'][] = 'OBS';
$dados['NUM_VALOR'][] = '10.45';
$dados['TXT_DESCRIMINACAO'][] = StringHelper::utf8_decode_windows1252('Descriminação');

$dados['TXT_EMPENHO'][] = '2015NE4478';
$dados['TXT_REGISTRO'][] = 'REGNE4457';
$dados['NUM'][] = 'NUM';
$dados['DAT'][] = '02/01/2015';
$dados['TXT_TERMO'][] = 'Termo 2';
$dados['TXT_OBS'][] = 'OBS 2';
$dados['NUM_VALOR'][] = '150.47';
$dados['TXT_DESCRIMINACAO'][] = StringHelper::utf8_decode_windows1252('Descriminação');

//exibir criterio utilizado no filtro
$criterio = isset($criterio) ? $criterio : null;
$criterio = (($criterio == '') ? 'Todos os produtos' : $criterio);
$pdf->SetTextColor(0, 0, 255);//0,64,128);
$pdf->setFont('', 'B', 7);
$pdf->cell(0, 5, 'Criterio de Consulta: '.$criterio, 0, 1, 'L');
$pdf->ln(1);


//adicionar array de objeto pdf
$pdf->setData($dados);

/*criacao de corpo do relatorio, que neste caso sera uma listagem simples, tipo tabela (gride)
 * adicionar colunas que iremos listar da tabela.
 */
$pdf->addColumn('Empenho', 20, 'C', 'TXT_EMPENHO', 'white', 'B', 8, 'black', 'times');
$pdf->addColumn('RM', 15, 'C', 'TXT_REGISTRO', 'white', 'B', 8, 'black', 'times');
$pdf->addColumn('Grupo', 40, 'L', 'NUM', 'white', null, 8, 'black', 'times');
$pdf->addColumn('Dt', 15, 'C', 'DAT', 'white', null, 8, 'black', 'times');
$pdf->addColumn('Termo', 20, 'C', 'TXT_TERMO', 'white', 'B', 8, 'black', 'times');
$pdf->addColumn('Obs.', 70, 'C', 'TXT_OBS', 'white', null, 8, 'black', 'times');
$pdf->addColumn('R$ (unitario)', 15, 'C', 'NUM_VALOR', 'white', null, 8, 'black', 'times');
$pdf->addColumn('Descricao', 80, 'C', 'TXT_DESCRIMINACAO', 'white', 'B', 8, 'black', 'times');
$pdf->printRows();  //criar a grid do pdf


// imprimir o subtotal
$total = 0;
$pdf->SetFillColor(240); // fundo cinza
foreach ($dados['NUM_VALOR'] as $k => $v) {
    $total += floatval($v); // somar a coluna NUM_VALOR
}
//  imprimir a palavra subtotal ocupando as 5 primeiras colunas, o metodo getRowMaxWidth() retorna a soma de todas as larguras das colunas ou a de uma coluna especifica
$pdf->cell($pdf->getRowMaxWidth()-($pdf->getRowWidths(6)+$pdf->getRowWidths(7)), 5, 'Subtotal:', 1, 0, 'R', 1);
$pdf->cell($pdf->getRowWidths(6), 5, number_format($total, 2, '.', ','), 1, 0, 'C', 1);
$pdf->cell($pdf->getRowWidths(7), 5, '', 1, 1, 'R', 1);
$pdf->SetFillColor(255, 255, 255); // fundo branco
$pdf->ln(3);
$pdf->multiCell(0, 4, StringHelper::utf8_decode_windows1252(getMsgFPDF()), 1);

$msg02 = 'Esse exemplo utiliza os metodos: TPDF->setData e TPDF->addColumn. Para criar um grid de forma facil e semelhante ao que acontece no FormDin;';
$pdf->multiCell(0, 4, StringHelper::utf8_decode_windows1252($msg02), 1);

$pdf->ln(4);
$pdf->SetTextColor(0, 0, 255);//0,64,128);
$pdf->setFont('', 'B', 7);
$pdf->cell(0, 5, 'Grid 02 - gerador de lero Lero', 0, 1, 'L');
$pdf->ln(1);

$dados02 = null;
$dados02['ID'][] = '20'; 
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Caros amigos, a execução dos pontos do programa garante a contribuição de um grupo importante na determinação das diretrizes de desenvolvimento para o futuro. Nunca é demais lembrar o peso e o significado destes problemas, uma vez que o novo modelo estrutural aqui preconizado cumpre um papel essencial na formulação dos níveis de motivação departamental. É importante questionar o quanto a revolução dos costumes maximiza as possibilidades por conta de alternativas às soluções ortodoxas.');
$dados02['ID'][] = '21'; 
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252(' Pensando mais a longo prazo, a crescente influência da mídia auxilia a preparação e a composição do remanejamento dos quadros funcionais. É claro que o desafiador cenário globalizado nos obriga à análise das novas proposições. ');
$dados02['ID'][] = '22';
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Desde ontem a noite o último pull request desse SCRUM causou a race condition dos argumentos que definem um schema dinâmico');
$dados02['ID'][] = '23';
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Explica pro Product Onwer que a compilação final do programa causou o bug do fluxo de dados de forma retroativa no server.');
$dados02['ID'][] = '24';
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Com este commit, a otimização de performance da renderização do DOM causou a race condition na estabilidade do protocolo de transferência de dados.');
$dados02['ID'][] = '25';
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Dado o fluxo de dados atual, o deploy automatizado no Heroku complexificou o merge na compilação de templates literais.');
$dados02['ID'][] = '26';
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Explica pro Product Onwer que a otimização de performance da renderização do DOM superou o desempenho no fechamento automático das tags.');
$dados02['ID'][] = '27';
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Nesse pull request, um erro não identificado otimizou a renderização de uma configuração Webpack eficiente nos builds.');
$dados02['ID'][] = '28';
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Com este commit, o último pull request desse SCRUM complexificou o merge da execução parelela de funções em multi-threads');
$dados02['ID'][] = '29';
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Com este commit, o deploy automatizado no Heroku deletou todas as entradas no parse retroativo do DOM.');
$dados02['ID'][] = '30';
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Fala pro cliente que um erro não identificado deletou todas as entradas na interpolação dinâmica de strings.');
$dados02['ID'][] = '31';
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Fala pro cliente que a compilação final do programa otimizou a renderização do JSON compilado a partir de proto-buffers.');
$dados02['ID'][] = '32';
$dados02['TEXTO'][] = StringHelper::utf8_decode_windows1252('Desde ontem a noite o gerenciador de dependências do frontend corrigiu o bug da renderização de floats parciais.');


$pdf->clearColumns();
$pdf->setData($dados02);
//$pdf->printGridHeader();
$pdf->setHeaderFillColors('orange');
$pdf->setHeaderFontColors('white');
$pdf->addColumn('id', 10, 'C', 'ID', 'white', 'B', 14, 'black', 'times');
$pdf->addColumn('Texto', 100, 'J', 'TEXTO', 'yellow', 'B', 8, 'black', 'Arial');
$pdf->printRows();  //criar a grid do pdf

//echo 'Pdf gerado em: '.$pdf->show('teste.pdf',false);
$pdf->show();
