<?php
class Acesso_menuDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  idmenu
									 ,nom_menu
									 ,idmenu_pai
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
									 from form_exemplo.acesso_menu ';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDMENU', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'NOM_MENU', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDMENU_PAI', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'URL', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'TOOLTIP', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IMG_MENU', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IMGDISABLED', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'DISSABLED', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'HOTKEY', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'BOOLSEPARATOR', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'JSONPARAMS', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'SIT_ATIVO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'DAT_INCLUSAO', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'DAT_UPDATE', SqlHelper::SQL_TYPE_TEXT_LIKE);
			$result = $where;
		}
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectById( $id ) {
		if( empty($id) || !is_numeric($id) ){
			throw new InvalidArgumentException();
		}
		$values = array($id);
		$sql = self::$sqlBasicSelect.' where idmenu = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(idmenu) as qtd from form_exemplo.acesso_menu';
		$sql = $sql.( ($where)? ' where '.$where:'');
		$result = self::executeSql($sql);
		return $result['QTD'][0];
	}
	//--------------------------------------------------------------------------------
	public static function selectAllPagination( $orderBy=null, $where=null, $page=null,  $rowsPerPage= null ) {
		$rowStart = PaginationSQLHelper::getRowStart($page,$rowsPerPage);
		$where = self::processWhereGridParameters($where);

		$sql = self::$sqlBasicSelect
		.( ($where)? ' where '.$where:'')
		.( ($orderBy) ? ' order by '.$orderBy:'')
		.( ' LIMIT '.$rowStart.','.$rowsPerPage);

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
	public static function selectMenuByLogin( $login_user )
	{
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
	    return self::executeSql($sql, $values);
	} 
	//--------------------------------------------------------------------------------
	public static function insert( Acesso_menuVO $objVo ) {
		$values = array(  $objVo->getNom_menu() 
						, $objVo->getIdmenu_pai() 
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
		return self::executeSql('insert into form_exemplo.acesso_menu(
								 nom_menu
								,idmenu_pai
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
	public static function update ( Acesso_menuVO $objVo ) {
		$values = array( $objVo->getNom_menu()
						,$objVo->getIdmenu_pai()
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
		return self::executeSql('update form_exemplo.acesso_menu set 
								 nom_menu = ?
								,idmenu_pai = ?
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
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.acesso_menu where idmenu = ?',$values);
	}
}
?>