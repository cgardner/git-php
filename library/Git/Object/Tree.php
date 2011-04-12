<?php
require_once 'Git/Object/Abstract.php';
require_once 'Git/Object/Blob.php';

/**
 * Git Tree Object
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Git_Object_Tree extends Git_Object_Abstract {
    /**
     * Properties |props
     */
    /**
     * Mode
     * @var mixed
     **/
    private $mode;

    /**
     * Trees
     * @var mixed
     **/
    private $trees;

    /**
     * Blobs
     * @var mixed
     **/
    private $blobs;

    /**
     * Public Methods |publics
     */
    /**
     * Constructor
     * @param Git_Base $base
     * @param string $sha
     * @param mixed $mode
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function __construct(Git_Base $base, $sha, $mode = NULL) {
        parent::__construct($base, $sha);
        $this->setMode($mode);
    } // end function __construct

    /**
     * Get the Full Tree
     * @param void
     * @return mixed
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function fullTree() {
        $lib = $this->getBase()->getLib();
        return $lib->fullTree($lib->revParse($this->getObjectish()));
    } // end function fullTree
    
    /**
     * Private Methods |privates
     */
    /**
     * Check and parse the tree structure
     * @param void
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    private function checkTree() {
        $trees = array();
        $blobs = array();
        $data = $this->getBase()->getLib()->lsTree($this->getObjectish());
        foreach ($data['tree'] as $key => $tree) {
            $trees[$key] = new Git_Object_Tree($this->getBase(), $tree['sha'], $tree['mode']);
        }
        $this->setTrees($trees);

        foreach ($data['blob'] as $key => $blob) {
            $blobs[$key] = new Git_Object_Blob($this->getBase(), $blob['sha'], $blob['mode']);
        }
        $this->setBlobs($blobs);
    } // end function checkTree

    /**
     * Getters and Setters |getset
     */
    /**
     * Getter for $this->blobs
     *
     * @param void
     * @return mixed
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getBlobs() {
        if (is_null($this->blobs)) {
            $this->checkTree();
        }
        return $this->blobs;
    } // end function getBlobs()
    
    /**
     * Setter for $this->blobs
     *
     * @param mixed
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setBlobs($arg0) {
        $this->blobs = $arg0;
        return $this;
    } // end function setBlobs()
    
    /**
     * Getter for $this->trees
     *
     * @param void
     * @return mixed
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function getTrees() {
        if (is_null($this->trees)) {
            $this->checkTree();
        }
        return $this->trees;
    } // end function getTrees()
    
    /**
     * Setter for $this->trees
     *
     * @param mixed
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function setTrees($arg0) {
        $this->trees = $arg0;
        return $this;
    } // end function setTrees()
    
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

} // end class Git_Object_Tree extends Git_Object_Abstract
