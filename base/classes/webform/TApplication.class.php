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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License version 3
 * along with this program; if not, see <http://www.gnu.org/licenses/>
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301, USA.
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
if (! defined ( 'DS' )) {
	define ( 'DS', DIRECTORY_SEPARATOR );
}
$currentl_dir = dirname ( __FILE__ );

require_once ($currentl_dir . DS . '..' . DS . 'constants.php');

$helps_dir = $currentl_dir . DS . '..' . DS . 'helpers' . DS;
require_once ($helps_dir . 'ArrayHelper.class.php');
require_once ($helps_dir . 'GetHelper.class.php');
require_once ($helps_dir . 'PaginationSQLHelper.class.php');
require_once ($helps_dir . 'PostHelper.class.php');
require_once ($helps_dir . 'RequestHelper.class.php');
require_once ($helps_dir . 'ServerHelper.class.php');

include_once ('autoload_formdin.php');
class TApplication extends TLayout {
	private $strTitle;
	private $strTitleTag;
	private $strSubtitle;
	private $strSigla;
	private $strUnit;
	private $strVersionSystem;
	private $defaultModule;
	private $showMenu;
	private $connectionFile;
	private $loginFile;
	private $mainMenuFile;
	private $configFile;
	private $includeFiles;
	private $waterMark;
	private $backgroundImage;
	private $backgroundRepeat;
	private $backgroundPosition;
	private $cssFile;
	private $loginInfo;
	private $headerContent;
	private $footerContent;
	private $bodyContent;
	private $horizontalAlign;
	private $verticalAlign;
	private $cellLogin;
	private $cellHeader;
	private $cellLogo;
	private $loCenter; // instância do LayoutCenter
	private $beforeActionFunction;
	private $width;
	private $onGetLoginInfo;
	private $menuIconsPath;
	private $headerBgImage;
	private $headerBgRepeat;
	private $footerBgImage;
	private $footerBgRepeat;
	private $menuTheme;
	private $onBeforeLogin;
	
	/**
	 * classe para criação da aplicação
	 *
	 * @param string $strTitle
	 * @param string $strSubtitle
	 * @param string $strSigla
	 * @param string $strUnit
	 * @return TApplication
	 */
	public function __construct($strTitle = null, $strSubtitle = null, $strSigla = null, $strUnit = null, $intWidth = null, $charSet = null) {
		ini_set ( 'xdebug.max_nesting_level', 150 );
		date_default_timezone_set ( 'America/Sao_Paulo' );
		
		$this->includePathDao();
		$this->includePathClasses();
		
		session_start ();
		
		// desenv: error_reporting( E_ALL | E_STRICT );
		// error_reporting( E_ALL | E_STRICT );
		parent::__construct ( 'app', 50, 20 ); // criar layout com norte=50px e sul=20px
		$this->setPadding ( 0 );
		// criar o layout central com area de menu 30px e o iframe central
		$this->loCenter = new TLayout ( 'loCenter', 30 );
		$this->loCenter->setPadding ( '0px' );
		$this->loCenter->getCenterArea ()->setTagType ( 'iframe' );
		$this->loCenter->getCenterArea ()->setId ( 'app_iframe' );
		$this->loCenter->getNorthArea ()->setId ( 'div_main_menu' );
		$this->loCenter->setNorthInitClosed ( false );
		$this->addLayout ( $this->loCenter, 'C' );
		
		$this->setTitle ( $strTitle );
		$this->setSubtitle ( $strSubtitle );
		$this->setUnit ( $strUnit );
		$this->setSigla ( $strSigla );
		$this->setShowMenu ( true );
		
		// arquivo css padrão localizado na base base/css
		$this->addCssFile ( 'app.css' );
		$this->setBackgroundImage ( $this->getBase () . '/css/imagens/app/bg_listrado.jpg' );
		
		// biblioteca de funções geral
		$this->addIncludeFile ( $this->getBase () . 'includes/funcoes.inc' );
	}

	private function includePathClasses() {
		if (file_exists ( 'classes/' )) {
			$this->includePath ( 'classes/' );
		}
	}

	private function includePathDao() {
		if (file_exists ( 'dao/' )) {
			$this->includePath ( 'dao/' );
		}
	}

	public function setTitle($strNewValue = null) {
		$this->strTitle = $strNewValue;
	}
	public function getTitle() {
		if (is_null ( $this->strTitle ) && defined ( 'TITULO_SISTEMA' )) {
			return TITULO_SISTEMA;
		}		
		return $this->strTitle;
	}
	/**
	 * Define a tag <title> da página que aparecerá na aba do browser
	 *
	 * @param string $strNewValue
	 */
	public function setTitleTag($strNewValue = null) {
		$this->strTitleTag = $strNewValue;
	}
	public function getTitleTag() {
		if (is_null ( $this->strTitleTag ) && defined ( 'APLICATIVO' )) {
			return APLICATIVO;
		}
		return $this->strTitleTag;
	}
	public function setSubtitle($strNewValue) {
		$this->strSubtitle = $strNewValue;
	}
	public function getSubtitle() {
		return $this->strSubtitle;
	}
	public function setSigla($strNewValue) {
		$this->strSigla = $strNewValue;
		if (! $this->getTitleTag ()) {
			$this->setTitleTag ( $this->strSigla );
		}
	}
	public function getSigla() {
		if (is_null ( $this->strSigla )) {
			if (! $this->getHeaderBgImage ()) {
				$this->setSigla ( APLICATIVO );
			}
		}
		if (! $this->strSigla) {
			return null;
		}
		if (preg_match ( '/</', strtolower ( $this->strSigla ) )) {
			return $this->strSigla;
		} else if (preg_match ( '/jp?|gif|png|bmp/', $this->strSigla )) {
			if (file_exists ( $this->strSigla )) {
				return '<img src="' . $this->strSigla . '">';
			}
			
			// procurar na pasta includes/imagens da apliacao e na base/
			if (file_exists ( $this->getRoot () . 'imagens/' . $this->strSigla )) {
				return '<img src="' . $this->getRoot () . 'imagens/' . $this->strSigla . '">';
			} else if (file_exists ( $this->getBase () . 'imagens/' . $this->strSigla )) {
				return '<img src="' . $this->getBase () . 'imagens/' . $this->strSigla . '">';
			}
		} else {
			return $this->strSigla;
		}
	}
	public function setUnit($strNewValue = null) {
		$this->strUnit = $strNewValue;
	}
	public function getUnit() {
		return $this->strUnit;
	}
	public function setVersionSystem($strVersionSystem = null) {
		$this->strVersionSystem = $strVersionSystem;
	}
	public function getVersionSystem() {
		return $this->strVersionSystem;
	}
	
	/**
	 * Permite ocultar ou exibir o menu principal da aplicação
	 */
	public function setShowMenu($boolNewValue = null) {
		$boolNewValue = is_null ( $boolNewValue ) ? true : $boolNewValue;
		$this->showMenu = $boolNewValue;
	}
	public function getShowMenu() {
		return $this->showMenu;
	}
	
	/**
	 * Este método inicializa a aplicação e cria a interface da aplicação.
	 * Se for passado o modulo ele apenas inclui módulo e sai funcionando como o modulo ler_modulo.php antigo
	 */
	public function run() {
		ini_set ( 'default_charset', $this->getCharset() );
		ob_start (); // arquivos includes podem conter espaços no final que causam erros nas chamadas ajax
			$this->checkIfExistConfigFile();
		ob_clean ();
		$this->defineConstantAplicativo();		
		$this->defineConstantSystemTitle();
		$this->includesAppAction();
		$this->setOnPostModuloAndAction();
		
		// ******************************************************************************************
		$this->processRequest (); // se existir modulo postado, a aplicação termina nesta linha senão cria a tela básica do aplicativo
		// ******************************************************************************************
		
        $this->clearTempFiles();
		
		if (! $this->getLoginFile () && ! $this->getMainMenuFile () && ! $this->getDefaultModule ()) {
			$_SESSION [APLICATIVO] = null;
		}
		
		if ($this->getWidth ()) {
			$e = new TElement ( 'div' );
			$e->setCss ( $this->getCss () );
			$e->SetCss ( array (
					'background-color' => 'transparent',
					'height' => '100%',
					'margin' => '0 auto',
					'widht' => '100%',
					'max-width' => $this->getWidth () . 'px',
					'min-width' => '700px',
					'_width' => '700px' 
			) );
			
			$this->setContainer ( $e );
		}
		
		// css
		if ($this->getHeaderBgImage ()) {
			// sobrescrever as definições do app.css
			$this->addStyle ( '#app_header_title{background	:transparent;}' );
			$this->addStyle ( '#app_header_login{background	:transparent;}' );
			$this->addStyle ( '#app_header_logo{background	:transparent;}' );
			
			if ($this->getNorthArea ()) {
				// definir a imagem de fundo do cabecalho
				$this->getNorthArea ()->setCss ( 'background-image', "url('" . $this->getHeaderBgImage () . "')" );
				$this->getNorthArea ()->setCss ( 'background-position', "50% 50%" );
				$this->getNorthArea ()->setCss ( 'border', "0px" );
				if (is_null ( $this->getHeaderBgRepeat () )) {
					if (function_exists ( 'getimagesize' ) && file_exists ( $this->getHeaderBgImage () )) {
						
						list ( $width, $height ) = getimagesize ( $this->getHeaderBgImage () );
						if ($width < 30) {
							$this->getNorthArea ()->setCss ( 'background-repeat', 'repeat-x' );
						}
					}
				} else {
					$this->getNorthArea ()->setCss ( 'background-repeat', $this->getHeaderBgRepeat () );
				}
			}
		}
		if ($this->getFooterBgImage ()) {
			// sobrescrever as definições do app.css
			$this->addStyle ( '#app_footer_message{background	:transparent;}' );
			$this->addStyle ( '#app_footer_company{background	:transparent;}' );
			$this->addStyle ( '#app_footer_module{background	:transparent;}' );
			
			if ($this->getSouthArea ()) {
				// definir a imagem de fundo do cabecalho
				$this->getSouthArea ()->setCss ( 'background-image', "url('" . $this->getFooterBgImage () . "')" );
				$this->getSouthArea ()->setCss ( 'background-position', "50% 50%" );
				$this->getSouthArea ()->setCss ( 'border', "0px" );
				if (is_null ( $this->getFooterBgRepeat () )) {
					if (function_exists ( 'getimagesize' ) && file_exists ( $this->getFooterBgImage () )) {
						
						list ( $width, $height ) = getimagesize ( $this->getFooterBgImage () );
						if ($width < 30) {
							$this->getSouthArea ()->setCss ( 'background-repeat', 'repeat-x' );
						}
					}
				} else {
					$this->getSouthArea ()->setCss ( 'background-repeat', $this->getFooterBgRepeat () );
				}
			}
		}
		if ($this->getTitleTag ()) {
			parent::setTitle ( $this->getTitleTag () );
		}
		
		
		$this->setJavaScriptCss();
		
		if ($this->getLoginDone ()) {
			// montar o cabeçalho da pagina
			$this->buildPageHeader ();
			
			$btnLogOut = '';
			
			// montar o rodapé da pagina
			$this->buildPageFooter ();
			
			if (isset ( $this->cellLogin )) {
				// exibir o botão de ecerrar a sessão somente se existir tela de login definida
				if ($this->getLoginFile ()) {
					$btnLogOut = '<input id="button_end_session" type="button" value="Encerrar Sessão" onclick="app_login(1,\'' . $this->getLoginFile () . '\')">';
				}
				if ($this->getLoginInfo ()) {
					$this->cellLogin->add ( $this->getLoginInfo () );
				} else if (isset ( $_SESSION [APLICATIVO] ["login"] ["num_cpf"] ) && $_SESSION [APLICATIVO] ["login"] ["num_cpf"]) {
					$this->cellLogin->add ( 'CPF:' . formatar_cpf_cnpj ( $_SESSION [APLICATIVO] ["login"] ["num_cpf"] ) . '<br/>' . $_SESSION [APLICATIVO] ["login"] ["nom_pessoa"] );
				}
				
				if (preg_match ( '/<input/i', $this->getLoginInfo () ) == 0) {
					$this->cellLogin->add ( '<br/>' . $btnLogOut );
				}
			} else {
				$this->cellHeader->clearChildren (); // limpar a celula da tabela
				$this->cellHeader->add ( $this->getHeaderContent () );
			}
		} else {
			// montar o cabeçalho da pagina
			$this->buildPageHeader ();
			
			// montar o rodapé da pagina
			$this->buildPageFooter ();
			
			// $this->loCenter->setNorthInitClosed(true); // não mostrar a área de menu
			if ($this->getLoginInfo () && isset ( $this->cellLogin )) {
				$this->cellLogin->add ( $this->getLoginInfo () );
			}
			
			if ($this->getLoginFile ()) {
				if (file_exists ( $this->getLoginFile () )) {
					$this->addJavascript ( 'app_login(false,"' . $this->getLoginFile () . '","' . addslashes ( $this->getLoginInfo () ) . '")' );
				} else {
					$this->addJavascript ( 'alert("Tela de login:' . $this->getLoginFile () . ', defindo para a aplicação, não existe.")' );
				}
				
				$this->show ();
				exit ();
			}
		}
		
		if ($this->getShowMenu ()) {
			if ($this->getMainMenuFile ()) {
				if (file_exists ( $this->getMainMenuFile () )) {
					$this->addJavascript ( 'try{app_main_menu = new dhtmlXMenuObject("div_main_menu",menuTheme);}catch(e){alert( "Erro no menu. Não foi possível instanciar a classe dhtmlXMenuObject.\t"+e.message)}' );
					$this->addJavascript ( 'app_build_menu(false,null,"' . $this->getMainMenuFile () . '")' );
				} else {
					$this->addJavascript ( 'alert("Módulo de menu:' . $this->getMainMenuFile () . ', defindo para a aplicação, não existe.")' );
				}
			}
		}
		
		// se pressionar F5, recarregar o ultimo módulo solicitado
		$loadModule = null;
		if (isset ( $_SESSION [APLICATIVO] ['modulo'] ) && $_SESSION [APLICATIVO] ['modulo']) {
			
			if ($_SESSION [APLICATIVO] ['modulo'] != $this->getLoginFile ()) {
				// $this->addJavascript( '//se pressionar F5, recarregar o ultimo módulo solicitado' );
				$loadModule = $_SESSION [APLICATIVO] ['modulo'];
				// $this->addJavascript( 'app_load_module("' . $_SESSION[ APLICATIVO ][ 'modulo' ] . '")' );
			}
		}
		if (! $loadModule) {
			if ($this->getDefaultModule ()) {
				$loadModule = $this->getDefaultModule ();
				$this->addJavascript ( 'var app_default_module="' . $this->getDefaultModule () . '";' );
				// $this->addJavascript( 'app_load_module("' . $this->getDefaultModule() . '")' );
			} else {
				// desenhar o background e marca dagua
				// $this->addJavascript( 'app_load_module("about:blank")' );
				$loadModule = 'about:blank';
			}
		}
		if ($loadModule) {
			$this->addJavascript ( 'app_load_module("' . $loadModule . '")' );
		}
		$this->show ();
	}
	
	/**
	 * 
	 */
	 private function setOnPostModuloAndAction() {
		if ($this->getBeforeActionFunction()) {
			$this->includeConnectionFile();
			$action = null;
			$module = null;
			if (isset ( $_REQUEST ['modulo'] )) {
				$module = $_REQUEST ['modulo'];
			} else if (isset ( $_POST ['modulo'] )) {
				$module = $_POST ['modulo'];
			}
			if (isset ( $_POST ['formDinAcao'] )) {
				$action = $_POST ['formDinAcao'];
			}
			$params = ( object ) array (
					'module' => $module,
					'action' => $action 
			);
			if (! call_user_func ( $this->getBeforeActionFunction (), $this, $params )) {
				exit ();
			}
			$module = $params->module;
			$action = $params->action;
			// echo 'Novo:'.$module.',';
			$_REQUEST ['modulo'] = $module;
			$_POST ['modulo'] = $module;
			$_POST ['formDinAcao'] = $action;
		}
	 }
	 
	 private function setJavaScriptCss() {
		// $this->addJsCssFile('greybox/gb_styles.css');
		// $menuTheme = 'clear_silver'; // Estilos válidos: standard,aqua_dark,aqua_sky,aqua_orange,clear_blue,clear_green,dhx_black,dhx_blue,glassy_blue,modern_black,modern_blue,modern_red,clear_silver
		// $menuTheme = 'aqua_dark'; // Estilos válidos: standard,aqua_dark,aqua_sky,aqua_orange,clear_blue,clear_green,dhx_black,dhx_blue,glassy_blue,modern_black,modern_blue,modern_red,clear_silver
		// $menuTheme = 'aqua_orange'; // Estilos válidos: standard,aqua_dark,aqua_sky,aqua_orange,clear_blue,clear_green,dhx_black,dhx_blue,glassy_blue,modern_black,modern_blue,modern_red,clear_silver
		// $menuTheme = 'aqua_sky'; // Estilos válidos: standard,aqua_dark,aqua_sky,aqua_orange,clear_blue,clear_green,dhx_black,dhx_blue,glassy_blue,modern_black,modern_blue,modern_red,clear_silver
		// $menuTheme = 'aqua_sky'; // Estilos válidos: standard,aqua_dark,aqua_sky,aqua_orange,clear_blue,clear_green,dhx_black,dhx_blue,glassy_blue,modern_black,modern_blue,modern_red,clear_silver
		// $menuTheme = 'clear_blue'; // Estilos válidos: standard,aqua_dark,aqua_sky,aqua_orange,clear_blue,clear_green,dhx_black,dhx_blue,glassy_blue,modern_black,modern_blue,modern_red,clear_silver
		// $menuTheme = 'clear_green'; // Estilos válidos: clear_green,dhx_black,dhx_blue,glassy_blue,modern_black,modern_blue,modern_red,clear_silver
		
		// ajustar css. o height do item pricipal esta muito pequeno
		// $menuTheme = 'dhx_black'; // dhx_blue,glassy_blue,modern_black,modern_blue,modern_red,clear_silver
		// $menuTheme = 'dhx_blue'; // dhx_blue,glassy_blue,modern_black,modern_blue,modern_red,clear_silver
		
		// estes estão com o funco combinando com o tema, ver como fazer para os outros que estão cinza
		// $menuTheme = 'glassy_blue'; // glassy_blue,modern_black,modern_blue,modern_red,clear_silver
		
		// heihght ok, falta o fundo na cor do thema
		// $menuTheme = 'modern_black'; // modern_blue,modern_red,clear_silver
		// $menuTheme = 'modern_blue'; // modern_red,clear_silver
		// $menuTheme = 'modern_red';
		// $menuTheme = 'standard';
		
		// javascript
		$this->addJsCssFile ( 'dhtmlx/dhtmlxcommon.js' );
		$this->addJsCssFile ( 'dhtmlx/menu/dhtmlxmenu_cas.js' );
		
		// o nome do estilo tem que ser alterado no arquivo app.js tambem
		$this->addJavascript ( "app_layout=true;" );
		$this->addJavascript ( "pastaBase='{$this->getBase()}';" );
		$this->addJavascript ( 'GB_ROOT_DIR 	= pastaBase+\'js/greybox/\';' );
		$this->addJavascript ( "menuTheme='{$this->getMenuTheme()}';" );
		$this->addJavascript ( "menuIconsPath='" . $this->getMenuIconsPath () . "';" );
		$this->addJavascript ( "aplicativo='" . APLICATIVO . "';" );
		$this->addJavascript ( "marca_dagua='" . $this->getWaterMark () . "';" );
		$this->addJavascript ( "background_image='" . $this->getBackgroundImage () . "';" );
		$this->addJavascript ( "background_repeat='" . $this->getBackgroundRepeat () . "';" );
		$this->addJavascript ( "background_position='" . $this->getBackgroundPosition () . "';" );
		$this->addJsCssFile ( $this->getBase () . 'js/dhtmlx/menu/skins/' . $this->getMenuTheme() . '/' . $this->getMenuTheme() . '.css' );
		$this->addJsCssFile ( 'app.js' );
		
		$this->addJsCssFile ( $this->getCssFile () );
		$this->addJsCssFile ( 'FormDin4.css' );
		
		// arquivo js que será carregado por último se existir
		$this->addJsCssFile ( 'js/main.js' );
		
		// arquivo css que será carregado por último se existir
		$this->addJsCssFile ( 'css/main.css' );
		
		/*
		 * $this->addJsCssFile( 'jquery/jquery.js' );
		 * $this->addJsCssFile( 'jquery/jquery.corner.js' );
		 * $this->addJsCssFile( 'jquery/jAlert/jquery.alerts.js' );
		 * $this->addJsCssFile( 'jquery/jAlert/jquery.alerts.css' );
		 * $this->addJsCssFile( 'lazyload/lazyload-min.js' );
		 */
		
		if (! $this->getShowMenu ()) {
			$this->addJavascript ( 'showMenu = false;' );
		} else {
			$this->addJavascript ( 'showMenu = true;' );
		}
		
		$this->addJavascript ( 'app_init()' );
	}

	
	/**
	 * Limpar arquivos temporários mas de 2 dias
	 */
	private function clearTempFiles() {
		// $h=opendir(getcwd().'/../tmp');
		$tmpDir = preg_replace ( '/\/\//', '/', $this->getBase () . '/tmp/' );
		if (is_dir ( $tmpDir )) {
			$h = opendir ( $tmpDir );
			if ($h) {
				$t = time (); // agora
				while ( $filetmp = readdir ( $h ) ) {
					if ($filetmp != '.' && $filetmp != '..') {
						$filepath = $tmpDir . $filetmp;
						if (! is_dir ( $filepath ) && file_exists ( $filepath )) {
							$lastModified = @filemtime ( $filepath );
							if ($lastModified == NULL)
								$lastModified = @filemtime ( utf8_decode ( $filepath ) );
							if ($lastModified) {
								// 172800 seconds = 2 dias
								if ($t - $lastModified > 172800) {
									@unlink ( $filepath );
								}
							}
						}
					}
				}
				closedir ( $h );
			}
		}
	}

	
	/**
	 * adicionar os arquivos definidos no setIncludeFile()
	 * @codeCoverageIgnore
	 */
	private function checkIfExistConfigFile() {
		if ($this->getIncludeFiles ()) {
			foreach ( $this->getIncludeFiles () as $k => $v ) {
				if (file_exists ( $v )) {
					require_once ($v);
				}
			}
		}
	}
	
	// -----------------------------------------------------------------
	/**
	 * Definir o Titulo do sistema
	 */
	public function defineConstantSystemTitle() {
		if (! defined ( 'TITULO_SISTEMA' )) {
			define ( 'TITULO_SISTEMA', $this->getTitle () );
		}
	}
	
	// -----------------------------------------------------------------
	/**
	 * Definir a constante de controle de sessão do aplicativo caso não tenha sido definido no config.inc (php)
	 */
	public function defineConstantAplicativo() {
		if (! defined ( 'APLICATIVO' )) {
			define ( 'APLICATIVO', 'FORMDIN' );
		}
	}
	
	// -----------------------------------------------------------------
	/**
	 * Adicionar os arquivos de Actions Gerais ou da aplicação
	 * @codeCoverageIgnore
	 */
	private function includesAppAction() {
		if (isset ( $_REQUEST ['app_action'] ) && $_REQUEST ['app_action']) {
			$this->includeConnectionFile ();
			// arquivo de actions gerais
			if (file_exists ( $this->getBase () . 'includes/app_action.php' )) {
				include ($this->getBase () . 'includes/app_action.php');
			}
			// arquivo de actions da aplicação
			if (file_exists ( 'includes/app_action.php' )) {
				include ('includes/app_action.php');
			}
			exit ();
		}
	}

	
	// -----------------------------------------------------------------
	/**
	 * Este método é responsável por processar as requisições web
	 */
	private function processRequest() {
		$modulo = '';
		
		if (isset ( $_REQUEST ['modulo'] )) {
			$_POST ['modulo'] = $_REQUEST ['modulo'];
			$_GET ['modulo'] = $_REQUEST ['modulo'];
			$modulo = $_REQUEST ['modulo'];
		} else if (isset ( $_REQUEST ['MODULO'] )) {
			$modulo = $_REQUEST ['MODULO'];
			$_POST ['modulo'] = $modulo;
			$_GET ['modulo'] = $modulo;
			$_REQUEST ['modulo'] = $modulo;
		}
		
		if (isset ( $_POST ['formDinAcao'] )) {
			$acao = $_POST ['formDinAcao'];
		} else if (isset ( $_POST ['FORMDINACAO'] )) {
			$acao = $_POST ['FORMDINACAO'];
			$_POST ['formDinAcao'] = $acao;
			$_GET ['formDinAcao'] = $acao;
			$_REQUEST ['formDinAcao'] = $acao;
		}
		
		if (isset ( $_POST ['modulo'] ) && ! isset ( $modulo )) {
			$modulo = $_POST ['modulo'];
		}
		
		if (isset ( $modulo ) && $modulo != '') {
			if (! $this->getLoginDone ()) {
				if ($modulo != $this->getLoginFile ()) {
					if (ob_get_level () > 0) {
						ob_clean ();
					}
					$_SESSION [APLICATIVO] = null;
					$_POST ['fwSession_expired'] = true; // avisar a classe TForm para reiniciar a aplicação
					                                    // die('<html><head><script>window.setTimeout("top.app_restart(\'Sua sessão foi encerrada.\\\n\\\nPressione OK para continuar.\')",100);</script></head><body></body></html>');
					if ((isset ( $_REQUEST ['ajax'] ) && $_REQUEST ['ajax']) || $_REQUEST ['gridOffline']) {
						if (strtolower ( $_REQUEST ['dataType'] ) == 'json') {
							$resAjax = null;
							$resAjax ['status'] = - 1;
							$resAjax ['data'] = null;
							$resAjax ['message'] = 'fwSession_expired';
							echo json_encode ( $resAjax );
							die ();
						} else if (strtolower ( $_REQUEST ['dataType'] ) == 'text') {
							die ( 'fwSession_expired' );
						} else if (strtolower ( $_REQUEST ['dataType'] ) == 'textjson') {
							die ( '{"fwSession_expired":"1"}' );
						} else {
							die ( 'Sessão Expirada. Efetue login novamente.' );
						}
						
						die ();
					}
				}
			}
			
			// ajustar caminho do modulo recebido
			$modulo = $this->getRealPath ( $modulo );
			
			// utilizado para criar o xml do menu quando o modulo base/seguranca/ler_menu_xml.php for chamado
			if (isset ( $_REQUEST ['content-type'] ) && strtolower ( $_REQUEST ['content-type'] ) == 'xml') {
				$_SESSION [APLICATIVO] ['modulo'] = null;
				if (! file_exists ( $modulo )) {
					header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
					header ( "Cache-Control: no-cache" );
					header ( "Pragma: no-cache" );
					header ( "content-type: text/xml; charset=" . $this->getCharset () . '"' );
					
					echo '<menu>
							<item id="cadastro" img="error16.gif" text="Arquivo: ' . $modulo . ' não existe."/>
							<item id="verifique" text="Verifique as configurações no index.php"/>
						</menu>';
					exit ();
				}
				
				$aFileInfo = pathinfo ( $modulo );
				
				if ($aFileInfo ['extension'] == 'php' || $aFileInfo ['extension'] == 'inc') {
					header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
					header ( "Cache-Control: no-cache" );
					header ( "Pragma: no-cache" );
					header ( "content-type: text/xml; charset=" . $this->getCharset () . '"' );
					$this->includeConnectionFile ();
					require_once ($modulo);
				} else {
					header ( "content-type: text/xml; charset=" . $this->getCharset () . "'" );
					
					echo file_get_contents ( $modulo );
				}
				
				exit ();
			}
			$htmlScript = "<!DOCTYPE HTML PUBLIC\"-//W3C//DTD HTML 4.01 Strict//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">\n<html>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=" . $this->getCharset () . "\">\n<body>\n" . "<table border=\"0\" width=\"100%\" height=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n<td name=\"data_content\" id=\"data_content\" align=\"" . $this->getHorizontalAlign () . "\" valign=\"" . $this->getVerticalAlign () . "\">";
			
			if (! file_exists ( $modulo )) {
				echo $htmlScript;
				$this->addJavascript ( 'top.app_show_message("Modulo ' . $_POST ['modulo'] . ' não encontrado","ERROR",8)' );
				$this->addJavascript ( 'top.app_setFooterModule();' );
				
				echo $this->getJavascript ( true, false );
				$_POST ['modulo'] = null;
				$_GET ['modulo'] = null;
				$_REQUEST ['modulo'] = null;
				$_SESSION [APLICATIVO] ['modulo'] = null;
				unset ( $_SESSION [APLICATIVO] ['modulo'] );
			} else {
				
				$this->includeConnectionFile ();
				if ((isset ( $_REQUEST ['fpdf'] ) && $_REQUEST ['fpdf']) || (isset ( $_REQUEST ['pdf'] ) && $_REQUEST ['pdf'])) {
					require_once ($modulo);
					exit ();
				}
				
				if (file_exists ( $this->getBase () . 'includes/formDin4Ajax.php' )) {
					require_once ($this->getBase () . 'includes/formDin4Ajax.php');
				}
				
				if ((isset ( $_REQUEST ['ajax'] ) && $_REQUEST ['ajax']) || (isset ( $_REQUEST ['gridOffline'] ) && $_REQUEST ['gridOffline'] == 1)) {
					require_once ($modulo);
					exit ();
				}
				
				// se existir o modulo terminado com xajax este será chamado
				if ($xajax = $this->processXajaxRequest ( $modulo )) {
					$xajax->processRequest ();
				}
				
				if (! isset ( $_REQUEST ['subform'] ) || ! $_REQUEST ['subform']) {
					// guardar o modulo na sessão para reexibir a página se o usuario pressionar F5
					$_SESSION [APLICATIVO] ['modulo'] = $_POST ['modulo'];
				}
				
				echo $htmlScript;
				
				// enquete - ibama
				if (defined ( 'COD_PSQ' ) && defined ( 'SEQ_CONTEXTO' ) && $_SESSION ['num_pessoa']) {
					if (function_exists ( 'executarPacote' )) {
						// verificar se já respondeu
						$bvars = array (
								'NUM_PESSOA' => $_SESSION ['num_pessoa'],
								'COD_PSQ_PESQUISA' => COD_PSQ,
								'SEQ_CONTEXTO' => SEQ_CONTEXTO 
						);
						
						executarPacote ( 'SISTAT.PK_SISREG.PESQUISA_PESSOA_RESPONDEU', $bvars, - 1 );
						
						if ($bvars ['SIT_RESPONDEU'] [0] == 'N') {
							$_SESSION [APLICATIVO] ['enquete'] ['modulo'] = $modulo;
							$modulo = $this->getBase () . 'includes/enquete.inc';
						}
					}
				}
				
				// fim enquete
				require_once ($modulo);
				
				// evitar notice do php
				if (! isset ( $acao )) {
					$acao = null;
				}
				
				// quando for subformularios dentro de um facebox, não sobrepor o nome do modulo principal aberto guardado na sessão
				if (! isset ( $_REQUEST ['subform'] )) {
					$this->addJavascript ( "try{ parent.app_setFooterModule(\"{$modulo}\",\"{$acao}\");}catch(e){}" );
				}
				
				echo $this->getJavascript ( true );
				
				if ($xajax) {
					// $xajax->configure('javascript URI', $this->getBase().'js/');
					// $xajax->register(XAJAX_EVENT_HANDLER,'afterProcessing','xajaxDone');
					$xajax->printJavascript ();
					
					echo "
					<script>
					//http://xajaxproject.org/en/docs-tutorials/upgrading-from-xajax-0-2-x-to-0-5/
					// fazer controle de requisições xajax
					var globalXajaxRequests	= 0;
					xajax.callback.global.onRequest = function()
					{
						globalXajaxRequests++;
						//alert('Requisição n. '+globalXajaxRequests);
						try{parent.app_setFooterMessage('Xajax:'+globalXajaxRequests);}catch(e){}
						//xajax.$('loadingMsg').style.display = 'block';
					};
					xajax.callback.global.onComplete = function()
					{
						globalXajaxRequests--;
						if(globalXajaxRequests<0)
						{
							globalXajaxRequests = 0;
						}
						//xajax.$('loadingMsg').style.display = 'none';
						try{parent.app_setFooterMessage('Xajax:'+globalXajaxRequests);}catch(e){}
					};
					xajax.callback.global.onFailure = function(args)
					{
						alert('Xajax Falha. HTTP status code: ' + args.request.status);
					}
					</script>
					";
				}
			}
			
			echo "</td>\n</tr>\n</table>\n</body>\n</html>";
			
			exit ();
		}
	}
	
	/**
	 * Este método faz a integração da aplicação com a classe XAJAX
	 * Ao receber o modulo, ela verifica se existe o arquivo correspondente terminado em _xajax.
	 * Se existir este será incluido e todas as suas funções serão extraidas e registradas automaticamente.
	 *
	 * @param string $modulo
	 * @return object xajax
	 */
	protected function processXajaxRequest($modulo) {
		// fazer integração com a classe XAJAX
		$moduloXajax = str_replace ( '.inc', '_xajax.php', str_replace ( '.php', '_xajax.php', $modulo ) );
		$xajax = null;
		
		if (strpos ( $moduloXajax, 'xajax.php' ) > 0) {
			if (file_exists ( $moduloXajax )) {
				$_POST ['modulo_xajax'] = $moduloXajax;
				require_once ($this->getBase () . 'classes/xajax_core/xajax.inc.php');
				// $xajax = new xajax();
				$xajax = new xajax ( $_SERVER ["SCRIPT_URI"] . '?modulo=' . $modulo );
				$xajax->configure ( 'javascript URI', $this->getBase () . 'js/' );
				// $xajax->configure('errorHandler', true);
				// $xajax->configure('logFile', 'xajax_error_log.log');
				// $xajax->configure('debug', true);
				$xajax->setCharEncoding ( ENCODINGS );
				$xajax->setFlag ( "decodeUTF8Input", true );
				require_once ($moduloXajax);
				$lines = file ( $moduloXajax, FILE_SKIP_EMPTY_LINES );
				
				foreach ( $lines as $line_num => $line ) {
					$line = trim ( $line );
					
					if (strpos ( $line, 'function ' ) === 0) {
						$posFunction = strpos ( $line, ' ' ) + 1;
						$posParenteses = strpos ( $line, '(' );
						$functionName = substr ( $line, $posFunction, $posParenteses - $posFunction );
						// print $functionName .'<br>';
						// $xajax->registerFunction($functionName);
						$xajax->register ( XAJAX_FUNCTION, $functionName );
					}
				}
			}
		}
		
		return $xajax;
	}
	public function setDefaultModule($strNewValue = null) {
		$this->defaultModule = $strNewValue;
	}
	public function getDefaultModule() {
		return $this->defaultModule;
	}
	
	/*
	 * //-------------------------------------------------------------------------------------------
	 * public function setPDOConnection($dbType,$dbHost=null,$dbName=null,$dbUser=null,$dbPassword=null)
	 * {
	 * if( ! $conn = TPDOConnection::connect($dbType,$dbHost,$dbName,$dbUser,$dbPassword) )
	 * {
	 * die(TPDOConnection::showError());
	 * }
	 * return $conn;
	 * }
	 * //-------------------------------------------------------------------------------------------
	 * public function setPDOConnectionOracle($strHost,$strServiceName,$strUserName,$strPassword,$intPort=1521)
	 * {
	 * $tns = "(DESCRIPTION =(ADDRESS_LIST=(ADDRESS = (PROTOCOL = TCP)(HOST = {$strHost})(PORT = {$intPort})))(CONNECT_DATA =(SERVICE_NAME = {$strServiceName})))";
	 * return $this->setPDOConnection(null,null,"oci:dbname=".$tns,$strUserName,$strPassword);
	 * }
	 * //-------------------------------------------------------------------------------------------
	 * public function setPDOConnectionMySql($strHost,$strDbName,$strUserName,$strPassword)
	 * {
	 * return $this->setPDOConnection("mysql",$strHost,$strDbName,$strUserName,$strPassword);
	 * }
	 * //-------------------------------------------------------------------------------------------
	 * public function setPDOConnectionPostgres($strHost,$strDbName,$strUserName,$strPassword)
	 * {
	 * return $this->setPDOConnection("pgsql",$strHost,$strDbName,$strUserName,$strPassword);
	 * }
	 */
	
	// -------------------------------------------------------------------------------------------
	public function setConnectionFile($strNewValue = null) {
		$this->connectionFile = $strNewValue;
		
		if ($strNewValue) {
			if (! file_exists ( $strNewValue )) {
				die ( 'Arquivo ' . $strNewValue . ' informado não existe!' );
			}
		}
	}
	
	// -------------------------------------------------------------------------------------------
	public function getConnectionFile() {
		return $this->connectionFile;
	}
	
	// -------------------------------------------------------------------------------------------
	public function setLoginFile($strNewValue = null, $onBeforeLoginFunction = null) {
		$this->loginFile = $strNewValue;
		if (! is_null ( $onBeforeLoginFunction )) {
			$this->setOnBeforeLogin ( $onBeforeLoginFunction );
		}
	}
	
	// -------------------------------------------------------------------------------------------
	public function getLoginFile() {
		// tentar encontrar o arquivo na pasta modulos
		if (! file_exists ( $this->loginFile )) {
			return $this->getRealPath ( $this->loginFile );
		}
		return $this->loginFile;
	}
	
	// -------------------------------------------------------------------------------------------
	public function setMainMenuFile($strNewValue = null) {
		$this->mainMenuFile = $strNewValue;
	}
	
	// -------------------------------------------------------------------------------------------
	public function getMainMenuFile() {
		return $this->mainMenuFile;
	}
	
	// --------------------------------------------------------------------------------------------
	function setConfigFile($strNewValue = null) {
		$this->configFile = $strNewValue;
		if (! is_null ( $this->configFile ) && file_exists ( $this->configFile )) {
			require_once ($this->configFile);
		} else {
			$this->addWarning ( 'config file ' . $strNewValue . ' not found!' );
		}
	}
	
	// --------------------------------------------------------------------------------------------
	function addIncludeFile($strFileName = null) {
		if ($strFileName) {
			$this->includeFiles [$strFileName] = $strFileName;
		}
	}
	
	// -----------------------------------------------------------------------------
	public function getIncludeFiles() {
		return $this->includeFiles;
	}
	
	// --------------------------------------------------------------------------------------------
	function getConfigFile() {
		if (isset ( $this->configFile ) && file_exists ( $this->configFile )) {
			return $this->configFile;
		}
		
		return null;
	}
	
	// --------------------------------------------------------------------------------------------
	private function includeConnectionFile() {
		if ($this->getConnectionFile ()) {
			if (file_exists ( $this->getConnectionFile () )) {
				require_once ($this->getConnectionFile ());
			} else {
				$this->addJavascript ( 'alert("Arquivo de conexão:' . $this->getConnectionFile () . ', defindo para a aplicação, não existe.")' );
			}
		}
	}
	
	// -----------------------------------------------------------------------------
	/**
	 * Método para encontrar e retornar o caminho correto do módulo dentro do diretório modulos/ da aplicação
	 *
	 * @param string $strFileName
	 */
	function getRealPath($strFileName = null) {
		if ($strFileName == '') {
			return $strFileName;
		}
		if ($strFileName == 'menu_principal.php') {
			return $strFileName;
		}
		
		if (file_exists ( 'modulos/' )) {
			$pathModulos = 'modulos/';
		} else {
			if (strpos ( $strFileName, 'modulos/' ) === false || strpos ( $strFileName, 'modulos/' ) > 0) {
				$pathModulos = str_replace ( 'base/', 'modulos/', $this->getBase () );
			}
		}
		
		$aFileParts = pathinfo ( $strFileName );
		
		$baseName = $aFileParts ['basename'];
		$fileName = $aFileParts ['filename'];
		$dirName = $aFileParts ['dirname'];
		// extensão padrão é inc
		$extName = isset ( $aFileParts ['extension'] ) ? $aFileParts ['extension'] : 'inc';
		$dirName = ($dirName == '.') ? '' : $dirName;
		$dirName = ($dirName == './') ? '' : $dirName;
		$dirName .= ($dirName != '') ? '/' : '';
		
		// se exisiter o diretório, não acrescenter o diretório modulos/
		if ($dirName != '' && is_dir ( $dirName )) {
			$pathModulos = '';
		}
		
		if (! $fileName) {
			$fileName = basename ( $baseName, '.' . $extName );
		}
		
		// 1º possibilidade: Estrutura de Visão e Controle
		$file = $pathModulos . $dirName . $fileName;
		
		if (is_dir ( $file )) {
			$fileOut = $file . '/' . $fileName . '.' . $extName;
			
			if (file_exists ( $fileOut )) {
				return $fileOut;
			}
			
			$extName2 = $extName == 'inc' ? 'php' : 'inc';
			$fileOut = $file . '/' . $fileName . '.' . $extName2;
			
			if (file_exists ( $fileOut )) {
				return $fileOut;
			}
		}
		
		// 2º possibilidade modelo normal na pasta modulos
		$fileOut = $pathModulos . $dirName . $fileName . '.' . $extName;
		
		if (file_exists ( $fileOut )) {
			return $fileOut;
		}
		
		$extName2 = $extName == 'inc' ? 'php' : 'inc';
		$fileOut = $pathModulos . $dirName . $fileName . '.' . $extName2;
		
		if (file_exists ( $fileOut )) {
			return $fileOut;
		}
		
		if (file_exists ( $strFileName )) {
			return $strFileName;
		}
		
		return null;
	}
	
	/**
	 * Adicinar diretórios no caminho de pesquisa de arquivos do php
	 *
	 * @param string $path
	 */
	public function includePath($path = null) {
		if ($path) {
			$path = PATH_SEPARATOR . $path . PATH_SEPARATOR . get_include_path ();
			set_include_path ( preg_replace ( '/' . PATH_SEPARATOR . PATH_SEPARATOR . '/', PATH_SEPARATOR, $path ) );
		}
		return $this;
	}
	
	/**
	 * Define a imagem que será exibida no fundo da tela principal da aplicação
	 * Se for uma imagem do diretório base/imagem/ ou ./imagem/ basta informar o nome da imagem
	 *
	 * @param string $strNewValue
	 */
	public function setBackgroundImage($strNewValue = null, $strRepeat = null, $strPosition = null) {
		$this->backgroundImage = $strNewValue;
		if ($strNewValue && file_exists ( $strNewValue )) {
			if (function_exists ( 'getimagesize' ) && file_exists ( $this->getFooterBgImage ( $strNewValue ) )) {
				list ( $width, $height ) = getimagesize ( $strNewValue );
				if (($width + $height) > 800) {
					$this->setBackgroundRepeat ( 'repeat-y' );
				}
			}
		}
		if ($strRepeat) {
			$this->setBackgroundRepeat ( $strRepeat );
		}
		$this->setBackgroundPosition ( $strPosition );
	}
	public function setBackgroundRepeat($strNewValue = null) {
		$this->backgroundRepeat = $strNewValue;
	}
	public function getBackgroundRepeat() {
		return is_null ( $this->backgroundRepeat ) ? 'repeat' : $this->backgroundRepeat;
	}
	public function setBackgroundPosition($strNewValue = null) {
		$this->backgroundPosition = $strNewValue;
	}
	public function getBackgroundPosition() {
		return is_null ( $this->backgroundPosition ) ? '' : $this->backgroundPosition;
	}
	
	/**
	 * Retorna a imagem que será exibida no fundo da tela principal da aplicação
	 * Se for uma imagem do diretório base/imagem/ ou ./imagem/ basta informar o nome da imagem
	 *
	 * @param string $strNewValue
	 */
	public function getBackgroundImage() {
		if (isset ( $this->backgroundImage )) {
			if (file_exists ( $this->backgroundImage )) {
				return $this->backgroundImage;
			} else {
				if (file_exists ( $this->getRoot () . 'imagens/' . $this->backgroundImage )) {
					return $this->getRoot () . 'imagens/' . $this->backgroundImage;
				} else if (file_exists ( $this->getBase () . 'imagens/' . $this->backgroundImage )) {
					return $this->getBase () . 'imagens/' . $this->backgroundImage;
				}
			}
		}
		
		return null;
	}
	
	/**
	 * Define a imagem que será exibida no centro da tela principal da aplicação
	 * Se for uma imagem do diretório base/imagem/ ou ./imagem/ basta informar o nome da imagem
	 *
	 * @param string $strNewValue
	 */
	public function setWaterMark($strNewValue = null) {
		$this->waterMark = $strNewValue;
		// $this->backgroundImage=null;
	}
	
	/**
	 * Retorna a imagem definida como marca d`agua da aplicacao
	 */
	public function getWaterMark() {
		if (isset ( $this->waterMark )) {
			if (file_exists ( $this->waterMark )) {
				return $this->waterMark;
			} else {
				if (file_exists ( $this->getRoot () . 'imagens/' . $this->waterMark )) {
					return $this->getRoot () . 'imagens/' . $this->waterMark;
				} else if (file_exists ( $this->getBase () . 'imagens/' . $this->waterMark )) {
					return $this->getBase () . 'imagens/' . $this->waterMark;
				}
			}
		}
		
		return null;
	}
	public function setCssFile($strNewValue = null) {
		$this->cssFile = $strNewValue;
	}
	public function getCssFile() {
		return $this->cssFile;
	}
	public function setLoginInfo($strInfo = null) {
		$this->loginInfo = preg_replace ( '/' . chr ( 10 ) . '/', '<br/>', $strInfo );
	}
	public function getLoginInfo() {
		if (isset ( $this->onGetLoginInfo ) && function_exists ( $this->removeIllegalChars ( $this->onGetLoginInfo ) )) {
			return call_user_func ( $this->getOnGetLoginInfo () );
		}
		
		return $this->loginInfo;
	}
	
	/**
	 * Define o conetudo ou o arquivo para montagem do cabeçalho da página
	 * 
	 * @param string $strNewValue
	 */
	public function setHeaderContent($strNewValue = null) {
		$this->headerContent = $strNewValue;
	}
	public function getHeaderContent() {
		if (preg_match ( '/\.php?|\.inc|\.htm?/', $this->headerContent ) > 0) {
			if (file_exists ( $this->headerContent )) {
				// $code= file_get_contents($this->headerContent);
				// $code= file_get_contents($this->headerContent);
				return $this->parsePhpFile ( $this->headerContent );
			} else {
				return 'Arquivo <b>' . $this->headerContent . '<b> definido para o cabeçalho não encontrado.';
			}
		}
		
		return $this->headerContent;
	}
	
	/**
	 * Define o conetudo ou o arquivo para montagem do corpo da página
	 *
	 * @param string $strNewValue
	 */
	public function setBodyContent($strNewValue = null) {
		$this->bodyContent = $strNewValue;
	}
	public function getBodyContent() {
		if (preg_match ( '/\.php?|\.inc|\.htm?/', $this->bodyContent ) > 0) {
			if (file_exists ( $this->bodyContent )) {
				return file_get_contents ( $this->bodyContent );
			} else {
				return 'Arquivo <b>' . $this->bodyContent . '<b> definido para o corpo não encontrado.';
			}
		}
		
		return $this->bodyContent;
	}
	
	/**
	 * Define o conetudo ou o arquivo para montagem do rodapé
	 *
	 * @param string $strNewValue
	 */
	public function setFooterContent($strNewValue = null) {
		$this->footerContent = $strNewValue;
	}
	public function getFooterContent() {
		if (preg_match ( '/\.php?|\.inc|\.htm?/', $this->footerContent ) > 0) {
			if (file_exists ( $this->footerContent )) {
				return file_get_contents ( $this->footerContent );
			} else {
				return 'Arquivo <b>' . $this->footerContent . '<b> definido para o rodapé não encontrado.';
			}
		}
		
		return $this->footerContent;
	}
	
	/**
	 * Define o alinhamento vertical dos formulários na tela
	 *
	 * @param mixed $strNewValue
	 *        	- top,center,bottom
	 */
	public function setVerticalAlign($strNewValue = null) {
		$this->verticalAlign = $strNewValue;
	}
	
	/**
	 * Recupera o valor definido para o alinhamento vertical dos formulários na tela
	 */
	public function getVerticalAlign() {
		return (is_null ( $this->verticalAlign ) || strtolower ( $this->verticalAlign ) == 'center') ? 'middle' : $this->verticalAlign;
	}
	
	/**
	 * Define o alinhamento horizontal dos formulários na tela
	 *
	 * @param mixed $strNewValue
	 */
	public function setHorizontalAlign($strNewValue = null) {
		$this->horizontalAlign = $strNewValue;
	}
	
	/**
	 * Recupera o valor do alinhamento vertical dos formulários na tela
	 */
	public function getHorizontalAlign() {
		return is_null ( $this->horizontalAlign ) ? 'center' : $this->horizontalAlign;
	}
	private function buildPageHeader() {
		/**
		 * tabela do cabeçalho
		 * ids: app_header_logo ,app_header_title, app_header_login
		 */
		$tbCab = new TTable ( 'table_header' );
		$tbCab->setProperty ( 'width', '100%' );
		$tbCab->setProperty ( 'border', '0' );
		$tbCab->setProperty ( 'cellpadding', '0px' );
		$tbCab->setProperty ( 'cellspacing', '0px' );
		$this->getNorthArea ()->add ( $tbCab );
		
		if ($this->getHeaderContent ()) {
			// cabeçalho definido pelo usuário
			$row = $tbCab->addRow ();
			$cellHeader = $row->addCell ( $this->getHeaderContent () );
			$cellHeader->setId ( 'app_header' );
			$cellHeader->clearCss ();
			$cellHeader->setCss ( 'text-align', 'left' );
			$cellHeader->setCss ( 'font-size', '14px' );
			$cellHeader->setCss ( 'border-top', 'none' );
			$cellHeader->setCss ( 'font-weight', 'normal' );
			$cellHeader->setCss ( 'line-height', '100%' );
			// td do cabeçalho
			$this->cellHeader = $cellHeader;
		} else {
			$row = $tbCab->addRow ();
			// app_header_logo
			$app_header_logo = $row->addCell ( $this->getSigla () );
			$app_header_logo->setId ( 'app_header_logo' );
			$app_header_logo->setCss ( 'width', '200' );
			// app_header_title
			$app_header_title = $row->addCell ( $this->getTitle () );
			$app_header_title->setId ( 'app_header_title' );
			$app_header_title->setCss ( 'Height', '55' );
			$app_header_title->setCss ( 'width', '*' );
			
			if ($this->getSubtitle ()) {
				$app_header_title->add ( '<br><span style="font-size:15px;" id="app_header_subtitle">' . $this->getSubtitle () . '</span>' );
			}
			
			$app_header_title->clearCss ();
			$app_header_title->setCss ( 'background-color', 'transparent' );
			
			if (defined ( 'COR_TITULO' )) {
				$app_header_title->setCss ( 'color', COR_TITULO );
			}
			
			// app_header_login
			$app_header_login = $row->addCell ( '' );
			$app_header_login->setId ( 'app_header_login' );
			$app_header_login->setCss ( 'Height', '55' );
			$app_header_login->setCss ( 'width', '200' );
			
			// propriedades da class
			$this->cellHeader = $app_header_title;
			$this->cellLogin = $app_header_login;
			$this->cellLogo = $app_header_logo;
			$this->cellLogo->setCss ( 'border', $this->getNorthArea ()->getCss ( 'border' ) );
			$this->cellHeader->setCss ( 'border', $this->getNorthArea ()->getCss ( 'border' ) );
			$this->cellLogin->setCss ( 'border', $this->getNorthArea ()->getCss ( 'border' ) );
		}
	}
	private function buildPageFooter() {
		if (! $this->getSouthArea ()) {
			return;
		}
		/**
		 * tabela do rodapé - app_footer
		 * ids: app_footer_message,app_footer_company, app_footer_module
		 */
		$tbFooter = new TTable ( 'table_footer' );
		$tbFooter->setProperty ( 'width', '100%' );
		$tbFooter->setProperty ( 'border', '0' );
		$tbFooter->setProperty ( 'cellpadding', '0px' );
		$tbFooter->setProperty ( 'cellspacing', '0px' );
		$this->getSouthArea ()->add ( $tbFooter );
		
		if ($this->getFooterContent ()) {
			$row = $tbFooter->addRow ();
			// app_footer_message
			$cellFooter = $row->addCell ( $this->getFooterContent () );
			$cellFooter->setId ( 'app_footer' );
			$cellFooter->setCss ( 'width', '100%' );
			$cellFooter->setCss ( 'Height', '30' );
		} else {
			$row = $tbFooter->addRow ();
			// app_footer_message
			$app_footer_message = $row->addCell ( '' );
			$app_footer_message->setId ( 'app_footer_message' );
			$app_footer_message->setCss ( 'width', '300' );
			$app_footer_message->setCss ( 'Height', '20' );
			// app_footer_company
			$info_company = $this->getUnit () . ' ' . $this->getVersionSystem ();
			$app_footer_company = $row->addCell ( $info_company );
			$app_footer_company->setId ( 'app_footer_company' );
			$app_footer_company->setCss ( 'width', '*' );
			// app_footer_module
			$app_footer_module = $row->addCell ( '' );
			$app_footer_module->setId ( '$app_footer_module' );
			$app_footer_module->setCss ( 'width', '300' );
		}
	}
	public function parsePhpFile($strFileName = null, $var = null) {
		if (is_null ( $strFileName ) || ! file_exists ( $strFileName )) {
			return null;
		}
		
		ob_start ();
		eval ( "?>" . implode ( "", file ( $strFileName ) ) . "<?" );
		$c = ob_get_contents ();
		ob_clean ();
		return $c;
	}
	public function getLoCenter() {
		return $this->loCenter;
	}
	public function setBeforeActionFunction($strNewValue = null) {
		$this->beforeActionFunction = $strNewValue;
	}
	public function getBeforeActionFunction() {
		return $this->beforeActionFunction;
	}
	public function setonBeforeActionFunction($strNewValue = null) {
		$this->setBeforeActionFunction ( $strNewValue );
	}
	public function getOnBeforeActionFunction() {
		return $this->getBeforeActionFunction ();
	}
	public function setWidth($intNewValue = null) {
		$this->width = $intNewValue;
	}
	public function getWidth() {
		return $this->width;
	}
	public function setOnGetLoginInfo($strNewValue = null) {
		$this->onGetLoginInfo = $strNewValue;
	}
	public function getOnGetLoginInfo() {
		return $this->onGetLoginInfo;
	}
	public function setMenuIconsPath($strNewValue = null) {
		$this->menuIconsPath = $strNewValue;
	}
	public function getMenuIconsPath() {
		// if ( isset( $this->menuIconsPath ) && file_exists( $this->menuIconsPath ) )
		{
			return $this->menuIconsPath;
		}
		return '';
	}
	/**
	 * Define a imagem de fundo do cabeçalho da aplicação
	 * O parametro $strRepeat define a maneira como a imagem de fundo é repetida:
	 * repeat -> repete vertical e horizontal
	 * repeat-y -> repete vertical;
	 * repeat-x -> repete horizontal;
	 *
	 * @param mixed $strNewImage
	 * @param mixed $strRepeat
	 */
	public function setHeaderBgImage($strNewImage = null, $strRepeat = null) {
		$this->headerBgImage = $strNewImage;
		if (is_null ( $this->getWidth () )) {
			if (function_exists ( 'getimagesize' ) && file_exists ( $strNewImage )) {
				list ( $width, $height ) = getimagesize ( $strNewImage );
				$this->setNorthSize ( $height );
				if ($width > 600) {
					$this->setWidth ( $width );
				}
			}
		}
		if (is_null ( $this->getHeaderBgRepeat () )) {
			$this->setHeaderBgRepeat ( $strRepeat );
		}
	}
	public function getHeaderBgImage() {
		return $this->headerBgImage;
	}
	public function setHeaderBgRepeat($strNewValue = null) {
		$this->headerBgRepeat = $strNewValue;
	}
	public function getHeaderBgRepeat() {
		return $this->headerBgRepeat;
	}
	public function setFooterBgImage($strNewImage = null, $strRepeat = null) {
		$this->footerBgImage = $strNewImage;
		if (function_exists ( 'getimagesize' ) && file_exists ( $strNewImage )) {
			list ( $width, $height ) = getimagesize ( $strNewImage );
			$this->setSouthSize ( $height );
		}
		if (is_null ( $this->getFooterBgRepeat () )) {
			$this->setFooterBgRepeat ( $strRepeat );
		}
	}
	public function getFooterBgImage() {
		return $this->footerBgImage;
	}
	public function setFooterBgRepeat($strNewValue = null) {
		$this->footerBgRepeat = $strNewValue;
	}
	public function getFooterBgRepeat() {
		return $this->footerBgRepeat;
	}
	public function setMenuTheme($strNewValue = 'standard | aqua_dark | aqua_sky | aqua_orange | clear_blue | clear_green | dhx_black | dhx_blue | glassy_blue | modern_black | modern_blue | modern_red | clear_silver') {
		$aThemes = explode ( ',', 'standard,aqua_dark,aqua_sky,aqua_orange,clear_blue,clear_green,dhx_black,dhx_blue,glassy_blue,modern_black,modern_blue,modern_red,clear_silver' );
		if (array_search ( $strNewValue, $aThemes )=== false ) {
			$strNewValue = 'clear_silver';
		}
		$this->menuTheme = $strNewValue;
	}
	public function getMenuTheme() {
		if( ! is_null( $this->menuTheme ) ) {
			return $this->menuTheme;
		}else{
			$this->setMenuTheme('clear_silver');
		}
		return $this->menuTheme;
	}
	public function getCellLogo()
	{
		return $this->cellLogo;
	}
	public function getCellHeader()
	{
		return $this->cellHeader;
	}
	public function getCellLogin()
	{
		return $this->cellLogin;
	}

	public function setOnBeforeLogin( $strFunctionName = null )
	{
		$this->onBeforeLogin = $strFunctionName;
	}

	public function getOnBeforeLogin()
	{
		return $this->onBeforeLogin;
	}

	public function getLoginDone()
	{
		/*if( isset( $_REQUEST['fwPublicMode'] ) && !is_null( $_REQUEST['fwPublicMode'] ) && ( $_REQUEST['fwPublicMode'] == 'S' || $_REQUEST['fwPublicMode'] == '1' || strtolower($_REQUEST['fwPublicMode']) == 'true' ) )
		{
			return true;
		}
		if( isset( $_SESSION[APLICATIVO]['public_mode'] ) && $_SESSION[APLICATIVO]['public_mode']==true )
		{
			return true;
		}
		*/
		// se não existe tela de login definida, então sempre retornar verdadeiro
		if( ! $this->getLoginFile() )
		{
			return true;
		}
		if( $this->getOnBeforeLogin() )
		{
			if ( function_exists( $this->removeIllegalChars( $this->getOnBeforeLogin()) ) )
			{
				return call_user_func( $this->getOnBeforeLogin(), $this );
			}
			else
			{
				$this->addJavascript('app_alert("Function '.$this->getOnBeforeLogin().' is not defined.");');
			}
		}
		else
		{
			if ( isset( $_SESSION[ APLICATIVO ][ "conectado" ] ) && $_SESSION[ APLICATIVO ][ "conectado" ] )
			{
			  return true;
			}
		}
		return false;
	}
}
?>