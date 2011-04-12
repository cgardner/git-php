<?php

defined('BASE_DIR') ||
    define('BASE_DIR', $this->getProject()->getProperty('project.basedir'));
if (defined('LIBRARY_PATH') === FALSE) {
    $libraryPath = realpath(BASE_DIR .'/library');
    if (!$libraryPath) {
        throw new Exception('Library Path does not exist');
    }
    define('LIBRARY_PATH', $libraryPath);
}


set_include_path(implode(PATH_SEPARATOR, array(
    LIBRARY_PATH,
    get_include_path(),
)));
