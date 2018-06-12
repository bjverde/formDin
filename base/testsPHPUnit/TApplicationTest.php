<?php
require_once '../classes/webform/TApplication.class.php';
/**
 * TApplication test case.
 */
class TApplicationTest extends PHPUnit_Framework_TestCase
{
    
    /**
     *
     * @var TApplication
     */
    private $tApplication;
    
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->tApplication = new TApplication(/* parameters */);
    }
    
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->tApplication = null;
        parent::tearDown();
    }
    
    public function testSetTitle_Defined()
    {
        $expected= 'xxxTest95784';
        
        $this->tApplication->setTitle($expected);
        $result = $this->tApplication->getTitle();
        $this->assertEquals($expected, $result);
    }
    
    public function testSetTitle_NotDefined()
    {
        $this->tApplication->setTitle(null);
        $result = $this->tApplication->getTitle();
        $this->assertNull($result);
    }
}
