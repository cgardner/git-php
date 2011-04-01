<?php

if (defined('LIBRARY_PATH') === FALSE) {
    $libraryPath = realpath($this->getProject()->getProperty('project.basedir') .'/library');
    if (!$libraryPath) {
        throw new Exception('Library Path does not exist');
    }
    define('LIBRARY_PATH', $libraryPath);
}
