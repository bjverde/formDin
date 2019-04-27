<?php
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
		$this->tApplication = new TApplication(/* parameters */);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
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
	
	public function testGetImgLogoHtml_null() {
		$result = $this->tApplication->getImgLogoHtml();
		$this->assertNull($result);
	}
	
	public function testGetAppImgLogoHtml_SetImg() {
		$expected= '<img src="images/logo.png">';
		
		$this->tApplication->setImgLogoPath('images/logo.png');
		$result = $this->tApplication->getImgLogoHtml();
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetAppImgLogoHtml_SetImgRootDir() {
		$expected= '<img src="/var/www/appv1/images/logo.png">';
		
		$this->tApplication->setAppRootDir('/var/www/appv1/');
		$this->tApplication->setImgLogoPath('images/logo.png');
		$result = $this->tApplication->getImgLogoHtml();
		$this->assertEquals( $expected , $result);
	}
	
}