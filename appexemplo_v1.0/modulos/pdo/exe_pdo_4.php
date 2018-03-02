<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Minist�rio do Planejamento
 * Criado por Lu�s Eug�nio Barbosa
 * Essa vers�o � um Fork https://github.com/bjverde/formDin
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
 * Este arquivo � parte do Framework Formdin.
 *
 * O Framework Formdin � um software livre; voc� pode redistribu�-lo e/ou
 * modific�-lo dentro dos termos da GNU LGPL vers�o 3 como publicada pela Funda��o
 * do Software Livre (FSF).
 *
 * Este programa � distribu�do na esperan�a que possa ser �til, mas SEM NENHUMA
 * GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer MERCADO ou
 * APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/LGPL em portugu�s
 * para maiores detalhes.
 *
 * Voc� deve ter recebido uma c�pia da GNU LGPL vers�o 3, sob o t�tulo
 * "LICENCA.txt", junto com esse programa. Se n�o, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Funda��o do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

$frm = new TForm('Cadastro de Anexo com Postgres');
$frm->addFileField('anexo','Arquivo:',false,'jpg,png,pdf','1k',80,true,true,'callbackAnexo',false);
$img = new TElement('img');
$img->setId('img_preview');
$img->setCss( array('border'=>'none','width'=>'auto','height'=>'auto') );
$frm->addHtmlField('html_imagem',$img,null,null,250,$frm->getWidth()-80,true)->setCss('border','1px dashed blue');

$acao = is_null($_POST['formDinAcao']) ? '' : $_POST['formDinAcao'];

if($acao == 'salvar_anexo')
{
	if( !file_exists($_REQUEST['anexo_temp_name']))
	{
		die('Arquivo inexistente');
	}

    $sql = 'insert into anexo (nom_anexo,des_mime_type,des_extension,lob_anexo) values (?,?,?,?)';
    TPDOConnection::beginTransaction();
 	$oid 		= TPDOConnection::getInstance()->pgsqlLOBCreate();
	$stream 	= TPDOConnection::getInstance()->pgsqlLOBOpen($oid,'w');
	$local 		= fopen($_REQUEST['anexo_temp_name'], 'rb');
	stream_copy_to_stream($local, $stream);
	$lob 		= null;
	$stream 	= null;
	$bvars = array($_REQUEST['anexo']
				,$_REQUEST['anexo_type']
				,'jpg'
				,$oid);
	$stmt = TPDOConnection::prepare($sql);
	$stmt->execute($bvars);
	TPDOConnection::commit();
	if( $frm->addError(TPDOConnection::getError()))
	{
		TPDOConnection::rollBack();
	}
	else
	{
		$frm->setMessage('Arquivo gravado com SUCESSO');
	}
}
else if( $acao=='Ler Lob')
{
	/* funcionando
	TPDOConnection::beginTransaction();
	$data = TPDOConnection::pgsqlLOBOpen(18586, 'r');
	file_put_contents('aaa.jpg',$data);
    die('aaa.jpg');
    */

    /* funcionando
    TPDOConnection::beginTransaction();
	$stream = TPDOConnection::pgsqlLOBOpen(18586, 'r');
	$data = stream_get_contents($stream);
	file_put_contents('aaa.jpg',$data);
    die('aaa.jpg');
    */

    TPDOConnection::beginTransaction();
	$stmt = TPDOConnection::prepare("select nom_anexo, lob_anexo from anexo where seq_anexo=1");
	$stmt->execute();
	$stmt->bindColumn(1, $fileName, PDO::PARAM_STR);
	$stmt->bindColumn(2, $oid, PDO::PARAM_LOB);
	$stmt->fetch(PDO::FETCH_BOUND);
	$data = TPDOConnection::pgsqlLOBOpen($oid, 'r');
	if( file_put_contents($fileName,$data ) )
	{
		//$frm->setMessage($fileName.' gravado');
		echo $fileName;
		$img->setAttribute('src',$fileName);
	}
}

$frm->addButtonAjax('Salvar',null,null,null,'salvar_anexo','Salvando...','text',true,null,'btnSalvar',null,true,false);

$frm->setAction('Atualizar,Ler Lob');
$frm->show();
?>
<script>
/*
function salvar_anexo()
{
	 	fwAjaxRequest(
	        {'callback':function(res)
	        {
            	jQuery("#img_preview").attr('src',res);
	        }
    		,'action':'salvar_anexo'
	        ,'async':true
	        ,'dataType':'text'
	        ,'msgLoad':'Salvando Anexo.'
	        }
	    );
}
*/
function callbackAnexo(tempName,fileName,type,size)
{
	jQuery("#img_preview").attr('src',tempName);
}
</script>

