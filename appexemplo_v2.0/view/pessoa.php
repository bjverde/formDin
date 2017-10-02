<?php

$frm = new TForm('Cadastro de Pessoa');

$frm->addHiddenField( 'IDPESSOA' ); // coluna chave da tabela
$frm->addTextField('NOME', 'Nome:',50,true);
$frm->addSelectField('TIPO'	, 'Tipo Pessoa:',null,'PF=Pessoa física,PJ=Pessoa jurídica',false);
$frm->addTextField('DAT_INCLUSAO', 'Data:',50,false);
//$frm->addDateField('DAT_INCLUSAO','Data:',null);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    case 'Salvar':
        if ( $frm->validate() ) {
            $vo = new PessoaVO();
            $frm->setVo( $vo );
            $resultado = pessoaDAO::insert( $vo );
            if($resultado==true) {
                $frm->setMessage('Registro gravado com sucesso!!!');
                $frm->clearFields();
            }
        }
    //------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
    //--------------------------------------------------------------------
    case 'gd_excluir':
        $id = $frm->get( 'IDPESSOA' ) ;
        pessoaDAO::delete( $id );
    break;
	//--------------------------------------------------------------------
}


$dados = pessoaDAO::selectAll('nome');
$gride = new TGrid( 'gd' // id do gride
                   ,'Lista de Pessoas' // titulo do gride
                   ,$dados 	    // array de dados
                   ,null		// altura do gride
                   ,null		// largura do gride
                   ,'IDPESSOA'  // chave primaria
                   ,'IDPESSOA|IDPESSOA,NOME|NOME,TIPO|TIPO,DAT_INCLUSAO|DAT_INCLUSAO'  // update dos campos
                );

$gride->addColumn('IDPESSOA','id',50,'center');
$gride->addColumn('NOME','Nome Pessoa',100,'left');
$gride->addColumn('TIPO','Tipo',50,'center');
$gride->addColumn('DAT_INCLUSAO','Data Inclusão',100,'center');


$frm->addHtmlField('gride',$gride);
$frm->setAction( 'Salvar,Limpar' );
$frm->show();
?>