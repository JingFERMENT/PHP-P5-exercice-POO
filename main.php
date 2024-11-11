<?php
require_once(__DIR__ . '/controller/Command.php');
require_once(__DIR__ . '/utils/echoHelp.php');
require_once(__DIR__ . '/utils/handleCreate.php');
require_once(__DIR__ . '/utils/handleModify.php');
require_once(__DIR__. '/config/init.php');

echo "Welcome to the Contact Manager!\nType 'help' for a list of available commands.\n\n";

// une boucle infinie Puisqu’il n’y a pas (encore) de commande pour arrêter le programme, il ne s’arrêtera pas tout seul.
while (true) {

    $line = trim(readline("Please enter your command: "));

    // La fonction explode() est utilisée pour diviser une chaîne de caractères en un tableau, en utilisant un délimiteur spécifique.
    // 2 ==> $limit : Nombre maximum d'éléments dans le tableau. 
    $parts = explode(' ', $line, 2);
    $command = strtolower($parts[0]); // 1ère partie de la valeur d'entrée
    $params = isset($parts[1]) ? $parts[1] : ''; // 2ème partie de la valeur d'entrée (valeur avec un id)

    switch ($command) {
            // quand la 1ère partie de valeur d'entrée est "quit"
        case 'quit':
            echo "Quit the Contact Manager, good bye !";
            exit;

            // quand la 1ère partie de valeur d'entrée est "list"
        case 'list':
            Command::list();
            break;

            // quand la 1ère partie de valeur d'entrée est "help"
        case 'help':
            echo echoHelp();
            break;

            // quand la 1ère partie de valeur d'entrée est "detail"
        case 'detail':

            // vérifier si une chaîne contient uniquement des chiffres 
            // ^début de la chaîne \d+: rechercher des chiffres $: fin de la chaîne
            $pattern = '/^\d+$/';

            // preg_match: vérifier si une chaîne correspond à une expression régulière donnée
            if (preg_match($pattern, $params)) {
                $detail = Command::detail($params);
                echo $detail ? "\nPlease find the detail as follow:\n" . $detail['id'] . ', ' . $detail['name'] . ', ' . $detail['email'] . ', ' . $detail['phone_number'] . "\n" :
                INVALID_ID_MSG;
            } else {
                echo INVALID_ID_MSG;
            }
            break;

            // quand la 1ère partie de valeur d'entrée est "create"
        case 'create':

            // pour extraire trois parties distinctes dans une chaîne de texte, séparées par des virgules.
            // ^ indique le début de la chaîne
            // [^,]+ Cherche un ou plusieurs caractères (+) qui ne sont pas des virgules ([^,]).
            // \s* : Capture zéro ou plusieurs espaces blancs après la virgule. 
            // (.+) : capture un ou plusieurs caractères, jusqu'à la fin de la chaîne.
            $pattern = '/^([^,]+),\s*([^,]+),\s*(.+)$/';

            // vérifier si la chaîne $params correspond à $pattern et, 
            // $matches : si une correspondance est trouvée, elle stocke les parties correspondantes dans le tableau $matches.
            if (preg_match($pattern, $params, $matches)) {
                $name = $matches[1];
                $email = $matches[2];
                $phoneNumber = $matches[3];

                handleCreate($email, $phoneNumber, $name);
            } else {
                echo "Invalid format. Use: create [name], [email], [phone number]\n";
            }
            break;

        case 'delete':
            if (preg_match(ID_PATTERN, $params)) {
                $deleteContact = Command::delete($params);
                echo $deleteContact ? "Contact deleted successfully.\n" : INVALID_ID_MSG;
            } else {
                echo INVALID_ID_MSG;
            }
            break;

        case 'modify':
            if (preg_match(ID_PATTERN, $params)) {

                $currentDetails = Command::detail($params);

                if ($currentDetails) {
                    $id = $currentDetails['id'];
                    $currentName = $currentDetails['name'];
                    $currentEmail = $currentDetails['email'];
                    $currentPhoneNumber = $currentDetails['phone_number'];

                    echo "Current details: $id, $currentName, $currentEmail, $currentPhoneNumber.\nDo you want to update this contact? (yes/no): ";

                    $response = strtolower(trim(fgets(STDIN)));

                    if ($response === 'yes') {
                        
                        $name = handleModify("Please enter new name (or press Enter to keep current): ", NAME_PATTERN, "Invalid name format. It should only contain letters and be at least 2 characters long.\n", $currentName);
                        
                        $email = handleModify("Please enter new email (or press Enter to keep current): ", FILTER_VALIDATE_EMAIL,"Invalid email format.\n", $currentEmail, true);
                        
                        $phoneNumber = handleModify("Please enter new phone number (or press Enter to keep current): ", PHONE_PATTERN, "Invalid phone number format.\n", $currentPhoneNumber);

                        Command::modify($id, $name, $email, $phoneNumber);

                    } else { // si pas envie de modifier ou pas de saisie 
                        echo "Update canceled.\n";
                    }
                } else { // pas de id existant 
                    echo INVALID_ID_MSG;
                }
            } else { // message erreur dans le cas où il n'y a pas de chiffre numérique 
                echo INVALID_ID_MSG;
            }
            break;

        default:
            echo "Unknown command. Type 'help' for a list of commands.\n";
            break;
    }

    echo "\nYou entered: $line\n";
}
