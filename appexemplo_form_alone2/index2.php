<?php

require_once 'includes/constantes.php';
require_once 'includes/config_conexao.php';

//FormDin version: 4.9.2
require_once '../base/classes/webform/TApplication.class.php';
//require_once 'controllers/autoload_audit.php';
require_once 'dao/autoload_audit_dao.php';


function addRadio($id,$texto, $listOption){
    echo '<p class="texto">'.$texto.'</p>';
    $i = 0;
    $postValeu = PostHelper::get($id);
    foreach ($listOption as $key => $label){
        if($key == 0){
            $checked = ($postValeu === $key) ? "checked" : null;
        }else{
            $checked = ($postValeu == $key) ? "checked" : null;
        }        
        echo '<input type="radio" id="'.$id.$i.'" name="'.$id.'" value="'.$key.'" '.$checked.'>';
        echo '<label for="'.$id.$i.'">'.$label.'</label>';
        $i = $i + 1;
    }
}

var_dump($_REQUEST);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Alone 2 - Layoyt 2</title>
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <link href="css/style.css" rel="stylesheet" media="all" type="text/css" />
    </head>
    <body>
        <div class="centro">
            <div class="conteudo">
            <h2>Quest</h2>
            <form action=""  method="post">
            <?php
                $listOption = array(0=>'A',1=>'B',2=>'B',3=>'D',4=>'E'); 
                addRadio('P01','P01', $listOption);
                addRadio('P02','P02', $listOption);
                addRadio('P03','P03', $listOption);
                addRadio('P04','P04', $listOption);
                addRadio('P05','P05', $listOption);
                addRadio('P06','P06', $listOption);
                addRadio('P07','P07', $listOption);
            ?>
            <br>
            <input type="submit" value="Submit">
            </form>
            </div>
        </div>
    </body>
</html>
