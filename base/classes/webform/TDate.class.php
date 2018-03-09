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

  /**
 * Campo para edição de data, dia/mes e mes/ano definindo o parametro
 * maskType como dmy, dm, my
 *
 * <!--<style type="text/css">@import url(base/css/calendar-win2k-1.css);</style>-->
 */
class TDate extends TMask
{
	private $maskType;
	private $minValue;
	private $maxValue;
	private $buttonVisible;
	/**
	 * @param string $name
	 * @param string $value
	 * @param boolean $required
	 * @param string $minValue
	 * @param string $maxValue
	 * @param string $maskType
	 */
	public function __construct($strName,$strValue=null,$boolRequired=null,$strMinValue=null,$strMaxValue=null,$strMaskType=null,$boolButtonVisible=null)
	{
		parent::__construct($strName,$strValue,null,$boolRequired);
		$this->setFieldType('date');
		$this->setMask($strMaskType);
		$this->setMinValue($strMinValue);
		$this->setMaxValue($strMaxValue);
		$this->setButtonVisible($boolButtonVisible);
	}
	//-------------------------------------------------------------------------------
	public function show($print=true)
	{
		// não colocar a imagem no campo data se ele estiver desabilitado
		if( $this->getEnabled())
		{
			$imgCalendar = new TElement('img');
			$imgCalendar->id = $this->getName().'_calendar';
			$imgCalendar->src 		= self::$base."imagens/btnCalendario.gif";
			$imgCalendar->width		= '15x';
			$imgCalendar->height	= '12px';
			$imgCalendar->setCss('vertical-align','middle');
			$imgCalendar->setCss('cursor','pointer');
			if($this->getButtonVisible())
			{
				$js = new TElement('script');
				$js->setProperty('type',"text/javascript");
				$js->add('Calendar.setup({inputField : "'.$this->getName().'", // ID of the input field');
				if($this->getMaskType()=='dmy')
				{
					$js->add('ifFormat : "%d/%m/%Y",');
				}
				else if($this->getMaskType()=='dm')
				{
					$js->add('ifFormat : "%d/%m",');
					if( is_null( $this->getExempleText() ) )
					{
						$this->setExampleText('dd/mm');
					}
				}
				else if($this->getMaskType()=='my')
				{
					$js->add('ifFormat : "%m/%y",');
					if( is_null( $this->getExampleText() ) )
					{
						$this->setExampleText('mm/yyyy');
					}
				}
				$js->add('electric : false,');
				$js->add('position : false,');
				$js->add('cache : true,');
				$js->add('onUpdate : fwCalendarioUpdate,');
				$js->add('button : "'.$imgCalendar->id.'" // ID of the button');
				$js->add('});');
				$imgCalendar->add($js);
				$this->add($imgCalendar);
			}
			$this->addEvent('onBlur' ,'fwValidarData(this,event,"'.$this->getMaskType().'","'.$this->getMinValue().'","'.$this->getMaxValue().'")');
		}
		return parent::show($print);
	}
	//--------------------------------------------------------------------------
	public function setMask($strNewMaskType=null)
	{
		$strNewMaskType = strtolower($strNewMaskType);
		$arrMasksTypes = array(
		 'dmy'	=> '99/99/9999'
		,'dm'	=> '99/99'
		,'my'	=> '99/9999');
		if (!array_key_exists($strNewMaskType,$arrMasksTypes) )
		{
			$strNewMaskType = 'dmy';
		}
		$this->maskType = $strNewMaskType;
		parent::setMask($arrMasksTypes[$strNewMaskType]);
	}
	//--------------------------------------------------------------------------
	public function getMaskType()
	{
		return $this->maskType;
	}
	//--------------------------------------------------------------------------
	public function setButtonVisible($boolValue=null)
	{
		$boolValue = $boolValue===null ? true : (bool)$boolValue;
		$this->buttonVisible = $boolValue;
	}
	public function getButtonVisible()
	{
		return $this->buttonVisible;
	}
	/**
	* validar campo dmy, dm, my
	*
	*/
	public function validate()
	{
		if(parent::validate())
		{
		    $date = preg_replace('[^0-9]','',$this->getValue());
			if($this->getMaskType() =='dm')
			{
				$date .= '2000';
			}
			elseif($this->getMaskType() == 'my')
			{
				$date = '01'.$date;
			}
			$tam = strlen($date);
			if ( $tam == 8 or $tam==6 )
			{
				$day = substr($date,0,2);
				$month = substr($date,2,2);
				$year = substr($date,4,4)+0;

				if( $year < 60 )
				{
					$year += 2000;
				}
				else if( $year > 59 and $year < 100)
				{
					$year += 1900;
				}

				if ( ($day<1) or ($day>31)  || ($month<1) || ($month>12)  || ( ($day>29) && ($month==2) ) || ( ($day>30) && ( ($month==4) || ($month==6) || ($month==9) || ($month==11)  ) ) )
				{
					if( $this->getMaskType() == 'dm')
					{
						$this->setError('DIA/MÊS está inválido');
					}
					else if( $this->getMaskType() == 'my')
					{
						$this->setError('MÊS/ANO está inválido');
					}
					else
					{
						$this->setError('Valor inválido');
					}
				}
				else
				{
					// validar ano bissexto
					if ( $month == 2 )
					{
						if (($day==29) && ((($year % 4) != 0) || ((($year % 100) == 0) && (($year % 400) != 0))))
						{
							$this->setError('Dia inválido. Ano não é bissexto.');
						}
					}
				}
			}
			else
			{
				$this->setValue('');
				parent::validate();
			}
		}
		return ( (string)$this->getError()==="" );
	}


//---------------------------------------------------------------------------
	public function setMaxValue($strNewValue=null)
	{
		$this->maxValue = $strNewValue;
	}
	//---------------------------------------------------------------------------
	public function getMaxValue()
	{
		return $this->maxValue;
	}
	//---------------------------------------------------------------------------
	public function setMinValue($strNewValue=null)
	{
		$this->minValue = $strNewValue;
	}
	//---------------------------------------------------------------------------
	public function getMinValue()
	{
		return $this->minValue;
	}
	//----------------------------------------------------------------------------
	/**
	* Retorna a data invertida
	* O parametro strNewDelim altera a barra para o novo valor passado
	*
	* @param bool $strNewDelim
	*/

	public function getYMD( $strNewDelim = null )
	{
		$strNewDelim = is_null( $strNewDelim ) ? '/' : $strNewDelim;
		if($this->getValue())
		{
			$aData = explode('/',$this->getValue());
			return $aData[2].$strNewDelim.$aData[1].$strNewDelim.$aData[0];
		}
	}
}
?>