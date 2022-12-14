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
 * Classe que faz varias transformações de data e hora
 *
 * @author reinaldo.junior
 */
class StringHelper
{

    /**
     * Evita problemas com PHP 8.1
     *
     * @param string $inputString
     * @return string|null
     */
    public static function strlen($inputString) 
    {
        $outputString    = 0;
        if( isset($inputString) ){
            $outputString = strlen($inputString);
        }
        return $outputString;
    }

    /**
     * Evita problemas com PHP 8.1
     *
     * @param string $inputString
     * @return string|null
     */
    public static function strtolower($inputString) 
    {
        $outputString    = null;
        if( isset($inputString) ){
            $outputString = mb_strtolower($inputString);
        }
        return $outputString;
    }    
    public static function strtolower_utf8($inputString) 
    {
        $string = self::strtolower($inputString);
        return  $string;
    }
    
    /**
     * Evita problemas com PHP 8.1
     *
     * @param string $inputString
     * @return string|null
     */
    public static function strtoupper($inputString) 
    {
        $outputString    = null;
        if( isset($inputString) ){
            $outputString = mb_strtoupper($inputString);
        }
        return $outputString;
    }
    public static function strtoupper_utf8($string)
    {
        $string = self::strtoupper($string);
        return $string;
    }
    
    /***
     * Checks if text is different from UTF8 and converts to UTF-8
     * @param string $string
     * @return string
     */
    public static function str2utf8($string)
    {
        if ( mb_detect_encoding($string, 'UTF-8', true)!='UTF-8' ){
            //$string= iconv('ISO-8859-1', 'UTF-8', $string);
            $string = utf8_encode($string);
            //$string = mb_convert_encoding($string, 'UTF-8');
        }
        return $string;
    }

    /**
     * Tranforma um string UTF8 para ASCII, criada para melhorar compatibilidade com PHP 8.2
     *
     * @param string $string
     * @return string
     */
    public static function utf8_decode($string)
    {
        $string = self::convert_encoding($string,'ISO-8859-1','UTF-8');
        return $string;
    }    
    
    /**
     * Converte uma string com enconding destino e enconding de origem
     * @param string $string        1: string que devera ser convertida
     * @param string $to_encoding   2: encoding de destino
     * @param string $from_encoding 3: encoding de origem
     * @return string
     */
    public static function convert_encoding($string,$to_encoding='UTF-8',$from_encoding='ASCII')
    {
        if( !empty($string) ){
            if ( mb_detect_encoding($string, $to_encoding, true)!=$to_encoding ){
                $string = mb_convert_encoding($string,$to_encoding,$from_encoding);
            }
        }
        return $string;
    }

    /**
     * Recebe uma string e formata com CPF ou CNPJ
     * https://gist.github.com/davidalves1/3c98ef866bad4aba3987e7671e404c1e
     * @param string $value
     * @return string
     */
    public static function formatCnpjCpf($value){
        $cnpj_cpf = self::limpaCnpjCpf($value);
        $tamanho  = StringHelper::strlen($cnpj_cpf);
        if ($tamanho === 11) {
            $value = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        } else if($tamanho === 14){
            $value = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
        }
        return $value;
    }

    public static function limpaCnpjCpf($value){
        $limpo = preg_replace("/\D/", '', $value);
        return $limpo;
    }

	public static function validarCpf($value){
		$dv 		= false;
		$cpf 		= self::limpaCnpjCpf($value);
		if($cpf=='') {
			return false;
		}

		$cpf_dv 	= substr($cpf,-2);
		$controle 	= '';
		// evitar sequencias de número. Ex:11111111111
		for ( $i = 0; $i < 10; $i++ ) {
			if( $cpf == str_repeat($i,11)){
				$cpf_dv = '99'; // causar erro de validação
				break;
			}
		}

        $digito = null;
		for ( $i = 0; $i < 2; $i++ ) {
			$soma = 0;
			for ( $j = 0; $j < 9; $j++ )
			$soma += substr($cpf,$j,1)*(10+$i-$j);
			if ( $i == 1 ) $soma += $digito * 2;
			$digito = ($soma * 10) % 11;
			if ( $digito == 10 ) $digito = 0;
			$controle .= $digito;
		}

		if ( $controle != $cpf_dv ){
		    return false;
		}
		return true;
	}    

    /**
     * Recebe uma string e formata o numero telefone em dos 4 formatos
     * (61) 91234-5678
     * (61) 1234-5678
     * 91234-5678
     * 1234-5678
     * @param string $value
     * @return string
     */
    public static function formatPhoneNumber($value) 
    {
        $cnpj_cpf = self::limpaCnpjCpf($value);
        $tamanho  = StringHelper::strlen($cnpj_cpf);
        if ($tamanho === 11) {
            $value = preg_replace("/(\d{2})(\d{5})(\d{4})/", "(\$1) \$2-\$3", $cnpj_cpf);
        } else if($tamanho === 10){
            $value = preg_replace("/(\d{2})(\d{4})(\d{4})/", "(\$1) \$2-\$3", $cnpj_cpf);
        } else if($tamanho === 9){
            $value = preg_replace("/(\d{5})(\d{4})/", "\$1-\$2", $cnpj_cpf);
        } else if($tamanho === 8){
            $value = preg_replace("/(\d{4})(\d{4})/", "\$1-\$2", $cnpj_cpf);
        }
        return $value;
    }
    
    /**
     * Troca caracteres acentuados por não acentudos.
     * Recebe uma string do tipo "olá ação à mim!" e retona "ola acao a mim!"
     * https://pt.stackoverflow.com/questions/49645/remover-acentos-de-uma-string-em-phps
     * https://pt.stackoverflow.com/questions/858/refatora%c3%a7%c3%a3o-de-fun%c3%a7%c3%a3o-para-remover-pontua%c3%a7%c3%a3o-espa%c3%a7os-e-caracteres-especiais
     * https://stackoverflow.com/questions/13614622/transliterate-any-convertible-utf8-char-into-ascii-equivalent
     * @param string $string
     * @return string
     */
    public static function tirarAcentos_old($string) 
    {
        $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
        $string = self::removeCaracteresEspeciais($string);
        return $string;
    }

    /**
     * Troca caracteres acentuados por não acentudos
     * Recebe uma string do tipo "olá ação à mim!" e retona "ola acao a mim!"
     * http://blog.dbins.com.br/removendo-acentos-e-caracteres-especiais-com-php
     *
     * @param string $string
     * @return string
     */
    public static function tirarAcentos($string) 
    {
        $comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú');
        $semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U');
        $string= str_replace($comAcentos, $semAcentos, $string);
        return $string;
    }

    /**
     * Recebe uma string remove tudo que não faz partes das palavras Brasileira
     * e espaços em branco
     * @param string $string
     * @return string
     */
    public static function removeCaracteresEspeciais($string) 
    {
        $string = preg_replace('/[^a-zA-Z0-9\sÀÁÃÂÉÊÍÓÕÔÚÜÇÑàáãâéêíóõôúüçñ]/', '', $string);        
        return $string;
    }

    /**
     * Recebe uma string remove espaços em branco
     * @param string $string
     * @return string
     */
    public static function removeEspacoBranco($string) 
    {
        $string = preg_replace('/[\s]/', '', $string);
        return $string;
    }

    /**
     * Recebe uma string "minha string"e converte para o formato PascalCase
     * "MinhaString"
     * https://medium.com/better-programming/string-case-styles-camel-pascal-snake-and-kebab-case-981407998841
     *
     * @param string $string
     * @return string
     */
    public static function string2PascalCase($string) 
    {
        $string = self::tirarAcentos($string);
        $string = mb_convert_case ( $string, MB_CASE_TITLE );
        $string = self::removeEspacoBranco($string);
        return $string;
    }

    /**
     * Recebe uma string "minha string"e converte para o formato CamelCase
     * "minhaString"
     * https://medium.com/better-programming/string-case-styles-camel-pascal-snake-and-kebab-case-981407998841
     *
     * @param string $string
     * @return string
     */
    public static function string2CamelCase($string) 
    {
        $string = self::string2PascalCase($string);
        $string = lcfirst($string);
        return $string;
    }

    /**
     * Recebe uma string "minha string"e converte para o formato KebabCase
     * "minha-string"
     * https://medium.com/better-programming/string-case-styles-camel-pascal-snake-and-kebab-case-981407998841
     *
     * @param string $string
     * @return string
     */
    public static function string2KebabCase($string) 
    {
        $string = self::removeCaracteresEspeciais($string);
        $string = self::tirarAcentos($string);
        $string = mb_convert_case ( $string,  MB_CASE_LOWER );
        $string = preg_replace('/[\s]/', '-', $string);
        return $string;
    }

    /**
     * Recebe uma string "minha string"e converte para o formato SnakeCase
     * "minha_string"
     * https://medium.com/better-programming/string-case-styles-camel-pascal-snake-and-kebab-case-981407998841
     *
     * @param string $string
     * @return string
     */
    public static function string2SnakeCase($string) 
    {
        $string = self::string2KebabCase($string);
        $string = preg_replace('/[-]/', '_', $string);
        return $string;
    }

}
