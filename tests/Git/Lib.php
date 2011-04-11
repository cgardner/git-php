<?php
require_once realpath(dirname(__FILE__) .'/BaseTest.php');

/**
 * Test the Git_Lib class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_Lib extends Test_Git_BaseTest {
    /**
     * Public Methods |publics
     */
    /**
     * Git_Lib ojbect
     * @var Git_Lib
     **/
    private $lib;

    /**
     * Object to perform tests with
     * @var Git_Object_Abstract
     **/
    private $object;

    /**
     * setUp
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setUp() {
        $options = array(
            'working_directory' => '/home/gardnerc/src/scripts',
            'path' => '/home/gardnerc/src/scripts',
        );
        $base = new Git_Base($options);
        $this->object = $base->object('HEAD');
        $this->lib = $base->getLib();
    } // end function setUp

    /**
     * Test the getContents Method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::objectContents
     **/
    public function testObjectContents() {
        $this->markTestIncomplete();
        $this->lib->objectContents($this->object->getSha());
    } // end function testObjectContents

    /**
     * Test the revParse method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::revParse
     **/
    public function testRevParse() {
        $shaTest = SHA1('hello world');
        $this->assertEquals($shaTest, $this->lib->revParse($shaTest));
    } // end function testRevParse

    /**
     * Test the revParse exception
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::revParse
     * @expectedException Git_Exception
     **/
    public function testRevParseException() {
        $this->lib->revParse('path/does/not/exist');
    } // end function testRevParseException

} // end class Test_Git_Lib extends Test_Git_BaseTest
?>
