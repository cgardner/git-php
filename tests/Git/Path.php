<?php
require_once 'tests/Git/BaseTest.php';
require_once 'Git/Path.php';

/**
 * Test the Git_Path class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_Path extends Test_Git_BaseTest {
    /**
     * Properties |props
     */
    /**
     * Boolean for whether a file was created or not
     * @var boolean
     **/
    private $file_created = FALSE;

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
        $this->testPath = '/tmp';
        $this->path = new Git_Path($this->testPath);
    } // end function setUp

    /**
     * tearDown
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function tearDown() {
        if ($this->file_created) {
            unlink($this->path->getPath());
        }
    } // end function tearDown

    /**
     * Test the Constructor
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Path::__construct
     **/
    public function testConstructor() {
        $path = new Git_Path('/tmp');
    } // end function testConstructor

    /**
     * Test the isReadable method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Path::isReadable
     **/
    public function testIsReadable() {
        $testPath = uniqid('unit_test_path_');
        $this->path->setPath($testPath);
        $this->assertFalse($this->path->isReadable());

        $this->createPath($testPath);
        $this->assertTrue($this->path->isReadable());
    } // end function testIsReadable

    /**
     * Test the isWritable method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Path::isWritable
     **/
    public function testIsWritable() {
        $testPath = uniqid('unit_test_path_');
        $this->path->setPath($testPath);
        $this->assertFalse($this->path->isWritable());

        $this->createPath($testPath);
        $this->assertTrue($this->path->isWritable());
    } // end function testIsWritable

    /**
     * Test the getPath method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Path::getPath
     **/
    public function testGetPath() {
        $this->assertEquals($this->testPath, $this->path->getPath());
    } // end function testGetPath

    /**
     * Test the setPath method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Path::setPath
     **/
    public function testSetPath() {
        $testPath = sprintf('/tmp/%s', uniqid('unit_test_path_'));
        $this->path->setPath($testPath);
        $this->assertEquals($testPath, $this->path->getPath());
    } // end function testSetPath

    /**
     * Test the exists method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Path::exists
     **/
    public function testExists() {
        $testPath = sprintf('/tmp/%s', uniqid('unit_test_path_'));
        $this->path->setPath($testPath);
        $this->assertFalse($this->path->exists());

        $this->createPath($testPath);
        $this->assertTrue($this->path->exists());
    } // end function testExists

    /**
     * Create a file at $path
     * @param string $path
     * @return boolean
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function createPath($path) {
        if (!file_exists($path)) {
            $return = touch($path);
            $this->file_created = TRUE;
        }
        return $this->file_created;
    } // end function createPath

} // end class Test_Git_Path
?>
