<?php
defined('APLICATIVO') or die();

$html1 = '<h1>Exemplo controle de transação de banco</h1>';
$html1 = $html1.'<br>'; 
$html1 = $html1.'Ao Clicar executar 3 ações de banco serão executadas';

$frm = new TForm('Exemplo RollBack');
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addHtmlField('html1', $html1, null, null, null, null)->setClass('boxAlert',true);

$frm->addButton('Executar', null, 'Executar', null, null, true, false)->setClass('btnOragen', false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    case 'Executar':
        try{
            if ( $frm->validate() ) {
                $vo = new PedidoVO();
                $frm->setVo( $vo );
                $resultado = Pedido::save( $vo );
                if($resultado==1) {
                    $frm->setMessage('Registro gravado com sucesso!!!');
                    $frm->clearFields();
                }else{
                    $frm->setMessage($resultado);
                }
            }
        }
        catch (DomainException $e) {
            $frm->setMessage( $e->getMessage() );
        }
        catch (Exception $e) {
            MessageHelper::logRecord($e);
            $frm->setMessage( $e->getMessage() );
        }
    break;
    //--------------------------------------------------------------------------------
}

$frm->show();
