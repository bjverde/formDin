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

if( $_REQUEST['id'] )
{
	print $_REQUEST['value'];
	return 'luis';
}
$file = $_REQUEST['file'];
if(strpos('http',$file)===0)
{
	header('location:'.$file);
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery/jquery.js"></script>
<script type="text/javascript" src="../js/jquery/jquery.jeditable.mini.js"></script>
<script language="javascript" >
	jQuery(document).ready(
		function()
		{
			//http://www.appelsiini.net/projects/jeditable
			/*jQuery('.editable').editable('../../modulos/gravar_ajuda.php',
			{
         		type	: 'textarea',
         		submit  : 'Salvar'
     		});
     		*/
			jQuery('.editInPlace').editable('../../base/callbacks/helpOnLine.php',
			{
         		type	: 'textarea',
         		submit  : 'Salvar',
				/*style  : 'inherit'*/
				cssclass : "editable"
				
     		});
		}
	);
</script>
<style>
.editInPlace 
{
	width:100%;
	height:85%;
	font-family: Arial;
	font-size: 12px;
	background-color: white;	
}
.editable
{
	background-color:yellow;
	width:300px;
	height:150px;
}
</style>
</head>
<body>
<?php
print '<div class="editInPlace" id="'.$file.'">'."\n";
print '<pre>';
print_r($_REQUEST);
print '</pre>';
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
// criar o arquivo
if( ! file_exists($file) )
{
	//file_put_contents($file,'O texto de ajuda para este campo ainda não foi definido!');
}
if( file_exists($file) )
{
	print 'Arquivo:'.$file.'<hr>';
	print file_get_contents($file);
}
?>
</div>
</body>
</html>
