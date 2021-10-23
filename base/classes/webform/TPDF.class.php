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

/**
 * extensão da classe FPDF v1.52 original adicionado o metodo row() e watermark
 *
 */
// artificio para encontrar a pasta base
//$e = new TElement();
//define( 'FPDF_FONTPATH', $e->getBase() . 'lib_fpdf181/font/' );
//require_once( $e->getBase() . 'lib_fpdf181/fpdf.php' );

class TPDF extends FPDF
{

    private $baseDir = null;
    private $pageBorder = false; // adicionar borda na página
    private $colums = null;
    private $data = null;
    private $waterMark = null;
    private $angle = 0;
    private $vars = null;
    //--- Parametros para o metodo Row()
    private $rowWidths;
    private $rowFillColors;
    private $rowFontColors;
    private $rowFontStyles;
    private $rowAligns;
    private $rowFieldNames;
    private $rowLineHeight;
    private $onDrawRow;
    private $onDrawCell;
    private $flagPrintHeader;

    private $headerFillColors;
    private $headerFontColors;
    private $headerFontStyles;

    /**
     * Classe para criação de relatórios no formato PDF
     *
     * @param string $strOrientation 01 : P or L
     * @param string $strUnit        02 :sunidade 
     * @param string $strFormat
     * @param string $strFontFamily
     * @param integer $intFontSize
     */
    public function __construct( $strOrientation = 'P'
                               , $strUnit = 'mm'
                               , $strFormat = 'A4'
                               , $strFontFamily = 'arial'
                               , $intFontSize = 8 )
    {
        parent::__construct( $strOrientation, $strUnit, $strFormat );
        $this->SetFont( ( is_null( $strFontFamily ) ? 'Arial' : $strFontFamily ), '', ( is_null( $intFontSize ) ? 8 : $intFontSize ) );
        $this->SetFillColor( 255 ); // fundo branco
        $this->AliasNbPages();
		$this->flagPrintHeader=true;
    }

    /**
     * Gerar o pdf e enviar para o browser ou retornar o arquivo gerado
     *
     * @param string$fileName
     * @param boolean $boolPrint
     * @return mixed
     */
    public function show( $strOutputFileName = null, $boolPrint = true )
    {
        // excluir os arquivos com mais de 5 minutos de vida
        $t = time();
        $tmpDir = str_replace( '//', '/', $this->getBaseDir() . "/tmp/" );

        if ( !file_exists( $tmpDir ) )
        {
            @mkdir( $tmpDir, '0775', true );
        }

        if ( !file_exists( $tmpDir ) )
        {
            die( 'Diretório para arquivos temporário ' . $tmpDir
                . ' deve ser criado com permissão de leitura/escrita.' );
        }

        if ( !is_writable( $tmpDir ) )
        {
            die( 'Diretório ' . $tmpDir . ' não está com permissão de leitura/escrita' );
        }

        if ( $h = opendir( $tmpDir ) )
        {
            while( $file = readdir( $h ) )
            {
                if ( substr( $file, 0, 3 ) == 'tmp' && substr( $file, -4 ) == '.pdf' )
                {
                    $path = $tmpDir . $file;

                    if ( $t - filemtime( $path ) > 300 )@unlink( $path );
                }
            }
            closedir( $h );
        }

        if ( is_null( $strOutputFileName ) )
        {
            //$file = tempnam(getcwd() . "/" . $this->getBaseDir() . "tmp", 'tmp');
            $file = $tmpDir . 'tmp_' . date( 'ymdhis' ) . '.pdf';
        //rename($file, $file . ".pdf");
        //$file.=".pdf";
        //print '2)'.$file.'<br>';
        }
        else
        {
            //$file = getcwd() . "/" . $this->getBaseDir() . '/tmp/' . $strOutputFileName;
            $file = $tmpDir . $strOutputFileName;
        //print '3)'.$file.'<br>';

        }

        if ($boolPrint){
            if ($boolPrint==true){
                $dest = 'F';
            }else{
                $dest = 'D';
            }
        }else{
            $dest = 'F';
        }
        
        $this->Output( $dest, $file );
        $file = $tmpDir . basename( $file );

        if ( $boolPrint ) {
            header( "Location: $file" );
        }
        return $file;
    }

    /**
     * Retorna o diretório da pasta base/ da aplicação
     *
     */
    public function getBaseDir()
    {
        if ( is_null( $this->baseDir ) )
        {
            $objTemp = new TElement();
            $this->baseDir = $objTemp->getBase();
        }
        return $this->baseDir;
    }

    /**
     * Sobrescrita da função addPage para possibilitar desenhar borda na página
     *
     * @param string $strOrientation P/L
     * @param boolean $boolBorder
     */
    function AddPage( $strOrientation='', $size='', $rotation=0 ) 
    {
    	$strOrientation = ( is_null($strOrientation) ? '' : $strOrientation );
        parent::AddPage( $strOrientation );

        if ( $this->getPageBorder()) {
            $yy = $this->GetY();
            $h = ( $this->h - $yy - $this->bMargin );
            $this->cell( 0, $h, '', 1, 0, 'L', 0 );
            $this->SetY( $yy );
        }

   		if ($str = $this->getWaterMark())
    	{
    		$currentFontSize  = $this->FontSizePt;
    		$currentTextColor = $this->getCurrentTextColor();  ;
	        $this->SetFont('Arial', 'B', 50);
	        $this->SetTextColor(255, 192, 203);
	        if ($this->w > $this->h) {
	            $angle = 35;
	        } else {
	            $angle = 55;
	        }
	        $this->RotatedText($this->lMargin, $this->h, $str, $angle);
	        $this->SetFont(null,null,$currentFontSize);
	        $this->SetTextColor($currentTextColor);
    	}
    }

    /**
     * Habilitar/desabilitar a impressão da borda na página
     *
     * @param mixed $boolNewValue
     */
    function setPageBorder( $boolNewValue = null )
    {
        $this->pageBorder = $boolNewValue;
    }

    /**
     * Retorna o valor da propriedade pageBorder para impressão da borda na página
     *
     */
    function getPageBorder()
    {
        return $this->pageBorder===true ? true : false;
    }

    /****
     * Add New Column in Grid. Need to use method printRows for show column in pdf.
     * 
     * Adicionar nova coluna na grade. Precisa usar o método printRows para mostrar coluna em pdf
     * 
     * @param string $strHeader      - 1: ID column
     * @param string $intWidth       - 2: Size column
     * @param string $strAlign       - 3: Align column, Values L = Left ,C= Center,R= ,J=justified
     * @param string $strFieldName   - 4: Label column head
     * @param string $hexFillColor   - 5: Cor do fundo, hexadecimal
     * @param string $strFontStyle   - 6: Style da font: I, B
     * @param string $intFontSize    - 7: Tamanho da fonte
     * @param string $hexFontColor   - 8: Cor em HexaDecimal
     * @param string $strFontFamily  - 9: 
     * @return TPDFColumn
     */
    public function addColumn( $strHeader = null
                             , $intWidth = null
                             , $strAlign = null
                             , $strFieldName = null
                             , $hexFillColor = null
                             , $strFontStyle = null
                             , $intFontSize = null
                             , $hexFontColor = null
                             , $strFontFamily = null 
                             )
    {
        $column = new TPDFColumn( $strHeader
                                , $intWidth
                                , $strAlign
                                , $strFieldName
                                , $hexFillColor
                                , $strFontStyle
                                , $intFontSize
                                , $hexFontColor
                                , $strFontFamily );
        $this->colums[] = $column;
        return $column;
    }

    function getColumns()
    {
        return $this->colums;
    }

    function getColumn( $intColumn = null )
    {
        return $this->colums[ $intColumn ];
    }

    function setData( $arrDados = null )
    {
        $this->data = $arrDados;
        return $this;
    }

    function getData()
    {
        return $this->data;
    }

    //----------------------------------------------------------------------------------------------------
    protected function prepare()
    {
        if ( !is_array( $this->getData() ) )
        {
            return;
        }

        if ( !$this->getColumns() )
        {
            die( 'Nenhuma coluna adicionada!' );
        }

        $aWidths = null;
        $aAligns = null;
        $aFontColors = null;
        $aFillColors = null;
        $aFontStyles = null;
        $aFieldNames = null;

        foreach( $this->getColumns() as $k => $oCol )
        {
            $aWidths[] = $oCol->getWidth();
            $aAligns[] = $oCol->getAlign();
            $aFillColors[] = $oCol->getFillColor();
            $aFontStyles[] = $oCol->getFontStyle();
            $aFieldNames[] = $oCol->getFieldName();
        }
        $this->setRowWidths( $aWidths );
        $this->setRowFillColors( $aFillColors );
        $this->setRowFontColors( $aFontColors );
        $this->setRowAligns( $aAligns );
        $this->setRowFieldNames( $aFieldNames );
    }

    /**
     * criar a grid do pdf
     *
     * @param [type] $newPage
     * @param [type] $strPageOrientation
     * @return void
     */
    public function printRows( $newPage = null, $strPageOrientation = null )
    {
    	//$this->clearColumns();
    	
        if ( !$this->getData() )
        {
            return;
        }
        $cloneColumns = null;

        // clonar as colunas para poder repetir a impressão do grid e exibir o mesmo
        // resultado, caso o usuario altera alguma propriedade original no evento onDrawCell
        if ( $this->getOnDrawCell() )
        {
            foreach( $this->getColumns() as $k => $objColumn )
            {
                $cloneColumns[] = clone $objColumn;
            }
        }
        $this->prepare();
        $res = $this->getData();

        if ( $newPage || $this->PageNo() == 0 )
        {
            $this->AddPage( $strPageOrientation, $this->getPageBorder() );
        }
        $this->printGridHeader();

        foreach( $res[ key( $res )] as $k => $v )
        {
            $aDados = array();

            foreach( $this->getRowFieldNames() as $k1 => $v1 )
            {
                $aDados[] = $res[ $v1 ][ $k ];
            }
            $this->row( $aDados );
        }

        if ( !is_null( $cloneColumns ) )
        {
            $this->colums = $cloneColumns;
        }
    }

    //----------------------------------------------------------------------------------------------------
    public function Header()
    {
        if ( function_exists( 'cabecalho' ) )
        {
            call_user_func( 'cabecalho', $this );
        }
        // imprimir o cabeçalho do gride
		$this->printGridHeader();
    /*
    if ($str = $this->getWaterMark())
    {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        if ($this->w > $this->h) {
            $angle = 35;
        } else {
            $angle = 55;
        }
        $this->RotatedText($this->lMargin, $this->h, $str, $angle);
    }
    */
    }

    public function Footer()
    {
        if ( function_exists( 'rodape' ) )
        {
            call_user_func( 'rodape', $this );
        }
    }

    //----------------------------------------------------------------------------------------------------
    public function setRowLineHeight( $intNewValue = null )
    {
        $this->rowLineHeight = $intNewValue;
    }

    public function getRowLineHeight()
    {
        return is_null( $this->rowLineHeight ) ? 4 : $this->rowLineHeight;
    }

    //----------------------------------------------------------------------------------------------------
    public function setWaterMark( $strNewValue = null )
    {
        $this->waterMark = $strNewValue;
    }

    //----------------------------------------------------------------------------------------------------
    public function getWaterMark()
    {
        $str = $this->waterMark;

        if ( $this->w < $this->h )
        {
            $max = 57.085088888889;
        }
        else
        {
            $max = 53.156555555556;
        }

        while( $this->GetStringWidth( $str ) < $max )
        {
            $str = " " . $str . " ";
        }
        return $str;
    }

    //----------------------------------------------------------------------------------------------------
    /**
     * Clean coluns to new grid
     * 
     * Limpa as colunas para gerar novo gride
     */    
    public function clearColumns()
    {
        $this->colums = null;
    }
    //----------------------------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------------------------
    /**
     * Imprimir array de dados em colunas
     *
     * O parametro $margemInferior indica o limite inferior maximo que a função
     * poderá utilizar para impressão da linha,  jogando o texto para a outra página se não couber.
     *
     * @param array $data
     * @param int   $intBottomMarginSize
     * @param mixed $mixFillColor
     * @param mixed $mixFontColor
     * @return void
     */
    function row( $data, $intBottomMarginSize = null, $mixFillColor = null, $mixFontColor = null )
    {
    	$this->flagPrintHeader=true; // imprimir o cabecalho do grid
        //Calculate the height of the row
        $nb = 0;
        $aNb = null;
        $currentFontFamily= $this->FontFamily;
        $currentFontStyle = $this->FontStyle;
        $currentFontSize  = $this->FontSizePt;
        $currentTextColor = $this->getCurrentTextColor();
        $currentFillColor = $this->FillColor;
        $currentDrawColor = $this->DrawColor;

        // calcular o espaço que a linha vai ocupar na página
        for( $i = 0; $i < count( $data ); $i++ ){
            $oCol = $this->getColumn( $i );

            if ( $this->getOnDrawCell() && function_exists( $this->getOnDrawCell() ) ){
            	//$params = (object) array('value'=>$data[$i],'colIndex'=>$i, 'data'=>$data );
                //call_user_func( $this->getOnDrawCell(), $oCol, $params );
                call_user_func( $this->getOnDrawCell(), $oCol, $data[ $i ], $i, $data );
            }

            //definir de volta o estilo, tamanho e cor da fonte da celula
            $this->SetFont( $oCol->getFontFamily( $currentFontFamily )
                          , $oCol->getFontStyle( $currentFontStyle )
                          , $oCol->getFontSize( $currentFontSize ) 
                          );

            $aNb[ $i ] = $this->NbLines( $oCol->getWidth(), $data[ $i ] );
            $nb = max( $nb, $aNb[ $i ] );
        }

        $lineHeight = $this->getRowLineHeight() * $nb;

        //saltar página se a linha for ocupar mais que o limite informado.
        if ( $intBottomMarginSize ){
            if ( ( $this->GetY() + $lineHeight ) > $intBottomMarginSize ) {
                $this->AddPage( $this->CurOrientation, $this->getPageBorder() );
            }
        }
        //Issue a page break first if needed
        $this->CheckPageBreak( $lineHeight );

        //Draw the cells of the row
        for( $i = 0; $i < count( $data ); $i++ ) {
            $oCol = $this->getColumn( $i );
            //definir o estilo, tamanho e cor da fonte da celula
            $this->SetFont( $oCol->getFontFamily( $currentFontFamily )
                          , $oCol->getFontStyle( $currentFontStyle )
                          , $oCol->getFontSize( $currentFontSize )
                          );
            $this->SetFillColor( $currentFillColor );
            $colWidth = $this->getRowWidths($i);
            $textAlign = strtoupper($this->getRowAligns(null,$i));
            $borda = 1;

            //alterar a cor da fonte
            $aCor = null;

            if ( $mixFontColor ) {
                if ( is_array( $mixFontColor ) ){
                    if ( isset( $mixFontColor[ 'g' ] ) ) {
                        $aCor = $mixFontColor;
                    } else {
                        $aCor[ 'r' ] = $mixFontColor[ 0 ];
                        $aCor[ 'g' ] = $mixFontColor[ 1 ];
                        $aCor[ 'b' ] = $mixFontColor[ 2 ];
                    }
                } else {
                    $aCor = $this->HexToRGB( $mixFontColor );
                }
            } else {
                $aCor = $this->HexToRGB( $oCol->getFontColor( $currentTextColor ) );
            }

            if ( is_array( $aCor ) ) {
                $this->SetTextColor( $aCor[ 'r' ], $aCor[ 'g' ], $aCor[ 'b' ] );
            } else {
                $this->SetTextColor( $aCor ); // Escala de cinza: 0 - 255
            }

            //cor de preenchimento da celula
            if ( $mixFillColor ){
                if ( is_array( $mixFillColor ) ){
                    if ( isset( $mixFillColor[ 'g' ] ) ){
                        $aCor = $mixFillColor;
                    } else {
                        $aCor[ 'r' ] = $mixFillColor[ 0 ];
                        $aCor[ 'g' ] = $mixFillColor[ 1 ];
                        $aCor[ 'b' ] = $mixFillColor[ 2 ];
                    }
                }else{
                    $aCor = $this->HexToRGB( $mixFillColor );
                }
            }else{
                $aCor = $this->HexToRGB( $oCol->getFillColor( $currentFillColor ) );
            }

            if ( is_array( $aCor ) ){
                $this->SetFillColor( $aCor[ 'r' ], $aCor[ 'g' ], $aCor[ 'b' ] );
            }else{
                $this->SetFillColor( $aCor ); // escala de cinza: 0 - 255
            }
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();

            $fill=1;
			if( $oCol->getFillColor() == '255'  && is_null( $mixFillColor ) )
			{
            	$fill = 0;
			}
			else
			{
	            //Pintar o fundo da celula
	            $this->Rect( $x, $y, $colWidth, $lineHeight, 'FD' );
			}

            // centralizar verticalmente o texto na célula
            if ( ( $c = $nb - $aNb[ $i ] ) > 0 )
            {
                $c *= ( $this->getRowLineHeight() / 2 );
                $this->SetXY( $x, ( $y + $c ) );
            }
            //Print the text
            $this->MultiCell( $colWidth, $this->getRowLineHeight(), $data[ $i ], 0, $textAlign, $fill );

            //Put the position to the right of the cell
            $this->SetXY( $x + $colWidth, $y );

            //eugenio - desenhar a borda
            if ( $borda )
            {
                $this->Rect( $x, $y, $colWidth, $lineHeight, 'D' );
            }
            // voltar as configurações padrão
            $this->SetFont( $currentFontFamily, $currentFontStyle, $currentFontSize );
            $this->SetFillColor( $currentFillColor );
            $this->SetTextColor( $currentTextColor );
            $this->SetDrawColor( $currentDrawColor );
        }
        //Go to the next line
        $this->Ln( $lineHeight );
    }

    //---------------------------------------------------------------------------------
    function CheckPageBreak( $h )
    {
        //If the height h would cause an overflow, add a new page immediately
        if ( $this->GetY() + $h > $this->PageBreakTrigger )$this->AddPage( $this->CurOrientation );
    }

    //-------------------------------------------------------------------------------
    function NbLines( $w, $txt )
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont[ 'cw' ];

        if ( $w == 0 )$w = $this->w - $this->rMargin - $this->x;
        $wmax = ( $w - 2 * $this->cMargin ) * 1000 / $this->FontSize;
        $s = str_replace( "\r", '', $txt );
        $nb = strlen( $s );

        if ( $nb > 0 and $s[ $nb - 1 ] == "\n" )$nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;

        while( $i < $nb )
        {
            $c = $s[ $i ];

            if ( $c == "\n" )
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }

            if ( $c == ' ' )$sep = $i;
            $l += $cw[ $c ];

            if ( $l > $wmax )
            {
                if ( $sep == -1 )
                {
                    if ( $i == $j )$i++;
                }
                else $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else $i++;
        }
        return $nl;
    }

    public function setRowWidths( $mixNewValue = null )
    {
        $this->rowWidths = $mixNewValue;
        return $this;
    }

    public function getRowWidths($intCol=null)
    {
    	if( ! is_null( $intCol ) )
    	{
			return $this->rowWidths[ $intCol ];
    	}
        return $this->rowWidths;
    }

    public function setRowFillColors( $mixNewValue = null )
    {
        $this->rowFillColors = $mixNewValue;
        return $this;
    }

    public function getRowFillColors()
    {
        return $this->rowFillColors;
    }

    public function setRowFontColors( $mixNewValue = null )
    {
        $this->rowFontColors = $mixNewValue;
        return $this;
    }

    public function getRowFontColors()
    {
        return $this->rowFontColors;
    }

    public function setRowFontStyles( $mixNewValue = null )
    {
        $this->rowFontStyles = $mixNewValue;
        return $this;
    }

    public function getRowFontStyles()
    {
        return $this->rowFontStyles;
    }

    public function setRowAligns( $mixNewValue = null )
    {
        $this->rowAligns = $mixNewValue;
        return $this;
    }

    /**
    * Retorna o array com os alinhamentos de cada coluna.
    * Se for informado o parametro $allAs, o array retornado
    * será preenchido todas as posições com o valor de $allAs
    * Utilize o parametro $colIndex para tetornar o alinhamento
    * de uma determinada coluna
    *
    * @param mixed $allAs
    */
    public function getRowAligns( $allAs = null,$colIndex=null )
    {
        if ( !is_null( $allAs ) && is_array( $this->rowAligns ) )
        {
            return array_fill( 0, count( $this->rowAligns ), $allAs );
        }
        if( ! is_null( $colIndex ) )
        {
			return $this->rowAligns[$colIndex];
        }
        return $this->rowAligns;
    }

    public function setRowFieldNames( $mixNewValue = null )
    {
        $this->rowFieldNames = $mixNewValue;
        return $this;
    }

    public function getRowFieldNames()
    {
        return $this->rowFieldNames;
    }
    public function setOnDrawCell( $newValue = null )
    {
        $this->onDrawCell = $newValue;
        return $this;
    }
    public function getOnDrawCell()
    {
        return $this->onDrawCell;
    }
    //------------------------------------------------------------------------------------
    public function RotatedText( $x, $y, $txt, $angle )
    {
        //Text rotated around its origin
        $this->Rotate( $angle, $x, $y );
        $this->Text( $x, $y, $txt );
        $this->Rotate( 0 );
    }
    public function Rotate( $angle, $x = -1, $y = -1 )
    {
        if ( $x == -1 )$x = $this->x;

        if ( $y == -1 )$y = $this->y;

        if ( $this->angle != 0 )$this->_out( 'Q' );
        $this->angle = $angle;

        if ( $angle != 0 )
        {
            $angle *= M_PI / 180;
            $c = cos( $angle );
            $s = sin( $angle );
            $cx = $x * $this->k;
            $cy = ( $this->h - $y ) * $this->k;
            $this->_out( sprintf( 'q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy,
                -$cx, -$cy ) );
        }
    }
	/*
    function _endpage()
    {
        if ( $str = $this->getWaterMark() )
        {
            $this->SetFont( 'Arial', 'B', 50 );
            $this->SetTextColor( 255, 192, 203 );

            if ( $this->w > $this->h )
            {
                $angle = 35;
            }
            else
            {
                $angle = 55;
            }
            $this->RotatedText( $this->lMargin, $this->h, $str, $angle );
        }

        if ( $this->angle != 0 )
        {
            $this->angle = 0;
            $this->_out( 'Q' );
        }
        parent::_endpage();
    }
	/*
    /**
     * Método para impressão do cabeçalho do gride
     */
    public function printGridHeader()
    {
        // se exisiter gride definido, imprimir o titulo
        if ( $cols = $this->getColumns() )
        {
        	if( $this->flagPrintHeader===true )
        	{
	            $headers = array();
	            // alinhar os titulos no centro da celula
	            $oldAligns = $this->getRowAligns();
	            $this->setRowAligns( $this->getRowAligns('c') );
	            foreach( $cols as $k => $oCol )
	            {
	                if ( $oCol->getHeader() )
	                {
	                    $headers[] = $oCol->getHeader();
	                }
	            }

	            if ( count( $headers ) > 0 )
	            {
                    $headerFillColors = $this->getHeaderFillColors();
                    $headerFontColors = $this->getHeaderFontColors();
	                $this->row( $headers, null, $headerFillColors, $headerFontColors );
	            }
	            $this->setRowAligns($oldAligns);
				$this->flagPrintHeader=false;
			}
        }
    }

    public function getRowMaxWidth()
    {
        $this->prepare();
        $r = 0;

        if ( $this->getRowWidths() )
        {
            foreach( $this->getRowWidths() as $k => $v )
            {
                $r += $v;
            }
        }
        return $r;
    }
    public function setVar( $varName = null, $varValue = null )
    {
        if ( $varName )
        {
            $this->vars[ strtolower( $varName )] = $varValue;
        }
    }
    public function getVar( $varName = null )
    {
        if ( $varName )
        {
            return $this->vars[ strtolower( $varName )];
        }
    }
    public function setTopMargin($intNewValue=null)
    {
    	if( (integer) $intNewValue > -1 )
    	{
    		$this->tMargin = $intNewValue;
		}else{
			$this->tMargin = 10.00125; // valor padrão.
		}
    }
    public function getTopMargin($intNewValue=null)
    {
   	   return $this->tMargin;
    }
    //------------------------------------------------------------------------------------    
    public function HexToRGB( $hex ){
        $hex = $this->translateColor( $hex );

        if ( is_null( $hex ) || $hex === 0 ){
            return $hex;
        }

        if ( $hex == 255 || $hex == '0 G' || $hex == '0 g' ){
            return $hex;
        }

        if ( !preg_match( '/^#/', $hex ) ) {
            return $hex;
        }
        $hex = preg_replace( "/#/", "", $hex );
        $color = array();

        if ( strlen( $hex ) == 3 ){
            $color[ 'r' ] = hexdec( substr( $hex, 0, 1 ) . $r );
            $color[ 'g' ] = hexdec( substr( $hex, 1, 1 ) . $g );
            $color[ 'b' ] = hexdec( substr( $hex, 2, 1 ) . $b );
        }else if( strlen( $hex ) == 6 ){
            $color[ 'r' ] = hexdec( substr( $hex, 0, 2 ) );
            $color[ 'g' ] = hexdec( substr( $hex, 2, 2 ) );
            $color[ 'b' ] = hexdec( substr( $hex, 4, 2 ) );
        }
        return $color;
    }
    /**
     * Converte o nome de uma cor no valor em HexaDecimal
     * @param string $strColor
     * @return void
     */
    public function translateColor( $strColor = null )
    {
        if ( is_null( $strColor ) || !is_string( $strColor ) || preg_match( '/#/', $strColor ) == 1 )
        {
            return $strColor;
        }
        $strColor = strtolower( $strColor );
        $aColors[ 'red' ] = '#ff0000';
        $aColors[ 'green' ] = '#00ff00';
        $aColors[ 'blue' ] = '#0000ff';
        $aColors[ 'yellow' ] = '#FFFF00';
        $aColors[ 'fuchsia' ] = '#FF00FF';
        $aColors[ 'gray' ] = '#989898';
        $aColors[ 'grey' ] = '#989898';
        $aColors[ 'black' ] = '#000000';
        $aColors[ 'white' ] = '#ffffff';
        $aColors[ 'orange' ] = '#FF9900';
        $aColors[ 'lightYellow' ] = '#FF9900';
        $aColors[ 'lightBlue' ] = '#0066FF';
        $aColors[ 'lightGreen' ] = '#66FF99';
        $aColors[ 'pink' ] = '#FF99FF';
        $aColors[ 'brown' ] = '#663300';
        $aColors[ 'silver' ] = '#E8E8E8';

        if ( isset( $aColors[ $strColor ] ) )
        {
            return $aColors[ $strColor ];
        }
        return $strColor;
    }    
    //------------------------------------------------------------------------------------    
    /**
     * Seta a cor de fundo do cabeçalho do Grid, é possíveis em HEX decimal um nome fixo.
     * alguns exemplos
     *   - red, green, blue, yellow, fuchsia, gray, black, white
     *   - orange, lightYellow, lightBlue, lightGreen, pink
     *   - brown, silver
     *  A lista completa em veja $this->translateColor
     *
     * @param string $headerFontColors
     */    
    public function setHeaderFillColors($headerFillColors)
    {
    	$this->headerFillColors = $headerFillColors;
    }
    public function getHeaderFillColors()
    {
        if(empty($this->headerFillColors) ) {
            $this->setHeaderFillColors('silver');
        }
        return $this->headerFillColors;
    }
    /**
     * Seta a cor da letro deo cabeçao do grid, é possíveis em HEX decimal um nome fixo.
     * alguns exemplos
     *   - red, green, blue, yellow, fuchsia, gray, black, white
     *   - orange, lightYellow, lightBlue, lightGreen, pink
     *   - brown, silver
     *  A lista completa em veja $this->translateColor
     *
     * @param string $headerFontColors
     */
    public function setHeaderFontColors($headerFontColors)
    {
    	$this->headerFontColors = $headerFontColors;
    }
    public function getHeaderFontColors(){
        if(empty($this->headerFontColors) ) {
            $this->setHeaderFontColors('black');
        }
        return $this->headerFontColors;
    }
    public function getFontSize(){
        return $this->FontSizePt;
    }
    public function getCurrentTextColor(){
        $currentTextColor=null;
        if( $this->TextColor == '0 g'){
            $currentTextColor=0;
        }else{
            $currentTextColor=$this->TextColor;
        }
        return $currentTextColor;
    }
}
?>