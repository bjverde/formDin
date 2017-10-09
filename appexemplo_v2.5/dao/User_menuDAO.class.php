<?php
class User_menuDAO extends TPDOConnection
{
	public function user_menuDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( User_menuVO $objVo )
	{
		if( $objVo->getIduser() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getLogin_user() 
						, $objVo->getIdperfil() 
						, $objVo->getNom_perfil() 
						, $objVo->getIdmenu() 
						, $objVo->getNom_menu() 
						);
		return self::executeSql('insert into user_menu(
								 login_user
								,idperfil
								,nom_perfil
								,idmenu
								,nom_menu
								) values (?,?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from user_menu where iduser = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 iduser
								,login_user
								,idperfil
								,nom_perfil
								,idmenu
								,nom_menu
								from user_menu where iduser = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 iduser
								,login_user
								,idperfil
								,nom_perfil
								,idmenu
								,nom_menu
								from user_menu'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( User_menuVO $objVo )
	{
		$values = array( $objVo->getLogin_user()
						,$objVo->getIdperfil()
						,$objVo->getNom_perfil()
						,$objVo->getIdmenu()
						,$objVo->getNom_menu()
						,$objVo->getIduser() );
		return self::executeSql('update user_menu set 
								 login_user = ?
								,idperfil = ?
								,nom_perfil = ?
								,idmenu = ?
								,nom_menu = ?
								where iduser = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>