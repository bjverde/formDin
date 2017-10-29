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
class TRadio extends TOption
{
    /**
    * Classe para criação de campos do tipo RadioButtons, onde apenas uma opção poderá ser selecionada
    *
    * @param string $strName
    * @param array $arrOptions
    * @param array $arrValues
    * @param boolean $boolRequired
    * @param integer $intQtdColumns
    * @param integer $intWidth
    * @param integer $intHeight
    * @param integer $intPaddingItems
    * @example RadioButtons.php
    * @return TEditRadio
    */
    public function __construct($strName,$arrOptions,$arrValues=null,$boolRequired=null,$intQtdColumns=null,$intWidth=null,$intHeight=null,$intPaddingItems=null)
    {
         parent::__construct($strName,$arrOptions,$arrValues,$boolRequired,$intQtdColumns,$intWidth,$intHeight,$intPaddingItems,false,'radio');
    }
    public function show($print=true)
    {
    	// se o controle etiver desativado, gerar um campo oculto com mesmo nome e id para não perder o post e
    	// renomear o input para "id"_disabled
    	if( ! $this->getEnabled() )
    	{
    		$value = $this->getValue();
   			$h = new THidden($this->getId());
   			if( $this->getRequired() )
   			{
   				$h->setProperty('needed','true');
			}
			if( isset($value[0] ) )
   			{
				$h->setValue($value[0]);
   			}
			$this->add($h);
		}
		return parent::show($print);
    }
}
/*
return;
for($i=0;$i<50;$i++)
{
	$arr[$i]= 'Opcao '.$i;
}
$radio = new TEditRadio('tip_bioma',$arr,null,true,10);
//$radio->setEnabled(false);

//$radio->setcss('color','red');
//$radio->setcss('font-size','18');
$radio->show();
*/
?>