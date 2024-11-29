<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/AccountManager.php';

class AccountManagerTest extends TestCase {
    private $accountManager;
    private $users;
    private $session;

    protected function setUp(): void {
        // Simula la base de datos de usuarios
        $this->users = [
            1 => ['name' => 'John Doe', 'contactno' => '1234567890', 'password' => md5('password123')],
            2 => ['name' => 'Jane Doe', 'contactno' => '0987654321', 'password' => md5('securepassword')],
        ];

        // Simula la sesión
        $this->session = ['id' => 1];

        // Instancia el AccountManager
        $this->accountManager = new AccountManager($this->users, $this->session);
    }

    public function testUpdateProfile() {
        $result = $this->accountManager->updateProfile(1, 'John Smith', '1112223333');
        $this->assertTrue($result);

        $user = $this->accountManager->getUser(1);
        $this->assertEquals('John Smith', $user['name']);
        $this->assertEquals('1112223333', $user['contactno']);
        echo "Perfil actualizado correctamente para el usuario 1.\n";
    }

    public function testUpdateProfileNonExistentUser() {
        $result = $this->accountManager->updateProfile(99, 'Nonexistent User', '0000000000');
        $this->assertFalse($result);

        echo "Intento de actualizar un perfil inexistente manejado correctamente.\n";
    }

    public function testChangePasswordSuccessful() {
        $result = $this->accountManager->changePassword(1, 'password123', 'newpassword');
        $this->assertTrue($result);

        $user = $this->accountManager->getUser(1);
        $this->assertEquals(md5('newpassword'), $user['password']);
        echo "Contraseña cambiada correctamente para el usuario 1.\n";
    }

    public function testChangePasswordIncorrectCurrentPassword() {
        $result = $this->accountManager->changePassword(1, 'wrongpassword', 'newpassword');
        $this->assertFalse($result);

        $user = $this->accountManager->getUser(1);
        $this->assertEquals(md5('password123'), $user['password']);
        echo "Intento de cambiar contraseña con contraseña actual incorrecta detectado correctamente.\n";
    }

    public function testChangePasswordNonExistentUser() {
        $result = $this->accountManager->changePassword(99, 'password123', 'newpassword');
        $this->assertFalse($result);

        echo "Intento de cambiar contraseña para un usuario inexistente manejado correctamente.\n";
    }
}
?>
