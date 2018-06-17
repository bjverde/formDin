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

/*
    Gravação da documentação via ajax
*/
$dir    = 'doc/';
if (!file_exists($dir)) {
    for ($i=1; $i<11; $i++) {
        $dir = '../'.$dir;
        if (file_exists($dir)) {
            break;
        }
    }
    
    if (!file_exists($dir)) {
        print 'Diretório para gravação dos dados ['.$dir.'] não encontrado!';
        return;
    }
}
$type   = 'db4';
$file   = 'documentacao.'.$type;
$key    = strtoupper($_REQUEST['modulo'].'_'.$_REQUEST['campo']);
$key    = md5(strtoupper($_REQUEST['modulo'].'_'.$_REQUEST['campo']));
$dbh = dba_open($dir.$file, 'c', $type) or die('Erro');
// retrieve and change values
if (!dba_replace($key, $_REQUEST['texto'], $dbh)) {
    print 'Erro de gravação!';
}
dba_close($dbh);
