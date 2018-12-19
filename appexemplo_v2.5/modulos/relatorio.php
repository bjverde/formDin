<?php
defined('APLICATIVO') or die();

d($_REQUEST);

$primaryKey = 'IDPEDIDO';
$frm = new TForm('Relatorio',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addCssFile('css/css_form02.css');


$frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );   // coluna chave da tabela

$frm->addNumberField('IDPESSOA', 'Cod',4,true,0);
$frm->addTextField('NOM_PESSOA', 'Nome',150,true,70,null,false);



$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false)->setClass('btnOragen', false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false)->setClass('btnOragen', false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'gd_imprimir':
	    try{
	        $frm->redirect('relatorio.php');
	    }
	    catch (DomainException $e) {
	        $frm->setMessage( $e->getMessage() );
	    }
	    catch (Exception $e) {
	        Mensagem::reportarLog($e);
	        $frm->setMessage( $e->getMessage() );
	    }
	    break;
}

$frm->show();
?>