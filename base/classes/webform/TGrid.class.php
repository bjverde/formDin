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

if(!defined('ENCODINGS')){ define('ENCODINGS','UTF-8'); }

/**
 * @todo	- possibilitar exibir ou não o botão editar e excluir do grid-offline
 * @todo	- definir o foco para o primeiro campo do formulario do grid-ofline se não tiver sido informado pelo usuario
 */
include_once( 'autoload_formdin.php');
class TGrid extends TTable
{
    private $width;
    private $height;
    private $columns;
    private $title;
    private $titleCell;
    private $bodyCell;
    private $footerCell;
    private $data;
    private $keyField;
    private $updateFields; // campos que serão atualizados no formulario antes de executar a ação
    private $buttons;
    private $onDrawRow;
    private $onDrawCell;
    private $onDrawHeaderCell;
    private $onDrawActionButton;
    private $onGetAutocompleteParameters;
    private $actionColumnTitle;
    private $zebrarColors;
    private $hiddenField;
    private $readOnly;
    private $maxRows;
    private $realTotalRowsSqlPaginator;
    private $url;
    private $bvars;
    private $cache;
    private $createDefaultButtons;
    private $createDefaultImages;
    private $exportExcel;
    private $excelHeadFields;
    private $noWrap;
    private $noDataMessage;
    
    // dados do grid offline
    private $form;
    private $newRecordColor;
    private $editedRecordColor;
    private $savedRecordColor;
    private $deletedRecordColor;
    private $sortable;
    private $showCollapsed;
    
    private $autocomplete;
    private $javaScript;
    
    protected $numPages;
    protected $currentPage;
    
    private $createDefaultEditButton;
    private $createDefaultDeleteButton;
    private $createDefaultAdicionarButton;
    private $showAdicionarButton; // botão do grid offline
    private $disableButtonImage=null;
    private $exportFullData;
    private $columnConfig;
    
    private $qtdColumns;
    private $tbody;
    
    
    /**
     * Classe para criação de grides
     *
     * Parametros do evento onDrawHeaderCell
     * 	1) $th			- objeto TElement
     * 	2) $objColumn 	- objeto TGridColum
     * 	3) $objHeader 	- objeto TElement
     *
     * Parametros do envento onDrawRow
     * 	1) $row 		- objeto TGridRow
     * 	2) $rowNum 		- número da linha corrente
     * 	3) $aData		- o array de dados da linha ex: $res[''][n]
     *
     * Parametros do envento onDrawCell
     * 	1) $rowNum 		- número da linha corrente
     * 	2) $cell		- objeto TTableCell
     * 	3) $objColumn	- objeto TGrideColum
     * 	4) $aData		- o array de dados da linha ex: $res[''][n]
     * 	5) $edit		- o objeto campo quando a coluna for um campo de edição
     *   ex: function ondrawCell($rowNum=null,$cell=null,$objColumn=null,$aData=null,$edit=null)
     *
     * Parametros do evento onDrawActionButton
     * 	1) $rowNum 		- número da linha corrente
     * 	2) $button 		- objeto TButton
     * 	3) $objColumn	- objeto TGrideColum
     * 	4) $aData		- o array de dados da linha ex: $res[''][n]
     *   Ex: function tratarBotoes($rowNum,$button,$objColumn,$aData);
     *
     * Parametros do evento onGetAutocompleteParameters
     * 	1) $ac 			- classe TAutocomplete
     * 	2) $aData		- o array de dados da linha ex: $res[''][n]
     * 	3) $rowNum 		- número da linha corrente
     * 	3) $cell		- objeto TTableCell
     * 	4) $objColumn	- objeto TGrideColum
     *
     *
     * @param string $strName          - 1: ID do campo
     * @param string $strTitle         - 2: Titulo do campo
     * @param array $mixData           - 3: Array de dados
     * @param mixed $strHeight         - 4: Altura 
     * @param mixed $strWidth          - 5: Largura
     * @param mixed $strKeyField       - 6: Chave primaria
     * @param array $mixUpdateFields   - 7: Campos do form origem que serão atualizados ao selecionar o item desejado. Separados por virgulas seguindo o padrão <campo_tabela> | <campo_formulario> , <campo_tabela> | <campo_formulario>
     * @param mixed $intMaxRows        - 8: Qtd Max de linhas
     * @param mixed $strRequestUrl     - 9: Url request do form
     * @param mixed $strOnDrawCell
     * @param mixed $strOnDrawRow
     * @param mixed $strOnDrawHeaderCell
     * @param mixed $strOnDrawActionButton
     * @return TGrid
     */
    public function __construct( $strName
                               , $strTitle = null
                               , $mixData = null
                               , $strHeight = null
                               , $strWidth = null
                               , $strKeyField = null
                               , $mixUpdateFields = null
                               , $intMaxRows = null
                               , $strRequestUrl = null
                               , $strOnDrawCell = null
                               , $strOnDrawRow = null
                               , $strOnDrawHeaderCell = null
                               , $strOnDrawActionButton = null )
    {
        parent::__construct( $strName );
        parent::clearCss();
        $this->setTitle( $strTitle );
        $this->setData( $mixData );
        $this->addKeyField( $strKeyField );
        $this->setOnDrawRow( $strOnDrawRow );
        $this->setOnDrawHeaderCell( $strOnDrawHeaderCell );
        $this->setOnDrawCell( $strOnDrawCell );
        $this->setOnDrawActionButton( $strOnDrawActionButton );
        $this->setUpdateFields( is_null( $mixUpdateFields ) ? $strKeyField : $mixUpdateFields );
        $this->setMaxRows( $intMaxRows );
        if( isset( $_REQUEST[ 'modulo' ] ) )
        {
            $this->setUrl( ( is_null( $strRequestUrl ) ? $_REQUEST[ 'modulo' ] : $strRequestUrl ) );
            
        }
        $this->setExportExcel( true );
        $this->setSortable( true ); // permitir ordernar clicando no titulo da coluna
        $this->setCreateDefaultDeleteButton( true );
        $this->setCreateDefaultEditButton( true );
        $this->setShowAdicionarButton( true );
        $this->setNoDataMessage('Nenhum registro cadastrado!');
        // css da table principal ( externa )
        $this->setProperty( 'border', 0 );
        $this->setProperty( 'cellspacing', 0 );
        $this->setProperty( 'cellpadding', 0 );
        $this->setCss( 'border', '1px solid silver' );
        $this->setClass('tablesorter',false);
        
        // criar o titulo do gride
        $trTitle = $this->addRow();
        $this->titleCell = $trTitle->addCell();
        $this->titleCell->setId( $this->getId() . '_title' );
        $this->titleCell->setClass( 'fwGridTitle' );
        $this->titleCell->setCss( 'text-align', 'center' );
        
        // criar o corpo do gride
        $trBody = $this->addRow();
        $this->bodyCell = $trBody->addCell();
        $this->bodyCell->setId( $this->getId() . '_body' );
        
        // definir as medidas
        $strWidth = is_null( $strWidth ) ? '100%' : $strWidth;
        $this->setWidth( $strWidth );
        $this->setHeight( $strHeight );
        
        // criar o rodape do gride
        $trFooter = $this->addRow();
        $this->footerCell = $trFooter->addCell();
        $this->footerCell->setId( $this->getId() . '_footer' );
        $this->footerCell->setClass( 'fwGridFooter' );
        $this->footerCell->setCss( 'text-align', 'left' );
        
        // zebrar o gride
        $this->setZebrarColors( '#ffffff', '#efefef' );
        
        // iniciar as variáveis de controle de paginação
        $this->currentPage = 1;
        $this->numPages = 0;
        
        if ( isset( $_REQUEST[ 'TGrid' ] ) && $_REQUEST[ 'TGrid' ] > 0 ) {
            /**
             * @todo alterar a chamada do gride para fwAjaxRequest e não mais pela json.onLoad();
             */
            $_REQUEST[ 'dataType' ] = 'text'; // evitar problema com a chamada pela fwAjaxRequest
        }
        
        if ( isset( $_REQUEST[ 'page' ] ) && $_REQUEST[ 'page' ] > 0 ) {
            // chamada via ajax
            $this->currentPage = ( int ) $_REQUEST[ 'page' ];
        }
        else if( isset( $_REQUEST[ $this->getId() . '_jumpToPage' ] ) && $_REQUEST[ $this->getId() . '_jumpToPage' ] > 0 ) {
            // chamada via post
            $this->currentPage = ( int ) $_REQUEST[ $this->getId() . '_jumpToPage' ];
        }
    }
    
    //------------------------------------------------------------------------------------
    /**
     * Retorna o numero de regristros quando for usar uma pagina de banco e não apenas paginação de tela
     *
     * @return int
     */
    public function getRealTotalRowsSqlPaginator(){
        return $this->realTotalRowsSqlPaginator;
    }
    
    //------------------------------------------------------------------------------------
    /**
     * Numero real de registros, deve ser utilizando somento com paginação de banco
     * está relacionado com setMaxRows
     *
     * @param int $realTotalRowsSqlPaginator
     * @return void
     */
    public function setRealTotalRowsSqlPaginator($realTotalRowsSqlPaginator){
        $this->realTotalRowsSqlPaginator = $realTotalRowsSqlPaginator;
    }
    
    //------------------------------------------------------------------------------------
    public function getQtdColumns(){
        return $this->qtdColumns;
    }
    
    //------------------------------------------------------------------------------------
    public function setQtdColumns($qtdColumns){
        $this->qtdColumns = $qtdColumns;
    }
        
    //------------------------------------------------------------------------------------
    public function show( $boolPrint = true ) {
        // quando for requisição de paginação do gride, limpar o buffer de saida
        if( isset($_REQUEST['page'] ) && isset( $_REQUEST['TGrid'] ) ) {
            ob_clean();
        }
        
        $this->showGridProperty();
        
        if ( $this->getColumnCount() == 0 ){
            // nenhuma coluna adicionada
            $row = $this->addRow();
            $row->addCell( 'nenhuma coluna adicionada' );
        }else{
            $this->showButonsUpdateDelete();
            // calcular a quantidade de colunas
            $qtdColumns = $this->getColumnCount() + ( count( $this->getButtons() ) > 0 ? 1 : 0 );
            $this->setQtdColumns($qtdColumns);
            
            // ajustar colspan do header e footer
            $this->titleCell->setProperty( 'colspan',  $this->getQtdColumns() );
            $this->footerCell->setProperty( 'colspan', $this->getQtdColumns() );
            
            // exibir o titulo do gride
            $this->titleCell->add( $this->getTitle() );
            
            if ( $this->getCss( 'font-size' ) ) {
                if ( !$this->titleCell->getCss( 'font-size' ) ) {
                    $this->titleCell->setcss( 'font-size', $this->getCss( 'font-size' ) );
                }
            }
            $this->bodyCell->setProperty( 'valign', 'top' );
            $this->bodyCell->setProperty( 'bgcolor', 'transparent' );
            
            $this->bodyCell->add( $divScrollArea = new TElement( 'div' ) );
            $divScrollArea->clearCss();
            $divScrollArea->setClass( 'fwGridBody' );
            $divScrollArea->setCss( 'width', $this->getWidth() );
            $divScrollArea->setCss( 'height', $this->getHeight() );
            
            $divScrollArea->add( $tableGrid = new TTable( $this->getId() . '_table' ) );
            $tableGrid->setProperty( 'border', '0' );
            $tableGrid->setProperty( 'cellspacing', '0' );
            $tableGrid->setProperty( 'cellpadding', '0' );
            
            $tableGrid->setCss( 'width', '100%' );
            $tableGrid->setCss( 'border-left', '1px solid silver' );
            $tableGrid->setCss( 'border-right', '1px solid silver' );
            //$tableGrid->setCss('border-collapse','collapse');
            //$tableGrid->setCss('height','auto');
            
            // thead e tbody
            $tableGrid->add( $thead = new TElement( 'thead' ) );
            $thead->clearCss();
            $thead->setClass( 'fwHeaderBar' );
            $thead->add( $row = new TTableRow() );
            $row->clearCss();
            $this->tbody = new TElement( 'tbody' );
            $tableGrid->add( $this->tbody );
            $this->tbody->clearCss();
            
            $this->showValidateDraws();
            $this->showColumnActionGrid();
            
            // contador de colunas
            $colIndex = 0;
            $colSort  = null;
            $headersSortable = '';
            // criar as colunas titulo do gride
            foreach( $this->getColumns() as $name => $objColumn ) {
                // aplicar as configurações definidas pelo usuário
                $objConfig = $this->getColumnConfig($colIndex);
                
                if( !is_null( $objConfig ) ) {
                    if( $objConfig->width) {
                        $objColumn->setWidth( $objConfig->width);
                    }
                    if( $objConfig->align ) {
                        $objColumn->setTextAlign( $objConfig->align);
                    }
                    if( $objConfig->arrCss ){
                        $objColumn->setCss( $objConfig->arrCss);
                    }
                    if( $objConfig->visible === false ) {
                        $objColumn->setVisible( false );
                    }
                }
                if( $objColumn->getVisible() ) {
                    if ( ! $this->getSortable()  ) {
                        $objColumn->setSortable( false );
                    }
                    if( ! $objColumn->getSortable() ) {
                        $headersSortable .= ( ($headersSortable == '' ) ? '' :',' );
                        $headersSortable .= $colIndex.': {sorter: false}';
                    } else {
                        if( is_null($colSort)) {
                            $colSort = $colIndex;
                        }
                    }
                    $objColumn->setGridId( $this->getId() );
                    $objColumn->setColIndex( ++$colIndex );
                    
                    $th = new TElement( 'th' );
                    $th->setId( $this->getid().'_th_' . $objColumn->getId() );
                    
                    $th->clearCss();
                    $objColumn->setCss( 'width', $objColumn->getWidth() );
                    $th->setClass( 'fwGridHeader' );
                    $th->setCss( 'width', $objColumn->getWidth() );
                    $th->setCss( 'text-align', $objColumn->getHeaderAlign() );
                    $th->setAttribute('grid_id',$this->getId());
                    $th->setAttribute('column_index',$objColumn->getColIndex());
                    if( $objColumn->getId()=='col_action')
                    {
                        $th->setAttribute( 'column_name', $this->getId().'_action' );
                    }
                    else
                    {
                        $th->setAttribute( 'column_name', strtolower( $objColumn->getFieldName() ) );
                    }
                    
                    if ( $objColumn->getHeader()->getCss( 'background-color' ) )
                    {
                        $th->setCss( 'background-color', $objColumn->getHeader()->getCss( 'background-color' ) );
                    }
                    $objHeader = $objColumn->getHeader();
                    $objHeader->setId( $th->getId() . '_label' );
                    
                    if ( $this->getCss( 'font-size' ) )
                    {
                        if ( !$objHeader->getCss( 'font-size' ) )
                        {
                            $objHeader->setCss( 'font-size', $this->getCss( 'font-size' ) );
                        }
                    }
                    $th->add( $objHeader );
                    
                    if ( $this->getOnDrawHeaderCell() && function_exists( $this->getOnDrawHeaderCell() ) ) {
                        call_user_func( $this->onDrawHeaderCell, $objHeader, $objColumn, $th );
                    }else{
                        $th->add( $th->getValue() );
                    }
                    
                    if ( $this->getReadOnly() ) {
                        $objColumn->setReadOnly( true );
                    }
                    
                    // colcocar checkbox no titulo se a coluna for do tipo checkbox
                    if ( $objColumn->getDataType() == 'checkbox' ) {
                        if ( $objColumn->getAllowCheckAll() )
                        {
                            $chk = new TElement( 'input' );
                            $chk->setProperty( 'type', 'checkbox' );
                            $chk->setProperty( 'value', '1' );
                            $chk->setId( 'chk_' . $objColumn->getId() . '_header' );
                            $chk->setCss( 'cursor', 'pointer' );
                            $chk->setProperty( 'title', 'marcar/desmarcar todos' );
                            $chk->addEvent( 'onclick', "fwGridCheckUncheckAll(this,'{$objColumn->getEditName()}',event)" );
                            if ( $objColumn->getReadOnly() )
                            {
                                $chk->setProperty( 'disabled', 'true' );
                            }
                            
                            if ( isset( $_POST[ $chk->getId()] ) && $_POST[ $chk->getId()] == 1 )
                            {
                                $chk->setProperty( 'checked', '' );
                            }
                            $divChk = new TElement('div');
                            $divChk->setCss(array('padding-left'=>'1.5px','background-color'=>'transparent','display'=>'table-cell','vertical-align'=>'middle') );
                            $divChk->add($chk);
                            $divVal = new TElement('div');
                            $divVal->setCss(array('background-color'=>'transparent','display'=>'table-cell','vertical-align'=>'middle' ) );
                            $divVal->add($objHeader->getValue());
                            $objHeader->setValue( $divChk->show(false).$divVal->show(false) );
                        }
                    }
                    $row->add( $th );
                }else{
                    $colIndex++;
                }
            }
            
            $tableSorterCfg = '';
            if( $headersSortable != '' ) {
                $tableSorterCfg .= 'headers:{'.$headersSortable.'}';
            }
            $this->javaScript[] = 'jQuery("#'.$this->getId().'_table").tablesorter({textExtraction: fwTableSorter ,'.$tableSorterCfg.'});';
            
            $this->validateMaxRowsWithoutUrl();
            
            //Incluir linhas do gride
            if ( !is_array( $this->getData() ) ) {
                $this->showNoRowsFound();
            }else{
                $res = $this->getData();
                
                $res = $this->sortDataByColum ( $res );
                
                $rowNum = 0;
                $rowStart = 0;
                $totalRows = $this->getRowCount();
                $rowEnd = $totalRows;
                
                if ( $this->getMaxRows() > 0 ) {
                    $this->numPages = ceil( $rowEnd / $this->getMaxRows() );
                    
                    // controle de paginacao
                    if ( $this->currentPage > 0 ) {
                        $rowStart = ( $this->currentPage - 1 ) * $this->getMaxRows();
                        $rowEnd = $rowStart + $this->getMaxRows();
                    }
                }
                
                
                
                $keys = array_keys($res);
                foreach( $res[ $keys[0] ] as $k => $v ) {
                    $rowNum = $this->getRowNumWithPaginator( $rowNum ,$rowStart ,$k );
                    $rowNum++;
                    
                    if ( ( $rowNum - 1 ) < $rowStart ) {
                        continue;
                    }
                    
                    if ( ( $rowNum - 1 ) >= $rowEnd ) {
                        break;
                    }
                    // adicionar uma linha na tabela ( tr )
                    $this->tbody->add( $row = new TTableRow() );
                    $row->setProperty( 'id', strtolower( $this->getId() . '_tr_' . $rowNum ) );
                    $row->setProperty( 'grid_id', $this->getId() );
                    $row->clearCss();
                    $row->setClass( 'fwGridRow' );
                    $row->getCss( $objColumn->getCss() );
                    $row->setProperty( 'line_number', $rowNum );
                    $row->setProperty( 'row_count', $totalRows );
                    //$row->setProperty( 'num_rows', $totalRows );
                    
                    if ( $this->onDrawRow ) {
                        call_user_func( $this->onDrawRow, $row, $rowNum, $this->getRowData( $k ) );
                    }
                    
                    if ( !$row->getVisible() ) {
                        continue;
                    }
                    $arrColunms = $this->getColumns();
                    /*if( $rowNum == 1 )
                     {
                     print_r($arrColunms);
                     }
                     */
                    
                    // adicionar as colunas ( td )
                    foreach( $arrColunms as $columnId => $objColumn ) {
                        if( !$objColumn->getVisible() ) {
                            continue;
                        }
                        $fieldName = $objColumn->getFieldName();
                        
                        $this->backgroundColorRowGrid ( $row, $rowNum );
                        $cell = $row->addCell();
                        $cell->setAttribute('column_index',$objColumn->getColIndex() );
                        $cell->setAttribute('grid_id',$this->getId() );
                        $cell->setProperty( 'id', strtolower( $this->getId() . '_td_' . $rowNum ) );
                        //$cell->clearCss();
                        $cell->setClass( 'fwGridCell', false );
                        
                        if ( $objColumn->getNoWrap() || ( is_null( $objColumn->getNoWrap() ) && $this->getNoWrap() === true ) ) {
                            $cell->setProperty( 'nowrap', 'nowrap' );
                        }
                        $cell->setCss( $objColumn->getCss() );
                        $cell->setCss( 'width', null ); // a largura é dada pelo titulo (head)
                        
                        if ( $objColumn->getTextAlign() ) {
                            $cell->setCss( 'text-align', $objColumn->getTextAlign() );
                        }
                        
                        // alterar o tamanho da fonte para o tamanho definido para o gride todo
                        if ( $this->getCss( 'font-size' ) ) {
                            if ( !$cell->getCss( 'font-size' ) ) {
                                $cell->setcss( 'font-size', $this->getCss( 'font-size' ) );
                            }
                        }
                        $cell->setProperty( 'line_number', $rowNum );
                        //$cell->setProperty( 'num_rows', $totalRows );
                        
                        if ( $objColumn->getColumnType() == 'rownum' )
                        {
                            $cell->setProperty( 'id', strtolower( $this->getid() . '_' . $objColumn->getFieldName() . '_' . $rowNum ) );
                            $cell->add( $rowNum );
                            
                            if ( $this->onDrawCell )
                            {
                                call_user_func( $this->onDrawCell, $rowNum, $cell, $objColumn, $this->getRowData( $k ), null );
                            }
                        }
                        else if( $objColumn->getColumnType() == 'plain' or $objColumn->getColumnType() == 'columncompact')
                        {
                            $cell->setProperty( 'field_name', $objColumn->getFieldName() );
                            $cell->setProperty( 'id', strtolower( $this->getid() . '_' . $objColumn->getFieldName() . '_' . $rowNum ) );
                            $tdValue = '';
                            
                            // verificar o nome da coluna informado em caixa alta, baixa e normal
                            $tdValue = $this->getTdValue($res, $fieldName, $k);                            

                            if ($objColumn->getColumnType() == 'columncompact')
                            {
                                if (strlen($tdValue)> $objColumn->getMaxTextLength())
                                {
                                    $cell->setProperty('title', $tdValue);
                                    $tdValue = substr($tdValue, 0, $objColumn->getMaxTextLength()-3).' (...)';
                                }
                            }
                            //$tdValue = isset($res[strtoupper($fieldName)][$k]) && $res[strtoupper($fieldName)][$k] ? $res[strtoupper($fieldName)][$k]: '<center>---</center>';
                            //$tdValue = ( $objColumn->getConvertHtml() ) ? htmlentities($tdValue): $tdValue;
                            $tdValue = ( $tdValue == '' ) ? '&nbsp;' : $tdValue;
                            $cell->setValue( $tdValue );
                            $tdValue = null;
                            
                            if ( $this->onDrawCell )
                            {
                                call_user_func( $this->onDrawCell, $rowNum, $cell, $objColumn, $this->getRowData( $k ), null );
                            }
                            
                            if ( $this->getForm() )
                            {
                                // colocar as cores dos estatus na primeira coluna do gride
                                if ( strtoupper( $columnId ) == strtoupper( $this->getId() . '_AEI' ) )
                                {
                                    $data = $this->getRowData( $k );
                                    
                                    if ( $data[ strtoupper( $this->getId() . '_AEI' )] == 'A' )
                                    {
                                        $cell->clearChildren();
                                        $cell->add( '<center><div style="width:10px;height:10px;background-color:' . $this->getEditedRecordColor() . ';"></div></center>' );
                                    }
                                    else if( $data[ strtoupper( $this->getId() . '_AEI' )] == 'E' )
                                    {
                                        $cell->clearChildren();
                                        $cell->add( '<center><div style="width:10px;height:10px;background-color:' . $this->getDeletedRecordColor() . ';"></div></center>' );
                                    }
                                    else if( $data[ strtoupper( $this->getId() . '_AEI' )] == 'I' )
                                    {
                                        $cell->clearChildren();
                                        $cell->add( '<center><div style="width:10px;height:10px;background-color:' . $this->getNewRecordColor() . ';"></div></center>' );
                                    }
                                    else
                                    {
                                        $cell->clearChildren();
                                        $cell->add( '<center><div style="width:10px;height:10px;background-color:' . $this->getSavedRecordColor() . ';"></div></center>' );
                                    }
                                }
                            }
                        }
                        else if( $objColumn->getColumnType() == 'edit' )
                        {
                            
                            $value = null;
                            // primeiro ler o valor do post, se não existir, ler do $res
                            if ( $objColumn->getFieldName() )
                            {
                                if ( isset( $res[ $objColumn->getFieldName()][ $k ] ) )
                                {
                                    $value = $res[ $objColumn->getFieldName()][ $k ];
                                }
                            }
                            $keyValue = '';
                            if ( $this->getKeyField() )
                            {
                                // chave composta
                                foreach( $this->getKeyField() as $key => $fieldName )
                                {
                                    $keyValue .= trim($res[ $fieldName ][ $k ]);
                                }
                            }
                            if( $keyValue == '')
                            {
                                $keyValue=$v;
                            }
                            $objColumn->setKeyValue( $keyValue );
                            // configurar a coluna
                            $objColumn->setRowNum( $rowNum );
                            $objColumn->setValue( $value );
                            $edit = $objColumn->getEdit();
                            
                            // definir o valor do campo chave para as colunas poderem gerar os edit
                            if ( $this->getKeyField() )
                            {
                                foreach( $this->getKeyField() as $key => $fieldName )
                                {
                                    // Se o edit tiver algum evento definido, adicionar os campos
                                    // chaves e seus valores como atributos para serem recuperados
                                    // no evento se necesário
                                    if ( is_array( $edit->getEvents() ) )
                                    {
                                        $edit->setAttribute( $fieldName, $res[ $fieldName ][ $k ] );
                                    }
                                }
                            }
                            // se a coluna checkbox tiver o campo descrição, adicionar a descrição na opção
                            if ( $objColumn->getDataType() == 'select' )
                            {
                                if ( !$objColumn->getKeyValue() )
                                {
                                    $edit->setName( $edit->getId() . '[' . $rowNum . ']' );
                                    $edit->setId( $edit->getId() . '_' . $rowNum );
                                }
                                if( $objColumn->getFieldName() && isset( $res[ $objColumn->getFieldName()][$k] ) )
                                {
                                    $edit->setOptions( $res[ $objColumn->getFieldName()][$k] );
                                    if( $objColumn->getInitialValueField() && isset($res[ $objColumn->getInitialValueField()][$k]) )
                                    {
                                        // o valor do post deve prevaler sobre o valor inicial
                                        if( ! isset( $_REQUEST[ $edit->getAttribute('fwName') ] ) )
                                        {
                                            $edit->setvalue( $res[ $objColumn->getInitialValueField()][$k] );
                                        }
                                    }
                                    
                                }
                                //$edit->setOptions('1=Um,2=Dois');
                            }
                            else if( $objColumn->getDataType() == 'checkbox' || $objColumn->getDataType() == 'radio' )
                            {
                                $cell->setProperty( 'nowrap', '' );
                                
                                if ( $objColumn->getDescField() )
                                {
                                    $desc = '';
                                    
                                    if ( isset( $res[ $objColumn->getDescField()][ $k ] ) ) $desc = $res[ $objColumn->getDescField()][ $k ];
                                    
                                    else if( isset( $res[ strtoupper( $objColumn->getDescField() )][ $k ] ) ) $desc = $res[ strtoupper( $objColumn->getDescField() )][ $k ];
                                    
                                    else if( isset( $res[ strtolower( $objColumn->getDescField() )][ $k ] ) ) $desc = $res[ strtolower( $objColumn->getDescField() )][ $k ];
                                    $objColumn->setDescValue( $desc );
                                    //$edit->setOptions(array($value=>$desc));
                                    $edit = $objColumn->getEdit();
                                }
                            }
                            //$edit = $objColumn->getEdit();
                            
                            if ( $edit->getEvents() )
                            {
                                foreach( $edit->getEvents() as $eventName => $eventFunction )
                                {
                                    if ( FormDinHelper::pregMatch( '/\(\)/', $eventFunction ) == 1 )
                                    {
                                        $eventFunction = preg_replace( '/\(\)/', '(this,' . $rowNum . ')', $eventFunction );
                                        $edit->setEvent( $eventName, $eventFunction );
                                    }
                                }
                            }
                            
                            //desabilitar o campo se a coluna for readonly
                            if ( $objColumn->getReadOnly() )
                            {
                                // o campo check nao tem setEnabled
                                if ( method_exists( $edit, 'setReadOnly' ) )
                                {
                                    $edit->setReadOnly( true );
                                }
                                else if( method_exists( $edit, 'setEnabled' ) )
                                {
                                    $edit->setEnabled( false );
                                }
                            }
                            
                            $this->showEditAutoComplete($edit,$rowNum, $cell, $keyValue, $objColumn);
                            
                            if ( $this->onDrawCell ){
                                call_user_func( $this->onDrawCell, $rowNum, $cell, $objColumn, $this->getRowData( $k ), $edit );
                            }
                            
                            // deaabilitar todos os edits se o grid for readonly
                            if ( $this->getReadOnly() ){
                                if ( method_exists( $edit, 'setEnabled' ) ){
                                    $edit->setEnabled( false );
                                }
                            }
                        }
                        else if( $objColumn->getColumnType() == 'action' )
                        {
                            //----------------------------------------------------
                            $cell->setClass( 'fwGridCellAction', false );
                            $cell->setProperty( 'nowrap', 'true' );
                            if ( is_array( $this->getButtons() ) )
                            {
                                foreach( $this->getButtons() as $buttonName => $objButton )
                                {
                                    if( $this->getDisabledButtonImage() && FormDinHelper::pregMatch('/fwblank/',$objButton->getImageDisabled() ) )
                                    {
                                        $objButton->setImageDisabled( $this->getDisabledButtonImage() ) ;
                                    }
                                    $ajax = false;
                                    // criar novo botão para não acumular o evento onClick
                                    if( $objButton instanceof TButtonAjax )
                                    {
                                        $ajax=true;
                                        $newButton = new TButtonAjax( $objButton->getName()
                                            , $objButton->getValue()
                                            , $objButton->getAction()
                                            , $objButton->getCallback()
                                            , $objButton->getReturnDataType()
                                            , $objButton->getBeforeSend()
                                            , $objButton->getAsync()
                                            , $objButton->getMessageLoading()
                                            , $objButton->getUrl()
                                            , $objButton->getContainerId()
                                            , $objButton->getConfirmMessage()
                                            , $objButton->getImage()
                                            , $objButton->getImageDisabled()
                                            , $objButton->getHint()
                                            , $objButton->getData()
                                            );
                                    }
                                    else
                                    {
                                        // criar novo botão para não acumular o evento onClick
                                        $newButton = new TButton( $objButton->getName(), $objButton->getValue(), $objButton->getAction(), $objButton->getOnClick(), $objButton->getConfirmMessage(), $objButton->getImage(), $objButton->getImageDisabled(), $objButton->getHint(), $objButton->getSubmitAction() );
                                    }
                                    
                                    $newButton->setClass( $objButton->getClass() );
                                    $newButton->setCss($objButton->getCss());
                                    $newButton->setCss( 'width', "auto" );
                                    $newButton->setCss( 'height', "auto" );
                                    $newButton->setVisible( $objButton->getVisible() );
                                    $newButton->setEnabled( $objButton->getEnabled() );
                                    
                                    // criar a função de atualizar os campos do formulário ao clicar no botão
                                    if ( is_array( $this->getUpdateFields() ) )
                                    {
                                        $strFields = null;
                                        $strValues = null;
                                        $strJquery = null; // para grids offline
                                        
                                        foreach( $this->getUpdateFields() as $field => $formField )
                                        {
                                            $strFields .= is_null( $strFields ) ? '' : '|';
                                            $strFields .= $formField;
                                            $strValues .= is_null( $strValues ) ? '' : '|';
                                            $strJquery .= is_null( $strJquery ) ? '' : ',';
                                            $aKeyFields = $this->getKeyField();
                                            
                                            if ( is_array($aKeyFields) && in_array( $field, $aKeyFields ) )
                                            {
                                                $newButton->setProperty( $field, $res[ $field ][ $k ] );
                                            }
                                            
                                            if ( array_key_exists( $field, $res ) )
                                            {
                                                if ( isset( $res[ $field ][ $k ] ) )
                                                {
                                                    $valeu  = $res[ $field ][ $k ];
                                                    if ( is_array($valeu) ){
                                                        $valeu  = 'PHP Array';
                                                        $strValues .= preg_replace('/'.chr(13).'/','', preg_replace('/'.chr(10).'/','\r',addcslashes($valeu,"'")) );
                                                        $strJquery .= '"' . strtolower( $field ) . '":"' . addcslashes($valeu,"'") . '"';
                                                    } else if ( is_object($valeu) ){
                                                        $valeu  = 'PHP Object';
                                                        $strValues .= preg_replace('/'.chr(13).'/','', preg_replace('/'.chr(10).'/','\r',addcslashes($valeu,"'")) );
                                                        $strJquery .= '"' . strtolower( $field ) . '":"' . addcslashes($valeu,"'") . '"';
                                                    }else {
                                                        $strValues .= preg_replace('/'.chr(13).'/','', preg_replace('/'.chr(10).'/','\r',addcslashes($valeu,"'")) );
                                                        $strJquery .= '"' . strtolower( $field ) . '":"' . addcslashes($valeu,"'") . '"';
                                                    }
                                                }
                                                else
                                                {
                                                    $strValues .= '';
                                                    $strJquery .= '"' . strtolower( $field ) . '":""';
                                                }
                                            }
                                        }
                                        if( !$ajax )
                                        {
                                            if ( $newButton->getOnClick() )
                                            {
                                                // deixar somente o nome da função sem os parametros
                                                $jsFunction = $objButton->getOnClick();
                                                if( substr($strJquery,0,1) != ',' )
                                                {
                                                    $strJquery = ','.$strJquery;
                                                }
                                                $pos = strpos( $jsFunction, '(' );
                                                
                                                if ( $pos > 0 )
                                                {
                                                    $jsFunction = substr( $jsFunction, 0, $pos );
                                                }
                                                
                                                if ( !$this->getForm() ) {
                                                    $jsFunction .= '("' . $strFields . '","' . $strValues . '","' . $this->getId() . '","' . $rowNum . '")';
                                                }else {
                                                    $postParentField = PostHelper::get('parent_field');
                                                    $jsFunction = 'jQuery("#' . $postParentField . '").load(app_url+app_index_file,{"ajax":0,"gridOffline":"1","modulo":"' . $this->getUrl() . '","parent_field":"' . $postParentField . '","subform":1,"' . $this->getId() . 'Width":"' . $this->getWidth() . '","action":"' . $newButton->getAction() . '"' . $strJquery . '} );';
                                                }
                                            }
                                            else
                                            {
                                                $strFields = 'fwAtualizarCampos("' . $strFields . '","' . $strValues . '");';
                                                $jsFunction = $strFields;
                                                if ( $newButton->getSubmitAction() )
                                                {
                                                    $jsFunction .= 'fwFazerAcao("' . $newButton->getAction() . '")';
                                                }
                                            }
                                            $newButton->setOnClick( $jsFunction );
                                            // retirar a acao do botão para valer o evento onclick;
                                            $newButton->setAction( null );
                                        }
                                        else
                                        {
                                            $params=null;
                                            if( $strFields )
                                            {
                                                $aFields = explode('|',$strFields);
                                                $aValues = explode('|',$strValues);
                                                $params=array();
                                                foreach($aFields as $k1=>$v1)
                                                {
                                                    $params[$v1] = $aValues[$k1];
                                                }
                                                // ajax button
                                                $data = $newButton->getData();
                                                //$data['fields']=$strFields;
                                                //$data['values']=$strValues;
                                                if( ! isset( $params['gdRownum'] ) )
                                                {
                                                    $params['gdRownum'] = $rowNum;
                                                }
                                                if( ! isset( $params['gdId'] ) )
                                                {
                                                    $params['gdId'] = $this->getId();
                                                }
                                                $data['grid'] = $params;
                                            }
                                            $newButton->setData( $data );
                                        }
                                    }
                                    
                                    $cell->add( $newButton );
                                    
                                    if ( $this->onDrawActionButton )
                                    {
                                        call_user_func( $this->onDrawActionButton, $rowNum, $newButton, $objColumn, $this->getRowData( $k ), $row );
                                    }
                                    
                                    // se o botão estiver invisível, trocar para uma imagem transparente para manter o epaçamento dos outros botões
                                    if ( !$newButton->getVisible() )
                                    {
                                        $newButton->setEnabled( false );
                                        $newButton->setVisible( true );
                                        $newButton->setImageDisabled( 'fwDisabled.png' );
                                    }
                                    
                                    // alterar o rotulo do botão excluir para recuperar quando o registro tiver excluido
                                    if ( $this->getForm() )
                                    {
                                        if ( strtolower( $newButton->getId() ) == strtolower( 'btn' . $this->getId() . '_edit' ) )
                                        {
                                            $data = $this->getRowData( $k );
                                            
                                            if ( $data[ strtoupper( $this->getId() . '_AEI' )] == 'E' )
                                            {
                                                $newButton->setEnabled( false );
                                            }
                                        }
                                        else if( strtolower( $newButton->getId() ) == strtolower( 'btn' . $this->getId() . '_delete' ) )
                                        {
                                            $data = $this->getRowData( $k );
                                            
                                            if ( $data[ strtoupper( $this->getId() . '_AEI' )] == 'E' )
                                            {
                                                $newButton->setValue( 'Recuperar' );
                                                $newButton->setHint( 'Recuperar' );
                                                // alterar a confirm message.
                                                //$newButton->setImage('lixeira_cancelar.gif');
                                                $newButton->setImage( 'undo16.gif' );
                                                $newButton->setConfirmMessage( 'Confirma a recuperação do registro ?' );
                                            }
                                        }
                                    }
                                    
                                    if ( $this->getReadOnly() )
                                    {
                                        $newButton->setEnabled( false );
                                    }
                                }
                            }
                        }
                    }
                    
                    $this->includeHiddenField($row, $res, $rowNum, $k);
                }
                
                // adicionar a imagem do excel no rodapé
                if ( $this->getExportExcel() ) {
                    $this->generateFileExcel ();
                }
                //$btnExcel = new TButton('btnExcel','Excel',null,'alert("excel")',null,'excel.gif',null,'Exportar dados para o excel');
                // adicionar a barra de navegação no fim do gride
                if ( $this->getMaxRows() ) {
                    //$this->setNavButtons($tbody,$qtdColumns);
                    $this->setNavButtons( $this->footerCell, $this->getQtdColumns() );
                }
            }
        }
        
        if ( isset( $_REQUEST[ 'ajax' ] ) && $_REQUEST[ 'ajax' ] && isset( $_REQUEST[ 'page' ] ) && $_REQUEST[ 'page' ] && $_REQUEST[ 'page' ] > 0 )
        {
            $this->tbody->show( true );
            return;
        }
        if ( $this->javaScript ) {
            $js = str_replace( ';;', ';', implode( ';', $this->javaScript ) );
            $this->tbody->add( '<script>jQuery(document).ready(function() {' . $js . '});</script>' );
        }
        return parent::show( $boolPrint );
    }
    

    /**
     * Show Gried Field AutoComplete
     * @param string $edit
     * @param int $rowNum
     * @param string $cell
     * @param string $keyValue
     * @param object $objColumn
     */
    private function showEditAutoComplete($edit,$rowNum, $cell, $keyValue, $objColumn)
    {
        if ( $edit ){
            $fieldName = strtolower($objColumn->getFieldName());
            if( is_array($this->autocomplete) ){ //Test to PHP 7.4
                $ac = $this->autocomplete[$fieldName];
                if ( is_object($ac) ) {
                    // transformar os campos de update para array
                    $up = $ac->getUpdateFields();
                    $ac->setUpdateFields( null );
                    
                    if ( $up ) {
                        if ( is_string( $up ) ) {
                            $up = explode( ',', $up );
                        }
                        $upFields = '';
                        
                        foreach( $up as $key => $value ) {
                            $value = explode( '%', $value );
                            $upFields .= $upFields == '' ? '' : ',';
                            $upFields .= $value[ 0 ] . '%' . $objColumn->getRowNum();
                        }
                        $ac->setUpdateFields( $upFields );
                    }
                    $ac->setFieldName( $edit->getId() );
                    // parametros defaul
                    $ac->setCallBackParameters( "'" . $keyValue . "'," . $objColumn->getRowNum() . ',' . $this->getRowCount() );
                    
                    // verificar se o usuário quer redefinir os parametros
                    if ( $this->getOnGetAutocompleteParameters() ){
                        call_user_func( $this->onGetAutocompleteParameters, $ac, $this->getRowData( $k ), $rowNum, $cell, $objColumn );
                    }
                    $edit->setHint( $ac->getHint() );
                    $this->javaScript[] = $ac->getJs() . "\n";
                }
            }
            $cell->add( $edit );
        }
    }

    
    /**
     * Include Hidden Fields on Grid
     * @param row
     * @param res
     * @param fieldName
     * @param k
     */
     private function includeHiddenField($row, $res, $rowNum, $k)
    {
        // adicionar os campos ocultos na linha ( tr )
        if ( $this->getHiddenField() )
        {
            foreach( $this->getHiddenField() as $fieldName => $id )
            {
                $value = '';
                
                if ( isset( $_POST[ strtolower( $id )][ $k ] ) )
                {
                    $value = $_POST[ strtolower( $id )][ $k ];
                }
                else if( isset( $res[ $fieldName ][ $k ] ) )
                {
                    $value = $res[ $fieldName ][ $k ];
                }
                else if( isset( $res[ strtoupper( $fieldName )][ $k ] ) )
                {
                    $value = $res[ strtoupper( $fieldName )][ $k ];
                }
                $hidden = new THidden( strtolower( $id ) . '[' . $k . ']' );
                $hidden->setId( strtolower( $id ) . '_' . $rowNum );
                $hidden->setValue( $value );
                $row->add( $hidden );
            }
        }
     }

    /**
     * @param row
     * @param rowNum
     */
    public function backgroundColorRowGrid($row, $rowNum) {
        // zebrar o gride se nao existir a funcao ondrawrow definida pelo usuario
        if ( $this->getZebrarColors( 0 ) ) {
            // não sobrepor se o background color estiver definido
            if ( !$row->getCss( 'background-color' ) ) {
                if ( $rowNum % 2 != 0 ) {
                    $row->setCss( 'background-color', $this->getZebrarColors( 0 ) );
                }else {
                    $row->setCss( 'background-color', $this->getZebrarColors( 1 ) );
                }
            }
        }
    }
    
    private function getTdValueByType($value) {
        $tdValue = '';
        
        if ( is_array($value) ){
            $tdValue = 'PHP Array';
        } else if ( is_object ($value) ){
            $tdValue = 'PHP Object';
        } else {
            $tdValue = ( ( (string) $value  <> '' ) ? $value : '' );
        }
        return $tdValue;
    }    

    /***
     *  Return value of TD in the grid 
     * @param array $res
     * @param string $fieldName
     * @param number $k
     * @return mixed
     */
    private function getTdValue($res,$fieldName,$k) {
        $tdValue = '';
        
        if ( isset( $res[ $fieldName ][ $k ] ) )
        {
            $value = $res[ $fieldName ][ $k ];
            $tdValue = $this->getTdValueByType($value);
        }
        else if( isset( $res[ strtolower( $fieldName )][ $k ] ) )
        {
            $value = $res[ strtolower( $fieldName )][ $k ];
            $tdValue = $this->getTdValueByType($value);
        }
        else if( isset( $res[ strtoupper( $fieldName )][ $k ] ) )
        {
            $value = $res[ strtoupper( $fieldName )][ $k ];
            $tdValue = $this->getTdValueByType($value);
        }
        return $tdValue;
    }
    
    /**
     * @param cell
     */
    private function showNoRowsFound() {
        // nenhum registro encontrado
        $this->tbody->add( $row = new TTableRow() );
        $row->clearCss();
        $cell = $row->addCell( '<center>'.$this->getNoDataMessage().'</center>' );
        $cell->clearCss();
        $cell->setClass( 'fwGridCell' );
        $cell->setCss( 'color', '#ff0000' );
        $cell->setCss( 'width', 'auto' );
        $cell->setProperty( 'colspan', $this->getQtdColumns() );
    }
    
    /**
     * @param colAction
     */
    protected function showColumnActionGrid() {
        // adicionar a coluna de ações do gride se tiver botoes adicionados
        if ( $this->getButtons() ) {
            $colAction = $this->addColumn( null, $this->getActionColumnTitle(), 'auto' );
            $colAction->setId('col_action');
            $colAction->setColumnType( 'action' );
            $colAction->setCss( 'text-align', 'center' );
            // distãncia entre a borda e os botões
            $colAction->setCss( 'padding', '2.5px' );
        }
    }
    
    /***
     * esconder o titulo se o titulo do gride for null
     */
    protected function showTitle() {
        if ( is_null( $this->getTitle() ) ){
            $this->titleCell->setCss( 'display', 'none' );
        }
    }
    
    /**
     * tentar criar as colunas automaticamente utilizando o array de dados
     */
    protected function showColumn() {
        if ( $this->getColumnCount() == 0 ){
            $this->autoCreateColumns();
        }
    }
    
    protected function showGridProperty() {
        // se o grid for offline, criar as colunas e configurar o form
        if ( $this->getForm() ) {
            $this->configOffLine();
        }
        
        if( $this->getWidth() == '100px' ){
            $this->setProperty('fullwidth','true');
        }
        // definir as medidas do gride
        $this->setProperty( 'width', $this->getWidth() );
        $this->setProperty( 'height', $this->getHeight() );
        $this->setProperty( 'row_count', $this->getRowCount() );
        $this->setProperty('fieldtype','grid' );
        
        $fldSortedColumn      = new THidden( $this->getId() . '_sorted_column' );
        $fldSortedColumnOrder = new THidden( $this->getId() . '_sorted_column_order' );
        $fldCollapsed 		  = new THidden( $this->getId() . '_collapsed' );
        //$this->add('<input id="'.$this->getId().'_sorted_column" type="hidden" value="">');
        $this->add($fldSortedColumn);
        $this->add($fldSortedColumnOrder);
        $this->add($fldCollapsed);
        
        $this->showTitle();
        $this->showColumn();
    }
    
    protected function showButonsUpdateDelete() {
        // adicionar os botões Alterar e Excluir
        if ( $this->getCreateDefaultButtons() ) {
            $imgEdit = null;
            $imgDeleter = null;
            
            if ( $this->getUseDefaultImages() ) {
                $imgEdit = 'alterar.gif';
                $imgDelete = 'lixeira.gif';
            }
            
            if ( $this->getCreateDefaultEditButton() ) {
                $this->addbutton( 'Alterar', $this->getId() . '_alterar', null, null, null, $imgEdit, null, 'Alterar' );
            }
            
            if ( $this->getCreateDefaultDeleteButton() ) {
                //$this->addButton('Excluir',$this->getId().'_excluir',null,null,'Confirma exclusão ?',$imgDelete,null,'Excluir');
                $this->addButton( 'Excluir', $this->getId() . '_excluir', null, 'fwGridConfirmDelete()', null, $imgDelete, null, 'Excluir' );
            }
        }
    }
    
    protected function showValidateDraws() {
        // se a funcao ondrawRow estiver definia e nao existir, retirar o evento
        if ( $this->getOnDrawRow() && !function_exists( $this->getOnDrawRow() ) ) {
            $this->setOnDrawRow( null );
        }
        
        // se a funcao ondrawcell estiver definia e nao existir, retirar o evento
        if ( $this->getOnDrawCell() && !function_exists( $this->getOnDrawCell() ) ) {
            $this->setOnDrawCell( null );
        }
        
        // se a funcao ondrawcell estiver definia e nao existir, retirar o evento
        if ( $this->getOnDrawHeaderCell() && !function_exists( $this->getOnDrawHeaderCell() ) ) {
            $this->setOnDrawHeaderCell( null );
        }
        
        // se a funcao ondrawActionButton estiver definia e nao existir, retirar o evento
        if ( $this->getOnDrawActionButton() && !function_exists( $this->getOnDrawActionButton() ) ){
            $this->setOnDrawActionButton( null );
        }
        
        // se a funcao onGetAutocompleteCallBackParameters estiver definia e nao existir, retirar o evento
        if ( $this->getOnGetAutocompleteCallBackParameters && !function_exists( $this->getOnGetAutocompleteCallBackParameters() ) ) {
            $this->setOnGetAutocompleteCallBackParameters( null );
        }
    }
    
    
    /***
     * avisar erro se tiver passado o parametro maxRows e não tiver informado a url
     */
    private function validateMaxRowsWithoutUrl() {
        if ( $this->getMaxRows() && !$this->url ) {
            $this->footerCell->add( '<blink><span style="color:red;font-weight:bold;">Para utilizar o recurso de paginação, o parametro strRequestUrl, tambem dever ser informado</span></blink>' );
        }
    }
    
    /**
     * sort Data Gride by colum
     */
    public function sortDataByColum($res) {
        if( isset($_REQUEST[$this->getId().'_sorted_column'] ) ) {
            $res = $this->sortArray($res,$_REQUEST[$this->getId().'_sorted_column'],$_REQUEST[$this->getId().'_sorted_column_order']);
        }
        return $res;
    }
    
    /**
     * Generate File Excel
     */
    public function generateFileExcel() {
        //$_SESSION['fwGrid'][$this->getId()] = $this->getData2Excel();
        //$_SESSION['fwGrid'][$this->getId()]['titulo'] =$this->getTitle();
        $excel = new TElement( 'a' );
        $excel->setProperty( 'href', 'javascript: void(0)' );
        $arrParams = null;
        $arrParams[ 'id' ] 		= $this->getId();
        $arrParams[ 'head' ] 	= $this->getExcelHeadField('utf8');
        $arrParams[ 'title' ] 	= $this->getTitle();
        $excel->addEvent( 'onclick', 'fwExportGrid2Excel(' . json_encode( $arrParams ) . ')' );
        $img = new TElement( 'img' );
        $img->setProperty( 'src', $this->getBase() . 'imagens/planilha.png' );
        $img->setCss( 'border', 'none' );
        $img->setCss( 'width', '16' );
        $img->setCss( 'height', '13' );
        $excel->setProperty( 'title', 'Exportar planilha' );
        $excel->add( $img );
        $excel->setCss( 'float', 'right' );
        $this->footerCell->add( $excel );
        
        // salvar o array em disco
        $tmpName = $excel->getBase().'tmp/tmp_'.$this->getId().'_'.session_id().'.go';
        if( !file_exists( $excel->getBase().'tmp' ) ) {
            mkdir( $excel->getBase().'tmp' );
        }
        if( file_exists( $tmpName ) ) {
            @unlink($tmpName);
        }
        if( !file_put_contents( $tmpName, serialize( $this->getData2Excel() ) ) ) {
            $excel->setAttribute('title',htmlentities('Erro ao salvar os dados para exportação',null,ENCODINGS));
        }
    }
    
    //------------------------------------------------------------------------------------
    public function getColumns()
    {
        return $this->columns;
    }
    
    //------------------------------------------------------------------------------------
    public function getColumn( $strColumnName )
    {
        $strColumnName = strtolower( $strColumnName );
        
        if ( isset( $this->columns[ $strColumnName ] ) )
        {
            return $this->columns[ $strColumnName ];
        }
        return null;
    }
    
    //------------------------------------------------------------------------------------
    public function getColumnCount()
    {
        if ( is_array( $this->getColumns() ) )
        {
            return ( int ) count( $this->columns );
        }
        return 0;
    }
    
    //------------------------------------------------------------------------------------
    /**
     * Coluna normal para o grid
     * @param string $strFieldName 1: ID da coluna = Nome da coluna da tabela
     * @param string $strValue     2: Nome do Label que irá aparecer 
     * @param integer $strWidth    3: tamanho da coluna
     * @param string $strTextAlign 4: Alinhamento do texto left|right|center|justify
     * @return TGridColumn
     */
    public function addColumn( $strFieldName, $strValue = null, $strWidth = null, $strTextAlign = null )
    {
        $col = new TGridColumn( $strFieldName, $strValue, $strWidth, $strTextAlign );
        $col->clearCss();
        $col->setGridId($this->getId());
        $this->columns[ $col->getId()] = $col;
        return $col;
    }
    //------------------------------------------------------------------------------------
    /**
     * Coluna com texto reduzido, deve ser usado quando o texto é longo. Depois do ponto de corte irá aparece ...
     * @param string $strFieldName     1: ID da coluna = Nome da coluna da tabela
     * @param string $strValue         2: Nome do Label que irá aparecer
     * @param integer $strWidth        3: tamanho da coluna
     * @param string $strTextAlign     4: Alinhamento do texto left|right|center|justify
     * @param number $strMaxTextLength 5: tamanho do texto antes do corte
     * @return TGridColumnCompact
     */
    public function addColumnCompact( $strFieldName, $strValue = null, $strWidth = null, $strTextAlign = null, $strMaxTextLength = 40  )
    {
        $col = new TGridColumnCompact( $strFieldName, $strValue, $strWidth, $strTextAlign, null,null,null,$strMaxTextLength);
        $col->clearCss();
        $col->setGridId($this->getId());
        $this->columns[ $col->getId()] = $col;
        return $col;
    }
    //------------------------------------------------------------------------------------
    /**
     * Use esse campo quando vc precisa pegar alguma informação sobre o regristro porém não pode mostrar a coluna
     * @param string $strFieldName Nome do campo na tabela
     * @param string $strId Nome do campo que será usado
     */
    public function addHiddenField( $strFieldName, $strId = null )
    {
        $strId = is_null( $strId ) ? strtolower( $strFieldName ) : $strId;
        $this->hiddenField[ $strFieldName ] = $strId;
    }
    
    //------------------------------------------------------------------------------------
    public function getHiddenField()
    {
        return $this->hiddenField;
    }
    
    //------------------------------------------------------------------------------------
    protected function addActionColumn( $strTitle = null )
    {
        $this->columns[ $strTitle ] = new TActionColumn( $strTitle );
    }
    
    //------------------------------------------------------------------------------------
    public function setTitle( $strValue = null )
    {
        $this->title = $strValue;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    //------------------------------------------------------------------------------------
    public function setData( $mixValue = null ){
        if ( is_array( $mixValue ) ) {
            $keys = array_keys($mixValue);
            if ( empty($keys) ) {
                $mixValue = null;
            }
        }
        $this->data = $mixValue;
    }
    
    //---------------------------------------------------------------------------------------
    /**
     * Retorna o array de dados do gride
     */
    public function getData() {
        $res = null;
        
        if ( is_array( $this->data ) ) {
            $keys = array_keys( $this->data );
            if( ! is_array($this->data[$keys[0]] ) || isset($this->data[$keys[0]][0] ) ) {
                return $this->data;
            }
            return $this->data;
        }
        else if( strpos( strtolower( $this->data ), 'select ' ) !== false ) {
            
            $bvars = null;
            $bvars = $this->getBvars();
            
            if ( function_exists( 'recuperarPacote' ) )
            {
                $cache = $this->getCache();
                print_r( $GLOBALS[ 'conexao' ]->executar_recuperar( $this->data, $bvars, $res, $cache ) );
            }
            else if( !class_exists( 'TPDOConnection' ) || !TPDOConnection::getInstance() )
            {
                $res = TPDOConnection::executeSql( $this->data );
            }
        }
        //else if( strpos(strtolower($this->data),'pk_') !== false || strpos(strtolower($this->data),'pkg_') !== false )
        else if( FormDinHelper::pregMatch( '/\.PK\a?/i', $this->data ) > 0 )
        {
            $bvars = $this->getBvars();
            $cache = $this->getCache();
            print_r( recuperarPacote( $this->data, $bvars, $res, $cache ) );
        }
        else if( !is_null( $this->data ) )
        {
            $where = '';
            
            if ( is_array( $this->getBvars() ) )
            {
                foreach( $this->getBvars() as $k => $v )
                {
                    $where .= $where == '' ? '' : ' and ';
                    $where .= "($k='$v')";
                }
                $where = $where == '' ? '' : ' where ' . $where;
            }
            $sql = "SELECT * FROM {$this->data} {$where}";
            $cache = $this->getCache();
            $bvars = null;
            
            if ( function_exists( 'recuperarPacote' ) )
            {
                print_r( $GLOBALS[ 'conexao' ]->executar_recuperar( $sql, $bvars, $res, $cache ) );
            }
            else if( !class_exists( 'TPDOConnection' ) || !TPDOConnection::getInstance() )
            {
                $res = TPDOConnection::executeSql( $sql );
            }
        }
        
        if ( $res ) {
            $this->setData( $res );
        }
        return $res;
    }
    
    //------------------------------------------------------------------------------------
    public function addKeyField( $strNewValue = null )
    {
        if ( $strNewValue )
        {
            if ( is_array( $this->getKeyField() ) )
            {
                if ( array_search( $strNewValue, ( array ) $this->getKeyField() ) === false )
                {
                    $this->keyField[] = $strNewValue;
                }
            }
            else
            {
                $aTemp = explode( ',', $strNewValue );
                
                if ( is_array( $aTemp ) )
                {
                    foreach( $aTemp as $v )
                    {
                        $this->keyField[] = $v;
                    }
                }
                //$this->keyField[] = $strNewValue;
            }
        }
    }
    
    //------------------------------------------------------------------------------------
    public function getKeyField()
    {
        return $this->keyField;
    }
    
    //------------------------------------------------------------------------------------
    /**
     * Adicionar botão na linha do gride
     *
     * $boolSubmitAction = adicionar/remover a função fwFazerAcao(). Padrão=true
     *
     * @param string $strRotulo         - 1: Nome do Label do Botão ou Hint que irá aparecer na imagem se o Hint estiver em branco
     * @param string $strAction         - 2: Nome da ação capitura no formDinAcao
     * @param string $strName           - 3: Nome
     * @param string $strOnClick        - 4: JavaScript que será chamado no evento OnClick
     * @param string $strConfirmMessage - 5: Mensagem com caixa de confirmação
     * @param string $strImage          - 6: Imagem que irá aparecer
     * @param string $strImageDisabled  - 7: Imagem quado desabilitado
     * @param string $strHint
     * @param boolean $boolSubmitAction
     * @return object> TButton
     */
    public function addButton( $strRotulo
        , $strAction = null
        , $strName = null
        , $strOnClick = null
        , $strConfirmMessage = null
        , $strImage = null
        , $strImageDisabled = null
        , $strHint = null
        , $boolSubmitAction = null
        ){
            if ( is_null( $strName ) ){
                $strName = $this->getId() . ucwords( $this->removeIllegalChars( $strRotulo ) );
            }
            if ( is_null( $strAction ) && is_null( $strOnClick ) ){
                $strAction = strtolower( $this->getId() . '_' . $strRotulo );
            }
            $this->buttons[ $strName ] = new TButton( $strName, $strRotulo, $strAction, $strOnClick, $strConfirmMessage, $strImage, $strImageDisabled, $strHint, $boolSubmitAction );
            // se o usuário adicionar um botão, cancelar a criação dos botões padrão de alterar e excluir
            $this->enableDefaultButtons( false );
            return $this->buttons[ $strName ];
    }
    
    //---------------------------------------------------------------------------------------
    public function addButtonAjax($strRotulo,$strAction,$strImage=null,$strImageDisabled=null,$strName=null,$strConfirmMessage=null,$jsBeforeSendFnc=null,$jsCallbackFnc=null,$strReturnType=null,$strMsgLoading=null,$strModuleName=null,$boolAsync=null,$strContainerId=null,$strHint=null,$arrData=null)
    {
        $strReturnType  = ( $strReturnType == 'text' ? 'text' : 'json' );
        $strMsgLoading  = is_null( $strMsgLoading ) ? 'Processando. Aguarde...': $strMsgLoading;
        $boolAsync      = ( $boolAsync===true ? true : false );
        $button = new TButtonAjax($strName,$strRotulo,$strAction,$jsCallbackFnc,$strReturnType,$jsBeforeSendFnc,$boolAsync,$strMsgLoading,$strModuleName,$strContainerId,$strConfirmMessage,$strImage,$strImageDisabled,$strHint,$arrData);
        $this->enableDefaultButtons( false );
        $this->buttons[$strName] = $button;
        return $this->buttons[$strName];
    }
    
    //---------------------------------------------------------------------------------------
    public function getButtons()
    {
        return ( array ) $this->buttons;
    }
    
    //------------------------------------------------------------------------------------
    /**
     * Seta o nome de uma função que será usada para desenhar as linha da tabela.
     * 
     * Parametros do envento onDrawRow
     * 	1) $row 		- objeto TGridRow
     * 	2) $rowNum 		- número da linha corrente
     * 	3) $aData		- o array de dados da linha ex: $res[''][n]
     * @param string $newValue
     */
    public function setOnDrawRow( $newValue = null )
    {
        $this->onDrawRow = $newValue;
    }
    
    //------------------------------------------------------------------------------------
    public function getOnDrawRow()
    {
        return $this->onDrawRow;
    }
    
    //------------------------------------------------------------------------------------
    /**
     * Seta o nome de uma função que será usada para desenhar as celula da tabela.
     * 
     * Parametros do envento onDrawCell
     * 	1) $rowNum 		- número da linha corrente
     * 	2) $cell		- objeto TTableCell
     * 	3) $objColumn	- objeto TGrideColum
     * 	4) $aData		- o array de dados da linha ex: $res[''][n]
     * 	5) $edit		- o objeto campo quando a coluna for um campo de edição
     *   ex: function ondrawCell($rowNum=null,$cell=null,$objColumn=null,$aData=null,$edit=null)
     * 
     * @param string $newValue
     */
    public function setOnDrawCell( $newValue = null )
    {
        $this->onDrawCell = $newValue;
    }
    
    //------------------------------------------------------------------------------------
    public function getOnDrawCell()
    {
        return $this->onDrawCell;
    }    
    //------------------------------------------------------------------------------------
    /**
     * Seta o nome de uma função que será usada para desenhar o Header do Grid
     * Um exemplo tipo é modificar o texto por uma imagem
     * 
     * Parametros do evento onDrawHeaderCell
     * 	1) $th			- objeto TElement
     * 	2) $objColumn 	- objeto TGridColum
     * 	3) $objHeader 	- objeto TElement
     * @param string $newValue
     */
    public function setOnDrawHeaderCell( $newValue = null )
    {
        $this->onDrawHeaderCell = $newValue;
    }
    //------------------------------------------------------------------------------------
    /***
     * Verifica se foi informada alguma função 
     * @return string
     */
    public function getOnDrawHeaderCell()
    {
        return $this->onDrawHeaderCell;
    }
    
    //------------------------------------------------------------------------------------
    /**
     * Seta o nome de uma função que será usada para desenhar os botões de uma linha da gride.
     * Um exemplo tipico é desabilitar determinado botão se o Registro estiver no estado X
     * 
     * Parametros do evento onDrawActionButton
     * 	1) $rowNum 		- número da linha corrente
     * 	2) $button 		- objeto TButton
     * 	3) $objColumn	- objeto TGrideColum
     * 	4) $aData		- o array de dados da linha ex: $res[''][n]
     *   Ex: function tratarBotoes($rowNum,$button,$objColumn,$aData);
     * 
     * @param string $newValue
     */
    public function setOnDrawActionButton( $newValue = null )
    {
        $this->onDrawActionButton = $newValue;
    }
    
    //------------------------------------------------------------------------------------
    public function getOnDrawActionButton()
    {
        return $this->onDrawActionButton;
    }
    
    //------------------------------------------------------------------------------------
    /**
     * Campos do form origem que serão atualizados ao selecionar o item desejado. Separados por virgulas seguindo o padrão <campo_tabela> | <campo_formulario> , <campo_tabela> | <campo_formulario>
     * @param string $mixUpdateFields
     */
    public function setUpdateFields( $mixUpdateFields = null )
    {
        if ( $mixUpdateFields )
        {
            if ( is_array( $mixUpdateFields ) )
            {
                foreach( $mixUpdateFields as $k => $v )
                {
                    if ( is_numeric( $k ) )
                    {
                        $k = $v;
                        $v = strtolower( $v );
                    }
                    $this->setUpdateFields( $k . '|' . $v );
                }
            }
            else if( strpos( $mixUpdateFields, ',' ) !== false )
            {
                $a = explode( ',', $mixUpdateFields );
                $this->setUpdateFields( $a );
            }
            else
            {
                $aFields = explode( '|', $mixUpdateFields );
                
                if ( !isset( $aFields[ 1 ] ) )
                {
                    $aFields[ 0 ] = strtoupper( $aFields[ 0 ] );
                    $aFields[ 1 ] = strtolower( $aFields[ 0 ] );
                }
                
                if ( $aFields[ 0 ] != '' )
                {
                    $this->updateFields[ $aFields[ 0 ] ] = $aFields[ 1 ];
                }
            }
        }
    }
    
    //------------------------------------------------------------------------------------
    public function getUpdateFields()
    {
        $arrResult = $this->updateFields;
        
        if ( $arrResult )
        {
            // adicionar o campo chave na lista de campos a serem atualizados
            if ( $this->getKeyField() )
            {
                $keyValue = '';
                
                foreach( $this->getKeyField() as $key => $fieldName )
                {
                    if ( !in_array( $fieldName, $arrResult ) )
                    {
                        $this->setUpdateFields( $fieldName );
                    }
                }
            }
        }
        return $arrResult;
    }
    
    //------------------------------------------------------------------------------------
    public function clearUpdateFields()
    {
        $this->updateFields = null;
    }
    
    //------------------------------------------------------------------------------------
    public function getWidth()
    {
        if ( is_null( $this->width ) )
        {
            return 'auto';
        }
        else
        {
            if ( strpos( $this->width, '%' ) === false )
            {
                $w = preg_replace( '/[^0-9]/', '', $this->width ) . 'px';
                $w = $w == 'px' ? 'auto' : $w;
            }
            else
            {
                return $this->width;
            }
        }
        return $w;
    }
    
    //---------------------------------------------------------------------------------------
    public function getHeight()
    {
        if ( is_null( $this->height ) )
        {
            return 'auto';
        }
        else
        {
            if ( strpos( $this->height, '%' ) === false )
            {
                $w = preg_replace( '/[^0-9]/', '', $this->height ) . 'px';
                $w = $w == 'px' ? 'auto' : $w;
            }
            else
            {
                return $this->height;
            }
        }
        return $w;
    }
    
    //------------------------------------------------------------------------------------
    public function setWidth( $strNewValue = null )
    {
        $this->width = $strNewValue;
    }
    
    //------------------------------------------------------------------------------------
    public function setHeight( $strNewValue = null )
    {
        $this->height = $strNewValue;
    }
    
    //------------------------------------------------------------------------------------
    public function setActionColumnTitle( $strNewValue = null )
    {
        $this->actionColumnTitle = $strNewValue;
    }
    
    //------------------------------------------------------------------------------------
    public function getActionColumnTitle( $strNewValue = null )
    {
        if ( is_null( $this->actionColumnTitle ) ){
            return htmlentities( 'Ação',ENT_COMPAT, ENCODINGS );
        }
        return htmlentities( $this->actionColumnTitle,null, ENCODINGS );
    }
    
    //---------------------------------------------------------------------------------------
    public function getRowData( $intRow = null )
    {
        $aData = array();
        
        if ( !is_null( $intRow ) )
        {
            foreach( $this->data as $k => $v )
            {
                $aData[ $k ] = $this->data[ $k ][ $intRow ];
            }
        }
        return $aData;
    }
    
    //---------------------------------------------------------------------------------------
    /**
     * Seta as cores para Zebrar um Grid, informe valores em Hexadecimal
     * como #efefef ou #ffffff
     *
     * @param string $strColor1
     * @param string $strColor2
     * @return void
     */
    function setZebrarColors( $strColor1 = null, $strColor2 = null )
    {
        HtmlHelper::validateHtmlColorHexa($strColor1);
        HtmlHelper::validateHtmlColorHexa($strColor2);
        $this->zebrarColors = array( $strColor1, $strColor2 );
    }
    
    //---------------------------------------------------------------------------------------
    function getZebrarColors( $intColor = null )
    {
        if ( $intColor == 0 || $intColor == 1 )
        {
            return isset( $this->zebrarColors[ $intColor ] ) ? $this->zebrarColors[ $intColor ] : ( ( $intColor == 0 ) ? '#efefef' : '#ffffff' );
        }
        return $this->zebrarColors;
    }
    
    //---------------------------------------------------------------------------------------
    /***
     * Adciona um campo do tipo texto livre, equivalente ao addTextField
     * @param string $strName      - id do campo
     * @param string $strTitle     - Titulo da coluna
     * @param string $strFieldName - id do array que veio do banco
     * @param string $strSize      - tamanho do campos
     * @param int    $intMaxLength - tamanho maximo
     * @param string $strMask
     * @param string $strWidth
     * @param string $strAlign     - alinhamento
     * @param bool $boolReadOnly   - somente leitura ou não
     * @return TGridEditColumn
     */
    public function addTextColumn( $strName, $strTitle = null
        , $strFieldName = null
        , $strSize = null
        , $intMaxLength = null
        , $strMask = null
        , $strWidth = null
        , $strAlign = null
        , $boolReadOnly = null ){
            $col = new TGridEditColumn( $strName
                                      , $strTitle
                                      , $strFieldName
                                      , 'text'
                                      , $strSize
                                      , $intMaxLength
                                      , $strMask
                                      , $strWidth
                                      , $strAlign
                                      , $boolReadOnly );
            $this->columns[ strtolower( $strName )] = $col;
            return $col;
    }
    
    //------------------------------------------------------------------------------------
    public function addAutoCompleteColumn( string $strName
                                         , string $strTitle = null
                                         , string $strFieldName = null
                                         , string $strSize = null
                                         , int $intMaxLength = null
                                         , string $strTablePackage
                                         , string $strSearchField
                                         , int $intMinChars = null
                                         , $mixUpdateFields = null
                                         , $strWidth = null
                                         , $strAlign = null
                                         , $boolReadOnly = null )
    {
        $this->autocomplete[ $strName ] = new TAutoComplete( $strFieldName, $strTablePackage, $strSearchField, $mixUpdateFields, null, null, 'callBack', $intMinChars );
        $tgridColumn = $this->addTextColumn( $strName
                                            , $strTitle
                                            , $strFieldName
                                            , $strSize
                                            , $intMaxLength
                                            , null
                                            , $strWidth
                                            , $strAlign
                                            , $boolReadOnly );
        return $tgridColumn;
    }
    
    //---------------------------------------------------------------------------------------
    /**
     * Adicionar coluna para entrada de datas no gride
     *
     * @param mixed $strName
     * @param mixed $strTitle
     * @param mixed $strFieldName
     * @param mixed $maskType
     * @param mixed $strWidth
     * @param mixed $strAlign
     * @param mixed $boolReadOnly
     * @return TGridDateColumn
     */
    public function addDateColumn( $strName, $strTitle = null
        , $strFieldName = null, $maskType = null
        , $strWidth = null, $strAlign = null
        , $boolReadOnly = null )
    {
        $col = new TGridDateColumn( $strName, $strTitle, $strFieldName, $maskType, $strWidth, $strAlign, $boolReadOnly );
        $this->columns[ strtolower( $strName )] = $col;
        return $col;
    }
    
    //---------------------------------------------------------------------------------------

    /**
     *  Adciona uma coluna do tipo numerico para form no grid
     *
     * @param string $strName           -1: id do campo
     * @param [type] $strTitle          -2: Titulo da coluna que vai aparcer para o usuário
     * @param [type] $strFieldName      -3: id do array que veio do banco
     * @param [type] $intSize           -4: tamanho do número
     * @param [type] $intDecimalPlaces  -5: quantidade de casas decimais
     * @param [type] $boolFormatInteger -6:
     * @param [type] $strWidth
     * @param [type] $strAlign
     * @param [type] $boolReadOnly
     * @return void
     */
    public function addNumberColumn( $strName, $strTitle = null, $strFieldName = null, $intSize = null, $intDecimalPlaces = null, $boolFormatInteger = null, $strWidth = null, $strAlign = null, $boolReadOnly = null )
    {
        $col = new TGridNumberColumn( $strName, $strTitle, $strFieldName, $intSize, $intDecimalPlaces, $boolFormatInteger, $strWidth, $strAlign, $boolReadOnly );
        $this->columns[ strtolower( $strName )] = $col;
        return $col;
    }
    
    //---------------------------------------------------------------------------------------
    /**
     * coluna tipo checkbox. Irá criar no gride uma coluno do tipo checkbox. Quando é feito o POST
     * será criado uma nova variavel com valor de strName
     *
     *
     * @param string $strName       - Nome do variavel no POST
     * @param string $strTitle      - Titulo que aparece no grid
     * @param string $strKeyField   - Valor que será passado no POST
     * @param string $strDescField  - Descrição do campo, valor que irá aparecer o gride
     * @param boolean $boolReadOnly
     * @param boolean $boolAllowCheckAll  - TRUE = pode selecionar todos , FALSE = não permite multiplas seleções
     * @return TGridCheckColumn
     */
    public function addCheckColumn( string $strName
        , string $strTitle = null
        , $strKeyField
        , $strDescField = null
        , $boolReadOnly = null
        , $boolAllowCheckAll = null )
    {
        if ( !$strKeyField )
        {
            $strKeyField = strtoupper( $strName );
        }
        $col = new TGridCheckColumn( $strName, $strTitle, $strKeyField, $strDescField, $boolReadOnly, $boolAllowCheckAll );
        $this->columns[ strtolower( $strName )] = $col;
        return $col;
    }
    /**
     * coluna tipo radioButton     
     *
     * @param string $strName       - Nome do variavel no POST
     * @param string $strTitle      - Titulo que aparece no grid
     * @param string $strKeyField   - Valor que será passado no POST
     * @param string $strDescField  - Descrição do campo, valor que irá aparecer o gride
     * @param boolean $boolReadOnly
     * @return TGridRadioColumn
     */
    public function addRadioColumn( string $strName, string $strTitle = null, $strKeyField, $strDescField = null, $boolReadOnly = null )
    {
        if ( !$strKeyField )
        {
            $strKeyField = strtoupper( $strName );
        }
        $col = new TGridRadioColumn( $strName, $strTitle, $strKeyField, $strDescField, $boolReadOnly );
        $this->columns[ strtolower( $strName )] = $col;
        return $col;
    }
    
    /*****
     * Coluna do tipo select
     *
     * @param string $strName         - 1: ID do campos
     * @param string $strTitle        - 2: Titulo que irá aparecer para o usuário no grid
     * @param string $strFieldName    - 3: ID do campo na origem dos dados do grid
     * @param mixed $mixOptions       - 4: Opções caso o Campo do gride não seja um array
     * @param mixed $strWidth         - 5: largura do campos em pixel
     * @param boolean $boolReadOnly   - 6: Somente Leitura
     * @param string $strFirstOptionText  - 7: Label do Primeiro elemento
     * @param string $strFirstOptionValue - 8: Valor do Primeiro elemento. Para o valor DEFAULT informe o ID do $mixOptions e $strFirstOptionText = '' não pode ser null  
     * @param string $strKeyField         - 9: 
     * @param string $strDisplayField     - 10:
     * @param string $strInitialValueField -11: Default Valeu
     * @return TGridSelectColumn
     */
    public function addSelectColumn( $strName
        , $strTitle = null
        , $strFieldName = null
        , $mixOptions = null
        , $strWidth = null
        , $boolReadOnly = null
        , $strFirstOptionText = null
        , $strFirstOptionValue = null
        , $strKeyField = null
        , $strDisplayField = null
        , $strInitialValueField=null
        ){
            $col = new TGridSelectColumn( $strName
                , $strTitle
                , $strFieldName
                , $mixOptions
                , $strWidth
                , $boolReadOnly
                , $strFirstOptionText
                , $strFirstOptionValue
                , $strKeyField
                , $strDisplayField
                , $strInitialValueField );
            $this->columns[ strtolower( $strName )] = $col;
            return $col;
    }
    
    //---------------------------------------------------------------------------------------
    /**
     * 
     * @param string $strName         - 1: ID do campos
     * @param string $strTitle        - 2: Titulo que irá aparecer no grid
     * @param string $strFieldName    - 3: Nome do campo do gride
     * @param int $intMaxLength       - 4: Tamanho maximo do campo
     * @param int $intColumns         - 5: Qtd colunas
     * @param int $intRows            - 6: Qtd de linhas
     * @param boolean $boolReadOnly   - 7: mostra ou não o contador. Default = TRUE
     * @param boolean $boolShowCounter  8: mostra ou não o contador. Default = TRUE
     * @return TGridMemoColumn
     */
    public function addMemoColumn( $strName, $strTitle = null, $strFieldName = null, $intMaxLength = null, $intColumns = null, $intRows = null, $boolReadOnly = null, $boolShowCounter = null )
    {
        $col = new TGridMemoColumn( $strName, $strTitle, $strFieldName, $intMaxLength, $intColumns, $intRows, $boolReadOnly, $boolShowCounter );
        $this->columns[ strtolower( $strName )] = $col;
        return $col;
    }
    
    //---------------------------------------------------------------------------------------
    public function addRowNumColumn( $strName = null, $strTitle = null, $strWidth = null, $strAlign = null )
    {
        $strName = is_null( $strName ) ? 'grid_rownum' : $strName;
        $strTitle = is_null( $strTitle ) ? 'Nº' : $strTitle;
        $strAlign = is_null( $strAlign ) ? 'center' : $strAlign;
        $col = new TGridRowNumColumn( $strName, $strTitle, $strWidth, $strAlign );
        $this->columns[ strtolower( $strName )] = $col;
        return $col;
    }
    
    //---------------------------------------------------------------------------------------
    public function getRowNumWithPaginator($rowNum,$rowStart, $index){
        if( !empty($this->getRealTotalRowsSqlPaginator()) ){
            $result = $rowStart+$index;
        }else {
            $result = $rowNum;
        }
        return $result;
    }
    
    //---------------------------------------------------------------------------------------
    public function getRowCount() {
        $result = 0;
        if( !empty($this->getRealTotalRowsSqlPaginator()) ){
            $result = $this->getRealTotalRowsSqlPaginator();
        }else{
            $res = $this->getData();
            if ( $res ) {
                $keys = array_keys($res);
                $result = count( $res[ $keys[0] ] );
            }
        }
        return $result;
    }
    
    //---------------------------------------------------------------------------------------
    public function setReadOnly( $boolNewValue = null )
    {
        $boolNewValue = $boolNewValue === true ? true : false;
        $this->readOnly = $boolNewValue;
    }
    
    //---------------------------------------------------------------------------------------
    public function getReadOnly()
    {
        return $this->readOnly;
    }
    
    //---------------------------------------------------------------------------------------
    /**
     * Qtd Max de linhas
     *
     * @param int $intNewValue
     * @return void
     */
    public function setMaxRows( $intNewValue = null ) {
        $this->maxRows = $intNewValue;
    }
    
    //---------------------------------------------------------------------------------------
    public function getMaxRows() {
        return ( int ) $this->maxRows;
    }
    
    //---------------------------------------------------------------------------------------
    protected function setNavButtons( $tbody, $qtdColumns ) {
        if ( !$this->url || !$this->getMaxRows() || $this->numPages == 1 ) {
            return;
        }
        /*
         Desabilitei os botoes next, prior etc.. porque quando o clica no titulo
         da coluna para ordenar, os botões estavam sendo ordenados tambem, ficando
         na parte superior do gride.
         */
        /*
         $prev 				= $this->currentPage -1;
         $next 				= $this->currentPage +1;
         //$jsOnClick 			= 'jQuery("#'.$this->getId().'_loading").show();jQuery("#'.$this->getId().'_jumpToPage").attr("disable",true);jQuery("#'.$this->getId().'_first_page").attr("disable",true);jQuery("#'.$this->getId().'_prev_page").attr("disable",true);jQuery("#'.$this->getId().'_next_page").attr("disable",true);jQuery("#'.$this->getId().'_last_page").attr("disable",true);';
         //sleep(3);
         $jsOnClick 			= 'jQuery("#'.$this->getId().'_loading").show();jQuery("#'.$this->getId().'_jumpToPage").hide();jQuery("#'.$this->getId().'_first_page").hide();jQuery("#'.$this->getId().'_prev_page").hide();jQuery("#'.$this->getId().'_next_page").hide();jQuery("#'.$this->getId().'_last_page").hide();';
         // se o proprio modulo fizer include da classe banco, config etc, não precisa ser chamado pelo index da aplicacao
         if( defined( APLICATIVO ) )
         {
         $urlFirst			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load("'.$this->url.' tbody>tr",{ "ajax":1,"page":1});';
         $urlPrev			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load("'.$this->url.' tbody>tr",{ "ajax":1,"page":'.$prev.'});';
         $urlNext 			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load("'.$this->url.' tbody>tr",{ "ajax":1,"page":'.$next.'});';
         $urlLast			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load("'.$this->url.' tbody>tr",{ "ajax":1,"page":'.$this->numPages.'});';
         }
         else
         {
         $urlFirst			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load(app_url+app_index_file+" tbody>tr",{ "ajax":1,"page":1,"modulo":"'.$this->url.'"});';
         $urlPrev			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load(app_url+app_index_file+" tbody>tr",{ "ajax":1,"page":'.$prev.',"modulo":"'.$this->url.'"});';
         $urlNext 			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load(app_url+app_index_file+" tbody>tr",{ "ajax":1,"page":'.$next.',"modulo":"'.$this->url.'"});';
         $urlLast			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load(app_url+app_index_file+" tbody>tr",{ "ajax":1,"page":'.$this->numPages.',"modulo":"'.$this->url.'"});';
         }
         $btnFirst 			= new TButton($this->getId().'_first_page','<<'	,null,$urlFirst,null,'page-first.png','page-first_disabled.png','Primeira página');
         $btnPrev 			= new TButton($this->getId().'_prev_page','<'	,null,$urlPrev,null ,'page-prev.png' ,'page-prev_disabled.png','Página anterior');
         $btnNext 			= new TButton($this->getId().'_next_page','>'	,null,$urlNext,null ,'page-next.png' ,'page-next_disabled.png','Próxima página');
         $btnLast 			= new TButton($this->getId().'_last_page','>>'	,null,$urlLast,null ,'page-last.png' ,'page-last_disabled.png','Última página');
         
         if( $prev == 0 )
         {
         $btnPrev->setEnabled(false);
         $btnFirst->setEnabled(false);
         }
         if( $next == 0 )
         {
         $btnNext->setEnabled(false);
         }
         if( $this->currentPage == $this->numPages)
         {
         $btnNext->setEnabled(false);
         $btnLast->setEnabled(false);
         }
         */
        $select = null;
        
        if ( $this->numPages > 1 )
        {
            $aPages = array();
            
            for( $i = 1; $i <= $this->numPages; $i++ )
            {
                $aPages[ $i ] = $i;
            }
            $select = new TSelect( $this->getId() . '_jumpToPage', $aPages, null, true );
            $select->setcss( 'margin-left', '5px' );
            $select->setcss( 'margin-right', '5px' );
            $select->setProperty( 'noClear', 'true' ); // evitar que a função fwClearFields() limpe o seu vavalor
            $select->setValue( $this->currentPage );
            // estes parametros devem ser sempre passados na atualização da página do gride
            //$arrRequest = array( 'ajax' => 1, 'page' => 'this.value', 'TGrid' => 1 );
            $arrRequest = array( 'ajax' => 1, 'TGrid' => 1, 'gridId' => $this->getId() );
            foreach( $_REQUEST as $k => $v )
            {
                if ( $k != 'modulo' && $k != 'ajax' && $k != 'page' && $k != 'PHPSESSID' && $k != 'cookieauth' )
                {
                    $arrRequest[ $k ] =$v;
                }
            }
            $arrRequest[ 'gridId' ]=$this->getId();
            $jsOnClick = isset( $jsOnClick ) ? $jsOnClick : '';
            if ( defined( APLICATIVO ) ) // já fez o includes dos arquivos ncessários
            {
                $arrRequest['url'] = $this->url;
            }
            else
            {
                $arrRequest[ 'modulo' ] = $this->getUrl();
            }
            $select->setEvent( 'onChange', $jsOnClick . 'fwGridPageChange(this.value,'.json_encode($arrRequest).')');
            $select->setEvent( 'onKeyUp', 'var key = fwGetKey(event); if( key >= 33 && key <= 40) { this.onchange(); }' );
        }
        $div = new TElement( 'div' );
        $div->setId( $this->getId() . '_div_nav_buttons' );
        $div->setcss( 'text-align', 'left' );
        $div->setcss( 'border', '1px solid gray' );
        $div->setcss( 'padding-top', '2px' );
        $div->setcss( 'width', '100%' );
        $div->setcss( 'float', 'left' );
        $div->add( 'Página:' );
        $div->add( $select );
        
        $btnFirst 			= new TButton($this->getId().'_first_page','<<'	,null,'fwGridChangePage('. json_encode(array('id'=>$this->getId(),'action'=>'first') ).')',null,'page-first.png',null,'Primeira página');
        $div->add( $btnFirst,false );
        $btnPrev	= new TButton($this->getId().'_prev_page','<'	,null,'fwGridChangePage('. json_encode(array('id'=>$this->getId(),'action'=>'prior') ).')',null ,'page-prev.png' ,null,'Página anterior');
        $div->add( $btnPrev,false );
        $btnNext 	= new TButton($this->getId().'_next_page','>'	,null,'fwGridChangePage('. json_encode(array('id'=>$this->getId(),'action'=>'next') ).')',null ,'page-next.png',null,'Próxima página');
        $div->add( $btnNext,false );
        $btnLast 			= new TButton($this->getId().'_last_page','>>'	,null,'fwGridChangePage('. json_encode(array('id'=>$this->getId(),'action'=>'last') ).')',null ,'page-last.png' ,null,'Última página');
        $div->add( $btnLast,false );
        
        $img = new TButton($this->getId().'_loading',null,null,null,null,'carregando.gif');
        $img->setCss('display','none');
        $div->add($img);
        /*
         $div->add($btnFirst);
         $div->add($btnPrev);
         $div->add($select);
         $div->add($btnNext);
         $div->add($btnLast);
         */
        
        // imagem processando durante as requisições ajax
        /*
         $img = new TElement('img');
         $img->setId($this->getId().'_loading');
         $img->setcss('display'	,'none');
         $img->setcss('float'	,'left');
         $img->setCss('height'	,'20px');
         $img->setCss('width'	,'135px');
         $img->setProperty('src','base/imagens/processando.gif');
         $div->add($img);
         */
        // criar uma linha <tr> no final do gride para mostrar os botões de paginação
        $tbody->add( $row = new TTableRow() );
        $row->setId( $this->getId() . '_tr_nav_buttons' );
        $row->clearCss();
        $cell = $row->addCell();
        $cell->setId( $this->getId() . '_td_nav_buttons' );
        $cell->clearCss();
        $cell->setClass( 'fwHeaderBar' );
        $cell->setCss( 'height', '26px' );
        $cell->setProperty( 'colspan', $qtdColumns );
        // adicionar a div no td
        $cell->add( $div );
    }
    
    //---------------------------------------------------------------------------------------
    public function setBvars( $arrBvars = null )
    {
        $this->bvars = $arrBvars;
    }
    
    //---------------------------------------------------------------------------------------
    public function getBvars()
    {
        return $this->bvars;
    }
    
    //---------------------------------------------------------------------------------------
    public function setCache( $intNewValue = null )
    {
        $this->cache = $intNewValue;
    }
    //---------------------------------------------------------------------------------------
    public function getCache()
    {
        return $this->cache;
    }
    //---------------------------------------------------------------------------------------
    public function getCreateDefaultButtons()
    {
        return is_null( $this->createDefaultButtons ) ? true : $this->createDefaultButtons;
    }
    /**
     * Define se os botoes Alterar e Excluir serão exibidos quando não for
     * adicionado nenhum botão
     *
     * @param mixed $boolNewValue
     */
    public function enableDefaultButtons( $boolNewValue = null )
    {
        $this->createDefaultButtons = is_null( $boolNewValue ) ? true : $boolNewValue;
    }
    
    //---------------------------------------------------------------------------------------
    /**
     * Define a utilização das imagens alterar.gif e lixeira.gif do diretorio base/imagens
     *
     * @param mixed $boolNewValue
     */
    public function setUseDefaultImages( $boolNewValue = null )
    {
        $this->useDefaultImages = $boolNewValue;
    }
    
    //---------------------------------------------------------------------------------------
    public function getUseDefaultImages()
    {
        return is_null( $this->useDefaultImages ) ? true : $this->useDefaultImages;
    }
    
    //---------------------------------------------------------------------------------------
    public function setExportExcel( $boolNewValue = null )
    {
        $this->exportExcel = is_null( $boolNewValue ) ? true : $boolNewValue;
    }
    
    public function getExportExcel() {
        return $this->exportExcel;
    }
    
    //---------------------------------------------------------------------------------------
    public function autoCreateColumns()
    {
        $res = $this->getData();
        
        if ( $res )
        {
            $keys = array_keys($res);
            $this->addKeyField( $keys[0] );
            $this->setUpdateFields( $keys[0] );
            
            foreach( $res as $k => $dados )
            {
                $this->addColumn( $k, $k );
            }
        }
    }
    
    //---------------------------------------------------------------------------------------
    /**
     * adicionar o formulário ao gride para criar o gride offline
     * @param TForm $frm
     * @param boolean $boolShowCollapsed
     */
    public function setForm( TForm $frm = null, $boolShowCollapsed = null )
    {
        $this->form = $frm;
        $this->setShowCollapsed( $boolShowCollapsed );
        if( $frm->getCss('background-color')=='#efefef')
        {
            $this->form->setCss('background-color','transparent');
        }
    }
    
    public function getForm()
    {
        return $this->form;
    }
    
    //---------------------------------------------------------------------------------------
    public function setUrl( $strNewValue = null )
    {
        $this->url = $strNewValue;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    //------------------------------------------------------------------------------------------------
    // Configurações do grid offline
    //-------------------------------------------------------------------------------------
    protected function configOffLine()
    {
        $frm = $this->getForm();
        if ( isset( $_REQUEST[ $this->getId() . 'Width' ] ) )
        {
            $frm->setWidth( $_REQUEST[ $this->getId() . 'Width' ] );
        }
        $frm->setFormGridOffLine(true);
        
        $frm->setId( $this->getId() . '_form' );
        $frm->setAttribute( 'idGridOffLine',$this->getId() );
        $frm->setName( $this->getId() . '_form' );
        $frm->setFlat( true );
        $frm->setFade( false );
        $frm->setAction( null );
        $frm->setShowCloseButton( false );
        $frm->setShowHeader( !$frm->getTitle() == "" );
        //$frm->showOnlyTagForm = true;
        $frm->setAutoIncludeJsCss( false );
        $frm->setOverflowY( 'hidden' );
        $frm->setCss( 'border', '0px' );
        $frm->body->setCss( 'border-bottom', '0px' );
        $frm->footer->setCss( 'border', '0px' );
        $frm->cssFiles = null;
        $frm->jsFiles = null;
        $frm->removeMessageArea();
        
        if ( $this->getShowCollapsed() )
        {
            $frm->addJavascript( 'jQuery("#' . $this->getId() . '_img_show_hide_form").click();' );
        }
        $this->columns = null;
        $strFirstKeyField = null;
        $noClearFields = null;
        
        // definir a chave primária do gride se não tiver sido passada
        if ( $keyField = $this->getKeyField() )
        {
            $strFirstKeyField = strtoupper( $keyField[ 0 ] );
            
            foreach( $keyField as $v )
            {
                $frm->addHiddenField( strtolower( $v ) );
            }
        }
        else
        {
            if ( $res = $this->getData() )
            {
                $keys = array_keys($res);
                $strFirstKeyField = strtoupper( $keys[0] );
                $frm->addHiddenField( strtolower( $strFirstKeyField ) );
            }
        }
        $this->keyField = null;
        // botão de esconder/exibir o formulário
        $this->titleCell->add( '<img id="' . $this->getId() . '_img_show_hide_form" onclick="if( jQuery(\'#' . $this->getId() . '_form_area\').is(\':visible\') ){this.src=this.src.replace(\'Collapse\',\'Expand\');jQuery(\'#' . $this->getId() . '_form_area\').hide(\'slow\');jQuery(\'#' . $this->getId() . '_collapsed\').val(1) } else { this.src=this.src.replace(\'Expand\',\'Collapse\');jQuery(\'#' . $this->getId() . '_form_area\').show(\'fast\');jQuery(\'#' . $this->getId() . '_collapsed\').val(0);}" src="' . $this->getBase() . 'imagens/groupCollapse.jpg" width="16px" height="16px" style="float:right;cursor:pointer;" title="Abrir/Fechar">' );
        
        // legenda do rodapé
        $this->footerCell->add( '<table border="0" style="float:left;border:none;" cellspacing="0" cellpadding="0">
		<tr>
		<td width="8" height="8" bgcolor="' . $this->getSavedRecordColor() . '"></td><td style="font-size:10px;">Salvo</td><td width="10px"></td>
		<td width="8" height="8" bgcolor="' . $this->getEditedRecordColor() . '"></td><td style="font-size:10px;">Alterado</td><td width="10px"></td>
		<td width="8" height="8" bgcolor="' . $this->getNewRecordColor() . '"></td><td style="font-size:10px;">Novo</td><td width="10px"></td>
		<td width="8" height="8" bgcolor="' . $this->getDeletedRecordColor() . '"></td><td style="font-size:10px;">Excluido</td>
		</tr>
		</table>' );
        // coluna de controle de registro incluido, alterado e excluído
        $controlAEI = strtoupper( $this->getId() . '_AEI' );
        
        if ( is_array( $frm->getDisplayControls() ) )
        {
            $strJquery = '';
            $aFieldNames = null;
            $col = $this->addColumn( $controlAEI, '' );
            $col->setSortable(false);
            
            $fields = $this->extractFormFields($frm);
            // criar as colunas do gride utilizando os campos do formulário
            foreach( $fields as $objField )
            {
                $field 		= $objField->field;
                $label 		= $objField->label;
                $fieldName 	= $field->getId();
                
                $col=null;
                if( $field->getFieldType() == 'hidden'  )
                {
                    
                    if ( strtoupper( $fieldName ) != 'FW_BACK_TO' )
                    {
                        $field->setAttribute( 'gridOfflineField', 'true' );
                        
                        // se não for campo chave do grid, adicionar tag noClear para a função frm->clearFields() apos a edição não limpar os campos ocultos
                        if ( !preg_match( '/,' . $fieldName . ',/i', ',' . implode( ',', $keyField ) . ',' ) )
                        {
                            $field->setAttribute( 'noClear', 'true' );
                            $noClearFields[] = $fieldName;
                        }
                        else
                        {
                            $this->addKeyField( strtoupper( $fieldName ) );
                            $aFieldNames[] = $fieldName;
                        }
                        
                        // considerar o primeiro campo oculto como a chave do gride
                        if ( is_null( $strFirstKeyField ) )
                        {
                            $strFirstKeyField = strtoupper( $fieldName );
                        }
                    }
                    else
                    {
                        $field->setAttribute( 'noClear', 'true' );
                    }
                }
                else if ( $field->getFieldType() == 'edit' || $field->getFieldType() == 'number' || $field->getFieldType() == 'date' || $field->getFieldType() == 'cpf' || $field->getFieldType() == 'cpfcnpj' || $field->getFieldType() == 'cnpj' || $field->getFieldType() == 'fone' || $field->getFieldType() == 'memo' || $field->getFieldType() == 'cep' )
                {
                    $field->setAttribute( 'gridOfflineField', 'true' );
                    $label = str_replace( ':', '', $label );
                    
                    if ( $field->getFieldType() == 'number' && $field->getDecimalPlaces() > 0 )
                    {
                        $align = 'right';
                    }
                    $align = $field->getAttribute( 'grid_algin' );
                    $col = $this->addColumn( strtoUpper( $fieldName ), $label, null, $align );
                    $strJquery .= $strJquery == '' ? ' ' : ',';
                    $strJquery .= '"' . $fieldName . '":jQuery("#' . $fieldName . '").val()';
                    $aFieldNames[] = $fieldName;
                    
                    // definir o foco para o primeiro campo do formulário do grid-offline
                    if ( !$frm->getFocusField() )
                    {
                        $frm->setFocusField( $fieldName );
                    }
                }
                else if( $field->getFieldType() == 'select' )
                {
                    $field->setAttribute( 'gridOfflineField', 'true' );
                    $aFieldNames[] = $fieldName;
                    $label = str_replace( ':', '', $label );
                    
                    $c = $field->getAttribute('grid_column');
                    if( $c )
                    {
                        $this->addColumn( strtoupper($c) , $label );
                        $field->addEvent('onChange',"jQuery(\"#\"+this.id+\"_temp\").val( this.options[this.selectedIndex].text )");
                        $strJquery .= $strJquery == '' ? ' ' : ',';
                        $strJquery .= '"' . $fieldName . '":jQuery("#' . $fieldName . '").val()';
                    }
                    else
                    {
                        $col = $this->addColumn( strtoUpper( $fieldName . '_text' ), $label );
                        $strJquery .= $strJquery == '' ? ' ' : ',';
                        $strJquery .= '"' . $fieldName . '":jQuery("#' . $fieldName . '").val()';
                    }
                }
                else if( $field->getFieldType() == 'memo' )
                {
                    $field->setAttribute( 'gridOfflineField', 'true' );
                    $label = str_replace( ':', '', $label );
                    $col = $this->addMemoColumn( $fieldName, $label, strtoupper( $fieldName ), $field->getMaxLenght(), $field->getColumns(), $field->getRows(), true, false );
                    $strJquery .= $strJquery == '' ? ' ' : ',';
                    $strJquery .= '"' . $fieldName . '":jQuery("#' . $fieldName . '").val()';
                    $aFieldNames[] = $fieldName;
                }
                if( isset($col) && isset( $field ) && $field->getAttribute('grid_hidden') == 'true' )
                {
                    $col->setVisible(false);
                }
            }
            
            if ( is_null( $strFirstKeyField ) )
            {
                $strFirstKeyField = strtolower( $this->getId() . '_PK' );
                $this->addKeyField( strtoupper( $strFirstKeyField ) );
                $frm->addHiddenField( $strFirstKeyField );
                $aFieldNames[] = $strFirstKeyField;
            }
            
            // adicionar os campos chave no evento do botão Adicionar para enviar o seu valor
            if( is_array( $this->getKeyField() ))
            {
                foreach( $this->getKeyField() as $k => $v )
                {
                    if ( !$this->getUpdateFields() )
                    {
                        $this->setUpdateFields( strtoupper( $v ) );
                    }
                    $strJquery .= $strJquery == '' ? ' ' : ',';
                    $strJquery .= '"' . strtolower( $v ) . '":jQuery("#' . strtolower( $v ) . '").val()';
                }
            }
            
            // campos ocultos que devem ser sempre submetidos ao executar uma ação do grid offline
            if ( is_array( $noClearFields ) )
            {
                foreach( $noClearFields as $k => $v )
                {
                    $strJquery .= $strJquery == '' ? ' ' : ',';
                    $strJquery .= '"' . strtolower( $v ) . '":jQuery("#' . strtolower( $v ) . '").val()';
                }
            }
            
            if ( !$this->getUpdateFields() )
            {
                $frm->addMessage( 'Para o funcionamento do grid offline, é necessário definir um campo chave.\nAdicione um campo oculto no formulário anexado ao gride com o nome do campo chave.' );
            }
            
            if ( $this->getUrl() )
            {
                // postar sempre o width do grid
                $strJquery .= ',"' . $this->getId() . 'Width":"' . $frm->getWidth() . '"';
                // definir a largura do grid
                $this->setWidth( $frm->getWidth() );
                
                $requestAction = RequestHelper::get('action');
                $postParentField = PostHelper::get('parent_field');
                if ( $this->getShowAdicionarButton() ) {
                    $frm->addButton( ($requestAction =='edit'?"Salvar Alteração":"Adicionar"), null, 'btn' . $this->getId() . 'Save', 'jQuery("#' . $frm->getId() . '_footer").html(fw_img_processando2);jQuery("#' . $postParentField . '").load(app_url+app_index_file,{"ajax":0,"gridOffline":"1","modulo":"' . $this->getUrl() . '","parent_field":"' . $postParentField . '","action":"save","subform":1,' . $strJquery . '} );' );
                }
                $frm->addButton( ($requestAction=='edit'?"Cancelar Alteração":"Limpar"), null, 'btn' . $this->getId() . 'Clear', 'jQuery("#' . $frm->getId() . '_footer").html(fw_img_processando2);jQuery("#' . $postParentField . '").load(app_url+app_index_file,{"ajax":0,"gridOffline":"1","modulo":"' . $this->getUrl() . '","parent_field":"' . $postParentField . '","action":"clear","subform":1,' . $strJquery . '} );' );
                $frm->addButton( 'Desfazer', null, 'btn' . $this->getId() . 'ClearAll', 'jQuery("#' . $frm->getId() . '_footer").html(fw_img_processando2);jQuery("#' . $postParentField . '").load(app_url+app_index_file,{"ajax":0,"gridOffline":"1","modulo":"' . $this->getUrl() . '","parent_field":"' . $postParentField . '","action":"clearAll","subform":1,' . $strJquery . '} );', 'Esta ação cancela todas as operações de inclusão, alteração e exclusão\nrealizadas no gride antes da última gravação.\n\n Confirma ?\n', null, null, null, null, 'Desfazer todas as alterações/inclusões e voltar os dados para a situação original!' );
                $this->bodyCell->add( '<span id="' . $this->getId() . '_form_area">' );
                $this->bodyCell->add( $frm );
                $this->bodyCell->add( '</span>' );
                
                // adicionar os botões de alterar e excluir no gride
                if ( $this->getCreateDefaultEditButton() )
                {
                    $this->addButton( 'Alterar', 'edit', 'btn' . $this->getId() . '_edit', '()', null, 'editar.gif', 'alterar_bw.gif', 'Alterar' );
                    
                }
                
                if ( $this->getCreateDefaultDeleteButton() )
                {
                    $this->addButton( 'Excluir', 'delete', 'btn' . $this->getId() . '_delete', '()', 'Confirma exclusão ?', 'lixeira.gif', 'lixeira_bw.gif', 'Excluir' );
                }
            }
            else
            {
                //$frm->addMessage('Para o funcionamento do grid offline, é necessário definir o parametro $strRequestUrl da classe TGrid');
                print 'Para o funcionamento do grid offline,<br>é necessário definir o parametro $strRequestUrl da classe TGrid';
            }
            
            // recuperar da sessão os dados e definir como $res para o grid
            // fazer a inclusão, alteração e exclusão
            if ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'save' )
            {
                if ( $frm->validate() )
                {
                    if ( $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] )
                    {
                        $res = $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()];
                    }
                    else
                    {
                        $res = array();
                    }
                    // o gride pode ter varias keyfields, assumir a primeira como chave e verificar se a primeira foi postada
                    $aKeys = $this->getKeyField();
                    $key = strtolower( $aKeys[ 0 ] );
                    $k = false;
                    
                    if ( isset( $res[ strtoupper( $key )] ) )
                    {
                        $k = array_search( $_POST[ $key ], $res[ strtoupper( $key )] );
                    }
                    
                    if ( $k === false )
                    {
                        // inclusão
                        //gravar na sessão os dados postados
                        $lower = 0;
                        
                        if ( isset( $res[ $aKeys[ 0 ] ] ) && is_array( $res[ $aKeys[ 0 ] ] ) )
                        {
                            foreach( $res[ $aKeys[ 0 ] ] as $key => $value )
                            {
                                if ( $value <= $lower )
                                {
                                    $lower = $value;
                                }
                            }
                        }
                        $_POST[ strtolower( $aKeys[ 0 ] )] = ( $lower - 1 );
                    }
                    
                    foreach( $aFieldNames as $key => $fieldName )
                    {
                        // inclusao
                        if ( $k === false ) {
                            $res[ strtoupper( $fieldName )][] =  $_POST[ $fieldName ];
                        }
                        // alteração
                        else {
                            $res[ strtoupper( $fieldName )][ $k ] = $_POST[ $fieldName ];
                        }
                        
                        $field = $frm->getField( $fieldName );
                        if ( $field->getFieldType() == 'select' )
                        {
                            $c = $field->getAttribute('grid_column');
                            if ( $k === false )
                            {
                                if( $c )
                                {
                                    if( $_POST[$fieldName] )
                                    {
                                        $res[strToUpper($c)][] = $_POST[$fieldName.'_temp'];
                                    } else {
                                        $res[strToUpper($c)][] = '';
                                    }
                                } else {
                                    $res[ strtoupper( $fieldName . '_text' )][] = $frm->getField( $fieldName )->getText();
                                }
                            } else {
                                if( $c )
                                {
                                    if( $_POST[$fieldName] )
                                    {
                                        $res[strToUpper($c)][$k] = $_POST[$fieldName.'_temp'];
                                    } else {
                                        $res[strToUpper($c)][$k] = '';
                                    }
                                } else {
                                    if( isset($_POST[$fieldName]) && $frm->getField( $fieldName )->getText()=='')
                                    {
                                        $res[ strtoupper( $fieldName . '_text' )][ $k ] = $this->decodeUtf8( $_POST[$fieldName] );
                                    } else {
                                        $res[ strtoupper( $fieldName . '_text' )][ $k ] = $frm->getField( $fieldName )->getText();
                                    }
                                }
                            }
                        }
                    }
                    
                    // adicionar / alterar a coluna de controle de Inc, Alt, Exc
                    if ( $k === false )
                    {
                        $res[ $controlAEI ][] = 'I';
                    }
                    else
                    {
                        // marcar como alterado somente registros que já existirem no banco de dados
                        if ( $res[ $strFirstKeyField ][ $k ] > 0 )
                        {
                            $res[ $controlAEI ][ $k ] = 'A';
                        }
                    }
                    $frm->clearFields();
                    $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] = $res;
                }
            }
            elseif( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'edit' )
            {
                $aKeys = $this->getKeyField();
                $key = strtolower( $aKeys[ 0 ] );
                $res = $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()];
                
                if ( is_array( $res[ strtoupper( $key )] ) )
                {
                    $k = array_search( $_POST[ $key ], $res[ strtoupper( $key )] );
                }
                
                foreach( $aFieldNames as $key => $fieldName )
                {
                    $frm->setValue( $fieldName, $res[ strtoupper( $fieldName )][ $k ] );
                }
            }
            elseif( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'clear' )
            {
                $frm->clearFields();
            }
            elseif( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'delete' )
            {
                $aKeys = $this->getKeyField();
                $key = strtolower( $aKeys[ 0 ] );
                $res = $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()];
                $k = array_search( $_POST[ $key ], $res[ strtoupper( $key )] );
                
                // se ja estiver excluido, recuperar o registro
                if ( $res[ $controlAEI ][ $k ] == 'E' )
                {
                    $res[ $controlAEI ][ $k ] = 'A';
                    $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] = $res;
                    $frm->clearFields();
                }
                else
                {
                    if ( $k > -1 )
                    {
                        // se ainda não existir no banco de dados pode excluir do gride, senão só marca para exclusão quando o gride for processado
                        if ( $res[ strtoupper( $key )][ $k ] < 0 )
                        {
                            foreach( $res as $fieldName => $value )
                            {
                                $res[ $fieldName ][ $k ] = null;
                                unset( $res[ $fieldName ][ $k ] );
                            }
                            unset( $res[ $controlAEI ][ $k ] );
                        }
                        else
                        {
                            $res[ $controlAEI ][ $k ] = 'E';
                        }
                        
                        $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] = $res;
                        $frm->clearFields();
                    }
                }
            }
            elseif( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'clearAll' )
            {
                $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] = null;
                $frm->clearFields();
            }
        }
        
        // se ainda não existir na sessão os dados offline, ler do banco os valores já gravados e adicionar na sessão
        if ( !isset( $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] ) || !$_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] && $this->getData() )
        {
            
            $data = $this->getData();
            $res = null;
            
            if ( $data )
            {
                foreach( $data[ $strFirstKeyField ] as $k => $v )
                {
                    foreach( $aFieldNames as $key => $fieldName )
                    {
                        $field = $frm->getField( $fieldName );
                        if ( $field->getFieldType() == 'select' )
                        {
                            
                            $c = $field->getAttribute('grid_column');
                            if( $c )
                            {
                                $res[ strtoupper( $c ) ][] = $data[ strToUpper($c) ][ $k ];
                            }
                            else
                            {
                                //echo $fieldName.'='.$frm->getField( $fieldName )->getText( $data[ strtoupper( $fieldName )][ $k ]).'<br>';
                                $res[ strtoupper( $fieldName . '_text' )][] = $frm->getField( $fieldName )->getText( $data[ strtoupper( $fieldName )][ $k ] );
                            }
                        }
                        $res[ strtoupper( $fieldName )][] = $data[ strtoupper( $fieldName )][ $k ];
                    }
                    $res[ $controlAEI ][] = '';
                }
            }
            $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] = $res;
        }
        
        if ( isset( $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] ) )
        {
            $res = $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()];
        }
        
        if ( isset( $res ) )
        {
            $this->setData( $res );
        }
        /*
         if ($res)
         {
         // evitar scroll do formulario
         if( $this->getHeight() == 'auto' || $this->getHeight() == '100%')
         {
         $this->setHeight('120px');
         }
         }
         */
    }
    
    //------------------------------------------------------------------------------------------------
    /**
     * Grid Off-line define a cor do novo regristro
     * @return string
     */    
    public function setNewRecordColor( $newColor = null )
    {
        $this->newRecordColor = $newColor;
    }
    /**
     * Grid Off-line define a cor do novo regristro
     * @return string
     */
    public function getNewRecordColor()
    {
        return is_null( $this->newRecordColor ) ? 'blue' : $this->newRecordColor;
    }
    
    /**
     * Grid Off-line define a cor do novo alterado
     * @return string
     */
    public function setEditedRecordColor( $strNewValue = null )
    {
        $this->editedRecordColor = $strNewValue;
    }
    
    /**
     * Grid Off-line define a cor do novo alterado
     * @return string
     */    
    public function getEditedRecordColor()
    {
        return is_null( $this->editedRecordColor ) ? '#FF9900' : $this->editedRecordColor;
    }
    
    /**
     * Grid Off-line define a cor do novo salvo
     * @return string
     */
    public function setSavedRecordColor( $strNewValue = null )
    {
        $this->savedRecordColor = $strNewValue;
    }
    
    /**
     * Grid Off-line define a cor do novo salvo
     * @return string
     */
    public function getSavedRecordColor( $strNewValue = null )
    {
        return is_null( $this->savedRecordColor ) ? '#009933' : $this->savedRecordColor;
    }
    
    /**
     * Grid Off-line define a cor do novo deletado
     * @return string
     */
    public function getDeletedRecordColor()
    {
        return is_null( $this->deletedRecordColor ) ? '#FF0000' : $this->deletedRecordColor;
    }
    //------------------------------------------------------------------------------------------------
    /**
     * Define o nome de uma função php que a classe TGrid irá executar passando a classe TAutocomplete, o array de dados ($res) referente a linha atual, o objeto celula e o objeto coluna
     *
     * @param mixed $strNewValue
     */
    public function setOnGetAutocompleteParameters( $strNewValue = null )
    {
        $this->onGetAutocompleteParameters = $strNewValue;
    }
    
    public function getOnGetAutocompleteParameters()
    {
        return $this->onGetAutocompleteParameters;
    }
    
    //------------------------------------------------------------------------------------------------
    public function getFooter()
    {
        return $this->footerCell;
    }
    
    //-------------------------------------------------------------------------------------------------
    public function addFooter( $strValor = null )
    {
        if ( !is_null( $strValor ) )
        {
            $this->footerCell->add( $strValor );
        }
    }
    
    //-------------------------------------------------------------------------------------------------
    public function setFooter( $strValor = null )
    {
        $this->footerCell->clearChildren();
        $this->addFooterCell( $strValor );
    }
    
    //------------------------------------------------------------------------------------------------
    public function setSortable( $boolNewValue = null )
    {
        $this->sortable = ( bool ) $boolNewValue;
    }
    
    //------------------------------------------------------------------------------------
    public function getSortable()
    {
        return $this->sortable;
    }
    
    //------------------------------------------------------------------------------------
    public function addExcelHeadField( $strLabel, $strFieldName )
    {
        $this->excelHeadFields[ $strLabel ] = $strFieldName;
    }
    
    //------------------------------------------------------------------------------------
    public function getExcelHeadField($boolUtf8=false)
    {
        if( $boolUtf8 && is_array($this->excelHeadFields ) )
        {
            $arrTemp = array();
            foreach($this->excelHeadFields as $k=>$v)
            {
                $arrTemp[utf8_encode($k)] = utf8_encode($v);
            }
            return $arrTemp;
        }
        return $this->excelHeadFields;
    }
    
    //-------------------------------------------------------------------------------------
    public function getTitleCell()
    {
        return $this->titleCell;
    }
    
    //------------------------------------------------------------------------------------
    public function setShowCollapsed( $boolNewValue = null )
    {
        $this->showCollapsed = ( $boolNewValue === true ) ? true : false;
    }
    
    //------------------------------------------------------------------------------------
    public function getShowCollapsed()
    {
        if ( isset( $_REQUEST[ $this->getId() . '_collapsed' ] ) )
        {
            $this->showCollapsed = ( $_REQUEST[ $this->getId() . '_collapsed' ] == '1' );
        }
        return $this->showCollapsed;
    }
    
    //------------------------------------------------------------------------------------
    public function getData2Excel() {
        $res = $this->getData();
        //return $res;
        
        if ( !is_array( $res ) ) {
            return null;
        }
        $result = null;
        if( $this->getExportFullData() ) {
            return $res;
        }
        $keys =  array_keys($res);
        
        /*if( $this->getId() =='idGride')
         {
         print_r($res);
         echo '<hr>';
         echo 'key e keys<br>';
         echo '$res[ key( $res )]<br>';
         echo 'Primeira chave =  '.key( $res ).'<br>';
         echo 'ou Primeira chave =  '.$keys[0].'<br>';
         echo '<hr>';
         }
         */
        foreach( $res[ $keys[0] ] as $k => $v )
        {
            foreach( $this->getColumns() as $name => $objColumn )
            {
                $getName = $objColumn->getFieldName();
                $colName = isset($getName)?strtoupper($getName):null;
                if ( isset( $res[ $colName ] ) ) {
                    if ( $objColumn->getColumnType() != 'hidden' && $objColumn->getVisible() ) {
                        $colTitle = $objColumn->getTitle() ? $objColumn->getTitle() : $colName;
                        if ( ENCODINGS == 'UTF-8'){
                            $result[ utf8_decode($colTitle) ][ $k ] = $res[ $colName ][ $k ];
                        } else {
                            $result[ utf8_encode($colTitle) ][ $k ] = $res[ $colName ][ $k ];
                        }
                    }
                }
            }
        }
        return $result;
    }
    
    //------------------------------------------------------------------------------------
    public function setCreateDefaultEditButton( $boolNewValue = null )
    {
        $this->createDefaultEditButton = $boolNewValue;
    }
    
    public function getCreateDefaultEditButton( $boolNewValue = null )
    {
        return is_null( $this->createDefaultEditButton ) ? true : $this->createDefaultEditButton;
    }
    
    //------------------------------------------------------------------------------------
    public function setCreateDefaultDeleteButton( $boolNewValue = null )
    {
        $this->createDefaultDeleteButton = $boolNewValue;
    }
    
    public function getCreateDefaultDeleteButton( $boolNewValue = null )
    {
        return is_null( $this->createDefaultDeleteButton ) ? true : $this->createDefaultDeleteButton;
    }
    
    //------------------------------------------------------------------------------------
    /**
     * No Grid off-line Mostra o Botão adicionar
     * @param boolean $boolNewValue
     */
    public function setShowAdicionarButton( $boolNewValue = null )
    {
        $this->showAdicionarButton = $boolNewValue;
    }
    
    function getShowAdicionarButton()
    {
        return ( $this->showAdicionarButton === false ? false : true );
    }
    
    //------------------------------------------------------------------------------------
    public function setNoWrap( $boolNewValue = null )
    {
        $this->noWrap = $boolNewValue;
    }
    
    public function getNoWrap()
    {
        return ( $this->noWrap === true ) ? true : $this->noWrap;
    }
    public function setNoDataMessage($strNewValue=null)
    {
        $this->noDataMessage = $strNewValue;
    }
    public function getNoDataMessage()
    {
        return $this->noDataMessage;
    }
    /**
     * Ordenar arrays
     * $order pode ser: up ou down
     *
     * @param array $array
     * @param string $coluna
     * @param string $order
     */
    public function sortArray($array=null,$coluna=null,$order=null) {
        if(!is_array($array) || is_null( $coluna ) || $coluna == '' ) {
            return $array;
        }
        if( !isset($array[$coluna]) ) {
            $coluna = strtoupper( $coluna );
            if( !isset($array[$coluna]) ) {
                return $array;
            }
        }
        $order = is_null($order) ? 'up': $order;
        
        if( count($array[$coluna])==1) {
            return $array;
        }
        
        $tipoString = isset($tipoString) ? $tipoString : null;
        if($tipoString || $tipoString === null)
            $tipo = 'SORT_STRING';
            else
                $tipo = 'SORT_NUMERIC';
                
                if($order == 'up' )
                    $ordem = 'SORT_DESC';
                    else
                        $ordem = 'SORT_ASC';
                        // tratamento para colunas tipo DATA
                        $aDataInvertida=null;
                        if( substr($array[$coluna][0],2,1).substr($array[$coluna][0],5,1) == '//') {
                            foreach ($array[$coluna] as $k=>$v){
                                $aDataInvertida[$coluna][$k] = substr($v,6,4).'/'.substr($v,3,2).'/'.substr($v,0,2).' '.substr($v,11,8);
                            }
                            $expressao= 'array_multisort($aDataInvertida["'.$coluna.'"], '.$tipo.', '.$ordem;
                            $coluna='';
                        } else if( preg_match('/^\s*[+-]?(\d+|[1-9]\d?(\.\d{3,3})*)(,\d+)?\s*$/',$array[$coluna][0])) {
                            $tipo = 'SORT_NUMERIC';
                            foreach ($array[$coluna] as $k=>$v){
                                $aNumeroPonto[$coluna][$k] = preg_replace('/,/','.',preg_replace('/\./','',$v));
                            }
                            $expressao= 'array_multisort($aNumeroPonto["'.$coluna.'"], '.$tipo.', '.$ordem;
                            $coluna='';
                        } else {
                            $expressao= 'array_multisort($array["'.$coluna.'"], '.$tipo.', '.$ordem;
                        }
                        foreach ($array as $k=>$col){
                            $array[$k][0] = $array[$k][0]; // para corrigir o bug de não alterar os dados da sessao
                            if( $k != $coluna ){
                                $expressao.=' ,$array["'.$k.'"]';
                            }
                        }
                        reset( $array);
                        $expressao.=');';
                        eval($expressao);
                        return $array;
    }
    /**
     * Definir a imagem que será exibida no lugar de um botão desabilitado quando
     * o próprio botão não tiver a sua imagem desabilitada definida
     *
     * ex: $g->setDisabledButtonImage('fwDisabled.png');
     *
     * @param string $strNewImage
     */
    public function setDisabledButtonImage($strNewImage=null)
    {
        $this->disableButtonImage = $strNewImage;
    }
    public function getDisabledButtonImage()
    {
        return $this->disableButtonImage;
    }
    public function setExportFullData($boolNewValue=null)
    {
        $this->exportFullData = $boolNewValue;
    }
    public function getExportFullData()
    {
        return $this->exportFullData;
    }
    /**
     * Retorna um array de objeto com os campos do formulário
     *
     * @param object $frm
     */
    public function extractFormFields($frm=null)
    {
        $fields=array();
        if( ! $frm )
        {
            return $fields;
        }
        //echo 'qdt fields:'.count($frm->getDisplayControls()).',';
        foreach( $frm->getDisplayControls() as $fieldName => $dc )
        {
            //echo $fieldName.'<br>';
            $field = $dc->getField();
            //echo $field->getFieldType().', ';
            if( $field->getFieldType() == 'group' )
            {
                $fields = array_merge($fields, (array) $this->extractFormFields($field) );
            }
            else if( preg_match('/edit|memo|hidden|select|number|date|cpf|cpfcnpj|cnpj/i',$field->getFieldType() ) )
            {
                $label=null;
                if( !empty($dc->getLabel()) && method_exists($dc->getLabel(),'getValue'))
                {
                    $label =$dc->getLabel()->getValue();
                }
                $fields[] = (object) array('field'=>$field,'label'=>$label);
            }
        }
        return $fields;
    }
    
    public function addColumnConfig($intColIndex, $intWidth=null,$strAlign=null,$arrCss=null,$boolVisible=null)
    {
        $this->columnConfig[$intColIndex] = (object) array('width'=>$intWidth,'align'=>$strAlign,'arrCss'=>$arrCss,'visible'=>($boolVisible===false?false:true) );
        return $this;
    }
    public function getColumnConfig( $intColIndex )
    {
        return isset( $this->columnConfig[$intColIndex] ) ? $this->columnConfig[$intColIndex] : null;
    }
    //xxx------------------------------------------------------------------------------------
}
?>