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
class FormDinHelper
{
    /**
     * Return FormDin version
     * @return string
     */
    public static function version()
    {
        return FORMDIN_VERSION;
    }
    /***
     * Returns if the current formDin version meets the minimum requirements
     * 
     * Retorna se a versão atual do formDin atende aos requisitos mínimos 
     * @param string $version
     * @return boolean
     */
    public static function versionMinimum($version)
    {
        $formVersion = explode("-", self::version());
        $formVersion = $formVersion[0];
        return version_compare($formVersion,$version,'>=');
    }
    
    //--------------------------------------------------------------------------------
    /**
     * Recebe o corpo de um request e um objeto VO. Quando o id do array bodyRequest for
     * igual ao nome de um atributo no objeto Vo esse deverá ser setado.
     *
     * @param array $bodyRequest - Array com corpo do request
     * @param object $vo - objeto VO para setar os valores
     * @return object
     */
    public static function setPropertyVo($bodyRequest,$vo)
    {
        $class = new \ReflectionClass($vo);
        $properties   = $class->getProperties();        
        foreach ($properties as $attribut) {
            $name =  $attribut->getName();
            if (array_key_exists($name, $bodyRequest)) {
                $reflection = new \ReflectionProperty(get_class($vo), $name);
                $reflection->setAccessible(true);
                $reflection->setValue($vo, $bodyRequest[$name]);
                //echo $bodyRequest[$name];
            }
        }
        return $vo;
    }    
    //--------------------------------------------------------------------------------
    /***
     * Convert Object Vo to Array FormDin 
     * @param object $vo
     * @throws InvalidArgumentException
     * @return array
     */
    public static function convertVo2ArrayFormDin($vo)
    {
        $isObject = is_object( $vo );
        if( !$isObject ){
            throw new InvalidArgumentException('Not Object .class:'.__METHOD__);
        }
        $class = new \ReflectionClass($vo);
        $properties   = $class->getProperties();
        $arrayFormDin = array();
        foreach ($properties as $attribut) {
            $name =  $attribut->getName();
            $property = $class->getProperty($name);
            $property->setAccessible(true);
            $arrayFormDin[strtoupper($name)][0] = $property->getValue($vo);
        }
        return $arrayFormDin;
    }
    
    /**
     * @deprecated chante to ValidateHelper::methodLine
     * @param string $method
     * @param string $line
     * @param string $nameMethodValidate
     * @throws InvalidArgumentException
     */
    public static function validateMethodLine($method,$line,$nameMethodValidate)
    {
        ValidateHelper::methodLine($method, $line, $nameMethodValidate);
    }
    //--------------------------------------------------------------------------------
    /**
     *  @deprecated chante to ValidateHelper::objTypeTPDOConnectionObj
     * Validate Object Type is Instance Of TPDOConnectionObj
     *
     * @param object $tpdo instanceof TPDOConnectionObj
     * @param string $method __METHOD__
     * @param string $line __LINE__
     * @throws InvalidArgumentException
     * @return void
     */
    public static function validateObjTypeTPDOConnectionObj($tpdo,$method,$line)
    {
        ValidateHelper::objTypeTPDOConnectionObj($tpdo, $method, $line);
    }
    //--------------------------------------------------------------------------------
    /**
     * @deprecated chante to ValidateHelper::isNumeric
     * Validade ID is numeric and not empty
     * @param integer $id
     * @param string $method
     * @param string $line
     * @throws InvalidArgumentException
     * @return void
     */
    public static function validateIdIsNumeric($id,$method,$line)
    {
        ValidateHelper::isNumeric($id, $method, $line);
    }
    /***
     * 
     * @param mixed $variable
     * @param boolean $testZero
     * @return boolean
     */
    public static function issetOrNotZero($variable,$testZero=true)
    {
        $result = false;
        if( is_array($variable) ){
            if( !empty($variable) ) {
                $result = true;
            }
        }else{
            if(isset($variable) && !($variable==='') ) {
                if($testZero) {
                    if($variable<>'0' ) {
                        $result = true;
                    }
                }else{
                    $result = true;
                }
            }
        }
        return $result;
    }
    

    /***
     * função para depuração. Exibe o modulo a linha e a variável/objeto solicitado
     * Retirado do FormDin 4.9.0
     * https://github.com/bjverde/formDin/blob/master/base/includes/funcoes.inc
     */
    public static function debug( $mixExpression,$strComentario='Debug', $boolExit=FALSE, $showBackTrace=false ) {
        ini_set ( 'xdebug.max_nesting_level', 150 );
        if (defined('DEBUGAR') && !DEBUGAR){
            return;
        }
        $arrBacktrace = debug_backtrace();
        if( isset($_REQUEST['ajax']) && $_REQUEST['ajax'] ){
            echo '<div class="formDinDebug">';
            echo '<pre>';
            foreach ( $arrBacktrace[0] as $strAttribute => $mixValue ){
                if ( !is_array($mixValue) ){
                    echo $strAttribute .'='. $mixValue ."\n";
                }
            }
            echo "---------------\n";
            print_r( $mixExpression );
            echo '</pre>';
            echo '</div>';
        } else {
            echo '<div class="formDinDebug">';
            echo "<script>try{fwUnblockUI();}catch(e){try{top.app_unblockUI();}catch(e){}}</script>";
            echo "<fieldset style='text-align:left;'><legend><font color=\"#007000\">".$strComentario."</font></legend><pre>" ;
            foreach ( $arrBacktrace[0] as $strAttribute => $mixValue ) {
                if( !is_array($mixValue) ) {
                    echo "<b>" . $strAttribute . "</b> ". $mixValue ."\n";
                }
            }
            echo "</pre><hr />";
            echo '<span style="color:red;"><blink>'.$strComentario.'</blink></span>'."\n";;
            echo '<pre>';
            if( is_object($mixExpression) ) {
                var_dump( $mixExpression );
            } else {
                print_r($mixExpression);
            }
            echo '</pre>';
            
            if($showBackTrace==true){
                echo '<hr>';
                echo '<font style="color:red;">BackTrack</font>';
                echo '<pre>';
                foreach ( $arrBacktrace as $key => $value ){
                    echo $value['file'] .' <b>line:</b> '.$value['line'].' <b>function:</b> '.$value['function']."\n";
                }
                echo '</pre>';
            }
            
            echo '</fieldset>';
            echo '</div>';
            if ( $boolExit ) {
                echo "<br /><font color=\"#700000\" size=\"4\"><b>D I E</b></font>";
                exit();
            }
        }
    }
    
    /**
     * Avoid the problem Deprecated preg_match in PHP 8.1.X
     * @param string $pattern
     * @param string $subject
     * @return string
     */
    public static function pregMatch($pattern,$subject) 
    {
    	if( empty($subject) ){
    		$result = FALSE;
    	}else{
            $result = preg_match ( $pattern, $subject );
        }
    	return $result;
    }
    
}
?>
