<?php

$frm = new TForm('Exemplo Campo CPF/CNPJ',220,600);

//$frm->addCpfCnpjField('cpf_cnpj1','CPF/CNPJ:',false)->setExampleText('Mensagem Padrão / Limpar se inconpleto');

$frm->addCpfCnpjField('cpf_cnpj2','CPF/CNPJ:',false,null,true,null,null,null,null,'myCb')->setExampleText('Tratamento no callback');
/**/
$frm->addCpfCnpjField('cpf_cnpj3','CPF/CNPJ:',false,null,true,null,null,'CPF/CNPJ Inválido',false)->setExampleText('Mensagem Customizada / Limpar se inconpleto');
$frm->addCpfCnpjField('cpf_cnpj4','CPF/CNPJ:',false,null,true,null,null,'CPF/CNPJ Inválido',true)->setExampleText('Mensagem Customizada / Não limpar se inconpleto');
$frm->addCpfField('cpf'	,'CPF:',false);
$frm->addCnpjField('cnpj','CNPJ:',false);
/**/
$frm->show();
?>
<script>
function myCb(valido,e,event)
{
	if( valido )
	{
		if (e.value != '' )
		{
			fwAlert('SUCESSO!!!! Cpf/Cnpj está válido');
		}
	}
	else
	{
		fwAlert('Oooooops!!! Cpf/Cnpj está inválido');
		e.value='';
	}
}
</script>