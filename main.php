<?php

require_once 'Commands.php';

$commands = Commands::get();

while(true){
    $line = readline("Entrez votre commande: ");
    $commands->$line();
}