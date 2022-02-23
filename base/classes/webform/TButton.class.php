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
*  Classe para criar botões
*/
class TButton extends TControl
{
	const CLASS_CSS = 'fwButton'; //FormDin 4
	//const CLASS_CSS = 'btn btn-primary btn-sm'; //FormDin 5
	const CLASS_CSS_IMG = 'fwButtonImg';

	private $action;
	private $onClick;
	private $confirMessage;
	private $imageEnabled;
	private $imageDisabled;
	private $submitAction;
	
	/***
	 *  Cria um botão 
	 * @param string $strName           - 1: Id do botão
	 * @param string $strValue          - 2: label do botão que irá aparecer para o usuário
	 * @param string $strAction         - 3: nome da ação que será executada
	 * @param string $strOnClick        - 4: 
	 * @param string $strConfirmMessage - 5: Mensagem de confirmação, para utilizar o confirme sem utilizar javaScript explicito.
	 * @param string $strImageEnabled   - 6: Imagem no botão. Evite usar no lugar procure usar a propriedade setClass. Busca pasta imagens do base ou no caminho informado
	 * @param string $strImageDisabled  - 7: Imagem no desativado. Evite usar no lugar procure usar a propriedade setClass. Busca pasta imagens do base ou no caminho informado
	 * @param string $strHint           - 8: Texto hint para explicar
	 * @param boolean $boolSubmitAction - 9: 
	 */
	public function __construct($strName
	                           ,$strValue=null
	                           ,$strAction=null
	                           ,$strOnClick=null
	                           ,$strConfirmMessage=null
	                           ,$strImageEnabled=null
	                           ,$strImageDisabled=null
	                           ,$strHint=null
	                           ,$boolSubmitAction=null)
	{
		$strName = is_null( $strName ) ? $this->removeIllegalChars( $strValue ) : $strName;
		parent::__construct('button',$strName,$strValue);
		$this->setHint($strHint);
		$this->setFieldType('button');
		$this->setProperty('type','button');
		$this->setAction($strAction);
		$this->setOnClick($strOnClick);
		$this->setConfirmMessage($strConfirmMessage);
		$this->setSubmitAction($boolSubmitAction);
		$this->setImage($strImageEnabled);
		$this->setImageDisabled($strImageDisabled);
		$this->setClass(self::CLASS_CSS);
	}

	public function show($print=true)
	{
	    // ajustar as propriedades se o botão for uma imagem
	    $isImage=false;
		if((string)$this->getImage()!="")
		{
			$this->setTagType('img');
			$this->setFieldType('img');
			$this->setProperty('src',$this->getImage());
			if( $this->getClass() == self::CLASS_CSS )
			{
				$this->setProperty('class',null);
				//$this->setClass(self::CLASS_CSS_IMG);
				$this->setCss('background',null);
				$this->setCss('cursor','pointer');
				$this->setCss('background-color',null);
				$this->setCss('font-family',null);
				$this->setCss('font-size',null);
				$this->setCss('border','none');
				$this->setCss('color',null);
				$this->setCss('vertical-align','top');				
                if( is_null( $this->getProperty('alt'))){
                    $this->setProperty('alt', $this->getvalue() );
                }
                if( !$this->getProperty('title')){
                	$this->setProperty('title', $this->getValue() );
                }
                $this->setAttribute('type',null);
				$this->setValue('');
			}
			$isImage=true;
		}

        // regra de acessibilidade
        if( is_null( $this->getHint() ) ){
            $this->setHint($this->getValue());
        }

//		$jsConfirm=null;
		$jsConfirmBegin=null;
		$jsConfirmEnd=null;
		if((string)$this->getConfirmMessage() != '')
		{
			//Alterado para padronizar as mensagens utilizando o fwConfirm
			//Por Diego Barreto e Felipe Colares
// 			$jsConfirm = 'if( !confirm("'.$this->getConfirmMessage().'")){return false;} ';
			$msg = htmlentities($this->getConfirmMessage(),ENT_COMPAT,ENCODINGS);
		    $jsConfirmBegin = 'fwConfirm("'.$msg.'", function() { ';
			$jsConfirmEnd	= '}, function() {})';
		}

		// o evento action tem precedencia sobre o evento onClick
		if((string)$this->getAction()!='')
		{
			if( $this->getSubmitAction() )
			{
				$formAction = 'fwFazerAcao("'.$this->getAction().'")';
// 				$this->addEvent('onclick',$jsConfirm.'if( typeof(btn'.ucwords($this->getId()).'OnClick)=="function"){btn'.ucwords($this->getId()).'OnClick(this);return true;};this.disabled=true;this.value="Aguarde";this.style.color="red";'.$formAction);
				$this->addEvent('onclick',$jsConfirmBegin.'if( typeof(btn'.ucwords($this->getId()).'OnClick)=="function"){btn'.ucwords($this->getId()).'OnClick(this);return true;};jQuery(this).attr("disabled","true").val("Aguarde").css("color","red");'.$formAction.$jsConfirmEnd);
			}
			else
			{
// 				$this->addEvent('onclick',$jsConfirm.'if( typeof(btn'.ucwords($this->getId()).'OnClick)=="function"){btn'.ucwords($this->getId()).'OnClick(this);return true;};');
				$this->addEvent('onclick',$jsConfirmBegin.'if( typeof(btn'.ucwords($this->getId()).'OnClick)=="function"){btn'.ucwords($this->getId()).'OnClick(this);return true;};.'.$jsConfirmEnd);
			}
			//$this->addEvent('onclick',$jsConfirm.'if( typeof(btn'.ucwords($this->getId()).'OnClick)=="function"){btn'.ucwords($this->getId()).'OnClick(this);return true;};this.disabled=true;this.value="Aguarde";this.style.color="red";fwFazerAcao("'.$this->getAction().'")');
			//$this->addEvent('onclick','if(!'.$this->getId().'Click()) { return false } '.$jsConfirm.'fwFazerAcao("'.$this->getAction().'")');
		}
		else if($this->getOnClick())
		{
			$this->setEvent('onclick',$jsConfirmBegin.$this->getOnClick().$jsConfirmEnd,false);
		}
		if( ! $this->getEnabled() ){
			$this->setCss('cursor','default');
			if( ! $this->getProperty('title') ){
				$property = htmlentities('Ação desabilitada',ENT_COMPAT,ENCODINGS);
			    $this->setProperty('title', $property);
			}
			$this->setAttribute('disabled','true');
			if( $this->getOnClick() && $this->getImage() != '' ){
				$this->setOnClick('if( jQuery(this).attr("disabled")){return false;};'.$this->getOnClick() ,false);
				$this->setEvent('onClick',$this->getOnClick());
			}
		}
		$this->add( $this->getValue() );
		$this->setValue(null);
		return parent::show($print);
	}
	//-----------------------------------------------------------------------------------------------
	public function setAction($strNewValue=null)
	{
		$this->action = $strNewValue;
	}
	public function getAction()
	{
		if((string) $this->action =='' && (string)$this->getOnClick()=='')
		{
			$this->setAction($this->getValue());
		}
		return $this->action;
	}
	public function setOnClick($strFunctionJs=null)
	{
		$this->onClick = $strFunctionJs;
	}
	public function getOnClick()
	{
		if( !is_null($this->onClick))
		{
			return $this->onClick;
		}
		return $this->getEvent('onclick');
	}
	public function setConfirmMessage($strNewMessage=null)
	{
		$this->confirMessage = $strNewMessage;
	}
	public function getConfirmMessage()
	{
		return $this->confirMessage;
	}
	public function setImage($strNewImage=null)
	{
		$this->imageEnabled=$strNewImage;
	}
	public function getImage()
	{
		$path="";
		if($this->getEnabled()){
			$image = $this->imageEnabled;
		}else{
			$image = $this->getImageDisabled();
		}
		if($image){
			// se não foi informado o endereço manualmente, encontrar na pasta base
			if( strpos($image,'/')===false){
				if( ! file_exists($image) ){
					$path = $this->getBase().'imagens/';
				}
			}
		}
		if( ! file_exists($path.$image) ){
			$image = empty($image)?'':$image;
			$image = str_replace('_disabled.','.',$image);
		}
		return $path.$image;
	}
	public function setImageDisabled($strNewImage=null)
	{
		$this->imageDisabled=$strNewImage;
	}
	public function getImageDisabled()
	{
		if( !$this->imageDisabled )
		{
			if( file_exists($this->getBase().'imagens/'.str_replace('.','_disabled.',$this->imageEnabled)))
			{
				return str_replace('.','_disabled.',$this->imageEnabled );
			}
			else
			{
				return 'fwblank16x16.png';
			}
		}
		return $this->imageDisabled;
	}
	public function setSubmitAction($boolNewValue=null)
	{
		$this->submitAction = $boolNewValue;
	}
	public function getSubmitAction()
	{
		return is_null($this->submitAction) ? true : $this->submitAction;
	}
	public function clearEvents()
	{
		$this->setOnClick(null);
		parent::clearEvents();
	}
}

/***
 * Exemplo de como usar apenas o botão
 */
/***
$btn = new TButton('btnGravar','Gravar','actGravar',null,'Confirma Gravação ?');
$btn->setImage('btnCalendario.gif');
$btn->show();
echo '<br>';
echo '<br>';
$btn = new TButton('btnGravar','Gravar',null,'fwTeste()','Tem Certeza ?','../../imagens/search.gif','../../imagens/lixeira.gif');
$btn->setEnabled(false);
$btn->setVisible(false);
$btn->show();
 */
?>