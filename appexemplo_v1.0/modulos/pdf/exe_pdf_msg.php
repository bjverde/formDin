<?php
function getMsgFPDF()
{
    $msg = '<b>ATENÇÃO</b>: Esse exemplo utiliza o TPDF que é uma extensão do FPDF '.FPDF_VERSION.' e não funciona corretamente com UTF-8.
           <br>Os arquivos podem ser UTF-8 porém deverá converta todas as string para windows-1252, se estiver usando até PHP 8.1.X. Com o PHP 8.2.0 use StringHelper::utf8_decode_windows1252. Veja o codigo para ficar mais claro';
    return $msg;
}
