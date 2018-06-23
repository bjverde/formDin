<?php
class Tb_textoVO {
	private $idtexto = null;
	private $txnome = null;
	private $txdata = null;
	private $stativo = null;
	private $texto = null;
	private $tx_data_inclusao = null;
	public function __construct( $idtexto=null, $txnome=null, $txdata=null, $stativo=null, $texto=null, $tx_data_inclusao=null ) {
		$this->setIdtexto( $idtexto );
		$this->setTxnome( $txnome );
		$this->setTxdata( $txdata );
		$this->setStativo( $stativo );
		$this->setTexto( $texto );
		$this->setTx_data_inclusao( $tx_data_inclusao );
	}
	//--------------------------------------------------------------------------------
	function setIdtexto( $strNewValue = null )
	{
		$this->idtexto = $strNewValue;
	}
	function getIdtexto()
	{
		return $this->idtexto;
	}
	//--------------------------------------------------------------------------------
	function setTxnome( $strNewValue = null )
	{
		$this->txnome = $strNewValue;
	}
	function getTxnome()
	{
		return $this->txnome;
	}
	//--------------------------------------------------------------------------------
	function setTxdata( $strNewValue = null )
	{
		$this->txdata = $strNewValue;
	}
	function getTxdata()
	{
		return $this->txdata;
	}
	//--------------------------------------------------------------------------------
	function setStativo( $strNewValue = null )
	{
		$this->stativo = $strNewValue;
	}
	function getStativo()
	{
		return $this->stativo;
	}
	//--------------------------------------------------------------------------------
	function setTexto( $strNewValue = null )
	{
		$this->texto = $strNewValue;
	}
	function getTexto()
	{
		return $this->texto;
	}
	//--------------------------------------------------------------------------------
	function setTx_data_inclusao( $strNewValue = null )
	{
		$this->tx_data_inclusao = $strNewValue;
	}
	function getTx_data_inclusao()
	{
		return $this->tx_data_inclusao;
	}
	//--------------------------------------------------------------------------------
}
?>