<?php

$frm = new TForm('Cadastro de Tipo de Tipos');

$frm->addTextField('idtipo_de_tipos', 'id', 10, false);
$frm->addTextField('descricao', 'Nome:', 50, false);
$frm->addSelectField('sit_ativo', 'Sit Ativo:', null, 'S=Sim,N=Não', false);


$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'Salvar':
        $vo = new Tipo_de_tiposVO();
        $frm->setVo($vo);
        Tipo_de_tiposDAO::insert($vo);
    //------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
    //--------------------------------------------------------------------
    case 'gd_excluir':
        $id = $frm->get('idtipo_de_tipos') ;
        Tipo_de_tiposDAO::delete($id);
        break;
    //--------------------------------------------------------------------
}


$dados = Tipo_de_tiposDAO::selectAll('descricao');
$gride = new TGrid('gd' // id do gride
, 'Lista de Pessoas' // titulo do gride
, $dados      // array de dados
, null        // altura do gride
, null        // largura do gride
, 'idtipo_de_tipos'  // chave primaria
, 'idtipo_de_tipos|idtipo_de_tipos,descricao|descricao,sit_ativo|sit_ativo');  // update dos campos


$gride->addColumn('idtipo_de_tipos', 'id', 50, 'center');
$gride->addColumn('descricao', 'Descrição', 100, 'left');
$gride->addColumn('sit_ativo', 'Tipo', 50, 'center');


$frm->addHtmlField('gride', $gride);
$frm->setAction('Salvar,Limpar');
$frm->show();
