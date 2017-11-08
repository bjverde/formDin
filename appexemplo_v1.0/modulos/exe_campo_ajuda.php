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

$frm = new TForm('Campos Campo Ajuda e campo BoxField',300,500);

$frm->addHtmlField('html1','Exemplo de ajuda utilizando boxField.')->setCss('color','blue');
$frm->addTextField('nome','Nome:',50,false,50,'',true,null,null,false);
$frm->addBoxField('bxNome','Informe o nome completo do proprietário do terreno',null,null,null,null,null,null,null);
 
$frm->addHtmlField('html2','Exemplo de ajuda utilizando boxField com imagem.')->setCss('color','blue');
$frm->addBoxField('bxImagem',null,$this->getBase()."js/jquery/facebox/stairs.jpg",null,'Visualizar Foto:','folder.gif',true,null,null,'Imagem');
$frm->addHtmlField('html3','Exemplo de ajuda utilizando setHelpOnLine.')->setCss('color','blue');

$frm->addTextField('endereco01','Endereço:',50,false,50,'',true,null,null,false)->setHelpOnLine('Como preencher o campo Endereço ?',300,800,'ajuda/ajuda.txt.html');
$frm->addTextField('endereco02','Endereço:',50,false,50,'',true,null,null,false)->setHelpOnLine('Como preencher o campo Endereço ?',300,800);
$frm->addBoxField('bxAjax',null,"http://localhost",'ajax','Visualizar Ajax:',null,true,null,null,'Conteudo ajax');


$frm->setAction('Atualizar');

// Firefox aparece o erro
//Load denied by X-Frame-Options: https://www.google.com.br/?modalbox=1&subform=1&facebox=1 does not permit cross-origin framing.
//$frm->addButton('Teste',null,'btnTeste','showAjuda()');

$frm->show();
?>
<script>
function fwOpenHelpFile(file) {
	fwFaceBox(app_url+'ajuda/'+file,true);
	//fwFaceBox(app_index_file+'?modulo='+pastaBase+'callbacks/helpOnLineLoad.php&ajax=1&file=appbase/ajuda/'+file,true);
}
function showAjuda()
{
    /*var wTotal = document.body.clientWidth;
    var hTotal = document.body.clientHeight;
  	var	h= jQuery("body").height()-15;
	var	w= jQuery("body").width()-15;
    //alert( w );
	//fwFaceBox('http://www.google.com.br',true,h,w);
	*/
	fwModalBox('teste','http://www.g1.com.br');


	/*
	if( top.app_prototype )
	{
		//jQuery.facebox('something cool<br>Linha<br>Linha<br>Linha<br>Linha<br>Linha<br>Linha<br>Linha<br>Linha<br>fim');
		top.jQuery.facebox(function() {
  		top.jQuery.get('base/js/jquery/facebox/README.txt', function(data) {
	    top.jQuery.facebox('<div style="border:1px solid red;width:400;height:300px;">'+data+'</div>')
		  })
		})
	}
	else
	{
		jQuery.facebox(function() {
  		jQuery.get('base/js/jquery/facebox/README.txt', function(data) {
	    jQuery.facebox('<div style="border:1px solid red;width:400;height:300px;">'+data+'</div>')
		  })
		})

	}
	*/


}
</script>
