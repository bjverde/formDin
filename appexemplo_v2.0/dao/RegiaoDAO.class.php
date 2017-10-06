<?php
class RegiaoDAO extends TPDOConnection
{
	public function regiaoDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( RegiaoVO $objVo )
	{
		if( $objVo->getCod_regiao() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getNom_regiao() 
						);
		return self::executeSql('insert into regiao(
								 nom_regiao
								) values (?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from regiao where cod_regiao = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 cod_regiao
								,nom_regiao
								from regiao where cod_regiao = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 cod_regiao
								,nom_regiao
								from regiao'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( RegiaoVO $objVo )
	{
		$values = array( $objVo->getNom_regiao()
						,$objVo->getCod_regiao() );
		return self::executeSql('update regiao set 
								 nom_regiao = ?
								where cod_regiao = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>