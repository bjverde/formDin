<?php
class PessoaVO {
	private $idpessoa = null;
	private $nome = null;
	private $tipo = null;
	private $dat_inclusao = null;
	public function __construct( $idpessoa=null, $nome=null, $tipo=null, $dat_inclusao=null ) {
		$this->setIdpessoa( $idpessoa );
		$this->setNome( $nome );
		$this->setTipo( $tipo );
		$this->setDat_inclusao( $dat_inclusao );
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
	public function setNome( $strNewValue = null )
	{
		$this->nome = $strNewValue;
	}
	public function getNome()
	{
		return $this->nome;
	}
	//--------------------------------------------------------------------------------
	public function setTipo( $strNewValue = null )
	{
		$this->tipo = $strNewValue;
	}
	public function getTipo()
	{
		return $this->tipo;
	}
	//--------------------------------------------------------------------------------
	public function setDat_inclusao( $strNewValue = null )
	{
		$this->dat_inclusao = $strNewValue;
	}
	public function getDat_inclusao()
	{
		return is_null( $this->dat_inclusao ) ? date( 'Y-m-d h:i:s' ) : $this->dat_inclusao;
	}
	//--------------------------------------------------------------------------------
}
?>