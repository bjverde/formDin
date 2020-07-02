<?php
class Tb_forma_pagamentoVO {
	private $idform_pagamento = null;
	private $descricao = null;
	public function __construct( $idform_pagamento=null, $descricao=null ) {
		$this->setIdform_pagamento( $idform_pagamento );
		$this->setDescricao( $descricao );
	}
	//--------------------------------------------------------------------------------
	function setIdform_pagamento( $strNewValue = null )
	{
		$this->idform_pagamento = $strNewValue;
	}
	function getIdform_pagamento()
	{
		return $this->idform_pagamento;
	}
	//--------------------------------------------------------------------------------
	function setDescricao( $strNewValue = null )
	{
		$this->descricao = $strNewValue;
	}
	function getDescricao()
	{
		return $this->descricao;
	}
	//--------------------------------------------------------------------------------
}
?>