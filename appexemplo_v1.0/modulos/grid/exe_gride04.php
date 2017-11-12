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

//d($_REQUEST);
$frm= new TForm('Exemplo de Criação de Gride');
// html dentro do form
$frm->addHtmlField('campo_gride');

// quando for uma chamada ajax, devolver apenas o conteudo do gride, sem o formulário
$_REQUEST['action'] = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
if( $_REQUEST['action'] == 'atualizar_gride' ) {
	// criação do array de dados
	for( $i=0; $i<30; $i++ ){
		$res['SEQ_GRIDE'][] = ($i+1);
		$res['NOM_LINHA'][] = 'Linha nº '. (10-$i+1);
		$res['DES_LINHA'][] = $i.' - '.str_repeat('Linha ',20);
		$res['VAL_PAGO'][]  = str_pad($i,5,'0',STR_PAD_LEFT);
		$res['SIT_CANCELADO'][] = $i;
		$res['DES_AJUDA'][] = 'Ajuda - Este é o "texto" <B>que</B> será exibido quando o usuário posicionar o mouse sobre a imagem, referente a linha '.($i+1);

	}
	$gride = new TGrid( 'idGride' // id do gride
						,'Título do Gride' // titulo do gride
						,$res 		// array de dados
						,250		// altura do gride
						,null		// largura do gride
						,'SEQ_GRIDE'
						,null
						);
	$gride->addColumn('nom_linha'	,'Nome',100);
	$gride->addColumn('des_linha'	,'Descrição',800);
	$gride->addColumn('val_pago'	,'Valor',1000);
	$gride->show();
	exit(0);
}
//error_reporting(E_ALL);
$frm->set('campo_gride',''); // adiciona o objeto gride ao campo html
$frm->addButton('Ler Gride',null,'btnx','atualizar_gride()');
$frm->show();


?>
<script>
function atualizar_gride()
{
	fwGetGrid('grid/exe_gride04.php','campo_gride',{"action":"atualizar_gride"},true);
}
</script>