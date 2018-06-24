<?php
class Vw_pedido_treeDAO extends TPDOConnection
{

    private static $sqlBasicSelect = 'select
									  idparent
									 ,id
									 ,text
									 ,idgrupo
									 from vw_pedido_tree ';

    //--------------------------------------------------------------------------------
    public static function selectCount()
    {
        $sql = 'select count(idParent) as qtd from vw_pedido_tree';
        $result = self::executeSql($sql);
        return $result['QTD'][0];
    }
    //--------------------------------------------------------------------------------
    public static function selectById($id)
    {
        $values = array($id);
        $sql = self::$sqlBasicSelect.' where idParent = ?';
        $result = self::executeSql($sql, $values);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function selectAll($orderBy = null, $where = null)
    {
        $sql = self::$sqlBasicSelect
        .( ($where)? ' where '.$where:'')
        .( ($orderBy) ? ' order by '.$orderBy:'');

        $result = self::executeSql($sql);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function insert(Vw_pedido_treeVO $objVo)
    {
        if ($objVo->getIdParent()) {
            return self::update($objVo);
        }
        $values = array(  $objVo->getId()
                        , $objVo->getText()
                        , $objVo->getIdgrupo()
                        );
        return self::executeSql('insert into vw_pedido_tree(
								 id
								,text
								,idgrupo
								) values (?,?,?)', $values);
    }
    //--------------------------------------------------------------------------------
    public static function update(Vw_pedido_treeVO $objVo)
    {
        $values = array( $objVo->getId()
                        ,$objVo->getText()
                        ,$objVo->getIdgrupo()
                        ,$objVo->getIdParent() );
        return self::executeSql('update vw_pedido_tree set 
								 id = ?
								,text = ?
								,idgrupo = ?
								where idParent = ?', $values);
    }
    //--------------------------------------------------------------------------------
    public static function delete($id)
    {
        $values = array($id);
        return self::executeSql('delete from vw_pedido_tree where idParent = ?', $values);
    }
}
