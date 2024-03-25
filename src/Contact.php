<?php

if(!defined('SEPARATOR')){
    define('SEPARATOR', '-------------------------' . "\n");
}

/**
 * Represente un contact
 * @property int $id Identifiant du contact
 * @property string $name Nom du Contact
 * @property string $email Email du contact
 * @property string $phone Téléphone du contact
 *  
 */
class Contact{
    /**
     * Identifiant du contact
     * @var int
     */
    protected $id;
    /**
     * Nom du contact
     * @var string
     */
    protected $name;
    /**
     * Email du contact
     * @var string
     */
    protected $email;
    /**
     * Téléphone du contact
     * @var string
     */
    protected $phone;

    /**
     * Permet d'acceder aux propriétés de la classe
     * @param string $name Nom de la propriété
     * @return mixed
     */
    public function __get($name){
        return $this->$name;
    }

    /**
     * Permet de modifier les propriétés de la classe
     * @param string $name Nom de la propriété
     * @param mixed $value Valeur de la propriété
     * @return void
     */
    public function __construct($id, $name, $email, $phone){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    /**
     * Permet d'afficher les informations du contact
     * @return string
     */
    public function __toString():string{
        $str = 'id: ' . $this->id . "\n";
        $str .= 'nom: ' . $this->name . "\n";
        $str .= 'email: ' . $this->email . "\n";
        $str .= 'téléphone: ' . $this->phone . "\n";
        $str .= SEPARATOR;

        return $str;
    }
}
