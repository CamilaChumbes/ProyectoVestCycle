<?php
class AccountManager {
    private $users;
    private $session;

    public function __construct(&$usersDatabase, &$session) {
        $this->users = &$usersDatabase; // Simula la base de datos de usuarios
        $this->session = &$session;     // Simula la sesión
    }

    /**
     * Actualizar información del usuario.
     */
    public function updateProfile($userId, $name, $contactNo) {
        if (!isset($this->users[$userId])) {
            return false; // Usuario no encontrado
        }
        $this->users[$userId]['name'] = $name;
        $this->users[$userId]['contactno'] = $contactNo;
        return true;
    }

    /**
     * Cambiar la contraseña del usuario.
     */
    public function changePassword($userId, $currentPassword, $newPassword) {
        if (!isset($this->users[$userId])) {
            return false; // Usuario no encontrado
        }
        if ($this->users[$userId]['password'] !== md5($currentPassword)) {
            return false; // Contraseña actual incorrecta
        }
        $this->users[$userId]['password'] = md5($newPassword);
        return true;
    }

    /**
     * Obtener datos del usuario.
     */
    public function getUser($userId) {
        return $this->users[$userId] ?? null;
    }
}
?>
