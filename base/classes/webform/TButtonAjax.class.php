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

class TButtonAjax extends TButton
{
	private $callback;
	private $returnDataType;
	private $beforeSend;
	private $async;
	private $containerId;
	private $url;
	private $messageLoading;
	private $data;

	public function __construct( $strName = null, $strValue = null, $strAction = null, $jsCallback = null, $strReturnDataType = null, $jsBeforeSend = null, $boolAsync = null, $strMessageLoading = null,$strUrl = null, $strContainerId = null, $strConfirmMessage = null, $strImageEnabled = null, $strImageDisabled = null, $strHint = null,$mixData=null )
	{
		parent::__construct( $strName, $strValue, $strAction, null, $strConfirmMessage, $strImageEnabled, $strImageDisabled, $strHint, null );
		$this->setCallback( $jsCallback );
		$this->setReturnDataType( $strReturnDataType );
		$this->setBeforeSend( $jsBeforeSend );
		$this->setAsync( $boolAsync );
		$this->setContainerId( $strContainerId );
		$this->setUrl( $strUrl );
		$this->setMessageLoading( $strMessageLoading );
		$this->setData( $mixData );
	}

	public function show( $print = true )
	{
		if ( $this->getAction() )
		{
			$data='';
			if( $this->getData() )
			{
				if( is_array( $this->getData() ) )
				{
					$data = $this->getData();
					$data = $this->utf8_encode_array($data);
				    /*
					foreach($data as $k=>$v)
					{
						// se não tiver valor, ler do campo do formulário
						$data[ utf8_encode($k) ] = utf8_encode($v);
					}
					*/
					$data = ',"data":'.json_encode($data);
				}
			}
			$strOnClick = 'fwAjaxRequest( {'.( $this->getCallback() ? '"callback":' . $this->getCallback().',' : '' ).( $this->getBeforeSend() ? '"beforeSend":' . $this->getBeforeSend().',' : '' ).'"action":"' . $this->getAction() . '","async":' . ($this->getAsync()===true?'true':'false') . ',"dataType":"' . $this->getReturnDataType() . '","msgLoad":"' . $this->getMessageLoading() . '","containerId":"' . $this->getContainerId() . '","module":"' . $this->getUrl() . '"'.$data.'});';
			$this->setOnClick( $strOnClick );
			$this->setAction(null);
		}
		return parent::show($print);
	}
	/**
	* Define a função ou handle da função javascript que será chamada ao terminar
	* a requisição ajax.
	*
	* @param string $jsCallback
	*/
	public function setCallback( $jsCallback = null )
	{
		$this->callback = $jsCallback;
        return $this;
	}
	/**
	* Retorna a função ou handle da função javascript que será chamada ao terminar
	* a requisição ajax.
	*
	*/
	public function getCallback()
	{
		if( isset( $this->callback ))
		{
			$a = explode('(',$this->callback);
			$this->callback=$a[0];
		}
		return $this->callback;
	}
	/**
	* Define o tipo de retorno da chamada ajax. Podendo ser text ou json.
	* O padrão será text
	* @param string $strReturnDataType
	*/
	public function setReturnDataType( $strReturnDataType = null )
	{
		$this->returnDataType = $strReturnDataType;
        return $this;
	}
	/**
	* Retorna o tipo de dados retornado pela requisição ajax, sendo, text ou json
	* text é o padrão.
	*
	*/
	public function getReturnDataType()
	{
		return strtolower( $this->returnDataType ) === 'json' ? 'json' : 'text';
	}
	/**
	* Define o nome de uma função js ou handle de uma função javascript que
	* será executa antes de fazer a requisição ajax.
	* Se a função retornar false a chamada será cancelada.
	*
	* @param string $jsBeforeSend
	*/
	public function setBeforeSend( $jsBeforeSend = null )
	{
		$this->beforeSend = $jsBeforeSend;
        return $this;
	}
	/**
	* Retorna o nome da função que será executada antes da requisição ajax
	* Se a função retornar false a chamada será cancelada.
	*/
	public function getBeforeSend()
	{
		if( isset( $this->beforeSend ))
		{
			$a = explode('(',$this->beforeSend);
			$this->beforeSend=$a[0];
		}
		return $this->beforeSend;
	}
	/**
	* Define se a chamada será assincrona ou sincrona
	*
	* @param boolean $boolAsync
	*/
	public function setAsync( $boolAsync = null )
	{
		$this->async = $boolAsync;
        return $this;
	}
	/**
	* Retorna true ou false, se a chamada será assincrona
	*
	* @param boolean $boolAsyn
	*/
	public function getAsync()
	{
		return ( $this->async === false ) ? false : true;
	}
	/**
	* Define o id do elemento html onde será inserido o resultado da consulta ajax
	*
	* @param string $strContainerId
	*/
	public function setContainerId( $strContainerId = null )
	{
		$this->containerId = $strContainerId;
        return $this;
	}
	/**
	* Retorna o id do elemento html onde será inserido o resultado da consulta ajax
	*
	*/
	public function getContainerId()
	{
		return $this->containerId;
	}

	/**
	* Define a url destino da requisição.
	* O padrão será o valor do campo oculto modulo do formulário.
	*
	* @param string $strUrl
	*/
	public function setUrl( $strUrl = null )
	{
		$this->url = $strUrl;
        return $this;
	}
	/**
	* Retorna a url destino da requisição.
	* O padrão será o valor do campo oculto modulo do formulário.
	*
	 */

	public function getUrl()
	{
		return $this->url;
	}
	/**
	* Define a mensagem que será exibida durante a requisição sincrona.
	*
	* @param mixed $strMessage
	*/
	public function setMessageLoading( $strMessage = null )
	{
		$this->messageLoading = $strMessage;
        return $this;
	}
	/**
	* Retorna a mensagem que será exibida durante a requisição sincrona.
	*
	* @param mixed $strMessage
	*/
	public function getMessageLoading()
	{
		return $this->messageLoading;
	}

    public function getData()
    {
        return $this->data;
    }

    public function setData($arrData=null)
    {
        $this->data = $arrData;
        return $this;
    }

	public function addData($strName=null,$mixValue=null )
	{
        if( !is_null( $strName ) )
        {
		    $this->data[$strName] = $mixValue;
        }
        return $this;
	}
}
?>