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


/*$x = '(abacate,pera)';
echo '='.preg_match('/\(a\)/i',$x);
die();
*/
//echo '<pre>'; print_r($_SESSION);  echo '</pre>';
/*session_start();
session_destroy();
session_start();
*/

$frm = new TForm('Exemplo do Gride Offline',500,600);

$frm->addDateField('dat_nascimento','Data:',true);
$frm->addMemoField('obs'		,'Obs:',1000,true,20,3,true);

// subformulário com campos "offline" 1-N
$frm->addHtmlGride('campo_moeda','grid/exe_gride03_dados.php','gdx');

$frm->setAction('Gravar,Novo');

$frm->show();

$acao = isset($acao) ? $acao : '';
if($acao == 'Novo'){
	$frm->clearFields();
}else if($acao == 'Gravar'){
    print_r($_POST);
	$res = $frm->createBvars('campo_moeda,dat_nascimento');
	foreach($res as $k=>$v)	{
		d($k,'$k');
		d($v,'$v');
	}
}
?>
<script>

function gridCallBack(res)
{
	var msg='';
	if( res && res.action )
	{
		for(key in res )
		{
			msg +='<b>'+key+'</b>='+res[key]+'\n';
		}
		jAlert('A função <b>callback</b> do gride offline foi chamada recebendo o <b>$_REQUEST</b>\n\nDefinição: gridCallBack(REQUEST)\nValores:\n'+msg);
	}

}
/*
function btnGravarOnClick()
{
	fwValidateForm({"ignoreFields":"dat_nascimento"});
}
*/
</script>
