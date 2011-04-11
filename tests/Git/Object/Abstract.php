<?php

/**
 * Test class for Git_Object_Abstract
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_Object_Abstract extends Test_Git_BaseTest {
    /**
     * Public Methods |publics
     */
    /**
     * Abstract Object class
     * @var Git_Object_Abstract
     **/
    private $abstract;

    /**
     * setUp
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setUp() {
        parent::setUp();
        $this->abstract = $this->base->object('master');
    } // end function setUp

    /**
     * Test the getSize method 
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Abstract::getSize
     **/
    public function testGetSize() {
        $size = $this->abstract->getSize();
        $this->assertInternalType('integer', $size);
        $this->assertGreaterThan(0, $size);
    } // end function testGetSize

    /**
     * Test the getContents method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Abstract::getContents
     **/
    public function testGetContents() {
        $contents = $this->abstract->getContents();
        $this->assertGreaterThan(0, count($contents));
    } // end function testGetContents

    /**
     * Test the sha method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Abstract::getSha
     **/
    public function testGetSha() {
        $this->assertRegExp('/[A-Fa-f0-9]{40}/', $this->abstract->getSha());
    } // end function testGetSha
} // end class Test_Git_Object_Abstract extends Test_Git_BaseTest
