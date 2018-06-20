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

$frm = new TForm('Exemplo Campo Arquivo',300,600);
$frm->setFlat(true);
//$frm->addTextField('descricao','Descrição:',20,true);
//$frm->addTextField('descricao2','',20,true);
// define a largura das colunas verticais do formulario para alinhamento dos campos
$frm->setColumns(array(100,100));


// campo arquivo ajax ( assyncrono )
//$frm->addFileField('anexo1','Arquivo 1:',null,'doc,pdf,rar,zip','1M');

// campo arquivo normal
//$frm->addFileField('anexo2','Arquivo 2:',true,'doc,pdf,rar,zip','1M',null,false);
$frm->addFileField('anexo_async','Anexo Async:',true,'pdf,gif,txt,jpg,doc,xls,odt','4M',40,true,null,'callBackAnexar');
$frm->addTextField('arquivo','Arquivo:',60);
$frm->addTextField('tipo'	,'Tipo:',40);
$frm->addTextField('extensao'	,'Extensão:',10);
$frm->addTextField('tamanho','Tamanho (kb):',20);
$frm->addTextField('local'	,'Local temp:',60);

//d($_SESSION);
//print_r(file_put_contents($frm->getBase().'tmp/upload_'.md5(session_id().$res_alt['DES_ARQUIVO'][0]),'teste') );
$frm->addButton('Limpar JS',null,'btnLimpar','fwClearChildFields()');
$frm->setAction('Gravar,Novo,TempName');

$acao = isset($acao) ? $acao : null;
switch($acao) {
	case 'Gravar':
	{
		if( $frm->validate() ) {
			$lobAnexo = $frm->getField('anexo_async')->getContent();
			//echo $dadosAnexo;
			//$bvars = $frm->createBvars('anexo_async');
			//d($bvars);
			//$frm->setMessage('Dados Gravados com Sucesso!');
			d($_POST);
			$frm->clearFields();
		}
	}
}
$frm->show();
//d($_POST,'Conteudo do $_POST');
?>
<script>
function callBackAnexar(tempName,fileName,type,size,extension)
{
	jQuery('#arquivo').val(fileName);
	jQuery('#local').val(tempName);
	jQuery('#tamanho').val(size);
	jQuery('#tipo').val(type);
	jQuery('#extensao').val(extension);
	//alert('Função de callback.\n\nTemp name:'+tempName+'\nFile name:'+fileName+'\nType:'+type+'\nSize?'+size);
	if( confirm('Visualizar o arquivo anexado ?'))
	{
		fwShowTempFile(tempName,type,fileName,extension);
	}
}
function btnTempnameOnClick()
{
	alert( jQuery("#anexo_async_temp_name").val() );

}
</script>

