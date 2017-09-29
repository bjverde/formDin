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

class TAutoComplete
{
	private $strFieldName;
	private $strTablePackageFuncion;
	private $strSearchField;
	private $mixUpdateFields;
	private $boolDisableUpdateFields;
	private $mixExtraSearchFields;
	private $strCallBackFunctionJs;
	private $intMinChars;
	private $intDelay;
	private $intMaxItensToShow;
	private $intCacheTime;
	private $boolRemoveMask;
	private $strUrl;
	private $callBackParams;
	private $hint;
	/**
    * Implementa o recurso de autosugestão ao um campo
    * @strUrl - se for informada a url que devolverá os dados para o autocomplete, o retorno deverá ser no seguinte formato:
    * "descriçao|chave\n"  exemplo: echo "Abacate|123\n"
    *
    * @param string $strFieldName
    * @param string $strPackageFunction
    * @param string $strSearchField
    * @param mixed $mixUpdateFields
    * @param boolea $boolDisableUpdateFields
    * @param mixed $mixExtraSearchFields
    * @param string $strCallBackFunctionJs
    * @param integer $intMinChars
    * @param integer $intDelay
    * @param integer $intMaxItensToShow
    * @param integer $intCacheTime
    * @param integer $boolRemoveMask
    * @param string $strUrl
    */
	public function __construct($strFieldName,$strTablePackageFuncion,$strSearchField,$mixUpdateFields=null,$boolDisableUpdateFields=null,$mixExtraSearchFields=null,$strCallBackFunctionJs=null,$intMinChars=null,$intDelay=null,$intMaxItensToShow=null,$intCacheTime=null,$boolRemoveMask=null,$strUrl=null)
	{
         $this->setFieldName($strFieldName);
         $this->setTablePackageFuncion($strTablePackageFuncion);
         $this->setSearchField($strSearchField);
         $this->setUpdateFields($mixUpdateFields);
         $this->setDisableUpdateFields($boolDisableUpdateFields);
         $this->setExtraSearchFields($mixExtraSearchFields);
         $this->setCallBackFunctionJs($strCallBackFunctionJs);
         $this->setMinChars($intMinChars);
         $this->setDelay($intDelay);
         $this->setMaxItensToShow($intMaxItensToShow);
         $this->setCacheTime($intCacheTime);
         $this->setRemoveMask($boolRemoveMask);
         $this->setUrl($strUrl);
	}
	//---------------------------------------------------------------------------------------------------
	public function setFieldName($strNewValue)
	{
		$this->strFieldName = $strNewValue;
	}
	public function getFieldName()
	{
		return $this->strFieldName;
	}
	//---------------------------------------------------------------------------------------------------
	public function setTablePackageFuncion($strNewValue)
	{
		$this->strTablePackageFuncion = $strNewValue;
	}
	public function getTablePackageFuncion()
	{
		return $this->strTablePackageFuncion;
	}
	//---------------------------------------------------------------------------------------------------
	public function setSearchField($strNewValue)
	{
		$this->strSearchField = $strNewValue;
	}
	public function getSearchField()
	{
		return $this->strSearchField;
	}
	//---------------------------------------------------------------------------------------------------
	public function setUpdateFields($mixNewValue=null)
	{
		$this->mixUpdateFields = $mixNewValue;
	}
	public function getUpdateFields()
	{
		return $this->mixUpdateFields;
	}
	//---------------------------------------------------------------------------------------------------
	public function setDisableUpdateFields($boolNewValue=null)
	{
		$this->boolDisableUpdateFields = $boolNewValue;
	}
	public function getDisableUpdateFields()
	{
		return $this->boolDisableUpdateFields;
	}
	//---------------------------------------------------------------------------------------------------
	public function setExtraSearchFields($mixNewValue=null)
	{
		$this->mixExtraSearchFields = $mixNewValue;
	}
	public function getExtraSearchFields()
	{
		return $this->mixExtraSearchFields;
	}
	//---------------------------------------------------------------------------------------------------
	public function setCallBackFunctionJs($strNewValue=null)
	{
		$this->strCallBackFunctionJs = $strNewValue;
	}
	public function getCallBackFunctionJs()
	{
		return $this->strCallBackFunctionJs;
	}
	//---------------------------------------------------------------------------------------------------
	public function setMinChars($intNewValue=null)
	{
		$this->intMinChars = $intNewValue;
	}
	public function getMinChars()
	{
		return is_null($this->intMinChars) ? 3 : $this->intMinChars;
	}
	//---------------------------------------------------------------------------------------------------
	public function setDelay($intNewValue=null)
	{
		$this->intDelay = $intNewValue;
	}
	public function getDelay()
	{
		return is_null($this->intDelay) ? 1000 : $this->intDelay;
	}
	//---------------------------------------------------------------------------------------------------
	public function setMaxItensToShow($intNewValue=null)
	{
		$this->intMaxItensToShow = $intNewValue;
	}
	public function getMaxItensToShow()
	{
		return is_null($this->intMaxItensToShow) ? 20 : $this->intMaxItensToShow;
	}
	//---------------------------------------------------------------------------------------------------
	public function setCacheTime($intNewValue=null)
	{
		$this->intCacheTime = $intNewValue;
	}
	public function getCacheTime()
	{
		return is_null($this->intCacheTime) ? 60 : $this->intCacheTime;
	}
	//---------------------------------------------------------------------------------------------------
	public function setRemoveMask($boolNewValue=null)
	{
		$this->boolRemoveMask = $boolNewValue;
	}
	public function getRemoveMask()
	{
		return is_null($this->boolRemoveMask) ? 'false' : ( ($this->boolRemoveMask)?'true':'false');
	}
	//---------------------------------------------------------------------------------------------------
	public function setUrl($strNewValue=null)
	{
		$this->strUrl = $strNewValue;
	}
	public function getUrl()
	{
		//return is_null($this->strUrl) ? 'base/callbacks/autocomplete.php' :$this->strUrl;
		//return is_null($this->strUrl) ? 'modulo=base/callbacks/autocomplete.php&ajax=1' :$this->strUrl;
		return $this->strUrl;
	}
	//---------------------------------------------------------------------------------------------------
	public function setCallBackParameters($strParameters=null)
	{
		$this->callBackParams=$strParameters;
	}
	public function getCallBackParameters()
	{
		return $this->callBackParams;
	}
	//---------------------------------------------------------------------------------------------------
	public function setHint($strNewValue=null)
	{
		$this->hint = $strNewValue;
	}
	public function getHint()
	{
		if( is_null($this->hint))
		{
			return 'Autocompletar - Inicie a digitação e interrompa por alguns segundos, para que a lista de sugestões, com os registros coincidentes, seja apresentada logo abaixo!';
		}
		return $this->hint;
	}
	//---------------------------------------------------------------------------------------------------

	//---------------------------------------------------------------------------------------------------
	//---------------------------------------------------------------------------------------------------

	public function getJs()
	{
		// criar array com dados para passar como extraparams via json
		$strExtraParams = '';
		$strFillFields 	= '';
		$aTemp=array();
		$aTemp['tablePackageFunction'] 	= $this->getTablePackageFuncion();
		$aTemp['searchField']			= $this->getSearchField();
		$aTemp['cacheTime']				= $this->getCacheTime();
		if( $this->getCallBackFunctionJs() )
		{
			$aTemp['functionJs'] = $this->getCallBackFunctionJs();
			if( ! strpos($aTemp['functionJs'],'(') )
			{
				$aTemp['functionJs'].="()";
			}
			if( strpos($aTemp['functionJs'],'()') > 0 && $this->getCallBackParameters() )
			{
				$aTemp['functionJs'] =  str_replace('()','('.$this->getCallBackParameters().')',$aTemp['functionJs']);
			}
		}
		if( $this->getUpdateFields() )
	 	{
	 		$mixUpdateFields = $this->getUpdateFields();
	 		if(!is_array($mixUpdateFields))
	 		{
	 			$mixUpdateFields = explode(',',$mixUpdateFields);
			}
			foreach($mixUpdateFields as $k=>$v)
			{
				if( is_int($k))
				{
					$aField = explode('|',$v);
					if( !isset($aField[1]))
					{
						$aField[1] = strtolower($aField[0]);
					}
					$k=strtoupper($aField[0]);
					$v=$aField[1];
				}
				// quando o autocomplete estiver sendo utilizado em campos do gride, o nome dos campos
				// virão em formato de array ( NUM_PESSOA%1 ). Utilize explode('%'...) para extrari o nome do campo
				$k = explode('%',$k);
				$strExtraParams .= $strExtraParams=="" ? "" : ",";
				$strFillFields 	.= $strFillFields=="" ? "" : ",";
				$strExtraParams	.= '"'.$k[0].'":"'.str_replace('%','_',$v).'"'; //"COD_UF":"cod_uf"
				$aTemp['_u_'.$k[0]] = str_replace('%','_',$v);
				$strFillFields 	.= str_replace('%','_',$v);
			}
		}
       	$strExtraParams = str_replace(array('{','}',':"$',').value"','"jQuery("#', '\").get', '"{', '}"'),array('','',':$',').value','jQuery("#','").get','{','}'),stripcslashes(json_encode($aTemp)));
       	if($this->getUrl())
       	{
			return 'jQuery("#'.$this->getFieldName().'").autocomplete("'.$this->getUrl().'", { delay:'.$this->getDelay().', minChars:'.$this->getMinChars().', matchSubset:1, matchContains:1, cacheLength:10, onItemSelect:fwAutoCompleteSelectItem, onFindValue:fwAutoCompleteFindValue, matchCase:false, maxItemsToShow:'.$this->getMaxItensToShow().', autoFill:true, selectFirst:true, mustMatch:false, selectOnly:true,removeMask:'.$this->getRemoveMask().',extraParams:{'.$strExtraParams.'} });';
		}
		else
		{
			return 'jQuery("#'.$this->getFieldName().'").autocomplete(app_url+app_index_file+"?modulo=base/callbacks/autocomplete.php&ajax=1", { delay:'.$this->getDelay().', minChars:'.$this->getMinChars().', matchSubset:1, matchContains:1, cacheLength:10, onItemSelect:fwAutoCompleteSelectItem, onFindValue:fwAutoCompleteFindValue, matchCase:false, maxItemsToShow:'.$this->getMaxItensToShow().', autoFill:true, selectFirst:true, mustMatch:false, selectOnly:true,removeMask:'.$this->getRemoveMask().',extraParams:{'.$strExtraParams.'} });';
		}
	}
}
//$ac = new TAutoComplete('nom_pessoa','PESSOA','NOM_PESSOA','NUM_PESSOA');
//print $ac->getJs();
?>