<?php
/**
 * Controla se a pessoa pode acessar o modulo ou não
 */
if ( Acesso::moduloAcessoPermitido($_REQUEST['modulo']) ){
    die();
}