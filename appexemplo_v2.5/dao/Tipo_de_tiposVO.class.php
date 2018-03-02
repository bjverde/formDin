<?php
class Tipo_de_tiposVO
{
	private $idtipo_de_tipos = null;
	private $descricao = null;
	private $sit_ativo = null;
	public function __construct( $idtipo_de_tipos=null, $descricao=null, $sit_ativo=null )
	{
		$this->setIdtipo_de_tipos( $idtipo_de_tipos );
		$this->setDescricao( $descricao );
		$this->setSit_ativo( $sit_ativo );
	}
	//--------------------------------------------------------------------------------
	function setIdtipo_de_tipos( $strNewValue = null )
	{
		$this->idtipo_de_tipos = $strNewValue;
	}
	function getIdtipo_de_tipos()
	{
		return $this->idtipo_de_tipos;
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
	function setSit_ativo( $strNewValue = null )
	{
		$this->sit_ativo = $strNewValue;
	}
	function getSit_ativo()
	{
		return $this->sit_ativo;
	}
	//--------------------------------------------------------------------------------
}
?>