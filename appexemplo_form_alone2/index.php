<?php

require_once 'includes/constantes.php';
require_once 'includes/config_conexao.php';

//FormDin version: 4.9.2
require_once '../base/classes/webform/TApplication.class.php';
//require_once 'controllers/autoload_audit.php';
require_once 'dao/autoload_audit_dao.php';

var_dump($_REQUEST);

$frm = new TForm('AUDIT - Alcool Use Disorders Identification Test');
$frm->setFlat(true);
$frm->setAutoSize(true);


$frm->addGroupField('gp1', '');

    $listTipo = array(0=>'A',1=>'B',2=>'B',3=>'D',4=>'E');
    $frm->addRadioField('P01', 'P01', true, $listTipo, null, true, null, 5, null, null, null, false, false);

    $listTipo = array(0=>'A',1=>'B',2=>'B',3=>'D',4=>'E');
    $frm->addRadioField('P02', 'P02', true, $listTipo, null, true, null, 5, null, null, null, false, false);

    $listTipo = array(0=>'A',1=>'B',2=>'B',3=>'D',4=>'E');
    $frm->addRadioField('P03', 'P03', true, $listTipo, null, true, null, 5, null, null, null, false, false);

    $listTipo = array(0=>'A',1=>'B',2=>'B',3=>'D',4=>'E');
    $frm->addRadioField('P04', 'P04', true, $listTipo, null, true, null, 5, null, null, null, false, false);

    $listTipo = array(0=>'A',1=>'B',2=>'B',3=>'D',4=>'E');
    $frm->addRadioField('P05', 'P05', true, $listTipo, null, true, null, 5, null, null, null, false, false);

    $listTipo = array(0=>'A',1=>'B',2=>'B',3=>'D',4=>'E');
    $frm->addRadioField('P06', 'P06', true, $listTipo, null, true, null, 5, null, null, null, false, false);

    $listTipo = array(0=>'A',1=>'B',2=>'B',3=>'D',4=>'E');
    $frm->addRadioField('P07', 'P07', true, $listTipo, null, true, null, 5, null, null, null, false, false);

    $listTipo = array(0=>'A',1=>'B',2=>'B',3=>'D',4=>'E');
    $frm->addRadioField('P08', 'P08', true, $listTipo, null, true, null, 5, null, null, null, false, false);

    $listTipo = array(0=>'A',1=>'B',2=>'B',3=>'D',4=>'E');
    $frm->addRadioField('P09', 'P09', true, $listTipo, null, true, null, 5, null, null, null, false, false);

    $listTipo = array(0=>'A',1=>'B',2=>'B',3=>'D',4=>'E');
    $frm->addRadioField('P10', 'P10', true, $listTipo, null, true, null, 5, null, null, null, false, false);
$frm->closeGroup();

$frm->addButton('Salvar', null, 'Salvar', null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = PostHelper::get('formDinAcao'); 
switch( $acao ) {
    //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
    break;
    //--------------------------------------------------------------------------------
    case 'Salvar':
        try{
            $x = $frm->validate();
            if ( $x ) {
                $vo = new PerguntasVO();
                $frm->setVo( $vo );
                $total = $vo->getP01() + $vo->getP02()
                       + $vo->getP03() + $vo->getP04()
                       + $vo->getP05() + $vo->getP06()
                       + $vo->getP07() + $vo->getP08()
                       + $vo->getP09() + $vo->getP10();
                $vo->setTotal($total);
                $dao = new PerguntasDAO();
                $resultado = $dao->insert($vo);
                if( is_int($resultado) && $resultado!=0) {
                    $msg = 'Sua pontuação foi: '. $total;
                    $frm->setMessage($msg);
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
}


$frm->show();
?>
