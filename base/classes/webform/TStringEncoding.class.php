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

/**
 * This class centralizes the encoding type detection and conversion. It is dependent on the mbstring module
 * 
 * Esse classe centraliza a detecção e conversão do tipo codificação do texto (encoding). É dependente do modulo mbstring e iconv
 * 
 * http://php.net/manual/pt_BR/mbstring.supported-encodings.php
 * https://stackoverflow.com/questions/8233517/what-is-the-difference-between-iconv-and-mb-convert-encoding-in-php
 * 
 * @author bjverte
 *
 */
class TStringEncoding {

	/**
	 * 
	 * @param string $string
	 */
	public static function convert2Utf8 ($string){
		$target_encoding = "UTF-8";
		$enconding = mb_detect_encoding ($string);
		$result = $string;
		if($enconding != "UTF-8"){
			//$result = mb_convert_encoding($target_encoding, $enconding,$string);
			$result = iconv ($enconding,$target_encoding,$string);
		}
		return $result;
	}
	
	
	public static function convert2Iso8859_1($string){
		$target_encoding = "ISO-8859-1";
		$enconding = mb_detect_encoding ($string);
		$result = $string;
		if($enconding != "ISO-8859-1"){
			//$result = mb_convert_encoding($target_encoding, $enconding,$string);
			$result = iconv ($enconding,$target_encoding,$string);
		}
		return $result;
	}
	
}