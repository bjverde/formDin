<?php
class Vw_pedido_qtd_itensDAO extends TPDOConnection
{

    private static $sqlBasicSelect = 'select
									  id_pedido
									 ,data_pedido
									 ,nome_comprador
									 ,forma_pagamento
									 ,des_forma_pagamento
									 ,qtd
									 from vw_pedido_qtd_itens ';

    //--------------------------------------------------------------------------------
    public static function selectCount()
    {
        $sql = 'select count(id_pedido) as qtd from vw_pedido_qtd_itens';
        $result = self::executeSql($sql);
        return $result['QTD'][0];
    }
    //--------------------------------------------------------------------------------
    public static function selectById($id)
    {
        $values = array($id);
        $sql = self::$sqlBasicSelect.' where id_pedido = ?';
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
}
