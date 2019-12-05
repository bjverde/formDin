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

$path =  __DIR__.'/../../../classes/';
require_once $path.'constants.php';
require_once $path.'helpers/autoload_formdin_helper.php';

use PHPUnit\Framework\TestCase;

/**
 * paginationSQLHelper test case.
 */
class StringHelperTest extends TestCase
{
    const STRING_ORIGIN = 'Você deve ter recebido uma cópia da GNU LGPL versão 3';
	
    public function testStr2utf8_notUtf8ISO88591() {
        $str = self::STRING_ORIGIN;
		$str = mb_convert_encoding($str, "ISO-8859-1");
		$str = StringHelper::str2utf8($str);
		$result = mb_detect_encoding($str, 'UTF-8', true);
		
		$this->assertEquals( self::STRING_ORIGIN ,$str);		
		$this->assertEquals( 'UTF-8' , $result);
	}
	
	public function testStr2utf8_notUtf8CP1252() {
	    $str = self::STRING_ORIGIN;
	    $str = mb_convert_encoding($str, "Windows-1252");
	    $str = StringHelper::str2utf8($str);
	    $result = mb_detect_encoding($str, 'UTF-8', true);
	    
	    $this->assertEquals( self::STRING_ORIGIN ,$str);
	    $this->assertEquals( 'UTF-8' , $result);
	}
	
	/*
	public function testStr2utf8_notUtf8CP850() {
	    $str = self::STRING_ORIGIN;
	    $str = mb_convert_encoding($str, "CP850");
	    $str = StringHelper::str2utf8($str);
	    $result = mb_detect_encoding($str, 'UTF-8', true);
	    
	    $this->assertEquals( self::STRING_ORIGIN ,$str);
	    $this->assertEquals( 'UTF-8' , $result);
	}
	*/
	
	public function testStr2utf8_Decode() {
	    $str = self::STRING_ORIGIN;
	    $str = utf8_decode($str);
	    $str = StringHelper::str2utf8($str);
	    $result = mb_detect_encoding($str, 'UTF-8', true);
	    
	    $this->assertEquals( self::STRING_ORIGIN ,$str);
	    $this->assertEquals( 'UTF-8' , $result);
	}
}