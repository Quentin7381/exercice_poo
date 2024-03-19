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
        echo 'Liste des contacts:'."\n";
        echo '-------------------------' . "\n";
        foreach($contacts as $contact){
            echo $contact->id.' : ' . $contact->name . "\n";
            echo $contact->email . "\n";
            echo $contact->phone . "\n";
            echo '-------------------------' . "\n";
        }
    }

    public function exit(){
        echo "Au revoir\n";
        sleep(2);
        exit(0);
    }

    public function help(){
        echo '-------------------------' . "\n";
        echo "Liste des commandes disponibles\n";
        echo '-------------------------' . "\n";
        echo "list: Liste les contacts\n";
        echo "exit: Quitte l'application\n";
        echo '-------------------------' . "\n";
    }

    public function detail($id = null){
        if($id == null){
            echo "Vous devez spécifier un id\n";
            echo "exemple: detail 3\n";
            return;
        }

        $contacts = ContactManager::get()->find(["id"=> $id]);
        $contact = $contacts[0];

        echo '-------------------------' . "\n";
        echo 'Détails du contact n°'.' : ' . $contact->id . "\n";
        echo '-------------------------' . "\n";
        echo $contact->name . "\n";
        echo $contact->email . "\n";
        echo $contact->phone . "\n";
        echo '-------------------------' . "\n";
    }

    public function create($name = null, $email = null, $phone = null){
        if($name == null || $email == null || $phone == null){
            echo "Vous devez spécifier un nom, un email et un numéro de téléphone\n";
            echo "exemple: create John jhon@mail.com 0123456789\n";
        }

        $contact = ContactManager::get()->create($name, $email, $phone);

        echo '-------------------------' . "\n";
        echo 'Contact créé avec succès' . "\n";
        echo '-------------------------' . "\n";
        echo 'id: ' . $contact->id . "\n";
        echo 'nom: ' . $contact->name . "\n";
        echo 'email: ' . $contact->email . "\n";
        echo 'téléphone: ' . $contact->phone . "\n";
        echo '-------------------------' . "\n";
    }

    public function delete($id){
        $manager = ContactManager::get();
        $contact = $manager->find(['id' => $id])[0] ?? null;
        $success = $manager->delete($id);

        if(!$success){
            echo '-------------------------' . "\n";
            echo "Echec de la suppression\n";
            if(is_null($contact)){
                echo "Le contact n'existe pas\n";
            }
            echo '-------------------------' . "\n";
            return;
        }

        echo '-------------------------' . "\n";
        echo 'delete : '. $contact->id . "\n";
        echo '-------------------------' . "\n";
        echo 'Contact supprimé avec succès :' . "\n";
        echo 'id : ' . $contact->id . "\n";
        echo 'nom : '. $contact->name . "\n";
        echo 'mail : '. $contact->email . "\n";
        echo 'téléphone : '. $contact->phone . "\n";
        echo '-------------------------' . "\n";
    }
}