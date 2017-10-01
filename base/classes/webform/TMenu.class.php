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

class TMenu
 {
 	static public $base;
 	private $id;
	private $items;
	private $cssPath;
	private $imagePath;
	private $targetId;
	private $top;
	private $left;
	private $width;
 	public function __construct($strId=null,$strTargetId=null,$strCssPath=null,$strImagePath=null,$top=null,$left=null,$width=null)
 	{
 		$this->setId($strId);
 		$this->cssPath 			= $strCssPath;
 		$this->imagePath		= $strImagePath;
 		$this->targetId			= $strTargetId;
 		$this->top				= $top;
 		$this->left				= $left;
 		$this->width			= $width;
 	}
 	//------------------------------------------------------------------------
 	public function show($print=true)
 	{
 		if(!isset(self::$base))
 		{
			$this->getBase();
			if(!$this->getTarget())
			{
				$this->top  	= is_null($this->top) 	? 0 :$this->top;
				$this->left 	= is_null($this->left) 	? 0 :$this->left;
				$this->width 	= is_null($this->width) ? '99%' :$this->width;
				echo "<div style=\"position:fixed;top:{$this->top};left:{$this->left};width:{$this->width};\" id=\"{$this->getId()}_containter\"></div>\n";
				$this->targetId = "{$this->getId()}_containter";
			}
			echo "<script type=\"text/javascript\" src=\"{$this->getBase()}js/menu/menu-for-applications.js\"></script>\n";
		}
 		echo "<script type=\"text/javascript\">\n";
		echo "var {$this->getId()} = new DHTMLSuite.menuModel();\n";
		echo "DHTMLSuite.configObj.setCssPath('{$this->getBase()}css/menu/css_silver/');\n";

		echo "DHTMLSuite.commonObj.setCssCacheStatus(true);\n";
		if($this->getCssPath())
		{
			echo "DHTMLSuite.configObj.setCssPath('{$this->getCssPath()}');\n";
		}
		echo "DHTMLSuite.configObj.setImagePath('{$this->getImagePath()}');\n";
		if( is_array($this->getItems()))
		{
			$aWidths=null;
			$currentMenu=null;
			foreach($this->getItems() as $k=>$item)
			{
				echo "{$this->getId()}.";
				if($item[1] == '|separator|')
				{
					echo  "addSeparator({$currentMenu});\n";
				}
				else
				{
					if($item[2])
					{
						if(!file_exists($item[2]))
						{
							$item[2] = self::$base.'imagens/'.$item[2];
						}
					}
					$item[4] = is_null($item[4])? "false": $item[4];
					echo "addItem({$item[0]},'{$item[1]}','{$item[2]}','{$item[3]}',{$item[4]},'{$item[5]}','{$item[6]}','{$item[7]}');\n";
					// width automatico se não tiver especificado
					if( isset($item[4] ) && $item[4] != "false")
					{
						$currentMenu = $item[4];
						$aWidths[$item[4]] = 0;
					 	if( isset($item[8]) && (int) $item[8] > 0 )
						{
							// guardar a maior largura definda do submenu
							if(!isset($aWidths[$item[4]]) || (int) $item[8] > $aWidths[$item[4]] )
							{
								$aWidths[$item[4]] = (int) $item[8];
							}
						}
					}
				}
			}
			if( is_array($aWidths))
			{
				foreach($aWidths as $k=>$v)
				{
					if( $v == 0 )
					{
						echo "{$this->getId()}.setSubMenuWidth({$k},'150');\n";
					}
					else
					{
						echo "{$this->getId()}.setSubMenuWidth({$k},{$v});\n";
					}
				}
			}
			echo "{$this->getId()}.init();\n";
			echo "var menuBar_{$this->getId()} = new DHTMLSuite.menuBar();\n";
			echo "menuBar_{$this->getId()}.addMenuItems({$this->getId()})\n";
			echo "menuBar_{$this->getId()}.setTarget('{$this->getTarget()}');\n";
			echo "jQuery(document).ready(function() { menuBar_{$this->getId()}.init();});\n";
			echo "// fim do menu\n";
		}
		echo "</script>\n";
 	}
	//---------------------------------------------------------------------------
	public function setId($strNewId=null)
	{
	 	$strNewId = (is_null($strNewId)) ? "menu".mt_rand(1, 100) : $strNewId;
		$this->id = $this->removeIllegalChars($strNewId);
	}
	//---------------------------------------------------------------------------
	public function getId()
	{
		return $this->id;
	}
 	//-------------------------------------------------------------------------
 	public function getCssPath()
 	{
 		return $this->cssPath;
 	}
 	//-------------------------------------------------------------------------
 	public function getImagePath()
 	{
 		if(is_null( $this->imagePath ))
 		{
 			return $this->getBase().'css/imagens/';
 		}
 		return $this->imagePath;
 	}
 	//-------------------------------------------------------------------------
 	//-------------------------------------------------------------------------
	/**
	* Remove os caracteres invalidos para criacao de nomes de funcoes e variaveis
	* Para não excluir algum caractere especifico, utilize o parametro $strExcept
	* ex: removeIllegalChars($teste,'[]');
	* @param string $word
	* @param string $strExcept
	* @return string
	*/
	public function removeIllegalChars($word,$strExcept=null)
	{
		if(isset($strExcept))
		{
			$strExcept = str_replace(array('[',']','^'),array('\\[','\\]','\\^'),$strExcept);
		}
		return $word = ereg_replace("[^a-zA-Z0-9_".$strExcept."]", "", strtr($word, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
	}
 	//-------------------------------------------------------------------------
	public function getBase()
	{
		if( is_null(self::$base) )
		{
			for($i=0;$i<10;$i++)
			{
				$base = str_repeat('../',$i).'base/';
				if( file_exists($base) )
				{
					$i=1000;
					self::$base=$base;
					break;
				}
			}
		}
		return self::$base;
	}
 	//-------------------------------------------------------------------------
 	public function addItem($intId=null,$intParentId=null,$strItemText=null,$strIcon=null,$strUrl=null,$strHelpText=null,$strJsFunction=null,$intWidth=null)
 	{

 		if(!isset($intId))
		{
			$this->items[] = array($intId,'|separator|');
		}
		else
		{
			$this->items[] = array($intId,$strItemText,$strIcon,$strUrl,$intParentId,$strHelpText,$strJsFunction,null,$intWidth);
		}
 	}
 	//-------------------------------------------------------------------------
 	public function getItems()
 	{
 		return $this->items;
 	}
 	public function getTarget()
 	{
 		return $this->targetId;
 	}
}
return;
new TElement();
$menu = new TMenu('main_menu',null,null,null,40,10,500);
$menu->addItem(1,null,'Cadastro','search.gif',null,'hint do item',null);
$menu->addItem();
$menu->addItem(2,null,'Relatório','lixeira.gif',null,'Relatório de Produtos');
$menu->addItem(22,2,'Vidas2','lixeira.gif',null,'Relatório de Funcionarios',null);
$menu->addItem(23,2,'Vidas','lixeira.gif',null,'Relatório de Funcionarios',null);
$menu->addItem();
$menu->addItem(24,2,'Maria','lixeira.gif',null,'Relatório de Funcionarios',null);
$menu->addItem(25,2,'Maria maria é um dom uma certa magia','lixeira.gif',null,'Relatório de Funcionarios',null,400);
$menu->show();
?>