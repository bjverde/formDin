<?php
class UfDAO extends TPDOConnection
{

    private static $sqlBasicSelect = 'select
									  cod_uf
									 ,nom_uf
									 ,sig_uf
									 ,cod_regiao
									 from uf ';

    public static function selectCount()
    {
        $sql = 'select count(cod_uf) as qtd from uf';
        $result = self::executeSql($sql);
        return $result['QTD'][0];
    }
    //--------------------------------------------------------------------------------
    public static function select($id)
    {
        $values = array($id);
        $sql = self::$sqlBasicSelect.' where cod_uf = ?';
        $result = self::executeSql($sql, $values);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function selectAllPagination($orderBy = null, $where = null, $page = null, $rowsPerPage = null)
    {
        $rowStart = PaginationSQLHelper::getRowStart($page, $rowsPerPage);
        
        $sql = self::$sqlBasicSelect
        .( ($where)? ' where '.$where:'')
        .( ($orderBy) ? ' order by '.$orderBy:'')
        .( ' LIMIT '.$rowStart.','.$rowsPerPage);
        
        $result = self::executeSql($sql);
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
    public static function insert(UfVO $objVo)
    {
        if ($objVo->getCod_uf()) {
            return self::update($objVo);
        }
        $values = array(  $objVo->getNom_uf()
         , $objVo->getSig_uf()
         , $objVo->getCod_regiao()
         );
        return self::executeSql(
            'insert into uf(
								 nom_uf
								,sig_uf
								,cod_regiao
								) values (?,?,?)',
            $values
        );
    }
    //--------------------------------------------------------------------------------
    public static function update(UfVO $objVo)
    {
        $values = array( $objVo->getNom_uf()
         ,$objVo->getSig_uf()
         ,$objVo->getCod_regiao()
         ,$objVo->getCod_uf() );
        return self::executeSql(
            'update uf set 
								 nom_uf = ?
								,sig_uf = ?
								,cod_regiao = ?
								where cod_uf = ?',
            $values
        );
    }
    //--------------------------------------------------------------------------------
    public static function delete($id)
    {
        $values = array($id);
        return self::executeSql('delete from uf where cod_uf = ?', $values);
    }
}
