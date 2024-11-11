<?php

define('DSN', 'mysql:dbname=php-p5-exercice-1;host=localhost');
define('LOGIN', 'admin_php_p5_exercice_1');
define('PASSWORD', 'rB0!b2WYyuFGq5XP');

// Expressions régulières et messages d'erreur dans des constantes
define('ID_PATTERN', '/^\d+$/');
define('NAME_PATTERN', '/^[A-Za-zÀ-ÿ]{2,}$/');
define('PHONE_PATTERN', '/^(?:(?:\+33|0)[1-9])(?:[ .-]?\d{2}){4}$/');
define('INVALID_ID_MSG', "Please provide a valid ID.\n");