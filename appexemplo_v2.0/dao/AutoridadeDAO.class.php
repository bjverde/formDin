<?php
class AutoridadeDAO extends TPDOConnection
{
	public function autoridadeDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( AutoridadeVO $objVo )
	{
		if( $objVo->getIdautoridade() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getDat_inclusao() 
						, $objVo->getDat_inicio() 
						, $objVo->getDat_fim() 
						, $objVo->getCargo() 
						, $objVo->getNome_pessoa() 
						, $objVo->getOrdem() 
						);
		return self::executeSql('insert into autoridade(
								 dat_inclusao
								,dat_inicio
								,dat_fim
								,cargo
								,nome_pessoa
								,ordem
								) values (?,?,?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from autoridade where idautoridade = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 idautoridade
								,dat_inclusao
								,dat_inicio
								,dat_fim
								,cargo
								,nome_pessoa
								,ordem
								from autoridade where idautoridade = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 idautoridade
								,dat_inclusao
								,dat_inicio
								,dat_fim
								,cargo
								,nome_pessoa
								,ordem
								from autoridade'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( AutoridadeVO $objVo )
	{
		$values = array( $objVo->getDat_inclusao()
						,$objVo->getDat_inicio()
						,$objVo->getDat_fim()
						,$objVo->getCargo()
						,$objVo->getNome_pessoa()
						,$objVo->getOrdem()
						,$objVo->getIdautoridade() );
		return self::executeSql('update autoridade set 
								 dat_inclusao = ?
								,dat_inicio = ?
								,dat_fim = ?
								,cargo = ?
								,nome_pessoa = ?
								,ordem = ?
								where idautoridade = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>