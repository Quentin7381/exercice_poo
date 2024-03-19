<?php

class Autoloader{

    protected $rootDir = __DIR__;

    public function __construct($rootDir = null){
        if($rootDir != null){
            $this->rootDir = $rootDir;
        }

        spl_autoload_register(array($this, 'autoload'));
    }

    public function autoload($className){
        $path = $this->rootDir . '/' . $className . '.php';
        if(file_exists($path)){
            require_once $path;
        }
    }
}

new Autoloader();