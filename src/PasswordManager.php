<?php
class PasswordManager {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function changePassword($username, $oldPassword, $newPassword) {
        // Verifica la contraseña actual
        $hashedOldPassword = md5($oldPassword);
        $query = $this->con->prepare("SELECT password FROM admin WHERE username = ? AND password = ?");
        $query->bind_param('ss', $username, $hashedOldPassword);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            // Actualiza con la nueva contraseña
            $hashedNewPassword = md5($newPassword);
            $currentTime = date('d-m-Y h:i:s A');
            $update = $this->con->prepare("UPDATE admin SET password = ?, updationDate = ? WHERE username = ?");
            $update->bind_param('sss', $hashedNewPassword, $currentTime, $username);
            return $update->execute();
        } else {
            return false; // Contraseña actual incorrecta
        }
    }
}
