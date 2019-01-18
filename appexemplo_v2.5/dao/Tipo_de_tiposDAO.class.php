<?php
class Tipo_de_tiposDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  idtipo_de_tipos
									 ,descricao
									 ,sit_ativo
									 from form_exemplo.tipo_de_tipos ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDTIPO_DE_TIPOS', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'DESCRICAO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'SIT_ATIVO', SqlHelper::SQL_TYPE_TEXT_LIKE);
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
		$sql = self::$sqlBasicSelect.' where idtipo_de_tipos = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(idtipo_de_tipos) as qtd from form_exemplo.tipo_de_tipos';
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
	public static function insert( Tipo_de_tiposVO $objVo ) {
		$values = array(  $objVo->getDescricao() 
						, $objVo->getSit_ativo() 
						);
		return self::executeSql('insert into form_exemplo.tipo_de_tipos(
								 descricao
								,sit_ativo
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( Tipo_de_tiposVO $objVo ) {
		$values = array( $objVo->getDescricao()
						,$objVo->getSit_ativo()
						,$objVo->getIdtipo_de_tipos() );
		return self::executeSql('update form_exemplo.tipo_de_tipos set 
								 descricao = ?
								,sit_ativo = ?
								where idtipo_de_tipos = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.tipo_de_tipos where idtipo_de_tipos = ?',$values);
	}
}
?>