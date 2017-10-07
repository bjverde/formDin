<?php
class Acesso_userDAO extends TPDOConnection
{
	public function acesso_userDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Acesso_userVO $objVo )
	{
		if( $objVo->getIduser() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getNom_user() 
						, $objVo->getPwd_user() 
						, $objVo->getSit_ativo() 
						, $objVo->getDat_inclusao() 
						, $objVo->getDat_update() 
						);
		return self::executeSql('insert into acesso_user(
								 nom_user
								,pwd_user
								,sit_ativo
								,dat_inclusao
								,dat_update
								) values (?,?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from acesso_user where iduser = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 iduser
								,nom_user
								,pwd_user
								,sit_ativo
								,dat_inclusao
								,dat_update
								from acesso_user where iduser = ?', $values );
	}
	public static function selectUser( $nom_user, $pwd_user)
	{
		$values = array($nom_user, $pwd_user);
		return self::executeSql('select
								 iduser
								,nom_user
								,pwd_user
								,sit_ativo
								,dat_inclusao
								,dat_update
								from acesso_user where nom_user = ? and pwd_user = ?', $values );
	}
	//--------------------------------------------------------------------------------	
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 iduser
								,nom_user
								,pwd_user
								,sit_ativo
								,dat_inclusao
								,dat_update
								from acesso_user'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Acesso_userVO $objVo )
	{
		$values = array( $objVo->getNom_user()
						,$objVo->getPwd_user()
						,$objVo->getSit_ativo()
						,$objVo->getDat_inclusao()
						,$objVo->getDat_update()
						,$objVo->getIduser() );
		return self::executeSql('update acesso_user set 
								 nom_user = ?
								,pwd_user = ?
								,sit_ativo = ?
								,dat_inclusao = ?
								,dat_update = ?
								where iduser = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>