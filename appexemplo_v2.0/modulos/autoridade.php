<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDMENU';
$frm = new TForm('Cadastro de Menu',1000,1000);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela
$frm->addTextField('NOM_MENU', 'Nome do Menu',45,TRUE,45);
$frm->getLabel('NOM_MENU')->setToolTip('o nome que o usuario irá ver');
$listAcesso_menu = Acesso_menu::selectAll();
$frm->addSelectField('IDMENU_PAI', 'Pai do Menu',FALSE,$listAcesso_menu,null,null,null,null,null,null,' ',null);
$frm->getLabel('IDMENU_PAI')->setToolTip('id do menu pai, se o pai é null então começa na raiz');
$frm->addMemoField('URL', 'URL',300,FALSE,80,3);
$frm->getLabel('URL')->setToolTip('caminho do item de menu');
$frm->addMemoField('TOOLTIP', 'TOOLTIP',300,FALSE,80,3);
$frm->getLabel('TOOLTIP')->setToolTip('decrição mais detalhada do menu');
$frm->addTextField('IMG_MENU', 'IMG_MENU',45,FALSE,45);
$frm->getLabel('IMG_MENU')->setToolTip('Caminho da imagem será utilizada como ícone');
$frm->addTextField('IMGDISABLED', 'IMGDISABLED',45,FALSE,45);
$frm->getLabel('IMGDISABLED')->setToolTip('Caminho da imagem para o menu desabilitado');
$frm->addSelectField('DISSABLED', 'DISSABLED:', true, 'S=Sim,N=Não', true);
//$frm->addTextField('DISSABLED', 'DISSABLED:',45,FALSE,45);
$frm->getLabel('DISSABLED')->setToolTip('Informa se o item de menu está habilitado ou não. N = Item de aparece porém não pode ser usada, S = Item menu aparece e pode ser clicado.');
$frm->addTextField('HOTKEY', 'HOTKEY',45,FALSE,45);
$frm->getLabel('HOTKEY')->setToolTip('Tecla de atalho');
$frm->addNumberField('BOOLSEPARATOR', 'BOOLSEPARATOR',3,FALSE,0);
$frm->addMemoField('JSONPARAMS', 'JSONPARAMS',300,FALSE,80,3);
$frm->addSelectField('SIT_ATIVO', 'Ativo:', true, 'S=Sim,N=Não', true);
//$frm->addTextField('SIT_ATIVO', 'SIT_ATIVO',1,TRUE,1);
$frm->getLabel('SIT_ATIVO')->setToolTip('Informa se o registro está ativo ou não. N = Item de nem aparece, S = Item menu aparece.');
$frm->addDateField('DAT_INCLUSAO', 'DAT_INCLUSAO',TRUE);
$frm->addDateField('DAT_UPDATE', 'DAT_UPDATE',FALSE);
$frm->getLabel('DAT_UPDATE')->setToolTip('data de update igual inclusao implica que nunca teve alteração');

$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    case 'Salvar':
        try{
            if ( $frm->validate() ) {
                $vo = new Acesso_menuVO();
                $frm->setVo( $vo );
                $resultado = Acesso_menu::save( $vo );
                if($resultado==1) {
                    $frm->setMessage('Registro gravado com sucesso!!!');
                    $frm->clearFields();
                }else{
                    $frm->setMessage($resultado);
                }
            }
        }
        catch (DomainException $e) {
            $frm->setMessage( $e->getMessage() );
        }
        catch (Exception $e) {
            MessageHelper::logRecord($e);
            $frm->setMessage( $e->getMessage() );
        }
        break;
        //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
        //--------------------------------------------------------------------------------
    case 'gd_excluir':
        try{
            $id = $frm->get( $primaryKey ) ;
            $resultado = Acesso_menu::delete( $id );;
            if($resultado==1) {
                $frm->setMessage('Registro excluido com sucesso!!!');
                $frm->clearFields();
            }else{
                $frm->clearFields();
                $frm->setMessage($resultado);
            }
        }
        catch (DomainException $e) {
            $frm->setMessage( $e->getMessage() );
        }
        catch (Exception $e) {
            MessageHelper::logRecord($e);
            $frm->setMessage( $e->getMessage() );
        }
        break;
}

$dados = Acesso_menu::selectAll($primaryKey);

$frm->addGroupField('gpTree','Menus em Treeview')->setcloseble(true);
$userData = array('IDMENU_PAI','NOM_MENU','URL','TOOLTIP','IMG_MENU','IMGDISABLED','DISSABLED','HOTKEY','BOOLSEPARATOR','JSONPARAMS','SIT_ATIVO','DAT_INCLUSAO','DAT_UPDATE');
$tree = $frm->addTreeField('tree',null,$dados,'IDMENU_PAI',$primaryKey,'NOM_MENU',null, $userData);
$tree->setStartExpanded(true);
$tree->setOnClick('treeClick'); // fefinir o evento que ser? chamado ao clicar no item da treeview
$frm->closeGroup();


function getWhereGridParameters(&$frm){
    $retorno = null;
    if($frm->get('BUSCAR') == 1 ){
        $retorno = array(
            'IDMENU'=>$frm->get('IDMENU')
            ,'NOM_MENU'=>$frm->get('NOM_MENU')
            ,'IDMENU_PAI'=>$frm->get('IDMENU_PAI')
            ,'URL'=>$frm->get('URL')
            ,'TOOLTIP'=>$frm->get('TOOLTIP')
            ,'IMG_MENU'=>$frm->get('IMG_MENU')
            ,'IMGDISABLED'=>$frm->get('IMGDISABLED')
            ,'DISSABLED'=>$frm->get('DISSABLED')
            ,'HOTKEY'=>$frm->get('HOTKEY')
            ,'BOOLSEPARATOR'=>$frm->get('BOOLSEPARATOR')
            ,'JSONPARAMS'=>$frm->get('JSONPARAMS')
            ,'SIT_ATIVO'=>$frm->get('SIT_ATIVO')
            ,'DAT_INCLUSAO'=>$frm->get('DAT_INCLUSAO')
            ,'DAT_UPDATE'=>$frm->get('DAT_UPDATE')
        );
    }
    return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
    $maxRows = ROWS_PER_PAGE;
    $whereGrid = getWhereGridParameters($frm);
    $page = PostHelper::get('page');
    $dados = Acesso_menu::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
    $realTotalRowsSqlPaginator = Acesso_menu::selectCount( $whereGrid );
    $mixUpdateFields = $primaryKey.'|'.$primaryKey
    .',NOM_MENU|NOM_MENU'
        .',IDMENU_PAI|IDMENU_PAI'
            .',URL|URL'
                .',TOOLTIP|TOOLTIP'
                    .',IMG_MENU|IMG_MENU'
                        .',IMGDISABLED|IMGDISABLED'
                            .',DISSABLED|DISSABLED'
                                .',HOTKEY|HOTKEY'
                                    .',BOOLSEPARATOR|BOOLSEPARATOR'
                                        .',JSONPARAMS|JSONPARAMS'
                                            .',SIT_ATIVO|SIT_ATIVO'
                                                .',DAT_INCLUSAO|DAT_INCLUSAO'
                                                    .',DAT_UPDATE|DAT_UPDATE'
                                                        ;
                                                        $gride = new TGrid( 'gd'                        // id do gride
                                                            ,'Menus em Visão de Tabela' // titulo do gride
                                                            );
                                                        $gride->addKeyField( $primaryKey ); // chave primaria
                                                        $gride->setData( $dados ); // array de dados
                                                        $gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
                                                        $gride->setMaxRows( $maxRows );
                                                        $gride->setUpdateFields($mixUpdateFields);
                                                        $gride->setUrl( 'acesso_menu.php' );
                                                        
                                                        $gride->addColumn($primaryKey,'id');
                                                        $gride->addColumn('NOM_MENU','NOM_MENU');
                                                        $gride->addColumn('IDMENU_PAI','IDMENU_PAI');
                                                        $gride->addColumn('URL','URL');
                                                        $gride->addColumn('TOOLTIP','TOOLTIP');
                                                        $gride->addColumn('IMG_MENU','IMG_MENU');
                                                        $gride->addColumn('IMGDISABLED','IMGDISABLED');
                                                        $gride->addColumn('DISSABLED','DISSABLED');
                                                        $gride->addColumn('HOTKEY','HOTKEY');
                                                        $gride->addColumn('BOOLSEPARATOR','BOOLSEPARATOR');
                                                        $gride->addColumn('JSONPARAMS','JSONPARAMS');
                                                        $gride->addColumn('SIT_ATIVO','SIT_ATIVO');
                                                        $gride->addColumn('DAT_INCLUSAO','DAT_INCLUSAO');
                                                        $gride->addColumn('DAT_UPDATE','DAT_UPDATE');
                                                        
                                                        $gride->show();
                                                        die();
}


$frm->addGroupField('gpGride','Menus Visão de Tabela',null,null,null,null,true,null,false)->setcloseble(true);
$frm->addHtmlField('gride');
$frm->closeGroup();

$frm->addJavascript('init()');
$frm->show();

?>
<script>
function init() {
	var Parameters = {"BUSCAR":""
					,"IDMENU":""
					,"NOM_MENU":""
					,"IDMENU_PAI":""
					,"URL":""
					,"TOOLTIP":""
					,"IMG_MENU":""
					,"IMGDISABLED":""
					,"DISSABLED":""
					,"HOTKEY":""
					,"BOOLSEPARATOR":""
					,"JSONPARAMS":""
					,"SIT_ATIVO":""
					,"DAT_INCLUSAO":""
					,"DAT_UPDATE":""
					};
	fwGetGrid('acesso_menu.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
function treeClick(id) {
	
	/*
	alert( 'Item id:'+treeJs.getSelectedItemId()+'\n'+
	'Item text:'+treeJs.getItemText(id )+'\n'+
	'User pai:'+treeJs.getUserData(id,'IDMENU_PAI')+'\n'+
	'User data URL:'+treeJs.getUserData(id,'URL')+'\n'+
	'IMG:'+treeJs.getUserData(id,'IMG_MENU')
	);
	*/
	
	// atualizar os campos do formulário
	jQuery("#IDMENU").val(treeJs.getSelectedItemId());
	jQuery("#NOM_MENU").val(treeJs.getItemText(id ));
	jQuery("#IDMENU_PAI").val(treeJs.getUserData(id,'IDMENU_PAI'));
	jQuery("#URL").val(treeJs.getUserData(id,'URL'));
	jQuery("#TOOLTIP").val(treeJs.getUserData(id,'TOOLTIP'));
	jQuery("#IMG_MENU").val(treeJs.getUserData(id,'IMG_MENU'));
	jQuery("#IMGDISABLED").val(treeJs.getUserData(id,'IMGDISABLED'));
	jQuery("#DISSABLED").val(treeJs.getUserData(id,'DISSABLED'));
	jQuery("#HOTKEY").val(treeJs.getUserData(id,'HOTKEY'));
	jQuery("#BOOLSEPARATOR").val(treeJs.getUserData(id,'BOOLSEPARATOR'));
	jQuery("#JSONPARAMS").val(treeJs.getUserData(id,'JSONPARAMS'));
	jQuery("#DAT_INCLUSAO").val(treeJs.getUserData(id,'DAT_INCLUSAO'));
	jQuery("#DAT_UPDATE").val(treeJs.getUserData(id,'DAT_UPDATE'));
	
}
</script>