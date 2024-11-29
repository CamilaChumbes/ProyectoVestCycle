<?php
class AuthManager {
    private $users;
    private $session;

    public function __construct(&$session) {
        $this->users = []; // Array para simular la base de datos
        $this->session = &$session; // Referencia a la sesión (simulada o real)
    }

    /**
     * Registra un nuevo usuario.
     */
    public function register($name, $email, $contactNo, $password) {
        if (isset($this->users[$email])) {
            return false; // Usuario ya existe
        }
        $this->users[$email] = [
            'name' => $name,
            'contactNo' => $contactNo,
            'password' => md5($password), // Almacena la contraseña hasheada
        ];
        return true;
    }

    /**
     * Inicia sesión un usuario con email y contraseña.
     */
    public function login($email, $password) {
        if (!isset($this->users[$email])) {
            return false; // Usuario no encontrado
        }
        if ($this->users[$email]['password'] !== md5($password)) {
            return false; // Contraseña incorrecta
        }
        // Configurar sesión simulada
        $this->session['login'] = $email;
        $this->session['username'] = $this->users[$email]['name'];
        return true;
    }

    /**
     * Obtiene todos los usuarios (para fines de prueba).
     */
    public function getUsers() {
        return $this->users;
    }
}
?>
