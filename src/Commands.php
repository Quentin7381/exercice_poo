<?php


if(!defined('SEPARATOR')){
    /**
     * @var string SEPARATOR Séparateur de blocs pour le terminal
     */
    define('SEPARATOR', '-------------------------' . "\n");
}

class Commands{
    /**
     * @var Commands $instance Instance Singleton
     */
    protected static $instance = null;

    /**
     * @return Commands Instance Singleton de la classe
     */
    public static function get():Commands{
        if(self::$instance == null){
            self::$instance = new Commands();
        }
        return self::$instance;
    }

    /**
     * Surcharge de la méthode __call, permet un affichage en terminal lorsqu'une commande n'existe pas
     * @param string $name Nom de la commande
     * @param array $arguments Arguments de la commande
     * @return void
     */
    public function __call($name, $arguments){
        echo "La commande $name n'existe pas\n";
    }

    /**
     * Affiche la liste des contacts
     * @return void
     */
    public function list():void{
        $contacts = ContactManager::get()->find();

        echo SEPARATOR;
        echo 'Liste des contacts:'."\n";
        echo SEPARATOR;
        foreach($contacts as $contact){
            echo $contact;
        }
    }

    /**
     * Quitte l'application
     * @return void
     */
    public function exit():void{
        echo "Au revoir\n";
        sleep(2);
        exit(0);
    }

    /**
     * Affiche la liste des commandes disponibles
     * @return void
     */
    public function help():void{
        echo SEPARATOR;
        echo "Liste des commandes disponibles\n";
        echo SEPARATOR;
        echo "list: Liste les contacts\n";
        echo "detail <id>: Affiche les détails d'un contact\n";
        echo "create <name> <email> <phone>: Crée un contact\n";
        echo "update <id> <name> <email> <phone>: Met à jour un contact\n";
        echo "delete <id>: Supprime un contact\n";
        echo "exit: Quitte l'application\n";
        echo SEPARATOR;
    }

    /**
     * Affiche les détails d'un contact
     * @param string $id Identifiant du contact (represente un INT)
     * @return void
     */
    public function detail(?string $id = null):void{
        if($id == null || !is_numeric($id)){
            echo SEPARATOR;
            echo "Vous devez spécifier un id valide\n";
            echo "exemple: detail 3\n";
            echo SEPARATOR;
            return;
        }

        $contacts = ContactManager::get()->find(["id"=> $id]);

        $contact = $contacts[0] ?? null;

        if(is_null($contact)){
            echo SEPARATOR;
            echo "Le contact n'existe pas\n";
            echo SEPARATOR;
            return;
        }

        echo $contact;
    }

    /**
     * Crée un contact
     * @param string $name Nom du contact
     * @param string $email Email du contact
     * @param string $phone Téléphone du contact
     * @return void
     */
    public function create(?string $name = null, ?string $email = null, ?string $phone = null):void{
        if($name == null || $email == null || $phone == null){
            echo SEPARATOR;
            echo "Vous devez spécifier un nom, un email et un numéro de téléphone\n";
            echo "exemple: create John jhon@mail.com 0123456789\n";
            echo SEPARATOR;
            return;
        }

        $contact = ContactManager::get()->create($name, $email, $phone);

        echo SEPARATOR;
        echo 'Contact créé avec succès' . "\n";
        echo SEPARATOR;
        echo $contact;
    }

    /**
     * Supprime un contact
     * @param string $id Identifiant du contact (represente un INT)
     * @return void
     */
    public function delete(?string $id = null):void{
        if($id == null || !is_numeric($id)){
            echo SEPARATOR;
            echo "Vous devez spécifier un id valide\n";
            echo "exemple: delete 3\n";
            echo SEPARATOR;
            return;
        }

        $manager = ContactManager::get();
        $contact = $manager->find(['id' => $id])[0] ?? null;
        $success = $manager->delete($id);

        if(!$success){
            echo SEPARATOR;
            echo "Echec de la suppression\n";
            if(is_null($contact)){
                echo "Le contact n'existe pas\n";
            }
            echo SEPARATOR;
            return;
        }

        echo SEPARATOR;
        echo 'Contact supprimé avec succès :' . "\n";
        echo SEPARATOR;
        echo $contact;
    }

    /**
     * Met à jour un contact
     * @param string $id Identifiant du contact (represente un INT)
     * @param string $name Nom du contact
     * @param string $email Email du contact
     * @param string $phone Téléphone du contact
     * @return void
     */
    public function update(?string $id = null, ?string $name = null, ?string $email = null, ?string $phone = null):void{
        if($id == null || $name == null || $email == null || $phone == null){
            echo SEPARATOR;
            echo "Vous devez spécifier un id, un nom, un email et un numéro de téléphone\n";
            echo "exemple: update 3 John jhon@mail.com 0123456789\n";
            echo SEPARATOR;
            return;
        }

        $manager = ContactManager::get();
        $success = $manager->update($id, $name, $email, $phone);
        $contact = new Contact($id, $name, $email, $phone);

        if(!$success){
            echo SEPARATOR;
            echo "Echec de la mise à jour\n";
            if(empty($manager->find(['id' => $id]))){
                echo "Le contact n°$id n'existe pas\n";
            }
            echo SEPARATOR;
            return;
        }

        echo SEPARATOR;
        echo 'Contact mis à jour avec succès :' . "\n";
        echo SEPARATOR;
        echo $contact;
    }
}
