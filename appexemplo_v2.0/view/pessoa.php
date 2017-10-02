<?php

$dados = pessoaDAO::selectAll('nome');
var_dump($dados);

$gride = new TGrid( 'gdPessoa' // id do gride
                   ,'Lista de Pessoas' // titulo do gride
                   ,$res 	// array de dados
                   ,null		// altura do gride
                   ,null		// largura do gride
                   ,'idpessoa'// chave primaria
                );

$gride->addColumn('idpessoa','idpessoa',100,'left');
$gride->addColumn('nome','nome',100,'left');
$gride->addColumn('sigla','sigla',100,'left');
//$gride->addSelectColumn('sit_opcoes' ,'Opções','SIT_OPCOES','1=Amarelo,2=Verde');
//$gride->addButton('Alterar 1', NULL, 'btnAlterar1', 'grideAlterar()', NULL, 'editar.gif','editar.gif', 'Alterar registro')->setEnabled( false );
//$gride->addButton('Alterar 2', NULL, 'btnAlterar2', 'grideAlterar()', NULL, null,null, 'Alterar registro')->setEnabled( false );
//$gride->addButton('Excluir', NULL, 'btnExcluir', 'grideAlterar()', NULL, null,null)->setEnabled( false )->setCss('color','red');




$frm = new TForm('Cadastro de Pessoa');
$frm->addHiddenField( 'idpessoa' ); // coluna chave da tabela
$frm->addHtmlField('gride',$gride);
$frm->setAction('Limpar');
$frm->show();
?>