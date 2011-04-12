<?php

/**
 * Test class for Git_Object_Blob
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_Object_Blob extends Test_Git_BaseTest {
    /**
     * Properties |props
     */
    /**
     * Git_Object_Blob storage
     * @var Git_Object_Blob
     **/
    private $blob;

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
        $this->blob = new Git_Object_Blob($this->base, 'HEAD:build.properties');
    } // end function setUp

    /**
     * Test the constructor
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Blob::__construct
     **/
    public function testConstructor() {
        $this->assertNull($this->blob->getMode());

        $mode = uniqid('mode_');
        $blob = new Git_Object_Blob($this->base, 'HEAD:build.properties', $mode);
        $this->assertEquals($mode, $blob->getMode());
    } // end function testConstructor

    /**
     * Test the getMode method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Blob::getMode
     * @covers Git_Object_Blob::setMode
     **/
    public function testGetMode() {
        $mode = uniqid('mode_');
        $this->assertInstanceOf('Git_Object_Blob', $this->blob->setMode($mode));
        $this->assertEquals($mode, $this->blob->getMode());
    } // end function testGetMode

} // end class Test_Git_Object_Blob extends Test_Git_BaseTest
