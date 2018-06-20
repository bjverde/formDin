<?php
class Tb_arquivoVO
{
	private $id_arquivo = null;
	private $nome_arquivo = null;
	private $tempName = null;

	public function __construct( $id_arquivo=null, $nome_arquivo=null ) {
		$this->setId_arquivo( $id_arquivo );
		$this->setNome_arquivo( $nome_arquivo );
	}
	//--------------------------------------------------------------------------------
	function setId_arquivo( $strNewValue = null ) {
		$this->id_arquivo = $strNewValue;
	}
	function getId_arquivo()
	{
		return $this->id_arquivo;
	}
	//--------------------------------------------------------------------------------
	function setNome_arquivo( $strNewValue = null )
	{
		$this->nome_arquivo = $strNewValue;
	}
	function getNome_arquivo()
	{
		return $this->nome_arquivo;
	}
	//--------------------------------------------------------------------------------
		//--------------------------------------------------------------------------------
	function setTempName($strNewValue=null)
	{
		$this->tempName = $strNewValue;
	}
	function getTempName()
	{
		return $this->tempName;
	}
}
?>