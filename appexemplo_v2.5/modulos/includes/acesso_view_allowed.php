<?php
/**
 * Controla se a pessoa pode acessar o modulo ou não
 */
if ( Acesso::viewAccessNotAllowed($_REQUEST['modulo']) ){
    die();
}