<?php
defined('APLICATIVO') or die();
require_once 'modulos/includes/acesso_view_allowed.php';

$html1 = '<h1>Exemplo setAutoComplete com diversos bancos</h1>';
$html1 = $html1.'<br>'; 
$html1 = $html1.'<br> No grupo Empresa - está conectado o banco MySql, na tebela pessoa. Pesquisando nomes de Empresas recondo usar BRAS';
$html1 = $html1.'<br> 2 - Select em tabela SqLite';
$html1 = $html1.'<br> 3 - Select em tabela MySql';
$html1 = $html1.'<br>';

$frm = new TForm('Exemplo Multiplos');
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addHtmlField('html1', $html1, null, null, null, null)->setClass('boxAlert',true);

$frm->addGroupField('gpx1','Empresa');
    $frm->addHiddenField('TIPO','PJ');
    $frm->addNumberField('IDPESSOA', 'Cod',4,true,0);
    $frm->addTextField('NOM_PESSOA', 'Nome',150,true,70,null,false);
    //Deve sempre ficar depois da definição dos campos
    $frm->setAutoComplete('NOM_PESSOA'
        ,'pessoa'// tabela
        ,'NOME'	 		// campo de pesquisa
        ,'IDPESSOA|IDPESSOA,NOME|NOM_PESSOA' // campo que será atualizado ao selecionar o nome do município <campo_tabela> | <campo_formulario>
        ,true
        ,'TIPO' 		    // campo do formulário que será adicionado como filtro
        ,null				// função javascript
        ,3					// Default 3, numero de caracteres minimos para disparar a pesquisa
        ,500				// 9: Default 1000, tempo após a digitação para disparar a consulta
        ,50					//10: máximo de registros que deverá ser retornado
        , null, null, null, null, true, null, null, true );
$frm->closeGroup();


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    case 'Executar':
        $controllerDatabase = new Database();
        $controllerDatabase->showMultiplos();
    break;
    //--------------------------------------------------------------------------------
}

$frm->show();
