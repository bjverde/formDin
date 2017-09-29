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

class TFile extends TEdit
{
	private $maxSize;
	private $allowedFileTypes;
	public function __construct($strName,$intSize=null,$boolRequired=null,$strAllowedFileTypes=null,$strMaxSize=null)
	{
		$intSize= is_null($intSize) ? 50 : $intSize;
		parent::__construct($strName,null,5000,$boolRequired,$intSize);
		$this->setFieldType('file');
		$this->setProperty('type','file');
		$this->setMaxSize($strMaxSize);
		$this->setAllowedFileTypes($strAllowedFileTypes);
		$this->addEvent('onchange','fwCampoArquivoChange(this)');
		// guardar os dados do arquivo temporário postado em campos ocultos
		if(isset($_FILES[$this->getId()]))
		{
			if( isset( $_FILES[$this->getId()]['size'] ) > 0 && $_FILES[$this->getId()]['error'] == 0 )
			{
				$to = $this->getBase().'tmp/'.$_FILES[$this->getId()]['name'];
				if( move_uploaded_file( $_FILES[$this->getId()]['tmp_name'],$to ) )
				{
					// define os valores dos campos ocultos que serão adicionados ao form
					$_POST[$this->getId().'_temp'] 	= $to;
					$_POST[$this->getId().'_type'] 	= $_FILES[$this->getId()]['type'];
					$_POST[$this->getId().'_size'] 	= $_FILES[$this->getId()]['size'];
					$_POST[$this->getId().'_name']	= $_FILES[$this->getId()]['name'];
				}
			}
		}
		$temp= new THidden($this->getId().'_temp');
		$this->setValue($temp->getValue());
		$btnClear = new TButton($this->getId().'_clear','Apagar',null,'fwLimparCampoAnexo(this,"'.$this->getId().'")',null,'lixeira.gif','lixeira_bw.gif');
		//$btnClear->setEnabled( ($imageClear=='lixeira.gif'));
		$btnClear->setProperty('title','Limpar arquivo anexado');
		$btnClear->setCss('width','16');
		$btnClear->setCss('height','16');

		$this->add($btnClear);
		//$this->add($btnView);
		$this->add($temp);
		// adiciona os campos ocultos de suporte ao campo arquivo
		$type= new THidden($this->getId().'_type');
		$this->add($type);
		$size= new THidden($this->getId().'_size');
		$this->add($size);
		$name= new THidden($this->getId().'_name');
		$this->add($name);
	}
	//-------------------------------------------------------------------------------------------
	public function setMaxSize($strMaxSize=null)
	{
		$strMaxSize = is_null($strMaxSize) ? ini_get('post_max_size') : $strMaxSize;
		$this->maxSize = $strMaxSize;
	}
	public function getMaxSize()
	{
		return $this->maxSize;
	}
	public function validate()
	{
		if( parent::validate())
		{
			if( isset($_POST[$this->getId().'_size']))
			{
				$maxSize = ereg_replace('[^0-9]','',$this->getMaxSize());
				if( strpos(strtoupper($this->getMaxSize()),'M')!==false )
				{
					// megabytes
					$fator = pow(1024,2);
					$this->setMaxSize($maxSize.'Mb');
				}
				else if( strpos(strtoupper($this->getMaxSize()),'G')!==false )
				{
					// gigabytes
					$fator = pow(1024,3);
					$this->setMaxSize($maxSize.'Gb');
				}
				else
				{
					// padrão é kilbytes
					$fator = 1024;
					$this->setMaxSize($maxSize.'Kb');
				}
				$maxSize *= $fator;
				if( (int)$_POST[$this->getId().'_size'] > (int)$maxSize)
				{
					$this->addError('Tamanho máximo permitido '.$this->getMaxSize().' O arquivo selecionado possui '.ceil($_POST[$this->getId().'_size'] / 1024).'Kb');
					$this->clear();
					$this->setCss('border','1px solid #ff0000');
				}
				else
				{
					// validar extensão
					if( $this->getAllowedFileTypes() )
					{
						$aExtensions = explode(',',strtolower($this->getAllowedFileTypes()));
						if( array_search($this->getFileExtension(),$aExtensions)===false)
						{
							$this->addError('Arquivo inválido. Tipo(s) válido(s):'.$this->getAllowedFileTypes());
						}
					}
				}
			}
		}
		return ( (string)$this->getError()==="" );
	}
	//------------------------------------------------------------------------
	public function clear()
	{
		// excluir o arquivo temporário
		if( file_exists($this->getValue(true)))
		{
			unlink($_POST[$this->getId().'_temp']);
		}
		// excluir os campos ocultos que registram os dados do arquivo anexo
		$this->clearChildren();
		// limpar os valores postados
		unset($_POST[$this->getId().'_temp']);
		unset($_POST[$this->getId().'_type']);
		unset($_POST[$this->getId().'_size']);
		unset($_POST[$this->getId().'_name']);
		parent::clear();
	}
	/**
	* Define as extensões de arquivos permitidas.
	* Devem ser informadas separadas por virgula
	* Ex: doc,gif,jpg
	*
	* @param string $strNewFileTypes
	*/
	public function setAllowedFileTypes($strNewFileTypes=null)
	{
		$this->allowedFileTypes = $strNewFileTypes;
	}
	/**
	* Recupera os tipos de extensões permitidas
	*
	*/
	public function getAllowedFileTypes()
	{
		return $this->allowedFileTypes;
	}
	/**
	* Retorna a extensão do arquivo anexado
	* Ex. teste.gif -> retorna: gif
	*/
	public function getFileExtension()
	{
		$filename = strtolower($this->getValue(true)) ;
		$exts = split("[/\\.]", $filename) ;
		$n = count($exts)-1;
		$exts = $exts[$n];
		return $exts;
	}
	//----------------------------------------
	public function getValue($boolFileName=null)
	{
		if($boolFileName===true)
		{
			return parent::getValue();
		}
		if( isset( $_POST[$this->getId().'_temp'] ) )
		{
			$tempFile = $_POST[$this->getId().'_temp'];
			if(file_exists($tempFile))
			{
				return file_get_contents($tempFile);
			}
		}
		return null;
	}
	/**
	* Retorna o caminho completo do arquivo na pasta temporária
	*
	*/
	public function getFileName()
	{
		return $this->getValue(true);
	}
	/**
	* Retorna o caminho completo do arquivo na pasta temporária
	*
	*/
	public function getTempFile()
	{
		return $this->getFileName();
	}

}
/*
print '<form enctype="multipart/form-data" method="POST" action="" name="formdin">';
	$val = new TFile('arq_anexo',50,true,'doc,pdf','170K');
	$val->validate();
	$val->show();
	//print_r($val->getValue());
print '<hr><input type="submit" value="Gravar" name="btnGravar">';
print '</form>';
print '<hr>';
print_r($_POST);
print '<hr>';
//print_r($_FILES);
if($val->getValue(true))
{
	print '<IFRAME id="results" name="Results" src="'.$val->getValue(true).'" frameBorder=1 style="position:absolute;top:15px;left:600px;width:600px;height:600px;background-color:white;"></IFRAME>-->';
}
*/
?>