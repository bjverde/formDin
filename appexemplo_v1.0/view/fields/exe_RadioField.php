<?php
$acao = !isset($acao) ? '' : $acao;

$frm = new TForm('Exemplo do Campo Radiobutton');
$frm->setFlat(true);
$frm->addGroupField('gp1', 'Grupo 1');
    $frm->addRadioField('sit_cancelado1', 'Ativo:', true, 'S=SIM,N=Não', null, false, null, 2, null, null, null, false);//->addEvent('onDblclick','dblClick(this)');
    $listGenero = array('M'=>'<span tooltip="true" title="Sexo Masculino">Masculino</span>','F'=>'<span tooltip="true" title="Sexo Feminino">Feminino</span>');
    $frm->addRadioField('sit_genero', 'Genero com Tooltip:', true, $listGenero, null, false, null, 2, null, null, null, false);
    $frm->addRadioField('sit_genero2', 'Genero 2 s/quebra:', true, 'M=Masculino,F=Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino ', null, false, null, 1, 400, null, null, false, true);
    $frm->addRadioField('sit_genero3', 'Genero 3 c/quebra:', true, 'M=Masculino,F=Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino Feminino ', null, false, null, 1, 400, null, null, false, false);
    $listTipo = array(1=>'A',2=>'B',3=>'B',4=>'D',5=>'E',6=>'F',7=>'G',8=>'H',9=>'I',10=>'J');
    $frm->addRadioField('sit_genero3', 'Em 5 Colunas:', false, $listTipo, null, true, null, 5, null, null, null, false, false);
$frm->closeGroup();

if ($acao=='Validar') {
    $frm->validate();
}

$frm->addButton('Validar Submetendo', 'Validar');
$frm->addButton('Validar Form Js', null, 'btnValidarJs', 'if( fwValidateForm()){alert("Ok")}');
$frm->addButton('Validar Campo Js', null, 'btnValidarFieldJs', 'if( fwValidateFields("sit_cancelado1")){alert("Ok")}');
$frm->addButton('Validar Grupo', null, 'btnValidarGrupo', 'fwValidateFields(null,"gp1")');
$frm->addButton('Limpar Campo Js', null, 'btnLimpar', 'fwSetFields("sit_cancelado")');

// exibir o formulário
$frm->show();
?>
<script type="text/javascript">
function dblClick(e)
{
    console.log( e.checked );
    e.checked = false;

}
</script>
