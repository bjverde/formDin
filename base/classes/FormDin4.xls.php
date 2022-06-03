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
//Incluir a classe excelwriter
require "excelwriter.inc.php";

// checkboxes marcados no gride ( quando existir )
if(isset($_REQUEST['checkboxes'])) {
    $checkboxes = json_decode($_REQUEST['checkboxes']);
}else{
    $checkboxes = json_decode("{}");
}

// radiobuttons marcados no gride ( quando existir )
if(isset($_REQUEST['radiobuttons'])) {
    $radiobuttons = json_decode($_REQUEST['radiobuttons']);
}else{
    $radiobuttons = json_decode("{}");
}
$grd = $_GET[ 'gride' ];
$e = new TElement('');
$dirBase = $e->getBase();
$tempFile = $dirBase . 'tmp/tmp_' .$grd .'_'.session_id().'.go';

$dadosGride = null;
$tituloGride = '';
if (FileHelper::exists($tempFile) ) {
    $fileContents = file_get_contents($tempFile);
    $dadosGride = unserialize($fileContents);
    $tituloGride = $_REQUEST[ 'title' ];
} else {
    echo '<h2>Dados do gride não foram salvos em ' . $tempFile . '</h2>';
    die();
}

// nome temporario da planilha
$fileName = $dirBase . 'tmp/Planilha '.date('d-m-Y His').'.xls';
$excel=new ExcelWriter($fileName);
if($excel==false) {
    die($excel->error);
}

// colunas
$keys = array_keys($dadosGride);

// escrever o titulo do gride
if($tituloGride ) {
    $excel->writeRow();
    $excel->writeCol(htmlentities($tituloGride, ENT_COMPAT, ENCODINGS), count($keys));
}

$count=0;
foreach( $_REQUEST as $k => $v )
{
    if (preg_match('/^w_/', $k) ) {
        if($count == 0 ) {
            $count++;
            $excel->writeRow();
            $htmlentities = htmlentities("Critério(s) de Seleção:", ENT_COMPAT, ENCODINGS);
            $excel->writeCol($htmlentities, count($keys));
        }
        $pregReplace   = preg_replace('/(w_|:)/', '', $k);
        $htmlentities0 = htmlentities($pregReplace, ENT_COMPAT, ENCODINGS);
        $htmlentities1 = htmlentities($v, ENT_COMPAT, ENCODINGS);
        $arrayInterno  = array( $htmlentities1,(count($keys)-1) );
        $arrayExterno  = array( $htmlentities0,$arrayInterno );
        $excel->writeLine($arrayExterno);
    }
}

// criar os titulos das colunas
$a=null;
foreach($keys as $v ) {
    $a[]  = htmlentities(utf8_encode($v), ENT_COMPAT, 'UTF-8');
}
$excel->writeLine($a);


foreach($dadosGride[$keys[0]] as $k => $v )
{
    $a=null;
    foreach($keys as $col => $v1 )
    {
        $isNumber = false;
        $x = prepareNumberPlanilha($dadosGride[$v1][$k], $isNumber);

        if(isset($checkboxes->$col) && is_object($checkboxes->$col) ) {
            if(in_array($k, $checkboxes->$col->dados) ) {
                $x = '[ X ]';
            }
            else
            {
                $x='';
            }
        }
        else if(isset($radiobuttons->$col) && is_object($radiobuttons->$col) ) {
            if(in_array($k, $radiobuttons->$col->dados) ) {
                $x = '[ X ]';
            }
            else
            {
                $x='';
            }
        }
        $a[]=$x;
    }
    $excel->writeLine($a);
}
//$excel->writeLine($a);
$excel->close();
//ob_clean();
//flush();

// Configurações header para forçar o download
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"".basename($fileName)."\"");
header("Content-Description: PHP Generated Data");
//echo "O arquivo foi salvo com sucesso. <a href=\"excel3.xls\">excel.xls</a>";
$handle = fopen($fileName, 'rb');
if($handle ) {
    $buffer = '';
    while( !feof($handle) )
    {
        $buffer = fread($handle, 4096);
        echo $buffer;
        ob_flush();
        flush();
    }
    fclose($handle);
}
else
{
    readfile($fileName);
}
// fim
//---------------------------------------------------------------------------
function prepareNumberPlanilha( $v = null,&$isNumber )
{
    if(empty($v)){
        return $v;
    }
    if (!is_numeric(preg_replace('/[,\.]/', '', $v)) ) {
        return $v;
    }
    $isNumber = true;
    // alterar o ponto por virgula para ficar compativel com a planilha
    $posPonto = ( int ) strpos($v, '.');
    $posVirgula = ( int ) strpos($v, ',');

    if ($posPonto && $posVirgula ) {
        if ($posVirgula > $posPonto ) {
            $v = preg_replace('/\./', '', $v);
        }
        else
        {
            $v = preg_replace('/,/', '', $v);
            $v = preg_replace('/\./', ',', $v);
        }
    }
    else if($posPonto ) {
        $v = preg_replace('/\./', ',', $v);
    }
    if(defined('DECIMAL_SEPARATOR') ) {
        $v = preg_replace('/,/', DECIMAL_SEPARATOR, $v);
    }
    return $v;
}
?>
