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
 * Este programa é distribuí1do na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licen?a Pública Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

/**
 * Classe para criação de formulário para entrada de dados
 */
$acao = !isset( $acao ) ? '' : $acao;

if( !isset( $_POST[ 'moduloId' ] ) && isset( $_REQUEST[ 'moduloId' ] ) )
{
	$_POST[ 'moduloId' ] = $_REQUEST[ 'moduloId' ];
}
if( !isset( $_POST[ 'modulo' ] ) && isset( $_REQUEST[ 'modulo' ] ) )
{
	$_POST[ 'modulo' ] = $_REQUEST[ 'modulo' ];
}
if( isset( $_POST[ 'formDinAcao' ] ) )
{
	if( !$acao )
	{
		$acao = $_POST[ 'formDinAcao' ];
	}
}
if( isset( $_POST[ 'moduloId' ] ) && !isset( $moduloId ) )
{
	$moduloId = $_POST[ 'moduloId' ];
}
if( isset( $_POST[ 'modulo' ] ) && !isset( $modulo ) )
{
	$modulo = $_POST[ 'modulo' ];
}

if ( !function_exists( 'formdin_autoload') )
{
	function formdin_autoload( $class_name )
	{
		require_once $class_name . '.class.php';
	}
	spl_autoload_register('formdin_autoload');
}
/**
 * Classe para criação de formulários web para entrada de dados
 * @author Luis Eugênio Barbosa
 */
class TForm Extends TBox
{
	static private $errors;
	static private $instance;
	static private $hasRequiredField;
	static private $onlineDocIgnoreFields;
	static private $onlineDocFields;
	static private $publicMode;
	static private $shortCuts;

	private $javascript;
	public $table;
	private $title;
	public $header;
	public $headerCloseButton;
	private $showCloseButton;
	public $body;
	public $footer;
	private $name;
	private $displayControls;
	private $method;
	private $action; // arquivo para onde será submetido o formulário
	private $columns;
	private $footerButtons;
	private $actions; // botões das ações do formulário.
	public $flat;
	private $focusField;
	private $messages;
	private $messagePopUp;
	private $selectsCombinados;
	private $autocompleteFields;
	private $onlineSearchs;
	private $onlineCruds;
	private $currentContainer;
	private $showHeader;
	private $prototypeId;
    private $jsFiles;
	private $cssFiles;
	private $showOnlyTagForm;
	private $autoIncludeJsCss;
	private $pdfs;
	private $enctype;
	private $onClose;
	private $onBeforeClose;
	private $noWrap;
	private $fade;
	private $overflowY;
	private $overflowX;
	private $confirmOnClose;
	private $richEdit;
	private $onlineDoc;
	private $onlineDocReadOnly;
	private $arrVar;
	private $F5Enabled;
	private $customHintEnabled;
	private $colorHighlightBackground;
	private $autoSize;
	private $message_area;
	private $showMessageAlert;
	private $verticalAlign;
	private $horizontalAlign;
	private $onDrawRow;
	private $onDrawField;
	private $returnAjaxData;
	private $onlineDocHeight;
	private $onlineDocWidth;
	private $screenPosition;
	private $onMaximize;
	private $formGridOffLine;
	private $maximize;
	private $requiredFieldText;
	private $appFitFormHeight;
	private $labelsAlign;


	/**
	 * Método construtor da classe
	 *
	 * <code>
	 * 	$frm = new TForm('Título do Formuláio');
	 * 	$frm->show();
	 * </code>
	 *
	 * @param string $strTitle - titulo do formulário
	 * @param string $strHeight - altura em pixels - padrão=400px
	 * @param string $strWidth - largura em pixels - padrão=800px
	 * @param bool $strFormName - nome do formulario para criação da tag form. Padrão=formdin
	 * @param string $strMethod - metodo GET ou POST, utilizado pelo formulario para submeter as informações. padrão=POST
	 * @param string $strAction - página/url para onde os dados serão enviados. Padrão = propria página
	 * @param boolean $boolPublicMode - ignorar mensagem fwSession_exprired da aplicação e não chamar atela de login
	 *
	 * @return TForm - instaância da classe
	 */
	public function __construct( $strTitle=null, $strHeight=null, $strWidth=null, $strFormName=null, $strMethod=null, $strAction=null,$boolPublicMode=null )
	{
		// todo formulario tem que ter uma largura e uma altura
		//$strWidth = ( int ) $strWidth == 0 ? 800 : $strWidth;
		//$strHeight = ( int ) $strHeight == 0 ? 400 : $strHeight;
		$strFormName = is_null( $strFormName ) ? "formdin" : $strFormName;
		// se não tiver sido informado o nome, gerar um aleatoriamente
		$strFormName = (( string ) $strFormName == "") ? "form" . mt_rand( 1, 100 ) : $strFormName;
		parent::__construct( $strFormName, $strWidth, $strHeight );
		$this->setFieldType( 'form' );
		$this->setFlat( false );
		$this->setMaximize(false); // não permitir maximizar com duplo clique
		$this->setShowHtmlTag( true );
		$this->setShowCloseButton( true );
		$this->setShowMessageAlert(true);
		$this->setConfirmOnClose( true );
		$this->name = $strFormName;
		$this->method = ($strMethod === null) ? 'POST' : $strMethod;
		$this->action = $strAction;

		$this->setRequiredFieldText('Preenchimento Obrigatório');
		$isForm=false; // pode ser uma aba ou um grupo
		$isAjax = ( isset( $_REQUEST[ 'ajax' ] ) && $_REQUEST[ 'ajax' ] === 1 );
		if( ! self::$instance )
		{
			$isForm=true;
			if( !$this->getWidth())
			{
				$this->setWidth(800);
			}
			if( ! $this->getHeight())
			{
				$this->setHeight(400);
			}
			self::$instance = $this;
			self::$hasRequiredField=false;
			$this->setPosition(null);
			$this->pdfs = null;
			$this->disableF5(); // não permitir atualizar a página com F5
			$this->setFade( 150 ); // habilitar o efeito fade-in para exibir o formulario
			$this->addJsFile( 'ajax.js' );
			$this->addJsFile( 'FormDin3.js' );
			$this->addJsFile( 'FormDin4.js' );
			$this->addJsFile( 'FormDin4Ajax.js' );
			
			
			if(!defined('MIGRATE_JQUERY')){ define('MIGRATE_JQUERY',FALSE); }
			if(MIGRATE_JQUERY){
				$this->addJsFile('http://code.jquery.com/jquery-1.9.1.js');
				$this->addJsFile('http://code.jquery.com/jquery-migrate-1.4.1.js');
				$this->addJsFile( 'jquery/js_new/jquery.metadata.js' );
				$this->addJsFile( 'jquery/js_new/jquery.corner.js' );
			}else{
				$this->addJsFile( 'jquery/jquery.js' );
				$this->addJsFile( 'jquery/jquery.metadata.js' );
				$this->addJsFile( 'jquery/jquery.corner.js' );
			}
			$this->addJsFile( 'jquery/jlayout/jquery.jlayout-1.3.js');
			$this->addJsFile( 'jquery/jquery-ui-all.js');
			$this->addJsFile( 'jquery/jAlert/jquery.alerts.js' );
			$this->addCssFile('jquery/jAlert/jquery.alerts.css' );
			$this->addCssFile('jquery/ui/base/base.css' );
          	$this->addJsFile( 'jquery/shortcuts/jquery.shortcuts.min.js' );
          	$this->addJsFile( 'jquery/tablesorter/jquery.tablesorter.min.js' );
			$this->addCssFile('jquery/tablesorter/themes/blue/formdin.css' );

			//$this->addJsFile( 'jquery/simplemodal/jquery.simplemodal.js' );
			$this->addJsFile( 'jquery/tooltip/jquery.tooltip.js' );
			$this->addJsFile( 'jquery/jquery.meio.mask.min.js' );
			$this->addJsFile( 'jquery/jquery.priceFormat.js' );
			$this->addCssFile( 'jquery/tooltip/jquery.tooltip.css' );
			$this->addCssFile( 'jquery/confirm/confirm.css' );
			$this->addJsFile( 'calendario/calendar.js' );
			$this->addJsFile( 'calendario/calendar-br.js' );
			$this->addJsFile( 'calendario/calendar-setup.js' );
			$this->addCssFile( 'calendario/calendar-win2k-cold-1.css' );
			$this->addCssFile( 'jquery/ui/base/base.css' );
			//$this->addJsFile( 'sorttable.js' );
			$this->addCssFile( 'FormDin3.css' );
			$this->addCssFile( 'FormDin4.css' );
			$this->addJsFile( 'lazyload/lazyload-min.js' );
			$this->addJsFile( 'jquery/jquery.qtip.min.js' );;

			// area de mensagem no topo do formulário
			$this->message_area = $this->addHtmlField( $this->getId() . '_msg_area',null,null,null);

			$btn = new TButton( 'btn_close_' . $this->getId() . '_msg_area', 'Fechar', null, 'fwHideMsgArea("'.$this->getName().'")', null, 'fwbtnclosered.jpg', null, 'Fechar mensagem' );
			$btn->setCss( 'float', 'right' );
			$btn->setCss( 'cursor', 'pointer' );
			$btn->setCss('visibility','visible');

			$this->message_area->add( $btn );
			$this->message_area->add( '<div id="' . $this->getId() . '_msg_area_content' . '"></div>' );
			$this->message_area->setCss( 'visibility', 'visible' );
			$this->message_area->setCss( 'width', '0px' );
			$this->setPublicMode($boolPublicMode);
			// campo oculto para guardar a página que chamou;
			$this->addHiddenField( 'fw_back_to' )->setProperty('noClear','true'); // evitar que a funcao js fwClearFields() limpe este campo
					// se for uma requisição ajax, capturar as saidas, para que a função prepareReturnAjax possa processar o contúdo
			if( $isAjax  && ob_get_level() == 0 )
			{
				ob_start();
			}
		}
		// exibir o titulo do formulário
		$this->setShowHeader( true );
		// controle interno para utilização dos recursos de janela da biblioteca prototype
		if( isset( $_REQUEST[ 'modalWinId' ] ) )
		{
			$this->addHiddenField( 'modalWinId')->setProperty('noClear','true'); // evitar que a funcao js fwClearFields() limpe este campo
		}
		if( isset( $_REQUEST[ 'prototypeId' ] ) )
		{
			$this->setPrototypeId( $_REQUEST[ 'prototypeId' ] );
		}
		$this->setAutoIncludeJsCss( true );  // incluir os arquivos css e javascripts necessários para o funcionamento do formulário
		$this->enableCustomHint(); // habilitar os tooltips personalizados estilo balão

		// definir fundo azul claro para os campos que possuirem title ( tooltip )
		$this->setColorHighlightBackground( '#E4F2FF' );

		// largura padrão para os campos da primeira coluna do formulário
		$this->setColumns( array( 120 ) );
		// criar a estrutura da tabela que formará o formulário
		$this->table = new TTable( $this->getId() . '_table' );
		$this->table->setCss( 'width', '100%' );
		$this->table->setCss( 'height', '100%' );
		$this->table->setAttribute('width','100%'); // a table de dentro do grupo deve ocupar a largura toda do grupo ou formulario
		$this->table->setCss( "background-color", "transparent" );
		$this->table->setCss( 'text-align', 'left' ); // alinhar os campos à esquerda
		$this->table->setProperty( "cellspacing", "0" );
		$this->table->setProperty( "cellpadding", "0" );
		$this->table->setProperty( "border", "0" );

		$this->header = new TTableCell();
		$this->header->setId( $this->getId() . '_header' );

		$this->headerCloseButton = new TTableCell();
		$this->headerCloseButton->setClass( 'fwTitleBarButtonArea' );

		$this->header->setClass( 'fwTitleBar' );
		$this->setTitle( $strTitle );

		// criar o corpo do formulario
		$this->body = new TElement( "div" );
		$this->body->setId( $this->getId() . '_body' );
		$this->body->setCss( "height", (( int ) $this->getHeight() - 70) . "px" );
		$this->body->setCss( "overflow", "hidden" );
		$this->body->setCss( "overflow-y", "auto" );
		$this->body->setCss( "overflow-x", "hidden" );

		$this->body->setCss( "margin", "0" );
		$this->body->setCss( "padding", "0" );
		$this->body->setCss( "border", "none" );
		$this->body->setCss( "display", "block" );
		$this->body->setCss( "padding-left", "3" );
		$this->body->setCss( "padding-top", "3" );
		if( $this->getCss( "border" ) == 'none' )
		{
			$this->body->setCss( "border-top", '1px solid silver' );
			$this->body->setCss( "border-bottom", '1px solid silver' );
		}
		// criar o rodapé
		$this->footer = new TTableCell();
		$this->footer->setId( $this->getId() . '_footer' );
		$this->footer->setProperty( "colspan", "2" );
		$this->footer->setCss( "height", "25px" );
		$this->footer->setCss( 'border-bottom', $this->header->getCss( 'border-bottom' ) );
		$this->footer->setCss( 'border', 'none' );
		$this->footer->setCss( 'text-align', 'center' );
		if( !defined('APLICATIVO'))
		{
			define('APLICATIVO','FORMDIN');
		}
		if( isset($_POST['modulo'] ) && isset( $_SESSION[ APLICATIVO ][ $_POST[ 'modulo' ] ][ 'post' ] ) )
		{
			$_POST = $_SESSION[ APLICATIVO ][ $_POST[ 'modulo' ] ][ 'post' ];
			$_POST[ 'formDinAcao' ] = '';
			unset( $_SESSION[ APLICATIVO ][ $_POST[ 'modulo' ] ][ 'post' ] );
		}
		if( $isForm && !$this->getPublicMode() && isset( $_POST['fwSession_expired'] ) && $_POST['fwSession_expired']== true )
		{
			if( ! $isAjax )
			{
				$this->show();
			}
			die();
		}

		/*
		$this->message_area = $this->addHtmlField( $this->getId() . '_msg_area' ,null,null,null,null,1);
		$btn = new TButton( 'btn_close_' . $this->getId() . '_msg_area', 'Fechar', null, 'fwHideMsgArea("'.$this->getName().'")', null, 'fwbtnclosered.jpg', null, 'Fechar mensagem' );
		$btn->setCss( 'float', 'right' );
		$btn->setCss( 'cursor', 'pointer' );
		$btn->setCss('visibility','visible');
		$this->message_area->add( $btn );
		$this->message_area->add( '<div id="' . $this->getId() . '_msg_area_content' . '"></div>' );
		//$this->message_area->setCss( 'visibility', 'visible' );
		$this->message_area->setCss( 'visibility', 'visible' );
		//$this->message_area->setCss( 'height', '1' );
		// campo oculto para guardar quem chamou o formulário
		$this->addHiddenField( 'fw_back_to' );
		*/
	}
	/**
	 * Exibe no browser ou devolve o html do formulário dependendo do parametro $print
	 *
	 * $print = true - exibe o formulário no browser
	 * $print = false - retorna o html do formulário
	 *
	 * @param boolean $print
	 * @return mixed
	 */
	public function show( $print=true, $flat=false )
	{
		$boolAjax = ( isset( $_REQUEST[ 'ajax' ] ) && $_REQUEST[ 'ajax' ] == 1);
		// colocar os ids nos objeto do formulario
		$this->table->setId( $this->getId() . '_table' );
		$this->header->setId( $this->getId() . '_header' );
		$this->body->setId( $this->getId() . '_body' );
		$this->footer->setId( $this->getId() . '_footer' );
		// ajustar a variavel $_POST['modulo']. Quando o $_POST é passado para a classe banco
		// no lugar do bvars, os valores das chaves retornam em caixa alta
		if( isset( $_POST[ 'MODULO' ] ) )
		{
			$_POST[ 'modulo' ] = $_POST[ 'MODULO' ];
			$_GET[ 'modulo' ] = $_POST[ 'MODULO' ];
		}
		// não deixar a classe TBox mostrar  as barras de rolagem lateral e inferior
		if( $this->getFieldType() != 'group' )
		{
			$this->divBody->setCss( 'overflow', 'hidden' );
		}
		//print $this->getFieldType();

	   if( $this->getFieldType() == 'form' )
	   {
			//$this->returnAjax();
			if( $boolAjax )
			{
				// para funcionar com chamadas ajax sem fwAjaxRequest.
				$_REQUEST['dataType'] = ( isset( $_REQUEST['dataType'] ) ) ? $_REQUEST['dataType'] : 'text';

				if( ! function_exists( 'prepareReturnAjax' ) )
				{
					require_once($this->getBase() . 'includes/formDin4Ajax.php');
				}
				// se tiver alguma coisa no buffer, poder ser algum echo, print ou mensagem de erro do php
				$flagSucess=1;
				if( $this->getErrors() )
				{
					$flagSucess=0;
					echo implode("\n", $this->getErrors() );// joga no buffer de saida
					//die();
				}
				if( $this->getMessages() )
				{
					echo implode("\n", $this->getMessages() ); // joga no buffer de saida
				}
				prepareReturnAjax( $flagSucess,$this->getReturnAjaxData());
				die;
			}
			// verificar se a classe TApplication (controller detectou que a sessão está expirdada
			if( !$this->getPublicMode() && isset( $_POST['fwSession_expired'] ) && $_POST['fwSession_expired']== true )
			{
				// configurar o formulário para exibir somente a mensagem
				$this->setTitle('Sessão Encerrada');
				$this->setWidth(300);
				$this->setHeight(120);
				$this->hideCloseButton();
				$this->removeField();
				$this->addHtmlField('msg','<center><br><h3>Reiniciando. Aguarde...</center>')->setCss('color','#ff0000');
				$this->addJavascript('window.setTimeout("fwApplicationRestart()",1500)');
			}
			if( $this->getPublicMode() )
			{
				$this->addHiddenField('fwPublicMode','S');
			}
			if( $this->getPosition() && ! $this->pdfs )
			{
				//die( $this->getPosition());
				$this->addJavascript('window.setTimeout(\'fwSet_position("'.$this->getId().'_area","'.$this->getPosition().'")\',100);');
			}
			if( $this->getAppFitFormHeight() )
			{
				//die( $this->getPosition());
				$this->addJavascript('window.setTimeout(\'fwAppFitFormHeight()\',100);');
			}

			// se a funcao ondrawRow estiver definia e nao existir, retirar o evento
			if ($this->getOnDrawRow() && !function_exists($this->getOnDrawRow()))
			{
				$this->setOnDrawRow(null);
			}
			// se a funcao ondrawField estiver definia e nao existir, retirar o evento
			if ($this->getOnDrawField() && !function_exists($this->getOnDrawField()))
			{
				$this->setOnDrawField(null);
			}
			// o form do grid offline não precisa destes scripts
			//if( !isset($_REQUEST['gridOffline']) && ! $this->getFormGridOffLine() )
			if( ! $this->getFormGridOffLine() )
			{
				$this->addJavascript( '// variáveis javascript de auxílio', -90 );
				if( $this->getVerticalAlign() || $this->getHorizontalAlign() )
				{
					$this->addJavascript( 'fwSetFormAlignment("' . $this->getVerticalAlign() . '","' . $this->getHorizontalAlign() . '")' );
				}

				$this->addJavascript( 'aplicativo="' . APLICATIVO . '";', -89 );
				$this->addJavascript( 'pastaBase="' . $this->getBase() . '";', -88 );
				$this->addJavascript( 'fw_img_processando1	= \'<img width="16px" height="16px" src="\'+pastaBase+\'imagens/carregando.gif"/>\'' );
				$this->addJavascript( 'fw_img_processando2	= \'<img width="190px" height="20px" src="\'+pastaBase+\'imagens/processando.gif"/>\'' );
				$this->addJavascript( 'GB_ROOT_DIR 			= pastaBase+\'js/greybox/\';' );
				$this->addJavascript( 'REQUIRED_FIELD_MARK	= '.( defined('REQUIRED_FIELD_MARK') ?'\''.REQUIRED_FIELD_MARK.'\'' : 'null' ).';' );
				//$this->addJavascript('fw_img_processando1 = \'<img width="16px" height="16px" src="'.$this->getBase().'imagens/carregando.gif"/>\'',-87);
				//$this->addJavascript('fw_img_processando2 = \'<img width="190px" height="20px" src="'.$this->getBase().'imagens/processando.gif"/>\'',-86);
				$this->addJavascript( 'jQuery(document).keydown(function(event) { fwCancelRefresh(event,' . $this->getF5Enabled() . ') } )', -85 );
				$this->addJavascript( 'fwAttatchTooltip({"container":"'.$this->getId().'"})' );
				$this->addJavascript('try{fwUnblockUI()}catch(e){}',-99);
				// criar link para exibir a planhila com os pontos de função
				$this->processApf();
			}
			// implementação para permitir aplicativos com a estrutura de visão e controle separados
			// se existir arquivo js/css externo com o mesmo nome do modulo, no mesmo diretorio ou no diretorio js/ fazer a inclusão automática
			$this->addJsCssModule();

			// remover/exibir as barras de rolagem
			$this->body->setCss( "overflow",'hidden');
			$this->body->setCss( "overflow-x", $this->getOverFlowX() );
			$this->body->setCss( "overflow-y", $this->getOverFlowY() );
			//$this->body->setCss('border','1px dashed blue');
			//$this->body->setCss('background-color','red');
			if( $this->getFlat())
			{
				$this->body->setCss( 'width', $this->getWidth()-5);
			}
			else
			{
				$this->body->setCss( 'width', $this->getWidth()-17);
			}
			//$this->body->setCss( 'width', $this->getMaxWidth());
			if( $this->getAutoSize() )
			{
				$this->setOverflowY( 'auto' );
			}

			// alterar a aparência do formulario se ele estiver sendo executado como subform - modal
			if( isset( $_REQUEST[ 'facebox' ] ) && $_REQUEST[ 'facebox' ] )
			{
				$this->hideCloseButton();
				$this->addHiddenField( 'facebox', 1 )->setProperty('noClear','true'); // evitar que a funcao js fwClearFields() limpe este campo;
				$this->setFlat( true );
				$this->setCss( 'background-color', 'white' );
				$this->setCss( 'border', 'none' );
			}
			else if( isset( $_REQUEST[ 'modalbox' ] ) && $_REQUEST[ 'modalbox' ] )
			{
				//$this->headerCloseButton->add('<img src="'.$this->getBase().'imagens/fwbtnclosered.jpg" style="cursor:pointer;float:right;width:28px; height:15px;vertical-align:top;margin-right:2px;" title="Fechar" onClick="fwFazerAcao(\'Sair\')");">');
				$this->hideCloseButton();
				$this->addHiddenField( 'modalbox', 1 )->setProperty('noClear','true'); // evitar que a funcao js fwClearFields() limpe este campo;
			}

			if( $this->getPrototypeId() || $this->getDialogId() )
			{
				$this->setFlat( true );
				$this->setShowHeader( false );
				//$this->setCss( 'background-color', '#efefef' );
				$this->setCss( 'background-color', 'transparent' );
				$this->setCss( 'border', '0px' );
				$_REQUEST[ 'prototypeId' ] = isset( $_REQUEST[ 'prototypeId' ] ) ? $_REQUEST[ 'prototypeId' ] : '';
				$this->addHiddenField( 'prototypeId', $_REQUEST[ 'prototypeId' ] )->setProperty('noClear','true'); // evitar que a funcao js fwClearFields() limpe este campo;
				$this->addHiddenField( 'dialogId', $this->getDialogId() )->setProperty('noClear','true'); // evitar que a funcao js fwClearFields() limpe este campo;
			}
			// este javascript tem que ser o ultimo a ser adicionado, por isso coloquei aqui
			$this->addJsFile( 'funcoes.js' );
			// se o formulario estiver fora de um objeto THtmlPage, inserir os javascripts e css necessários
			if( $this->getAutoIncludeJsCss() )
			{
				$this->includeJsCss();
			}
			$this->setId( $this->getId() . '_area' );
			$this->setTagType( 'div' );
			$this->setCss( 'width', $this->getWidth() );
			//$this->setCss('border','0px solid red');
			// centralizar o formulário na tela - no IE não funcionou
			//$this->setCss('margin','auto');
			$this->table->setCss( 'background-color', $this->getCss( 'background-color' ) );

			$row = $this->table->addRow();
			if( $this->getShowHeader() )
			{
				//$this->header->clearChildren();
				$this->header->add( $this->getTitle() );
				$row->add( $this->header );
				$row->add( $this->headerCloseButton );
				$this->header->setCss( 'width', $this->getWidth() - 70 );
				if( $this->getMaximize() == true )
				{
					if( preg_match('/\(/',$this->getOnMaximize() )==1)
					{
						$this->header->addEvent('ondblclick','fwFullScreen("'.$this->name.'","'.$this->getOnMaximize().'")');
					}
					else
					{
						$this->header->addEvent('ondblclick','fwFullScreen("'.$this->name.'","'.$this->getOnMaximize().'")');
					}
				}
			}
			else
			{
				$this->header->setCss( 'height', 0 );
				$this->body->setCss( "border-top", 'none' );
			}
			$cell = $this->table->addRow()->addCell( $this->body );
			$cell->setProperty( 'colspan', 2 );
			$this->table->addRow()->add( $this->footer );
			// criar os campos ocultos padrão do modulo e da acao
			if ( !$this->getFormGridOffLine())
			{
				$this->addHiddenField( 'moduloId' )->setProperty('noClear','true'); // evitar que a funcao js fwClearFields() limpe este campo;
				$this->addHiddenField( 'modulo' )->setProperty('noClear','true'); // evitar que a funcao js fwClearFields() limpe este campo;
				$this->addHiddenField( 'formDinAcao' );
                if ( isset( $GLOBALS['formdin_instance_id'] ) )
                {
                    $this->addHiddenField( 'formdin_instance_id', $GLOBALS['formdin_instance_id'] )->setProperty('noClear','true'); // evitar que a funcao js fwClearFields() limpe este campo;
                }
			}
			$areaBody = ( int ) $this->getHeight() - ( int ) $this->header->getCss( 'height' ) - ( int ) $this->footer->getCss( 'height' ) - 20;
			$this->body->setCss( "height", $areaBody . "px" );
			// verificar se tem algum erro para ser exibido
			if( $this->getErrors() )
			{
				$flag = 0;
				$this->setMessage( null );

				foreach( $this->getErrors() as $idField=>$msgError )
				{
					// definir o foco do formulario para o primeiro campo com erro de validacao
					// ignorar a mensagem que tiver com espaço representando o nome da aba onode ocorreu o erro
					if( $flag == 0 && !strpos( $idField, " " ) )
					{
						$this->setFocusField( $idField );
						$flag++;
					}
					if( trim($msgError)!='' )
					{
						$this->addMessage( ( count( $this->getMessages() ) + 1) . ') ' . $msgError );
					}
				}
			}
		}
		else
		{
			// abas, grupos não precisam da area de mensagem
			if( $this->message_area )
			{
				$this->removeField( $this->message_area->getId() );
			}
		}
		// se existir um metodo, criar com a tag form
		if( ( string ) $this->method != "" )
		{
			$form = new TElement( 'form' );
			$form->setId( $this->name );
			$form->method = $this->method;
			$form->action = ( string ) $this->action;
			$form->setEvents( $this->getEvents() );
			$this->clearEvents();
			if( $this->getEncType() )
			{
				$form->setProperty( 'enctype', $this->getEncType() );
			}
			if(  $this->getFieldType()=='tabsheet' )
			{
				$parentName = $this->body->getAttribute('pagecontrol').'_'.$this->name;
			}
			else
			{
				$parentName = $this->name;
			}
		}
		else
		{
			// nao criar a tag <form>
			$form = new TElement( 'span' );
			if( $this->getFieldType() == 'group')
			{
				$form->setId($this->getId().'_span');
			}
			else
			{
				$form->setId($this->getId());
			}
			$parentName = $this->getId();
		}
		if( $this->getFormGridOffLine())
		{
			$form->setTagType('span');
			$this->getDivBody()->setId($this->getAttribute('idGridOffLine').'_form_body');
			$form->setId($this->getAttribute('idGridOffLine').'_form_fields' );
			$form->method=null;
			$form->action=null;
		}
		// adicionar a tag form ao html final
		$this->add( $form );
		// o formulario será estruturado em uma Table com cabecalho ,corpo e rodape
		$form->add( $this->table );
		// adicionar o botao fechar
		if( $this->getShowCloseButton() )
		{
			$sub = 'null';
			if( isset( $_REQUEST[ 'subform' ] ) && $_REQUEST[ 'subform' ] )
			{
				$this->addHiddenField( 'subform', 1 )->setProperty('noClear','true'); // evitar que a funcao js fwClearFields() limpe este campo;
				$sub = '1';
			}
			// integração com o modulo onlinesearch que possibilita fazer cadastro on-line quando a pesquisa retorna sem resultado
			if( isset( $_REQUEST[ 'onLineSearch' ] ) && $_REQUEST[ 'onLineSearch' ] )
			{
				$this->headerCloseButton->add( '<img src="' . $this->getBase() . 'imagens/fwbtnclosered.jpg" style="cursor:pointer;float:right;width:28px; height:15px;vertical-align:top;margin-right:2px;" title="Fechar" onClick="fwFazerAcao(\'Sair\')");">' );
				$this->addHiddenField( 'onLineSearch', 1 )->setProperty('noClear','true'); // evitar que a funcao js fwClearFields() limpe este campo;
			}
			else
			{
				$confirm = $this->getConfirmOnClose() ? 'true' : 'false';
				if( ! $this->get('modalWinId') )
				{
					$this->headerCloseButton->add( '<img id="btn_'.$form->getId().'_close" src="' . $this->getBase() . 'imagens/fwbtnclosered.jpg" style="cursor:pointer;float:right;width:20px; height:15px;vertical-align:top;margin-right:2px;" title="Fechar" onClick="fwConfirmCloseForm(\'' . $this->getId() . '\',' . $sub . ',' . $this->getOnClose() . ',' . $this->getOnBeforeClose().');">' );
					if( $this->getMaximize() )
					{
						$this->headerCloseButton->add( '<img id="btn_'.$form->getId().'_max_min" src="' . $this->getBase() . 'imagens/fwbtnmaximize.png" style="cursor:pointer;float:right;width:20px; height:15px;vertical-align:top;margin-right:2px;" title="Maximizar" onClick="fwFullScreen(\''.$form->getId().'\')">' ,false);
   						$this->headerCloseButton->setCss('width',50);
   						$this->headerCloseButton->setCss('white-space','nowrap');
					}
				}
				else
				{
					$this->headerCloseButton->add( '<img src="' . $this->getBase() . 'imagens/fwbtnclosered.jpg" style="cursor:pointer;float:right;width:28px; height:15px;vertical-align:top;margin-right:2px;" title="Fechar" onClick="top.app_close_modal_window();">' );
				}
			}
			//print '<img src="'.$this->getBase().'imagens/fwbtnclosered.jpg" style="cursor:pointer;float:right;width:28px; height:15px;vertical-align:top;margin-right:2px;" title="Fechar" onClick="fwFecharFormulario(\''.$this->getId().'\',\''.$sub.'\',\''.$this->getOnClose().'\');">';
		}
		if( $this->getHelpOnline() )
		{
			//$this->headerCloseButton->add('<img src="'.$this->getBase().'imagens/fwbtnhelp.gif" style="cursor:pointer;float:right;width:28px; height:15px;vertical-align:top;margin-right:2px;" title="Visualizar arquivo de Ajuda" onClick="fwMostrarAjuda(\''.$this->getHelpFile().'\');"/>');
			$this->headerCloseButton->add( $this->getHelpOnLine() );
		}
		// adicionar os campos
		if( is_array( $this->displayControls ) )
		{
			$currentCol 		= null;
			$hiddenFields 		= null;
			$divButtonOpen 		= false;
			$lastDisplayControl = null;
			$tableLayout 		= new TTable( $form->getId().'_layout' );
			$tableLayout->setProperty('width','100%');
			$tableLayout->setProperty('border','0');
			$tableLayout->setProperty('cellpadding','0px');
			$tableLayout->setProperty('cellspacing','0px');
			/*$tableFields 		= new TTable( $form->getId().'_fields' );
			$tableFields->setProperty('border','1');
			$tableFields->setProperty('cellpadding','3px');
			$tableFields->setProperty('cellspacing','0px');
			*/
			// adicionar a table do layout no corpo do formulário
			$this->body->add($tableLayout);

/*			if( defined('REQUIRED_FIELD_MARK') && $this->getFieldType() == 'form' )
			{
				$this->addHtmlField('teste','(*) Preenchimento obrigatório')->setCss(array('margin-top'=>'5','font-size'=>'10px','color'=>'red' ) );
			}
*/
			// inicio
			$rows=0;
			foreach( $this->displayControls as $name=>$dc )
			{
				// se falso então campo tambem falso
				if( $this->getEnabled() == false )
				{
					$dc->getField()->setEnabled( false );
				}

				// se o formulário tiver documentação on-line, ativar no displaycontrol
				if( $this->getOnlineDoc() )
				{
					if( !self::$onlineDocIgnoreFields || preg_match('/,'.$dc->getField()->getId().',/',','.self::$onlineDocIgnoreFields.',' ) == 0 )
					{
						if( !self::$onlineDocFields || preg_match('/,'.$dc->getField()->getId().',/',','.self::$onlineDocFields.',' ) > 0 )
						{
							$dc->setOnlineDoc($this->getOnlineDoc());
						}
					}
				}
				// se o formulário estiver definido com required, todos os campos serão obrigatórios
				if( $this->getRequired() == true )
				{
					if( method_exists( $dc->getField(), 'setRequired' ) )
					{
						$dc->getField()->setRequired( true );
					}
				}
				if( $this->getLabelsAlign() )
				{
					if( method_exists( $dc->getField(), 'setLabelsAlign' ) )
					{
						if( ! $dc->getField()->getLabelsAlign())
						{
							$dc->getField()->setLabelsAlign( $this->getLabelsAlign() );
						}
					}
				}
				$dcField 		= $dc->getField();
				$dcLabel		= $dc->getLabel();
				if( $dcLabel )
				{
					if( ! $dcLabel->getCss('font-size') )
					{
						$dcLabel->setCss('font-size',$this->getCss('font-size') );
					}
					if( ! $dcLabel->getCss('color'))
					{
						$dcLabel->setCss('color',$this->getCss('color') );
					}
	 			    if( ! $dcLabel->getcss('text-align') && $this->getLabelsAlign()  )
				    {
				   	    $dcLabel->setcss('text-align',$this->getLabelsAlign());
				    }
      				// verificar se o label está com shortcut ( tecla de atalho "&" )
				   	$this->parseShortcut( $dcLabel, $dcField->getId() );
				}
				$dcFieldType	= strtolower( $dc->getField()->getFieldType() );

				// ativar/desativar as barras de rolagem
				if( $this->getFieldType() == 'tabsheet')
				{

					$this->setTagType( 'div' );
					$this->body->setClass( $this->getClass() );
					$this->body->setCss( $this->getCss() );
					$this->body->setId( $this->getId() );
					$this->body->setCss('height',$this->getHeight());
					$h = $this->getHeight();
					if( $h )
					{
						$this->body->setcss('overflow','hidden');
						$this->body->setCss('overflow-x',$this->getOverFlowX());
						$this->body->setCss('overflow-y',$this->getOverFlowY());
					}
					else
					{
						// height = auto não precisa do overflow
						$this->body->setcss('overflow'	,'hidden');
						$this->body->setCss('overflow-x','hidden');
						$this->body->setCss('overflow-y','hidden');
					}
					$this->setOverflowX($this->body->getCss('overflow-x'));
					$this->setoverflowY($this->body->getCss('overflow-y'));
					if( $this->body->getcss('display')=='inline')
					{
						$this->body->setcss('display','block');
					}
				}
				// ajustar a altura e largura se for null
				if( !$dcField->getWidth() )
				{
					$fieldType 	= $dcField->getFieldType();
					if( $fieldType == "treeview" || $fieldType == 'pagecontrol' ||$fieldType == 'html' || $fieldType == 'group' || $fieldType=='fullcalendar' )
					{
						$dcField->setAttribute('fullwidth','true');
						$w = $this->getWidth();
						$parentType = $this->getFieldType();
						$overFlowY 	= ($this->getOverFlowY() != 'hidden');
						$flat 		= $this->getFlat();
						if( $parentType == 'form')
						{
							// adicionando aba ao form
							if( $fieldType == 'html')
							{
								$w-=22;
								if( $overFlowY )
								{
									$w-=17;
								}
								if( $flat )
								{
									$w+=12;
								}
							}
							else if( $fieldType == 'fullcalendar')
							{
								$w-=22;
								if( $overFlowY )
								{
									$w-=17;
								}
								if( $flat )
								{
									$w+=12;
								}
							}
							else if( $fieldType == 'pagecontrol')
							{

								if( $this->getFlat() )
								{
									$w-=42;
								}
								else
								{
									$w-=32;
								}
								if( $overFlowY )
								{
									$w-=20;
								}
								if( $flat )
								{
									$w+=25;
								}
							}
							else if( $fieldType == 'group')
							{
								//$dcField->table->setAttribute('width','100%');
								if( $this->getFlat())
								{
									$w-=29;
								}
								else
								{
									$w-=32;
								}
								if( $overFlowY )
								{
									$w-=17;
								}
								if( $flat )
								{
									$w+=12;
								}
							}
							else if( $fieldType == 'treeview' )
							{
								$w-=25;
								if( $overFlowY )
								{
									$w-=17;
								}
								if( $flat )
								{
									$w+=12;
								}
							}

						}
						else if( $parentType == 'tabsheet')
						{
							$w = $this->getParentControl()->getcss('width');
							// adicionando html na aba
							$w-=15;
							if( $fieldType == 'html')
							{
								if( $overFlowY )
								{
									$w-=10;
								}
								if( $flat )
								{
									$w+=12;
								}
							}
							// adicionando aba na aba
							else if( $fieldType == 'pagecontrol')
							{
								$w-=20;
								if( $overFlowY )
								{
									$w-=15;
								}
								if( $flat )
								{
									$w+=15;
								}
							}
							// adicionando grupo na aba
							else if( $fieldType == 'group')
							{
								$w+=0;
								if( $overFlowY )
								{
									$w-=10;
								}
								if( $flat )
								{
									$w+=12;
								}
							}
							else if( $fieldType == 'treeview' )
							{
								$w-=5;
								if( $overFlowY )
								{
									$w-=7;
								}
								if( $flat )
								{
									$w+=12;
								}
							}

						}
						else if( $parentType == 'group')
						{
							//d($w,null,true);
							// adicionando html na aba
							if( $fieldType == 'html')
							{
								$w-=35;
								if( $overFlowY )
								{
									$w-=15;
								}
								if( $flat )
								{
									$w+=12;
								}
							}
							// adicionando aba na grupo
							else if( $fieldType == 'pagecontrol')
							{

								$w-=57;
								if( $overFlowY )
								{
									$w-=15;
								}
								if( $flat )
								{
									$w+=30;
								}
							}
							// adicionando grupo no grupo
							else if( $fieldType == 'group')
							{
								$w-=35;
								if( $overFlowY )
								{
									$w-=15;
								}
								if( $flat )
								{
									$w+=12;
								}
							}
							else if( $fieldType == 'treeview' )
							{
								$w-=35;
								if( $overFlowY )
								{
									$w-=15;
								}
								if( $flat )
								{
									$w+=12;
								}
							}
						}
						$dcField->setWidth( $w );
					}
				}
				//if( method_exists( $dcField, 'getRequired' ) && $dcField->getRequired() )
				if( method_exists( $dcField, 'getRequired' ) && $dcField->getRequired() )
				{
					self::$hasRequiredField=true;
				}
				if( $dcFieldType == "cep" )
				{
					// retirar o botão consultar cep
					if( $dcField->getEnabled() == false )
					{
						$dcField->clearChildren();
					}
				}
				else if( $dcFieldType == "password" )
				{
					if($dcField->getVirtualKeyboard())
					{
						$this->addJavascript('VKI_attach(jQuery("#'.$dcField->getId().'").get(0),'.( $dcField->getShowVirtualKeyboardImage()===true ? 'true': 'false' ).');');
					}
				}
				if( $dcFieldType == 'tag' )
				{
					continue;
				}
				// ajustar campo html se não tiver label e for newLine = true
				else if( $dcFieldType == 'html' )
				{
					// se dentro do campo html tiver um objeto treeview, adicionar o javascript do objeto no onload da página
					$arr = $dcField->getChildren();
					if( is_array( $arr ) )
					{
						foreach( $arr as $k=>$v )
						{
							if( is_object( $v ) )
							{
								if( get_class( $v ) == 'TTreeView' )
								{
									$this->addJavascript( $v->getJs() );
								}
							}
						}
					}

					if( ! $dcField->getWidth() )
					{
						if( ! $dcLabel && $dc->getNewLine() )
						{
							//form,tabsheet,groupbox,
							if( $this->getFieldType() == 'tabsheet' )
							{
								//$dcField->setWidth( ( $this->getCss( 'width' ) - 15 ) ); // IE=27
								//$dc->getField()->setWidth($this->getMaxWidth()-50); // IE=27
							}
							else if( $this->getFieldType() == 'groupbox' )
							{
								//$dcField->setWidth( $this->getMaxWidth() + 95 );
							}
							else
							{
								//$dcField->setWidth( $this->getMaxWidth() );
							}
						}
					}
					// criar javascript para inicializar o gride anexado ao campo html
					if( is_array( $dcField->getGridFile() ) )
					{
						if( $dcField->getLoadingMessage() )
						{
							$this->addJavascript( 'jQuery("#' . $dcField->getId() . '").html("' . $dcField->getLoadingMessage() . '");' );
						}
						$gdId 			= $dcField->getGridFile( 'id' );
						$gdFile 		= $dcField->getGridFile( 'file' );
						$gdFormFields	= $dcField->getGridFile( 'formFields' );
						$gdWidth		= ($dcField->getWidth()-3);
						$fieldValues = '';
						if( is_array( $gdFormFields ) )
						{
							foreach( $gdFormFields as $k=>$v )
							{
								if( is_numeric( $k ) )
								{
									$fieldValues .= ( $fieldValues == '' ? '' : ',' ) . '"' . $v . '":"' . $this->get( $v ) . '"';

								}
								else
								{
									$fieldValues .= ( $fieldValues == '' ? '' : ',' ) . '"' . $k . '":"' . $v . '"';
								}
							}
							$fieldValues = (($fieldValues) != '' ? ',' : '').$fieldValues;
						}
						$gdCurrentPage = 1;
						if( isset( $_REQUEST[ $gdId . '_jumpToPage' ] ) )
						{
							$gdCurrentPage = $_REQUEST[ $gdId . '_jumpToPage' ];
						}
						$gdCollapsed = 0;
						if( isset( $_REQUEST[ $gdId . '_collapsed' ] ) )
						{
							$gdCollapsed = $_REQUEST[ $gdId . '_collapsed' ];
						}
						$this->addJavascript( 'jQuery("#' . $dcField->getId() . '").load(app_index_file,{"subform":1,"ajax":0,"gridOffline":"1","parent_field":"' . $dcField->getId() . '","' . $gdId . '_jumpToPage":"' . $gdCurrentPage . '","' . $gdId . '_collapsed":"' . $gdCollapsed . '","'.$gdId.'Width":'.$gdWidth.',"modulo":"' . $gdFile . '"' . $fieldValues . '} );' );
					}
				}
				else if( $dcFieldType == 'group' )
				{
					$dcField->setOnlineDoc( $this->getOnlineDoc() );
				}
				else if( $dcFieldType == 'pagecontrol' )
				{
					// ativar/desativar online doc nos forms das abas e aplicar shortcuts
					if( is_array( $dcField->getPages() ) )
					{
						forEach( $dcField->getPages() as $name=>$page )
						{
							$page->setOnlineDoc( $this->getOnlineDoc() );
							$page->setCustomHintEnabled( $this->getCustomHintEnabled() );
							$this->parseShortcut($page,$page->getId() );
						}
					}
				}
				else if( $dcFieldType == 'button' )
				{
					// alinhar o botão com o campo quando o campo estiver com labelabove=true
					if( $lastDisplayControl )
					{
						if( $lastDisplayControl->getLabelAbove() )
						{
							$dc->setLabelAbove( true );
						}
					}
					$this->parseShortcut($dc->getField(),$dc->getField()->getid() );
				}
				else if( $dcFieldType == 'treeview' )
				{
					$this->addJavascript( $dcField->getJs() );
				}

				if( method_exists( $dcField, 'getHint' ) )
				{

					if( $dcField->getHint() )
					{
						$hint = trim( $dcField->getHint() );
						// destacar os campos com ajuda ao usuário alterando a cor de fundo
						if( $this->getColorHighlightBackground() )
						{
							if( $dcField->getFieldType() != 'link')
							{
								if( !$dcField->getCss( 'background-color' ) )
								{
									$dcField->setCss( 'background-color', $this->getColorHighlightBackground() );
								}
							}
						}
						$dcField->setProperty( 'tooltip', 'true' );
					}
				}
				// se o form ou aba ou grupo estiver desabilitado, desabilitar todos os campos
				if( $this->getReadOnly() == true )
				{
					if( method_exists( $dcField, 'setReadOnly' ) )
					{
						$dcField->setReadOnly( true );
					}
				}
				else if( $this->getEnabled() == false )
				{
					if( method_exists( $dcField, 'setEnabled' ) )
					{
						$dcField->setEnabled( false );
					}
				}
				// definir o parent do campo para poder recuperar com javascript (jquery) os campos pertencentes a uma aba ou grupo ou form etc..se for preciso
				$dcField->setProperty( 'parent', $parentName );
				// gerar os campos ocultos no final do form
				if( $dcFieldType == "hidden" )
				{
					$hiddenFields[ ] = $dcField;
				}
				else
				{
					// inicializar o contador de colunas
					if( $currentCol === null )
					{
						$currentCol = 0;
						$dc->setNewLine( true );
					}
					// adicionar quebra do segundo campo em diante
					if( $dc->getNewLine() )
					{
						$rows++;
						$tableFields = new TTable('table_'.$dcField->getId().'_line');
						$tableFields->setProperty('cellpadding','0px');
						$tableFields->setProperty('cellspacing','0px');
						$tableFields->setProperty('border','0');
						$currentRow			= $tableFields->addRow();
						$currentRow->setid("tr_".$dcField->getId());
						$currentCell		= $currentRow->addCell();
						$currentCell->setId('td_'.$dcField->getId());
						$currentCell->setProperty('form_line',$rows );
						$currentCell->setProperty('form_col',0);

						$boolLabelAbove = false;
						$loRow = $tableLayout->addRow();
						$loCell = $loRow->addCell();
						$loCell->add( $tableFields );
						$loCell->setProperty('form_line',$rows);

						if( $rows > 1 )
						{
							$loCell->setCss('padding-top','2px');
						}
						if( $dc->getField()->getCss('text-align')=='center' )
						{
							//$loCell->setProperty('align', 'center');
						}
						if( $dc->getField()->getProperty('align') )
						{
							$loCell->setProperty('align', $dc->getField()->getProperty('align')  );
						}
						if( $this->getOnDrawRow() && function_exists($this->getOnDrawRow() ) )
						{
							call_user_func($this->getOnDrawRow(),$dc,$loCell,$rows,$loRow);
						}
						$currentCol = 0;
					}
					else
					{
						$currentCell= $currentRow->addCell();
						$currentCell->setCss('padding-left','15px');
						$currentCell->setProperty('form_line',$rows );
						$currentCell->setProperty('form_col',($currentCol+1));
						$currentCol++;
					}
					if( $dc->getLabelAbove() && !$boolLabelAbove )
					{
						$boolLabelAbove=true;
					}
					if( $boolLabelAbove)
					{
						$currentCell->setProperty('valign','bottom');
					}

					if( $this->getOnDrawField() && function_exists($this->getOnDrawField() ) )
					{
						call_user_func($this->getOnDrawField(),$dc,$loCell,$rows);
					}

					// fazer o controle das larguras das colunas do formulário
					$column = $currentCol;
					if( $column > 0 )
					{
						$column = $column * 2;
					}
					if( !is_null( $this->getColumnWidth( $column  ) )  && is_object( $dcLabel ) )
					{
						if( $dc->getNoWrapLabel() || $this->getNoWrap() )
						{
							$dc->setLabelCellWidth( 'auto' );
						}
						else
						{
							$dc->setLabelCellWidth( $this->getColumnWidth( $column ) );
						}
						$dc->setFieldCellWidth( $this->getColumnWidth( $column + 1 ) );
					}
					// adicionar javascript para selects combinados
					if( is_array( $this->selectsCombinados ) && $dc->getField()->getFieldType() == 'select' )
					{
						//print $field->getId().'<br>';
						if( isset( $this->selectsCombinados[ $dcField->getId() ] ) )
						{
							// um campo select pode ter varios select filhos e os parametros
							// para cada select filho devem ser separados por ponto e virgula
							$parametros = "";
							$proximoSelect = "";
							foreach( $this->selectsCombinados[ $dcField->getId() ] as $fieldName=>$aDados )
							{
								if( $proximoSelect == "" )
								{
									$proximoSelect = $fieldName;
								}
								$aDados[ 'valorInicial' ] = null;
								$childField = $this->getField( $aDados[ 'selectFilho' ] );
								if( ! $childField ) 	//procurar no formulário inteiro
								{
									$childField = self::$instance->getField( $aDados[ 'selectFilho' ] );
								}
								if( $childField )
								{
									$childField->setAttribute('parentSelect', $dcField->getId());
									if( !$childField->getEnabled() )
									{
										$aDados[ 'selectFilhoStatus' ] = "desabilitado";
										// se alterar o valor de um select desabilitado, alterar o tambem o valor do campo oculto relativo ao select desabilitado
										$childField->addEvent( 'onchange', "fwGetObj('" . $aDados[ 'selectFilho' ] . "').value=this.value;" );
										$aDados[ 'selectFilho' ] = $aDados[ 'selectFilho' ] . '_disabled';
									}

									if( $childField->getValue() )
									{
										if( is_array( $childField->getValue() ) )
										{
											//list($aDados['valorInicial']) = implode('|',$childField->getValue());
											$aDados[ 'valorInicial' ] = implode( '|', $childField->getValue() );
										}
										else
										{
											$aDados[ 'valorInicial' ] = $childField->getValue();
										}
									}
								}
								foreach($aDados as $k=>$v)
								{
									$aDados[$k] = htmlentities($v,null,'ISO-8859-1');
								}
								if( $this->getPublicMode() )
								{
									$aDados['fwPublicMode']='S';
								}
								$parametros.= ( $parametros == "") ? "" : ";";
								$parametros.= str_replace( '"', '\\"', json_encode( $aDados ) );
							}
							//$dcField->addEvent( 'onchange', 'fwSetFocus("' . $proximoSelect . '");fwSetOpcoesSelect("' . $parametros . '")' );
							$dcField->addEvent( 'onchange','fwSetOpcoesSelect("' . $parametros . '")' );
							if( $dcField->getEnabled() )
							{
								$this->addJavascript( 'jQuery("#' . $dcField->getId() . '").change()' );
							}
							else
							{
								$this->addJavascript( 'jQuery("#' . $dcField->getId() . '_disabled").change()' );
							}
						}
					}
					$currentCell->add($dc);
				}
				$lastDisplayControl = $dc;
			}
			// fim
			if( $divButtonOpen )
			{
				//$this->body->add( '</div>' );
			}
			// adicionar javascript para serchs online aos campos ( consulta Dinamica )
			if( is_array( $this->onlineSearchs ) )
			{
				if( isset( $_REQUEST[ 'onLineSearch' ] ) && $_REQUEST[ 'onLineSearch' ] )
				{
					$this->clearOnlineSearch();
					$this->addMessage( 'O formulário de cadastro on-line (' . $_REQUEST[ 'modulo' ] . '), possui campos com recurso de consulta on-line.\nNão é permitido realizar uma consulta on-line dentro de outra consulta on-line já em execução, portanto, utilize o recurso de autocomplete se possível.\nOutra forma seria adicionar um botão no formulário principal para fazer o cadastramento on-line.' );
				}
				else
				{
					foreach( $this->onlineSearchs as $fieldName=>$aData )
					{
						if( $field = $this->getField( $fieldName ) )
						{
							$modulo = isset( $_POST[ 'modulo' ] ) ? $_POST[ 'modulo' ] : 'teste';
							$sessionField = $modulo . '_' . $form->getId() . '_' . $fieldName;
							$jsBefore = '';
							if( !is_null( $aData[ 'beforeExecuteJs' ] ) )
							{
								$jsBefore = "if( typeof({$aData[ 'beforeExecuteJs' ]})=='function' && !{$aData[ 'beforeExecuteJs' ]}()){return false} ";
							}
							$img1 = '<img id="' . $field->getId() . '_search" style="width:12px;height:13px;cursor:pointer;" title="Consulta on-line" onClick="' . $jsBefore . 'fwModalBox(\'Consulta on-line\',\'?subform=1&modulo=' . $this->getBase() . 'callbacks/onlineSearch.php&subform=1&sessionField=' . $sessionField . '\',' . $aData[ 'windowHeight' ] . ',' . $aData[ 'windowWidth' ] . ')" src="' . $this->getBase() . 'imagens/search.gif">';
							// textarea não pode utilizar o metodo add para adicionar imagens na frente do campo
							if( $field->getFieldType() != 'memo' )
							{
								$field->add( $img1 );
							}
							if( !$aData[ 'disableEnterKey' ] )
							{
								$field->addEvent( 'onKeyPress', 'fwCallOnlineSearch(this,event)' );
							}
							if( !$field->getEnabled())
							{
								$field->setEnabled(true);
								$field->setReadOnly(true);
								$this->addJavascript('jQuery("#'.$field->getId().'").click(function(){jQuery("#'.$field->getId() . '_search").click();})');
							}
							if( $aData[ 'updateFormFields' ] )
							{
								// criar a string com os nomes dos campos que serão limpos quando clicar na lixeira
								$aTemp = explode( ',', $aData[ 'updateFormFields' ] );
								$formFields = $fieldName;
								foreach( $aTemp as $i=>$fld )
								{
									$aField = explode( '|', $fld );
									$aField[ 1 ] = (!isset( $aField[ 1 ] ) ? strtolower( $aField[ 0 ] ) : $aField[ 1 ] );
									$formFields.='|' . $aField[ 1 ];
								}
							}
							$img2 = '<img id="' . $field->getId() . '_search_clear" style="width:16px;height:14px;cursor:pointer;" title="Limpar campos" onClick="fwAtualizarCampos(\'' . $formFields . '\')" src="' . $this->getBase() . 'imagens/lixeira.gif">';
							if( $field->getFieldType() == 'memo' )
							{
								$field->setOnlineSearch( $img1 . $img2 );
							}
							else
							{
								$field->add( $img2 );
							}
							$aData['prototypeParentWin'] = $this->get('modalWinId');
							$aData['dialogId'] = $this->get('dialogId');
							if( $this->getPublicMode() )
							{
								$aData['fwPublicMode'] = 'S';
							}
							$_SESSION[ APLICATIVO ][ 'onlineSearch' ][ $sessionField ] = $aData;
						}
					}
				}
			}
			// adicionar os botões aos campos que possuem cadastro on-line
			if( is_array( $this->onlineCruds ) )
			{
				foreach( $this->onlineCruds as $fieldName=>$aData )
				{
					if( $field = $this->getField( $fieldName ) )
					{
						$w = is_null( $aData[ 'width' ] ) ? ($this->getWidth() + 10) : $aData[ 'width' ];
						$h = is_null( $aData[ 'height' ] ) ? ($this->getHeight() - 50) : $aData[ 'height' ];
						$field->add( new TButton( $field->getId() . '_crud', $aData[ 'buttonLabel' ], null, "fwModalBox('" . $aData[ 'title' ] . "',app_index_file+'?showCloseButton=0&modulo=" . $aData[ 'module' ] . "','" . $h . "','" . $w . "')", null, $aData[ 'buttonImage' ], null, $aData[ 'buttonHint' ] ) );
					}
				}
			}
			// adicionar os campos ocultos
			if( $hiddenFields )
			{
				$this->body->add( '<!-- campos ocultos -->' );
				foreach( $hiddenFields as $k=>$field )
				{
					$this->body->add( $field );
				}
			}
		}

		if( defined('REQUIRED_FIELD_MARK') && $this->getFieldType() == 'form' && self::$hasRequiredField )
		{
			if( $this->getRequiredFieldText() )
			{
				//$this->addHtmlField('teste','(*) Preenchimento obrigatório')->setCss(array('margin-top'=>'5','font-size'=>'10px','color'=>'red' ) );
				$this->body->add( '<center><span style="margin:0px; padding:0px;margin-top:5px;color:red;font-size:10px;">'.REQUIRED_FIELD_MARK.' '.$this->getRequiredFieldText().'</span></center>');
			}
		}
		// adicionar os botões das ações
		if( ( string ) $this->actions != '' )
		{
			$this->addButton( $this->actions );
		}
		// adicionar os botoes no rodapé
		if( is_array( $this->footerButtons ) && $this->getEnabled() )
		{
            // criar shortcuts para os botões do rodapé
			foreach( $this->footerButtons as $id=>$button )
			{
				$this->parseShortcut($button,$id );
			}

			$this->footer->add( '<!-- Botões do formulário -->' );
			if( $this->getFieldType() == 'form' )
			{
				foreach( $this->footerButtons as $id=>$button )
				{
					$this->footer->add( $button );
				}
			}
			else
			{
				// criar uma div para mostrar os botoes dentro de uma aba ou groupbox
				if( $this->footer->getCss( 'border-top' ) )
				{
					$this->body->add( '<hr style="border:none;border-top:' . $this->footer->getCss( 'border-top' ) . ';">' );
				}
				else
				{
					$this->body->add( '<hr style="border:none;border-top:1px solid #c0c0c0;">' );
				}
				$e = new TElement( 'div' );
				//$e->setCss( 'border', '1px solid red' );
				$e->setCss( 'text-align:', 'center' );
				foreach( $this->footerButtons as $id=>$button )
				{
					$e->add( $button );
				}
				$this->body->add( $e );
			}
		}
		if( $this->getFieldType() == "form" )
		{

			// este arquivo tem que ser o ultimo js da lista por isso tem que ficar aqui.
			//if( !isset($_REQUEST['gridOffline']))
			if( ! $this->getFormGridOffLine() )
			{
				$this->addJsFile( 'funcoes.js' );
			}
			if( $this->getShowMessageAlert())
			{
			   $this->addJavascript( 'fwHideMsgArea("'.$form->getName().'")',-1 );
			}
			// verificar se tem algum erro para ser exibido
			if( $this->getMessages() )
			{
				$msg = "";
				foreach( $this->getMessages() as $k=>$message )
				{
					$msg .= $msg == "" ? "" : '\n';
					$msg .= $message;
				}

				if( $this->message_area )
				{
					//$this->message_area->setCss( 'width', $this->getWidth() - 50 );
					if( $this->getErrors() )
					{
						$this->addJavascript( 'fwShowMsgArea({"formId":"' . $form->getName() . '","message":"' . $msg . '","alert":' . $this->getShowMessageAlert() . ',"class":"fwMessageAreaError","title":"Erro"})' );
					}
					else
					{
						$this->addJavascript( 'fwShowMsgArea({"formId":"' . $form->getName() . '","message":"' . $msg . '","alert":' . $this->getShowMessageAlert() . ',"class":"fwMessageAreaSucess","title":"Mensagem"})' );
					}
				}
			}
			// verificar se tem alguma mensagem de topo para ser exibida
			if( $this->getPopUpMessage() )
			{
				$aMsg = $this->getPopUpMessage();
				$aMsg[ 1 ] = isset( $aMsg[ 1 ] ) ? $aMsg[ 1 ] : 'SUCESS';
				if( $aMsg[ 1 ] == 'ERROR' && !$aMsg[ 3 ] )
				{
					$aMsg[ 3 ] = 'ruim.gif';
				}
				$aMsg[ 2 ] = isset( $aMsg[ 2 ] ) ? $aMsg[ 2 ] : 5; // duração
				$aMsg[ 3 ] = isset( $aMsg[ 3 ] ) ? $aMsg[ 3 ] : 'sucess.gif';
				// se não foi informado o endereço manualmente, encontrar na pasta base
				if( strpos( $aMsg[ 3 ], '/' ) === false )
				{
					if( !file_exists( $aMsg[ 3 ] ) )
					{
						$aMsg[ 3 ] = $this->getBase() . 'imagens/' . $aMsg[ 3 ];
					}
				}
				$this->addJavascript( 'try{ parent.app_show_message("' . $aMsg[ 0 ] . '","' . $aMsg[ 1 ] . '","' . $aMsg[ 2 ] . '","' . $aMsg[ 3 ] . '");}catch(e){alert("' . $aMsg[ 0 ] . '")}' );
			}
			// definir o campo que receberá o foco unicial
			$jsFocusField = '';
			if( !$this->getFormGridOffLine() )
			{
				if( $this->getFocusField() )
				{
					$jsFocusField = 'jQuery("#' . $this->getFocusField() . '").focus();';
				}
				else
				{
						$jsFocusField = 'jQuery(":text:visible:enabled:first").focus();';
				}
			}
			if( isset( $_POST[ 'modulo' ] ) && isset( $_REQUEST[ 'redirect' ] ) )
			{
				//if( !isset($_REQUEST['gridOffline']))
				if( ! $this->getFormGridOffLine() )
				{
					$this->addJavascript( 'try{ parent.app_setFooterModule("' . $_POST[ 'modulo' ] . '","' . (isset( $_POST[ 'acao' ] ) ? $_POST[ 'acao' ] : '') . '");}catch(e){}' );
					// compatibilidade com formdin3
					$this->addJavascript( 'try{ parent.setmodulo("' . $_POST[ 'modulo' ] . '");}catch(e){} // formdin3' );
					if( isset( $_REQUEST[ 'redirect_message' ] ) && $_REQUEST[ 'redirect_message' ] != '' )
					{
						$this->addJavascript( 'try{alert("' . $_REQUEST[ 'redirect_message' ] . '");}catch(e){}' );
					}
				}
			}
		}
		// os campos que forem autocomplete e tiverem valor, disparar o evento de validação
		if( is_array( $this->autocompleteFields ) )
		{
			$this->addJavascript( '// Inicializar e validar os campos com auto-complete' );
			foreach( $this->autocompleteFields as $fieldName=>$params )
			{
				if( isset( $params[ 'fillFields' ] ) && $params[ 'disableFields' ] )
				{
					$this->disableFields( $params[ 'fillFields' ], true );
				}
				if( method_exists($this->getField( $fieldName ),'setAutoTab'))
				{
					$this->getField( $fieldName )->setAutoTab(false);// campo autocomplete não pode ter autotab
				}
				if( $this->getField( $fieldName )->value )
				{
					$this->addJavascript( 'fwAutoCompleteValidade(fwGetObj("' . $fieldName . '"))' );
				}
			}
		}
		if( $this->getFieldType() == "form" )
		{
            // adicionar as teclas de atalho
            if( is_array(self::$shortCuts))
            {
				foreach(self::$shortCuts as $key=>$objParams)
				{
					//echo 'Tecla:'.$key.' no '.$objParams->objectId.'<br>';
					$field  = $this->getField($objParams->objectId);
					$js = null;
					if( $field )
					{
						$field->setAttribute('shortcut',$key.'|'.$objParams->objectId);
					}
					else
					{
						if( isset( $this->footerButtons[ $objParams->objectId ] ))
						{
							$this->footerButtons[ $objParams->objectId ]->setAttribute('shortcut',$key.'|'.$objParams->objectId);
						}
						else
						{
							$js ="try { fwSetShortcut('".$key."','".$objParams->objectId."',".$objParams->changeLabel.",'".$objParams->functionJs."') } catch(e) {}";
						}
					}
					if( $js )
					{
						$this->addJavascript($js);
					}
				}
            }
			$this->addJavascript('try{fwApplyShortcuts();} catch(e) {}');
			$scriptAfterShow = '';
			$_POST[ 'ajax' ] = isset( $_POST[ 'ajax' ] ) ? $_POST[ 'ajax' ] : false;
			// javascript para ajustar a altura da area body em função da altura do header e footer do formulário
			//if( !$this->showOnlyTagForm && !$_POST[ 'ajax' ] && ! isset($_REQUEST['gridOffline'] ) )
			if( !$this->showOnlyTagForm && !$_POST[ 'ajax' ] && ! $this->getFormGridOffLine() )
			{
				if( $this->getShowHeader() )
				{
					$scriptAfterShow = 'jQuery("#' . $form->getId() . '_body").height( (jQuery("#' . $form->getId() . '_area").height()-' . (($this->getFlat()) ? 10 : 25) . ')-(jQuery("#' . $form->getId() . '_header").height()+jQuery("#' . $form->getId() . '_footer").height()));';
				}
				else
				{
					//$this->addJavascript('jQuery("#'.$form->getId().'_body").height( (jQuery("#'.$form->getId().'_area").height()-'.(($this->getFlat()) ? 15 : 25).')-(jQuery("#'.$form->getId().'_footer").height()));');
					$scriptAfterShow = 'jQuery("#' . $form->getId() . '_body").height( (jQuery("#' . $form->getId() . '_area").height()-' . (($this->getFlat()) ? 15 : 25) . ')-(jQuery("#' . $form->getId() . '_footer").height()));';
				}
			}
			if( $this->getPrototypeId() )
			{
				$header = $this->getTitle();
				$header = str_replace( '<br>', '<BR>', $header );
				$header = str_replace( '<BR>', ' ', $header );
				$aDadosPrototype = array( 'winId'=>$this->getPrototypeId(), 'title'=>utf8_encode( $header ), 'width'=>$this->getWidth(), 'height'=>$this->getHeight() );
				$this->addJavascript( "parent.app_set_prototype_win(" . json_encode( $aDadosPrototype ) . ")" );
				//registra o id da janela quando estiver utilizando a classe prototype
				/*
				  $this->addJavascript("parent.lastWin.setSize({$this->getWidth()}+20,{$this->getHeight()}+20);parent.lastWin.showCenter();");
				  $header = $this->getTitle();
				  $header = str_replace('<br>','<BR>',$header);$header = str_replace('<BR>',' ',$header);
				  $this->addJavascript("try{ parent.lastWin.setTitle('{$header}')} catch(e){}");
				 */
			}
			//$this->addJavascript('jQuery("#'.$this->getId().'").show("slow",function () {'.$scriptAfterShow.'})');
			// formulario será exibido depois do parse via jquery
			if( $this->getVisible() )
			{
				// esconder e mostrar o form com efeito de fade-in
				$fadeDuration = 1;
				$this->setCss( 'display', 'block' );
				if( $this->getFade() > 0 )
				{
					$this->setCss( 'display', 'none' );
					$fadeDuration = $this->getFade();
					$this->addJavascript( 'jQuery("#' . $this->getId() . '").fadeIn(' . $fadeDuration . ',function () {' . $scriptAfterShow . $jsFocusField . '})' );
				}
				else
				{
					$this->addJavascript( $scriptAfterShow . $jsFocusField );
				}
				if( $this->getAutoSize() )
				{
					$aParams = array( 'formId'=>$this->name );
					if( $this->getPrototypeId() )
					{
						$aParams[ 'windId' ] = $this->getPrototypeId();
					}
					//$this->addJavascript('jQuery("#'.$this->name.'_body").bind("overflow",function (e) { fwFormDinAutoSize("'.$this->name.'",'.json_encode($aDadosPrototype).')});');
					$this->addJavascript( 'try{ fwFormDinAutoSize(' . json_encode( $aParams ) . ');} catch(e) {}' );
					//$this->addJavascript('jQuery("#'.$this->name.'_body").bind("overflow",function (e) { '.$overFlowFunction.'});');
				}
				// ajustar a largura dos grupos e das abas à largura do formulário.
				$this->addJavascript( 'try{ fwAdjustGroupsWidth(); fwAdjustTabsWidth(); fwAdjustHtmlFieldsWidth(); } catch(e) {}' );

			}
			// integração com o gride off-line versão antiga
			if( isset( $GLOBALS[ 'jsgride' ] ) && is_array( $GLOBALS[ 'jsgride' ] ) )
			{
				$js = '';
				foreach( $GLOBALS[ 'jsgride' ] as $grd=>$v )
				{
					$gride = $GLOBALS[ 'jsgride' ][ $grd ];
					$js .= $grd . "_estrutura = " . json_encode( $GLOBALS[ 'jsgride' ][ $grd ] ) . ";\n";
				}
				if( $js )
				{
					$this->addJavascript( '// script necessário para o grid off-line' );
					$this->addJavascript( $js );
				}
			}
		}

		if( is_array( $this->getJavascript() ) )
		{
			$js = new TElement( 'script' );
			$js->clearCss();
			$js->add( 'jQuery(document).ready(function() {' );
			$js->add( chr( 9 ) . '// javasripts que serão executados depois que o documento estiver 100% carregado. Utilizando o jquery.' );
			$alerts = array( );
			foreach( $this->getJavascript() as $k=>$strJs )
			{
				//print $strJs.'<br>';
				if( preg_match( '/alert\(/', $strJs ) > 0 )
				{
					$alerts[] = preg_replace( '/;;/', '', $strJs );
				}
				else
				{
					//$js->add(chr(9).str_replace(";;",";",$strJs.";"));
					$js->add( chr( 9 ) . preg_replace( '/;;/', '', $strJs ) );
				}
			}
			foreach( $alerts as $k=>$strJs )
			{
				$js->add( chr( 9 ) . $strJs );
			}
			$js->add( '});' );
			if( $this->getFieldType() == "tabsheet" )
			{
				$this->body->add( $js );
			}
			else
			{
				$this->add( $js );
			}
		}

		// tem que habilitar o container senão ele não é exibido
		$this->setEnabled( true );

		/* if( $this->getFieldType() == "form" )
		  {

		  if( $_POST['fw_back_to'] )
		  {
		  $this->getHeaderCell()->add('<img src="'.$this->getBase().'imagens/fwreturn16x16.gif" style="float:left;cursor:pointer;" alt="V" onClick="top.app_load_module(\''.$_POST['fw_back_to'].'\')">');
		  }
		  }
		 */

		// colocar o form dentro de uma pagina html completa com as tags html, head e body
		if( $this->getFieldType() == "form" && $this->getShowHtmlTag() )
		{
			$page = new THtmlPage();
			$this->setShowHtmlTag( false );
			$page->addInBody( parent::show( false, $this->getFlat() ) ) . $this->showPdfs( false, $this->getFlat() ) . $this->getOnlineDocDiv( false,$this->getOnlineDocHeight(),$this->getOnlineDocWidth() );
			$page->addJsCssFile( $this->getJsCss() );
			return $page->show( $print );
		}
		// se for aba ou groupbox não precisa das tags html, head e body
		else if( $this->getFieldType() == "tabsheet" )
		{
			// configurar a apresentação do form quando for um tabsheet ( aba )
			/*
			$this->setTagType( 'div' );
			$this->body->setClass( $this->getClass() );
			$this->body->setCss( $this->getCss() );
			$this->body->setId( $this->getId() );
			$parentWidth = $this->getCurrentContainer() ? $this->getCurrentContainer()->getcss('width') : $this->getCss('width');

			//--
			if( $this->body->getcss('display')=='inline')
			{
				$this->body->setcss('display','block');
			}
			*/
			/*
			if( !$this->body->getcss('height') )
			{
				$this->body->setcss('height',($this->getHeight()-120).'px');
			}
			*/
			/*
			if( !$this->body->getcss('height')=='auto' )
			{
				$this->body->setcss('overflow',null);
				$this->body->setCss('overflow-x',null);
				$this->body->setCss('overflow-y',null);
			}
			else
			{
				$this->body->setcss('overflow','hidden');
				$this->body->setCss('overflow-x',$this->getOverFlowX());
				$this->body->setCss('overflow-y',$this->getOverFlowY());
			}
			*/

		return $this->body->show( $print );
		}
		else if( $this->getFieldType() == "groupbox" || $this->getFieldType() == "coordgmsx" )
		{
			// configurar a apresentação do form quando for um groupbox
			$this->divBody->clearCss();
			//$this->divBody->setCss('width',$this->getWidth());
			$this->divBody->setCss( 'height', $this->getHeight() );
			if( is_null($this->divBody->getCss('overflow')))
			{
				$this->divBody->setCss( 'overflow', 'hidden' );
			}
			$this->divBody->setCss( 'overflow-y', $this->getOverFlowY() );
			$this->divBody->setCss( 'overflow-x', $this->getOverFlowX() );
			/*
			$this->divBody->setCss( 'overflow', 'hidden' );
			$this->divBody->setCss( 'overflow-y', 'hidden' );
			$this->divBody->setCss( 'overflow-x', 'hidden' );
			*/
			$this->body->clearCss();
			$cell = $this->table->addRow()->addCell( $this->body );
			$cell->setCss( 'vertical-align', $this->getCss( 'vertical-align' ) );
			$cell->setCss( 'text-align', $this->getCss( 'text-align' ) );
			return parent::show( $print, $this->getFlat() );
		}
		else if( $this->getFieldType() == "group" || $this->getFieldType() == "coordgms")
		{
					if( $this->getFieldType() == "coordgms" )
					{
						$this->getButtonGMap()->setEnabled(true);
					}


			// configurar a apresentação do form quando for um groupbox
			//$this->divBody->clearCss();
			//$this->divBody->setCss('width',$this->getWidth());
			//$this->divBody->setCss( 'height', $this->getHeight() );
			//if( is_null($this->divBody->getCss('overflow')))
			//{
			//	$this->divBody->setCss( 'overflow', 'hidden' );
			//}
			//$this->divBody->setCss( 'overflow-y', $this->getOverFlowY() );
			//$this->divBody->setCss( 'overflow-x', $this->getOverFlowX() );
			/*
			if( is_null($this->divBody->getCss('overflow')))
			{
				$this->divBody->setCss( 'overflow', 'hidden' );
			}
			$this->divBody->setCss( 'overflow-y', $this->getOverFlowY() );
			$this->divBody->setCss( 'overflow-x', $this->getOverFlowX() );
			*/
			//$this->body->setProperty('luis','eugenio');
			//$this->body->setCss('overflow','auto'
			$this->body->clearCss(); // retirar as bordas do top e bottom
			$cell = $this->table->addRow()->addCell( $this->body );
			$this->table->clearCss();
			$cell->setCss( 'vertical-align', $this->getCss( 'vertical-align' ) );
			$cell->setCss( 'text-align', $this->getCss( 'text-align' ) );
			return parent::show( $print, $this->getFlat() );
			//return parent::show($print);
		}
		else
		{
			return parent::show( $print, $this->getFlat() ) . $this->showPdfs( $print, $this->getFlat() ) . $this->getOnlineDocDiv( $print,$this->getOnlineDocHeight(),$this->getOnlineDocWidth() );
		}
	}
	//-----------------------------------------------------------------------------
	/**
	 * Define a largura do formulário
	 *
	 * @param integer $strNewValue
	 */
	public function setWidth( $strNewValue=200 )
	{
		if( $this->getFieldType() == 'form' )
		{
			if( ( int ) $strNewValue < 200 )
			{
				$strNewValue = 200;
			}
		}
		return parent::setWidth( $strNewValue );
	}
	//-----------------------------------------------------------------------------
	/**
	 * Define a altura do formulário
	 *
	 * @param integer $strNewValue
	 */
	public function setHeight( $strNewValue=100 )
	{
		if( $this->getFieldType() == 'form' )
		{
			if( ( int ) $strNewValue < 100 )
			{
				$strNewValue = 100;
			}
		}
		return parent::setHeight( $strNewValue );
	}
	//-----------------------------------------------------------------------------
	/**
	 * Implementa o recurso de autosugestão a um campo texto do formulário utilizando jquery
	 *
	 * @link http://www.pengoworks.com/workshop/jquery/autocomplete_docs.txt
	 *
	 * @strUrl - se for informada a url que devolverá os dados para o autocomplete, o retorno deverá ser no seguinte formato:
	 * "descriçao|chave\n"  exemplo: echo "Abacate|123\n"
	 *
	 * <code>
	 * 	$frm->setAutoComplete( 'num_cpf',
	 *                   'PESSOA_FISICA, // nome da tabela
	 *                   'NUM_CPF',
	 *                   'NUM_PESSOA|num_pessoa,NOM_PESSOA,COD_UNIDADE_IBAMA,END_PESSOA,DES_BAIRRO,NUM_CEP,NUM_FONE,DES_EMAIL,NOM_MUNICIPIO,DAT_NASC,NOM_UNIDADE_IBAMA,COD_UNIDADE_EXERCICIO,NOM_UNIDADE_EXERCICIO,COD_UF,SIG_UF,COD_MATRICULA',
	 *                   false,
	 *                   null,
	 *                   null,
	 *                   14,
	 *                   400,
	 *                   2,
	 *                   null,
	 *                   true );
	 * </code>
	 *
	 * @param string $strFieldName
	 * @param string $strTablePackageFuncion
	 * @param string $strSearchField
	 * @param mixed $mixUpdateFields
	 * @param boolea $boolDisableUpdateFields
	 * @param mixed $mixExtraSearchFields
	 * @param string $strCallBackFunctionJs
	 * @param integer $intMinChars
	 * @param integer $intDelay
	 * @param integer $intMaxItensToShow
	 * @param integer $intCacheTime default = 0 ( sessão )
	 * @param boolean $boolRemoveMask
	 * @param string $strUrl
	 * @param string $strMessageNotFound
	 * @params boolean $boolKeepFieldValuesOnPost
	 * @params boolean $boolClearOnNotFound
     * @params boolean $boolClearUpdateFields
     * @params boolean $boolSearchAnyPosition
	 */
	public function setAutoComplete( $strFieldName, $strTablePackageFuncion, $strSearchField, $mixUpdateFields=null, $boolDisableUpdateFields=null, $mixExtraSearchFields=null, $strCallBackFunctionJs=null, $intMinChars=null, $intDelay=null, $intMaxItensToShow=null, $intCacheTime=null, $boolRemoveMask=null, $strUrl=null, $strMessageNotFound=null, $boolKeepFieldValuesOnPost=null, $boolClearOnNotFound=null, $boolClearUpdateFields=null,$boolSearchAnyPosition=null )
	{

		// não criar o autocomplente se o campo não existir
		if( !$this->getField( $strFieldName ) )
		{
			return;
		}
		//$strUrl						= $strUrl					=== null	? $this->getBase().'callbacks/autocomplete.php' : $strUrl;
		//$strUrl = $strUrl === null ? 'app_url+app_index_file+"?modulo=' . $this->getBase() . 'callbacks/autocomplete.php' : $strUrl;
		$strUrl = $strUrl === null ? 'app_index_file+"?modulo=' . $this->getBase() . 'callbacks/autocomplete.php' : $strUrl;
		$intDelay = $intDelay === null ? 1000 : ( int ) $intDelay; // 1000 = 1 segund
		$intMaxItensToShow = $intMaxItensToShow === null ? 50 : ( int ) $intMaxItensToShow;
		$intMinChars = $intMinChars === null ? 3 : ( int ) $intMinChars;
		$intCacheTime = $intCacheTime === null ? 0 : ( int ) $intCacheTime; // 0 = sessão
		$boolRemoveMask = $boolRemoveMask === null ? false : ( bool ) $boolRemoveMask;
		$boolDisableUpdateFields = $boolDisableUpdateFields === null ? true : ( bool ) $boolDisableUpdateFields;
		$boolClearOnNotFound = $boolClearOnNotFound === null ? true : ( bool ) $boolClearOnNotFound;
		$boolClearUpdateFields = $boolClearUpdateFields === null ? true : ( bool ) $boolClearUpdateFields;
		$strMessageNotFound = $strMessageNotFound === null ? 'Nenhum registro encontrado' : ( string ) $strMessageNotFound;
		$boolSearchAnyPosition = ( $boolSearchAnyPosition === true ? true : false );
		if(is_null( $boolKeepFieldValuesOnPost))
		{
			//if( $_REQUEST['gridOffline'] == 1 )
			if( $this->getFormGridOffLine() )
			{
				$boolKeepFieldValuesOnPost=true;
			}
		}
		$boolKeepFieldValuesOnPost = $boolKeepFieldValuesOnPost === null ? false : (bool)$boolKeepFieldValuesOnPost;
		$strExtraParams = "";
		$strLimparCampos = "";
		$aTemp[ 'tablePackageFunction' ] = $strTablePackageFuncion;
		$aTemp[ 'searchField' ] = $strSearchField;
		$aTemp[ 'cacheTime' ] = $intCacheTime;
		$aTemp[ 'searchAnyPosition' ] = $boolSearchAnyPosition;
		//$aTemp['messageNotFound']	= $strMessageNotFound;
		if( ( string ) $strCallBackFunctionJs )
		{
			if( !strpos( $strCallBackFunctionJs, '(' ) )
			{
				$strCallBackFunctionJs.="()";
			}
			$aTemp[ 'functionJs' ] = $strCallBackFunctionJs;
		}
		if( $mixUpdateFields )
		{
			if( !is_array( $mixUpdateFields ) )
			{
				$mixUpdateFields = explode( ',', $mixUpdateFields );
			}
			forEach( $mixUpdateFields as $k=>$v )
			{
				if( is_int( $k ) )
				{
					$aField = explode( '|', $v );
					if( !isset( $aField[ 1 ] ) )
					{
						$aField[ 1 ] = strtolower( $aField[ 0 ] );
					}
					$k = strtoupper( $aField[ 0 ] );
					$v = $aField[ 1 ];
				}
				// o campo que recebe o autocomplete não pode estar na lista dos campos que serão atualizados no formulário.
				if( $v != $strFieldName )
				{
					$strExtraParams = (isset( $strExtraParams ) && strlen( $strExtraParams ) > 0 ? $strExtraParams . "," : "");
					$strFillFields = (isset( $strFillFields ) && strlen( $strFillFields ) > 0 ? $strFillFields . "," : "");
					$strExtraParams.='"' . $k . '":"' . $v . '"'; //"COD_UF":"cod_uf"
					$aTemp[ '_u_' . $k ] = $v;
					$strFillFields .= $v;
				}
			}
		}
		if( $mixExtraSearchFields )
		{
			/* o parametro $mixExtraParams deve ser utilizado para passagem de parametros extras para a url alem do conteúdo digitado no campo
			  O formato pode ser uma string ou um array de string com ou sem valores fixos
			  Ex: "cod_uf:53" ou  array("cod_uf",'sig_uf'=>'GO')
			  Se o parametro passado não tiver um valor fixado, este valor será lido dinamicamente de um campo do formulario que
			  possua o mesmo nome.
			 */
			if( is_array( $mixExtraSearchFields ) )
			{
				forEach( $mixExtraSearchFields as $k=>$v )
				{
					if( is_int( $k ) )
					{
						$k = $v;
						$v = null;
					}
					$strExtraParams .= $strExtraParams == '' ? '' : ',';
					if( ( string ) $v == "" )
					{
						if( $this->getField( $k ) )
						{
							$v = 'jQuery("#' . $k . '").get(0).value';
						}
					}
					$strExtraParams.='"' . $k . '":' . $v;
					//$aSearchFields[$k]=$v;
					$aTemp[ '_w_' . $k ] = $v;
				}
			}
			else
			{
				if( !strpos( $mixExtraSearchFields, ":" ) )
				{
					//$aSearchFields[$mixExtraSearchFields] ='jQuery("#'.$mixExtraSearchFields.'").get(0).value';
					//$aTemp['_w_'.$mixExtraSearchFields] ='jQuery("#'.$mixExtraSearchFields.'").get(0).value';
					$field = explode('|',$mixExtraSearchFields);


					$aTemp[ '_w_' . $mixExtraSearchFields ] = '';
					if( !$this->getField( $field[0] ) )
					{
						print 'SetAutoComplete: O campo ' . $field[0] . ' não exite no formulário.';
					}

					$mixExtraSearchFields = '"' . $mixExtraSearchFields . '":' . $v = 'jQuery("#' . $mixExtraSearchFields . '").get(0).value';
				}
				$strExtraParams.= $strExtraParams == '' ? '' : ',';
				$strExtraParams.= $mixExtraSearchFields;
			}
		}
		$strExtraParams = str_replace( array( '{', '}', ':"$', ').value"', '"jQuery("#', '\").get', '"{', '}"' ), array( '', '', ':$', ').value', 'jQuery("#', '").get', '{', '}' ), stripcslashes( json_encode( $aTemp ) ) );
		$this->addJavascript( 'jQuery("#' . $strFieldName . '").autocomplete(' . $strUrl . '&ajax=1", { ajax:1, delay:' . $intDelay . ', minChars:' . $intMinChars . ', matchSubset:1, matchContains:1, cacheLength:10, onItemSelect:fwAutoCompleteSelectItem, onFindValue:fwAutoCompleteFindValue, matchCase:false, maxItemsToShow:' . $intMaxItensToShow . ', autoFill:true, selectFirst:true, mustMatch:false, selectOnly:true,removeMask:' . ($boolRemoveMask ? 'true' : 'false') . ',messageNotFound:"' . $strMessageNotFound . '",clearOnNotFound:' . ($boolClearOnNotFound ? 'true' : 'false') .',extraParams:{' . $strExtraParams . '} });' );
		$this->getField( $strFieldName )->addEvent( 'ondblclick', 'fwAutoCompleteValidade(this)' );
		if( $boolClearUpdateFields )
		{
			$this->getField( $strFieldName )->addEvent( 'onkeydown', 'fwSetFields("' . $strFillFields . '","",event)' );
		}
		$this->getField( $strFieldName )->setAttribute('keepFieldValues',$boolKeepFieldValuesOnPost);
		$this->autocompleteFields[ $strFieldName ][ 'disableFields' ] = $boolDisableUpdateFields;
		$this->autocompleteFields[ $strFieldName ][ 'fillFields' ] = isset( $strFillFields ) ? $strFillFields : null;

		if( !$this->getField( $strFieldName )->getProperty( 'title' ) )
		{
			// colocar hint no input para auxiliar o usuário
			if( ( int ) $intMinChars < 5 )
			{
				if( !$this->getField( $strFieldName )->getTooltip() )
				{
					$this->getField( $strFieldName )->setTooltip( 'Campo autocompletar', 'Inicie a digitação e aguarde a lista de opções!' );
				}
			}
		}
		//$this->getField($strFieldName)->addEvent('onkeyup','jQuery("'.$strFillFields.'").get(0).value="?"');
	}
	//-----------------------------------------------------------------------------
	/**
	 * Método para adicionar funções javascript ao formulario que serão executadas
	 * após o mesmo tiver sido completamente carregado pelo browser
	 *
	 * O parametro, $intIndex é opcional, e deve ser utilizado para estabelecer a ordem de
	 * execução dos códigos javascripts, do menor para o maior
	 *
	 * Para retornar o conteudo das variáveis php $_POST,$_GET ou $_REQUEST no formato json,
	 * basta passar o nome da função no formato: minhaFuncao(POST) ou minhaFuncao(GET) ou minhaFuncao(REQUEST);
	 *
	 * <code>
	 * 	addJavascript("alert('mensagem 1')");
	 * 	addJavascript("alert('mensagem 2')",10);
	 * 	addJavascript("var x=1;");
	 *  addJavascript(POST); // retorna o $_POST no formato Json
	 *  addJavascript(GET); // retorna o $_GET no formato Json
	 *  addJavascript(REQUEST); // retorna o $_REGUEST no formato Json
	 * </code>
	 *
	 * @param string $strJs
	 * @param integer $intIndex
	 */
	public function addJavascript( $strJs, $intIndex=null )
	{

		if( $strJs )
		{
			// adicionar parentes se tiver passado o nome da função
			if( !preg_match('/[ =\(]/',$strJs))
			{
				//$strJs.='('.json_encode($_REQUEST).')';
				$strJs.='()';
			}
			// quando for passado assim: minhaFuncao(POST), retornar os valores do $_POST
			if( preg_match('/\(POST\)/',$strJs) )
			{
				$strJs = preg_replace('/\(POST\)/','('.json_encode($_POST).')',$strJs );
			}
			else if( preg_match('/\(GET\)/',$strJs) )
			{
				$strJs = preg_replace('/\(GET\)/','('.json_encode($_GET).')',$strJs );
			}
			else if( preg_match('/\(REQUEST\)/',$strJs) )
			{
				$strJs = preg_replace('/\(REQUEST\)/','('.json_encode($_REQUEST).')',$strJs );
			}
			// adicionar ; se não tiver
			if( preg_match( '/;\z/', $strJs ) == 0 )
			{
				$strJs .= ';';
			}
			if( preg_match( '/GB_HIDE/i', $strJs ) > 0 )
			{
				//$strJs .= ';return;';
			}
		}
		if( isset( $intIndex ) )
		{
			if( isset( $this->javascript[ $intIndex ] ) )
			{
				while( isset( $this->javascript[ $intIndex ] ) && $intIndex < 1000 )
				{
					$intIndex++;
				}
			}
			$this->javascript[ $intIndex ] = $strJs;
		}
		else
		{
			if( !is_array( $this->getJavascript() ) )
			{
				// começar no indice 20 para poder inserir algum javascript que precise
				// ser executado primeiro
				$this->javascript[ 20 ] = $strJs;
			}
			else
			{
				$this->javascript[ ] = $strJs;
			}
		}
	}
	//-----------------------------------------------------------------------------
	/**
	 * Retorna o array com os scripts adicionados no formulario
	 *
	 */
	public function getJavascript()
	{
		$arrTemp = null;
		if( is_array( $this->javascript ) )
		{
			$arrTemp = ( array ) $this->javascript;
			ksort( $arrTemp );
		}
		return $arrTemp;
	}
	/**
	 * Metodo para recuperar o objeto campo do formulario.
	 *
	 * <code>
	 * 	$f = $frm->getField('nom_pessoa');
	 * 	$f->setCss('color','red');
	 * </code>
	 *
	 * @param string $strFieldName
	 * @return object
	 */
	public function getField( $strFieldName=null )
	{
		$field = null;
		if( is_array( $this->displayControls ) )
		{
			if( array_key_exists( $strFieldName, $this->displayControls ) )
			{
				return $this->displayControls[ $strFieldName ]->getField();
			}
			else if( array_key_exists( strtolower($strFieldName), $this->displayControls ) )
			{
				return $this->displayControls[ strtolower($strFieldName) ]->getField();
			}
			else if( array_key_exists( strtoupper($strFieldName), $this->displayControls ) )
			{
				return $this->displayControls[ strtoupper($strFieldName) ]->getField();
			}
			// varrer todo o array para pesquisar dentro de abas e grupos
			foreach( $this->displayControls as $id=>$dc )
			{
				//print $id.'=>'.$dc->getField()->getFieldType().'<br>';
				if( $dc->getField()->getFieldType() == 'pagecontrol' )
				{
					if( $field = $dc->getField()->getField( $strFieldName ) )
					{
						break;
					}
				}
				else if( $dc->getField()->getFieldType() == 'coordgms' )
				{
					if( $dc->getField()->getFieldNameLon() == $strFieldName )
					{
						return $dc->getField();
						break;
					}
					elseif( $dc->getField()->getFieldNameLat() == $strFieldName )
					{
						return $dc->getField();
						break;
					}
				}
				else if( $dc->getField()->getFieldType() == 'group' )
				{
					if( $field = $dc->getField()->getField( $strFieldName ) )
					{
						break;
					}
				}
			}
		}
		return $field;
	}
	/**
	 * Retorna o objeto label do campo permitindo alterar suas propriedades
	 *
	 * <code>
	 * 	$frm->getLabel('dat_aniversario')->setCss('text-align','right');
	 * </code>
	 *
	 * @param mixed $strFieldName
	 */
	public function getLabel( $strFieldName=null )
	{
		$label = null;

		if( is_array( $this->displayControls ) )
		{
			if( array_key_exists( $strFieldName, $this->displayControls ) )
			{
				return $this->displayControls[ $strFieldName ]->getLabel();
			}

			// varrer todo o array para pesquisar dentro de abas e grupos
			foreach( $this->displayControls as $id=>$dc )
			{
				if( $dc->getField()->getFieldType() == 'pagecontrol' )
				{
					if( $label = $dc->getField()->getLabel($strFieldName) )
					{
						break;
					}
				}
				else if( $dc->getField()->getFieldType() == 'coordgms' )
				{
					if( $dc->getField()->getFieldNameLon() == $strFieldName )
					{
						return $dc->getLabel();
						break;
					}
					elseif( $dc->getField()->getFieldNameLat() == $strFieldName )
					{
						return $dc->getLabel();
						break;
					}
				}
				else if( $dc->getField()->getFieldType() == 'group' )
				{
					if( $label = $dc->getField()->getLabel( $strFieldName ) )
					{
						break;
					}
				}
			}
		}
		return $label;
	}
	/**
	 * Validar os campos do formulario,Abas ou Grupos
	 *
	 * Os erros encontrados serão adicionados ao array estático self::errors
	 *
	 * O parametro $strPage deve ser utilizado para validar os campos de uma aba/grupo quando
	 * necessario
	 *
	 * <code>
	 * 	if( $frm->validate() )
	 * 	{
	 * 		$frm->setMessage('Dados Ok');
	 * 	}
	 * </code>
	 *
	 * @param string $strPage
	 * @return boolean
	 */
	public function validate( $strPage=null, $strFields=null, $strIgnoreFields=null )
	{
		if( !is_array( $this->displayControls ) )
		{
			return true;
		}
		//$strPage = $this->removeIllegalChars($strPage);
		foreach( $this->displayControls as $name=>$dc )
		{

			$field = $dc->getField();
			if( $field->getFieldType() == 'tag' ) // não possui validação
			{

			}
			else if( $field->getFieldType() == 'helpbox' ) // não possui validação
			{

			}
			else if( $field->getFieldType() == 'link' ) //não possui validação
			{

			}
			else if( $field->getFieldType() == 'pagecontrol' )
			{
				$field->validate( $strPage,$strFields, $strIgnoreFields );
			}
			else if( $field->getFieldType() == 'group' )
			{
				$field->validate( $strPage,$strFields, $strIgnoreFields );
			}
			else
			{
				if( $strPage === null )
				{

					$aValidFields=array();
					if( $strFields )
					{
						$aValidFields = explode(',',preg_replace('/ /','',$strFields ) );
					}
					$aIgnoreFields=array();
					if( $strIgnoreFields )
					{
						$aIgnoreFields = explode(',',preg_replace('/ /','',$strIgnoreFields ) );
					}

					if( !in_array($field->getId(),$aIgnoreFields) && ( ! $aValidFields || in_array($field->getId(),$aValidFields) ) && method_exists( $field, 'validate' ) && !$field->validate() )
					{
						$tbsName = '';
						$tab = '';
						// adicionar o nome da aba na mensagem de campos inválidos do formulário
						//if($this->getFieldType()=='tabsheet')
						//{
						// a variavel $tbsName tem que conter um espaço para diferenciar do nome de um campo com erro
						// e permitir setar o foco no primeiro campo que contiver um erro.
						//print $this->getId().'<br>';
						//$tbsName = '(Aba '.substr($this->getId(),(strpos($this->getId(),'_'))).'):';
						/*
						  $tbsName = '(Aba '.$this->getValue().') :';
						  if(!array_key_exists($tbsName,$this->getErrors()))
						  {
						  self::$errors[$tbsName]=$tbsName;
						  }
						  $tab='\t';
						 */
						//}
                        $label='';
						if( $dc->getLabel() )
						{
							if( $field->getFieldType() == 'captcha' )
							{
								if( $dc->getLabel()->getValue() == '' )
								{
									$label = 'C&oacute;digo de seguran&ccedil;a';
								}
							}
							self::$errors[ $field->getId() ] = str_replace( "::", ":", $tab . $label.$dc->getLabel()->getValue() . ':' . $field->getError() );
						}
						else
						{

							if( $field->getFieldType() == 'hidden' )
							{
								self::$errors[ $field->getId() ] = 'Campo oculto ' . $field->getId() . ':' . $field->getError();
							}
							else
							{
								self::$errors[ $field->getId() ] = $field->getError();
							}
						}
					}
				}
			}
		}
		return (count( self::$errors ) == 0);
	}
	//-----------------------------------------------------------------------------
	/**
	 * Define o campo que receberá o foco inicial quando o formulário for exibido
	 *
	 * @param mixed $strFieldName
	 */
	function setFocusField( $strFieldName=null )
	{
		$this->focusField = $strFieldName;
		// definir o campo foco unicial dos pagecontrols para quando
		// for montar a aba saber se o campo foco pertence a ela
		// e defini-la como aba inicial do pagecontrol
		if( is_array( $this->displayControls ) )
		{
			foreach( $this->displayControls as $idField=>$dc )
			{
				if( $dc->getField()->getFieldType() == 'pagecontrol' )
				{
					$dc->getField()->setFocusField( $this->getFocusField() );
				}
				else if( $dc->getField()->getFieldType() == 'group' )
				{
					$dc->getField()->setFocusField( $this->getFocusField() );
				}
				else if( $dc->getField()->getFieldType() == 'coordgms' )
				{
					$this->focusField = $dc->getField()->getId() . '_lat_grau';
				}
			}
		}
	}
	/**
	 * Retorna o campo definido para receber o foco inicial quando o formulário for exibido
	 *
	 */
	public function getFocusField()
	{
		return $this->focusField;
	}
	/**
	 * Define ou limpa as mensagens que serão exibidas na tela via alert() em javascript
	 *
	 * <code>
	 * 	$frm->setMessage(); // limpar todas as mensagns
	 * 	$frm->setMessage('Nova mensagem'); // limpa e define uma nova mensagem
	 * 	$frm->setMessage(array('Mensagem linha 1','mensagem linha 2');
	 * </code>
	 *
	 * @param string $mixMessage
	 */
	public function setMessage( $mixMessage=null )
	{
		if( is_array( $mixMessage ) )
		{
			$mixMessage = implode( '\n', $mixMessage );
			$this->setMessage( $mixMessage );
		}
		else If( is_null( $mixMessage ) )
		{
			$this->messages = null;
		}
		else
		{
			$mixMessage = preg_replace( '/"/', '', $mixMessage );
			$this->messages = array( $mixMessage );
			/* if( isset( $_REQUEST['ajax'] ) && isset( $_REQUEST['dataType'] ) && $_REQUEST['dataType'] == 'text' )
			  {
			  echo $mixMessage."\n";
			  }
			 */
		}
	}
	/**
	 * Define a mensagem para ser exibida no topo da tela em uma div com efeito de auto-esconder
	 *
	 * intSeconds -> tempo em segundos que a mensagem ficará visível na tela. Default: 5
	 * strType -> define a cor de fundo e boda, pode ser ERROR, SUCESS. Default: SUCESS
	 * strImage -> icone que será exibido à esquerda da mensagem . Default:sucess.gif
	 * <code>
	 * 	$frm->setPopupMessge('Dados gravados corretamente');
	 * </code>
	 * @param string $strMessage
	 * @param integer $intSeconds
	 * @param string $strType
	 * @param string $strImage
	 */
	public function setPopUpMessage( $strMessage=null, $intSeconds=null, $strType=null, $strImage=null )
	{
		$this->messagePopUp = array( $strMessage, $strType, $intSeconds, $strImage );
	}
	/**
	 * Retorna a mensagem popup atual
	 *
	 */
	public function getPopUpMessage()
	{
		return $this->messagePopUp;
	}
	/**
	 * Adiciona uma mensagem à lista, para ser exibida na tela via alert() em javascript quando o formulário for exibido
	 *
	 * <code>
	 * 	$frm->addMessae('Mensagem nova');
	 * 	$frm->addMessae(array('Mensagem 1', 'Mensagem 2');
	 * </code>
	 *
	 * @param string $mixMessage
	 */
	public function addMessage( $mixMessage=null )
	{
		if( is_array( $mixMessage ) )
		{
			$mixMessage = implode( '\n', $mixMessage );
		}
		$mixMessage = preg_replace( '/' . chr( 10 ) . '/', '\n', $mixMessage );
		$mixMessage = preg_replace( '/' . chr( 13 ) . '/', '', $mixMessage );
		$mixMessage = preg_replace( '/"/', '', $mixMessage );
		$this->messages[ ] = $mixMessage;
	}
	/**
	 * Recupera a lista de mensagens que serao exibidas na tela via javascript quando o formulario for exibido
	 *
	 * @return array
	 */
	public function getMessages()
	{
		return $this->messages;
	}
	/**
	 * Desabilitar/Habilitar campos do formulário
	 * Pode ser passado um campo ou varios, separados por virgula,
	 * tambem pode ser um array de campos.
	 * Se for passado null, todos os campos serão desabilitados.
	 *
	 * <code>
	 * 	$form->disableFields('nom_pessoa');
	 * 	$form->disableFields('nom_pessoa,des_endereco');
	 * 	$form->disableFields(array('nom_pessoa,des_endereco'));
	 * </code>
	 *
	 * @param mixed $mixFields
	 * @param boolean $boolNewValue
	 */
	public function disableFields( $mixFields=null, $mixIgnoreFields=null, $boolNewValue=null, $boolClearOnlieSearch=null )
	{
		if( is_null( $mixFields ) )
		{
			if( $boolClearOnlieSearch === true )
			{
				$this->clearOnlineSearch();
			}
			if( is_array( $this->displayControls ) )
			{
				foreach( $this->displayControls as $name=>$dc )
				{
					$field = $dc->getField();
					if( $field->getFieldType() == 'pagecontrol' )
					{
						$field->disableFields( null, $mixIgnoreFields, $boolNewValue );
					}
					else if( $field->getFieldType() == 'group' )
					{
						$field->disableFields( null, $mixIgnoreFields, $boolNewValue );
					}
					else if( $field->getFieldType() == 'tag' )
					{

					}
					else if( $field->getFieldType() == 'html' )
					{

					}
					else
					{
						// evitar loop infinito
						$fieldName = $field->getName() ? $field->getName() : $field->getId();
						if( $fieldName )
						{
							$this->disableFields( $fieldName, $mixIgnoreFields, $boolNewValue );
						}
					}
				}
			}
		}
		else
		{
			$boolNewValue = ($boolNewValue === null) ? true : ( bool ) $boolNewValue;
			if( isset( $mixIgnoreFields ) && !is_array( $mixIgnoreFields ) )
			{
				$mixIgnoreFields = explode( ',', $mixIgnoreFields );
			}
			if( is_array( $mixFields ) )
			{
				foreach( $mixFields as $k=>$v )
				{
					$this->disableFields( $v, $mixIgnoreFields, $boolNewValue );
				}
			}
			else
			{
				if( strpos( $mixFields, ',' ) > 0 )
				{
					$mixFields = explode( ',', $mixFields );
					$this->disableFields( $mixFields, $mixIgnoreFields, $boolNewValue );
				}
				else
				{
					if( $field = $this->getField( $mixFields ) )
					{
						if( !isset( $mixIgnoreFields ) || !in_array( $mixFields, $mixIgnoreFields ) )
						{
							$field->setEnabled( !$boolNewValue );
						}
					}
				}
			}
		}
	}
	/**
	 * Método para retornar um array com dados das UFs
	 *
	 * <code>
	 * 	$frm->getUfs("COD_UF,SIG_UF"); // retorna array com codigo e sigla
	 * 	$frm->getUf("SIG_UF,NOM_UF"); // retorna array com sigla e nome
	 * </code>
	 *
	 * @param string $strReturnColumns
	 * @return array
	 */
	public function getUfs( $strReturnColumns=null )
	{
		$strReturnColumns = $strReturnColumns === null ? 'COD_UF,NOM_UF' : $strReturnColumns;
		$aCols = explode( ',', $strReturnColumns );
		$aUf = null;
		$aUf[ "COD_UF" ][ 2 ] = "12";
		$aUf[ "SIG_UF" ][ 2 ] = "AC";
		$aUf[ "NOM_UF" ][ 2 ] = "ACRE";
		$aUf[ "COD_UF" ][ 14 ] = "27";
		$aUf[ "SIG_UF" ][ 14 ] = "AL";
		$aUf[ "NOM_UF" ][ 14 ] = "ALAGOAS";
		$aUf[ "COD_UF" ][ 6 ] = "16";
		$aUf[ "SIG_UF" ][ 6 ] = "AP";
		$aUf[ "NOM_UF" ][ 6 ] = "AMAPA";
		$aUf[ "COD_UF" ][ 3 ] = "13";
		$aUf[ "SIG_UF" ][ 3 ] = "AM";
		$aUf[ "NOM_UF" ][ 3 ] = "AMAZONAS";
		$aUf[ "COD_UF" ][ 16 ] = "29";
		$aUf[ "SIG_UF" ][ 16 ] = "BA";
		$aUf[ "NOM_UF" ][ 16 ] = "BAHIA";
		$aUf[ "COD_UF" ][ 10 ] = "23";
		$aUf[ "SIG_UF" ][ 10 ] = "CE";
		$aUf[ "NOM_UF" ][ 10 ] = "CEARA";
		$aUf[ "COD_UF" ][ 27 ] = "53";
		$aUf[ "SIG_UF" ][ 27 ] = "DF";
		$aUf[ "NOM_UF" ][ 27 ] = "DISTRITO FEDERAL";
		$aUf[ "COD_UF" ][ 18 ] = "32";
		$aUf[ "SIG_UF" ][ 18 ] = "ES";
		$aUf[ "NOM_UF" ][ 18 ] = "ESPIRITO SANTO";
		$aUf[ "COD_UF" ][ 26 ] = "52";
		$aUf[ "SIG_UF" ][ 26 ] = "GO";
		$aUf[ "NOM_UF" ][ 26 ] = "GOIÁS";
		$aUf[ "COD_UF" ][ 8 ] = "21";
		$aUf[ "SIG_UF" ][ 8 ] = "MA";
		$aUf[ "NOM_UF" ][ 8 ] = "MARANHÃO";
		$aUf[ "COD_UF" ][ 25 ] = "51";
		$aUf[ "SIG_UF" ][ 25 ] = "MT";
		$aUf[ "NOM_UF" ][ 25 ] = "MATO GROSSO";
		$aUf[ "COD_UF" ][ 24 ] = "50";
		$aUf[ "SIG_UF" ][ 24 ] = "MS";
		$aUf[ "NOM_UF" ][ 24 ] = "MATO GROSSO DO SUL";
		$aUf[ "COD_UF" ][ 17 ] = "31";
		$aUf[ "SIG_UF" ][ 17 ] = "MG";
		$aUf[ "NOM_UF" ][ 17 ] = "MINAS GERAIS";
		$aUf[ "COD_UF" ][ 5 ] = "15";
		$aUf[ "SIG_UF" ][ 5 ] = "PA";
		$aUf[ "NOM_UF" ][ 5 ] = "PARA";
		$aUf[ "COD_UF" ][ 12 ] = "25";
		$aUf[ "SIG_UF" ][ 12 ] = "PB";
		$aUf[ "NOM_UF" ][ 12 ] = "PARAIBA";
		$aUf[ "COD_UF" ][ 21 ] = "41";
		$aUf[ "SIG_UF" ][ 21 ] = "PR";
		$aUf[ "NOM_UF" ][ 21 ] = "PARANA";
		$aUf[ "COD_UF" ][ 13 ] = "26";
		$aUf[ "SIG_UF" ][ 13 ] = "PE";
		$aUf[ "NOM_UF" ][ 13 ] = "PERNAMBUCO";
		$aUf[ "COD_UF" ][ 9 ] = "22";
		$aUf[ "SIG_UF" ][ 9 ] = "PI";
		$aUf[ "NOM_UF" ][ 9 ] = "PIAUI";
		$aUf[ "COD_UF" ][ 19 ] = "33";
		$aUf[ "SIG_UF" ][ 19 ] = "RJ";
		$aUf[ "NOM_UF" ][ 19 ] = "RIO DE JANEIRO";
		$aUf[ "COD_UF" ][ 11 ] = "24";
		$aUf[ "SIG_UF" ][ 11 ] = "RN";
		$aUf[ "NOM_UF" ][ 11 ] = "RIO GRANDE DO NORTE";
		$aUf[ "COD_UF" ][ 23 ] = "43";
		$aUf[ "SIG_UF" ][ 23 ] = "RS";
		$aUf[ "NOM_UF" ][ 23 ] = "RIO GRANDE DO SUL";
		$aUf[ "COD_UF" ][ 1 ] = "11";
		$aUf[ "SIG_UF" ][ 1 ] = "RO";
		$aUf[ "NOM_UF" ][ 1 ] = "RONDONIA";
		$aUf[ "COD_UF" ][ 4 ] = "14";
		$aUf[ "SIG_UF" ][ 4 ] = "RR";
		$aUf[ "NOM_UF" ][ 4 ] = "RORAIMA";
		$aUf[ "COD_UF" ][ 22 ] = "42";
		$aUf[ "SIG_UF" ][ 22 ] = "SC";
		$aUf[ "NOM_UF" ][ 22 ] = "SANTA CATARINA";
		$aUf[ "COD_UF" ][ 20 ] = "35";
		$aUf[ "SIG_UF" ][ 20 ] = "SP";
		$aUf[ "NOM_UF" ][ 20 ] = "SAO PAULO";
		$aUf[ "COD_UF" ][ 15 ] = "28";
		$aUf[ "SIG_UF" ][ 15 ] = "SE";
		$aUf[ "NOM_UF" ][ 15 ] = "SERGIPE";
		$aUf[ "COD_UF" ][ 7 ] = "17";
		$aUf[ "SIG_UF" ][ 7 ] = "TO";
		$aUf[ "NOM_UF" ][ 7 ] = "TOCANTINS";
		$result = null;
		foreach( $aUf[ $aCols[ 0 ] ] as $k=>$v )
		{
			$result[ $v ] = $aUf[ $aCols[ 1 ] ][ $k ];
		}
		return $result;
	}
	/**
	 * Método para fazer campos selects em cascata, onde o valor do select filho depende
	 * do valor do select pai
	 * O parametro pacoteFuncaoOracle pode ser o nome de uma tabela ou visão
	 * Se for utilizar a classe banco, pode ser passado o tempo do cache separado com pipe
	 * Ex: sisteste.pkg_geral.sel_municipio|60 ( chave de 60 segundos ), para não utilizar cache
	 * passe -1, para utilizar a sessão passe 0 ( zero )
	 *
	 * O parametro $strFuncaoExecutar é o nome de uma função que será chamada quando o campo pai for alterado ( onChange ).
	 *
	 * o Parametro $campoFormFiltro dever estar no formato: campo_formulario|campo_banco. Ex: nome_usuario|NOM_USUARIO, quando
	 * o nome do formulário for diferente do nome do parametro do banco de dados
	 *
	 * O parametro $boolSelectUniqueOption ativa a seleção automática quando houver apenas uma opção disponível
	 *
	 * @example exemple/exCampoSelectAgrupado.php
	 *
	 *
	 * @param string $selectPai
	 * @param string $selectFilho
	 * @param string $TabelaPacoteFuncao
	 * @param string $colunaFiltro
	 * @param string $colunaCodigo
	 * @param string $colunaDescricao
	 * @param string $descPrimeiraOpcao
	 * @param string $valorPrimeiraOpcao
	 * @param string $descNenhumaOpcao
	 * @param string $campoFormFiltro
	 * @param string $funcaoExecutar
	 * @param boolean $boolSelectUniqueOption
	 */
	function combinarSelects( $selectPai='cod_uf', $selectFilho='cod_municipio', $TabelaPacoteFuncao=null, $colunaFiltro='COD_UF', $colunaCodigo='COD_MUNICIPIO', $colunaDescricao='NOM_MUNICIPIO', $descPrimeiraOpcao='-- Selecione --', $valorPrimeiraOpcao='', $descNenhumaOpcao='-- vazio --', $campoFormFiltro='', $funcaoExecutar='',$boolSelectUniqueOption=null )
	{
		// se o campo estiver dentro de uma aba ou de cum container, chamar o método combinar select destes
		$parentField = $this->getField( $selectPai );
		if( $parentField )
		{
			if( $parentField->getParentControl() != $this )
			{
				$parentField->getParentControl()->combinarSelects( $selectPai, $selectFilho, $TabelaPacoteFuncao, $colunaFiltro, $colunaCodigo, $colunaDescricao, $descPrimeiraOpcao, $valorPrimeiraOpcao, $descNenhumaOpcao, $campoFormFiltro, $funcaoExecutar , $boolSelectUniqueOption );
				return;
			}
		}
		else
		{
			return;
		}
		//die($selectPai);
		// inicializar com os valores padrão
		$descNenhumaOpcao = $descNenhumaOpcao == null ? '-- vazio --' : $descNenhumaOpcao;
		$descPrimeiraOpcao = is_null( $descPrimeiraOpcao ) ? '-- selecione --' : $descPrimeiraOpcao;
		$valorPrimeiraOpcao = $valorPrimeiraOpcao == null ? '' : $valorPrimeiraOpcao;
		$funcaoExecutar = $funcaoExecutar == null ? null : $this->removeIllegalChars( $funcaoExecutar ) . '()';
		$boolSelectUniqueOption = ( ( $boolSelectUniqueOption==true )  ? 1 : 0);
		// criticar se os campo existem
		$parentField = $this->getField( $selectPai );
		//$childField = $this->getField( $selectFilho );
		// todo campo filho combinado dever ter um _temp correspondente
		$this->addHiddenField( $selectFilho . '_temp' );
		$arrDados = array( );
		$arrDados[ 'selectPai' ] = $selectPai;
		$arrDados[ 'selectFilho' ] = $selectFilho;
		$arrDados[ 'selectFilhoStatus' ] = "habilitado";
		$arrDados[ 'pacoteOracle' ] = $TabelaPacoteFuncao;
		$arrDados[ 'colunaFiltro' ] = $colunaFiltro;
		$arrDados[ 'colunaCodigo' ] = $colunaCodigo;
		$arrDados[ 'colunaDescricao' ] = $colunaDescricao;
		$arrDados[ 'valorInicial' ] = "";
		$arrDados[ 'descPrimeiraOpcao' ] = $descPrimeiraOpcao;
		$arrDados[ 'valorPrimeiraOpcao' ] = $valorPrimeiraOpcao;
		$arrDados[ 'descNenhumaOpcao' ] = $descNenhumaOpcao;
		$arrDados[ 'campoFormFiltro' ] = $campoFormFiltro;
		$arrDados[ 'pastaBase' ] = $this->getBase();
		$arrDados[ 'funcaoExecutar' ] = $funcaoExecutar;
		$arrDados[ 'selectUniqueOption' ] = $boolSelectUniqueOption;
		$this->selectsCombinados[ $selectPai ][ $selectFilho ] = $arrDados;
	}
	/**
	 * Adiciona botão à frente do campo para fazer pesquisa on-line no banco de dados e retornar valores
	 * para os campos do formulario
	 *
	 * O parametro strAutoFillFilterField informa o nome do campo de filtro que receberá o valor digitado
	 * pelo usuário ao chamar a consulta on-line.
	 *
	 * O parametro $boolAutoStart - informa que a pesquisa deve iniciada assim que a tela for
	 * aberta sem precisar pressionar o botão pesquisar.
	 *
	 * O parametro $boolAutoSelect - informa que se a consulta retornar apenas um resultado este deverá ser
	 * automaticamente selecionado e retornado para a tela
	 *
	 * Ex: strFilterFields (campoBanco|Rotulo|caracteres|tamanho|obrigatorio|tipo|casas decimais|parte do campo|pesquisar formatado )
	 * 	NOM_INTERRESSADO|Nome Interessado:|45||||true,NUM_ORIGINAL|Nº Original:,DES_ASSUNTO|Assunto,COD_UF|Estado:||||uf'
	 * 	o tipo pode ser: char, uf, cpf, cnpj, cpfcnpj, data, int, dec, select ou hidden
	 * 	o padrao é char de 30
	 *
	 * Ex: $strFormFilterFields  (campoForm|campoBanco)
	 * 	NUM_PESSOA,NUM_PESSOA=2,num_pessoa|COD_PESSOA
	 *
	 * O parametro @arrSql dever ser utilizado para popular os campos do tipo select.
	 * Deve ser informado o nome do campo e a instrução sql ou o nome do pacote
	 * Ex: array('COD_UF'=>"SELECT COD_UF,NOM_UF||'/'||SIG_UF AS SIG_UF FROM UF ORDER BY SIG_UF")
	 * 	   array('COD_UF'=>"TESTE.PKG_MOEDA.SEL_UF,0,COD_UF,SIG_UF")
	 * Juntamente com o nome do pacote, pode ser informado o tempo de cache, o campo chave, o campo descricao
	 * separados por virgula
	 *
	 * O parametro $strClickCondition informa  uma condição para habilitar ou não o hiperlink nos itens do resultado da consulta
	 * para que o usuário possa selecinar ou não aquele item
	 *
	 * O parametro $strOnClickJs deve ser utilizado para chamar uma função js antes de abrir a consulta dinamica.
	 * Se esta função retornar false a tela de consulta dinãmica não será aberta
	 *
	 * o parametro boolDisableEnterKey - desabilita/habilita a tecla Enter para chamar a consulta dinamica do campo
	 * deve ser utilizado em conjunto com os parametros strAutoFillFilterField,$boolAutoStart e $boolAutoSelect
	 *
	 * O parametro $strCrudModuleName deve ser utilizado para quando for necessãrio permitir ao usuário
	 * fazer o cadastramento on-line do item não encontrado na pesquisa. Basta passar o nome do módulo a ser chamado.
	 * @param string $strFieldName
	 * @param string $strPackageFunction
	 * @param string $strFilterFields
	 * @param string $strAutoFillFilterField
	 * @param bool $boolAutoStart
	 * @param bool $boolAutoSelect
	 * @param string $strGridColumns
	 * @param string $strUpdateFormFields
	 * @param string $strWindowHeader
	 * @param string $strGridHeader
	 * @param string $strFocusFieldName
	 * @param bool $strWindowHeight
	 * @param bool $strWindowWidth
	 * @param string $strSearchButtonLabel
	 * @param string $strFormFilterFields
	 * @param string $strFunctionExecute
	 * @param integer $intMaxRecord
	 * @param string $strClickCondition
	 * @param string $strMultiSelectKeyField
	 * @param string $strColumnLink
	 * @param array $arrSqls
	 * @param string $strBeforeExecuteJs
	 * @param bool $boolDisableEnterKey
	 * @param string $strCrudModuleName
	 * @param boolean $boolCaseSensitive
	 *
	 */
	public function setOnlineSearch( $strFieldName, $strPackageFunction=null, $strFilterFields=null, $strAutoFillFilterField=null, $boolAutoStart=null, $boolAutoSelect=null, $strGridColumns=null, $strUpdateFormFields=null, $strWindowHeader=null, $strGridHeader=null, $strFocusFieldName=null, $strWindowHeight=null, $strWindowWidth=null, $strSearchButtonLabel=null, $strFormFilterFields=null, $strFunctionExecute=null, $intMaxRecord=null, $strClickCondition=null, $strMultiSelectKeyField=null, $strColumnLink=null, $arrSqls=null, $strBeforeExecuteJs=null, $boolDisableEnterKey=null, $strCrudModuleName=null,$boolCaseSensitive=null )
	{
		// valores padrão;
		$strWindowHeight = ( is_null( $strWindowHeight )) ? 400 : $strWindowHeight;
		$strWindowHeight = ( ( int ) $strWindowHeight < 100 ) ? 400 : $strWindowHeight;
		$strWindowWidth = ( is_null( $strWindowWidth ) ) ? 600 : $strWindowWidth;
		$strWindowWidth = ( ( int ) $strWindowWidth < 100 ) ? 600 : $strWindowWidth;
		$boolAutoStart = ( is_null( $boolAutoStart ) ) ? true : $boolAutoStart;
		$boolCaseSensitive = ( is_null( $boolCaseSensitive ) ) ? true : $boolCaseSensitive;
		$boolAutoSelect = ( is_null( $boolAutoSelect ) ) ? true : $boolAutoSelect;
		$boolDisableEnterKey = ( is_null( $boolDisableEnterKey ) ) ? false : $boolDisableEnterKey;
		if( $strFunctionExecute )
		{
			$strFunctionExecute = str_replace( '"', "'", $strFunctionExecute );
			$strFunctionExecute = str_replace( '\\', "", $strFunctionExecute );
			$strFunctionExecute = addslashes( $strFunctionExecute );
		}
		if( $strBeforeExecuteJs )
		{
			$i = strpos( $strBeforeExecuteJs, '(' );
			if( $i > 0 )
			{
				$strBeforeExecuteJs = substr( $strBeforeExecuteJs, 0, $i );
			}
		}
		$arrData = array( 'fieldName'=>$strFieldName,
			'packageFunction'=>$strPackageFunction,
			'autoFillFilterField'=>$strAutoFillFilterField,
			'autoStart'=>$boolAutoStart,
			'autoSelect'=>$boolAutoSelect,
			'updateFormFields'=>$strUpdateFormFields,
			'gridColumns'=>$strGridColumns,
			'focusFieldName'=>$strFocusFieldName,
			'filterFields'=>$strFilterFields,
			'windowHeight'=>$strWindowHeight,
			'windowWidth'=>$strWindowWidth,
			'windowHeader'=>$strWindowHeader,
			'gridHeader'=>$strGridHeader,
			'searchButtonLabel'=>$strSearchButtonLabel,
			'formFilterFields'=>$strFormFilterFields,
			'functionExecute'=>$strFunctionExecute,
			'maxRecords'=>$intMaxRecord,
			'clickCondition'=>$strClickCondition,
			'columnLink'=>$strColumnLink,
			'multiSelectKeyField'=>$strMultiSelectKeyField,
			'arrSqls'=>json_encode( $arrSqls ),
			'beforeExecuteJs'=>$strBeforeExecuteJs,
			'disableEnterKey'=>$boolDisableEnterKey,
			'crudModule'=>$strCrudModuleName,
			'caseSensitive'=>(int)$boolCaseSensitive,
			'prototypeParentWin'=>$this->getPrototypeId(),
			'dialogParentWin'=>$this->getDialogId()
		);
		$this->onlineSearchs[ $strFieldName ] = $arrData;
	}
	/**
	 * Método para implementação de cadastro on-line durante o preenchimento do formulario.
	 *
	 * <code>
	 * 	$frm->setOnlineCrud('nom_pessoa','cad_pessoa','adicionar_pasta.gif',null,'Cadastrar pessoa','Cadastro de Pessoa',350,820);
	 * </code>
	 *
	 * @param string $strFieldName
	 * @param string $strModuleName
	 * @param string $strButtonImage
	 * @param string $strButtonLabel
	 * @param string $strButtonHint
	 * @param string $strWindowTitle
	 * @param integer $intWindowHeight
	 * @param integer $intWindowWidth
	 */
	public function setOnlineCrud( $strFieldName, $strModuleName, $strButtonImage=null, $strButtonLabel=null, $strButtonHint=null, $strWindowTitle=null, $intWindowHeight=null, $intWindowWidth=null )
	{
		$arrData = array( 'fieldName'=>$strFieldName,
			'module'=>$strModuleName,
			'title'=>$strWindowTitle,
			'height'=>$intWindowHeight,
			'width'=>$intWindowWidth,
			'buttonLabel'=>$strButtonLabel,
			'buttonImage'=>$strButtonImage,
			'buttonHint'=>$strButtonHint
		);
		$this->onlineCruds[ $strFieldName ] = $arrData;
	}
	/**
	 * Método para limpar os campos do formulario
	 * Pode ser passado um campo ou varios separados por virgula.
	 * Também pode ser um array de campos. Se for passado null,
	 * todos os campos serão lipos
	 *
	 * <code>
	 * 	$form->clearFields('nom_pessoa');
	 * 	$form->clearFields('nom_pessoa,des_endereco');
	 * 	$form->clearFields(array('nom_pessoa,des_endereco'));
	 * </code>
	 *
	 * @param mixed $mixFields
	 * @param mixed $mixIgnoreFields
	 * @param bool $boolNewValue
	 */
	public function clearFields( $mixFields=null, $mixIgnoreFields=null, $boolNewValue=null )
	{
		if( is_null( $mixFields ) )
		{
			if( is_array( $this->displayControls ) )
			{
				foreach( $this->displayControls as $name=>$dc )
				{
					$field = $dc->getField();
					if( $field->getFieldType() == 'pagecontrol' )
					{
						$field->clearFields( $mixFields, $mixIgnoreFields, $boolNewValue );
					}
					else if( $field->getFieldType() == 'group' )
					{
						$field->clearFields( null, $mixIgnoreFields, $boolNewValue );
					}
					else
					{
						$this->clearFields( $field->getId(), $mixIgnoreFields, $boolNewValue );
					}
				}
			}
		}
		else
		{
			$boolNewValue = ($boolNewValue === null) ? true : ( bool ) $boolNewValue;
			if( isset( $mixIgnoreFields ) && !is_array( $mixIgnoreFields ) )
			{
				$mixIgnoreFields = explode( ',', $mixIgnoreFields );
			}
			if( is_array( $mixFields ) )
			{
				foreach( $mixFields as $k=>$v )
				{
					$this->clearFields( $v, $mixIgnoreFields, $boolNewValue );
				}
			}
			else
			{
				if( strpos( $mixFields, ',' ) > 0 )
				{
					$mixFields = explode( ',', $mixFields );
					$this->clearFields( $mixFields, $mixIgnoreFields, $boolNewValue );
				}
				else
				{
					if( $field = $this->getField( $mixFields ) )
					{
						if( !isset( $mixIgnoreFields ) || array_search( $mixFields, $mixIgnoreFields ) === false )
						{
							if( ! $field->getProperty('noClear') )
							{
								if( $field->getFieldType() == 'html' )
								{
									if( $gridFile = $field->getGridFile() )
									{
										unset( $_SESSION[ APLICATIVO ][ 'offline' ][ $gridFile[ 'id' ] ] );
									}
								}
								else if( $field->getFieldType() != 'tag' && $field->getFieldType() != 'button' && $field->getFieldType() != 'html' && $field->getId() != 'fw_back_to' && !$field->getProperty('noClear') )
								{
									$field->clear();
								}
							}
						}
					}
				}
			}
		}
	}
	//-----------------------------------------------------------------------------
	/**
	 * Método para definir o valor de um campo
	 * O parametro strTag pode ser utilizado para passar um valor a mais para a função
	 * setValue do campo. No caso do campo coordGMS é utilizado para passar LAT ou LON
	 * <code>
	 * 	$form->setFieldValue('coord2',-28.4541666667,'LAT');
	 * </code>
	 *
	 * @param string $strFieldName
	 * @param mixed $mixValue
	 * @param string @strTag
	 */
	public function setFieldValue( $strFieldName=null, $mixValue=null, $strTag=null )
	{
		$strFieldName = $this->removeIllegalChars( $strFieldName );
		$field = $this->getField( $strFieldName );
		if( is_object( $field ) )
		{
			if( $field->getFieldType() == 'coordgms' )
			{
				$field->setValue( $strFieldName, $mixValue, $strTag );
			}
			else
			{
				$this->getField( $strFieldName )->setValue( $mixValue );
			}
		}
	}
	//-----------------------------------------------------------------------------
	/**
	 * Retorna o valor de um campo
	 *
	 * @param string $strField
	 */
	public function getFieldValue( $strField=null )
	{
		return $this->getValue( $strField );
	}
	/**
	 * Define o valor de um campo do formulário ( equivalente a setFieldValue() )
	 *
	 * @param string $strFieldName
	 * @param mixed $mixValue
	 * @param string $strTag
	 */
	public function setValue( $strFieldName=null, $mixValue=null, $strTag=null )
	{
		// excecao para abas
		if( $this->getFieldType() == 'tabsheet' || is_null( $strFieldName ) )
		{
			parent::setValue( $mixValue );
		}
		else
		{
			$this->setFieldValue( $strFieldName, $mixValue, $strTag );
		}
	}
	//-----------------------------------------------------------------------------
	/**
	 * Retorna o valor de um campo do formulário ( equivalente ao getFieldValue())
	 *
	 * @param string $strField
	 */
	public function getValue( $strField=null )
	{
		// excecao para abas
		if( $this->getFieldType() == 'tabsheet' || is_null( $strField ) )
		{
			return parent::getValue();
		}
		else
		{
			if( $this->getField( $strField ) )
			{
				return $this->getField( $strField )->getValue();
			}
		}
		return null;
	}
	/**
	 * Este método deve ser utilizado para criar o array com os nomes e valores dos campos que
	 * será utilizado como parametro "$bvars" no metodo executarPacote ou recuperarPacote
	 *
	 * <code>
	 * 	$bvars = $frm->createBvars('num_pessoa,nom_pessoa,uf|COD_UF');
	 * </code>
	 *
	 * Quando o nome do campo do formulário não for igual ao nome do campo da tabela do banco
	 * de dados, deve ser informado o nome do campo do formulário e o nome do campo da tabela
	 *
	 * O parametro boolPDO retorna o array simples para ser passado como parametro das queries da
	 * classe pdo.
	 *
	 * @param string $strFields
	 * @param string $$boolPDO
	 * @return array
	 */
	public function createBvars( $strFields=null, $boolPDO=null, $strDecimalSeparator=null )
	{
		$strDecimalSeparator = ( is_null( $strDecimalSeparator ) ? '.' : $strDecimalSeparator );
		if( $strDecimalSeparator != '.' && $strDecimalSeparator!=',')
		{
			$strDecimalSeparator = '.';
		}
		$bvars = (!isset( $bvars )) ? array( ) : $bvars;
		if( !isSet( $strFields ) )
		{
			foreach( $this->displayControls as $name=>$dc )
			{
				$bvars = array_merge( ( array ) $bvars, $this->createBvars( $name ) );
			}
		}
		if( isset( $strFields ) )
		{
			// tratar campos separados por virgula
			if( isset( $strFields ) && strpos( $strFields, ',' ) !== false )
			{
				$strFields = explode( ',', $strFields );
				foreach( $strFields as $k=>$v )
				{
					$bvars = array_merge( ( array ) $bvars, $this->createBvars( trim( $v ) ) );
				}
			}
			else
			{
				$aField = explode( '|', $strFields );
				$aField[ 1 ] = !isset( $aField[ 1 ] ) ? strtoupper( $aField[ 0 ] ) : $aField[ 1 ];
				if( $field = $this->getField( $aField[ 0 ] ) )
				{
					if( $field->getFieldType() != 'pagecontrol' && $field->getFieldType() != 'group' )
					{
						if( $field->getFieldType() == 'fileasync' )
						{
							$bvars[ strtoupper( $aField[ 1 ] ) ] = $field->getContent();
						}
						else
						{
							$value = $field->getValue();
							if( is_array( $value ) )
							{
								// campo multiselect, check, coordGMS retorna um array de valores
								foreach( $value as $k=>$v )
								{
									if( $field->getFieldType() == 'multiselect' || $field->getFieldType() == 'check' )
									{
										$bvars[ strtoupper( $field->getId() ) ][ ] = $v;
									}
									else if( $field->getFieldType() == 'select' )
									{
										$bvars[ strtoupper( $field->getId() ) ] = $v;
									}
									else if( $field->getFieldType() == 'radio' )
									{
										$bvars[ strtoupper( $field->getId() ) ] = $v;
									}
									else if( $field->getFieldType() == 'coordgms' )
									{
										$bvars[ strtoupper( $k ) ] = $v;
									}
								}
							}
							else
							{
								$value = $field->getValue();
								if( $field->getFieldType() == 'html' )
								{
									if( $gridFile = $field->getGridFile() )
									{
										$value = $_SESSION[ APLICATIVO ][ 'offline' ][ $gridFile[ 'id' ] ];
										unset( $value[ 'FW_BACK_TO' ] );
									}
								}
								else if( $field->getFieldType() == 'number' )
								{
									if( $strDecimalSeparator == '.')
									{
										if( preg_match('/,/',$value) == 1 )
										{
											$value = str_replace( ',', '.', str_replace( '.', '', $value ) );
										}
									}
									else
									{
										$value = str_replace( '.', ',', str_replace( ',', '', $value ) );
									}
								}
								$bvars[ strtoupper( $aField[ 1 ] ) ] = $value;
							}
						}
					}
					else
					{
						if( $field->getFieldType() == 'group' )
						{
							$bvars = array_merge( ( array ) $bvars, $field->createBvars() );
						}
					}
				}
			}
		}
		if( $boolPDO )
		{
			$arr = null;
			forEach( $bvars as $k=>$v )
			{
				$arr[] = $v;
			}
			$bvars = $arr;
		}
		return $bvars;
	}
	/**
	 * Define um array no formato "key=>value" ou string no formato "S=SIM,N=NAO,..." ou
	 * o nome de um pacoteFunção para recuperar do banco de dados para alimentar as opções dos
	 * campos selects.
	 * Quando for utilizado o pacote/função, pode ser especificada a coluna chave, a coluna descrição e
	 * searchFields como parametros para a função do pacote que será executada.
	 *
	 * <code>
	 * 	$mixSearchFields="cod_uf=53,num_pessoa=20" ou array('COD_UF'=53,'NUM_PESSOA'=>20)
	 * </code>
	 *
	 * @param string $strFieldName
	 * @param mixed $mixOptions
	 * @param string $strDisplayField
	 * @param string $strKeyField
	 * @param mixed $mixSearchFields
	 */
	public function setOptionsSelect( $strFieldName, $mixOptions=null, $strDisplayField=null, $strKeyField=null, $mixSearchFields=null )
	{
		if( $field = $this->getField( $strFieldName ) )
		{
			if( method_exists( $field, 'setOptions' ) )
			{
				$field->setOptions( $mixOptions, $strDisplayField, $strKeyField, $mixSearchFields );
			}
		}
	}
	/**
	 * Define se os campos do formulario ou a aba ou o grupo serão todos obrigatórios.
	 *
	 * @param boolean $boolValue
	 */
	public function setRequired( $boolValue=null )
	{
		$this->setAttribute('needed', ( ( bool ) $boolValue ? 'true' : 'false' ) );
	}
	/**
	 * Retorna se o form ou grupo ou aba estão definido como obrigatórios.
	 * Se estiverem obrigatório, todos os seus campos serão defindos como obrigatórios.
	 *
	 */
	public function getRequired()
	{
		return $this->getAttribute('needed') == "true";
	}
	/**
	 * Este método fecha um campo grupo ou um campo aba para que os campos
	 * seguintes fique abaixo dos mesmos e não dentro deles.
	 *
	 */
	public function closeGroup()
	{
		//$this->currentContainer = array_pop($this->currentContainer);

		if( is_array($this->currentContainer) && count($this->currentContainer)>0)
		{
			array_pop( $this->currentContainer );
		}
	}
	/**
	 * Define se o botão fechar do formulário estará visível ou não.
	 *
	 * @param boolean $boolNewValue
	 */
	public function setShowCloseButton( $boolNewValue=null )
	{
		$boolNewValue = $boolNewValue === null ? true : $boolNewValue;
		$this->showCloseButton = $boolNewValue;
	}
	/**
	 * Desativa a exibição do botão fechar  no canto superior direito do formulario. ( equivalente a setShowCloseButton(false); )
	 *
	 */
	public function hideCloseButton()
	{
		$this->showCloseButton = false;
	}
	/**
	 * Ativa o modo de exibição do botão fechar no canto superior direito do formulário. ( equivalente a setShowCloseButton(true); )
	 *
	 */
	public function showCloseButton()
	{
		$this->showCloseButton = true;
	}
	/**
	 * Retorna se a exibição do botão fechar no canto superior direito do formulário está ativada ou não.
	 *
	 */
	public function getShowCloseButton()
	{
		if( isset( $_REQUEST[ 'showCloseButton' ] ) && !$_REQUEST[ 'showCloseButton' ] )
		{
			return false;
		}
		return $this->showCloseButton;
	}
	/**
	 * Atualiza os valores dos campos do formulário com os valores do array recebido.
	 *
	 *
	 * <code>
	 * 	// atualizar todos os campos
	 * 	$frm->update($res);
	 * 	// atualizar o campo nome e cpf
	 * 	$frm->update($res,'nome,cpf');
	 * 	// atualizar todos os campos menos o cpf e e matricula
	 * 	$frm->upadte($res,null,'cpf,matricula');
	 *
	 * </code>
	 *
	 * @param mixed $arrValues
	 * @param mixed $strFields
	 * @param mixed $strIgnoreFields
	 */
	public function update( $arrValues=null, $strFields=null, $strIgnoreFields=null )
	{
		if( !$arrValues )
		{
			return;
		}
		$arrFields = explode( ',', $strFields );
		$arrIgnoreFields = explode( ',', $strIgnoreFields );
		$key = key( $arrValues );
		if( is_array( $arrValues[ $key ] ) ) // FORMATO DO ARRAY: [CAMPO][N]
		{
			foreach( $arrValues as $k=>$v )
			{
				$field = $this->getField( strtolower( $k ) );
				$field = !is_object( $field ) ? $this->getField( $k ) : $field;
				if( $field )
				{
					if( method_exists( $field, 'setValue' ) )
					{
						if( ( is_null( $strFields ) || in_array( $field->getId(), $arrFields )) && ( is_null( $strIgnoreFields ) || !in_array( $field->getId(), $arrIgnoreFields ) ) )
						{
							//$field->setValue($arrValues[$k][0]);
							if( $field->getFieldType() == 'check' || $field->getFieldType() == 'multiselect' )
							{
								$field->setValue( $v );
							}
							if( $field->getFieldType() == 'coordgms' )
							{
								if( isset( $arrValues[ strtoupper( $field->getFieldNameLat() ) ][ 0 ] ) )
								{
									$field->setLat( $arrValues[ strtoupper( $field->getFieldNameLat() ) ][ 0 ] );
								}
								else if( isset( $arrValues[ strtolower( $field->getFieldNameLat() ) ][ 0 ] ) )
								{
									$field->setLat( $arrValues[ strtolower( $field->getFieldNameLat() ) ][ 0 ] );
								}
								if( isset( $arrValues[ strtoupper( $field->getFieldNameLon()) ][ 0 ] ) )
								{
									$field->setLon( $arrValues[ strtoupper( $field->getFieldNameLon() ) ][ 0 ] );
								}
								else if( isset( $arrValues[ strtolower( $field->getFieldNameLon() ) ][ 0 ] ) )
								{
									$field->setLon( $arrValues[ strtolower( $field->getFieldNameLon() ) ][ 0 ] );
								}
							}
							else
							{
								$field->setValue( $v[ 0 ] );
								$field = $this->getField( strtoupper($k) );
								if( is_object( $field ) && method_exists( $field, 'setValue' ) )
								{
									$field->setValue( $v[ 0 ] );
								}
							}
						}
					}
				}
			}
		}
		else // FORMATO DO ARRAY: KEY=>VALUE
		{
			foreach( $arrValues as $k=>$v )
			{
				$field = $this->getField( strtolower($k) );
				//$field = !is_object( $field ) ? $this->getField( strtoupper( $k ) ) : $field;
				if( is_object( $field ) )
				{
					if( method_exists( $field, 'setValue' ) )
					{
						if( ( is_null( $strFields ) || in_array( $field->getId(), $arrFields )) && ( is_null( $strIgnoreFields ) || !in_array( $field->getId(), $arrIgnoreFields ) ) )
						{
							$field->setValue( $k, $v );
						}
					}
				}
				$field = $this->getField( strtoupper( $k ) );
				if( is_object( $field ) )
				{
					if( method_exists( $field, 'setValue' ) )
					{
						if( ( is_null( $strFields ) || in_array( $field->getId(), $arrFields )) && ( is_null( $strIgnoreFields ) || !in_array( $field->getId(), $arrIgnoreFields ) ) )
						{
							$field->setValue( $k, $v );
						}
					}
				}
			}
		}
	}
	/**
	 * Elimina o array de botões que serão exibidos no rodapé do formulário.
	 *
	 */
	public function clearButtons()
	{
		$this->footerButtons = null;
	}
	/**
	 * Elimina todos os campos do formulário ou apenas os campos informados no parametro mixFields, ignorando
	 * os campos informados no parametro mixIgnoreFields.
	 *
	 * <code>
	 * 	$frm->removeField('campo1,campo2,campo3');
	 * 	$frm->removeField(null,'campo_x');
	 * </code>
	 *
	 * @param array $mixFields
	 * @param array $mixIgnoreFields
	 */
	public function removeField( $mixFields=null, $mixIgnoreFields=null )
	{
		// excluir todos os campos menos as abas e os grupos
		if( is_null( $mixFields ) )
		{
			foreach( $this->displayControls as $name=>$dc )
			{
				if( $dc->getField()->getFieldType() == 'pagecontrol' )
				{
					$dc->getField()->removeField( null, $mixIgnoreFields );
				}
				else if( $dc->getField()->getFieldType() == 'group' )
				{
					$dc->getField()->removeField( null, $mixIgnoreFields );
				}
				else
				{
					$this->removeField( $dc->getField()->getId(), $mixIgnoreFields );
				}
			}
			return;
		}
		// excluir campo
		if( isset( $mixIgnoreFields ) && !is_array( $mixIgnoreFields ) )
		{
			$mixIgnoreFields = explode( ',', $mixIgnoreFields );
		}
		if( is_array( $mixFields ) )
		{
			foreach( $mixFields as $k=>$v )
			{
				$this->removeField( $v, $mixIgnoreFields );
			}
		}
		else
		{
			if( strpos( $mixFields, ',' ) > 0 )
			{
				$mixFields = explode( ',', $mixFields );
				$this->removeField( $mixFields, $mixIgnoreFields );
			}
			else
			{
				if( $field = $this->getField( $mixFields ) )
				{
					// se o campo estiver dentro de uma aba ou grupo, chamar o metodo delete destes
					if( $field->getParentControl() != $this )
					{
						$field->getParentControl()->removeField( $mixFields );
					}
					else
					{
						if( !isset( $mixIgnoreFields ) || array_search( $mixFields, $mixIgnoreFields ) === false )
						{
							$keys = array_keys( $this->displayControls );
							$pos = array_search( $mixFields, $keys );
							if( $pos !== false )
							{
								array_splice( $this->displayControls, $pos, 1 );
							}
						}
					}
				}
			}
		}
	}
	/**
	 * Exclui um campo ou os campos informados do formulário, ignorando os que estiverem no parametro $mixIgnoreFields
	 *
	 * <code>
	 * 	$frm->deleteFields('campo1,campo2,campo3');
	 * 	$frm->deleteFields(null,'campo_x');
	 * </code>
	 *
	 * @param mixed $mixFields
	 * @param mixed $mixIgnoreFields
	 */
	public function deleteField( $mixFields=null, $mixIgnoreFields=null )
	{
		$this->removeField( $mixFields = null, $mixIgnoreFields = null );
	}
	/**
	 * Define se o formuário deverá ou não exibir o título.
	 *
	 * @param boolean $boolShow
	 */
	public function setShowHeader( $boolShow=null )
	{
		if( is_null( $boolShow ) )
		{
			return $this->showHeader;
		}
		return $this->showHeader = ( bool ) $boolShow;
	}
	/**
	 * Retorna se o formulário deve ou não exibir o título.
	 *
	 */
	public function getShowHeader()
	{
		return $this->showHeader;
	}
	/**
	 * Define se o formulário deverá incluir os arquivos base/js/... necessários automaticamente em
	 * função dos campos que foram adicionados.
	 *
	 * @param boolean $boolAutoInclude
	 */
	public function setAutoIncludeJsCss( $boolAutoInclude=null )
	{
		$this->autoIncludeJsCss = ( bool ) $boolAutoInclude;
	}
	public function getAutoIncludeJsCss()
	{
		return $this->autoIncludeJsCss;
	}
	/**
	 * Define o valor que setá exibido no titulo do formulário.
	 *
	 * @param string $strNewText
	 */
	public function setTitle( $strNewText=null )
	{
		$this->title = $strNewText;
		return $this;
	}
	/**
	 * Retorna o valor do titulo do formulário
	 *
	 */
	public function getTitle()
	{
		return $this->title;
	}
	/**
	 * Define o formato das bordas do formulário.
	 * True = borda simples
	 * False = borda 3d
	 *
	 * @param boolean $boolNewValue
	 */
	public function setFlat( $boolNewValue=null )
	{
		$this->flat = ( bool ) $boolNewValue;
		return $this;
	}
	/**
	 * Retona se o formulário dever ser exibido com ou sem as bordas 3d
	 *
	 */
	public function getFlat()
	{
		return $this->flat;
	}
	/**
	 * Define se a classe deverá adicionar código javascript para compatibilidade
	 * com a biblioteca prototype window.
	 *
	 * @param boolean $boolNewValue
	 */
	public function setPrototypeId( $strNewValue=null )
	{
		$this->prototypeId = $strNewValue;
	}
	/**
	 * Retorna se o formulário deverá ser ou não compativel com a biblioteca prototype window
	 *
	 */
	public function getPrototypeId()
	{
		return $this->prototypeId;
	}
	/**
	 * Retorna se o formulário deverá ser ou não compativel com a biblioteca prototype window
	 *
	 */
	public function getDialogId()
	{
		if( isset( $_REQUEST['dialogId'] ) &&  $_REQUEST['dialogId'] )
		{
			return  $_REQUEST['dialogId'];
		}
		return null;
	}
	/**
	 * Retorna array como os arquivos js e css necessários para funcionamento
	 * dos campos adicionados ao formulário.
	 */
	public function getJsCss()
	{
		if( !$this->getFlat() )
		{
			$this->addCssFile( 'box/box.css' );
		}
		if( is_array( $this->autocompleteFields ) )
		{
			$this->addJsFile( 'jquery/jquery.autocomplete.dylan.js' );
			$this->addCssFile( 'jquery/jquery.autocomplete.dylan.css' );
		}
		if( $this->getOnlineDoc() )
		{
			$this->addJsFile('FormDin4OnlineDoc.js');
			$this->enableRichEdit(); // adiconar javascript para tinymce
			//$this->addJavascript( "edOnlineReadOnly = ".( ( $this->onlineDocReadOnly ) ? 'true' : 'false') . ";" );
			$this->addJavascript( "fwInitOnlieDocEditor(".(( $this->onlineDocReadOnly ) ? 'true' : 'false').")");

			//$this->addJavascript("jQuery('#fw_div_online_doc').easydrag();jQuery('#fw_div_online_doc').setHandler('fw_div_online_doc_header');");
		}
		if( $this->getRichEdit() )
		{
			$this->addJsFile( 'jquery/tinymce/jscripts/tiny_mce/tiny_mce.js' );
		}
		if( is_array( $this->displayControls ) )
		{

			foreach( $this->displayControls as $name=>$dc )
			{
				if( $dc->getField()->getFieldType() == 'pagecontrol' )
				{
					$this->addCssFile( 'pagecontrol/pagecontrol.css' );
					$arrTemp = $dc->getField()->getJsCss();
					$this->addJsFile( $arrTemp[ 0 ] );
					$this->addCssFile( $arrTemp[ 1 ] );
				}
				else if( $dc->getField()->getFieldType() == 'group' )
				{
					$arrTemp = $dc->getField()->getJsCss();
					$this->addJsFile( $arrTemp[ 0 ] );
					$this->addCssFile( $arrTemp[ 1 ] );
				}
				else if( $dc->getField()->getFieldType() == 'color' )
				{
					$this->addJsFile( 'colorPicker.js' );
				}
				else if( $dc->getField()->getFieldType() == 'date' )
				{
					/*
					if( array_search( 'calendario/calendar.js', $this->jsFiles, true ) === false )
					{
						$this->addJsFile( 'calendario/calendar.js' );
						$this->addJsFile( 'calendario/calendar-br.js' );
						$this->addJsFile( 'calendario/calendar-setup.js' );
						$this->addCssFile( 'calendario/calendar-win2k-cold-1.css' );
					}
					*/
				}
				else if( $dc->getField()->getFieldType() == 'password' )
				{
					$this->addJsFile('virtualKeyboard/keyboard.js');
					$this->addCssFile('virtualKeyboard/keyboard.css');
				}
				else if( $dc->getField()->getFieldType() == 'fullcalendar' )
				{
					$this->addCssFile('fullcalendar/cupertino/theme.css');
					$this->addCssFile('fullcalendar/fullcalendar.css');
					$this->addJsFile('fullcalendar/fullcalendar.min.js');
				}
				else if( $dc->getField()->getFieldType() == 'helpbox' )
				{
					if( array_search( 'jquery/facebox/facebox.js', $this->jsFiles, true ) === false )
					{
						$this->addJsFile( 'jquery/facebox/facebox.js' );
						$this->addCssFile( 'jquery/facebox/facebox.css' );
					}
				}
				else if( $dc->getField()->getFieldType() == 'pagecontrol' )
				{
					// css abas
					$this->addCssFile( 'pagecontrol/pagecontrol.css' );
				}
				else if( $dc->getField()->getFieldType() == 'opendir' )
				{
					$this->addJsFile("jquery/jqueryFileTree/jquery.easing.js");
					$this->addJsFile("jquery/jqueryFileTree/jqueryFileTree.js");
					$this->addCssFile("jquery/jqueryFileTree/jqueryFileTree.css");
				}
				else if( $dc->getField()->getFieldType() == 'coordgms' )
				{
					$this->addJsFile("FormDin4Geo.js");
				}
			}
		}
		return array( $this->jsFiles, $this->cssFiles );
	}
	//-----------------------------------------------------------------------------
	/**
	 * Adiciona um ou vários arquivos js ao formulário
	 *
	 * @param mixed $mixJsFile
	 */
	public function addJsFile( $mixJsFile=null,$addOnTop=null )
	{
		if( is_null( $mixJsFile) || ( is_string( $mixJsFile ) && trim( $mixJsFile ) == '' ) )
		{
			return;
		}
		if( is_array( $mixJsFile ) )
		{
			foreach( $mixJsFile as $k=>$file )
			{
				if( $file )
				{
					$this->addJsFile( $file,$addOnTop );
				}
			}
		}
		else if( !is_array( $this->jsFiles ) || array_search( $mixJsFile, $this->jsFiles, true ) === false )
		{
			if( trim( $mixJsFile ) != '' )
			{
				if( $addOnTop )
				{
					array_unshift($this->jsFiles,$mixJsFile);
				}
				else
				{
					$this->jsFiles[ ] = $mixJsFile;
				}
			}
		}
	}
	//-----------------------------------------------------------------------------
	/**
	 * Adiciona um ou vários arquivos CSS ao formulário.
	 *
	 * @param mixed $mixCssFile
	 */
	public function addCssFile( $mixCssFile=null )
	{

		if( is_null( $mixCssFile) || ( is_string($mixCssFile) && trim( $mixCssFile) == '' ) )
		{
			return;
		}
		if( is_array( $mixCssFile ) )
		{

			foreach( $mixCssFile as $k=>$file )
			{
				if( $file )
				{
					$this->addCssFile( $file );
				}
			}
		}
		else if( !is_array( $this->cssFiles ) || array_search( $mixCssFile, $this->cssFiles, true ) === false )
		{

			if( trim($mixCssFile)!='')
			{
						$this->cssFiles[ ] = $mixCssFile;
			}
		}
	}
	/**
	 * Define se o html gerado deverá ser somente da tag form ou o codigo html da pagina completo.
	 *
	 * @param boolean $boolShow
	 */
	public function setShowHtmlTag( $boolShow=null )
	{
		$this->showHtmlTag = $boolShow;
	}
	public function getShowHtmlTag()
	{
		return $this->showHtmlTag;
	}
	/**
	 * Método interno para gerar o codigo html de inserção dos arquivos js/css adicionados ao formulário
	 *
	 */
	protected function includeJsCss()
	{
		// verificar quais css e js serão necessários de acordo com os campos adicionados
		$this->getJsCss();
		$arrTemp = array_merge( $this->jsFiles, $this->cssFiles );
		if( is_array( $arrTemp ) )
		{
			foreach( $arrTemp as $k=>$file )
			{
				$fileName = $file;
				if( strpos( $file, '.css' ) )
				{
					$tipo = 'css';
				}
				else if( strpos( $file, '.js' ) )
				{
					$tipo = 'js';
				}
				if( strpos( $file, 'http:' ) === false )
				{
					$isUrl = false;
					// primeiro procurar na pasta js/ do projeto
					if( !file_exists( $fileName ) )
					{
						$fileName = $this->getRoot() . $tipo . '/' . $file;
					}
					// depois procurar na pasta base/js
					if( !file_exists( $fileName ) )
					{
						$fileName = $this->getBase() . $tipo . '/' . $file;
					}
					if( !file_exists( $fileName ) )
					{
						// o css pode estar junto com o js
						if( $tipo == 'css' )
						{
							// procurar na pasta base/js
							$fileName = $this->getBase() . 'js/' . $file;
						}
					}
				}
				else
				{
					$isUrl = true;
				}
				if( $isUrl || file_exists( $fileName ) )
				{
					if( $tipo == 'js' )
					{
						$this->add( '<script type="text/javascript" src="' . $fileName . '"></script>' );
					}
					else if( $tipo == 'css' )
					{
						$this->add( '<link rel="stylesheet" type="text/css" href="' . $fileName . '" />' );
					}
				}
			}
			// evitar que a classe JQuery entre em confilto com outras classes
			$this->add( '<script>jQuery.noConflict();</script>' );
		}
	}
	/**
	 * Retorna a largura máxima da área interna do formulário.
	 *
	 */
	public function getMaxWidth($controlType=null)
	{
		if( ! $parent = $this->getCurrentContainer())
		{
			$parent = $this;
		}

		if( $parent->getOverFlowY()=='hidden')
		{
			$w=$parent->getWidth()-23;
		}
		else
		{
			$w = $parent->getWidth()-36;
		}
		$parentType =  $parent->getFieldType();
		//print 'Elem:'.$this->getId()."  parent = ".$parent->getId().' Parent type: '.$parentType.', id: '.$this->getId(). ' type:'.$controlType.'<hr>';
		if( $parentType == 'group' )
		{
			$w -= 10;
			if( $controlType == 'pagecontrol' )
			{
				$w-=15;
			}
			else if( $controlType == 'html' )
			{
				$w -= 2;
			}
		}
		else if( $parentType == 'tabsheet' )
		{
			$w-=45;
			if( $controlType=='group')
			{
				$w-=0;
			}
			else if( $controlType=='pagecontrol')
			{
				$w-=25;
			}
			else if( $controlType=='html')
			{
				$w+=2;
			}
		}
		else if ($parentType=='form' )
		{
			$w=$this->getWidth();
			if( $controlType=='group')
			{
				if( $parent->getOverflowY()=='hidden')
				{
					$w-=30;
				}
				else
				{
					$w-=45;
				}
			}
			else if( $controlType=='pagecontrol')
			{
				if( $parent->getOverflowY()=='hidden')
				{
					$w-=50;
				}
				else
				{
					$w-=65;
				}
			}
			else if( $controlType=='html')
			{
				if( $parent->getOverflowY()=='hidden')
				{
					$w-=30;
				}
				else
				{
					$w-=45;
				}
			}
		}
		if( $parent->getFlat())
		{
			$w+=10;
		}
		return $w;



/*
		if( ! $parent = $this->getCurrentContainer())
		{
			$parent = $this;
		}
		if( $parent->getOverFlowY()=='hidden')
		{
			$w=$parent->getWidth()-23;
		}
		else
		{
			$w = $parent->getWidth()-36;
		}
		if( $parent->getFlat())
		{
			$w+=10;
		}
		$type =  $parent->getFieldType();
		if( $type == 'group' )
		{
			$w -= 10;
			if( $controlType == 'pagecontrol' )
			{
				$w-=15;
			}
		}
		else if( $type == 'tabsheet' )
		{
			$w-=45;
			if( $controlType=='group')
			{
				$w-=15;
			}
			else if( $controlType=='pagecontrol')
			{
				$w-=35;
			}
		}
		return $w;

*/



	}
	/**
	 * Retorna o campo aba ou o campo grupo que está aberto no momento
	 *
	 */
	public function getCurrentContainer()
	{
		if( is_array( $this->currentContainer ) && count( $this->currentContainer ) > 0 )
		{
			if( $this->currentContainer[ count( $this->currentContainer ) - 1 ]->getFieldType() == "pagecontrol" )
			{
				// retornar a última aba aberta
				if( $this->currentContainer[ count( $this->currentContainer ) - 1 ]->getPages() )
				{
					$aLastPage = array_slice( $this->currentContainer[ count( $this->currentContainer ) - 1 ]->getPages(), -1, 1, true );
					$lastPage = $aLastPage[ key( $aLastPage ) ];
					return $lastPage;
				}
			}
			else
			{
				return $this->currentContainer[ count( $this->currentContainer ) - 1 ];
			}
		}
		return null;
	}
	/**
	 * Método para adicionar arquivos php que geram PDF
	 * o PDF será exibido em um outro formulário, abaixo do formulário principal
	 *
	 * @param string $strFileName
	 * @param string $strWindowTitle
	 * @param integer $intHeight
	 * @param integer $intWidth
	 */
	public function addPdfFile( $strFileName, $strWindowTitle=null, $intHeight=null, $intWidth=null )
	{
		// aba e grupos não pode ter pdfs anexados
		if( $this->getFieldType() == "form" )
		{
			$strFileName = preg_replace( '/\?/', '&', $strFileName );
			$this->pdfs[ $strFileName ] = array( $strWindowTitle, $intHeight, $intWidth );
		}
	}
	//-----------------------------------------------------------------------------
	/**
	 * Limpar a consulta dinâmica de um campo ou todas se o nome do campo não for informado
	 *
	 * @param string $strFieldName
	 */
	public function clearOnlineSearch( $strFieldName=null )
	{
		if( is_null( $strFieldName ) )
		{
			$this->onlineSearchs = null;
		}
		else
		{
			$this->onlineSearchs[ $strFieldName ] = null;
			unset( $this->onlineSearchs[ $strFieldName ] );
		}
	}
	//-----------------------------------------------------------------------------
	/**
	 * Utilizado para definr o formato de postagem do formulário
	 *
	 * @param string $strNewValue
	 */
	public function setEncType( $strNewValue=null )
	{
		$this->enctype = $strNewValue;
	}
	//-----------------------------------------------------------------------------
	/**
	 * Retorna o formato de postagem do formulário
	 *
	 */
	public function getEncType()
	{
		return $this->enctype;
	}
	//-----------------------------------------------------------------------------
	/**
	 * Exibe os arquivos que geram pdf, adicionados pelo método addPdfFile(), na parte
	 * inferior do formulário.
	 *
	 * @param mixed $print
	 * @param mixed $flat
	 */
	protected function showPdfs( $print=true, $flat=false )
	{
		$html = null;
		if( $this->pdfs )
		{
			$i = 1;
			foreach( $this->pdfs as $fileName=>$aDados )
			{
				//if( strpos($fileName,'http')===false )
				$fileName = trim( $fileName );
				if( !strpos( strtolower( $fileName ), '.pdf' ) )
				//if(	preg_match('/(?i)^https*:\/\/.+\pdf$/',$fileName )== 0 )
				{
					$fileName = $_SERVER[ 'SCRIPT_URI' ] . '?modulo=' . $fileName . '&ajax=1&fpdf=1';
				}
				$aDados[ 1 ] = $aDados[ 1 ] ? $aDados[ 1 ] : 700;
				$aDados[ 2 ] = $aDados[ 2 ] ? $aDados[ 2 ] : $this->getWidth();
				$boxIframe = new TBoxIframe( $aDados[ 0 ], $fileName, $this->getId() . '_sub_' . $i++, $aDados[ 1 ], $aDados[ 2 ] );
				$html .= $boxIframe->show( $print, $flat );
			}
		}
		return $html;
	}
	//-----------------------------------------------------------------------------
	/**
	 * Define uma função javascript que será chamada quando o formulário for fechado
	 *
	 * @param string $strJsFunction
	 */
	public function setOnClose( $strJsFunction=null )
	{
		$this->onClose = str_replace( "'", "\'", str_replace( '"', "'", $strJsFunction ) );
	}
	/**
	 * Retorna a função javascript que será chamada quando o formulário for fechado
	 *
	 */
	public function getOnClose()
	{
		if(preg_match('/\(/',$this->onClose) == 1 )
		{
			return "'".$this->onClose."'";
		}
		return is_null($this->onClose) ? 'null' : $this->onClose;
	}
	/**
	 * Define uma função javascript que será chamada antes do formulário for fechado.
	 * Se o resultado for false o fechamento será cancelado
	 *
	 * @param string $strJsFunction
	 */
	public function setOnBeforeClose( $strJsFunction=null )
	{
		$this->onBeforeClose = str_replace( "'", "\'", str_replace( '"', "'", $strJsFunction ) );
	}
	/**
	 * Retorna a função javascript que será chamada quando o formulário for fechado
	 *
	 */
	public function getOnBeforeClose()
	{
		if(preg_match('/\(/',$this->onBeforeClose) == 1 )
		{
			return "'".$this->onBeforeClose."'";
		}
		return is_null($this->onBeforeClose) ? 'null' : $this->onBeforeClose;
	}
	/**
	 * O método redirect deve ser utilizado para chamar um outro formulário dentro de uma ação do formulário
	 * corrente, sem ter que submeter a página.
	 * Quando o parametro $boolSaveData for true, os dados do formulário serão salvos na sessão para quando
	 * retornar manter os campos preenchidos. O Padrão é true.
	 * <code>
	 * 	if($acao =='Ir')
	 * 	{
	 * 		$frm->redirect('modulo2.inc','Redirect realizado com sucesso. Você está agora no 2º form.');
	 * 	}
	 * </code>
	 *
	 * @param mixed $strModule
	 * @param mixed $strMessage
	 * @param mixed $boolSubmit
	 * @param mixed $arrVars
	 * @param boolean $boolRedirect
	 */
	public function redirect( $strModule=null, $strMessage=null, $boolSubmit=false, $arrVars=null, $boolSaveData=null )	{
		$boolSaveData = is_null( $boolSaveData ) ? false : $boolSaveData;
		
		$filePath = $this->getRealPath( $strModule );
		$fileExists = file_exists( $filePath );
		
		if( $fileExists ) {
			$currentModule = $this->getRealPath( $_POST['modulo'] );
			// guardar na sessão somente se estiver indo, na volta não precisa
			if( $boolSaveData )
			{
				$_SESSION[ APLICATIVO ][ $currentModule ][ 'post' ] = $_POST;
			}
			$_POST[ 'fw_back_to' ] = $currentModule;
			$_REQUEST[ 'redirect_message' ] 	= $strMessage;
			$_POST[ 'modulo' ] 					= $filePath;
			$_GET[ 'modulo' ] 					= $filePath;
			$_REQUEST[ 'modulo' ]				= $filePath;
			$_REQUEST[ 'redirect' ] 			= '1';
			$_SESSION[ APLICATIVO ][ 'modulo' ] = $filePath;
			$_POST[ 'formDinAcao' ] = null;
			if( !$boolSubmit )
			{
				//$formDinModulo = $currentModule;
				//$acao = $_POST[ 'formDinAcao' ];
				// variaveis que serão recuperadas no formulario destino
				if( is_array( $arrVars ) )
				{
					foreach( $arrVars as $k=>$v )
					{
						$_POST[ $k ] = $v;
					}
				}
				self::$instance=null;
				include($filePath);
				exit( 0 );
			}
			else
			{
				if( is_array( $arrVars ) )
				{
					foreach( $arrVars as $k=>$v )
					{
						if( is_array( $v ) )
						{
							foreach( $v as $k1=>$v1 )
							{
								$this->addHiddenField( $k1, $v1 );
							}
						}
						else
						{
							$this->addHiddenField( $k, $v );
						}
					}
				}
				// definir o novo modulo e submeter o form
				$this->addHiddenField( 'modulo', $filePath );
				$this->addHiddenField( 'moduloId', $filePath );
				$this->addHiddenField( 'fw_back_to', $currentModule);
				$this->clearJavascript();
				$this->addJavascript( 'fwFazerAcao("redirect")' );
				$this->setVisible( false );
				$this->show();
				exit();
				/*
				  die('redirecionar para '.$strModule);

				  // criar formulario e submeter
				  echo "\n".'<form method="POST" name="frm_temp" action="./index.php">'."\n";
				  $arrVars['redirect']=1;
				  if( !isset( $arrVars['modulo']))
				  {
				  $arrVars['modulo']=$strModule;
				  }
				  foreach($arrVars as $k=>$v )
				  {
				  if( is_array($v ))
				  {
				  foreach($v as $k1=>$v1)
				  {
				  echo '<input type=hidden name="'.$k.'['.$k1.']" value="'.$v1.'">'."\n";
				  }
				  }
				  else
				  {
				  echo '<input type=hidden name="'.$k.'" value="'.$v.'">'."\n";

				  }
				  }
				  echo ' <script>javascript:document.frm_temp.submit();</script>';
				  echo '</form>'."\n";
				  echo '</td>'."\n";
				  echo '</tr>'."\n";
				  echo '</center>'."\n";
				  echo '</body>'."\n";
				  echo '</html>'."\n";
				  exit();
				 */
			}
		}
	}
	/**
	 * Adiciona um evento a um campo do formulário
	 *
	 * @param string $strFieldName
	 * @param string $strEventName
	 * @param string $strFunctionJs
	 */
	public function setFieldEvent( $strFieldName, $strEventName=null, $strFunctionJs=null )
	{
		$f = $this->getField( $strFieldName );
		if( $f )
		{
			if( $strFunctionJs )
			{
				$f->addEvent( $strEventName, $strFunctionJs );
			}
			else
			{
				$f->setEvent( $strEventName );
			}
		}
	}
	/**
	 * Se noWrap estiver TRUE, os rótulos dos campos não sofrerão quebra de linha quando forem
	 * mais largos que as medidas defindas pelo metodo $this->setColumns(), e os campos
	 * serão alinhados de acordo com o comprimento dos mesmos
	 *
	 * @param boolean $boolNewValue
	 */
	public function setNoWrap( $boolNewValue=null )
	{
		$this->noWrap = $boolNewValue;
		return $this;
	}
	/**
	 * Retora se os rótulos do campos do formulário serão nowrap ou não.
	 *
	 */
	public function getNoWrap()
	{
		return $this->noWrap;
	}
	//-----------------------------------------------------------------------------
	/**
	 * Adiciona ou retira o efeito de "fade" na exibição do formulário.
	 *
	 * @param integer $intNewValue
	 */
	public function setFade( $intNewValue=null )
	{
		$this->fade = (int) $intNewValue;
		return $this;
	}
	/**
	 * Retorna se o efeito fade está ligado ou desligado
	 *
	 */
	public function getFade()
	{
		return is_null( $this->fade ) ? 1 : (int) $this->fade;
	}
	/**
	 * Define o valor da variável overflow que controla o aparecimento ou
	 * não da barra de rolagem vertical do formulário
	 *
	 */
	public function setOverflowY( $newValue=null )
	{
		$this->overflowY = $newValue;
		return $this;
	}
	//-----------------------------------------------------------------------------
	/**
	 * Retorna o valor da variável overflowy que controla o aparecimento ou
	 * não da barra de rolagem vertical do formulário
	 *
	 */
	public function getOverFlowY()
	{
		$this->overflowY = is_null( $this->overflowY ) ? true : $this->overflowY;
		if( $this->overflowY === true )
		{
			return 'auto';
		}
		else if( $this->overflowY === false )
		{
			return 'hidden';
		}
		return $this->overflowY;
	}
	/**
	 * Define o valor da variável overflow que controla o aparecimento ou
	 * não da barra de rolagem horizontal do formulário
	 *
	 */
	public function setOverflowX( $newValue=null )
	{
		$this->overflowX = $newValue;
		return $this;
	}
	//-----------------------------------------------------------------------------
	/**
	 * Retorna o valor da variável overflowy que controla o aparecimento ou
	 * não da barra de rolagem horizontal do formulário
	 *
	 */
	public function getOverFlowX()
	{
		$this->overflowX = is_null( $this->overflowX ) ? true : $this->overflowX;
		if( $this->overflowX === true )
		{
			return 'auto';
		}
		else if( $this->overflowX === false )
		{
			return 'hidden';
		}
		return $this->overflowX;
	}
	/**
	 * Define o valor do atributo confirmonClose que define se a mensagem de confirmação
	 * de fechamento do formulário será exibida ou não.
	 *
	 */
	public function setConfirmOnClose( $boolNewValue=null )
	{
		$this->confirmOnClose = $boolNewValue;
		return $this;
	}
	/**
	 * Retorna o valor do atributo confirmonClose que define se a mensagem de confirmação
	 * de fechamento do formulário será exibida ou não.
	 *
	 */
	public function getConfirmOnClose()
	{
		return is_null( $this->confirmOnClose ) ? true : $this->confirmOnClose;
	}
	/**
	 * Habilita javascript para transformação dos campos memos
	 * em um editor de textos com recursos avançados de formatação ( WYSIWYG HTML ).
	 * Tambem pode ser utilizada o método setRichEdit(true)
	 *
	 */
	public function enableRichEdit()
	{
		$this->richEdit = true;
	}
	/**
	 * Deabilita recurso de edição avançada ( WYSIWYG HTML ).
	 * Tambem pode ser utilizado o metodo setRichEdit(false);
	 *
	 */
	public function disableRichEdit()
	{
		$this->richEdit = false;
	}
	//-----------------------------------------------------------------------------
	/**
	 * Retorna se o recurso de edição avançada está habilitado ou não.
	 * @return boolean
	 */
	public function getRichEdit()
	{
		return $this->richEdit;
	}
	//-----------------------------------------------------------------------------
	/**
	 * Habilita/Desabilita o recurso de edição de textos com recursos avançados de formatação ( WYSIWYG HTML ).
	 * Tambem pode ser utilizada o enableRichEdit() e disableRichEdit();
	 *
	 * @param bool $boolNewValue
	 */
	public function setRichEdit( $boolNewValue=null )
	{
		$this->richEdit = is_null( $boolNewValue ) ? true : $boolNewValue;
	}
	/**
	* Habilita o icone para edição da documentção online em todos os campos do formulário.
	* Se for passado readonly como true, a documentação abrirá para somente leitura.
	*
	* @param boolean $boolReadOnly
	*/
	public function enableOnlineDoc( $boolReadOnly=null,$intHeight=null,$intWidth=null,$strFields=null,$strIgnoreFields=null)
	{
		$this->onlineDoc=true;
		$this->onlineDocReadOnly = (bool) ( is_null( $boolReadOnly ) ? false : $boolReadOnly);
		$this->setOnlineDocHeight($intHeight);
		$this->setOnlineDocWidth($intWidth);
		self::$onlineDocFields=$strFields;
		self::$onlineDocIgnoreFields=$strIgnoreFields;
	}
	/**
	* Desabilitar a documentção on-line
	*
	*/
	public function disableOnlineDoc()
	{
		$this->onlineDoc = false;
	}
	/**
	* Ativar/Desativar documentação o recurso de edição da documentção on-line dos campos
	*
	* @param mixed $boolEnabled
	* @param mixed $boolReadOnly
	*/
	public function setOnlineDoc( $boolEnabled=null,$boolReadOnly=null)
	{
		$this->onlineDoc = $boolEnabled;
		$this->onlineDocReadOnly = (bool) ( is_null( $boolReadOnly ) ? false : $boolReadOnly);
	}
	/**
	* Recuperar o valor da propriedade onlineDoc
	*
	*/
	public function getOnlineDoc()
	{
		return $this->onlineDoc;
	}
	/**
	* Retorna o codigo html necessário para exibição/edição da documentação on-line
	*
	* @param boolean $print
	*/
	protected function getOnlineDocDiv( $print=true,$intHeight=null,$intWidth=null )
	{
		$style 	= !is_null($intHeight)?'height:'.$intHeight.'px;':'';
		$style .= !is_null($intWidth)?'width:'.$intWidth.'px;':'';
		if( $style != '' )
		{
			$style = ' style="'.$style.'"';
		}
		if( $this->getOnlineDoc() )
		{
			$html = '<table class="fwOnlineDoc" id="fwOnlineDoc" cellpadding="3px" cellspacing="0px"'.$style.' >
					<tr id="fwOnlineDocHeader" class="fwOnlineDocHeader">
						<td id="fwOnlineDoc_image_left_td" height="50px" width="50px" valign="middle" align="center">
							<img id="fwOnlineDoc_image_left" src="'.$this->getBase().'imagens/fwarquivo.gif" border="0" width="45px" height="45px"/>
						</td>
						<td  id="fwOnlineDocTitulo_td" height="50px" valign="middle" align="center">
							<div id="fwOnlineDocTituloSystemName">'.TITULO_SISTEMA.'</div>
							<div id="fwOnlineDocTituloModuleName">Cadastro de Pessoa Física</div>
							<div id="fwOnlineDocTituloFieldName">
								<input type="text" name="fwOnlineDocInputTitle" id="fwOnlineDocInputTitle" size="100" maxlength="150"   class="fwOnlineDocInput">
							</div>
						</td>
						<td  id="fwOnlineDoc_image_right_td" height="50px" width="50px" valign="top" align="right">
							<img id="fwOnlineDocCloseButton" class="fwOnlineDocCloseButton" src="'.$this->getBase().'imagens/fwbtnclosered.jpg" border="0" width="28px" height="16px" alt="Fechar" title="Fechar Ajuda" onClick="fwHideOnlineDocumentation()">
						</td>
					</tr>
					<tr id="fwOnlineDocBody_tr">
						<td id="fwOnlineDocBody" class="fwOnlineDocBody" colspan="3">
							<textarea class="fwOnlineDocTextArea"  name="fwOnlineDocTextArea"  id="fwOnlineDocTextArea" wrap="virtual"></textarea>
						</td>
					</tr>
				</table>'."\n";
				if( $print ) { echo $html; };
				return $html;
		}
	}
	/**
	 * Método para fazer a inclusão do modulo de acordo com a ação solicitada
	 *
	 * @param mixed $arrVar
	 * @param string $strAction
	 */
	public function processAction( $arrVar=null, $strAction=null )
	{

		$boolAjax = ( isset( $_REQUEST[ 'ajax' ] ) && $_REQUEST[ 'ajax' ] == 1);
		// para funcionar com chamadas ajax sem fwAjaxRequest.
		if( $boolAjax )
		{
			$_REQUEST['dataType'] = ( isset( $_REQUEST['dataType'] ) ) ? $_REQUEST['dataType'] : $_REQUEST['dataType']='text';
			require_once($this->getBase() . 'includes/formDin4Ajax.php');
		}
		$this->setVar( $arrVar );


		$strModule = null;
		// encontrar a modulo postado em uma das variáveis: modulo, module
		if( isset($_POST[ 'modulo' ]) && $_POST[ 'modulo' ]  )
		{
			$strModule = $_POST[ 'modulo' ];
		}
		else if( isset($_GET[ 'modulo' ]) && $_GET[ 'modulo' ]  )
		{
			$strModule = $_GET[ 'modulo' ];
		}
		else if( isset($_REQUEST[ 'modulo' ]) && $_REQUEST[ 'modulo' ]  )
		{
			$strModule = $_REQUEST[ 'modulo' ];
		}
		if( isset($_POST[ 'module' ]) && $_POST[ 'module' ]  )
		{
			$strModule = $_POST[ 'module' ];
		}
		else if( isset($_GET[ 'module' ]) && $_GET[ 'module' ]  )
		{
			$strModule = $_GET[ 'module' ];
		}
		else if( isset($_REQUEST[ 'module' ]) && $_REQUEST[ 'module' ]  )
		{
			$strModule = $_REQUEST[ 'module' ];
		}
		// encontrar a ação postada em uma das variáveis: formDinAcao, acao ou action
		if( is_null( $strAction ) )
		{
			if( isset($_POST[ 'formDinAcao' ]) && $_POST[ 'formDinAcao' ]  )
			{
				$strAction = $_POST[ 'formDinAcao' ];
			}
			else if( isset($_GET[ 'formDinAcao' ]) && $_GET[ 'formDinAcao' ]  )
			{
				$strAction = $_GET[ 'formDinAcao' ];
			}
			else if( isset($_REQUEST[ 'formDinAcao' ]) && $_REQUEST[ 'formDinAcao' ]  )
			{
				$strAction = $_REQUEST[ 'formDinAcao' ];
			}
			if( isset($_POST[ 'acao' ]) && $_POST[ 'acao' ]  )
			{
				$strAction = $_POST[ 'acao' ];
			}
			else if( isset($_GET[ 'acao' ]) && $_GET[ 'acao' ]  )
			{
				$strAction = $_GET[ 'acao' ];
			}
			else if( isset($_REQUEST[ 'acao' ]) && $_REQUEST[ 'acao' ]  )
			{
				$strAction = $_REQUEST[ 'action' ];
			}
			if( isset($_POST[ 'action' ]) && $_POST[ 'action' ]  )
			{
				$strAction = $_POST[ 'action' ];
			}
			else if( isset($_GET[ 'action' ]) && $_GET[ 'action' ]  )
			{
				$strAction = $_GET[ 'action' ];
			}
			else if( isset($_REQUEST[ 'action' ]) && $_REQUEST[ 'action' ]  )
			{
				$strAction = $_REQUEST[ 'action' ];
			}

			$strAction = $this->removeIllegalChars( $strAction );
		}

		if( $strAction && $strModule )
		{
			$strModule = $this->getRealPath( $strModule, $strAction );
			$frm = $this;
			if( !is_null( $strModule ) )
			{
				include($strModule); // adiciona o arquivo da ação
			}
		}
		if( $boolAjax )
		{
			// se tiver alguma coisa no buffer, poder ser algum echo, print ou mensagem de erro do php
			$flagSucess=1;
			if( $this->getErrors() )
			{
				$flagSucess=0;
				echo implode("\n", $this->getErrors() );// joga no buffer de saida
				//die();
			}
			if( $this->getMessages() )
			{
				echo implode("\n", $this->getMessages() ); // joga no buffer de saida
			}
			prepareReturnAjax( $flagSucess,$this->getReturnAjaxData());
			die;
		}
	}
	/**
	 * Este médodo faz uma atualização da página principal
	 *
	 */
	public function restart($strMessage=null)
	{
		$this->addJavascript( 'fwApplicationRestart("'.$strMessage.'")');
	}
	/**
	 * método para registrar variáveis na instância da classe TForm
	 * O array de valores deve ser no formato key=>value onde key é o nome
	 * da variável e value é o seu valor.
	 *
	 * Ex: setVar(array('nome','José da Silva'));
	 *
	 * @param array $arrObj
	 */
	public function setVar( $arrObj )
	{
		if( is_array( $arrObj ) )
		{
			foreach( $arrObj as $k=>$v )
			{
				$this->arrVar[ $k ] = $v;
			}
		}
	}
	//-----------------------------------------------------------------------------
	/**
	 * Método para recuperar uma variável registrada pelo método setVar()
	 *
	 * Ex: $nome = getVar('nome');
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function getVar( $id )
	{
		return isset( $this->arrVar[ $id ] ) ? $this->arrVar[ $id ] : null;
	}
	//-----------------------------------------------------------------------------
	/**
	 * Método para encontrar e retornar o caminho correto do módulo dentro do diretório modulos/ da aplicação
	 *
	 * @param string $strFileName
	 */
	function getRealPath( $strFileName=null, $strAction=null )
	{

		if( file_exists( 'modulos/' ) )
		{
			$pathModulos = 'modulos/';
		}
		else
		{
			if( strpos( $strFileName, 'modulos/' ) === false || strpos( $strFileName, 'modulos/' ) > 0 )
			{
				$pathModulos = str_replace( 'base/', 'modulos/', $this->getBase() );
			}
		}
		$aFileParts = pathinfo( $strFileName );
		$baseName = $aFileParts[ 'basename' ];
		$fileName = $aFileParts[ 'filename' ];
		$dirName = $aFileParts[ 'dirname' ];
		// extensão padrão é inc
		$extName = isset( $aFileParts[ 'extension' ] ) ? $aFileParts[ 'extension' ] : 'inc';
		$dirName = ($dirName == '.') ? '' : $dirName;
		$dirName = ($dirName == './') ? '' : $dirName;
		$dirName .= ( $dirName != '') ? '/' : '';
		// se exisiter o diretório, não acrescenter o diretório modulos/
		if( $dirName != '' && is_dir( $dirName ) )
		{
			$pathModulos = '';
		}
		if( !$fileName )
		{
			$fileName = basename( $baseName, '.' . $extName );
		}
		//1º possibilidade: Estrutura de Visão e Controle
		$file = $pathModulos . $dirName . $fileName;
		if( is_dir( $file ) )
		{
			$fileOut = $file . '/' . $fileName . '.' . $extName;
			if( file_exists( $fileOut ) )
			{
				//------------------------------------------------------------------
				if( $strAction )
				{
					$fileOut = $file . '/action/' . $strAction . '.php';
					if( !file_exists( $fileOut ) )
					{
						$fileOut = $file . '/action/' . strtolower( $strAction ) . '.php';
						if( !file_exists( $fileOut ) )
						{
							$fileOut = $file . '/action/' . $strAction . '.inc';
							if( !file_exists( $fileOut ) )
							{
								$fileOut = $file . '/action/' . strtolower( $strAction ) . '.inc';
								if( !file_exists( $fileOut ) )
								{
									$fileOut = null;
								}
							}
						}
					}
				}
				//-----------------------------------------------------------------
				//print '<br>tipo 1:'.$fileOut.' Action:'.$strAction;
				return $fileOut;
			}
			$extName2 = $extName == 'inc' ? 'php' : 'inc';
			$fileOut = $file . '/' . $fileName . '.' . $extName2;
			if( file_exists( $fileOut ) )
			{
				//--------------------------------------------
				if( $strAction )
				{
					$fileOut = $file . '/action/' . $strAction . '.php';
					if( !file_exists( $fileOut ) )
					{
						$fileOut = $file . '/action/' . strtolower( $strAction ) . '.php';
						if( !file_exists( $fileOut ) )
						{
							$fileOut = $file . '/action/' . $strAction . '.inc';
							if( !file_exists( $fileOut ) )
							{
								$fileOut = $file . '/action/' . strtolower( $strAction ) . '.inc';
								if( !file_exists( $fileOut ) )
								{
									//print 'Ação: <b>'.$fileOut.' nem .php</b> não existe';
									$fileOut = null;
								}
							}
						}
						$fileOut = null;
					}
				}
				//--------------------------------------------
				//print '<br>tipo 2:'.$fileOut.' Action:'.$strAction;
				return $fileOut;
			}
		}
		//2º possibilidade modelo normal na pasta modulos
		$fileOut = $pathModulos . $dirName . $fileName . '.' . $extName;
		if( file_exists( $fileOut ) )
		{
			//---------------------------------------------------------------------
			if( $strAction )
			{
				$fileOut = $pathModulos . $dirName . 'action/' . $strAction . '.php';
				if( !file_exists( $fileOut ) )
				{
					$fileOut = $pathModulos . $dirName . 'action/' . $strAction . '.inc';
					if( !file_exists( $fileOut ) )
					{
						$fileOut = $pathModulos . $dirName . 'action/' . strtolower( $strAction ) . '.php';
						if( !file_exists( $fileOut ) )
						{
							$fileOut = $pathModulos . $dirName . 'action/' . strtolower( $strAction ) . '.inc';
							if( !file_exists( $fileOut ) )
							{
								return null;
							}
						}
					}
				}
			}
			//----------------------------------------------------------------------
			//print '<br>tipo 3:'.$fileOut.' Action:'.$strAction;
			return $fileOut;
		}
		$extName2 = $extName == 'inc' ? 'php' : 'inc';
		$fileOut = $pathModulos . $dirName . $fileName . '.' . $extName2;
		if( file_exists( $fileOut ) )
		{
			if( $strAction )
			{
				$fileOut = $pathModulos . $dirName . 'action/' . $strAction . '.php';
				if( !file_exists( $fileOut ) )
				{
					$fileOut = $pathModulos . $dirName . 'action/' . strtolower( $strAction ) . '.php';
					if( !file_exists( $fileOut ) )
					{
						$fileOut = $pathModulos . $dirName . 'action/' . $strAction . '.inc';
						if( !file_exists( $fileOut ) )
						{
							$fileOut = $pathModulos . $dirName . 'action/' . strtolower( $strAction ) . '.inc';
							if( !file_exists( $fileOut ) )
							{
								$fileOut = null;
							}
						}
					}
				}
			}
			//print '<br>tipo 4:'.$fileOut.' Action:'.$strAction;
			return $fileOut;
		}
		return null;
	}
	//-----------------------------------------------------------------------------
	/**
	 * Método para procurar e incluir o arquivo css e js que possua o mesmo
	 * nome do modulo sendo executado
	 *
	 */
	public function addJsCssModule()
	{
		if( isset( $_POST[ 'modulo' ] ) && $_POST[ 'modulo' ] )
		{
			if( $module = $this->getRealPath( $_POST[ 'modulo' ] ) )
			{
				$aFileInfo = pathinfo( $module );
				if( file_exists( $viewJs = $aFileInfo[ 'dirname' ] . '/' . $aFileInfo[ 'filename' ] . '.js' ) )
				{
					$this->addCssFile( $viewJs );
				}
				else if( file_exists( $viewJs = $aFileInfo[ 'dirname' ] . '/js/' . $aFileInfo[ 'filename' ] . '.js' ) )
				{
					$this->addCssFile( $viewJs );
				}
				if( file_exists( $viewJs = $aFileInfo[ 'dirname' ] . '/' . $aFileInfo[ 'filename' ] . '.css' ) )
				{
					$this->addCssFile( $viewJs );
				}
				else if( file_exists( $viewJs = $aFileInfo[ 'dirname' ] . '/css/' . $aFileInfo[ 'filename' ] . '.css' ) )
				{
					$this->addCssFile( $viewJs );
				}
			}
		}
	}
	/**
	 * Define o array com as larguras das colunas do layout do formulario
	 *
	 * @param array $arrNewColumns
	 */
	public function setColumns( $arrNewColumns )
	{
		if( is_string( $arrNewColumns ) )
		{
			$this->columns = explode( ',', $arrNewColumns );
		}
		else if( is_integer( $arrNewColumns ) )
		{

			$this->columns = array( $arrNewColumns );
		}
		else if( is_array( $arrNewColumns ) )
		{
			$this->columns = $arrNewColumns;
		}
		return $this;
	}
	/**
	 * Retorna o array com as larguras das colunas do layout do formulario
	 *
	 */
	public function getColumns()
	{
		return $this->columns;
	}
	/**
	 * Retorna a largura definida ou o array de larguras se o valor da coluna não for informado
	 *
	 * @param integer $intColumn
	 * @return mixed
	 */
	public function getcolumnWidth( $intColumn=null )
	{
		if( is_null( $intColumn ) )
		{
			return $this->columns;
		}
		else
		{

			if( isset( $this->columns[ $intColumn ] ) )
			{
				return ( int ) $this->columns[ $intColumn ];
			}
			return 0;
		}
	}
	/**
	 * Define o metodo de postagem do formulario. (post, get)
	 *
	 * @param mixed $strNewMethod
	 */
	public function setMethod( $strNewMethod=null )
	{
		$this->method = $strNewMethod;
	}
	//------------------------------------------------------------------------------
	/**
	 * Método interno utilizado para adicionar um campo e um rótulo ao formulário. A classe TDisplaycontrol
	 * é responsável pela criação do html do rotulo e campo que serão exibidos no formulário.
	 *
	 * @param object $newDisplayControl
	 */
	protected function addDisplayControl( $newDisplayControl )
	{
		// incluir o campo dentro do grupo ou da aba aberta
		if( is_array( $this->currentContainer ) && count( $this->currentContainer ) > 0 )
		{
			// se for pagecontrol, adicionar na ultima aba adicionada
			if( $this->currentContainer[ count( $this->currentContainer ) - 1 ]->getFieldType() == "pagecontrol" )
			{
				// não executar se não tiver nenhuma aba adicionada no page control
				if( $this->currentContainer[ count( $this->currentContainer ) - 1 ]->getPages() )
				{
					$aLastPage = array_slice( $this->currentContainer[ count( $this->currentContainer ) - 1 ]->getPages(), -1, 1, true );
					$lastPage = $aLastPage[ key( $aLastPage ) ];
					$lastPage->addDisplayControl( $newDisplayControl );
				}
				else
				{
					if( method_exists( $newDisplayControl->getField(), 'getFieldType' ) )
					{
						if( $newDisplayControl->getField()->getFieldType() <> 'hidden' )
						{
							$this->addMessage( 'Para adicionar campos a uma aba,utilize o metodo $pc->addPage() primeiro.<br>' );
						}
					}
				}
			}
			else
			{
				// o grupo ou a aba será o pai do controle
				$newDisplayControl->getField()->setParentControl( $this->currentContainer[ count( $this->currentContainer ) - 1 ] );
				$this->currentContainer[ count( $this->currentContainer ) - 1 ]->displayControls[ $newDisplayControl->getField()->getName() ] = $newDisplayControl;
			}
		}
		else
		{
			if( method_exists( $newDisplayControl->getField(), 'setParentControl' ) )
			{
				$newDisplayControl->getField()->setParentControl( $this );
			}
			$this->displayControls[ $newDisplayControl->getField()->getName() ] = $newDisplayControl;
		}
		// adicionar o valor do rotulo do campo em sua propriedade
		if( $newDisplayControl->getLabel() )
		{
			$newDisplayControl->getField()->setProperty( 'label', $newDisplayControl->getLabel()->getValue() );
		}
		return $newDisplayControl;
	}
	/**
	 * retorna o array de objetos displaycontrol que contem os campos e os labels do
	 * formulário
	 *
	 * @return array
	 */
	public function getDisplayControls()
	{
		return $this->displayControls;
	}
	/**
	 * Adicionar botão no layout
	 *
	 * O parametro mixValue pode ser um array com os nomes dos botões. ex: array('Gravar', 'Limpar').
	 * Nesta caso os demais parametros não serão considerados exceto o strOnClick que
	 * pode ser informado o nome de uma função javascript para ser executada ao clicar no botão.
	 * Esta função receberá o Valor do botão e a variavel this.
	 *
	 * Para que o botão fique alinhado na frente de um campo com labelAbove=true, basta
	 * definir o parametro boolLabelAbove do botão para true tambem.
	 *
	 * @param mixed   $mixValue
	 * @param string  $strName
	 * @param string  $strAction  - Nome da ação
	 * @param string  $strOnClick
	 * @param string  $strConfirmMessage
	 * @param boolean $boolNewLine  - em nova linha
	 * @param boolean $boolFooter   - mostrar no fim do form
	 * @param string  $strImage
	 * @param string  $strImageDisabled
	 * @param string  $strHint
	 * @param string  $strVerticalAlign
	 * @param string  $strLabel
	 * @param bool    $boolLabelAbove
	 * @return TButton
	 */
	public function addButton( $mixValue=null, $strAction=null, $strName=null, $strOnClick=null, $strConfirmMessage=null, $boolNewLine=null, $boolFooter=null, $strImage=null, $strImageDisabled=null, $strHint=null, $strVerticalAlign=null, $boolLabelAbove=null, $strLabel=null, $strHorizontalAlign=null)
	{
		// botão será criado no rodapé do formulário por padrão
		$boolFooter = ($boolFooter === null) ? true : $boolFooter;
		$strVerticalAlign = is_null( $strVerticalAlign ) ? 'center' : $strVerticalAlign;
		$strHorizontalAlign = is_null( $strHorizontalAlign ) ? 'center' : $strHorizontalAlign;
		// a maioria dos botões ficam na frente dos campos
		if( $boolNewLine === null )
		{
			$boolNewLine = false;
		}
		if( is_string( $mixValue ) && strpos( $mixValue, ',' ) > 0 )
		{
			$mixValue = explode( ',', $mixValue );
		}
		if( is_array( $mixValue ) )
		{
			// passar o objeto e o nome do botão se for informado o nome de uma função para tratamento do click
			$onClick = $strOnClick;
			if( ( string ) $strOnClick != '' )
			{
				// retirar os parenteses do nome da função para poder adicionar os parametros padrão
				if( $posParentese = strpos( $onClick, '(' ) )
				{
					$onClick = substr( $onClick, 0, $posParentese );
				}
			}
			foreach( $mixValue as $k=>$value )
			{
				//$strName	= $this->removeIllegalChars($value).'_'.mt_rand(1, 100);
				$strName = strtolower( $this->removeIllegalChars( $value ) );
				$strValue = $value;
				if( !$onClick )
				{
					if( $this->getFieldType() != 'form' )
					{
						$strAction = $this->getId() . '_' . $value;
					}
					else
					{
						$strAction = $value;
					}
				}
				else
				{
					$strAction = null;
					$strOnClick = $onClick . '("' . $value . '",this)';
				}
				$btn = new TButton( $strName, $strValue, $strAction, $strOnClick, $strConfirmMessage, $strImage, $strImageDisabled, $strHint );
				if( $boolFooter )
				{
					$this->footerButtons[ $btn->getId() ] = $btn;
				}
				else
				{
					$this->addDisplayControl( new TDisplayControl( $strLabel, $btn, $boolLabelAbove, $boolNewLine, false, $strVerticalAlign ) );
					//$dc->setCss('text-align',$strHorizontalAlign);
					$btn->setAttribute('align',$strHorizontalAlign);
				}
				$button[ $strName ] = $btn;
				// colocar os botões lado a lado na horizontal
				$boolNewLine = false;
			}
		}
		else if( !is_object( $mixValue ) )
		{
			if( !isset( $strName ) )
			{
				if( isset( $mixValue ) )
				{
					$strName = strtolower( $this->removeIllegalChars( $mixValue ) );
				}
			}
			$button = new TButton( $strName, $mixValue, $strAction, $strOnClick, $strConfirmMessage, $strImage, $strImageDisabled, $strHint );
			if( $boolFooter )
			{
				$this->footerButtons[ $button->getId() ] = $button;
			}
			else
			{
				$dc = $this->addDisplayControl( new TDisplayControl( $strLabel, $button, $boolLabelAbove, $boolNewLine, false, $strVerticalAlign ) );
				//$dc->setCss('text-align',$strHorizontalAlign);
				$button->setAttribute('align',$strHorizontalAlign);
			}
		}
		else
		{
			$strName = $mixValue->getName();
			$button = $mixValue;
			if( $boolFooter )
			{
				$this->footerButtons[ $button->getId() ] = $button;
			}
			else
			{
				$this->addDisplayControl( new TDisplayControl( null, $button, false, $boolNewLine, false, $strVerticalAlign ) );
				//$dc->setCss('text-align',$strHorizontalAlign);
				$button->setAttribute('align',$strHorizontalAlign);

			}
		}
		return $button;
	}

	/**
	* Cria um botão para executar uma chamada ajax utilizando a função fwAjaxRequest
	*
	*
	* @param string $strValue
	* @param string $strModule
	* @param string $strJsCallback
	* @param string $strAction
	* @param string $strMsgLoading
	* @param string $strDataTypeReturn
	* @param boolean $boolAsync
	* @param string $strName
	* @param string $strConfirmMessage
	* @param boolean $boolNewLine
	* @param boolean $boolFooter
	* @param string $strImage
	* @param string $strImageDisabled
	* @param string $strHint
	* @param string $strVerticalAlign
	* @param boolean $boolLabelAbove
	* @param string $strLabel
	* @param mixed $strHorizontalAlign
	* @param mixed $boolBlockScreen
	* @return object TButton
	*/
	public function addButtonAjax( $strValue=null, $strModule=null, $strJsBeforeSend=null, $strJsCallback=null, $strAction=null, $strMsgLoading=null, $strDataTypeReturn=null, $boolAsync=null, $strContainerId=null, $strName=null, $strConfirmMessage=null, $boolNewLine=null, $boolFooter=null, $strImage=null, $strImageDisabled=null, $strHint=null, $strVerticalAlign=null, $boolLabelAbove=null, $strLabel=null,$strHorizontalAlign=null,$boolBlockScreen=null )
	{
		$strOnClick = '';
		// botão será criado no rodapé do formulário por padrão
		$boolFooter = ($boolFooter === null) ? true : $boolFooter;
		$boolAsync = ($boolAsync === true) ? true : false;
		$boolBlockScreen = ($boolBlockScreen === true) ? true : false; // mesmo em uma chamada assyncrona pode ser necessário bloquear a tela
		$strVerticalAlign = is_null( $strVerticalAlign ) ? 'center' : $strVerticalAlign;
		$strHorizontalAlign = is_null( $strHorizontalAlign ) ? 'center' : $strHorizontalAlign;

		// a maioria dos botões ficam na frente dos campos
		if( $boolNewLine === null )
		{
			$boolNewLine = false;
		}
		if( !isset( $strName ) )
		{
			if( isset( $strValue ) )
			{
				$strName = strtolower( $this->removeIllegalChars( $strValue ) );
			}
		}
		/*if( is_null( $strJsCallback ) )
		{
			if( !is_null( $strAction ) )
			{
				$function = 'callback' . ucfirst( $strAction ) . 'Ajax';
			}
			else
			{
				$function = 'callback' . ucfirst( $strName ) . 'Ajax';
			}
		}
		else
		{
			$function = $strJsCallback;
		}

		if( is_null( $strJsBeforeSend ) )
		{
			if( ! is_null( $strAction ) )
			{
				$functionBeforeSend = 'beforeSend' . ucfirst( $strAction ) . 'Ajax';
			}
			else
			{
				$functionBeforeSend = 'beforeSend' . ucfirst( $strName ) . 'Ajax';
			}
		}
		else
		{
			$functionBeforeSend = $strJsBeforeSend;
		}
		*/
		$function = is_null($strJsCallback) ? 'null' : $strJsCallback;
		$functionBeforeSend = is_null($strJsBeforeSend) ? 'null':$strJsBeforeSend;
		if( is_null( $strAction ) )
		{
			$strAction = $this->removeIllegalChars( $strValue );
		}
		if( is_null( $strDataTypeReturn ) )
		{
			$strDataTypeReturn = 'json'; // json is default
			// @todo validar parametro =>  json || text
		}
		$strOnClick = 'fwAjaxRequest( {"callback": (typeof ' . $function . ' == "function") ? ' . $function . ' : null,"beforeSend":' . ( $functionBeforeSend=='null' ? $functionBeforeSend : '"'.$functionBeforeSend.'"' ) . ',"action":"' . $strAction . '","async":' . ( ( $boolAsync ) ? 'true' : 'false' ) . ',"dataType":"' . $strDataTypeReturn . '","msgLoading":"' . $strMsgLoading . '","containerId":"' . $strContainerId . '","module":"' . $strModule . '","blockScreen":'. ( ( $boolBlockScreen ) ? 'true' : 'false' ).'});';
		//$strOnClick = 'fwAjaxRequest( {"callback": (typeof ' . $function . ' == "function") ? ' . $function . ' : null,"beforeSend": (typeof ' . $functionBeforeSend . ' == "function") ? ' . $functionBeforeSend . ' : null,"action":"' . $strAction . '","async":' . ( ( $boolAsync ) ? 'true' : 'false' ) . ',"dataType":"' . $strDataTypeReturn . '","msgLoad":"' . $strMsgLoading . '","containerId":"' . $strContainerId . '","module":"' . $strModule . '"});';
		$strAction = null;
		$button = new TButton( $strName, $strValue, $strAction, $strOnClick, $strConfirmMessage, $strImage, $strImageDisabled, $strHint );
		if( $boolFooter )
		{
			$this->footerButtons[ $button->getId() ] = $button;
		}
		else
		{
			$dc=$this->addDisplayControl( new TDisplayControl( $strLabel, $button, $boolLabelAbove, $boolNewLine, false, $strVerticalAlign ) );
			$dc->setCss('text-align',$strHorizontalAlign);
			$button->setAttribute('align',$strHorizontalAlign);
		}
		return $button;
	}
	/**
	 * Define os botões do rodapé do formulario. Pode ser passado uma acao ou um array de ações.
	 * Cada ação será um botão no rodapé do formulário
	 *
	 * @param mixed $mixActions
	 */
	public function setAction( $mixActions )
	{
		$this->actions = $mixActions;
	}
	/**
	 * Remove uma ou todas definidas por setAction()
	 *
	 * @param string $strAction
	 */
	public function RemoveAction( $strAction=null )
	{
		if( is_null( $strAction ) )
		{
			$this->actions = null;
		}
		if( is_string( $this->actions ) )
		{
			$aAction = explode( ',', $this->actions );
		}
		else if( is_array( $this->actions ) )
		{
			$aAction = $this->actions;
		}
		if( is_array( $aAction ) )
		{
			foreach( $aAction as $k=>$action )
			{
				if( trim( $action ) == trim( $strAction ) )
				{
					array_splice( $aAction, $k, 1 );
					break;
				}
			}
			$this->setAction( implode( ',', $aAction ) );
		}
	}
	//-----------------------------------------------------------------------------
	/**
	 * Limpar a fila de codigos javascripts que serão executados no enveno on-load do formulario
	 *
	 */
	public function clearJavascript()
	{
		$this->javascript = null;
	}
	/**
	 * Método para habilitar a tecla F5 do navegador
	 *
	 */
	public function enableF5()
	{
		$this->F5Enabled = true;
	}
	/**
	 * Método para desabilitar a tecla F5 do navegador
	 *
	 */
	public function disableF5()
	{
		$this->F5Enabled = false;
	}
	/**
	 * Método para retornar se a tecla F5 deverá ou não ser habilitada.
	 *
	 */
	public function getF5Enabled()
	{
		if( $this->F5Enabled )
		{
			return 'true';
		}
		else
		{
			return 'false';
		}
	}
	//-----------------------------------------------------------------------------
	private function processApf()
	{
		return;
		if( $this->getFieldType() == 'form' )
		{
			if( strpos( __FILE__, 'prototipo' ) > 0 || strpos( __FILE__, 'appbase' ) > 0 )
			{
				$this->addButton( 'APF', 'process_apf', '_btnApf' );
			}
			if( $_POST[ 'formDinAcao' ] == 'process_apf' )
			{
				require_once 'Spreadsheet/Excel/Writer.php';
				$fileName = $this->getBase() . 'tmp/' . $this->removeIllegalChars( $_POST[ 'modulo' ] ) . '.xls';
				$workbook = new Spreadsheet_Excel_Writer( $fileName );

				$format_title = & $workbook->addFormat();
				$format_title->setBold();
				$format_title->setFgColor( 'silver' );
				$format_title->setBorder( 1 );
				$format_title->setAlign( 'center' );

				$format_group = & $workbook->addFormat();
				$format_group->setBold();
				$format_group->setFgColor( 'gray' );
				$format_group->setBorder( 1 );
				$format_group->setAlign( 'center' );

				$worksheet = & $workbook->addWorksheet( 'PLANILHA' );
				$worksheet->setColumn( 0, 2, 30 );

				$format_cell = & $workbook->addFormat();
				$format_cell->setBorder( 1 );
				// criar o titulo da planilha
				$worksheet->write( 0, 0, $this->getTitle(), $format_title );
				$worksheet->setMerge( 0, 0, 0, 2 );
				$worksheet->write( 1, 0, 'CAMPO', $format_title );
				$worksheet->write( 1, 1, 'TIPO', $format_title );
				$worksheet->write( 1, 2, 'RÓTULO', $format_title );
				$worksheet->line = 2;
				//$workbook->send('base/tmp/apf.xls');
				$aDc = $this->getDisplayControls();
				$this->processarApfFields( $aDc, $worksheet, $format_cell, $format_group );
				$workbook->close();
				$this->addLinkField( 'link_apf', '', 'Visualizar Planilha - APF', null, $fileName, null, null, null, null, 'Pontos de Função - Clique aqui para visualizar a plinilha.' );
			}
		}
	}
	protected function processarApfFields( $aDc, $worksheet, $format_cell, $format_group )
	{
				// não terminada
				return;
		foreach( $aDc as $k=>$dc )
		{
			$field = $dc->getField();
			$label = $dc->getLabel();
			if( $label )
			{
				//if($field->getEnabled())
				{
					$worksheet->write( $worksheet->line, 0, $k . '-' . $worksheet->line, $format_cell );
					$worksheet->write( $worksheet->line, 1, $dc->getField()->getFieldType(), $format_cell );
					$worksheet->write( $worksheet->line, 2, $label->getValue(), $format_cell );
					$worksheet->line = $worksheet->line + 1;
				}
				//print 'Campo:'.$k.' Rótulo:'.$label->getValue().'  tipo:'.$dc->getField()->getFieldType().'<br>';
			}
			else
			{
				if( $field->getFieldType() == 'group' )
				{
					$worksheet->write( $worksheet->line, 0, $field->getLegend(), $format_group );
					$worksheet->setMerge( $worksheet->line, 0, $worksheet->line, 2 );
					$worksheet->line = $worksheet->line + 1;
					$field->processarApfFields( $field->getDisplayControls(), $worksheet, $format_cell, $format_group );
				}
				else if( $field->getFieldType() == 'pagecontrol' )
				{
					if( is_array( $field->getPages() ) )
					{
						forEach( $field->getPages() as $name=>$page )
						{
							$worksheet->write( $worksheet->line, 0, $page->getValue(), $format_group );
							$worksheet->line = $worksheet->line + 1;
							$page->processarApfFields( $page->getDisplayControls(), $worksheet, $format_cell, $format_group );
						}
					}
				}
			}
		}
	}
	/**
	 * Método para adicionar texto explicativo a um campo quando o mouse for passado sobre o mesmo.
	 *
	 * @param mixed $strFieldName
	 * @param mixed $strHint
	 */
	public function setHint( $strFieldName=null, $strHint=null )
	{
		if( is_null( $strFieldName ) )
		{
			parent::setHint( $strHint );
		}
		else
		{
			if( $field = $this->getField( $strFieldName ) )
			{
				$field->setHint( $strHint );
			}
		}
	}
	//-----------------------------------------------------------------------------
	/**
	 * Habilitar a exibição dos hints no formato de balão
	 *
	 */
	public function enableCustomHint()
	{
		$this->setCustomHintEnabled( true );
	}
	/**
	 * Desabilitar a exibição dos hints no formato de balão
	 *
	 */
	public function disableCustomHint()
	{
		$this->setCustomHintEnabled( false );
	}
	/**
	 * Definir ou não a utilização dos hints dentro de um balão
	 *
	 * @param mixed $boolNewValue
	 */
	public function setCustomHintEnabled( $boolNewValue=null )
	{
		$boolNewValue = ($boolNewValue === true ) ? true : false;
		$this->customHintEnabled = $boolNewValue;
	}
	/**
	 * Retorna verdadeiro ou falso para utilizar os hints de ajuda no formato de balão customizado
	 *
	 */
	public function getCustomHintEnabled()
	{
		return $this->customHintEnabled;
	}
	//-----------------------------------------------------------------------------
	public function setColorHighlightBackground( $strNewColor=null )
	{
		$this->colorHighlightBackground = $strNewColor;
	}
	//----------------------------------------------------------------------------
	public function getColorHighlightBackground()
	{
		return $this->colorHighlightBackground;
	}
	/**
	 * Define se a altura do formulário sera ajustada de acordo com o seu conteudo não
	 * mostrando a barra vertical de rolagem
	 *
	 * @param bool $boolNewValue
	 */
	public function setAutoSize( $boolNewValue=null )
	{
		$boolNewValue = is_null( $boolNewValue ) ? false : ( bool ) $boolNewValue;
		$this->autoSize = $boolNewValue;
	}
	/**
	 * Retorna se o formulário está ou não com autosize definido
	 *
	 */
	public function getAutoSize()
	{
		return $this->autoSize;
	}
	//-----------------------------------------------------------------------------
	public function get( $strFieldName=null )
	{
		return $this->getValue( $strFieldName );
	}
	//-----------------------------------------------------------------------------
	public function set( $strFieldName, $strNewValue )
	{
		return $this->setValue( $strFieldName, $strNewValue );
	}
	//-----------------------------------------------------------------------------
	public function setTooltip( $strFieldName=null, $strTitle=null, $strText=null )
	{
		if( $field = $this->getField( $strFieldName ) )
		{
			$field->setTooltip( $strTitle, $strText );
			return $field;
		}
	}
	//-----------------------------------------------------------------------------
	public function setVO( $vo )
	{
		foreach( $this->displayControls as $name=>$dc )
		{
			if( $dc->getField()->getFieldType() == 'pagecontrol' )
			{
				$dc->getField()->setVo( $vo );
			}
			else if( $dc->getField()->getFieldType() == 'group' )
			{
				$dc->getField()->setVo( $vo );
			}
			else
			{
				$dc = new TDAOCreate();
				if( method_exists( $vo, $method = 'set' . ucfirst( $name ) )
					|| method_exists($vo, $method = 'set' . ucfirst( $dc->removeUnderline($name) )) )
				{
					$field = $this->getField( $name );
					if( $field )
					{
						if( ! is_array($field->getValue() ) )
						{
							if( $field->getFieldType()=='fileasync')
							{
								$value = $field->getContent();
							}
							else
							{
								$value = $field->getValue();
							}
						}
						else
						{
							$value = $field->getValue();
							//print $name.' = '.print_r($field->getValue(),true).'<br>';
							if(isset($value[0]))
							{
								$value = $value[0];
							}
							else
							{
								$value=null;
							}

						}
						$method = '$vo->' . $method . '(\'' . addslashes($value) . '\');';
						eval( $method );
					}
				}
			}
		}
	}
	/**
	 * Retorna o objeto header (TTableCell) referente a área do titulo do formulário.
	 *
	 */
	public function getHeaderCell()
	{
		return $this->header;
	}
	/**
	 * Retorna o objeto TTableCell referente a area do botão fechar da janela
	 *
	 */
	public function getHeaderButtonCell()
	{
		return $this->headerCloseButton;
	}
	public function getFooterButtons()
	{
		return $this->footerButtons;
	}
	/**
	 * Retorna o objeto TTableCell referente a area do rodapé da janela
	 *
	 */
	public function getFooterCell()
	{
		return $this->footer;
	}
	/**
	 * Habilitar/Desabilitar a exibição de mensagens na parte de cima do formulário
	 *
	 * @param boolean $boolNewValue
	 */
	public function setShowMessageForm( $boolNewValue = null )
	{
		$boolNewValue = is_null($boolNewValue) ? true : $boolNewValue;
		$this->showMessageAlert = !$boolNewValue;
	}
	public function getShowMessageForm()
	{
		return ! $this->showMessageAlert;
	}
	/**
	 * Habilitar/Desabilitar a exibição de mensagens com a função alert do javascript
	 *
	 * @param boolean $boolNewValue
	 */
	public function setShowMessageAlert( $boolNewValue = null )
	{
		$this->showMessageAlert = $boolNewValue;
	}
	public function getShowMessageAlert()
	{
		return $this->showMessageAlert === true ? 1 : 0;
	}
	//-----------------------------------------------------------------------------
	/**
	 * Define o alinhamento vertical do formulário na tela
	 *
	 * @param string $strNewValue - top,middle,bottom
	 */
	public function setVerticalAlign( $strNewValue=null )
	{
		$this->vertical_align = $strNewValue;
	}
	/**
	 * Recupera o valor definido para o alinhamento vertical do formulário na tela
	 */
	public function getVerticalAlign()
	{
		return $this->vertical_align;
	}
	/**
	 * Define o alinhamento horizontal do formulário na tela
	 *
	 * @param string $strNewValue - left,right,center
	 */
	public function setHorizontalAlign( $strNewValue=null )
	{
		$this->horizontal_align = $strNewValue;
	}
	/**
	 * Recupera o valor do alinhamento vertical do formulário na tela
	 */
	public function getHorizontalAlign()
	{
		return $this->horizontal_align;
	}
	//-----------------------------------------------------------------------------
	public function clearJsFiles()
	{
		$this->jsFiles = null;
	}
	public function clearCssFiles()
	{
		$this->cssFiles = null;
	}
	//-----------------------------------------------------------------------------
	public function addError( $mixError=null, $id=null )
	{
		static $result=false;
		if( is_string($mixError) && trim( $mixError ) !== '' )
		{
			if( $id )
			{
				self::$errors[ $id ] = $mixError;
			}
			else
			{
				self::$errors[] = $mixError;
			}
			$result = true;
		}
		elseif ( is_array( $mixError ) )
		{
			foreach($mixError as $k=>$v)
			{
				if( $v )
				{
					$result = $this->addError($v);
				}
			}
		}
		return $result;
	}
	//-----------------------------------------------------------------------------
	public function setError( $strError=null )
	{
		self::$errors = array( $strError );
	}
	/**
	 * Retorna o array de erros de validação gerado pelo método validate()
	 *
	 */
	public function getErrors()
	{
		/* if( isset( $_REQUEST['ajax'] ) && isset( $_REQUEST['dataType'] ) && $_REQUEST['dataType']=='text' )
		  {
		  return null;
		  }
		 */
		return ( array ) self::$errors;
	}

	//-----------------------------------------------------------------------------
	/**
	* Remove a área de mensagem criada pela classe no topo do formulário
	*
	*/
	public function removeMessageArea()
	{
		if( $this->message_area )
		{
			$this->removeField( $this->message_area->getId() );
		}
	}
	//-----------------------------------------------------------------------------
	/**
	* Define nome da função do usuário, que será chamada a cada linha adicionada ao formulário.
	*
	* A class passa automaticamente os seguintes parâmetros:
	* $dc - Instância da classe TDisplayControl
	* $cell - Instância da classe TTableCell
	* $RowNum - O número da linha corrente do formulário, aba ou grupo que estiver sendo criado
	* $row = Instância do objeto TTableRow
	*
	* <code>
	* function myFormOnDrawRow($ObjDc,$objCell,$intRowNum,$objRow)
	* {
	* 	if( $intRowNum == 2 )
	* 	{
	* 		$objCell->setCss('border-bottom','1px dashed blue');
	* 		$objDc->getField()->setEnabled( false );
	* 	}
	* }
	* </code>
	*
	* @param mixed $strFunctionName
	*/
	public function setOnDrawRow($strFunctionName=null)
	{
		$this->onDrawRow=$strFunctionName;
	}
	/**
	* Retorna o nome da função do usuario a ser chamada na criação de cada linha do formulário
	*
	* A class passa automaticamente os seguintes parâmetros:
	* $dc - Instância da classe TDisplayControl
	* $cell - Instância da classe TTableCell
	* $RowNum - O número da linha corrente do formulário, aba ou grupo que estiver sendo criado
	* $row = Instância do objeto TTableRow
	*
	* <code>
	* function myFormOnDrawRow($ObjDc,$objCell,$intRowNum,$objRow)
	* {
	* 	if( $intRowNum == 2 )
	* 	{
	* 		$objCell->setCss('border-bottom','1px dashed blue');
	* 		$objDc->getField()->setEnabled( false );
	* 	}
	* }
	* </code>
	*
	* @param mixed $strFunctionName
	*/
	public function getOnDrawRow($strFunctionName=null)
	{
		return $this->onDrawRow;
	}
	/**
	* Definie o nome da função do usuário, que será chamada na criação de cada campo no formulário
	* A class passa automaticamente os seguintes parâmetros:
	*
	* $dc - Instância da classe TDisplayControl
	* $cell - Instância da classe TTableCell
	* $RowNum - O número da linha corrente do formulário, aba ou grupo que estiver sendo criado
	* $row = Instância do objeto TTableRow
	*
	* <code>
	*	function minhaFuncao($dc,$cell,$rowNum )
	*	{
	*		if( $dc->getLabel() )
	*		{
	*			$dc->getLabel()->setCss('color','yellow');
	*		}
	* 	}
	* </code>
	*
	* @param mixed $strFunctionName
	*/
	public function setOnDrawField($strFunctionName=null)
	{
		$this->onDrawField=$strFunctionName;
	}
	/**
	* Retorna o nome da função do usuário chamada na criação de cada campo no formulário
	* A class passa automaticamente os seguintes parâmetros:
	*
	* $dc - Instância da classe TDisplayControl
	* $cell - Instância da classe TTableCell
	* $RowNum - O número da linha corrente do formulário, aba ou grupo que estiver sendo criado
	* $row = Instância do objeto TTableRow
	*
	* <code>
	*	function minhaFuncao($dc,$cell,$rowNum )
	*	{
	*		if( $dc->getLabel() )
	*		{
	*			$dc->getLabel()->setCss('color','yellow');
	*		}
	* 	}
	* </code>
	*
	* @param mixed $strFunctionName
	* @return mixed
	*/
	public function getOnDrawField($strFunctionName=null)
	{
		return $this->onDrawField;
	}
	//-----------------------------------------------------------------------------
	public function setReturnAjaxData($arrData=null)
	{
		$this->returnAjaxData = $arrData;
	}
	//-----------------------------------------------------------------------------
	public function getReturnAjaxData()
	{
		if( isset( $this->returnAjaxData ) && !is_array($this->returnAjaxData) )
		{
			return array( $this->returnAjaxData );
		}
		return $this->returnAjaxData;
	}
	//-----------------------------------------------------------------------------
	public function addReturnAjaxData($value=null)
	{
		if( $value )
		{
			if( is_null( $this->returnAjaxData ) )
			{
				$this->returnAjaxData=array();
			}
			$this->returnAjaxData = $value;
		}
	}
	//-----------------------------------------------------------------------------
	function setOnlineDocHeight($intNewValue=null)
	{
		$this->onlineDocHeight = $intNewValue;
	}
	//-----------------------------------------------------------------------------
	function getOnlineDocHeight()
	{
		return $this->onlineDocHeight;
	}
	//-----------------------------------------------------------------------------
	function setOnlineDocWidth($intNewValue=null)
	{
		$this->onlineDocWidth = $intNewValue;
	}
	//-----------------------------------------------------------------------------
	function getOnlineDocWidth()
	{
		return $this->onlineDocWidth;
	}
	//-----------------------------------------------------------------------------
	/**
	* Método utilizado para desformatar números decimas adicionando a virgula ou o ponto
	* como serparador decimal
	*
	* @param mixed $number
	* @param str $strDecimalSeparator
	* @return mixed
	*/
	function unformatNumber($number=null, $strDecimalSeparator=null)
	{
		if( is_null($number))
		{
			return $number;
		}
		$strDecimalSeparator = ( is_null( $strDecimalSeparator ) ? '.' : $strDecimalSeparator );
		if( $strDecimalSeparator != '.' && $strDecimalSeparator!=',')
		{
			$strDecimalSeparator = '.';
		}
		$posComma 	= strpos($number,',');
		$posDot		= strpos($number,'.');
		if($posComma == $posDot)
		{
			return $number;
		}
		// logica para virgula
		if( $strDecimalSeparator == ',')
		{
			// 1.234,56
			if( $posComma > $posDot )
			{
				$number = preg_replace('/\./','',$number);
			}
			else // 1,234.56
			{
				$number = preg_replace('/\./',',', preg_replace('/,/','',$number ) );
			}
		}
		else
		{
			// 1.234,56
			if( $posComma > $posDot )
			{
				$number = preg_replace('/,/','.',preg_replace('/\./','',$number ) );
			}
			else // 1,234.56
			{
				$number = preg_replace('/,/','',$number );
			}
		}
		return $number;
	}
	//-----------------------------------------------------------------------------
	public function setOnMaximize($strNewValue=null)
	{
		$this->onMaximize = $strNewValue;
	}
	public function getOnMaximize()
	{
		return $this->onMaximize;
	}
	//-----------------------------------------------------------------------------
	/**
	* Define o formulário como sendo parte do gride offline para que o mesmo
	* não crie campos de controles duplicados com o form principal
	*
	* @param mixed $boolNewValue
	*/
	public function setFormGridOffLine($boolNewValue=null)
	{
		$this->formGridOffLine = $boolNewValue;
	}
	public function getFormGridOffLine()
	{
		return $this->formGridOffLine;
	}
	//-----------------------------------------------------------------------------
	/**
	* Habilitar/Desabilitar o recurso de maximizar o formulário ao efetuar um duplo-clique
	* na barra de título
	*
	* @param bool $boolNewValue
	*/
	public function setMaximize($boolNewValue = null)
	{
		$this->maximize = $boolNewValue;
	}
	/**
	* Recuperar o valor da propriedade maximize. Se true o formulário é maximizado
	* ao efeturar um duplo-clique no título
	*
	*/
	public function getMaximize()
	{
		return ( $this->maximize === false ? false: true );
	}

	//-----------------------------------------------------------------------------
	/**
	* Define se o formulário será exibido ou não ao receber o post fwSession_expired da
	* aplicação
	*
	* @param boolean $boolNewValue
	*/
	public function setPublicMode($boolNewValue = null)
	{
		self::$publicMode = $boolNewValue;
	}
	/**
	* Retorna se o formulário será exibido ou não ao receber o post fwSession_expired da
	* aplicação
	*
	*/
	public function getPublicMode()
	{
		//return ( $this->publicMode == 'S' || strtolower($this->publicMode) == '1' || strtolower( $this->publicMode == 'true') ) ? true : false;
		return ( self::$publicMode == 'S' || strtolower(self::$publicMode) == '1' || strtolower( self::$publicMode == 'true') ) ? true : false;
	}
	//-----------------------------------------------------------------------------
	public function setRequiredFieldText($strNewValue=null)
	{
		$this->requiredFieldText = $strNewValue;
	}
	public function getRequiredFieldText()
	{
		return $this->requiredFieldText;
	}
	//-----------------------------------------------------------------------------
	public function addShortCut($strShortcutKey=null,$objId=null,$boolChangeLabel=null,$strJsFunction=null)
	{
		$boolChangeLabel = ($boolChangeLabel===false ? 0 : 1);
		self::$shortCuts[$strShortcutKey] = (object) array('objectId'=>$objId,'changeLabel'=>$boolChangeLabel,'functionJs'=>$strJsFunction);
	}
	//-----------------------------------------------------------------------------
	public function parseShortcut($obj,$target)
	{

		if( !is_object($obj) || ! method_exists($obj,'getValue') )
		{
			return;
		}
		$label = $obj->getValue();
		if( preg_match('/\|/',$label) == 1)
		{
			$char = explode('|',$label);
			if( isset($char[0] ) )
			{
				$obj->setProperty('shortcut',$char[0].'|'.$target);
				//$obj->setValue(preg_replace('/&/','',$label) );
				$label = preg_replace('/'.$char[0].'\|/','',$label);
				if( $obj->getFieldType() == 'tabsheet')
				{
					$obj->setValue(null,$label);
				}
				else
				{
					$obj->setValue( $label );
				}
			}
		}
		else if( preg_match('/\&/',$label) == 1)
		{

			$arrSpecialCharFrom = array('&nbsp;','&aacute','&Aacute','&atilde','&Atilde','&acirc','&Acirc','&agrave','&Agrave','&eacute','&Eacute','&ecirc','&Ecirc','&iacute','&Iacute','&oacute','&Oacute','&otilde','&Otilde','&ocirc','&Ocirc','&uacute','&Uacute','&ccedil','&Ccedil;','&amp;','','&circ;','&tilde;','&uml;','&cute;','&cedil;','&quot;','&ldquo;','&rdquo;','&lsquo;','&rsquo;','&sbquo;','&bdquo;','&ordm;','&ordf;','&ndash;','&mdash;','&shy;','&macr;','&lsaquo;','&rsaquo;','&ldquo;','&raquo;','&hellip;','&brvbar;','&bull;','&#8227;','&para;','&sect;','&copy;','&reg;','&trade;','&pound;','&cent;','&#8357;','&euro;','&yen;','&#8354;','&#8355;','&#8356;','&#8367;','&#8358;','&#8359;','&#8360;','&#8361;','&#8362;','&#8363;','&#8365;','&#8366;','&curren;','&sup1;','&#8321;','&sup2;','&#8322;','&sup3;','&#8323;','&#8308;','&#8324;','&#8309;','&#8325;','&#8310;','&#8326;','&#8311;','&#8327;','&#8312;','&#8328;','&#8313;','&#8329;','&#8304;','&#8320;','&#8316;','&#8332;','&#8314;','&#8330;','&#8315;','&#8331;','&#8317;','&#8318;','&#8333;','&#8334;','&#8319;','&#8305;','&frac12;','&#8531;','&frac14;','&#8533;','&#8537;','&#8539;','&#8532;','&#8534;','&frac34;','&#8535;','&#8540;','&#8536;','&#8538;','&#8541;','&#8542;','&ne;','&asymp;','&cong;','&prop;','&equiv;','&gt;','&lt;','&le;','&ge;','&plusmn;','&minus;','&times;','&divide;','&lowast;','&frasl;','&permil;','&int;','&sum;','&prod;','&radic;','&infin;','&ang;','&perp;','&prime;','&Prime;','&deg;','&there4;','&sdot;','&middot;','&part;','&image;','&alefsym;','&real;','&nabla;','&oplus;','&otimes;','&slash;','&Oslash;','&isin;','&notin;','&cap;','&cup;','&sub;','&sup;','&sube;','&supe;','&exist;','&forall;','&empty;','&not;','&and;','&or;','&loz;','&crarr;','&lceil;','&rceil;','&lfloor;','&rfloor;','&#10102;','&#10103;','&#10104;','&#10105;','&#10106;','&#10107;','&#10108;','&#10109;','&#10110;','&#10111;','&#10112;','&#10113;','&#10114;','&#10115;','&#10116;','&#10117;','&#10118;','&#10119;','&#10120;','&#10121;','&#9312;','&#9313;','&#9314;','&#9315;','&#9316;','&#9317;','&#9318;','&#9319;','&#9320;','&#9321;','&#9322;','&#9323;','&#9324;','&#9325;','&#9326;','&#9327;','&#9328;','&#9329;','&#9330;','&#9331;','&#12881;','&#12882;','&#12883;','&#12884;','&#12885;','&#12886;','&#12887;','&#12888;','&#12889;','&#12890;','&#12891;','&#12892;','&#12893;','&#12894;','&#12895;','&#12977;','&#12978;','&#12979;','&#12980;','&#12981;','&#12982;','&#12983;','&#12984;','&#12985;','&#12986;','&#9450;','&#10122;','&#10123;','&#10124;','&#10125;','&#10126;','&#10127;','&#10128;','&#10129;','&#10130;','&#10131;','&#9451;','&#9452;','&#9453;','&#9454;','&#9455;','&#9456;','&#9457;','&#9458;','&#9459;','&#9460;','&#9461;','&#9462;','&#9463;','&#9464;','&#9465;','&#9466;','&#9467;','&#9468;','&#9469;','&#9470;','&#9398;','&#9399;','&#9400;','&#9401;','&#9402;','&#9403;','&#9404;','&#9405;','&#9406;','&#9407;','&#9408;','&#9409;','&#9410;','&#9411;','&#9412;','&#9413;','&#9414;','&#9415;','&#9416;','&#9417;','&#9418;','&#9419;','&#9420;','&#9421;','&#9422;','&#9423;','&#9424;','&#9425;','&#9426;','&#9427;','&#9428;','&#9429;','&#9430;','&#9431;','&#9432;','&#9433;','&#9433;','&#9434;','&#9435;','&#9436;','&#9437;','&#9438;','&#9439;','&#9440;','&#9441;','&#9442;','&#9443;','&#9444;','&#9445;','&#9446;','&#9447;','&#9448;','&#9449;','&ntilde;','&Ntilde;','&iexcl;','&iquest;','&fnof;','&szlig;','&micro;','&auml;','&Auml;','&aring;','&Aring;','&euml;','&Euml;','&grave;','&Egrave;','&iuml;','&Iuml;','&igrave;','&Igrave;','&icirc;','&Icirc;','&ouml;','&Ouml;','&ograve;','&Ograve;','&ugrave;','&Ugrave;','&ucirc;','&Ucirc;','&uuml;','&Uuml;','&yacute;','&Yacute;','&yuml;','&Yuml;','&aelig;','&AElig;','&oelig;','&OElig;','&dagger;','&Dagger;','&scaron;','&Scaron;','&thorn;','&THORN;','&eth;','&ETH;','&alpha;','&Alpha;','&beta;','&Beta;','&gamma;','&Gamma;','&delta;','&Delta;','&epsilon;','&Epsilon;','&zeta;','&Zeta;','&eta;','&Eta;','&theta;','&Theta;','&iota;','&Iota;','&kappa;','&Kappa;','&lambda;','&Lambda;','&mu;','&Mu;','&nu;','&Nu;','&xi;','&Xi;','&omicron;','&Omicron;','&pi;','&Pi;','&rho;','&Rho;','&sigma;','&Sigma;','&sigmaf;','&tau;','&Tau;','&upsilon;','&Upsilon;','&phi;','&Phi;','&chi;','&Chi;','&psi;','&Psi;','&omega;','&Omega;','&thetasym;','&upsih;','&piv;');
			$arrSpecialCharTo   = array('xnbsp;','xaacute','xAacute','xatilde','xAtilde','xacirc','xAcirc','xagrave','xAgrave','xeacute','xEacute','xecirc','xEcirc','xiacute','xIacute','xoacute','xOacute','xotilde','xOtilde','xocirc','xOcirc','xuacute','xUacute','xccedil','xCcedil;','xamp;','','xcirc;','xtilde;','xuml;','xcute;','xcedil;','xquot;','xldquo;','xrdquo;','xlsquo;','xrsquo;','xsbquo;','xbdquo;','xordm;','xordf;','xndash;','xmdash;','xshy;','xmacr;','xlsaquo;','xrsaquo;','xldquo;','xraquo;','xhellip;','xbrvbar;','xbull;','x#8227;','xpara;','xsect;','xcopy;','xreg;','xtrade;','xpound;','xcent;','x#8357;','xeuro;','xyen;','x#8354;','x#8355;','x#8356;','x#8367;','x#8358;','x#8359;','x#8360;','x#8361;','x#8362;','x#8363;','x#8365;','x#8366;','xcurren;','xsup1;','x#8321;','xsup2;','x#8322;','xsup3;','x#8323;','x#8308;','x#8324;','x#8309;','x#8325;','x#8310;','x#8326;','x#8311;','x#8327;','x#8312;','x#8328;','x#8313;','x#8329;','x#8304;','x#8320;','x#8316;','x#8332;','x#8314;','x#8330;','x#8315;','x#8331;','x#8317;','x#8318;','x#8333;','x#8334;','x#8319;','x#8305;','xfrac12;','x#8531;','xfrac14;','x#8533;','x#8537;','x#8539;','x#8532;','x#8534;','xfrac34;','x#8535;','x#8540;','x#8536;','x#8538;','x#8541;','x#8542;','xne;','xasymp;','xcong;','xprop;','xequiv;','xgt;','xlt;','xle;','xge;','xplusmn;','xminus;','xtimes;','xdivide;','xlowast;','xfrasl;','xpermil;','xint;','xsum;','xprod;','xradic;','xinfin;','xang;','xperp;','xprime;','xPrime;','xdeg;','xthere4;','xsdot;','xmiddot;','xpart;','ximage;','xalefsym;','xreal;','xnabla;','xoplus;','xotimes;','xslash;','xOslash;','xisin;','xnotin;','xcap;','xcup;','xsub;','xsup;','xsube;','xsupe;','xexist;','xforall;','xempty;','xnot;','xand;','xor;','xloz;','xcrarr;','xlceil;','xrceil;','xlfloor;','xrfloor;','x#10102;','x#10103;','x#10104;','x#10105;','x#10106;','x#10107;','x#10108;','x#10109;','x#10110;','x#10111;','x#10112;','x#10113;','x#10114;','x#10115;','x#10116;','x#10117;','x#10118;','x#10119;','x#10120;','x#10121;','x#9312;','x#9313;','x#9314;','x#9315;','x#9316;','x#9317;','x#9318;','x#9319;','x#9320;','x#9321;','x#9322;','x#9323;','x#9324;','x#9325;','x#9326;','x#9327;','x#9328;','x#9329;','x#9330;','x#9331;','x#12881;','x#12882;','x#12883;','x#12884;','x#12885;','x#12886;','x#12887;','x#12888;','x#12889;','x#12890;','x#12891;','x#12892;','x#12893;','x#12894;','x#12895;','x#12977;','x#12978;','x#12979;','x#12980;','x#12981;','x#12982;','x#12983;','x#12984;','x#12985;','x#12986;','x#9450;','x#10122;','x#10123;','x#10124;','x#10125;','x#10126;','x#10127;','x#10128;','x#10129;','x#10130;','x#10131;','x#9451;','x#9452;','x#9453;','x#9454;','x#9455;','x#9456;','x#9457;','x#9458;','x#9459;','x#9460;','x#9461;','x#9462;','x#9463;','x#9464;','x#9465;','x#9466;','x#9467;','x#9468;','x#9469;','x#9470;','x#9398;','x#9399;','x#9400;','x#9401;','x#9402;','x#9403;','x#9404;','x#9405;','x#9406;','x#9407;','x#9408;','x#9409;','x#9410;','x#9411;','x#9412;','x#9413;','x#9414;','x#9415;','x#9416;','x#9417;','x#9418;','x#9419;','x#9420;','x#9421;','x#9422;','x#9423;','x#9424;','x#9425;','x#9426;','x#9427;','x#9428;','x#9429;','x#9430;','x#9431;','x#9432;','x#9433;','x#9433;','x#9434;','x#9435;','x#9436;','x#9437;','x#9438;','x#9439;','x#9440;','x#9441;','x#9442;','x#9443;','x#9444;','x#9445;','x#9446;','x#9447;','x#9448;','x#9449;','xntilde;','xNtilde;','xiexcl;','xiquest;','xfnof;','xszlig;','xmicro;','xauml;','xAuml;','xaring;','xAring;','xeuml;','xEuml;','xgrave;','xEgrave;','xiuml;','xIuml;','xigrave;','xIgrave;','xicirc;','xIcirc;','xouml;','xOuml;','xograve;','xOgrave;','xugrave;','xUgrave;','xucirc;','xUcirc;','xuuml;','xUuml;','xyacute;','xYacute;','xyuml;','xYuml;','xaelig;','xAElig;','xoelig;','xOElig;','xdagger;','xDagger;','xscaron;','xScaron;','xthorn;','xTHORN;','xeth;','xETH;','xalpha;','xAlpha;','xbeta;','xBeta;','xgamma;','xGamma;','xdelta;','xDelta;','xepsilon;','xEpsilon;','xzeta;','xZeta;','xeta;','xEta;','xtheta;','xTheta;','xiota;','xIota;','xkappa;','xKappa;','xlambda;','xLambda;','xmu;','xMu;','xnu;','xNu;','xxi;','xXi;','xomicron;','xOmicron;','xpi;','xPi;','xrho;','xRho;','xsigma;','xSigma;','xsigmaf;','xtau;','xTau;','xupsilon;','xUpsilon;','xphi;','xPhi;','xchi;','xChi;','xpsi;','xPsi;','xomega;','xOmega;','xthetasym;','xupsih;','xpiv;');
			//$label = html_entity_decode($label,null,'ISO-8859-1');
			$label = str_replace( $arrSpecialCharFrom,$arrSpecialCharTo,$label);
			if( preg_match('/\&/',$label) == 1)
			{
				$char = trim( substr($label,strpos($label,'&')+1,1));

				if( $char )
				{
					$obj->setProperty('shortcut','ALT+'.$char.'|'.$target);
					//$obj->setValue(preg_replace('/&/','',$label) );
					$label = preg_replace('/&/','',$label);
					$label = htmlentities( $label,null,'ISO-8859-1' );
					$label = str_replace( $arrSpecialCharTo,$arrSpecialCharFrom,$label);
					if( $obj->getFieldType() == 'tabsheet')
					{
						$obj->setValue(null,$label);
					}
					else
					{
						$obj->setValue( $label );
					}
				}
			}
		}
	}
	//-----------------------------------------------------------------------------
	/**
	* Define se o form deve redimensionar a area central da aplicação para a sua altura
	* evitando a barra de rolagem vertical dentro do iframe central e exibindo
	* a barra vertical do browser.
	*
	* @param boolean $boolNewValue
	*/
	public function setAppFitFormHeight($boolNewValue=null)
	{
		$this->appFitFormHeight = $boolNewValue;
	}

	public function getAppFitFormHeight()
	{
		return $this->appFitFormHeight;
	}

	/**
	* Define o alinhamento dos rótulos dos campos.
	* Os valores válidos são:center,left ou right.
	* O padrão é left
	*
	* @param string $strNewValue
	*/
	public function setLabelsAlign($strNewValue=null)
	{
		$this->labelsAlign = $strNewValue;
		return $this;
	}
	//-----------------------------------------------------------------------------
	public function getLabelsAlign()
	{
		return $this->labelsAlign;
	}
	//-----------------------------------------------------------------------------
	// xxx //
	/**
	 * Adiciona um campo oculto ao layout
	 *
	 * @param string $strName
	 * @param string $strValue
	 * @param boolean $boolRequired
	 * @return THidden
	 */
	public function addHiddenField( $strName, $strValue=null, $boolRequired=null )
	{
		$field = new THidden( $strName, $strValue, $boolRequired );
		$this->addDisplayControl( new TDisplayControl( null, $field, false, false ) );
		return $field;
	}
	/**
	 * Adicionar campo entrada de dados texto livre
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param integer $intMaxLength
	 * @param boolean $boolRequired
	 * @param integer $intSize
	 * @param string $strValue
	 * @param boolean $boolNewLine
	 * @param string $strHint
	 * @param string $strExampleText
	 * @param boolean $boolLabelAbove
	 * @param boolean $boolNoWrapLabel
	 * @return TEdit
	 */
	public function addTextField( $strName, $strLabel=null, $intMaxLength, $boolRequired=null, $intSize=null, $strValue=null, $boolNewLine=null, $strHint=null, $strExampleText=null, $boolLabelAbove=null, $boolNoWrapLabel=null )
	{
		$field = new TEdit( $strName, $strValue, $intMaxLength, $boolRequired, $intSize );
		$field->setHint( $strHint );
		$field->setExampleText( $strExampleText );
		$dc = $this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel,null,null,null,true) );
		return $field;
	}
	/**
	 * Adicionar campo de entrada de texto com multiplas linhas ( memo )
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param integer $intMaxLength
	 * @param boolean $boolRequired
	 * @param integer $intColumns
	 * @param integer $intRows
	 * @param boolean $boolNewLine
	 * @param boolean $boolLabelAbove
	 * @param boolean $boolShowCounter
	 * @param string $strValue
	 * @return TMemo
	 */
	public function addMemoField( $strName, $strLabel=null, $intMaxLength, $boolRequired=null, $intColumns=null, $intRows=null, $boolNewLine=null, $boolLabelAbove=null, $boolShowCounter=null, $strValue=null, $boolNoWrapLabel=null )
	{
		$field = new TMemo( $strName, $strValue, $intMaxLength, $boolRequired, $intColumns, $intRows, $boolShowCounter );
		$field->setClass( 'fwMemo' );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	 * Adicona um campo data ou mes/ano ou dia/mes de acordo com o parametro strMaxType
	 * Tipo de máscara: DMY, DM, MY
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param string $strValue
	 * @param boolean $boolRequired
	 * @param boolean $boolNewLine
	 * @param string $strMinValue
	 * @param string $strMaxValue
	 * @param string $strMaskType
	 * @param boolean $boolButtonVisible
	 * @param boolean $boolLabelAbove
	 * @return object TDate
	 */
	public function addDateField( $strName, $strLabel=null, $boolRequired=null, $boolNewLine=null, $strValue=null, $strMinValue=null, $strMaxValue=null, $strMaskType=null, $boolButtonVisible=null, $strExampleText=null, $boolLabelAbove=null, $boolNoWrapLabel=null )
	{
		$field = new TDate( $strName, $strValue, $boolRequired, $strMinValue, $strMaxValue, $strMaskType, $boolButtonVisible );
		$field->setExampleText( $strExampleText );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	* Adiciona campo tipo grupo com legenda na parte superior
	* Se o parametro $intHeight for null será auto height
	* se o parametro $intWidth for null utilizado a largura do form
	*
	* <code>
	* 	// sem quebra nos rotulos quando excederem a largura da coluna definida
	*   $frm->addGroupField('gp01','Grupo Teste');
	* 	// com quebra nos rotulos quando excederem a largura da coluna definida
	*   $frm->addGroupField('gp01','Grupo Teste',null,null,null,true);
	* </code>
	*
	*
	* @param string $strName
	* @param string $strLegend
	* @param integer $intHeight
	* @param integer $intWidth
	* @param boolean $boolNewLine
	* @param boolean $boolNoWrapLabel
	* @param boolean $boolCloseble
	* @param string $accordionId
	* @param boolean $boolOpened
	* @param string $imgOpened
	* @param string $imgClosed
	* @param boolean $boolOverflowX
	* @param boolean $boolOverflowY
	* @return TGroupBox
	*/
	public function addGroupField( $strName, $strLegend=null, $strHeight=null, $strWidth=null, $boolNewLine=null, $boolNoWrapLabel=null, $boolCloseble=null, $strAccordionId=null, $boolOpened=null, $imgOpened=null, $imgClosed=null,$boolOverflowX=null,$boolOverflowY=null )
	{

		//$strWidth = is_null($strWidth) ? $this->getMaxWidth('group') : $strWidth;
		$field = new TGroup( $strName, $strLegend, $strHeight, $strWidth,$boolCloseble,$boolOpened,$boolOverflowY,$boolOverflowX );
		$field->setAccordionId($strAccordionId);
		$this->addDisplayControl( new TDisplayControl( null, $field, false, $boolNewLine ) );
		$field->setColumns( $this->getColumns() );
		$this->currentContainer[ ] = $field;
		if( !is_null($strHeight))
		{
			$field->setOverFlowY(true);
		}
		return $field;
	}

	/**
	 * Campo de uso geral para insersão manual de códigos html na página
	 *
	 * Se os parametros width ou height não forem informados, serão
	 * definidos como "auto"
	 *
	 * Se o label for null, não será criado o espaço referente a ele no formulário, para criar
	 * um label invisível defina como "" o seu valor
	 *
	 * criado o espaço
	 * @param string $strName
	 * @param string $strLabel
	 * @param string $strValue
	 * @param string $strIncludeFile
	 * @param string $strWidth
	 * @param string $strHeight
	 * @param boolean $boolNewLine
	 * @param boolean $boolLabelAbove
	 * @return THtmlField
	 */
	public function addHtmlField( $strName, $strValue=null, $strIncludeFile=null, $strLabel=null, $strHeight=null, $strWidth=null, $boolNewLine=null, $boolLabelAbove=null, $boolNoWrapLabel=null )
	{
		//$strWidth = is_null($strWidth) ? $this->getMaxWidth('html') : $strWidth;
		$field = new THtml( $strName, $strValue, $strIncludeFile, $strHeight, $strWidth );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel, null, null, null, false ));
		return $field;
	}
	/**
	 * Cria um campo html para exibir um gride via ajax no formulário utilizando a classe TGrid
	 *
	 * @example $mixFormFields - campos do formulário que serão enviados para o grid na variavel $_POST. 'seq_x,des_x' ou array( 'seq_X'=>10, 'des_x')
	 * neste caso o valor de des_x será lido do campo do formulário
	 *
	 * @param string $strName
	 * @param string $strGridFile
	 * @param string $strHeight
	 * @param string $strWidth
	 * @param string  $strLoadingMessage
	 * @param boolean $boolNewLine
	 * @param mixed $mixFormFields
	 * @return THtml
	 */
	public function addHtmlGride( $strName, $strGridFile, $strGridId, $strHeight=null, $strWidth=null, $strLoadingMessage=null, $boolNewLine=null, $mixFormFields=null )
	{
		//$strWidth = is_null($strWidth) ? $this->getMaxWidth() : $strWidth;
		if( $strGridId )
		{
			$field = new THtml( $strName, null, null, $strHeight, $strWidth );
			$field->setGridFile( $strGridFile, $strGridId, $mixFormFields );
			$strLoadingMessage = is_null( $strLoadingMessage ) ? '<center>Carregando...<br><img width=\"190px\" height=\"20px\" src=\"' . $this->getBase() . 'imagens/processando.gif\"><center>' : $strLoadingMessage;
			$field->setLoadingMessage( $strLoadingMessage );
			$this->addDisplayControl( new TDisplayControl( null, $field, false, $boolNewLine ) );
			return $field;
		}
	}
	/**
	 * Adicionar campo CPF
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param string $strValue
	 * @param boolean $boolNewLine
	 * @param boolean $boolLabelAbove
	 * @return TCpfField
	 */
	public function addCpfField( $strName, $strLabel=null, $boolRequired=null, $strValue=null, $boolNewLine=null, $boolLabelAbove=null, $boolNoWrapLabel=null,$strInvalidMessage=null,$boolAlwaysValidate=null,$strJsCallback=null )
	{
		$field = new TCpf( $strName, $strValue, $boolRequired );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		$field->setInvalidMessage( $strInvalidMessage );
		$field->setAlwaysValidate( $boolAlwaysValidate );
		$field->setCallback( $strJsCallback );
		return $field;
	}
	/**
	 * Adicionar campo CNPJ
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param string $strValue
	 * @param boolean $boolNewLine
	 * @param boolean $boolLabelAbove
	 * @return TCnpjField
	 */
	public function addCnpjField( $strName, $strLabel=null, $boolRequired=null, $strValue=null, $boolNewLine=null, $boolLabelAbove=null, $boolNoWrapLabel=null,$strInvalidMessage=null,$boolAlwaysValidate=null,$strJsCallback=null )
	{
		$field = new TCnpj( $strName, $strValue, $boolRequired );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		$field->setInvalidMessage( $strInvalidMessage );
		$field->setAlwaysValidate( $boolAlwaysValidate );
		$field->setCallback( $strJsCallback );
		return $field;
	}
	/**
	 * Adicionar campo CPF/CNPJ
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param string $strValue
	 * @param boolean $boolNewLine
	 * @param boolean $boolLabelAbove
	 * @return TCpfCnpjField
	 */
	public function addCpfCnpjField( $strName, $strLabel=null, $boolRequired=null, $strValue=null, $boolNewLine=null, $boolLabelAbove=null, $boolNoWrapLabel=null,$strInvalidMessage=null,$boolAlwaysValidate=null,$strJsCallback=null )
	{
		$field = new TCpfCnpj( $strName, $strValue, $boolRequired );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		$field->setInvalidMessage( $strInvalidMessage );
		$field->setAlwaysValidate( $boolAlwaysValidate );
		$field->setCallback( $strJsCallback );
		return $field;
	}
	/**
	 * Adicionar campo para informar o CEP
	 *
	 * Para preenchimento automático dos campos do formulário relacionados ao endereço,
	 * informar o campo do formulário que deverá ser preenchido na lista de parametros.
	 * Exemplo: para informar o cep e preencher o campo des_endereco do formulário automaticamente, fazer assim:
	 * 	$frm->addCepField('num_cep','Cep:',true,null,null,'des_endereco');
	 * 
	 * Chama FormDin4.js getCepJquery que chama getCep.php que utiliza o serviço buscarcep.com.br 
	 * Esse serviço é pago em 13-10-2017 estava disponivel a consulta gratuida via xml
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param string $strValue
	 * @param boolean $boolNewLine
	 * @param string $strFieldEndereco
	 * @param string $strFieldBairro
	 * @param string $strFieldCidade
	 * @param string $strFieldCodidoUf
	 * @param string $strFieldSiglaUf
	 * @param string $strFieldLogradouro
	 * @param string $strFieldNumero
	 * @param string $strFieldComplemento
	 * @param string $strFieldCodigoMunicipio
	 * @param boolean $boolLabelAbove
	 * @param boolean $boolNoWrapLabel
	 * @param string $jsCallback
	 * @return TMask
	 */
	public function addCepField( $strName, $strLabel=null, $boolRequired=null, $strValue=null, $boolNewLine=null, $strFieldEndereco=null, $strFieldBairro=null, $strFieldCidade=null, $strFieldCodidoUf=null, $strFieldSiglaUf=null, $strFieldNumero=null, $strFieldComplemento=null, $strFieldCodigoMunicipio=null, $boolLabelAbove=null, $boolNoWrapLabel=null,$jsCallback=null,$jsBeforeSend=null,$boolClearIncompleteValue=null,$strIncompleteMessage=null )
	{
		$boolClearIncompleteValue = ( $boolClearIncompleteValue === false ? 'false' : 'true' );
		$field = new TMask( $strName, $strValue, '99.999-999', $boolRequired );
		$field->setFieldType( 'cep' );
		$field->addEvent( 'onBlur', 'fwValidarTamanhoCep(this,'.$boolClearIncompleteValue.',"'.$strIncompleteMessage.'")' );
		$arrFields = array( );
		$arrClearFields = array( );
		if( isset( $strFieldEndereco ) )
		{
			$arrFields[ 'endereco' ] = $strFieldEndereco;
			$arrClearFields[ ] = $strFieldEndereco;
			$arrClearValues[ ] = '';
		}
		if( isset( $strFieldBairro ) )
		{
			$arrFields[ 'bairro' ] = $strFieldBairro;
			$arrClearFields[ ] = $strFieldBairro;
		}
		/*
		  if( isset($strFieldLogradouro) )
		  {
		  $arrFields['logradouro'] = $strFieldLogradouro;
		  $arrClearFields[]=$strFieldLogradouro;
		  }
		 */
		if( isset( $strFieldCidade ) )
		{
			$arrFields[ 'cidade' ] = $strFieldCidade;
			$arrClearFields[ ] = $strFieldCidade;
		}
		if( isset( $strFieldCodidoUf ) )
		{
			$arrFields[ 'ibge_uf' ] = $strFieldCodidoUf;
			$arrClearFields[ ] = $strFieldCodidoUf;
		}
		if( isset( $strFieldNumero ) )
		{
			$arrFields[ 'numero' ] = $strFieldNumero;
			$arrClearFields[ ] = $strFieldNumero;
		}
		if( isset( $strFieldSiglaUf ) )
		{
			$arrFields[ 'uf' ] = $strFieldSiglaUf;
			$arrClearFields[ ] = $strFieldSiglaUf;
		}
		if( isset( $strFieldComplemento ) )
		{
			$arrFields[ 'complemento' ] = $strFieldComplemento;
			$arrClearFields[ ] = $strFieldComplemento;
		}
		if( isset( $strFieldCodigoMunicipio ) )
		{
			$arrFields[ 'ibge_municipio_verificador' ] = $strFieldCodigoMunicipio;
			$arrClearFields[ ] = $strFieldCodigoMunicipio;
		}
		if( count( $arrFields ) > 0 )
		{
			//$field->addEvent('onBlur','getCepJquery("'.$field->getId().'",'.json_encode($arrFields).')');
			$button = new TButton( $field->getId() . '_btn_consultar', 'Consultar', null, 'getCepJquery("' . $field->getId() . '",' . json_encode( $arrFields ) . ',' . ($jsCallback ? $jsCallback : 'null'). ',' . ($jsBeforeSend ? $jsBeforeSend : 'null').')', null, null, null, 'Infome o CEP e clique aqui para autocompletar os campos de endereço.' );
			//$button->addEvent('onclick','getCepJqueryy("'.$field->getId().'",'.json_encode($arrFields).')');
			$field->addEvent( 'onKeyUp', 'fwFieldCepKeyUp(this,event,"' . implode( ',', $arrClearFields ) . '")' );
			$field->add( $button );

		}
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel, null, null, null, true ) );
		return $field;
	}
	/**
	 * Adicionar campo tipo combobox ou menu select
	 *
	 * $mixOptions = array no formato "key=>value", nome do pacote oracle e da função a ser executada, comando sql ou tabela|condicao
	 * $strKeyColumn = nome da coluna que será utilizada para preencher os valores das opções
	 * $strDisplayColumn = nome da coluna que será utilizada para preencher as opções que serão exibidas para o usuário
	 * $strDataColumns = informações extras do banco de dados que deverão ser adicionadas na tag option do campo select
	 *
	 * <code>
	 * 	// exemplos
	 * 	$frm->addSelectField('tipo','Tipo:',false,'1=Tipo 1,2=Tipo 2');
	 * 	$frm->addSelectField('tipo','Tipo:',false,'tipo');
	 * 	$frm->addSelectField('tipo','Tipo:',false,'select * from tipo order by descricao');
	 * 	$frm->addSelectField('tipo','Tipo:',false,'tipo|descricao like "F%"');
	 * </code>
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param mixed $mixOptions
	 * @param boolean $boolNewLine
	 * @param boolean $boolLabelAbove
	 * @param mixed $mixValue
	 * @param boolean $boolMultiSelect
	 * @param integer $intSize
	 * @param integer $intWidth
	 * @param string $strFirstOptionText
	 * @param string $strFirstOptionValue
	 * @param string $strKeyField
	 * @param string $strDisplayField
	 * @return TSelect
	 */
	public function addSelectField( $strName, $strLabel=null, $boolRequired=null, $mixOptions=null, $boolNewLine=null, $boolLabelAbove=null, $mixValue=null, $boolMultiSelect=null, $intSize=null, $intWidth=null, $strFirstOptionText=null, $strFirstOptionValue=null, $strKeyColumn=null, $strDisplayColumn=null, $boolNoWrapLabel=null,$strDataColumns=null )
	{
		if( ( substr( $strName, 0, 6 ) == 'cod_uf' || $strName === 'uf') && $mixOptions === null )
		{
			$mixOptions = $this->getUfs();
		}
		else if( substr( $strName, 0, 4 ) == 'sit_' && $mixOptions === null )
		{
			$mixOptions = 'N=Não,S=Sim';
		}
		$field = new TSelect( $strName, $mixOptions, $mixValue, $boolRequired, $boolMultiSelect, $intSize, $intWidth, $strFirstOptionText, $strFirstOptionValue, $strKeyColumn, $strDisplayColumn, $strDataColumns);
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	 * Adicicionar campo tipo radiobutton
	 *
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param array $arrOptions
	 * @param boolean $boolNewLine
	 * @param boolean $boolLabelAbove
	 * @param string $strValue
	 * @param integer $intQtdColumns
	 * @param integer $intWidth
	 * @param integer $intHeight
	 * @param integer $intPaddingItems
	 */
	public function addRadioField( $strName, $strLabel=null, $boolRequired=null, $arrOptions=null, $boolNewLine=null, $boolLabelAbove=null, $strValue=null, $intQtdColumns=null, $intWidth=null, $intHeight=null, $intPaddingItems=null, $boolNoWrapLabel=null,$boolNowrapText=null )
	{
		$field = new TRadio( $strName, $arrOptions, $strValue, $boolRequired, $intQtdColumns, $intWidth, $intHeight, $intPaddingItems,$boolNowrapText);
		$field->setNoWrapText($boolNowrapText);
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		$field->addEvent('onDblclick','this.checked=false;fwFieldCheckBoxClick(this);');
		return $field;
	}
	/**
	 * Adicicionar campo tipo checkbox
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param array $arrOptions
	 * @param boolean $boolNewLine
	 * @param boolean $boolLabelAbove
	 * @param array $arrValues
	 * @param integer $intQtdColumns
	 * @param integer $intWidth
	 * @param integer $intHeight
	 * @param integer $intPaddingItems
	 * @return TCheck
	 */
	public function addCheckField( $strName, $strLabel=null, $boolRequired=null, $arrOptions=null, $boolNewLine=null, $boolLabelAbove=null, $arrValues=null, $intQtdColumns=null, $intWidth=null, $intHeight=null, $intPaddingItems=null, $boolNoWrapLabel=null ,$boolNowrapText=null)
	{
		$field = new TCheck( $strName, $arrOptions, $arrValues, $boolRequired, $intQtdColumns, $intWidth, $intHeight, $intPaddingItems );
		$field->setNoWrapText($boolNowrapText);
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	 * Adicona controle de paginação através de abas
	 * Se o parametro $intHeight for null será assumido o height do form, para ser auto, informar "auto";
	 * se o parametro $intWidth for null utilizado a largura máxima do form
	 * A função informada no parametro $strOnAfterClick e a função onBeforeClick,
	 * recebem 3 parametros: a rotulo da aba, o id do page control e o id da aba clicada em caixa baixa.
	 * Se a função onBeforeClick retornar falso, não ocorrerá a mudança de aba.
	 *
	 * @example $pc = $frm->addPageControl('pc',null,null,'pcClick','pcAfterClick');
	 * @example function pcAfterClick(aba,pageControl,id)
	 *
	 * @param mixed $strName
	 * @param mixed $strHeight
	 * @param mixed $strWidth
	 * @param mixed $strOnBeforeClick
	 * @param mixed $strOnAfterClick
	 * @param mixed $boolShowTabs
	 * @param bool $boolNewLine
	 * @return TPageControl
	 */
	public function addPageControl( $strName, $strHeight=null, $strWidth=null, $strOnBeforeClick=null, $strOnAfterClick=null, $boolShowTabs=null, $boolNewLine=null )
	{
		$boolNewLine = is_null( $strWidth ) ? true : $boolNewLine;
		$field = new TPageControl( $strName, $strHeight, $strWidth, $boolShowTabs, $strOnBeforeClick, $strOnAfterClick );
		$this->addDisplayControl( new TDisplayControl( null, $field, false, $boolNewLine ) );
		$field->setColumns( $this->getColumns() );

		/*
		if( $this->getCurrentContainer() )
		{
			$height = $this->getCurrentContainer()->getHeight();
			$field->setColumns( $this->getCurrentContainer()->getColumns() );
			if( $this->getCurrentContainer()->getFieldType()=='group')
			{
				if( !$field->getWidth())
				{
					$diff = ( $this->getCurrentContainer()->getOverflowY()=='hidden' ? 50 : 64 );
					$field->setWidth( ( $this->getCurrentContainer()->getWidth() - $diff ) );
				}
				if( $field->getHeight() )
				{   if( $field->getHeight() > $height)
					{
						$this->getCurrentContainer()->setHeight( ( $field->getHeight() + 20));
					}
				}
				else
				{
					if( $this->getCurrentContainer()->getOverflowY()=='hidden')
					{
						$field->setHeight( ( $this->getCurrentContainer()->getHeight()-47 ) );
					}
				}
			}
			else
			{
				$strHeight = is_null( $strHeight ) ? '250' : $strHeight;
				$strWidth = is_null( $strWidth ) ? $this->getCurrentContainer()->getWidth()-20 : $strWidth;
			}
		}
		else
		{
			if( is_null( $strWidth ) )
			{
				if( $this->getOverFlowY()=='hidden')
				{
					$field->setWidth( $this->getWidth()-40 );
				}
				else
				{
					$field->setWidth( $this->getWidth()-60 );
				}
			}
		}
		*/
		$this->currentContainer[ ] = $field;
		return $field;
	}
	/**
	 * Adiciona campo de entrada de dados numérico
	 *
	 * @param string $strName
	 * @param string $strValue
	 * @param integer $intMaxLength
	 * @param boolean $boolRequired
	 * @param integer $intDecimalPlaces
	 * @param boolean $boolNewLine
	 * @param boolean $boolLabelAbove
	 * @param string $strMinValue
	 * @param string $strMaxValue
	 * @param boolean $boolFormatInteger
	 * @param string $strDirection
	 * @param boolean $boolAllowZero
	 * @param boolean $boolAllowNull
	 * @param string  $strHint
	 * @return TNumber
	 */
	public function addNumberField( $strName, $strLabel=null, $intMaxLength, $boolRequired=null, $intDecimalPlaces=null, $boolNewLine=null, $strValue=null, $strMinValue=null, $strMaxValue=null, $boolFormatInteger=null, $strDirection=null, $boolAllowZero=null, $boolAllowNull=null, $boolLabelAbove=null, $boolNoWrapLabel=null, $strHint=null )
	{
		$field = new TNumber( $strName, $strValue, $intMaxLength, $boolRequired, $intDecimalPlaces, $strMinValue, $strMaxValue, $boolFormatInteger, $strDirection, $boolAllowZero, $boolAllowNull );
		if( $strHint )
		{
			$field->setHint( $strHint );
		}
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	 * Adiciona campo para entrada de endereço eletrônico - e-mail
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolNewLine
	 * @param integer $intMaxLength
	 * @param boolean $boolRequired
	 * @param integer $intSize
	 * @param string  $strValue
	 * @param boolean $boolLabelAbove
	 * @return TNumber
	 */
	public function addEmailField( $strName, $strLabel=null, $intMaxLength, $boolRequired=null, $intSize=null, $boolNewLine=null, $strValue=null, $boolLabelAbove=null, $boolNoWrapLabel=null )
	{
		$field = new TEmail( $strName, $strValue, $intMaxLength, $boolRequired, $intSize );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	 * Adiciona campo de entrada para telefone e fax
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param boolean $boolNewLine
	 * @param string $strValue
	 * @param boolean $boolLabelAbove
	 * @return TFone
	 */
	public function addFoneField( $strName, $strLabel=null, $boolRequired=null, $boolNewLine=null, $strValue=null, $boolLabelAbove=null, $boolNoWrapLabel=null )
	{
		$field = new TFone( $strName, $strValue, $boolRequired );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	 /**
	 * Adicinar campos para entrada de dados de coordenada geográfica no formato GMS ( GRAU, MIN E SEG )
	 *
	 * @param mixed $strName
	 * @param mixed $strLabel
	 * @param mixed $boolRequired
	 * @param mixed $boolNewLine
	 * @param mixed $strLatY
	 * @param mixed $strLonX
	 * @param mixed $strFieldNameLat
	 * @param mixed $strFieldNameLon
	 * @param string $strLabels - rótulos dos campos separados por virgula: ex: 'Grau:,Min:,Seg:'
	 * @param string $strSymbols - simbolo para grau, minuto e segundo separado por vígula:. ex: °,',"
	 * @param mixed $intMapHeight
	 * @param mixed $intMapWidth
	 * @param mixed $boolLabelAbove
	 * @param mixed $boolNoWrapLabel
	 * @param type $strMapHeaderText
	 * @param type $strMapHeaderFontColor
	 * @param type $strMapHeaderFontSize
	 * @return TCoordGMS
	 */
	public function addCoordGMSField( $strName, $strLabel=null, $boolRequired=null, $boolNewLine=null, $strLatY=null, $strLonX=null, $strFieldNameLat=null, $strFieldNameLon=null, $strLabels=null, $strSymbols=null, $intSymbolsFontSize=null, $intMapHeight=null, $intMapWidth=null, $boolLabelAbove=null, $boolNoWrapLabel=null,$strMapHeaderText=null,$strMapHeaderFontColor=null,$strMapHeaderFontSize=null)
	{
		$field = new TCoordGMS( $strName, $boolRequired, $strLatY, $strLonX, $strFieldNameLat, $strFieldNameLon, $strLabels, $strSymbols,$intSymbolsFontSize,$intMapHeight, $intMapWidth,$strMapHeaderText,$strMapHeaderFontColor,$strMapHeaderFontSize);
		$field->setCustomHintEnabled( $this->getCustomHintEnabled() );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	 * Campo para entrada de senhas
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param boolean $boolNewLine
	 * @param integer $intmaxLength
	 * @param string $strValue
	 * @param boolean $boolLabelAbove
	 * @param boolean $boolNoWrapLabel
	 * @param integer $intSize
	 * @param boolean $boolUseVirtualKeyboard
	 * @param boolean $boolShowVirtualKeyboardImage
	 * @param boolean $boolReadOnly
	 * @return TPassword
	 */
	public function addPasswordField( $strName, $strLabel=null, $boolRequired=null, $boolNewLine=null, $intmaxLength=null, $strValue=null, $boolLabelAbove=null, $boolNoWrapLabel=null,$intSize=null , $boolUseVirtualKeyboard=null, $boolShowVirtualKeyboardImage=null, $boolReadOnly=null )
	{
		$field = new TPassword( $strName, $strValue, $intmaxLength, $boolRequired, $intSize, $boolUseVirtualKeyboard, $boolShowVirtualKeyboardImage, $boolReadOnly);
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	 * Campo para entrada de numero de processo do serviço público
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param string $boolRequired
	 * @param string $boolNewLine
	 * @param string $strValue
	 * @param string $boolLabelAbove
	 * @return TProcesso
	 */
	public function addProcessoField( $strName, $strLabel=null, $boolRequired=null, $boolNewLine=null, $strValue=null, $boolLabelAbove=null, $boolNoWrapLabel=null )
	{
		$field = new TProcesso( $strName, $strValue, $boolRequired );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	 * Campos para anexar arquivo
	 *
	 * @param string  $strName
	 * @param string  $strLabel
	 * @param boolean $boolRequired
	 * @param integer $intFieldSize
	 * @param boolean $boolNewLine
	 * @param string  $strAllowedFileTypes
	 * @param string  $strMaxFileSize
	 * @param boolean $boolLabelAbove
	 * @param boolean $boolNoWrapLabel
	 * @return TFile / TFileAsyn
	 */
	public function addFileField( $strName, $strLabel=null, $boolRequired=null, $strAllowedFileTypes=null, $strMaxFileSize=null, $intFieldSize=null, $boolAsync=null, $boolNewLine=null, $strJsCallBack=null, $boolLabelAbove=null, $boolNoWrapLabel=null,$strMessageInvalidFileType=null )
	{
		$this->setEncType( 'multipart/form-data' );
		if( $boolAsync === false )
		{
			$field = new TFile( $strName, $intFieldSize, $boolRequired, $strAllowedFileTypes, $strMaxFileSize );
		}
		else
		{
			$field = new TFileAsync( $strName, $intFieldSize, $boolRequired, $strAllowedFileTypes, $strMaxFileSize, null, $strJsCallBack , $strMessageInvalidFileType);
		}
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel, null, null, null, true ) );
		return $field;
	}
	/**
	 * Classe para criação de campos de entrada de dados com máscara de edição
	 *
	 * a - Represents an alpha character (A-Z,a-z)
	 * 9 - Represents a numeric character (0-9)
	 * * - Represents an alphanumeric character (A-Z,a-z,0-9)
	 *
	 * @link http://digitalbush.com/projects/masked-input-plugin/
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param string $strMask
	 * @param boolean $boolNewLine
	 * @param string $strValue
	 * @param boolean $boolLabelAbove
	 * @return TMask
	 */
	public function addMaskField( $strName, $strLabel=null, $boolRequired=null, $strMask=null, $boolNewLine=null, $strValue=null, $boolLabelAbove=null, $boolNoWrapLabel=null, $strExampleText=null )
	{
		$field = new TMask( $strName, $strValue, $strMask, $boolRequired );
		$field->setExampleText( $strExampleText );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );

		return $field;
	}
	/**
	 * Campo para criação de hiperlink no formulário
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param string $strValue
	 * @param string $strOnClick
	 * @param string $strUrl
	 * @param string $strTarget
	 * @param boolean $boolNewLine
	 * @param boolean $boolLabelAbove
	 * @param boolean $boolNoWrapLabel
	 * @param string $strHint
	 * @return TLink
	 */
	public function addLinkField( $strName, $strLabel=null, $strValue=null, $strOnClick=null, $strUrl=null, $strTarget=null, $boolNewLine=null, $boolLabelAbove=null, $boolNoWrapLabel=null, $strHint=null )
	{
		$field = new TLink( $strName, $strValue, $strOnClick, $strUrl, $strTarget, $strHint );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	 * Método para criar campo de edição de horas
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param string $strMinValue
	 * @param string $strMaxValue
	 * @param string $strMask
	 * @param boolean $boolNewLine
	 * @param string $strValue
	 * @param boolean $boolLabelAbove
	 * @param boolean $boolNoWrapLabel
	 * @return TTime
	 */
	public function addTimeField( $strName, $strLabel=null, $boolRequired=null, $strMinValue=null, $strMaxValue=null, $strMask=null, $boolNewLine=null, $strValue=null, $boolLabelAbove=null, $boolNoWrapLabel=null )
	{
		$field = new TTime( $strName, $boolRequired, $strValue, $strMinValue, $strMaxValue, $strMask );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	 * Adiciona campo para seleção de cor
	 *
	 * @param string $strName
	 * @param string $strLabel
	 * @param mixed $boolRequired
	 * @param mixed $boolNewLine
	 * @param string $strValue
	 * @param boolean $boolLabelAbove
	 * @param boolean $boolNoWrapLabel
	 * @return TColorPicker
	 */
	public function addColorPickerField( $strName, $strLabel=null, $boolRequired=null, $boolNewLine=null, $strValue=null, $boolLabelAbove=null, $boolNoWrapLabel=null )
	{
		$field = new TColorPicker( $strName, $boolRequired, $strValue );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}
	/**
	 * Adicionar treeview ao formulário.
	 *
	 * @param mixed $strName
	 * @param string $strRootLabel
	 * @param mixed $arrData
	 * @param mixed $strParentFieldName
	 * @param mixed $strChildFieldName
	 * @param mixed $strDescFieldName
	 * @param mixed $strInitialParentKey
	 * @param mixed $mixUserDataFields
	 * @param bool $strHeight
	 * @param bool $strWidth
	 * @param mixed $jsOnClick
	 * @param mixed $jsOnCheck
	 * @param mixed $jsOnDrag
	 * @param mixed $boolEnableCheckBoxes
	 * @param mixed $boolEnableRadioButtons
	 * @param mixed $boolEnableTreeLines
	 * @param mixed $strLabel
	 * @param mixed $boolLabelAbove
	 * @param mixed $boolNewLine
	 * @param mixed $boolNoWrapLabel
	 * @param mixed $mixFormSearchFields
	 * @return TTreeView
	 */
	public function addTreeField( $strName, $strRootLabel=null, $arrData = null, $strParentFieldName = null, $strChildFieldName = null, $strDescFieldName = null, $strInitialParentKey=null, $mixUserDataFields = null, $strHeight = null, $strWidth = null, $jsOnClick = null, $jsOnDblClick = null, $jsOnCheck = null, $jsOnDrag = null, $boolEnableCheckBoxes = null, $boolEnableRadioButtons = null, $boolEnableTreeLines = null, $strLabel = null, $boolLabelAbove = null, $boolNewLine = null, $boolNoWrapLabel = null, $mixFormSearchFields=null )
	{
		$this->addJsFile( 'dhtmlx/dhtmlxcommon.js' );
		$this->addJsFile( 'dhtmlx/treeview/dhtmlxtree.js' );
		$this->addCssFile( 'dhtmlx/treeview/dhtmlxtree.css' );
		/*
		if( $this->getCurrentContainer() )
		{
			if( $this->getCurrentContainer()->getFieldType()=='group')
			{
				$strHeight = is_null( $strHeight ) ? '250' : $strHeight;
				$strWidth = is_null( $strWidth ) ? $this->getCurrentContainer()->getWidth()-30 : $strWidth;
				if( $this->getCurrentContainer()->getHeight() < $strHeight )
				{
					$this->getCurrentContainer()->setHeight(( 50+ $strHeight ));
				}
			}
			else
			{
				$strHeight = is_null( $strHeight ) ? '250' : $strHeight;
				$strWidth = is_null( $strWidth ) ? $this->getCurrentContainer()->getWidth()-20 : $strWidth;
			}
		}
		else
		{
			$strHeight = is_null( $strHeight ) ? '250' : $strHeight;
			$strWidth = is_null( $strWidth ) ? $this->getWidth() - 40 : $strWidth;
		}
		$strHeight = is_null( $strHeight ) ? '250' : $strHeight;
		$strWidth = is_null( $strWidth ) ? $this->getWidth() - 40 : $strWidth;
		 *
		 */
		$tree = new TTreeView( $strName, $strRootLabel, $arrData, $strParentFieldName, $strChildFieldName, $strDescFieldName, $strInitialParentKey, $mixUserDataFields, $strHeight, $strWidth, $jsOnClick, $jsOnDblClick, $jsOnCheck, $jsOnDrag, $boolEnableCheckBoxes, $boolEnableRadioButtons, $boolEnableTreeLines, $mixFormSearchFields );
		//$tree->addItem(0,1,'Animal',true,'Animais');
		$this->addDisplayControl( new TDisplayControl( $strLabel, $tree, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $tree;
	}
	/**
	 * Permite abrir uma tag html entre os campos do formulário. Utilizado para criar áreas ou grupos de campos
	 * para que sejam exibidos/escondidos em conjunto ou delimitados por bordas ou cor de fundo diferentes
	 *
	 * Exemplo:  $t = $frm->addTag('<div>'); // para abrir
	 * 			$t->setCss('border','1px solid blue');
	 * 			conteudo.......
	 * 			$t = $frm->addTag('</div>'); // para fechar
	 * @param string $strTagType
	 * @param string $strId
	 * @return mull
	 */
	public function addTag( $strTagType, $strId = null,$boolNewLine=null )
	{
		$field = new TTag( $strTagType, $strId );
		$boolNewLine = is_null( $boolNewLine ) ? false : $boolNewLine;
		$this->addDisplayControl( new TDisplayControl( null, $field, false, $boolNewLine ) );
		return null;
	}
	/**
	 * Este método foi substitituido pelo addTag()
	 */
	public function openTag( $strTagType, $strId=null )
	{
		//$this->addTag($strTagType,$strId);
	}
	/**
	 * Este método foi substitituido pelo addTag()
	 */
	public function closeTag()
	{
		// não será mais necessário, utilizar o metodo metodo addTag() para adicionar a tag de fechamento
	}
	/**
	 * Adiciona campo para exibição de texto ou imagen dentro de um box modal
	 *
	 * <code>
	 * $frm->addBoxField('campo_1','Informe o nome completo',$this->getBase().'imagens/folder.gif',null,null,null,null,null,null,'Ajuda');
	 * $frm->addBoxField('campo_2',null,$this->getBase().'exemplos/ajuda.html','ajax',null,null,null,null,null,'Ver arquivo de ajuda');
	 * $frm->addBoxField('campo_3','Este é o texto de ajuda que será exibido quando o usuário clicar na imagem',null,null,null,null,null,null,null,'Exibir ajuda');
	 * $frm->addBoxField('campo_4',null,$this->getBase()."js/jquery/facebox/stairs.jpg",'jpg','Visualizar Foto:','folder.gif',true,null,null,'Imagem');
	 * </code>
	 *
	 * @param mixed $strId - identificador do campo
	 * @param mixed $strText - texto para exibição
	 * @param mixed $strFileName - nome do arquivo que será carregado dentro do box
	 * @param mixed $strDataType - define o conteudo que será carregado. Ex: image, ajax
	 * @param mixed $strLabel - rótulo do campo
	 * @param mixed $strImage - imagem que aparecerá na frente do label
	 * @param bool $boolNewLine - true ou false se o campo será colocado na frente ou abaixo do último campo adicionado ao formulário
	 * @param mixed $boolLabelAbove - true ou false para alterar o layout do rótulo para cima ou na frente da imagem
	 * @param mixed $boolNoWrapLabel - true ou false para quebrar ou não o valor do label se não couber na coluna do formulario
	 * @param mixed $strHint - texto de ajuda que será exibido ao posicinar o mouse sobre a imagem
	 */
	public function addBoxField( $strId, $strText=null, $strFileName=null, $strDataType=null, $strLabel=null, $strImage=null, $boolNewLine=null, $boolLabelAbove=null, $boolNoWrapLabel=null, $strHint=null )
	{
		$boolNewLine = is_null( $boolNewLine ) ? false : $boolNewLine; // o padrão é false
		$field = new THelpBox( $strId, $strText, $strFileName, $strDataType, $strImage, $strHint );
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel, 'bottom' ) );
		return null;
	}
	public function addCaptchaField( $strName, $strLabel=null, $hint=null,$intCaracters=null )
	{
		$field = new TCaptcha( $strName, $hint, $intCaracters );
		
		$strLabel = isset($strLabel) ? $strLabel : null;
		$field    = isset($field) ? $field : null;
		$boolLabelAbove= isset($boolLabelAbove) ? $boolLabelAbove : null;
		$boolNewLine   = isset($boolNewLine) ? $boolNewLine : null;
		$boolNoWrapLabel = isset($boolNoWrapLabel) ? $acao : null;
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel, null, null, null, true ) );
		return $field;
	}
	/**
	 * Adiciona no form uma area para mostrar as mensagens ao usuario identica as mensagens do topo do form
	 * diferenciando que nesta pode-se definir a mensagem em qualquer lugar do form e será exibida com a mesma formatação da padrão
	 * <code>
	 *		$frm->addMessageField('msg_local');
	 * 		<script> fwShowMessage({message:"Mensagem em local especifico<br>Linha2<br>linha3","containerId":"msg_local"});</script>
	 *	</code>
	 *
	 * @param string $strName Nome do campos mensagem
	 * @return THtml
	 */
	public function addMessageField( $strName=null,$intHeight=null )
	{
		$field 	= $this->addHtmlField( $this->getId().'_'.$strName. '_msg_area','');
			$field->setCss( 'visibility', 'visible' );
			$field->setCss('width','0px');
		$btn 	= new TButton( 'btn_close_' .$this->getId() .'_'.$strName.'_msg_area', 'Fechar', null, 'fwHideMsgArea("'.$this->getId() .'_'.$strName.'")', null, 'fwbtnclosered.jpg', null, 'Fechar mensagem' );
			$btn->setCss( 'float', 'right' );
			$btn->setCss( 'cursor', 'pointer' );
			$btn->setCss('visibility','visible');
		$field->add( $btn );
		$field->add( '<div id="' .$this->getId() .'_'.$strName. '_msg_area_content' . '"></div>' );
		return $field;
	}
	/**
	 * Campo para seleção de Diretório ou Pasta
	 * @param type $strName
	 * @param type $rootDir
	 * @param type $strValue
	 * @param type $intMaxLength
	 * @param type $boolRequired
	 * @param type $intSize
	 * @param type $boolLabelAbove
	 * @param type $boolNewLine
	 * @return TOpenDir
	 */
	public function addOpenDirField( $strName, $strLabel=null, $rootDir=null, $strValue=null, $intMaxLength=null, $boolRequired=null, $intSize=null, $strTitle=null, $strJsCallBack=null, $boolLabelAbove=null, $boolNewLine=null)
	{
		$field = new TOpenDir( $strName, $rootDir, $strValue, $intMaxLength, $boolRequired, $intSize, $strTitle, $strJsCallBack);
		$boolNoWrapLabel = isset($boolNoWrapLabel) ? $boolNoWrapLabel : null;
		$TDisplayControl = new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel, null, null, null, true );
		$this->addDisplayControl( $TDisplayControl );
		return $field;
	}
	/**
	* Campo para seleção de fuso horário
	*
	* @param string $strName
	* @param string $strLabel
	* @param boolean $boolRequired
	* @param boolean $boolNewLine
	* @param boolean $boolLabelAbove
	* @param mixed $mixValue
	* @param integer $intSize
	* @param integer $intWidth
	* @param string $strFirstOptionText
	* @param string $strFirstOptionValue
	* @param boolean $boolNoWrapLabel
	* @return TTimeZone
	*/
	public function addTimeZoneField( $strName, $strLabel=null, $boolRequired=null,$boolNewLine=null, $boolLabelAbove=null, $mixValue=null, $intSize=null, $intWidth=null, $strFirstOptionText=null, $strFirstOptionValue=null, $boolNoWrapLabel=null )
	{
		$field = new TTimeZone( $strName, $mixValue, $boolRequired, $intSize, $intWidth, $strFirstOptionText, $strFirstOptionValue);
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}

	/**
	 * Adiciona um editor de texto (CKEDITOR)
	 * @author Daniel Andrade
	 * @param string $strName
	 * @param string $strLabel
	 * @param boolean $boolRequired
	 * @param boolean $boolNewLine
	 * @param boolean $boolLabelAbove
	 * @param string $strValue
	 * @param boolean $boolNoWrapLabel
	 * @return TTextEditor
	 */
	public function addTextEditorField( $strName, $strLabel=null, $boolRequired=null, $boolNewLine=null, $strValue=null, $boolLabelAbove=null, $boolNoWrapLabel=true )
	{
		$field = new TTextEditor( $strName, $strValue, null, $boolRequired, null, null, false );
		$field->setClass( 'ckeditor' );
		$field->setCss('height','0px');
		$this->addJsFile('ckeditor/ckeditor.js');
		$this->addDisplayControl( new TDisplayControl( $strLabel, $field, is_null($boolLabelAbove) ? true : $boolLabelAbove, $boolNewLine, $boolNoWrapLabel ) );
		return $field;
	}

	/**
	* Criação de campo calendário de eventos tipo agenda
	*
	* @param string $strName
	* @param string $strUrl
	* @param string $strHeight
	* @param string $strWidth
	* @param mixed $defaultView
	* @param string $jsOnResize
	* @param string $jsOnDrag
	* @param string $jsOnDrop
	* @param string $jsOnEventClick
	* @param string $jsOnSelectDay
	* @param string $jsMouseOver
	* @return TCalendar
	*/
	public function addCalendarField( $strName, $strUrl=null,  $strHeight=null, $strWidth=null, $defaultView=null, $jsOnResize=null, $jsOnDrag=null, $jsOnDrop=null, $jsOnEventClick=null, $jsOnSelectDay=null, $jsMouseOver=null, $jsEventRender=null )
	{
		if( !DEFINED('INDEX_FILE_NAME') )
		{
			DEFINE('INDEX_FILE_NAME','index.php');
		}
		if( ! is_null($strUrl) )
		{
			$strUrl = INDEX_FILE_NAME.'?ajax=1&modulo='.$strUrl;
		}
		$field = new TCalendar($strName, $strUrl,  $strHeight, $strWidth, $defaultView, $jsOnResize, $jsOnDrag, $jsOnDrop, $jsOnEventClick, $jsOnSelectDay, $jsMouseOver, $jsEventRender);
		$field->setClass( 'fwCalendar',false );
		$this->addDisplayControl( new TDisplayControl( null, $field, false,true,true  ) );
		return $field;
	}
}
?>