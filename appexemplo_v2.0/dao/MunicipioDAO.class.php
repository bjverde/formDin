<?php
class MunicipioDAO extends TPDOConnection
{
	public function municipioDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( MunicipioVO $objVo )
	{
		if( $objVo->getCod_municipio() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getCod_uf() 
						, $objVo->getNom_municipio() 
						, $objVo->getSit_ativo() 
						);
		return self::executeSql('insert into municipio(
								 cod_uf
								,nom_municipio
								,sit_ativo
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from municipio where cod_municipio = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 cod_municipio
								,cod_uf
								,nom_municipio
								,sit_ativo
								from municipio where cod_municipio = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 m.cod_municipio
								,m.cod_uf
								,(select sig_uf from uf where cod_uf = m.cod_uf) as sig_uf
								,m.nom_municipio
								,m.sit_ativo
								from municipio as m'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( MunicipioVO $objVo )
	{
		$values = array( $objVo->getCod_uf()
						,$objVo->getNom_municipio()
						,$objVo->getSit_ativo()
						,$objVo->getCod_municipio() );
		return self::executeSql('update municipio set 
								 cod_uf = ?
								,nom_municipio = ?
								,sit_ativo = ?
								where cod_municipio = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>