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
 * Este programa é distribuí1do na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licen?a Pública Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

$frm = new TForm('Exemplo de Ajax usando Semáforo', 400, 600);

$frm->addTextField('id_semaforo','ID semáforo:',20,true,20,'semaforo_1',null,'Informe uma string para identificar o semaforo')->add('<span id="imagem"></span>');

$frm->addHtmlField('msg', '<p>Ao fazer uma requisição Ajax com semáforo, o semáforo fica "fechado" até que a chamada retorne.<BR />
						   Uma nova chamada com o mesmo semáforo só é realizada se o semáforo estiver aberto.<BR />
						   Utilizando a função javascript "fwSemaphoreIsOpen(idSemaphore)" é possível verifiar se o semáforo está aberto ou fecahdo.</p>')->setcss('font-size','12px');

$frm->addButton('Chamar ajax com Semáforo', null, 'btnAjax', 'chamarAjax()');
$frm->addButton('Verificar Semáforo', null, 'btnVerfificar', 'verificarSemaforo()');

$acao = isset($acao) ? $acao : null;
if( $acao == 'ajax_lento') {
	sleep(20);
	echo 'Voltei depois de 20 segundos!';
}
$frm->setAction('Atualizar');
$frm->show();

?>


<script>
function chamarAjax()
{
	var id = jQuery('#id_semaforo').val();
	if( ! fwSemaphoreIsOpen( id ) )
	{
		jAlert('Esta ação já esta sendo executada');
		return;
	}
	var chamada = fwAjaxRequest({
		'action':'ajax_lento',
		'async':true,
		'dataType':'text',
		'semaphore': id,
		'semaphoreTimeout':10000,
		'containerId':'imagem',
		'msgLoading':fw_img_processando1,
		'callback':function(res) {
			fwAlert('Requisição com semáforo "' + id + '" retornada!\n\nMensagem de retorno:\n' + res);
		}
	});
	fwAlert(chamada !== false? 'Requisição Ajax chamada com o semáforo "' + id + '"': 'Requisição Ajax NÃO foi chamada pois o semáforo "' + id + '" está FECHADO!');
}

function verificarSemaforo() {
	var id = jQuery('#id_semaforo').val();
	var status = fwSemaphoreIsOpen(id);
	fwAlert('Semáforo "' + id + '" está ' + (status ? 'ABERTO' : 'FECHADO') );
}
</script>
