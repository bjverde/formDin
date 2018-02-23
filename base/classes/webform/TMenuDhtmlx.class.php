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
* Classe para gerar o xml para criação de menus verticais utilizando a bibliotaca DHTMLX
* Link: http://www.dhtmlx.com/docs/products/docsExplorer/index.shtml?node=dhtmlxmenu
* Ex:
* 	$menu = new TMenuDhtmlx();
*	$menu->add(1,0,'Cadastro');
*	$menu->add(2,0,'Consulta');
*	$menu->add(21,2,'Consulta 2.1');
*	$menu->add(22,2,'Consulta 2.2');
*	$menu->add(221,22,'Consulta 2.2.1');
* 	echo $menu->getStructure();
* 	ou echo $menu->getXml()
*
*/
class TMenuDhtmlx
{
    private $arrMenu;
    private $arrOrphan;
    private $strId;
    private $strIdParent;
    private $strText;
	private $strUrl;
	private $boolDisabled;
	private $strImg;
	private $strImgDisabled;
	private $strHotKey;
	private $strTooltip;
	private $boolIgnoreOrphans;
	private $boolSeparator;
	private $jsonParams;

    public function __construct($data=null,$boolIgnoreOrphans=null)
    {
    	$this->boolIgnoreOrphans = $boolIgnoreOrphans === null ? true : $boolIgnoreOrphans;
        $this->arrMenu=null;
    }
    /**
    * Método para adicionar itens de menu
    *
    * @param string $strId
    * @param string $strIdParent
    * @param string $strText
    * @param string $strUrl
    * @param string $strToolTip
    * @param string $strImg
    * @param string $strImgDisabled
    * @param boolean $boolDisabled
    * @param string $strHotKey
    * @param boolean $boolSeparator
    * @return TMenuDhtmlx
    */
    public function add($strId, $strIdParent,$strText,$strUrl=null,$strToolTip=null,$strImg=null,$strImgDisabled=null,$boolDisabled=null,$strHotKey=null,$boolSeparator=null,$jsonParams=null)
    {
        $menu = new TMenuDhtmlx();
        $menu->setText($strText);
        $menu->setId($strId);
        $menu->setIdParent($strIdParent);
        $menu->setUrl($strUrl);
        $menu->setToolTip($strToolTip);
        $menu->setImg($strImg);
        $menu->setImgDisabled($strImgDisabled);
        $menu->setDisabled($boolDisabled);
        $menu->setHotKey($strHotKey);
        $menu->setSeparator($boolSeparator);
        $menu->setJsonParams($jsonParams);

        if( $menu->getIdParent() )
        {
	        // verificar se o pai já está adicionado
	        $objMenu = $this->getMenuById($strIdParent);
	        if( ! is_null( $objMenu ) )
	        {
	            $objMenu->addMenu($menu);
	        }
	        else
	        {
        		$this->addOrphan($menu);
	        }
		}
		else
		{
			$this->addMenu( $menu );
		}
		/*
        // verificar se o pai já está adicionado
        $objMenu = $this->getMenuById($strIdParent);
        if( ! is_null( $objMenu ) )
        {
            $objMenu->addMenu($menu);
        }
        else
        {
        	$this->addOrphan($menu);
        	// se tiver idparent então é orfão
            if( !$strIdParent )
            {
            	// item pai ou filho
                $this->addMenu($menu);
            }
            else
            {
                // Orphan
                $this->addOrphan($menu);
            }
        }
        */
        return $menu;
    }
    protected function addMenu(TMenuDhtmlx $objMenu)
    {
        if( $Orphan = $this->getOrphanByIdParent($objMenu->getId()))
        {
            $objMenu->addMenu($Orphan);
        }
        $this->arrMenu[] = $objMenu;
    }
    function setText($strNewValue)
    {
        $this->text = preg_replace('/</','&lt;',$strNewValue);
        $this->text = preg_replace('/"/','&quot;',$this->text);
    }
    function setId($strNewValue)
    {
        $this->id = is_null($strNewValue) ? 0 : $strNewValue;
    }
    function setIdParent($strNewValue)
    {
        $this->idParent = is_null($strNewValue) ? 0 : $strNewValue;
    }
    function setUrl($strNewValue)
    {
        $this->strUrl = $strNewValue;
    }
    function setToolTip($strNewValue)
    {
        $this->strTooltip = $strNewValue;
    }
    function setImg($strNewValue)
    {
        $this->strImg = $strNewValue;
    }
    function setImgDisabled($strNewValue)
    {
        $this->strImgDisabled = $strNewValue;
    }
     function setDisabled($boolNewValue)
    {
        $this->boolDisabled = $boolNewValue;
    }
    function setHotKey($strNewValue)
    {
        $this->strHotKey = $strNewValue;
    }
    function setJsonParams($strNewValue)
    {
        $this->jsonParams = $strNewValue;
    }

    function getText()
    {
        return $this->text;
    }
    function getId()
    {
        return $this->id;
    }
    function getIdParent()
    {
        if( (string) $this->idParent != '' && (int) $this->idParent != 0 )
        {
			return $this->idParent;
        }
        return null;
	}
    function getUrl()
    {
        return $this->strUrl;
    }
    function getToolTip()
    {
        return $this->strTooltip;
    }
    function getImg()
    {
        return $this->strImg;
    }
    function getImgDisabled()
    {
        return $this->strImgDisabled;
    }
     function getDisabled()
    {
        return $this->boolDisabled;
    }
    function getHotKey()
    {
        return $this->strHotKey;
    }
    function getMenuById($strId)
    {
    	static $o = null;
		if( (string) $strId == '0' )
		{
			return null;
		}
        if( $this->arrMenu )
        {
            foreach($this->arrMenu as $k=>$objMenu)
            {
            	if( is_null( $o ))
            	{
	                if( $objMenu->getId() == $strId )
	                {
	                   $o = $objMenu;
	                   break;

	                }
	                else
	                {
                 		$o = $objMenu->getMenuById($strId);
					}
				}
            }
        }
        // ver como resolver esse problema, se retornar o $o diretamente não funciona
        $oo=$o;
        $o=null;
        return $oo;
    }

    function getOrphans()
    {
    	return $this->arrOrphan;
    }
    //--------------------------------------------------------------------------------------
    function ignoreOrphans($boolNewValue=null)
    {
	    if( $boolNewValue === null)
	    {
    		return $this->boolIgnoreOrphans;
	    }
		$this->boolIgnoreOrphans = $boolNewValue;
    }
    //--------------------------------------------------------------------------------------
    public function clearOrphans()
    {
    	$this->arrOrphan = null;
    }
    //--------------------------------------------------------------------------------------
    public function setSeparator($boolNewValue=null)
    {
    	$this->boolSeparator = $boolNewValue;
    }
    public function getSeparator()
    {
    	return $this->boolSeparator;
    }
    //--------------------------------------------------------------------------------------
	function getJsonParams()
    {
        return $this->jsonParams;
    }
    //--------------------------------------------------------------------------------------
    function getOrphanById($strId)
    {
        $result = null;
        if($this->arrOrphan)
        {
            foreach($this->arrOrphan as $k=>$objMenu)
            {
                if( $objMenu->getId() == $strId)
                {
                    $result=$objMenu;
                    break;
                }
                $result = $objMenu->getOrphanById($strId);
            }
        }
        return $result;
    }
    function addOrphan(TMenuDhtmlx $menu)
    {
        // se existir filhos orfão, adicionar todos os filhos
        while( $objMenu = $this->getOrphanByIdParent($menu->getId()) )
        {
            $menu->addMenu($objMenu);
        }
        // adicionar ao pai se existir
        if( $objMenu = $this->getOrphanById($menu->getIdParent()))
        {
            $objMenu->addMenu($menu);
        }
        else
        {
        	// adicionar a lista de orfãos
            $this->arrOrphan[] = $menu;
        }
    }
    function getOrphanByIdParent($strId)
    {
        $result = null;
        if($this->arrOrphan )
        {
            foreach($this->arrOrphan as $k=>$objMenu)
            {
                if( $objMenu->getIdParent() == $strId)
                {
                    $result=$objMenu;
                    // remover o registro órfão
                    array_splice($this->arrOrphan,$k,1);
                    break;
                }
                $result = $objMenu->getOrphanByIdParent($strId);
            }
        }
        return $result;
    }
	public function getStructure()
	{
		static $level = 0;
		$xml=null;
		if( $level == 0 )
		{
			// processar o itens que ficaram sem pai e coloca-los no nivel 0 para aparecer no menu principal
			if($this->ignoreOrphans())
			{
				$this->clearOrphans();
			}
			else
			{
				if( $this->getOrphans())
				{
					foreach($this->getOrphans() as $k=>$objMenu)
					{
						// não adicionar o item 2 vezes
						if( ! $this->getMenuById( $objMenu->getId() ) )
						{
							$objMenu->setIdParent(0);
   							$this->addMenu($objMenu);
						}
					}
				}
			}
			$xml ='<menu>'."\n";
		}
		else
		{
			if( $this->getSeparator() )
			{
				$xml = "<item id='{$this->getId()}' type='separator'";
			}
			else
			{
				$xml = "<item id='{$this->getId()}' text='{$this->getText()}'";
			}
			if($this->getDisabled())
			{
				$xml.= " enabled='false'";
			}
			if($this->getImg())
			{
				$xml.= " img='{$this->getImg()}'";
			}
			if($this->getImgDisabled())
			{
				$xml.= " imgDis='{$this->getImgDisabled()}'";
			}
			$xml.= ">\n";
			if($this->getHotKey())
			{
				$xml.= "   <hotkey>{$this->getHotKey()}</hotkey>\n";
			}
			if($this->getToolTip())
			{
				$xml.= "   <tooltip>{$this->getToolTip()}</tooltip>\n";
			}
			if($this->getUrl())
			{
				$xml.= "   <userdata name='url'>{$this->getUrl()}</userdata>\n";
			}
			if($this->jsonParams)
			{
				$xml.= "   <userdata name='jsonParams'>{$this->jsonParams}</userdata>\n";
				// este squi
			}
		}
        if( is_array($this->arrMenu))
		{
			foreach($this->arrMenu as $k => $objMenu)
			{
				$level++;
				$xml .= $objMenu->getStructure();
				$level--;
			}
		}
		return $xml.= ($level > 0 ) ? '</item>' :"\n</menu>";
		//return str_replace("\n","",$xml .= "</item>\n");
	}
	//--------------------------------------------------------------------------------------
	function getXml($print=true)
	{
		// adicionar os itens orfãos
		if($this->getOrphans())
		{
			foreach( $this->getOrphans() as $k=>$objMenu)
			{
				 $objMenuPai =  $this->getMenuById( $objMenu->getIdParent() );
				 if( $objMenuPai )
				 {
					$objMenuPai->addMenu($objMenu);
				 }
			}
		}
		$print = $print === null ? true : $print;
		if( $print) {
			header ("content-type: text/xml; charset=".ENCODINGS);
			echo str_replace("'",'"',$this->getStructure());
		}else {
			return str_replace("'",'"',$this->getStructure());
		}
        /*
		echo '<menu>
		<item id="file" text="Administração">
			<item id="new" text="New" img="new.gif"/>
			<item id="file_sep_1" type="separator"/>
			<item id="open" text="Open" img="open.gif">
				<userdata name="url">app_server_action("limparCache",false, "script")</userdata>
			</item>
			<item id="save" text="Save" img="save.gif"/>
			<item id="saveAs" text="Save As..." imgdis="save_as_dis.gif" enabled="false"/>
			<item id="file_sep_2" type="separator"/>
			<item id="print" text="Print" img="print.gif"/>
			<item id="pageSetup" text="Page Setup" imgdis="page_setup_dis.gif" enabled="false"/> <item id="file_sep_3" type="separator"/> <item id="close" text="Close" img="close.gif"/>
		</item>
		<item id="edit" text="Edit">
			<item id="undo" text="Undo" img="undo.gif"/>
			<item id="redo" text="Redo" img="redo.gif"/>
			<item id="edit_sep_1" type="separator"/>
			<item id="selectAll" text="Select All" img="select_all.gif"/>
			<item id="edit_sep_2" type="separator"/>
			<item id="cut" text="Cut" img="cut.gif"/>
			<item id="copy" text="Copy" img="copy.gif"/>
			<item id="paste" text="Paste" img="paste.gif"/>
		</item>
		<item id="help" text="Help">
			<item id="about" text="About..." img="about.gif"/>
			<item id="needhelp" text="Help" img="help.gif"/>
			<item id="bugReporting" text="Bug Reporting" img="bug_reporting.gif"/>
		</item>
		</menu>';
		*/
	}
}
?>