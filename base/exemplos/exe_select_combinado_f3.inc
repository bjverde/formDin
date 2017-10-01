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

$arrCampos['cod_uf'] 			= new camposelect('cod_uf','Uf:');
$arrCampos['cod_municipio'] 	= new camposelect('cod_municipio','Municipio:',null,null,null,null,null,null,null,null,null,null,null,null,null,null,5);
$arrCampos['cod_bairro']	 	= new camposelect('cod_bairro','Bairro:');
$frm = new FormDin3($arrCampos,'Teste Select Combinado',$_POST);

$frm->combinarSelects('cod_uf'			,'cod_municipio',null,'TESTE.PKG_TESTE.SEL_MUNICIPIO'	,'COD_UF'		,'COD_MUNICIPIO','NOM_MUNICIPIO');  
//$frm->combinarSelects('cod_municipio'	,'cod_bairro'	,null,'TESTE.PKG_TESTE.SEL_BAIRRO'		,'COD_MUNICIPIO','COD_BAIRRO'	,'NOM_BAIRRO');  
/*
$frm->disableFields();
$frm->setValue('cod_municipio','1200203');
$frm->setValue('cod_bairro'	,'1200203001');
*/
$frm->preencherUf('cod_uf');
//$frm->set('cod_uf',12);
//$frm->set('cod_municipio','1200203');
//$frm->set('cod_bairro','1200203001');

//$frm->protegerCampos('cod_uf,cod_municipio,cod_bairro');
//$frm->protegerCampos('cod_municipio');
$frm->botaoAcao['']  = array('Gravar','Limpar');
echo $frm->criarForm();
?>
