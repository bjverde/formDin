<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
 * Criado por Luís Eugênio Barbosa
 * Essa versão é um Fork https://github.com/bjverde/formDin
 *
 * ----------------------------------------------------------------------------
 * This file is part of Formdin Framework.
 *
 * Formdin Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License version 3
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License version 3
 * along with this program; if not,  see <http://www.gnu.org/licenses/>
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA  02110-1301, USA.
 * ----------------------------------------------------------------------------
 * Este arquivo é parte do Framework Formdin.
 *
 * O Framework Formdin é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da GNU LGPL versão 3 como publicada pela Fundação
 * do Software Livre (FSF).
 *
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

function verifyPath($path){
    $diretorio = str_replace('//','/',$path.'/');
    @mkdir($diretorio,"775",true);
    if( ! file_exists( $diretorio ) ) {
        $diretorio = 0;
    }
    return $diretorio;
}


$dbms_html = 'O FormDin 4.1.0 ou superior tem 3 tipos de grids.'
            .'<ul>'
            .'<li>Grid Simples - sem paginação mostrando todos os registros</li>'
            .'<li>Grid Paginado via Tela - A paginação acontece apenas em tela. Todos os registros são carregados na memoria e paginados via JQuery</li>'
            .'<li>Grid Paginado via SQL - A paginação acontece via banco de dados. Bem mais rapido que paginação via tela, porém no momento disponivel apenas para MySQL e MS SQL Server 2012 ou superior</li>'
            .'</ul>';


$frm = new TForm('Gerador de From, VO e DAO',650,700);
$frm->setFlat(true);
$frm->setMaximize(true);

$frm->addGroupField('gpxForm','Informações do form');
    $frm->addTextField('form_title','Título do formulario:',50,true,50);
    $frm->addTextField('form_dir','Diretório do formulário:',50,true,150,'modulos/');
    $frm->addTextField('form_name','Nome do arquivo formulario:',50,true,50);
$frm->closeGroup();

$frm->addGroupField('gpxEsquema','Informações do Esquema');
    $frm->addHtmlField('html','Em alguns bancos como o MS SQL Server a informação do esquema é nescessaria para as intruções de banco. SE Marcar a opção SIM nas DAOs será incluido a constante SCHEME antes do nome da tabela.',null,null,50)->setCss('border','1px solid blue');
    $frm->addSelectField('sit_const_schema','Constante Esquema:',null,'0=Não,1=Sim',null,null,'0');
$frm->closeGroup();

$frm->addGroupField('gpxFormPag','Form com paginação');
    $frm->addHtmlField('html',$dbms_html,null,null,100)->setCss('border','1px solid blue');
    $gridType = array(GRID_SIMPLE=>'Simples',GRID_SCREEN_PAGINATION=>'Paginação via Tela',GRID_SQL_PAGINATION=>'Paginação via SQL');
    $frm->addSelectField('TPGRID','Escolha o tipo de Gride:',true,$gridType,null,null,'0')->addEvent('onChange','select_change(this)');
    $frm->addGroupField('gpxDBMS');
    $dbType = array(DBMS_MYSQL=>'MySQL',DBMS_MSSQL=>'MS SQL SERVER');
    $frm->addSelectField('TPBANCO','Escolha o tipo de Bando de dados:',null,$dbType,null,null,'0');
    $frm->closeGroup();
$frm->closeGroup();


$frm->addGroupField('gpxDAO','Informações do VO e DAO');
    $frm->addTextField('diretorio','Diretório:',50,true);
    $frm->addTextField('tabela','Nome da Tabela:',30,true);
    $frm->addTextField('coluna_chave','Nome da Coluna Chave:',30);
    $frm->addMemoField('colunas','Colunas:',5000,true,45,20);
$frm->closeGroup();

$frm->setAction('Gerar');

if(!$frm->get('diretorio')) {
    $frm->set('diretorio','dao/');
}

$acao = ( isset($acao) ) ? $acao : '';
switch( $acao ) {
    case 'Gerar':
        if( $frm->validate() ) {
            $diretorio = str_replace('//','/',$frm->get('diretorio').'/');
            @mkdir($diretorio,"775",true);
            if( ! file_exists( $diretorio ) ) {
                $frm->setMessage('Diretório '.$diretorio.' não existe!');
                break;
            }
            $txt = preg_replace('/'.chr(13).'/',',',$frm->get('colunas'));
            $txt = preg_replace('/'.chr(10).'/',',',$txt);
            $txt = preg_replace('/\,\,/',',',$txt);
            $txt = preg_replace('/ /','',$txt);
            $txt = preg_replace('/\,\,/',',',$txt);
            if( substr($txt,-1) ==',') {
                $txt=substr($txt,0,strlen($txt)-1);
            }
            $listColumns = explode(',',$txt);
            $coluna_chave = $frm->get('coluna_chave') ? $frm->get('coluna_chave') : $listColumns[0];
            $TPGRID  = $frm->get('TPGRID');
            $TPBANCO = $frm->get('TPBANCO');
            
            $gerador = new TDAOCreate($frm->get('tabela'), $coluna_chave, $diretorio);
            foreach($listColumns as $k=>$v) {
                $gerador->addColumn($v);
            }
            $showSchema = $frm->get('sit_const_schema');
            $gerador->setShowSchema($showSchema);
            if( $TPGRID == GRID_SQL_PAGINATION){
                $gerador->setWithSqlPagination(TRUE);
                $gerador->setDatabaseManagementSystem($TPBANCO);
            }else{
                $gerador->setWithSqlPagination(FALSE);
            }
            $gerador->saveVO();
            $gerador->saveDAO();
            
            $diretorio = str_replace('//','/',$frm->get('form_dir').'/');
            @mkdir($diretorio,"775",true);
            if( ! file_exists( $diretorio ) ) {
                $frm->setMessage('Diretório '.$diretorio.' não existe!');
                break;
            }
            
            $geradorForm = new TFormCreate();
            $geradorForm->setFormTitle( $frm->get('form_title') );
            $geradorForm->setFormPath( $diretorio );
            $geradorForm->setFormFileName($frm->get('form_name'));
            $geradorForm->setPrimaryKeyTable($frm->get('coluna_chave'));
            $geradorForm->setTableRef($frm->get('tabela'));
            $geradorForm->setListColunnsName($listColumns);
            $geradorForm->setGridType($TPGRID);
            $geradorForm->saveForm();
            
            $frm->setMessage('Fim');
        }
        break;
}

$frm->addJavascript('init()');
$frm->show();
?>
<script>
function init() {
	//fwReadOnly(true,'gpxDBMS', null);
	jQuery("#TPBANCO").attr( 'disabled' , true );
}
function select_change(e) {
	if( e.id == 'TPGRID'){		
		var valueTPGRID = fwGetObj('TPGRID').value;
		if (valueTPGRID == '3'){
			//fwReadOnly(false,'gpxDBMS', null);
			jQuery("#TPBANCO").attr( 'disabled' , false );
		}else{
			//fwReadOnly(true,'gpxDBMS', null);
			jQuery("#TPBANCO").attr( 'disabled' , true );
		}
	}
}
</script>