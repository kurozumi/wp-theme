<?php

namespace Theme\Hook;

/**
 * Singleton
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
abstract class Singleton {

    public function register() {}
    
    protected function __construct() {}

    public static function getInstance() {
        
        static $_instance = null;
        
        if ($_instance === null) {
            $_instance = new static;
        }
        return $_instance;
    }

    final function __clone() {
        throw new \Exception('Clone is not allowed against' . __CLASS__);
    }

    final function __wakeup() {
        throw new \Exception('Unserialize is not allowed against' . __CLASS__);
    }

}
