<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/AddressManager.php';

class AddressManagerTest extends TestCase {
    private $addressManager;
    private $users;

    protected function setUp(): void {
        // Simula la base de datos de usuarios
        $this->users = [
            1 => [
                'name' => 'John Doe',
                'billingAddress' => 'Old Billing Address',
                'billingState' => 'Old Billing State',
                'billingCity' => 'Old Billing City',
                'billingPincode' => '000000',
                'shippingAddress' => 'Old Shipping Address',
                'shippingState' => 'Old Shipping State',
                'shippingCity' => 'Old Shipping City',
                'shippingPincode' => '111111',
            ]
        ];

        // Instancia AddressManager
        $this->addressManager = new AddressManager($this->users);
    }

    public function testUpdateBillingAddress() {
        $result = $this->addressManager->updateBillingAddress(
            1,
            'New Billing Address',
            'New Billing State',
            'New Billing City',
            '123456'
        );
        $this->assertTrue($result);

        $user = $this->addressManager->getUser(1);
        $this->assertEquals('New Billing Address', $user['billingAddress']);
        $this->assertEquals('New Billing State', $user['billingState']);
        $this->assertEquals('New Billing City', $user['billingCity']);
        $this->assertEquals('123456', $user['billingPincode']);
        echo "Dirección de facturación actualizada correctamente.\n";
    }

    public function testUpdateShippingAddress() {
        $result = $this->addressManager->updateShippingAddress(
            1,
            'New Shipping Address',
            'New Shipping State',
            'New Shipping City',
            '654321'
        );
        $this->assertTrue($result);

        $user = $this->addressManager->getUser(1);
        $this->assertEquals('New Shipping Address', $user['shippingAddress']);
        $this->assertEquals('New Shipping State', $user['shippingState']);
        $this->assertEquals('New Shipping City', $user['shippingCity']);
        $this->assertEquals('654321', $user['shippingPincode']);
        echo "Dirección de envío actualizada correctamente.\n";
    }

    public function testUpdateBillingAddressNonExistentUser() {
        $result = $this->addressManager->updateBillingAddress(
            99,
            'Address',
            'State',
            'City',
            '123456'
        );
        $this->assertFalse($result);
        echo "Intento de actualizar la dirección de facturación para un usuario inexistente manejado correctamente.\n";
    }

    public function testUpdateShippingAddressNonExistentUser() {
        $result = $this->addressManager->updateShippingAddress(
            99,
            'Address',
            'State',
            'City',
            '654321'
        );
        $this->assertFalse($result);
        echo "Intento de actualizar la dirección de envío para un usuario inexistente manejado correctamente.\n";
    }
}
?>
