<?php

$primaryKey = 'idautoridade';

$frm = new TForm('Cadastro de Autoridade',600);

$frm->addHiddenField( $primaryKey ); // coluna chave da tabela
$frm->addDateField('dat_inicio','Data Inicio:',true);
$frm->addDateField('dat_fim','Data Fim:',null);
$frm->addTextField('cargo', 'Cargo:',50,true);
$frm->addTextField('nome_pessoa', 'Nome Pessoa:',50,true);
$frm->addNumberField('ordem', 'Ordem:',10,true,0,true,null,1,5,true);

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    case 'Salvar':
        $vo = new AutoridadeVO();
        $frm->setVo( $vo );
        autoridadeDAO::insert( $vo );
    //------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
    //--------------------------------------------------------------------
    case 'gd_excluir':
        $id = $frm->get( $primaryKey ) ;
        autoridadeDAO::delete( $id );
    break;
	//--------------------------------------------------------------------
}


//,$primaryKey.'|'.$primaryKey.',dat_inclusao|dat_inclusao,dat_inicio|dat_inicio,dat_fim|dat_fim,cargo|cargo,nome_pessoa|nome_pessoa,ordem|ordem'  // update dos campos
$dados = autoridadeDAO::selectAll('dat_inicio');
$gride = new TGrid( 'gd'                   // id do gride
                   ,'Lista de Autoridades' // titulo do gride
                   ,$dados 	    // array de dados
                   ,null		// altura do gride
                   ,null		// largura do gride
                   ,$primaryKey  // chave primaria
                   ,',dat_inclusao|dat_inclusao,dat_inicio|dat_inicio,dat_fim|dat_fim,cargo|cargo,nome_pessoa|nome_pessoa,ordem|ordem'  // update dos campos
                );

$gride->addColumn( $primaryKey,'id',50,'center');
$gride->addColumn('dat_inclusao','Data Inclusão',100,'center');
$gride->addColumn('dat_inicio','Data Inicio',100,'center');
$gride->addColumn('dat_fim','Data Fim',100,'center');
$gride->addColumn('cargo','Cargo',100,'left');
$gride->addColumn('nome_pessoa','Nome Pessoa',100,'left');
$gride->addColumn('ordem','Ordem',100,'left');


$frm->addHtmlField('gride',$gride);
$frm->setAction( 'Salvar,Limpar' );
$frm->show();
?>