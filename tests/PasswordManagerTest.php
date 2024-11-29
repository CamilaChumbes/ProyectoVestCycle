<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/PasswordManager.php'; // Ruta a PasswordManager.php

class PasswordManagerTest extends TestCase {
    private $con;
    private $passwordManager;

    protected function setUp(): void {
        $this->con = new mysqli("localhost", "root", "", "test_database");
        $this->con->query("DELETE FROM admin");
        $this->passwordManager = new PasswordManager($this->con);
    }

    protected function tearDown(): void {
        $this->con->query("DELETE FROM admin");
        $this->con->close();
    }

    public function testChangePassword() {
        // Configuración inicial
        $username = "testadmin";
        $oldPassword = "oldpassword";
        $newPassword = "newpassword";
    
        echo "=== Inicio de la prueba de cambio de contraseña ===\n";
    
        // Inserta un usuario de prueba
        $hashedOldPassword = md5($oldPassword);
        $this->con->query("INSERT INTO admin (username, password) VALUES ('$username', '$hashedOldPassword')");
    
        echo "1. Usuario insertado en la base de datos:\n";
        $query = $this->con->query("SELECT * FROM admin WHERE username = '$username'");
        $data = $query->fetch_assoc();
        print_r($data);
    
        // Cambiar la contraseña
        echo "2. Intentando cambiar la contraseña...\n";
        $hashedNewPassword = md5($newPassword);
        $currentTime = date('Y-m-d H:i:s');
        $result = $this->passwordManager->changePassword($username, $oldPassword, $newPassword);
    
        // Verifica que el cambio fue exitoso
        $this->assertTrue($result, "La contraseña no se cambió correctamente.");
    
        echo "3. Contraseña cambiada exitosamente.\n";
    
        // Verifica que la nueva contraseña fue guardada
        $query = $this->con->query("SELECT * FROM admin WHERE username = '$username'");
        $data = $query->fetch_assoc();
        echo "4. Datos después del cambio de contraseña:\n";
        print_r($data);
    
        // Verifica que la nueva contraseña coincida
        $this->assertEquals($hashedNewPassword, $data['password'], "La nueva contraseña no coincide.");
    
        echo "=== Fin de la prueba ===\n";
    }
}
