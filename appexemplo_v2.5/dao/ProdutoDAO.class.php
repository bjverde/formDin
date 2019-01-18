<?php
class ProdutoDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  idproduto
									 ,nom_produto
									 ,modelo
									 ,versao
                                     ,idpessoa
                                     ,nom_pessoa
									 ,idmarca
                                     ,nom_marca
									 ,idtipo_produto
                                     ,nom_tipo
									 from (select
    									  p.idproduto
    									 ,p.nom_produto
    									 ,p.modelo
    									 ,p.versao
                                         ,vwpmp.idpessoa
                                         ,vwpmp.nome as nom_pessoa
    									 ,p.idmarca
                                         ,vwpmp.nom_marca
    									 ,p.idtipo_produto
                                         ,t.descricao as nom_tipo
    									 from form_exemplo.produto as p
                                             ,form_exemplo.vw_pessoa_marca_produto as vwpmp
                                             ,form_exemplo.tipo as t
                                         where p.idproduto = vwpmp.idproduto
                                         and t.idtipo =  p.idtipo_produto
                                     ) as res';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDPRODUTO', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'NOM_PRODUTO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'MODELO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'VERSAO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDMARCA', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDTIPO_PRODUTO', SqlHelper::SQL_TYPE_NUMERIC);
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
		$sql = self::$sqlBasicSelect.' where idproduto = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(idproduto) as qtd 	from (select
    									  p.idproduto
    									 ,p.nom_produto
    									 ,p.modelo
    									 ,p.versao
                                         ,vwpmp.idpessoa
                                         ,vwpmp.nome as nom_pessoa
    									 ,p.idmarca
                                         ,vwpmp.nom_marca
    									 ,p.idtipo_produto
                                         ,t.descricao as nom_tipo
    									 from form_exemplo.produto as p
                                             ,form_exemplo.vw_pessoa_marca_produto as vwpmp
                                             ,form_exemplo.tipo as t
                                         where p.idproduto = vwpmp.idproduto
                                         and t.idtipo =  p.idtipo_produto
                                     ) as res';
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
	public static function insert( ProdutoVO $objVo ) {
		$values = array(  $objVo->getNom_produto() 
						, $objVo->getModelo() 
						, $objVo->getVersao() 
						, $objVo->getIdmarca() 
						, $objVo->getIdtipo_produto() 
						);
		return self::executeSql('insert into form_exemplo.produto(
								 nom_produto
								,modelo
								,versao
								,idmarca
								,idtipo_produto
								) values (?,?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( ProdutoVO $objVo ) {
		$values = array( $objVo->getNom_produto()
						,$objVo->getModelo()
						,$objVo->getVersao()
						,$objVo->getIdmarca()
						,$objVo->getIdtipo_produto()
						,$objVo->getIdproduto() );
		return self::executeSql('update form_exemplo.produto set 
								 nom_produto = ?
								,modelo = ?
								,versao = ?
								,idmarca = ?
								,idtipo_produto = ?
								where idproduto = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.produto where idproduto = ?',$values);
	}
}
?>