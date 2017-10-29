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
class TCaptcha extends TButton
{
    private $input;
	public function __construct($strName,$strHint=null,$intCaracters=null)
	{
        $intCaracters = is_null($intCaracters) ? 6 : $intCaracters;
        $intCaracters = $intCaracters > 10 ? 10 : $intCaracters;
        $strName = isset($strName) ? $strName : null;
        $strValue = isset($strValue) ? $strValue : null;
        
        $url = $this->getBase().'classes/captcha/CaptchaSecurityImages.class.php?field='.$this->removeIllegalChars($strName).( is_null( $intCaracters ) ? '' : '&characters='.$intCaracters);
        parent::__construct($strName.'_img',$strValue,null,"javascript:this.src='".$url."&'+ Math.random()",null,null,null,'Código de Segurança - Digite no campo ao lado os caracteres que estão impressos nesta imagem!');
        //parent::__construct($strName.'_img',$strValue,null,"javascript:document.getElementById('".$strName."_img').src = '".$url."&'+ Math.random()",null,null,null,'Clique aqui para atualizar a imagem!');
		$this->setFieldType('captcha');
        $this->setImage($url);
        $this->input = new TEdit($strName,null,6,true,6);
        $this->input->setHeight(25);
        $this->input->setCss('font-size','14px');
        $this->input->setCss('font-weight','bold');
        $this->input->setProperty('autocomplete','off');
        //$this->input->setValue('');
        if(!is_null($strHint) )
        {
            $this->setHint($strHint);
        }
        $this->add($this->input);
	}
    public function getInput()
    {
        return $this->input;
    }
    public function validate()
    {
		if( strtolower($this->removeIllegalChars($this->getInput()->getValue())) != strtolower($this->removeIllegalChars($_SESSION[$this->getInput()->getId().'_code'])) )
		{
			/*$this->setError(strtolower($this->removeIllegalChars($this->getInput()->getValue())) .' e '.
			strtolower($this->removeIllegalChars($_SESSION[$this->getInput()->getId().'_code'])) );
			//'Códigos de segurança não foi digitado corretamente!');
			*/
			if( $this->getInput()->getValue() != '' )
			{
				$this->setError('digitado incorretamente!');
			}
			else
			{
				$this->setError('obrigat&oacute;rio!');
			}
		}

		return ( (string)$this->getError()==="" );
    }
}
/*$f = new TCaptcha('des_captcha',null,6,true);
$f->show();
*/
?>