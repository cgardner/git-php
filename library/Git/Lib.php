<?php
require_once 'Git/Exception/Execute.php';

/**
 * Git Lib class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Git_Lib {
    /**
     * Properties |props
     */
    /**
     * Git Directory
     * @var string
     **/
    private $git_dir;

    /**
     * Git Index File
     * @var string
     **/
    private $git_index_file;

    /**
     * Git Working Directory
     * @var string
     **/
    private $git_work_dir;

    /**
     * Path
     * @var string
     **/
    private $path;
    
    /**
     * Public Methods |publics
     */
    /**
     * Constructor
     * @param Git_Base $base
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function __construct($base) {
        if ($base instanceOf Git_Base) {
            $this->setGitDir($base->getRepo()->getPath());
            if ($base->getIndex()) {
                $this->setGitIndexFile($base->getIndex()->getPath());
            }
            if ($base->getWorkingDirectory()) {
                $this->setGitWorkingDirectory($base->getWorkingDirectory()->getPath());
            }
        }
        elseif (is_array($base)) {
            $this->config($base);
        }
        
    } // end function __construct
    /**
     * Configure the object based on the passed associative array
     * @param array $options
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function config(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = sprintf('set%s', str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
    } // end function config

    /**
     * Intialize a repository
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function init() {
        $this->executeCommand('init');
    } // end function init

    /**
     * Clone a repository
     * @param string $repository
     * @param string $name
     * @param array $options
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function cloneRepo($repository, $name, array $options = array()) {
        $this->setPath(array_key_exists('path', $options) ? $options['path'] : '.');
        $cloneDir = array_key_exists('path', $options) ? sprintf('%s/%s', $this->getPath(), $name) : $name;

        $cloneOptions = array();
        if (array_key_exists('bare', $options)) {
            $cloneOptions[] = '--bare';
        }
        if (array_key_exists('remote', $options)) {
            array_push($cloneOptions, '-o', $options['remote']);
        }
        if (array_key_exists('depth', $options) && $options['depth'] > 0) {
            array_push($cloneOptions, '--depth', $options['depth']);
        }

        array_push($cloneOptions, '--', $repository, $cloneDir);

        $this->executeCommand('clone', $cloneOptions);
        return array_key_exists('bare', $options) ? array('repository' => $cloneDir) : array('working_directory' => $cloneDir);
    } // end function cloneRepo
    /**
     * Private Methods |privates
     */
    /**
     * Execute a Git Command
     * @param string $command
     * @param array $options
     * @param boolean $chDir
     * @param string $redirect
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function executeCommand($cmd, array $options = array(), $chDir = TRUE, $redirect = '') {
        $options = array_map('escapeshellarg', $options);
        $gitCommand = sprintf('git %s %s %s 2>&1', $cmd, implode(' ', $options), $redirect);

        switch (TRUE) {
            case !is_null($this->getGitWorkingDirectory()):
                $path = $this->getGitWorkingDirectory();
                break;
            case !is_null($this->getGitDir()):
                $path = $this->getGitDir();
                break;
            default:
            case !is_null($this->getPath()):
                $path = $this->getPath();
                break;
        }

        $output = NULL;
        if ($chDir && ($origPath = getcwd()) != $path) {
            chdir($path);
            $this->runCommand($gitCommand);
            chdir($origPath);
        }
        else {
            $this->runCommand($gitCommand);
        }
    } // end function executeCommand

    /**
     * Run a command line command
     * @param string $command
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function runCommand($command) {
        exec($command, $output, $returnVar);
        $output = implode("\n", $output);

        if ($returnVar > 0) {
            throw new Git_Exception_Execute(sprintf('%s : %s', $command, $output));
        }
        return $output;
    } // end function runCommand

    /**
     * Getters & Setters |getset
     */
    /**
     * Getter for $this->path
     *
     * @param void
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getPath() {
        return $this->path;
    } // end function getPath()
    
    /**
     * Setter for $this->path
     *
     * @param string
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setPath($arg0) {
        $this->path = $arg0;
        return $this;
    } // end function setPath()
    
    /**
     * Getter for $this->git_work_dir
     *
     * @param void
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getGitWorkingDirectory() {
        return $this->git_work_dir;
    } // end function getGitWorkingDirectory()
    
    /**
     * Setter for $this->git_work_dir
     *
     * @param string
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setGitWorkingDirectory($arg0) {
        $this->git_work_dir = $arg0;
        return $this;
    } // end function setGitWorkingDirectory()
    
    /**
     * Getter for $this->git_index_file
     *
     * @param void
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getGitIndexFile() {
        return $this->git_index_file;
    } // end function getGitIndexFile()
    
    /**
     * Setter for $this->git_index_file
     *
     * @param string
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setGitIndexFile($arg0) {
        $this->git_index_file = $arg0;
        return $this;
    } // end function setGitIndexFile()
    
    /**
     * Getter for $this->git_dir
     *
     * @param void
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getGitDir() {
        return $this->git_dir;
    } // end function getGitDir()
    
    /**
     * Setter for $this->git_dir
     *
     * @param string
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setGitDir($arg0) {
        $this->git_dir = $arg0;
        return $this;
    } // end function setGitDir()

} // end class Git_Lib
?>
