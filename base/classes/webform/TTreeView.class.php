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

/*
	Estrutura do xml - http://docs.dhtmlx.com/doku.php?id=dhtmlxtree:syntax_templates
	API - http://docs.dhtmlx.com/doku.php?id=dhtmlxtree:api_toc_categories
	Componente: http://docs.dhtmlx.com/doku.php?id=dhtmlxtree:toc
*/
class TTreeView extends TControl
{
	private $itens;
	private $xmlFile;
	private $onClick;    // recebe o ID do item clicado
	private $onDblClick; // recebe o ID do item clicado
	private $onDragEnd;  // recebe o ID do ítem de origem e o ID do ítem destino
	private $onCheck;    // recebe o ID e o state do check box do ítem. State = 0 ou 1
	private $enableCheckBoxes;
	//private $enableRadiobuttons;
	private $enableDragAndDrop;
	private $enableTreeLines;
	private $formSearchFields;
	private $initialParentKey;
	private $enableHighlighting;
	private $imagesPath;
	private $theme;
	private $userDataFieldNames;
	private $rootLabel;
	private $rootNode;
	private $startExpanded;
	private $toolBarVisible;
	private $arrOrphan;

	private $parentFieldName;
  	private $childFieldName;
  	private $descFieldName;
  	private $tableName;

	/**
	* Implementa Tree View
	*
	* O parametro $mixData pode ser um array de dados ou o nome de uma tabela. Se for o nome de uma tabela,
	* o carregamento dos filhos será feito dinamicamente ao clicar no item pai
	*
	* A função definida no parametro jsOnClick recebe o id do item clicado e deve ser utilizado para
	* recuperar attributos do nó.
	* <code>
	* 	alert( tree.getSelectedItemId());
	* 	alert( tree.getItemText(id ) );
	* 	alert( tree.getUserData(id,'URL') );
	* </code>
	*
	* A função definida no parametro jsOnDblClick recebe o id do item duplamente clicado e deve ser utilizado para
	* recuperar attributos do nó.
	* <code>
	* 	alert( tree.getSelectedItemId());
	* 	alert( tree.getItemText(id ) );
	* 	alert( tree.getUserData(id,'URL') );
	* </code>
	*
	* A função definida no parametro jsOnCheck recebe o id e o state do item clicado.
	* <code>
	* 	function treeCheck(id, state)
	* 	{
	* 		alert( state );
	* 	}
	* </code>
	*
	* A função definida no parametro jsOnDrag recebe o id do item arrastado e o id do item destino, se retornar true a operação e aceita
	* <code>
	* 	function treeDrag(id, id2) {
	*		return confirm("Deseja mover o ítem " + tree.getItemText(id) + " para o item " + tree.getItemText(id2) + "?");
	*	};
	* </code>
	*
	* @param mixed $strName
	* @param string $strRootLabel
	* @param mixed $mixData
	* @param mixed $strParentFieldName
	* @param mixed $strChildFieldName
	* @param mixed $strDescFieldName
	* @param mixed $strInitialParentKey
	* @param mixed $mixUserDataFieldNames - campos separados por virgula ou array normal ex: array('nome','telefone');
	* @param mixed $strHeight
	* @param mixed $strWidth
	* @param mixed $jsOnClick
	* @param mixed $jsOnDblClick
	* @param mixed $jsOnCheck
	* @param mixed $jsOnDrag
	* @param mixed $boolEnableCheckBoxes
	* @param mixed $boolEnableRadioButtons
	* @param mixed $boolEnableTreeLines
	* @param mixed $mixFormSearchFields
	* @return TTreeView
	*/
	public function __construct( $strName=null, $strRootLabel = null, $mixData = null, $strParentFieldName = null, $strChildFieldName = null, $strDescFieldName = null, $strInitialParentKey = null, $mixUserDataFieldNames = null, $strHeight = null, $strWidth = null, $jsOnClick = null, $jsOnDblClick = null, $jsOnCheck = null, $jsOnDrag = null, $boolEnableCheckBoxes = null, $boolEnableRadioButtons = null, $boolEnableTreeLines = null, $mixFormSearchFields = null, $boolShowToolBar = null )
	{
		$strName = is_null($strName) ? 'tree_'.$this->getRandomChars(3):$strName;
		parent::__construct( 'div', $strName );
		$this->setFieldType( 'treeview' );
		$this->setClass( 'fwTreeView' );
		$this->setOnClick( $jsOnClick );
		$this->setOnDblClick( $jsOnDblClick );
		$this->setOnCheck( $jsOnCheck );
		$this->setWidth( $strWidth );
		$this->setHeight( $strHeight );
		$this->enableCheck( $boolEnableCheckBoxes );
		$this->enableDrag( !is_null( $jsOnDrag ), $jsOnDrag );
		$this->setInitialParentKey( $strInitialParentKey );
		$this->setEnableHighlighting( true );
		$this->setRootLabel( $strRootLabel );
		$this->setShowToolBar( $boolShowToolBar );
		//$this->initialParentKey = $strInitialParentKey;
		//$this->enableRadio($boolEnableRadioButtons);
		$this->addFormSearchFields( $mixFormSearchFields );
		$this->enableLines( $boolEnableTreeLines );
		$this->setData( $mixData, $strParentFieldName, $strChildFieldName, $strDescFieldName, $mixUserDataFieldNames );
        $this->setParentFieldName($strParentFieldName);
 		$this->SetChildFieldName($strChildFieldName);
 		$this->setDescFieldName($strDescFieldName);
 		$this->setUserDataFieldNames($mixUserDataFieldNames);
		if ( is_string( $mixData ) )
		{
			$this->setTableName($mixData);
			/*if ( is_array( $mixUserDataFieldNames ) )
			{
				$mixUserDataFieldNames = implode(',',$mixUserDataFieldNames);
			}
			*/
			//$this->setXmlFile( 'index.php?modulo='.$this->getBase().'callbacks/treeView.php&ajax=1&parentField=' . $strParentFieldName . '&childField=' . $strChildFieldName . '&descField=' . $strDescFieldName . '&tableName=' . $mixData . '&userDataFields=' . $mixUserDataFieldNames );
			//$this->setXmlFile($this->getBase().'callbacks/treeView.php');
		}
	}

	/**
	* Define o arquivo externo para criação dinâmica da árvore quando o ítem for expandido.
	*
	* Se for definido os parametros $mixData,$strParentFieldName,$strChildFieldName,$strDescFieldName, a classe
	* utilizará automaticamente o arquivo genérico base/callbacks/treeView.php para obter os valores via ajax

	* <code>
	* 	$tree->setXmlFile('index.php?modulo=base/exemplos/tree.php&ajax=1');
	* </code>
	* @param mixed $strFileName
	*/
	public function setXmlFile( $strFileName = null )
	{
		$this->xmlFile = $strFileName;
	}

	public function getXmlFile()
	{
		if( !$this->itens )
		{
	   		$xmlFile = is_null($this->xmlFile) ? $this->getBase().'callbacks/treeView.php' : $this->xmlFile;
   			if( file_exists($xmlFile) )
   			{
   				return 'index.php?modulo='
   				. $xmlFile .'&ajax=1&fwTreeview=1&parentField='
   				. $this->getParentFieldName(). '&childField='
   				. $this->getChildFieldName() . '&descField='
   				. $this->getDescFieldName() . '&tableName='
   				. $this->getTableName() . '&userDataFields=' . $this->getUserDataFieldNames();
				//return $this->xmlFile;
			}
			else
			{
				$this->addItem(0,1,'Arquivo '.$xmlFile.' não encontrado!', true, '' );
			}
		}
	}

	public function show( $print = true )
	{
		$this->setToolBar();
		return parent::show( $print );
	}
	/**
	* Define a função que será chamada quando o usuário clicar em um ítem da árvore.
	* Esta função recebe o id do ítem clicado
	* Exemplo: alert( tree.getItemText(id) );
	*
	* @param mixed $strJsFuncion
	*/
	public function setOnClick( $strJsFunction = null )
	{
		$this->onDblClick = null;
		$this->onClick = $strJsFunction;
	}

	public function getOnClick()
	{
		return $this->removeIllegalChars( $this->onClick, '.' );
	}
	/**
	* Define a função que será chamada quando o usuário fizer um duplo clique em um ítem da árvore.
	* Esta função recebe o id do ítem clicado
	* Exemplo: alert( tree.getItemText(id) );
	*
	* @param mixed $strJsFuncion
	*/
	public function setOnDblClick( $strJsFunction = null )
	{
		$this->onClick = null;
		$this->onDblClick = $strJsFunction;
	}

	public function getOnDblClick()
	{
		return $this->removeIllegalChars( $this->onDblClick, '.' );
	}
	/**
	* Define o nome de uma função javascript que será chamada ao clicar no checkbox
	* Esta função receberá dois parametros: o ID do state do checkbox sendo 0 ou 1
	*
	* @param mixed $strJsFunction
	*/
	public function setOnCheck( $strJsFunction = null )
	{
		$this->onCheck = $strJsFunction;
	}

	public function getOnCheck()
	{
		return $this->removeIllegalChars( $this->onCheck, '.' );
	}

	public function enableCheck( $boolNewValue = null )
	{
		$boolNewValue = $boolNewValue === true ? true : false;
		$this->enableCheckBoxes = $boolNewValue;

		if ( $this->enableCheckBoxes )
		{
		//$this->enableRadiobuttons=false;
		}
	}

	public function getEnableCheck()
	{
		return $this->enableCheckBoxes;
	}
	/*public function enableRadio($boolNewValue=null)
	{
		$boolNewValue = $boolNewValue===true ? true : false;
		$this->enableRadiobuttons = $boolNewValue;
		if( $this->enableRadiobuttons )
		{
			$this->enableCheckBoxes=false;
		}
	}
	*/
	/*blic function getEnableRadio()
	{
		return $this->enableRadiobuttons;
	}
	*/
	public function getOnDragEnd()
	{
		return $this->removeIllegalChars( $this->onDragEnd, '.' );
	}
	/**
	* Habilita/Desabilita o recurso de arrastar e soltar
	*
	* A função de callback recebe os IDs dos ítens origem e destino, se for
	* returnado false a operação é cancelada
	* Exemplo:     return confirm("Deseja mover o ítem " + tree.getItemText(id) + " para o item " + tree.getItemText(id2) + "?");
	*
	* @param boolean $boolNewValue
	* @param string $strJsCallBack
	*/
	public function enableDrag( $boolNewValue = null, $strJsCallBack = null )
	{
		$boolNewValue = $boolNewValue === true ? true : false;
		$this->enableDragAndDrop = $boolNewValue;
		$this->onDragEnd = $strJsCallBack;
	}

	public function getEnableDrag()
	{
		return $this->enableDragAndDrop;
	}
	/**
	* Permite mostra ou esconder as linhas de desenho dos níveis da treeview
	*
	* @param boolean $boolNewValue
	*/
	public function enableLines( $boolNewValue = null )
	{
		$boolNewValue = $boolNewValue === true ? true : false;
		$this->enableTreeLines = $boolNewValue;
	}

	//---------------------------------------------------------------------------
	public function getEnableLines()
	{
		return $this->enableTreeLines;
	}

	//---------------------------------------------------------------------------
	public function setData( $arrData, $strParentField, $strChildField, $strDescField, $mixUserDataFields = null )
	{
		if ( !is_array( $arrData ) || is_null( $strParentField ) || is_null( $strChildField ) || is_null( $strDescField ) )
		{
			return;
		}

		// construir valores do parametro UserData
		if ( is_string( $mixUserDataFields ) )
		{
			$mixUserDataFields = explode( ',', $mixUserDataFields );
		}

		foreach( $arrData[ $strParentField ] as $k => $v )
		{
			$arrUserData = null;

			if ( is_array( $mixUserDataFields ) )
			{
				foreach( $mixUserDataFields as $kData => $vData )
				{
					if ( isset( $arrData[ trim( $vData )] ) )
					{
						$arrUserData[ trim( $vData )] = $arrData[ trim( $vData )][ $k ];
					}
				}
			}

			if ( ( string ) $v == '' )
			{
				$this->addItem( 0, $arrData[ $strChildField ][ $k ], $arrData[ $strDescField ][ $k ], null, null, $arrUserData );
			}
			else
			{
				$this->addItem( $v, $arrData[ $strChildField ][ $k ], $arrData[ $strDescField ][ $k ], null, null, $arrUserData );
			}
		}
	}

	//---------------------------------------------------------------------------
	/**
	* Método para adicionar campos do formulário como parametro de filtragem nos
	* dados retornados para construção da árvore.
	* Se o valor for passado, este será constante, se for nulo será o valor atual do
	* campo no formulário.
	*
	* @param mixed $mixFieldId
	* @param mixed $strValue
	*/
	public function addFormSearchFields( $mixFieldId = null, $strValue = null )
	{
		if ( is_null( $mixFieldId ) || $mixFieldId == '' )
		{
			return;
		}

		if ( is_array( $mixFieldId ) )
		{
			$this->formSearchFields = $mixFieldId;
		}
		else
		{
			$this->formSearchFields[ $mixFieldId ] = $strValue;
		}
	}

	//---------------------------------------------------------------------------
	public function getFormSearchFields( $boolJson = null )
	{
		if ( !$boolJson )
		{
			return $this->formSearchFields;
		}

		if ( is_array( $this->formSearchFields ) )
		{
			return json_encode( $this->formSearchFields );
		}
	}

	//---------------------------------------------------------------------------
	public function setInitialParentKey( $mixNewValue = null )
	{
		$this->initialParentKey = $mixNewValue;
	}
    public function getInitialParentKey()
	{
		$id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : '0';
		return is_null($this->initialParentKey) ? $id : $this->initialParentKey;
	}

	//---------------------------------------------------------------------------
	public function setEnableHighlighting( $boolNewValue = null )
	{
		$this->enableHighlighting = $boolNewValue;
	}

	public function getEnableHighlighting()
	{
		if ( $this->enableHighlighting === false )
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	//---------------------------------------------------------------------------
	function setImagesPath( $strNewValue = null )
	{
		$this->imagesPath = $strNewValue;
	}

	function getImagesPath()
	{
		if ( is_null( $this->imagesPath ) || !file_exists( $this->imagesPath ) )
		{
			return $this->getBase() . 'js/dhtmlx/treeview/imgs/' . $this->getTheme() . '/';
		}
		return $this->imagesPath;
	}

	//---------------------------------------------------------------------------
	/**
	* define o tema da treeview
	*
	* @param array $strNewTheme
	*/
	public function setTheme( $strNewTheme = 'default|vista|skyblue|winstyle' )
	{
		if ( preg_match( '/\|/', $strNewTheme ) > 0 )
		{
			$strNewTheme = null;
		}
		$this->theme = $strNewTheme;
	}

	public function getTheme()
	{
		return is_null( $this->theme ) ? 'default' : $this->theme;
	}

	//---------------------------------------------------------------------------
	public function setRootLabel( $strNewValue = null )
	{
		if (!is_null($this->rootNode))
		{
			echo 'Função setRootLabel() classe TTreeview só pode ser utilizada enquanto a árvore está vazia.';
			return;
		}
		$this->rootLabel = $strNewValue;
	}

	public function getRootLabel()
	{
		return $this->rootLabel;
	}

	//---------------------------------------------------------------------------
	function setStartExpanded( $boolNewValue = null )
	{
		$boolNewValue = is_null( $boolNewValue ) ? false : $boolNewValue;
	}

	function getStartExpanded()
	{
		return $this->startExpanded;
	}

	//---------------------------------------------------------------------------
	/**
	* Adicionar ítem na árvore
	*
	* @param bool $idParent
	* @param mixed $id
	* @param mixed $text
	* @param mixed $open
	* @param mixed $hint
	* @param mixed $arrUserData
	* @param mixed $boolSelect
	* @param mixed $boolChecked
	*/
	public function addItem( $idParent = null, $id, $text, $open = null, $hint = null, $arrUserData = null, $boolSelect = null, $boolChecked = null )
	{
		$idParent = is_null($idParent) ? '' : $idParent.'';
 		if ( !$this->itens ) {

 			$expand = is_null( $this->getStartExpanded() ) ? true : $this->getStartExpanded();
		    if( $idParent == $this->initialParentKey && ! isset($_REQUEST['id'] ) ) {				
				if ( $this->getRootLabel() ) {
					$this->itens = new TTreeViewData( '0', 'root', true, '' ); // nivel obrigatório
					$this->itens->addItem($this->rootNode = new TTreeViewData( $this->getRandomChars(10)  , $this->getRootLabel(), true, 'Item Raiz' )); //raiz
				}
				else {
					$this->itens = $this->rootNode = new TTreeViewData( '0', 'root', $expand, '' ); // nivel obrigatório
				}
			} else {
				$this->itens = $this->rootNode = new TTreeViewData( $idParent, 'root', $expand, '' ); // nivel obrigatório
			}

		}
		$parent = ( is_null($idParent) || $idParent=="" || $idParent == '0') ? $this->rootNode : $this->itens->getElementById( $idParent );
 		if ( !$parent )
		{
			$item = New TTreeViewData( $id, $text, $open, $hint, $arrUserData, $boolSelect );
			$item->setParent( $idParent );
			$this->addOrphan( $item );
			return;
		}
		if ( $id === '0' )
		{
			echo 'Função addItem() da classe TTreeview não permite ítem com ID = 0 (ZERO).';
			return;
		}
		// adicionar filho somente se não existir
		if ( !$item = $this->itens->getElementById( $id ) )
		{
			$parent->addItem( new TTreeViewData( $id, $text, $open, $hint, $arrUserData, $boolSelect, $boolChecked ) );
		}
	}
	//---------------------------------------------------------------------------
	function clear() {
		parent::clear();
		if ($this->rootNode)
			$this->rootNode->clear();
		$this->rootNode = null;
		$this->itens = null;
	}
	//---------------------------------------------------------------------------
	function removeAll() {
		$this->clear();
	}
	//---------------------------------------------------------------------------
	protected function setToolBar()
	{
		if ( $this->getShowToolBar() )
		{
			$tb = new TElement( 'div' );
			$tb->setClass( 'fwTreeViewToolBar' );
			$tb->setId( $this->getId() . '_toolbar' );
			$tb->add( new TButton( $tb->getId() . '_btn1', null, null, $this->getId() . 'Js.openAllItems(0)', null, 'folderAzulOpen.gif', null, 'Expandir Todos' ) );
			$tb->add( new TButton( $tb->getId() . '_btn2', null, null, $this->getId() . 'Js.closeAllItems(0)', null, 'folderAzul.gif', null, 'Fechar Todos' ) );

			if ( $this->getEnableCheck() )
			{
				$tb->add( new TButton( $tb->getId() . '_btn3', null, null, 'if(!' . $this->getId() . 'Js.getSelectedItemId()){alert("Selecione um ítem");return false;}' . $this->getId() . 'Js.setSubChecked(' . $this->getId() . 'Js.getSelectedItemId(),true)', null, 'iconCheckAll.gif', null, 'Marcar o ítem e seus descendentes' ) );
				$tb->add( new TButton( $tb->getId() . '_btn4', null, null, 'if(!' . $this->getId() . 'Js.getSelectedItemId()){alert("Selecione um item");return false;}' . $this->getId() . 'Js.setSubChecked(' . $this->getId() . 'Js.getSelectedItemId(),false)', null, 'iconUncheckAll.gif', null, 'Desmarcar o ítem e seus descendentes' ) );
			}
			$this->add( $tb );
			$this->setCss( 'overflow', 'auto' );
		}
	}

	//---------------------------------------------------------------------------
	public function getJs()
	{

		$id = $this->getId() . "Js";
		$js = $id . ' = new dhtmlXTreeObject("' . $this->getId() . '", "100%", "100%", 0);' . "\n";
		//$js .= $this->getId().".setSkin('dhx_skyblue');"."\n";
		//$js .= $this->getId().'.setImagePath("'.$this->getBase().'js/dhtmlx/codebase/imgs/csh_bluebooks/");'."\n";
		$js .= $id . '.setImagePath("' . $this->getImagesPath() . '");' . "\n";
		$js .= $id . '.enableHighlighting(' . $this->getEnableHighlighting() . ');' . "\n";

		if ( $this->getXmlFile() )
		{
			$js .= $id . '.attachEvent("onXLS", function(tree,id){fwTreeAddLoading(tree,id);});' . "\n";
			$js .= $id . '.attachEvent("onXLE", function(tree,id){fwTreeRemoveLoading(tree,id);});' . "\n";
		}

		if ( $this->getOnClick() )
		{
			$js .= $id . '.setOnClickHandler( ' . $this->getOnClick() . ' );' . "\n";
		}
		else if( $this->getOnDblClick() )
		{
			$js .= $id . '.setOnDblClickHandler( ' . $this->getOnDblClick() . ' );' . "\n";
		}

		if ( $this->getEnableCheck() )
		{
			$js .= $id . '.enableCheckBoxes(true);' . "\n";
		}

		//if($this->getEnableRadio() )
		//{
		//$js .= $id.'.enableRadiobuttons(true);'."\n";
		//}
		if ( $this->getEnableDrag() )
		{
			// Parametro false = não pode soltar em uma area vazia da arvore, somente sobre outro item
			$js .= $id . '.enableDragAndDrop(1,false);' . "\n";
		}

		if ( $this->getOnDragEnd() )
		{
			$js .= $id . '.setDragHandler( ' . $this->getOnDragEnd() . ' );' . "\n";
		}

		if ( $this->getOnCheck() )
		{
			$js .= $id . '.setOnCheckHandler( ' . $this->getOnCheck() . ' );' . "\n";
		}

		if ( $this->getEnableLines() )
		{
			$js .= $id . '.enableTreeLines(true);' . "\n";
		}

		if ( $this->getXmlFile() )
		{
			$url = $this->getXmlFile();
			$url = str_replace( 'index.php', '', $url );
			if ( !strpos( $url, 'ajax=1' ) )
			{
				$url .= ( strpos( $url, '?' ) > 0 ? '&' : '?' ) . 'ajax=1';
			}
			if ( $this->initialParentKey )
			{
				$url .= '&initialParentKey=' . $this->initialParentKey;
			}

			if ( strpos( $this->getXmlFile(), 'index.php' ) == 0 )
			{
				$js .= $id . '.setXMLAutoLoading(fwUrlAddParams(app_url+app_index_file+"' . $url . '"' . ( $this->getFormSearchFields( true ) ? ',' . $this->getFormSearchFields( true ) : '' ) . '));' . "\n";
 				$js .= $id . '.loadXML(fwUrlAddParams(app_url+app_index_file+"' . $url . '"' . ( $this->getFormSearchFields( true ) ? ',' . $this->getFormSearchFields( true ) : '' ) . '));' . "\n";
 		}
			else
			{
				$js .= $id . '.setXMLAutoLoading(fwUrlAddParams("' . $url . '"' . ( ( $this->getFormSearchFields( true )) ? ',' . $this->getFormSearchFields( true ) : '' ) . '));' . "\n";
				$js .= $id . '.loadXML(fwUrlAddParams("' . $url . '"' . ( $this->getFormSearchFields( true ) ? ',' . $this->getFormSearchFields( true ) : '' ) . '));' . "\n";
			}
		}
		else
		{
			// adicionar os itens orfãos
			if ( $this->getOrphans() )
			{
				foreach( $this->getOrphans() as $k => $item )
				{
					if ( $parent = $this->itens->getElementById( $item->getIdParent() ) )
					{
						$parent->addItem( $item );
					}
				}
			}
			if (is_null($this->itens))
			{
				$this->itens = new TTreeViewData( 0, 'root', $expand, '' ); // nivel obrigatório
			}
			$js .= $id . ".loadXMLString('" . $this->getXml(false) . "')";
		}
		return $js;
	}

	public function setShowToolBar( $boolNewValue = null )
	{
		$this->toolBarVisible = $boolNewValue;
	}

	public function getShowToolBar()
	{
		return is_null( $this->toolBarVisible ) ? true : $this->toolBarVisible;
		showToolBar;
	}

	public function showToolBar()
	{
		$this->setShowToolBar( true );
	}

	public function hideToolBar()
	{
		$this->setShowToolBar( false );
	}

	function addOrphan( TTreeViewData $item )
	{
		// se existir filhos orfão, adicionar todos os filhos
		while( $obj = $this->getOrphanByIdParent( $item->getId() ) )
		{
			$item->addItem( $obj );
		}

		// adicionar ao pai se existir
		if ( $obj = $this->getOrphanById( $item->getIdParent() ) )
		{
			$obj->addItem( $item );
		}
		else
		{
			// adicionar a lista de orfãos
			$this->arrOrphan[ ] = $item;
		}
	}

	function getOrphanById( $strId )
	{
		$result = null;

		if ( $this->arrOrphan )
		{
			foreach( $this->arrOrphan as $k => $obj )
			{
				if ( $obj->getId() == $strId )
				{
					$result = $obj;
					break;
				}
				//$result = $obj->getOrphanById( $strId );
			}
		}
		return $result;
	}

	function getOrphanByIdParent( $strId )
	{
		$result = null;

		if ( $this->arrOrphan )
		{
			foreach( $this->arrOrphan as $k => $obj )
			{
				if ( $obj->getIdParent() == $strId )
				{
					$result = $obj;
					// remover o registro órfão
					array_splice( $this->arrOrphan, $k, 1 );
					break;
				}
				//$result = $obj->getOrphanByIdParent( $strId );
			}
		}
		return $result;
	}

	function getOrphans()
	{
		return $this->arrOrphan;
	}

	public function setParentFieldName($strNewValue=null)
	{
		$this->parentFieldName = $strNewValue;
	}
	public function getParentFieldName()
	{
		return $this->parentFieldName;
	}
	public function setChildFieldName($strNewValue=null)
	{
		$this->childFieldName = $strNewValue;
	}
	public function getChildFieldName()
	{
		return $this->childFieldName;
	}
	public function setDescFieldName($strNewValue=null)
	{
		$this->descFieldName = $strNewValue;
	}
	public function getDescFieldName()
	{
		return $this->descFieldName;
	}
	public function setTableName($strNewValue=null)
	{
		$this->tableName = $strNewValue;
	}
	public function getTableName()
	{
		return $this->tableName;
	}
	public function setUserDataFieldNames($mixNewValue=null)
	{
		$this->userDataFieldNames = $mixNewValue;
	}
	public function getUserDataFieldNames()
	{
		return $this->userDataFieldNames;
	}
	public function getXml($print=false)
	{
	  	if( !$this->itens  )
		{
   			if( $this->getOrphans() )
			{
				list($item) = $this->getOrphans();
				$this->itens=null;
				$this->itens = new TTreeViewData( $item->getIdParent(), 'root');
			 }
			else
			{
				$this->itens = new TTreeViewData( $this->getInitialParentKey(), 'root');
			}
   		}
   		if( $this->getOrphans() )
   		{
			foreach( $this->getOrphans() as $item )
			{
				$this->itens->addItem($item);
			}
   		}

		$xml = '<?xml version="1.0" encoding="iso-8859-1"?>' . str_replace( chr( 13 ), '', str_replace( chr( 9 ), '', str_replace( chr( 10 ), '', $this->itens->getXml() ) ) );
		if ( $print === true )
		{
			ob_clean();
			header("Content-type:text/xml");
			echo $xml;
		}
		else
		{
			return $xml;
		}
	}
}
?>