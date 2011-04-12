<?php
require_once realpath(dirname(__FILE__) .'/BaseTest.php');

/**
 * Test the Git_Lib class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
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
     * setUp
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setUp() {
        parent::setUp();
        $this->object = $this->base->object('master');
        $this->lib = $this->base->getLib();


        $this->iniFile = sprintf('%s/.git/config', $this->base->getWorkingDirectory()->getPath());
        $this->origIniString = file_get_contents($this->iniFile);
        $this->origIni = parse_ini_file($this->iniFile, TRUE);
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
        $repoUrl = 'git@DSADPCGITPOREH.plaza.ds.adp.com:gardnerc/git-php.git';

        $repoPath = '/tmp/git-php';
        $this->deleteFiles[] = $repoPath;
        $options = array(
            'working_directory' => $repoPath,
            'path' => dirname($repoPath),
        );

        $options = $this->lib->cloneRepo($repoUrl, 'git-php', $options);
        $this->assertInternalType('array', $options);

        $this->assertFileExists($options['working_directory']);
        $this->assertFileExists(sprintf('%s/.git', $options['working_directory']));

        // Check the git settings
        $ini = parse_ini_file(sprintf('%s/.git/config', $repoPath), TRUE);
        $this->assertEquals($repoUrl, $ini['remote "origin"']['url']);
    } // end function testCloneRepo

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
