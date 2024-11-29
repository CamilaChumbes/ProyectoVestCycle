<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/OrderManager.php';

class OrderManagerTest extends TestCase {
    private $orderManager;
    private $orders;

    protected function setUp(): void {
        // Simula la base de datos de órdenes
        $this->orders = [
            [
                'id' => 'ORD123',
                'email' => 'customer1@example.com',
                'status' => 'Shipped',
                'items' => [
                    ['name' => 'Product 1', 'quantity' => 1, 'price' => 100],
                    ['name' => 'Product 2', 'quantity' => 2, 'price' => 50],
                ],
            ],
            [
                'id' => 'ORD124',
                'email' => 'customer2@example.com',
                'status' => 'Delivered',
                'items' => [
                    ['name' => 'Product 3', 'quantity' => 1, 'price' => 200],
                ],
            ],
        ];

        // Instancia OrderManager
        $this->orderManager = new OrderManager($this->orders);
    }

    public function testTrackOrderSuccess() {
        $order = $this->orderManager->trackOrder('ORD123', 'customer1@example.com');
        $this->assertNotNull($order);
        $this->assertEquals('ORD123', $order['id']);
        $this->assertEquals('customer1@example.com', $order['email']);
        $this->assertEquals('Shipped', $order['status']);
        echo "Orden encontrada correctamente: ORD123\n";
    }

    public function testTrackOrderInvalidOrderId() {
        $order = $this->orderManager->trackOrder('ORD999', 'customer1@example.com');
        $this->assertNull($order);
        echo "Intento de rastrear una orden con un ID inexistente manejado correctamente.\n";
    }

    public function testTrackOrderInvalidEmail() {
        $order = $this->orderManager->trackOrder('ORD123', 'invalid@example.com');
        $this->assertNull($order);
        echo "Intento de rastrear una orden con un email inválido manejado correctamente.\n";
    }

    public function testTrackOrderInvalidCombination() {
        $order = $this->orderManager->trackOrder('ORD999', 'invalid@example.com');
        $this->assertNull($order);
        echo "Intento de rastrear una orden con combinación inválida manejado correctamente.\n";
    }
}
?>
