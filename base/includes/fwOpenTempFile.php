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
error_reporting(0);
/*
Visualizar arquivo anexado ainda não salvos que ainda estão na pasta temporária
*/
$extension		= isset( $_REQUEST['extension'] ) 	? $_REQUEST['extension'] : '';
$extension		= ( $extension=='undefined' ) ? '' : $extension;
$tempName   	= isset( $_REQUEST['tempName'] ) 	? $_REQUEST['tempName'] : null;
$contentType   	= isset( $_REQUEST['contentType'] ) ? $_REQUEST['contentType'] : null;
$contentType	= ( $contentType=='null' ) ? null : $contentType;
$fileName   	= isset( $_REQUEST['fileName']) 	? $_REQUEST['fileName']: null; // opcional se tiver o tempFile e o contentType

if( ! file_exists($tempName ) )
{
	die('<h3>Arquivo '.$tempName.' não encontrado!</h3>');
}
if( $ct = getContentType( $fileName.'.'.$extension ) )
{
    $contentType = $ct;
}

setHeader( $tempName, $contentType, $extension, $fileName);


function setHeader($tempName, $contentType=null, $extension=null,$fileName=null)
{
	$fileName = is_null( $fileName ) ? $tempName : $fileName;
	if( !$extension)
	{
		$aFileParts = pathinfo($fileName);
		$extension = $aFileParts['extension'];
		if( ! file_exists( $tempName.'.'.$extension) )
		{
			if( copy( $tempName,$tempName.'.'.$extension) )
			{
				$tempName = $tempName.'.'.$extension;
			}
		}
		else
		{
			$tempName = $tempName.'.'.$extension;
		}
	}

	/*echo 'tempName:'.$tempName.'<br>';
	echo 'contentType:'.$contentType.'<br>';
	echo 'extension:'.$extension.'<br>';
	echo 'fileName:'.$fileName.'<br>';
	die();*/
	//d($fileName.'<hr>'.$extension.'<hr>'.$contentType.'<hr>'.$tempName,null,true);
    //die();
    header("Cache-Control: no-cache");
 	header("Pragma: no-cache");
 	header("Expires: Fri, 01 Jan 2000 05:00:00 GMT");
    if( is_null( $contentType ) )
    {
		header("Content-Type: application/download");
		header("Content-Disposition:attachment; filename=\"".preg_replace('/^tmp_/','',baseName($fileName))."\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Description: File Transfer");
		header("Content-Length: ".filesize($tempName));
	}
    else
    {
		header("Pragma: public"); // required
		header("Expires: 0");
		// estes tipos abrem diretamente no browser
		if( !preg_match('/htm|xml|pdf|jpe?g|bmp|gif|txt/i',$extension ) )
		{
			header("Content-Disposition:attachment; filename=\"".preg_replace('/^tmp_/','',baseName($fileName))."\"");
		}
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers
		header("Content-Type: $contentType");
		header("Content-Transfer-Encoding: binary");
	}
   	ob_clean();
	flush();
	$handle = fopen( $tempName, 'rb' );
	if( $handle )
	{
		$buffer = '';
		while( !feof( $handle ) )
		{
			$buffer = fread( $handle, 4096 );
			echo $buffer;
			ob_flush();
			flush();
		}
		fclose ( $handle );
	}
	else
	{
		readfile ( $tempName );
	}
}
function getContentType( $fileName = null )
{
    $contentType=null;
    if( preg_match('/\.gif/i',$fileName) > 0  )
    {
        $contentType="image/gif";
    }
    else if( preg_match('/\.jpe?g/i',$fileName) > 0  )
    {
        $contentType="image/jpg";
    }
    else if( preg_match('/\.docx?/i',$fileName) > 0  )
    {
        $contentType="application/msword";
    }
    else if( preg_match('/\.pdf/i',$fileName) > 0  )
    {
        $contentType="application/pdf";
    }
    else if( preg_match('/\.zip/i',$fileName) > 0  )
    {
        $contentType="application/zip";
    }
    else if( preg_match('/\.gz/i',$fileName) > 0  )
    {
        $contentType="application/x-gzip";
    }
    else if( preg_match('/\.rar/i',$fileName) > 0  )
    {
        $contentType="application/x-rar-compressed";
    }
    else if( preg_match('/\.xls/i',$fileName) > 0  )
    {
        $contentType="application/ms-excel";
    }
    else if( preg_match('/\.ppt/i',$fileName) > 0  )
    {
        $contentType="application/ms-powerpoint";
    }
    else if( preg_match('/\.bmp/i',$fileName) > 0  )
    {
        $contentType="image/bmp";
    }
    else if( preg_match('/\.png/i',$fileName) > 0  )
    {
        $contentType="image/png";
    }
    else if( preg_match('/\.tif/i',$fileName) > 0  )
    {
        $contentType="image/tif";
    }
    else if( preg_match('/\.aud?/i',$fileName) > 0  )
    {
        $contentType="application/audio/basic";
    }
    else if( preg_match('/\.wav/i',$fileName) > 0  )
    {
        $contentType="application/audio/wav";
    }
    else if( preg_match('/\.mid/i',$fileName) > 0  )
    {
        $contentType="application/audio/x-mid";
    }
    else if( preg_match('/\.avi/i',$fileName) > 0  )
    {
        $contentType="application/video/avi";
    }
    else if( preg_match('/\.mp3/i',$fileName) > 0  )
    {
        $contentType="application/audio/mp3";
    }
    else if( preg_match('/\.mpg/i',$fileName) > 0  )
    {
        $contentType="application/video/mpg";
    }
    else if( preg_match('/\.mpeg/i',$fileName) > 0  )
    {
        $contentType="application/video/mpeg";
    }
    else if( preg_match('/\.swf/i',$fileName) > 0  )
    {
        $contentType="application/x-shockwave-flash";
    }
    else if( preg_match('/\.txt/i',$fileName) > 0  )
    {
        $contentType="text/plain";
    }
    return $contentType;
}
?>
