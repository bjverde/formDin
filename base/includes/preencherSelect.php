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

session_start();
/*
Este módulo é utilizado pela função agruparSelects do formulario dinâmico para preencher os selects filhos.
Autor: Luis Eugênio Barbosa
Data : 04/07/2005
*/
?>
<script>
function limparSelect(sel) {
   while (sel.options.length > 0 ){
      sel.options[sel.options.length-1] = null;
   }
}
function setOpt(selectPai, filhos,chaves,valores,valorFilho,valorNulo,textoSelecione,valorSelecione) {
   var selPai   = parent.document.getElementById(selectPai);
   // o select pode estar desabilitado no formulario
   if (!selPai)
        selPai   = parent.document.getElementById(selectPai+'disabled');
   var i,opt;
    var aChave  = chaves.split('|');
    var aValor  = valores.split('|');
    var aFilhos = filhos.split('|');
    valorNulo      = valorNulo==null ?'':valorNulo;
    textoSelecione = textoSelecione==null?'':textoSelecione;
    valorSelecione = valorSelecione==null?'':valorSelecione;
    valorFilho     = valorFilho    ==null?'':valorFilho;

/*        alert( 'valores='+valores+'\n'+
             'Select Pai ='+selectPai+'\n'+
             'Filhos ='+filhos+'\n'+
             'valorNulo='+valorNulo+'\n'+
             'selectPai.value='+selPai.value+'\n'+
             'textoSelecione='+textoSelecione+'\n'+
             'valorSelecione='+valorSelecione)

*/
    try {
         //selPai.focus();
    } catch(e) {}
    // limpar filhos de baixo para cima
    for(i=aFilhos.length-1; i>-1; i-- ) {
       selFilho=parent.document.getElementById(aFilhos[i]);
       if (!selFilho){
           selFilho=parent.document.getElementById(aFilhos[i]+'disabled');
       }
       // proteger contra edição os selects filhos
       limparSelect(selFilho);
       selFilho.disabled=true;
    }
    // se não tiver dados, deixar os filhos bloqueados
   if ( valores != ''){
      // se o select pai tiver valor, preencher o select filho
      if( selPai.value != valorNulo && selPai.value !='' ) {
         // criar a primeira opcao do select ex. -- selecione --
         if( textoSelecione == '' ) {
            textoSelecione = '-- selecione --';
         }
         if( textoSelecione != '' ) {
            opt = new Option(textoSelecione,valorSelecione);
            selFilho.options[selFilho.options.length] =opt;
            if( valorFilho=='')
              valorFilho=valorSelecione;
         }
      for(i=0;i<aChave.length;i++){
            opt = new Option(aValor[i],aChave[i]);
            selFilho.options[selFilho.options.length] =opt;
         }
       selFilho.value=valorFilho;
       if( selFilho.name.indexOf('disabled') == -1 )
          selFilho.disabled=false;
       //selFilho.focus();
      }
   }
}
</script>
<?php
include('conexao.inc');
print '<pre>';
print_r($_GET);
print'</pre>';
//-----------------------------------------------------------------------
// trannformar todos os parametro em um array
$aSelelectPai         = explode('|', $_GET['selectPai']);
$aSelelectFilho       = explode('|', $_GET['selectFilho']);
$aColFiltroPacote     = explode('|', $_GET['colFiltroPacote']);
$aColChavePacote      = explode('|', $_GET['colChavePacote']);
$aColListarPacote     = explode('|', $_GET['colListarPacote']);
$aNomePacote          = explode('|', $_GET['nomePacote']);
$aValoresPai          = explode('|', $_GET['valorPai']);
//$aValorFilho          = explode('|',$aValorPai[1]);
//$aValorPai            = explode('|',$aValorPai);
$aValorNulo           = explode('|', $_GET['valorNulo']);
$aOpcaoSelecione      = explode('|', $_GET['opcaoSelecione']);
$aValorOpcaoSelecione = explode('|', $_GET['valorOpcaoSelecione']);
$aBvars               = explode(',', $_GET['bvars']);
$tempoCache           = $_GET['tempoCache'];


// se o parametro nomePacote  vier com apenas um pacote, indica que não é a primeira chamada
// para configurar os selects do formulario, então os campos filhos devem ser passados da forma que chegarem

if (count($aNomePacote) == 1) {
    $aSelelectFilho  = $_GET['selectFilho'];
}
foreach ($aSelelectPai as $k => $v) {
   // recupear dados do banco
    print 'Valores passados:'.$aValoresPai[$k].'<br>';
    print 'Select Pai:'.$v.'<br>';
    $aValorPai=explode(chr(255), $aValoresPai[$k]);
    $aValorFilho=$aValorPai[1];
    print 'Valor do pai:'.$aValorPai[0].'<br>Valor do Filho:'.$aValorFilho;
    print '<hr>';
    $res=null;
    if ($aValorPai[0]) {
        $bvars=array($aColFiltroPacote[$k]=>$aValorPai[0]);
        if ($aBvars[$k]) {
             $a = explode('|', $aBvars[$k]);
             $bvars[$a[0]]=$a[1];
        }
       //$mens = $db->executar_pacote_func_proc($aNomePacote[$k],$bvars);
        print 'pacote='.$aNomePacote[$k];
        print '<br>';
        print '$bvars=';
        print_r($bvars);
        print '<hr>';
        $mens = recuperarPacote($aNomePacote[$k], $bvars, $res, $tempoCache);
    }
    $erro='';
    if (is_array($res) and !array_key_exists($aColChavePacote[$k], $res)) {
        $erro.= "Coluna: $aColChavePacote[$k] não existe no pacote $aNomePacote[$k]. Verifique parametros da função agruparSelects()";
    }
    if (is_array($res) and !array_key_exists($aColListarPacote[$k], $res)) {
        $erro.= "\\nColuna: $aColListarPacote[$k] não existe no pacote $aNomePacote[$k]. Verifique parametros da função agruparSelects()";
    }
    if ($erro) {
        print '<script>alert(\''.$erro.'\');</script>';
        break;
    }
    if (!$res or count($res[$aColChavePacote[$k]]) == 0) {
        $res=null;
        if (is_array($aSelelectFilho)) {
            print '<script>setOpt("'.$aSelelectPai[$k].'","'.$aSelelectFilho[$k].'","","","'.$aValorFilho.'","'.$aValorNulo[$k].'","'.$aOpcaoSelecione[$k].'","'.$aValorOpcaoSelecione[$k].'");</script>'."\n";
        } //        print '<script>setOpt("'.$aSelelectPai[$k].'","'.$aSelelectFilho[$k].'","","","'.$aValorPai[$k+1].'","'.$aValorNulo[$k].'","'.$aOpcaoSelecione[$k].'","'.$aValorOpcaoSelecione[$k].'");</script>';
        else {
            print '<script>setOpt("'.$aSelelectPai[$k].'","'.$aSelelectFilho.'","","","'.$aValorFilho.'","'.$aValorNulo[$k].'","'.$aOpcaoSelecione[$k].'","'.$aValorOpcaoSelecione[$k].'");</script>'."\n";
        }
//        print '<script>setOpt("'.$aSelelectPai[$k].'","'.$aSelelectFilho.'","","","'.$aValorPai[$k+1].'","'.$aValorNulo[$k].'","'.$aOpcaoSelecione[$k].'","'.$aValorOpcaoSelecione[$k].'");</script>';
    } else {
        $seq='';
        $des='';
        foreach ($res[$aColChavePacote[$k]] as $k1 => $v1) {
            if ($des <> '') {
                $seq.='|"'.chr(13).'+"';
                $des.='|"'.chr(13).'+"';
            }
            $seq = $seq.tirarAspas($v1);
            $des = $des.tirarAspas(trim($res[$aColListarPacote[$k]][$k1]));
        }
        if (is_array($aSelelectFilho)) {
            print '<script>setOpt("'.$aSelelectPai[$k].'","'.$aSelelectFilho[$k].'","'.$seq.'","'.$des.'","'.$aValorFilho.'","'.$aValorNulo[$k].'","'.$aOpcaoSelecione[$k].'","'.$aValorOpcaoSelecione[$k].'");</script>'."\n";
 //         print '<script>setOpt("'.$aSelelectPai[$k].'","'.$aSelelectFilho[$k].'","'.$seq.'","'.$des.'","'.$aValorPai[$k+1].'","'.$aValorNulo[$k].'","'.$aOpcaoSelecione[$k].'","'.$aValorOpcaoSelecione[$k].'");</script>';
        } else {
            print '<script>setOpt("'.$aSelelectPai[$k].'","'.$aSelelectFilho.'","'.$seq.'","'.$des.'","'.$aValorFilho.'","'.$aValorNulo[$k].'","'.$aOpcaoSelecione[$k].'","'.$aValorOpcaoSelecione[$k].'");</script>'."\n";
 //         print '<script>setOpt("'.$aSelelectPai[$k].'","'.$aSelelectFilho.'","'.$seq.'","'.$des.'","'.$aValorPai[$k+1].'","'.$aValorNulo[$k].'","'.$aOpcaoSelecione[$k].'","'.$aValorOpcaoSelecione[$k].'");</script>';
        }
    }
}
function tirarAspas($valor)
{
    $valor = str_replace("'", '`', $valor);
    $valor = str_replace('"', '“', $valor);
    return trim($valor);
}
?>
