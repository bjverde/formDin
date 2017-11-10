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

$frm = new TForm('Exemplo de Gride com Campo Anexo');
$frm->addHiddenField('seq_propriedade',22);
$frm->addFileField('anexo','Anexo:',true,'pdf,gif,txt,jpg',null,40,true,null,'callBackAnexar');
$frm->addButton('Limpar Tudo',null,'btnLimparTudo','btnLimparTudoClick()','Tem Certeza?',true,false);
$frm->addHtmlField('campo_gride');
// cria o gride via ajax
$frm->addJavascript('init()');

$acao = isset($acao) ? $acao : null;
if( $acao == 'gravar_anexo')
{
	// grava na sessão os dados do arquivo anexado. A chave é o nome do arquivo 
	// para evitar anexar o mesmo arquivo 2 vezes
	$_SESSION['meus_anexos'][ $_POST['nom_arquivo'] ] =  array('SEQ_PROPRIEDADE'=>$_POST['seq_propriedade'],'NOM_TEMP'=>$_POST['nom_temp']); 
	exit(0);
}
else if( $acao == 'limpar_tudo')
{
	$_SESSION['meus_anexos']=null;
	exit(0);
}
$frm->show();
?>
<script>
function init() {
	fwGetGrid("modulos/grid/exe_gride14.php","campo_gride",{"seq_propriedade":""});
}
function callBackAnexar(tempName,fileName,type,size) {
	jQuery('#nom_arquivo').val(fileName);
	jQuery('#nom_temp').val(tempName);
	jQuery.post(app_url+app_index_file,	{
		'modulo':'modulos/grid/exe_gride13.php'
		,'formDinAcao':'gravar_anexo'
		,'nom_arquivo':fileName
		,'ajax':1
		,'nom_temp':tempName
		,'seq_propriedade':jQuery("#seq_propriedade").val()
	}
	,function( erro ) {
		if( ! erro ) {
			if( confirm('Visualizar o arquivo anexado ?')) {
				fwShowTempFile(tempName,type,fileName);
			}
			init(); // atualizar o gride
		} else {
			alert( erro ); // exibir o erro
		}
	});
}
function btnVisualizarClick(campos,valores) {
		$aValores = valores.split('|');
		fwShowTempFile($aValores[0],null,$aValores[1]);
}
function btnLimparTudoClick() {
	jQuery.post(app_url+app_index_file, {
		'modulo':'modulos/grid/exe_gride13.php'
		,'formDinAcao':'limpar_tudo'
		,'ajax':1
	}
	,function( erro ) {
		if( ! erro ){
			init(); // atualizar o gride
		} else {
			alert( erro ); // exibir o erro
		}
	});	
}
</script>

