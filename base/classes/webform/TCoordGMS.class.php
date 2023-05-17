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

class TCoordGMS extends TGroup
{

	private $latGrau;
	private $latMin;
	private $latSeg;
	private $latHem;
	private $lonGrau;
	private $lonMin;
	private $lonSeg;
	private $lonHem;
	private $fieldNameLat;
	private $fieldNameLon;
	private $fieldZoom;
	private $symbols;
	private $labels;
	private $mapWidth;
	private $mapHeight;
	private $buttonGMap;
	private $mapHeaderText;
	private $mapHeaderFontSize;
	private $mapHeaderFontColor;
    private $mapCallback;
	private $mapZoom;
	private $mapType;

	/**
	 * campo para inclusão de coordenadas geográficas no formato Grau, Minuto e Segundos
	 *
	 * @param string  $strName
	 * @param boolean $boolRequired
	 * @param float $floatLatY
	 * @param float $floatLonX
	 * @param string $strFieldNameLat
	 * @param string $strFieldNameLon
	 * @param string $strSymbols
	 * @param int    $intSymbolsFontSize
	 * @param int    $intMapHeight
	 * @param int    $intMapWidth
	 * @param string $mapHeaderText
	 * @param string $mapHeaderFontColor
	 * @param string $mapHeaderFontSize
	 * @return TCoordGMS
	 */
	public function __construct($strName, $boolRequired=null, $floatLatY=null, $floatLonX=null, $strFieldNameLat=null, $strFieldNameLon=null, $strLabels=null, $strSymbols=null, $intSymbolsFontSize=null, $intMapHeight=null, $intMapWidth=null, $strMapHeaderText=null, $strMapHeaderFontColor=null, $strMapHeaderFontSize=null,$strJsMapCallback=null,$intMapZoom=null,$strMapType=null)
	{
		parent::__construct($strName, 'Coordenadas Geográficas', 55, 425);
		$this->setFieldType('coordgms');
		$this->setRequired($boolRequired);
		$this->setFieldNameLat($strFieldNameLat);
		$this->setFieldNameLon($strFieldNameLon);
		$this->setMapHeight($intMapHeight);
		$this->setMapWidth($intMapWidth);
		$this->setMapHeaderText(is_null($strMapHeaderText) ? 'Clique com o botão direito do mouse sobre o mapa para selecionar o ponto.' : $strMapHeaderText );
		$this->setMapHeaderFontSize(is_null($strMapHeaderFontSize) ? '12px' : $strMapHeaderFontSize );
		$this->setMapHeaderFontColor(is_null($strMapHeaderFontColor) ? 'black' : $strMapHeaderFontColor );
        $this->setMapCallback($strJsMapCallback);
		$this->setMapZoom( $intMapZoom );
		$this->setMapType($strMapType);
		$strSymbols = is_null($strSymbols) ? "°,',\"" : $strSymbols;
		$strLabels = is_null($strSymbols) ? ",," : $strLabels;
		$intSymbolsFontSize = is_null($intSymbolsFontSize) ? "18" : $intSymbolsFontSize;
		$labels = null;
		if(!empty($strLabels)){
			$labels = explode(',', $strLabels);
		}
		$labels[0] = isset($labels[0]) ? $labels[0] : '';
		$labels[1] = isset($labels[1]) ? $labels[1] : '';
		$labels[2] = isset($labels[2]) ? $labels[2] : '';

		$symbols = explode(',', $strSymbols);
		$symbols[0] = isset($symbols[0]) ? $symbols[0] : '';
		$symbols[1] = isset($symbols[1]) ? $symbols[1] : '';
		$symbols[2] = isset($symbols[2]) ? $symbols[2] : '';

		if ($labels[0] != '')
		{
			parent::setWidth(465);
		}
		if (preg_match('/Segundos/i',$labels[2]))
		{
			parent::setWidth(535);
		}
		$this->setColumns(array(60));

		// construir os campos de latitude e longitude
		$this->latGrau = $this->addNumberField($this->getId() . '_lat_grau', "Latitude&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $labels[0], 2, $boolRequired, 0, true, null, 0, 33, false, null, true, true);
		$this->latGrau->setExampleText('<span style="font-size:' . $intSymbolsFontSize . 'px;">' . $symbols[0] . '</span>');
		$this->latGrau->setProperty('title', 'Intervalo válido - Grau: 0º a 33º');
		$this->latMin = $this->addNumberField($this->getId() . '_lat_min', $labels[1], 2, $boolRequired, 0, false, null, 0, 59, false, null, true);
		$this->latMin->setExampleText('<span style="font-size:' . $intSymbolsFontSize . 'px;">' . $symbols[1] . '</span>');
		$this->latMin->setProperty('title', "Intervalo válido - Minuto: 0 a 59");
		//$this->latSeg = $this->addNumberField($this->getId() . '_lat_seg', $labels[2], 5, $boolRequired, 2, false, null, 0, "59.99", false, null, true, true);
		//$this->latSeg = $this->addMaskField($this->getId() . '_lat_seg', $labels[2],$boolRequired,'99,99',false)->setAttribute('dir', 'rtl');
		$this->latSeg = $this->addTextField($this->getId() . '_lat_seg', $labels[2],5,$boolRequired,5,null,false)->setCss('text-align', 'right');
		$this->latSeg->addEvent('onblur',"fwChkMinMax(0, 59.99, '".$this->getId() . '_lat_seg'."',2,true,0)");
		$this->latSeg->addEvent('onkeydown',"fwFormatSecondsGms(this,event)");
		$this->latSeg->setExampleText('<span style="font-size:' . $intSymbolsFontSize . 'px;">' . $symbols[2] . '</span>');
		$this->latSeg->setProperty('title', 'Intervalo válido - Segundo: 0 a 59,99');
		$this->latHem = $this->addSelectField($this->getId() . '_lat_hem', 'Hem:', $boolRequired, "S=Sul,N=Norte", false, null, null, null, null, null, "");


		// longitude
		$this->lonGrau = $this->addNumberField($this->getId() . '_lon_grau', "Longitude&nbsp;&nbsp;" . $labels[0], 2, $boolRequired, 0, true, null, 32, 73, false, null, false, true);
		$this->lonGrau->setProperty('title', 'Intervalo válido - Grau: 32º a 73º');
		$this->lonGrau->setExampleText('<span style="font-size:' . $intSymbolsFontSize . 'px;">' . $symbols[0] . '</span>');
		$this->lonMin = $this->addNumberField($this->getId() . '_lon_min', $labels[1], 2, $boolRequired, 0, false, null, 0, 59, false, null, true);
		$this->lonMin->setProperty('title', 'Intervalo válido - Minuto: 0 a 59');
		$this->lonMin->setExampleText('<span style="font-size:' . $intSymbolsFontSize . 'px;">' . $symbols[1] . '</span>');
		//$this->lonSeg = $this->addNumberField($this->getId() . '_lon_seg', $labels[2], 5, $boolRequired, 2, false, null, 0, "59.99", false, null, true, true);
		//$this->lonSeg = $this->addMaskField($this->getId() . '_lon_seg', $labels[2],$boolRequired,'99,99',false)->setAttribute('dir', 'rtl');
		$this->lonSeg = $this->addTextField($this->getId() . '_lon_seg', $labels[2],5,$boolRequired,5,null,false)->setCss('text-align', 'right');
		$this->lonSeg->addEvent('onblur',"fwChkMinMax(0, 59.99, '".$this->getId() . '_lon_seg'."',2,true,false)");
		$this->lonSeg->addEvent('onkeydown',"fwFormatSecondsGms(this,event)");
		$this->lonSeg->setProperty('title', 'Intervalo válido - Segundo: 0 a 59,99');
		$this->lonSeg->setExampleText('<span style="font-size:' . $intSymbolsFontSize . 'px;">' . $symbols[2] . '</span>');
		//$this->lonHem = $this->addTextField($this->getId() . '_lon_hem', 'Hem:', 1, $boolRequired, 1, 'W', false);
		$this->lonHem = $this->addSelectField($this->getId() . '_lon_hem', 'Hem:', $boolRequired, "W=Oeste,E=Leste", false, null, null, null, null, null, "");

		//$this->lonHem->setEnabled(false);
		// botão para abrir o mapa
		$this->buttonGMap = $this->addButton('G', null, 'btnGoogle_' . $this->getId(), null, null, false, false, 'fwgoogle-maps-icon_19x19px.gif', 'fwgoogle-maps-icon_19x19px.gif', 'Mapa - Visualizar / selecionar a coordenada');
		$this->fieldZoom = $this->addHiddenField($this->getId().'_map_zoom');
		$this->fieldLonCenter = $this->addHiddenField($this->getId().'_map_lon_center');
		$this->fieldLatCenter= $this->addHiddenField($this->getId().'_map_lat_center');
		/*
		  //$this->addButton('G',null,'btnGoogle_'.$this->getId(),'fwFieldCoordShowMap("'.$this->getId().'","'.$this->getMapHeight().'","'.$this->getMapWidth().'")',null,false,false,'gmark_grey.jpg',null,'Google Map - Visualizar/selecionar coordenadas');
		  // se não tiver sido postado, inicializar com os valores passados em $floatLat e $floatLon
		  if(is_null($this->latGrau->getValue()))
		  {
		  $this->setLat($floatLatY);
		  $this->setLon($floatLonX);
		  }
		 */
	}
/**
	 * Imprime ou devolve o código html se $print for false
	 *
	 * @param boolean $print
	 * @return string
	 */
	function show($print=true,$flat=false)
	{
		if (!$this->getButtonGMap()->getOnClick())
		{
			$params = array('readonly' => !$this->getEnabled()
				, 'mapHeaderText' => StringHelper::utf8_encode($this->getMapHeaderText())
				, 'mapHeaderFontColor' => StringHelper::utf8_encode($this->getMapHeaderFontColor())
				, 'mapHeaderFontColor' => StringHelper::utf8_encode($this->getMapHeaderFontColor())
				, 'mapHeaderCallBaFontSize' => StringHelper::utf8_encode((integer) $this->getMapHeaderFontSize())
				, 'mapCallback' => $this->getMapCallback()
				, 'zoom' => $this->getMapZoom()
				, 'mapType' => $this->getMapType()
				);
			$this->getButtonGMap()->setOnClick('fwFieldCoordShowMap("' . $this->getId() . '","' . $this->getMapHeight() . '","' . $this->getMapWidth() . '",' . json_encode($params) . ')');
//            $this->getButtonGMap()->setOnClick('fwFieldCoordShowMap("'.$this->getId().'","'.$this->getMapHeight().'","'.$this->getMapWidth().'","'.$params.'")');
			$this->getButtonGMap()->setAction(null);
			$this->getButtonGMap()->setEnabled(true);
			if (!$this->getEnabled())
			{
				$this->getButtonGMap()->setHint('Mapa - Visualizar Coordenada');
			}
		}

		$this->fieldZoom->setValue($this->getMapZoom());
		// retirar este if quando o problema do TForm de gerar as larguras das colunas corretamente estiver resolvido
		if ($this->getRequired() == true)
		{
			$this->setColumns(array(60));
		}
		return parent::show($print);
	}
	/**
	 * Retorna o array contendo o valor da latitude (y) e da longitude (x)
	 *
	 */
	function getValue($strField=null)
	{
		if ( ! is_null( $this->latGrau->getValue() ) )
		{
			// latitude
			$grau = $this->latGrau->getValue();
			$min = $this->latMin->getValue();
			$seg = $this->latSeg->getValue();
			list($hem) = $this->latHem->getValue();
			$grau = is_null($grau) ? 0 : (float) str_replace(',', '.', $grau);
			$min = is_null($min) ? 0 : (float) str_replace(',', '.', $min);
			$seg = is_null($seg) ? 0 : (float) str_replace(',', '.', $seg);
			if (strtoupper($hem) == 'W' || strtoupper($hem) == 'S')
			{
				$lat = (-$grau - $min / 60) - ($seg / 3600);
			}
			else
			{
				$lat = ($grau + $min / 60) + ($seg / 3600);
			}
			// longitude
			$grau = $this->lonGrau->getValue();
			$min = $this->lonMin->getValue();
			$seg = $this->lonSeg->getValue();
			//$hem = $this->lonHem->getValue();
			list($hem) = $this->lonHem->getValue();
			$grau = is_null($grau) ? 0 : (float) str_replace(',', '.', $grau);
			$min = is_null($min) ? 0 : (float) str_replace(',', '.', $min);
			$seg = is_null($seg) ? 0 : (float) str_replace(',', '.', $seg);
			if (strtoupper($hem) == 'W' || strtoupper($hem) == 'S')
			{
				$lon = (-$grau - $min / 60) - ($seg / 3600);
			}
			else
			{
				$lon = ($grau + $min / 60) + ($seg / 3600);
			}
			return array($this->getFieldNameLat() => $lat, $this->getFieldNameLon() => $lon);
		}
		return null;
		// campo select retorna array no getValue()
		/* list($latHem)=$this->latHem->getValue();
		  return array(
		  $this->latGrau->getId()	=>$this->latGrau->getValue(),
		  $this->latMin->getId()	=>$this->latMin->getValue(),
		  $this->latSeg->getId()	=>$this->latSeg->getValue(),
		  $this->latHem->getId()	=>$latHem[0],
		  $this->lonGrau->getId()	=>$this->lonGrau->getValue(),
		  $this->lonMin->getId()	=>$this->lonMin->getValue(),
		  $this->lonSeg->getId()	=>$this->lonSeg->getValue(),
		  str_replace('_disabled','',$this->lonHem->getId())=>$this->lonHem->getValue());
		 */
	}
	//-------------------------------------------------------------------------
	/**
	 * converte grau decimal em Grau, Min e Seg
	 *
	 * @param float $gd
	 * @param float $latlon
	 *
	 * @return array
	 */
	protected function gd2gms($gd, $latlon=null)
	{
		$result = array();
		if (is_null($latlon) || ( strtoupper($latlon) != 'LAT' && strtoupper($latlon) != 'LON'))
		{
			return $result;
		}

		if (!is_null($gd))
		{
			$grau   = abs( (int) $gd );
			$min    = abs( (int) ( ( abs($gd) - $grau ) * 60 ));
			$seg    = $this->roundUp((60*((abs($gd)-$grau)*60-$min)),2);
			if (strtoupper($latlon) == 'LON')
			{
				if ($gd > 0)
				{
					$hem = 'E';
				}
				else
				{
					$hem = 'W';
				}
			}
			else if (strtoupper($latlon) == 'LAT')
			{
				if ($gd > 0)
				{
					$hem = 'N';
				}
				else
				{
					$hem = 'S';
				}
			}
			$result = array($grau, $min, $seg, $hem);
		}
		return $result;
	}

	//----------------------------------------------------------------------
	/**
	 * Retorna um valor decimal sem arredondamento até a quantidade de casas informada
	 *
	 * @param float $val
	 * @param int $casas
	 * @return float
	 */
	protected function trunc($val, $casas)
	{
		$casas = is_null($casas) ? 0 : ($casas + 1);
		$pos = strpos($val, '.');
		if ($pos)
		{
			return substr($val, 0, ($pos + $casas));
		}
		return $val;
	}

	/**
	 * Arredondar para cima

	 *
	 * @param float $value
	 * @param integer $precision
	 */
	function roundUp($value, $precision=0)
	{
		if ($precision == 0)
		{
			$precisionFactor = 1;
		}
		else
		{
			$precisionFactor = pow(10, $precision);
		}
		return ceil($value * $precisionFactor) / $precisionFactor;
	}

	//-------------------------------------------
	/**
	 * Define o valor de grau min e seg da latitude (y) em função do valor decimal passado
	 *
	 * @param float $y
	 */
	public function setLat($y=null)
	{
		$this->latGrau->setValue(null);
		$this->latMin->setValue(null);
		$this->latSeg->setValue(null);
		$this->latHem->setValue(null);
		if (!is_null($y))
		{
			$y = (float) str_replace(",", ".", $y);
            $y = $this->roundUp($y, 14);
			$aDados = $this->gd2gms($y, 'lat');
			if (isset($aDados[0]))
			{
				//$this->lat->setValue($y);
				$this->latGrau->setValue(( $aDados[0]));
				$this->latMin->setValue($aDados[1]);
				$this->latSeg->setValue($aDados[2]);
				$this->latHem->setValue($aDados[3]);
			}
		}
		return $this;
	}

	/**
	 * Define o valor de grau min e seg da longitude (x) em função do valor decimal passado
	 *
	 * @param float $x
	 */
	public function setLon($x=null)
	{
		$this->lonGrau->setValue(null);
		$this->lonMin->setValue(null);
		$this->lonSeg->setValue(null);
		if (!is_null($x))
		{
			$x = (float) str_replace(",", ".", $x);
			$x = $this->roundUp($x, 8);
			$aDados = $this->gd2gms($x, 'lon');
			if (isset($aDados[0]))
			{
				//$this->lon->setValue($x);
				$this->lonGrau->setValue(( $aDados[0]));
				$this->lonMin->setValue($aDados[1]);
				$this->lonSeg->setValue($aDados[2]);
				$this->lonHem->setValue($aDados[3]);
			}
		}
		return $this;
	}

	/**
	 * Define o nome do campo referente ao valor da latitude que será retornado no array da função getValue()
	 *
	 * @param string $strNewValue
	 */
	public function setFieldNameLat($strNewValue=null)
	{
		$this->fieldNameLat = $strNewValue;
		return $this;
	}

	/**
	 * Define o nome do campo referente ao valor da longitude que será retornado no array da função getValue()
	 *
	 * @param string $strNewValue
	 */
	public function setFieldNameLon($strNewValue=null)
	{
		$this->fieldNameLon = $strNewValue;
		return $this;
	}

	/**
	 * Retonra o nome do campo referente ao valor da latitude que será retornado no array da função getValue()
	 *
	 */
	public function getFieldNameLat()
	{
		if (is_null($this->fieldNameLat))
		{
			return $this->getId() . '_lat';
		}
		return $this->fieldNameLat;
	}

	/**
	 * Retonra o nome do campo referente ao valor da longitude que será retornado no array da função getValue()
	 *
	 */
	public function getFieldNameLon()
	{
		if (is_null($this->fieldNameLon))
		{
			return $this->getId() . '_lon';
		}
		return $this->fieldNameLon;
	}

	/**
	 * Define o valor da latitude ou da longitude
	 *
	 * @param string $strFieldName
	 * @param mixed $strValue
	 * @param string $strLatLon
	 */
	public function setValue($strFieldName=null, $strValue=null, $strLatLon=null)
	{
		if ($strFieldName == $this->getFieldNameLat())
		{
			$this->setLat($strValue);
		}
		else if ($strFieldName == $this->getFieldNameLon())
		{
			$this->setLon($strValue);
		}
		else if ($strFieldName == $this->getId() && isset($strLatLon))
		{
			$strLatLon = strtoupper($strLatLon);
			if ($strLatLon == 'LAT')
			{
				$this->setLat($strValue);
			}
			else if ($strLatLon == 'LON')
			{
				$this->setLon($strValue);
			}
		}
		return $this;
	}

	/**
	 * Valida se os campos estão preenchidos coretamente.
	 *
	 */
	public function validate($strPage=null, $strFields=null, $strIgnoreFields=null)
	{
		$this->setClass('fwFieldBoarder');
		$this->latGrau->setClass('fwFieldBoarder');
		$this->latMin->setClass('fwFieldBoarder');
		$this->latSeg->setClass('fwFieldBoarder');
		$this->latHem->setClass('fwFieldBoarder');
		$this->lonGrau->setClass('fwFieldBoarder');
		$this->lonMin->setClass('fwFieldBoarder');
		$this->lonSeg->setClass('fwFieldBoarder');
		$this->lonHem->setClass('fwFieldBoarder');
		if ($this->getRequired() == true)
		{
			if (is_null($this->latGrau->getValue()) ||
				is_null($this->latMin->getValue()) ||
				is_null($this->latSeg->getValue()) ||
				is_null($this->lonGrau->getValue()) ||
				is_null($this->lonMin->getValue()) ||
				is_null($this->lonSeg->getValue()))
			{
				$this->addError("Campo obrigatório");
				$this->setClass('fwFieldRequiredBoarder');
				return ( (string) $this->getError() === "" );
			}
		}
		if (!is_null($this->latGrau->getValue()) && $this->latGrau->getValue() > 35)
		{
			$this->addError("Grau Latitude inválido");
			$this->latGrau->setClass('fwFieldRequiredBoarder');
		}
		if (!is_null($this->latMin->getValue()) && $this->latMin->getValue() > 59)
		{
			$this->addError("Minuto Latitude inválido");
			$this->latMin->setClass('fwFieldRequiredBoarder');
		}
		if (!is_null($this->latSeg->getValue()) && $this->latSeg->getValue() > 59)
		{
			$this->addError("Segundo Latitude inválido");
			$this->latSeg->setClass('fwFieldRequiredBoarder');
		}
		// longitude
		if (!is_null($this->lonGrau->getValue()) && $this->lonGrau->getValue() != '' && $this->lonGrau->getValue() < 30 || $this->lonGrau->getValue() > 70)
		{
			$this->addError("Grau Longitude inválido");
			$this->lonGrau->setClass('fwFieldRequiredBoarder');
		}
		if (!is_null($this->lonMin->getValue()) && $this->lonMin->getValue() > 59)
		{
			$this->addError("Minuto Longitude inválido");
			$this->lonMin->setClass('fwFieldRequiredBoarder');
		}
		if (!is_null($this->lonSeg->getValue()) && $this->lonSeg->getValue() > 59)
		{
			$this->addError("Segundo Longitude inválido");
			$this->lonSeg->setClass('fwFieldRequiredBoarder');
		}
		return ( (string) $this->getError() === "" );
	}

	/**
	 * Limpa o conteudo dos campos
	 *
	 */
	public function clear()
	{
		$this->latGrau->setValue(null);
		$this->latMin->setValue(null);
		$this->latSeg->setValue(null);
		$this->lonGrau->setValue(null);
		$this->lonMin->setValue(null);
		$this->lonSeg->setValue(null);
	}

	/**
	 * Define os simbolos para Grau, Minuto e Segundos, que serão exibidos depois dos campos como texto de exemplo
	 * Devem ser passados separados por virgula;
	 * <code>
	 * $f->setSymbolS('G,M,S');
	 * </code>
	 *
	 * @param mixed $strNewValue
	 */
	public function setSymbols($strNewValue='grau,min,seg')
	{
		$this->symbols = $strNewValue;
		return $this;
	}

	/**
	 * Retorna a string com os simbolos para Grau, Minutos e Segundos, separados por vírgula
	 *
	 */
	public function getSymbols()
	{
		return $this->symbols;
	}

	/**
	 * Define os rótulos para os campos Grau, Minuto e Segundos, que serão exibidos na frente dos campos.
	 * Devem ser passados separados por virgula;
	 * <code>
	 * $f->setLabels('Grau:,Min:,Seg:');
	 * </code>
	 *
	 * @param mixed $strNewValue
	 */
	public function setLabels($strNewValue='Grau:,Min:,Seg:')
	{
		$this->labels = $strNewValue;
		return $this;
	}

	/**
	 * Retorna a string com os labels dos campos separados por virgula.
	 *
	 */
	public function getLabels()
	{
		return $this->labels;
	}

	public function setLatGrau($intNewValue=null)
	{
		$this->latGrau->setValue($intNewValue);
		return $this;
	}

	public function setLatMin($intNewValue=null)
	{
		$this->latMin->setValue($intNewValue);
		return $this;
	}

	public function setLatSeg($intNewValue=null)
	{
		$this->latSeg->setValue($intNewValue);
		return $this;
	}

	public function setLatHem($strNewValue=null)
	{
		$this->latHem->setValue($strNewValue);
		return $this;
	}

	public function setLonGrau($intNewValue=null)
	{
		$this->lonGrau->setValue($intNewValue);
		return $this;
	}

	public function setLonMin($intNewValue=null)
	{
		$this->lonMin->setValue($intNewValue);
		return $this;
	}

	public function setLonSeg($intNewValue=null)
	{
		$this->lonSeg->setValue($intNewValue);
		return $this;
	}

	public function setLonHem($strNewValue=null)
	{
		$this->lonHem->setValue($strNewValue);
		return $this;
	}

	public function getLatGrau()
	{
		return $this->latGrau->getValue();
	}

	public function getLatMin()
	{
		return $this->latMin->getValue();
	}

	public function getLatSeg()
	{
		return $this->latSeg->getValue();
	}

	public function getLatHem()
	{
		return $this->latHem->getValue();
	}

	public function getLonGrau()
	{
		return $this->lonGrau->getValue();
	}

	public function getLonMin()
	{
		return $this->lonMin->getValue();
	}

	public function getLonSeg()
	{
		return $this->lonSeg->getValue();
	}

	public function getLonHem()
	{
		return $this->lonHem->getValue();
	}

	public function setMapWidth($intNewValue=null)
	{
		$this->mapWidth = $intNewValue;
		return $this;
	}

	public function getMapWidth($intNewValue=null)
	{
		return $this->mapWidth;
	}

	public function setMapHeight($intNewValue=null)
	{
		$this->mapHeight = $intNewValue;
		return $this;
	}

	public function getMapHeight()
	{
		return $this->mapHeight;
	}

	public function getButtonGMap()
	{
		return $this->buttonGMap;
	}

	public function setMapHeaderText($strNewValue=null)
	{
		$this->mapHeaderText = $strNewValue;
		return $this;
	}

	public function getMapHeaderText()
	{
		return $this->mapHeaderText;
	}

	public function setMapHeaderFontSize($strNewValue=null)
	{
		$this->mapHeaderFontSize = $strNewValue;
		return $this;
	}

	public function getMapHeaderFontSize()
	{
		return $this->mapHeaderFontSize;
	}

	public function setMapHeaderFontColor($strNewValue=null)
	{
		$this->mapHeaderFontColor = $strNewValue;
		return $this;
	}

	public function getMapHeaderFontColor()
	{
		return $this->mapHeaderFontColor;
	}

    public function setMapCallback($strNewValue=null)
    {
        $this->mapCallback= $strNewValue;
		return $this;
    }
    public function getMapCallback()
    {
        return is_null($this->mapCallback) ? '' : $this->mapCallback;
    }
	public function setMapZoom($intNewValue=null)
	{
		$this->mapZoom = $intNewValue;
		return $this;
	}
	public function getMapZoom()
	{
		$zoom = ( ( $this->getLatGrau() && $this->getLonGrau() ) ? 12 : 4 );
		return is_null($this->mapZoom) ? $zoom : $this->mapZoom;
	}
	public function setMapType($strNewValue=null)
	{
		$this->mapType = $strNewValue;
		return $this;
	}
	public function getMapType()
	{
		$aTypes = array('ROADMAP','SATELLITE','TERRAIN','HYBRID');
		if( in_array( StringHelper::strtoupper($this->mapType), $aTypes ) ){
		 	return StringHelper::strtolower( $this->mapType );
		}
		return 'roadmap';
	}
}

/*
  print '<form name="formdin" action="" method="POST">';
  $c = new TCoordGMS('coord');
  $c->setRequired(true);
  $c->setLat(-15.52);
  $c->setLon(-28.74);
  $c->show();
  print '<hr>';
  print '<input type="submit" value="Gravar">';
  print '</form><pre>';
  print_r($c->getValue());
  print '</pre>'
 */
?>
