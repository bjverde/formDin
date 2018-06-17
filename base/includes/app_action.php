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

if (!session_id()) {
    session_start();
}
$acao =  $_REQUEST['app_action'];
switch ($acao) {
    case 'clearCache':
    case 'limparCache':
        if (file_exists('base/cache')) {
            if ($GLOBALS['conexao']) {
                $GLOBALS['conexao']->limparCache();
                echo 'alert("Diretório base/cache limpo com sucesso!")';
            }
        }
        break;
    //-------------------------------------------------------------------------------------
    case "unsetSessionModule":
    case "unsetModuloSessao":
        $_SESSION[APLICATIVO]['modulo']='';
        unset($_SESSION[APLICATIVO]['modulo']);
        break;
    //--------------------------------------------------------------------
    case "setSessionModule":
    case "setModuloSessao":
        $_SESSION[APLICATIVO]['modulo']=$_REQUEST['modulo'];
        break;
    //--------------------------------------------------------------------
    case "logout":
        /*
        $_SESSION[APLICATIVO]["conectado"]=false;
        $_SESSION['num_pessoa']=null;
        $_SESSION['num_cpf']=null;
        $_SESSION['APLICATIVO']=null; // para classe banco gravar sisreg.funcionario_sessão.
        $_SESSION[APLICATIVO]=null;
        $_SESSION['conexao']=null;
        unset($_SESSION[APLICATIVO]);
        */
        session_start();
        if (defined('APLICATIVO')) {
            $_SESSION[APLICATIVO]["conectado"]=false;
            $_SESSION[APLICATIVO]=null;
        } else {
            session_destroy();
            session_start();
            //echo 'alert("Sessão encerrada")';
        }
        
        break;
}
