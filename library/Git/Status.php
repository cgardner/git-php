<?php

/**
 * Git Status Class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Git_Status extends ArrayIterator {
    /**
     * Public Methods |publics
     */
    /**
     * Constructor
     * @param Git_Base $base
     * @return void
     * @author Craig Gardner <craig_gardner@adp.com>
     **/
    public function __construct(Git_Base $base) {
        // Get list of files in path
        $files = $base->lsFiles();

        parent::__construct($base->getPath());
    } // end function __construct
} // end class Git_Status extends ArrayIterator
