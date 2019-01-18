<?php
class Acesso_perfil_userDAO extends TPDOConnection {

	private static $sqlBasicSelect = 'select
									  idperfiluser
									 ,idperfil
									 ,(select p.nom_perfil from form_exemplo.acesso_perfil as p where p.idperfil = pu.idperfil) as nom_perfil
									 ,iduser
									 ,(select u.login_user from form_exemplo.acesso_user as u where u.iduser = pu.iduser) as login_user
									 ,sit_ativo
									 ,dat_inclusao
									 ,dat_update
									 from form_exemplo.acesso_perfil_user as pu';

	private static function processWhereGridParameters( $whereGrid ) {
		$result = $whereGrid;
		if ( is_array($whereGrid) ){
			$where = ' 1=1 ';
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDPERFILUSER', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDPERFIL', SqlHelper::SQL_TYPE_NUMERIC);
			$where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDUSER', SqlHelper::SQL_TYPE_NUMERIC);
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
		$sql = self::$sqlBasicSelect.' where idperfiluser = ?';
		$result = self::executeSql($sql, $values );
		return $result;
	}
	//--------------------------------------------------------------------------------
	public static function selectCount( $where=null ){
		$where = self::processWhereGridParameters($where);
		$sql = 'select count(idperfiluser) as qtd from form_exemplo.acesso_perfil_user';
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
	public static function insert( Acesso_perfil_userVO $objVo ) {
		$values = array(  $objVo->getIdperfil() 
						, $objVo->getIduser() 
						, $objVo->getSit_ativo() 
						, $objVo->getDat_inclusao() 
						, $objVo->getDat_update() 
						);
		return self::executeSql('insert into form_exemplo.acesso_perfil_user(
								 idperfil
								,iduser
								,sit_ativo
								,dat_inclusao
								,dat_update
								) values (?,?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function update ( Acesso_perfil_userVO $objVo ) {
		$values = array( $objVo->getIdperfil()
						,$objVo->getIduser()
						,$objVo->getSit_ativo()
						,$objVo->getDat_inclusao()
						,$objVo->getDat_update()
						,$objVo->getIdperfiluser() );
		return self::executeSql('update form_exemplo.acesso_perfil_user set 
								 idperfil = ?
								,iduser = ?
								,sit_ativo = ?
								,dat_inclusao = ?
								,dat_update = ?
								where idperfiluser = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id ){
		$values = array($id);
		return self::executeSql('delete from form_exemplo.acesso_perfil_user where idperfiluser = ?',$values);
	}
}
?>