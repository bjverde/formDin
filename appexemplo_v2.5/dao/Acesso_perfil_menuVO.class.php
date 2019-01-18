<?php
class Acesso_perfil_menuVO {
	private $idperfilmenu = null;
	private $idperfil = null;
	private $idmenu = null;
	private $sit_ativo = null;
	private $dat_inclusao = null;
	private $dat_update = null;
	public function __construct( $idperfilmenu=null, $idperfil=null, $idmenu=null, $sit_ativo=null, $dat_inclusao=null, $dat_update=null ) {
		$this->setIdperfilmenu( $idperfilmenu );
		$this->setIdperfil( $idperfil );
		$this->setIdmenu( $idmenu );
		$this->setSit_ativo( $sit_ativo );
		$this->setDat_inclusao( $dat_inclusao );
		$this->setDat_update( $dat_update );
	}
	//--------------------------------------------------------------------------------
	public function setIdperfilmenu( $strNewValue = null )
	{
		$this->idperfilmenu = $strNewValue;
	}
	public function getIdperfilmenu()
	{
		return $this->idperfilmenu;
	}
	//--------------------------------------------------------------------------------
	public function setIdperfil( $strNewValue = null )
	{
		$this->idperfil = $strNewValue;
	}
	public function getIdperfil()
	{
		return $this->idperfil;
	}
	//--------------------------------------------------------------------------------
	public function setIdmenu( $strNewValue = null )
	{
		$this->idmenu = $strNewValue;
	}
	public function getIdmenu()
	{
		return $this->idmenu;
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
	public function setDat_inclusao( $strNewValue = null )
	{
		$this->dat_inclusao = $strNewValue;
	}
	public function getDat_inclusao()
	{
		return is_null( $this->dat_inclusao ) ? date( 'Y-m-d h:i:s' ) : $this->dat_inclusao;
	}
	//--------------------------------------------------------------------------------
	public function setDat_update( $strNewValue = null )
	{
		$this->dat_update = $strNewValue;
	}
	public function getDat_update()
	{
		return is_null( $this->dat_update ) ? date( 'Y-m-d h:i:s' ) : $this->dat_update;
	}
	//--------------------------------------------------------------------------------
}
?>