<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGen: https://github.com/bjverde/sysgen
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * SysGen  Version: 1.9.0-alpha
 * FormDin Version: 4.7.5
 * 
 * System appev2 created in: 2019-09-10 09:04:47
 */
class Natureza_juridicaVO
{
    private $idnatureza_juridica = null;
    private $nom_natureza_juridicac = null;
    private $administradores = null;
    public function __construct( $idnatureza_juridica=null, $nom_natureza_juridicac=null, $administradores=null ) {
        $this->setIdnatureza_juridica( $idnatureza_juridica );
        $this->setNom_natureza_juridicac( $nom_natureza_juridicac );
        $this->setAdministradores( $administradores );
    }
    //--------------------------------------------------------------------------------
    public function setIdnatureza_juridica( $strNewValue = null )
    {
        $this->idnatureza_juridica = $strNewValue;
    }
    public function getIdnatureza_juridica()
    {
        return $this->idnatureza_juridica;
    }
    //--------------------------------------------------------------------------------
    public function setNom_natureza_juridicac( $strNewValue = null )
    {
        $this->nom_natureza_juridicac = $strNewValue;
    }
    public function getNom_natureza_juridicac()
    {
        return $this->nom_natureza_juridicac;
    }
    //--------------------------------------------------------------------------------
    public function setAdministradores( $strNewValue = null )
    {
        $this->administradores = $strNewValue;
    }
    public function getAdministradores()
    {
        return $this->administradores;
    }
    //--------------------------------------------------------------------------------
}
?>