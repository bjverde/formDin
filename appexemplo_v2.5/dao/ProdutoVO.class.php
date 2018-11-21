<?php
class ProdutoVO {
	private $idproduto = null;
	private $nom_produto = null;
	private $modelo = null;
	private $versao = null;
	private $marca_idmarca = null;
	public function __construct( $idproduto=null, $nom_produto=null, $modelo=null, $versao=null, $marca_idmarca=null ) {
		$this->setIdproduto( $idproduto );
		$this->setNom_produto( $nom_produto );
		$this->setModelo( $modelo );
		$this->setVersao( $versao );
		$this->setMarca_idmarca( $marca_idmarca );
	}
	//--------------------------------------------------------------------------------
	public function setIdproduto( $strNewValue = null )
	{
		$this->idproduto = $strNewValue;
	}
	public function getIdproduto()
	{
		return $this->idproduto;
	}
	//--------------------------------------------------------------------------------
	public function setNom_produto( $strNewValue = null )
	{
		$this->nom_produto = $strNewValue;
	}
	public function getNom_produto()
	{
		return $this->nom_produto;
	}
	//--------------------------------------------------------------------------------
	public function setModelo( $strNewValue = null )
	{
		$this->modelo = $strNewValue;
	}
	public function getModelo()
	{
		return $this->modelo;
	}
	//--------------------------------------------------------------------------------
	public function setVersao( $strNewValue = null )
	{
		$this->versao = $strNewValue;
	}
	public function getVersao()
	{
		return $this->versao;
	}
	//--------------------------------------------------------------------------------
	public function setMarca_idmarca( $strNewValue = null )
	{
		$this->marca_idmarca = $strNewValue;
	}
	public function getMarca_idmarca()
	{
		return $this->marca_idmarca;
	}
	//--------------------------------------------------------------------------------
}
?>