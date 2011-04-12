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
            $this->configure($base);
        }
        
    } // end function __construct
    /**
     * Configure the object based on the passed associative array
     * @param array $options
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function configure(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = sprintf('set%s', str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
    } // end function configure

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
     * Set a Git Configuration option
     * @param string $name
     * @param mixed $value
     * @return mixed
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function configSet($name, $value) {
        $this->executeCommand('config', array($name, $value));
    } // end function configSet

    /**
     * Get a Git Configuration option
     * @param string $name
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function configGet($name) {
        return $this->executeCommand('config', array($name));
    } // end function configGet

    /**
     * Get the size of an object
     * @param string $sha
     * @return integer
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function objectSize($sha) {
        return (int)$this->executeCommand('cat-file', array('-s', $sha));
    } // end function objectSize
    /**
     * Get a list of Configuration Options
     * @param void
     * @return array
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function configList() {
        $config = parse_ini_file(sprintf('%s/.git/config', $this->getGitWorkingDirectory()), TRUE);
        return $config;
    } // end function configList
    /**
     * Get the Contents of a git object
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function objectContents($sha) {
        return $this->executeCommand('cat-file', array('-p', $sha));
    } // end function objectContents

    /**
     * Perform a rev-parse on an object
     * @param string $string
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function revParse($string) {
        // If the string is a SHA1, return it
        if (preg_match('@[A-Fa-f0-9]{40}@', $string)) {
            return $string;
        }
        $rev = FALSE;
        foreach (array('heads', 'remotes', 'tags') as $dir) {
            $path = implode(DIRECTORY_SEPARATOR, array(
                $this->getGitDir(),
                'refs',
                $dir,
                $string,
            ));
            if (file_exists($path)) {
                $rev = $path;
                break;
            }
        }

        if (!$rev) {
            try {
                return $this->executeCommand('rev-parse', array($string));
            }
            catch (Git_Exception $e) {
                throw new Git_Exception(sprintf('Git Revision Not Found: %s', $string));
            }
        }
        else {
            return trim(file_get_contents($rev));
        }
    } // end function revParse

    /**
     * Get the full tree information
     * @param string $sha
     * @return mixed
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function fullTree($sha) {
        return $this->executeCommand('ls-tree', array('-r', $sha));
    } // end function fullTree
    /**
     * Get a list of the elements in a tree
     * @param string $sha
     * @return array
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function lsTree($sha) {
        $data = array(
            'tree' => array(),
            'blob' => array(),    
        );

        $treeData = explode("\n", $this->executeCommand('ls-tree', array($sha)));
        foreach ($treeData as $line) {
            list($info, $filename) = explode("\t", $line);
            list($mode, $type, $sha) = explode(' ', $info);
            $data[$type][$filename] = array(
                'mode' => $mode,
                'sha' => $sha,
            );
        }

        return $data;
    } // end function lsTree
    /**
     * Get a SHA for a tag
     * @param string $tagName
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function tagSha($tagName) {
        $head = implode(DIRECTORY_SEPARATOR, array(
            $this->getGitDir(),
            'refs',
            'tags',
            $tagName,
        ));
        if (file_exists($head)) {
            return trim(file_get_contents($head));
        }
        return $this->executeCommand('show-ref', array('--tags', '-s', $tagName));
    } // end function tagSha
    /**
     * Get the object type for an object
     * @param string $sha
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function objectType($sha) {
        return $this->executeCommand('cat-file', array('-t', $sha));
    } // end function objectType

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
            $output = $this->runCommand($gitCommand);
            chdir($origPath);
        }
        else {
            $output = $this->runCommand($gitCommand);
        }
        return $output;
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
