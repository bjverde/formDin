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

class TFone extends TEdit
{
    /**
     * @param string  $name
     * @param string  $value
     * @param boolean $required
     */
    public function __construct($strName,$strValue=null,$boolRequired=null)
    {
        parent::__construct($strName, $strValue, 18, $boolRequired);
        $this->setFieldType('fone');
        $this->addEvent('onkeyup', 'fwFormatarTelefone(this)');
        // aplicar formatação ao exibir.
        $js = new TElement('script');
        $js->setProperty('type', "text/javascript");
        $js->add('fwFormatarTelefone(fwGetObj("'.$this->getId().'"));');
        $this->add($js);
    }
    public function getFormated()
    {

        if($this->getValue() ) {
            $value = preg_replace("/[^0-9]/", "", $this->getValue());
            // nao pode comecar com zero
            while ( substr($value, 0, 1)==="0" )
            {
                $value=substr($value, 1);
            }
            if (! $value) // nenhum valor informado
            {
                return null;
            }
            if (strlen($value) < 5 ) // não precisa formatar
            {
                return $value;
            }
            if (substr($value, 0, 4) == '0800' ) {
                print 'luis';
                $value = substr($value, 0, 4)." " . substr($value, 4, 3) . " " . substr($value, 7);
            }
            else if (strlen($value) < 8 ) {
                $value = substr($value, 0, 3).'-'.substr($value, 3);
            }
            else if (strlen($value) == 8 ) {
                $value=substr($value, 0, 4).'-'.substr($value, 4);
            }
            elseif (strlen($value)==9) {
                $value='('.substr($value, 0, 2).') '.substr($value, 2, 3).'-'.substr($value, 5);
            }
            elseif (strlen($value)==10) {
                $value='('.substr($value, 1, 2).') '.substr($value, 3, 3).'-'.substr($value, 6);
            }
            elseif (strlen($value) > 10 ) {
                $value='('.substr($value, 1, 2).') '.substr($value, 3, 4).'-'.substr($value, 7);
            }
            return $value;
        }
    }
}
//$val = new TFone('des_telefone','6234683581',50);
//$val->show();
//print '<br>'.$val->getValue();
//print '<br>'.$val->getFormated();
?>
