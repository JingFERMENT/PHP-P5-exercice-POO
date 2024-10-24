<?php

require_once (__DIR__ . '/../config/init.php');

class DBConnect
{
    private static $pdo;
    
    public static function getPDO()
    {
        // Si l'instance PDO n'a pas encore été créée, on la crée
        if (!self::$pdo) {
            // Création d'une nouvelle connexion PDO avec les constantes DSN, LOGIN et PASSWORD
            self::$pdo = new PDO(DSN, LOGIN, PASSWORD);

            // Définition de l'attribut par défaut pour récupérer les résultats sous forme d'objets
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        // Retourne l'instance PDO (réutilisée si elle a déjà été créée)
        return self::$pdo;
    }
}