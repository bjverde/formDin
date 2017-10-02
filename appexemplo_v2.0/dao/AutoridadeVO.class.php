<?php
class AutoridadeVO
{
	private $idautoridade = null;
	private $dat_inclusao = null;
	private $dat_inicio = null;
	private $dat_fim = null;
	private $cargo = null;
	private $nome_pessoa = null;
	private $ordem = null;
	public function AutoridadeVO( $idautoridade=null, $dat_inclusao=null, $dat_inicio=null, $dat_fim=null, $cargo=null, $nome_pessoa=null, $ordem=null )
	{
		$this->setIdautoridade( $idautoridade );
		$this->setDat_inclusao( $dat_inclusao );
		$this->setDat_inicio( $dat_inicio );
		$this->setDat_fim( $dat_fim );
		$this->setCargo( $cargo );
		$this->setNome_pessoa( $nome_pessoa );
		$this->setOrdem( $ordem );
	}
	//--------------------------------------------------------------------------------
	function setIdautoridade( $strNewValue = null )
	{
		$this->idautoridade = $strNewValue;
	}
	function getIdautoridade()
	{
		return $this->idautoridade;
	}
	//--------------------------------------------------------------------------------
	function setDat_inclusao( $strNewValue = null )
	{
		$this->dat_inclusao = $strNewValue;
	}
	function getDat_inclusao()
	{
		return is_null( $this->dat_inclusao ) ? date( 'Y-m-d h:i:s' ) : $this->dat_inclusao;
	}
	//--------------------------------------------------------------------------------
	function setDat_inicio( $strNewValue = null )
	{
		$this->dat_inicio = $strNewValue;
	}
	function getDat_inicio()
	{
		return is_null( $this->dat_inicio ) ? date( 'Y-m-d h:i:s' ) : $this->dat_inicio;
	}
	//--------------------------------------------------------------------------------
	function setDat_fim( $strNewValue = null )
	{
		$this->dat_fim = $strNewValue;
	}
	function getDat_fim()
	{
		return is_null( $this->dat_fim ) ? date( 'Y-m-d h:i:s' ) : $this->dat_fim;
	}
	//--------------------------------------------------------------------------------
	function setCargo( $strNewValue = null )
	{
		$this->cargo = $strNewValue;
	}
	function getCargo()
	{
		return $this->cargo;
	}
	//--------------------------------------------------------------------------------
	function setNome_pessoa( $strNewValue = null )
	{
		$this->nome_pessoa = $strNewValue;
	}
	function getNome_pessoa()
	{
		return $this->nome_pessoa;
	}
	//--------------------------------------------------------------------------------
	function setOrdem( $strNewValue = null )
	{
		$this->ordem = $strNewValue;
	}
	function getOrdem()
	{
		return $this->ordem;
	}
	//--------------------------------------------------------------------------------
}
?>