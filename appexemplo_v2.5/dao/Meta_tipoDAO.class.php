<?php
class Meta_tipoDAO extends TPDOConnection {

	const PRODUTO = 3;
	const PAGAMENTO = 4;

	private static $sqlBasicSelect = 'select
									  idmetatipo
									 ,descricao
									 ,sit_ativo
									 from form_exemplo.meta_tipo ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDMETATIPO', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'DESCRICAO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'SIT_ATIVO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$result = $where;
		}
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectById( $id ) {
		$values = array($id);
		$sql = self::$sqlBasicSelect.' where idMetaTipo = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(idMetaTipo) as qtd from form_exemplo.meta_tipo';
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
	public static function insert( Meta_tipoVO $objVo ) {
		$values = array(  $objVo->getDescricao() 
						, $objVo->getSit_ativo() 
						);
		return self::executeSql('insert into form_exemplo.meta_tipo(
								 descricao
								,sit_ativo
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( Meta_tipoVO $objVo ) {
		$values = array( $objVo->getDescricao()
						,$objVo->getSit_ativo()
						,$objVo->getIdMetaTipo() );
		return self::executeSql('update form_exemplo.meta_tipo set 
								 descricao = ?
								,sit_ativo = ?
								where idMetaTipo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.meta_tipo where idMetaTipo = ?',$values);
	}
}
?>