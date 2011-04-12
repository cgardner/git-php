<?php

/**
 * Abstract Git Object Class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Git_Object_Abstract {
    /**
     * Properties |props
     */
    /**
     * String that relates to a Git Object
     * @var string
     **/
    private $objectish;

    /**
     * Size of the object
     * @var integer
     **/
    private $size;

    /**
     * Type of the Object
     * @var string
     **/
    private $type;

    /**
     * Mode of the object
     * @var string
     **/
    private $mode;
    
    /**
     * Base Object
     * @var Git_Base
     **/
    private $base;
    
    /**
     * SHA1 value for the object
     * @var string
     **/
    private $sha;

    /**
     * Contents of the Object
     * @var mixed
     **/
    private $contents;
    
    /**
     * Public Methods |publics
     */
    /**
     * Class Constructor
     * @param Git_Base $base
     * @param string $objectish
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function __construct($base, $objectish) {
        $this->setBase($base);
        $this->setObjectish($objectish);
        $this->setSize($this->getBase()->getLib()->objectSize($objectish));
    } // end function __construct

    /**
     * Getters and Setters |getset
     */
    /**
     * Getter for $this->contents
     *
     * @param void
     * @return mixed
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getContents() {
        if (is_null($this->contents)) {
            $this->setContents($this->getBase()->getLib()->objectContents($this->getObjectish()));
        }
        return $this->contents;
    } // end function getContents()
    
    /**
     * Setter for $this->contents
     *
     * @param mixed
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setContents($arg0) {
        $this->contents = $arg0;
        return $this;
    } // end function setContents()
    /**
     * Getter for $this->sha
     *
     * @param void
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getSha() {
        if (is_null($this->sha)) {
            $this->setSha($this->getBase()->getLib()->revparse($this->getObjectish()));
        }
        return $this->sha;
    } // end function getSha()
    
    /**
     * Setter for $this->sha
     *
     * @param string
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setSha($arg0) {
        $this->sha = $arg0;
        return $this;
    } // end function setSha()
    /**
     * Getter for $this->base
     *
     * @param void
     * @return Git_Base
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    protected function getBase() {
        return $this->base;
    } // end function getBase()
    
    /**
     * Setter for $this->base
     *
     * @param Git_Base
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    protected function setBase($arg0) {
        $this->base = $arg0;
        return $this;
    } // end function setBase()

    /**
     * Getter for $this->mode
     *
     * @param void
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getMode() {
        return $this->mode;
    } // end function getMode()
    
    /**
     * Setter for $this->mode
     *
     * @param string
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setMode($arg0) {
        $this->mode = $arg0;
        return $this;
    } // end function setMode()
    
    /**
     * Getter for $this->type
     *
     * @param void
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function getType() {
        return $this->type;
    } // end function getType()
    
    /**
     * Setter for $this->type
     *
     * @param string
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function setType($arg0) {
        $this->type = $arg0;
        return $this;
    } // end function setType()
    
    /**
     * Getter for $this->size
     *
     * @param void
     * @return integer
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getSize() {
        return $this->size;
    } // end function getSize()
    
    /**
     * Setter for $this->size
     *
     * @param integer
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setSize($arg0) {
        $this->size = $arg0;
        return $this;
    } // end function setSize()
    
    /**
     * Getter for $this->objectish
     *
     * @param void
     * @return string
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getObjectish() {
        return $this->objectish;
    } // end function getObjectish()
    
    /**
     * Setter for $this->objectish
     *
     * @param string
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setObjectish($arg0) {
        $this->objectish = $arg0;
        return $this;
    } // end function setObjectish()

} // end class Git_Object_Abstract
?>
