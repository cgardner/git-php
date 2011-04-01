<?php

/**
 * Git Config Object
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Git_Config {
    /**
     * Properties |props
     */
    /**
     * Instance of Git_Config
     * @var Git_Config
     **/
    private static $instance;

    /**
     * Public Methods |publics
     */
    /**
     * Get an Instance of Git_Config
     * @param mixed $config
     * @return Git_Config
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public static function getInstance($config = NULL) {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    } // end function getInstance

} // end class Git_Config
