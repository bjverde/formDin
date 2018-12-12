<?php
class TelefoneDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  idtelefone
									 ,numero
									 ,idpessoa
									 ,idtipo_telefone
									 ,idendereco
									 ,sit_fixo
									 ,whastapp
									 ,telegram
									 from form_exemplo.telefone ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDTELEFONE', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'NUMERO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDPESSOA', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDTIPO_TELEFONE', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDENDERECO', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'SIT_FIXO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'WHASTAPP', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'TELEGRAM', SqlHelper::SQL_TYPE_TEXT_LIKE);
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
		$sql = self::$sqlBasicSelect.' where idtelefone = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(idtelefone) as qtd from form_exemplo.telefone';
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
	public static function insert( TelefoneVO $objVo ) {
		$values = array(  $objVo->getNumero() 
						, $objVo->getIdpessoa() 
						, $objVo->getIdtipo_telefone() 
						, $objVo->getIdendereco() 
						, $objVo->getSit_fixo() 
						, $objVo->getWhastapp() 
						, $objVo->getTelegram() 
						);
		return self::executeSql('insert into form_exemplo.telefone(
								 numero
								,idpessoa
								,idtipo_telefone
								,idendereco
								,sit_fixo
								,whastapp
								,telegram
								) values (?,?,?,?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( TelefoneVO $objVo ) {
		$values = array( $objVo->getNumero()
						,$objVo->getIdpessoa()
						,$objVo->getIdtipo_telefone()
						,$objVo->getIdendereco()
						,$objVo->getSit_fixo()
						,$objVo->getWhastapp()
						,$objVo->getTelegram()
						,$objVo->getIdtelefone() );
		return self::executeSql('update form_exemplo.telefone set 
								 numero = ?
								,idpessoa = ?
								,idtipo_telefone = ?
								,idendereco = ?
								,sit_fixo = ?
								,whastapp = ?
								,telegram = ?
								where idtelefone = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.telefone where idtelefone = ?',$values);
	}
}
?>