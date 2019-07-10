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

class TNumber extends TEdit
{
	private $minValue;
	private $maxValue;
	private $decimalPlaces;
	private $formatInteger;
	private $direction;
	private $allowZero;
	private $allowNull;
	/**
	 * @param string $name
	 * @param string $value
	 * @param boolean $required
	 * @param integer $decimalPlaces
	 * @param string $minValue
	 * @param string $maxValue
	 * @param boolean $formatInteger
	 * @param boolean $allowZero
	 * @param boolean $allowNull
	 */
	public function __construct($strName,$strValue=null,$intMaxLength,$boolRequired=null,$intDecimalPlaces=null,$strMinValue=null,$strMaxValue=null,$boolFormatInteger=null,$strDirection=null,$boolAllowZero=null,$boolAllowNull=null)
	{
		parent::__construct($strName,null,$intMaxLength,$boolRequired);
		$this->setFieldType('number');
		$this->setAllowZero($boolAllowZero);
		$this->setAllowNull($boolAllowNull);
		$this->setMinValue($strMinValue);
		$this->setMaxValue($strMaxValue);
		$this->setDecimalPlaces($intDecimalPlaces);
		$this->setFormatInteger($boolFormatInteger);
		$this->setDirection($strDirection);
		if( !isset($_POST[ $this->getId() ] ) )
		{
			if( !is_null( $strValue ) )
			{
				$this->setValue($strValue);
			}
			if( ! $this->getValue())
			{
				// inicializar com o valor minimo se tiver valor inválido
				if( $this->getMinValue() && $this->getValue() < $this->getMinValue())
				{

					if( !$this->getAllowZero() && !$this->getAllowNull())
					{
						$this->value = $this->getMinValue();
					}
				}
			}
		}
		else
		{
			$this->setValue( $_POST[ $this->getId() ] );
		}
	}
	//--------------------------------------------------------------------------
	public function show($print=true)
	{
		// definir a direção do texto durante a entrada de dados
		switch($this->getDirection())
		{
			case 'rtl':
				$this->setCss('text-align','right');
				break;
			case 'ltr':
				$this->setCss('text-align','left');
				break;
			case 'c':
				$this->setCss('text-align','center');
				break;
		}

		//$this->setProperty('dir',$this->getDirection()); retirei porque o sina de negativo fica a direita com rtl
		// não utilizar formatCurrency(this,...) porque dá erro quando o campos tem decimal=0
		$js = new TElement('script');
		$js->setProperty('type',"text/javascript");
		if( (int) $this->getDecimalPlaces() == 0)
		{
			$this->addEvent('onKeyUp' ,'fwFormatarInteiro(this,"'. ( ($this->getFormatInteger())?'S':'N').'")');
			//$js->add('jQuery("#'.$this->getId().'").bind("keyup",function(){ fwFormatarInteiro(this,"'. ( ($this->getFormatInteger())?'S':'N').'") }');
		}
		else
		{
			$limit = $this->getMaxLenght();
			if( $limit - $this->getDecimalPlaces() < 2 )
			{
				$this->setMaxLenght( $limit + 2 );
				$this->setSize($this->getMaxLenght());
				$limit = $this->getMaxLenght();
			}
			$this->getMask(); // ajustar size e maxlenght
			$js->add('jQuery("#'.$this->getId().'").priceFormat({ prefix: "",centsSeparator: ",", thousandsSeparator: ".","allowNull":'.$this->getAllowNull().',centsLimit:'.$this->getDecimalPlaces().',limit:'.$limit.'});');
			// aumentar o tamanho do campo para a função preice format funcionar
			$this->setMaxLenght(($this->getMaxLenght()+1));
			$this->setSize($this->getMaxLenght());
    	}
		if(	$this->getMinValue() || $this->getMaxValue())
		{
			$this->addEvent('onBlur', "fwChkMinMax(". (is_numeric(str_replace(',','.',$this->getMinValue()) ) ? str_replace(',','.',$this->getMinValue()) : "Number.NaN").",".(is_numeric( str_replace(',','.',$this->getMaxValue()) ) ? str_replace(',','.',$this->getMaxValue()) : "Number.NaN").",'".$this->getName()."',".$this->getDecimalPlaces().",".$this->getAllowZero().",".$this->getAllowNull().")");
		}
		if( $this->getEvents() )
		{
			foreach($this->getEvents() as $eventName=>$event)
			{
				$eventName = preg_replace('/^on/i','',strtolower($eventName));
			   	$js->add('jQuery("#'.$this->getId().'").bind("'.$eventName.'",function(){ '.$event.' })');
			}
			$this->clearEvents();
		}
		$this->add($js);
		return parent::show($print);
	}
	//---------------------------------------------------------------------------
	public function setMaxValue($numNewValue=null)
	{
		$this->maxValue = $numNewValue;
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
	public function setDecimalPlaces($numNewDecimalPlaces)
	{
		$this->decimalPlaces = $numNewDecimalPlaces;
	}
	//----------------------------------------------------------------------------
	public function getDecimalPlaces()
	{
		return (int)$this->decimalPlaces;
	}
	//-----------------------------------------------------------------------------
	public function setFormatInteger($boolNewValue=null)
	{
		$boolNewValue = $boolNewValue===null ? false : $boolNewValue;
		$this->formatInteger=(bool) $boolNewValue;
	}
	//-----------------------------------------------------------------------------
	public function getFormatInteger()
	{
		return (bool) $this->formatInteger;
	}
	public function setDirection($strDirection=null)
	{
		switch($strDirection)
		{
			case 'R';
			case 'r';
				$this->direction = 'rtl';
			break;
			case 'L';
			case 'l';
				$this->direction = 'ltr';
			break;
			case 'C';
			case 'c';
				$this->direction = 'c';
			break;
			//--------------------------------
			default:
				$this->direction = 'rtl';
		}
	}
	//------------------------------------------------
	public function getDirection()
	{
		return $this->direction;
	}
	//------------------------------------------------
	public function setAllowZero($boolNewValue=null)
	{
		$boolNewValue = is_null($boolNewValue) ? false : $boolNewValue;
		$this->allowZero = $boolNewValue;
	}
	//------------------------------------------------
	public function getAllowZero()
	{
		return $this->allowZero ? 1 : 0;
	}
	public function setAllowNull($boolNewValue=null)
	{
		$boolNewValue = is_null($boolNewValue) ? false : $boolNewValue;
		$this->allowNull = $boolNewValue;
	}
	//------------------------------------------------
	public function getAllowNull()
	{
		return $this->allowNull ? 1 : 0;
	}
	//-------------------------------------------------
	public function getAsNumber($strNumber=null)
	{
		$strNumber = is_null($strNumber) ? $this->getValue() : $strNumber;
		if($this->getDecimalPlaces()>0)
		{
			return (double) str_replace(',','.',str_replace('.','',$strNumber));
		}
		else
		{
			return (int) str_replace(',','.',str_replace('.','',$strNumber));
		}
	}
	//---------------------------------------------------
	public function validate()
	{
		if( parent::validate() )
		{
			$zero 	= (double) ($this->getDecimalPlaces()>0) ? '0.'.str_repeat('0',$this->getDecimalPlaces()) : "0";
			if( $this->getValue() == '' || is_null($this->getValue()))
			{
				if($this->getAllowNull())
				{
					return true;
				}
			}
			else if( $this->getAsNumber() == $zero && $this->getAllowZero())
			{
				return true;
			}
			// validar valor minimo
			if($this->getMinValue())
			{
				$min = $this->getAsNumber($this->getMinValue());
				$val = $this->getAsNumber();
				$msg = '';
				if($val < $min  )
				{
					if( $this->getMaxValue())
					{
						$msg = 'Valor deve estar entre '.$this->getMinValue().' e '.$this->getMaxValue();
					}
					else
					{
						$msg = 'Valor deve ser MAIOR ou IGUAL a '.$this->getMinValue();
					}
				}
				if($msg != '')
				{
					if( $this->getAllowZero())
					{
						$msg .= ' ou zero';
					}
					if( $this->getAllowNull())
					{
						$msg .= ' ou em branco';
					}
					$this->addError($msg );
				}
			}
			// validar valor maximo
			if($this->getMaxValue())
			{
				$max = $this->getAsNumber($this->getMaxValue());
				$val = $this->getAsNumber();
				$msg = '';
				if( $val > $max  )
				{
					if( $this->getMinValue())
					{
						$msg = 'Valor deve estar entre '.$this->getMinValue().' e '.$this->getMaxValue();
					}
					else
					{
						$msg = 'Valor deve ser MENOR ou IGUAL a '.$this->getMaxValue();
					}
				}
				if( $msg != '' )
				{
					if( $this->getAllowZero())
					{
						$msg .= ' ou zero';
					}
					if( $this->getAllowNull())
					{
						$msg .= ' ou em branco';
					}
					$this->addError($msg );
				}
			}
			if($this->getRequired())
			{
				if( $this->getAsNumber() == $zero )
				{
					$this->addError('Campo obrigatório');
				}
			}
		}
		if( !$result = ( (string)$this->getError()==="" ))
		{
		    $this->setClass('fwFieldRequiredBoarder');
		}
		return $result;
	}
	/**
	* Criar a máscara de formatação para entrada de dados numérica com casas decimais
	*/
	public function getMask()
	{
		$d 		= (int) $this->getDecimalPlaces();
		$d 		+=  $d > 0 ? 1 : 0 ;
		$qtd9 	= $this->getMaxLenght()-$d;
		$int 	= '';
		for($i=0;$i<$qtd9;$i++)
		{
			if( $i%3==0 && $i>0)
			{
				$int = ','.$int;
			}
			$int = '9'.$int;
		}
		$dec = str_repeat('9',(int)$this->getDecimalPlaces());
		$int .= $dec ? '.' : '';
		$this->setMaxLenght(strlen($int.$dec));
		$this->setSize($this->getMaxLenght());
		return $int.$dec;
	}
	public function setValue($newValue=null)
	{
		parent::setValue($newValue);
		$newValue = $this->value;
		if( preg_match('/[1-9]/',$newValue)==0 && ! $this->getAllowZero() )
		{
			if( $this->getAllowNull() )
			{
				$this->value = '';
				return;
			}
  		}
		if( $this->getDecimalPlaces() > 0 )
		{
			$posComma = strpos($newValue,',');
			$posPoint = strpos($newValue,'.');
			$posComma = !$posComma ? 0 : $posComma;
			$posPoint = !$posPoint ? 0 : $posPoint;
			if( $posComma && $posPoint )
			{
				if( $posComma>$posPoint)
				{
					$newValue = preg_replace('/\./','',$newValue);
				}
				else
				{
					$newValue = preg_replace('/,/','',$newValue);
					$newValue = preg_replace('/\./',',',$newValue);
				}

			}
			else if( $posPoint )
			{
				$newValue = preg_replace('/\./',',',$newValue);
			}
			//completar casas decimais
			if ( preg_match('/,/',$newValue)==0)
			{
				$newValue.=',0'; // deve ter pelo menos uma casa decimal
			}
			$aParts = explode(',',$newValue);
			if( isset( $aParts[1] ) )
			{
				if( strlen($aParts[1]) < $this->getDecimalPlaces())
				{
					$aParts[1] = str_pad($aParts[1], $this->getDecimalPlaces(),'0',STR_PAD_RIGHT );
				}
				else if( strlen($aParts[1]) > $this->getDecimalPlaces())
				{
					$aParts[1] = substr($aParts[1],0,$this->getDecimalPlaces());
				}
				$newValue = $aParts[0].','.$aParts[1];
			}
			parent::setValue($newValue);
		}
	}
    public function getValue()
    {
        parent::getValue();
        if( $this->value == '')
        {
            $this->value=null;
        }
        return $this->value;
    }
}
//return;
//$val = new TNumber('val_salario','100,20',20,true,2);
//$val->setDirection('c');
//$val->setDirection('L');
/*$val->validate();
$val->setValue('0,00');
$val->validate();
$val->setAllowZero(true);
$val->validate();
// teste min value
$val->setMinValue('5,50');
$val->validate();
$val->setValue(2);
$val->validate();
$val->setValue('5,4');
$val->validate();
*/
// teste max value
//print '<br>'.$val->getValue();
//$val->setMaxValue('10,87');
//$val->validate();
//$val->setValue('10,88');
//$val->validate();
//$val->setValue('11,88');
//$val->validate();
//$val->show();
?>