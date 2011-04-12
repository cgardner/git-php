<?php
require_once 'Git/Object/Abstract.php';

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
                $klass = 'Blob';
                break;

            case 'commit':
                $klass = 'Commit';
                break;

            case 'tree':
                $klass = 'Tree';
                break;

            default:
                throw new Git_Exception(sprintf('Object Type %s does not exist', $type));
        }

        return new $klass($base, $objectish);
    } // end function factory
    

} // end class Git_Object extends Git_Object_Abstract
