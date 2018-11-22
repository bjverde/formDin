<?php
class UfDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  cod_uf
									 ,nom_uf
									 ,sig_uf
									 ,cod_regiao
									 from form_exemplo.uf ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'COD_UF', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'NOM_UF', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'SIG_UF', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'COD_REGIAO', SqlHelper::SQL_TYPE_NUMERIC);
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
		$sql = self::$sqlBasicSelect.' where cod_uf = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(cod_uf) as qtd from form_exemplo.uf';
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
	public static function insert( UfVO $objVo ) {
		$values = array(  $objVo->getNom_uf() 
						, $objVo->getSig_uf() 
						, $objVo->getCod_regiao() 
						);
		return self::executeSql('insert into form_exemplo.uf(
								 nom_uf
								,sig_uf
								,cod_regiao
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( UfVO $objVo ) {
		$values = array( $objVo->getNom_uf()
						,$objVo->getSig_uf()
						,$objVo->getCod_regiao()
						,$objVo->getCod_uf() );
		return self::executeSql('update form_exemplo.uf set 
								 nom_uf = ?
								,sig_uf = ?
								,cod_regiao = ?
								where cod_uf = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.uf where cod_uf = ?',$values);
	}
}
?>