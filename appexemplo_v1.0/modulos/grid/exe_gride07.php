<?php
d($_REQUEST);
$frm = new TForm('Gride 07 - exemplo Evento',300,700);

// simulação de dados para o gride
$dados = null;
$dados['ID_TABELA'][] = 1;
$dados['NM_TABELA'][] = 'Linha1';
$dados['ST_TABELA'][] = 'S';
$dados['SIT_OPCOES'][] = '1=>Um,2=>Dois';

$dados['ID_TABELA'][] = 2;
$dados['NM_TABELA'][] = 'Linha2';
$dados['ST_TABELA'][] = 'S';
$dados['SIT_OPCOES'][] = '3=Tres,4=>Quatro';

$dados['ID_TABELA'][] = 3;
$dados['NM_TABELA'][] = 'Linha3';
$dados['ST_TABELA'][] = 'N';
$dados['SIT_OPCOES'][] = '3=Tres,4=>Quatro';


$html ='Os botões só funcionam depois das linha dos gride selecionadas'; 
$frm->addHtmlField('html1',$html,null,'Dica:',null,200)->setCss('border','1px dashed blue');
$gride = new TGrid( 'gdTeste' // id do gride
					,'Título do Gride' // titulo do gride
					,$dados 	// array de dados
					,null		// altura do gride
					,null		// largura do gride
					,'ID_TABELA'// chave primaria
					);

$gride->addCheckColumn('st_tabela','Selecione','ST_TABELA','NM_TABELA')->setEvent('onClick','chkClic()');
$gride->addColumn('nm_tabela','Nome',100,'left');
$gride->addSelectColumn('sit_opcoes' ,'Opções','SIT_OPCOES','1=Amarelo,2=Verde');
$gride->addButton('Alterar 1', NULL, 'btnAlterar1', 'grideAlterar()', NULL, 'editar.gif','editar.gif', 'Alterar registro')->setEnabled( false );
$gride->addButton('Alterar 2', NULL, 'btnAlterar2', 'grideAlterar()', NULL, null,null, 'Alterar registro')->setEnabled( false );
$gride->addButton('Excluir', NULL, 'btnExcluir', 'grideAlterar()', NULL, null,null)->setEnabled( false )->setCss('color','red');
//$gride->addButton('Abrir Redirect 2', 'btnRedirect2', 'btnRedirect2', 'grideRedirect2()', 'Redirecionar ?', null,null,null,true)->setCss('color','blue');
$gride->addButton('Ir para Redirect 2', 'btnRedirect2', null, null, null, null,null,null,true)->setCss('color','blue');

// função de callback da criação das celulas
$gride->setOnDrawCell('gdAoDesenharCelula');
// campo html para exibir o gride
$frm->addHtmlField('gride',$gride);


$acao = isset($acao) ? $acao : null;
d($acao);
switch( $acao ) {
	case 'Ir submit':
		//Redirect só funciona se o arquivo estiver na pasta modulos
		$frm->redirect('exe_redirect_form2.inc','Redirect realizado com sucesso. Você está agora no 2º form.',true);
		break;
		//------------------------------------------------------------------
	case 'Ir Ajax':
		//Redirect só funciona se o arquivo estiver na pasta modulos
		$frm->redirect('exe_redirect_form2.inc', 'Redirect realizado com sucesso. Você está agora no 2º form.', false, null );
		break;
		//--------------------------------------------------------------------
}

$frm->setAction('POST PAGINA');
// exibir o formulário
$frm->show();


function gdAoDesenharCelula($rowNum,$cell,$objColumn,$aData,$edit){
	if( $objColumn->getFieldName() == 'SIT_OPCOES')	{
		$edit->setVisible( false );
	}
}
?>
<script>
function chkClic(e, linha) {
	// mostrar o campo select
    if( jQuery(e).is(':checked') )   {
    	jQuery("#sit_opcoes_"+linha).show();

    	// mostrar o botão alterar da linha
	    //jQuery("#gdteste_td_"+linha+" img").show(); // se tiver utilizando imagem
		//jQuery("#gdteste_td_"+linha+" button").show(); // se não estiver utilizando imagem
		jQuery("#gdteste_td_"+linha+" button").removeAttr('disabled');
		jQuery("#gdteste_td_"+linha+" img").removeAttr('disabled');
    }
    else // esconder o botao alterar e o  campo select
    {
    	jQuery("#sit_opcoes_"+linha).hide();
		//jQuery("#gdteste_td_"+linha+" img").hide(); // se tiver utilizando imagem
		//jQuery("#gdteste_td_"+linha+" button").hide(); // se não tiver utilizando imagem
		jQuery("#gdteste_td_"+linha+" button").attr('disabled','true');
		jQuery("#gdteste_td_"+linha+" img").attr('disabled','true');

    }
}

function grideAlterar(fields, values, idGride, linha) {
	alert( 'Alterar..Linha: '+linha);
}

function grideRedirect2(fields, values, idGride, linha) {
	alert( 'Cliclou na linha: '+linha+', agora será redirecionado para o modulo Redirect2');
}

// esconder todos os botoes alterar ao iniciar o formulário
jQuery("[name=btnAlterar]").each(
  function()
  {
  	//jQuery(this).hide();
  	//jQuery(this).hide();
  }
)

</script>