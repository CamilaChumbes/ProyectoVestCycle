<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/AuthManager.php';

class AuthManagerTest extends TestCase {
    private $authManager;
    private $session;

    protected function setUp(): void {
        $this->session = []; // Simula la sesión como un array
        $this->authManager = new AuthManager($this->session);
    }

    public function testRegisterUser() {
        $result = $this->authManager->register("John Doe", "johndoe@example.com", "1234567890", "password123");
        $this->assertTrue($result);

        $users = $this->authManager->getUsers();
        $this->assertArrayHasKey("johndoe@example.com", $users);
        $this->assertEquals("John Doe", $users["johndoe@example.com"]["name"]);
        echo "Usuario registrado exitosamente: johndoe@example.com\n";
    }

    public function testRegisterDuplicateUser() {
        $this->authManager->register("John Doe", "johndoe@example.com", "1234567890", "password123");
        $result = $this->authManager->register("John Doe", "johndoe@example.com", "1234567890", "password123");
        $this->assertFalse($result);

        echo "Intento de registro duplicado detectado correctamente.\n";
    }

    public function testLoginSuccessful() {
        $this->authManager->register("Jane Doe", "janedoe@example.com", "0987654321", "securepassword");
        $result = $this->authManager->login("janedoe@example.com", "securepassword");
        $this->assertTrue($result);

        $this->assertEquals("janedoe@example.com", $this->session['login']);
        $this->assertEquals("Jane Doe", $this->session['username']);
        echo "Inicio de sesión exitoso para: janedoe@example.com\n";
    }

    public function testLoginFailedWrongPassword() {
        $this->authManager->register("Alice", "alice@example.com", "1122334455", "mypassword");
        $result = $this->authManager->login("alice@example.com", "wrongpassword");
        $this->assertFalse($result);

        $this->assertArrayNotHasKey('login', $this->session);
        echo "Inicio de sesión fallido con contraseña incorrecta.\n";
    }

    public function testLoginFailedUserNotFound() {
        $result = $this->authManager->login("nonexistent@example.com", "password");
        $this->assertFalse($result);

        echo "Inicio de sesión fallido para un usuario inexistente.\n";
    }
}
?>
