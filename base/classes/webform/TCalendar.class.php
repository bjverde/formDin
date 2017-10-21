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
 * Este programa é distribuí1do na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licen?a Pública Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

class TCalendar extends TControl
{
	private $height;
	private $contentHeight;
	private $aspectRatio;
	private $showHeader;
	private $showTitle;
	private $showNavigatorButtons;
	private $showTodayButton;
	private $showDayButton;
	private $showMonthButton;
	private $showWeekButton;
	private $showWeekends;
	private $basicView;
	private $buttons;
	private $views;
	private $url;

	private $jsOnResize;
	private $jsOnDrag;
	private $jsOnDrop;
	private $jsOnEventClick;
	private $jsOnSelectDay;
	private $jsMouseOver;
	private $jsEventRender;
	private $jsViewDisplay;
	private $defaultView;

	public function __construct($strName, $strUrl=null,  $strHeight=null, $strWidth=null, $defaultView=null, $jsOnResize=null, $jsOnDrag=null, $jsOnDrop=null, $jsOnEventClick=null, $jsOnSelectDay=null, $jsMouseOver=null, $jsEventRender=null, $jsViewDisplay=null)
	{
		//parent::__construct('fieldset',$strName);
		parent::__construct('div', $strName);
		parent::setFieldType('fullcalendar');
		$this->setClass('fwHtml');
		$this->setCss('margin','0');
		$this->setUrl($strUrl);
		$this->setWidth($strWidth);
		$this->setHeight($strHeight);
		$this->setJsOnResize($jsOnResize);
		$this->setJsOnDrag($jsOnDrag);
		$this->setJsOnDrop($jsOnDrop);
		$this->setJsOnEventClick($jsOnEventClick);
		$this->setJsMouseOver($jsMouseOver);
		$this->setDefaultView($defaultView);
		$this->setJsOnSelectDay($jsOnSelectDay);
		$this->setJsEventRender($jsEventRender);
		$this->setJsViewDisplay($jsViewDisplay);
//		$this->setIncludeFile($strIncludeFile);
//		$this->setLoadingMessage($strLoadingMessage);
	}

	//-------------------------------------------------------------------------------------
	public function show($print=true)
	{
		$script=new TElement('<script>');
		$script->add('
		jQuery(document).ready(function() {

		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		var selecionavel;

		jQuery("#'. $this->getName(). '").fullCalendar({
			'.( ($aux=$this->getAspectRatio()) ? "aspectRatio: {$aux}," : '' ) .'
			'.( ($aux=$this->getHeight()) ? "height: {$aux}," : '' ) .'
			'.( ($aux=$this->getContentHeight()) ? "contentHeight: {$aux}," : '' ) .'
			theme: true,
			monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
						"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
			monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun",
 								"Jul", "Ago", "Set", "Out", "Nov", "Dec"],
 			dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sabado"],
 			dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
 			allDayText : "Dia todo",
 			firstHour : 6,
 			buttonText: {
 							today:    "Hoje",
    						month:    "Mês",
    						week:     "Semana",
    						day:      "Dia"
						},
			header: ' .
				($this->getShowHeader() == false ?
					'false' :
					'{
						left: "' .
							($this->getShowNavigatorButtons() ? 'prev,next' : '') .
							($this->getShowTodayButton() ? ',today' : '') .
							'",
						center: "' .
							($this->getShowTitle() ? 'title' : '') .
							'",
						right: "' .
							($this->getShowMonthButton() ? 'month' : '') .
							($this->getShowWeekButton() ? ','.$this->getView().'Week' : '') .
							($this->getShowDayButton() ? ','.$this->getView().'Day' : '') .
							'"
					}') . ',
			loading: function (carregando) {
						selecionavel = !carregando;},
			lazyFetching: false,
			defaultView: "' . ($this->getDefaultView() ? $this->getDefaultView() : "month") . '",
			weekends: ' . ($this->getShowWeekends() ? 'true' : 'false') . ' ,

			eventSources: [ {
	            url: "'.$this->getUrl().'",
	            type: "POST",
	            data: { ajax:1 },
	            error: function() {  alert("Erro ao carregar os eventos da Agenda!");}
	        	}],
			eventResize: '.($this->getJsOnResize() ? $this->getJsOnResize() : 'null').',
			eventDragStart: '.($this->getJsOnDrag() ? $this->getJsOnDrag() : 'null').',
			eventDrop: '.($this->getJsOnDrop() ? $this->getJsOnDrop() : 'null').',
			eventClick: '.($this->getJsOnEventClick() ? $this->getJsOnEventClick() : 'null').',
			eventMouseover: '.($this->getJsMouseOver() ? $this->getJsMouseOver() : 'null').',
			editable: '.($this->getReadOnly() ? 'false' : 'true').',
			eventRender: '.($this->getJsEventRender() ? $this->getJsEventRender() : 'null').',
			selectable: '.($this->getJsOnSelectDay() ? 'true' : 'false').',
			select: '.($this->getJsOnSelectDay() ? $this->getJsOnSelectDay() : 'null').',

			viewDisplay: '.($this->getJsViewDisplay() ? $this->getJsViewDisplay() : 'null').'
			});
		});
		');
		//$this->add();

	 	return parent::show($print).$script->show($print);
	}
/*
select: function (dataInicial, dataFinal) {
if (selecionavel) {
// Executa código
}}*/
	//-------------------------------------------------------------------------------------

	/**
	 * @param integer $newHeight Tamanho da área total ocupada pelo calendário
	 * @return TCalendar
	 */
	public function setHeight($newHeight=null)
	{
		parent::setHeight($newHeight);
		$this->height = (int) ($newHeight - 10);
        return $this;
	}
	public function getHeight($strMinHeight = null)
	{
		return ( is_integer($this->height) ) ? $this->height : null;
	}

	/**
	 * @param integer $newContentHeight Tamanho do calendário
	 * @return TCalendar
	 */
	public function setContentHeight($newContentHeight=null)
	{
		$this->contentHeight = $newContentHeight;
        return $this;
	}
	public function getContentHeight()
	{
		return ( is_integer($this->contentHeight) ) ? $this->contentHeight : null;
	}

	/**
	 * @param float $newAspectRatio Proporção entra largura e altura do calendário
	 * @return TCalendar
	 */
	public function setAspectRatio($newAspectRatio=null)
	{
		$this->aspectRatio = $newAspectRatio;
        return $this;
	}
	public function getAspectRatio()
	{
		return ( is_integer($this->aspectRatio) ) ? $this->aspectRatio : null;
	}

	/**
	 * @param boolean $boolShowHeader Informa se deve exibir o cabeçalho
	 * @return TCalendar
	 */
	public function setShowHeader($boolShowHeader=null)
	{
		$this->showHeader = $boolShowHeader;
        return $this;
	}
	public function getShowHeader()
	{
		return ( $this->showHeader === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowTitle Informa se deve exibir o título "Ex: Janeiro 2000".
	 * @return TCalendar
	 */
	public function setShowTitle($boolShowTitle=null)
	{
		$this->showTitle = $boolShowTitle;
        return $this;
	}
	public function getShowTitle()
	{
		return ( $this->showTitle === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowNavigatorButtons Informa se deve exibir os botões de navegação (anterior e próximo).
	 * @return TCalendar
	 */
	public function setShowNavigatorButtons($boolShowNavigatorButtons=null)
	{
		$this->showNavigatorButtons = $boolShowNavigatorButtons;
        return $this;
	}
	public function getShowNavigatorButtons()
	{
		return ( $this->showNavigatorButtons === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowTodayButton Informa se deve exibir o botão "Hoje".
	 * @return TCalendar
	 */
	public function setShowTodayButton($boolShowTodayButton=null)
	{
		$this->showTodayButton = $boolShowTodayButton;
        return $this;
	}
	public function getShowTodayButton()
	{
		return ( $this->showTodayButton === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowMonthButton Informa se deve exibir o botão "Mês".
	 * @return TCalendar
	 */
	public function setShowMonthButton($boolShowMonthButton=null)
	{
		$this->showMonthButton = $boolShowMonthButton;
        return $this;
	}
	public function getShowMonthButton()
	{
		return ( $this->showMonthButton === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowDayButton Informa se deve exibir o botão "Dia".
	 * @return TCalendar
	 */
	public function setShowDayButton($boolShowDayButton=null)
	{
		$this->showDayButton = $boolShowDayButton;
        return $this;
	}
	public function getShowDayButton()
	{
		return ( $this->showDayButton === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowWeekButton Informa se deve exibir o botão "Semana".
	 * @return TCalendar
	 */
	public function setShowWeekButton($boolShowWeekButton=null)
	{
		$this->showWeekButton = $boolShowWeekButton;
        return $this;
	}
	public function getShowWeekButton()
	{
		return ( $this->showWeekButton === false) ? false : true;
	}

	/**
	 * @param boolean $boolBasicView Define tipo de visão dos calendários "Semana" e "Dia" para básica ou completa.
	 * @return TCalendar
	 */
	public function setBasicView($boolBasicView=null)
	{
		$this->basicView = $boolBasicView;
        return $this;
	}
	public function getBasicView()
	{
		return ( $this->basicView === true) ? true : false;
	}
	protected function getView() {
		return ($this->getbasicView() ? 'basic' : 'agenda');
	}

	/**
	 * @param boolean $boolShowWeekends Informa se deve exibir fins de semana no calendário (sábado e domingo).
	 * @return TCalendar
	 */
	public function setShowWeekends($boolShowWeekends=null)
	{
		$this->showWeekends = $boolShowWeekends;
        return $this;
	}
	public function getShowWeekends()
	{
		return ( $this->showWeekends === false) ? false : true;
	}
	/**
	 *  str $strNewvalue Define a url onde os eventos serão carregados
	 *  Ex. array(array("title"=>'Titulo do evento', "start"=>'2011-12-03', "end"=>'2011-12-04')
	 *  Evento deve ser retornado pelo: echo json_encode($retorno);
	 * @param $strNewvalue
	 */
	public function setUrl( $strNewvalue = null)
	{
		$this->url = $strNewvalue;
	}
	public function getUrl()
	{
		return $this->url;
	}
	/**
	 *
	 * @param unknown_type $jsOnResize
	 */
	public function setJsOnResize($jsOnResize=null)
	{
		$this->jsOnResize = $jsOnResize;
	}
	public function getJsOnResize()
	{
		return $this->jsOnResize;
	}
	/**
	 *
	 * @param unknown_type $jsOnDrag
	 */
	public function setJsOnDrag($jsOnDrag=null)
	{
		$this->jsOnDrag = $jsOnDrag;
	}
	public function getJsOnDrag()
	{
		return $this->jsOnDrag;
	}
	/**
	 *
	 * @param unknown_type $jsOnDrop
	 */
	public function setJsOnDrop($jsOnDrop=null)
	{
		$this->jsOnDrop = $jsOnDrop;
	}
	public function getJsOnDrop()
	{
		return $this->jsOnDrop;
	}

	/**
	 * @param str $jsOnEventClick Informa qual metodo javascript tratara o evento de clicar sobre um evento
	 *
	 * Deve possuir a assinatura(calEvent, jsEvent, view)
	 * calEvent -> possui os dados do evento. (Padrão: calEvent.title, calEvent.start, calEvent.end) ou os que definiu ex. calEvent.descricao
	 * jsEvent -> mostrara as coordenadas
	 * view -> a visão ativa do calendario
	 *
	 * @return TCalendar
	 */
		public function setJsOnEventClick($jsOnEventClick=null)
		{
			$this->jsOnEventClick = $jsOnEventClick;
		}
		public function getJsOnEventClick()
		{
			return $this->jsOnEventClick;
		}

	/**
	 * @param str $jsMouseOver Informa qual metodo javascript tratara o evento mouseover
	 *
	 * Deve possuir a assinatura ( event, jsEvent, view )
	 * @return TCalendar
	 */
		public function setJsMouseOver($jsMouseOver=null)
		{
			$this->jsMouseOver = $jsMouseOver;
		}
		public function getJsMouseOver()
		{
			return $this->jsMouseOver;
		}

	/**
	 * @param str $defaultView Informa qual deve ser a visualização padrão do calendário, padrão month. ex:(basicWeek, basicDay, agendaWeek, agendaDay).
	 * @return TCalendar
	 */
		public function setDefaultView($defaultView=null)
		{
			$this->defaultView = $defaultView;
		}
		public function getDefaultView()
		{
			return $this->defaultView;
		}


		public function setJsEventRender($jsEventRender=null)
		{
			$this->jsEventRender = $jsEventRender;
		}
		public function getJsEventRender()
		{
			return $this->jsEventRender;
		}

		public function setJsOnSelectDay($jsOnSelectDay=null)
		{
			$this->jsOnSelectDay = $jsOnSelectDay;
		}
		public function getJsOnSelectDay()
		{
			return $this->jsOnSelectDay;
		}

		public function setJsViewDisplay($jsViewDisplay=null)
		{
			$this->jsViewDisplay = $jsViewDisplay;
		}
		public function getJsViewDisplay()
		{
			return $this->jsViewDisplay;
		}
}
?>