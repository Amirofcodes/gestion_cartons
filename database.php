<?php
require_once 'config.php';

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if tables exist, if not, run the setup script
            if (!$this->tablesExist()) {
                require_once 'setup_database.php';
                setupDatabase();
            }
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    private function tablesExist()
    {
        $tables = ['produits', 'cartons', 'capacites'];
        foreach ($tables as $table) {
            $result = $this->conn->query("SHOW TABLES LIKE '$table'");
            if ($result->rowCount() == 0) {
                return false;
            }
        }
        return true;
    }
}
