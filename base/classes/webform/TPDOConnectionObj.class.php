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

    private $tpdo = null;
    
    public function __construct($connect = true)
    {
        $tpdo = New TPDOConnection();
        //$configArray = $this->getFakeConnectionArray();
        if( $connect ){
            $tpdo::connect(null,true,null,null);
        }
        $this->setTPDOConnection($tpdo);
    }    
    private function getFakeConnectionArray(){
        $configArray= array(
             'DBMS' => DBMS_MYSQL
            ,'PORT' => null
            ,'HOST' => 'locahost'
            ,'DATABASE' => 'fake'
            ,'USERNAME' => 'fake'
            ,'PASSWORD' => 'fake'
        );
        return $configArray;
    }
    //--------------------------------------------------------------------------------------    
    public function getTPDOConnection()
    {
        return $this->tpdo;
    }
    public function setTPDOConnection($TPDOConnection)
    {
        $this->tpdo = $TPDOConnection;
    }
    //--------------------------------------------------------------------------------------
    /**
     * Gera o Array de configuração com base nos atributos dos metodos
     * @return array
     */
    public function makeConfigArray(){
        $configArray = null;
        $hasDBMS = FormDinHelper::issetOrNotZero($this->getDBMS());
        $hasDBas = FormDinHelper::issetOrNotZero($this->getDataBaseName());
        if($hasDBMS && $hasDBas){
            $configArray= array(
                'DBMS' => $this->getDBMS()
                ,'PORT' => $this->getPort()
                ,'HOST' => $this->getHost()
                ,'DATABASE' => $this->getDataBaseName()
                ,'USERNAME' => $this->getUsername()
                ,'PASSWORD' => $this->getPassword()
            );
        }
        return $configArray;
    }
    //--------------------------------------------------------------------------------------
    /**
     * Forma de conexão com o banco de dados, usando arquivos $configFile ou $array
     *
     * @param string $configFile     - 1: nome do arquivo na pasta <APP>/includes/<nome_arquivo>.php
     * @param boolean $boolRequired  - 2: Default TRUE
     * @param boolean $boolUtfDecode - 3: Default TRUE = faz o Decode / Encode UTF8
     * @param array $configArray     - 4: Usa array de configuração, prevalecendo sobre o $configFile
     * @return void
     */
    public function connect( $configFile = null, $boolRequired = true, $boolUtfDecode = null, $configArray = null )
    {
        $hasConfigArray = FormDinHelper::issetOrNotZero($configArray);
        if(!$hasConfigArray){
            $configArray = $this->makeConfigArray();
        }        
        $tpdo = $this->getTPDOConnection();
        $hasConfigArray = FormDinHelper::issetOrNotZero($configArray);
        if($hasConfigArray){
            $tpdo::connect(null,$boolRequired,$boolUtfDecode,$configArray);
        }else{
            $tpdo::connect($configFile,$boolRequired,$boolUtfDecode,null);
        }
        $this->setTPDOConnection($tpdo);
    }
    //--------------------------------------------------------------------------------------
    public function getDBMS()
    {
        //return $this->tpdo::getDBMS();
        $tpdo = $this->getTPDOConnection();
        $attribute = $tpdo::getDBMS();
        return $attribute;
    }
    public function setDBMS( $banco = null )
    {
        //$this->tpdo::setBanco($banco);
        $tpdo = $this->getTPDOConnection();
        $tpdo::setBanco($banco);
        $this->setTPDOConnection($tpdo);
    }
    //--------------------------------------------------------------------------------------
    public function getPort()
    {
        //return $this->tpdo::getPort();
        $tpdo = $this->getTPDOConnection();
        $attribute = $tpdo::getPort();
        return $attribute;
    }
    public function setPort($port = null )
    {
        //$this->tpdo::setPort($port);
        $tpdo = $this->getTPDOConnection();
        $tpdo::setPort($port);
        $this->setTPDOConnection($tpdo);
    }
    //--------------------------------------------------------------------------------------
    public function getHost()
    {
        //return $this->tpdo::getHost();
        $tpdo = $this->getTPDOConnection();
        $attribute = $tpdo::getHost();
        return $attribute;
    }
    public function setHost($host)
    {
        //$this->tpdo::setHost($host);
        $tpdo = $this->getTPDOConnection();
        $tpdo::setHost($host);
        $this->setTPDOConnection($tpdo);        
    }
    //--------------------------------------------------------------------------------------
    public function getDataBaseName()
    {
        //return $this->tpdo::getDataBaseName();
        $tpdo = $this->getTPDOConnection();
        $attribute = $tpdo::getDataBaseName();
        return $attribute;
    }
    public function setDataBaseName($host)
    {
        //$this->tpdo::setDataBaseName($host);
        $tpdo = $this->getTPDOConnection();
        $tpdo::setDataBaseName($host);
        $this->setTPDOConnection($tpdo); 
    }
    //--------------------------------------------------------------------------------------
    public function getUsername()
    {
        //return $this->tpdo::getUsername();
        $tpdo = $this->getTPDOConnection();
        $attribute = $tpdo::getUsername();
        return $attribute;
    }
    public function setUsername($username)
    {
        //$this->tpdo::setUsername($username);
        $tpdo = $this->getTPDOConnection();
        $tpdo::setUsername($username);
        $this->setTPDOConnection($tpdo);         
    }
    //--------------------------------------------------------------------------------------
    public function getPassword()
    {
        //return $this->tpdo::getPassword();
        $tpdo = $this->getTPDOConnection();
        $attribute = $tpdo::getPassword();
        return $attribute;
    }
    public function setPassword($password)
    {
        //$this->tpdo::setPassword($password);
        $tpdo = $this->getTPDOConnection();
        $tpdo::setPassword($password);
        $this->setTPDOConnection($tpdo);         
    }
    //--------------------------------------------------------------------------------------
    public function getUtfDecode()
    {
        //return $this->tpdo::getUtfDecode();
        $tpdo = $this->getTPDOConnection();
        $attribute = $tpdo::getUtfDecode();
        return $attribute;
    }
    public function setUtfDecode( $boolNewValue = null )
    {
        //$this->tpdo::setUtfDecode($boolNewValue);
        $tpdo = $this->getTPDOConnection();
        $tpdo::setUtfDecode($boolNewValue);
        $this->setTPDOConnection($tpdo);   
    }
    //--------------------------------------------------------------------------------------
    public function executeSql($sql, $arrParams = null)
    {
        $tpdo = $this->getTPDOConnection();
        $result = $tpdo::executeSql($sql,$arrParams);
        return $result;
    }
    //--------------------------------------------------------------------------------------
    public function getInstance()
    {
        $tpdo = $this->getTPDOConnection();
        $instance = $tpdo::getInstance();
        return $instance;
    }
    //--------------------------------------------------------------------------------------
    public function beginTransaction()
    {
        //$this->tpdo::rollBack();
        $tpdo = $this->getTPDOConnection();
        //$tpdo::rollBack();
        $instance = $tpdo::getInstance();
        $instance->beginTransaction();
        $this->setTPDOConnection($tpdo);          
    }
    //--------------------------------------------------------------------------------------
    public function inTransaction()
    {
        $instance = $this->getInstance();
        return $instance->inTransaction();
    }
    //--------------------------------------------------------------------------------------
    public function commit()
    {
        //$this->tpdo::commit();
        $tpdo = $this->getTPDOConnection();
        //$tpdo::commit();
        $instance = $tpdo::getInstance();
        $instance->commit();
        $this->setTPDOConnection($tpdo);          
    }
    //--------------------------------------------------------------------------------------
    public function rollBack()
    {
        //$this->tpdo::rollBack();
        $tpdo = $this->getTPDOConnection();
        //$tpdo::rollBack();
        $instance = $tpdo::getInstance();
        $instance->rollBack();
        $this->setTPDOConnection($tpdo);         
    }
    //--------------------------------------------------------------------------------------
    public function getLastInsertId()
    {
        $instance = $this->getInstance();
        $id = $instance->lastInsertId();
        return $id;
    }
}
?>