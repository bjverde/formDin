<?php
require_once('servicos/autoridades.php');

$primaryKey = 'IDAUTORIDADE';
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
        if ( $frm->validate() ) {
            $vo = new AutoridadeVO();
            $frm->setVo( $vo );
            $resultado = autoridadeDAO::insert( $vo );
            //$resultado = autoriadeGravar($vo);
            if($resultado==1) {
                $frm->setMessage('Registro gravado com sucesso!!!');
                $frm->clearFields();
            }else{
                $frm->setMessage($resultado);
            }
        }
    break;
    //------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
    break;
    //--------------------------------------------------------------------
    case 'gd_excluir':
        $id = $frm->get( $primaryKey ) ;
        $resultado = autoridadeDAO::delete( $id );
        if($resultado==1) {
            $frm->setMessage('Registro excluido com sucesso!!!');
            $frm->clearFields();
        }else{
            $frm->clearFields();
            $frm->setMessage($resultado);
        }
    break;
	//--------------------------------------------------------------------
}

$dados = autoridadeDAO::selectAll('DAT_INCLUSAO');
$gride = new TGrid( 'gd'                   // id do gride
                   ,'Lista de Autoridades' // titulo do gride
                   ,$dados 	    // array de dados
                   ,null		// altura do gride
                   ,null		// largura do gride
                   ,'IDAUTORIDADE' // chave primaria
                   ,$primaryKey.'|'.$primaryKey.',DAT_INCLUSAO|DAT_INCLUSAO,DAT_INICIO|DAT_INICIO,DAT_FIM|DAT_FIM,CARGO|cargo,NOME_PESSOA|NOME_PESSOA,ORDEM|ORDEM'
                );
$gride->addColumn($primaryKey,'id',50,'center');
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