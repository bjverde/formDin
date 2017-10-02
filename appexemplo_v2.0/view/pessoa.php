<?php

$dados = pessoaDAO::selectAll('nome');
var_dump($dados);

$gride = new TGrid( 'gdPessoa' // id do gride
                   ,'Lista de Pessoas' // titulo do gride
                   ,$dados 	    // array de dados
                   ,null		// altura do gride
                   ,null		// largura do gride
                   ,'IDPESSOA'  // chave primaria
                );

$gride->addColumn('IDPESSOA','id',100,'left');
$gride->addColumn('NOME','Nome Pessoa',100,'left');
$gride->addColumn('TIPO','Tipo',100,'left');
$gride->addColumn('DAT_INCLUSAO','Data Inclusão',100,'left');



$frm = new TForm('Cadastro de Pessoa');
$frm->addHiddenField( 'IDPESSOA' ); // coluna chave da tabela
$frm->addHtmlField('gride',$gride);
$frm->setAction('Limpar');
$frm->show();
?>