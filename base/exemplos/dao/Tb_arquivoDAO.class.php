<?php
class Tb_arquivoDAO extends TPDOConnection
{
	public function tb_arquivoDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public function insert( Tb_arquivoVO $objVo )
	{
		if( $objVo->getId_arquivo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getNome_arquivo()
						);
		// mover o arquivo para a pasta de armazenamento da aplicaзгo
		$origem = $objVo->getTempName();
		$destino = 'arquivos/'.$objVo->getNome_arquivo();
		if( copy($origem,$destino) )
		{

			return self::executeSql('insert into tb_arquivo(
									 nome_arquivo
									) values (?)', $values );
		}
	}
	//--------------------------------------------------------------------------------
	public function delete( $id )
	{
    	// recuperar o nome do arquivo para excluн-lo do disco
		$res = self::select($id);
		@unlink('arquivos/'.$res['NOME_ARQUIVO'][0]);
		$values = array($id);
		return self::executeSql('delete from tb_arquivo where id_arquivo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 id_arquivo
								,nome_arquivo
								from tb_arquivo where id_arquivo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 id_arquivo
								,nome_arquivo
								from tb_arquivo'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public function update ( Tb_arquivoVO $objVo )
	{
		$values = array( $objVo->getNome_arquivo()
						,$objVo->getId_arquivo() );
		return self::executeSql('update tb_arquivo set
								 nome_arquivo = ?
								where id_arquivo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>