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
define('MIGRATE_JQUERY', false);

require_once('includes/constantes.php');
require_once('includes/config_conexao.php');
require_once('../base/classes/webform/TApplication.class.php');
require_once('classes/autoload_ap1v.php');
require_once('dao/autoload_ap1v_dao.php');


//$app = new TApplication('Exemplos das Funcionalidades',null,'FORMDIN 4','Centro Nacional de Telemática - CNT');
$app = new TApplication(); // criar uma instancia do objeto aplicacao
$app->setAppRootDir(__DIR__);
$app->setTitle(SYSTEM_NAME);
$app->setSubtitle(APLICATIVO);
$app->setSigla(APLICATIVO);
$app->setImgLogoPath('imagem/appv1_logo.png');
$app->setUnit('Centro Nacional de Telemática - CNT');
$app->setVersionSystem(SYSTEM_VERSION);
$app->setMenuIconsPath('imagem/');

$app->setWidth(990);
$app->setNorthSize(55);
$app->setMainMenuFile('includes/menu.php');
$app->setConfigFile(null);
//$app->setLoginFile('includes/tela_login.php');
$app->setOnGetLoginInfo('minhaFuncaoLogin');
//$app->setConnectionFile(null);

//$app->addIncludeFile('config.php');
//$app->getLoCenter()->setCss('background-color','blue');

//$app->setBackgroundImage(null);
$app->setBackgroundImage('../css/imagens/app/bg_listrado.jpg');
//$app->setBackgroundImage('../imagens/bg_blackmosaic.png');


// testar prototyï¿½
set_error_handler("exception_error_handler");
$app->run();

function minhaFuncaoLogin()
{
    return 'Olá, FormDin '.FORMDIN_VERSION;
}

function exception_error_handler($errno, $errstr, $errfile, $errline)
{
    echo '<pre>';
    //throw new ErrorException($errstr, 0, $errno, $errfile, $errline);

    echo '<div style="text-align:left;border:1px solid red;width:100%;font-size:18px;">Erro N.'.$errno.'<br>'.
    'Mensagem:'.$errstr.'<br>'.
    'Arquivo:'.$errfile.'<br>'.
    'Linha:'.$errline.'</div></pre>'.
    '<script>try{top.app_unblockUI();}catch(e){};</script>';
}
