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
class ValidateHelper
{
    
    
    public static function methodLine($method,$line,$nameMethodValidate)
    {
        if( empty($method) ){
            throw new InvalidArgumentException(TMessage::ERROR_EMPTY_INPUT.' variable method is null. '.$nameMethodValidate);
        }
        if( empty($line) ){
            throw new InvalidArgumentException(TMessage::ERROR_EMPTY_INPUT.' variable line is null. '.$nameMethodValidate);
        }
    }
    
    public static function isNumeric($id,$method,$line)
    {
        self::methodLine($method, $line, __METHOD__);
        if( empty($id) || !is_numeric($id) ){
            throw new InvalidArgumentException(TMessage::ERROR_TYPE_NOT_INT.'See the method: '.$method.' in the line: '.$line);
        }
    }
    
    public static function isSet($variable,$method,$line)
    {
        self::methodLine($method, $line, __METHOD__);
        if( is_null($variable) ){
            throw new InvalidArgumentException(TMessage::ERROR_TYPE_NOT_SET.'See the method: '.$method.' in the line: '.$line);
        }
    }
    
    /**
     * Validade is array and not empty
     * @param array $array
     * @param string $method __METHOD__
     * @param string $line __LINE__
     * @throws InvalidArgumentException
     * @return void
     */
    public static function isArray($array,$method,$line)
    {
        self::methodLine($method, $line, __METHOD__);
        if( empty($array) || !is_array($array) ){
            throw new InvalidArgumentException(TMessage::ERROR_TYPE_NOT_ARRAY.'See the method: '.$method.' in the line: '.$line);
        }
    }
    
    //--------------------------------------------------------------------------------
    /**
     * Validate Object Type is Instance Of TPDOConnectionObj
     *
     * @param object $tpdo instanceof TPDOConnectionObj
     * @param string $method __METHOD__
     * @param string $line __LINE__
     * @throws InvalidArgumentException
     * @return void
     */
    public static function objTypeTPDOConnectionObj($tpdo,$method,$line)
    {
        self::methodLine($method, $line, __METHOD__);
        $typeObjWrong = !($tpdo instanceof TPDOConnectionObj);
        if( !is_null($tpdo) && $typeObjWrong ){
            throw new InvalidArgumentException('Informed class is not an instance of TPDOConnectionObj. See the method: '.$method.' in the line: '.$line);
        }
    }
}
?>
