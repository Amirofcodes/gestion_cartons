<?php
require_once 'config.php';
require_once 'database.php';

function setupDatabase()
{
    $db = Database::getInstance()->getConnection();

    try {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "
        -- Drop existing tables
        DROP TABLE IF EXISTS capacites;
        DROP TABLE IF EXISTS cartons;
        DROP TABLE IF EXISTS produits;

        -- Create tables
        CREATE TABLE produits (
          id INT AUTO_INCREMENT PRIMARY KEY,
          nom VARCHAR(255) NOT NULL,
          dimension VARCHAR(20) NOT NULL,
          poids FLOAT NOT NULL
        );

        CREATE TABLE cartons (
          id INT AUTO_INCREMENT PRIMARY KEY,
          nom VARCHAR(10) NOT NULL,
          poids_max FLOAT NOT NULL
        );

        CREATE TABLE capacites (
          id INT AUTO_INCREMENT PRIMARY KEY,
          carton_id INT,
          produit_id INT,
          capacite INT NOT NULL,
          FOREIGN KEY (carton_id) REFERENCES cartons(id),
          FOREIGN KEY (produit_id) REFERENCES produits(id)
        );

        -- Insert products
        INSERT INTO produits (nom, dimension, poids) VALUES
        ('Verre a pieds', '10x10x20', 0.5),
        ('Verre en bois', '8x8x12', 0.3),
        ('Assiette', '25x25x2', 0.6),
        ('Bol', '15x15x8', 0.4),
        ('Tasse', '12x12x10', 0.3),
        ('Plat', '30x30x4', 0.8),
        ('Pichet', '20x20x25', 1.0),
        ('Saladier', '18x18x12', 0.7),
        ('Coupe', '12x12x15', 0.5),
        ('Carafe', '22x22x30', 1.2);

        -- Insert cartons
        INSERT INTO cartons (nom, poids_max) VALUES
        ('A1', 3.0), ('A2', 5.0), ('B1', 4.0), ('B2', 4.5), ('C1', 4.5),
        ('C2', 5.0), ('D1', 6.0), ('D2', 6.5), ('E1', 7.0), ('E2', 7.5),
        ('F1', 8.0), ('F2', 8.5);

        -- Insert capacities
        INSERT INTO capacites (carton_id, produit_id, capacite) VALUES
        -- A1
        (1, 1, 13), (1, 2, 7), (1, 3, 8), (1, 4, 12), (1, 5, 10),
        (1, 6, 6), (1, 7, 5), (1, 8, 7), (1, 9, 9), (1, 10, 4),
        -- A2
        (2, 1, 26), (2, 2, 14), (2, 3, 16), (2, 4, 20), (2, 5, 18),
        (2, 6, 12), (2, 7, 10), (2, 8, 14), (2, 9, 15), (2, 10, 8),
        -- B1
        (3, 1, 18), (3, 2, 10), (3, 3, 10), (3, 4, 15), (3, 5, 12),
        (3, 6, 8), (3, 7, 7), (3, 8, 10), (3, 9, 12), (3, 10, 6),
        -- B2
        (4, 1, 20), (4, 2, 11), (4, 3, 12), (4, 4, 18), (4, 5, 14),
        (4, 6, 9), (4, 7, 8), (4, 8, 12), (4, 9, 14), (4, 10, 7),
        -- C1
        (5, 1, 22), (5, 2, 13), (5, 3, 14), (5, 4, 22), (5, 5, 16),
        (5, 6, 10), (5, 7, 9), (5, 8, 15), (5, 9, 16), (5, 10, 9),
        -- C2
        (6, 1, 25), (6, 2, 15), (6, 3, 18), (6, 4, 24), (6, 5, 18),
        (6, 6, 11), (6, 7, 11), (6, 8, 18), (6, 9, 18), (6, 10, 10),
        -- D1
        (7, 1, 30), (7, 2, 16), (7, 3, 20), (7, 4, 30), (7, 5, 20),
        (7, 6, 12), (7, 7, 12), (7, 8, 20), (7, 9, 20), (7, 10, 12),
        -- D2
        (8, 1, 35), (8, 2, 18), (8, 3, 24), (8, 4, 32), (8, 5, 22),
        (8, 6, 14), (8, 7, 14), (8, 8, 22), (8, 9, 22), (8, 10, 14),
        -- E1
        (9, 1, 40), (9, 2, 20), (9, 3, 28), (9, 4, 35), (9, 5, 25),
        (9, 6, 15), (9, 7, 16), (9, 8, 25), (9, 9, 25), (9, 10, 16),
        -- E2
        (10, 1, 45), (10, 2, 22), (10, 3, 30), (10, 4, 38), (10, 5, 27),
        (10, 6, 16), (10, 7, 18), (10, 8, 28), (10, 9, 28), (10, 10, 18),
        -- F1
        (11, 1, 50), (11, 2, 25), (11, 3, 35), (11, 4, 40), (11, 5, 30),
        (11, 6, 18), (11, 7, 20), (11, 8, 30), (11, 9, 30), (11, 10, 20),
        -- F2
        (12, 1, 55), (12, 2, 27), (12, 3, 40), (12, 4, 42), (12, 5, 32),
        (12, 6, 20), (12, 7, 22), (12, 8, 32), (12, 9, 32), (12, 10, 22);
        ";

        $db->exec($sql);
        echo "Database setup completed successfully.";
    } catch (PDOException $e) {
        echo "Error setting up database: " . $e->getMessage();
    }
}

// Run the setup function
setupDatabase();
