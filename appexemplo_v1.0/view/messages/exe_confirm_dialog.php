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

d($_REQUEST);
$frm = new TForm('Exemplo de Caixa de Confirmação',200,500);

$frm->addTextField('field5', 'Resultado do Confirma5',40);

$frm->addButton('Confirmar',null,'btnConfirmar','fwConfirm("Tem certeza ?","confirmSim","confirmNao")');
$frm->addButton('Confirmar 2',null,'btnConfirmar2','fwConfirm("Tem certeza ?",confirmSim)');
$frm->addButton('Confirmar 3',null,'btnConfirmar3','fwConfirm("O que deseja fazer?",confirmSim,confirmNao,"Repetir o Cadasro","Repetir a Consulta","Tome uma decisão")');
$frm->addButton('Confirmar 4',null,'btnConfirmar3','fwConfirm("O que deseja fazer?",confirmSim,confirmNao,"Repetir o Cadasro","Repetir a Consulta","Tome uma decisão")');
$frm->addButton('Confirmar 5 - submit','btn05',null,null,'Quer submeter essa pagina e evitar JavaScript explicito? ');
$frm->addButton('Limpar'    , null, 'Limpar');

$acao = isset($acao) ? $acao : null;
switch( $acao ) {
	case 'btn05':
		$frm->setFieldValue('field5','Você falou SIM !! :-) ');
	break;
	//--------------------------------------------------------------------------------
	case 'Limpar':
		$frm->clearFields(null);
	break;
	//--------------------------------------------------------------------------------
}

$frm->show();
?>
<script>
function confirmSim() {
	alert('sim');
}
function confirmNao() {
	alert('nao');
}
</script>
