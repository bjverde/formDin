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
* Classe para criação de Abas ( pagecontrol )
*
* Sintaxe para definir a aba ativa utilizando o $_POST
*
* $_POST[ [id do pagecontrol+"_current"]=id do pagecontrol+'_'+nome da aba desejada;
* ex: para definir a aba "Cadastro" do pagecontrol "aba_exemplo" seria:
* $_POST['aba_exemplo_current']='aba_exemplo_cadastro';
*/
class TPageControl extends TTable
{
	private $pages;
	private $activePage;
	private $showTabs;
	private $hiddenField;
	private $focusField;
	private $onBeforeClick;
	private $onAfterClick;
	private $adjustFormHeight;
	private $columns;
	private $labelsAlign;
	/**
	* classe para criação de tab
	*
	* Widgh null para ficar com a largura do form
	* Se for informado somente o nome da função, sem os parentes, no paramentro onBeforeClick
	* a função receberá o rótulo da aba clicada,o nome do pagecontrol e o id da abaClicada. Se a função retorna false
	*
	* @param string $strName
	* @param string $strHeight
	* @param string $strWidth
	* @param string $boolShowTabs
	* @param string $strOnBeforeClick
	* @param string $strOnAfterClick
	* @return TPageControl
	*/
	public function __construct($strName,$strHeight=null,$strWidth=null,$boolShowTabs=null,$strOnBeforeClick=null,$strOnAfterClick=null)
	{
		parent::__construct(strtolower($strName));
		$this->setWidth($strWidth);
		$this->setHeight($strHeight);
		$this->setShowTabs((is_null($boolShowTabs) ? true : $boolShowTabs ) );
		$this->setOnBeforeClick($strOnBeforeClick);
		$this->setOnAfterClick($strOnAfterClick);
	}
	//----------------------------------------------------------------------------------------------
	/**
	* Adicionar aba ao pageControl
	* boolDefaut - indica se a aba será a seleciona na criação do formulãrio
	* @param mixed $strLabel      - Nome da Aba
	* @param boolean $boolDefault - indica se a aba será a seleciona na criação do formulário
	* @param boolean $boolVisible - Visivel
	* @param string $strName
	* @param boolean $boolDisableTab - Desabilita 
	* @return TForm
	*/
	public function addPage($strLabel,$boolDefault=null,$boolVisible=null,$strName=null,$boolDisableTab=null,$boolEnabled=null) {
		$strName	= ($strName==null) ? $strLabel : $strName;
		$boolEnabled= ($boolEnabled===false) ? false : true;
		$strName 	= strtolower(parent::removeIllegalChars($strName));
		$pageName 	= $strName;
		$this->setAttribute('fieldType','pagecontrol');
		$page 		= new TForm(null,null,null,$pageName);
		$page->setClass('tabsJsheet');
		$page->body->setAttribute('pagecontrol',$this->getId());
		$page->clearCss();
		$page->setCss('margin-top','10px');
		$page->setCss('margin-left','5px');
		$page->setColumns($this->columns);
		$page->setFlat(true);
		$page->setFieldType('tabsheet');
		$page->setTagType('div');
		$page->setValue(null,$strLabel);
		$page->setEnabled($boolEnabled);
		$page->setHeight($this->getHeight());
		if($boolVisible===false){
			$page->setCss('display','none');
		}
		if($boolDisableTab){
			$page->setProperty('disabled','true');
		}
		$this->pages[$pageName] = $page;
		// definir como pagina default
		if($boolDefault){
			$this->setActivePage($strName,false);
		}
		return $page;
	}
	/**
	* Habilitar/desabilitar a Aba mas não os campos
	*
	* @param mixed $boolNewValue
	*/
	public function disableTab($tabName,$boolNewValue=null)
	{
		$boolNewValue = is_null($boolNewValue) ? true:$boolNewValue;
		$tabName = strtolower($tabName);
		if($boolNewValue)
		{
			if($this->pages[$tabName])
			{
				$this->pages[$tabName]->setProperty('disabled','true');
			}
		}
		else
		{
			if($this->pages[$tabName])
			{
				$this->pages[$tabName]->setProperty('disabled','');
			}
		}
	}
	/**
	* Desabilitar a aba para não poder ser acessada
	*
	* @param string $tabName
	*/
	public function enableTab($tabName)
	{
		$tabName = strtolower($tabName);
		if($this->pages[$tabName])
		{
			$this->pages[$tabName]->setProperty('disabled','');
		}
	}
	/**
	* Tornar a aba invisível
	*
	* @param string $tabName
	*/
	public function hideTab($tabName)
	{
		$tabName = strtolower($tabName);
		if($this->pages[$tabName])
		{
			//$this->pages[$tabName]->setCss('display','none');
			$this->pages[$tabName]->setVisible(false);
		}
	}
	/**
	* Tornar a aba visível
	*
	* @param string $tabName
	*/
	public function showTab($tabName)
	{
		$tabName = strtolower($tabName);
		if($this->pages[$tabName])
		{
			//$this->pages[$tabName]->setCss('display','block');
			$this->pages[$tabName]->setVisible(true);

		}
	}
	//----------------------------------------------------------------------------------------------
	public function show($print=true)
	{
		// altura e largura das paginas
		$width 	= $this->getCss('width');
		$height = $this->getCss('height');
    	// css da tabela
    	$this->setProperty('cellpadding','0');
    	$this->setProperty('cellspacing','0');
    	$this->setCss('width','auto');
    	$this->setCss('height','auto');
    	$this->setCss('border','1px solid silver');
    	// se não especificar a largura, assumir 100 %
    	if(!$width)
    	{
	    	$this->setCss('width','100%');
    		$this->setCss('border','none');
    		if( !$this->getCss('background-color'))
    		{
    			$this->setCss('background-color','transparent');
			}
    	}
    	$tr = $this->addRow();
    	$tr->clearCss();
    	$td = $tr->addCell();
    	// todo pagecontrol tem que ter um campo oculto para guardar a aba atual quando postar o formulario
		$td->add( $this->hiddenField = new THidden($this->getId().'_current'));
		$this->hiddenField->setValue('');
    	if( isset( $_POST[$this->getId().'_current']) &&  $_POST[$this->getId().'_current'] )
    	{
			// verificar se aba postada como corrente existe no pagecontrol
			if($this->getPages())
			{
				forEach( $this->getPages() as $name=>$page)
				{
					if( $this->getId().'_'.$name == $_POST[$this->getId().'_current'] )
					{
						$this->hiddenField->setValue($_POST[$this->getId().'_current']);
						break;
					}
				}
			}
    	}
		if($this->hiddenField->getValue())
		{
			$this->setActivePage( $this->hiddenField->getValue() );
		}
		else
		{
			unset($_POST[$this->getId().'_current']);
		}
    	$td->clearCss();
    	$td->setCss('width',$width);
    	$td->setCss('overflow','hidden');
    	$td->add($div = new TElement('div'));
    	$div->ClearCss();
    	$div->setId($this->getId().'_container');
    	$div->setClass('tabsJ');
    	$div->add($ul = new TElement('ul'));
    	$ul->clearCss();
    	$ul->setId($div->getId().'_page');

     	$tr2 = $this->addRow();
    	$tr2->clearCss();
    	$td2 = $tr2->addCell();
    	$td2->clearCss();
    	$td2->setId($this->getId().'_body');
    	$td2->setCss('width',$width);
    	$td2->setCss('height',$height);
    	$td2->setCss('overflow','auto');
    	$td2->setCss('border','none');
    	$td2->setCss('vertical-align','top');
    	if( ! $this->getShowTabs() )
    	{
			$div->setCss('display','none');
    	}
		foreach( $this->pages as $name=>$page)
		{
			// configurar as páginas
			$page->setCss('width',$width);
			$page->setCss('height',$height);

			// definir o alinhamento dos rótulos
			if( ! $page->getLabelsAlign() && $this->getLabelsAlign() )
			{
				$page->setLabelsAlign($this->getLabelsAlign());
			}

			// definir a cor de fundo da aba com a cor de fundo do pagecontrols se a aba não tiver cor própria
			if( !$page->getCss('background-color'))
			{
				$page->setCss('background-color','transparent');
			}
			$ul->add($li = new TElement('li'));
			$li->ClearCss();
			$li->setId($ul->getId().'_'.$page->getId());
			$li->setProperty('tabref',$this->getId().'_'.$page->getId());
			if($page->getCss('display')=='none')
			{
				$li->setCss('display','none');
			}
			// definir a aba ativa
			//print $this->getid().'_'.$page->getId().'=='.$this->getActivePage().',';
			if( $this->getId().'_'.$page->getId() == $this->getActivePage())
			{
				$li->setProperty('class','activePageControl');
				// mostrar o conteúdo da aba
				//$page->setCss('display','block');
				$page->setVisible(true);
			}

			$li->add($a = new TElement('a'));
			$a->clearCss();
			$a->setId($li->getId().'_link');
			$a->setProperty('title',$page->getValue());
			$a->setProperty('pagecontrol',$this->getId());
			$a->setProperty('href','javascript:void(0);');
			if( $onAfterClick = $this->getOnAfterClick() )
			{
				if( strpos( $onAfterClick,'(') === false || strpos( $onAfterClick,'()') > 0 )
				{
					$onAfterClick = preg_replace('/\(|\)/','',$onAfterClick);
					$onAfterClick = $onAfterClick.'(\"'.$page->getValue().'\",\"'.$this->getId().'\",\"'.$page->getId().'\")';
				}
			}
			if(!$onBeforeClick = $this->getEvent('onClick'))
			{
				$onBeforeClick = $this->getOnBeforeClick();
			}
			if( $onBeforeClick )
			{
				if( strpos( $onBeforeClick,'(') === false )
				{
					$onBeforeClick = 'if(!'.$onBeforeClick.'("'.$page->getValue().'","'.$this->getId().'","'.$page->getId().'")) return false';
				}
			}
			$onBeforeClick = 'if( this.getAttribute("tabDisabled")=="1"){return false};'.$onBeforeClick;
			$a->add($span = new TElement('span'));
			$span->clearCss();
			$span->setProperty('pagecontrol',$this->getId());
			$span->setAttribute('shortcut',$page->getAttribute('shortcut'));
			$span->setAttribute('fieldtype','tabsheet');
			$span->setProperty('tabId',$page->getId());
			$span->setCss('white-space','nowrap');
			$span->setId($li->getId().'_span');
			$span->add($page->getValue());
			// se a pagina estiver desabilitada, não adicionar o evento onBeforeclick e alterar a cor da fonte para cinza
			$a->addEvent('onclick',$onBeforeClick.';fwSelecionarAba(this,"","'.$onAfterClick.'")');
			if( !$page->getProperty('disabled') )
			{
				$a->setProperty('tabDisabled','0');
			}
			else
			{
				$span->setCss('color','#A9A9A9');
				$a->setProperty('tabDisabled','1');
			}
			$page->setId($this->getId().'_'.$page->getId());
			//$td2->setProperty('nivel','TD2');
			$td2->add($page);
		}
		$this->setId($this->getId());
		$this->hiddenField->setValue($this->getActivePage());
		return parent::show($print);
	}
	/**
	* Define a aba inicial
	* Por padrão a aba postada sempre virá selecionada.
	* Para selecionar a aba ativa independente da aba postada
	* passe true para boolIgnorePost
	*
	* @param string $strPageName
	* @param bool $boolIgnorePost
	* @example $pg->setActivePate('Relatório',true);
	*
	*/
	public function setActivePage($strPageName=null,$boolIgnorePost=null)
	{
		$this->activePage=null;
		$strPageName = strtolower(parent::removeIllegalChars($strPageName));
		// se o nome da aba for passado sem o nome do container, adicionar o nome do container ao nome da aba
		if(strpos($strPageName,$this->getId().'_') !==0 )
		{
				$strPageName = $this->getId().'_'.$strPageName;
		}
		$this->activePage = $strPageName;
		// sobrepor a aba que foi postada
		if( (bool)$boolIgnorePost==true )
		{
			$_POST[$this->getId().'_current']=$strPageName;
		}
		return $this;
	}
	/**
	* Retorna a aba selecionada
	*
	*/
	public function getActivePage()
	{
		return $this->activePage;
	}
	/**
	 * Habilitar/Desabilitar a exibição das orelhas
	*/
	public function setShowTabs($boolShow=null)
	{
		if(is_null($boolShow))
		{
			return $this->showTabs;
		}
		$boolShow = $boolShow === false ? false : true;
		$this->showTabs=(bool)$boolShow;
	}
	public function getShowTabs()
	{
		return $this->showTabs === false ? false : true;
	}

	/**
	* retorna as paginas adicionadas no PageControl
	*
	*/
	public function getPages()
	{
		return $this->pages;
	}
	public function getPage($strPageName = null)
	{
		if( is_null( $strPageName ) )
		{
			return null;
		}
		$strPageName = strtolower($strPageName);
		if( isset( $this->pages[$strPageName] ) )
		{
			return $this->pages[$strPageName];
		}
		return null;
	}
	//-----------------------
	public function setOnClick($strJsFunction=null)
	{
		$this->onClick = $strJsFunction;
		return $this;
	}
	//-----------------------
	public function setOnBeforeClick($strJsFunction=null)
	{
		$this->onBeforeClick = $strJsFunction;
		return $this;
	}
	//-----------------------
	public function getOnBeforeClick()
	{
		return $this->removeIllegalChars($this->onBeforeClick,'()');
	}
	//-----------------------
	public function setOnAfterClick($strJsFunction=null)
	{
		$this->onAfterClick = $strJsFunction;
		return $this;
	}
	//-----------------------
	public function getOnAfterClick()
	{
		return $this->removeIllegalChars($this->onAfterClick,'()');
	}
	//---------------------------------------------------------------------------
	public function validate($strPage=null,$strFields=null,$strIgnoreFields=null)
	{
		if(is_array($this->pages))
		{
			$strPage = $this->removeIllegalChars($strPage);
			$result=true;
			// validar os formularios das abas
			forEach( $this->pages as $name=>$page)
			{
				// o nome da aba tem o nome do pagecontrol + o nome da aba em caixa baixa
				if( $strPage=='' || $page->getid()==$this->getId().strtolower($strPage) || $page->getid()==$this->getId().'_'.strtolower($strPage) || $page->getid()==strtolower($strPage) )
				{
					$page->validate(null, $strFields, $strIgnoreFields );
					if($result)
					{
						$result = count($page->getErrors()==0);
					}
				}
			}
		}
		return $result;
	}
	//------------------------------------------------------------------------
    function getField($strFieldName)
    {
    	$field=null;
    	if($strFieldName)
    	{
			if(is_array($this->pages))
			{
				// adicionar as páginas ( elementos li )
				forEach( $this->pages as $name=>$page)
				{
					if($field = $page->getField($strFieldName) )
					{
						break;
					}
				}
			}
    	}
		return $field;
    }
    function setFocusField($strFieldName=null)
    {
    	$this->focusField=$strFieldName;
    	return $this;
    }
    function getFocusField($strFieldName=null)
    {
    	return $this->focusField;
    }
	/**
	 * Desabilitar/Habilitar campos do formulário
	 * Pode ser passado um campo ou varios separados por virgula,
	 * tambem pode ser um array de campos
	 *
	 * Ex:	$obj->disableFields('nom_pessoa');
	 * 		$obj->disableFields('nom_pessoa,des_endereco');
	 * 		$obj->disableFields(array('nom_pessoa,des_endereco'));
	 *
	 * @param mixed $mixFields
	 * @param boolean $boolNewValue
	 */
    public function disableFields($mixFields=null,$mixIgnoreFields=null,$boolNewValue=null)
	{
		if(is_array($this->getPages()))
		{
			// adicionar as páginas ( elementos li )
			forEach( $this->pages as $name=>$page)
			{
				$page->disableFields($mixFields,$mixIgnoreFields,$boolNewValue);
			}
		}
	}
	//------------------------------------------------------------------------------------
    public function clearFields($mixFields=null,$mixIgnoreFields=null,$boolNewValue=null)
	{
		if(is_array($this->getPages()))
		{
			// adicionar as páginas ( elementos li )
			forEach( $this->pages as $name=>$page)
			{
				$page->clearFields($mixFields,$mixIgnoreFields,$boolNewValue);
			}
		}
	}
	//------------------------------------------------------------------------------------
    public function getJsCss()
	{
		$arrJsCss=array();
		if(is_array($this->getPages()))
		{
			forEach( $this->pages as $name=>$page)
			{
				$arrTemp = $page->getJsCss();
				$arrJsCss[0][]=$arrTemp[0];
				$arrJsCss[1][]=$arrTemp[1];
			}
		}
		return $arrJsCss;
	}
	//---------------------------------------------------------------------------------------
    public function deleteField($mixFields=null,$mixIgnoreFields=null)
	{
		if(is_array($this->getPages()))
		{
			// adicionar as páginas ( elementos li )
			forEach( $this->pages as $name=>$page)
			{
				$page->deleteField($mixFields,$mixIgnoreFields);
			}
		}
	}
	//------------------------------------------------------------------------------------------
	public function getFieldType()
	{
		return 'pagecontrol';
	}

	public function setColumns($mixColumns=null)
	{
		$this->columns=$mixColumns;
		return $this;
	}
	public function getColumns()
	{
		return $this->columns;
	}
	public function disableTabs()
	{
		if(is_array($this->getPages()))
		{
			// adicionar as páginas ( elementos li )
			forEach( $this->pages as $name=>$page)
			{
				$this->disableTab($name);
			}
		}
	}
	public function setVo($vo)
	{
		if(is_array($this->getPages()))
		{
			forEach( $this->pages as $name=>$page)
			{
				$page->setVo($vo);
			}
		}
		return $this;
	}
	public function setWidth($strNewValue=null)
	{
		$this->setCss('width',$strNewValue);
		if(is_array( $this->getPages()) )
		{
			// redimensionar as paginas
			forEach( $this->pages as $name=>$page)
			{
				$page->setWidth($strNewValue);
			}
		}
		return $this;
	}
	public function getWidth($strNewValue=null)
	{
		return $this->getCss('width');
	}
	//-----------------------------------------------------
	public function setHeight($strNewValue=null)
	{
		$this->setCss('height',$strNewValue);
		if(is_array( $this->getPages()) )
		{
			// redimensionar as paginas
			forEach( $this->pages as $name=>$page)
			{
				$page->setHeight($strNewValue);
			}
		}
		return $this;
	}
	public function getHeight($strNewValue=null)
	{
		return $this->getCss('height');
	}
	//---------------------------------------------------------------------------------------
    public function getLabel($strFieldName=null)
	{
		$label=null;
		if(is_array($this->getPages()))
		{
			// adicionar as páginas ( elementos li )
			forEach( $this->pages as $name=>$page)
			{
				if( $label = $page->getLabel($strFieldName) )
				{
					break;
				}
			}
		}
		return $label;
	}
		/**
	* Define o alinhamento dos rótulos dos campos.
	* Os valores válidos são:center,left ou right.
	* O padrão é left
	*
	* @param string $strNewValue
	*/
	public function setLabelsAlign($strNewValue=null)
	{
		$this->labelsAlign = $strNewValue;
	}
	//-----------------------------------------------------------------------------
	public function getLabelsAlign()
	{
		return $this->labelsAlign;
	}
	//-----------------------------------------------------------------------------

}
?>