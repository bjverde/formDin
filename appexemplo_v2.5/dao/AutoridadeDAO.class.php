<?php
class AutoridadeDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  idautoridade
									 ,dat_inclusao
									 ,dat_evento
									 ,ordem
									 ,cargo
									 ,nome_pessoa
									 from form_exemplo.autoridade ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDAUTORIDADE', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'DAT_INCLUSAO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'DAT_EVENTO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'ORDEM', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'CARGO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'NOME_PESSOA', SqlHelper::SQL_TYPE_TEXT_LIKE);
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
		$sql = self::$sqlBasicSelect.' where idautoridade = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(idautoridade) as qtd from form_exemplo.autoridade';
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
	public static function insert( AutoridadeVO $objVo ) {
		$values = array(  $objVo->getDat_evento() 
						, $objVo->getOrdem() 
						, $objVo->getCargo() 
						, $objVo->getNome_pessoa() 
						);
		$sql = 'insert into form_exemplo.autoridade(
								 dat_evento
								,ordem
								,cargo
								,nome_pessoa
								) values (?,?,?,?)';
		$retorno = self::executeSql($sql, $values );
		return $retorno;
	}
	//--------------------------------------------------------------------------------
	public static function update ( AutoridadeVO $objVo ) {
		$values = array( $objVo->getDat_evento()
						,$objVo->getOrdem()
						,$objVo->getCargo()
						,$objVo->getNome_pessoa()
						,$objVo->getIdautoridade() );
		return self::executeSql('update form_exemplo.autoridade set 
								 dat_evento = ?
								,ordem = ?
								,cargo = ?
								,nome_pessoa = ?
								where idautoridade = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.autoridade where idautoridade = ?',$values);
	}
}
?>