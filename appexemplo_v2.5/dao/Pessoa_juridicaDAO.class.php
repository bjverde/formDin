<?php
class Pessoa_juridicaDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  idpessoa_juridica
									 ,cnpj
									 ,idpessoa
									 from form_exemplo.pessoa_juridica ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDPESSOA_JURIDICA', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'CNPJ', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDPESSOA', SqlHelper::SQL_TYPE_NUMERIC);
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
		$sql = self::$sqlBasicSelect.' where idpessoa_juridica = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(idpessoa_juridica) as qtd from form_exemplo.pessoa_juridica';
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
	public static function insert( Pessoa_juridicaVO $objVo ) {
		$values = array(  $objVo->getCnpj() 
						, $objVo->getIdpessoa() 
						);
		return self::executeSql('insert into form_exemplo.pessoa_juridica(
								 cnpj
								,idpessoa
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( Pessoa_juridicaVO $objVo ) {
		$values = array( $objVo->getCnpj()
						,$objVo->getIdpessoa()
						,$objVo->getIdpessoa_juridica() );
		return self::executeSql('update form_exemplo.pessoa_juridica set 
								 cnpj = ?
								,idpessoa = ?
								where idpessoa_juridica = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.pessoa_juridica where idpessoa_juridica = ?',$values);
	}
}
?>