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

class TFile extends TEdit {
    private $maxSize;
    private $maxSizeKb;
    private $allowedFileTypes;
    private $msgUploadException;
    
    
    /**
     * Classe para fazer upload de arquivo
     *
     * @param string $strName       - 1: ID do campo
     * @param integer $intSize
     * @param [type] $boolRequired
     * @param [type] $strAllowedFileTypes
     * @param [type] $strMaxSize
     */
    public function __construct($strName,$intSize=null,$boolRequired=null,$strAllowedFileTypes=null,$strMaxSize=null) {
        $intSize= is_null($intSize) ? 50 : $intSize;
        parent::__construct($strName,null,5000,$boolRequired,$intSize);
        $this->setFieldType('file');
        $this->setProperty('type','file');
        $this->setMaxSize($strMaxSize);
        $this->setMaxSizeKb($strMaxSize);
        $this->setAllowedFileTypes($strAllowedFileTypes);
        $this->addEvent('onchange','fwCampoArquivoChange(this)');
        // guardar os dados do arquivo temporário postado em campos ocultos
        try {
            $this->setPostFileInfo();
        } catch (Exception $e) {
            $this->setMsgUploadException($e->getMessage());
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
    /**
     * define os valores dos campos ocultos que serão adicionados ao form
     * @throws UploadException
     */
    public function setPostFileInfo(){
        if(isset($_FILES[$this->getId()])) {
            if( $_FILES[$this->getId()]['error'] == UPLOAD_ERR_OK ) {
                $to = $this->getBase().'tmp/'.$_FILES[$this->getId()]['name'];
                if( move_uploaded_file( $_FILES[$this->getId()]['tmp_name'],$to ) ) {
                    $_POST[$this->getId().'_temp'] 	= $to;
                    $_POST[$this->getId().'_type'] 	= $_FILES[$this->getId()]['type'];
                    $_POST[$this->getId().'_size'] 	= $_FILES[$this->getId()]['size'];
                    $_POST[$this->getId().'_name']	= $_FILES[$this->getId()]['name'];
                }
            }else{
                throw new UploadException($_FILES[$this->getId()]['error']);
            }
        }
    }
    //-------------------------------------------------------------------------------------------
    public function getMsgUploadException() {
        return $this->msgUploadException;
    }
    //-------------------------------------------------------------------------------------------
    public function setMsgUploadException($msgUploadException) {
        $this->msgUploadException = $msgUploadException;
    }
    //-------------------------------------------------------------------------------------------
    public function setMaxSize($strMaxSize=null){
        $post_max_size = ini_get('post_max_size');
        $strMaxSize = is_null($strMaxSize) ? $post_max_size : $strMaxSize;
        $this->maxSize = $strMaxSize;
    }
    //-------------------------------------------------------------------------------------------
    public function getMaxSize(){
        return $this->maxSize;
    }
    //-------------------------------------------------------------------------------------------
    public function setMaxSizeKb($strMaxSize=null){
        $this->setMaxSize($strMaxSize);
        
        $maxSize = preg_replace('/[^0-9]/','',$this->getMaxSize());
        $fator = null;
        $sizeKilbytes = 1024;
        if( strpos(strtoupper($this->getMaxSize()),'M')!==false ) {
            // megabytes
            $fator = pow($sizeKilbytes,2);
            $this->setMaxSize($maxSize.'Mb');
        } else if( strpos(strtoupper($this->getMaxSize()),'G')!==false ) {
            // gigabytes
            $fator = pow($sizeKilbytes,3);
            $this->setMaxSize($maxSize.'Gb');
        } else {
            // padrão é kilbytes
            $fator = $sizeKilbytes;
            $this->setMaxSize($maxSize.'Kb');
        }
        
        $maxSize = $maxSize*$fator;
        $this->maxSizeKb = $maxSize;
    }
    //-------------------------------------------------------------------------------------------
    public function getMaxSizeKb(){
        return $this->maxSizeKb;
    }
    //-------------------------------------------------------------------------------------------
    public function validate() {
        if( parent::validate()) {
            if($this->getMsgUploadException()){
                $this->addError('ERRO interno: '.$this->getMsgUploadException());
            }else{
                $fileSizeKb = PostHelper::get($this->getId().'_size');
                if( $fileSizeKb ) {
                    $maxSize = $this->getMaxSizeKb();
                    if( (int)$fileSizeKb > (int)$maxSize) {
                        $msg = 'Tamanho máximo permitido '.$this->getMaxSize().' O arquivo selecionado possui '.ceil($_POST[$this->getId().'_size'] / 1024).'Kb';
                        $this->addError($msg);
                        $this->clear();
                        $this->setCss('border','1px solid #ff0000');
                    } else {
                        // validar extensão
                        if( $this->getAllowedFileTypes() ) {
                            $aExtensions = explode(',',strtolower($this->getAllowedFileTypes()));
                            if( array_search($this->getFileExtension(),$aExtensions)===false) {
                                $this->addError('Arquivo inválido. Tipo(s) válido(s):'.$this->getAllowedFileTypes());
                            }
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
        if( FileHelper::exists($this->getValue(true)))
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
    public function getFileExtension() {
        $filename = strtolower($this->getValue(true)) ;
        $exts = explode(".", $filename);
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
            if( FileHelper::exists($tempFile) ){
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