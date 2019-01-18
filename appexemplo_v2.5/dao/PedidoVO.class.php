<?php
class PedidoVO {
	private $idpedido = null;
	private $idpessoa = null;
	private $idtipo_pagamento = null;
	private $dat_pedido = null;
	public function __construct( $idpedido=null, $idpessoa=null, $idtipo_pagamento=null, $dat_pedido=null ) {
		$this->setIdpedido( $idpedido );
		$this->setIdpessoa( $idpessoa );
		$this->setIdtipo_pagamento( $idtipo_pagamento );
		$this->setDat_pedido( $dat_pedido );
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
	public function setIdpessoa( $strNewValue = null )
	{
		$this->idpessoa = $strNewValue;
	}
	public function getIdpessoa()
	{
		return $this->idpessoa;
	}
	//--------------------------------------------------------------------------------
	public function setIdtipo_pagamento( $strNewValue = null )
	{
		$this->idtipo_pagamento = $strNewValue;
	}
	public function getIdtipo_pagamento()
	{
		return $this->idtipo_pagamento;
	}
	//--------------------------------------------------------------------------------
	public function setDat_pedido( $strNewValue = null )
	{
		$this->dat_pedido = $strNewValue;
	}
	public function getDat_pedido()
	{
		return is_null( $this->dat_pedido ) ? date( 'Y-m-d h:i:s' ) : $this->dat_pedido;
	}
	//--------------------------------------------------------------------------------
}
?>