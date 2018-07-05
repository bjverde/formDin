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
 * Classe base para construção de inputs tipo radio button, checkbox, combobox e multi select
 */
abstract class TOption extends TControl
{
	
	const RADIO = 'radio';
	
	private $arrOptions;
	private $arrValues;
	//private $required;
	private $qtdColunms;
	private $columns;
	private $paddingRight;
	private $multiSelect;
	private $selectSize;
	private $keyField;
	private $displayField;
	private $showMinimal;
	private $nowWrapText;
	private $arrOptionsData;
	/**
	 * Método construtor
	 *
	 * $mixOptions = array no formato "key=>value" ou nome do pacote oracle e da função a ser executada
	 * $arrValues = array no formato "key=>key" para identificar a(s) opção(ões) selecionada(s)
	 * $intPaddingItems = numero inteiro para definir o espaço vertical entre as colunas de opções
	 * $strInptType = define o tipo de input a ser gerado. Ex: select, radio ou check
	 * $strKeyColumn = nome da coluna que será utilizada para preencher os valores das opções
	 * $strDisplayColumn = nome da coluna que será utilizada para preencher as opções que serão exibidas para o usuário
	 * $strDataColumns = informações extras do banco de dados que deverão ser adicionadas na tag option do campo select
	 *
	 * @abstract
	 * @param string $strName
	 * @param array $arrOptions
	 * @param array $arrValues
	 * @param boolean $boolRequired
	 * @param integer $intQtdColumns
	 * @param integer $intWidth
	 * @param integer $intHeight
	 * @param integer $intPaddingItems
	 * @param boolean $boolMultiSelect
	 * @param string $strInputType
	 * @param string $strKeyField
	 * @param string $strDisplayField
	 * @param string $strDataColumns
	 * @return TOption
	 */
	public function __construct( $strName, $mixOptions, $arrValues=null, $boolRequired=null, $intQtdColumns=null, $intWidth=null, $intHeight=null, $intPaddingItems=null, $boolMultiSelect=null, $strInputType=null, $strKeyField=null, $strDisplayField=null,$boolNowrapText=null,$strDataColumns=null )
	{
		parent::__construct( 'div', $strName );
		$this->setValue( $arrValues );
		$this->setRequired( $boolRequired );
		$this->setQtdColumns( $intQtdColumns );
		$this->setPaddingItems( $intPaddingItems );
		$this->setFieldType( ($strInputType == null) ? 'select' : $strInputType );
		$this->setMultiSelect( $boolMultiSelect );
		$this->setCss( 'border',  '1px solid #c0c0c0' );
		$this->setCss( 'display', 'inline' );
		$this->setWidth( $intWidth );
		$this->setHeight( $intHeight );
		$this->setKeyField( $strKeyField );
		$this->setDisplayField( $strDisplayField );
		$this->setOptions( $mixOptions, $strDisplayField, $strKeyField, null, $strDataColumns );
		$this->setNowrapText($boolNowrapText);
		// tratamento para campos selects postados das colunas tipo do TGrid onde os nomes são arrays
	   if( $this->getFieldType() == 'select' && strpos( $this->getName(), '[' ) !== false )
	   {
	   	   $name = $this->getName();
		   $arrTemp = explode('[',$name);
		   if( isset($_POST[$arrTemp[0] ] ) )
		   {
		      $expr = '$v=$_POST["'.str_replace( '[', '"][', $name ).';';
		      if( ! preg_match('/\[\]/',$expr ))
		      {
		   		@eval( $expr );
		   		$this->setValue( $v );
		      }
		   }
		}
		//if(isset($_POST[$this->getId()]) && $_POST[$this->getId()] )
		if( isset( $_POST[ $this->getId() ] ) )
		{
			$this->setValue( $_POST[ $this->getId() ] );
		}
	}
	
	public function showRadioOrCheck( $boolPrint=true ){
		
	}
	
	
	/**
	 * cria o html do input
	 * se $boolPrint for true, joga o html para o browser
	 * se $boolPrint for false, retorna o html gerado apenas
	 * se $boolShowOnlyInput for true, será retornada somente a tag input do campo
	 *
	 * @param boolean $boolPrint
	 * @param boolean $boolShowOnlyInput
	 * @return string
	 */
	public function show( $boolPrint=true )
	{
		if( $this->getFieldType() == 'radio' || $this->getFieldType() == 'check' )
		{

			$this->setCss( 'overflow', 'auto' );
			$this->setCss( 'border',  '1px solid transparent' );
			// é necessário pelo menos uma coluna
			if( ( int ) $this->getColumnCount() == 0 && ( int ) $this->getQtdColumns() == 0 )
			{
				$this->setQtdColumns( 1 );
			}
			if( $this->getColumnCount() == 0 )
			{
				for( $i = 0; $i < $this->getQtdColumns(); $i++ )
				{
					$this->addColumn( 'auto' );
				}
			}
			else
			{
				$this->setQtdColumns( $this->getColumnCount() );
			}

			// o campo multi deve ser construido utilizando table para fazer o layout dos itens em colunas
			$this->add( $table = new TTable( $this->getName() . '_table' ) );
			$table->setCss( $this->getCss() );
			$table->setCss('border','1px solid transparent');
			$table->setCss('background-color','transparent');
			$table->setCss( 'display', null );
			$this->clearCss();
			$this->setcss( 'overflow', 'auto' );
			$this->setcss( 'width', $table->getCss( 'width' ) );
			$this->setcss( 'height', $table->getCss( 'height' ) );
			$table->setCss( 'width', null );
			$table->setCss( 'height', null );
			$table->setCss( 'overflow', null );
            if( !$table->getCss('font-size'))
            {
                $table->setCss('font-size','11px');
            }

			$table->setProperty( 'border', 0 );
			$table->setProperty( 'cellspacing', 0 );
			$table->setProperty( 'cellpadding', 0 );
			//transferir a borda do elemento container para table interna
			if( !$this->getEnabled() )
			{
				$table->setProperty( 'disabled', 'true' );
				$table->setCss( 'color', '#52A100' );
				//$this->setId($this->getId().'_disabled');
			}
			if( is_array( $this->getOptions() ) )
			{
				$col = 0;
				$item = 1;
				$linkHelpFile = null;
				foreach( $this->getOptions() as $k=>$v )
				{
					if( $col == 0 )
					{
						$row = $table->addRow();
						$row->clearCss();
					}
					$k=trim($k);
					$v=trim($v);
					$input = new TElement( 'input' );
					$input->clearCss();
    				$input->setProperty('label',$this->getProperty('label'));
    				$input->setCss( 'vertical-align', 'middle' );
					if( !$this->getEnabled() )
					{
						$input->setProperty( 'disabled', 'true' );
					}

					if( $this->getMultiSelect() )
					{
						$input->setProperty( 'type', 'checkbox' );
						$input->setName( $this->getId() . '[]' );
						$input->setProperty( 'id', $this->getId() . '_' . $k );
					}
					else
					{
						$input->setProperty( 'type', 'radio' );
						$input->setName( $this->getId() );
						$input->setProperty( 'id', $this->getId() . '_' . $k );

					}
					$input->setProperty( 'value', $k );
					$input->setCss( 'border', 'none' );
					$input->setCss( 'cursor', 'pointer' );
					$input->setEvents( $this->getEvents() );
					$span = new TElement( 'span' );
					$span->clearCss();
					$span->setId( $this->getId() . '_opcao_' . $item++ );
					$tableLayout=null;
					if( ( string ) $v != '' )
					{
						$span->add($v);
  						if( $this->getWidth() && ! $this->getNowrapText() )
  						{
                        	$tableLayout=new TTable();
                        	$tableLayout->setAttribute('border','0');
                        	$tableLayout->setAttribute('cellspacing','0');
                        	$tableLayout->setAttribute('cellpadding','0');
                        	$r = $tableLayout->addRow();
                        	$r->addCell($input);
                        	$r->addCell($span);
						}
						else
						{
							$input->add( $span );
						}

					}
					if( $this->getFieldType() == 'check' && $this->getEnabled() == true )
					{
						$span->setcss( 'cursor', 'pointer' );
						$input->addEvent( 'onclick', "fwFieldCheckBoxClick(this,'" . $span->getId() . "')" );
						$span->setEvent( 'onclick', "fwGetObj('" . $input->getId() . "').click();" );
					}
					else if( $this->getFieldType() == 'radio' && $this->getEnabled() == true )
					{
						$span->setcss( 'cursor', 'pointer' );
						$input->addEvent( 'onclick', "fwFieldRadioClick(this,'" . $span->getId() . "')" );
						$span->setEvent( 'onclick', "fwGetObj('" . $input->getId() . "').click();" );
					}
					
					if( $this->getFieldType() == self::RADIO ){
						if( $k == $this->getValue() )
						{
							$input->setProperty( 'checked', "true" );
							$span->setCss( 'color', '#0000ff' );
						}
					}else{
						if( ( string ) array_search( $k, $this->getValue() ) != '' )
						{
							$input->setProperty( 'checked', "true" );
							$span->setCss( 'color', '#0000ff' );
						}
					}
					

					
					if( $this->getRequired() )
					{
						$input->setProperty( 'needed', 'true' );
					}
					if( $tableLayout )
						$cell = $row->addCell( $tableLayout );
					else
						$cell = $row->addCell( $input );
					/* if(is_null($linkHelpFile) && $this->getHelpFile())
					  {
					  $aHelpFile = $this->getHelpFile();
					  $linkHelpFile = "&nbsp;&nbsp;<a href=\"{$aHelpFile[0]}\" title=\"{$aHelpFile[1]}\" rel=\"gb_page_center[{$aHelpFile[2]},{$aHelpFile[3]}]\"><img style=\"vertical-align:middle;border:none;cursor:pointer;width:16px;height:16px;\" src=\"{$aHelpFile[4]}\"></a>";
					  $cell->add($linkHelpFile);
					  }
					 */
					$cell->clearCss();
					if( !$this->getWidth() || $this->getNowrapText() )
					{
						$cell->setProperty( 'nowrap', true );
					}
					$cell->setcss( 'padding-right', $this->getPaddingRight() . 'px' );
					if( ( int ) $this->getQtdColumns() > 1 )
					{
						$cell->setcss( 'border-right', '0px solid #c0c0c0' );
					}

					// definir a largura
					if( $this->columns[ $col ][ 0 ] )
					{
						$cell->width = $this->columns[ $col ][ 0 ];
					}
					// definir a cor
					if( $this->columns[ $col ][ 1 ] )
					{
						$cell->setCss( 'color', $this->columns[ $col ][ 1 ] );
					}
					// definir o alinhamento
					if( $this->columns[ $col ][ 1 ] )
					{
						$cell->setCss( 'text-align', $this->columns[ $col ][ 2 ] );
					}
					$col++;
					if( $col == $this->getQtdColumns() )
					{
						$col = 0;
					}
				}
			}
			// trocar o id da div para não conflitar
			$this->setid( $this->getId() . '_container' );

			// para colocar a borda vermelha na validação do campo obrigatório tem que ter uma borda já definida
			if( !$this->getCss('border') )
			{
				$this->setCss('border','1px solid transparent');
			}
			// retirar os eventos do objeto containter
			$this->clearEvents();
			if( $this->getShowMinimal() )
			{
				return $input->show( $boolPrint );
			}
		}
		else
		{
			// criar o input do tipo select ( comboBox )
			if( $this->getMultiSelect() )
			{
				$this->setTagType( 'select multiple' );
				$this->setName( $this->getId() . '[]' );
				$this->setProperty( 'id', $this->getId() );
			}
			else
			{
				$this->setTagType( 'select' );
				$this->setHeight( null );
			}
			$this->setProperty( 'size', $this->getSelectSize() );
			//$this->setCss('border','1px solid #c0c0c0');
			$this->setCss( 'background-color', '#ffffff' );
			// colocar hint se não tiver
			if( $this->getMultiSelect() && $this->title == '' )
			{
				$this->setProperty( 'title', 'Pressione a tecla CTRL ou SHIFT para marcar/desmarcar as opções!' );
			}
			if( is_array( $this->getOptions() ) )
			{
				$this->setCss( 'cursor', 'pointer' );
				$arrOptionsData = $this->getOptionsData();
				foreach( $this->getOptions() as $k=>$v )
				{
					$k=trim($k);
					$v=trim($v);
					$this->add( $opt = new TElement( 'option' ) );
					$opt->setProperty( 'value', $k );
					$opt->clearCss();
					if( !is_array( $this->getValue() ) ) {
					    if( html_entity_decode( ( string ) $k ) == html_entity_decode( ( string ) $this->getValue(),null, ENCODINGS ) ) {
							$opt->setProperty( 'selected', "true" );
						}
					}
					else {
						if( ( string ) array_search( $k, $this->getValue() ) != "" ) {
							$opt->setProperty( 'selected', "true" );
						}
					}
					$opt->add( $v );

					if( isset( $arrOptionsData[$k] ) )
					{
						if( is_array( $arrOptionsData[$k]  ))
						{
							foreach($arrOptionsData[$k] as $e=>$f)
							{
								$opt->setAttribute($e,$f);
							}
						}
						else
						{
							$opt->setAttribute('data-value',$arrOptionsData[$k] );
						}
					}
				}
			}
		}
		if( $this->getRequired() )
		{
			$this->setProperty( 'needed', 'true' );
		}

		return parent::show( $boolPrint );
	}

	/**
	 * Define a quantidade de itens que ficarão visíveis quando o input for do tipo multi select
	 *
	 * @param integer $intNewValue
	 */
	public function setSelectSize( $intNewValue=null )
	{
		$this->selectSize = ( int ) $intNewValue;
		return $this;
	}
	/**
	 * Recupera a quantidade de itens que ficarão visíveis quando o input for do tipo multi select
	 *
	 */
	public function getSelectSize()
	{
		if( ( int ) $this->selectSize == 0 )
		{
			if( $this->getMultiSelect() )
			{
				$this->setSelectSize( count( $this->getOptions() ) );
			}
			else
			{
				$this->setSelectSize( 1 );
			}
		}
		return ( int ) $this->selectSize;
	}
	/**
	 * Define se o input será do tipo multi select
	 *
	 * @param boolean $boolMultiSelect
	 */
	public function setMultiSelect( $boolMultiSelect=null )
	{
		$this->multiSelect = ( bool ) $boolMultiSelect;
		if( $this->getFieldType() == 'select' )
		{
			if( $this->multiSelect === true )
			{
				$this->setFieldType( 'multiselect' );
			}
		}
		else if( $this->getFieldType() == 'multiselect' )
		{
			if( $this->multiSelect === false )
			{
				$this->setFieldType( 'select' );
			}
		}
		return $this;
	}
	/**
	 * Recupera se o input será do tipo multi select
	 *
	 */
	public function getMultiSelect()
	{
		return $this->multiSelect;
	}
	/**
	 * Adiciona uma coluna para gerar a visualiazação dos checkbox ou radio buttons em mais de uma coluna
	 * Tambem pode ser utilzado o parametro $intQtdColumns para definir a quantidade de colunas caso NÃO seja necessário
	 * especificar a largura, cor e alinhamento de cada coluna.
	 *
	 * @param int $intWidth
	 * @param string $strColor
	 * @param string $strAlign
	 */
	public function addColumn( $intWidth=null, $strColor=null, $strAlign=null )
	{
		$this->columns[ ] = array( $intWidth, $strColor, $strAlign );
		return $this;
	}
	/**
	 * Recupera a quantidade de colunas
	 *
	 */
	public function getColumnCount()
	{
		$result  = CountHelper::count( $this->columns ); 
		return $result;
	}
	/**
	 * Define o(s) valor(es) que será(ão) selecionado(s) no campo
	 *
	 * @param mixed $mixValues
	 */
	public function setValue( $mixValues=null )
	{
		if (is_array($mixValues))
		{
			$this->arrValues = $mixValues;
		}
		else
		{
			$this->arrValues = array($mixValues);
		}
		return $this;
// 		$this->arrValues = ( array ) $mixValues;
	}
	/**
	 * recupera os valores selecionados no input
	 *
	 */
	public function getValue()
	{
		$type = $this->getFieldType();
		if( $type == 'select' && !$this->getMultiSelect() )
		{
			if( $this->arrValues )
			{
				if( is_array( $this->arrValues ) )
				{
					return $this->arrValues[ 0 ];
				}
				else
				{
					return null;
				}
			}
			return null;
		}
		elseif ($type == self::RADIO){
			$result = $this->arrValues[0];
			return $result;
		}
		else
		{
			return ( array ) $this->arrValues;
		}
	}

	/**
	 * Define um array no formato "key=>value" ou string no formato "S=SIM,N=NAO,..." ou
	 * o nome de um pacoteFunção para recuperar do banco de dados, neste
	 * caso pode ser especificada a coluna chave, a coluna descrição e
	 * searchFields como parametros para a função do pacote oracle.
	 *
	 * Ex: $mixSearchFields="cod_uf=53,num_pessoa=20" ou array('COD_UF'=53,'NUM_PESSOA'=>20)
	 * Ex: $strDataColumns = "cod_uf,sig_uf,cod_regiao"
	 *
	 * @param mixed $mixOptions
	 * @param string $strDisplayField
	 * @param string $strKeyField
	 * @param mixed $mixSearchFields
	 * @param string $strDataColumns
	 */
	public function setOptions( $mixOptions=null, $strDisplayField=null, $strKeyField=null, $mixSearchFields=null, $strDataColumns=null )
	{
		if( isset( $mixOptions ) )
		{

			if( !is_null($strDataColumns) && trim( $strDataColumns) != '' )
			{
				$arrDataColumns	= explode(',',$strDataColumns);
				$strDataColumns	= ','.$strDataColumns.' ';
			}

			if( is_string( $mixOptions ) )
			{
				$where = null;
				$cacheSeconds = null;
				if( preg_match('/\|/',$mixOptions))
				{
					$mixOptions  	= explode( '|', $mixOptions );
					$mixOptions[1]  = ( isset( $mixOptions[1] ) ? $mixOptions[1] : '' );
					// segundo parametro pode ser o where ou tempo de cache
					$where 		 = is_numeric($mixOptions[1] ) ? '' : $mixOptions[1];
					$cacheSeconds= is_numeric($mixOptions[1])  ? $mixOptions[1] : null;
					$mixOptions  = $mixOptions[0];
				}
				// verificar se passou no formato "S=SIM,N=NAO...."
				if( strpos( $mixOptions, '=' ) || strlen($mixOptions)==1 )
				{

				// tratar opção de 1 caractere. Ex: S,N,1,2...
					if( strlen($mixOptions)==1 )
					{
						$mixOptions = array( 'N'=>'' );
					}
					else
					{
						// tratar formato S=>SIM,N=>NÃO
						$mixOptions = preg_replace('/\=\>/','=',$mixOptions);
						$mixOptions = explode( ',', $mixOptions );
						forEach( $mixOptions as $k=>$v )
						{
							$v = explode( '=', $v );
							$v[ 1 ] = ( isset( $v[ 1 ] ) ) ? $v[ 1 ] : $v[ 0 ];
							$arrTemp[ $v[ 0 ] ] = $v[ 1 ];
						}
						$mixOptions = $arrTemp;
						$arrTemp = null;
					}
				}
				else
				{
					if( function_exists( 'recuperarPacote' ) )
					{
						$packageName 	= $mixOptions;
						$mixOptions = null;
						$searchFields = null;
						if( isset( $mixSearchFields ) )
						{
							if( is_string( $mixSearchFields ) )
							{
								$searchFields = explode( ',', $mixSearchFields );
								if( is_array( $searchFields ) )
								{
									forEach( $searchFields as $k=>$v )
									{
										$v = explode( '=', $v );
										$bvars[ $v[ 0 ] ] = $v[ 1 ];
									}
								}
							}
							else if( is_array( $mixSearchFields ) )
							{
								$bvars = $mixSearchFields;
							}
						}
						// se passou somente o nome da tabela , criar comando select
						if( preg_match( '/\.PK\a?/i', $packageName ) )
						{
							print_r( recuperarPacote( $packageName, $bvars, $mixOptions, $cacheSeconds ) );
						}
						else
						{
							if( $strKeyField && $strDisplayField )
							{
								$sql = "select {$strKeyField},{$strDisplayField}{$strDataColumns} from  {$packageName} order by {$strDisplayField}";
							}
							else
							{
								if( !preg_match( '/' . ESQUEMA . '\./', $packageName ) )
								{
									$packageName = ESQUEMA . '.' . $packageName;
								}
								$sql = "select * from {$packageName}";
							}
							$bvars = null;
							$nrows = 0;
							$mixOptions = null;
							if( $GLOBALS[ 'conexao' ] )
							{
								if( $GLOBALS[ 'conexao' ]->executar_recuperar( $sql, $bvars, $mixOptions, $nrows ) )
								{
									echo 'Erro na execução do sql:' . $sql;
								}
							}
						}
					}
					else
					{
						if( TPDOConnection::getInstance() )
						{
							if( preg_match( '/^select/i', $mixOptions ) > 0 )
							{
								$mixOptions = TPDOConnection::executeSql( $mixOptions );
							}
							else
							{
								if( !is_null( $where ) )
								{
									$where = ' where ' . preg_replace( '/"/', "'", $where );
								}
								else
								{
									$where = '';
								}
								if( $this->getKeyField() && $this->getDisplayField() )
								{
									$sql = "select {$this->getKeyField()},{$this->getDisplayField()}{$strDataColumns} from {$mixOptions} {$where} order by {$this->getDisplayField()}";
								}
								else
								{
									$sql = "select * from {$mixOptions} {$where}";
								}
								$mixOptions = TPDOConnection::executeSql( $sql );
							}
							TPDOConnection::showError();
						}
					}
				}
			}

			$this->arrOptions = null;
			if( is_array( $mixOptions ) )
			{
				// verificar se o array está no formato oracle
				if( key( $mixOptions ) && is_array( $mixOptions[ key( $mixOptions ) ] ) )
				{
					// assumir a primeira e segunda coluna para popular as opções caso não tenha sido informadas
					if( !isset( $strKeyField ) )
					{
						if( !$this->getKeyField() )
						{
							list($strKeyField) = array_keys( $mixOptions );
						}
						else
						{
							$strKeyField = $this->getKeyField();
						}
					}
					if( !isset( $strDisplayField ) )
					{
						if( !$this->getDisplayField() )
						{
							list(, $strDisplayField) = array_keys( $mixOptions );
						}
						else
						{
							$strDisplayField = $this->getDisplayField();
						}
						if( !isset( $strDisplayField ) )
						{
							$strDisplayField = $strKeyField;
						}
					}
					if( $strKeyField && $strDisplayField )
					{
						// reconhecer nome da columa em caixa baixa ou alta
						if( !array_key_exists( $strKeyField, $mixOptions ) )
						{
							$strKeyField = strtoupper( $strKeyField );
							$strDisplayField = strtoupper( $strDisplayField );
						}
						if( !array_key_exists( $strKeyField, $mixOptions ) )
						{
							$strKeyField = strtolower( $strKeyField );
							$strDisplayField = strtolower( $strDisplayField );
						}
						if( is_array( $mixOptions[ $strKeyField ] ) )
						{
							foreach( $mixOptions[ $strKeyField ] as $k=>$v )
							{
								$this->arrOptions[ $v ] = $mixOptions[ $strDisplayField ][ $k ];
								if( isset( $arrDataColumns ) && is_array( $arrDataColumns ) )
								{
									foreach($arrDataColumns as $colName )
									{
										$value='';
										if( isset( $mixOptions[$colName][$k] ) )
										{
											$value = $mixOptions[$colName][$k];
										}
										elseif( isset( $mixOptions[strtoupper($colName) ][$k] ) )
										{
											$value = $mixOptions[strtoupper($colName) ][$k];
										}
										elseif( isset( $mixOptions[strtolower($colName) ][$k] ) )
										{
											$value = $mixOptions[strtolower($colName)][$k];
										}
										$value = $this->specialChars2htmlEntities( $value );
										$value = preg_replace("/\n/",' ',$value);
										$this->arrOptionsData[$v]['data-'.strtolower($colName)] = $value;
									}
								}
							}
						}
					}
				}
				else
				{
					$this->arrOptions = $mixOptions;
				}
			}
		}
		return $this;
	}

	/**
	 * Recupera o array de opções do campo
	 *
	 */
	public function getOptions()
	{
		return $this->arrOptions;
	}
	/**
	 * Define se o campo deverá ter pelo menos uma opção selecinada para o teste de validação
	 *
	 * @param boolean $boolValue
	 */
	public function setRequired( $boolValue=null )
	{
		$this->setAttribute('needed', ( ( bool ) $boolValue ? 'true' : 'false' ) );
		return $this;
	}
	/**
	 * Retorna se campo está definido como obrigatório.
	 *
	 */
	public function getRequired()
	{
		return $this->getAttribute('needed') == "true";
	}

	/**
	 * Define a quantidade de colunas para distribuição dos checkbox ou radios na tela
	 *
	 * @param integer $intNewValue
	 */
	public function setQtdColumns( $intNewValue=null )
	{
		$this->qtdColunms = (( int ) $intNewValue == 0) ? 1 : ( int ) $intNewValue;
		return $this;
	}
	/**
	 * Recupera a quantidade de colunas para distribuição dos checkbox ou radios na tela
	 *
	 */
	public function getQtdColumns()
	{
		return ( int ) $this->qtdColunms;
	}
	/**
	 * Define a distância entre as colunas. Padrão=20px
	 *
	 * @param integer $intNewValue
	 */
	public function setPaddingItems( $intNewValue=null )
	{
		$this->paddingRight = (( int ) $intNewValue == 0) ? 20 : ( int ) $intNewValue;
		return $this;
	}
	/**
	 * recupera a distância entre as colunas. Padrão=20px
	 *
	 */
	public function getPaddingRight()
	{
		return ( int ) $this->paddingRight;
	}
	//-------------------------------------------------
	public function setKeyField( $strNewValue=null )
	{
		$this->keyField = $strNewValue;
		return $this;
	}
	//-------------------------------------------------
	public function setDisplayField( $strNewValue=null )
	{
		$this->displayField = $strNewValue;
		return $this;
	}
	//-------------------------------------------------
	public function getKeyField()
	{
		return $this->keyField;
	}
	//-------------------------------------------------
	public function getDisplayField()
	{
		return $this->displayField;
	}
	//---------------------------------------------------
	public function validate()
	{
		if( $this->getRequired() == true  )
		{
			$value = $this->getValue();
			if( is_array( $value ) )
			{
				if( count( $value) == 0 || trim( $value[0] ) == ''  )
				{
					$this->addError( "Campo obrigatório" );
				}
			}
			else if ( is_null( $value ) || trim($value) == '' )
			{
				$this->addError( "Campo obrigatório" );
			}
		}
		return ( ( string ) $this->getError() === "" );
	}
	/**
	 * Permite retornar somente a tag input do campo sem as tags de formatação para exibição na classe TForm.
	 *
	 * @param boolean $boolNewValue
	 */
	public function setShowMinimal( $boolNewValue=null )
	{
		$this->showMinimal = $boolNewValue;
		return $this;
	}
	public function getShowMinimal()
	{
		return $this->showMinimal;
	}
	public function setNowrapText($boolNewValue = null )
	{
		$this->nowWrapText = $boolNewValue;
		return $this;
	}
	public function getNowrapText()
	{
		return $this->nowWrapText === true? true: false;
	}
	public function getOptionsData()
	{
		return is_null( $this->arrOptionsData ) ? array() : $this->arrOptionsData;
	}
	public function setOptionsData($arrData=null)
	{
		$this->arrOptionsData = $arrData;
		return $this;
	}
	public function setOptionData($strKey=null,$strValue=null)
	{
		$this->arrOptionsData[$strKey] = $strValue;
		return $this;
	}
}
//return;
/*
  $radio = new TRadio('tip_bioma',array(1=>'Cerrado',2=>'Pantanal'),null,true,2);
  $radio->show();
  $check = new TCheck('tip_vegetacao',array(1=>'Cerrado',2=>'Pantanal'),null,true,2);
  $check->show();
  return;
 */
/* for($i=1;$i<10;$i++)
  {
  $opt[$i]='Opção Nº '.($i+1);
  }
  //$check = new TCheck('chk',array(1=>'Maça',2=>'Tomate',3=>'Limão'),array('2',1),false);
  //$check = new TCheck('chk',$opt,array('2',1),false,5,null,null,null,5);
  //$check->show();
  //$check = new TCheck('chk',$opt,array('2',1),false,10,800,600,null,5);
  //$check->addColumn(100,'black','left');
  //$check->addColumn(100,'red','left');
  //$check->addColumn(100,'blue','left');
  //
  //$check->setEvent('onclick','fwTeste(this.value)');
  //$check->setflat(false);
 */

/*
  print '<form name="formdin" method="POST" action="">';
  $select = new TSelect('tip_arvore',array(1=>'Cerrado',2=>'Pantanal',3=>'Mata',5=>'Caatinga'),null,true,true,3,500);
  $select->show();
  print '<hr>';
  print '<input type="submit" value="Gravar">';
  print '</form>';
  print_r($_REQUEST);
 */

/*
  $select = new TSelect('seq_bioma',"1=Um,2=Dois");
  $select->show();
  $ta = new TMemo('memo','Lua de sao jorge',200,false,100,5);
  $ta->show();
 */
?>