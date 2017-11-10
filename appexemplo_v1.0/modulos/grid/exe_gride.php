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

$frm = new TForm('Gride',600);
$frm->addJavascript('init()');
$frm->addHiddenField('num_pessoa',22);
$frm->addSelectField('cod_uf','Estado:');
$gride = new TGrid('gd7','Gride Nº 7','UF',250,null,'COD_UF');
$gride->setcss('font-size','10px');
$gride->addExcelHeadField('Estado:','cod_uf');
$gride->autoCreateColumns();

$frm->addHtmlField('campo_gride4','Clique no botão Criar Gride 4 Abaixo',null,null,null,300,false);

// alterar a fonte do titulo do gride
$gride->getTitleCell()->setCss('font-size',20);

// recuperar o objeto coluna NOM_UF
$c = $gride->getColumn('NOM_UF');
//$c->setcss('font-size','14');

// recuperar o objeto heade do objeto coluna NOM_UF
//$h = $c->getHeader();
//$h->setCss('background-color','red');
//$h->setCss('font-size','14');


$gride->addSelectColumn('seq_fruta','Fruta','seq_fruta','fruta',null,null,null,null,'SEQ_FRUTA','NOM_FRUTA');
$gride->setCache(-1);
$gride->autoCreateColumns();
$frm->addHtmlField('campo_gride7',$gride);

$frm->addButton('Criar Gride 4',null,'btnCriarGride4','fwGetGrid("modulos/grid/exe_gride04_anexos.php","campo_gride4",{"num_pessoa":""});');
$frm->show();
?>
<script>
function init() {
    alert( 'o');
	fwGetGrid("modulos/grid/exe_gride04_anexos.php","campo_gride4",{"seq_propriedade":""});
}
function callBackAnexar(tempName,fileName,type,size)
{
	jQuery('#arquivo').val(fileName);
	jQuery('#local').val(tempName);
	jQuery('#tamanho').val(size);
	jQuery('#tipo').val(type);
	//alert('Função de callback.\n\nTemp name:'+tempName+'\nFile name:'+fileName+'\nType:'+type+'\nSize?'+size);
	if( confirm('Visualizar o arquivo anexado ?')) {
		fwShowTempFile(tempName,type,fileName);
	}
	jQuery.post(app_index_file,{'modulo':'modulos/grid/exe_gride.php','formDinAcao':'gravar_anexo'},function()
	{
		alert( 'atualizar o gride');
	});

}
</script>


