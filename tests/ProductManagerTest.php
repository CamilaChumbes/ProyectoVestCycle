<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/ProductManager.php';

class ProductManagerTest extends TestCase {
    private $dbHost = 'localhost';
    private $dbName = 'test_db';
    private $dbUser = 'root';
    private $dbPassword = '';
    private $productManager;

    protected function setUp(): void {
        // Crear conexión a la base de datos MySQL
        $pdo = new PDO("mysql:host=$this->dbHost", $this->dbUser, $this->dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crear base de datos temporal para pruebas
        $pdo->exec("DROP DATABASE IF EXISTS $this->dbName");
        $pdo->exec("CREATE DATABASE $this->dbName");
        $pdo->exec("USE $this->dbName");
        $pdo->exec("
            CREATE TABLE products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                productName VARCHAR(255) NOT NULL,
                category VARCHAR(255) NOT NULL,
                subCategory VARCHAR(255) NOT NULL,
                productCompany VARCHAR(255) NOT NULL
            )
        ");

        $this->productManager = new ProductManager($this->dbHost, $this->dbName, $this->dbUser, $this->dbPassword);
    }

    public function testRegisterProduct() {
        $result = $this->productManager->registerProduct("Camisa", "Ropa", "Casual", "Zara");
        $this->assertTrue($result);

        // Verificar que el producto se registró correctamente
        $pdo = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPassword);
        $query = $pdo->query("SELECT * FROM products WHERE productName = 'Camisa'");
        $product = $query->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($product);
        $this->assertEquals("Camisa", $product['productName']);
        $this->assertEquals("Ropa", $product['category']);
        $this->assertEquals("Casual", $product['subCategory']);
        $this->assertEquals("Zara", $product['productCompany']);

        // Mensaje en consola
        if ($product) {
            echo "Producto registrado exitosamente: " . $product['productName'] . "\n";
        } else {
            echo "Error al registrar el producto.\n";
        }
    }

    public function testDeleteProduct() {
        // Insertar producto de prueba
        $pdo = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPassword);
        $pdo->exec("INSERT INTO products (productName, category, subCategory, productCompany) VALUES ('Pantalón', 'Ropa', 'Formal', 'H&M')");
        $productId = $pdo->lastInsertId();

        // Verificar que el producto existe antes de eliminarlo
        $query = $pdo->query("SELECT * FROM products WHERE id = $productId");
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $this->assertNotEmpty($product);

        // Probar eliminación
        $result = $this->productManager->deleteProduct($productId);
        $this->assertTrue($result);

        // Verificar que el producto ya no exista
        $query = $pdo->query("SELECT * FROM products WHERE id = $productId");
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $this->assertEmpty($product);

        // Mensaje en consola
        if (empty($product)) {
            echo "Producto eliminado exitosamente: ID $productId\n";
        } else {
            echo "Error al eliminar el producto.\n";
        }
    }
}
?>
