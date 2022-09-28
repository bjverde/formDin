<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.12.0
 * FormDin Version: 4.19.0
 * 
 * System appev2 created in: 2022-09-28 00:42:12
 */
class Acesso_perfil_user
{


    private $dao = null;

    public function __construct($tpdo = null)
    {
        $this->dao = new Acesso_perfil_userDAO($tpdo);
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
    public function selectByIdUser( $idUser )
    {
        $where  = array ('IDUSER'=>$idUser);
        $result = $this->dao->selectAll( null, $where );
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
        $where=array('IDPERFILUSER'=>$id);
        $qtd = $this->selectCount($where);
        if( empty($qtd) ){
            throw new DomainException(Message::GENERIC_ID_NOT_EXIST);
        }
    }
    //--------------------------------------------------------------------------------
    public function save( Acesso_perfil_userVO $objVo )
    {
        $result = null;
        $objVo->setSit_ativo('S');
        if( $objVo->getIdperfiluser() ) {
            $this->validatePkNotExist( $objVo->getIdperfiluser() );
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
    public function deleteByIdUser( $id )
    {
        $result = $this->dao->deleteByIdUser( $id );
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