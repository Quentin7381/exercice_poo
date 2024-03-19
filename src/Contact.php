<?php

class Contact{
    protected $id;
    protected $name;
    protected $email;
    protected $phone;

    public function __get($name){
        return $this->$name;
    }

    public function __construct($id, $name, $email, $phone){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }
}