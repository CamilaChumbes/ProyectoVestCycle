<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/CategoryManager.php'; // Asegúrate de que la ruta sea correcta

class CategoryManagerTest extends TestCase {
    private $con;
    private $categoryManager;

    protected function setUp(): void {
        // Crea una conexión de base de datos de prueba con root sin contraseña
        $this->con = new mysqli("localhost", "root", "", "test_database");
        $this->categoryManager = new CategoryManager($this->con);

        // Limpia la tabla antes de cada prueba
        $this->con->query("DELETE FROM category");
    }

    protected function tearDown(): void {
        // Limpia la tabla después de cada prueba y cierra la conexión
        $this->con->query("DELETE FROM category");
        $this->con->close();
    }

    public function testCreateCategory() {
        $category = "Test Category";
        $description = "This is a test description.";

        // Llama al método para crear la categoría
        $result = $this->categoryManager->createCategory($category, $description);
        $this->assertTrue($result);

        // Verifica que la categoría fue insertada correctamente
        $query = $this->con->query("SELECT * FROM category WHERE categoryName = 'Test Category'");
        $this->assertEquals(1, $query->num_rows, "La categoría no fue insertada en la base de datos");

        // Recupera los datos insertados y verifica su contenido
        $data = $query->fetch_assoc();
        $this->assertEquals($category, $data['categoryName']);
        $this->assertEquals($description, $data['categoryDescription']);

        // Muestra los datos insertados en la consola
        echo "Datos insertados:\n";
        print_r($data);
    }

    public function testDeleteCategory() {
        // Primero, inserta una categoría de prueba
        $this->categoryManager->createCategory("Delete Category", "To be deleted");

        // Obtén el ID de la categoría recién creada
        $query = $this->con->query("SELECT id FROM category WHERE categoryName = 'Delete Category'");
        $row = $query->fetch_assoc();
        $id = $row['id'];

        // Ahora, prueba la función de eliminación
        $result = $this->categoryManager->deleteCategory($id);
        $this->assertTrue($result);

        // Verifica que la categoría fue eliminada
        $query = $this->con->query("SELECT * FROM category WHERE id = $id");
        $this->assertEquals(0, $query->num_rows, "La categoría no fue eliminada de la base de datos");

        // Muestra un mensaje en la consola para confirmar que la categoría fue eliminada
        echo "La categoría con ID $id fue eliminada.\n";
    }
}
