<?php

class RelatorioPedidoItem extends TPDF
{
    private $idPessoa;
    private $cellHeight = 4;
    private $gridFontTipo = 'arial';
    private $gridFontTamanho = 8;
    private $gridFontCor = 'black';
    
    public function getIdPessoa()
    {
        return $this->idPessoa;
    }
    public function setIdPessoa($idPessoa)
    {
        $this->idPessoa = $idPessoa;
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
    
    public function dadosBasicaos($nome,$cpf)
    {
        $this->estiloTexto();
        $this->ln(1);
        $this->SetFont('Arial','B',9);
        $this->linha(0, $this->getCellHeight(), 'CPF: '.$cpf.'  Nome: '.$nome, 0, 1, 'L');
        $this->estiloTexto();
    }
    
    public function dadosBancarios()
    {
        $this->tituloH1('Dados Bancarios');
        $idPessoa = $this->getIdPessoa();
        $dados = Dados_bancarios::selectByIdPessoa($idPessoa);
        if( !empty($dados) ) {
            $banco = $dados['NMBANCO'][0];
            $agencia = $dados['NRAGENCIA'][0];
            $conta = $dados['NRCONTA'][0];
            
            $this->ln(1);
            $this->linha(27, $this->getCellHeight(), 'Nome do Banco', 0, 0, 'L');
            $this->linha(18, $this->getCellHeight(), $banco, 0, 0, 'L');
            $this->ln();
            $this->linha(27, $this->getCellHeight(), 'Agência', 0, 0, 'L');
            $this->linha(18, $this->getCellHeight(), $agencia, 0, 0, 'L');
            $this->linha(30, $this->getCellHeight(), 'Conta Corrente', 0, 0, 'L');
            $this->linha(18, $this->getCellHeight(), $conta, 0, 0, 'L');
            $this->ln();
        } else {
            $this->sem_dados();
        }
    }
    
    public function dadosPessoaMPDFT($dadosPessoa)
    {
        $matricula = $dadosPessoa['IMATRICULA'][0];
        $cargo = $dadosPessoa['SDESCRICAOCARGO'][0];
        $lotacao = $dadosPessoa['SNOMEORGAO'][0];
        $idPessoa = $this->getIdPessoa();        
        $this->linha(15, $this->getCellHeight(), 'Matrícula:', 0, 0, 'L');
        $this->linha(18, $this->getCellHeight(), $matricula, 0, 0, 'L');
        $this->linha(10, $this->getCellHeight(), 'Cargo:', 0, 0, 'L');
        $this->linha(0, $this->getCellHeight(), $cargo, 0, 0, 'L');
        $this->ln();
        $this->linha(15, $this->getCellHeight(), 'Lotação:', 0, 0, 'L');
        $this->linha(10, $this->getCellHeight(), $lotacao, 0, 0, 'L');
        $this->ln();
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
    
    public function experiencia()
    {
        $this->tituloH1('Experiências como instrutor');
        $idPessoa = $this->getIdPessoa();
        $dados = Experiencia::selectByIdPessoa($idPessoa);
        $dados = $this->convertArrayUtf8ParaIso($dados);

        if( !is_array($dados)){
            $this->sem_dados();
        }else{
            $tipo = $this->gridFontTipo;
            $tamanho = $this->gridFontTamanho;
            $cor = $this->gridFontCor;
            
            $this->clearColumns();
            $this->setData( $dados );
            $this->addColumn('Modalidade',30,'C', 'NMTPMODALIDADE',null,null,$tamanho,$fontCor,$tipo);
            $this->addColumn(utf8_decode('Organização'),100,'L', 'NMORGANIZACAO',null,null,$tamanho,$fontCor,$tipo);
            $this->addColumn('Dat Inicio',30,'C', 'DTINICIO',null,null,$tamanho,$fontCor,$tipo);
            $this->addColumn('Dat Fim',30,'C', 'DTFIM',null,null,$tamanho,$fontCor,$tipo);
            $this->printRows();
        }
    }
    
    public function cursos_grid($dados){
        $dados = $this->convertArrayUtf8ParaIso($dados);
        $tipo = $this->gridFontTipo;
        $tamanho = $this->gridFontTamanho;
        $cor = $this->gridFontCor;
        
        $this->clearColumns();
        $this->setData( $dados );
        $this->addColumn(utf8_decode('Ano'),10,'C', 'NRANO',null,null,$tamanho,$fontCor,$tipo);
        $this->addColumn(utf8_decode('Nome'),100,'L', 'NMCURSO'	,null,null,$tamanho,$fontCor,$tipo);
        $this->addColumn(utf8_decode('Organização')	,60 ,'L', 'NMORGANIZACAO',null,null,$tamanho,$fontCor,$tipo);
        $this->addColumn(utf8_decode('Carga Horaria'),20,'C', 'NRCARGAHORARIA',null,null,$tamanho,$fontCor,$tipo);
        $this->printRows();
    }
    
    public function sem_dados(){
        $this->linha(0, $this->getCellHeight(), 'Não existem dados cadastrados', 1, 1, 'C');
    }
    
    public function cursos()
    {
        $idPessoa = $this->getIdPessoa();
        $this->tituloH1('Cursos');
        $dados = Curso_instrutor::selectByIdPessoa($idPessoa);
        if( !is_array($dados)){
            $this->sem_dados();
        }else{
            $this->cursos_grid($dados);
        }
    }
}

if( !ArrayHelper::has('RELATORIO', $_SESSION[APLICATIVO]) ){
    echo ('Informação para o relatório, não carregada');
}else{
    $idPessoa = (ArrayHelper::has('RELATORIO', $_SESSION[APLICATIVO]) ? $_SESSION[APLICATIVO]['RELATORIO']['IDPESSOA']:null);
    $nome = (ArrayHelper::has('RELATORIO', $_SESSION[APLICATIVO]) ? $_SESSION[APLICATIVO]['RELATORIO']['NMPESSOA']:null);
    $cpf = (ArrayHelper::has('RELATORIO', $_SESSION[APLICATIVO]) ? $_SESSION[APLICATIVO]['RELATORIO']['NRCPF']:null);
    if( empty($idPessoa) ){
        echo ($msgErro);
    }else{
        $dadosPessoa = Pessoa::selectById($idPessoa);
        $pdf = new InstrutorFicha('P');
        $pdf->setIdPessoa($idPessoa);
        $pdf->AddPage();
        $pdf->ln(5);
        $pdf->SetFont('Arial', '', 12);
        $pdf->linha(0, 5, 'Ficha do Instrutor', 1, 1, 'C');
        $pdf->ln(2);
        $pdf->dadosBasicaos($nome, $cpf);
        if( empty($dadosPessoa['IDPESSOAFISICAMPDFT'][0]) ){
            $pdf->dadosBancarios($dadosPessoa);
        } else {
            $pdf->dadosPessoaMPDFT($dadosPessoa);
        }
        $pdf->experiencia();
        $pdf->cursos();
        $pdf->show();
    }
}

// função chamada automaticamente pela classe TPDF quando existir
function cabecalho(TPDF $pdf)
{
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Image('images/logo_mpdft.png',10,6,30);
    $pdf->cell(0, 5, utf8_decode('MINISTÉRIO PÚBLICO DA UNIÃO'), 0, 1, 'C');
    $pdf->cell(0, 5, utf8_decode('Ministério Público do Distrito Federal e Territórios'), 0, 1, 'C');
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