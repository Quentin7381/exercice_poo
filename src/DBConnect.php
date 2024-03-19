<?php

class DBConnect extends PDO{
    protected static $instance = null;

    public static function get(){
        if(self::$instance == null){
            self::$instance = new DBConnect();
        }
        return self::$instance;
    }

    public function __construct(){
        $config = $this->getConfig();
        parent::__construct(
            'mysql:host=' . $config['host'] .
            ';dbname=' . $config['dbname'],
            $config['user'],
            $config['password']);
    }

    public function getConfig(){
        return array(
            'host' => 'localhost',
            'dbname' => 'carnet_contact',
            'user' => 'root',
            'password' => ''
        );
    }
}