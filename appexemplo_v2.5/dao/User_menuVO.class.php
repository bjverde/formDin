<?php
class User_menuVO
{
	private $iduser = null;
	private $login_user = null;
	private $idperfil = null;
	private $nom_perfil = null;
	private $idmenu = null;
	private $nom_menu = null;
	public function User_menuVO( $iduser=null, $login_user=null, $idperfil=null, $nom_perfil=null, $idmenu=null, $nom_menu=null )
	{
		$this->setIduser( $iduser );
		$this->setLogin_user( $login_user );
		$this->setIdperfil( $idperfil );
		$this->setNom_perfil( $nom_perfil );
		$this->setIdmenu( $idmenu );
		$this->setNom_menu( $nom_menu );
	}
	//--------------------------------------------------------------------------------
	function setIduser( $strNewValue = null )
	{
		$this->iduser = $strNewValue;
	}
	function getIduser()
	{
		return $this->iduser;
	}
	//--------------------------------------------------------------------------------
	function setLogin_user( $strNewValue = null )
	{
		$this->login_user = $strNewValue;
	}
	function getLogin_user()
	{
		return $this->login_user;
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
	function setIdmenu( $strNewValue = null )
	{
		$this->idmenu = $strNewValue;
	}
	function getIdmenu()
	{
		return $this->idmenu;
	}
	//--------------------------------------------------------------------------------
	function setNom_menu( $strNewValue = null )
	{
		$this->nom_menu = $strNewValue;
	}
	function getNom_menu()
	{
		return $this->nom_menu;
	}
	//--------------------------------------------------------------------------------
}
?>