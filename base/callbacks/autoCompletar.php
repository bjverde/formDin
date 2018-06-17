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

// quanto este arquivo for chamado pela função registerExternalFunction() não precisa da include dos arquivos abaixo
if (file_exists('../xajax/xajax.inc.php')) {
    session_start();
    require_once('../xajax/xajax.inc.php');
    require_once('../includes/conexao.inc');
}

function genFieldRetunr1($arrIdRetorno, $arrCampoRetorno, $retorno)
{
    
    foreach ($arrIdRetorno as $k1 => $v1) {
        $campoRetorno = $arrCampoRetorno[$k1];
        $pattern = "/'/";
        $subject = "\\'";
        $result = preg_replace($pattern, $subject, $res[$campoRetorno][$k]);
        $retorno .= ";document.getElementById('".$arrIdRetorno[$k1]."').value = '".utf8_encode($result)."'";
    }
    
    return $retorno;
}


function autoCompletar($jsonBusca, $strOrigem, $divSelect, $idsRetorno, $nomePacoteFuncaoCache, $camposDescricao, $camposRetorno, $funcaoExecutar = null)
{
    // formar os arrays com parametros de entrada
    $arrCampoDescricao = explode(',', $camposDescricao);
    $arrStrOrigem = explode(',', $strOrigem);

    // instanciar o objeto resposta
    $objResponse = new xajaxResponse();
    // esconder o div e a imagem carregando.gif
    $objResponse->addScript("document.getElementById('".$arrStrOrigem[0]."').style.backgroundImage = \"\"");
    $objResponse->addScript("document.getElementById('".$divSelect."').style.display = \"none\"");

    // Gerar array de entrada
    $arrBusca = json_decode($jsonBusca);

    // verficar se o array de pesquisa tem mesmo tamanho que array dos parametros de entrada
    if (count($arrBusca) != count($arrCampoDescricao)) {
        $objResponse->addAlert(utf8_encode('Tamanho dos campos de entrada não são iguais!'));
        return $objResponse->getXML();
    }

    // construir array de pesquisa e pesquisar no banco
    $bvars = array();
    foreach ($arrCampoDescricao as $k => $v) {
        $bvars[$v] = utf8_decode($arrBusca[$k]);
    }

    // Por razões de segurança, o variável num_pessoa tem que ser lido da sessão
    if (defined('TIPO_ACESSO') && TIPO_ACESSO=='I') {
        $bvars['NUM_PESSOA_CERTIFICADO'] = $_SESSION['num_pessoa'];
    } else {
        $bvars['NUM_PESSOA'] = $_SESSION['num_pessoa'];
    }

    list($nomePacoteFuncao,$tempoCache) = explode(',', $nomePacoteFuncaoCache);
    $tempoCache = (isset($tempoCache)?(float)$tempoCache:0);

    if ($tempoCache >= 0) {
        $bvarsCache = $bvars;
        $pac_func_proc = strtoupper($nomePacoteFuncao);
        $dados=null;

        // Pesquisar se a pesquisa ja foi feita com string mais curto
        for ($i=strlen($arrBusca[0])-1; $i>0 && $dados===null; $i--) {
            // Gerar nome de arquivo usando nome do pacote e hash dos paramtros
            $bvarsCache[$arrCampoDescricao[0]] = substr($bvars[$arrCampoDescricao[0]], 0, $i);
            $arquivo = md5(serialize($bvarsCache)).".cache";
            $nome_arquivo = $pac_func_proc."/".$arquivo;

            //Tentar abrir arquivo cache ou ler da sessão
            if ($tempoCache > 0 and is_readable($GLOBALS['conexao']->getbase()."cache/".$nome_arquivo)
                    and (time() - filemtime($GLOBALS['conexao']->getbase()."cache/".$nome_arquivo)) < $tempoCache ) {
                $fp = fopen($GLOBALS['conexao']->getbase()."cache/".$nome_arquivo, "r");
                $dados = unserialize(fread($fp, filesize($GLOBALS['conexao']->getbase()."cache/".$nome_arquivo)));
                fclose($fp);
            } elseif (isset($_SESSION['dados'][$pac_func_proc][$arquivo])) {
                $dados = $_SESSION['dados'][$pac_func_proc][$arquivo];
            }
        }
        if (is_array($dados) and count($dados['CURSOR'][$arrCampoDescricao[0]]) > 0) {
            // filtrar os dados que obedecem ao argumento e gravar um arquivo cache para esses dados
            foreach ($dados['CURSOR'][$arrCampoDescricao[0]] as $k => $v) {
                if (preg_match("'^".preg_quote($arrBusca[0], "'")."'i", $v)) {
                    foreach ($dados['CURSOR'] as $k1 => $v1) {
                        $dadosNovo['CURSOR'][$k1][] = $dados['CURSOR'][$k1][$k];
                    }
                }
            }
            if (is_array($dadosNovo['CURSOR'])) {
                foreach ($dados as $k => $v) {
                    if ($k !== 'CURSOR') {
                        $dadosNovo[$k] = $v;
                    }
                }
                // gravar dados no cache
                if ($tempoCache > 0 and is_writable($GLOBALS['conexao']->getbase()."cache/".$pac_func_proc)
                        and filetype($GLOBALS['conexao']->getbase()."cache/".$pac_func_proc)=="dir"
                        and ( is_writable($GLOBALS['conexao']->getbase()."cache/".$pac_func_proc."/".$nome_arquivo)
                                or !file_exists($GLOBALS['conexao']->getbase()."cache/".$pac_func_proc."/".$nome_arquivo) ) ) {
                    $nome_arquivo = md5(serialize($bvars)).".cache";
                    $fp = fopen($GLOBALS['conexao']->getbase()."cache/".$pac_func_proc."/".$nome_arquivo, "w");
                    fwrite($fp, serialize($dadosNovo));
                    fclose($fp);
                } else {
                    $_SESSION['dados'][$pac_func_proc][$nome_arquivo]=$dadosNovo;
                }
            }
        }
    }
    $err = @recuperarPacote($nomePacoteFuncao, $bvars, $res, $tempoCache);
    if ($err) {
        $objResponse->addScript("document.getElementById('".$divSelect."').style.display = \"none\"");
        $objResponse->addAlert($err[0]);
         return $objResponse->getXML();
    }

    $nCnt = count($res[$arrCampoDescricao[0]]);
    $sret = "";
    $objResponse->addScript("document.getElementById('".$divSelect."').style.display = \"none\"");

    // formar os array com parametros de retorno
    $arrIdRetorno = explode(',', $idsRetorno);
    $arrCampoRetorno = explode(',', $camposRetorno);

    // verficar se os arrays dos parametros de retorno tem mesmo tamanho
    if (count($arrIdRetorno) != count($arrCampoRetorno)) {
        $objResponse->addAlert('Tamanho dos campos de retorno não são iguais!');
        return $objResponse->getXML();
    }
    if ($nCnt > 50) {
        $objResponse->addAlert('Mais de 50 registros! Informe mais letras.');
    } elseif ($nCnt < 50 && $nCnt > 1) {
        $campoDescricao = $arrCampoDescricao[0];
        // Gerar a lista com as possibilidades
        foreach ($res[$campoDescricao] as $k => $v) {
            $retorno = null;
            //  Gerar os campos de retorno
            $retorno = genFieldRetunr1($arrIdRetorno, $arrCampoRetorno, $retorno);
            //  Formar os links que retornam os dados
            $pattern = "/'(".preg_quote($arrBusca[0], "'").")'/i";
            $dadoMarcado = preg_replace($pattern, "<span style=\"color:black;font-weight:bold;\">\\1</span>", $v, 1);
            if ((string)$funcaoExecutar<>'') {
                if (!strpos($funcaoExecutar, '()')) {
                    $funcaoExecutar.='()';
                }
            }
            $valeu = preg_replace("/'/", "\\'", utf8_encode($v));
            $sRet .= "<li class=\"liAjaxSelect\"><a class=\"linkAjaxSelect\" onclick=\"javascript:document.getElementById('".$arrStrOrigem[0]."').value='".$valeu."'".$retorno.";document.getElementById('".$divSelect."').style.display = 'none';".$funcaoExecutar.";\">".utf8_encode($dadoMarcado)."</a></li>\n";
        }
        if (strlen($sRet) > 0) {
            //  Se foi gerado algum retorno, colocamos isso entre tags <ul> </ul>
            $sRet = "<ul class=\"ulAjaxSelect\">".$sRet."</ul>";

            // mostrar o div de opcoes
            $objResponse->addScript("document.getElementById('".$divSelect."').style.display = \"block\"");


            // calcular a altura do div em função da quantidade de opções encontradas
            $alturaDiv = (16 * $nCnt);

            // limite 200
            $alturaDiv= $alturaDiv>200?200:$alturaDiv;
            $campo_origem = preg_replace('/div_autosugestao_/', '', $divSelect);
            $objResponse->addScript("document.getElementById('".$divSelect."').style.height=\"".$alturaDiv."\"");
            $objResponse->addScript("document.getElementById('".$divSelect."').style.width=6.5*getObj('".$campo_origem."').size");

            // Aqui zeramos todos os parametros de retorno menos o parametro de retorno que também é parametros de pesquisa.
            // Depois serão preenchidos com os valores da lista acima
            foreach ($arrIdRetorno as $k1 => $v1) {
                $campoRetorno = $arrCampoRetorno[$k1];
                if (!array_search($v1, $arrStrOrigem)) {
                    $objResponse->addScript("document.getElementById('".$arrIdRetorno[$k1]."').value = \"\"");
                }
            }
        } else {
            $objResponse->addAlert("Nenhuma Opção");
        }
    } elseif ($nCnt == 1) {
        $campoDescricao = $arrCampoDescricao[0];
        // Se tiver so uma linha de retorno, podemos auto-completar os campos
        $objResponse->addScript("document.getElementById('".$divSelect."').style.display = \"none\"");
        $objResponse->addScript("document.getElementById('".$arrStrOrigem[0]."').value = \"".utf8_encode(preg_replace("/'/", "\\'", $res[$campoDescricao][0]))."\"");
        //  Gerar os campos de retorno
        foreach ($arrIdRetorno as $k => $v) {
            $campoRetorno = $arrCampoRetorno[$k];
            $objResponse->addScript("document.getElementById('".$arrIdRetorno[$k]."').value = \"".utf8_encode(preg_replace("/'/", "\\'", $res[$campoRetorno][0]))."\"");
        }
        $objResponse->addScript("formDinAutoSugestao.clearBuffer()");
    } elseif ($nCnt < 1) {
        //  Se não tiver nenhum resultado, esconder o div-select
        $objResponse->addScript("document.getElementById('".$divSelect."').style.display = \"none\"");
        $objResponse->addScriptCall('setImagemFundoCampo(\''.$arrStrOrigem[0].'\',\'base/imagens/erro.gif\')');
        foreach ($arrIdRetorno as $k1 => $v1) {
            $IdRetorno = $arrIdRetorno[$k1];
            $objResponse->addScript("document.getElementById('".$IdRetorno."').value = \"\"");
        }
    }
    $objResponse->addScriptCall("$funcaoExecutar");

    //  Colocar o html gerado no div
    $objResponse->addAssign($divSelect, "innerHTML", $sRet);

    //  Enviar dado para o browser
    return $objResponse->getXML();
}

//echo "<pre>"; print_r(autoCompletar(json_encode(array('ale','S')),'nom_cientifico_comum,sit_cientifico_comum','divSelect','seq_cientifico_comum,sit_cientifico_comum','AGROTOXICO.PKG_DOENCA_PRAGA.PESQ_CIENTIFICO_COMUM,10000','NOM_CIENTIFICO_COMUM,SIT_CIENTIFICO_COMUM','SEQ_CIENTIFICO_COMUM,SIT_CIENTIFICO_COMUM','disable1()')); echo "</pre>";
//exit();
if (file_exists('../xajax/xajax.inc.php')) {
    $xajax = new xajax("base/callbacks/autoCompletar.php");
    $xajax->registerFunction("autoCompletar");
    $xajax->processRequests();
}
