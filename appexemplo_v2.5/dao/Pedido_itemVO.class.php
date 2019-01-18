<?php
class Pedido_itemVO {
	private $idpedido_item = null;
	private $idpedido = null;
	private $idproduto = null;
	private $qtd_unidade = null;
	private $preco = null;
	public function __construct( $idpedido_item=null, $idpedido=null, $idproduto=null, $qtd_unidade=null, $preco=null ) {
		$this->setIdpedido_item( $idpedido_item );
		$this->setIdpedido( $idpedido );
		$this->setIdproduto( $idproduto );
		$this->setQtd_unidade( $qtd_unidade );
		$this->setPreco( $preco );
	}
	//--------------------------------------------------------------------------------
	public function setIdpedido_item( $strNewValue = null )
	{
		$this->idpedido_item = $strNewValue;
	}
	public function getIdpedido_item()
	{
		return $this->idpedido_item;
	}
	//--------------------------------------------------------------------------------
	public function setIdpedido( $strNewValue = null )
	{
		$this->idpedido = $strNewValue;
	}
	public function getIdpedido()
	{
		return $this->idpedido;
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
	public function setQtd_unidade( $strNewValue = null )
	{
		$this->qtd_unidade = $strNewValue;
	}
	public function getQtd_unidade()
	{
		return $this->qtd_unidade;
	}
	//--------------------------------------------------------------------------------
	public function setPreco( $strNewValue = null )
	{
		$this->preco = $strNewValue;
	}
	public function getPreco()
	{
		return $this->preco;
	}
	//--------------------------------------------------------------------------------
}
?>