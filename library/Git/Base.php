<?php
require_once 'Git/Exception.php';
require_once 'Git/Repository.php';
require_once 'Git/WorkingDirectory.php';
require_once 'Git/Index.php';
require_once 'Git/Lib.php';

/**
 * Base Git Class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Git_Base {
    /**
     * Properties |props
     */
    /**
     * Repository
     * @var Git_Repo
     **/
    private $repo;

    /**
     * Working Directory
     * @var Git_WorkingDirectory
     **/
    private $working_directory;
    
    /**
     * Index
     * @var Git_Index
     **/
    private $index;

    /**
     * Public Methods |publics
     */
    /**
     * Class Constructor
     * @param array $options
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function __construct(array $options = array()) {
        if (array_key_exists('working_directory', $options) && ($workingDir = realpath($options['working_directory'])) !== FALSE) {
            $options['repo'] = realpath(sprintf('%s/.git', $workingDir));
            $options['index'] = realpath(sprintf('%s/.git/index', $workingDir));
        }

        $this->config($options);
    } // end function __construct

    /**
     * Configure the Object
     * @param arra $options
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function config(array $options = array()) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $val) {
            $method = sprintf('set%s', str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            if (in_array($method, $methods)) {
                $this->$method($val);
            }
        }
    } // end function config

    /**
     * Initailize a git repository
     * @param string $workingDir
     * @param array $options
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function init($workingDir, array $options = array()) {
        $options = $options + array(
            'working_directory' => $workingDir,
            'repository' => sprintf('%s/.git', $workingDir),
        );

        if ($options['working_directory'] && !file_exists($options['working_directory'])) {
            mkdir($options['working_directory'], 0777, TRUE);
        }
        $this->config($options);

        $lib = new Git_Lib($this);
        $lib->init();

        return $this;
    } // end function init
    
    /**
     * Getters and Setters |getset
     */
    /**
     * Getter for $this->index
     *
     * @param void
     * @return Git_Index
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getIndex() {
        return $this->index;
    } // end function getIndex()
    
    /**
     * Setter for $this->index
     *
     * @param Git_Index
     * @return Git_Base
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setIndex($arg0) {
        if (!($arg0 instanceOf Git_Index)) {
            $arg0 = new Git_Index($arg0);
        }
        $this->index = $arg0;
        return $this;
    } // end function setIndex()
    
    /**
     * Getter for $this->working_directory
     *
     * @param void
     * @return Git_WorkingDirectory
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getWorkingDirectory() {
        return $this->working_directory;
    } // end function getWorkingDirectory()
    
    /**
     * Setter for $this->working_directory
     *
     * @param Git_WorkingDirectory
     * @return Git_Base
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setWorkingDirectory($arg0) {
        if (!($arg0 instanceOf Git_WorkingDirectory)) {
            $arg0 = new Git_WorkingDirectory($arg0);
        }
        $this->working_directory = $arg0;
        return $this;
    } // end function setWorkingDirectory()
    
    /**
     * Getter for $this->repo
     *
     * @param void
     * @return Git_Repo
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getRepo() {
        return $this->repo;
    } // end function getRepo()
    
    /**
     * Setter for $this->repo
     *
     * @param Git_Repo
     * @return Git_Base
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setRepo($arg0) {
        if (!($arg0 instanceOf Git_Repository)) {
            $arg0 = new Git_Repository($arg0);
        }
        $this->repo = $arg0;
        return $this;
    } // end function setRepo()
} // end class Git_Base
