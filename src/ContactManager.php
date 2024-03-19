<?php

class ContactManager{
    protected static $columns = ['id', 'name', 'email', 'phone_number'];
    protected static $instance = null;
    protected static $db;

    public static function get(){
        if(self::$instance == null){
            self::$instance = new ContactManager();
        }
        return self::$instance;
    }
    
    protected function __construct(){
        if(self::$db == null){
            self::$db = new DBConnect();
        }
    }

    public function find($arguments = []){
        // Creation de la requete
        $query = new Query();
        $query->select('*');
        $query->from('contact');
        $query = $query->print();

        // Execution de la requete
        $stmt = self::$db->query($query);

        // Traitement des resultats
        $contacts = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $contacts[] = new Contact(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['phone_number']
            );
        }

        return $contacts;
    }
}