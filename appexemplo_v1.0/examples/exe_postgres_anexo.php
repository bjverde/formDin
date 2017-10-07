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

  $frm = new TForm('Anexar');
  $frm->addFileField('anexo','Anexo:',true,'gif,zip,jpg,png,bmp,doc,txt,pdf,xls,gif,jpeg');
  $frm->addFileField('anexo2','Anexo II:',true,'gif,zip,jpg,png,bmp,doc,txt,pdf,xls,gif,jpeg',null,null,false);
  $frm->addHtmlGride('html_anexo','base/exemplos/gride_anexo.php','gdAnexo');
  switch($acao)
  {
	  case 'Gravar':
	  
	  	print 'temp:'.$frm->getField('anexo')->getTempFile().'<br>';
	  	print $frm->getField('anexo')->getFileName().'<br><hr>';
	  	print 'Temp:'.$frm->getField('anexo2')->getTempFile().'<br>';
	  	print $frm->getField('anexo2')->getFileName().'<br>';
	  	
	  
	    break;
	  	TPDOConnection::connect();
  		TPDOConnection::getInstance()->beginTransaction();  	  
		$aFileParts = pathinfo($frm->getvalue('documento'));
		$fileName 	= $frm->getField('anexo')->getTempFile();
		$oid 		= TPDOConnection::getInstance()->pgsqlLOBCreate();
		$stream 	= TPDOConnection::getInstance()->pgsqlLOBOpen($oid, 'w');
		$local 		= fopen($fileName, 'rb');
		stream_copy_to_stream($local, $stream);
		$local 		= null;
		$stream 	= null;
		$stmt 		= TPDOConnection::prepare('insert into anexo( nom_anexo, lob_anexo) values (?,?)');
		$aDados		= array($frm->getValue('anexo'),$oid);
		$stmt->execute($aDados);
		TPDOConnection::getInstance()->commit();
	  	print TPDOConnection::getError();
	  break;
	  //---------------------------------------------------
  }
  $frm->setAction('Gravar,Atualizar');
  $frm->show();
?>
<script>
function visualizar(campo, valor)
{
	//fwModalBox('Visualizar',app_url+app_index_file+'?ajax=1&modulo=includes/visualizar_anexo.php&id='+valor,600,800);
	window.open(app_url+app_index_file+'?ajax=1&modulo=includes/visualizar_anexo.php&id='+valor,'win','toolbar=no,location=no,scrollbars=no,width=0,height=0,top=100,left=180');
}
</script>

