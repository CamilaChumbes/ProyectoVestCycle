<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/SubCategoryManager.php';

class SubCategoryManagerTest extends TestCase {
    private $con;
    private $subCategoryManager;

    protected function setUp(): void {
        // Configuración de la conexión a la base de datos de prueba
        $this->con = new mysqli("localhost", "root", "", "test_database");
        $this->con->query("DELETE FROM subcategory");
        $this->con->query("DELETE FROM category");

        // Inserta una categoría de prueba para asociarla a la subcategoría
        $this->con->query("INSERT INTO category (id, categoryName) VALUES (1, 'Test Category')");

        $this->subCategoryManager = new SubCategoryManager($this->con);
    }

    protected function tearDown(): void {
        $this->con->query("DELETE FROM subcategory");
        $this->con->query("DELETE FROM category");
        $this->con->close();
    }

    public function testCreateSubCategory() {
        echo "=== Prueba de creación de subcategoría ===\n";

        $categoryId = 1;
        $subCategoryName = "Test SubCategory";

        // Llama al método para crear una subcategoría
        $result = $this->subCategoryManager->createSubCategory($categoryId, $subCategoryName);
        $this->assertTrue($result, "La subcategoría no se creó correctamente.");

        // Verifica que la subcategoría fue insertada correctamente
        $query = $this->con->query("SELECT * FROM subcategory WHERE subcategory = '$subCategoryName'");
        $data = $query->fetch_assoc();
        $this->assertEquals($categoryId, $data['categoryid']);
        $this->assertEquals($subCategoryName, $data['subcategory']);

        echo "Datos insertados:\n";
        print_r($data);
    }

    public function testUpdateSubCategory() {
        echo "=== Prueba de edición de subcategoría ===\n";

        // Crea una subcategoría para editarla
        $this->con->query("INSERT INTO subcategory (id, categoryid, subcategory) VALUES (1, 1, 'Old SubCategory')");

        $subCategoryId = 1;
        $newCategoryId = 1; // Mantiene la misma categoría en este caso
        $newSubCategoryName = "Updated SubCategory";

        // Llama al método para editar la subcategoría
        $result = $this->subCategoryManager->updateSubCategory($subCategoryId, $newCategoryId, $newSubCategoryName);
        $this->assertTrue($result, "La subcategoría no se actualizó correctamente.");

        // Verifica que los datos fueron actualizados
        $query = $this->con->query("SELECT * FROM subcategory WHERE id = $subCategoryId");
        $data = $query->fetch_assoc();
        $this->assertEquals($newCategoryId, $data['categoryid']);
        $this->assertEquals($newSubCategoryName, $data['subcategory']);

        echo "Datos después de la actualización:\n";
        print_r($data);
    }
}
