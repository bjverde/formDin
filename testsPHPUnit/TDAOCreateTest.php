<?php
require_once 'base/classes/webform/TDAOCreate.class.php';

/**
 * TDAOCreate test case.
 */
class TDAOCreateTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var TDAOCreate
     */
    private $tDAOCreate;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(){
        parent::setUp();        
        // TODO Auto-generated TDAOCreateTest::setUp()        
        $this->tDAOCreate = new TDAOCreate(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(){
        // TODO Auto-generated TDAOCreateTest::tearDown()
        $this->tDAOCreate = null;        
        parent::tearDown();
    }
    
    public function testSetShowSchema_true(){
        $esperado = true;
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setShowSchema(true);
        $retorno = $tDAOCreate->getShowSchema();
        //$this->tDAOCreate->setShowSchema(true);
        //$retorno = $this->tDAOCreate->getShowSchema();        
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testSetShowSchema_false(){
        $esperado = false;
        $this->tDAOCreate->setShowSchema(false);
        $retorno = $this->tDAOCreate->getShowSchema();
        $this->assertEquals($esperado, $retorno);
    }

    public function testHasSchema_yes(){
        $esperado = '\'.SCHEMA.\'';        
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setShowSchema(true);
        $retorno = $tDAOCreate->hasSchema();        
        $this->assertEquals($esperado, $retorno);
    }
    
    public function testHasSchema_no(){
        $esperado = '';
        $tDAOCreate = $this->tDAOCreate;
        $tDAOCreate->setShowSchema(false);
        $retorno = $tDAOCreate->hasSchema();  
        $this->assertEquals($esperado, $retorno);
    }

}