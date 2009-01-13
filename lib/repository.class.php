<?php
/**
 * Repository Class
 *
 * @author Craig Gardner
 * @copyright Goodpacket, 12 January, 2009
 * @package git-php
 **/

/**
 * Define DocBlock
 **/


class Repository {
  
  /**
   * Initializing a git repository using PHP
   *
   * @return boolean
   * @author Craig Gardner
   **/
  private function init($dir, $bare = FALSE) {
    if (!file_exists($dir) && is_dir($dir)) {
      $this->mkdir($dir);
    } // end if (!file_exists($dir) && is_dir($dir))
    
    if (chdir($dir)) {
      if (file_exists('objects')) {
        return FALSE; // Repository has already been created
      } // end if (file_exists('objects'))
      
      $this->create_initial_config($bare);
      
      // Create the directory structure
      $this->mkdir('refs/heads');
      $this->mkdir('refs/tags');
      $this->mkdir('objects/info');
      $this->mkdir('objects/pack');
      $this->mkdir('branches');
      $this->mkdir('hooks');
      $this->mkdir('info');
      
      // Add the files to the directories
      $this->add_file('description', 'Unnamed repository; edit this file to name it for gitweb.');
      $this->add_file('HEAD', "ref: refs/heads/master\n");
      $this->add_file('info/exclude', "# *.[oa]\n# *~");
      // Hook files
      $this->add_file('hooks/applypatch-msg', '# add shell script and make executable to enable');
      $this->add_file('hooks/post-commit', '# add shell script and make executable to enable');
      $this->add_file('hooks/post-receive', '# add shell script and make executable to enable');
      $this->add_file('hooks/post-update', '# add shell script and make executable to enable');
      $this->add_file('hooks/pre-applypatch', '# add shell script and make executable to enable');
      $this->add_file('hooks/pre-commit', '# add shell script and make executable to enable');
      $this->add_file('hooks/pre-rebase', '# add shell script and make executable to enable');
      $this->add_file('hooks/update', '# add shell script and make executable to enable');
    } // end if (chdir($dir))
    
    return TRUE;
  } // end function init()
  
  /**
   * Create an initial git ini file
   *
   * @param boolean
   * @return void
   * @author Craig Gardner
   **/
  private function create_initial_config($bare = FALSE) {
    $bare_status = ($bare ? 'true' : 'false');
    $config = "[core]\n\trepositoryformatversion = 0\n\tfilemode = true\n\tbare = $bare_status\n\tlogallrefupdates = true";
    file_put_contents('config', $config);
  } // end function create_initial_config()
  
  /**
   * wrapper for mkdir($dir, 0755, TRUE)
   *
   * @return void
   * @author Craig Gardner
   **/
  private function mkdir($dir) {
    mkdir($dir, 0755, TRUE)
  } // end function mkdir()
  
  
  /**
   * wrapper for file_put_contents
   *
   * @param string Filename of the file to be written
   * @param string Contents of the file to be written
   * @return integer The number of bytes that were written, or FALSE on failure
   * @author Craig Gardner
   **/
  private function add_file($name, $contents) {
    return file_put_contents($name, $contents);
  } // end function add_file()
}

?>