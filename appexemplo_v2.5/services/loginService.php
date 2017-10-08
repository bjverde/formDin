<?php

class loginService {
	
	//--------------------------------------------------------------------------------
	public static function validarLogin( $nom_user, $pwd_user )	{
        $dados = Acesso_userDAO::selectUser($nom_user, $pwd_user);
        var_dump($dados);
        if ( count($dados) == 1 ) {
            $msg = 1;
        }else{
            $msg = 'Login Invalido !';
        }
    }
}

?>