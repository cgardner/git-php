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
    protected $deleteFiles = array();

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
            if (is_dir($file)) {
                exec(sprintf('rm -rf %s 2>&1', $file), $output, $return);
                if ($return > 0) {
                    var_dump($output);
                }
            }
            else {
                unlink($file);
            }
        }
    } // end function tearDown
    
    /**
     * Protected Methods |protect
     */
} // end class Test_Git_BaseTest extends PHPUnit_Framework_TestCase
?>
