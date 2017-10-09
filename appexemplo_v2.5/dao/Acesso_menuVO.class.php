<?php
class Acesso_menuVO
{
	private $idmenu = null;
	private $idmenu_pai = null;
	private $nom_menu = null;
	private $url = null;
	private $tooltip = null;
	private $img_menu = null;
	private $imgdisabled = null;
	private $dissabled = null;
	private $hotkey = null;
	private $separator = null;
	private $sit_ativo = null;
	private $dat_inclusao = null;
	private $dat_update = null;
	public function Acesso_menuVO( $idmenu=null, $idmenu_pai=null, $nom_menu=null, $url=null, $tooltip=null, $img_menu=null, $imgdisabled=null, $dissabled=null, $hotkey=null, $separator=null, $sit_ativo=null, $dat_inclusao=null, $dat_update=null )
	{
		$this->setIdmenu( $idmenu );
		$this->setIdmenu_pai( $idmenu_pai );
		$this->setNom_menu( $nom_menu );
		$this->setUrl( $url );
		$this->setTooltip( $tooltip );
		$this->setImg_menu( $img_menu );
		$this->setImgdisabled( $imgdisabled );
		$this->setDissabled( $dissabled );
		$this->setHotkey( $hotkey );
		$this->setSeparator( $separator );
		$this->setSit_ativo( $sit_ativo );
		$this->setDat_inclusao( $dat_inclusao );
		$this->setDat_update( $dat_update );
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
	function setIdmenu_pai( $strNewValue = null )
	{
		$this->idmenu_pai = $strNewValue;
	}
	function getIdmenu_pai()
	{
		return $this->idmenu_pai;
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
	function setUrl( $strNewValue = null )
	{
		$this->url = $strNewValue;
	}
	function getUrl()
	{
		return $this->url;
	}
	//--------------------------------------------------------------------------------
	function setTooltip( $strNewValue = null )
	{
		$this->tooltip = $strNewValue;
	}
	function getTooltip()
	{
		return $this->tooltip;
	}
	//--------------------------------------------------------------------------------
	function setImg_menu( $strNewValue = null )
	{
		$this->img_menu = $strNewValue;
	}
	function getImg_menu()
	{
		return $this->img_menu;
	}
	//--------------------------------------------------------------------------------
	function setImgdisabled( $strNewValue = null )
	{
		$this->imgdisabled = $strNewValue;
	}
	function getImgdisabled()
	{
		return $this->imgdisabled;
	}
	//--------------------------------------------------------------------------------
	function setDissabled( $strNewValue = null )
	{
		$this->dissabled = $strNewValue;
	}
	function getDissabled()
	{
		return $this->dissabled;
	}
	//--------------------------------------------------------------------------------
	function setHotkey( $strNewValue = null )
	{
		$this->hotkey = $strNewValue;
	}
	function getHotkey()
	{
		return $this->hotkey;
	}
	//--------------------------------------------------------------------------------
	function setSeparator( $strNewValue = null )
	{
		$this->separator = $strNewValue;
	}
	function getSeparator()
	{
		return $this->separator;
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
	function setDat_update( $strNewValue = null )
	{
		$this->dat_update = $strNewValue;
	}
	function getDat_update()
	{
		return is_null( $this->dat_update ) ? date( 'Y-m-d h:i:s' ) : $this->dat_update;
	}
	//--------------------------------------------------------------------------------
}
?>