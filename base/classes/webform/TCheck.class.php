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

class TCheck extends TOption
{
    /**
    * Classe para criação de campos do tipo Checkbox, onde uma ou várias opções poderão ser selecinadas;
    *
    *<code>
    * <?php
    * $check = new TCheck('tip_bioma',array(1=>'Cerrado',2=>'Pantanal'),null,true,2);
    * $check->show();
    * ?>
    *</code>
    *
    * @param string $strName
    * @param array $arrOptions
    * @param array $arrValues
    * @param boolean $boolRequired
    * @param integer $intQtdColumns
    * @param integer $intWidth
    * @param integer $intHeight
    * @param integer $intPaddingItems
    * @return TCheck
    */
    public function __construct($strName,$arrOptions,$arrValues=null,$boolRequired=null,$intQtdColumns=null,$intWidth=null,$intHeight=null,$intPaddingItems=null)
    {
    	// no nome do campo check não precisa passar []
		$strName = $this->removeIllegalChars($strName);
		parent::__construct($strName,$arrOptions,$arrValues,$boolRequired,$intQtdColumns,$intWidth,$intHeight,$intPaddingItems,true,'check');

    }
    /**
     * Exibe html ou retorna o html se $print for false
     * se $boolShowOnlyInput for true, será retornada somente a tag input do campo
     *
     * @param boolean $print
     * @param boolean $boolShowOnlyInput
     * @return string
     */
    public function show($print=true)
    {
    	// se o campo check estiver sem nenhuma opção, inicializar com a opção S
    	if( !$this->getOptions())
    	{
			$this->setOptions(array('S'=>''));
			$this->setcss('border','none');
    	}
    	// se o controle etiver desativado, gerar um campo oculto com mesmo nome e id para não perder o post e
    	// renomear o input para "id"_disabled
    	if( ! $this->getEnabled() )
    	{
    		foreach ($this->getValue() as $k=>$v)
			{
				$h = new THidden($this->getId().'[]');
				$h->setValue($v);
				$this->add($h);
			}
		}
		return parent::show($print);
    }
}
/*
$res['SEQ_PERFIL'][0] = 1;
$res['DES_PERFIL'][0] = 'Administrador';
$res['SEQ_PERFIL'][1] = 2;
$res['DES_PERFIL'][1] = 'Desenvolvedor';
$res['SEQ_PERFIL'][3] = 3;
$res['DES_PERFIL'][3] = 'Analista';
$res['SEQ_PERFIL'][4] = 4;
$res['DES_PERFIL'][4] = 'Programador';
*/
/*
$radio = new TCheck('sit_publico',$res,null,null,2);
$radio->show();
RETURN;
*/

/*
$frm = new TForm('Campo Check');
$frm->addCheckField('seq_perfil','Perfil:',false,$res,true,false,null,2);
$frm->show();
*/
/*
//$_POST['tip_bioma'][]=2;
for($i=0;$i<10;$i++)
{
	$arr[$i]= 'Opcao '.$i;
}
$radio = new TCheck('tip_bioma',$arr,null,true,2);
print '<form name="formdin" action="" method="POST">';
//$radio->setEnabled(false);
$radio->show();
print '<hr>';
print '<input type="submit" value="Gravar">';
print '</form>';
print_r($_POST);
*/

/*
print '<form name="formdin" action="" method="POST">';
$radio = new TCheck('tip_bioma',array(1=>'Cerrado',2=>'Pantanal'),null,true,2);
$radio->show();
print '<hr>';
print '<input type="submit" value="Gravar">';
print '</form>';
print_r($_POST);
 */
?>