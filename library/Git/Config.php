<?php
require_once 'Git/Exception.php';

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
     * Configuration Options
     * @var array
     **/
    private $config;

    /**
     * Public Methods |publics
     */
    /**
     * Get an Instance of Git_Config
     * @param mixed $config
     * @return Git_Config
     * @author Craig Gardner <craig_gardner@adp.com>
     * @throws Git_Exception
     **/
    public static function getInstance($config = NULL) {
        // If the instance isn't set, let's generate it
        if (is_null(self::$instance)) {
            $instance = new self;
            $instance->loadConfig($config);

            self::$instance = $instance;
        }
        return self::$instance;
    } // end function getInstance

    /**
     * Load a configuration
     * @param mixed $config
     * @return Git_Config
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function loadConfig($config = NULL) {
        // Build the configuration based on the passed parameter
        if (!is_array($config)) {
            $configFile = FALSE;
            if (is_null($config)) {
                $configFile = realpath(getenv('HOME') .'/.gitconfig');
            }
            elseif (is_string($config)) {
                $configFile = realpath($config);
            }

            if (!$configFile) {
                throw new Git_Exception(sprintf('Invalid Config File: "%s"', $config));
            }
            $config = parse_ini_file($configFile, TRUE);
        }

        if (is_array($config)) {
            $this->setConfig($config);
        }
        
        return $this;
    } // end function loadConfig

    /**
     * Get a configuration option
     * @param string $name
     * @return mixed
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function get($name) {
        $keys = explode('.', $name);
        $value = $this->getConfig();
        while ($key = array_shift($keys)) {
            if (isset($value[$key])) {
                $value = $value[$key];
            }
        }
        return $value;
    } // end function get

    /**
     * Getters and Setters |getset
     */
    /**
     * Getter for $this->config
     *
     * @param void
     * @return array
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getConfig() {
        return $this->config;
    } // end function getConfig()
    
    /**
     * Setter for $this->config
     *
     * @param array
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setConfig($arg0) {
        $this->config = $arg0;
        return $this;
    } // end function setConfig()
} // end class Git_Config
