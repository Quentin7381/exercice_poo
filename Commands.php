<?php

class Commands{
    protected static $instance = null;

    public static function get(){
        if(self::$instance == null){
            self::$instance = new Commands();
        }
        return self::$instance;
    }

    public function __call($name, $arguments){
        echo "La commande $name n'existe pas\n";
    }
}