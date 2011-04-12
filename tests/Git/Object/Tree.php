<?php
require_once 'Git/Object/Tree.php';

/**
 * Tests for Git_Object_Tree
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_Object_Tree extends Test_Git_BaseTest {
    /**
     * Properties |props
     */
    /**
     * Git_Object_Tree object
     * @var Git_Object_Tree
     **/
    private $tree;

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
        $this->tree = new Git_Object_Tree($this->base, 'test');
    } // end function setUp

    /**
     * tearDown
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function tearDown() {
        parent::tearDown();
    } // end function tearDown

    /**
     * Test the constructor
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Tree::__construct
     **/
    public function testConstructor() {
        $mode = uniqid('mode_');
        $tree = new Git_Object_Tree($this->base, 'test', $mode);
        $this->assertEquals($mode, $tree->getMode(), 'Assert that Git_Object_Tree::$mode was set in the constructor');
    } // end function testConstructor

    /**
     * Test the fullTree method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Tree::fullTree
     **/
    public function testFullTree() {
        $tree = $this->tree->fullTree();
        $this->assertInternalType('string', $tree);
        $this->assertGreaterThan(0, count($tree));
    } // end function testFullTree
    /**
     * Test the getBlobs method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Tree::getBlobs
     * @covers Git_Object_Tree::setBlobs
     * @covers Git_Object_Tree::checkTree
     **/
    public function testGetBlobs() {
        $blobs = $this->tree->getBlobs();
        $this->assertInternalType('array', $blobs);
        if (count($blobs) > 0) {
            $blob = array_shift($blobs);
            $this->assertInstanceOf('Git_Object_Blob', $blob);
        }

        $blobs = uniqid('blobs_');
        $this->assertInstanceOf('Git_Object_Tree', $this->tree->setBlobs($blobs));
        $this->assertEquals($blobs, $this->tree->getBlobs());
    } // end function testGetBlobs

    /**
     * Test the getTrees method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Tree::getTrees
     * @covers Git_Object_Tree::setTrees
     * @covers Git_Object_Tree::checkTree
     **/
    public function testGetTrees() {
        $trees = $this->tree->getTrees();
        $this->assertInternalType('array', $trees);
        if (count($trees) > 0) {
            $tree = array_shift($trees);
            $this->assertInstanceOf('Git_Object_Tree', $tree);
        }

        $trees = uniqid('trees_');
        $this->assertInstanceOf('Git_Object_Tree', $this->tree->setTrees($trees));
        $this->assertEquals($trees, $this->tree->getTrees());
    } // end function testGetTrees
    /**
     * Test the getMode method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object_Tree::getMode
     * @covers Git_Object_Tree::setMode
     **/
    public function testGetMode() {
        $mode = uniqid('mode_');
        $this->assertInstanceOf('Git_Object_Tree', $this->tree->setMode($mode));
        $this->assertEquals($mode, $this->tree->getMode());  
    } // end function testGetMode
} // end class Test_Git_Object_Tree extends Test_Git_BaseTest
