<?php
class RegiaoVO
{
	private $cod_regiao = null;
	private $nom_regiao = null;
	public function __construct( $cod_regiao=null, $nom_regiao=null )
	{
		$this->setCod_regiao( $cod_regiao );
		$this->setNom_regiao( $nom_regiao );
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
	function setNom_regiao( $strNewValue = null )
	{
		$this->nom_regiao = $strNewValue;
	}
	function getNom_regiao()
	{
		return $this->nom_regiao;
	}
	//--------------------------------------------------------------------------------
}
?>