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

?>

<script>
//-----------------------------------------------------------------------
function fechar(){
	// retirar o iframe de cima dos campos porque está escondendo o cursor do campo em edição
	parent.document.getElementById(this.name).style.top = -5000;
	parent.document.getElementById(this.name).style.visibility='hidden';
}
//-----------------------------------------------------------------------
function centralizar() {
	var wTotal = parent.document.body.clientWidth;
	var hTotal = parent.document.body.clientHeight;
	var wIframe = parseInt( parent.document.getElementById(this.name).style.width);
	var hIframe = parseInt( parent.document.getElementById(this.name).style.height);
	var t,l;
	t = parseInt( ( hTotal - hIframe)/2);
	l = parseInt( ( wTotal - wIframe)/2);
	t= t + parent.document.body.scrollTop;
	l= l + parent.document.body.scrollLeft;
	parent.document.getElementById(this.name).style.top = t;
	parent.document.getElementById(this.name).style.left= l;
}
centralizar();
</script>
<?php

$Erros = explode('|',$_GET['erros']);
print '<b><font face="Arial" size="4"><center>ERROS ENCONTRADOS:</font></center></b><br><hr><font face="Arial" color=red size="2"><ol>';
for ($i=0; $i < count( $Erros ); $i++) {
	print '<li><b>'.$Erros[$i].'</b><br><br>';
}
print '</ol></font><hr><center>';
print '<input type="button" onclick="fechar();" value="Fechar"></center>';
?>

