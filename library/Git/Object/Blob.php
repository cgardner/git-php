<?php
require_once 'Git/Object/Abstract.php';

/**
 * Git_Object_Blob
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Git_Object_Blob extends Git_Object_Abstract {
    /**
     * Properties |props
     */
    /**
     * Mode
     * @var mixed
     **/
    private $mode;
    
    /**
     * Public Methods |publics
     */
    /**
     * Constructor
     * @param Git_Base $base
     * @param string $objectish
     * @param mixed $mode
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function __construct(Git_Base $base, $objectish, $mode = NULL) {
        parent::__construct($base, $objectish);
        $this->setMode($mode);
    } // end function __construct
    
    /**
     * Getters and Setters |getset
     */
    /**
     * Getter for $this->mode
     *
     * @param void
     * @return mixed
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getMode() {
        return $this->mode;
    } // end function getMode()
    
    /**
     * Setter for $this->mode
     *
     * @param mixed
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setMode($arg0) {
        $this->mode = $arg0;
        return $this;
    } // end function setMode()

} // end class Git_Object_Blob extends Git_Object_Abstract
