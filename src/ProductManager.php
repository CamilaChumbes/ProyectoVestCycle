<?php
class ProductManager {
    private $db;

    public function __construct($host, $dbname, $user, $password) {
        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Registra un nuevo producto en la base de datos.
     */
    public function registerProduct($productName, $category, $subCategory, $productCompany) {
        $query = $this->db->prepare("INSERT INTO products (productName, category, subCategory, productCompany) VALUES (?, ?, ?, ?)");
        return $query->execute([$productName, $category, $subCategory, $productCompany]);
    }

    /**
     * Elimina un producto de la base de datos por su ID.
     */
    public function deleteProduct($productId) {
        $query = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $query->execute([$productId]);
    }
}
?>
