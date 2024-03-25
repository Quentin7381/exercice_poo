<?php

/**
 * Class Autoloader
 * Permet de charger automatiquement les classes
 * Le dossier cible est la propriété rootDir
 */
class Autoloader{

    protected $rootDir = __DIR__;

    /**
     * Initialise et enregistre la fonction autoload
     *
     * @param string|null $rootDir Dossier cible
     */
    public function __construct(?string $rootDir = null){
        if($rootDir != null){
            $this->rootDir = $rootDir;
        }

        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * Charge une classe
     *
     * @param $className Nom de la classe
     */
    public function autoload($className):void{
        $path = $this->rootDir . '/' . $className . '.php';
        if(file_exists($path)){
            require_once $path;
        }
    }
}

new Autoloader();
