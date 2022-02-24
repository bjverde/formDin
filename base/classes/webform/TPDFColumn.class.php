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

class TPDFColumn
{
	private $header;
	private $width;
	private $align;
	private $fieldName;
	private $fontColor;
	private $fontStyle;
	private $fontSize;
	private $fontFamily;
	private $fillColor;

	/**
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
	 **/
	public function __construct( $strHeader=null
	                           , $intWidth=null
							   , $strAlign=null
							   , $strFieldName=null
							   , $hexFillColor=null
							   , $strFontStyle=null
							   , $intFontSize=null
							   , $hexFontColor=null
							   , $strFontFamily=null)
	{
		$this->setHeader($strHeader);
		$this->setWidth($intWidth);
		$this->setAlign($strAlign);
		$this->setFieldName($strFieldName);
		$this->setFillColor($hexFillColor);
		$this->setFontStyle($strFontStyle);
		$this->setFontSize($intFontSize);
		$this->setFontColor($hexFontColor);
		$this->setFontFamily($strFontFamily);
	}
	public function setHeader($strNewValue=null)
	{
		$this->header = $strNewValue;
		return $this;
	}
	public function getHeader()
	{
		return $this->header;
	}

	public function setWidth($intNewValue=null)
	{
		$this->width = $intNewValue;
		return $this;
	}
	public function getWidth()
	{
		return $this->width;
	}

	public function setAlign($strNewValue=null)
	{
		$this->align = $strNewValue;
		return $this;
	}
	public function getAlign()
	{
		return is_null($this->align) ? 'L' : strtoupper($this->align);
	}

	public function setFieldName($strNewValue=null)
	{
		$this->fieldName = $strNewValue;
		return $this;
	}
	public function getFieldName()
	{
		return $this->fieldName;
	}

	public function setFontColor($strHexColor=null)
	{
		$this->fontColor = $strHexColor;
		return $this;
	}
	public function getFontColor()
	{
		return is_null($this->fontColor) ? 0 : $this->fontColor; // preta
	}

	public function setFillColor($hexFillColor=null)
	{
		$this->fillColor = ( $hexFillColor == '' ) ? null : $hexFillColor;
		return $this;
	}
	public function getFillColor()
	{
		return is_null($this->fillColor) ? 255 : $this->fillColor; // branca
	}

	public function setFontStyle($strNewValue=null)
	{
		$this->fontStyle = $strNewValue;
		return $this;
	}
	public function getFontStyle( $currentFontStyle=null )
	{
		return is_null( $this->fontStyle ) ? $currentFontStyle : $this->fontStyle;
	}
	public function setFontSize($intNewValue=null)
	{
		$this->fontSize = $intNewValue;
		return $this;
	}
	public function getFontSize($currentValue=null)
	{
		return is_null($this->fontSize) ? $currentValue : $this->fontSize;
	}
	public function setFontFamily($strNewValue=null)
	{
		$this->fontFamily = $strNewValue;
	}
	public function getFontFamily($currentValue=null)
	{
		return is_null($this->fontFamily) ? $currentValue : $this->fontFamily;
	}

}
?>