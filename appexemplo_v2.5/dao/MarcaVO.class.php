<?php
class MarcaVO {
	private $idmarca = null;
	private $nom_marca = null;
	private $idpessoa = null;
	public function __construct( $idmarca=null, $nom_marca=null, $idpessoa=null ) {
		$this->setIdmarca( $idmarca );
		$this->setNom_marca( $nom_marca );
		$this->setIdpessoa( $idpessoa );
	}
	//--------------------------------------------------------------------------------
	public function setIdmarca( $strNewValue = null )
	{
		$this->idmarca = $strNewValue;
	}
	public function getIdmarca()
	{
		return $this->idmarca;
	}
	//--------------------------------------------------------------------------------
	public function setNom_marca( $strNewValue = null )
	{
		$this->nom_marca = $strNewValue;
	}
	public function getNom_marca()
	{
		return $this->nom_marca;
	}
	//--------------------------------------------------------------------------------
	public function setIdpessoa( $strNewValue = null )
	{
		$this->idpessoa = $strNewValue;
	}
	public function getIdpessoa()
	{
		return $this->idpessoa;
	}
	//--------------------------------------------------------------------------------
}
?>