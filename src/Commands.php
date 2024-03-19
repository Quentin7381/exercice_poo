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

    public function list(){
        $contacts = ContactManager::get()->find();
        echo '-------------------------' . "\n";
        foreach($contacts as $contact){
            echo $contact->id.' : ' . $contact->name . "\n";
            echo $contact->email . "\n";
            echo $contact->phone . "\n";
            echo '-------------------------' . "\n";
        }
    }

    public function exit(){
        echo "Bye bye\n";
        sleep(2);
        exit(0);
    }
}