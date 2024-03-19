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

        // Ajout des arguments de recherche
        $stmtArgs = [];
        foreach($arguments as $key => $value){
            $query->where([[$key, $key]]);
            $stmtArgs[':'.$key] = $value;
        }

        // Execution de la requete
        $query = $query->print();
        $stmt = self::$db->prepare($query);
        $stmt->execute($stmtArgs);

        // Traitement des resultats
        $contacts = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $contacts[] = new Contact(
                $row['id'] ?? '',
                $row['name'] ?? '',
                $row['email'] ?? '',
                $row['phone_number'] ?? '',
            );
        }

        return $contacts;
    }

    public function create($name, $email, $phone){
        $query = new Query();
        $query->insert_into('contact');
        $query->values(['name' => 'name', 'email'=> 'email','phone_number'=> 'phone']);
        $query = $query->print();
        
        $arguments = [
            ':name' => $name,
            ':email'=> $email,
            ':phone'=> $phone
        ];

        $stmt = self::$db->prepare($query);
        $success = $stmt->execute($arguments);
        $id = self::$db->lastInsertId();

        // Recuperation du contact cree
        $contacts = $this->find(['id'=> $id]);
        $contact = $contacts[0];

        return $contact;
    }

    public function delete($id){
        if(empty($this->find(['id'=> $id]))){
            return false;
        }

        $query = new Query();
        $query->delete('contact');
        $query->where([['id', 'id']]);
        $query = $query->print();
        
        $stmt = self::$db->prepare($query);
        $success = $stmt->execute([':id' => $id]);
        return $success;
    }
}