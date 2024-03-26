<?php

/**
 * Permet de gerer les contacts
 */
class ContactManager
{
    /**
     * @var array $columns Colonnes de la table contact
     */
    protected static array $columns = ['id', 'name', 'email', 'phone_number'];
    /**
     * @var ContactManager $instance Instance Singleton
     */
    protected static ?ContactManager $instance = null;
    /**
     * @var ?PDO $db Instance de connexion à la base de donnees
     */
    protected static ?PDO $db = null;

    /**
     * @return ContactManager Instance Singleton de la classe
     */
    public static function get(): ?ContactManager
    {
        if (self::$instance == null) {
            self::$instance = new ContactManager();
        }
        return self::$instance;
    }

    /**
     * Constructeur de la classe
     * Initialise la connexion à la base de donnees
     */
    protected function __construct()
    {
        if (self::$db == null) {
            self::$db = new DBConnect();
        }
    }

    /**
     * Permet de rechercher des contacts
     * @param array $arguments Arguments de recherche
     * Les arguments de recherche sont un tableau de paires clef->valeurAttendue
     * 
     * @return array Tableau de contacts
     */
    public function find(array $arguments = []): array
    {
        // Creation de la requete
        $query = new Query();
        $query->select('*');
        $query->from('contact');

        // Ajout des arguments de recherche
        $stmtArgs = [];
        foreach ($arguments as $key => $value) {
            $query->where([[$key, $key]]);
            $stmtArgs[':' . $key] = $value;
        }

        // Execution de la requete
        $query = $query->print();
        $stmt = self::$db->prepare($query);
        $stmt->execute($stmtArgs);

        // Traitement des resultats
        $contacts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (empty ($row) || empty ($row['id'])) {
                continue;
            }

            $contacts[] = new Contact(
                $row['id'] ?? '',
                $row['name'] ?? '',
                $row['email'] ?? '',
                $row['phone_number'] ?? '',
            );
        }

        return $contacts;
    }

    /**
     * Permet de creer un contact
     * @param string $name Nom du contact
     * @param string $email Email du contact
     * @param string $phone Téléphone du contact
     */
    public function create(string $name, string $email, string $phone): ?Contact
    {
        $query = new Query();
        $query->insert_into('contact');
        $query->values(['name' => 'name', 'email' => 'email', 'phone_number' => 'phone']);
        $query = $query->print();

        $arguments = [
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone
        ];

        $stmt = self::$db->prepare($query);
        $success = $stmt->execute($arguments);
        $id = self::$db->lastInsertId();

        // Recuperation du contact cree
        $contacts = $this->find(['id' => $id]);
        $contact = $contacts[0] ?? null;

        return $contact;
    }

    /**
     * Permet de supprimer un contact
     * @param string  $id Identifiant du contact (represente un INT)
     * @return bool Resultat de la suppression
     */
    public function delete(string $id): bool
    {
        if (empty ($this->find(['id' => $id]))) {
            // Apparement, pas d'exception PDO ni de $success a false si contact inexistant
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

    /**
     * Permet de mettre à jour un contact
     * @param string $id Identifiant du contact (represente un INT)
     * @param string $name Nom du contact
     * @param string $email Email du contact
     * @param string $phone Téléphone du contact
     * @return bool Resultat de la mise à jour
     */
    public function update(string $id, string $name, string $email, string $phone): bool
    {
        if (empty ($this->find(['id' => $id]))) {
            return false;
        }

        $query = new Query();
        $query->update('contact');
        $query->set([['name', 'name'], ['email', 'email'], ['phone_number', 'phone']]);
        $query->where([['id', 'id']]);
        $query = $query->print();

        $arguments = [
            ':id' => $id,
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone
        ];

        $stmt = self::$db->prepare($query);
        $success = $stmt->execute($arguments);
        return $success;
    }
}