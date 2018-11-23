<?php
defined('APLICATIVO') or die();

$primaryKey = 'IDAUTORIDADE';
$frm = new TForm('Ordem da leitura das Autoridades', 600);
$frm->setFlat(true);
$frm->setMaximize(true);

$html = '<b>Regra de Negocio</b>'
    .'<br>Varias autoridades estarão presentes em um evento no dia X.'
        .'O cerimonial precisa da ordem das autoridades, da mais importante para menos importante. Para fazer a leitura.';
        
        $frm->addHiddenField( 'BUSCAR' ); //Campo oculto para buscas
        $frm->addHiddenField( $primaryKey );   // coluna chave da tabela
        $frm->addHiddenField($primaryKey); // coluna chave da tabela
        $frm->addHtmlField('texto', $html)->setCss('border', '1px solid red');;
        $frm->addHtmlField('separador', null);
        $frm->addDateField('DAT_INCLUSAO', 'Data inclusão', false, null, null, null, null, null, false)->setReadOnly(true);;
        $frm->addDateField('DAT_EVENTO', 'Data Evento:', true);
        $frm->addNumberField('ordem', 'Ordem das autoridades:', 10, true, 0, true, null, 1, 5, true);
        $frm->addTextField('cargo', 'Nome do Cargo:', 50, true);
        $frm->addTextField('nome_pessoa', 'Nome Pessoa:', 50, true);
        
        $frm->addButton('Buscar', null, 'btnBuscar', 'buscar()', null, true, false);
        $frm->addButton('Salvar', null, 'Salvar', null, null, false, false);
        $frm->addButton('Limpar', null, 'Limpar', null, null, false, false);
        
        
        $acao = isset($acao) ? $acao : null;
        switch( $acao ) {
            case 'Salvar':
                try{
                    if ( $frm->validate() ) {
                        $vo = new AutoridadeVO();
                        $frm->setVo( $vo );
                        $resultado = Autoridade::save( $vo );
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
                    $resultado = Autoridade::delete( $id );;
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
                    'IDAUTORIDADE'=>$frm->get('IDAUTORIDADE')
                    ,'DAT_INCLUSAO'=>$frm->get('DAT_INCLUSAO')
                    ,'DAT_EVENTO'=>$frm->get('DAT_EVENTO')
                    ,'ORDEM'=>$frm->get('ORDEM')
                    ,'CARGO'=>$frm->get('CARGO')
                    ,'NOME_PESSOA'=>$frm->get('NOME_PESSOA')
                );
            }
            return $retorno;
        }
        
        if( isset( $_REQUEST['ajax'] )  && $_REQUEST['ajax'] ) {
            $maxRows = ROWS_PER_PAGE;
            $whereGrid = getWhereGridParameters($frm);
            $page = PostHelper::get('page');
            $dados = Autoridade::selectAllPagination( 'DAT_EVENTO, ORDEM', $whereGrid, $page,  $maxRows);
            $realTotalRowsSqlPaginator = Autoridade::selectCount( $whereGrid );
            $mixUpdateFields = $primaryKey.'|'.$primaryKey
            .',DAT_INCLUSAO|DAT_INCLUSAO'
                .',DAT_EVENTO|DAT_EVENTO'
                    .',ORDEM|ORDEM'
                        .',CARGO|CARGO'
                            .',NOME_PESSOA|NOME_PESSOA'
                                ;
                                $gride = new TGrid( 'gd'                        // id do gride
                                    ,'Lista de Autoridades por data' // titulo do gride
                                    );
                                $gride->addKeyField( $primaryKey ); // chave primaria
                                $gride->setData( $dados ); // array de dados
                                $gride->setRealTotalRowsSqlPaginator( $realTotalRowsSqlPaginator );
                                $gride->setMaxRows( $maxRows );
                                $gride->setUpdateFields($mixUpdateFields);
                                $gride->setUrl( 'autoridade.php' );
                                
                                $gride->addColumn($primaryKey,'id');
                                $gride->addColumn('DAT_EVENTO','Data do Evento');
                                $gride->addColumn('ORDEM','Ordem');
                                $gride->addColumn('CARGO','Cargo');
                                $gride->addColumn('NOME_PESSOA','Nome');
                                $gride->addColumn('DAT_INCLUSAO','Data da Inclusão');
                                
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
					,"IDAUTORIDADE":""
					,"DAT_INCLUSAO":""
					,"DAT_EVENTO":""
					,"ORDEM":""
					,"CARGO":""
					,"NOME_PESSOA":""
					};
	fwGetGrid('autoridade.php','gride',Parameters,true);
}
function buscar() {
	jQuery("#BUSCAR").val(1);
	init();
}
</script>