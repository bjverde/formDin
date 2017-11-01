<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
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
 * GARANTIA; sem uma garantia implícita de ADEQUA�?�?O a qualquer MERCADO ou
 * APLICA�?�?O EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */
include ('../base/classes/webform/TApplication.class.php');

define('APLICATIVO','APPEV20');

$app = new TApplication(); // criar uma instancia do objeto aplicacao
$app->setTitle('Sistema exemplo 2.0 com FormDin '.FORMDIN_VERSION);
//$app->setSUbTitle('Framework para Desenvolvimento de Aplicativos WEB');
//$app->setSUbTitle('Framework para Desenvolvimento de Aplicativos WEB');
$app->setSigla(APLICATIVO);
$app->setVersionSystem('v 2.0.0.0');
$app->setUnit('Departamento de Inform�tica - DI - IBAMA 2011');
$app->setLoginInfo('Bem-vindo');
$app->setMainMenuFile('includes/menu.php');
$app->setWaterMark('brasao_marca_dagua.png');
$app->run();
?>