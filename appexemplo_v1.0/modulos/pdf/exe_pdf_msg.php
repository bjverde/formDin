<?php
function getMsgFPDF()
{
    $msg = '<b>ATENÇÃO</b>: Esse exemplo utiliza o TPDF que é uma extensão do FPDF 1.81 e não funciona corretamente com UTF-8.
           <br>Os arquivos podem ser UTF-8 porém deverá converta todas as string com StringHelper::utf8_decode (para compatibilidade com PHP 8.2) ou similar. Veja o codigo para ficar mais claro';
    return $msg;
}
