<?php
require_once 'Git/Base.php';
require_once 'tests/Git/BaseTest.php';

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
     * Public Methods |publics
     */

    /**
     * teardown
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function tearDown() {
        parent::tearDown();
    } // end function tearDown

    /**
     * Test the Configure method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::__construct
     * @covers Git_Base::configure
     **/
    public function testConfigure() {
        $base = new Git_Base($this->options);
        $this->assertEquals($this->options['working_directory'], $base->getWorkingDirectory()->getPath());

        $base = new Git_Base();
        $base->configure($this->options);
        $this->assertEquals($this->options['working_directory'], $base->getWorkingDirectory()->getPath());
    } // end function testConfigure

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
        $this->assertFileExists(sprintf('%s/.git', $repoPath));
        $this->deleteFiles[] = $repoPath;
    } // end function testInit

    /**
     * Test the cloneRepo method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::cloneRepo
     **/
    public function testCloneRepo() {
        $repoUrl = 'git@DSADPCGITPOREH.plaza.ds.adp.com:gardnerc/git-php.git';
        $repoPath = '/tmp/git-php';
        $this->deleteFiles[] = $repoPath;
        $this->tearDown();
        $options = array(
            'working_directory' => $repoPath,
            'path' => dirname($repoPath),
        );
        $this->base->cloneRepo($repoUrl, 'git-php', $options);
        
        $this->assertFileExists($options['working_directory']);
        $this->assertFileExists(sprintf('%s/.git', $options['working_directory']));

        // Check the git settings
        $ini = parse_ini_file(sprintf('%s/.git/config', $repoPath), TRUE);
        $this->assertEquals($repoUrl, $ini['remote "origin"']['url']);
    } // end function testCloneRepo
    /**
     * Test the repoSize method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::repoSize
     **/
    public function testRepoSize() {
        $repoUrl = 'git@DSADPCGITPOREH.plaza.ds.adp.com:gardnerc/git-php.git';
        $repoPath = '/tmp/git-php';
        $this->deleteFiles[] = $repoPath;
        $options = array(
            'working_directory' => $repoPath,
            'path' => dirname($repoPath),
        );
        $this->base->cloneRepo($repoUrl, 'git-php', $options);

        $this->assertGreaterThan(0, $this->base->repoSize());
    } // end function testRepoSize
    /**
     * Test the Config method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::config
     **/
    public function testConfig() {
        $origIni = parse_ini_file(sprintf('%s/.git/config', $this->base->getWorkingDirectory()->getPath()), TRUE);
        // Test a variable set
        $value = uniqid('config_');
        $output = $this->base->config('user.name', $value);
        $this->assertNull($output);

        $ini = parse_ini_file(sprintf('%s/.git/config', $this->base->getWorkingDirectory()->getPath()), TRUE);
        $this->assertEquals($ini['user']['name'], $value);

        // Test a variable Get
        $output = $this->base->config('user.name');
        $this->assertEquals($value, $output);

        $config = $this->base->config();
        $this->assertInternalType('array', $config);
        $this->assertEquals($config, $ini);

        $this->base->config('user.name', $origIni['user']['name']);
    } // end function testConfig
    /**
     * Test the Object method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::object
     **/
    public function testObject() {
        $object = $this->base->object('HEAD');
        $this->assertInstanceOf('Git_Object', $object);

        $this->assertGreaterThan(0, $object->getSize());
        $this->assertGreaterThan(0, count($object->getContents()));
    } // end function testObject
    /**
     * Test the gTree method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Base::gTree
     **/
    public function testGTree() {
        $object = $this->base->gTree('master');
        $this->assertInstanceOf('Git_Object', $object);

        $this->assertGreaterThan(0, $object->getSize());
        $this->assertGreaterThan(0, count($object->getContents()));
        
    } // end function testGTree
} // end class Test_Git_Base extends PHPUnit_Framework_TestCase
?>
