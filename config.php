<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gestion_cartons');

// Autres configurations
define('DEBUG', true); // Activer le mode débogage

// Fonction pour afficher les erreurs en mode débogage
function debug($var)
{
    if (DEBUG) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}
