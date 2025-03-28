<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.12.0
 * FormDin Version: 4.19.0
 * 
 * System appev2 created in: 2022-09-28 00:42:14
 */
class Uf
{


    private $dao = null;

    public function __construct($tpdo = null)
    {
        $this->dao = new UfDAO($tpdo);
    }
    public function getDao()
    {
        return $this->dao;
    }
    public function setDao($dao)
    {
        $this->dao = $dao;
    }
    //--------------------------------------------------------------------------------
    public function selectById( $id )
    {
        $result = $this->dao->selectById( $id );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectCount( $where=null )
    {
        $result = $this->dao->selectCount( $where );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectAllPagination( $orderBy=null, $where=null, $page=null,  $rowsPerPage= null)
    {
        $result = $this->dao->selectAllPagination( $orderBy, $where, $page,  $rowsPerPage );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function selectAll( $orderBy=null, $where=null )
    {
        $result = $this->dao->selectAll( $orderBy, $where );
        return $result;
    }
    //--------------------------------------------------------------------------------
    private function validatePkNotExist( $id )
    {
        $where=array('COD_UF'=>$id);
        $qtd = $this->selectCount($where);
        if( empty($qtd) ){
            throw new DomainException(Message::GENERIC_ID_NOT_EXIST);
        }
    }
    //--------------------------------------------------------------------------------
    public function save( UfVO $objVo )
    {
        $result = null;
        if( $objVo->getCod_uf() ) {
            $this->validatePkNotExist( $objVo->getCod_uf() );
            $result = $this->dao->update( $objVo );
        } else {
            $result = $this->dao->insert( $objVo );
        }
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function delete( $id )
    {
        $this->validatePkNotExist( $id );
        $result = $this->dao->delete( $id );
        return $result;
    }
    //--------------------------------------------------------------------------------
    public function getVoById( $id )
    {
        $result = $this->dao->getVoById( $id );
        return $result;
    }

}
?>