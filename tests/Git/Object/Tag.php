<?php

/**
 * Test class for Git_Object_Tag
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_Object_Tag extends Test_Git_BaseTest {
    /**
     * Properties |props
     */
    /**
     * Git_Object_Tag storage
     * @var Git_Object_Tag
     **/
    private $tag;

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
        $this->tag = new Git_Object_Tag($this->base, 'test', 'test');
    } // end function setUp

    /**
     * Test the constructor
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Tag::__construct
     **/
    public function testConstructor() {
        $name = uniqid('name_');
        $tag = new Git_Object_Tag($this->base, 'test', $name);
        $this->assertEquals($name, $tag->getName());
    } // end function testConstructor

    /**
     * Test the getName method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Tag::getName
     * @covers Git_Object_Tag::setName
     **/
    public function testGetName() {
        $name = uniqid('name_');
        $this->assertInstanceOf('Git_Object_Tag', $this->tag->setName($name));
        $this->assertEquals($name, $this->tag->getName());
        
    } // end function testGetName

} // end class Test_Git_Object_Tag extends Test_Git_BaseTest
?>
