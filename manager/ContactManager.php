<?php

// Le manager est orienté sur la gestion des données et des opérations de traitement métier.

require_once(__DIR__ . '/../helpers/DBConnect.php');
require_once(__DIR__. '/../model/Contact.php');

class ContactManager
{

    /**
     * Méthode pour trouver la liste des contacts
     * @return array
     */
    public static function findAll(): array
    {
        $pdo = DBConnect::getPDO();
        $sql = 'SELECT * FROM `contact`;';
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $contactsFromDatabase = $sth->fetchAll();

        $contacts = []; // Tableau pour stocker les objets Contact

        if (!empty($contactsFromDatabase)) {
            foreach ($contactsFromDatabase as $oneContactFromDatabase) {
                // Créez un objet Contact pour chaque ligne
                $contacts[] = new Contact($oneContactFromDatabase['id'], 
                $oneContactFromDatabase['name'], 
                $oneContactFromDatabase['email'], 
                $oneContactFromDatabase['phone_number']);
            }
        } else {
            // Retourne un tableau vide si aucune donnée n'est trouvée
            return [];
        }

        return $contacts; // Retournez le tableau d'objets Contact
    }


    /** 
     * Méthode pour trouver un contact dans la base des données
     * @param int $id
     * 
     * @return array
     */
    public static function findById(int $id): array |false {

        $pdo = DBConnect::getPDO();
        $sql = 'SELECT * FROM `contact` WHERE `id` =:id;';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $data = $sth->fetch();
             
        if (!$data) {
            return false;
        } else {
            return $data;
        }
    }

    /**
     * Méthode pour insérer un contact dans la base des données
     * @return bool
     */
    public static function insert($contact): bool{

        $pdo = DBConnect::getPDO();
        
        $sql = 'INSERT INTO `contact`(`name`, `email`, `phone_number`) 
        VALUES (:name, :email, :phone_number);';
        
        $sth = $pdo->prepare($sql);
        
        $sth->bindValue(':name', $contact->getName());
        $sth->bindValue(':email', $contact->getEmail());
        $sth->bindValue(':phone_number', $contact->getPhoneNumber());
        
        $sth->execute();
        return $sth->rowCount() > 0;  
    }

    
    /**
     * Méthode pour supprimer un contact dans la list
     * @param int $id
     * 
     * @return bool
     */
    public static function delete(int $id) : bool {
        $pdo = DBConnect::getPDO();

        $sql = 'DELETE FROM `contact` WHERE `id`=:id';

        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->rowCount() > 0;  
    }


    public static function modify($contact) : int {
        
        $pdo = DBConnect::getPDO();

         // Requête contenant un marqueur nominatif
        $sql = 'UPDATE `contact` SET `name` = :name, `email` = :email,`phone_number` = :phone_number 
        WHERE `id` = :id;';
        // Si marqueur nominatif, il faut préparer la requête
        $sth = $pdo->prepare($sql);
    
         // Affectation de la valeur correspondant au marqueur nominatif concerné
         $sth->bindValue(':name', $contact->getName());
        
         $sth->bindValue(':email', $contact->getEmail());
         $sth->bindValue(':phone_number', $contact->getPhoneNumber());
         $sth->bindValue(':id', $contact->getId());
         $operationIsSuccessfull = $sth->execute();
         
         if ($operationIsSuccessfull) {
            // modification dans la base des données
            if ($sth->rowCount() > 0) {
                return 1;
            } else {
            // pas de modification dans la base des données
                return 2;
            }
         } else {
            // problème de connexion à la base des données
            return 3;
         }
    }
}
