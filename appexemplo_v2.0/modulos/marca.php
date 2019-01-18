<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDMARCA';
$frm = new TForm('Marca',800,950);
$frm->setFlat(true);
$frm->setMaximize(true);


$frm->addHiddenField( 'BUSCAR' );   //Campo oculto para buscas
$frm->addHiddenField( $primaryKey );//Coluna chave da tabela

$frm->addHiddenField('TIPO','PJ');
$frm->addHiddenField('SIT_ATIVO','S');

//$listPessoa = Pessoa::selectAll();
//$frm->addSelectField('IDPESSOA', 'IDPESSOA',TRUE,$listPessoa,null,null,null,null,null,null,' ',null);

$frm->addGroupField('gpx1','Empresa');
    $frm->addNumberField('IDPESSOA', 'Cod',4,true,0);
    $frm->addTextField('NOM_PESSOA', 'Nome',150,true,70,null,false);
    //Deve sempre ficar depois da definição dos campos
    $frm->setAutoComplete('NOM_PESSOA'
        ,'pessoa'// tabela
        ,'NOME'	 		// campo de pesquisa
        ,'IDPESSOA|IDPESSOA,NOME|NOM_PESSOA' // campo que será atualizado ao selecionar o nome do município <campo_tabela> | <campo_formulario>
        ,true
        ,'TIPO' 		    // campo do formulário que será adicionado como filtro
        ,null				// função javascript
        ,3					// Default 3, numero de caracteres minimos para disparar a pesquisa
        ,500				// 9: Default 1000, tempo após a digitação para disparar a consulta
        ,50					//10: máximo de registros que deverá ser retornado
        , null, null, null, null, true, null, null, true );
$frm->closeGroup();

$frm->addTextField('NOM_MARCA', 'Nome da Marca',45,FALSE,45);


$frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
$frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'Salvar':
		try{
			if ( $frm->validate() ) {
				$vo = new MarcaVO();
				$frm->setVo( $vo );
				$resultado = Marca::save( $vo );
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
	case 'Limpar':
		$frm->clearFields();
	break;
	//--------------------------------------------------------------------------------
	case 'gd_excluir':
		try{
			$id = $frm->get( $primaryKey ) ;
			$resultado = Marca::delete( $id );;
			if($resultado==1) {
				$frm->setMessage('Registro excluido com sucesso!!!');
				$frm->clearFields();
			}else{
				$frm->clearFields();
				$frm->setMessage($resultado);
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


function getWhereGridParameters(&$frm){
	$retorno = null;
	if($frm->get('BUSCAR') == 1 ){
		$retorno = array(
				'IDMARCA'=>$frm->get('IDMARCA')
				,'NOM_MARCA'=>$frm->get('NOM_MARCA')
				,'IDPESSOA'=>$frm->get('IDPESSOA')
		);
	}
	return $retorno;
}

if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
	$maxRows = ROWS_PER_PAGE;
	$whereGrid = getWhereGridParameters($frm);
	$page = PostHelper::get('page');
	$dados = Marca::selectAllPagination( $primaryKey, $whereGrid, $page,  $maxRows);
	$realTotalRowsSqlPaginator = Marca::selectCount( $whereGrid );
	$mixUpdateFields = $primaryKey.'|'.$primaryKey
					.',NOM_MARCA|NOM_MARCA'
					.',IDPESSOA|IDPESSOA'
					.',NOM_PESSOA|NOM_PESSOA'
					;
	$gride = new TGrid( 'gd'              // id do gride
					   ,'Lista de Marcas' // titulo do gride
					   );
	$gride->addKeyField( $primaryKey ); // chave primaria
	$gride->setData( $dados ); // array de dados
	$gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
	$gride->setMaxRows( $maxRows );
	$gride->setUpdateFields($mixUpdateFields);
	$gride->setUrl( 'marca.php' );

	$gride->addColumn($primaryKey,'id');
	$gride->addColumn('NOM_MARCA','Nome da Marca');
	$gride->addColumn('IDPESSOA','id Pessoa',null,'center');
	$gride->addColumn('NOM_PESSOA','Pessoa');

	$gride->show();
	die();
}

$frm->addHtmlField('gride');
$frm->addJavascript('init()');
$frm->show();
?>
<script>
function init() {
	var Parameters = {"BUSCAR":""
					,"IDMARCA":""
					,"NOM_MARCA":""
					,"IDPESSOA":""
					};
	fwGetGrid('marca.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>