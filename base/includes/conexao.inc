<?php
if ( !session_id() )
{
    session_start();
}
if( !defined('PASTA_BASE') )
{
	// permitir utilizar o arquivo de configuração config_sem_autenticar quando a variavel de sessão ACESSO_PUBLICO estiver true
    $arquivo = encontrarArquivoNivel('includes/config_sem_autenticar.inc',$nivel);
    if( $arquivo && isset($_SESSION['ACESSO_PUBLICO']) && $_SESSION['ACESSO_PUBLICO'] == true )
    {
        include_once($arquivo);
    }
    else if( $arquivo = encontrarArquivoNivel('includes/config.inc',$nivel) )
    {
	    include_once($arquivo);
    }
    else
    {
        echo 'Módulo conexao.inc. Arquivo config.inc não encontrado';
        return;
    }
}

if( $arquivo = encontrarArquivoNivel(PASTA_BASE.'classes/banco.inc',$nivel) )
{
    include_once($arquivo);
}
else
{
    print utf8_encode('Módulo base/includes/conexao.inc, arquivo banco.inc não encontrado.');
    return;
}
$clientedb = new banco();
$GLOBALS['conexao'] = $clientedb;

if( (isset($_REQUEST["modulo"]) && strtolower($_REQUEST["modulo"])=='limparcache'))
{
    $clientedb->limparCache();
    $_POST["modulo"]=null;
    $_GET["modulo"]=null;
    $_REQUEST["modulo"]=null;
    echo '<script>alert("Cache da classe banco foi limpo com SUCESSO!")</script>';
}
/**
* Recupera um pacote do Banco, deve ser usado caso tenha um pacote com uma função que retorne dados um ou mais cursores
*
* $porLinha - retorna o array de dados no formato $res[0]['NUM_PESSOA']=2, o padrão é $res['NUM_PESSOA'][0] = 2;
* $cursor_skip - quantidade de registros que devem ser ignorados a partir do primeiro registro
* $cursor_linhas - quantidade de linhas a serem retornadas
*
* @param mixed $pacote
* @param array $bvars
* @param mixed $res
* @param mixed $tempo_cache
* @param mixed $porLinha
* @param mixed $cursor_skip
* @param mixed $cursor_linhas
*/
Function recuperarPacote($pacote,&$bvars,&$res,$tempo_cache=-1,$porLinha=null,$cursor_skip=null,$cursor_linhas=null){
    if(is_array($bvars) )
        $bvars=array_change_key_case($bvars, CASE_UPPER);

    ob_start('callback');
    $mens = $GLOBALS['conexao']->executar_pacote_func_proc($pacote,$bvars,$tempo_cache,$porLinha,$cursor_skip,$cursor_linhas);
    ob_end_flush();

    if($bvars['CURSOR']) {
        $res = $bvars['CURSOR'];
        if (count($res[key($res)])==0 ) {
            $res=null;
        }
    }
    return $mens;
}

/*
Function recuperarPacote($pacote,&$bvars,&$res,$tempo_cache=-1){
if(is_array($bvars) )
$bvars=array_change_key_case($bvars, CASE_UPPER);
$mens = $GLOBALS['conexao']->executar_pacote_func_proc($pacote,$bvars,$tempo_cache);

if($bvars['CURSOR']) {
$res = $bvars['CURSOR'];
if (count($res[key($res)])==0 ) {
$res=null;
}
}
return $mens;
}
*/
Function executarPacote($pacote,&$bvars,$tempo_cache=-1)
{
    if(is_array($bvars) )
        $bvars=array_change_key_case($bvars, CASE_UPPER);
    $mens=$GLOBALS['conexao']->executar_pacote_func_proc($pacote,$bvars,$tempo_cache);

    if ( !$mens )
        $GLOBALS['conexao']->commit();
    else
        $GLOBALS['conexao']->rollback();
    return $mens;
}

function encontrarArquivo($arquivo) {
    for( $i=0;$i<10;$i++) {
        $path = str_repeat('../',$i);
        if( file_exists($path.$arquivo ) ) {
            return $path.$arquivo;
            break;
        }
    }
    return null;
}

function encontrarArquivoNivel($arquivo,&$i)
{
    $retorno = null;
    for( $i=0;$i<10;$i++)
    {
        $path = str_repeat('../',$i);
        if( file_exists($path.$arquivo ) ) {
            $retorno = $path.$arquivo;
            break;
        }
    }
    if( !is_null( $retorno ) )
    {
        return $retorno;
    }
	
	if( ! isset($_SESSION['APLICATIVO']) && isset( $_SESSION['SISTEMA']['SIGLA']))
	{
		$_SESSION['APLICATIVO'] = $_SESSION['SISTEMA']['SIGLA']	;
	}
	
    // ajuste para quando estiver utiliznado a pasta base fora da pasta do projeto
    if( isset( $_SESSION['APLICATIVO'] ) && trim($_SESSION['APLICATIVO']) != '' )
    {
        $aplicativo =  strtolower($_SESSION['APLICATIVO'] );
        $local = __FILE__;
        if( preg_match( '/\/base\//',$local))
        {
            $local = substr( $local, 0, strpos($local,'base/')).$aplicativo.'/';
            if( file_exists ( $local.$arquivo  ))
            {
                return $local.$arquivo;
            }
        }
    }
	else 
	{
        $aplicativo =  'ctf';
        $local = __FILE__;
        if( preg_match( '/\/base\//',$local))
        {
            $local = substr( $local, 0, strpos($local,'base/')).$aplicativo.'/';
            if( file_exists ( $local.$arquivo  ))
            {
                return $local.$arquivo;
            }
        }
	}
    return null;
}

function callback($buffer)
{
    if( preg_match('/expects parameter 1 to be resource/i', ob_get_contents() ) ) // erro oracle por falta de conexão
    {
        if( ! isset($_REQUEST['ajax'] ) || ! $_REQUEST['ajax'] )
        {
            return '<script>alert("Sua sessão expirou. Necessário informar sua senha novamente!");top.app_server_action("logout",true,"script",null,"top.app_restart()");</script>';
        }
        else if( isset($_REQUEST['ajax'] ) && $_REQUEST['ajax'] )
        {
            if( $_REQUEST['datatype'] && $_REQUEST['datatype']=='json' )
            {
                $resAjax['status']        = 0;
                $resAjax['data']        = null;
                $resAjax['message']        = utf8_encode('Sua sessão expirou. Necessário informar sua senha novamente!');
                $resAjax['dataType']    = 'json';
                $resAjax['containerId']    = null;
                $resAjax['script']        = 'top.app_server_action("logout",true,"script",null,"top.app_restart()")';
                return json_encode($resAjax);
            }
            else if( $_REQUEST['datatype'] && $_REQUEST['datatype']=='text' )
            {
                return utf8_encode('Sua sessão expirou. Necessário informar sua senha novamente!');
            }
        }
    }
    return '';
}