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
require_once __DIR__.'/../callbacks/autocomplete_functions.php';

use PHPUnit\Framework\TestCase;
/**
 * GetHelper test case.
 */
class Autocomplete_functionsTest extends TestCase
{
	public function testTableRecoverCreateSql_boolSearchAnyPositionFALSE() {
		$_REQUEST['q'] = 'x';
        $bvars = null;
        $boolSearchAnyPosition = false;
        $arrUpdateFields = null;
        $strSearchField = 'nome_camplo_coluna';
        $strTablePackageFuncion = 'table_sys';
      
        $esperado = 'select nome_camplo_coluna from table_sys where upper(nome_camplo_coluna) like upper(\'x%\') order by nome_camplo_coluna';
        
        $retorno = tableRecoverCreateSql($bvars, $boolSearchAnyPosition, $arrUpdateFields, $strSearchField, $strTablePackageFuncion,true);
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testTableRecoverCreateSql_boolSearchAnyPositionTRUE() {
    	$_REQUEST['q'] = 'x';
    	$bvars = null;
    	$boolSearchAnyPosition = true;
    	$arrUpdateFields = null;
    	$strSearchField = 'nome_camplo_coluna';
    	$strTablePackageFuncion = 'table_sys';
    	
    	$esperado = 'select nome_camplo_coluna from table_sys where upper(nome_camplo_coluna) like upper(\'%x%\') order by nome_camplo_coluna';
    	
    	$retorno = tableRecoverCreateSql($bvars, $boolSearchAnyPosition, $arrUpdateFields, $strSearchField, $strTablePackageFuncion,true);
    	
    	$this->assertEquals($esperado, $retorno);
    }
    
}