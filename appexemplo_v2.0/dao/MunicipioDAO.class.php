<?php
class MunicipioDAO extends TPDOConnection
{

    private static $sqlBasicSelect = 'select
									  m.cod_municipio
									 ,m.cod_uf
									 ,(select sig_uf from uf where cod_uf = m.cod_uf) as sig_uf
									 ,m.nom_municipio
									 ,m.sit_ativo
									 from municipio m';


    public static function selectCount($where = null)
    {
        $sql = 'select count(cod_municipio) as qtd from municipio';
        $sql = $sql.( ($where)? ' where '.$where:'');
        $result = self::executeSql($sql);
        return $result['QTD'][0];
    }
    //--------------------------------------------------------------------------------
    public static function select($id)
    {
        $values = array($id);
        $sql = self::$sqlBasicSelect.' where cod_municipio = ?';
        $result = self::executeSql($sql, $values);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public static function selectAllSqlPagination($orderBy = null, $where = null, $page = null, $rowsPerPage = null)
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
    public static function insert(MunicipioVO $objVo)
    {
        if ($objVo->getCod_municipio()) {
            return self::update($objVo);
        }
        $values = array(  $objVo->getCod_uf()
         , $objVo->getNom_municipio()
         , $objVo->getSit_ativo()
         );
        return self::executeSql(
            'insert into municipio(
								 cod_uf
								,nom_municipio
								,sit_ativo
								) values (?,?,?)',
            $values
        );
    }
    //--------------------------------------------------------------------------------
    public static function update(MunicipioVO $objVo)
    {
        $values = array( $objVo->getCod_uf()
         ,$objVo->getNom_municipio()
         ,$objVo->getSit_ativo()
         ,$objVo->getCod_municipio() );
        return self::executeSql(
            'update municipio set 
								 cod_uf = ?
								,nom_municipio = ?
								,sit_ativo = ?
								where cod_municipio = ?',
            $values
        );
    }
    //--------------------------------------------------------------------------------
    public static function delete($id)
    {
        $values = array($id);
        return self::executeSql('delete from municipio where cod_municipio = ?', $values);
    }
}
