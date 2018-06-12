<?php

require_once '../classes/webform/TApplicationHtml.class.php';
/**
 * TApplicationHtml test case.
 */
class TApplicationHtmlTest extends PHPUnit_Framework_TestCase
{
    
    /**
     *
     * @var TApplicationHtml
     */
    private $tApplicationHtml;
    
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        if (!defined('ENCODINGS')) {
            define('ENCODINGS', 'UTF-8');
        }
        $this->tApplicationHtml = new TApplicationHtml(/* parameters */);
    }
    
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->tApplicationHtml = null;
        parent::tearDown();
    }
    
    public function testDefineConstantAplicativo_NotDefined()
    {
        $expected= 'FORMDIN';
        
        $this->tApplicationHtml->defineConstantAplicativo();
        $this->assertEquals($expected, APLICATIVO);
    }
}
