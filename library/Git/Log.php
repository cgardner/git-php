<?php

/**
 * Git_Log Class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Git_Log extends ArrayIterator {
    /**
     * Properties |props
     */
    /**
     * Determine whether the log is dirty
     * @var boolean
     **/
    private $dirtyFlag = FALSE;

    /**
     * Git_Base Object
     * @var Git_Base
     **/
    private $base;
    
    /**
     * Maximum number of items in the log
     * @var integer
     **/
    private $count;

    /**
     * Public Methods |publics
     */
    /**
     * Constructor
     * @param Git_Base $base
     * @param integer $count
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function __construct(Git_Base $base, $count = 30) {
        $this->setBase($base);
        $this->setCount($count);
    } // end function __construct


    /**
     * Private Methods |privates
     */
    /**
     * Make the log dirty
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function dirtyLog() {
        $this->dirtyLog = TRUE;
    } // end function dirtyLog

    /**
     * Update the log if it isn't dirty
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function checkLog() {
        if ($this->dirtyLog === FALSE) {
            $this->runLog();
            $this->dirtyLog = FALSE;
        }
    } // end function checkLog

    /**
     * Run the git-log command
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function runLog() {
        $log = $this->getBase()->getLib()->fullLogCommits(array(
            'count' => $this->getCount(),
            'object' => $this->getObject(),
            'path_limiter' => $this->getPath(),
            'since' => $this->getSince(),
            'author' => $this->getAuthor(),
            'grep' => $this->getGrep(),
            'skip' => $this->getSkip(),
            'until' => $this->getUntil(),
            'between' => $this->getBetween(),
        ));
    } // end function runLog

    /**
     * Getters and Setters |getset
     */
    /**
     * Getter for $this->count
     *
     * @param void
     * @return integer
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getCount() {
        return $this->count;
    } // end function getCount()
    
    /**
     * Setter for $this->count
     *
     * @param integer
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setCount($arg0) {
        $this->count = $arg0;
        return $this;
    } // end function setCount()
    
    /**
     * Getter for $this->base
     *
     * @param void
     * @return Git_Base
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function getBase() {
        return $this->base;
    } // end function getBase()
    
    /**
     * Setter for $this->base
     *
     * @param Git_Base
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function setBase($arg0) {
        $this->base = $arg0;
        return $this;
    } // end function setBase()

} // end class Git_Log extends ArrayIterator
