<?php
class Tb_textoDAO extends TPDOConnection
{

    private static $sqlBasicSelect = 'select
									  idtexto
									 ,txnome
									 ,txdata
									 ,stativo
									 ,texto
									 ,tx_data_inclusao
									 from tb_texto ';

    private static function processWhereGridParameters($whereGrid)
    {
        $result = $whereGrid;
        if (is_array($whereGrid)) {
            $where = ' 1=1 ';
            $where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid, 'IDTEXTO', ' AND IDTEXTO like \'%'.$whereGrid['IDTEXTO'].'%\' ', null) );
            $where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid, 'TXNOME', ' AND TXNOME like \'%'.$whereGrid['TXNOME'].'%\' ', null) );
            $where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid, 'TXDATA', ' AND TXDATA like \'%'.$whereGrid['TXDATA'].'%\' ', null) );
            $where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid, 'STATIVO', ' AND STATIVO like \'%'.$whereGrid['STATIVO'].'%\' ', null) );
            $where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid, 'TEXTO', ' AND TEXTO like \'%'.$whereGrid['TEXTO'].'%\' ', null) );
            $where = $where.( paginationSQLHelper::attributeIssetOrNotZero($whereGrid, 'TX_DATA_INCLUSAO', ' AND TX_DATA_INCLUSAO like \'%'.$whereGrid['TX_DATA_INCLUSAO'].'%\' ', null) );
            $result = $where;
        }
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function selectById($id)
    {
        $values = array($id);
        $sql = self::$sqlBasicSelect.' where idtexto = ?';
        $result = self::executeSql($sql, $values);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function selectCount($where = null)
    {
        $where = self::processWhereGridParameters($where);
        $sql = 'select count(idtexto) as qtd from tb_texto';
        $sql = $sql.( ($where)? ' where '.$where:'');
        $result = self::executeSql($sql);
        return $result['QTD'][0];
    }
    //--------------------------------------------------------------------------------
    public static function selectAll($orderBy = null, $where = null)
    {
        $where = self::processWhereGridParameters($where);
        $sql = self::$sqlBasicSelect
        .( ($where)? ' where '.$where:'')
        .( ($orderBy) ? ' order by '.$orderBy:'');

        $result = self::executeSql($sql);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function insert(Tb_textoVO $objVo)
    {
        if ($objVo->getIdtexto()) {
            return self::update($objVo);
        }
        $values = array(  $objVo->getTxnome()
                        , $objVo->getTxdata()
                        , $objVo->getStativo()
                        , $objVo->getTexto()
                        );
        return self::executeSql('insert into tb_texto(
								 txnome
								,txdata
								,stativo
								,texto
								) values (?,?,?,?)', $values);
    }
    //--------------------------------------------------------------------------------
    public static function update(Tb_textoVO $objVo)
    {
        $values = array( $objVo->getTxnome()
                        ,$objVo->getTxdata()
                        ,$objVo->getStativo()
                        ,$objVo->getTexto()
                        ,$objVo->getIdtexto() );
        return self::executeSql('update tb_texto set 
								 txnome = ?
								,txdata = ?
								,stativo = ?
								,texto = ?
								where idtexto = ?', $values);
    }
    //--------------------------------------------------------------------------------
    public static function delete($id)
    {
        $values = array($id);
        return self::executeSql('delete from tb_texto where idtexto = ?', $values);
    }
}
