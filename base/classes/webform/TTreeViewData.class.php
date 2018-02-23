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

class TTreeViewData
{
	//static 	private $level = 0;
	private $xml;
	private $parent;
	private $id;
	private $child;
	private $itens;
	private $text;
	private $hint;
	private $userData;
	private $open;
	private $checked;
	/**
	* Classe TTreeView
	*
	* @param mixed $id
	* @param mixed $text
	* @param mixed $boolOpen
	* @param mixed $hint
	* @param mixed $arrUserData
	* @param mixed $boolSelect
	* @param mixed $boolChecked
	* @return TTreeViewData
	*/
	public function __construct( $id, $text, $boolOpen=null, $hint=null, $arrUserData=null, $boolSelect=null, $boolChecked=null )
	{
		$this->parent	= null;
		$this->child	= 0;
		$this->id 		= $id;
		$this->text 	= $text;
		$this->open		= ($boolOpen===true) ? 'yes' :'no';
		$this->hint 	= $hint;
		$this->select	= ($boolSelect===true) ? 'yes' :'no';
		$this->userData = $arrUserData;
		$this->checked	= (	$boolChecked===true) ? 'yes' :'no';
	}
	public function addItem( TTreeViewData $item )
	{
		$item->setParent($this->getId());
		$item->child=1;
		$this->itens[$item->getId()] = $item;
		return $item;
	}
	public function getId()
	{
		return $this->id;
	}
	public function setParent($id)
	{
		$this->parent=$id;
	}
	public function clear()
	{
		if($this->itens)
		{
			forEach($this->itens as $k=>$item)
			{
				$result = $item->clear();
				unset($this->itens[$k]);
			}
			unset($this->itens);
		}
	}
	function getIdParent()
    {
        if( (string) $this->parent != '' && (int) $this->parent != 0 )
        {
			return $this->parent;
        }
        return null;
	}
	public function getElementById($id)
	{
		$result=null;
		if($id == $this->id)
		{
			return $this;
		}
		if($this->itens)
		{
			forEach($this->itens as $k=>$item)
			{
				if( $k == $id)
				{
					$result = $this->itens[$k];
				}
				else
				{
					$result = $item->getElementById($id);
				}
				if ($result)
					break;
			}
		}
		//return $result ? $result : $this;
		return $result;
	}
	//----------------------------------------------------------------------------------------------
	/*
	private function getTagOld($ident)
	{
		$tag = "";
		if(is_null($this->parent) )
		{
			$tag .= "<tree id=\"{$this->getId()}\">";
		}
		else
		{
			$tag .="<item id=\"{$this->getId()}\" text=\"{$this->text}\"";
			if($this->tooltip)
			{
				$tag.=" tooltip=\"{$this->hint}\"";
			}
			if($this->select=="yes")
			{
				$tag.=" select=\"{$this->select}\"";
			}
			if($this->open=="yes")
			{
				$tag.=" open=\"{$this->open}\">";
			}
			$tag.=">";
		}
		return $ident.$tag."\n";
	}
	*/
	//----------------------------------------------------------------------------------------------
	private function getTag()
	{
		$tag = new TElement('tree');
		$tag->setProperty('id',$this->getId());
		$tag->setProperty('text',$this->text);
		if(!is_null($this->parent) )
		{
			$tag->setTagType('item');
			if($this->child==1)
			{
				$tag->setProperty('child',"1");
			}
			if($this->hint)
			{
				$tag->setProperty('tooltip',$this->hint);
			}
			if($this->select=="yes")
			{
				$tag->setProperty('select',$this->select);
			}
			if($this->open=="yes")
			{
				$tag->setProperty('open',$this->open);
			}
			if($this->checked=="yes")
			{
				$tag->setProperty("checked",$this->checked);
			}
		}
		return $tag;
	}
	//---------------------------------------------------------------------------------------
	public function generateXml($fim=true)
	{
		$xml = $this->getTag();

		if( is_array( $this->userData ) )
		{
			foreach($this->userData as $k=>$v)
			{
				/*
				$userData = new TElement('userdata');
				$userData->setProperty('name',$k);
				$userData->add($v,false);
				$xml->add($userData);
				*/
				$xml->add('<userdata name="'.$k.'">'.$v.'</userdata>');
			}
		}
		if( $this->itens)
		{
			foreach($this->itens as $k=>$item)
			{
				$xml->add($item->generateXml(false));
			}
		}
		$this->xml = $xml;
		return $xml;
	}
	public function getXml()
	{
		$this->generateXml();
		if( $this->xml)
		{
			return $this->xml->show(false);
		}
	}
	public function show()
	{
		$this->generateXml();
		if( $this->xml)
		{
			$this->xml->show();
		}
	}
	//----------------------------------------------------------------------------------
	/*public function getXml()
	{
		self::$level++;
		$ident = str_repeat(chr(9),(self::$level-1));
		$xml = $this->getTag($ident);
		if( $this->itens)
		{
			foreach($this->itens as $k=>$item)
			{
				$xml.=$item->getXml();
			}
		}
		if($this->userData)
		{
			foreach($this->userData as $k=>$v)
			{
				$xml .= $ident.chr(9)."<userdata name=\"{$k}\">{$v}</userdata>\n";
			}
		}
		if(is_null($this->parent) )
		{
			$xml.= $ident."</tree>\n";
		}
		else
		{
			$xml.= $ident."</item>\n";
		}
		self::$level--;
		return $xml;
	}
	*/
}
/*
$item = new TTreeViewItem('0','root');
$item->getElementById(0)->addItem( new TTreeViewItem(1,'Cadastro') );
$item->getElementById(1)->addItem( new TTreeViewItem(11,'Livros') );
$item->getElementById(1)->addItem( new TTreeViewItem(12,'Bicicletas') );
$item->getElementById(1)->addItem( new TTreeViewItem(13,'Móveis') );
$item->getElementById(11)->addItem( new TTreeViewItem(111,'Usados') );
$item->getElementById(11)->addItem( new TTreeViewItem(112,'Novos') );
$item->getElementById(112)->addItem( new TTreeViewItem(1121,'Novo 1',true,"Item novo",true,array("url"=>"http://www.google.com.br")) );
echo $item->getXml();
*/

/*
$subItem = $item->addItem(new TTreeViewItem(1,'Cadastro'));
$subItem->addItem(new TTreeViewItem(11,'Usuários'));
$subItem->addItem(new TTreeViewItem(12,'Computador'));
$subItem->addItem(new TTreeViewItem(13,'Livros'));
$item14 = $subItem->addItem(new TTreeViewItem(14,'Canetas'));
$item14->addItem(new TTreeViewItem(141,'Usados',false,'Livros Usados',false,array('url'=>'http://www.google.com.br')));
print_r($item->getElementById(141));
*/
//$item->Show();

?>