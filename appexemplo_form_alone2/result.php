<?php

require_once 'includes/constantes.php';
require_once 'includes/config_conexao.php';

//FormDin version: 4.9.2
require_once '../base/classes/webform/TApplication.class.php';
//require_once 'controllers/autoload_audit.php';
require_once 'dao/autoload_audit_dao.php';

$primaryKey = 'ID';

$frm = new TForm('Result');
$frm->setFlat(true);
$frm->setAutoSize(true);

$frm->addLinkField('Link2','','index',null,'index.php','new');
$frm->addLinkField('Link1','','Layout 2',null,'index2.php','new');

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
    break;
    //--------------------------------------------------------------------------------
    case 'Salvar':
        try{
            if ( $frm->validate() ) {
                $vo = new PerguntasVO();
                $frm->setVo( $vo );
                $controller = new Perguntas();
                $resultado = $controller->save( $vo );
                if( is_int($resultado) && $resultado!=0 ) {
                    $frm->addMessage(Message::GENERIC_SAVE);
                    $frm->clearFields();
                }else{
                    $frm->addMessage($resultado);
                }
            }
        }
        catch (DomainException $e) {
            $frm->addMessage( $e->getMessage() ); //addMessage evita o problema do setMessage
        }
        catch (Exception $e) {
            MessageHelper::logRecord($e);
            $frm->addMessage( $e->getMessage() ); //addMessage evita o problema do setMessage
        }
    break;
    //--------------------------------------------------------------------------------
    case 'gd_excluir':
        try{
            $id = $frm->get( $primaryKey ) ;
            $controller = new Perguntas();
            $resultado = $controller->delete( $id );
            if($resultado==1) {
                $frm->addMessage(Message::GENERIC_DELETE);
                $frm->clearFields();
            }else{
                $frm->addMessage($resultado);
            }
        }
        catch (DomainException $e) {
            $frm->addMessage( $e->getMessage() ); //addMessage evita o problema do setMessage
        }
        catch (Exception $e) {
            MessageHelper::logRecord($e);
            $frm->addMessage( $e->getMessage() ); //addMessage evita o problema do setMessage
        }
    break;
}


function getWhereGridParameters(&$frm)
{
    $retorno = null;
    if($frm->get('BUSCAR') == 1 ){
        $retorno = array(
                'ID'=>$frm->get('ID')
                ,'DTINSERT'=>$frm->get('DTINSERT')
                ,'TOTAL'=>$frm->get('TOTAL')
                ,'P01'=>$frm->get('P01')
                ,'P02'=>$frm->get('P02')
                ,'P03'=>$frm->get('P03')
                ,'P04'=>$frm->get('P04')
                ,'P05'=>$frm->get('P05')
                ,'P06'=>$frm->get('P06')
                ,'P07'=>$frm->get('P07')
                ,'P08'=>$frm->get('P08')
                ,'P09'=>$frm->get('P09')
                ,'P10'=>$frm->get('P10')
        );
    }
    return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
    $maxRows = ROWS_PER_PAGE;
    $whereGrid = getWhereGridParameters($frm);
    $controller = new PerguntasDAO();
    $page = PostHelper::get('page');
    $dados = $controller->selectAllPagination( $primaryKey.' DESC', $whereGrid, $page,  $maxRows);
    $realTotalRowsSqlPaginator = $controller->selectCount( $whereGrid );
    $mixUpdateFields = $primaryKey.'|'.$primaryKey
                    .',DTINSERT|DTINSERT'
                    .',TOTAL|TOTAL'
                    .',P01|P01'
                    .',P02|P02'
                    .',P03|P03'
                    .',P04|P04'
                    .',P05|P05'
                    .',P06|P06'
                    .',P07|P07'
                    .',P08|P08'
                    .',P09|P09'
                    .',P10|P10'
                    ;
    $gride = new TGrid( 'gd'                        // id do gride
    				   ,'Gride with SQL Pagination. Qtd: '.$realTotalRowsSqlPaginator // titulo do gride
    				   );
    $gride->addKeyField( $primaryKey ); // chave primaria
    $gride->setData( $dados ); // array de dados
    $gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
    $gride->setMaxRows( $maxRows );
    $gride->setUpdateFields($mixUpdateFields);
    $gride->setUrl( 'perguntas.php' );

    $gride->addRowNumColumn(); //Mostra Numero da linha
    $gride->addColumn($primaryKey,'id');
    $gride->addColumn('DTINSERT','Data Insert');
    $gride->addColumn('TOTAL','TOTAL');
    $gride->addColumn('P01','P01');
    $gride->addColumn('P02','P02');
    $gride->addColumn('P03','P03');
    $gride->addColumn('P04','P04');
    $gride->addColumn('P05','P05');
    $gride->addColumn('P06','P06');
    $gride->addColumn('P07','P07');
    $gride->addColumn('P08','P08');
    $gride->addColumn('P09','P09');
    $gride->addColumn('P10','P10');


    $gride->show();
    die();
}

$frm->addHtmlField('gride');
$frm->addJavascript('init()');
$frm->show();

?>
<script>
function init() {
    //fwFullScreen(); //Habilitar iniciar maximizado
    var Parameters = {"BUSCAR":""
                    ,"ID":""
                    ,"DTINSERT":""
                    ,"TOTAL":""
                    ,"P01":""
                    ,"P02":""
                    ,"P03":""
                    ,"P04":""
                    ,"P05":""
                    ,"P06":""
                    ,"P07":""
                    ,"P08":""
                    ,"P09":""
                    ,"P10":""
                    };
    fwGetGrid('perguntas.php','gride',Parameters,true);
}
function buscar() {
    jQuery("#BUSCAR").val(1);
    init();
}
</script>