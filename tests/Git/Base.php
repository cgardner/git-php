<?php
require_once 'Git/Base.php';

/**
 * Test the Base Class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_Base extends PHPUnit_Framework_TestCase {
    /**
     * Properties |props
     */
    /**
     * undocumented class variable
     * @var string
     **/
    private $options = array(
        'path' => '/home/gardnerc/src/scripts',
    );

    /**
     * Public Methods |publics
     */
    /**
     * Test the Configure method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::__construct
     * @covers Git_Base::config
     **/
    public function testConfig() {
        $this->markTestIncomplete();
        $base = new Git_Base($this->options);

        $base = new Git_Base();
        $base->config($this->options);
    } // end function testConfig

    /**
     * Test the getRepo Method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::getRepo
     **/
    public function testGetRepo() {
        $base = new Git_Base($this->options);
        
    } // end function testGetRepo
} // end class Test_Git_Base extends PHPUnit_Framework_TestCase
?>
