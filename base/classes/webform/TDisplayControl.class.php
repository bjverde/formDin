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
* Classe para criar a disposição do rotulo e do input
* utilizando TABLE para definir o layout rotulo em cima ou na frente do campo
*/
class TDisplayControl extends TTable
{
	private $label;
	private $field;
	private $labelAbove;
	private $noWrapLabel;
	private $noWrapField;
	private $newLine;
	private $verticalAlign;
	// Está é a estrutura padrão de saida do display control, 1 ou 2 linhas com 1 ou 2 colunas dependendo do labelAbove
	private $row1;
	private $row2; // no caso do label em cima
	private $column1;
	private $column2;
	private $column3; // no caso do label em cima
	private $onlineDoc;
	private $labelCellWidth;
	private $fieldCellWidth;

	/**
	* Cria a estrutura (table) de exibição do rotulo e do campo no formulário
	*
	* @param mixed $strLabel
	* @param mixed $objField
	* @param mixed $boolLabelAbove
	* @param mixed $boolNewLine
	* @param mixed $boolNoWrapLabel
	* @param mixed $strVerticalAlign
	* @param mixed $boolOnlineDoc
	* @param mixed $boolOnlineDocReadOnly
	* @param mixed $boolNoWrapField
	*
	* @return TDisplayControl
	*/
	public function __construct( $strLabel = null, $objField = null, $boolLabelAbove = null, $boolNewLine = null, $boolNoWrapLabel = null, $strVerticalAlign = null, $boolOnlineDoc = null, $boolOnlineDocReadOnly = null, $boolNoWrapField = null )
	{
		if ( !$objField )
		{
			return null;
		}
		parent::__construct( $objField->getId() . '_area' );
		$this->setClass( 'fwField' );
		$this->setProperty( 'border', '0' );
		$this->setProperty( 'cellspacing', '0' );
		$this->setProperty( 'cellpadding', '0' );
		$this->setVerticalAlign( $strVerticalAlign );
		$this->setCss( 'background-color', 'transparent' );
		$this->setCss( 'display', 'inline' );

		$this->setNoWrapLabel( $boolNoWrapLabel );
		$this->setNoWrapField( $boolNoWrapField );
		$this->setOnlineDoc( $boolOnlineDoc, $boolOnlineDocReadOnly );

		$this->field = $objField;

		if ( isset( $strLabel ) && !is_null( $strLabel ) )
		{
			$this->label = new TLabel( $objField->getId() . '_label', $strLabel );
			$this->label->clearCss();
		}
		$this->labelAbove = $boolLabelAbove === true ? true : false;
		$this->newLine = $boolNewLine === false ? false : true;

		// criar os objetos da estrura
		$this->row1 = $this->addRow();
		$this->column1 = $this->row1->addCell();
		$this->column2 = $this->row1->addCell();
		$this->column2->setCss( 'vertical-align', $this->getVerticalAlign() );
	}

	//---------------------------------------------------------------------------
	function show( $print = true )
	{
		$label = null;
		$labelClean = null;

		if ( $this->label )
		{
			$labelClean = $this->label->getValue();
			$idLabel = $this->label->getId();
			$labelValue = '<span id="' . $idLabel . '">' . $labelClean . '</span>';
			$this->label->setId( $idLabel . '_area' );
			$this->label->setValue( $labelValue );
			if ( $this->field->getRequired() )
			{
				$this->label->setProperty( 'needed', 'true' );

				if ( defined( 'REQUIRED_FIELD_MARK' ) )
				{
					if( ! trim( $labelClean ) == ''  )
					{
					   $this->label->setValue( $this->label->getValue() . '<span id="' . $this->field->getId() . '_label_required" style="cursor:pointer;" tooltip="true" class="fwFieldRequired" title="Campo obrigatório">' . REQUIRED_FIELD_MARK . '</span>' );
					}
				}
				else
				{
					$this->label->setClass( $this->label->getClass() . ' fwFieldRequired', false );
				}
			}
			else
			{
				// adicionar a tag para ser utilizada para funcao js fwSetRequired()
				$this->label->setValue( $this->label->getValue() . '<span id="' . $this->field->getId() . '_label_required" style="cursor:pointer;" tooltip="true" class="fwFieldRequired" title=""></span>' );
			}
			$label = trim( preg_replace( '/:/', '', $labelClean ) );
		}
		$btnTooltip = '';

		if ( method_exists( $this->field, 'getTooltip' ) )
		{
			if ( $tt = $this->field->getTooltip() )
			{
				$btnTooltip = new TButton( 'btn_tooltip_' . $this->field->getId(), 'tooltip', null, 'void(0)', null, $tt->getImage(), null, $tt->getTooltip() );
				$btnTooltip->setProperty( 'tooltip', 'true' );
			}
		}
		$btnDocumentation = '';

		if ( $this->getOnlineDoc() )
		{
			$btnDocumentation = new TButton( 'btn_documentation_' . $this->field->getId(), 'Manual', null, 'fwShowOnlineDocumentation("' . $this->removeIllegalChars( $_REQUEST[ 'modulo' ] ) . '","' . $this->field->getId() . '","' . $label . '")', null, 'ajudaonline.gif', null, 'Clique aqui para exibir o texto de ajuda!' );
			$btnDocumentation = preg_replace( '/' . chr( 10 ) . '/', '', $btnDocumentation->show( false ) );
		}

		if ( $this->labelAbove )
		{
			$this->row2 = $this->addRow();
			$this->column3 = $this->row2->addCell();
			$this->column3->setProperty( 'nowrap', 'true' );
			$this->column1->setId( 'td_label_' . $this->field->getId() );
			$this->column3->setId( 'td_field_' . $this->field->getId() );
			$this->row1->setId( 'tr_label_' . $this->field->getId() );
			$this->row2->setId( 'tr_field_' . $this->field->getId() );

			if ( !$this->label )
			{
				// criar um label vazio para manter o linhamento
				$this->label = new TLabel( $this->field->getId() . '_label', '&nbsp;' );
				$this->label->clearCss();
			}
			$this->label->setCss( 'width', '100%' );
			$this->column1->add( $this->label );
			//$this->column3->add('<div style="margin-right:2px;float:left;cursor:pointer;" tooltip="true" class="fwFieldRequired" title="Campo obrigatório">*</div>');
			$this->column3->add( $this->field );
			$this->column3->setCss( 'padding-bottom', '3px' );

			if ( $this->field->getCss( 'margin-left' ) )
			{
				$this->setCss( 'margin-left', $this->field->getCss( 'margin-left' ) );
				$this->field->setCss( 'margin-left', null );
			}

			if ( $btnTooltip )
			{
				$this->column3->add( $btnTooltip );
			}

			if ( $btnDocumentation )
			{
				$this->label->setValue( $btnDocumentation . $this->label->getValue() );
			}
			$btnTooltipLabel=null;
			if ( method_exists( $this->label, 'getTooltip' ) )
			{
				if ( $tt = $this->label->getTooltip() )
				{
					$btnTooltipLabel = new TButton( 'btn_tooltip_' . $this->field->getId().'_label', 'tooltip', null, 'void(0)', null, $tt->getImage(), null, $tt->getTooltip() );
					$btnTooltipLabel->setProperty( 'tooltip', 'true' );
					$this->label->setValue( $this->label->getValue().$btnTooltipLabel->show(false) );
				}
			}
			$this->row1->clearChildren();
			$this->row1->add( $this->column1 );
		}
		else
		{
			$this->column1->setId( 'td_label_' . $this->field->getId() );
			$this->column2->setId( 'td_field_' . $this->field->getId() );

			if ( $this->getNoWrapField() )
			{
				$this->column2->setProperty( 'nowrap', 'nowrap' );
			}
			$this->row1->setId( 'tr_field_' . $this->field->getId() );

			if ( $btnDocumentation && isset( $this->label ) )
			{
				$this->label->setValue( $btnDocumentation . $this->label->getValue() );
			}
			$btnTooltipLabel=null;
			if ( method_exists( $this->label, 'getTooltip' ) )
			{
				if ( $tt = $this->label->getTooltip() )
				{
					$btnTooltipLabel = new TButton( 'btn_tooltip_' . $this->field->getId().'_label', 'tooltip', null, 'void(0)', null, $tt->getImage(), null, $tt->getTooltip() );
					$btnTooltipLabel->setProperty( 'tooltip', 'true' );
					$this->label->setValue( $this->label->getValue().$btnTooltipLabel->show(false) );
				}
			}
			if ( $this->label )
			{
				if ( $this->label->getValue() == '' )
				{
					$this->label->setValue( '&nbsp;' );
				}
				$this->column1->add( $this->label );
			}
			else
			{
				$this->row1->clearChildren();
				$this->row1->add( $this->column2 );
			}
			$this->column2->add( $this->field );

			if ( $btnTooltip )
			{
				$this->column2->add( $btnTooltip );
			}

			if ( $this->field->getCss( 'margin-left' ) )
			{
				$this->setCss( 'margin-left', $this->field->getCss( 'margin-left' ) );
				$this->field->setCss( 'margin-left', null );
			}
		}

		if ( $this->field->getCss( 'top' ) )
		{
			$this->setCss( 'position', 'absolute' );
			$this->setCss( 'top', $this->field->getCss( 'top' ) );
			$this->field->setCss( 'top', null );
			$this->field->setCss( 'position', 'relative' );
		}

		if ( $this->field->getCss( 'left' ) )
		{
			$this->setCss( 'position', 'absolute' );
			$this->setCss( 'left', $this->field->getCss( 'left' ) );
			$this->field->setCss( 'left', null );
			$this->field->setCss( 'position', 'relative' );
		}

		if ( $this->column2 )
		{
			if ( $this->getNoWrapField() === true )
			{
				$this->column2->setProperty( 'nowrap', 'true' );
			}

			if ( $this->getFieldCellWidth() )
			{
				if ( $this->getFieldCellWidth() != '0px' )
				{
					$this->column2->setCss( 'width', $this->getFieldCellWidth() );
				}
			}
			$this->column2->setCss( 'vertical-align', $this->getVerticalAlign() );
		}

		if ( $this->column1 )
		{
			if ( $this->getLabelCellWidth() )
			{
				if( !is_null( $labelClean ) && trim($labelClean) != '')
				{
					$this->column1->setCss( 'width', $this->getLabelCellWidth() );
				}
			}
		}

		if ( $this->column3 )
		{
			if ( $this->getNoWrapField() )
			{
				$this->column3->setProperty( 'nowrap', 'true' );
			}

			if ( $this->getFieldCellWidth() )
			{
				$this->column3->setCss( 'width', $this->getFieldCellWidth() );
			}
		}

		if ( method_exists( $this->field, 'getVisible' ) )
		{
			// esconder a linha se o campo estiver invisível
			if ( !$this->field->getVisible() )
			{
				$this->setCss( 'display', 'none' );
				$this->field->setVisible( true );
				$this->field->setCss( 'display', null );
			}
		}
		return parent::show( $print );
	}

	//---------------------------------------------------------------------------------------------
	public function getField()
	{
		return $this->field;
	}

	//------------------------------------------------------------------------------------------
	public function getLabel()
	{
		return $this->label;
	}

	//------------------------------------------------------------------------------------------
	public function getNewLine()
	{
		return $this->newLine;
	}

	//------------------------------------------------------------------------------------------
	public function setNewLine( $boolNewValue )
	{
		$this->newLine = $boolNewValue;
	}

	//-------------------------------------------------------------------------------------------
	public function setVerticalAlign( $strNewValue = null )
	{
		$this->verticalAlign = ( is_null( $strNewValue ) ? 'middle' : $strNewValue );
	}

	//-------------------------------------------------------------------------------------------
	public function getVerticalAlign()
	{
		if ( is_null( $this->verticalAlign ) )
		{
			$va = $this->getField()->getCss( 'vertical-align' );
		}
		else
		{
			$va = $this->verticalAlign;
		}
		return strtolower( ( is_null( $va ) ? 'middle' : $va ) );
	}
	/**
	* Retorna o objeto coluna caso seja necessário fazer algum tratamento
	* como no caso do pageControl que tem que alterar o css para a aba ocupar a largura do form
	*
	*/
	public function getColumn1()
	{
		return $this->column1;
	}

	//--------------------------------------------------------------------------------------------
	public function getColumn2()
	{
		if ( $this->labelAbove )
		{
			return $this->column3;
		}
		return $this->column2;
	}

	public function getRow1()
	{
		return $this->row1;
	}

	//--------------------------------------------------------------------------------------------
	public function getRow2()
	{
		return $this->row2;
	}

	//---------------------------------------------------------------------------
	/**
	* Define se o conteudo da coluna da tebela onde o rótulo será exibido,
	* pode ocorrer quebra de linha quando o seu conteúdo for muito longo.
	*
	* @param bool $boolNewValue
	*/
	public function setNoWrapLabel( $boolNewValue = null )
	{
		$boolNewValue = is_null( $boolNewValue ) ? false : $boolNewValue;
		$this->noWrapLabel = $boolNewValue;
	}

	//---------------------------------------------------------------------------
	public function getNoWrapLabel()
	{
		return $this->noWrapLabel;
	}

	//---------------------------------------------------------------------------
	/**
	* Define se o conteudo da coluna da tebela onde o campo será exibido,
	* pode ocorrer quebra de linha quando o campo tiver alguma imagem, botão ou texto
	* sendo exibido na sua frente
	*
	* @param bool $boolNewValue
	*/
	public function setNoWrapField( $boolNewValue = null )
	{
		// padrão é false, para não afetar as linhas da classe TGrid
		$boolNewValue = is_null( $boolNewValue ) ? false : $boolNewValue;
		$this->noWrapField = $boolNewValue;
	}

	//---------------------------------------------------------------------------
	public function getNoWrapField()
	{
		return is_null( $this->noWrapField ) ? true : $this->noWrapField;
	}

	//----------------------------------------------------------------------------
	public function getLabelAbove()
	{
		return $this->labelAbove;
	}

	public function setLabelAbove( $boolNewValue = null )
	{
		$this->labelAbove = $boolNewValue;
	}
	/**
	* Habilita/Desabilita o botão para edição online da documentação do campo
	*
	* @param boolean $boolNewValue
	*/
	public function setOnlineDoc( $boolEnabled = null, $boolReadOnly = null )
	{
		$this->onlineDoc = is_null( $boolEnabled ) ? false : $boolEnabled;
		$this->onlineDocReadOnly = is_null( $boolReadOnly ) ? false : $boolReadOnly;
	}

	public function getOnlineDoc()
	{
		return ( $this->onlineDoc === true ? true : false );
	}
	/**
	* Define a largura da celula da tabela que exibirá o rótulo do campo
	*
	* @param mixed $strWidth
	*/
	public function setLabelCellWidth( $strWidth = null )
	{
		$this->labelCellWidth = $strWidth;
	}

	/**
	* Define a largura da celula da tabela que exibirá o campo
	*
	* @param mixed $strWidth
	*/
	public function setFieldCellWidth( $strWidth = null )
	{
		$this->fieldCellWidth = $strWidth;
	}
	/**
	* Recupera a largura da celula da tabela que exibirá o rótulo do campo
	*
	* @param mixed $strWidth
	*/
	public function getLabelCellWidth()
	{
		if ( is_numeric( $this->labelCellWidth ) )
		{
			if ( $this->labelCellWidth > 0 )
			{
				return $this->labelCellWidth . 'px';
			}
			else
			{
				return null;
			}
		}
		return $this->labelCellWidth;
	}
	/**
	* Recupera a largura da celula da tabela que exibirá o campo
	*
	* @param mixed $strWidth
	*/
	public function getFieldCellWidth()
	{
		if ( is_numeric( $this->fieldCellWidth ) )
		{
			if ( $this->fieldCellWidth > 0 )
			{
				return $this->fieldCellWidth . 'px';
			}
			else
			{
				return null;
			}
		}
		return $this->fieldCellWidth;
	}
}

//-----------------------------------------------
/*
$teste = new TDisplayControl('Nome:',new TEdit('nom_pessoa','Luis Eugênio',30),false);
*/
?>