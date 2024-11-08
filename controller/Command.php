<?php

// s'occupe principalement de la logique de la requête, du routage, et de l'interface utilisateur.

require_once(__DIR__.'/manager/ContactManager.php');
require_once(__DIR__.'/model/Contact.php');

class Command {
    /**
     * 
     * Afficher la liste des contacts
     * 
     * @return void
     */
    public static function list() {
        try {
            $listOfContacts = ContactManager::findAll();

            if (!empty($listOfContacts)) {
                foreach ($listOfContacts as $oneContact) {
                    echo "\n". $oneContact;
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
     * @return void
     */
    public static function detail(int $id):array {

        $detail = ContactManager::findById($id);
        if (!$detail) {
            echo "Contact with ID $id not found.\n";
            return [];
        }
        return $detail;
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
    public function create(string $name, string $email, string $phoneNumber):bool{

        $creation = new Contact();

        $creation->setName($name);
        $creation->setEmail($email);
        $creation->setPhoneNumber($phoneNumber);

        $addCreation = ContactManager::insert($creation);

        return $addCreation > 0;  

    }

    public static function delete(int $id):bool {

        $delete = ContactManager::delete($id);

        return $delete > 0;  

    }

    public static function modify(int $id, string $name, string $email, string $phoneNumber):bool {

        $modification = new Contact();
        $modification->setId($id);
        $modification->setName($name);
        $modification->setEmail($email);
        $modification->setPhoneNumber($phoneNumber);

        return ContactManager::modify($modification);
    }

}