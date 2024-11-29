<?php
class WishlistManager {
    private $wishlist;
    private $products;

    public function __construct(&$sessionWishlist, &$productDatabase) {
        $this->wishlist = &$sessionWishlist; // Referencia a la lista de deseos (simulada o real)
        $this->products = &$productDatabase; // Referencia a la base de datos de productos (simulada)
    }

    /**
     * Agregar un producto a la lista de deseos.
     */
    public function addToWishlist($productId) {
        if (!isset($this->products[$productId])) {
            return false; // Producto no existe
        }
        $this->wishlist[$productId] = $this->products[$productId];
        return true;
    }

    /**
     * Eliminar un producto de la lista de deseos.
     */
    public function removeFromWishlist($productId) {
        if (isset($this->wishlist[$productId])) {
            unset($this->wishlist[$productId]);
            return true;
        }
        return false;
    }

    /**
     * Obtener todos los productos en la lista de deseos.
     */
    public function getWishlist() {
        return $this->wishlist;
    }
}
?>
