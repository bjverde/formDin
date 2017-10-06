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
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */
 
  $menu = new TMenuDhtmlx();
  $menu->add('1',null,'Menu',null,null,'menu-alt-512.png');
  $menu->add('11','1','Pessoa','view/pessoa.php',null,'user916.gif');
  $menu->add('12','1','Tipos de Tipos','view/tipo_tipos.php',null);
  
  
  $menu->add('2',null,'Autoridades',null,null);
  $menu->add('21','2','Cadastro Autoridades','modulos/autoridades.php',null);


  $menu->add('9',null,'Tabelas de Apoio',null,null,'table16.gif');
  $menu->add('91','9','Regi�o','modulos/regiao.php',null);
  $menu->add('92','9','UF','modulos/uf.php',null);
  $menu->add('93','9','Munic�pio ','modulos/municipio.php',null);

  
  $menu->add('10',null,'Config Ambiente',null,null,'setting-gear-512.png');
  $menu->add('101','10','Ambiente Resumido','view/ambiente_resumido.php',null,'information-circle.jpg');
  $menu->add('102','10','Ambiente PHPInfo em IFrame','view/ambiente_phpinfo.php',null,'php_logo.png');
  $menu->add('103','10','Banco MySQL','view/exe_teste_conexao.php',null,'data_base.png');
  $menu->add('104','10','Gerador VO/DAO','../base/includes/gerador_vo_dao.php');
  $menu->add('105','10','Gerador Form VO/DAO','../base/includes/gerador_form_vo_dao.php',null,'smiley-1-512.png');
  
  $menu->getXml();
?>
