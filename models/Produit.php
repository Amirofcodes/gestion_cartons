<?php
require_once __DIR__ . '/../database.php';

class Produit
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->conn->query("SELECT * FROM produits");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($nom, $dimension, $poids)
    {
        $stmt = $this->conn->prepare("INSERT INTO produits (nom, dimension, poids) VALUES (:nom, :dimension, :poids)");
        $stmt->execute(['nom' => $nom, 'dimension' => $dimension, 'poids' => $poids]);
    }
}
