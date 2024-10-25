<?php
require_once(__DIR__ . '/Command.php');

// Boucle infinie qui continue tant que la condition est vraie
while (true) {
    // Demande à l'utilisateur d'entrer une commande et stocke la saisie
    $line = readline("Entrez votre commande (create, delete, detail, help, list, quit): ");

    // l'utilisateur demande d'afficher la liste des contactes
    if ($line === 'list') {
        echo "Liste des contacts :\n\nid, name, email, phone number\n";
        Command::list();
    }

    // l'utilisateur demande d'afficher le détail d'un contact
    $pattern = '/^detail\s+(\d+)$/'; // le patterne à matcher pour détailler un contact
    if (preg_match($pattern, $line, $matches)) {
        $id = $matches[1];
        Command::detail($id);
    }

    // l'utilisateur demande de créer un noveau contact
    $pattern = '/^create\s+([^,]+),\s+([^,]+),\s+([^\s]+)$/';
    if (preg_match($pattern, $line, $matches)) {
        $name = $matches[1];       // John
        $email = $matches[2];      // johne@test.com
        $phoneNumber = $matches[3]; // 0123456789
        
        $contact = new Command();
        $contact->create($name, $email, $phoneNumber);
    } 

    // l'utilisateur demande de supprimer un contact
    $pattern = '/^delete\s+(\d+)$/';
    if (preg_match($pattern, $line, $matches)) {
        $id = $matches[1];
        Command::delete($id);
    }

    // l'utilisateur demande de l'aider 
    if (trim($line) === 'help') {
        echo "\nCommandes disponibles :
        \nlist                                  : liste les contacts
        \ndetail [id]                           : affiche le détail d’un contact
        \ncreate [name] [email] [phone number]  : crée un contact
        \ndelete [id]                           : supprime un contact
        \nquit                                  : quitte le programme
        \nhelp                                  : affiche cette aide\n";
    }

    echo "\nVous avez saisi : $line\n";
}
