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


//$num = new TNumber('fnum','2.5678',10,null,6);
//echo $num->getValue();
//return;
//$strNewValue= '1,78.45';
//print 	preg_replace('/,/','',$strNewValue);

//phpinfo();
//return;
$frm = new TForm('Campo Numérico');
//$frm->setAutoSize(true);
//$frm->setColumns(array(50,100,200,200));
$frm->addNumberField('num_pessoa'			,'Qtd:',9,false,2,true,null,5,null,null,null,true,true);
$frm->addNumberField('num_peso',             'Peso Unitário',4,true,2,false)->setExampleText('Kg');
$frm->addNumberField('num_peso2',            'Peso Unitário2',9,true,2,false)->setExampleText('Kg');

//$frm->addTag('<div style="border:1px dashed red;">');
//$frm->addNumberField('val_salario'	,'Salário:',10,false,2,false);
//$frm->addNumberField('val_taxa'		,'Taxa:',10,false,4,null,null,null,null,null,null,null,null,null,null,'Informe a taxa de varição do valor');
//$frm->addSelectField('sit_cancelado','Cancelado?',null,'S=Sim,N=Não')->addEvent('onChange','alert("oi")');
//$frm->addTag('</div>');
$frm->set('num_peso','1,5');
$frm->setAction('Gravar,Testar');

if($acao=='Gravart')
{
	if( $frm->validate())
	{
		//d($_POST);
		$bvars = $frm->createBvars('num_pessoa,val_salario,val_taxa');
		//d($bvars);
		$frm->setPopUpMessage('Validação OK');
	}
}
// exibir o formulário
$frm->show();
?>
<script>
function btnTestarOnClick()
{
	//var i=145741.587987;
	//alert( i.formatMoney(2) ) ; 
	//alert( fwAddPoints(i));
	//alert( fwAddPoints('123456'));
	//alert( fwAddPoints('1234.56'));
	//alert( fwAddPoints('1234,56'));
	//alert( fwAddPoints('555,234.56'));
}
</script>
