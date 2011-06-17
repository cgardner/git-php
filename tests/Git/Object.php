<?php

/**
 * Test class for Git_Object
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Test_Git_Object extends Test_Git_BaseTest {
    /**
     * Public Methods |publics
     */
    /**
     * Test the factory method
     * @param array $params
     * @param string $expected
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object::factory
     * @dataProvider factoryDataProvider
     **/
    public function testFactory(array $params, $expected) {
        array_unshift($params, $this->base);
        $object = call_user_func_array('Git_Object::factory', $params);
        $this->assertInstanceOf($expected, $object);
    } // end function testFactory

    /**
     * Make sure the Factory method throws a 
     * Git_Object_Exception_TagDoesNotExist exception when it is supposed to
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     * @group all
     * @covers Git_Object::factory
     * @expectedException Git_Object_Exception_TagDoesNotExist
     **/
    public function testFactoryTagDoesNotExistException() {
        $object = Git_Object::factory($this->base, 'tag/does/not/exist', NULL, TRUE);
    } // end function testFactoryTagDoesNotExistException

    /**
     * Data Providers
     */
    /**
     * Data Provider for testFactory
     * @param void
     * @return array
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function factoryDataProvider() {
        return array(
            /*'tag' => array(
                array(
                    'test',
                    'tag',
                    TRUE
                ),
                'Git_Object_Tag',
            ),*/
            'commit' => array(
                array(
                    'HEAD',
                ),
                'Git_Object_Commit',
            ),
            'tree' => array(
                array(
                    'HEAD^{tree}',
                ),
                'Git_Object_Tree',
            ),
            'blob' => array(
                array(
                    'HEAD:build.properties',
                ),
                'Git_Object_Blob',
            ),
        );
        
    } // end function factoryDataProvider

} // end class Test_Git_Object extends Test_Git_BaseTest
?>
