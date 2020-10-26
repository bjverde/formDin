<?php
defined('APLICATIVO') or die();
require_once 'modulos/includes/acesso_view_allowed.php';

$html1 = '<h1>Exemplo setAutoComplete com diversos bancos</h1>';
$html1 = $html1.'<br>'; 
$html1 = $html1.'<br> No grupo "MySql: Empresa" - está conectado o banco MySql, na tebela pessoa. Pesquisando nomes de Empresas recondo usar BRAS';
$html1 = $html1.'<br> No grupo "SqLite: Municípios" - está conectado o banco SqLite, na tebela tb_municipio. Pesquisando nomes de Municípios recondo usar SERRA';
$html1 = $html1.'<br>';

$frm = new TForm('Exemplo Multiplos');
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addHtmlField('html1', $html1, null, null, null, null)->setClass('boxAlert',true);

$frm->addGroupField('gpx1','MySql: Empresa');
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


$frm->addGroupField('gpx2', 'SqLite: Municípios');
    $frm->addTextField('nom_municipio2', 'Nome:', 60)->setExampleText('Digite os 3 primeiros caracteres.')->addEvent('onblur', 'validarMunicipio(this)');
    $frm->addTextField('cod_uf2', 'Cód Uf 2:', false);

    $frm->setAutoComplete('nom_municipio2'
                        , 'tb_municipio'            // 2: tabela alvo da pesquisa
                        , 'nom_municipio'           // 3: campo de pesquisa
                        , 'cod_municipio|cod_municipio2,cod_uf|cod_uf2'  // 4: campos do form origem que serão atualizados ao selecionar o item desejado. Separados por virgulas seguindo o padrão <campo_tabela> | <campo_formulario> , <campo_tabela> | <campo_formulario>
                        , true
                        , null                      // 6: campo do formulário que será adicionado como filtro
                        , null
                        , 3
                        , 1000                       // 09: Default 1000, tempo após a digitação para disparar a consulta
                        , 50                         // 10: máximo de registros que deverá ser retornado
                        , null, null, null           // url da função de callbacks, se ficar em branco será tratado por callbacks/autocomplete.php
                        , null                       // 15: Mesagem caso não encontre nenhum registro
                        , null
                        , null
                        , null
                        , true                       // 18: $boolSearchAnyPosition busca o texto em qualquer posição igual Like %texto%
                        , 'config_sqlite.php'
                    );      
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
