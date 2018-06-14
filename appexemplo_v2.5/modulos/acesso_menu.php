<?php
$primaryKey = 'IDMENU';
$frm = new TForm('Cadastro de Menu', 600, 900);
$frm->setFlat(true);


$frm->addHiddenField($primaryKey); // coluna chave da tabela
$frm->addTextField('IDMENU_PAI', 'Id PAI', 15, true);
$frm->addTextField('NOM_MENU', 'Nome do Menu:', 50, true, null, null, false);
$frm->addTextField('URL', 'URL', 80, false);
$frm->addTextField('TOOLTIP', 'TOOLTIP', 50, false);
$frm->addTextField('IMG_MENU', 'IMG_MENU', 50, false);
$frm->addTextField('IMGDISABLED', 'IMGDISABLED', 50, false);
$frm->addTextField('DISSABLED', 'DISSABLED', 50, false);
$frm->addTextField('HOTKEY', 'HOTKEY', 50, false);
$frm->addTextField('BOOLSEPARATOR', 'BOOLSEPARATOR', 50, false);
$frm->addTextField('JSONPARAMS', 'JSONPARAMS', 50, false);
$frm->addSelectField('SIT_ATIVO', 'Ativo:', true, 'S=Sim,N=Não', true);
$frm->addTextField('DAT_INCLUSAO', 'Data Inclusão:', null, false, null, null, true)->setReadOnly(true);
$frm->addTextField('DAT_UPDATE', 'Data Update: ', null, false, null, null, false)->setReadOnly(true);

$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'Salvar':
        if ($frm->validate()) {
            $vo = new Acesso_menuVO();
            $frm->setVo($vo);
            $resultado = Acesso_menuDAO::insert($vo);
            if ($resultado==1) {
                $frm->setMessage('Registro gravado com sucesso!!!');
                $frm->clearFields();
            } else {
                $frm->setMessage($resultado);
            }
        }
        break;
    //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
    //--------------------------------------------------------------------------------
    case 'gd_excluir':
        $id = $frm->get($primaryKey) ;
        $resultado = Acesso_menuDAO::delete($id);
        ;
        if ($resultado==1) {
            $frm->setMessage('Registro excluido com sucesso!!!');
            $frm->clearFields();
        } else {
            $frm->clearFields();
            $frm->setMessage($resultado);
        }
        break;
}

$dados = Acesso_menuDAO::selectAll($primaryKey);

$frm->addGroupField('gpTree', 'Menus Treeview')->setcloseble(true);
$userData = array('IDMENU_PAI','NOM_MENU','URL','TOOLTIP','IMG_MENU','IMGDISABLED','DISSABLED','HOTKEY','BOOLSEPARATOR','JSONPARAMS','SIT_ATIVO','DAT_INCLUSAO','DAT_UPDATE');
$tree = $frm->addTreeField('tree', null, $dados, 'IDMENU_PAI', $primaryKey, 'NOM_MENU', null, $userData);
$tree->setStartExpanded(true);
$tree->setOnClick('treeClick'); // fefinir o evento que ser? chamado ao clicar no item da treeview
$frm->closeGroup();

$mixUpdateFields = $primaryKey.'|'.$primaryKey.',IDMENU_PAI|IDMENU_PAI,NOM_MENU|NOM_MENU,URL|URL,TOOLTIP|TOOLTIP,IMG_MENU|IMG_MENU,IMGDISABLED|IMGDISABLED,DISSABLED|DISSABLED,HOTKEY|HOTKEY,BOOLSEPARATOR|BOOLSEPARATOR,JSONPARAMS|JSONPARAMS,SIT_ATIVO|SIT_ATIVO,DAT_INCLUSAO|DAT_INCLUSAO,DAT_UPDATE|DAT_UPDATE';
$gride = new TGrid('gd'        // id do gride
, 'Gride'     // titulo do gride
, $dados        // array de dados
, null          // altura do gride
, null          // largura do gride
, $primaryKey   // chave primaria
, $mixUpdateFields);
$gride->addColumn($primaryKey, 'id', 10, 'center');
$gride->addColumn('IDMENU_PAI', 'Id Pai', 20, 'center');
$gride->addColumn('NOM_MENU', 'Nome', 50, null);
$gride->addColumn('URL', 'URL', 50, null);
$gride->addColumn('TOOLTIP', 'ToolTip', 50, 'center');
$gride->addColumn('IMG_MENU', 'Img', 50, 'center');
$gride->addColumn('IMGDISABLED', 'IMGDISABLED', 50, 'center');
$gride->addColumn('DISSABLED', 'DISSABLED', 50, 'center');
$gride->addColumn('HOTKEY', 'HOTKEY', 50, 'center');
$gride->addColumn('BOOLSEPARATOR', 'BOOLSEPARATOR', 50, 'center');
$gride->addColumn('JSONPARAMS', 'JSONPARAMS', 50, 'center');
$gride->addColumn('SIT_ATIVO', 'SIT_ATIVO', 50, 'center');
$gride->addColumn('DAT_INCLUSAO', 'DAT_INCLUSAO', 50, 'center');
$gride->addColumn('DAT_UPDATE', 'DAT_UPDATE', 50, 'center');


$frm->addGroupField('gpGride', 'Menus Visão de Tabela', null, null, null, null, true, null, false)->setcloseble(true);
$frm->addHtmlField('gride', $gride);
$frm->closeGroup();




$frm->setAction('Salvar,Limpar');
$frm->show();
?>

<script>
function treeClick(id) {
    
    /*
    alert( 'Item id:'+treeJs.getSelectedItemId()+'\n'+
    'Item text:'+treeJs.getItemText(id )+'\n'+
    'User pai:'+treeJs.getUserData(id,'IDMENU_PAI')+'\n'+
    'User data URL:'+treeJs.getUserData(id,'URL')+'\n'+
    'IMG:'+treeJs.getUserData(id,'IMG_MENU')
    );
    */
    
    // atualizar os campos do formul?rio
    jQuery("#IDMENU").val(treeJs.getSelectedItemId());
    jQuery("#NOM_MENU").val(treeJs.getItemText(id ));
    jQuery("#IDMENU_PAI").val(treeJs.getUserData(id,'IDMENU_PAI'));
    jQuery("#URL").val(treeJs.getUserData(id,'URL'));
    jQuery("#IMG_MENU").val(treeJs.getUserData(id,'IMG_MENU'));
    
}
</script>