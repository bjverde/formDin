<?php
class Tb_municipioDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  cod_municipio
									 ,cod_uf
									 ,nom_municipio
									 from tb_municipio ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid,'COD_MUNICIPIO',' AND COD_MUNICIPIO like \'%'.$whereGrid['COD_MUNICIPIO'].'%\' ',null) );
			$where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid,'COD_UF',' AND COD_UF like \'%'.$whereGrid['COD_UF'].'%\' ',null) );
			$where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid,'NOM_MUNICIPIO',' AND NOM_MUNICIPIO like \'%'.$whereGrid['NOM_MUNICIPIO'].'%\' ',null) );
			$result = $where;
		}
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectById( $id ) {
		$values = array($id);
		$sql = self::$sqlBasicSelect.' where cod_municipio = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(cod_municipio) as qtd from tb_municipio';
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
	public static function insert( Tb_municipioVO $objVo ) {
		if( $objVo->getCod_municipio() ) {
			return self::update($objVo);
		}
		$values = array(  $objVo->getCod_uf() 
						, $objVo->getNom_municipio() 
						);
		return self::executeSql('insert into tb_municipio(
								 cod_uf
								,nom_municipio
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( Tb_municipioVO $objVo ) {
		$values = array( $objVo->getCod_uf()
						,$objVo->getNom_municipio()
						,$objVo->getCod_municipio() );
		return self::executeSql('update tb_municipio set 
								 cod_uf = ?
								,nom_municipio = ?
								where cod_municipio = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from tb_municipio where cod_municipio = ?',$values);
	}
}
?>