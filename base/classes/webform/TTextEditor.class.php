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
* Classe para implementar campos de entrada de dados de varias linhas (textareas)
*
*/
class TTextEditor extends TMemo
{
	private $showCounter;
	private $onlineSearch;
	private $resizeEnabled;

	/**
     * Adiciona um campo do tipo texto rico, com ckeditor 5
	 *
	 * @param string $strName        -01: ID do campo
	 * @param string|null $strValue  -02: Valor inicial do campo
	 * @param [type] $intMaxLength   -03:
	 * @param [type] $boolRequired   -04: True = Obrigatório; False (Defalt) = Não Obrigatório
	 * @param [type] $intColumns     -05:
	 * @param [type] $intRows        -06:
	 * @param [type] $boolShowCounter-07: True = Obrigatório; False (Defalt) = Não Obrigatório
	 */
	public function __construct(string $strName
	                           ,string $strValue=null
							   ,$intMaxLength
							   ,$boolRequired=null
							   ,$intColumns=null
							   ,$intRows=null
							   ,$boolShowCounter=null
							   )
	{
		parent::__construct($strName,$strValue,$intMaxLength,$boolRequired,$intColumns,$intRows,$boolShowCounter);
		parent::setFieldType('textEditor');
	}

	/**
	 * @return $resizeEnabled
	 */
	public function getResizeEnabled() {
		return $this->resizeEnabled;
	}

	/**
	 * 
	 * @param bool $boolResizeEnabled
	 * @return TTextEditor
	 */
	public function setResizeEnabled($boolResizeEnabled) {
		if (is_bool($boolResizeEnabled))
			$this->resizeEnabled = $boolResizeEnabled;
		return $this;
	}

	public function show($print=true) {
		//CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
		$id = $this->getId();
		$sck = <<<EOD
		ClassicEditor
		.create( document.querySelector( '#$id' ), {
			language: 'pt-br'
			,toolbar: {
				items: [ 'restrictedEditingException','findAndReplace'
						,'|','heading','style'
						,'|','bold','italic','underline','strikethrough','specialCharacters','link','subscript','superscript'
						,'|','bulletedList','numberedList','todoList'
						,'|','alignment','outdent','indent'
						,'|','blockQuote','insertTable','mediaEmbed','undo','redo',
						,'-','removeFormat','fontSize','highlight','fontBackgroundColor','fontColor','fontFamily'
						,'|','imageUpload','imageInsert'
						,'|','pageBreak','htmlEmbed','sourceEditing','code','codeBlock','textPartLanguage' ]
				,shouldNotGroupWhenFull: true
			}
			,image: {
				toolbar: [
					'imageTextAlternative',
					'toggleImageCaption',
					'imageStyle:inline',
					'imageStyle:block',
					'imageStyle:side',
					'linkImage'
				]
			}
			,table: {
				contentToolbar: [
					'tableColumn',
					'tableRow',
					'mergeTableCells',
					'tableCellProperties',
					'tableProperties'
				]
			}			
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
		EOD;	

		$div = new TElement('div');
		$div->setId($id.'_div');
		$div->add( parent::show(false).$this->getOnlineSearch());
		$script=new TElement('<script>');
		$script->add('//Config Ckeditor 5 classic-36.0.1');
		//$script->add('CKEDITOR.config.resize_enabled = false;');
		$script->add($sck);
		$div->add($script);
		return $div->show($print);

		//return parent::show($print).$this->getOnlineSearch();
	}

	public function getValue() {
		$valor = parent::getValue();
		if( !empty($valor) ){
			$valor = str_replace(chr(147), '"', parent::getValue()); //substitui aspas erradas pelas corretas
		}
		return $valor;
	}
}
?>