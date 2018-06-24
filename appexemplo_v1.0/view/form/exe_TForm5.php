<?php
defined('APLICATIVO') or die();

d($_REQUEST);

$whereGrid = ' 1=1 ';
$primaryKey = 'IDTEXTO';
$frm = new TForm('Exemplo Form5 - Texto Rico com TinyMCE', 700);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField($primaryKey);   // coluna chave da tabela
$frm->addTextField('TXNOME', 'Nome do Texto', 50, true);
$frm->addDateField('TXDATA', 'Data', 50, true);
$frm->addRadioField('STATIVO', 'Ativo:', true, 'S=SIM,N=Não', null, false, null, 2, null, null, null, false);//->addEvent('onDblclick','dblClick(this)');
$html = 'Instruções. O campo Memo com TinyMCE só funciona com a função de BakcEditor habilita. O campo deve ser obrigatorio para envitar possiveis problemas.';
$frm->addHtmlField('html1', $html, null, 'Dica:', null, 400)->setCss('border', '1px dashed blue');

$frm->addMemoField('TEXTO', 'Texto', 10000, false, 100, 15, true, true, false);
$frm->setRichEdit(true);
//Metodo customizado
//$frm->addJavascript('fwSetHtmlEditorPreview("TEXTO")');

$frm->addJavascript('fwSetHtmlEditor("TEXTO","callBackEditor",false)');


echo 'Valor do Campo: TEXTO =<br>';
echo htmlspecialchars($frm->get('TEXTO'));


$frm->addButton('Buscar', null, 'Buscar', null, null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'Salvar':
        if ($frm->validate()) {
            $vo = new Tb_textoVO();
            $frm->setVo($vo);
            $resultado = Tb_textoDAO::insert($vo);
            if ($resultado==1) {
                $frm->setMessage('Registro gravado com sucesso!!!');
                $frm->clearFields();
            } else {
                $frm->setMessage($resultado);
            }
        }
        break;
    //--------------------------------------------------------------------------------
    case 'Buscar':
        $retorno = array(
                'IDTEXTO'=>$frm->get('IDTEXTO')
                ,'TXNOME'=>$frm->get('TXNOME')
                ,'TXDATA'=>$frm->get('TXDATA')
                ,'STATIVO'=>$frm->get('STATIVO')
                ,'TEXTO'=>$frm->get('TEXTO')
                ,'TX_DATA_INCLUSAO'=>$frm->get('TX_DATA_INCLUSAO')
        );
        $whereGrid = $retorno;
        break;
    //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
    //--------------------------------------------------------------------------------
    case 'gd_excluir':
        $id = $frm->get($primaryKey) ;
        $resultado = Tb_textoDAO::delete($id);
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


$dados = Tb_textoDAO::selectAll($primaryKey, $whereGrid);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',TXNOME|TXNOME,TXDATA|TXDATA,STATIVO|STATIVO,TEXTO|TEXTO,TX_DATA_INCLUSAO|TX_DATA_INCLUSAO';
$gride = new TGrid('gd'        // id do gride
, 'Gride'     // titulo do gride
, $dados        // array de dados
, null          // altura do gride
, null          // largura do gride
, $primaryKey   // chave primaria
, $mixUpdateFields);
$gride->addColumn($primaryKey, 'id', 10, 'center');
$gride->addColumn('TXNOME', 'Nome', 50, 'center');
$gride->addColumn('TXDATA', 'Dat Texto', 50, 'center');
$gride->addColumn('STATIVO', 'Ativo', 20, 'center');
$gride->addColumn('TEXTO', 'TEXTO');
$gride->addColumn('TX_DATA_INCLUSAO', 'Dat Inclusão', 50, 'center');
$frm->addHtmlField('gride', $gride);

$frm->show();
?>

<script>

function callBackEditor(ed) {
    ed.windowManager.alert('Texto Alterado com sucesso!');
    var ed = tinyMCE.get('help');
    ed.setProgressState(1);
    alert( 'salvar\t\t'+ed.getContent());
    ed.setProgressState(0);
    jQuery('#formDinAcao').val('salvar');
    var dados = jQuery("#formdin").serialize();
    dados += '&ajax=1';
    // inicia a requisição ajax
    fwBlockScreen();
    jQuery.ajax({
          url: app_url+app_index_file,
          type: "POST",
          async: true,
          data: dados,
          dataType: 'text',
          containerId:null,
          success: function(res){alert(res);fwUnBlockScreen();  },
          error: function( res ){ alert('Erro!\n\n'+res );fwUnBlockScreen(); }
    });
}
//-----------------------------------------------------------------------------------------------
function fwSetHtmlEditorPreview(textAreaName){
    tinyMCE.init({
        // General options
        mode        : "exact",
        elements    : textAreaName,
        language    :'pt',          
        theme       : "advanced",
        //skin      : "o2k7",
        //skin_variant : "silver",
        
        plugins     : "safari,spellchecker,pagebreak,style,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,tabfocus",
        
        // Theme options
        /*theme_advanced_buttons1 : "preview",
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom"
        */
        content_css : pastaBase+"css/tinyMCE.css",

        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

    })
}
//-----------------------------------------------------------------------------------------------
</script>