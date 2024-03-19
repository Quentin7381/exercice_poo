<?php

require_once 'src/Autoloader.php';

$commands = Commands::get();

while(true){
    $line = readline("Entrez votre commande: ");
    $commands->$line();
}