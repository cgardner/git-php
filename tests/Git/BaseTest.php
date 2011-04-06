<?php

/**
 * Git Base Test Case
 * @package TestFramework
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_BaseTest extends PHPUnit_Framework_TestCase {
    /**
     * Properties |props
     */
    /**
     * Array of files to delete
     * @var array
     **/
    private $deleteFiles = array();

    /**
     * Public Methods |publics
     */
    /**
     * tearDown
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function tearDown() {
        foreach ($this->deleteFiles as $file) {
            unlink($file);
        }
    } // end function tearDown
    
    /**
     * Protected Methods |protect
     */
} // end class Test_Git_BaseTest extends PHPUnit_Framework_TestCase
?>
