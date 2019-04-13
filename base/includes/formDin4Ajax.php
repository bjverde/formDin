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

/**
 * Função para ajustar o retorno da chamada ajax para ser devolvido para a
 * função callback
 *
 * @param integer $pStatus
 * @param mixed $pData
 * @return mixed
 */
function prepareReturnAjax($pStatus, $pData=null, $pMessage=null,$boolBancoUtf8=null)
{
    if( ! isset( $_REQUEST['ajax' ] ) ) // não usar esta função quando não for uma requisição ajax
    {
		return;
    }
    if( !defined('BANCO_UTF8') )
    {
    	define('BANCO_UTF8',1);
    }

	$buffer = ob_get_contents();
	$buffer = trim( $buffer );

	// retornos padrão para facilitar
	if( strtoupper( $pMessage ) == 'POST')
	{
		$pMessage = print_r($_POST,true);
	}
	else if( strtoupper( $pMessage ) == 'SESSION')
	{
		$pMessage = print_r($_SESSION,true);
	}
	else if( strtoupper( $pMessage ) == 'SERVER')
	{
		$pMessage = print_r($_SERVER,true);
	}
	else if( is_array( $pMessage ) )
	{
		$pMessage = print_r($pMessage,true);
	}

	ob_clean();
   	$boolAplicarUtf8  = false;
	$boolBancoUtf8 = is_null($boolBancoUtf8) ? BANCO_UTF8 : $boolBancoUtf8;
	$pMessage .= $buffer;
	// tratamento para as requisições de paginação da classe TGrid.
	if( isset($_REQUEST['page']) && $_REQUEST['page']>0)
	{
		echo $pData.$pMessage;
		die();
	}


    if( isset($_REQUEST['containerId']) && !is_null( $_REQUEST['containerId'] ) && trim($_REQUEST['containerId'] ) != ''  )
    {
    	if( !$pData )
    	{
    	    
    	    $pData=$pMessage;
    	    /*
    		if( $_REQUEST['dataType']=='json'){
    			$pData=utf8_encode($pMessage);
			}else {
    			$pData=$pMessage;
			}
			*/
    	}
		$pMessage=null;
    }

   	if( $pData )
    {
	    if( is_array( $pData ) )
		{
		    $vData='';
		    foreach( $pData as $k => $v)
		    {
		        if($_REQUEST['dataType']=='json')
		        {
        	    	//$boolAplicarUtf8=true;
		        	if( !is_array( $v ) ) {
		        	    $pData[$k]=$v ;
		        	    /*
		        		if( $boolBancoUtf8 ) {
		       				$pData[$k]=utf8_encode($v) ;
						} else {
							$pData[$k]=$v ;
						}
						*/
					}
					/*
					else {
					    $pData[ $k ] = utf8_encode_array($v);
					}
					*/
				} else {
    		        $vData .= print_r($v,true)."\n";
				}
		    }
		    if($_REQUEST['dataType']=='text')
		    {
		        $pData = $vData;
			}

		}
		if($_REQUEST['dataType']=='text')
		{
			echo $pData;
		}
		/*
		else
		{
			$pData = ($boolAplicarUtf8) ? $pData : utf8_encode($pData);
		}
		*/
	}
	if( $pMessage ) {
        if( is_array( $pMessage ) ) {
            $vData=null;
            foreach($pMessage as $k => $v ) {
   		        $vData .= $v."\n";
			}
       		$pMessage = $vData;
        }
		$pMessage = str_replace('\n',"\n",$pMessage);
		if(isset($_REQUEST['dataType'] ) && $_REQUEST['dataType'] == 'text' ) {
			echo $pMessage;
		} 
		/*
		else {
			$pMessage = utf8_encode($pMessage);
		}
		*/
	}
    if(	isset($_REQUEST['dataType']) && $_REQUEST['dataType'] == 'json'	)
	{
		ob_clean();
		$resAjax=null;
		$resAjax['status']	= $pStatus;
		$resAjax['data']	= $pData;
		$resAjax['message']	= $pMessage;
		$resAjax['dataType']= $_REQUEST['dataType'];
		if(	isset($_REQUEST['containerId'] ) )
		{
			$resAjax['containerId']= $_REQUEST['containerId'];
		}
		if( isset($_REQUEST['TGrid']) && isset($_REQUEST['page'] ) )
		{
			echo trim($pMessage);
		}
		else
		{
			echo json_encode($resAjax);
		}
	}
	die;
}

/**
 * Cria um array com as variáveis e seus respectivos valores oriundo do POST para
 * ser enviado para o banco
 * @param string $pFields ex: 'seq_pessoa,nom_pessoa, ...'
 * @return array Array com os dados
 *
 * @see ex: fwCreateBvarsAjax('nom_pessoa,des_obs|observacao, ...')
 * 
 * @todo criar opção de colocar um valor de campo diferente em um id ex: num_pessoa|num_cliente
 * @todo add no arquivo de funções ajax
 */
function createBvarsAjax($pFields) {
    $aFields = explode(',', $pFields);
    $bvar = null;
    foreach ($aFields as $k => $v) {
        $v = trim($v);
        if (strpos($v, '|')) {
            $v = explode('|', $v);
            if (isset($_POST[strtolower($v[1])]) && $_POST[strtolower($v[1])] || trim($_POST[strtolower($v[1])]) == '0') {
                //$bvar[strtoupper($v[0])] = str_replace(array('"'),array('“'),stripslashes(utf8_decode($_POST[strtolower($v[1])])) );
                $text = stripslashes($_POST[strtolower($v[1])]);
                $bvar[strtoupper($v[0])] = str_replace(array('"'),array('“'),$text);
            } else {
                $bvar[strtoupper($v[0])] = '';
            }
        } else {
            if (isset($_POST[strtolower($v)]) && $_POST[strtolower($v)] || trim($_POST[strtolower($v)]) == '0') {
                //$bvar[strtoupper($v)] = str_replace(array('"'),array('“'),stripslashes(utf8_decode($_POST[strtolower($v)])));
                $text = stripslashes($_POST[strtolower($v)]);
                $bvar[strtoupper($v)] = str_replace(array('"'),array('“'),$text);
            } else {
                $bvar[strtoupper($v)] = '';
            }
        }
    }
    return $bvar;
}

function utf8_encode_array($res)
{
	foreach($res as $k=>$v)
	{
		if( is_array( $v ) )
			{
				$res[$k] = utf8_encode_array($v);
			}
			else
			{
				$res[$k] = utf8_encode($v);
			}
	}
	return $res;
}
?>