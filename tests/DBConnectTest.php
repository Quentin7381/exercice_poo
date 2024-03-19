<?php

require_once __DIR__.'/TestSetup.php';

class DBConnectTest extends TestSetup{

    protected static $className = 'DBConnect';

    function test__instanceIsValid(){
        // Pas d'erreur lors de l'instantiation
        $db = new DBConnect();

        // L'instance n'est pas nulle
        $this->assertNotNull($db);

        // L'instance est bien de la classe attendue
        $this->assertInstanceOf(PDO::class, $db);
    }

}