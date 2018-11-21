<?php
class RegiaoVO {
	private $cod_regiao = null;
	private $nom_regiao = null;
	public function __construct( $cod_regiao=null, $nom_regiao=null ) {
		$this->setCod_regiao( $cod_regiao );
		$this->setNom_regiao( $nom_regiao );
	}
	//--------------------------------------------------------------------------------
	public function setCod_regiao( $strNewValue = null )
	{
		$this->cod_regiao = $strNewValue;
	}
	public function getCod_regiao()
	{
		return $this->cod_regiao;
	}
	//--------------------------------------------------------------------------------
	public function setNom_regiao( $strNewValue = null )
	{
		$this->nom_regiao = $strNewValue;
	}
	public function getNom_regiao()
	{
		return $this->nom_regiao;
	}
	//--------------------------------------------------------------------------------
}
?>