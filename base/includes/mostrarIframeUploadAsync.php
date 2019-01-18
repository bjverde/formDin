<?php 
/**
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
?>
<html>
<head>
<script language="JavaScript">
function resetarIframe() {
	window.parent.document.getElementById('div_iframe_geral').style.display='none';
	document.getElementById('iframeMostrarUpload').src='mostrarUploadAsync.php';
}
</script>
</head>
<body>
<table width="100%" height="100%">
<tr><td>
<iframe name="iframeMostrarUpload" src="mostrarUploadAsync.php" id="iframeMostrarUpload" frameborder="0" marginWidth="0" marginHeight="0" width="100%" height="100%"></iframe>
</td></tr>
<tr height="20px">
<td align="center" valign="bottom"><input type=button value="Fechar" onclick="resetarIframe()" style="font-size:11px;color:#336699;font-family:verdana;background:silver;border-style:groove;font-weight:bold;cursor:pointer;"></td></tr>
</table>
</body>
</html>

