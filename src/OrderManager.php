<?php
class OrderManager {
    private $orders;

    public function __construct(&$ordersDatabase) {
        $this->orders = &$ordersDatabase; // Simula la base de datos de órdenes
    }

    /**
     * Buscar orden por ID y email.
     */
    public function trackOrder($orderId, $email) {
        foreach ($this->orders as $order) {
            if ($order['id'] === $orderId && $order['email'] === $email) {
                return $order; // Orden encontrada
            }
        }
        return null; // Orden no encontrada
    }
}
?>
