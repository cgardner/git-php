<?php
require_once 'Git/Base.php';
require_once 'tests/Git/Base.php';

/**
 * Test the Base Class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_Base extends Test_Git_BaseTest {
    /**
     * Properties |props
     */
    /**
     * undocumented class variable
     * @var string
     **/
    private $options = array(
        'working_directory' => '/home/gardnerc/src/scripts',
    );

    /**
     * Array of files to delete
     * @var array
     **/
    private $deleteFiles = array();

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
            if (file_exists($file)) {
                unlink($file);
            }
        }
    } // end function tearDown

    /**
     * Test the Configure method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::__construct
     * @covers Git_Base::config
     **/
    public function testConfig() {
        $base = new Git_Base($this->options);
        $this->assertEquals($this->options['working_directory'], $base->getWorkingDirectory()->getPath());

        $base = new Git_Base();
        $base->config($this->options);
        $this->assertEquals($this->options['working_directory'], $base->getWorkingDirectory()->getPath());
    } // end function testConfig

    /**
     * Test the getRepo Method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::getRepo
     **/
    public function testGetRepo() {
        $repo = $this->base->getRepo();
        $this->assertInstanceOf('Git_Repository', $repo);
        $this->assertEquals($this->options['working_directory'] .'/.git', $repo->getPath());
    } // end function testGetRepo

    /**
     * Test the getWorkingDirectory method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::getWorkingDirectory
     **/
    public function testGetWorkingDirectory() {
        $workingDirectory = $this->base->getWorkingDirectory();
        $this->assertInstanceOf('Git_WorkingDirectory', $workingDirectory);
        $this->assertEquals($this->options['working_directory'], $workingDirectory->getPath());
    } // end function testGetWorkingDirectory

    /**
     * Test the getIndex method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::getIndex
     **/
    public function testGetIndex() {
        $index = $this->base->getIndex();
        $this->assertInstanceOf('Git_Index', $index); 
        $this->assertEquals($this->options['working_directory'] .'/.git/index', $index->getPath());
    } // end function testGetIndex

    /**
     * Test the bare method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::bare
     **/
    public function testBare() {
        $this->markTestIncomplete();
    } // end function testBare

    /**
     * Test the init method 
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @coverse Git_Base::init
     **/
    public function testInit() {
        $repoPath = sprintf('/tmp/%s', uniqid('test_repo_'));
        $base = $this->base->init($repoPath);
        $this->assertInstanceOf('Git_Base', $base);
        $this->assertFileExists($repoPath);
    } // end function testInit
} // end class Test_Git_Base extends PHPUnit_Framework_TestCase
?>
