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
//d($_REQUEST);

$_REQUEST['subform'] = isset($_REQUEST['subform']) ? $_REQUEST['subform'] : '';
if( $_REQUEST['subform'] == 1){
	//require_once('../classes/FormDin3.class.php');
	//$f = new FormDin3(null,'Teste');
	//echo $f->criarForm();
	//die();
}

$frm = new TForm('Exemplo de Subcadastro',200);


/*$frm->addJsFile('prototype/prototype.js',true);
$frm->addJsFile('prototype/window.js');
$frm->addJsFile('prototype/window_ext.js');
$frm->addCssFile('prototype/themes/alphacube.css');
  */
$frm->addTextField('nome','Nome:',null,false);
$frm->addTextField('nome2','Nome Subcadastro:',null,false)->setReadOnly(true);

$frm->setonMaximize('onMaximize');
$frm->addButton('Subcadastro',null,'btn3','subcadastro()');
$frm->show();

?>
<script>
function subcadastro()
{
	// Passsando o campo nome como json. Se não for informado o valor, será lido do formulário
	//fwModalBox('Este é um Subcadastro','../teste.php');
	//fwModalBox('Este é um Subcadastro','www.globo.com.br');
	fwModalBox('Este é um Subcadastro',app_index_file+'?modulo=exe_TForm.php',380,820,callbackModaBox,{'nome':''});
}

/**
* A função de callback da janela modal, recebe 2 parametros:
* 1) array com todos os campos do formulário do subcadastro
* 2) instancia do objeto document do subcadastro
*/
function callbackModaBox(data, doc )
{
	var msg;
    // exemplo de tratamento do retorno do subcadastro
	msg = 'A função callbackModalBox() foi executada!\n\nAcessando os dados da janela modal:\n'+'Campo nome = '+data.nome+'\nCores:'+String(data.cor);
	try{
		msg+='\n\n A cor '+data.cor[0]+' foi selecionada';
	} catch(e){};
	jQuery("#nome2").val(data.nome);
	msg +='\n\nUsando getElementById("nome").value='+doc.getElementById('nome').value;
	alert( msg );
}
</script>