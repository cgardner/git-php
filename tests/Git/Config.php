<?php
require_once LIBRARY_PATH .'/Git/Config.php';

/**
 * Test Class for Git_Config
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_Config extends PHPUnit_Framework_TestCase {
    /**
     * Public Methods |publics
     */
    /**
     * Test the getInstance method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     **/
    public function testGetInstance() {
        $instance = Git_Config::getInstance();
        $this->assertInstanceOf('Git_Config', $instance);
    } // end function testGetInstance

} // end class Test_Git_Config extends PHPUnit_Framework_TestCase
