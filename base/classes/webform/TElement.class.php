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

/*
Esta classe representa qualquer elemento HTML criado atraves de tag de abertura e fechamento
Ex: <input> <br> <p> <h1> etc...

Estrutura básica
<tagType class="" style="">x y z</tagType>
*/
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
$GLOBALS[ 'teste' ] = true; // deixar as quebras de linha e a identação do html

class TElement
{
    /**
     * Armazenar o caminho do diretório base/
     * @var string
     */

    static public $base;
    /**
    * Controla a identacao do html gerado
    *
    * @var integer $depth
    */
    static private $depth;
    /**
    * Array com as mensagens de advertências encontradas durante o processamento
    *
    * @var array $warnings
    */
    static public $warnings;
    //   $this->depth++;
    /**
     * Tipo da tag que sera criada. Ex: div, table, span
     *
     * @var string $tagType
     */
    private $tagType;
    /**
     * Valores que serão inseridos na tag de abertura
     * ex: style, class, size, maxlength etc..
     *
     * @var array $properties
     */
    private $properties;
    /**
     * Conteudo que será exibido entre a tag de abertura e fechamento
     *
     * @var array $children
     */
    private $children;
    /**
     * Array de propriedades css que formarao a propriedade style da tag html
     * Ex: style="top:10px;"
     *
     * @var array $css
     */
    protected $css;
    /**
     * Array de eventos javascript que serão atribuidos a tag html
     * Ex: addEvent("onClick","fazerAlgo()");
     *
     * @var array $events
     */
    private $events;
    /**
    * Armazena o Id do objeto pai
    *
    */
    private $parentControl;

    /**
     * Funcao construtora da classe.
     * Recebe como parametro o tipo de tag html que sera gerada
     * Ex: div, span, input ...
     *
     * @var string tagType - name tag html
     */
    public function __construct( $strTagType = null )
    {
        // evitar que um modulo seja executado diretamente da URL sem ter sido
        // chamado pelo controller
        if ( !defined( 'FORMDIN' ) )
        {
        //die();
        }
        $strTagType = is_null( $strTagType ) ? 'span' : $strTagType;
        $this->tagType = $this->removeIllegalChars( strtolower( $strTagType ) );

        //$this->setCss('font-family','Arial,Helvetica, Geneva, Sans-Serif');
        //$this->setCss('font-size','12px');
        if ( is_null( self::$depth ) )
        {
            if ( $this->tagType == 'doctype' )
            {
                self::$depth = -1;
            }
            else
            {
                self::$depth = 0;
            }
        }

        if ( is_null( self::$base ) )
        {
            $this->getBase();
        }
    }
    /**
    * define uma propriedade da tag. Equivalente ao metodo setProperty()
    *
    * @param string $property
    * @param mixed $value
    */
    public function __set( $property, $value )
    {
        if ( is_object( $value ) )
        {
            return $this;
        }

        if ( isset( $this->properties[ $property ] ) && is_object( $this->properties[ $property ] ) )
        {
            $this->properties[ strtolower( $property )]->$property = $value;
        }
        else
        {
            // todas as propriedades terao nomes em caixa baixa
            $property = strtolower( $property );

            // id e name nao podem ter caracteres da lingua portuguesa
            if ( $property == 'id' || $property == 'name' )
            {
                $property = $this->removeIllegalChars( $property );
            }
            $this->properties[ $property ] = $value;
        }
        return $this;
    }
    /**
    * Mesmo que setAttribute(). Define uma propriedade e um valor para a tag html de abertura
    * Ex: setProperty('name','xxx'); gera: <tag name="xxx">
    *
    * @param string $name
    * @param mixed $value
    */
    public function setProperty( $strProperty, $strValue )
    {
        $strProperty = $this->removeIllegalChars( $strProperty,'-' );
        if( strtolower($strProperty) == 'id')
        {
			$strValue = $this->removeIllegalChars($strValue);
        }
        $this->$strProperty = $strValue;
        return $this;
    }
    /**
    * Mesmo que setProperty. Define um atributo e o seu valor para a tag html de abertura
    * Ex: setAttribute('name','myDiv'); gera: <tag name="myDiv">
    *
    * @param string $name
    * @param mixed $value
    */
    public function setAttribute( $strProperty, $strValue = null )
    {
        return $this->setProperty( $strProperty, $strValue );
    }
    /**
    * Retorna o valor definido para uma propriedade
    * o mesmo que getProperty()
    *
    * @param mixed $strProperty
    */
    public function getAttribute( $strProperty = null )
    {
        return $this->getProperty( $strProperty );
    }
    /**
    * Retorna o valor definido para uma propriedade
    *
    * @param string $property
    * @return string
    */
    public function getProperty( $strProperty )
    {
        $strProperty = strtolower( $strProperty );
        return $this->$strProperty;
    }
    /**
    * Retorna o valor definido para uma propriedade
    *
    * @param string $property
    * @return string
    */
    public function __get( $strProperty )
    {
        if ( isset( $this->properties[ $strProperty ] ) )
        {
            return $this->properties[ $strProperty ];
        }
        return null;
    }

    //---------------------------------------------------------------------
    /**
    * Faz o tratamento das aspas duplas e simples para evitar erro de sintaxe
    *
    * @param string $str
    * @return string
    */
    private function setQuotes( $str )
    {
        $str = str_replace( '( "', "('", $str );
        $str = str_replace( '("', "('", $str );
        $str = str_replace( '")', "')", $str );
        $str = str_replace( '" )', "')", $str );
        //$str=str_replace('"','“' ,$str);
        $str = str_replace( '"', "'", $str );
        //$str=str_replace('"',"\'\'" ,$str);

        //$str=str_replace("(''","('\'" ,$str);
        //$str=str_replace("'')","\'')" ,$str);

        $str = str_replace( "\\\'')", "\\'')", $str );

        $str = str_replace( "\\'\\'+", "'+", $str );
        $str = str_replace( "+\\'\\'", "+'", $str );

        $str = str_replace( "\\'\\' +", "'+", $str );
        $str = str_replace( " +\\'\\'", "+'", $str );
        //$str=str_replace("","" ,$str);
        return $str;
    }

    //----------------------------------------------------------------------
    /**
    * Transforma as tags html para o simbolo correspondente
    *
    * @param string $s
    * @return string
    */
    public function safehtml( $s )
    {
        $s = str_replace( "&", "&amp;", $s );
        $s = str_replace( "<", "&lt;", $s );
        $s = str_replace( ">", "&gt;", $s );
        $s = str_replace( "'", "&apos;", $s );
        $s = str_replace( "\"", "&quot;", $s );
        return $s;
    }
    /**
    * Remove os caracteres invalidos para criacao de nomes de funcoes e variaveis
    * Para não excluir algum caractere especifico, utilize o parametro $strExcept
    * ex: removeIllegalChars($teste,'[]');
    * @param string $word
    * @param string $strExcept
    * @return string
    */
    public function removeIllegalChars( $word=null, $strExcept = null )
    {
    	if( is_null($word) || trim($word) == '' )
    	{
    		return null;
		}
        if ( isset( $strExcept ) )
        {
            $strExcept = str_replace( array( '[', ']', '^' ), array( '\\[', '\\]', '\\^' ), $strExcept );
        }
        return $word = @preg_replace( "/[^a-zA-Z0-9_" . $strExcept . "]/", "",
            strtr( $word, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_" ) );


    }
    /**
    * Adiciona conteudo dentro da tag. Pode ser um texto ou outro objeto da classe Element
    *
    * @param mixed $child
    */
    public function add( $child, $boolLF = true )
    {
        if ( is_array( $child ) )
        {
            foreach( $child as $v )
            {
                $this->add( $v, $boolLF );
            }
        }
        else
        {
            if ( $child != null )
            {
                if ( $boolLF === false && !is_object( $child ) )
                {
                    $index = ( is_array( $this->children ) ? count( $this->children ) - 1 : 0 );
                    $this->children[ $index ] .= $child;
                }
                else
                {
                    $this->children[ ] = $child;
                }

                // gravar o objeto pai no objeto filho
                if ( is_object( $child ) )
                {
                    $child->setParentControl( $this );
                }
                return $child;
            }
        }
    }
    /**
    * Adiciona conteudo dentro da tag antes de todos os objeto já inseridos.
    * Pode ser um texto ou outro objeto da classe Element
    *
    * @param mixed $child
    * @param mixed $boolLF
    */
    public function addOnTop( $child, $boolLF = true )
    {
    	$children = $this->getChildren();
    	$this->clearChildren();
    	$this->add($child,$boolLF);
    	$this->add($children);
	}

    // retorna o array de conteudo que sera impresso entre as tags de abertura e fechamento
    public function getChildren($intIndex=null)
    {
    	if( !is_null( $intIndex ))
    	{
			return $this->children[$intIndex]; // retorna o filho selecionado
    	}
        return $this->children; // retorna todos os filhos
    }

    //---------------------------------------------------------------------
    /**
    * Abre a tag e imprime todo o seu conteudo.
    * Se print for false, retorna o html gerado
    * Se print for true, joga o html para o browser ( padrao )
    *
    * @param bool $print
    */
    protected function open( $print = true )
    {
        $result = '';

        // tags simples que nao possuem fechamento
        if ( $this->tagType == 'br' )
        {
            $result .= "<{$this->tagType}/>";
        }
        else if( $this->tagType == 'doctype' )
        {
            $result
                .= '<!DOCTYPE html> '
                . "\n";
        }
        else
        {
            $result = '';

            if ( $this->getTagType() )
            {
                $result .= "<{$this->tagType}";

                if ( is_array( $this->properties ) )
                {
                    foreach( $this->properties as $k => $v )
                    {
                        if ( !is_object( $v ) )
                        {
                            if ( !is_null( $v ) )
                            {
                                // regras de acessibilidade para div
                                if( $k == 'name' )
                                {
                                    if( preg_match('/(div|table|tr|td)/i',$this->getTagType()))
                                     continue;
                                }
                            	if(substr($k,0,3) != '_fl')
                            	{
	                                if ( $k == 'nowrap' )
	                                {
	                                    $v = ( ( $v == '' || $v == '1' ) ? 'true' : $v );

	                                    if ( $v == 'false' )
	                                    {
	                                        $k = null;
	                                    }
	                                }

	                                // tags que devem possuir unidade de medida para funcionarem em strict mode no browser
	                                if ( preg_match( '/(width|height|top|left|font-size|padding|margin) /', $k )
	                                    && preg_match( '/[0-9]$/', $v ) )
	                                {
	                                    $v .= 'px';
	                                }
                                    // atributos que não possuem medidas
                                    if( preg_match('/(cellspacing|cellpadding)/i', $k ) )
                                    {
                                        $v = preg_replace('/[^0-9]/','',$v);
                                    }
	                                if ( !is_null( $k ) && $k != '' )
	                                {
	                                	if( is_string($v) || is_numeric($v) )
	                                	{
	                                    	$result .= " $k=\"$v\" ";
										}
										else
										{
											$result .= "$k=\"".gettype($v)."\" ";
										}
	                                }
								}
                            }
                        }
                        else
                        {
                            $result .= " $k=\"{$v->show(false)}\"";
                        }
                    }
                }

                if ( $this->tagType == 'option' )
                {
                    $result .= ">";
                }
                else
                {
                    $result .= ">\n";
                }
            }
        }

        if ( $result != '' )
        {
            $result = $this->getIdent() . $result;

            if ( $print )
            {
                echo $result;
            }
            else
            {
                return $result;
            }
        }
    }

    //---------------------------------------------------------------------
    /**
    * fecha a tag
    * Se print for false, retorna o html gerado
    * Se print for true, joga o html para o browser ( padrao )
    *
    * @param mixed $print
    */
    protected function close( $print = true )
    {
        //print 'depth:'.self::$depth."\n";
        // tags que nao precisam ser fechadas
        if ( $this->tagType == '' || $this->tagType == 'br' || $this->tagType == 'doctype'
            || $this->tagType == 'input' )
        {
            return null;
        }

        if ( $print )
        {
            if ( $this->tagType == 'textarea' || $this->tagType == 'option' )
            {
                echo "</{$this->tagType}>";
            }
            else
            {
                echo $this->getIdent() . "</{$this->tagType}>\n";
            }
        }
        else
        {
            if ( $this->tagType == 'textarea' || $this->tagType == 'option' )
            {
                return "</{$this->tagType}>\n";
            }
            else
            {
                return $this->getIdent() . "</{$this->tagType}>\n";
            }
        }
    }

    //---------------------------------------------------------------------
    /**
    * Imprime/retorna o codigo completo de abertura e fechamento da tag
    * Se print for false, retorna o html gerado
    * Se print for true, joga o html para o browser ( padrao )
    *
    * @param mixed $print
    */
    public function show( $print = true )
    {
        // criar o estilo se tiver sido definida alguma propriedade
        if ( is_array( $this->css ) )
        {
            $css = '';

            foreach( $this->css as $name => $value )
            {
                if ( $value )
                {
                    // tags que devem possuir unidade de medida para funcionarem em strict mode no browser
                    if ( preg_match( '/(padding|margin|width|height|top|left|font-size)/', $name )
                        && preg_match( '/[0-9]$/', $value ) )
                    {
                        $value .= 'px';
                    }
				}
                $css .= $name . ':' . $value . ';';
            }

            if ( ( string ) $css != '' )
            {
                $this->style = $css;
            }
        }

        // adicionar os eventos definidos por setEvent()
        if ( is_array( $this->events ) )
        {
            foreach( $this->events as $event => $function )
            {
                $actualValue = $this->$event;
                $this->$event = $actualValue . ( ( string ) $actualValue != '' ? ';' : '' ) . $function;
            }
        }
        $result = $this->open( $print );

        if ( is_array( $this->children ) )
        {
            foreach( $this->children as $child )
            {
                if ( is_object( $child ) )
                {
                    self::$depth++;
                    $result .= $child->show( false );
                    self::$depth--;
                }
                else
                {
                    // o texto do campo textarea e option não ser identado senão aparece na tela
                    if ( $this->tagType != 'textarea' && $this->tagType != 'option' )
                    {
                        // linha de comentario
                        if ( preg_match('/^\/\//',ltrim( $child ) ) && !$GLOBALS[ 'teste' ] )
                        {
                            $child = "";
                        }
                        else
                        {
                        	$result .= $this->getIdent( 1 ) . $child . "\n";
						}
                    }
                    else
                    {
                        if ( ! preg_match('/^\/\//',ltrim( $child ) ) )
                        {
                            $result .= $child;
                        }
                    }
                }
            }
        }

        // encontrar depois uma expressão regular para retirar estra quebra
        // para evitar epaco em branco no internet explorer
/* exeplo de codigo com problema:
<fieldset name="lay_x"  id="lay_x"  type="panel"  style="width:auto;height:auto;overflow:auto;display:inline;verticalalign:top;margin:0px;padding:2px;border:1px dashed red;position:relative;" >
<fieldset name="pnl_x"  id="pnl_x"  type="panel"  style="width:auto;height:auto;overflow:auto;display:inline;verticalalign:top;margin:0px;padding:2px;border:1px dashed red;position:relative;" >
<div name="lblDataInclusao"  value="Data Inclusão:"  id="lblDataInclusao"  type="label"  style="float:left;position:relative;" >
    Data Inclusão:
</div>
<input name="dat_inclusao"  maxlength="10"  size="10"  required="false"  id="dat_inclusao"  type="edit"  style="position:relative;"  onblur="fwValidarData(this,event,'dmy','','')"  onfocus="MaskInput(this,'99/99/9999')"  onkeyup="fwSetBordaCampo(this,false)" >
</input>
</fieldset>
<br/>
<fieldset name="pnl_x"  id="pnl_x"  type="panel"  style="width:auto;height:auto;overflow:auto;display:inline;verticalalign:top;margin:0px;padding:2px;border:1px dashed red;position:relative;" >
<input name="dat_inclusao2"  maxlength="10"  size="10"  required="false"  id="dat_inclusao2"  type="edit"  style="position:relative;"  onblur="fwValidarData(this,event,'dmy','','')"  onfocus="MaskInput(this,'99/99/9999')"  onkeyup="fwSetBordaCampo(this,false)" >
</input>
</fieldset>
</fieldset>

*/
/*$result = str_replace(chr(9).'<br/>','<br/>',$result);
$result = str_replace(chr(9).'<br/>','<br/>',$result);
$result = str_replace(chr(9).'<br/>','<br/>',$result);
$result = str_replace(chr(9).'<br/>','<br/>',$result);
$result = str_replace("\n".'<br/>','<br/>'."\n",$result);
*/

        // tive que remover quebras e tabs para nao interferir no layout dos elementos na pagina
        if ( !$GLOBALS[ 'teste' ] )
        {
            $result = str_replace( "\n", '', $result );
            $result = str_replace( chr( 9 ), '', $result );
        }

        if ( $print )
        {
            echo $result;
        }
        $result .= $this->close( $print );
        return $result;
    }

    //----------------------------------------------------------------
    /**
    * permite alterar o tipo de tag que será gerada. Ex. input, label, textarea, div ...
    *
    * $param string $newTagType
    */
    public function setTagType( $newTagType )
    {
        $this->tagType = strtolower( $newTagType );
        return $this;
    }

    //----------------------------------------------------------------
    /**
    * Retorna o tipo da tag html definda
    * ex: html, span, div, input...
    *
    * @return string
    */
    public function getTagType()
    {
        return $this->tagType;
    }
    /**
    * Define a classe (css) para estilizar a tag html
    *
    * @param string $newClass
    */
    public function setClass( $newClass, $boolClearCss = null )
    {
        $boolClearCss = $boolClearCss === false ? false : true;
        $this->class = $newClass;

        if ( $boolClearCss )
        {
            $this->clearCss();
        }
        return $this;
    }
    /**
    * Retorna a classe definida para estilizar a tag html
    *
    * @return string
    */
    public function getClass()
    {
        return $this->class;
    }

    //--------------------------------------------------------------------------
   /**
    * DEPRECADED - PREFIRA USAR setClass. 
    * Define uma propriedade do css IN LINE para criar o style da tag. 
    * Para setar o CSS de um formulario utilize addCssFile.
    *
    * O parametro $mixProperty pode ser um array de propriedades e valores de css.
    *
    * <code>
    * 	$obj->setCss( array('color'=>'white','border'=>'1px solid red') );
    * 	$obj->setCss('border','1px dashed blue');
    * </code>
    *
    * @deprecated 
    * 
    * @param mixed $mixProperty
    * @param string $newValue
    */
    public function setCss( $mixProperty, $newValue = null )
    {
        if ( is_array( $mixProperty ) ) {
            $this->css = $mixProperty;
        } else {
            // os nomes das propriedades serao em caixa baixa
            $mixProperty = preg_replace( '[-]', '_', $mixProperty );
            $mixProperty = $this->removeIllegalChars( strtolower( $mixProperty ) );
            $mixProperty = preg_replace( '[_]', '-', $mixProperty );
            if ( $newValue === null ) {
                $this->css[ $mixProperty ] = null;
                unset( $this->css[ $mixProperty ] );
            } else {
                $this->css[ $mixProperty ] = $newValue;
            }
        }
        return $this;
    }
    /**
    * Retorna o valor de uma propriedade css
    * @deprecated 
    */
    public function getCss( $strProperty = null )
    {
        if ( $strProperty === null )
        {
            return $this->css;
        }

        if ( isset( $this->css[ $strProperty ] ) )
        {
            return $this->css[ $strProperty ];
        }
        return null;
    }

    //--------------------------------------------------------------------------
    /**
    * Define o evento e a funcao javascript que sera executada ao ocorrer o evento
    * Se for restritivo e a função executada retornar false, interrompe a execução dos próximos eventos se houver
    *
    * @param string $eventName
    * @param string $functionJs
    * @param boolean $boolRestrictive
    */
    public function setEvent( $eventName, $functionJs = null, $boolRestrictive = null )
    {
        $eventName = strtolower( $this->removeIllegalChars( $eventName ) );
        //$functionJs	= $this->removeIllegalChars($functionJs);
        $this->events[ $eventName ] = '';

        if ( ( string ) $functionJs != '' )
        {
            if ( ( bool ) $boolRestrictive === true )
            {
                $functionJs = 'if(!' . $functionJs . '){return false;}';
            }
            $this->addEvent( $eventName, $functionJs );
        }
        return $this;
    }
    /**
    * Atribui um array de ventos e funções ao elemento
    *
    * @param array $arrEvents
    */
    public function setEvents( $arrEvents = null )
    {
        $this->events = $arrEvents;
        return $this;
    }

    /**
    * Adiciona um evento na tag html. Se ja exisitir um evento com o mesmo nome, faz a concatenacao
    * dos eventos, executando ambos em sequencia.
    * Se for restritivo e a função executada retornar false, interrompe a execução dos próximos eventos se houver
    *
    * @param string $eventName
    * @param string $functionJs
    * @param boolean $boolRestrictive
    */
    public function addEvent( $eventName, $functionJs = null, $boolRestrictive = null )
    {
        $eventName = strtolower( $this->removeIllegalChars( $eventName ) );

        if ( isset( $this->events[ $eventName ] ) && ( string ) $this->events[ $eventName ] != '' )
        {
            $this->events[ $eventName ] .= ';';
        }

        if ( ( bool ) $boolRestrictive === true )
        {
            $functionJs = 'if(!' . $functionJs . '){return false;}';
        }

        if ( !isset( $this->events[ $eventName ] ) )
        {
            $this->events[ $eventName ] = ""; // evitar wornings do php
        }
        $this->events[ $eventName ] .= $this->setQuotes( $functionJs );
        return $this;
    }
    /**
    *  Retorna a função chamada pelo evento solicitado
    *  se não existir, retorna null
    *
    * @param string $strEventName
    */
    public function getEvent( $strEventName )
    {
        $strEventName = strtolower( $this->removeIllegalChars( $strEventName ) );
        return $this->events[ $strEventName ];
    }
    /**
    *  Retorna o array de eventos ligados ao elemento
    *  se não existir, retorna null
    *
    */
    public function getEvents()
    {
        return $this->events;
    }
    /**
    * Remove todos os eventos definidos
    *
    */
    public function clearEvents()
    {
        $this->events = null;
    }

    //-------------------------------------------------------------------------------------------------
    protected function getIdent( $intDepth = 0 )
    {
        if ( $GLOBALS[ 'teste' ] && self::$depth > 0 )
        {
            return str_repeat( chr( 9 ), ( self::$depth + $intDepth ) );
        }
        return null;
    }

    //-------------------------------------------------------------------------------
    public function clearChildren()
    {
        $this->children = null;
    }

    //---------------------------------------------------------------------------------
    public function setId( $newId )
    {
        // considerar os caracteres [] porque os campo check e select multi tem [] no final
        // e a função removeillegaChars remove eles se não for informado
        $this->id = $this->removeIllegalChars( $newId );
        if( ! is_null($newId) )
        {
	        // se o nome não possuir colchetes, dos campos multivalorados, igualar ao id
	        if ( !strpos( $this->name, '[' ) )
	        {
	            $this->name = $this->removeIllegalChars( $newId, '[]' );
	        }
		}
        return $this;
    }

    //---------------------------------------------------------------------
    public function setName( $newName )
    {
        $this->name = $this->removeIllegalChars( $newName, '[]' );

        // se o nome não possuir colchetes, dos campos multivalorados, igualar ao id
        if ( !$this->id )
        {
            $this->id = $this->removeIllegalChars( $newName);
        }
        return $this;
    /*
    if( !strpos($this->name,'['))
    {
        $this->id	= $this->removeIllegalChars($newName);
    }
    */

    }

    //---------------------------------------------------------------------
    public function getName()
    {
        return $this->name;
    }

    //---------------------------------------------------------------------
    public function getId()
    {
        return $this->id;
    }

    //---------------------------------------------------------------------
    public function clearCss()
    {
        $this->css = null;
    }

    public function getBase()
    {
        //if((string)$this->base=="")
        if ( is_null( self::$base ) )
        {
            for( $i = 0; $i < 10; $i++ )
            {
                $base = str_repeat( '../', $i ) . 'base/';

                if ( file_exists( $base ) )
                {
                    $i = 1000;
                    //$this->base = $base;
                    self::$base = $base;
                    break;
                }
            }
        }
        return self::$base;
    }

    public function getRoot()
    {
        $base = $this->getBase();
        return str_replace( 'base/', '', $base );
    }

    //----------------------------------------------------------------------------
    public function setValue( $strNewValue = null )
    {
        $this->value = $strNewValue;
        return $this;
    }

    //----------------------------------------------------------------------------
    public function getValue()
    {
        return $this->value;
    }

    public function setParentControl( $objParent = null )
    {
        $this->parentControl = $objParent;
        return $this;
    }

    //-----------------------------------------------------------------------------
    public function getParentControl()
    {
        return $this->parentControl;
    }

    //-----------------------------------------------------------------------------
    public function getTopMostParent()
    {
        if ( $this->parentControl ){
            //$id = $this->parentControl->getId();
            return $this->parentControl->getTopMostParent();
        }
        //$id = $this->getId();
        return $this;
    }

    //------------------------------------------------------------------------------
    public function setXY( $mixX = null, $mixY = null )
    {
        if ( !is_null( $mixX ) )
        {
            $this->setCss( 'left', $mixX );
        }

        if ( !is_null( $mixY ) )
        {
            $this->setCss( 'top', $mixY );
        }
        return $this;
    }

    //---------------------------------------------------------------------------------
    public function getRandomChars( $intSize = 5 )
    {
        $intSize = ( int ) $intSize == 0 ? 5 : $intSize;
        $intSize = ( int ) $intSize > 32 ? 32 : $intSize;
        return substr( preg_replace('/[li1]/','x',md5( microtime() ) ), 0, $intSize );
    }

    //-----------------------------------------------------------------------------
	public function getIndexFileName()
    {
        if ( defined( 'INDEX_FILE_NAME' ) )
        {
            return INDEX_FILE_NAME;
        }
        $url = $_SERVER[ 'SCRIPT_NAME' ];
        $url = ( $url == '' ? $_SERVER[ 'REQUEST_URI' ] : $url );
        $url = ( $url == '' ? $_SERVER[ 'SCRIPT_FILENAME' ] : $url );
        $url = ( $url == '' ? $_SERVER[ 'SCRIPT_NAME' ] : $url );
        $url = ( $url == '' ? $_SERVER[ 'PHP_SELF' ] : $url );
        if ( !$url )
        {
            return 'index.php';
        }
		if( preg_match('/\./',$url))
		{
			$aFileParts = pathinfo( $url );
			return $aFileParts[ 'basename' ];
		}
		return '';
    }

    public function addWarning($strWarning=null)
    {
		if( ! is_null( $strWarning ) )
		{
			self::$warnings[] = $strWarning;
		}
    }

    public function getWarnings()
    {
		return self::$warnings;
    }

    public function specialChars2htmlEntities($value = null) {
        if (is_string($value)) {
            $html_entities = array
                (
                'Á' => '&Aacute;',
                'À' => '&Agrave;',
                'É' => '&Eacute;',
                'È' => '&Egrave;',
                'Í' => '&Iacute;',
                'Ì' => '&Igrave;',
                'Ó' => '&Oacute;',
                'Ò' => '&Ograve;',
                'Ú' => '&Uacute;',
                'Ù' => '&Ugrave;',
                'á' => '&aacute;',
                'à' => '&agrave;',
                'é' => '&eacute;',
                'è' => '&egrave;',
                'í' => '&iacute;',
                'ì' => '&igrave;',
                'ó' => '&oacute;',
                'ò' => '&ograve;',
                'ú' => '&uacute;',
                'ù' => '&ugrave;',
                'Ä' => '&Auml;',
                'Â' => '&Acirc;',
                'Ë' => '&Euml;',
                'Ê' => '&Ecirc;',
                'Ï' => '&Iuml;',
                'Î' => '&Icirc;',
                'Ö' => '&Ouml;',
                'Ô' => '&Ocirc;',
                'Ü' => '&Uuml;',
                'Û' => '&Ucirc;',
                'ä' => '&auml;',
                'â' => '&acirc;',
                'ë' => '&euml;',
                'ê' => '&ecirc;',
                'ï' => '&iuml;',
                'î' => '&icirc;',
                'ö' => '&ouml;',
                'ô' => '&ocirc;',
                'ü' => '&uuml;',
                'û' => '&ucirc;',
                'Ã' => '&Atilde;',
                'å' => '&aring;',
                'Ñ' => '&Ntilde;',
                'Å' => '&Aring;',
                'Õ' => '&Otilde;',
                'Ç' => '&Ccedil;',
                'ã' => '&atilde;',
                'ç' => '&ccedil;',
                'ñ' => '&ntilde;',
                'Ý' => '&Yacute;',
                'õ' => '&otilde;',
                'ý' => '&yacute;',
                'Ø' => '&Oslash;',
                'ÿ' => '&yuml;',
                'ø' => '&oslash;',
                'Þ' => '&THORN;',
                'Ð' => '&ETH;',
                'þ' => '&thorn;',
                'ð' => '&eth;',
                'Æ' => '&AElig;',
                'ß' => '&szlig;',
                'æ' => '&aelig;'
            );

            return strtr($value, $html_entities);
        }
    }
    /**
    * aplicar utf8_encode em todos os elementos de um array com recursividade
    *
    * @param string[] $data
    * @return string[]
    */
	public function utf8_encode_array( $data=null )
	{
		if( is_array($data ))
		{
			foreach($data as $k=>$v)
			{
				if( is_array( $v ) )
				{
					$data[$k] = $this->utf8_encode_array($v);
				}
				else
				{
					$data[$k] = utf8_encode($v);
				}
			}
		}
		return $data;
	}

  	public function decodeUtf8( $strValue=null )
	{
		if( is_null( $strValue ) || $strValue == '' )
		{
			return $strValue;
		}
		if( preg_match( '/\?/', utf8_decode($strValue) ) )
		{
			return $strValue;
		}
		return utf8_decode( $strValue );
	}

}
?>