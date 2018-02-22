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
 * @author reinaldo.junior        
 */
class DateTimeHelper {
    const DEFAULT_TIME_ZONE = 'America/Sao_Paulo';
    
    /**
     * Getter para criar uma inst�ncia de um objeto do tipo DateTime.
     * @return DateTime
     */
    public static function getCurrentDateTime() {
        $dateTime = new DateTime();
        $dateTime->setTimezone(new DateTimeZone(self::DEFAULT_TIME_ZONE));
        
        return $dateTime;
    }
    
    /**
     *  Retorn Data e hora no formato 'Y-m-d H:i:s'
     * @return string 'Y-m-d H:i:s'
     */
    public static function getNow() {
        $dateTime = self::getCurrentDateTime();
        $retorno = $dateTime->format('Y-m-d H:i:s');
        return $retorno;
    }    
    
    /**
     * Converter data no formato dd/mm/yyyy para yyyy-mm-dd
     * @param string $dateSql
     * @return string
     */
    public static function date2Mysql($dateSql){
        $retorno = null;
        if(isset($dateSql) && ($dateSql<>'') ){
            $ano= substr($dateSql, 6);
            $mes= substr($dateSql, 3,-5);
            $dia= substr($dateSql, 0,-8);
            $retorno = $ano."-".$mes."-".$dia;
        }
        return $retorno;
    }
    
}