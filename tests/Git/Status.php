<?php
require_once 'Git/Status.php';

/**
 * Test class for Git_Status
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_Status extends PHPUnit_Framework_TestCase {
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
         parent::setUp();
     } // end function setUp

     /**
      * test the Git_Status constructor
      * @param void
      * @return void
      * @author Craig Gardner <craig_gardner@adp.com>
      **/
     public function testConstructor() {
         $this->markTestIncomplete();
         $base = new Git_Base(array('path' => '/home/gardnerc/src/scripts/'));
         $status = new Git_Status($base);
         

     } // end function testConstructor

} // end class Test_Git_Status extends PHPUnit_Framework_TestCase
?>
