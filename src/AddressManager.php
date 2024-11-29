<?php
class AddressManager {
    private $users;

    public function __construct(&$usersDatabase) {
        $this->users = &$usersDatabase; // Simula la base de datos de usuarios
    }

    /**
     * Actualizar dirección de facturación.
     */
    public function updateBillingAddress($userId, $address, $state, $city, $pincode) {
        if (!isset($this->users[$userId])) {
            return false; // Usuario no encontrado
        }
        $this->users[$userId]['billingAddress'] = $address;
        $this->users[$userId]['billingState'] = $state;
        $this->users[$userId]['billingCity'] = $city;
        $this->users[$userId]['billingPincode'] = $pincode;
        return true;
    }

    /**
     * Actualizar dirección de envío.
     */
    public function updateShippingAddress($userId, $address, $state, $city, $pincode) {
        if (!isset($this->users[$userId])) {
            return false; // Usuario no encontrado
        }
        $this->users[$userId]['shippingAddress'] = $address;
        $this->users[$userId]['shippingState'] = $state;
        $this->users[$userId]['shippingCity'] = $city;
        $this->users[$userId]['shippingPincode'] = $pincode;
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
