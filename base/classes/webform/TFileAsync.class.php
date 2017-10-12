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

class TFileAsync extends TEdit
{
	private $maxSize;
	private $allowedFileTypes;
	private $jsCallBack;
	private $messageInvalidFileType;
	/**
	* Classe para fazer upload de arquivo de forma asyncrona
	* $intSize = numero de caracteres do arquivo anexado que serão exibido na tela, pode ser utilizado
	* o parametro $intWidth tambem
	*
	* O parametro $strJsCallBack define a função javascript que será chamada quando o upload assincrono terminar.
	* Esta função receberá, como parametros, o nome do arquivo temporário e o nome do arquivo anexado.
	*
	* @param string $strName
	* @param integer $intSize
	* @param boolean  $boolRequired
	* @param string $strAllowedFileTypes
	* @param string $strMaxSize
	* @param integer $intWidth
	* @param $strJsCallBack
	* @return TFileAsync
	*/
	public function __construct($strName,$intSize=null,$boolRequired=null,$strAllowedFileTypes=null,$strMaxSize=null,$intWidth=null,$strJsCallBack=null,$strMessageInvalidFileType=null)
	{
		$intSize= is_null($intSize) ? 50 : $intSize;
		parent::__construct($strName,null,5000,$boolRequired,$intSize);
		$this->setFieldType('fileAsync');
		$this->setMaxSize($strMaxSize);
		$this->setAllowedFileTypes($strAllowedFileTypes);
		//$this->setEnabled(false);
		$this->jsCallBack = $strJsCallBack;
		$this->setMessageInvalidFileType($strMessageInvalidFileType);
		//$intWidth = $intWidth === null ? '300px' : $intWidth;
		//$this->setWidth($intWidth);
	}
	/**
	* Exibe o html ou devolve o html se $print for false
	*
	* @param bool $print
	* @return mixed
	*/
	public function show($print=true)
	{
		$table = new TTable($this->getId().'_table');
		$row = $table->addRow();
		// adiciona o iframe de suporte ao campo arquivo
		$size= new THidden($this->getId().'_size');
		$tempFileNameHidden = new THidden($this->getId().'_temp_name',(  isset( $_REQUEST[ $this->getId().'_temp_name'] ) ? $_REQUEST[ $this->getId().'_temp_name'] : '' ) );
		$fileExtension = new THidden($this->getId().'_extension');
		$fileExtension->setValue($this->getFileExtension());
		$fileType = new THidden($this->getId().'_type');
		$this->setCss('background-repeat',"no-repeat");
		$iframe = new TElement('iframe');
		$iframe->setId($this->getId().'_upload_iframe');
		$iframe->setName($this->getId().'_upload_iframe');
		$iframe->setCss('padding','0px');
		$iframe->setCss('margin','0px');
		$iframe->setCss('width','130px');
		$iframe->setCss('height','23px');
		$iframe->setCss('border-width','0px');
		$iframe->setCss('margin-width','0px');
		$iframe->setCss('overflow','hidden');
		$iframe->setCss('vertical-align','top');
		//$iframe->setCss('background-color','green');
		$boolReadOnly = $this->getReadOnly() ? 1 : 0;
		$iframe->setProperty('frameBorder','0');
		$iframe->setProperty("allowTransparency","true");
        $indexFileName = $this->getIndexFileName();
       if( $indexFileName )
       {
           $iframe->setProperty('src',$this->getIndexFileName().'?ajax=1&modulo='.$this->getBase().'includes/upload.php&readOnly='.$boolReadOnly.'&name='.$this->getId().'&tamanhoMaxAlert='.$this->maxSize.'&tamanhoMaxBytes='.$this->getMaxSize().'&callBack='.$this->jsCallBack.'&messageInvalidFileType='.$this->getMessageInvalidFileType());
       }
       else
       {
           $iframe->setProperty('src',$this->getBase().'includes/upload.php?readOnly='.$boolReadOnly.'&name='.$this->getId().'&tamanhoMax='.$this->maxSize.'&callBack='.$this->jsCallBack.'&messageInvalidFileType='.$this->getMessageInvalidFileType());
       }

		$_SESSION['frmFileAsync'][$this->getId()]['tiposValidos'] 	= $this->getAllowedFileTypes();
		$_SESSION['frmFileAsync'][$this->getId()]['tamanhoKb'] 		= $this->getMaxSize();
		$img = ( isset( $_REQUEST[$this->getId().'_temp_name'] ) && $_REQUEST[$this->getId().'_temp_name'] ) ? 'lixeira.gif': 'lixeira_disabled.gif';
		$btnDelete = new TButton($this->getId().'_btn_delete',null,null,'fwClearFileAsync("'.$this->getId().'")',null,$img);
		$this->setReadOnly(true);
		$row->addCell( parent::show(false).$btnDelete->show(false).$iframe->show(false).$size->show(false).$tempFileNameHidden->show(false).$fileExtension->show(false).$fileType->show(false))->setProperty('nowrap','true');

		return $table->show($print);
		//return '<table id="xxxx"><tr><td nowrap>'.parent::show(false).$iframe->show(false).$size->show(false).'</td></tr></table>';
	}
	//-------------------------------------------------------------------------------------------
	/**
	* Define o tamanho máximo do arquivo permitido
	* Pode ser definido assim:
	* ex: 1T, 2G, 30M, 1024KB
	* se não for espeficificado a unidade T, G, M, KB será assumido KB
	* @param string $strMaxSize
	*/
	public function setMaxSize($strMaxSize=null)
	{
		$strMaxSize = is_null($strMaxSize) ? ini_get('post_max_size') : $strMaxSize;
		$this->maxSize = $strMaxSize;
	}
	/**
	* Retorna o tamanho máximo em bytes permitido para o arquivo ser válido
	*
	*/
	public function getMaxSize()
	{
		$maxSize = preg_replace('/[^0-9]/','',$this->maxSize);
	$bytes=1024; // padrao 1kb
	if( strpos(strtoupper($this->maxSize),'M')!==false )
	{
		// megabytes
		$bytes  =  ( 1024 * $maxSize ) * 1024;
		$this->setMaxSize($maxSize.'Mb');
	}
	else if( strpos(strtoupper($this->maxSize),'G')!==false )
	{
		// gigabytes
		$bytes = ( ( 1024 *1024 ) * $maxSize) * 1024;
		$this->setMaxSize($maxSize.'Gb');
	}
	else
	{
		$this->setMaxSize('1Kb');
	}
	return $bytes;
}
/**
	* faz a validação da extensão e do tamanho máximo permitido
	*
	*/
	public function validate()
	{
		//verficar se o arquivo está no servidor
		$filename = $this->getTempFile();

		if ( !file_exists($filename) && $this->getRequired() )
		{
			$this->addError('Campo obrigatório');
		}
		return ( (string)$this->getError()==="" );
	}
	//------------------------------------------------------------------------
	public function clear()
	{
		// excluir o arquivo temporário
		if( file_exists($this->getTempFile()))
		{
			@unlink($this->getTempFile());
		}
		if( isset( $_REQUEST[$this->getId().'_temp_name'] ) )
		{
			$_REQUEST[$this->getId().'_temp_name']=null;
			$_REQUEST[$this->getId().'_name']=null;
			$_REQUEST[$this->getId().'_size']=null;
			$_REQUEST[$this->getId().'_extension']=null;
		}
		// excluir os campos ocultos que registram os dados do arquivo anexo
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
		$filename = strtolower($this->getValue()) ;
		/*
		$exts = @split("[/\\.]", $filename) ;
		$n = count($exts)-1;
		$exts = $exts[$n];
		return $exts;
		*/
		$aFileInfo = pathinfo( $filename );
        return  isset( $aFileInfo[ 'extension' ] ) ? $aFileInfo[ 'extension' ]  : '';
	}
	/**
	* Retorna o conteudo do arquivo anexado
	*
	*/
	public function getContent()
	{
		if($this->getTempFile())
		{
			return file_get_contents($this->getTempFile());
		}
		return null;
	}
	/**
	* Retorna o nome temporário do arquivo gravado na pasta base/tmp
	*
	*/
	public function getTempFile()
	{
		if( isset($_POST[$this->getId().'_temp_name']))
		{
			$tempFileName = $_POST[$this->getId().'_temp_name'];
		}
		else if( isset($_GET[$this->getId().'_temp_name']))
		{
			$tempFileName = $_GET[$this->getId().'_temp_name'];
		}
		else if( isset($_REQUEST[$this->getId().'_temp_name']))
		{
			$tempFileName = $_REQUEST[$this->getId().'_temp_name'];
		}
        if( preg_match('/base\//',$tempFileName))
        {
			$x = strpos($tempFileName,'base/');
			$tempFileName = $this->getBase.substr($tempFileName,($x+5));
        }
        if( $tempFileName)
        {
			if(file_exists($tempFileName))
			{
				return $tempFileName;
			}
			else
			{
				// procurar no diretorio base/tmp
				if(file_exists($this->getBase().$tempFileName))
				{
					return $this->getBase().$tempFileName;
				}
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
		return $this->getValue();
	}
	/**
	* Define a função javascript que será chamada quando o upload assincrono terminar.
	* Serão passados o nome do arquivo temporário e o nome do arquivo anexado
	*
	* @param string $strNewValue
	*/
	public function setCallBackJs($strNewValue=null)
	{
		$this->jsCallBack=$strNewValue;
	}
	public function getCallBackJs()
	{
		return $this->jsCallBack;
	}
	public function setMessageInvalidFileType( $strNewValue=null )
	{
		$this->messageInvalidFileType = $strNewValue;
	}
	public function getMessageInvalidFileType()
	{
		return $this->messageInvalidFileType;
	}


}
?>