<?php

/**
 * Git-PHP Library
 *  This library provides a pure php implementation of git.  Based on the git-ruby library by Scott Chacon
 *
 * @author Craig Gardner
 * @version 0.0.1
 * @copyright Goodpacket, 12 January, 2009
 * @package git-php
 **/

/**
 * Define DocBlock
 **/

 
class Git_PHP {
  
  /**
   * Class Constructor
   *
   * @return void
   * @author Craig Gardner
   **/
  public function __construct() {
    require 'lib/base.class.php';
  } // end function __construct()
  
  /**
   * initialize a new repository in the given directory
   *
   * @param string directory of the files that will be under version control with git
   * @param array Options
   *  repository => '/path/to/alt_git_dir',
   *  index => '/path/to/alt_index'
   * @return object
   * @author Craig Gardner
   **/
  public function init($working_dir = '.', $options = array()) {
    return Git_PHP_Base::init($working_dir, $options);
  } // end function init()
  
  /**
   * open a bare repository
   *
   * @param string location of the git files
   * @param array Options
   * @return object
   * @author Craig Gardner
   **/
  public function bare($git_dir, $options) {
    return Git_PHP_Base::bare($git_dir, $options);
  } // end function bare()
  
  /**
   * Open an existing git working directory
   *
   * @param string Working directory
   * @param array Options
   *  repository => '/path/to/alt_git_dir',
   *  index => '/path/to/alt_index'
   * @return object
   * @author Craig Gardner
   **/
  public function open($working_dir, $options) {
    return Git_PHP_Base::open($working_dir, $options);
  } // end function open()
  
  /**
   * Clone a remote repository
   *
   * @param string Remote Repository
   * @param string Local working directory
   * @param array Options Options
   *  repository => '/path/to/alt_git_dir',
   *  index => '/path/to/alt_index'
   *  bare => true (does a bare clone)
   * @return object
   * @author Craig Gardner
   **/
  public function clone($repository, $name, $options) {
    return Git_PHP_Base::clone($repository, $name, $options);
  } // end function clone()
  
}

?>