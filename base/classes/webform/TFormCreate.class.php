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
 * Este programa é distribuí1do na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licen?a Pública Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

define('EOL',"\n");
define('TAB',chr(9));
define('DS',DIRECTORY_SEPARATOR);
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
	public function showDao($print=false) {
		$this->lines=null;
        $this->addLine('<?php');
        $this->addLine('$primaryKey = \''.$this->primaryKeyTable.'\'');
        $this->addLine('$frm = new TForm(\''.$this->formTitle.'\',600);');
        $this->addLine('$frm->setFlat(true);');
		$this->addLine('class '.ucfirst($this->getTableName()).'DAO extends TPDOConnection');
		$this->addLine('{');

		// construct
		$this->addLine(TAB.'public function '.$this->getTableName().'DAO()');
		$this->addLine(TAB.'{');
		$this->addLine(TAB.'}');
		$this->addLine();

		// insert
		$this->addLine(TAB.'public static function insert( '.ucfirst($this->tableName).'VO $objVo )');
		$this->addLine(TAB.'{');
		$this->addLine(TAB.TAB.'if( $objVo->get'.ucFirst($this->keyColumnName).'() )');
		$this->addLine(TAB.TAB.'{');
		$this->addLine(TAB.TAB.'	return self::update($objVo);');
		$this->addLine(TAB.TAB.'}');
		$this->addLine(TAB.TAB.'$values = array(',false);
		$cnt=0;
		foreach($this->getColumns() as $k=>$v)
		{
			if( $v != $this->keyColumnName)
			{
				$this->addLine(( $cnt++==0 ? ' ' : TAB.TAB.TAB.TAB.TAB.TAB.',').' $objVo->get'.ucfirst($v).'() ');
			}
		}
		$this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.');');
		$this->addLine(TAB.TAB.'return self::executeSql(\'insert into '.$this->getTableName().'(');
		$cnt=0;
		foreach($this->getColumns() as $k=>$v)
		{
			if( $v != $this->keyColumnName)
			{
				$this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.( $cnt++==0 ? ' ' : ',').$v);
			}
		}
		//$this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.') values (?'.str_repeat(',?',count($this->getColumns())-1 ).')\', $values );');
		$this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.') values ('.$this->getParams().')\', $values );');
		$this->addLine(TAB.'}');
		//FIM INSERT

		// EXCLUIR
		$this->addLine();
		$this->addLine(TAB.'public static function delete( $id )');
		$this->addLine(TAB.'{');
		$this->addLine(TAB.TAB.'$values = array($id);');
		$this->addLine(TAB.TAB.'return self::executeSql(\'delete from '.$this->getTableName().' where '.$this->keyColumnName.' = '.$this->charParam.'\',$values);');
		$this->addLine(TAB.'}');
		$this->addLine();
		//FIM excluir


		// select
		$this->addLine(TAB.'public static function select( $id )');
		$this->addLine(TAB.'{');
		$this->addLine(TAB.TAB.'$values = array($id);');
		$this->addLine(TAB.TAB.'return self::executeSql(\'select');
		foreach($this->getColumns() as $k=>$v)
		{
			$this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.( $k==0 ? ' ' : ',').$v);
		}
		$this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.'from '.$this->getTableName().' where '.$this->keyColumnName.' = '.$this->charParam.'\', $values );');
		$this->addLine(TAB.'}');
		$this->addLine();
		// fim select


		// select where
		$this->addLine(TAB.'public static function selectAll( $orderBy=null, $where=null )');
		$this->addLine(TAB.'{');
		$this->addLine(TAB.TAB.'return self::executeSql(\'select');
		foreach($this->getColumns() as $k=>$v)
		{
			$this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.( $k==0 ? ' ' : ',').$v);
		}
		$this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.'from '.$this->getTableName().'\'.');
		$this->addLine(TAB.TAB.'( ($where)? \' where \'.$where:\'\').');
		$this->addLine(TAB.TAB.'( ($orderBy) ? \' order by \'.$orderBy:\'\'));');
		$this->addLine(TAB.'}');
		$this->addLine();
		// fim select

		// update
		$this->addLine(TAB.'public static function update ( '.ucfirst($this->tableName).'VO $objVo )');
		$this->addLine(TAB.'{');
		$this->addLine(TAB.TAB.'$values = array(',false);
		$count=0;
		foreach($this->getColumns() as $k=>$v)
		{
			if( strtolower($v) != strtolower($this->keyColumnName))
			{
				$this->addLine(( $count==0 ? ' ' : TAB.TAB.TAB.TAB.TAB.TAB.',').'$objVo->get'.ucfirst($v).'()');
				$count++;
			}
		}
		$this->addline(TAB.TAB.TAB.TAB.TAB.TAB.',$objVo->get'.ucfirst($this->keyColumnName).'() );');
		$this->addLine(TAB.TAB.'return self::executeSql(\'update '.$this->getTableName().' set ');
		$count=0;
		foreach($this->getColumns() as $k=>$v)
		{

			if( strtolower($v) != strtolower($this->keyColumnName))
			{
				$param = $this->bdType=='POSTGRES' ? '$'.($count+1) : '?';
				$this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.( $count==0 ? ' ' : ',').$v.' = '.$param);
				$count++;
			}
		}
		$param = $this->bdType=='POSTGRES' ? '$'.($count+1) : '?';
		$this->addLine(TAB.TAB.TAB.TAB.TAB.TAB.TAB.TAB.'where '.$this->keyColumnName.' = '.$param.'\',$values);');
		$this->addLine(TAB.'}');
		$this->addLine();



		//-------- FIM
		$this->addLine("}");
		$this->addLine("?>");
		if( $print)
		{
			echo trim(implode($this->lines));
		}
		else
		{
			return trim(implode($this->lines));
		}
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