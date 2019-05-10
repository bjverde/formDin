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


 
/***
 * This TPDOConnectionObj class is just a possible improvement of the TPDOConnection class.
 * The TPDOConnection class makes use of many static methods which
 * Do unit tests. Moreover, this change does not cause backwards compatibility problem.
 * 
 * 
 * Essa classe TPDOConnectionObj é apenas uma possível melhoria da classe TPDOConnection.
 * A classe TPDOConnection faz uso de muitos metodos estaticos o que ficulta na hora de
 * fazer testes unitarios. Alem disso esse mudança não gera problema de retro compatibilidade. 
 */
class TPDOConnectionObj
{

    private $TPDOConnection = null;
    
    public function __construct() {
        $tpdo = New TPDOConnection();
        $tpdo::connect(null,true,null,null);
        $this->setTPDOConnection($tpdo);
    }
    //--------------------------------------------------------------------------------------    
    public function getTPDOConnection()
    {
        return $this->TPDOConnection;
    }
    public function setTPDOConnection($TPDOConnection)
    {
        $this->TPDOConnection = $TPDOConnection;
    }
    //--------------------------------------------------------------------------------------
    public static function getDBMS() {
        return  $this->TPDOConnection::getDBMS();
    }
    public function setDBMS( $banco = null ) {
        $this->TPDOConnection::setBanco($banco);
    }
    //--------------------------------------------------------------------------------------
    public function getHost() {
        return $this->TPDOConnection::getHost();
    }
    public function setHost($host) {
        $this->TPDOConnection::setHost($host);
    }
    //--------------------------------------------------------------------------------------
    public function connect( $configFile = null, $boolRequired = true, $boolUtfDecode = null, $configArray = null )
    {
        $tpdo = $this->getTPDOConnection();
        $tpdo::connect($configFile,$boolRequired,$boolUtfDecode,$configArray);
    }
    //--------------------------------------------------------------------------------------
    public function executeSql($sql, $arrParams = null)
    {
        $tpdo = $this->getTPDOConnection();
        $result = $tpdo::executeSql($sql,$arrParams);
        return $result;
    }
}
?>