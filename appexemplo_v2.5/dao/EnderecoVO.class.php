<?php
class EnderecoVO {
	private $idendereco = null;
	private $endereco = null;
	private $idpessoa = null;
	private $idtipo_endereco = null;
	private $cod_municipio = null;
	private $cep = null;
	private $numero = null;
	private $complemento = null;
	private $bairro = null;
	private $cidade = null;
	public function __construct( $idendereco=null, $endereco=null, $idpessoa=null, $idtipo_endereco=null, $cod_municipio=null, $cep=null, $numero=null, $complemento=null, $bairro=null, $cidade=null ) {
		$this->setIdendereco( $idendereco );
		$this->setEndereco( $endereco );
		$this->setIdpessoa( $idpessoa );
		$this->setIdtipo_endereco( $idtipo_endereco );
		$this->setCod_municipio( $cod_municipio );
		$this->setCep( $cep );
		$this->setNumero( $numero );
		$this->setComplemento( $complemento );
		$this->setBairro( $bairro );
		$this->setCidade( $cidade );
	}
	//--------------------------------------------------------------------------------
	public function setIdendereco( $strNewValue = null )
	{
		$this->idendereco = $strNewValue;
	}
	public function getIdendereco()
	{
		return $this->idendereco;
	}
	//--------------------------------------------------------------------------------
	public function setEndereco( $strNewValue = null )
	{
		$this->endereco = $strNewValue;
	}
	public function getEndereco()
	{
		return $this->endereco;
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
	public function setIdtipo_endereco( $strNewValue = null )
	{
		$this->idtipo_endereco = $strNewValue;
	}
	public function getIdtipo_endereco()
	{
		return $this->idtipo_endereco;
	}
	//--------------------------------------------------------------------------------
	public function setCod_municipio( $strNewValue = null )
	{
		$this->cod_municipio = $strNewValue;
	}
	public function getCod_municipio()
	{
		return $this->cod_municipio;
	}
	//--------------------------------------------------------------------------------
	public function setCep( $strNewValue = null )
	{
		$this->cep = $strNewValue;
	}
	public function getCep()
	{
		return $this->cep;
	}
	//--------------------------------------------------------------------------------
	public function setNumero( $strNewValue = null )
	{
		$this->numero = $strNewValue;
	}
	public function getNumero()
	{
		return $this->numero;
	}
	//--------------------------------------------------------------------------------
	public function setComplemento( $strNewValue = null )
	{
		$this->complemento = $strNewValue;
	}
	public function getComplemento()
	{
		return $this->complemento;
	}
	//--------------------------------------------------------------------------------
	public function setBairro( $strNewValue = null )
	{
		$this->bairro = $strNewValue;
	}
	public function getBairro()
	{
		return $this->bairro;
	}
	//--------------------------------------------------------------------------------
	public function setCidade( $strNewValue = null )
	{
		$this->cidade = $strNewValue;
	}
	public function getCidade()
	{
		return $this->cidade;
	}
	//--------------------------------------------------------------------------------
}
?>