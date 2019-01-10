<?php
class Natureza_juridicaDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  idnatureza_juridica
									 ,nom_natureza_juridicac
									 ,administradores
									 from form_exemplo.natureza_juridica ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDNATUREZA_JURIDICA', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'NOM_NATUREZA_JURIDICAC', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'ADMINISTRADORES', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$result = $where;
		}
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectById( $id ) {
		if( empty($id) || !is_numeric($id) ){
			throw new InvalidArgumentException();
		}
		$values = array($id);
		$sql = self::$sqlBasicSelect.' where idnatureza_juridica = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(idnatureza_juridica) as qtd from form_exemplo.natureza_juridica';
		$sql = $sql.( ($where)? ' where '.$where:'');
		$result = self::executeSql($sql);
		return $result['QTD'][0];
	}
	//--------------------------------------------------------------------------------
	public static function selectAllPagination( $orderBy=null, $where=null, $page=null,  $rowsPerPage= null ) {
		$rowStart = PaginationSQLHelper::getRowStart($page,$rowsPerPage);
		$where = self::processWhereGridParameters($where);

		$sql = self::$sqlBasicSelect
		.( ($where)? ' where '.$where:'')
		.( ($orderBy) ? ' order by '.$orderBy:'')
		.( ' LIMIT '.$rowStart.','.$rowsPerPage);

		$result = self::executeSql($sql);
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null ) {
		$where = self::processWhereGridParameters($where);
		$sql = self::$sqlBasicSelect
		.( ($where)? ' where '.$where:'')
		.( ($orderBy) ? ' order by '.$orderBy:'');

		$result = self::executeSql($sql);
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function insert( Natureza_juridicaVO $objVo ) {
		$values = array(  $objVo->getNom_natureza_juridicac() 
						, $objVo->getAdministradores() 
						);
		return self::executeSql('insert into form_exemplo.natureza_juridica(
								 nom_natureza_juridicac
								,administradores
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( Natureza_juridicaVO $objVo ) {
		$values = array( $objVo->getNom_natureza_juridicac()
						,$objVo->getAdministradores()
						,$objVo->getIdnatureza_juridica() );
		return self::executeSql('update form_exemplo.natureza_juridica set 
								 nom_natureza_juridicac = ?
								,administradores = ?
								where idnatureza_juridica = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.natureza_juridica where idnatureza_juridica = ?',$values);
	}
}
?>