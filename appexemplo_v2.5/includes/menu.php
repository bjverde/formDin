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

//Pega a lista de Menus do Banco em função do usuario logado
$userMenu = Acesso::getAcessoUserMenuByLogin();

$menu = new TMenuDhtmlx();
foreach ($userMenu['IDMENU'] as $key => $value){
    if($userMenu['SIT_ATIVO'][$key]=='S'){
        $disabled = $userMenu['DISABLED'][$key]=='N'?false:true;
        $menu->add($value
                  ,$userMenu['IDMENU_PAI'][$key]
                  ,$userMenu['NOM_MENU'][$key]
                  ,$userMenu['URL'][$key]
                  ,$userMenu['TOOLTIP'][$key]
                  ,$userMenu['IMG_MENU'][$key]
                  ,$userMenu['IMGDISABLED'][$key]
                  ,$disabled
                  ,$userMenu['HOTKEY'][$key]
                  ,$userMenu['BOOLSEPARATOR'][$key]
                  ,$userMenu['JSONPARAMS'][$key]
                  );
    }
}
$menu->getXml();

/***
$menu = new TMenuDhtmlx();
$menu->add(1, null, 'Menu', null, null, 'menu-alt-512.png');
$menu->add(11,1,'marca','modulos/marca.php');
$menu->add(12,1,'pedido','modulos/pedido.php');
$menu->add(13,1,'pedido_item','modulos/pedido_item.php');
$menu->add(14,1,'produto','modulos/produto.php');

$menu->add(2, null, 'Pessoas', null, null);
$menu->add(21,2,'pessoa','modulos/pessoa.php');
$menu->add(22,2,'pessoa_fisica','modulos/pessoa_fisica.php');
$menu->add(23,2,'pessoa_juridica','modulos/pessoa_juridica.php');

$menu->add(3, null, 'Autoridades', null, null);
$menu->add(31, 3, 'Cadastro Autoridades', 'modulos/autoridade.php', null);

$menu->add(7, null, 'Tabelas de Apoio', null, null, 'table16.gif');
$menu->add(71, 7,'Região', 'modulos/regiao.php', null, null, null, false, null);
$menu->add(72, 7,'UF','modulos/uf.php');
$menu->add(73, 7,'Município','modulos/municipio.php');
$menu->add(74, 7,'Meta Tipo','modulos/meta_tipo.php');
$menu->add(75, 7,'Tipo','modulos/tipo.php');

$menu->add(8, null, 'Acesso', null, null, 'icon-key-yellow.png');
$menu->add(81, 8, 'Usuários', 'modulos/acesso_user.php', null, 'user916.gif');
$menu->add(82, 8, 'Pefil de Acesso', 'modulos/acesso_perfil.php', null, 'icon_mask.png');
$menu->add(83, 8, 'Menu', 'modulos/acesso_menu.php', null, 'icon-menu.png');
$menu->add(84, 8, 'Relacionar Perfil com Menu','modulos/acesso_perfil_menu.php');
$menu->add(85, 8, 'Relacionar Perfil com Usuário','modulos/acesso_perfil_user.php');
$menu->add(86, 8, 'Alterar a minha senha','modulos/acesso_senha.php', null, 'lock16.gif');

$menu->add(9, null, 'Sobre', 'modulos/sys_about.php', null, 'information-circle.jpg');

$menu->add(10,null,'Config Ambiente',null,null,'setting-gear-512.png');
$menu->add(101,10,'Ambiente Resumido','modulos/sys_environment_summary.php',null,'information-circle.jpg');
$menu->add(102,10,'PHPInfo','modulos/sys_environment.php',null,'php_logo.png');
$menu->add(104,10,'Gerador VO/DAO','../base/includes/gerador_vo_dao.php');
$menu->add(105,10,'Gerador Form VO/DAO','../base/includes/gerador_form_vo_dao.php',null,'smiley-1-512.png');

$menu->getXml();
***/
?>
