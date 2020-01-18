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

// ============= PROJECT CONSTANTS =================//

if(!defined('ROWS_PER_PAGE') ) { define('ROWS_PER_PAGE', 20); 
}
if(!defined('ENCODINGS') ) { define('ENCODINGS', 'UTF-8'); 
}




// ============= FORMDIN FRAMEWORK CONSTANTS =================//

if(!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); 
}
if (!defined('EOL')) {
    define('EOL', "\n");
}
if (!defined('ESP')) {
    $esp = chr(32).chr(32).chr(32).chr(32);
    //define('ESP', '    ');
    define('ESP', $esp);
}
if (!defined('TAB')) {
    define('TAB', chr(9));
}


define('FORMDIN_VERSION', '4.8.1');

// --Data Base Management System
define('DBMS_ACCESS', 'ACCESS');
define('DBMS_FIREBIRD', 'FIREBIRD');
define('DBMS_MYSQL', 'MYSQL');
define('DBMS_ORACLE', 'ORACLE');
define('DBMS_POSTGRES', 'POSTGRES');
define('DBMS_SQLITE', 'SQLITE');
define('DBMS_SQLSERVER', 'SQLSERVER');

// --Type Grid
define('GRID_SIMPLE', '1');
define('GRID_SCREEN_PAGINATION', '2');
define('GRID_SQL_PAGINATION', '3');


?>
