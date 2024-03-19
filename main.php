<?php

require_once 'src/Autoloader.php';

$commands = Commands::get();

while(true){
    $line = readline("Entrez votre commande: ");
    $args = explode(' ', $line);
    $command = array_shift($args);
    $commands->$command(...$args);
}