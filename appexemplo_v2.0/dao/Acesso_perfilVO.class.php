<?php
class Acesso_perfilVO
{
	private $idperfil = null;
	private $nom_perfil = null;
	private $sit_ativo = null;
	private $dat_inclusao = null;
	public function Acesso_perfilVO( $idperfil=null, $nom_perfil=null, $sit_ativo=null, $dat_inclusao=null )
	{
		$this->setIdperfil( $idperfil );
		$this->setNom_perfil( $nom_perfil );
		$this->setSit_ativo( $sit_ativo );
		$this->setDat_inclusao( $dat_inclusao );
	}
	//--------------------------------------------------------------------------------
	function setIdperfil( $strNewValue = null )
	{
		$this->idperfil = $strNewValue;
	}
	function getIdperfil()
	{
		return $this->idperfil;
	}
	//--------------------------------------------------------------------------------
	function setNom_perfil( $strNewValue = null )
	{
		$this->nom_perfil = $strNewValue;
	}
	function getNom_perfil()
	{
		return $this->nom_perfil;
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
	function setDat_inclusao( $strNewValue = null )
	{
		$this->dat_inclusao = $strNewValue;
	}
	function getDat_inclusao()
	{
		return is_null( $this->dat_inclusao ) ? date( 'Y-m-d h:i:s' ) : $this->dat_inclusao;
	}
	//--------------------------------------------------------------------------------
}
?>