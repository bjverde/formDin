<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Minist�rio do Planejamento
 * Criado por Lu�s Eug�nio Barbosa
 * Essa vers�o � um Fork https://github.com/bjverde/formDin
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
 * Este arquivo � parte do Framework Formdin.
 *
 * O Framework Formdin � um software livre; voc� pode redistribu�-lo e/ou
 * modific�-lo dentro dos termos da GNU LGPL vers�o 3 como publicada pela Funda��o
 * do Software Livre (FSF).
 *
 * Este programa � distribu�1do na esperan�a que possa ser �til, mas SEM NENHUMA
 * GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer MERCADO ou
 * APLICA��O EM PARTICULAR. Veja a Licen?a P�blica Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Voc� deve ter recebido uma c�pia da GNU LGPL vers�o 3, sob o t�tulo
 * "LICENCA.txt", junto com esse programa. Se n�o, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Funda��o do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

define('EOL',"\n");
define('TAB',chr(9));
if(!defined('DS')){ define('DS',DIRECTORY_SEPARATOR); }
class TFormCreate {
	private $formTitle;
	private $formPath;
	private $formFileName;
	private $primaryKeyTable;
	private $tableRef;
    private $daoTableRef;
	private $voTableRef;
	private $listColumnsName;
    private $lines;

	public function __construct(){
	}
	//--------------------------------------------------------------------------------------
	public function setFormTitle($formTitle) {
		$formTitle = ( isset($formTitle) ) ? $formTitle : "titulo";
		$this->formTitle    = $formTitle;
	}
	//--------------------------------------------------------------------------------------
	public function setFormPath($formPath) {
		$formPath = ( isset($formPath) ) ?$formPath : "/modulos";
		$this->formPath    = $formPath;
	}	
	//--------------------------------------------------------------------------------------
	public function setFormFileName($formFileName) {
		$formFileName = ( isset($formFileName) ) ?$formFileName : "form-".date('Ymd-Gis');
		$this->formFileName    = $formFileName;
	}
	//--------------------------------------------------------------------------------------
	public function setPrimaryKeyTable($primaryKeyTable) {
		$primaryKeyTable = ( isset($primaryKeyTable) ) ?$primaryKeyTable : "id";
		$this->primaryKeyTable    = strtoupper($primaryKeyTable);
	}
	//--------------------------------------------------------------------------------------
	public function setTableRef($tableRef) {
		$this->daoTableRef= ucfirst($tableRef).'DAO';
		$this->voTableRef = ucfirst($tableRef).'VO';
	}
	public function setListColunnsName($listColumnsName) {
		array_shift($listColumnsName);
		$this->listColumnsName = array_map('strtoupper', $listColumnsName);
	}	
	//--------------------------------------------------------------------------------------	
	private function addLine($strNewValue=null,$boolNewLine=true){
		$strNewValue = is_null( $strNewValue ) ? TAB.'//' . str_repeat( '-', 80 ) : $strNewValue;
		$this->lines[] = $strNewValue.( $boolNewLine ? EOL : '');
	}
	//--------------------------------------------------------------------------------------	
	private function addBlankLine(){
		$this->addLine('');
	}	
	//--------------------------------------------------------------------------------------
	private function addBasicaFields() {
		$this->addBlankLine();
		$this->addBlankLine();
		$this->addLine('$frm->addHiddenField( $primaryKey ); // coluna chave da tabela');
		if( isset($this->listColumnsName) && !empty($this->listColumnsName) ){
			foreach($this->listColumnsName as $key=>$value){
				$this->addLine('$frm->addTextField(\''.$value.'\', \''.$value.'\',50,true);');
			}
		}		
	}
	//--------------------------------------------------------------------------------------
	private function addBasicaViewController() {
		$this->addBlankLine();
		$this->addLine('$acao = isset($acao) ? $acao : null;');
		$this->addLine('switch( $acao ) {');
		$this->addLine(TAB.'case \'Salvar\':');
		$this->addLine(TAB.TAB.'if ( $frm->validate() ) {');
		$this->addLine(TAB.TAB.TAB.'$vo = new '.$this->voTableRef.'();');
		$this->addLine(TAB.TAB.TAB.'$frm->setVo( $vo );');
		$this->addLine(TAB.TAB.TAB.'$resultado = '.$this->daoTableRef.'::insert( $vo );');
		$this->addLine(TAB.TAB.TAB.'if($resultado==1) {');
		$this->addLine(TAB.TAB.TAB.TAB.'$frm->setMessage(\'Registro gravado com sucesso!!!\');');
		$this->addLine(TAB.TAB.TAB.TAB.'$frm->clearFields();');
		$this->addLine(TAB.TAB.TAB.'}else{');
		$this->addLine(TAB.TAB.TAB.TAB.'$frm->setMessage($resultado);');
		$this->addLine(TAB.TAB.TAB.'}');
		$this->addLine(TAB.TAB.'}');
		$this->addLine(TAB.'break;');
		$this->addLine();
		$this->addLine(TAB.'case \'Limpar\':');
		$this->addLine(TAB.TAB.'$frm->clearFields();');
		$this->addLine(TAB.'break;');
		$this->addLine();
		$this->addLine(TAB.'case \'gd_excluir\':');
		$this->addLine(TAB.TAB.'$id = $frm->get( $primaryKey ) ;');
		$this->addLine(TAB.TAB.'$resultado = '.$this->daoTableRef.'::delete( $id );;');
		$this->addLine(TAB.TAB.'if($resultado==1) {');
		$this->addLine(TAB.TAB.TAB.'$frm->setMessage(\'Registro excluido com sucesso!!!\');');
		$this->addLine(TAB.TAB.TAB.'$frm->clearFields();');
		$this->addLine(TAB.TAB.'}else{');
		$this->addLine(TAB.TAB.TAB.'$frm->clearFields();');
		$this->addLine(TAB.TAB.TAB.'$frm->setMessage($resultado);');
		$this->addLine(TAB.TAB.'}');		
		$this->addLine(TAB.'break;');		
		$this->addLine('}');
	}
	//--------------------------------------------------------------------------------------
	private function addBasicaGrid() {
		$this->addBlankLine();
		$this->addLine('$dados = '.$this->daoTableRef.'::selectAll($primaryKey);');
		if( isset($this->listColumnsName) && !empty($this->listColumnsName) ){
			$mixUpdateFields = '$primaryKey.\'|\'.$primaryKey.\'';
			foreach($this->listColumnsName as $key=>$value){
				$mixUpdateFields = $mixUpdateFields.','.$value.'|'.$value;
			}
			$mixUpdateFields = $mixUpdateFields.'\';';
			$this->addLine('$mixUpdateFields = '.$mixUpdateFields);
		}
		$this->addLine('$gride = new TGrid( \'gd\'        // id do gride');
		$this->addLine('				   ,\'Gride\'     // titulo do gride');
		$this->addLine('				   ,$dados 	      // array de dados');
		$this->addLine('				   ,null		  // altura do gride');
		$this->addLine('				   ,null		  // largura do gride');
		$this->addLine('				   ,$primaryKey   // chave primaria');
		$this->addLine('				   ,$mixUpdateFields');
		$this->addLine('				   );');
		$this->addLine('$gride->addColumn($primaryKey,\'id\',50,\'center\');');
		if( isset($this->listColumnsName) && !empty($this->listColumnsName) ){
			foreach($this->listColumnsName as $key=>$value){
				$this->addLine('$gride->addColumn(\''.$value.'\',\''.$value.'\',50,\'center\');');
			}
		}
		$this->addLine('$frm->addHtmlField(\'gride\',$gride);');
	}
	//--------------------------------------------------------------------------------------
	public function showForm($print=false) {
		$this->lines=null;
        $this->addLine('<?php');
        $this->addLine('$primaryKey = \''.$this->primaryKeyTable.'\';');
        $this->addLine('$frm = new TForm(\''.$this->formTitle.'\',600);');
		$this->addLine('$frm->setFlat(true);');
		$this->addBasicaFields();
		$this->addBasicaViewController();
		$this->addBasicaGrid();
		//-------- FIM
		$this->addLine('$frm->setAction( \'Salvar,Limpar\' );');
		$this->addLine('$frm->show();');
		$this->addLine("?>");
        
        if( $print){
			echo trim(implode($this->lines));
		}else{
			return trim(implode($this->lines));
		}
	}
    
	//---------------------------------------------------------------------------------------
	public function saveForm(){
		$fileName = $this->formPath.DS.$this->formFileName.'.php';
		if($fileName){
			if( file_exists($fileName)){
				unlink($fileName);
            }
            $payload = $this->showForm(false);
			file_put_contents($fileName,$payload);
		}
	}
}
?>