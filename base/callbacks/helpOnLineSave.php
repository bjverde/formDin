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

sleep(1); // mostrar a imagem de processando.
ini_set('default_charset','iso-8859-1');
error_reporting(0);
$file = $_REQUEST['id'];
/**
* se no nome do arquivo não tiver a extensão .html, adicionar a extensão .html e se o arquivo
* não existir criar um em branco
*/
if( strpos(strtolower($file),'.html') === false)
{
	$file.='.html';
}
// se passar o nome do arquivo puro, procurar na pasta ajuda/
if( strpos( $file, '../' ) === false)
{
	$file = '../../ajuda/'.$file;
}
// gravar o arquivo / Remover tag iframe
$_REQUEST['value'] = preg_replace('/{(<iframe).*?(>).*?(<\/iframe>)}/i', '', $_REQUEST['value']);
//$_REQUEST['value'] .=utf8_encode('<hr><center>Alterado por:Luis Eugênio em '.date('d/m/Y h:i:s').'</center>');
if(!file_put_contents($file,utf8_decode($_REQUEST['value'])))
{
	print '<script>alert("Não foi possível gravar o texto, verifique as permissões de escrita no arquivo '.$file.')</script>';
	return;
}
print utf8_decode($_REQUEST['value']);
print '<script>alert("Gravação Ok");</script>';
?>
