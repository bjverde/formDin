<?php

class acessoUserMenuService {
	
	//--------------------------------------------------------------------------------
	public static function getAcessoUserMenuByLogin()	{
        $login = $_SESSION[APLICATIVO]['LOGIN'];
        $userMenu = acesso_menuDAO::selectMenuByLogin($login);
        return $userMenu;
    }
}

?>