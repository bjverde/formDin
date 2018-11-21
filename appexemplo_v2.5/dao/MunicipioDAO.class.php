<?php
class MunicipioDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  m.cod_municipio
									 ,m.cod_uf
									 ,(select sig_uf from uf where cod_uf = m.cod_uf) as sig_uf
									 ,m.nom_municipio
									 ,m.sit_ativo
									 from form_exemplo.municipio as m';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'COD_MUNICIPIO', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'COD_UF', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'NOM_MUNICIPIO', SqlHelper::SQL_TYPE_TEXT_LIKE);
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
		$sql = self::$sqlBasicSelect.' where cod_municipio = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(cod_municipio) as qtd from form_exemplo.municipio';
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
	public static function insert( MunicipioVO $objVo ) {
		$values = array(  $objVo->getCod_uf() 
						, $objVo->getNom_municipio() 
						, $objVo->getSit_ativo() 
						);
		return self::executeSql('insert into form_exemplo.municipio(
								 cod_uf
								,nom_municipio
								,sit_ativo
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( MunicipioVO $objVo ) {
		$values = array( $objVo->getCod_uf()
						,$objVo->getNom_municipio()
						,$objVo->getSit_ativo()
						,$objVo->getCod_municipio() );
		return self::executeSql('update form_exemplo.municipio set 
								 cod_uf = ?
								,nom_municipio = ?
								,sit_ativo = ?
								where cod_municipio = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.municipio where cod_municipio = ?',$values);
	}
}
?>