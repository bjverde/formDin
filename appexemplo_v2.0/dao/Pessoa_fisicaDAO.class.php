<?php
class Pessoa_fisicaDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  idpessoa_fisica
									 ,idpessoa
									 ,cpf
									 ,dat_nascimento
									 ,cod_municipio_nascimento
									 ,dat_inclusao
									 ,dat_alteracao
									 from form_exemplo.pessoa_fisica ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDPESSOA_FISICA', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDPESSOA', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'CPF', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'DAT_NASCIMENTO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'COD_MUNICIPIO_NASCIMENTO', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'DAT_INCLUSAO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'DAT_ALTERACAO', SqlHelper::SQL_TYPE_TEXT_LIKE);
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
		$sql = self::$sqlBasicSelect.' where idpessoa_fisica = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(idpessoa_fisica) as qtd from form_exemplo.pessoa_fisica';
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
	public static function insert( Pessoa_fisicaVO $objVo ) {
		$values = array(  $objVo->getIdpessoa() 
						, $objVo->getCpf() 
						, $objVo->getDat_nascimento() 
						, $objVo->getCod_municipio_nascimento() 
						, $objVo->getDat_inclusao() 
						, $objVo->getDat_alteracao() 
						);
		return self::executeSql('insert into form_exemplo.pessoa_fisica(
								 idpessoa
								,cpf
								,dat_nascimento
								,cod_municipio_nascimento
								,dat_inclusao
								,dat_alteracao
								) values (?,?,?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( Pessoa_fisicaVO $objVo ) {
		$values = array( $objVo->getIdpessoa()
						,$objVo->getCpf()
						,$objVo->getDat_nascimento()
						,$objVo->getCod_municipio_nascimento()
						,$objVo->getDat_inclusao()
						,$objVo->getDat_alteracao()
						,$objVo->getIdpessoa_fisica() );
		return self::executeSql('update form_exemplo.pessoa_fisica set 
								 idpessoa = ?
								,cpf = ?
								,dat_nascimento = ?
								,cod_municipio_nascimento = ?
								,dat_inclusao = ?
								,dat_alteracao = ?
								where idpessoa_fisica = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.pessoa_fisica where idpessoa_fisica = ?',$values);
	}
}
?>