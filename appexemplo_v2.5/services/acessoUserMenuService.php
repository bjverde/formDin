<?php

class acessoUserMenuService {
	
	//--------------------------------------------------------------------------------
	public static function getAcessoUserMenuByLogin()	{
        $login = $_SESSION[APLICATIVO]['LOGIN'];
        $userMenu = Acesso_menu::selectMenuByLogin($login);
        return $userMenu;
    }
}

?>