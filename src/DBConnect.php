<?php

/**
 * Permet de gerer la connexion à la base de donnees
 * La connexion est directement parametree
 * @property PDO $instance Instance de connexion à la base de données
 */
class DBConnect extends PDO
{
    protected static $instance = null;

    /**
     * @return DBConnect Instance Singleton de la classe
     */
    public static function get()
    {
        if (self::$instance == null) {
            self::$instance = new DBConnect();
        }
        return self::$instance;
    }

    /**
     * Constructeur de la classe
     * Initialise la connexion à la base de données
     */
    public function __construct()
    {
        $config = $this->getConfig();
        parent::__construct(
            'mysql:host=' . $config['host'] .
            ';dbname=' . $config['dbname'],
            $config['user'],
            $config['password']
        );
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Retourne la configuration de la connexion
     * Permet une surcharge future pour ne pas avoir les identifiants en dur
     * @return array Configuration de la connexion
     */
    public function getConfig(): array
    {
        return array(
            'host' => 'localhost',
            'dbname' => 'carnet_contact',
            'user' => 'root',
            'password' => ''
        );
        $filePath = __DIR__ . '/../db.json';
        if (file_exists($filePath)) {
            return json_decode(file_get_contents($filePath), true);
        }
    }
}