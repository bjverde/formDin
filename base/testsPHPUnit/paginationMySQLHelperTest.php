<?php
require_once '../classes/helpers/PaginationMySQLHelper.class.php';

/**
 * paginationMySQLHelper test case.
 */
class paginationMySQLHelperTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var paginationMySQLHelper
	 */
	private $paginationMySQLHelper;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		// TODO Auto-generated paginationMySQLHelperTest::setUp()
		
		$this->paginationMySQLHelper = new paginationMySQLHelper(/* parameters */);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated paginationMySQLHelperTest::tearDown()
		$this->paginationMySQLHelper = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testGetRowStart_pageNullAndRowsPerPageNull() {
		$expected = 0;
		$page = null;
		$rowsPerPage =  null;
		$result = paginationMySQLHelper::getRowStart($page,$rowsPerPage);		
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page1AndRowsPerPageNull() {
		$expected = 0;
		$page = 1;
		$rowsPerPage =  null;
		$result = paginationMySQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page2AndRowsPerPageNull() {
		$expected = 20;
		$page = 2;
		$rowsPerPage =  null;
		$result = paginationMySQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_pageNullAndRowsPerPage10() {
		$expected = 0;
		$page = null;
		$rowsPerPage =  10;
		$result = paginationMySQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page1AndRowsPerPage30() {
		$expected = 0;
		$page = 1;
		$rowsPerPage =  30;
		$result = paginationMySQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page2AndRowsPerPage30() {
		$expected = 30;
		$page = 2;
		$rowsPerPage =  30;
		$result = paginationMySQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page3AndRowsPerPage10() {
		$expected = 20;
		$page = 3;
		$rowsPerPage =  10;
		$result = paginationMySQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page2AndRowsPerPage13() {
		$expected = 13;
		$page = 2;
		$rowsPerPage =  13;
		$result = paginationMySQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page3AndRowsPerPage13() {
		$expected = 26;
		$page = 3;
		$rowsPerPage =  13;
		$result = paginationMySQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
	
	public function testGetRowStart_page10AndRowsPerPage13() {
		$expected = 117;
		$page = 10;
		$rowsPerPage =  13;
		$result = paginationMySQLHelper::getRowStart($page,$rowsPerPage);
		$this->assertEquals( $expected , $result);
	}
}

