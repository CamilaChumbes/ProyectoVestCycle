<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/WishlistManager.php';

class WishlistManagerTest extends TestCase {
    private $wishlistManager;
    private $wishlist;
    private $products;

    protected function setUp(): void {
        // Simular base de datos de productos
        $this->products = [
            1 => ['name' => 'Producto 1', 'price' => 100],
            2 => ['name' => 'Producto 2', 'price' => 200],
            3 => ['name' => 'Producto 3', 'price' => 300],
        ];

        // Simular lista de deseos
        $this->wishlist = [];

        // Instanciar WishlistManager
        $this->wishlistManager = new WishlistManager($this->wishlist, $this->products);
    }

    public function testAddToWishlist() {
        $result = $this->wishlistManager->addToWishlist(1);
        $this->assertTrue($result);

        $wishlist = $this->wishlistManager->getWishlist();
        $this->assertArrayHasKey(1, $wishlist);
        $this->assertEquals('Producto 1', $wishlist[1]['name']);
        echo "Producto agregado a la lista de deseos: Producto 1\n";
    }

    public function testAddNonExistentProductToWishlist() {
        $result = $this->wishlistManager->addToWishlist(99); // Producto inexistente
        $this->assertFalse($result);

        $wishlist = $this->wishlistManager->getWishlist();
        $this->assertArrayNotHasKey(99, $wishlist);
        echo "Intento de agregar un producto inexistente detectado correctamente.\n";
    }

    public function testRemoveFromWishlist() {
        $this->wishlistManager->addToWishlist(2);
        $result = $this->wishlistManager->removeFromWishlist(2);
        $this->assertTrue($result);

        $wishlist = $this->wishlistManager->getWishlist();
        $this->assertArrayNotHasKey(2, $wishlist);
        echo "Producto eliminado de la lista de deseos: Producto 2\n";
    }

    public function testRemoveNonExistentProductFromWishlist() {
        $result = $this->wishlistManager->removeFromWishlist(99); // Producto inexistente en la wishlist
        $this->assertFalse($result);

        echo "Intento de eliminar un producto inexistente manejado correctamente.\n";
    }

    public function testGetWishlist() {
        $this->wishlistManager->addToWishlist(1);
        $this->wishlistManager->addToWishlist(3);

        $wishlist = $this->wishlistManager->getWishlist();
        $this->assertCount(2, $wishlist);
        $this->assertArrayHasKey(1, $wishlist);
        $this->assertArrayHasKey(3, $wishlist);
        echo "Productos obtenidos de la lista de deseos correctamente.\n";
    }
}
?>
