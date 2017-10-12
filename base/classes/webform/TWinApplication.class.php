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

include_once( 'autoload_formdin.php');
class TWinApplication   extends THtmlPage
{
	public function __construct()
	{
		parent::__construct();
		$this->addJsCssFile('prototype/themes/default.css');
		$this->addJsCssFile('prototype/themes/lighting.css');
		$this->addJsCssFile('prototype/themes/mac_os_x.css');
		$this->addJsCssFile('prototype/themes/alphacube.css');
		$this->addJsCssFile('app_prototype.css');
		$this->addJsCssFile('dhtmlx/codebase/skins/dhtmlxmenu_clear_silver.css');
		$this->addJsCssFile('prototype/prototype.js');
		$this->addJsCssFile('prototype/effects.js');
		$this->addJsCssFile('prototype/window.js');
		$this->addJsCssFile('prototype/window_ext.js');
		$this->addJsCssFile('prototype/window_effects.js');
		$this->addJsCssFile('prototype/javascripts/debug.js');
		$this->addJsCssFile('dhtmlx/codebase/dhtmlxcommon.js');
		$this->addJsCssFile('dhtmlx/codebase/dhtmlxmenu_cas.js');
		$this->addJsCssFile('app_prototype.js');

		$divTitle = new TElement('div');
		$divTitle->setId('app_header_title');
		$divTitle->setProperty('align','center');
		$this->addInBody($divTitle);
		//div menu principal
		$div = new TElement('div');
		$div->setId('div_main_menu');
		$div->setProperty('align','center');
		$this->addInBody($div);
		// area de trabalho
		$div = new TElement('div');
		$div->setId('dock');
		$this->addInBody($div);

		$divTheme = new TElement('div');
		$divTheme->setId('theme');
		$divTheme->add('Tema:');
		$divTheme->add(new TSelect('appTheme','0=Cinza Claro,1=Mac Os X,2=Azul Claro,3=Verde Claro',null,null,null,nulll,nulll,''));
		$div->add($divTheme);
	}
}
?>