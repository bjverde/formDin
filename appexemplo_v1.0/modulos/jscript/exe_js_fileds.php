<?php
defined('APLICATIVO') or die();

$html1 = 'Os campos: "Somente restrição patrimoniais" e "Prestação de Contas" tem um evento addEvent que mostra campos.'
        .'<br>'
        .'<br>'
        .'<br>O campo "Prestação de Contas" mostra campos "Obrigatorios" porém esses campos não são realmente obrigatorios, apenas aparecem em vermelho simulando um campo obrigatorio. Porém é apenas uma alteração no front-end (fwSetRequired). Se preicsar de uma validar deverá fazer no Back-end (PHP)'
        .'<br>';

$frm = new TForm('Sentença');
$frm->setFlat(true);
$frm->setMaximize(true);
$frm->addCssFile('css/css_formDinv5.css');


$frm->addHtmlField('html1', $html1, null, null, null, null)->setClass('boxAlert',false);


$frm->addGroupField('gpEditar','Campos para alterar:');
$frm->addTextField('Nome', 'Nome do sentenciado',150,true,50);


$listSimNao = array('S'=>'Sim','N'=>'Não');
$STRESTRICAOATOPATRIMONIAL = $frm->addSelectField('STRESTRICAOATOPATRIMONIAL', 'Somente restrição patrimoniais',true,$listSimNao,false,null,null,null,null,null,' ',null);
$STRESTRICAOATOPATRIMONIAL->addEvent('onChange','altera_campos(this)');

$listTipo_ato = array('1'=>'Tipo 1','2'=>'Tipo 2');
$frm->addCheckField('IDTIPOATO', 'Demais limites',false,$listTipo_ato,null,true,null,6);
//$frm->addSelectField('IDTIPOATO', 'IDTIPOATO',true,$listTipo_ato,null,null,null,null,null,null,' ',null);
$frm->addMemoField('DSTIPOATOOUTROS', 'Descrição dos outros limites',800,false,80,3,true,true);

$frm->addDateField('DTSENTENCA', 'Data da Sentença',true);

$listSTPRESTACAOCONTAS = array('S'=>'Sim','N'=>'Dispensa Expressa','A'=>'Sem Menção Expressa');
$STPRESTACAOCONTAS = $frm->addSelectField('STPRESTACAOCONTAS', 'Prestação de Contas',true,$listSTPRESTACAOCONTAS,null,true,null,null,null,null,' ',null);
$STPRESTACAOCONTAS->addEvent('onChange','altera_campos(this)');
$listTPCONTAGEMPRAZO = array('D'=>'Data da decisão/sentença','A'=>'Data da assinatura do termo');
$frm->addSelectField('TPCONTAGEMPRAZO', 'Contragem de prazo a partir da',false,$listTPCONTAGEMPRAZO,false,true,null,null,null,null,' ',null);
$frm->addNumberField('NMPERIODICIDADE', 'Periodicidade (meses)',10,false,0,false,null,1,null,false,null,false,true,true);

$frm->addButton('Alterar', null, 'Alterar', null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);
$frm->closeGroup();

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
    break;
    //--------------------------------------------------------------------------------
    case 'Alterar':
        try{
            if ( $frm->validate() ) {
                $frm->setMessage('Ação alterar chamada');
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

$frm->addJavascript('init()');
$frm->show();
?>

<script>
function init() {
	alteraRestricaoPatrimonial();
	alteraPrestacaoContas();
}
//Essa função foi feita no backend tambem
function alteraRestricaoPatrimonial() {	
	var value = fwGetObj('STRESTRICAOATOPATRIMONIAL').value;
	if ( (value == 'S') || (value =='') ){
		//jQuery("#IDTIPOATO").attr( 'disabled' , true );
		fwSetNotRequired('IDTIPOATO');
		jQuery("#tr_IDTIPOATO").hide();
		//jQuery("#DSTIPOATOOUTROS").attr( 'disabled' , true );
		jQuery("#DSTIPOATOOUTROS").val('');
		jQuery("#tr_DSTIPOATOOUTROS").hide();
	}else{
		//jQuery("#IDTIPOATO").attr( 'disabled' , false );
		fwSetRequired('IDTIPOATO');
		jQuery("#tr_IDTIPOATO").show();
		//jQuery("#DSTIPOATOOUTROS").attr( 'disabled' , false );
		jQuery("#tr_DSTIPOATOOUTROS").show();
	}
}
//Essa função foi feita no backend tambem
function alteraPrestacaoContas(){
	var value = fwGetObj('STPRESTACAOCONTAS').value;
	if ( value == 'S' ){
		//jQuery("#TPCONTAGEMPRAZO").attr( 'disabled' , false );
		fwSetRequired('TPCONTAGEMPRAZO');
		jQuery("#TPCONTAGEMPRAZO_area").show();
		//jQuery("#NMPERIODICIDADE").attr( 'disabled' , false );
		fwSetRequired('NMPERIODICIDADE');
		jQuery("#NMPERIODICIDADE_area").show();
	}else{
		//jQuery("#TPCONTAGEMPRAZO").attr( 'disabled' , true );
		jQuery("#TPCONTAGEMPRAZO").val('');
		fwSetNotRequired('TPCONTAGEMPRAZO');
		jQuery("#TPCONTAGEMPRAZO_area").hide();
		//jQuery("#NMPERIODICIDADE").attr( 'disabled' , true );
		jQuery("#NMPERIODICIDADE").val('');
		fwSetNotRequired('NMPERIODICIDADE');
		jQuery("#NMPERIODICIDADE_area").hide();
	}
}
function altera_campos(e) {
	if( e.id == 'STRESTRICAOATOPATRIMONIAL'){		
		alteraRestricaoPatrimonial();
	}
	if( e.id == 'STPRESTACAOCONTAS'){		
		alteraPrestacaoContas();
	}
}
</script>
