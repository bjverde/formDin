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

/*
Visualizador de campos blob
*/
$table_name         = $_REQUEST['table_name'];
$blob_column_name   = $_REQUEST['blob_column_name'];
$file_column_name   = $_REQUEST['file_column_name'];
$type_column_name   = $_REQUEST['type_column_name'];
$key_column_name    = $_REQUEST['key_column_name'];
$key_value          = $_REQUEST['key_value'];
$file_extension     = $_REQUEST['file_extension'];
$pastaBase          = isset($_REQUEST['pastaBase']) ? $_REQUEST['pastaBase'] :'base/';

if (! file_exists($pastaBase.'tmp')) {
    die('<h3>Diretoiro '.$pastaBase.'tmp não encontrado!</h3>');
}

if (!$table_name) {
    die('Necessário informar o nome da tabela. Parametro: table_name');
}
if (!$blob_column_name) {
    die('Necessário informar o nome da coluna que contem os dados binarios ( blob ). Parametro: blob_column_name');
}
if (!$file_column_name && !$type_column_name && !$file_extension) {
    die('Necessário informar o nome da coluna ou o tipo do arquivo ou a extensão do arquivo que será exibido. Parametro: file_column_name ou type_colum_name ou file_extension');
}
if (!$key_column_name) {
    die('Necessário informar o nome da coluna chave da tabela. Parametro: key_column_name');
}
if (!$key_value) {
    die('Necessário informar o id do registro que será consultado. key_value');
}

$aKey_column_name   = explode('|', $key_column_name);
$aKey_value         = explode('|', $key_value);
$isOracle=false;
if (preg_match('/\.PK\a?/i', $table_name) == 0) {
    $where='';
    foreach ($aKey_column_name as $k => $v) {
        if (isset($aKey_value[$k])) {
            $where .= ( $where == '' ? ' where ': ' and ').$v."='".$aKey_value[$k]."'";
        }
    }

    $sql = "select ".$blob_column_name.( ($file_column_name) ? ', '.$file_column_name : '').( ($type_column_name) ? ', '.$type_column_name : '').' from '.$table_name.' '.$where;
} else {
    $sql = $table_name;
    $aTemp = explode('|', $table_name);
    $sql = $aTemp[0];
    $intCacheTime = isset($aTemp[1]) ? $aTemp[1] : 3600;
    $isOrale=true;
}

// se for passado o nome de uma tabela, criar o comando select
if (!$isOracle && ( !class_exists('TPDOConnection') || !TPDOConnection::getInstance() )) {
    $intCacheTime = isset($intCacheTime) ? $intCacheTime : 3600;
    $bvars=null;
    foreach ($aKey_column_name as $k => $v) {
        $bvars[strtoupper($v)]= isset($aKey_value[$k])?$aKey_value[$k]:null;
    }
    print_r(recuperarPacote($sql, $bvars, $res, (int)$intCacheTime));
    if (isset($bvars[strtoupper($blob_column_name)])) {
        $res[strtoupper($blob_column_name)][0] = $bvars[strtoupper($blob_column_name)];
    }
    if ($erro) {
        print_r($erro);
        die();
    }
} else {
        $res = TPDOConnection::executeSql($sql);
}
// limpar arquivos temporários antigos
$t=time();
$h = opendir($pastaBase . "tmp");
while ($file = readdir($h)) {
    if (substr($file, 0, 3) == 'tmp' && substr($file, -4) == '.pdf') {
        $path = $pastaBase . 'tmp/' . $file;
        if ($t - filemtime($path) > 300) {
            @unlink($path);
        }
    }
}
closedir($h);


if ($file_column_name) {
    $file_column_name = strtoupper($file_column_name);
    if (isset($res[$file_column_name][0]) && $res[$file_column_name][0]) {
        $tempfilename = $pastaBase.'tmp/tmp_'.$res[$file_column_name][0];
    } else {
        //print $file_column_name;
        //$tempfilename = $pastaBase.'tmp/tmp_'.date('YmdHis').'.'.preg_replace('/\./','',$res[$type_column_name][0]);
        $tempfilename = $pastaBase.'tmp/tmp_'.$file_column_name;
    }
    if ($tempfilename) {
        $aFileParts = pathinfo($tempfilename);
        $baseName = preg_replace('/tmp_/', '', $aFileParts['basename']);
        $tempfilename = $pastaBase.'tmp/tmp_'.$baseName;
    }
} else {
    if ($type_column_name) {
        $tempfilename = $pastaBase.'tmp/tmp_'.date('YmdHis').'.'.preg_replace('/\./', '', $res[$type_column_name][0]);
    } else {
        $tempfilename = $pastaBase.'tmp/tmp_'.date('YmdHis').'.'. ( is_null($file_extension) ? 'pdf' : $file_extension );
    }
}
if (file_exists($tempfilename)) {
    unlink($tempfilename);
}
if ($res) {
    if (file_put_contents($tempfilename, $res[strtoupper($blob_column_name)][0])) {
        setHeader($tempfilename);
    }
} else {
    print 'Anexo não existe';
}
function setHeader($fileName)
{

    $contentType=null;

    if (preg_match('/\.gif/i', $fileName) > 0) {
        $contentType="application/image/gif";
    } elseif (preg_match('/\.jpe?g/i', $fileName) > 0) {
        $contentType="application/image/jpg";
    } elseif (preg_match('/\.docx?/i', $fileName) > 0) {
        $contentType="application/msword";
    } elseif (preg_match('/\.pdf/i', $fileName) > 0) {
        $contentType="application/pdf";
    } elseif (preg_match('/\.zip/i', $fileName) > 0) {
        $contentType="application/zip";
    } elseif (preg_match('/\.gz/i', $fileName) > 0) {
        $contentType="application/x-gzip";
    } elseif (preg_match('/\.rar/i', $fileName) > 0) {
        $contentType="application/x-rar-compressed";
    } elseif (preg_match('/\.xls/i', $fileName) > 0) {
        $contentType="application/ms-excel";
    } elseif (preg_match('/\.ppt/i', $fileName) > 0) {
        $contentType="application/ms-powerpoint";
    } elseif (preg_match('/\.bmp/i', $fileName) > 0) {
        $contentType="application/image/bmp";
    } elseif (preg_match('/\.png/i', $fileName) > 0) {
        $contentType="application/image/png";
    } elseif (preg_match('/\.tif/i', $fileName) > 0) {
        $contentType="application/image/tif";
    } elseif (preg_match('/\.aud?/i', $fileName) > 0) {
        $contentType="application/audio/basic";
    } elseif (preg_match('/\.wav/i', $fileName) > 0) {
        $contentType="application/audio/wav";
    } elseif (preg_match('/\.mid/i', $fileName) > 0) {
        $contentType="application/audio/x-mid";
    } elseif (preg_match('/\.avi/i', $fileName) > 0) {
        $contentType="application/video/avi";
    } elseif (preg_match('/\.mp3/i', $fileName) > 0) {
        $contentType="application/audio/mp3";
    } elseif (preg_match('/\.mpg/i', $fileName) > 0) {
        $contentType="application/video/mpg";
    } elseif (preg_match('/\.mpeg/i', $fileName) > 0) {
        $contentType="application/video/mpeg";
    } elseif (preg_match('/\.swf/i', $fileName) > 0) {
        $contentType="application/x-shockwave-flash";
    } elseif (preg_match('/\.txt/i', $fileName) > 0) {
        $contentType="application/txt";
    }
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
    header("Expires: Fri, 01 Jan 2000 05:00:00 GMT");
    if (is_null($contentType)) {
        header("Content-Type: application/download");
        header("Content-Disposition:attachment; filename=\"".preg_replace('/^tmp_/', '', baseName($fileName))."\"");
        header("Content-Transfer-Encoding:­ binary");
        header("Content-Description: File Transfer");
        header("Content-Length: ".filesize($fileName));

        $handle = fopen($fileName, 'rb');
        if ($handle) {
            $buffer = '';
            while (!feof($handle)) {
                $buffer = fread($handle, 4096);
                echo $buffer;
                ob_flush();
                flush();
            }
            fclose($handle);
        } else {
            readfile($fileName); // para arquivos muito grandes não funciona
        }
    } else {
        header('Content-type: '.$contentType);
        header("Location: $fileName");
    }
}
