<?php
class Acesso_menuDAO extends TPDOConnection {

	public static function insert( Acesso_menuVO $objVo )
	{
		if( $objVo->getIdmenu() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getIdmenu_pai() 
						, $objVo->getNom_menu() 
						, $objVo->getUrl() 
						, $objVo->getTooltip() 
						, $objVo->getImg_menu() 
						, $objVo->getImgdisabled() 
						, $objVo->getDissabled() 
						, $objVo->getHotkey() 
						, $objVo->getBoolseparator() 
						, $objVo->getJsonparams() 
						, $objVo->getSit_ativo() 
						, $objVo->getDat_inclusao() 
						, $objVo->getDat_update() 
						);
		return self::executeSql('insert into acesso_menu(
								 idmenu_pai
								,nom_menu
								,url
								,tooltip
								,img_menu
								,imgdisabled
								,dissabled
								,hotkey
								,boolseparator
								,jsonparams
								,sit_ativo
								,dat_inclusao
								,dat_update
								) values (?,?,?,?,?,?,?,?,?,?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from acesso_menu where idmenu = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id ){
		$values = array($id);
		return self::executeSql('select
								 idmenu
								,idmenu_pai
								,nom_menu
								,url
								,tooltip
								,img_menu
								,imgdisabled
								,dissabled
								,hotkey
								,boolseparator
								,jsonparams
								,sit_ativo
								,dat_inclusao
								,dat_update
								from acesso_menu where idmenu = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectMenuByLogin( $login_user ){
		$values = array($login_user);
		$sql = 'select
				 m.idmenu
				,m.idmenu_pai
				,m.nom_menu
				,m.url
				,m.tooltip
				,m.img_menu
				,m.imgdisabled
				,m.dissabled
				,m.hotkey
				,m.boolseparator
				,m.jsonparams
				,m.sit_ativo
				,m.dat_inclusao
				,m.dat_update
				from acesso_menu as m 
					,acesso_user_menu as um 
				where um.idmenu = m.idmenu 
				AND um.login_user = ?';
		return self::executeSql($sql, $values );
	}	
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 idmenu
								,idmenu_pai
								,nom_menu
								,url
								,tooltip
								,img_menu
								,imgdisabled
								,dissabled
								,hotkey
								,boolseparator
								,jsonparams
								,sit_ativo
								,dat_inclusao
								,dat_update
								from acesso_menu'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Acesso_menuVO $objVo )
	{
		$values = array( $objVo->getIdmenu_pai()
						,$objVo->getNom_menu()
						,$objVo->getUrl()
						,$objVo->getTooltip()
						,$objVo->getImg_menu()
						,$objVo->getImgdisabled()
						,$objVo->getDissabled()
						,$objVo->getHotkey()
						,$objVo->getBoolseparator()
						,$objVo->getJsonparams()
						,$objVo->getSit_ativo()
						,$objVo->getDat_inclusao()
						,$objVo->getDat_update()
						,$objVo->getIdmenu() );
		return self::executeSql('update acesso_menu set 
								 idmenu_pai = ?
								,nom_menu = ?
								,url = ?
								,tooltip = ?
								,img_menu = ?
								,imgdisabled = ?
								,dissabled = ?
								,hotkey = ?
								,boolseparator = ?
								,jsonparams = ?
								,sit_ativo = ?
								,dat_inclusao = ?
								,dat_update = ?
								where idmenu = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>