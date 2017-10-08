<?php

class loginService {
	
	//--------------------------------------------------------------------------------
	public static function validarLogin( $nom_user, $pwd_user )	{
        $dados = Acesso_userDAO::selectUser($nom_user, $pwd_user);
        if ( count($dados['IDUSER']) == 1 ) {
            $_SESSION[APLICATIVO]['IDUSER'] = $dados['IDUSER'][0];
            $_SESSION[APLICATIVO]['LOGIN']  = $dados['NOM_USER'][0];
            $msg = 1;
        }else{
            $msg = 'Login Invalido !';
        }
        return $msg;
    }
}

?>