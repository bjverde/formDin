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


define("APLICATIVO","TEST");
define("TITULO_SISTEMA","SistemaS de TesteS");
define("COR_TITULO","black");
define("FORMDINCSS","css/FormDin.css");
define('PASTA_BASE','base/');
define("DEBUG",1);
define("BANCO_TNS","desenv");
define('TIPO_ACESSO','E'); // 'I'= banco_interno ; 'E' = banco_externo

// as seguintes linhas apenas para conxÃ£o com usuÃ¡rio fixo. (TIPO_ACESSO='E')
define('AUTENTICAR_EXTERNO','MCP.PK_AUTENTICAR.AUTENTICAR'); // funÃ§Ã£o usada para autenticar usuÃ¡rio externo
define('SESSAO_TEMPO_MAX',0); // Tempo mÃ¡ximo que usuÃ¡rio pode ficar logado em segundos. 0=sem limite
define("BANCO_USUARIO","12345678909");
define("BANCO_SENHA","teste");

define("CACHE_REFRESH",86400);	// Tempo que a descricao dos cabeÃ§alhos do pacotes ficam em cache
								//segundos !! 1 hora=3600 1 dia=86400
?>

