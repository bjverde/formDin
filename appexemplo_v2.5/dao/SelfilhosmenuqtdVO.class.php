<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.9.0-alpha
 * FormDin Version: 4.7.5
 * 
 * System appev2 created in: 2019-09-10 09:04:46
 */
class SelfilhosmenuqtdVO
{
    private $qtd = null;
    private $idmenu_pai = null;
    public function __construct( $qtd=null, $idmenu_pai=null ) {
        $this->setQtd( $qtd );
        $this->setIdmenu_pai( $idmenu_pai );
    }
    //--------------------------------------------------------------------------------
    public function setQtd( $strNewValue = null )
    {
        $this->qtd = $strNewValue;
    }
    public function getQtd()
    {
        return $this->qtd;
    }
    //--------------------------------------------------------------------------------
    public function setIdmenu_pai( $strNewValue = null )
    {
        $this->idmenu_pai = $strNewValue;
    }
    public function getIdmenu_pai()
    {
        return $this->idmenu_pai;
    }
    //--------------------------------------------------------------------------------
}
?>