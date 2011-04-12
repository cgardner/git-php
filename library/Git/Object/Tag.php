<?php
require_once 'Git/Object/Abstract.php';

/**
 * Git Tag Object Class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Git_Object_Tag extends Git_Object_Abstract {
    /**
     * Properties |props
     */
    /**
     * Name
     * @var string
     **/
    private $name;
    
    /**
     * Public Methods |publics
     */
    /**
     * Constructor
     * @param Git_Base $base
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function __construct(Git_Base $base, $sha, $name) {
        parent::__construct($base, $sha);
        $this->setName($name);
    } // end function __construct

    /**
     * Getters and Setters |getset
     */
    /**
     * Getter for $this->name
     *
     * @param void
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getName() {
        return $this->name;
    } // end function getName()
    
    /**
     * Setter for $this->name
     *
     * @param string
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setName($arg0) {
        $this->name = $arg0;
        return $this;
    } // end function setName()

} // end class Git_Object_Tag extends Git_Object_Abstract
