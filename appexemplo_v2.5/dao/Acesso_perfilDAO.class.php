<?php
class Acesso_perfilDAO extends TPDOConnection {

	public static function insert( Acesso_perfilVO $objVo )
	{
		if( $objVo->getIDPERFIL() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getIdperfil() 
						, $objVo->getNom_perfil() 
						, $objVo->getSit_ativo() 
						, $objVo->getDat_inclusao() 
						);
		return self::executeSql('insert into acesso_perfil(
								 idperfil
								,nom_perfil
								,sit_ativo
								,dat_inclusao
								) values (?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from acesso_perfil where IDPERFIL = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 idperfil
								,nom_perfil
								,sit_ativo
								,dat_inclusao
								from acesso_perfil where IDPERFIL = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 idperfil
								,nom_perfil
								,sit_ativo
								,dat_inclusao
								from acesso_perfil'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Acesso_perfilVO $objVo )
	{
		$values = array( $objVo->getNom_perfil()
						,$objVo->getSit_ativo()
						,$objVo->getDat_inclusao()
						,$objVo->getIDPERFIL() );
		return self::executeSql('update acesso_perfil set 
								 nom_perfil = ?
								,sit_ativo = ?
								,dat_inclusao = ?
								where IDPERFIL = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>