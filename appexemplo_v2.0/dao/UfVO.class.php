<?php
class UfVO
{
	private $cod_uf = null;
	private $nom_uf = null;
	private $sig_uf = null;
	private $cod_regiao = null;
	public function UfVO( $cod_uf=null, $nom_uf=null, $sig_uf=null, $cod_regiao=null )
	{
		$this->setCod_uf( $cod_uf );
		$this->setNom_uf( $nom_uf );
		$this->setSig_uf( $sig_uf );
		$this->setCod_regiao( $cod_regiao );
	}
	//--------------------------------------------------------------------------------
	function setCod_uf( $strNewValue = null )
	{
		$this->cod_uf = $strNewValue;
	}
	function getCod_uf()
	{
		return $this->cod_uf;
	}
	//--------------------------------------------------------------------------------
	function setNom_uf( $strNewValue = null )
	{
		$this->nom_uf = $strNewValue;
	}
	function getNom_uf()
	{
		return $this->nom_uf;
	}
	//--------------------------------------------------------------------------------
	function setSig_uf( $strNewValue = null )
	{
		$this->sig_uf = $strNewValue;
	}
	function getSig_uf()
	{
		return $this->sig_uf;
	}
	//--------------------------------------------------------------------------------
	function setCod_regiao( $strNewValue = null )
	{
		$this->cod_regiao = $strNewValue;
	}
	function getCod_regiao()
	{
		return $this->cod_regiao;
	}
	//--------------------------------------------------------------------------------
}
?>