<?php

/**
 * Base Class
 *
 * @author Craig Gardner
 * @version $Id$
 * @copyright Goodpacket, 12 January, 2009
 * @package git-php
 **/

/**
 * Define DocBlock
 **/

/**
 * Base Class
 *
 * @package git-php
 * @author Craig Gardner
 **/
class Git_PHP_Base {
  /**
   * Working Directory
   *
   * @var object
   **/
  private $working_directory = NULL;
  
  /**
   * Working Repository
   *
   * @var string
   **/
  private $repository = NULL;
  
  /**
   * Working Index
   *
   * @var string
   **/
  private $index = NULL;
  
  /**
   * Unknown
   *
   * @var string
   **/
  private $lib = NULL;
  
  /**
   * Class Constructor
   *
   * @return void
   * @author Craig Gardner
   **/
  public function __construct($options) {
    // If working_directory has been set in the options, adjust the repository and index.
    if (($working_dir = $options['working_directory']) == TRUE) { 
      $options['repository'] = $options['repository'] ? $options['repository'] : "$working_dir/.git";
      $options['index'] = $options['index'] ? $options['index'] : "{$options['repository']}/index";
    } // end if ($working_dir = $options['working_directory'])
    
    // Set the class variables
    $this->working_directory = ($options['working_directory'] ? new Git_PHP_WorkingDirectory($options['working_directory']) : NULL);
    $this->repository = ($options['repository'] ? new Git_PHP_Repository($options['repository']) : NULL);
    $this->index = ($options['index'] ? new Git_PHP_Index($this, $options['index'], FALSE) : NULL);
    $this->lib = NULL;
    return $this->lib;
  } // end function __construct()
  
  /**
   * Open a bare git repository
   *
   * @return object
   * @author Craig Gardner
   **/
  public function bare($git_dir, $options=array()) {
    $defaults = array(
      'repository'          => realpath($git_dir)
    );
    
    $git_options = array_merge($defaults, $options);
    
    return new Git_PHP_Base($git_options);
  } // end function bare()
  
  /**
   * Open a new git project from the working directory
   *
   * @return object
   * @author Craig Gardner
   **/
  public function open($working_dir, $options) {
    $defaults = array(
      'working_directory'   => realpath($git_dir),
    );
    $git_options = array_merge($defaults, $options);
    
    return new Git_PHP_Base($git_options);
  } // end function open()
  
  /**
   * Initialize a git repository
   *
   * @return object
   * @author Craig Gardner
   **/
  public function init($working_dir, $options) {
    $defaults = array(
      'working_directory'   => realpath($working_dir),
      'repository'          => "$working_dir/.git",
    );
    $git_options = array_merge($defaults, $options);
    
    // if the working directory isn't a directory, create it.
    if (!is_dir($git_options['working_directory'])) {
      $this->mkdir($git_options['working_directory']);
    } // end if ($git_options['working_directory'])
    
    Git_PHP_Repository::init($git_options['repository']);
    return new Git_PHP_Base($git_options);
  } // end function init()
  
  /**
   * wrapper for mkdir($dir, 0755, TRUE)
   *
   * @return void
   * @author Craig Gardner
   **/
  private function mkdir($dir) {
    mkdir($dir, 0755, TRUE);
  } // end function mkdir()

  
} // END class Base

?>