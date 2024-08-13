# Documentation complète du projet Gestion des Cartons

## Structure du projet

Le projet est structuré de la manière suivante :

1. `config.php` : Fichier de configuration
2. `database.php` : Gestion de la connexion à la base de données
3. `setup_database.php` : Script pour initialiser la base de données
4. `models/Produit.php` : Modèle pour les produits
5. `models/Carton.php` : Modèle pour les cartons
6. `calculateur.php` : Logique principale pour le calcul des cartons optimaux
7. `index.php` : Point d'entrée de l'application
8. `styles.css` : Feuille de style pour l'interface utilisateur

## Explication détaillée de chaque fichier

### config.php

Ce fichier contient les constantes de configuration pour la base de données et le mode de débogage.

### database.php

Ce fichier gère la connexion à la base de données en utilisant le pattern Singleton. Il vérifie également si les tables nécessaires existent et, si ce n'est pas le cas, exécute le script de configuration de la base de données.

### setup_database.php

Ce script initialise la base de données en créant les tables nécessaires et en insérant les données initiales pour les produits, les cartons et leurs capacités.

### models/Produit.php

Ce modèle gère les opérations liées aux produits, notamment la récupération de tous les produits et l'insertion de nouveaux produits.

### models/Carton.php

Ce modèle gère les opérations liées aux cartons, notamment la récupération de tous les cartons avec leurs capacités et l'insertion de nouveaux cartons.

### calculateur.php

Ce fichier contient la logique principale pour calculer les cartons optimaux nécessaires pour emballer une quantité donnée d'un produit spécifique.

### index.php

C'est le point d'entrée de l'application. Il initialise les modèles, récupère les données de la base de données, formate ces données pour le calcul, exécute les cas de test et affiche les résultats.

### styles.css

Cette feuille de style définit l'apparence de l'interface utilisateur, assurant une présentation claire et agréable des données et des résultats.

## Fonctionnement de l'application

1. L'utilisateur accède à `index.php`.
2. Le script vérifie si la base de données est configurée. Si ce n'est pas le cas, il exécute `setup_database.php`.
3. Les données des produits et des cartons sont récupérées de la base de données.
4. L'algorithme de calcul des cartons optimaux est exécuté pour chaque cas de test.
5. Les résultats sont affichés dans une interface utilisateur formatée.

Cette structure modulaire permet une séparation claire des responsabilités, facilitant la maintenance et l'extension future de l'application.
