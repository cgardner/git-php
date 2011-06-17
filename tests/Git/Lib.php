<?php
require_once realpath(dirname(__FILE__) .'/BaseTest.php');

/**
 * Test the Git_Lib class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 * @TODO Add coverage for Git_Lib::executeCommand
 * @TODO Add coverage for Git_Lib::objectType
 * @TODO Cover the exception thrown in Git_Lib::runCommand
 **/
class Test_Git_Lib extends Test_Git_BaseTest {
    /**
     * Public Methods |publics
     */
    /**
     * Git_Lib Object
     * @var Git_Lib
     **/
    private $lib;

    /**
     * Object to perform tests with
     * @var Git_Object_Abstract
     **/
    private $object;

    /**
     * File Name of the INI file to be tested against
     * @var string
     **/
    private $iniFile;

    /**
     * Original INI Configuration
     * @var array
     **/
    private $origIni;

    /**
     * Contents of the Original INI file
     * @var string
     **/
    private $origIniString;

    /**
     * Repository URL
     * @var string
     **/
    private $repoUrl = 'git://github.com/cgardner/git-php.git';

    /**
     * undocumented class variable
     * @var string
     **/
    private $repoPath = '';

    /**
     * setUp
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setUp() {
        parent::setUp();
        $this->object = $this->base->object('master');
        $this->lib = $this->base->getLib();
        $this->repoPath = TMP_DIR .'/git-php';

        $this->iniFile = sprintf('%s/.git/config', $this->base->getWorkingDirectory()->getPath());
        $this->origIniString = file_get_contents($this->iniFile);
        $this->origIni = parse_ini_file($this->iniFile, TRUE);

        $this->deleteFiles[] = $this->repoPath;
    } // end function setUp

    /**
     * tearDown
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function tearDown() {
        file_put_contents($this->iniFile, $this->origIniString);
    } // end function tearDown

    /**
     * Test the configure method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::configure
     **/
    public function testConfigure() {
        $options = array(
            'working_directory' => '/home/gardnerc/src/scripts',
            'path' => '/home/gardnerc/src/scripts',
        );
        $lib = new Git_Lib($options);
    } // end function testConfigure

    /**
     * Test the getContents Method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::objectContents
     **/
    public function testObjectContents() {
        $contents = $this->lib->objectContents($this->object->getSha());
        $this->assertInternalType('string', $contents);
        $this->assertGreaterThan(0, count($contents));
    } // end function testObjectContents

    /**
     * Test the objectSize method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::objectSize
     **/
    public function testObjectSize() {
        $objectSize = $this->lib->objectSize($this->object->getSha());
        $this->assertInternalType('integer', $objectSize);
        $this->assertGreaterThan(0, $objectSize);
    } // end function testObjectSize

    /**
     * Test the revParse method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::revParse
     **/
    public function testRevParse() {
        $shaTest = SHA1('hello world');
        $this->assertEquals($shaTest, $this->lib->revParse($shaTest));

        $this->assertRegExp('@[A-Fa-f0-9]{40}@', $this->lib->revParse('master'));
    } // end function testRevParse

    /**
     * Test the revParse exception
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::revParse
     * @expectedException Git_Exception
     **/
    public function testRevParseException() {
        $this->lib->revParse('path/does/not/exist');
    } // end function testRevParseException

    /**
     * Test the cloneRepo method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::cloneRepo
     **/
    public function testCloneRepo() {
        $options = array(
            'working_directory' => $this->repoPath,
            'path' => dirname($this->repoPath),
        );

        $options = $this->lib->cloneRepo($this->repoUrl, 'git-php', $options);
        $this->assertInternalType('array', $options);

        $this->assertFileExists($options['working_directory']);
        $this->assertFileExists(sprintf('%s/.git', $options['working_directory']));

        // Check the git settings
        $ini = parse_ini_file(sprintf('%s/.git/config', $this->repoPath), TRUE);
        $this->assertEquals($this->repoUrl, $ini['remote origin']['url']);
    } // end function testCloneRepo

    /**
     * Clone a Bare Repository 
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::cloneRepo
     **/
    public function testCloneBareRepo() {
        /**
         * Make sure the path doesn't exist before continuing
         * For some reason, the tearDown method isn't running properly
         */
        $this->removeFile($this->repoPath);

        $options = array(
            'working_directory' => $this->repoPath,
            'path' => dirname($this->repoPath),
            'bare' => TRUE,
        );

        $options = $this->lib->cloneRepo($this->repoUrl, 'git-php', $options);
        $this->assertInternalType('array', $options);

        $this->assertFileExists($this->repoPath);
        $this->assertFileNotExists(sprintf('%s/.git', $this->repoPath));
        $this->assertFileExists(sprintf('%s/HEAD', $this->repoPath));
    } // end function testCloneBareRepo

    /**
     * Test the cloneRepo method and change the name of the origin
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::cloneRepo
     **/
    public function testCloneRepoOrigin() {
        /**
         * Make sure the path doesn't exist before continuing
         * For some reason, the tearDown method isn't running properly
         */
        $this->removeFile($this->repoPath);
        $remote = uniqid('origin_');
        $options = array(
            'working_directory' => $this->repoPath,
            'path' => dirname($this->repoPath),
            'remote' => $remote,
        );

        $options = $this->lib->cloneRepo($this->repoUrl, 'git-php', $options);
        $this->assertInternalType('array', $options);

        $this->assertFileExists($options['working_directory']);
        $this->assertFileExists(sprintf('%s/.git', $options['working_directory']));

        // Check the git settings
        $ini = parse_ini_file(sprintf('%s/.git/config', $this->repoPath), TRUE);
        $this->assertTrue(array_key_exists(sprintf('remote %s', $remote), $ini));
    } // end function testCloneRepoOrigin

    /**
     * Test the cloneRepo method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::cloneRepo
     **/
    public function testCloneRepoDepth() {
        /**
         * Make sure the path doesn't exist before continuing
         * For some reason, the tearDown method isn't running properly
         */
        $this->removeFile($this->repoPath);
        $remote = uniqid('origin_');
        $options = array(
            'working_directory' => $this->repoPath,
            'path' => dirname($this->repoPath),
            'depth' => 3,
        );

        $options = $this->lib->cloneRepo($this->repoUrl, 'git-php', $options);
        $this->assertInternalType('array', $options);

        $this->assertFileExists($this->repoPath);
        $this->assertFileExists(sprintf('%s/.git', $this->repoPath));

        $this->assertFileExists(sprintf('%s/.git/shallow', $this->repoPath));
    } // end function testCloneRepoDepth
    /**
     * Test the configSet method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::configSet
     **/
    public function testConfigSet() {
        $testVal = uniqid('test_user_');
        $this->lib->configSet('user.name', $testVal);

        $ini = parse_ini_file($this->iniFile, TRUE);
        $this->assertEquals($testVal, $ini['user']['name']);
    } // end function testConfigSet

    /**
     * Test the configGet method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::configGet
     **/
    public function testConfigGet() {
        $this->assertEquals($this->origIni['user']['name'], $this->lib->configGet('user.name'));
    } // end function testConfigGet
    /**
     * Test the configList method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::configList
     **/
    public function testConfigList() {
        $this->assertEquals($this->origIni, $this->lib->configList());
    } // end function testConfigList
    /**
     * Test the fullTree Method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::fullTree
     **/
    public function testFullTree() {
        $tree = $this->lib->fullTree('master');
        $this->assertInternalType('string', $tree);
        $this->assertGreaterThan(0, count($tree));
    } // end function testFullTree

    /**
     * Test the lsTree method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::lsTree
     **/
    public function testLsTree() {
        $data = $this->lib->lsTree('master');
        $this->assertInternalType('array', $data);
        $this->assertTrue(array_key_exists('tree', $data));
        $this->assertTrue(array_key_exists('blob', $data));
    } // end function testLsTree
    /**
     * Test the tagSha method
     * @param string $tag
     * @param boolean $expected
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::tagSha
     * @dataProvider tagShaDataProvider
     **/
    public function testTagSha($tag, $expected) {
        try {
            $sha = $this->lib->tagSha($tag);
            $this->assertInternalType('string', $sha);
            $this->assertRegExp('@[A-Fa-f0-9]{40}@', $sha);
        }
        catch (Exception $e) {
            if ($expected) {
                $this->fail();
            }
        }
    } // end function testTagSha

    /**
     * Test the objectType method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::objectType
     **/
    public function testObjectType() {
        
    } // end function testObjectType

    /**
     * Test the getPath method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::getPath
     * @covers Git_Lib::setPath
     **/
    public function testGetPath() {
        $path = uniqid('path_');
        $this->assertInstanceOf('Git_Lib', $this->lib->setPath($path));
        $this->assertEquals($path, $this->lib->getPath());  
    } // end function testGetPath
    /**
     * Test the getGitIndeFile
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::getGitIndexFile
     * @covers Git_Lib::setGitIndexFile
     **/
    public function testGetGitIndexFile() {
        $indexFile = uniqid('indexFile_');
        $this->assertInstanceOf('Git_Lib', $this->lib->setGitIndexFile($indexFile));
        $this->assertEquals($indexFile, $this->lib->getGitIndexFile());
    } // end function testGetGitIndexFile
    /**
     * Test the getGitDir method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Lib::getGitDir
     * @covers Git_Lib::setGitDir
     **/
    public function testGetGitDir() {
        $gitDir = uniqid('gitDir_');
        $this->assertInstanceOf('Git_Lib', $this->lib->setGitDir($gitDir));
        $this->assertEquals($gitDir, $this->lib->getGitDir());  
    } // end function testGetGitDir
    /**
     * Data Providers
     */
    /**
     * Data Provider for the testTagSha test
     * @param void
     * @return array
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function tagShaDataProvider() {
        return array(
            array('test', TRUE),
            array('does/not/exist', FALSE),
        );
    } // end function tagShaDataProvider
} // end class Test_Git_Lib extends Test_Git_BaseTest
?>
