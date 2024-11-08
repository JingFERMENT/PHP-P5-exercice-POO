<?php
require_once(__DIR__ . '/controller/Command.php');

// Display available commands on start
echo "Welcome to the Contact Manager!\nType 'help' for a list of available commands.\n\n";

// une boucle infinie Puisqu’il n’y a pas (encore) de commande pour arrêter le programme, il ne s’arrêtera pas tout seul.
while (true) {

    $line = trim(readline("Please enter your command: "));

    // Split the command and parameters for easier parsing
    $parts = explode(' ', $line, 2);
    $command = strtolower($parts[0]); // the first part of input
    $params = isset($parts[1]) ? $parts[1] : ''; // the 2nd part of input with id

    switch ($command) {
        case 'quit':
            echo "Quit the Contact Manager, good bye !";
            exit;

        case 'list':
            Command::list();
            break;

        case 'help':
            echo "Commandes disponibles :
            list                                    : liste les contacts
            detail [id]                             : afficher le détail d’un contact
            create [name], [email], [phone number]  : créer un contact
            modify [id]                             : modifier un contact
            delete [id]                             : supprimer un contact
            help                                    : afficher cette aide
            quit                                    : quitter le programme\n";
            break;

        case 'detail':
            $pattern = '/^\d+$/';
            if (preg_match($pattern, $params)) {
                $detail = Command::detail($params);
                echo "\n" . $detail['id'] . ', ' . $detail['name'] . ', ' . $detail['email'] . ', ' . $detail['phone_number'] . "\n";
            } else {
                echo "Please provide a valid ID.\n";
            }
            break;

        case 'create':
            $pattern = '/^([^,]+),\s*([^,]+),\s*(.+)$/';
            if (preg_match($pattern, $params, $matches)) {
                $name = $matches[1];
                $email = $matches[2];
                $phoneNumber = $matches[3];

                // name, email and phone number validation
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "Invalid email format.\n";
                } elseif (!preg_match('/^(?:(?:\+33|0)[1-9])(?:[ .-]?\d{2}){4}$/', $phoneNumber)) {
                    echo "Invalid phone number format.\n";
                } elseif (!preg_match('/^[A-Za-zÀ-ÿ]{2,}$/', $name)) {
                    echo "Invalid name format.It should be only characters and a minimum of 2 characters long!\n";
                } else {
                    $contact = new Command();
                    $contact->create($name, $email, $phoneNumber);
                    echo "Contact created successfully.\n";
                }
            } else {
                echo "Invalid format. Use: create [name], [email], [phone number]\n";
            }
            break;

        case 'delete':
            $pattern = '/^\d+$/';
            if (preg_match($pattern, $params)) {
                Command::delete($params);
                echo "Contact deleted successfully.\n";
            } else {
                echo "Please provide a valid ID.\n";
            }
            break;

        case 'modify':
            $pattern = '/^\d+$/';
            if (preg_match($pattern, $params)) {

                $currentDetails = Command::detail($params);

                if ($currentDetails) {
                    $id = $currentDetails['id'];
                    $currentName = $currentDetails['name'];
                    $currentEmail = $currentDetails['email'];
                    $currentPhoneNumber = $currentDetails['phone_number'];

                    echo "Current details: $id, $currentName, $currentEmail, $currentPhoneNumber.\nDo you want to update this contact? (yes/no): ";

                    // Split the current details into name, email, and phone number (adjust as needed)
                    $response = trim(fgets(STDIN)); // Capture user input

                    if (strtolower($response) === 'yes') {
                        echo "Enter new name (or press Enter to keep current):";
                        $name = trim(fgets(STDIN)); // fgets(STDIN): capture user input from the command line in php
                        $name = $name ?: $currentName;

                        echo "Enter new email (or press Enter to keep current): ";
                        $email = trim(fgets(STDIN));
                        $email = $email ?: $currentEmail;

                        echo "Enter new phone number (or press Enter to keep current): ";
                        $phoneNumber = trim(fgets(STDIN));
                        $phoneNumber = $phoneNumber ?: $currentPhoneNumber;

                        $updateSuccess = Command::modify($id, $name, $email, $phoneNumber);

                        echo $updateSuccess ? "Update successful!\n" : "Update failed!\n";
                    } else {
                        echo "Update canceled.\n";
                    }
                } else {
                    echo "Please provide a valid ID.\n";
                }
            } else {
                echo "Please provide a valid ID.\n";
            }
            break;

        default:
            echo "Unknown command. Type 'help' for a list of commands.\n";
            break;
    }

    echo "\nVous avez saisi : $line\n";
}
