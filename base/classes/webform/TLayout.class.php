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

class TLayout extends THtmlPage {

    private static $arrLayout;
    private $northSize;
    private $southSize;
    private $eastSize;
    private $westSize;
    private $showBorders;
    private $centerArea;
    private $northArea;
    private $southArea;
    private $eastArea;
    private $westArea;
    private $container;
    // global
    private $closable; // permite fechar/abrir as areas clicando no centro
    private $resizable; // clicar na barra e arrastar para mudar o tamanho do espaço
    private $slidable; // quanto esta aberto, ao clicar na barra ele abre e ao retirar o mouse da area ela se fecha automaticamente
    private $initClosed; // inicia com todas as áreas  fechadas
    // area iniClosed
    private $northInitClosed;
    private $southInitClosed;
    private $eastInitClosed;
    private $westInitClosed;
    // area spacing_open/closed
    private $spacingOpen;
    private $spacingClosed;
    private $northSpacingOpen;
    private $northSpacingClosed;
    private $southSpacingOpen;
    private $southSpacingClosed;
    private $eastSpacingOpen;
    private $eastSpacingClosed;
    private $westSpacingOpen;
    private $westSpacingClosed;
    // area resizable
    private $northResizable;
    private $southResizable;
    private $eastResizable;
    private $westResizable;
    // area slidable
    private $northSlidable;
    private $southSlidable;
    private $eastSlidable;
    private $westSlidable;
    // area closable
    private $northClosable;
    private $southClosable;
    private $eastClosable;
    private $westClosable;
    private $padding; // margem interna da área
    private $url;

    /**
     * put your comment there...
     *
     * @param mixed $strId
     * @param mixed $intNorthSize
     * @param mixed $intSouthSize
     * @param mixed $intEastSize
     * @param mixed $intWestSize
     * @param mixed $boolShowBorders
     * @param mixed $boolClosable
     * @param mixed $boolResizable
     * @param mixed $boolSlidable
     * @param mixed $intPadding
     * @param mixed $boolInitClosed
     * @param mixed $intSpacingOpen
     * @param mixed $intSpacingClosed
     * @param mixed $intNorthSpacingOpen
     * @param mixed $intNorthSpacingClosed
     * @param mixed $intSouthSpacingOpen
     * @param mixed $intSouthSpacingClosed
     * @param mixed $intEastSpacingOpen
     * @param mixed $intEastSpacingClosed
     * @param mixed $intWestSpacingOpen
     * @param mixed $intWestSpacingClosed
     * @param mixed $boolNorthResizable
     * @param mixed $boolSouthResizable
     * @param mixed $boolEastResizable
     * @param mixed $boolWestResizable
     * @param mixed $boolNorthClosable
     * @param mixed $boolSouthClosable
     * @param mixed $boolEastClosable
     * @param mixed $boolWestClosable
     * @param mixed $boolNorthSlidable
     * @param mixed $boolSouthSlidable
     * @param mixed $boolEastSlidable
     * @param mixed $boolWestSlidable
     * @param mixed $boolNorthInitClosed
     * @param mixed $boolSouthInitClosed
     * @param mixed $boolEastInitClosed
     * @param mixed $boolWestInitClosed
     * @return TLayout
     */
    public function __construct($strId=null
    , $intNorthSize=null
    , $intSouthSize=null
    , $intEastSize=null
    , $intWestSize=null
    , $boolShowBorders=null
    , $boolClosable=null
    , $boolResizable=null
    , $boolSlidable=null
    , $intPadding=null
    , $boolInitClosed=null
    , $intSpacingOpen=null
    , $intSpacingClosed=null
    , $intNorthSpacingOpen=null, $intNorthSpacingClosed=null
    , $intSouthSpacingOpen=null, $intSouthSpacingClosed=null
    , $intEastSpacingOpen=null, $intEastSpacingClosed=null
    , $intWestSpacingOpen=null, $intWestSpacingClosed=null
    , $boolNorthResizable=null
    , $boolSouthResizable=null
    , $boolEastResizable=null
    , $boolWestResizable=null
    , $boolNorthClosable=null
    , $boolSouthClosable=null
    , $boolEastClosable=null
    , $boolWestClosable=null
    , $boolNorthSlidable=null
    , $boolSouthSlidable=null
    , $boolEastSlidable=null
    , $boolWestSlidable=null
    , $boolNorthInitClosed=null
    , $boolSouthInitClosed=null
    , $boolEastInitClosed=null
    , $boolWestInitClosed=null) {
	parent::__construct();

	// adicionar prototype
	$this->addJsFile('prototype/prototype.js');
	$this->addJsFile('prototype/window_ext.js');

	//$this->addJsFile('prototype/effects.js');
	$this->addJsFile('prototype/window.js');
	//$this->addJsFile('prototype/window_effects.js');
	$this->addCssFile('prototype/themes/default.css');
	$this->addCssFile('prototype/themes/alphacube.css');
		
	if(!defined('MIGRATE_JQUERY')){ define('MIGRATE_JQUERY',FALSE); }	
	if(MIGRATE_JQUERY){
		// Tentaiva de Migrar para Jquery 1.9.1 
		$this->addJsFile('jquery-1.9/jquery-1.9.1.js');
		$this->addJsFile('jquery-1.9/jquery-migrate-1.4.1.js');
		$this->addJsFile('jquery/js_new/jquery.corner.js' );
	}else{
		// adicionar jquery
		$this->addJsFile( 'jquery/jquery.js' );
		$this->addJsFile( 'jquery/jquery.corner.js' );
	}
	
	$this->addJsFile('jquery/jlayout/jquery.jlayout-1.3.js');
	$this->addJsFile('jquery/jquery-ui-all.js');
	$this->addJsFile( 'jquery/blockui/jquery.blockUI.js' );
	$this->addJsFile( 'jquery/jAlert/jquery.alerts.js' );
	$this->addCssFile( 'jquery/jAlert/jquery.alerts.css' );
	$this->addCssFile( 'jquery/ui/base/base.css' );
	$this->addJsFile( 'lazyload/lazyload-min.js' );
	$this->setId(is_null($strId) ? $this->getRandomChars(5) : $strId );
	$this->parent = null;
	//$this->setId('myLayout');
	$this->setNorthSize($intNorthSize);
	$this->setSouthSize($intSouthSize);
	$this->setEastSize($intEastSize);
	$this->setWestSize($intWestSize);
	$this->setShowBorders($boolShowBorders);
	//---------------------------------------
	$this->setSpacingOpen($intSpacingOpen);
	$this->setSpacingClosed($intSpacingClosed);
	$this->setNorthSpacingOpen($intNorthSpacingOpen);
	$this->setNorthSpacingClosed($intNorthSpacingClosed);
	$this->setSouthSpacingOpen($intSouthSpacingOpen);
	$this->setSouthSpacingClosed($intSouthSpacingClosed);
	$this->setEastSpacingOpen($intEastSpacingOpen);
	$this->setEastSpacingClosed($intEastSpacingClosed);
	$this->setWestSpacingOpen($intWestSpacingOpen);
	$this->setWestSpacingClosed($intWestSpacingClosed);
	//-------------------------------------------------------------------
	$this->setNorthResizable($boolNorthResizable);
	$this->setSouthResizable($boolSouthResizable);
	$this->setEastResizable($boolEastResizable);
	$this->setWestResizable($boolWestResizable);
	//-------------------------------------------------------------------
	$this->setNorthSlidable($boolNorthSlidable);
	$this->setSouthSlidable($boolSouthSlidable);
	$this->setEastSlidable($boolEastSlidable);
	$this->setWestSlidable($boolWestSlidable);

	//-------------------------------------------------------------------
	$this->setNorthClosable($boolNorthClosable);
	$this->setSouthClosable($boolSouthClosable);
	$this->setEastClosable($boolEastClosable);
	$this->setWestClosable($boolWestClosable);

	$this->setClosable($boolClosable);
	$this->setResizable($boolResizable);
	$this->setSlidable($boolSlidable);
	$this->setPadding($intPadding);
	$this->setInitClosed($boolInitClosed);

	$this->setNorthInitClosed($boolNorthInitClosed);
	$this->setSouthInitClosed($boolSouthInitClosed);
	$this->setEastInitClosed($boolEastInitClosed);
	$this->setWestInitClosed($boolWestInitClosed);

	/*
	  $this->centerArea = new TElement('div');
	  $this->northArea = new TElement('div');
	  $this->southArea = new TElement('div');
	  $this->eastArea = new TElement('div');
	  $this->westArea = new TElement('div');
	 */
	$this->centerArea = new TLayOutArea();
	$this->northArea = new TLayOutArea();
	$this->southArea = new TLayOutArea();
	$this->eastArea = new TLayOutArea();
	$this->westArea = new TLayOutArea();
	$this->clearCss();
    }

    public function show($print=true) {
		$id = $this->getId();
		$this->centerArea->setClass('ui-' . $id . '-center', false);
		$this->northArea->setClass('ui-' . $id . '-north', false);
		$this->southArea->setClass('ui-' . $id . '-south', false);
		$this->eastArea->setClass('ui-' . $id . '-east', false);
		$this->westArea->setClass('ui-' . $id . '-west', false);
		if (is_null ( $this->parent )) {
			$arrJsOnLoad = $this->getJsOnLoad ();
			$this->setJsOnLoad ( null );
			$this->addJsCssFile ( 'jlayout.css' );
			$this->addStyle ( $this->getStyle () );
			$this->addJavascript ( $this->getJs () );
			if (is_array ( self::$arrLayout )) {
				foreach ( self::$arrLayout as $k => $objLayout ) {
					$this->addJavascript ( $objLayout->getJs () );
					$this->addStyle ( $objLayout->getStyle () );
				}
			}
			if (is_array ( $arrJsOnLoad )) {
				$arrJsOnLoad = array_merge ( $this->getJsOnLoad (), $arrJsOnLoad );
				$this->setJsOnLoad ( $arrJsOnLoad );
			}
		}
	
		if( $this->getContainer()) {
		    $container = $this->getContainer();
		    $container->setId($this->getId().'_container');
		    $container->add($this->getNorthArea());
		    $container->add($this->getSouthArea());
		    $container->add($this->getEastArea());
		    $container->add($this->centerArea);
		    $container->add($this->getWestArea());
		    $this->addInBody($container);
		} else {
		    $this->addInBody($this->centerArea);
		    $this->addInBody($this->getNorthArea());
		    $this->addInBody($this->getSouthArea());
		    $this->addInBody($this->getEastArea());
		    $this->addInBody($this->getWestArea());
		}
		return parent::show($print);
    }

    public function getJs() {
	if (!$this->getSpacingOpen() && $this->getResizable()) {
	    $this->setSpacingOpen(4);
	}
	if (!$this->getSpacingClosed() && $this->getResizable()) {
	    $this->setSpacingClosed(4);
	}
	if (!$this->getSpacingOpen() && $this->getClosable()) {
	    $this->setSpacingOpen(4);
	}
	if (!$this->getSpacingClosed() && $this->getClosable()) {
	    $this->setSpacingClosed(4);
	}
	$centerClass = '.ui-' . $this->getId() . '-center';
	$northClass = '.ui-' . $this->getId() . '-north';
	$southClass = '.ui-' . $this->getId() . '-south';
	$eastClass = '.ui-' . $this->getId() . '-east';
	$westClass = '.ui-' . $this->getId() . '-west';

	$js = new TElement('');
	$js->add('l' . $this->getId() . '=jQuery( jQuery("' . $centerClass . '").parent() ).layout({');
	// definições gerais para todas as áreas
	$js->add('spacing_open:' . $this->getSpacingOpen(), false);

	if (!is_null($this->getSpacingClosed())) {
	    $js->add(', spacing_closed:' . $this->getSpacingClosed(), false);
	}
	if (!$this->getResizable()) {
	    $js->add(', resizable:false', false);
	}
	if (!$this->getClosable()) {
	    $js->add(', closable:false', false);
	}
	if (!$this->getSlidable()) {
	    $js->add(', slidable:false', false);
	}
	if ($this->getInitClosed()) {
	    $js->add(', initClosed:true', false);
	}
	// definições gerais para cada área
	$js->add(',center__paneSelector:"' . $centerClass . '"', false);
	$child = $this->getCenterArea()->getChildren();
	if (is_array($child) && is_object($child[0]) && get_Class($child[0]) == 'TLayout') {
	    $js->add(', center__onresize:"l' . $child[0]->getId() . '.resizeAll"', false);
	}
	$child = null;
	if ($this->getNorthArea()) {

	    if (!is_null($this->getNorthSlidable())) {
		$js->add(', north__slidable:' . ( $this->getNorthSlidable() ? 'true' : 'false'));
	    }
	    if (!is_null($this->getNorthResizable())) {
		$js->add(', north__resizable:' . ( $this->getNorthResizable() ? 'true' : 'false'), false);
	    }
	    if (!is_null($this->getNorthSpacingOpen())) {
		$js->add(', north__spacing_open:' . $this->getNorthSpacingOpen(), false);
	    }
	    if (!is_null($this->getNorthSpacingClosed())) {
		$js->add(', north__spacing_closed:' . $this->getNorthSpacingClosed(), false);
	    }
	    if ($this->getNorthInitClosed()) {
		$js->add(', north__initClosed:true', false);
	    }
	    if ($this->getNorthClosable()) {
		$js->add(', north__closable:true', false);
	    }
	    $js->add(', north__paneSelector:"' . $northClass . '"', false);
	    $js->add(', north__size:' . $this->getNorthSize(), false);
	    $child = $this->getNorthArea()->getChildren();
	    if (is_array($child) && is_object($child[0]) && get_Class($child[0]) == 'TLayout') {
		$js->add(', north__onresize:"l' . $child[0]->getId() . '.resizeAll"', false);
	    }
	}
	if ($this->getSouthArea()) {
	    if (!is_null($this->getSouthSlidable())) {
		$js->add(', south__slidable:' . ( $this->getSouthSlidable() ? 'true' : 'false'));
	    }
	    if (!is_null($this->getSouthResizable())) {
		$js->add(', south__resizable:' . ( $this->getSouthResizable() ? 'true' : 'false'), false);
	    }
	    if (!is_null($this->getSouthSpacingOpen())) {
		$js->add(', south__spacing_open:' . $this->getSouthSpacingOpen(), false);
	    }
	    if (!is_null($this->getSouthSpacingClosed())) {
		$js->add(', south__spacing_closed:' . $this->getSouthSpacingClosed(), false);
	    }
	    if ($this->getSouthInitClosed()) {
		$js->add(', south__initClosed:true', false);
	    }
	    if ($this->getSouthClosable()) {
		$js->add(', south__closable:true', false);
	    }
	    $js->add(', south__paneSelector:"' . $southClass . '"', false);
	    $js->add(', south__size:' . $this->getSouthSize(), false);
	    if (is_array($child) && is_object($child[0]) && get_Class($child[0]) == 'TLayout') {
		$js->add(', south__onresize:"l' . $child[0]->getId() . '.resizeAll"', false);
	    }
	}
	if ($this->getEastArea()) {
	    if (!is_null($this->getEastSlidable())) {
		$js->add(', east__slidable:' . ( $this->getEastSlidable() ? 'true' : 'false'));
	    }
	    if (!is_null($this->getEastResizable())) {
		$js->add(', east__resizable:' . ( $this->getEastResizable() ? 'true' : 'false'), false);
	    }
	    if (!is_null($this->getEastSpacingOpen())) {
		$js->add(', east__spacing_open:' . $this->getEastSpacingOpen(), false);
	    }
	    if (!is_null($this->getEastSpacingClosed())) {
		$js->add(', east__spacing_closed:' . $this->getEastSpacingClosed(), false);
	    }
	    if ($this->getEastInitClosed()) {
		$js->add(', east__initClosed:true', false);
	    }
	    if ($this->getEastClosable()) {
		$js->add(', east__closable:true', false);
	    }
	    $js->add(', east__paneSelector:"' . $eastClass . '"', false);
	    $js->add(', east__size:' . $this->getEastSize(), false);
	    if (is_array($child) && is_object($child[0]) && get_Class($child[0]) == 'TLayout') {
		$js->add(', east__onresize:"l' . $child[0]->getId() . '.resizeAll"', false);
	    }
	}
	if ($this->getWestArea()) {
	    if (!is_null($this->getWestSlidable())) {
		$js->add(', west__slidable:' . ( $this->getWestSlidable() ? 'true' : 'false'));
	    }
	    if (!is_null($this->getWestResizable())) {
		$js->add(', west__resizable:' . ( $this->getWestResizable() ? 'true' : 'false'), false);
	    }
	    if (!is_null($this->getWestSpacingOpen())) {
		$js->add(', west__spacing_open:' . $this->getWestSpacingOpen(), false);
	    }
	    if (!is_null($this->getWestSpacingClosed())) {
		$js->add(', west__spacing_closed:' . $this->getWestSpacingClosed(), false);
	    }
	    if ($this->getWestInitClosed()) {
		$js->add(', west__initClosed:true', false);
	    }
	    if ($this->getWestClosable()) {
		$js->add(', west__closable:true', false);
	    }
	    $js->add(', west__paneSelector:"' . $westClass . '"', false);
	    $js->add(', west__size:' . $this->getWestSize(), false);
	    if (is_array($child) && is_object($child[0]) && get_Class($child[0]) == 'TLayout') {
		$js->add(', west__onresize:"l' . $child[0]->getId() . '.resizeAll"', false);
	    }
	}
	$js->add(' } );', false);
	return $js;
    }

    //--------------------------------------------------------------------
    public function getStyle() {
	$centerClass = '.ui-' . $this->getId() . '-center';
	$northClass = '.ui-' . $this->getId() . '-north';
	$southClass = '.ui-' . $this->getId() . '-south';
	$eastClass = '.ui-' . $this->getId() . '-east';
	$westClass = '.ui-' . $this->getId() . '-west';
	if (!$this->getShowBorders()) {
	    $this->setCss('border', '0px');
	} else {
	    if (!$this->getCss('border')) {
		$this->setCss('border', '1px solid black');
	    }
	}
	if ($this->getPadding() && !$this->getCss('padding')) {
	    $this->setCss('padding', $this->getPadding());
	}
	if ($css = $this->getCss()) {
	    $style = new TElement('');
	    if ($this->getNorthArea()) {
		$style->add($northClass . '{');
		foreach ($css as $k => $v) {
		    if (!$this->getNorthArea()->getCss($k)) {
			$style->add($k . ':' . $v . ';', false);
		    }
		}
		if (is_array($cssArea = $this->getNorthArea()->getCss())) {
		    foreach ($cssArea as $k => $v) {
			$style->add($k . ':' . $this->getNorthArea()->getCss($k) . ';', false);
		    }
		}
		$this->getNorthArea()->clearCss();
		$style->add('}', false);
	    }
	    if ($this->getSouthArea()) {
		$style->add($southClass . '{');
		foreach ($css as $k => $v) {
		    if (!$this->getSouthArea()->getCss($k)) {
			$style->add($k . ':' . $v . ';', false);
		    }
		}
		if (is_array($cssArea = $this->getSouthArea()->getCss())) {
		    foreach ($cssArea as $k => $v) {
			$style->add($k . ':' . $this->getSouthArea()->getCss($k) . ';', false);
		    }
		}
		$this->getSouthArea()->clearCss();
		$style->add('}', false);
	    }
	    if ($this->getEastArea()) {
		$style->add($eastClass . '{');
		foreach ($css as $k => $v) {
		    if (!$this->getEastArea()->getCss($k)) {
			$style->add($k . ':' . $v . ';', false);
		    }
		}
		if (is_array($cssArea = $this->getEastArea()->getCss())) {
		    foreach ($cssArea as $k => $v) {
			$style->add($k . ':' . $this->getEastArea()->getCss($k) . ';', false);
		    }
		}
		$style->add('}', false);
		$this->getEastArea()->clearCss();
	    }
	    if ($this->getWestArea()) {
		$style->add($westClass . '{');
		foreach ($css as $k => $v) {
		    if (!$this->getWestArea()->getCss($k)) {
			$style->add($k . ':' . $v . ';', false);
		    }
		}
		if (is_array($cssArea = $this->getWestArea()->getCss())) {
		    foreach ($cssArea as $k => $v) {
			$style->add($k . ':' . $this->getWestArea()->getCss($k) . ';', false);
		    }
		}
		$style->add('}', false);
		$this->getWestArea()->clearCss();
	    }
	    // estilo da area do centro
	    $style->add($centerClass . '{');
	    foreach ($css as $k => $v) {
		if (!$this->getCenterArea()->getCss($k)) {
		    $style->add($k . ':' . $v . ';', false);
		}
	    }
	    if (is_array($cssArea = $this->getCenterArea()->getCss())) {
		foreach ($cssArea as $k => $v) {
		    $style->add($k . ':' . $this->getCenterArea()->getCss($k) . ';', false);
		}
	    }
	    $this->getCenterArea()->clearCss();
	    $style->add('}', false);
	}
	//return $style->show(false);
	return $style;
    }

    //-------------------------------------------------------------------------------------------
    public function setNorthSize($intNewValue=null) {
	$this->northSize = $intNewValue;
    }

    public function getNorthSize() {
	return $this->northSize;
    }

    //-------------------------------------------------------------------------------------------
    public function setSouthSize($intNewValue=null) {
	$this->southSize = $intNewValue;
    }

    public function getSouthSize() {
	return $this->southSize;
    }

    //-------------------------------------------------------------------------------------------
    public function setEastSize($intNewValue=null) {
	$this->eastSize = $intNewValue;
    }

    public function getEastSize($intNewValue=null) {
	return $this->eastSize;
    }

    //-------------------------------------------------------------------------------------------
    public function setWestSize($intNewValue=null) {
	$this->westSize = $intNewValue;
    }

    public function getWestSize() {
	return $this->westSize;
    }

    //-------------------------------------------------------------------------------------------
    public function getCenterArea() {
	return $this->centerArea;
    }

    //-------------------------------------------------------------------------------------------
    public function getNorthArea() {
	if ($this->getNorthSize()) {
	    return $this->northArea;
	}
	return;
    }

    //-------------------------------------------------------------------------------------------
    public function getSouthArea() {
	if ($this->getSouthSize()) {
	    return $this->southArea;
	}
	return null;
    }

    //-------------------------------------------------------------------------------------------
    public function getEastArea() {
	if ($this->getEastSize()) {
	    return $this->eastArea;
	}
	return null;
    }

    //-------------------------------------------------------------------------------------------
    public function getWestArea() {
	if ($this->getWestSize()) {
	    return $this->westArea;
	}
	return null;
    }

    //-------------------------------------------------------------------------------------------
    public function setShowBorders($boolNewValue=null) {
	$this->showBorders = $boolNewValue;
    }

    public function getShowBorders() {
	return ($this->showBorders === true) ? true : false;
    }

    //-------------------------------------------------------------------------------------------
    public function setClosable($boolNewValue=null, $intSpacingOpened=null, $intSpacingClosed=null) {
	$this->closable = $boolNewValue;
	if ($intSpacingClosed) {
	    $this->setSpacingClosed($intSpingClosed);
	}
	if ($intSpacingOpened) {
	    $this->setSpacingOpen($intSpacingOpened);
	}
    }

    public function getClosable() {
	return ($this->closable === true) ? true : false;
    }

    //-------------------------------------------------------------------------------------------
    public function setResizable($boolNewValue=null) {
	$this->resizable = $boolNewValue;
    }

    public function getResizable() {
	return ($this->resizable === true) ? true : false;
    }

    //-------------------------------------------------------------------------------------------
    /**
     * Define se a área será aberta ao clicar na divisão e será fechada quando o mouse sair
     *
     * @param mixed $boolNewValue
     */
    public function setSlidable($boolNewValue=null) {
	$this->slidable = $boolNewValue;
    }

    public function getSlidable() {
	return ($this->slidable === true) ? true : false;
    }

    /**
     * Define se todas as áres inicializarão fechadas
     *
     * @param boolean $boolNewValue
     */
    public function setInitClosed($boolNewValue=null) {
	$this->initClosed = $boolNewValue;
    }

    public function getInitClosed() {
	return ($this->initClosed === true) ? true : false;
    }

    //-------------------------------------------------------------------------------------------
    public function setNorthInitClosed($boolNewValue=null) {
	$this->northInitClosed = $boolNewValue;
    }

    public function getNorthInitClosed() {
	return ($this->northInitClosed === true) ? true : false;
    }

    //-------------------------------------------------------------------------------------------
    public function setSouthInitClosed($boolNewValue=null) {
	$this->southInitClosed = $boolNewValue;
    }

    public function getSouthInitClosed() {
	return ($this->southInitClosed === true) ? true : false;
    }

    //-------------------------------------------------------------------------------------------
    public function setEastInitClosed($boolNewValue=null) {
	$this->eastInitClosed = $boolNewValue;
    }

    public function getEastInitClosed() {
	return ($this->eastInitClosed === true) ? true : false;
    }

    public function setWestInitClosed($boolNewValue=null) {
	$this->westInitClosed = $boolNewValue;
    }

    public function getWestInitClosed() {
	return ($this->westInitClosed === true) ? true : false;
    }

    /**
     * Define a espessuara da disvisória quando a área estiver aberta
     *
     * @param int $intNewValue
     */
    public function setSpacingOpen($intNewValue=null) {
	$this->spacingOpen = $intNewValue;
    }

    public function getSpacingOpen() {
	return is_null($this->spacingOpen) ? 0 : (int) $this->spacingOpen;
    }

    /**
     * Define a espessuara da disvisória quando a área estiver fechada
     *
     * @param int $intNewValue
     */
    public function setSpacingClosed($intNewValue=null) {
	$this->spacingClosed = $intNewValue;
    }

    public function getSpacingClosed() {
	return is_null($this->spacingClosed) ? 0 : (int) $this->spacingClosed;
    }

    //-------------------------------------------------------------------------------------------
    public function setPadding($intNewValue=null) {
	$this->padding = $intNewValue;
    }

    public function getPadding() {
	return (is_null($this->padding) ? '2' : preg_replace('/[^0-9]/', '', $this->padding)) . 'px';
    }

    //-------------------------------------------------------------------------------------------
    public function setLayOut(TLayout $newLayOut=null) {
	$this->layOut = $newLayOut;
    }

    //-------------------------------------------------------------------------------------------
    public function setUrl($strNewValue=null) {
	$this->getCenterArea()->setUrl($strNewValue);
    }

    public function GetUrl() {
	return $this->url;
    }

    //-------------------------------------------------------------------------------------------
    public function addLayout(TLayout $objLayout, $strArea=null) {
	$strArea = is_null($strArea) ? 'C' : $strArea;
	$objLayout->parent = $this;
	self::$arrLayout[] = $objLayout;
	if ($strArea == 'C') {
	    $this->clearArea($this->centerArea);
	    $this->getCenterArea()->add($objLayout);
	    $this->getCenterArea()->setCss('padding', '0px');
	    $this->getCenterArea()->setCss('border', '0px');
	} else if ($strArea == 'N') {
	    $this->clearArea($this->northArea);
	    $this->getNorthArea()->add($objLayout);
	    $this->getNorthArea()->setCss('padding', '0px');
	    $this->getNorthArea()->setCss('border-bottom', '0px');
	} else if ($strArea == 'S') {
	    $this->clearArea($this->southArea);
	    $this->getSouthArea()->add($objLayout);
	    $this->getSouthArea()->setCss('padding', '0px');
	    $this->getSouthArea()->setCss('border-top', '0px');
	} else if ($strArea == 'E') {
	    $this->clearArea($this->estArea);
	    $this->getEastArea()->add($objLayout);
	    $this->getEastArea()->setCss('padding', '0px');
	    $this->getEasthArea()->setCss('border-right', '0px');
	} else if ($strArea == 'W') {
	    $this->clearArea($this->westArea);
	    $this->getWestArea()->add($objLayout);
	    $this->getWestArea()->setCss('padding', '0px');
	    $this->getWesthArea()->setCss('border-left', '0px');
	}
    }

    //-------------------------------------------------------------------------------------------
    public function removeLayout(TLayout $layout=null) {
	$this->clearArea($layout->getNorthArea());
	$this->clearArea($layout->getSouthArea());
	$this->clearArea($layout->getEastArea());
	$this->clearArea($layout->getWestArea());
	$this->clearArea($layout->getCenterArea());
    }

    public function clearArea(TLayoutArea $area=null) {
	if (is_null($area)) {
	    return;
	}
	$child = $area->getChildren();
	if (is_array($child)) {
	    if (is_object($child[0]) && get_Class($child[0]) == 'TLayout') {
		$this->removeLayout($child[0]);
		$id = $child[0]->getId();
		foreach (self::$arrLayout as $k => $lo) {
		    if ($lo->getId() == $id) {
			unset(self::$arrLayout[$k]);
			break;
		    }
		}
	    }
	    $area->clearChildren();
	    //$key = array_search($child[0],self::$arrLayout);
	    //self::$arrLayout[$key]=null;
	    //unset(self::$arrLayout[$key] );
	}
    }

    //-------------------------------------------------------------------------------------------
    /**
     * Define a espessuara da disvisória quando a área estiver aberta
     *
     * @param int $intNewValue
     */
    public function setNorthSpacingOpen($intNewValue=null) {
	$this->northSpacingOpen = $intNewValue;
    }

    public function getNorthSpacingOpen() {
	return is_null($this->northSpacingOpen) ? null : (int) $this->northSpacingOpen;
    }

    /**
     * Define a espessuara da disvisória quando a área estiver fechada
     *
     * @param int $intNewValue
     */
    public function setNorthSpacingClosed($intNewValue=null) {
	$this->northSpacingClosed = $intNewValue;
    }

    public function getNorthSpacingClosed() {
	return is_null($this->northSpacingClosed) ? null : (int) $this->northSpacingClosed;
    }

    //-------------------------------------------------------------------------------------------

    /**
     * Define a espessuara da disvisória quando a área estiver aberta
     *
     * @param int $intNewValue
     */
    public function setSouthSpacingOpen($intNewValue=null) {
	$this->southSpacingOpen = $intNewValue;
    }

    public function getSouthSpacingOpen() {
	return is_null($this->southSpacingOpen) ? null : (int) $this->southSpacingOpen;
    }

    /**
     * Define a espessuara da disvisória quando a área estiver fechada
     *
     * @param int $intNewValue
     */
    public function setSouthSpacingClosed($intNewValue=null) {
	$this->southSpacingClosed = $intNewValue;
    }

    public function getSouthSpacingClosed() {
	return is_null($this->southSpacingClosed) ? null : (int) $this->southSpacingClosed;
    }

    //-------------------------------------------------------------------------------------------

    /**
     * Define a espessuara da disvisória quando a área estiver aberta
     *
     * @param int $intNewValue
     */
    public function setEastSpacingOpen($intNewValue=null) {
	$this->eastSpacingOpen = $intNewValue;
    }

    public function getEastSpacingOpen() {
	return is_null($this->eastSpacingOpen) ? null : (int) $this->eastSpacingOpen;
    }

    /**
     * Define a espessuara da disvisória quando a área estiver fechada
     *
     * @param int $intNewValue
     */
    public function setEastSpacingClosed($intNewValue=null) {
	$this->eastSpacingClosed = $intNewValue;
    }

    public function getEastSpacingClosed() {
	return is_null($this->eastSpacingClosed) ? null : (int) $this->eastSpacingClosed;
    }

    //-------------------------------------------------------------------------------------------

    /**
     * Define a espessuara da disvisória quando a área estiver aberta
     *
     * @param int $intNewValue
     */
    public function setWestSpacingOpen($intNewValue=null) {
	$this->westSpacingOpen = $intNewValue;
    }

    public function getWestSpacingOpen() {
	return is_null($this->westSpacingOpen) ? null : (int) $this->westSpacingOpen;
    }

    /**
     * Define a espessuara da disvisória quando a área estiver fechada
     *
     * @param int $intNewValue
     */
    public function setWestSpacingClosed($intNewValue=null) {
	$this->westSpacingClosed = $intNewValue;
    }

    public function getWestSpacingClosed() {
	return is_null($this->westSpacingClosed) ? null : (int) $this->westSpacingClosed;
    }

    //-------------------------------------------------------------------------------------------
    public function setNorthResizable($boolNewValue=null) {
	$this->northResizable = $boolNewValue;
    }

    public function getNorthResizable() {
	return $this->northResizable;
    }

    //-------------------------------------------------------------------------------------------

    public function setSouthResizable($boolNewValue=null) {
	$this->southResizable = $boolNewValue;
    }

    public function getSouthResizable() {
	return $this->southResizable;
    }

    //-------------------------------------------------------------------------------------------

    public function setEastResizable($boolNewValue=null) {
	$this->eastResizable = $boolNewValue;
    }

    public function getEastResizable() {
	return $this->nortResizable;
    }

    //-------------------------------------------------------------------------------------------

    public function setWestResizable($boolNewValue=null) {
	$this->westResizable = $boolNewValue;
    }

    public function getWestResizable() {
	return $this->westResizable;
    }

    //-------------------------------------------------------------------------------------------

    public function setNorthSlidable($boolNewValue=null) {
	$this->northSlidable = $boolNewValue;
    }

    public function getNorthSlidable() {
	return $this->northSlidable;
    }

    //-------------------------------------------------------------------------------------------

    public function setSouthSlidable($boolNewValue=null) {
	$this->southSlidable = $boolNewValue;
    }

    public function getSouthSlidable() {
	return $this->southSlidable;
    }

    //-------------------------------------------------------------------------------------------

    public function setEastSlidable($boolNewValue=null) {
		$this->eastSlidable = $boolNewValue;
    }

    public function getEastSlidable() {
		return $this->eastSlidable;
    }

    //-------------------------------------------------------------------------------------------
    public function setWestSlidable($boolNewValue=null) {
		$this->westSlidable = $boolNewValue;
    }
    public function getWestSlidable() {
		return $this->westSlidable;
    }
    //-------------------------------------------------------------------------------------------
    public function setNorthClosable($boolNewValue=null) {
		$this->northClosable = $boolNewValue;
    }
    public function getNorthClosable() {
		return $this->northClosable;
    }
    //-------------------------------------------------------------------------------------------
    public function setSouthClosable($boolNewValue=null) {
		$this->southClosable = $boolNewValue;
    }
    public function getSouthClosable() {
		return $this->southClosable;
    }
    //-------------------------------------------------------------------------------------------
    public function setEastClosable($boolNewValue=null) {
		$this->eastClosable = $boolNewValue;
    }

    public function getEastClosable() {
		return $this->eastClosable;
    }
    // -------------------------------------------------------------------------------------------
	public function setWestClosable($boolNewValue = null) {
		$this->westClosable = $boolNewValue;
	}
	public function getWestClosable() {
		return $this->westClosable;
	}
	// -------------------------------------------------------------------------------------------
	public function addJsFile($strJsFile = null) {
		if (! is_null ( $strJsFile )) {
			$this->addJsCssFile ( $strJsFile );
		}
	}
	// -------------------------------------------------------------------------------
	public function addCssFile($strCssFile = null) {
		if (! is_null ( $strCssFile )) {
			$this->addJsCssFile ( $strCssFile );
		}
	}
	// -------------------------------------------------------------------------------------------
	public function getContainer() {
		return $this->container;
	}
	// -------------------------------------------------------------------------------------------
	public function setContainer(TELEMENT $objNewContainer) {
		$this->container = $objNewContainer;
	}
    //-------------------------------------------------------------------------------------------
}

class TLayOutArea extends TElement {

    private $url;

    public function __construct() {
	parent::__construct('div');
    }

    public function setUrl($strNewValue=null) {
	$this->url = $strNewValue;
    }

    public function getUrl() {
	return $this->url;
    }

    public function show($print=true) {
	if ($this->getUrl() || strtolower($this->getTagType()) == 'iframe') {
	    $this->setTagType('iframe');
	    $this->setProperty('src', ( is_null($this->getUrl()) ? 'about:blank' : $this->getUrl()));
	    $this->setCss('padding', '0px');
	    $this->setCss('overflow', 'auto');
	    $this->setCss('border', '0px');
	    $this->setCss('vertical-align', 'middle');
	    $this->setCss('background', 'transparent');
	    $this->setCss('background-color', 'transparent');
	    $this->setProperty('hspace', '0');
	    $this->setProperty('vspace', '0');
	    $this->setProperty('tabindex', '-1');
	    $this->setProperty('frameborder', '0');
	    $this->setProperty('allowTransparency', 'true');
	}
	return parent::show($print);
    }
}

/*
  $lo = new TLayout(250,50,100,100,true,false,false,false,null,false,10,10,5,5);
  $lo->setCss('background-color','#efefef');
  $lo2 = new TLayout(0,0,50,50,true,true,true,true,null,false,10,10);
  $lo2->setCss('background-color','red');
  $lo2->getWestArea()->setCss('background-color','blue');
  $lo->addLayout($lo2,'N');

  $loCenter = new TLayout(20,20,0,0,true,true,true,true,2,null,10,5) ;
  $lo->addLayout($loCenter,'C');
 */
//$lo2 = new TLayout(50,50,50,50);
//$lo->getCenterArea()->add($lo2);
//$lo->setUrl('http://www.bb.com.br');
//$lo->setLayOut($lo2);
//$lo->getNorthArea()->add('luis');
//$lo->setResizable(true);
//$lo->setClosable(true);
//$lo->setShowBorders(true);
//$lo->setCss('border','2px solid red');
//$lo->setPadding('10');
//$lo->setCss('background-color','gray');
//$lo->getNorthArea()->setCss('background','red');
//print_r($lo->getCenterArea()->getCss());
//$lo2 = new TLayout(50,50,50,50);
//$lo2 = new TLayout(50,50,50,50);
//$lo->show();
?>