<?php
class Meta_tipoVO {
	private $idmetatipo = null;
	private $descricao = null;
	private $sit_ativo = null;
	public function __construct( $idmetatipo=null, $descricao=null, $sit_ativo=null ) {
		$this->setIdmetatipo( $idmetatipo );
		$this->setDescricao( $descricao );
		$this->setSit_ativo( $sit_ativo );
	}
	//--------------------------------------------------------------------------------
	public function setIdmetatipo( $strNewValue = null )
	{
		$this->idmetatipo = $strNewValue;
	}
	public function getIdmetatipo()
	{
		return $this->idmetatipo;
	}
	//--------------------------------------------------------------------------------
	public function setDescricao( $strNewValue = null )
	{
		$this->descricao = $strNewValue;
	}
	public function getDescricao()
	{
		return $this->descricao;
	}
	//--------------------------------------------------------------------------------
	public function setSit_ativo( $strNewValue = null )
	{
		$this->sit_ativo = $strNewValue;
	}
	public function getSit_ativo()
	{
		return $this->sit_ativo;
	}
	//--------------------------------------------------------------------------------
}
?>