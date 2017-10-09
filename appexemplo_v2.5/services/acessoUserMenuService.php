<?php

class acessoUserMenuService {
	
	//--------------------------------------------------------------------------------
	public static function getAcessoUserMenuByLogin()	{
        $login = $_SESSION[APLICATIVO]['LOGIN'];

        $userMenu = acesso_user_menuDAO::selectByLogin($login);
        var_dump ($userMenu['IDMENU']);
        /*
        foreach ($userMenu['IDMENU'] as $key => $value) {
            $menu[]=acesso_menuDAO::select($value);
        }*/
        $menu=acesso_menuDAO::select('10');
        var_dump ($menu);
        
    }
}

?>