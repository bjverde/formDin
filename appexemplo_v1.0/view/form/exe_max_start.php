<?php
//var_dump($_REQUEST);
d($_REQUEST);

$frm = new TForm('Exemplo Form - Inicia já Maximizador');
$frm->setFlat(true);
$frm->setShowCloseButton(false);

$html1 = 'veja o metodo: <i>addJavascript e fwFullScreen</i>.
          <br>
          <br>';

$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');


$frm->addButton('Limpar', null, 'Limpar', null, null, true, false);

$acao = isset($acao) ? $acao : null;
switch ($acao) {
    //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
}
$frm->addJavascript('init()');
$frm->show();
?>
<script>
function init() {
	fwFullScreen('formdin');
}
</script>