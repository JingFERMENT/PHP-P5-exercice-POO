<?php

require_once(__DIR__ . '/../config/init.php');

class DBService
{
    private static $pdo;

    public static function getPDO()
    {
        // Si l'instance PDO n'a pas encore été créée, on la crée
        if (!self::$pdo) {

            try {
                // Création d'une nouvelle connexion PDO avec les constantes DSN, LOGIN et PASSWORD
                self::$pdo = new PDO(DSN, LOGIN, PASSWORD);

                // Définition de l'attribut par défaut pour récupérer les résultats sous forme d'objets
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //code...
            } catch (\Throwable $e) {
                echo "Impossible de se connecter à la base de données. Veuillez vérifier vos paramètres de connexion.";
                error_log("Erreur de connexion PDO : " . $e->getMessage());
                die;
            }
        }

        // Retourne l'instance PDO (réutilisée si elle a déjà été créée)
        return self::$pdo;
    }
}
