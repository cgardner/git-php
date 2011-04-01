<?php
require_once LIBRARY_PATH .'/Git/Config.php';

/**
 * Test Class for Git_Config
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 * @runTestsInSeparateProcesses
 **/
class Test_Git_Config extends PHPUnit_Framework_TestCase {
    /**
     * Public Methods |publics
     */

    /**
     * Test the getInstance method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @dataProvider getInstanceDataProvider
     * @covers Git_Config::getInstance
     **/
    public function testGetInstance($config, $expected) {
        $instance = Git_Config::getInstance($config);
        $this->assertInstanceOf('Git_Config', $instance);
        $instanceConfig = $instance->getConfig();
        $this->assertInternalType('array', $instanceConfig);
        $this->testExpectation($config, $expected, $instanceConfig);

        // Test a second time without passing parameters
        $instanceConfig2 = Git_Config::getInstance()->getConfig();
        $this->testExpectation($config, $expected, $instanceConfig2);

    } // end function testGetInstance

    /**
     * Make sure that getInstance throws an Exception at the right time
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @expectedException Git_Exception
     **/
    public function testGetInstanceException() {
        Git_Config::getInstance('/path/to/invalid.file');
    } // end function testGetInstanceException

    /**
     * Test the getConfig
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @dataProvider getInstanceDataProvider
     * @covers Git_Config::getConfig
     **/
    public function testGetMethod($config, $expected) {
        $instanceConfig = Git_Config::getInstance($config)->getConfig();
        $this->assertInternalType('array', $instanceConfig);
        $this->testExpectation($config, $expected, $instanceConfig);
    } // end function testGetMethod

    /**
     * Test the loadConfig method
     * @param mixed $config
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @dataProvider getInstanceDataProvider
     * @covers Git_Config::loadConfig
     **/
    public function testLoadConfig($config, $expected) {
        $instance = Git_Config::getInstance();
        $this->assertInstanceOf('Git_Config', $instance);
        $this->assertInstanceOf('Git_Config', $instance->loadConfig($config));
        $instanceConfig = $instance->getConfig();
        $this->assertInternalType('array', $instanceConfig);
        $this->testExpectation($config, $expected, $instanceConfig);
    } // end function testLoadConfig

    /**
     * Test the setConfig method
     * @param mixed $config
     * @param mixed $expected
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Config::setConfig
     **/
    public function testSetConfig() {
        $config = array(
            'user' => array(
                'name' => uniqid(),
                'mail' => 'test@test.com',
            ),
        );
        $instance = Git_Config::getInstance();

        $this->assertInstanceOf('Git_Config', $instance->setConfig($config));
        $instanceConfig = $instance->getConfig();
        $this->assertInternalType('array', $instanceConfig);
        $this->assertEquals($config, $instanceConfig);
    } // end function testSetConfig

    /**
     * Test the get method
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     **/
    public function testGet() {
        $config = array(
            'user' => array(
                'name' => uniqid(),
                'mail' => 'test@test.com',
            ),
        );

        $this->assertEquals($config['user'], Git_Config::getInstance($config)->get('user'));
        $this->assertEquals($config['user']['name'], Git_Config::getInstance()->get('user.name'));
    } // end function testGet

    /**
     * Data Providers
     */
    /**
     * Data Provider for the testGetInstance method
     * @param void
     * @return array
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getInstanceDataProvider() {
        return array(
            // Default config file (~/.gitconfig)
            'Default Config File' => array(
                NULL, 
                FALSE,
            ),
            // Test a config file
            'Custom Config File' => array(
                realpath(dirname(__FILE__) .'/testGitConfig.ini'),
                array(
                    'user' => array(
                        'name' => 'Test User',
                        'mail' => 'testUser@test.com',
                    ),
                )
            ),
            // Custom Configuration
            'Array Configuration' => array (
                array(
                    'testKey' => uniqid(),
                ),
                NULL,
            ),
        );
    } // end function getInstanceDataProvider

    /**
     * Test the expected result
     * @param mixed $config
     * @param mixed $expected
     * @param array $instanceConfig
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function testExpectation($config, $expected, $instanceConfig) {
        if ($expected !== FALSE) {
            // Test the expectation
            if (is_null($expected)) {
                $this->assertEquals($config, $instanceConfig);
            }
            else {
                $this->assertEquals($expected, $instanceConfig);
            }
        }
    } // end function testExpectation

} // end class Test_Git_Config extends PHPUnit_Framework_TestCase
