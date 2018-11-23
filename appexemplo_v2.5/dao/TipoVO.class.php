<?php
class TipoVO {
	private $idtipo = null;
	private $descricao = null;
	private $idmeta_tipo = null;
	private $sit_ativo = null;
	public function __construct( $idtipo=null, $descricao=null, $idmeta_tipo=null, $sit_ativo=null ) {
		$this->setIdtipo( $idtipo );
		$this->setDescricao( $descricao );
		$this->setIdmeta_tipo( $idmeta_tipo );
		$this->setSit_ativo( $sit_ativo );
	}
	//--------------------------------------------------------------------------------
	public function setIdtipo( $strNewValue = null )
	{
		$this->idtipo = $strNewValue;
	}
	public function getIdtipo()
	{
		return $this->idtipo;
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
	public function setIdmeta_tipo( $strNewValue = null )
	{
		$this->idmeta_tipo = $strNewValue;
	}
	public function getIdmeta_tipo()
	{
		return $this->idmeta_tipo;
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