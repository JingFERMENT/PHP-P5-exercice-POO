<?php

require_once(__DIR__.'/ContactManager.php');
require_once(__DIR__.'/Contact.php');

class Command {
    /**
     * 
     * Afficher la liste des contacts
     * 
     * @return void
     */
    public static function list():void {

        $listOfContacts = ContactManager::findAll();

        if (!empty($listOfContacts)) {
            foreach ($listOfContacts as $oneContact) {
                echo "\n".$oneContact->toString()."\n";
            }
        } else {
            echo "Aucun contact trouvé!\n";
        }
    }

    /**
     * afficher le détail d'un contact 
     * 
     * @param int $id
     * 
     * @return void
     */
    public static function detail(int $id):void {

        $detail = ContactManager::findById($id);
        echo "\n". $detail['id'].', '. $detail['name'].', '. $detail['email'].', '. $detail['phone_number']."\n"; 
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

}