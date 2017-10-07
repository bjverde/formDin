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

/*
$g = new TGroup('gpx','Teste AutoSize');
$g->addTextField('nome','Nome:',40,true);
$g->show();
die();
*/

$frm = new TForm('Exemplo de Grupos',600);
//$frm->setFlat(true);
$frm->addTextField('nome','Nome:',20);
	$frm->addGroupField('gpx1','Teste Novo Grupo 1')->setLabelsAlign('center');

		$frm->addTextField('nome1','Nome 1:',40,true);
		$frm->addTextField('nome2','Nome 2:',40,true);
		$frm->addTextField('nome3','Nome 3:',40,true);
		$frm->addButton('Gravar', null, 'btnGravar', 'alert(0)', null, true, false )->setAttribute( 'align', 'left' );

	$frm->closeGroup();
/**/
$pc = $frm->addPageControl('pc',220);
	$pc->addPage('Cadastro',true,true,'aba')->setLabelsAlign('center');
	$frm->addDateField('dt1','Data:');
	$frm->addGroupField('gpx2','Teste Novo Grupo 2')->setLabelsAlign('left');
		$frm->addTextField('nomeA','Nome A:',40,true);
		$frm->addTextField('nomeB','Nome B:',40,true);
		$frm->addTextField('nomeC','Nome C:',40,true);
		$frm->addRadioField('cod_sexo','Sexo:',true,array('M'=>'Masculino','F'=>'Feminino'));
		$frm->addCheckField('cod_regiao','Região:',true,array('N'=>'Norte','S'=>'Sul'));
		//$frm->addButton('Gravar', null, 'btnGravar', 'alert(0)', null, true, false );
	$frm->closeGroup();
$frm->closeGroup();


$frm->addGroupField('gpy','Grupo com outro Grupo e overflow Y',null,null,null,null,true,null,false);
	$frm->addTextField('nome','Nome:',40,true);
	$frm->addGroupField('gpw','Subgrupo');
		//$frm->addTextField('nomeG','Nome G:',40,true);
	$frm->closeGroup();
$frm->closegroup();

/**/

//$frm->setFlat(true);


/*
$frm->addGroupField('gpExemplo1','Grupo 1');
$frm->closeGroup();
*/
/*
$frm->addGroupField('gpExemplo1','Grupo 1');
$frm->closeGroup();
*/
/*
$frm->addGroupField('gpExemplo2','Grupo 2');
	$frm->addGroupField('gpExemplo2.1','Grupo 2.1');
	$frm->closeGroup();
$frm->closeGroup();
*/

/*
$frm->addGroupField('gpExemplo3','Grupo 3',50,null,null,null,true,'gpx',true);
$frm->closeGroup();
$frm->addGroupField('gpExemplo4','Grupo 4',100,null,null,null,true,'gpx');
	$frm->addTextField('nome','Nome',30);
$frm->closeGroup();
*/
//$frm->addGroupField('gpExemplo4','Grupo 4',100)->setColumns(array(80));
/*
$g = $frm->addGroupField('gpExemplo4','Grupo 4',100,null,null,null,true);
$g->setColumns(array(80));
	$frm->addTextField('nome1','Nome',30);
	$frm->addTextField('nome2','Nome',30);
	$frm->addTextField('nome3','Nome',30);
	$frm->addTextField('nome4','Nome',30);
$frm->closeGroup();
*/

$frm->setAction("Refresh,Validar Grupo,Validar Form");
$frm->setLabelsAlign( 'right');
$frm->show();
?>
<script type="text/javascript">
function btnValidar_grupoOnClick()
{
	if( ! fwValidateFields(null,'gpx2'))
	{
		return false;
	}
}
function btnValidar_formOnClick()
{
	if( ! fwValidateFields())
	{
		return false;
	}
}
</script>

