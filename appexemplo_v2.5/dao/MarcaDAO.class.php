<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.9.0-alpha
 * FormDin Version: 4.7.5
 * 
 * System appev2 created in: 2019-09-10 11:31:30
 */
class MarcaDAO 
{

    private static $sqlBasicSelect = 'select
                                      idmarca
                                     ,nom_marca
                                     ,idpessoa
                                     ,( select p.nome from form_exemplo.pessoa as p where p.idpessoa = m.idpessoa ) as nom_pessoa
                                     from form_exemplo.marca as m';

    private $tpdo = null;

    public function __construct($tpdo=null)
    {
        $this->validateObjType($tpdo);
        if( empty($tpdo) ){
            $tpdo = New TPDOConnectionObj();
        }
        $this->setTPDOConnection($tpdo);
    }
    public function getTPDOConnection()
    {
        return $this->tpdo;
    }
    public function setTPDOConnection($tpdo)
    {
        $this->validateObjType($tpdo);
        $this->tpdo = $tpdo;
    }
    public function validateObjType($tpdo)
    {
        $typeObjWrong = !($tpdo instanceof TPDOConnectionObj);
        if( !is_null($tpdo) && $typeObjWrong ){
            throw new InvalidArgumentException('class:'.__METHOD__);
        }
    }
    private function processWhereGridParameters( $whereGrid )
    {
        $result = $whereGrid;
        if ( is_array($whereGrid) ){
            $where = ' 1=1 ';
            $where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDMARCA', SqlHelper::SQL_TYPE_NUMERIC);
            $where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'NOM_MARCA', SqlHelper::SQL_TYPE_TEXT_LIKE);
            $where = SqlHelper::getAtributeWhereGridParameters($where, $whereGrid, 'IDPESSOA', SqlHelper::SQL_TYPE_NUMERIC);
            $result = $where;
        }
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectById( $id )
    {
        if( empty($id) || !is_numeric($id) ){
            throw new InvalidArgumentException(Message::TYPE_NOT_INT.'class:'.__METHOD__);
        }
        $values = array($id);
        $sql = self::$sqlBasicSelect.' where idmarca = ?';
        $result = $this->tpdo->executeSql($sql, $values);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectCount( $where=null )
    {
        $where = $this->processWhereGridParameters($where);
        $sql = 'select count(idmarca) as qtd from form_exemplo.marca';
        $sql = $sql.( ($where)? ' where '.$where:'');
        $result = $this->tpdo->executeSql($sql);
        return $result['QTD'][0];
    }
    //--------------------------------------------------------------------------------
    public function selectAllPagination( $orderBy=null, $where=null, $page=null,  $rowsPerPage= null )
    {
        $rowStart = SqlHelper::getRowStart($page,$rowsPerPage);
        $where = $this->processWhereGridParameters($where);

        $sql = self::$sqlBasicSelect
        .( ($where)? ' where '.$where:'')
        .( ($orderBy) ? ' order by '.$orderBy:'')
        .( ' LIMIT '.$rowStart.','.$rowsPerPage);

        $result = $this->tpdo->executeSql($sql);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectAll( $orderBy=null, $where=null )
    {
        $where = $this->processWhereGridParameters($where);
        $sql = self::$sqlBasicSelect
        .( ($where)? ' where '.$where:'')
        .( ($orderBy) ? ' order by '.$orderBy:'');

        $result = $this->tpdo->executeSql($sql);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function insert( MarcaVO $objVo )
    {
        $values = array(  $objVo->getNom_marca() 
                        , $objVo->getIdpessoa() 
                        );
        $sql = 'insert into form_exemplo.marca(
                                 nom_marca
                                ,idpessoa
                                ) values (?,?)';
        $result = $this->tpdo->executeSql($sql, $values);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function update ( MarcaVO $objVo )
    {
        $values = array( $objVo->getNom_marca()
                        ,$objVo->getIdpessoa()
                        ,$objVo->getIdmarca() );
        $sql = 'update form_exemplo.marca set 
                                 nom_marca = ?
                                ,idpessoa = ?
                                where idmarca = ?';
        $result = $this->tpdo->executeSql($sql, $values);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function delete( $id )
    {
        if( empty($id) || !is_numeric($id) ){
            throw new InvalidArgumentException(Message::TYPE_NOT_INT.'class:'.__METHOD__);
        }
        $values = array($id);
        $sql = 'delete from form_exemplo.marca where idmarca = ?';
        $result = $this->tpdo->executeSql($sql, $values);
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function getVoById( $id )
    {
        if( empty($id) || !is_numeric($id) ){
            throw new InvalidArgumentException(Message::TYPE_NOT_INT.'class:'.__METHOD__);
        }
        $result = $this->selectById( $id );
        $result = \ArrayHelper::convertArrayFormDin2Pdo($result,false);
        $result = $result[0];
        $vo = new MarcaVO();
        $vo = \FormDinHelper::setPropertyVo($result,$vo);
        return $vo;
    }
}
?>