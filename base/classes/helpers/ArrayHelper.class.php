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
class ArrayHelper
{
    
    static function validateUndefined($array,$atributeName) 
    {
        if(!isset($array[$atributeName])) {
            $array[$atributeName]=null;
        }
        return is_null($array[$atributeName])?null:trim($array[$atributeName]);
    }
    
    /**
     * Similar to array_key_exists. But it does not generate an error message
     *
     * Semelhante ao array_key_exists. Mas não gera mensagem de erro
     *
     * @param  string $atributeName
     * @param  array  $array
     * @return boolean
     */
    static function has($atributeName,$array) 
    {
        $value = false;
        if (is_array($array) && array_key_exists($atributeName, $array)) {
            $value = true;
        }
        return $value;
    }
    
    /***
     *
     * @param array  $array
     * @param string $atributeName
     * @param mixed  $DefaultValue
     * @return mixed
     */
    static function getDefaultValeu($array,$atributeName,$DefaultValue) 
    {
        $value = $DefaultValue;
        if(self::has($atributeName, $array) ) {
            if(isset($array[$atributeName]) && ($array[$atributeName]<>'') ) {
                $value = $array[$atributeName];
            }
        }
        return $value;
    }
    
    static function get($array,$atributeName) 
    {
        $result = self::getDefaultValeu($array, $atributeName, null);
        return $result;
    }
    
    /**
     * Convert Array PDO Format to FormDin format
     *
     * @param  array $array
     * @return array
     */
    static function convertArrayPdo2FormDin($dataArray,$upperCase = true) 
    {
        $result = false;
        if(is_array($dataArray) ) {
            foreach( $dataArray as $k => $arr ) {
                foreach( $arr as $fieldName => $value ) {
                    if($upperCase) {
                        $result[ strtoupper($fieldName) ][ $k ] = $value;
                    }else{
                        $result[ $fieldName ][ $k ] = $value;
                    }
                }
            }
        }
        return $result;
    }
}
?>
