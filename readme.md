# Gestion des Cartons

Ce projet est une application PHP pour optimiser l'utilisation des cartons lors de l'emballage de produits.

## Description

L'application "Gestion des Cartons" permet de calculer le nombre optimal de cartons nécessaires pour emballer une quantité donnée d'un produit spécifique. Elle prend en compte les dimensions et le poids des produits, ainsi que les capacités et les limites de poids des différents types de cartons disponibles.

## Fonctionnalités

- Calcul optimal des cartons nécessaires pour l'emballage
- Gestion d'une base de données de produits et de cartons
- Interface utilisateur pour visualiser les résultats des calculs

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache, Nginx, etc.)

## Installation

1. Clonez ce dépôt dans le répertoire de votre serveur web :

   ```
   git clone https://github.com/Amirofcodes/gestion_cartons.git
   ```

2. Configurez votre base de données MySQL en modifiant le fichier `config.php` :

   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'votre_utilisateur');
   define('DB_PASS', 'votre_mot_de_passe');
   define('DB_NAME', 'gestion_cartons');
   ```

3. Accédez à l'application via votre navigateur web.

## Utilisation

1. Ouvrez l'application dans votre navigateur.
2. L'application affichera automatiquement les résultats pour les cas de test prédéfinis.
3. Pour ajouter de nouveaux produits ou cartons, modifiez le fichier `setup_database.php` et réexécutez-le.

## Structure du projet

- `config.php` : Configuration de la base de données
- `database.php` : Gestion de la connexion à la base de données
- `setup_database.php` : Initialisation de la base de données
- `models/` : Modèles pour les produits et les cartons
- `calculateur.php` : Logique de calcul des cartons optimaux
- `index.php` : Point d'entrée de l'application
- `styles.css` : Styles CSS pour l'interface utilisateur
