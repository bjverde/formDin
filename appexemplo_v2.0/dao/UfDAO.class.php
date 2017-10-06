<?php
class UfDAO extends TPDOConnection
{
	public function ufDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( UfVO $objVo )
	{
		if( $objVo->getCod_uf() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getNom_uf() 
						, $objVo->getSig_uf() 
						, $objVo->getCod_regiao() 
						);
		return self::executeSql('insert into uf(
								 nom_uf
								,sig_uf
								,cod_regiao
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from uf where cod_uf = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 cod_uf
								,nom_uf
								,sig_uf
								,cod_regiao
								from uf where cod_uf = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 cod_uf
								,nom_uf
								,sig_uf
								,cod_regiao
								from uf'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( UfVO $objVo )
	{
		$values = array( $objVo->getNom_uf()
						,$objVo->getSig_uf()
						,$objVo->getCod_regiao()
						,$objVo->getCod_uf() );
		return self::executeSql('update uf set 
								 nom_uf = ?
								,sig_uf = ?
								,cod_regiao = ?
								where cod_uf = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>