<?php

/**
 * Path class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Git_Path {
    /**
     * Properties |props
     */
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
     * @param string $path
     * @param bool $checkPath
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function __construct($path, $checkPath = TRUE) {
        if ($checkPath && file_exists($path)) {
            $path = realpath($path);
        }
        else {
            throw new Git_Exception(sprintf('Path does not Exist: %s', $path));
        }
        $this->setPath($path);
    } // end function __construct

    /**
     * Determine whether or not the path is readable
     * @param void
     * @return boolean
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function isReadable() {
        return is_readable($this->getPath());
    } // end function isReadable

    /**
     * Determine whether or not the path is writable
     * @param void
     * @return boolean
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function isWritable() {
        return is_writable($this->getPath());
    } // end function isWritable

    /**
     * Determine whether or not a path exists
     * @param void
     * @return boolean
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function exists() {
        return file_exists($this->getPath());
    } // end function exists

    /**
     * Getters and Setters |getset
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
} // end class Git_Path extends DirectoryIterator
