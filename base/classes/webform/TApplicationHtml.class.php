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
include_once('autoload_formdin.php');
class TApplicationHtml
{
	private $strTitle;
	private $strSubtitle;
	private $strSigla;
	private $strUnit;
	private $page;
	private $defaultModule;
	private $showMenu;
	private $formDin3Compatible;
	private $connectionFile;
	private $loginFile;
	private $mainMenuFile;
	private $configFile;
	private $includeFiles;
	private $waterMark;
	private $backgroundImage;
	private $windowApp;
	private $cssFile;
	private $loginInfo;
	private $headerContent;
	private $footerContent;
	private $bodyContent;
	private $horizontalAlign;
	private $verticalAlign;
	/**
	* classe para criação da aplicação
	*
	* @param string $strTitle
	* @param string $strSubtitle
	* @param string $strSigla
	* @param string $strUnit
	* @return TApplication
	*/
	public function __construct($strTitle=null,$strSubtitle=null,$strSigla=null,$strUnit=null)
	{
		session_start();
		$this->setTitle( $strTitle);
		$this->setSubtitle( $strSubtitle);
		$this->setUnit( $strUnit);
		$this->setSigla($strSigla);
		$this->setShowMenu(true);
		$this->setFormDin3Compatible(false);
		$this->page = new THtmlPage();
		// arquivo css padrão localizado na base base/css
		$this->setCssFile('app.css');
		// desabilitar tecla F5
		$this->page->getBody()->setProperty('onKeyDown',"javascript:try{ return fwCancelRefresh(event); } catch(e){};");

		$this->setBackgroundImage($this->page->getBase().'css/imagens/app/bg_listrado.jpg');

		// biblioteca de funções geral
		$this->addIncludeFile($this->page->getBase().'includes/funcoes.inc');
		// posição padrão dos formulário - centralizado na tela
		$this->setHorizontalAlign('center');
		$this->setVerticalAlign('middle');
	}
	public function setTitle($strNewValue)
	{
		$this->strTitle = $strNewValue;
	}
	public function getTitle()
	{
		if( is_null($this->strTitle) && defined('TITULO_SISTEMA'))
		{
			return TITULO_SISTEMA;
		}
		return $this->strTitle;
	}
	public function setSubtitle($strNewValue)
	{
		$this->strSubtitle = $strNewValue;
	}
	public function getSubtitle()
	{
		return $this->strSubtitle;
	}
	public function setSigla($strNewValue)
	{
		$this->strSigla = $strNewValue;
	}
	public function getSigla()
	{
		if( !$this->strSigla )
		{
			$this->setSigla(APLICATIVO);
		}
		if( preg_match('/<img/',strtolower($this->strSigla)))
		{
			return $this->strSigla;
		}
		else if( preg_match('/jp?|gif|png|bmp/',$this->strSigla))
		{
			if( file_exists($this->strSigla) )
			{
				return '<img src="'.$this->strSigla.'">';
			}
			// procurar na pasta includes/imagens da apliacao e na base/
			if( file_exists($this->page->getRoot().'imagens/'.$this->strSigla))
			{
				return  '<img src="'.$this->page->getRoot().'imagens/'.$this->strSigla.'">';
			}
			else if( file_exists($this->page->getBase().'imagens/'.$this->strSigla))
			{
				return '<img src="'.$this->page->getBase().'imagens/'.$this->strSigla.'">';
			}
		}
		else
		{
			return $this->strSigla;
		}
	}
	public function setUnit($strNewValue)
	{
		$this->strUnit = $strNewValue;
	}
	/**
	* Permite ocultar ou exibir o menu principal da aplicação
	*/
	public function setShowMenu($boolNewValue=null)
	{
		$boolNewValue = is_null($boolNewValue) ? true : $boolNewValue;
		$this->showMenu = $boolNewValue;
	}
	public function getShowMenu()
	{
		return $this->showMenu;
	}
	public function setFormDin3Compatible($boolNewValue=null)
	{
		$this->formDin3Compatible = $boolNewValue;
	}
	public function getFormDin3Compatible()
	{
		return $this->formDin3Compatible;
	}
	/**
	* Este método inicializa a aplicação e cria a interface da aplicação.
	* Se for passado o modulo ele apenas inclui módulo e sai funcionando como o modulo ler_modulo.php antigo
	*
	*/
	public function run()
	{
		ini_set('default_charset','iso-8859-1');
		// não exibir as mensagens de E_NOTICE para evitar os aviso de redefinição das constantes BANCO_USUARIO E BANCO_SENHA do config.php
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
//error_reporting(E_ALL);
		if($this->getConfigFile())
		{
			if( file_exists($this->getConfigFile()))
			{
				require_once($this->getConfigFile());
			}
		}
		// definir a constante de controle de sessão do aplicativo caso não tenha sido definido no config.inc (php)
		if(!defined('APLICATIVO'))
		{
			define('APLICATIVO','FORMDIN');
		}
		// adicionar os arquivos definidos no setIncludeFile()
		if($this->getIncludeFiles())
		{
			foreach($this->getIncludeFiles() as $k=>$v)
			{
				if( file_exists($v))
				{
					require_once($v);
				}
			}
		}
		if( isset($_REQUEST['app_action']) && $_REQUEST['app_action'] )
		{
			$this->includeConnectionFile();
			// arquivo de actions gerais
			if( file_exists($this->page->getBase().'includes/app_action.php'))
			{
				include($this->page->getBase().'includes/app_action.php');
			}
			// arquivo de actions da aplicação
			if( file_exists('includes/app_action.php'))
			{
				include('includes/app_action.php');
			}
			exit();
		}
		//******************************************************************************************
		$this->processRequest(); // se existir modulo postado, a aplicação termina nesta linha senão cria a tela básica do aplicativo
		//******************************************************************************************

		if( !$this->getLoginFile() && !$this->getMainMenuFile() && !$this->getDefaultModule() )
		{
			$_SESSION[APLICATIVO]=null;
		}
		if($this->getSubtitle() )
		{
			$this->page->addInTitle($this->getSubtitle());
		}
		else
		{
			$this->page->addInTitle($this->getTitle());
		}
		// css
		$this->page->addJsCssFile($this->getCssFile());
		$this->page->addJsCssFile('FormDin4.css');
		//$this->page->addJsCssFile('greybox/gb_styles.css');
		$menuTheme = 'clear_silver'; // Estilos válidos: standard,aqua_dark,aqua_sky,aqua_orange,clear_blue,clear_green,dhx_black,dhx_blue,glassy_blue,modern_black,modern_blue,modern_red,clear_silver
		if($this->windowApp)
		{
			$this->page->addJsCssFile('prototype/themes/default.css');
			$this->page->addJsCssFile('prototype/themes/lighting.css');
			//$this->page->addJsCssFile('prototype/themes/mac_os_x.css');
			$this->page->addJsCssFile('prototype/themes/mac_os_x_right.css');
			$this->page->addJsCssFile('prototype/themes/alphacube.css');
			$this->page->addJsCssFile('app_prototype.css');
			$this->page->addJsCssFile('js/dhtmlx/menu/skins/'.$menuTheme.'/'.$menuTheme.'.css');
			$this->page->addJsCssFile('prototype/prototype.js');
			$this->page->addJsCssFile('prototype/effects.js');
			$this->page->addJsCssFile('prototype/window.js');
			$this->page->addJsCssFile('prototype/window_ext.js');
			$this->page->addJsCssFile('prototype/window_effects.js');
			$this->page->addJsCssFile('prototype/javascripts/debug.js');
			$this->page->addJsCssFile('dhtmlx/dhtmlxcommon.js');
			$this->page->addJsCssFile('dhtmlx/menu/dhtmlxmenu_cas.js');
			$this->page->addJsCssFile('app_prototype.js');
			$this->page->addJsCssFile('FormDin4.js'); // necessário para funcionar o searchonline
		}
		else
		{
			// javascript
			$this->page->addJsCssFile('dhtmlx/dhtmlxcommon.js');
			$this->page->addJsCssFile('dhtmlx/menu/dhtmlxmenu_cas.js');
		}
		// o nome do estilo tem que ser alterado no arquivo app.js tambem
		$this->page->addJavascript("pastaBase='{$this->page->getBase()}';");
		$this->page->addJavascript('GB_ROOT_DIR 	= pastaBase+\'js/greybox/\';');
		$this->page->addJavascript("menuTheme='{$menuTheme}';");
		$this->page->addJavascript("aplicativo='".APLICATIVO."';");
		$this->page->addJavascript("marca_dagua='".$this->getWaterMark()."';");
		$this->page->addJavascript("background_image='".$this->getBackgroundImage()."';");
		$this->page->addJsCssFile($this->page->getBase().'js/dhtmlx/menu/skins/'.$menuTheme.'/'.$menuTheme.'.css');
		$this->page->addJsCssFile('app.js');
		$this->page->addJsCssFile('jquery/jquery.js');
		$this->page->addJsCssFile('http://code.jquery.com/jquery-migrate-1.4.1.js');
		$this->page->addJsCssFile('jquery/jquery.corner.js');
		//$this->page->addJsCssFile('jquery/jquery.dimensions.min.js');
		/*
		$this->page->addJsCssFile('greybox/AJS.js');
		$this->page->addJsCssFile('greybox/AJS_fx.js');
		$this->page->addJsCssFile('greybox/gb_scripts.js');
		*/
		$this->page->addJsCssFile('lazyload/lazyload-min.js');
		//$this->page->addJsCssFile('lazyload.js');

		// criar o layout da aplicação
		$table = new TTable();
		$table->setId('app_main_table');
		$table->clearCss();
		$this->page->addInBody($table);
		$table->setProperty('border',0);
		$table->setProperty('width','100%');
		$table->setProperty('height','100%');
		$table->setProperty('cellpadding','0');
		$table->setProperty('cellspacing','0');

		// criar o cabeçalho da página
		$rowHeader  = $table->addRow();
		$cellHeader = $rowHeader->addCell('');
		$cellHeader->setProperty('width'	,'100%');
		$cellHeader->setProperty('height'	,'10px');
		$cellHeader->setProperty('id'		,'app_header');
		$cellHeader->setCss('background-color','silver');

		// menu
		$rowMenu  = $table->addRow();
		$cellMenu = $rowMenu->addCell('<div id="div_main_menu"></div>');
		$cellMenu->setProperty('width'	,'100%');
		$cellMenu->setProperty('height'	,'20px');
		$cellMenu->setProperty('id'		,'app_main_menu');
		$cellMenu->setCss('background-color','gray');
		$cellMenu->setCss('display','none');

		// corpo da pagina
		$rowBody  = $table->addRow();
		$cellBody = $rowBody->addCell('');
		$cellBody->setProperty('width'	,'100%');
		$cellBody->setProperty('height'	,'80%');
		$cellBody->setProperty('id'		,'app_center');
		$cellBody->setCss('background-color','white');

		// rodape da página
		$rowFooter 	= $table->addRow();
		$cellFooter = $rowFooter->addCell('');
		$cellFooter->setProperty('width'	,'100%');
		$cellFooter->setProperty('height'	,'10px');
		$cellFooter->setProperty('id'		,'app_footer');
		$cellFooter->setCss('background-color','white');
		if( $this->getFooterContent() == '' && !is_null($this->getFooterContent()) )
		{
			$cellFooter->setCss('display','none');
		}

		if( $this->getHeaderContent() )
		{
        	$cellHeader->add($this->getHeaderContent());
        	$cellHeader->clearCss();
			$cellHeader->setCss('text-align'	,'left');
			$cellHeader->setCss('font-size'	,'14px');
			$cellHeader->setCss('border-top'  ,'none');
			$cellHeader->setCss('font-weight' ,'normal');
			$cellHeader->setCss('line-height' ,'100%');
		}
		else
		{
			$tableHeader = new TTable('table_header');
			$cellHeader->add($tableHeader);
			$tableHeader->setProperty('width','100%');
			$tableHeader->setProperty('cellspacing','0px');
			$tableHeader->setProperty('cellpadding','0px');
			$tableHeader->setCss('border','none');
			$row = $tableHeader->addRow();

			// logotipo
			$cell= $row->addCell($this->getSigla()); // '<img src="imagens/logotipo.gif">'
			$cell->clearCss();
			$cell->setCss('background-color','transparent');
			$cell->setCss('padding-left','5px');
			$cell->setProperty('id','app_header_logotipo');
			$cell->setProperty('height','55px');
			$cell->setProperty('width','200px');

			// titulo
			$cell = $row->addCell($this->getTitle());
			if($this->getSubtitle())
			{
				$cell->add('<br><span style="font-size:15px;" id="app_header_subtitle">'.$this->getSubtitle().'</span>');
			}
			$cell->clearCss();
			$cell->setCss('background-color','transparent');
			if ( defined('COR_TITULO'))
			{
				$cell->setCss('color',COR_TITULO);
			}

			$cell->setProperty('id','app_header_title');
			$cell->setProperty('width','*');

			// area para informações do usuário logado
			$cellLogin = $row->addCell();
			$cellLogin->clearCss();
			$cellLogin->setCss('background-color','transparent');
			$cellLogin->setProperty('id','app_header_login');
			$cellLogin->setProperty('width','200px');
		}

		// corpo da página
		if( ! $this->windowApp )
		{
			if($this->getBodyContent() )
			{
				$cellBody->add($this->getBodyContent());
				$cellBody->setId('app_body');
			}
			else
			{
				$cellBody->add('<div id="app_div_message" title="Fechar este aviso" style="display:none;top:0px;left:0px;position:absolute;">'."\n".'<img onClick="jQuery(\'#app_div_message\').hide();" src="'.$this->page->getBase().'/imagens/icon_alert.png" style="float:left;margin-right:10px;vertical-align:middle;cursor:pointer;"><span></span></div>'.
						"\n".'<iframe id="app_iframe" src="'.$this->page->getBase().'includes/pagina_branco.html"  frameborder="0" marginheight="0px" marginwidth="0px" allowtransparency="false"></iframe>');
			}
		}
		else
		{
			$cellBody->add('<div id="app_div_message" title="Fechar este aviso" style="display:none;top:0px;left:0px;position:absolute;">'."\n".'<img onClick="jQuery(\'#app_div_message\').hide();" src="'.$this->page->getBase().'/imagens/icon_alert.png" style="float:left;margin-right:10px;vertical-align:middle;cursor:pointer;"><span></span></div>');
		}

		// rodapé da página
		if( $this->windowApp )
		{
			// mostrar as janelas prototype minimizadas
			$this->page->addJavascript('app_prototype = true;');
			$cellFooter->setId('dock');
		}
		else
		{
			// criar estrutura do rodape
			if( ! is_null($this->getFooterContent())  )
			{
				$cellFooter->add( $this->getFooterContent() );
			}
			else
			{
				$tableFooter = new TTable('table_footer');
				$tableFooter->setProperty('width','100%');
				$tableFooter->setProperty('cellspacing','0px');
				$tableFooter->setProperty('cellpadding','0px');
				$tableFooter->setCss('border','none');
				$cellFooter->add($tableFooter);
				$row = $tableFooter->addRow();
				$row->clearCss();
				$cell = $row->addCell('');
				$cell->clearCss();
				$cell->setCss('background-color','transparent');
				$cell->setProperty('id','app_footer_message');
				$cell->setProperty('width','400px');
				$cell->setProperty('height','20px');
				$cell =  $row->addCell($this->strUnit);
				$cell->clearCss();
				$cell->setCss('background-color','transparent');
				$cell->setProperty('id',"app_footer_company");
				$cell->setProperty('width',"*");
				$cell =  $row->addCell('');
				$cell->clearCss();
				$cell->setCss('background-color','transparent');
				$cell->setProperty('id',"app_footer_module");
				$cell->setProperty('width',"400px");
			}

		}
		$this->page->addJavascript('app_init()');
		if( ! $this->getShowMenu() )
		{
			$this->page->addJavascript('showMenu = false;');
		}
		else
		{
			$this->page->addJavascript('showMenu = true;');
		}
		if( isset($_SESSION[APLICATIVO]["conectado"]) && $_SESSION[APLICATIVO]["conectado"])
		{
			if( isset( $cellLogin ) )
			{
				$btnLogOut = '<input id="button_end_session" type="button" value="Encerrar Sessão" onclick="app_login(1,\''.$this->getLoginFile().'\')">';
				if( $this->getLoginInfo())
				{
					$cellLogin->add( $this->getLoginInfo());
				}
				else if( isset($_SESSION[APLICATIVO]["login"]["num_cpf"]) && $_SESSION[APLICATIVO]["login"]["num_cpf"] )
				{
					$cellLogin->add( 'CPF:'.formatar_cpf_cnpj($_SESSION[APLICATIVO]["login"]["num_cpf"]).'<br/>'.
					$_SESSION[APLICATIVO]["login"]["nom_pessoa"]);
				}
				if( preg_match('/<input/i',$this->getLoginInfo()) == 0 )
				{
					$cellLogin->add('<br/>'.$btnLogOut);
				}
        	}
			else
			{
				$cellHeader->clearChildren();// limpar a celula da tabela
				$cellHeader->add($this->getHeaderContent());
			}
		}
		else
		{
			if( $this->getLoginInfo())
			{
				$cellLogin->add( $this->getLoginInfo());
			}
			if( $this->getLoginFile() )
			{
				if( file_exists($this->getLoginFile()))
				{
					$this->page->addJavascript('app_login(false,"'.$this->getLoginFile().'","'.$this->getLoginInfo().'")');
				}
				else
				{
					$this->page->addJavascript('alert("Tela de login:'.$this->getLoginFile().', defindo para a aplicação, não existe.")');
				}
				$this->page->show();
				exit();
			}
		}

		if($this->getShowMenu())
		{
			if( $this->getMainMenuFile())
			{
				if( file_exists($this->getMainMenuFile()) )
				{
					$this->page->addJavascript('try{app_main_menu = new dhtmlXMenuObject("div_main_menu",menuTheme);}catch(e){alert( "Erro no menu. Não foi possível instanciar a classe dhtmlXMenuObject.\t"+e.message)}');
					$this->page->addJavascript('app_build_menu(false,null,"'.$this->getMainMenuFile().'")');
				}
				else
				{
					$this->page->addJavascript('alert("Módulo de menu:'.$this->getMainMenuFile().', defindo para a aplicação, não existe.")');
				}
			}
		}
		//se pressionar F5, recarregar o ultimo módulo solicitado
		if( isset($_SESSION[APLICATIVO]['modulo']) && $_SESSION[APLICATIVO]['modulo'] )
		{
			if( $_SESSION[APLICATIVO]['modulo'] != $this->getLoginFile())
			{
				$this->page->addJavascript('//se pressionar F5, recarregar o ultimo módulo solicitado');
				$this->page->addJavascript('app_load_module("'.$_SESSION[APLICATIVO]['modulo'].'")');
			}
		}
		else
		{
			if($this->getDefaultModule())
			{
				$this->page->addJavascript('var app_default_module="'.$this->getDefaultModule().'";');
				$this->page->addJavascript('app_load_module("'.$this->getDefaultModule().'")');
			}
		}
		$this->page->show();
	}
	//-----------------------------------------------------------------
	/**
	* Este método é responsável por processar as requisições web
	*
	*/
	private function processRequest()
	{
		$modulo='';
		if( isset( $_REQUEST['modulo'] ))
		{
			$_POST['modulo']	= $_REQUEST['modulo'];
			$_GET['modulo']		= $_REQUEST['modulo'];
			$modulo				= $_REQUEST['modulo'];
		}
		else if( isset( $_REQUEST['MODULO'] ))
		{
			$modulo 			= $_REQUEST['MODULO'];
			$_POST['modulo'] 	= $modulo;
			$_GET['modulo']	 	= $modulo;
			$_REQUEST['modulo'] = $modulo;
		}
		if( isset( $_POST['formDinAcao'] ) )
		{
			$acao 	= $_POST['formDinAcao'];
		}
		else if( isset( $_POST['FORMDINACAO'] ) )
		{
			$acao 	= $_POST['FORMDINACAO'];
			$_POST['formDinAcao'] 	= $acao;
			$_GET['formDinAcao'] 	= $acao;
			$_REQUEST['formDinAcao'] = $acao;
		}
		if( isset($_POST['modulo']) && !isset($modulo) )
		{
			$modulo	= $_POST['modulo'];
		}
		if( isset($modulo) && $modulo != '' )
		{
			// ajustar caminho do modulo recebido
			$modulo = $this->getRealPath($modulo);

			// utilizado para criar o xml do menu quando o modulo base/seguranca/ler_menu_xml.php for chamado
			if(isset($_REQUEST['content-type']) && strtolower($_REQUEST['content-type'])=='xml')
			{
				$_SESSION[APLICATIVO]['modulo']=null;
				ob_clean();
				if( !file_exists($modulo))
				{
					header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
					header("Cache-Control: no-cache");
					header("Pragma: no-cache");
					header("content-type: text/xml; charset=ISO-8859-1");
					echo '<menu>
							<item id="cadastro" img="error16.gif" text="Arquivo: '.$modulo.' não existe."/>
							<item id="verifique" text="Verifique as configurações no index.php"/>
						</menu>';
					exit();
				}
				$aFileInfo 		= pathinfo($modulo);
				if( $aFileInfo['extension'] == 'php' || $aFileInfo['extension'] == 'inc')
				{

					header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
					header("Cache-Control: no-cache");
					header("Pragma: no-cache");
					header("content-type: text/xml; charset=ISO-8859-1");
					$this->includeConnectionFile();
					require_once($modulo);
				}
				else
				{
					header("content-type: text/xml; charset=UTF-8");
					echo file_get_contents($modulo);
				}
				exit();
			}
			$htmlScript ="<!DOCTYPE HTML PUBLIC\"-//W3C//DTD HTML 4.01 Strict//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">\n<html>\n<body>\n".
						 "<table border=\"0\" width=\"100%\" height=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n<td name=\"data_content\" id=\"data_content\" align=\"".$this->horizontalAlign."\" valign=\"".$this->getVerticalAlign()."\">";

			if( !file_exists($modulo) )
			{
				echo $htmlScript;
				$this->page->addJavascript('top.app_show_message("Modulo '.$_POST['modulo'].' não encontrado","ERROR",8)');
				$this->page->addJavascript('top.app_setFooterModule();');
				echo $this->page->getJavascript(true,false);
				$_POST['modulo']=null;
				$_GET['modulo']=null;
				$_REQUEST['modulo']=null;
				$_SESSION[APLICATIVO]['modulo']=null;
				unset($_SESSION[APLICATIVO]['modulo']);
			}
			else
			{

				if( $this->getFormDin3Compatible())
				{
					require_once($this->page->getBase().'classes/FormDin3.class.php');
					require_once($this->page->getBase().'classes/FormDin3.func.inc');
				}
				$this->includeConnectionFile();
				if(isset($_REQUEST['fpdf']) && $_REQUEST['fpdf'] )
				{
					//define('FPDF_FONTPATH',$this->page->getBase().'classes/fpdf/fonts/');
					//require_once($this->page->getBase().'classes/fpdf/fpdf.php');
					require_once($modulo);
					exit();
				}
				//require_once($this->page->getBase().'includes/funcoes.inc');
				//require_once($this->page->getBase().'includes/conexao.inc');
				if( isset($_REQUEST['ajax']) && $_REQUEST['ajax'] )
				{
					require_once($modulo);
					exit();
				}
				// se existir o modulo terminado com xajax este será chamado
				if( $xajax = $this->processXajaxRequest($modulo))
				{
					$xajax->processRequest();
				}
				if( ! isset( $_REQUEST['subform']) || !$_REQUEST['subform'] )
				{
					// guardar o modulo na sessão para reexibir a página se o usuario pressionar F5
					$_SESSION[APLICATIVO]['modulo'] = $_POST['modulo'];
				}
				echo $htmlScript;

				// enquete - ibama
				if(defined('COD_PSQ') && defined('SEQ_CONTEXTO') && $_SESSION['num_pessoa'] )
				{
					if( function_exists('executarPacote'))
					{
						// verificar se já respondeu
						$bvars = array('NUM_PESSOA'=>$_SESSION['num_pessoa'],'COD_PSQ_PESQUISA'=>COD_PSQ,'SEQ_CONTEXTO'=>SEQ_CONTEXTO);
						executarPacote('SISTAT.PK_SISREG.PESQUISA_PESSOA_RESPONDEU',$bvars,-1);
						if( $bvars['SIT_RESPONDEU'][0] == 'N' )
						{
							$_SESSION[APLICATIVO]['enquete']['modulo']=$modulo;
							$modulo = $this->page->getBase().'includes/enquete.inc';
						}
					}
				}
				// fim enquete
				require_once($modulo);

				// evitar notice do php
				if( !isset($acao))
				{
					$acao=null;
				}
				// quando for subformularios dentro de um facebox, não sobrepor o nome do modulo principal aberto guardado na sessão
				if( ! isset( $_REQUEST['subform'] ) )
				{
					$this->page->addJavascript("try{ parent.app_setFooterModule(\"{$modulo}\",\"{$acao}\");}catch(e){}");
				}
				echo $this->page->getJavascript(true);
				if($xajax)
				{
					//$xajax->configure('javascript URI', $this->page->getBase().'js/');
					//$xajax->register(XAJAX_EVENT_HANDLER,'afterProcessing','xajaxDone');
					$xajax->printJavascript();
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
			exit();
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
	protected function processXajaxRequest($modulo)
	{
		// fazer integração com a classe XAJAX
		$moduloXajax 	=str_replace('.inc','_xajax.php',str_replace('.php','_xajax.php',$modulo));
		$xajax	 		= null;
		if( strpos($moduloXajax,'xajax.php') > 0 )
		{
			if(file_exists($moduloXajax))
			{
				$_POST['modulo_xajax'] = $moduloXajax;
				require_once($this->page->getBase().'classes/xajax_core/xajax.inc.php');
				//$xajax = new xajax();
				$xajax = new xajax($_SERVER["SCRIPT_URI"].'?modulo='.$modulo);
				$xajax->configure('javascript URI', $this->page->getBase().'js/');
				//$xajax->configure('errorHandler', true);
				//$xajax->configure('logFile', 'xajax_error_log.log');
				//$xajax->configure('debug', true);
				$xajax->setCharEncoding('ISO-8859-1');
				$xajax->setFlag("decodeUTF8Input",true);
				require_once($moduloXajax);
				$lines = file($moduloXajax, FILE_SKIP_EMPTY_LINES);
				foreach ($lines as $line_num => $line)
				{
					$line = trim($line);
					if( strpos($line,'function ') === 0 )
					{
						$posFunction 	= strpos($line,' ')+1;
						$posParenteses 	= strpos($line,'(');
						$functionName 	= substr($line,$posFunction,$posParenteses-$posFunction);
						//print $functionName .'<br>';
						//$xajax->registerFunction($functionName);
						$xajax->register(XAJAX_FUNCTION,$functionName);
					}
				}
			}
		}
		return $xajax;
	}
	public function setDefaultModule($strNewValue=null)
	{
		$this->defaultModule = $strNewValue;
	}
	public function getDefaultModule()
	{
		return $this->defaultModule;
	}
	/*
	//-------------------------------------------------------------------------------------------
	public function setPDOConnection($dbType,$dbHost=null,$dbName=null,$dbUser=null,$dbPassword=null)
	{
		if( ! $conn = TPDOConnection::connect($dbType,$dbHost,$dbName,$dbUser,$dbPassword) )
		{
			die(TPDOConnection::showError());
		}
		return $conn;
	}
	//-------------------------------------------------------------------------------------------
	public function setPDOConnectionOracle($strHost,$strServiceName,$strUserName,$strPassword,$intPort=1521)
	{
		$tns = "(DESCRIPTION =(ADDRESS_LIST=(ADDRESS = (PROTOCOL = TCP)(HOST = {$strHost})(PORT = {$intPort})))(CONNECT_DATA =(SERVICE_NAME = {$strServiceName})))";
		return $this->setPDOConnection(null,null,"oci:dbname=".$tns,$strUserName,$strPassword);
	}
	//-------------------------------------------------------------------------------------------
	public function setPDOConnectionMySql($strHost,$strDbName,$strUserName,$strPassword)
	{
		return $this->setPDOConnection("mysql",$strHost,$strDbName,$strUserName,$strPassword);
	}
	//-------------------------------------------------------------------------------------------
	public function setPDOConnectionPostgres($strHost,$strDbName,$strUserName,$strPassword)
	{
		return $this->setPDOConnection("pgsql",$strHost,$strDbName,$strUserName,$strPassword);
	}
	*/
	//-------------------------------------------------------------------------------------------
	public function setConnectionFile($strNewValue=null)
	{
		$this->connectionFile = $strNewValue;
		if( $strNewValue )
		{
			if( !file_exists($strNewValue))
			{
				die('Arquivo '.$strNewValue.' informado não existe!');
			}
		}
	}
	//-------------------------------------------------------------------------------------------
	public function getConnectionFile()
	{
		return $this->connectionFile;
	}
	//-------------------------------------------------------------------------------------------
	public function setLoginFile($strNewValue=null)
	{
		$this->loginFile = $strNewValue;
	}
	//-------------------------------------------------------------------------------------------
	public function getLoginFile()
	{
		return $this->loginFile;
	}
	//-------------------------------------------------------------------------------------------
	public function setMainMenuFile($strNewValue=null)
	{
		$this->mainMenuFile = $strNewValue;
	}
	//-------------------------------------------------------------------------------------------
	public function getMainMenuFile()
	{
		return $this->mainMenuFile;
	}
	//--------------------------------------------------------------------------------------------
	function setConfigFile($strNewValue=null)
	{
		$this->configFile = $strNewValue;
	}
	//--------------------------------------------------------------------------------------------
	function addIncludeFile($strFileName=null)
	{
		if( $strFileName )
		{
			$this->includeFiles[$strFileName] = $strFileName;
		}
	}
	//-----------------------------------------------------------------------------
	public function getIncludeFiles()
	{
		return $this->includeFiles;
	}
	//--------------------------------------------------------------------------------------------
	function getConfigFile()
	{
		if( isset($this->configFile) && file_exists($this->configFile))
		{
			return $this->configFile;
		}
		return null;
	}
	//--------------------------------------------------------------------------------------------
	private function includeConnectionFile()
	{
		if( $this->getConnectionFile())
		{
			if( file_exists($this->getConnectionFile()) )
			{
				require_once($this->getConnectionFile());
			}
			else
			{
				$this->page->addJavascript('alert("Arquivo de conexão:'.$this->getConnectionFile().', defindo para a aplicação, não existe.")');
			}
		}
	}
	//-----------------------------------------------------------------------------
	/**
	* Método para encontrar e retornar o caminho correto do módulo dentro do diretório modulos/ da aplicação
	*
	* @param string $strFileName
	*/
	function getRealPath($strFileName=null)
	{
		if( $strFileName == 'menu_principal.php')
		{
			return $strFileName;
		}
		if( file_exists('modulos/') )
		{
			$pathModulos = 'modulos/';
		}
		else
		{

			if( strpos($strFileName,'modulos/') === false || strpos($strFileName,'modulos/') > 0 )
			{
				$pathModulos = str_replace('base/','modulos/',$this->page->getBase());
			}
		}
		$aFileParts = pathinfo($strFileName);
		$baseName 	= $aFileParts['basename'];
		$fileName 	= $aFileParts['filename'];
		$dirName 	= $aFileParts['dirname'];
		// extensão padrão é inc
		$extName 	= isset($aFileParts['extension']) ? $aFileParts['extension'] : 'inc';
		$dirName = ($dirName == '.') 	? ''    : $dirName;
		$dirName = ($dirName == './') 	? ''    : $dirName;
		$dirName .= ($dirName != '') 	? '/'   : '';
		// se exisiter o diretório, não acrescenter o diretório modulos/
		if( $dirName != '' && is_dir($dirName))
		{
			$pathModulos='';
		}
		if( !$fileName )
		{
			$fileName =  basename($baseName,'.'.$extName);
		}
		//1º possibilidade: Estrutura de Visão e Controle
		$file = $pathModulos.$dirName.$fileName;
		if( is_dir($file))
		{
			$fileOut =  $file.'/'.$fileName.'.'.$extName;
			if( file_exists($fileOut))
			 {
				return $fileOut;
			 }
			$extName2  = $extName == 'inc' ? 'php' : 'inc';
			$fileOut =  $file.'/'.$fileName.'.'.$extName2;
			if( file_exists($fileOut))
			 {
				return $fileOut;
			 }

		}
		//2º possibilidade modelo normal na pasta modulos
		$fileOut = $pathModulos.$dirName.$fileName.'.'.$extName;
		if( file_exists($fileOut))
		{
			return $fileOut;
		}
		$extName2  = $extName == 'inc' ? 'php' : 'inc';
		$fileOut = $pathModulos.$dirName.$fileName.'.'.$extName2;
		if( file_exists($fileOut))
		{
			return $fileOut;
		}
		if( file_exists($strFileName) )
		{
			return $strFileName;
		}
		return null;
	}
	/**
	* Adicinar diretórios no caminho de pesquisa de arquivos do php
	*
	* @param string $path
	*/
	public function includePath($path=null)
	{
		if( $path )
		{
		   set_include_path($path . PATH_SEPARATOR . get_include_path());
		}
		return $this;
	}
	/**
	* Define a imagem que será exibida no fundo da tela principal da aplicação
	* Se for uma imagem do diretório base/imagem/ ou ./imagem/ basta informar o nome da imagem
	*
	* @param string $strNewValue
	*/
	public function setBackgroundImage($strNewValue=null)
	{
		$this->backgroundImage = $strNewValue;
		//$this->waterMark=null;
	}
	/**
	* Retorna a imagem que será exibida no fundo da tela principal da aplicação
	* Se for uma imagem do diretório base/imagem/ ou ./imagem/ basta informar o nome da imagem
	*
	* @param string $strNewValue
	*/
	public function getBackgroundImage()
	{
		if(isset($this->backgroundImage))
		{
			if( file_exists( $this->backgroundImage ) )
			{
				return $this->backgroundImage;
			}
			else
			{
				if( file_exists($this->page->getRoot().'imagens/'.$this->backgroundImage))
				{
					return $this->page->getRoot().'imagens/'.$this->backgroundImage;
				}
				else if( file_exists($this->page->getBase().'imagens/'.$this->backgroundImage))
				{
					return $this->page->getBase().'imagens/'.$this->backgroundImage;
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
	public function setWaterMark($strNewValue=null)
	{
		$this->waterMark = $strNewValue;
		//$this->backgroundImage=null;
	}
	/**
	* Retorna a imagem definida como marca d`agua da aplicacao
	*
	*/
	public function getWaterMark()
	{
		if(isset($this->waterMark))
		{
			if( file_exists( $this->waterMark ) )
			{
				return $this->waterMark;
			}
			else
			{
				if( file_exists($this->page->getRoot().'imagens/'.$this->waterMark))
				{
					return $this->page->getRoot().'imagens/'.$this->waterMark;
				}
				else if( file_exists($this->page->getBase().'imagens/'.$this->waterMark))
				{
					return $this->page->getBase().'imagens/'.$this->waterMark;
				}
			}
		}
		return null;
	}
	/**
	* Altera o estilo da aplicação para a execução dos módulos em janelas flutuantes e independentes, com recurso de minimizar, maximizar e arrastar e soltar.
	* Este modo permite a execução de vários módulos ao mesmo tempo.
	*
	*/
	public function setWindowApp()
	{
		$this->windowApp = true;
	}
	/**
	* Retorna o estado da variavel windowApp
	*
	*/
	public function getWindowApp()
	{
		return $this->windowApp;
	}
	public function setCssFile($strNewValue=null)
	{
		$this->cssFile = $strNewValue;
	}
	public function getCssFile()
	{
		return $this->cssFile;
	}
	public function setLoginInfo($strInfo=null)
	{
		$this->loginInfo = preg_replace('/'.chr(10).'/','<br/>', $strInfo);
	}
	public function getLoginInfo()
	{
		return $this->loginInfo;
	}
	/**
	* Define o conetudo ou o arquivo para montagem do cabeçalho da página
	*
	* @param string $strNewValue
	*/
	public function setHeaderContent($strNewValue=null)
	{
		$this->headerContent = $strNewValue;
	}
	public function getHeaderContent()
	{
		if( preg_match('/\.php?|\.inc|\.htm?/',$this->headerContent ) > 0 )
		{
			if( file_exists( $this->headerContent ) )
			{
				return file_get_contents($this->headerContent);
			}
			else
			{
				return 'Arquivo <b>'.$this->headerContent.'<b> definido para o cabeçalho não encontrado.';
			}
		}
		return $this->headerContent;
	}
	/**
	* Define o conetudo ou o arquivo para montagem do corpo da página
	*
	* @param string $strNewValue
	*/
	public function setBodyContent($strNewValue=null)
	{
		$this->bodyContent = $strNewValue;
	}
	public function getBodyContent()
	{
		if( preg_match('/\.php?|\.inc|\.htm?/',$this->bodyContent ) > 0 )
		{
			if( file_exists( $this->bodyContent ) )
			{
				return file_get_contents($this->bodyContent);
			}
			else
			{
				return 'Arquivo <b>'.$this->bodyContent.'<b> definido para o corpo não encontrado.';
			}
		}
		return $this->bodyContent;
	}
	/**
	* Define o conetudo ou o arquivo para montagem do rodapé
	*
	* @param string $strNewValue
	*/
	public function setFooterContent($strNewValue=null)
	{
		$this->footerContent = $strNewValue;
	}
	public function getFooterContent()
	{
		if( preg_match('/\.php?|\.inc|\.htm?/',$this->footerContent ) > 0 )
		{
			if( file_exists( $this->footerContent ) )
			{
				return file_get_contents($this->footerContent);
			}
			else
			{
				return 'Arquivo <b>'.$this->footerContent.'<b> definido para o rodapé não encontrado.';
			}
		}
		return $this->footerContent;
	}
	/**
	* Retorna o objeto THtmlPage da estrutura da página
	*
	*/
	public function getPage()
	{
		return $this->page;
	}
	public function getBase()
	{
		return $this->page->getBase();
	}
	public function getRoot()
	{
		return $this->page->getRoot();
	}
		//-----------------------------------------------------------------------------
	/**
	* Define o alinhamento vertical dos formulários na tela
	*
	* @param mixed $strNewValue - top,center,bottom
	*/
	public function setVerticalAlign($strNewValue=null)
	{
		$this->verticalAlign = $strNewValue;
	}
	/**
	* Recupera o valor definido para o alinhamento vertical dos formulários na tela
	*/
	public function getVerticalAlign()
	{
		return ( is_null( $this->verticalAlign ) || strtolower($this->verticalAlign) == 'center') ? 'middle' : $this->verticalAlign;
	}
	/**
	* Define o alinhamento horizontal dos formulários na tela
	*
	* @param mixed $strNewValue
	*/
	public function setHorizontalAlign($strNewValue=null)
	{
		$this->horizontalAlign = $strNewValue;
	}
	/**
	* Recupera o valor do alinhamento vertical dos formulários na tela
	*/
	public function getHorizontalAlign()
	{
		return is_null( $this->horizontalAlign ) ? 'center' : $this->horizontalAlign;
	}

}
?>