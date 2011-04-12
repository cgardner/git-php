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
     * Test the constructor
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Abstract::__construct
     **/
    public function testConstructor() {
        $abstract = new Git_Object_Abstract($this->base, 'master');
        $this->assertEquals('master', $abstract->getObjectish());
        $this->assertGreaterThan(0, $abstract->getSize());
    } // end function testConstructor
    /**
     * Test the getSize method 
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Abstract::getSize
     * @covers Git_Object_Abstract::setSize
     **/
    public function testGetSize() {
        $size = $this->abstract->getSize();
        $this->assertInternalType('integer', $size);
        $this->assertGreaterThan(0, $size);

        $size = rand(0, 999);
        $this->assertInstanceOf('Git_Object_Abstract', $this->abstract->setSize($size));
        $this->assertEquals($size, $this->abstract->getSize());
    } // end function testGetSize

    /**
     * Test the getContents method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Abstract::getContents
     * @covers Git_Object_Abstract::setContents
     **/
    public function testGetContents() {
        $contents = $this->abstract->getContents();
        $this->assertGreaterThan(0, count($contents));

        $newContents = uniqid('contents_');
        $this->assertInstanceOf('Git_Object_Abstract', $this->abstract->setContents($newContents));
        $this->assertEquals($newContents, $this->abstract->getContents());
    } // end function testGetContents

    /**
     * Test the sha method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Abstract::getSha
     * @covers Git_Object_Abstract::setSha
     **/
    public function testGetSha() {
        $this->assertRegExp('/[A-Fa-f0-9]{40}/', $this->abstract->getSha());

        $sha = uniqid('sha_');
        $this->assertInstanceOf('Git_Object_Abstract', $this->abstract->setSha($sha));
        $this->assertEquals($sha, $this->abstract->getSha());
    } // end function testGetSha
    /**
     * Test the getMode method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Abstract::getMode
     * @covers Git_Object_Abstract::setMode
     **/
    public function testGetMode() {
        $mode = uniqid('mode_');
        $this->assertInstanceOf('Git_Object_Abstract', $this->abstract->setMode($mode));
        $this->assertEquals($mode, $this->abstract->getMode());
    } // end function testGetMode
    /**
     * Test the getObjectish method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Abstract::getObjectish
     * @covers Git_Object_Abstract::setObjectish
     **/
    public function testGetObjectish() {
        $objectish = uniqid('objectish_');
        $this->assertInstanceOf('Git_Object_Abstract', $this->abstract->setObjectish($objectish));
        $this->assertEquals($objectish, $this->abstract->getObjectish());
        
    } // end function testGetObjectish
} // end class Test_Git_Object_Abstract extends Test_Git_BaseTest
