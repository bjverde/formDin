<?php
require_once __DIR__.'/../classes/constants.php';
require_once __DIR__.'/../classes/webform/TApplication.class.php';

use PHPUnit\Framework\TestCase;
/**
 * TApplication test case.
 */
class TApplicationTest extends TestCase
{
	
	/**
	 *
	 * @var TApplication
	 */
	private $tApplication;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		if (! defined ( 'APLICATIVO' )) {
		    define ( 'APLICATIVO', 'phpunit' );
		}
		$this->tApplication = new TApplication(/* parameters */);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
	    session_destroy();
		$this->tApplication = null;		
		parent::tearDown ();
	}

	public function testSetTitle_Defined() {
	    $expected= 'xxxTest95784';
	    
	    $this->tApplication->setTitle($expected);
	    $result = $this->tApplication->getTitle();
	    $this->assertEquals( $expected , $result);
	}
	
	public function testSetTitle_NotDefined() {
	    $this->tApplication->setTitle(null);
	    $result = $this->tApplication->getTitle();
	    $this->assertNull($result);
	}
	
	public function testSetFormDinMinimumVersion_OK() {
	    $this->tApplication->setFormDinMinimumVersion('1.0.0');
	}
	
	/**
	 * @expectedException DomainException
	 */
	public function testSetFormDinMinimumVersion_fail() {
	    $this->tApplication->setFormDinMinimumVersion('999.999.999');
	}
	
	/**
	 * @expectedException DomainException
	 */
	public function testSetFormDinMinimumVersion_formatInvalid() {
	    $this->tApplication->setFormDinMinimumVersion('4.0');
	}
	
	public function testGetImgLogoHtml_null() {
		$result = $this->tApplication->getImgLogoHtml();
		$this->assertNull($result);
	}
	
	public function testGetAppImgLogoHtml_SetImg() {
	    $expected= '<img src="'.__DIR__.'/../imagens/tree.gif">';
		
		$this->tApplication->setImgLogoPath(__DIR__.'/../imagens/tree.gif');
		$result = $this->tApplication->getImgLogoHtml();
		$this->assertEquals( $expected , $result);
	}
}