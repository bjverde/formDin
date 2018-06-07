<?php
class Tipo_de_tiposDAO extends TPDOConnection
{

    public static function insert( Tipo_de_tiposVO $objVo )
    {
        if($objVo->getIdtipo_de_tipos() ) {
            return self::update($objVo);
        }
        $values = array(  $objVo->getDescricao() 
         , $objVo->getSit_ativo() 
         );
        return self::executeSql(
            'insert into tipo_de_tipos(
								 descricao
								,sit_ativo
								) values (?,?)', $values 
        );
    }
    //--------------------------------------------------------------------------------
    public static function delete( $id )
    {
        $values = array($id);
        return self::executeSql('delete from tipo_de_tipos where idtipo_de_tipos = ?', $values);
    }
    //--------------------------------------------------------------------------------
    public static function select( $id )
    {
        $values = array($id);
        return self::executeSql(
            'select
								 idtipo_de_tipos
								,descricao
								,sit_ativo
								from tipo_de_tipos where idtipo_de_tipos = ?', $values 
        );
    }
    //--------------------------------------------------------------------------------
    public static function selectAll( $orderBy=null, $where=null )
    {
        return self::executeSql(
            'select
								 idtipo_de_tipos
								,descricao
								,sit_ativo
								from tipo_de_tipos'.
            ( ($where)? ' where '.$where:'').
            ( ($orderBy) ? ' order by '.$orderBy:'')
        );
    }
    //--------------------------------------------------------------------------------
    public static function update( Tipo_de_tiposVO $objVo )
    {
        $values = array( $objVo->getDescricao()
         ,$objVo->getSit_ativo()
         ,$objVo->getIdtipo_de_tipos() );
        return self::executeSql(
            'update tipo_de_tipos set 
								 descricao = ?
								,sit_ativo = ?
								where idtipo_de_tipos = ?', $values
        );
    }
    //--------------------------------------------------------------------------------
}
?>
