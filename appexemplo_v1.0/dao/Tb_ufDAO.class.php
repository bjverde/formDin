<?php
class Tb_ufDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  cod_uf
									 ,sig_uf
									 ,nom_uf
									 ,cod_regiao
									 from tb_uf ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid,'COD_UF',' AND COD_UF like \'%'.$whereGrid['COD_UF'].'%\' ',null) );
			$where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid,'SIG_UF',' AND SIG_UF like \'%'.$whereGrid['SIG_UF'].'%\' ',null) );
			$where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid,'NOM_UF',' AND NOM_UF like \'%'.$whereGrid['NOM_UF'].'%\' ',null) );
			$where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid,'COD_REGIAO',' AND COD_REGIAO like \'%'.$whereGrid['COD_REGIAO'].'%\' ',null) );
			$result = $where;
		}
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectById( $id ) {
		$values = array($id);
		$sql = self::$sqlBasicSelect.' where cod_uf = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(cod_uf) as qtd from tb_uf';
		$sql = $sql.( ($where)? ' where '.$where:'');
		$result = self::executeSql($sql);
		return $result['QTD'][0];
	}
	//--------------------------------------------------------------------------------
	public static function selectComboSigUf() {
	    $sql = 'select sig_uf
					  ,nom_uf
					  ,cod_uf
					  ,cod_regiao
					   from tb_uf 
                order by nom_uf';
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
	public static function insert( Tb_ufVO $objVo ) {
		if( $objVo->getCod_uf() ) {
			return self::update($objVo);
		}
		$values = array(  $objVo->getSig_uf() 
						, $objVo->getNom_uf() 
						, $objVo->getCod_regiao() 
						);
		return self::executeSql('insert into tb_uf(
								 sig_uf
								,nom_uf
								,cod_regiao
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( Tb_ufVO $objVo ) {
		$values = array( $objVo->getSig_uf()
						,$objVo->getNom_uf()
						,$objVo->getCod_regiao()
						,$objVo->getCod_uf() );
		return self::executeSql('update tb_uf set 
								 sig_uf = ?
								,nom_uf = ?
								,cod_regiao = ?
								where cod_uf = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from tb_uf where cod_uf = ?',$values);
	}
}
?>