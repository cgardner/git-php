<?php
require_once 'Git/Object/Abstract.php';
require_once 'Git/Object/Tag.php';
require_once 'Git/Object/Tree.php';
require_once 'Git/Object/Blob.php';
require_once 'Git/Object/Commit.php';

/**
 * Git Object Class
 * @package Git
 * @author Craig Gardner <craig_gardner@adp.com>
 **/
class Git_Object extends Git_Object_Abstract {
    /**
     * Public Methods |publics
     */
    /**
     * Factory method for Git_Objects
     * @param Git_Base $base
     * @param string $objectish
     * @param string $type
     * @param boolean $isTag
     * @return Git_Base_Abstract
     * @author Craig Gardner <craig_gardner@adp.com>
     * @throws Git_Object_Exception_TagDoesNotExist
     **/
    public static function factory($base, $objectish, $type = NULL, $isTag = FALSE) {
        if ($isTag) {
            $sha = $base->getLib()->tagSha($objectish);
            if ($sha == '') {
                throw new Git_Object_Exception_TagDoesNotExist(sprintf('Tag %s Does not exist', $objectish));
            }
            return new Git_Object_Tag($base, $sha, $objectish);
        }

        $type = $base->getLib()->objectType($objectish);
        switch ($type) {
            case 'blob':
                $klass = 'Git_Object_Blob';
                break;

            case 'commit':
                $klass = 'Git_Object_Commit';
                break;

            case 'tree':
                $klass = 'Git_Object_Tree';
                break;
        }

        return new $klass($base, $objectish);
    } // end function factory
} // end class Git_Object extends Git_Object_Abstract
