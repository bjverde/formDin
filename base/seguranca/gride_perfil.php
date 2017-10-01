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

$bvars = array('SEQ_PROJETO'=>PROJETO);
print_r(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_PERFIL_PROJETO',$bvars,$res));
$gride = new TGrid('gd'
	,'Perfís Cadastrados'
	,$res
	,null
	,'100%'
	,'SEQ_PERFIL'
	,'SEQ_PERFIL'
	);
$gride->addColumn('DES_PERFIL'	,'Perfil',300);
$gride->addColumn('NUM_NIVEL'	,'Nível',100);

/*	
// criar o gride com os projetos cadastrados
$frm->set('gride_perfil','<br>'.criarGride('gride_perfil'
									,null
									,$res
									,null
									,null
									,'SEQ_PERFIL'
									,'DES_PERFIL|PERFIL,NUM_NIVEL|NÍVEL,CALC_SIT_PUBLICO|PÚBLICO,CALC_SIT_CANCELADO|CANCELADO'
									,null
									,null
									,null
									,null
									,null
									,null
									,null
									,'Nenhum perfil cadastrado'
									,null
									,'COR_FUNDO||$nl%2!=0|#efefef
									,ALINHAMENTO_TEXTO|||CENTER
									,ALINHAMENTO_TEXTO|DES_PERFIL||LEFT
									,COR_FONTE||$res["SIT_CANCELADO"][$k]=="S"|gray
									,LARGURA|DES_PERFIL||350'
									,null,null,false
									)
								);
 */
$gride->show();
?>

