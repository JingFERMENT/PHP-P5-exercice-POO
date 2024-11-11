<?php

// s'occupe principalement de la logique de la requête, du routage, et de l'interface utilisateur.

require_once(__DIR__ . '/../manager/ContactManager.php');
require_once(__DIR__ . '/../model/Contact.php');

class Command
{
    /**
     * 
     * Afficher la liste des contacts
     * 
     * @return void
     */
    public static function list()
    {
        try {
            $listOfContacts = ContactManager::findAll();

            if (!empty($listOfContacts)) {
                foreach ($listOfContacts as $oneContact) {
                    echo "\n" . $oneContact;
                }
            } else {
                echo "Aucun contact trouvé!\n";
            }
        } catch (\Throwable $th) {
            echo "erreur base des données.";
        }
    }

    /**
     * afficher le détail d'un contact 
     * 
     * @param int $id
     * 
     * @return array|string
     */
    public static function detail(int $id): array|false
    {
        try {
            $detail = ContactManager::findById($id);
            return $detail;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Méthode pour créer un nouveau contact
     * 
     * @param string $name
     * @param string $email
     * @param string $phoneNumber
     * 
     * @return [type]
     */
    public function create(string $name, string $email, string $phoneNumber): bool
    {
        $creation = new Contact();

        $creation->setName($name);
        $creation->setEmail($email);
        $creation->setPhoneNumber($phoneNumber);

        $addCreation = ContactManager::insert($creation);

        return $addCreation > 0;
    }

    public static function delete(int $id): bool
    {
        // Vérifier si le contact existe
        if (!ContactManager::findById($id)) {
            return false; // Si le contact n'existe pas, retourne `false`
        }

        try {
            $delete = ContactManager::delete($id);
            return $delete > 0;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function modify(int $id, string $name, string $email, string $phoneNumber): bool
    {
        // Vérifier si le contact existe avant de procéder
        if(!ContactManager::findById($id)) {
            return false;
        }

        try {
            // Créer et configurer l'objet Contact avec les nouvelles informations
                $modification = new Contact();
                $modification->setId($id);
                $modification->setName($name);
                $modification->setEmail($email);
                $modification->setPhoneNumber($phoneNumber);
                
                $resultCode = ContactManager::modify($modification);

                if ($resultCode == 1) {
                    echo "Update successful! The information has been updated!\n";
                    return true;
                } elseif ($resultCode == 2) {
                    echo "Update successful! No changes were necessary.\n";
                    return true;
                } else {
                    echo 'problem of database connexion!';
                    return false;
                }
        } catch (\Throwable $th) {
            return false;
        }
    }
}
