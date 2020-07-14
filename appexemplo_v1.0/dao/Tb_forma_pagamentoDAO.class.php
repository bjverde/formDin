<?php
class Tb_forma_pagamentoDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  idform_pagamento
									 ,descricao
									 from tb_forma_pagamento ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid,'IDFORM_PAGAMENTO',' AND IDFORM_PAGAMENTO like \'%'.$whereGrid['IDFORM_PAGAMENTO'].'%\' ',null) );
			$where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid,'DESCRICAO',' AND DESCRICAO like \'%'.$whereGrid['DESCRICAO'].'%\' ',null) );
			$result = $where;
		}
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectById( $id ) {
		$values = array($id);
		$sql = self::$sqlBasicSelect.' where idform_pagamento = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(idform_pagamento) as qtd from tb_forma_pagamento';
		$sql = $sql.( ($where)? ' where '.$where:'');
		$result = self::executeSql($sql);
		return $result['QTD'][0];
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
	public static function insert( Tb_forma_pagamentoVO $objVo ) {
		if( $objVo->getIdform_pagamento() ) {
			return self::update($objVo);
		}
		$values = array(  $objVo->getDescricao() 
						);
		return self::executeSql('insert into tb_forma_pagamento(
								 descricao
								) values (?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( Tb_forma_pagamentoVO $objVo ) {
		$values = array( $objVo->getDescricao()
						,$objVo->getIdform_pagamento() );
		return self::executeSql('update tb_forma_pagamento set 
								 descricao = ?
								where idform_pagamento = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from tb_forma_pagamento where idform_pagamento = ?',$values);
	}
}
?>