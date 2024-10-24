<?php


require_once(__DIR__ . '/Command.php');

// Boucle infinie qui continue tant que la condition est vraie
while (true) {
    // Demande à l'utilisateur d'entrer une commande et stocke la saisie
    $line = readline("Entrez votre commande : ");

    // l'utilisateur demande d'afficher la liste des contactes
    if ($line === 'list') {
        echo "Liste des contacts :\n\nid, name, email, phone number\n";
        // Appel à la méthode pour récupérer la liste des contacts
        Command::list();
    }

    // l'utilisateur demande d'afficher le détail d'un contact
    $pattern = '/^detail\s+(\d+)$/'; // le patterne à matcher pour détailler un contact
    if (preg_match($pattern, $line, $matches)) {
        $id = $matches[1];
        Command::detail($id);
        break;
    } else {
        echo 'Invalid format!';
    }

    $pattern = '/^create\s+([^,]+),\s+([^,]+),\s+([^\s]+)$/';
    if (preg_match($pattern, $line, $matches)) {
        $name = $matches[1];       // John
        $email = $matches[2];      // johne@test.com
        $phoneNumber = $matches[3]; // 0123456789
        $contact = new Command();
        
        $contact->create($name, $email, $phoneNumber);
    } else {
        echo 'Invalid format!';
    }

    echo "Vous avez saisi : $line\n";
}
