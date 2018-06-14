<?php
function autoriadeGravar(AutoridadeVO $autoridadeVO)
{
    //Invertendo a string de data pois vem da tela dd-mm-yyyy
    // e o mysql no campo datetime na configuração padrao só entende yyyy-mm-dd
    $dat_evento = implode("-", array_reverse(explode("/", $autoridadeVO->getDat_evento())));
    
    $ordem = $autoridadeVO->getOrdem();
    $where = 'ordem ='.$ordem.' and dat_evento = \''.$dat_evento.'\'';
    $resultado = AutoridadeDAO::selectAll(null, $where);

    if (count($resultado)>0) {
        $msg = "No evento do mesmo dia só pode ter uma autoridade da mesma ordem";
    } else {
        $msg = AutoridadeDAO::insert($autoridadeVO);
    }
    return $msg;
}
