<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/CartManager.php';

class CartManagerTest extends TestCase {
    private $cart;
    private $cartManager;

    protected function setUp(): void {
        $this->cart = []; // Carrito simulado
        $this->cartManager = new CartManager($this->cart);
    }

    public function testAddProductToCart() {
        $this->cartManager->addProductToCart(1, 2);
        $cart = $this->cartManager->getCart();

        $this->assertArrayHasKey(1, $cart);
        $this->assertEquals(2, $cart[1]['quantity']);

        echo "Producto agregado: ID 1, Cantidad 2\n";
    }

    public function testUpdateCart() {
        $this->cartManager->addProductToCart(1, 2);
        $this->cartManager->addProductToCart(2, 1);

        $this->cartManager->updateCart([1 => 5, 2 => 0]);
        $cart = $this->cartManager->getCart();

        $this->assertArrayHasKey(1, $cart);
        $this->assertEquals(5, $cart[1]['quantity']);
        $this->assertArrayNotHasKey(2, $cart);

        echo "Carrito actualizado: Producto 1 cantidad 5, Producto 2 eliminado\n";
    }

    public function testRemoveProduct() {
        $this->cartManager->addProductToCart(1, 2);
        $this->cartManager->removeProduct(1);
        $cart = $this->cartManager->getCart();

        $this->assertArrayNotHasKey(1, $cart);

        echo "Producto eliminado: ID 1\n";
    }

    public function testClearCart() {
        $this->cartManager->addProductToCart(1, 2);
        $this->cartManager->addProductToCart(2, 3);
        $this->cartManager->clearCart();
        $cart = $this->cartManager->getCart();

        $this->assertEmpty($cart);

        echo "Carrito limpiado\n";
    }
}
?>
