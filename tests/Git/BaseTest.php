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
     * Git_Base Object
     * @var Git_Base
     **/
    protected $base;

    /**
     * Options used to instantiate Git_Base Object
     * @var array
     **/
    protected $options;

    /**
     * Public Methods |publics
     */
    /**
     * setUp
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setUp() {
        $this->options = array(
            'working_directory' => '/home/gardnerc/src/scripts',
            'path' => '/home/gardnerc/src/scripts'
        );
        $this->base = new Git_Base($this->options);
    } // end function setUp

    /**
     * tearDown
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function tearDown() {
        foreach ($this->deleteFiles as $file) {
            if (is_dir($file)) {
                exec(sprintf('chmod -R 777 %s 2>&1', $file));
                exec(sprintf('rm -rf %s 2>&1', $file), $output, $return);
                if ($return > 0) {
                    exec(sprintf('rm -r %s 2>&1', $file), $output, $return);
                    if ($return > 0) {
                        exec(sprintf('rmdir %s 2>&1', $file), $output, $return);
                        if ($return > 0) {
                            throw new Exception(sprintf('Failed to delete %s', $file));
                        }
                    }
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
