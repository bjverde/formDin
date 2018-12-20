<?php

class RelatorioPedidoItem extends TPDF
{
    private $idPedido;
    private $cellHeight = 4;
    private $gridFontTipo = 'arial';
    private $gridFontTamanho = 8;
    private $gridFontCor = 'black';
    
    public function getIdPedido()
    {
        return $this->idPedido;
    }
    public function setIdPedido($idPedido)
    {
        $this->idPedido = $idPedido;
    }
    public function getCellHeight()
    {
        return $this->cellHeight;
    }    
    public function setCellHeight($cellHeight)
    {
        $this->cellHeight = $cellHeight;
    }

    public function linha($w,$h=0,$txt='',$border=0,$ln=0,$align='L',$fill=false){
        $txt = utf8_decode(trim($txt));
        $this->cell($w,$h,$txt,$border,$ln,$align,$fill);
    }
    public function estiloTexto(){
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
    }
    public function tituloH1($label)
    {
        // Title
        $this->Ln(6);
        $this->SetFont('Arial','',11);
        //$this->SetFillColor(200,220,255);
        $this->SetFillColor(105,105,105);
        $this->SetTextColor(255,255,255);
        $this->linha(0,$this->getCellHeight()+2,"$label",0,1,'L',true);
        $this->estiloTexto();
        $this->Ln(1);
        // Save ordinate
        $this->y0 = $this->GetY();
    }
    public function tituloH2($label)
    {
        // Title
        $this->Ln(1);
        $this->SetFont('Arial','',10);
        $this->linha(0,$this->getCellHeight()+2,"$label",0,1,'L',false);
        $this->estiloTexto();
        $this->Ln(1);
        // Save ordinate
        $this->y0 = $this->GetY();
    }
    
    public function dadosBasicaos($idPedido, $nomPessoa,$datPedido)
    {
        $this->estiloTexto();
        $this->ln(1);
        $this->SetFont('Arial','B',9);
        $this->linha(0, $this->getCellHeight(), 'Num Pedido: '.$idPedido.'  Data: '.$datPedido, 0, 1, 'L');
        $this->linha(0, $this->getCellHeight(), 'Solicitante: '.$nomPessoa, 0, 1, 'L');
        $this->estiloTexto();
    }   
    
    public function convertArrayUtf8ParaIso($arrayUtf8){
        $arrayIso = null;
        if( !is_array($arrayUtf8) ){
            $arrayIso = $arrayUtf8;
        }else{
            foreach( $arrayUtf8 as $key => $arr ) {
                foreach( $arr as $index => $value ) {
                    $arrayIso[$key][$index] = strtoupper( utf8_decode($value) );
                }
            }
        }
        return $arrayIso;
    }
    
    public function itens_grid($dados){
        $dados = $this->convertArrayUtf8ParaIso($dados);
        $tipo = $this->gridFontTipo;
        $tamanho = $this->gridFontTamanho;
        $cor = $this->gridFontCor;
        
        $this->clearColumns();
        $this->setData( $dados );
        $this->addColumn(utf8_decode('id Item'),10,'C', 'NRANO',null,null,$tamanho,$fontCor,$tipo);
        $this->addColumn(utf8_decode('id Produto'),100,'L', 'IDPRODUTO'	,null,null,$tamanho,$fontCor,$tipo);
        $this->addColumn(utf8_decode('Quantidade')	,60 ,'L', 'QTD_UNIDADE',null,null,$tamanho,$fontCor,$tipo);
        $this->addColumn(utf8_decode('Preço'),20,'C', 'PRECO',null,null,$tamanho,$fontCor,$tipo);
        $this->printRows();
    }
    
    public function sem_dados(){
        $this->linha(0, $this->getCellHeight(), 'Não existem dados cadastrados', 1, 1, 'C');
    }
    
    public function itens()
    {
        $idPedido = $this->getIdPedido();
        $this->tituloH1('Itens');
        $dados = Pedido_item::selectByIdPedido($idPedido);
        if( !is_array($dados)){
            $this->sem_dados();
        }else{
            $this->itens_grid($dados);
        }
    }
}

function getValueSession($attribute){
    $result = (ArrayHelper::has('RELATORIO', $_SESSION[APLICATIVO]) ? $_SESSION[APLICATIVO]['RELATORIO'][$attribute]:null);
    return $result;
}

$msgErro = 'Informação para o relatório, não carregada';
if( !ArrayHelper::has('RELATORIO', $_SESSION[APLICATIVO]) ){
    echo ($msgErro);
}else{
    $idPedido  = getValueSession('IDPEDIDO');
    $nomPessoa = getValueSession('NOM_PESSOA');
    $datPedido = getValueSession('DAT_PEDIDO');
    if( empty($idPedido) ){
        echo ($msgErro);
    }else{
        $dados = Pedido_item::selectByIdPedido($idPedido);
        $pdf = new RelatorioPedidoItem('P');
        $pdf->setIdPedido($idPedido);
        $pdf->AddPage();
        $pdf->ln(5);
        $pdf->SetFont('Arial', '', 12);
        $pdf->linha(0, 5, 'Ficha do Pedido', 1, 1, 'C');
        $pdf->ln(2);
        $pdf->dadosBasicaos($idPedido, $nomPessoa,$datPedido);
        $pdf->itens();
        $pdf->show();
    }
}

// função chamada automaticamente pela classe TPDF quando existir
function cabecalho(TPDF $pdf)
{
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Image('images/appv1_logo.png',10,6,30);
    $pdf->cell(0, 5, utf8_decode('Relatorio exemplo em FormDin'), 0, 1, 'C');
}
// função chamada automaticamente pela classe TPDF quando existir
function rodape(TPDF $pdf)
{   
    $fs=$pdf->getFontSize();
    $pdf->SetY(-9);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(0, 5, 'Emitido em: '.date('d/m/Y H:i:s'), 'T', 0, 'L');
    $pdf->setx(0);
    $pdf->Cell(0, 5, utf8_decode('Página ').$pdf->PageNo().'/{nb}', 0, 0, 'R');
    $pdf->setfont('', '', $fs);
}