<?php
function getMsgFPDF() {
	$msg = '<b>ATENÇÃO</b>: a função FPDF 1.81 não funciona corretamente com UTF-8.
          <br> Converta todas as string com utf8_decode ou similar.';
    return $msg;
}
?>