<?php
require_once __DIR__ . '/../database.php';

class Carton
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->conn->query("SELECT c.*, GROUP_CONCAT(CONCAT(p.nom, ':', ca.capacite) SEPARATOR ';') as capacites 
                                    FROM cartons c
                                    JOIN capacites ca ON c.id = ca.carton_id
                                    JOIN produits p ON ca.produit_id = p.id
                                    GROUP BY c.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($nom, $poids_max, $capacites)
    {
        $this->conn->beginTransaction();
        try {
            $stmt = $this->conn->prepare("INSERT INTO cartons (nom, poids_max) VALUES (:nom, :poids_max)");
            $stmt->execute(['nom' => $nom, 'poids_max' => $poids_max]);
            $carton_id = $this->conn->lastInsertId();

            foreach ($capacites as $produit_nom => $capacite) {
                $stmt = $this->conn->prepare("INSERT INTO capacites (carton_id, produit_id, capacite) 
                                              SELECT :carton_id, id, :capacite FROM produits WHERE nom = :produit_nom");
                $stmt->execute(['carton_id' => $carton_id, 'capacite' => $capacite, 'produit_nom' => $produit_nom]);
            }

            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
}
